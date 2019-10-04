<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Repositories\ContactRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use Auth;

class ContactController extends AppBaseController
{
    /** @var  ContactRepository */
    private $contactRepository;

    public function __construct(ContactRepository $contactRepo)
    {
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
            // dd(UsersAttendant::with('User')->find(3));
            //TODO-JR-ALBERTO 
            //get contacts by company_id or by attendant_id
            $User = Auth::check()? Auth::user():session('logged_user');
            $Contacts = $this->contactRepository->all();;
            if ($User->role_id == ContactsStatusController::MANAGER) {
                $Contacts = $this->contactRepository->fullContacts($User->company_id, null);
            } 
            else if ($User->role_id == ContactsStatusController::ATTENDANT) {
                $Contacts = $this->contactRepository->fullContacts($User->company_id, (int)$User->id);
            }
            dd($Contacts);

            return $Contacts->toJson();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Show the form for creating a new Contact.
     *
     * @return Response
     */
    public function create()
    {
        return view('contacts.create');
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
            //um admin desde CVS: vai para sacola
            //um atendente: deve ser inserido com o Id do atendente que esta na sessão
            //um admin manualmente: pode ir para a sacola ou pode ser atribuido a um atendente: 
            // onde devo enviar o contact_atendant_id, por url ou nos dados? 
        $contact = $this->contactRepository->create($input);

        // TODO: Create Contact Chat Table
        //

        Flash::success('Contact saved successfully.');

        return redirect(route('contacts.index'));
    }

    /**
     * Display the specified Contact.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $contact = $this->contactRepository->findWithoutFail($id);

        if (empty($contact)) {
            Flash::error('Contact not found');

            return redirect(route('contacts.index'));
        }

        return view('contacts.show')->with('contact', $contact);
    }

    /**
     * Show the form for editing the specified Contact.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $contact = $this->contactRepository->findWithoutFail($id);

        if (empty($contact)) {
            Flash::error('Contact not found');

            return redirect(route('contacts.index'));
        }

        return view('contacts.edit')->with('contact', $contact);
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
        $contact = $this->contactRepository->findWithoutFail($id);

        //TODO-JR-ALBERTO: um contato pode ser atualizado por:
            //um atendente: atualiza dados do contato, status, atendente
            //um admin: onde devo enviar o contact_atendant_id, por url ou nos dados? 

        if (empty($contact)) {
            Flash::error('Contact not found');
            return redirect(route('contacts.index'));
        }

        $contact = $this->contactRepository->update($request->all(), $id);

        Flash::success('Contact updated successfully.');

        return redirect(route('contacts.index'));
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

        $this->contactRepository->delete($id);

        Flash::success('Contact deleted successfully.');

        return redirect(route('contacts.index'));
    }
}
