<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateContactsTagsRequest;
use App\Http\Requests\UpdateContactsTagsRequest;
use App\Repositories\ContactsTagsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ContactsTagsController extends AppBaseController
{
    /** @var  ContactsTagsRepository */
    private $contactsTagsRepository;

    public function __construct(ContactsTagsRepository $contactsTagsRepo)
    {
        $this->contactsTagsRepository = $contactsTagsRepo;
    }

    /**
     * Display a listing of the ContactsTags.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $contact_id = $request['contact_id'];
        
        $this->contactsTagsRepository->pushCriteria(new RequestCriteria($request));
        // $contactsTags = $this->contactsTagsRepository->all();
        $contactsTags = $this->contactsTagsRepository->contactTags($contact_id);

        return $contactsTags->toJson();

        // return view('contacts_tags.index')
        //     ->with('contactsTags', $contactsTags);
    }

    /**
     * Show the form for creating a new ContactsTags.
     *
     * @return Response
     */
    public function create()
    {
        return view('contacts_tags.create');
    }

    /**
     * Store a newly created ContactsTags in storage.
     *
     * @param CreateContactsTagsRequest $request
     *
     * @return Response
     */
    public function store(CreateContactsTagsRequest $request)
    {
        $input = $request->all();

        $contactsTags = $this->contactsTagsRepository->create($input);

        Flash::success('Contacts Tags saved successfully.');

        return $contactsTags->toJson();

        // return redirect(route('contactsTags.index'));
    }

    /**
     * Display the specified ContactsTags.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $contactsTags = $this->contactsTagsRepository->findWithoutFail($id);

        if (empty($contactsTags)) {
            Flash::error('Contacts Tags not found');

            return redirect(route('contactsTags.index'));
        }

        return view('contacts_tags.show')->with('contactsTags', $contactsTags);
    }

    /**
     * Show the form for editing the specified ContactsTags.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $contactsTags = $this->contactsTagsRepository->findWithoutFail($id);

        if (empty($contactsTags)) {
            Flash::error('Contacts Tags not found');

            return redirect(route('contactsTags.index'));
        }

        return view('contacts_tags.edit')->with('contactsTags', $contactsTags);
    }

    /**
     * Update the specified ContactsTags in storage.
     *
     * @param  int              $id
     * @param UpdateContactsTagsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateContactsTagsRequest $request)
    {
        $contactsTags = $this->contactsTagsRepository->findWithoutFail($id);

        if (empty($contactsTags)) {
            Flash::error('Contacts Tags not found');

            return redirect(route('contactsTags.index'));
        }

        $contactsTags = $this->contactsTagsRepository->update($request->all(), $id);

        Flash::success('Contacts Tags updated successfully.');

        return redirect(route('contactsTags.index'));
    }

    /**
     * Remove the specified ContactsTags from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $contactsTags = $this->contactsTagsRepository->findWithoutFail($id);

        if (empty($contactsTags)) {
            Flash::error('Contacts Tags not found');

            return redirect(route('contactsTags.index'));
        }

        $this->contactsTagsRepository->delete($id);

        Flash::success('Contacts Tags deleted successfully.');

        // return redirect(route('contactsTags.index'));
    }
}
