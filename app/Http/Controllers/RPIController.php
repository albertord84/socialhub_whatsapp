<?php

namespace App\Http\Controllers;

use App\Events\MessageToAttendant;
use App\Events\NewContactMessage;
use App\Models\ExtendedChat;
use App\Models\Company;
use App\Models\Contact;
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
        $input = $request->all();
        // var_dump($input);
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
            // dd($Contact->latestAttendantContact->attendant_id);
            if ($Contact->latestAttendantContact) {
                $Chat->table = $Contact->latestAttendantContact->attendant_id;
                $Chat->attendant_id = $Contact->latestAttendantContact->attendant_id;
            }
            $Chat->contact_id = $Contact->id;
            
            broadcast(new MessageToAttendant($Chat));
            
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
            
            broadcast(new NewContactMessage($company_id));
            
        }


        $Chat->save();
        
        $Chat->contact_name = $Contact->first_name;
        if ($Contact->latestAttendantContact) {
            $Chat->attendant_name = $Contact->latestAttendantContact->attendant_name;
        }

        return $Chat->toJson();
    }

}
