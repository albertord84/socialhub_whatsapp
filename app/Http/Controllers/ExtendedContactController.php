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

    public function contactsFromCSV(CreateContactRequest $request)
    {
       
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
