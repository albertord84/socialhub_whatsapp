<?php

namespace App\Http\Controllers;

use App\Business\FileUtils;
use App\Http\Requests\CreateContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use App\Models\AttendantsContact;
use App\Repositories\ExtendedAttendantsContactRepository;
use App\Repositories\ExtendedContactRepository;
use App\Repositories\ExtendedUserRepository;
use App\Repositories\ExtendedUsersAttendantRepository;
use Auth;
use Flash;
use Illuminate\Http\Request;
use Response;

class ExtendedContactController extends ContactController
{

    public function __construct(ExtendedContactRepository $contactRepo)
    {
        parent::__construct($contactRepo);

        $this->contactRepository = $contactRepo;
        $this->APP_FILE_PATH = env('APP_FILE_PATH');
    }

    /**
     * Display a listing of the Contact.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        try {
            $User = Auth::check() ? Auth::user() : session('logged_user');
            if($User){
                $Contacts = $this->contactRepository->all();
                if ($User->role_id == ExtendedContactsStatusController::MANAGER) {
                    $Contacts = $this->contactRepository->fullContacts((int) $User->company_id, null);
                } else if ($User->role_id == ExtendedContactsStatusController::ATTENDANT) {
                    $filter = $request->filter_contact;
                    $Contacts = $this->contactRepository->fullContacts((int) $User->company_id, (int) $User->id, $filter);
                }    
                return $Contacts->toJson();
            }else{
                //emitir mensagem de erro, sessão morreu
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Store a newly created Contact in storage.
     *
     * @param CreateContactRequest $request
     *
     * @return Response
     */
    public function store(CreateContactRequest $request)
    {
        $input = $request->all();

        $User = Auth::check() ? Auth::user() : session('logged_user');
        $input['company_id'] = $User->company_id;

        $contact = $this->contactRepository->create($input);

        Flash::success('Contact saved successfully.');

        return $contact->toJson();
        //return redirect(route('contacts.index'));
    }

