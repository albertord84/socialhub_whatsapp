<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateContactsStatusRequest;
use App\Http\Requests\UpdateContactsStatusRequest;
use App\Repositories\ContactsStatusRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ContactsStatusController extends AppBaseController
{
    /** @var  ContactsStatusRepository */
    private $contactsStatusRepository;

    public function __construct(ContactsStatusRepository $contactsStatusRepo)
    {
        $this->contactsStatusRepository = $contactsStatusRepo;
    }

    /**
     * Display a listing of the ContactsStatus.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {   
        $this->contactsStatusRepository->pushCriteria(new RequestCriteria($request));
        $contactsStatuses = $this->contactsStatusRepository->all();
        return $contactsStatuses->toJson();
        // return view('contacts_statuses.index')
        //     ->with('contactsStatuses', $contactsStatuses);
    }

    /**
     * Show the form for creating a new ContactsStatus.
     *
     * @return Response
     */
    public function create()
    {
        return view('contacts_statuses.create');
    }

    /**
     * Store a newly created ContactsStatus in storage.
     *
     * @param CreateContactsStatusRequest $request
     *
     * @return Response
     */
    public function store(CreateContactsStatusRequest $request)
    {
        $input = $request->all();

        $contactsStatus = $this->contactsStatusRepository->create($input);

        Flash::success('Contacts Status saved successfully.');

        return redirect(route('contactsStatuses.index'));
    }

    /**
     * Display the specified ContactsStatus.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $contactsStatus = $this->contactsStatusRepository->findWithoutFail($id);

        if (empty($contactsStatus)) {
            Flash::error('Contacts Status not found');

            return redirect(route('contactsStatuses.index'));
        }

        return view('contacts_statuses.show')->with('contactsStatus', $contactsStatus);
    }

    /**
     * Show the form for editing the specified ContactsStatus.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $contactsStatus = $this->contactsStatusRepository->findWithoutFail($id);

        if (empty($contactsStatus)) {
            Flash::error('Contacts Status not found');

            return redirect(route('contactsStatuses.index'));
        }

        return view('contacts_statuses.edit')->with('contactsStatus', $contactsStatus);
    }

    /**
     * Update the specified ContactsStatus in storage.
     *
     * @param  int              $id
     * @param UpdateContactsStatusRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateContactsStatusRequest $request)
    {
        $contactsStatus = $this->contactsStatusRepository->findWithoutFail($id);

        if (empty($contactsStatus)) {
            Flash::error('Contacts Status not found');

            return redirect(route('contactsStatuses.index'));
        }

        $contactsStatus = $this->contactsStatusRepository->update($request->all(), $id);

        Flash::success('Contacts Status updated successfully.');

        return redirect(route('contactsStatuses.index'));
    }

    /**
     * Remove the specified ContactsStatus from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $contactsStatus = $this->contactsStatusRepository->findWithoutFail($id);

        if (empty($contactsStatus)) {
            Flash::error('Contacts Status not found');

            return redirect(route('contactsStatuses.index'));
        }

        $this->contactsStatusRepository->delete($id);

        Flash::success('Contacts Status deleted successfully.');

        return redirect(route('contactsStatuses.index'));
    }
}
