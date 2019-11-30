<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMessagesStatusRequest;
use App\Http\Requests\UpdateMessagesStatusRequest;
use App\Repositories\MessagesStatusRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class MessagesStatusController extends AppBaseController
{
    const ROUTED = 1; 
    const SENDED = 2; 
    const RECEVEIVED = 3; 
    const READED = 4; 
    const DELETED = 5; 
    const UNREADED = 6; 
    
    /** @var  MessagesStatusRepository */
    private $messagesStatusRepository;

    public function __construct(MessagesStatusRepository $messagesStatusRepo)
    {
        $this->messagesStatusRepository = $messagesStatusRepo;
    }

    /**
     * Display a listing of the MessagesStatus.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->messagesStatusRepository->pushCriteria(new RequestCriteria($request));
        $messagesStatuses = $this->messagesStatusRepository->all();

        return view('messages_statuses.index')
            ->with('messagesStatuses', $messagesStatuses);
    }

    /**
     * Show the form for creating a new MessagesStatus.
     *
     * @return Response
     */
    public function create()
    {
        return view('messages_statuses.create');
    }

    /**
     * Store a newly created MessagesStatus in storage.
     *
     * @param CreateMessagesStatusRequest $request
     *
     * @return Response
     */
    public function store(CreateMessagesStatusRequest $request)
    {
        $input = $request->all();

        $messagesStatus = $this->messagesStatusRepository->create($input);

        Flash::success('Messages Status saved successfully.');

        return redirect(route('messagesStatuses.index'));
    }

    /**
     * Display the specified MessagesStatus.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $messagesStatus = $this->messagesStatusRepository->findWithoutFail($id);

        if (empty($messagesStatus)) {
            Flash::error('Messages Status not found');

            return redirect(route('messagesStatuses.index'));
        }

        return view('messages_statuses.show')->with('messagesStatus', $messagesStatus);
    }

    /**
     * Show the form for editing the specified MessagesStatus.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $messagesStatus = $this->messagesStatusRepository->findWithoutFail($id);

        if (empty($messagesStatus)) {
            Flash::error('Messages Status not found');

            return redirect(route('messagesStatuses.index'));
        }

        return view('messages_statuses.edit')->with('messagesStatus', $messagesStatus);
    }

    /**
     * Update the specified MessagesStatus in storage.
     *
     * @param  int              $id
     * @param UpdateMessagesStatusRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMessagesStatusRequest $request)
    {
        $messagesStatus = $this->messagesStatusRepository->findWithoutFail($id);

        if (empty($messagesStatus)) {
            Flash::error('Messages Status not found');

            return redirect(route('messagesStatuses.index'));
        }

        $messagesStatus = $this->messagesStatusRepository->update($request->all(), $id);

        Flash::success('Messages Status updated successfully.');

        return redirect(route('messagesStatuses.index'));
    }

    /**
     * Remove the specified MessagesStatus from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $messagesStatus = $this->messagesStatusRepository->findWithoutFail($id);

        if (empty($messagesStatus)) {
            Flash::error('Messages Status not found');

            return redirect(route('messagesStatuses.index'));
        }

        $this->messagesStatusRepository->delete($id);

        Flash::success('Messages Status deleted successfully.');

        return redirect(route('messagesStatuses.index'));
    }
}
