<?php

namespace App\Http\Controllers;

use App\Business\FileUtils;
use App\Events\MessageToAttendant;
use App\Events\NewContactMessage;
use App\Models\Chat;
use App\Models\Contact;
use App\Models\ExtendedChat;
use Illuminate\Http\Request;
use Response;

class RPIController extends Controller
{
    private $APP_WP_API_URL;

    public function __construct()
    {
        $this->APP_WP_API_URL = env('APP_WP_API_URL');
    }

    /**
     * Display a listing of the Chat.
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        dd("ok");
    }

    /**
     * Recive Text Message
     * @param Request $request
     * @return Response
     */
    public function reciveTextMessage(Request $request)
    {
        // dd("test 2 ok");
        $input = $request->all();
        $contact_Jid = $input['Jid'];

        // TODO: Alberto
        $company_id = 1;
        // $company_id = $input['company_id'];
        // $contact_Jid = "123";

        $Contact = Contact::with(['Status', 'latestAttendantContact', 'latestAttendant'])->where(['whatsapp_id' => $contact_Jid])->first();

        $Chat = $this->messageToChatModel($input, $Contact);

        $Chat->save();

        if ($Contact) {
            // Send event to attendants with new chat message
            broadcast(new MessageToAttendant($Chat));
        } else {
            // Send event to all attendants with new contact
            broadcast(new NewContactMessage($company_id));
        }

        $Chat->contact_name = $Contact->first_name;
        if ($Contact->latestAttendantContact) {
            $userAttendant = $Contact->latestAttendant->attendant()->first()->user()->first();
            $Chat->attendant_name = $userAttendant ? $userAttendant->name : "Atendant not identified";
        }

        return $Chat->toJson();
    }

    /**
     * Recive Image Message
     * @param Request $request
     * @return Response
     */
    public function reciveImageMessage(Request $request)
    {
        dd("test 3 ok");

        $input = $request->all();

        $Chat = $this->messageToChatModel($input);

        $Chat->attendant_id = $Chat->attendant_id ? $Chat->attendant_id : "NULL";
        $files_path = env('APP_FILE_PATH', 'app.socialhub.pro.files');
        $path = base_path() . "/../$files_path/attendants/$Chat->attendant_id/$Chat->contact_id";

        $file_response = FileUtils::SavePostFile($request->file('File'), $path, $Chat->id);

        $Chat->data = $file_response;
        $Chat->save();

        return $Chat->toJson();
    }

    /**
     * Create a Chat model from a RPi message
     *
     * @param array Request $input
     * @return Chat
     */
    public function messageToChatModel(array $input, Contact $Contact): Chat
    {
        $contact_Jid = $input['Jid'];

        $Chat = new ExtendedChat();
        $Chat->source = 1;
        $Chat->message = $input['Msg'];
        $Chat->created_at = $input['Date'];
        $Chat->type_id = 1; // TEXT
        $Chat->status_id = 1; // Active
        $Chat->socialnetwork_id = 1; // WhatsApp
        if ($Contact) {
            $Chat = new Chat();
            if ($Contact->latestAttendantContact) {
                $Chat->table = $Contact->latestAttendantContact->attendant_id;
                $Chat->attendant_id = $Contact->latestAttendantContact->attendant_id;
            }
            $Chat->contact_id = $Contact->id;
            $Chat->source = 1;
            $Chat->message = $input['Msg'];
            $Chat->created_at = $input['Date'];
            $Chat->type_id = 1; // TEXT
            $Chat->status_id = 1; // Active
            $Chat->socialnetwork_id = 1; // WhatsApp


        } else {
            // TODO: Albert: Conferir com o Bruno
            $company_phone = $input['CompanyPhone'];
            $Company = Company::where(['whatsapp_id' => $company_phone])->first();

            // Create Mock Contact
            $Contact = new Contact();
            $Contact->first_name = $contact_Jid;
            $Contact->company_id = $Company->id;
            $Contact->whatsapp_id = $contact_Jid;

            // TODO: Jose: Remoe it
            $Contact->attendant_id = 4;

            $Contact->save();
            // Create Chat Message
            $Chat->contact_id = $Contact->id;
            $Chat->source = 1;
            $Chat->message = $input['Msg'];
            $Chat->created_at = $input['Date'];
            $Chat->type_id = 1; // TEXT
            $Chat->status_id = 1; // Active
            $Chat->socialnetwork_id = 1; // WhatsApp

        }

        return $Chat;
    }

    public function sendMessage(string $message, string $contact_Jid)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $url = $this->APP_WP_API_URL . '/SendTextMessage';

            $form_params['RemoteJid'] = $contact_Jid;
            $form_params['Contact'] = Contact::where(['whatsapp_id' => $contact_Jid])->first();
            $form_params['Message'] = $message;
            $response = $client->request('POST', $url, [
                'form_params' => [
                    'RemoteJid' => $contact_Jid,
                    'Message' => $message,
                ],
            ]);

            // dd($response);
            return $response;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
