<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMessageTypeRequest;
use App\Http\Requests\UpdateMessageTypeRequest;
use App\Repositories\MessageTypeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class MessageTypeController extends AppBaseController
{
    /** @var  MessageTypeRepository */
    private $messageTypeRepository;

    public function __construct(MessageTypeRepository $messageTypeRepo)
    {
        $this->messageTypeRepository = $messageTypeRepo;
    }

    /**
     * Display a listing of the MessageType.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->messageTypeRepository->pushCriteria(new RequestCriteria($request));
        $messageTypes = $this->messageTypeRepository->all();

        return view('message_types.index')
            ->with('messageTypes', $messageTypes);
    }

    /**
     * Show the form for creating a new MessageType.
     *
     * @return Response
     */
    public function create()
    {
        return view('message_types.create');
    }

    /**
     * Store a newly created MessageType in storage.
     *
     * @param CreateMessageTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateMessageTypeRequest $request)
    {
        $input = $request->all();

        $messageType = $this->messageTypeRepository->create($input);

        Flash::success('Message Type saved successfully.');

        return redirect(route('messageTypes.index'));
    }

    /**
     * Display the specified MessageType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $messageType = $this->messageTypeRepository->findWithoutFail($id);

        if (empty($messageType)) {
            Flash::error('Message Type not found');

            return redirect(route('messageTypes.index'));
        }

        return view('message_types.show')->with('messageType', $messageType);
    }

    /**
     * Show the form for editing the specified MessageType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $messageType = $this->messageTypeRepository->findWithoutFail($id);

        if (empty($messageType)) {
            Flash::error('Message Type not found');

            return redirect(route('messageTypes.index'));
        }

        return view('message_types.edit')->with('messageType', $messageType);
    }

    /**
     * Update the specified MessageType in storage.
     *
     * @param  int              $id
     * @param UpdateMessageTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMessageTypeRequest $request)
    {
        $messageType = $this->messageTypeRepository->findWithoutFail($id);

        if (empty($messageType)) {
            Flash::error('Message Type not found');

            return redirect(route('messageTypes.index'));
        }

        $messageType = $this->messageTypeRepository->update($request->all(), $id);

        Flash::success('Message Type updated successfully.');

        return redirect(route('messageTypes.index'));
    }

    /**
     * Remove the specified MessageType from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $messageType = $this->messageTypeRepository->findWithoutFail($id);

        if (empty($messageType)) {
            Flash::error('Message Type not found');

            return redirect(route('messageTypes.index'));
        }

        $this->messageTypeRepository->delete($id);

        Flash::success('Message Type deleted successfully.');

        return redirect(route('messageTypes.index'));
    }
}
