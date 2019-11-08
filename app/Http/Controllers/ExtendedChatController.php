<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateChatRequest;
use App\Http\Requests\UpdateChatRequest;
use App\Models\Contact;
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
    public function index(Request $request) {
        $User = Auth::check()? Auth::user():session('logged_user');
        $contact_id = (int)$request['contact_id'];
        $page = (int)$request['page'];
        $searchMessageByStringInput = (isset($request['searchMessageByStringInput'])) ? $request['searchMessageByStringInput'] : '';
        $chats = $this->chatRepository->contactChat($User->id, $contact_id, $page, $searchMessageByStringInput);
        return $chats->toJson();
    }

    /**
     * Store a newly created Chat in storage.
     * @param CreateChatRequest $request
     * @return Response
     */
    public function store(CreateChatRequest $request) {
        // Send text message to SH Rest API 
        $User = Auth::check()? Auth::user():session('logged_user');
        $input = $request->all();
        $input['attendant_id'] = $User->id;

        $Contact = Contact::findOrFail($input['contact_id']);
        if ($this->send_message($input['message'], $Contact->whatsapp_id)) {
            $chat = $this->chatRepository->createMessage($input);        
            return $chat->toJson();
        }        

        return Flash::error('Chat saved successfully.');

        // Flash::success('Chat saved successfully.');
        // return redirect(route('chats.index'));
    }

    public function send_message(string $message, string $contact_id)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $url = "http://192.168.25.91:8000/SendTextMessage";
            
            $myBody['RemoteJid'] = $contact_id;
            $myBody['Message'] = $message;
            $request = $client->post($url,  ['body'=>$myBody]);
            $response = $request->send();

            dd($response);
            // return $response;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getGuzzleRequest()
    {
        $client = new \GuzzleHttp\Client();
        $request = $client->get('http://myexample.com');
        $response = $request->getBody();

        dd($response);
    }

    public function postGuzzleRequest()
    {
        $client = new \GuzzleHttp\Client();
        $url = "http://myexample.com/api/posts";

        $myBody['name'] = "Demo";
        $request = $client->post($url,  ['body'=>$myBody]);
        $response = $request->send();
    
        dd($response);
    }

    public function putGuzzleRequest()
    {
        $client = new \GuzzleHttp\Client();
        $url = "http://myexample.com/api/posts/1";
        $myBody['name'] = "Demo";
        $request = $client->put($url,  ['body'=>$myBody]);
        $response = $request->send();
    
        dd($response);
    }

    public function deleteGuzzleRequest()
    {
        $client = new \GuzzleHttp\Client();
        $url = "http://myexample.com/api/posts/1";
        $request = $client->delete($url);
        $response = $request->send();
    
        dd($response);
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
