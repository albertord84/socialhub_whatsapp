<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateChatRequest;
use App\Http\Requests\UpdateChatRequest;
use App\Repositories\ExtendedChatRepository;

use Illuminate\Http\Request;
use Flash;
use Response;
use Auth;

class ExtendedChatController extends ChatController
{

    public function __construct(ExtendedChatRepository $chatRepo)
    {
        $this->chatRepository = $chatRepo;
    }

    /**
     * Display a listing of the Chat.
     * @param Request $request
     * @return Response
     */
    public function index(Request $request){
        //em $request->id deve vir o id do contato e a pagina de busca (que por default 0 é a mais recente)
        $User = Auth::check()? Auth::user():session('logged_user');
        // $this->chatRepository->pushCriteria(new RequestCriteria($request));
        $chats = $this->chatRepository->contactChat($User->id,$request->id,$request->page);
        return $chats->toJson();

        // $chats = $this->chatRepository->all();
        // return view('chats.index')
        //     ->with('chats', $chats);
    }

    /**
     * Store a newly created Chat in storage.
     * @param CreateChatRequest $request
     * @return Response
     */
    public function store(CreateChatRequest $request){
        $input = $request->all();

        $chat = $this->chatRepository->create($input);

        Flash::success('Chat saved successfully.');

        return redirect(route('chats.index'));
    }

    /**
     * Update the specified Chat in storage.
     * @param  int              $id
     * @param UpdateChatRequest $request
     * @return Response
     */
    public function update($id, UpdateChatRequest $request){
        $chat = $this->chatRepository->findWithoutFail($id);

        if (empty($chat)) {
            Flash::error('Chat not found');

            return redirect(route('chats.index'));
        }

        $chat = $this->chatRepository->update($request->all(), $id);

        Flash::success('Chat updated successfully.');

        return redirect(route('chats.index'));
    }

    /**
     * Remove the specified Chat from storage.
     * @param  int $id
     * @return Response
     */
    public function destroy($id){
        $chat = $this->chatRepository->findWithoutFail($id);

        if (empty($chat)) {
            Flash::error('Chat not found');

            return redirect(route('chats.index'));
        }

        $this->chatRepository->delete($id);

        Flash::success('Chat deleted successfully.');

        return redirect(route('chats.index'));
    }
}
