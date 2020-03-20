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
            $request->last_contact_id = $request->last_contact_id ?? null;
            $User = Auth::check() ? Auth::user() : session('logged_user');
            if($User){
                $Contacts = $this->contactRepository->all();
                if ($User->role_id == ExtendedContactsStatusController::MANAGER) {
                    $Contacts = $this->contactRepository->fullContacts((int) $User->company_id, null, null, $request->last_contact_id);
                } else if ($User->role_id == ExtendedContactsStatusController::ATTENDANT) {
                    $filter = $request->filter_contact;
                    $Contacts = $this->contactRepository->fullContacts((int) $User->company_id, (int) $User->id, $filter, $request->last_contact_id);
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

    // public function contactsFromCSV(CreateContactRequest $request)
    // {
    //     $input = $request->all();
    //     $User = Auth::check() ? Auth::user() : session('logged_user');

    //     if ($file = $request->file('file')) {

    //         $array = $this->csv_to_array($file->getRealPath(), ',');
    //         if(count($array)>1 && count($array[1])<2 ){
    //             $array = $this->csv_to_array($file->getRealPath(), ';');
    //         }
    //         unlink($file->getRealPath());

    //         //obtaining emails and ids of attendants
    //         $extendedUserRepository = new ExtendedUserRepository(app());
    //         $ExtendedUsersAttendantRepository = new ExtendedUsersAttendantRepository(app());
    //         $attendantsUser = $ExtendedUsersAttendantRepository->Attendants_User_By_Attendant($User->company_id,4);
    //         $attendatn_ids = array();
    //         foreach ($attendantsUser as $key => $attendant) {
    //             $user = $extendedUserRepository->findWithoutFail($attendant->user_id);
    //             $attendatn_ids[$user->email] = $attendant->user_id;
    //         }
    //         $response = array();
            
    //         //insert contacts in database
    //         $cntMessage1 = 0;
    //         $cntMessage2 = 0;
    //         $cntMessage3 = 0;
    //         $cntMessage4 = 0;
    //         $cntMessage5 = 0;
    //         $i = 2;
    //         foreach($array as $contact){
    //             try{
    //                 $whatsapp = $contact['Whatsapp'];
    //                 $whatsapp = trim(str_replace('/', '', str_replace(' ', '', str_replace('-', '', str_replace(')', '', str_replace('(', '', $whatsapp))))));
    //                 $Contact = new Contact();
    //                 $Contact1 = new Contact();
    //                 $Contact1 = $Contact1
    //                         ->where('whatsapp_id' ,$whatsapp)
    //                         ->where('company_id', '=', $User->company_id)
    //                         ->first();
    //                 if($Contact1)$Contact = $Contact1;

    //                 $last_attendant_id = null; //get_last_attendant_contact_id($Contact->id); //TODO:Alberto
    //                 $Contact->company_id = $User->company_id;
    //                 $Contact->origin = 3;
                    
    //                 if (preg_match("/^[a-z A-Z0-9çÇáÁéÉíÍóÓúÚàÀèÈìÌòÒùÙãÃõÕâÂêÊôÔûÛñ\._-]{2,150}$/" , $contact['Nome'])) {
    //                     $Contact->first_name = trim($contact['Nome']);
    //                 }
    //                 if (preg_match("/^[0-9]{1,3}\ ?[0-9]{1,3}\ ?[0-9]{3,5}(?:-)?[0-9]{4}$/", $whatsapp) ) {
    //                     $Contact->whatsapp_id = $whatsapp;
    //                 }
    //                 if (isset($contact['Email']) && filter_var(trim($contact['Email']), FILTER_VALIDATE_EMAIL)) {
    //                     $Contact->email = trim($contact['Email']);
    //                 }
    //                 if (isset($contact['Facebook']) && preg_match("/^[a-zA-Z0-9\._]{1,300}$/" , $contact['Facebook'])) {
    //                     $Contact->facebook_id = trim($contact['Facebook']);
    //                 }
    //                 if (isset($contact['Instagram']) && preg_match("/^[a-zA-Z0-9\._]{1,300}$/" , $contact['Instagram'])) {
    //                     $Contact->instagram_id = trim($contact['Instagram']);
    //                 }
    //                 if (isset($contact['LinkedIn']) && preg_match("/^[a-zA-Z0-9\._]{1,300}$/" , $contact['LinkedIn'])) {
    //                     $Contact->linkedin_id = trim($contact['LinkedIn']);
    //                 }
    //                 if (isset($contact['Estado']) && preg_match("/^[a-z A-Z0-9çÇáÁéÉíÍóÓúÚàÀèÈìÌòÒùÙãÃõÕâÂêÊôÔûÛñ\.,_-]{2,80}$/" , $contact['Estado'])) {
    //                     $Contact->estado = trim($contact['Estado']);
    //                 }
    //                 if (isset($contact['Cidade']) && preg_match("/^[a-z A-Z0-9çÇáÁéÉíÍóÓúÚàÀèÈìÌòÒùÙãÃõÕâÂêÊôÔûÛñ\.,_-]{2,80}$/" , $contact['Cidade'])) {
    //                     $Contact->cidade = trim($contact['Cidade']);
    //                 }
    //                 if (isset($contact['Categoria1']) && preg_match("/^[a-z A-Z0-9çÇáÁéÉíÍóÓúÚàÀèÈìÌòÒùÙãÃõÕâÂêÊôÔûÛñ\.,_-]{2,80}$/" , $contact['Categoria1'])) {
    //                     $Contact->categoria1 = trim($contact['Categoria1']);
    //                 }
    //                 if (isset($contact['Categoria2']) && preg_match("/^[a-z A-Z0-9çÇáÁéÉíÍóÓúÚàÀèÈìÌòÒùÙãÃõÕâÂêÊôÔûÛñ\.,_-]{2,80}$/" , $contact['Categoria2'])) {
    //                     $Contact->categoria2 = trim($contact['Categoria2']);
    //                 }
    //                 if(!empty($Contact->whatsapp_id)){
    //                     if(!isset($Contact->status_id))
    //                         $Contact->status_id = 2;
    //                     $Contact->created_at = '1959-01-01 00:00:00';
    //                     $Contact->updated_at = '1959-01-01 00:00:00';
    //                     $Contact->save();
                        
    //                     //processar atendentes
    //                     if ($contact['Email-Atendente']!=""){
    //                         if(filter_var(trim($contact['Email-Atendente']), FILTER_VALIDATE_EMAIL)){
    //                             $attendant_email = trim($contact['Email-Atendente']);
    //                             //1. buscar el id del atendiente segun la empresa y el email dado
    //                             if (array_key_exists($attendant_email, $attendatn_ids)){
    //                                 if(isset($attendatn_ids[$attendant_email]) && ($last_attendant_id==null) || ($attendatn_ids[$attendant_email] != $last_attendant_id) ){
    //                                     //2. crear una fila en la tabla attendants_contacts                                
    //                                     $AttendantsContact = new AttendantsContact();
    //                                     $AttendantsContact->created_at = '1959-01-01 00:00:00';
    //                                     $AttendantsContact->updated_at = '1959-01-01 00:00:00';
    //                                     $AttendantsContact->attendant_id = (int)$attendatn_ids[$attendant_email];
    //                                     $AttendantsContact->contact_id = $Contact->id;
    //                                     $AttendantsContact->save();
    //                                     $Contact = $Contact
    //                                         ->where('whatsapp_id' ,$whatsapp)
    //                                         ->where('company_id', '=', $User->company_id)
    //                                         ->first();
    //                                     $Contact->created_at = '1959-01-01 00:00:00';
    //                                     $Contact->updated_at = '1959-01-01 00:00:00';
    //                                     if($Contact->status_id == 2){
    //                                         $Contact->status_id = 1;
    //                                         $Contact->save();
    //                                     }
                                        
    //                                     $response["message1"][$cntMessage1++]= array('line'=>$i, "ws"=>$Contact->whatsapp_id,"code"=>"success"); //Contato adicionado corretamente. Contato atribuido ao atendente
    //                                 }
    //                             }else{
    //                                 $response["message2"][$cntMessage2++]= array('line'=>$i,"ws"=>$Contact->whatsapp_id,"code"=>"warning"); //Contato adicionado corretamente. Contato não atribuido a um atendente; causa: email do atendente não pertence a esta empresa
    //                             }
    //                         }else{
    //                             $response["message3"][$cntMessage3++]= array('line'=>$i, "ws"=>$Contact->whatsapp_id, "code"=>"warning"); //Contato adicionado corretamente. Contato não atribuido a um atendente; causa: email do atendente inválido
    //                         }
    //                     }else{
    //                         $response["message4"][$cntMessage4++]= array('line'=>$i, "ws"=>$Contact->whatsapp_id, "code"=>"warning"); //Contato adicionado corretamente. Contato não atribuido a um atendente; email do atendente não indicado
    //                     }
    //                 }else{
    //                     if(empty($Contact->whatsapp_id))
    //                     $response["message5"][$cntMessage5++]= array('line'=>$i,"ws"=>$Contact->whatsapp_id, "code"=>"error"); //Contem um número de whatsapp inválido
                            
    //                 }

    //             } catch (\Throwable $th) {
    //                 //throw $th;
    //             }
    //             $i++;
    //         }
            
    //     } else {
    //         abort(302, "Error uploading file!");
    //     }
            
    //     // Flash::success('Contact saved successfully.');
    //     return json_encode($response);
    //     // return $response->toJson();
    // }

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

            //obtaining emails and ids of attendants
            $extendedUserRepository = new ExtendedUserRepository(app());
            $ExtendedUsersAttendantRepository = new ExtendedUsersAttendantRepository(app());
            $attendantsUser = $ExtendedUsersAttendantRepository->Attendants_User_By_Attendant($User->company_id,4);
            $attendatn_ids = array();
            foreach ($attendantsUser as $key => $attendant) {
                $user = $extendedUserRepository->findWithoutFail($attendant->user_id);
                $attendatn_ids[$user->email] = $attendant->user_id;
            }
            $response = array();
            
            //insert contacts in database
            $i=2;
            foreach($array as $contact){
                try{
                    $whatsapp = $contact['Whatsapp'];
                    $whatsapp = trim(str_replace('/', '', str_replace(' ', '', str_replace('-', '', str_replace(')', '', str_replace('(', '', $whatsapp))))));
                    $Contact = new Contact();
                    $Contact1 = new Contact();
                    $Contact1 = $Contact1
                            ->where('whatsapp_id' ,$whatsapp)
                            ->where('company_id', '=', $User->company_id)
                            ->first();
                    if($Contact1)$Contact = $Contact1;

                    $last_attendant_id = null; //get_last_attendant_contact_id($Contact->id); //TODO:Alberto
                    $Contact->company_id = $User->company_id;
                    $Contact->origin = 3;
                    
                    if (preg_match("/^[a-z A-Z0-9çÇáÁéÉíÍóÓúÚàÀèÈìÌòÒùÙãÃõÕâÂêÊôÔûÛñ\._-]{2,150}$/" , $contact['Nome'])) {
                        $Contact->first_name = trim($contact['Nome']);
                    }
                    if (preg_match("/^[0-9]{1,3}\ ?[0-9]{1,3}\ ?[0-9]{3,5}(?:-)?[0-9]{4}$/", $whatsapp) ) {
                        $Contact->whatsapp_id = $whatsapp;
                    }
                    if (isset($contact['Email']) && filter_var(trim($contact['Email']), FILTER_VALIDATE_EMAIL)) {
                        $Contact->email = trim($contact['Email']);
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
                    if(!empty($Contact->whatsapp_id)){
                        if(!isset($Contact->status_id))
                            $Contact->status_id = 2;
                        $Contact->created_at = '1959-01-01 00:00:00';
                        $Contact->updated_at = '1959-01-01 00:00:00';
                        $Contact->save();
                        
                        //processar atendentes
                        if ($contact['Email-Atendente']!=""){
                            if(filter_var(trim($contact['Email-Atendente']), FILTER_VALIDATE_EMAIL)){
                                $attendant_email = trim($contact['Email-Atendente']);
                                //1. buscar el id del atendiente segun la empresa y el email dado
                                if (array_key_exists($attendant_email, $attendatn_ids)){
                                    if(isset($attendatn_ids[$attendant_email]) && ($last_attendant_id==null) || ($attendatn_ids[$attendant_email] != $last_attendant_id) ){
                                        //2. crear una fila en la tabla attendants_contacts                                
                                        $AttendantsContact = new AttendantsContact();
                                        $AttendantsContact->created_at = '1959-01-01 00:00:00';
                                        $AttendantsContact->updated_at = '1959-01-01 00:00:00';
                                        $AttendantsContact->attendant_id = (int)$attendatn_ids[$attendant_email];
                                        $AttendantsContact->contact_id = $Contact->id;
                                        $AttendantsContact->save();
                                        $Contact = $Contact
                                            ->where('whatsapp_id' ,$whatsapp)
                                            ->where('company_id', '=', $User->company_id)
                                            ->first();
                                        $Contact->created_at = '1959-01-01 00:00:00';
                                        $Contact->updated_at = '1959-01-01 00:00:00';
                                        if($Contact->status_id == 2){
                                            $Contact->status_id = 1;
                                            $Contact->save();
                                        }
                                        $response[$i] = array(
                                            "message" => "Linha $i: contato $Contact->whatsapp_id adicionado corretamente. Contato atribuido ao atendente.",
                                            "code" => "success",
                                            // ECR: acho melhor usar assim
                                            // "message" => "1",
                                            // "code" => "success",
                                            // "whatsapp" => "$Contact->whatsapp_id",
                                            // "line" => "$i"
                                        );
                                    }
                                }else{
                                    $response[$i] = array(
                                        "message" => "Linha $i: contato $Contact->whatsapp_id adicionado corretamente. Contato não atribuido a um atendente; causa: email do atendente não pertence a esta empresa.",
                                        "code" => "warning"
                                    );
                                }
                            }else{
                                $response[$i] = array(
                                    "message" => "Linha $i: contato $Contact->whatsapp_id adicionado corretamente. Contato não atribuido a um atendente; causa: email do atendente inválido.",
                                    "code" => "warning"
                                );
                            }
                        }else{
                            $response[$i] = array(
                                "message" => "Linha $i: contato $Contact->whatsapp_id adicionado corretamente. Contato não atribuido a um atendente; email do atendente não indicado.",
                                "code" => "warning"
                            );
                        }
                    }else{
                        if(empty($Contact->whatsapp_id))
                            $response[$i] = array(
                                "message" => "Linha $i: contem um número de whatsapp inválido.",
                                "code" => "error"
                            );
                    }

                } catch (\Throwable $th) {
                    //throw $th;
                }
                $i++;
            }
            
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
