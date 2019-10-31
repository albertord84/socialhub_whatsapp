<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateContactsStatusRequest;
use App\Repositories\ContactsStatusRepository;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ExtendedContactsStatusController extends ContactsStatusController
{
    
    const ADMIN = 1; 
    const SELLER = 2; 
    const MANAGER = 3; 
    const ATTENDANT = 4; 
    const VISITOR = 5; 
    
    public function __construct(ContactsStatusRepository $contactsStatusRepo)
    {
        parent::__construct($contactsStatusRepo);
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
}
