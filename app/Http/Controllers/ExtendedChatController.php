<?php

namespace App\Http\Controllers;

use App\Business\ChatsBusiness;
use App\Business\FileUtils;
use App\Events\NewContactMessage;
use App\Http\Requests\CreateChatRequest;
use App\Http\Requests\UpdateChatRequest;
use App\Models\Contact;
use App\Repositories\ExtendedChatRepository;
use Auth;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Response;

use function GuzzleHttp\json_encode;

class ExtendedChatController extends ChatController
{
    private $APP_WP_API_URL;

    public function __construct(ExtendedChatRepository $chatRepo)
    {
        parent::__construct($chatRepo);

        $this->chatRepository = $chatRepo;

        $this->APP_WP_API_URL = env('APP_WP_API_URL');
    }

    /**
     * Display a listing of the Chat.
     * @param Request $request
     * @return Response
     */
    public function getBagContact(Request $request)
    {
        $User = Auth::check() ? Auth::user() : session('logged_user');
        $attendant_id = $User->id;
        
        $Contact = $this->chatRepository->getBagContact($attendant_id);
        Log::debug('getContactFromBag | ExtendedChatController | Contact: ', [$Contact]);
        
        $newContactsCount = (new ChatsBusiness())->getBagContactsCount($User->company_id);
        broadcast(new NewContactMessage($User->company_id, $newContactsCount));

        if($Contact){
            // Get cotact info (profile photo etc..)
            $Controller = new ExternalRPIController();
            $contactInfo = $Controller->getContactInfo($Contact->whatsapp_id);
            Log::debug('getContactFromBag | ExtendedChatController | whatsapp_id: ', [$Contact->whatsapp_id]);
            Log::debug('getContactFromBag | ExtendedChatController: ', [$contactInfo]);
            $Contact->json_data = json_encode($contactInfo);
            
            // Update contact without latestAttendant
            $UpdateContact = Contact::find($Contact->id);
            $UpdateContact->json_data = $Contact->json_data;
            $UpdateContact->save();
        }

        return $Contact->toJson();
    }

    /**
     * Display a listing of the Chat.
     * @param Request $request
     * @return Response
     */
    public function index(Request $request) //
    {
        $User = Auth::check() ? Auth::user() : session('logged_user');
        $contact_id = (int) $request['contact_id'];

        $page = (int) $request['page'];
        $searchMessageByStringInput = (isset($request['searchMessageByStringInput'])) ? $request['searchMessageByStringInput'] : '';
        
        $Contact = $this->chatRepository->contactChatAllAttendants($contact_id, $page, $searchMessageByStringInput);

        return $Contact->toJson();
    }
    
    public function getBagContactsCount(Request $request) //
    {
        $User = Auth::check() ? Auth::user() : session('logged_user');
        $newContactsCount = (new ChatsBusiness())->getBagContactsCount($User->company_id);

        return $newContactsCount;
    }

    /**
     * Display a listing of the Chat.
     * @param Request $request
     * @return Response
     */
    

    /**
     * Display a listing of the Chat.
     * @param Request $request
     * @return Response
     */
    public function indexOld(Request $request)
    {
        $User = Auth::check() ? Auth::user() : session('logged_user');
        $contact_id = (int) $request['contact_id'];
        $page = (int) $request['page'];
        $searchMessageByStringInput = (isset($request['searchMessageByStringInput'])) ? $request['searchMessageByStringInput'] : '';
        
        $Contact = $this->chatRepository->contactChat($User->id, $contact_id, $page, $searchMessageByStringInput);

        return $Contact->toJson();
    }

    /**
     * Store a newly created Chat in storage.
     * @param CreateChatRequest $request
     * @return Response
     */
    public function store(CreateChatRequest $request)
    {
        // Send text message to SH Rest API
        $User = Auth::check() ? Auth::user() : session('logged_user');
        $input = $request->all();
        $input['attendant_id'] = $User->id;

        $Contact = Contact::findOrFail($input['contact_id']);
        $externalRPiController = new ExternalRPIController();

        $chat = $this->chatRepository->createMessage($input);
        
        if (isset($input['file'])) {
            $fileName = $chat->id; // Laravel Auto gerated file name
            // $envFilePath = env('APP_FILE_PATH');
            // $filePath = "$envFilePath/$Contact->company_id/contacts/$Contact->id/chat_files";
            $filePath = "companies/$Contact->company_id/contacts/$Contact->id/chat_files";
            $json_data = FileUtils::SavePostFile($request->file, $filePath, $fileName);
            if ($json_data) { // Save file to disk (public/app/..)
                // $fileContent = Storage::disk('chats_files')->get("$json_data->FullPath"); // Retrive file like file_get_content(...) 
                $fileContent = Storage::disk('chats_files')->get("$json_data->SavedFilePath/$json_data->SavedFileName"); // Retrive file like file_get_content(...) 
                $response = $externalRPiController->sendFileMessage(
                    $fileContent, $json_data->SavedFileName, $input['type_id'], 
                    $input['message'], $Contact
                );
                
                $chat->data = json_encode($json_data);

                $chat->save();
                // $chat = $this->chatRepository->updateMessage($input, $chat->id);
            }
        } else {
            $response = $externalRPiController->sendTextMessage($input['message'], $Contact);
        }

        Flash::success('Chat saved successfully.');

        return $chat->toJson();
    }

    /**
     * Update the specified Chat in storage.
     * @param  int              $id
     * @param UpdateChatRequest $request
     * @return Response
     */
    public function update($id, UpdateChatRequest $request)
    {
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
    public function destroy($id)
    {
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
