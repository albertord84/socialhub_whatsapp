<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateChatsBlingRequest;
use App\Http\Requests\UpdateChatsBlingRequest;
use App\Repositories\ChatsBlingRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ChatsBlingController extends AppBaseController
{
    /** @var  ChatsBlingRepository */
    private $chatsBlingRepository;

    public function __construct(ChatsBlingRepository $chatsBlingRepo)
    {
        $this->chatsBlingRepository = $chatsBlingRepo;
    }

    /**
     * Display a listing of the ChatsBling.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->chatsBlingRepository->pushCriteria(new RequestCriteria($request));
        $chatsBlings = $this->chatsBlingRepository->all();

        return view('chats_blings.index')
            ->with('chatsBlings', $chatsBlings);
    }

    /**
     * Show the form for creating a new ChatsBling.
     *
     * @return Response
     */
    public function create()
    {
        return view('chats_blings.create');
    }

    /**
     * Store a newly created ChatsBling in storage.
     *
     * @param CreateChatsBlingRequest $request
     *
     * @return Response
     */
    public function store(CreateChatsBlingRequest $request)
    {
        $input = $request->all();

        $chatsBling = $this->chatsBlingRepository->create($input);

        Flash::success('Chats Bling saved successfully.');

        return redirect(route('chatsBlings.index'));
    }

    /**
     * Display the specified ChatsBling.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $chatsBling = $this->chatsBlingRepository->findWithoutFail($id);

        if (empty($chatsBling)) {
            Flash::error('Chats Bling not found');

            return redirect(route('chatsBlings.index'));
        }

        return view('chats_blings.show')->with('chatsBling', $chatsBling);
    }

    /**
     * Show the form for editing the specified ChatsBling.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $chatsBling = $this->chatsBlingRepository->findWithoutFail($id);

        if (empty($chatsBling)) {
            Flash::error('Chats Bling not found');

            return redirect(route('chatsBlings.index'));
        }

        return view('chats_blings.edit')->with('chatsBling', $chatsBling);
    }

    /**
     * Update the specified ChatsBling in storage.
     *
     * @param  int              $id
     * @param UpdateChatsBlingRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateChatsBlingRequest $request)
    {
        $chatsBling = $this->chatsBlingRepository->findWithoutFail($id);

        if (empty($chatsBling)) {
            Flash::error('Chats Bling not found');

            return redirect(route('chatsBlings.index'));
        }

        $chatsBling = $this->chatsBlingRepository->update($request->all(), $id);

        Flash::success('Chats Bling updated successfully.');

        return redirect(route('chatsBlings.index'));
    }

    /**
     * Remove the specified ChatsBling from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $chatsBling = $this->chatsBlingRepository->findWithoutFail($id);

        if (empty($chatsBling)) {
            Flash::error('Chats Bling not found');

            return redirect(route('chatsBlings.index'));
        }

        $this->chatsBlingRepository->delete($id);

        Flash::success('Chats Bling deleted successfully.');

        return redirect(route('chatsBlings.index'));
    }
}