    public function contactsFromCSV(CreateContactRequest $request)
    {
        $input = $request->all();
        $User = Auth::check() ? Auth::user() : session('logged_user');

        if ($file = $request->file('file')) {

            $array = $this->csv_to_array($file->getRealPath(), ',');
            if(count($array)>1 && count($array[1])<2 ){
                $array = $this->csv_to_array($file->getRealPath(), ';');
            }
            unlink($file->getRealPath());

            //obtainin emails and ids of attendants
            $extendedUserRepository = new ExtendedUserRepository(app());
            $ExtendedUsersAttendantRepository = new ExtendedUsersAttendantRepository(app());
            $attendantsUser = $ExtendedUsersAttendantRepository->Attendants_User_By_Attendant($User->company_id,4);
            $attendatn_ids = array();
            foreach ($attendantsUser as $key => $attendant) {
                $user = $extendedUserRepository->findWithoutFail($attendant->user_id);
                $attendatn_ids[$user->email] = $attendant->user_id;
            }
            
            //insert contacts in database
            foreach($array as $contact){
                try{
                    $whatsapp = $contact['Whatsapp'];
                    $whatsapp= trim(str_replace('/', '', str_replace(' ', '', str_replace('-', '', str_replace(')', '', str_replace('(', '', $whatsapp))))));
                    $Contact = new Contact();
                    $Contact->company_id = $User->company_id;
                    $Contact->origin = 3;
                    
                    if (preg_match("/^[a-z A-Z0-9çÇáÁéÉíÍóÓúÚàÀèÈìÌòÒùÙãÃõÕâÂêÊôÔûÛñ\._-]{2,150}$/" , $contact['Nome'])) {
                        $Contact->first_name = trim($contact['Nome']);
                    }
                    if (preg_match("/^[0-9]{1,3}\ ?[0-9]{1,3}\ ?[0-9]{3,5}(?:-)?[0-9]{4}$/", $whatsapp) ) {
                        $Contact->whatsapp_id = $whatsapp;
                    }

                    if ($contact['Email'] && filter_var(trim($contact['Email']), FILTER_VALIDATE_EMAIL)) {
                        $Contact->email = trim($contact['Email']);
                    }

                    if ($contact['Facebook'] && preg_match("/^[a-zA-Z0-9\._]{1,300}$/" , $contact['Facebook'])) {
                        $Contact->facebook_id = trim($contact['Facebook']);
                    }
                    if ($contact['Instagram'] && preg_match("/^[a-zA-Z0-9\._]{1,300}$/" , $contact['Instagram'])) {
                        $Contact->instagram_id = trim($contact['Instagram']);
                    }
                    if ($contact['LinkedIn'] && preg_match("/^[a-zA-Z0-9\._]{1,300}$/" , $contact['LinkedIn'])) {
                        $Contact->linkedin_id = trim($contact['LinkedIn']);
                    }
                    if ($contact['Estado'] && preg_match("/^[a-z A-Z0-9çÇáÁéÉíÍóÓúÚàÀèÈìÌòÒùÙãÃõÕâÂêÊôÔûÛñ\.,_-]{2,80}$/" , $contact['Estado'])) {
                        $Contact->estado = trim($contact['Estado']);
                    }
                    if ($contact['Cidade'] && preg_match("/^[a-z A-Z0-9çÇáÁéÉíÍóÓúÚàÀèÈìÌòÒùÙãÃõÕâÂêÊôÔûÛñ\.,_-]{2,80}$/" , $contact['Cidade'])) {
                        $Contact->cidade = trim($contact['Cidade']);
                    }
                    if ($contact['Categoria1'] && preg_match("/^[a-z A-Z0-9çÇáÁéÉíÍóÓúÚàÀèÈìÌòÒùÙãÃõÕâÂêÊôÔûÛñ\.,_-]{2,80}$/" , $contact['Categoria1'])) {
                        $Contact->categoria1 = trim($contact['Categoria1']);
                    }
                    if ($contact['Categoria2'] && preg_match("/^[a-z A-Z0-9çÇáÁéÉíÍóÓúÚàÀèÈìÌòÒùÙãÃõÕâÂêÊôÔûÛñ\.,_-]{2,80}$/" , $contact['Categoria2'])) {
                        $Contact->categoria2 = trim($contact['Categoria2']);
                    }
                    if(!empty($Contact->first_name) && !empty($Contact->whatsapp_id)){
                        $cnt = $Contact->save();

                        //processar atendentes
                        if ($contact['Email-Atendente'] && filter_var(trim($contact['Email-Atendente']), FILTER_VALIDATE_EMAIL)){
                            $attendant_email = trim($contact['Email-Atendente']);
                            //1. buscar el id del atendiente segun la empresa y el email dado
                            if(isset($attendatn_ids[$attendant_email])){
                                //2. crear una fila en la tabla attendants_contacts
                                $AttendantsContact = new AttendantsContact();
                                $AttendantsContact->attendant_id = (int)$attendatn_ids[$attendant_email];
                                $AttendantsContact->contact_id = $cnt->id;
                                $AttendantsContact->save();
                            }else{
                                print_r("O email ".$attendatn_ids[$attendant_email]."não pertence a um attendente cadastrado nesta empresa");
                            }
                        }


                    }


                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
            
        } else {
            abort(302, "Error uploading file!");
        }


        


        // $User = Auth::check() ? Auth::user() : session('logged_user');
        // $input['company_id'] = $User->company_id;

        // $contact = $this->contactRepository->create($input);

        // Flash::success('Contact saved successfully.');

        // return $contact->toJson();
        //return redirect(route('contacts.index'));
    }

    /**
     * Update the specified Contact in storage.
     *
     * @param  int              $id
     * @param UpdateContactRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateContactRequest $request)
    {
        $input = $request->all();

        $contact = $this->contactRepository->findWithoutFail($id);

        if (empty($contact)) {
            Flash::error('Contact not found');
            return redirect(route('contacts.index'));
        }

        $contact = $this->contactRepository->update($input, $id);

        Flash::success('Contact updated successfully.');

        // return redirect(route('contacts.index'));
        return $contact->toJson();
    }

    /**
     * Update the specified Contact in storage.
     *
     * @param  int              $id
     * @param UpdateContactRequest $request
     *
     * @return Response
     */
    public function updatePicture($id, Request $request)
    {
        $Contact = Contact::find($id);

        $Controller = new ExternalRPIController(null);
        $contactInfo = $Controller->getContactInfo($Contact->whatsapp_id);
        $Contact->json_data = $contactInfo;
        $Contact->timestamps = false;
        $Contact->save();

        if (empty($Contact)) {
            Flash::error('Contact not found');
            return redirect(route('contacts.index'));
        }

        Flash::success('Contact picture updated.');

        // return redirect(route('contacts.index'));
        return $Contact->toJson();
    }

    /**
     * Remove the specified Contact from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $contact = $this->contactRepository->findWithoutFail($id);

        if (empty($contact)) {
            Flash::error('Contact not found');

            return redirect(route('contacts.index'));
        }

        // Delete All Attendants x Contact from attendats_contacs table
        // app('PrintReportController::class')->deleteAllByContactId($id);

        $extAttContRepo = new ExtendedAttendantsContactRepository(app());

        $extAttContRepo->deleteAllByContanct($id);

        $this->contactRepository->delete($id);

        Flash::success('Contact deleted successfully.');

        // return redirect(route('contacts.index'));
    }

    public function csv_to_array($filename='', $delimiter=',')
    {
        if(!file_exists($filename) || !is_readable($filename))
            return FALSE;
        
        $header = NULL;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== FALSE)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
            {
                if(!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }
        return $data;
    }


}
