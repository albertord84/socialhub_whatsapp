<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Repositories\ExtendedAttendantsContactRepository;
use App\Repositories\ExtendedContactRepository;
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
            $Contacts = $this->contactRepository->all();
            if ($User->role_id == ExtendedContactsStatusController::MANAGER) {
                $Contacts = $this->contactRepository->fullContacts((int) $User->company_id, null);
            } else if ($User->role_id == ExtendedContactsStatusController::ATTENDANT) {
                $filter = $request->filter_contact;
                $Contacts = $this->contactRepository->fullContacts((int) $User->company_id, (int) $User->id, $filter);
            }

            return $Contacts->toJson();
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

        //TODO-JR-ALBERTO: um contato pode ser criado por:
        //um robot: manda para sacola
        //um admin desde CVS: va para sacola
        //um atendente: deve ser inserido com o Id do atendente que esta na sessão
        //um admin manualmente: pode ir para a sacola ou pode ser atribuido a um atendente:
        //onde devo enviar o contact_atendant_id, por url ou nos dados?

        $User = Auth::check() ? Auth::user() : session('logged_user');
        $input['company_id'] = $User->company_id;
        $contact = $this->contactRepository->create($input);

        // TODO: Create Contact Chat Table

        Flash::success('Contact saved successfully.');

        return $contact->toJson();
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

        //TODO-JR-ALBERTO: um contato pode ser atualizado por:
        //um atendente: atualiza dados do contato, status, atendente
        //um admin: onde devo enviar o contact_atendant_id, por url ou nos dados?

        unset($input["created_at"]);
        unset($input["updated_at"]);

        if (empty($contact)) {
            Flash::error('Contact not found');
            return redirect(route('contacts.index'));
        }

        $contact = $this->contactRepository->update($input, $id);

        Flash::success('Contact updated successfully.');

        // return redirect(route('contacts.index'));
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
}
