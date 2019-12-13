<?php

namespace App\Http\Controllers;

use App\Business\ChatsBusiness;
use App\Business\FileUtils;
use App\Events\MessageToAttendant;
use App\Events\NewContactMessage;
use App\Models\Company;
use App\Models\Contact;
use App\Models\ExtendedChat;
use App\Models\Rpi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use stdClass;

class ExternalRPIController extends Controller
{
    private $APP_WP_API_URL;

    public function __construct()
    {
        $this->APP_WP_API_URL = env('APP_WP_API_URL', '');
        $this->APP_FILE_PATH = 'public/' . env('APP_FILE_PATH');
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
     * Update or Register RPi.
     * @param Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $rpiMAC = $request->MAC;
        $rpiUser = $request->user;
        $rpiPass = $request->password;

        $Company = Company::with('rpi')->whereHas('rpi', function($query) use ($rpiMAC) {
            $query->where(['mac' => $rpiMAC]);
        })->first();
        
        if (!$Company) { // Whether not found RPI associated to a company
            $RPI = Rpi::where(['mac' => $rpiMAC])->first();
            if (!$RPI) { // Whether not found RPI
                $RPI = $this->registerNewRPI($rpiMAC);
            }
        }

        return json_encode($Company);
    }

    public function registerNewRPI(string $MAC = null)
    {
        $RPI = new Rpi();
        try {
            $RPI->mac = $MAC;
            return $RPI->save();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Get QRCode
     */
    public static function getQRCode(Rpi $Rpi = null) //: stdClass

    {
        // $Rpi = new stdClass();
        // $Rpi->tunnel = 'http://shrpialberto.sa.ngrok.io.ngrok.io';
        $QRCode = new stdClass();
        try {
            $client = new \GuzzleHttp\Client();
            $url = $Rpi->api_tunnel . '/qrcode';

            $QRCode = $client->request('GET', $url);
            $QRCode = $QRCode->getBody()->getContents();
            $QRCode = json_decode($QRCode);
            return $QRCode;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Get Contact Info
     */
    // public function getContactInfo(string $contact_id = '551199723998')//: stdClass
    public function getContactInfo(string $contact_id = '5521976550734') //: stdClass
    {
        $contactInfo = new stdClass();
        try {
            $client = new \GuzzleHttp\Client();
            $url = $this->APP_WP_API_URL . '/GetContact';

            $contactInfo = $client->request('GET', $url, [
                'query' => ['RemoteJid' => $contact_id],
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
        return $contactInfo;
    }

    /**
     * Recive Text Message
     * @param Request $request
     * @return Response
     */
    public function reciveTextMessage(Request $request)
    {
        $input = $request->all();
        $contact_Jid = $input['Jid'];

        $contact_Jid = str_replace("@c.us", "", $contact_Jid);
        
        $company_phone = $input['CompanyPhone'];

        $Contact = Contact::with(['Status', 'latestAttendantContact', 'latestAttendant'])->where(['whatsapp_id' => $contact_Jid])->first();

        $Chat = $this->messageToChatModel($input, $Contact);
        if (!$Chat) {
            return "Ignored group message!";
        }

        $Chat->save();

        if ($Contact) {
            $Chat->contact_name = $Contact->first_name;
            if ($Contact->latestAttendantContact) {
                $userAttendant = $Contact->latestAttendant->attendant()->first()->user()->first();
                $Chat->attendant_name = $userAttendant ? $userAttendant->name : "Atendant not identified";
            }
            // Send event to attendants with new chat message
            broadcast(new MessageToAttendant($Chat));
        } else {
            // Send event to all attendants with new bag contact count
            $Company = Company::where(['phone' => $company_phone])->first();
            $bagContactsCount = (new ChatsBusiness())->getBagContactsCount($Company->id);
            broadcast(new NewContactMessage($Company->id, $bagContactsCount));
        }

        return $Chat->toJson();
    }

    /**
     * Recive Image Message
     * @param Request $request
     * @return Response
     */
    public function reciveFileMessage(Request $request)
    {
        $input = $request->all();
        $contact_Jid = $input['Jid'];

        $contact_Jid = str_replace("@c.us", "", $contact_Jid);

        $company_phone = $input['CompanyPhone'];
        
        $Company = Company::where(['phone' => $company_phone])->first();

        Log::debug('reciveFileMessage: ', [$input]);
        $Contact = Contact::with(['Status', 'latestAttendantContact', 'latestAttendant'])->where(['whatsapp_id' => $contact_Jid])->first();

        $Chat = $this->messageToChatModel($input, $Contact);
        if (!$Chat) {
            return "Ignored group message!";
        }

        $Chat->attendant_id = $Chat->attendant_id ? $Chat->attendant_id : "NULL";

        $filePath = "$Company->id/contacts/$Chat->contact_id/chat_files";
        // Log::debug('reciveFileMessage: ', [$filePath]);

        $file_response = FileUtils::SavePostFile($request->file('File'), $filePath, $Chat->id);
        // Log::debug('reciveFileMessage: ', [$file_response]);

        $Chat->data = json_encode($file_response);
        $Chat->save();

        if ($Contact) {
            // Send event to attendants with new chat message
            broadcast(new MessageToAttendant($Chat));
        } else {
            // Send event to all attendants with new contact
            $bagContactsCount = (new ChatsBusiness())->getBagContactsCount($Company->id);
            broadcast(new NewContactMessage($Company->id, $bagContactsCount));
        }

        return $Chat->toJson();
    }

    /**
     * Create a Chat model from a RPi message
     *
     * @param array Request $input
     * @return Chat
     */
    public function messageToChatModel(array $input, ?Contact $Contact): ExtendedChat
    {
        // if (strpos("@g.us", $input['Msg']) !== false) return null;

        $contact_Jid = $input['Jid'];
        $input['Type'] = isset($input['Type']) ? $input['Type'] : 'text';

        $type_id = 1; // text
        switch ($input['Type']) {
            case 'image':
                $type_id = 2;
                break;
            case 'audio':
                $type_id = 3;
                break;
        }

        $Chat = new ExtendedChat();
        $Chat->source = 1;
        $Chat->message = $input['Msg'];
        $Chat->type_id = $type_id;
        $Chat->status_id = MessagesStatusController::UNREADED; // Active
        $Chat->socialnetwork_id = 1; // WhatsApp
        $Chat->message = $input['Msg'];
        // $Chat->created_at = $input['Date'];
        if ($Contact) {
            if ($Contact->latestAttendantContact) {
                $Chat->table = $Contact->latestAttendantContact->attendant_id;
                $Chat->attendant_id = $Contact->latestAttendantContact->attendant_id;
            }
        } else {
            // Find Company by Phone Number
            $company_phone = $input['CompanyPhone'];
            $Company = Company::where(['phone' => $company_phone])->first();

            // Create Mock Contact
            $Contact = new Contact();
            $Contact->first_name = $contact_Jid;
            $Contact->company_id = $Company->id;
            $Contact->whatsapp_id = $contact_Jid;

            // TODO Alberto: Get contact info photo

            $Contact->save();
        }

        $Chat->contact_id = $Contact->id;
        $Chat->company_id = $Contact->company_id;
        $Chat->save();

        return $Chat;
    }

    public function sendTextMessage(string $message, string $contact_Jid)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $url = $this->APP_WP_API_URL . '/SendTextMessage';

            $response = $client->request('POST', $url, [
                'form_params' => [
                    'RemoteJid' => "$contact_Jid@s.whatsapp.net",
                    'Message' => $message,
                    'Contact' => Contact::where(['whatsapp_id' => $contact_Jid])->first(),
                ],
            ]);

            return $response;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // public function sendFileMessage(File $File, string $file_type, string $message, string $contact_Jid)
    public function sendFileMessage(string $File, string $file_name, string $file_type, ?string $message, string $contact_Jid)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $EndPoint = 'SendDocumentMessage';
            $FileName = 'Document';
            switch ($file_type) {
                // case 'image':
                case '2':
                    $EndPoint = 'SendImageMessage';
                    $FileName = 'Image';
                    break;

                // case 'audio':
                case '3':
                    $EndPoint = 'SendAudioMessage';
                    $FileName = 'Audio';
                    break;

                // case 'video':
                case '4':
                    $EndPoint = 'SendVideoMessage';
                    $FileName = 'Video';
                    break;
            }

            $url = $this->APP_WP_API_URL . "/$EndPoint";
            $Contact = Contact::where(['whatsapp_id' => $contact_Jid])->first();
            $response = $client->request('POST', $url, [
                'multipart' => [
                    [
                        'name' => "$FileName",
                        'contents' => $File,
                        'filename' => "$file_name",
                    ],
                    ['name' => "RemoteJid", 'contents' => "$contact_Jid@s.whatsapp.net"],
                    ['name' => "Contact", 'contents' => $Contact],
                    ['name' => "Message", 'contents' => $message],
                ],
            ]);

            return $response;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
