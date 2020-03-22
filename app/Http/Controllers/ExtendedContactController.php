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
use Illuminate\Support\Carbon;
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
            $request->last_contact_idx = $request->last_contact_idx ?? null;
            $User = Auth::check() ? Auth::user() : session('logged_user');
            if($User){
                $Contacts = $this->contactRepository->all();
                if ($User->role_id == ExtendedContactsStatusController::MANAGER) {
                    $Contacts = $this->contactRepository->fullContacts((int) $User->company_id, null, null, $request->last_contact_idx);
                } else if ($User->role_id == ExtendedContactsStatusController::ATTENDANT) {
                    $filter = $request->filter_contact;
                    $Contacts = $this->contactRepository->fullContacts((int) $User->company_id, (int) $User->id, $filter, $request->last_contact_idx);
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

            //conver the file content to a Contacts array
            $Contacts = $this->csv_to_array($file->getRealPath(), ',');
            if(count($Contacts)>1 && count($Contacts[1])<2 ){
                $Contacts = $this->csv_to_array($file->getRealPath(), ';');
            }
            unlink($file->getRealPath());

            //get the updated time from the oldest updated contact
            $oldestUpdatedContact = Contact::where('company_id', '=', $User->company_id)->orderBy('updated_at', 'asc')->first();
            $oldestUpdatedContactTime = isset($oldestUpdatedContact->updated_at)?strtotime($oldestUpdatedContact->updated_at):time();
            $oldestUpdatedContactTime--;

            //obtaining emails and ids of attendants of this company
            $extendedUserRepository = new ExtendedUserRepository(app());
            $ExtendedUsersAttendantRepository = new ExtendedUsersAttendantRepository(app());
            $attendantsUser = $ExtendedUsersAttendantRepository->Attendants_User_By_Attendant($User->company_id,4);
            $attendatn_ids = array();
            foreach ($attendantsUser as $key => $attendant) {
                $user = $extendedUserRepository->findWithoutFail($attendant->user_id);
                $attendatn_ids[$user->email] = $attendant->user_id;
            }
            $response = array();
            $lineError = array();
            
            //insert contacts in database
            $cntMessage1 = 0;
            $cntMessage2 = 0;
            $cntMessage3 = 0;
            $i=2;
            foreach($Contacts as $contact){
                try{
                    $whatsapp = $contact['Whatsapp'];
                    $whatsapp = trim(str_replace('/', '', str_replace(' ', '', str_replace('-', '', str_replace(')', '', str_replace('(', '', $whatsapp))))));
                    $Contact = Contact::where('whatsapp_id' ,$whatsapp)
                            ->where('company_id', '=', $User->company_id)
                            ->first();

                    $Contact = $Contact ?? new Contact;
                    $latestAttendantContact = $Contact->latestAttendantContact()->first();

                    $last_attendant_id = $latestAttendantContact->attendant_id ?? null; //TODO:Alberto
                    $Contact->company_id = $User->company_id;
                    $Contact->origin = 3;
                    if (preg_match("/^[a-z A-Z0-9çÇáÁéÉíÍóÓúÚàÀèÈìÌòÒùÙãÃõÕâÂêÊôÔûÛñ\._-]{2,150}$/" , $contact['Nome'])) {
                        $Contact->first_name = trim($contact['Nome']);
                    }
                    if (isset($contact['Email']) && filter_var(trim($contact['Email']), FILTER_VALIDATE_EMAIL)) {
                        $Contact->email = trim($contact['Email']);
                    }
                    if (preg_match("/^[0-9]{1,3}\ ?[0-9]{1,3}\ ?[0-9]{3,5}(?:-)?[0-9]{4}$/", $whatsapp) ) {
                        $Contact->whatsapp_id = $whatsapp;
                    }
                    if (isset($contact['Facebook']) && preg_match("/^[a-zA-Z0-9\._]{1,300}$/" , $contact['Facebook'])) {
                        $Contact->facebook_id = trim($contact['Facebook']);
                    }
                    if (isset($contact['Instagram']) && preg_match("/^[a-zA-Z0-9\._]{1,300}$/" , $contact['Instagram'])) {
                        $Contact->instagram_id = trim($contact['Instagram']);
                    }
                    if (isset($contact['LinkedIn']) && preg_match("/^[a-zA-Z0-9\._]{1,300}$/" , $contact['LinkedIn'])) {
                        $Contact->linkedin_id = trim($contact['LinkedIn']);
                    }
                    if (isset($contact['Estado']) && preg_match("/^[a-z A-Z0-9çÇáÁéÉíÍóÓúÚàÀèÈìÌòÒùÙãÃõÕâÂêÊôÔûÛñ\.,_-]{2,80}$/" , $contact['Estado'])) {
                        $Contact->estado = trim($contact['Estado']);
                    }
                    if (isset($contact['Cidade']) && preg_match("/^[a-z A-Z0-9çÇáÁéÉíÍóÓúÚàÀèÈìÌòÒùÙãÃõÕâÂêÊôÔûÛñ\.,_-]{2,80}$/" , $contact['Cidade'])) {
                        $Contact->cidade = trim($contact['Cidade']);
                    }
                    if (isset($contact['Categoria1']) && preg_match("/^[a-z A-Z0-9çÇáÁéÉíÍóÓúÚàÀèÈìÌòÒùÙãÃõÕâÂêÊôÔûÛñ\.,_-]{2,80}$/" , $contact['Categoria1'])) {
                        $Contact->categoria1 = trim($contact['Categoria1']);
                    }
                    if (isset($contact['Categoria2']) && preg_match("/^[a-z A-Z0-9çÇáÁéÉíÍóÓúÚàÀèÈìÌòÒùÙãÃõÕâÂêÊôÔûÛñ\.,_-]{2,80}$/" , $contact['Categoria2'])) {
                        $Contact->categoria2 = trim($contact['Categoria2']);
                    }
                    $Contact->description = "Adicionado ou atualizado desde planilha CSV";
                    $Contact->json_data = '{"picurl":"images/contacts/default.png"}';
                    $Contact->company_id = $User->company_id;
                    $Contact->origin = $Contact->origin ?? 3; //original origin or 3->by spreadsheed

                    if(!empty($Contact->whatsapp_id)){
                        if(!isset($Contact->status_id))
                            $Contact->status_id = 2;
                        $Contact->created_at = Carbon::minValue();
                        $Contact->updated_at = Carbon::minValue();
                        // $Contact->created_at = '1959-01-01 00:00:00';
                        // $Contact->updated_at = '1959-01-01 00:00:00';
                        $Contact->save();
                        
                        //process the respective atendent email in the actual csv row
                        if (trim($contact['Email-Atendente']) != ""){
                            if(filter_var(trim($contact['Email-Atendente']), FILTER_VALIDATE_EMAIL)){
                                $csv_attendant_email = trim($contact['Email-Atendente']);
                                //1. process only if csv-email is an attendant of actual company
                                if (array_key_exists($csv_attendant_email, $attendatn_ids)){
                                    //2. process only if the contact dont has attendant, or if csv-email is different of the current attendant (i.e. contact it is transferring to a new attendant)
                                    if(($last_attendant_id == null) || ($attendatn_ids[$csv_attendant_email] != $last_attendant_id) ){
                                        //3. find the saved contact object
                                        $Contact = $Contact->where('whatsapp_id' ,$whatsapp)->where('company_id', '=', $User->company_id)->first();
                                        //4. criate new record in attendants_contacts table (created_at and updated_at dates must be the current date for this record)
                                        $AttendantsContact = new AttendantsContact();
                                        $AttendantsContact->attendant_id = (int)$attendatn_ids[$csv_attendant_email];
                                        $AttendantsContact->contact_id = $Contact->id;
                                        $AttendantsContact->save();
                                        //5. update the contact status_id to ACTIVE and keep the criated_at and updated_at dates
                                        if($Contact->status_id == 2){
                                            $Contact->status_id = 1;
                                            $Contact->created_at = date('Y-m-d H:i:s',$oldestUpdatedContactTime);
                                            $Contact->updated_at = date('Y-m-d H:i:s',$oldestUpdatedContactTime);
                                            $Contact->save();
                                        }
                                        $cntMessage1++;
                                    }
                                }else{
                                    $cntMessage2++;
                                }
                            }else{
                                $cntMessage2++;
                            }
                        }else{
                            $cntMessage2++;
                        }
                    }else{
                        $cntMessage3++;
                    }

                } catch (\Throwable $th) {
                    //throw $th;
                }
                $i++;
                $oldestUpdatedContactTime--;
            }
        
            $response["message1"] = array(
                "message" => "contatos foram adicionados e atribuídos aos atendentes corretamente.",
                "code" => "success",
                "cnt" => "$cntMessage1"
            );

            $response["message2"] = array(
                "message" => "contatos foram adicionados mas não foram atribuídos a um atendente. Confira o email que foi inserido para o atendente, ele pode ser inválido ou o atendente pode não estar criado.",
                "code" => "warning",
                "cnt" => "$cntMessage2"
            );

            $response["message3"] = array(
                "message" => "contatos não foram adicionados porque o número de whatsapp parece errado ou inexistente.",
                "code" => "error",
                "cnt" => "$cntMessage3"
            );

        } else {
            abort(302, "Error uploading file!");
        }
        // Flash::success('Contact saved successfully.');
        return json_encode($response);
        // return $response->toJson();
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
