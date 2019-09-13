<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAttendentsContactRequest;
use App\Http\Requests\UpdateAttendentsContactRequest;
use App\Repositories\AttendentsContactRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class AttendentsContactController extends AppBaseController
{
    /** @var  AttendentsContactRepository */
    private $attendentsContactRepository;

    public function __construct(AttendentsContactRepository $attendentsContactRepo)
    {
        $this->attendentsContactRepository = $attendentsContactRepo;
    }

    /**
     * Display a listing of the AttendentsContact.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->attendentsContactRepository->pushCriteria(new RequestCriteria($request));
        $attendentsContacts = $this->attendentsContactRepository->all();

        return view('attendents_contacts.index')
            ->with('attendentsContacts', $attendentsContacts);
    }

    /**
     * Show the form for creating a new AttendentsContact.
     *
     * @return Response
     */
    public function create()
    {
        return view('attendents_contacts.create');
    }

    /**
     * Store a newly created AttendentsContact in storage.
     *
     * @param CreateAttendentsContactRequest $request
     *
     * @return Response
     */
    public function store(CreateAttendentsContactRequest $request)
    {
        $input = $request->all();

        $attendentsContact = $this->attendentsContactRepository->create($input);

        Flash::success('Attendents Contact saved successfully.');

        return redirect(route('attendentsContacts.index'));
    }

    /**
     * Display the specified AttendentsContact.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $attendentsContact = $this->attendentsContactRepository->findWithoutFail($id);

        if (empty($attendentsContact)) {
            Flash::error('Attendents Contact not found');

            return redirect(route('attendentsContacts.index'));
        }

        return view('attendents_contacts.show')->with('attendentsContact', $attendentsContact);
    }

    /**
     * Show the form for editing the specified AttendentsContact.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $attendentsContact = $this->attendentsContactRepository->findWithoutFail($id);

        if (empty($attendentsContact)) {
            Flash::error('Attendents Contact not found');

            return redirect(route('attendentsContacts.index'));
        }

        return view('attendents_contacts.edit')->with('attendentsContact', $attendentsContact);
    }

    /**
     * Update the specified AttendentsContact in storage.
     *
     * @param  int              $id
     * @param UpdateAttendentsContactRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAttendentsContactRequest $request)
    {
        $attendentsContact = $this->attendentsContactRepository->findWithoutFail($id);

        if (empty($attendentsContact)) {
            Flash::error('Attendents Contact not found');

            return redirect(route('attendentsContacts.index'));
        }

        $attendentsContact = $this->attendentsContactRepository->update($request->all(), $id);

        Flash::success('Attendents Contact updated successfully.');

        return redirect(route('attendentsContacts.index'));
    }

    /**
     * Remove the specified AttendentsContact from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $attendentsContact = $this->attendentsContactRepository->findWithoutFail($id);

        if (empty($attendentsContact)) {
            Flash::error('Attendents Contact not found');

            return redirect(route('attendentsContacts.index'));
        }

        $this->attendentsContactRepository->delete($id);

        Flash::success('Attendents Contact deleted successfully.');

        return redirect(route('attendentsContacts.index'));
    }
}
