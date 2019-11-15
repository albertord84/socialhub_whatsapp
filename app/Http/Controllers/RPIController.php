<?php

namespace App\Http\Controllers;

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
        // dd("test 3 ok");

        // $input = $request->all();

        // $Chat = $this->messageToChatModel($input);

        // $Chat->attendant_id = $Chat->attendant_id ? $Chat->attendant_id : "NULL";
        // $path = base_path() . "/../socialhub_mvp_files/attendants/$Chat->attendant_id/$Chat->contact_id";

        // $file_response = FileUtils::SavePostFile($request->file('File'), $path, $Chat->id);

        // $Chat->data = $file_response;
        // $Chat->save();

        // return $Chat->toJson();
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

        // TODO: Alberto
        $company_id = 1;
        // $company_id = $input['company_id'];
        // $contact_Jid = "123";

        $Contact = Contact::with(['Status', 'latestAttendantContact', 'latestAttendant'])->where(['whatsapp_id' => $contact_Jid])->first();

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

}
