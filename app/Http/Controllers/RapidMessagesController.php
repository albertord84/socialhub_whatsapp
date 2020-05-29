<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRapidMessagesRequest;
use App\Http\Requests\UpdateRapidMessagesRequest;
use App\Repositories\RapidMessagesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class RapidMessagesController extends AppBaseController
{
    /** @var  RapidMessagesRepository */
    private $rapidMessagesRepository;

    public function __construct(RapidMessagesRepository $rapidMessagesRepo)
    {
        $this->rapidMessagesRepository = $rapidMessagesRepo;
    }

    /**
     * Display a listing of the RapidMessages.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $attendant_id = $request['attendant_id'];
        $rapidMessages = $this->rapidMessagesRepository->getRapidMessageByAttendantId($attendant_id);
        return $rapidMessages->toJson();
        
        // $this->rapidMessagesRepository->pushCriteria(new RequestCriteria($request));
        // return view('rapid_messages.index')
        //     ->with('rapidMessages', $rapidMessages);
    }

    /**
     * Show the form for creating a new RapidMessages.
     *
     * @return Response
     */
    public function create()
    {
        return view('rapid_messages.create');
    }

    /**
     * Store a newly created RapidMessages in storage.
     *
     * @param CreateRapidMessagesRequest $request
     *
     * @return Response
     */
    public function store(CreateRapidMessagesRequest $request)
    {
        $input = $request->all();

        $rapidMessages = $this->rapidMessagesRepository->create($input);

        return $rapidMessages->toJson();

        // Flash::success('Rapid Messages saved successfully.');

        // return redirect(route('rapidMessages.index'));
    }

    /**
     * Display the specified RapidMessages.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $rapidMessages = $this->rapidMessagesRepository->findWithoutFail($id);

        if (empty($rapidMessages)) {
            Flash::error('Rapid Messages not found');

            return redirect(route('rapidMessages.index'));
        }

        return view('rapid_messages.show')->with('rapidMessages', $rapidMessages);
    }

    /**
     * Show the form for editing the specified RapidMessages.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $rapidMessages = $this->rapidMessagesRepository->findWithoutFail($id);

        if (empty($rapidMessages)) {
            Flash::error('Rapid Messages not found');

            return redirect(route('rapidMessages.index'));
        }

        return view('rapid_messages.edit')->with('rapidMessages', $rapidMessages);
    }

    /**
     * Update the specified RapidMessages in storage.
     *
     * @param  int              $id
     * @param UpdateRapidMessagesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRapidMessagesRequest $request)
    {
        $rapidMessages = $this->rapidMessagesRepository->findWithoutFail($id);

        // if (empty($rapidMessages)) {
        //     Flash::error('Rapid Messages not found');

        //     return redirect(route('rapidMessages.index'));
        // }

        $rapidMessages = $this->rapidMessagesRepository->update($request->all(), $id);

        return $rapidMessages->toJson();

        // Flash::success('Rapid Messages updated successfully.');

        // return redirect(route('rapidMessages.index'));
    }

    /**
     * Remove the specified RapidMessages from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $rapidMessages = $this->rapidMessagesRepository->findWithoutFail($id);

        // if (empty($rapidMessages)) {
        //     Flash::error('Rapid Messages not found');

        //     return redirect(route('rapidMessages.index'));
        // }

        $this->rapidMessagesRepository->delete($id);

        // Flash::success('Rapid Messages deleted successfully.');

        // return redirect(route('rapidMessages.index'));
    }
}
