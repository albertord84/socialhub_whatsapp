<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAttendantsTagsRequest;
use App\Http\Requests\UpdateAttendantsTagsRequest;
use App\Repositories\AttendantsTagsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class AttendantsTagsController extends AppBaseController
{
    /** @var  AttendantsTagsRepository */
    private $attendantsTagsRepository;

    public function __construct(AttendantsTagsRepository $attendantsTagsRepo)
    {
        $this->attendantsTagsRepository = $attendantsTagsRepo;
    }

    /**
     * Display a listing of the AttendantsTags.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $attendant_id = $request['attendant_id'];
        $this->attendantsTagsRepository->pushCriteria(new RequestCriteria($request));
        $attendantsTags = $this->attendantsTagsRepository->attendantTags($attendant_id);

        return $attendantsTags->toJson();
        
        // return view('attendants_tags.index')
        //     ->with('attendantsTags', $attendantsTags);
    }

    /**
     * Show the form for creating a new AttendantsTags.
     *
     * @return Response
     */
    public function create()
    {
        return view('attendants_tags.create');
    }

    /**
     * Store a newly created AttendantsTags in storage.
     *
     * @param CreateAttendantsTagsRequest $request
     *
     * @return Response
     */
    public function store(CreateAttendantsTagsRequest $request)
    {
        $input = $request->all();

        $attendantsTags = $this->attendantsTagsRepository->create($input);

        Flash::success('Attendants Tags saved successfully.');

        return $attendantsTags->toJson();

        // return redirect(route('attendantsTags.index'));
    }

    /**
     * Display the specified AttendantsTags.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $attendantsTags = $this->attendantsTagsRepository->findWithoutFail($id);

        if (empty($attendantsTags)) {
            Flash::error('Attendants Tags not found');

            return redirect(route('attendantsTags.index'));
        }

        return view('attendants_tags.show')->with('attendantsTags', $attendantsTags);
    }

    /**
     * Show the form for editing the specified AttendantsTags.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $attendantsTags = $this->attendantsTagsRepository->findWithoutFail($id);

        if (empty($attendantsTags)) {
            Flash::error('Attendants Tags not found');

            return redirect(route('attendantsTags.index'));
        }

        return view('attendants_tags.edit')->with('attendantsTags', $attendantsTags);
    }

    /**
     * Update the specified AttendantsTags in storage.
     *
     * @param  int              $id
     * @param UpdateAttendantsTagsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAttendantsTagsRequest $request)
    {
        $attendantsTags = $this->attendantsTagsRepository->findWithoutFail($id);

        if (empty($attendantsTags)) {
            Flash::error('Attendants Tags not found');

            return redirect(route('attendantsTags.index'));
        }

        $attendantsTags = $this->attendantsTagsRepository->update($request->all(), $id);

        Flash::success('Attendants Tags updated successfully.');

        return redirect(route('attendantsTags.index'));
    }

    /**
     * Remove the specified AttendantsTags from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $attendantsTags = $this->attendantsTagsRepository->findWithoutFail($id);

        if (empty($attendantsTags)) {
            Flash::error('Attendants Tags not found');

            return redirect(route('attendantsTags.index'));
        }

        $this->attendantsTagsRepository->delete($id);

        Flash::success('Attendants Tags deleted successfully.');

        return redirect(route('attendantsTags.index'));
    }
}
