<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMessagesTypeRequest;
use App\Http\Requests\UpdateMessagesTypeRequest;
use App\Repositories\MessagesTypeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class MessagesTypeController extends AppBaseController
{
    /** @var  MessagesTypeRepository */
    private $messagesTypeRepository;

    public function __construct(MessagesTypeRepository $messagesTypeRepo)
    {
        $this->messagesTypeRepository = $messagesTypeRepo;
    }

    /**
     * Display a listing of the MessagesType.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->messagesTypeRepository->pushCriteria(new RequestCriteria($request));
        $messagesTypes = $this->messagesTypeRepository->all();

        return view('messages_types.index')
            ->with('messagesTypes', $messagesTypes);
    }

    /**
     * Show the form for creating a new MessagesType.
     *
     * @return Response
     */
    public function create()
    {
        return view('messages_types.create');
    }

    /**
     * Store a newly created MessagesType in storage.
     *
     * @param CreateMessagesTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateMessagesTypeRequest $request)
    {
        $input = $request->all();

        $messagesType = $this->messagesTypeRepository->create($input);

        Flash::success('Messages Type saved successfully.');

        return redirect(route('messagesTypes.index'));
    }

    /**
     * Display the specified MessagesType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $messagesType = $this->messagesTypeRepository->findWithoutFail($id);

        if (empty($messagesType)) {
            Flash::error('Messages Type not found');

            return redirect(route('messagesTypes.index'));
        }

        return view('messages_types.show')->with('messagesType', $messagesType);
    }

    /**
     * Show the form for editing the specified MessagesType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $messagesType = $this->messagesTypeRepository->findWithoutFail($id);

        if (empty($messagesType)) {
            Flash::error('Messages Type not found');

            return redirect(route('messagesTypes.index'));
        }

        return view('messages_types.edit')->with('messagesType', $messagesType);
    }

    /**
     * Update the specified MessagesType in storage.
     *
     * @param  int              $id
     * @param UpdateMessagesTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMessagesTypeRequest $request)
    {
        $messagesType = $this->messagesTypeRepository->findWithoutFail($id);

        if (empty($messagesType)) {
            Flash::error('Messages Type not found');

            return redirect(route('messagesTypes.index'));
        }

        $messagesType = $this->messagesTypeRepository->update($request->all(), $id);

        Flash::success('Messages Type updated successfully.');

        return redirect(route('messagesTypes.index'));
    }

    /**
     * Remove the specified MessagesType from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $messagesType = $this->messagesTypeRepository->findWithoutFail($id);

        if (empty($messagesType)) {
            Flash::error('Messages Type not found');

            return redirect(route('messagesTypes.index'));
        }

        $this->messagesTypeRepository->delete($id);

        Flash::success('Messages Type deleted successfully.');

        return redirect(route('messagesTypes.index'));
    }
}
