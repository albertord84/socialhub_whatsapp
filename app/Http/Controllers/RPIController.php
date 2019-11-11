<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Contact;
use Illuminate\Http\Request;
use Response;
use stdClass;

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
        $input = $request->all();
        // var_dump($input);
        $contact_Jid = $input['Jid'];
        // $contact_Jid = "123";

        $Contact = Contact::with(['Status', 'latestAttendantContact', 'latestAttendant'])->where(['whatsapp_id' => $contact_Jid])->first();

        if ($Contact) {
            // dd($Contact->latestAttendantContact->attendant_id);
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
            $Chat->save();

            if ($Contact->latestAttendantContact) {
                $userAttendant = $Contact->latestAttendant->attendant()->first()->user()->first();
                $Chat->attendant_name = $userAttendant ? $userAttendant->name : "Atendant not identified";
            }
            $Chat->contact_name = $Contact->first_name;
            return $Chat->toJson();
        } else {
            // Create Mock Contact
            $Contact = new Contact();
            $Contact->first_name = $contact_Jid;
            $Contact->whatsapp_id = $contact_Jid;
            $Contact->save();
            // Create Chat Message
            $Chat = new Chat();
            $Chat->contact_id = $Contact->id;
            $Chat->source = 1;
            $Chat->message = $input['Msg'];
            $Chat->created_at = $input['Date'];
            $Chat->type_id = 1; // TEXT
            $Chat->status_id = 1; // Active
            $Chat->socialnetwork_id = 1; // WhatsApp
            $Chat->save();

            $Chat->contact_name = $Contact->first_name;
            if ($Contact->latestAttendantContact) {
                $Chat->attendant_name = $Contact->latestAttendantContact->attendant_name;
            }
            return $Chat->toJson();
        }

        $error = new stdClass();
        $error->code = 1;
        $error->message = "Error Reciveing Text Message";
        return $error->message;
        // return Flash::error('Chat saved successfully.');
    }

}
