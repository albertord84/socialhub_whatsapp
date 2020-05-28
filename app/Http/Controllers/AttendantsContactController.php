<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAttendantsContactRequest;
use App\Http\Requests\UpdateAttendantsContactRequest;
use App\Repositories\AttendantsContactRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class AttendantsContactController extends AppBaseController
{
    /** @var  AttendantsContactRepository */
    private $attendantsContactRepository;

    public function __construct(AttendantsContactRepository $attendantsContactRepo)
    {
        $this->attendantsContactRepository = $attendantsContactRepo;
    }

    /**
     * Display a listing of the AttendantsContact.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->attendantsContactRepository->pushCriteria(new RequestCriteria($request));
        $attendantsContacts = $this->attendantsContactRepository->all();

        // return view('attendants_contacts.index')
        //     ->with('attendantsContacts', $attendantsContacts);

        return $attendantsContacts->toJson();
    }

    /**
     * Show the form for creating a new AttendantsContact.
     *
     * @return Response
     */
    public function create()
    {
        return view('attendants_contacts.create');
    }

    /**
     * Store a newly created AttendantsContact in storage.
     *
     * @param CreateAttendantsContactRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $attendantsContact = $this->attendantsContactRepository->create($input);

        Flash::success('Attendants Contact saved successfully.');

        // return redirect(route('attendantsContacts.index'));
    }

    /**
     * Display the specified AttendantsContact.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $attendantsContact = $this->attendantsContactRepository->findWithoutFail($id);

        if (empty($attendantsContact)) {
            Flash::error('Attendants Contact not found');

            return redirect(route('attendantsContacts.index'));
        }

        return view('attendants_contacts.show')->with('attendantsContact', $attendantsContact);
    }

    /**
     * Show the form for editing the specified AttendantsContact.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $attendantsContact = $this->attendantsContactRepository->findWithoutFail($id);

        if (empty($attendantsContact)) {
            Flash::error('Attendants Contact not found');

            return redirect(route('attendantsContacts.index'));
        }

        return view('attendants_contacts.edit')->with('attendantsContact', $attendantsContact);
    }

    /**
     * Update the specified AttendantsContact in storage.
     *
     * @param  int              $id
     * @param UpdateAttendantsContactRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAttendantsContactRequest $request)
    {
        $attendantsContact = $this->attendantsContactRepository->findWithoutFail($id);

        if (empty($attendantsContact)) {
            Flash::error('Attendants Contact not found');

            return redirect(route('attendantsContacts.index'));
        }

        $attendantsContact = $this->attendantsContactRepository->update($request->all(), $id);

        Flash::success('Attendants Contact updated successfully.');

        return $attendantsContact->toJson();
    }

    /**
     * Remove the specified AttendantsContact from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $attendantsContact = $this->attendantsContactRepository->findWithoutFail($id);

        if (empty($attendantsContact)) {
            Flash::error('Attendants Contact not found');

            return redirect(route('attendantsContacts.index'));
        }

        $this->attendantsContactRepository->delete($id);

        Flash::success('Attendants Contact deleted successfully.');

    }
}
