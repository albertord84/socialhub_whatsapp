<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateContactsOriginsRequest;
use App\Http\Requests\UpdateContactsOriginsRequest;
use App\Repositories\ContactsOriginsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ContactsOriginsController extends AppBaseController
{
    /** @var  ContactsOriginsRepository */
    private $contactsOriginsRepository;

    public function __construct(ContactsOriginsRepository $contactsOriginsRepo)
    {
        $this->contactsOriginsRepository = $contactsOriginsRepo;
    }

    /**
     * Display a listing of the ContactsOrigins.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->contactsOriginsRepository->pushCriteria(new RequestCriteria($request));
        $contactsOrigins = $this->contactsOriginsRepository->all();

        return view('contacts_origins.index')
            ->with('contactsOrigins', $contactsOrigins);
    }

    /**
     * Show the form for creating a new ContactsOrigins.
     *
     * @return Response
     */
    public function create()
    {
        return view('contacts_origins.create');
    }

    /**
     * Store a newly created ContactsOrigins in storage.
     *
     * @param CreateContactsOriginsRequest $request
     *
     * @return Response
     */
    public function store(CreateContactsOriginsRequest $request)
    {
        $input = $request->all();

        $contactsOrigins = $this->contactsOriginsRepository->create($input);

        Flash::success('Contacts Origins saved successfully.');

        return redirect(route('contactsOrigins.index'));
    }

    /**
     * Display the specified ContactsOrigins.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $contactsOrigins = $this->contactsOriginsRepository->findWithoutFail($id);

        if (empty($contactsOrigins)) {
            Flash::error('Contacts Origins not found');

            return redirect(route('contactsOrigins.index'));
        }

        return view('contacts_origins.show')->with('contactsOrigins', $contactsOrigins);
    }

    /**
     * Show the form for editing the specified ContactsOrigins.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $contactsOrigins = $this->contactsOriginsRepository->findWithoutFail($id);

        if (empty($contactsOrigins)) {
            Flash::error('Contacts Origins not found');

            return redirect(route('contactsOrigins.index'));
        }

        return view('contacts_origins.edit')->with('contactsOrigins', $contactsOrigins);
    }

    /**
     * Update the specified ContactsOrigins in storage.
     *
     * @param  int              $id
     * @param UpdateContactsOriginsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateContactsOriginsRequest $request)
    {
        $contactsOrigins = $this->contactsOriginsRepository->findWithoutFail($id);

        if (empty($contactsOrigins)) {
            Flash::error('Contacts Origins not found');

            return redirect(route('contactsOrigins.index'));
        }

        $contactsOrigins = $this->contactsOriginsRepository->update($request->all(), $id);

        Flash::success('Contacts Origins updated successfully.');

        return redirect(route('contactsOrigins.index'));
    }

    /**
     * Remove the specified ContactsOrigins from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $contactsOrigins = $this->contactsOriginsRepository->findWithoutFail($id);

        if (empty($contactsOrigins)) {
            Flash::error('Contacts Origins not found');

            return redirect(route('contactsOrigins.index'));
        }

        $this->contactsOriginsRepository->delete($id);

        Flash::success('Contacts Origins deleted successfully.');

        return redirect(route('contactsOrigins.index'));
    }
}
