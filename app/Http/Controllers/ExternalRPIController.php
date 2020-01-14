<?php

namespace App\Http\Controllers;

use App\Business\ChatsBusiness;
use App\Business\FileUtils;
use App\Events\MessageToAttendant;
use App\Events\NewContactMessage;
use App\Events\WhatsappLoggedIn;
use App\Models\AttendantsContact;
use App\Models\Company;
use App\Models\Contact;
use App\Models\ExtendedChat;
use App\Models\Rpi;
use App\Models\UsersAttendant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use stdClass;

class ExternalRPIController extends Controller
{
    private $Rpi;

    public function __construct(?Rpi $Rpi = null)
    {
        parent::__construct();

        $this->Rpi = $Rpi ?? $this->getRPI();

        // $this->APP_WP_API_URL = env('APP_WP_API_URL', 'http://shrpialberto.sa.ngrok.io.ngrok.io');
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

        $Company = Company::with('rpi')->whereHas('rpi', function ($query) use ($rpiMAC) {
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
     * Force RPi Update
     */
    public static function sai_rpi_to_update(?Rpi $Rpi = null) //: stdClass

    {
        // $Rpi = new stdClass();
        // $Rpi->tunnel = 'http://shrpialberto.sa.ngrok.io.ngrok.io';
        $response = new stdClass();
        try {
            $client = new \GuzzleHttp\Client();
            $Rpi = $Rpi ?? self::getRPI();
            $url = $Rpi->api_tunnel . '/update';

            $response = $client->request('POST', $url);
            $response = $response->getBody()->getContents();
            $response = json_decode($response);
            return $response;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Logged in from GoMain whatsapp handler
     */
    public function loggedin(Request $request = null): stdClass
    {
        Log::debug('WhatsappLoggedIn Callback Recived: ', [$request]);
        $response = new stdClass();
        try {
            if ($this->LoggedUser) {
                broadcast(new WhatsappLoggedIn($this->LoggedUser->id));
                Log::debug('WhatsappLoggedIn Event to: ', [$this->LoggedUser]);
            }

        } catch (\Throwable $th) {
            throw $th;
        }

        return $response;
    }

    /**
     * Log Out from whatsapp
     */
    public static function logout(?Rpi $Rpi = null) //: stdClass
    {
        // $Rpi = new stdClass();
        // $Rpi->tunnel = 'http://shrpialberto.sa.ngrok.io.ngrok.io';
        $response = new stdClass();
        try {
            $client = new \GuzzleHttp\Client();
            $Rpi = $Rpi ?? self::getRPI();
            $url = $Rpi->api_tunnel . '/logout';
            
            $response = $client->request('POST', $url);
            $response = $response->getBody()->getContents();
            Log::debug('RPI/Logout $response', [$response]);
            // $response = json_decode($response);
        } catch (\Throwable $th) {
            throw $th;
        }

        return $response;
    }

    /**
     * Get QRCode
     */
    public static function getQRCode(?Rpi $Rpi = null) : stdClass
    {
        // $Rpi = new stdClass();
        // $Rpi->tunnel = 'http://shrpialberto.sa.ngrok.io.ngrok.io';
        $QRCode = new stdClass();
        try {
            $client = new \GuzzleHttp\Client();
            $Rpi = $Rpi ?? self::getRPI();
            $url = $Rpi->api_tunnel . '/qrcode';

            $QRCode = $client->request('GET', $url);
            $QRCode = $QRCode->getBody()->getContents();
            $QRCode = json_decode($QRCode);
            return $QRCode;
        } catch (\Throwable $th) {
            // throw $th;
        }
        return $QRCode;
    }

    /**
     * Get Contact Info
     */
    // public function getContactInfo(string $contact_id = '551199723998')//: stdClass
    public function getContactInfo(string $contact_id = '', ?Rpi $Rpi = null) //: stdClass
    {
        $contactInfo = new stdClass();
        try {
            $client = new \GuzzleHttp\Client();
            $Rpi = $Rpi ?? self::getRPI();
            $url = $Rpi->api_tunnel . '/GetContact';

            $contactInfo = $client->request('GET', $url, [
                'query' => ['RemoteJid' => $contact_id],
            ]);

            $contactInfo = $contactInfo->getBody()->getContents();
            // $contactInfo = json_decode($contactInfo);
            Log::debug('getContactInfo Response: ', [$contactInfo]);
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
        Log::debug('reciveTextMessage: ', [$input]);

        $input['Jid'] = str_replace("@s.whatsapp.net", "", $input['Jid']);
        $input['CompanyPhone'] = str_replace("@c.us", "", $input['CompanyPhone']);

        $contact_Jid = $input['Jid'];
        $company_phone = $input['CompanyPhone'];

        $Company = Company::where(['phone' => $company_phone])->first();
        // Log::debug('reciveTextMessage to Company: ', [$Company]);

        $Contact = Contact::with(['Status', 'latestAttendantContact', 'latestAttendant'])
            ->where(['whatsapp_id' => $contact_Jid, 'company_id' => $Company->id])
            ->first();
        // Log::debug('reciveTextMessage to Contact: ', [$Contact]);

        $Chat = $this->messageToChatModel($input, $Contact, $Contact->latestAttendantContact ?? null);
        if (!$Chat) {
            return "Error saving text message!";
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
        // Log::debug('reciveFileMessage: ', [$input]);

        $input['Jid'] = str_replace("@s.whatsapp.net", "", $input['Jid']);
        $input['CompanyPhone'] = str_replace("@c.us", "", $input['CompanyPhone']);

        $contact_Jid = $input['Jid'];
        $company_phone = $input['CompanyPhone'];

        $Company = Company::where(['phone' => $company_phone])->first();
        // Log::debug('reciveFileMessage to Company: ', [$Company]);

        $Contact = Contact::with(['Status', 'latestAttendantContact', 'latestAttendant'])
            ->where(['whatsapp_id' => $contact_Jid, 'company_id' => $Company->id])
            ->first();

        $Chat = $this->messageToChatModel($input, $Contact, $Contact->latestAttendantContact);
        if (!$Chat) {
            return "Error saving file message!";
        }

        $Chat->attendant_id = $Chat->attendant_id ? $Chat->attendant_id : "NULL";

        // $envFilePath = env('APP_FILE_PATH', 'external_files');
        // Log::debug('Storage Disk: ', [Storage::disk('chats_files')]);
        // $envFilePath = Storage::disk('chats_files')->root;

        $filePath = "companies/$Company->id/contacts/$Chat->contact_id/chat_files";
        Log::debug('reciveFileMessage File Path: ', [$filePath]);

        $file_response = FileUtils::SavePostFile($request->file('File'), $filePath, $Chat->id);
        Log::debug('reciveFileMessage File Response: ', [$file_response]);

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
    public function messageToChatModel(array $input, ?Contact $Contact, ?AttendantsContact $AttendantsContact): ExtendedChat
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

        try {
            
            $Chat->source = 1;
            $Chat->message = $input['Msg'];
            $Chat->type_id = $type_id;
            $Chat->status_id = MessagesStatusController::UNREADED;
            $Attendnat = isset($AttendantsContact->attendant_id) ? UsersAttendant::find($AttendantsContact->attendant_id) : null;
            if ($Attendnat && $Contact && $Attendnat->selected_contact_id == $Contact->id) {
                $Chat->status_id = MessagesStatusController::READED;
            }
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

                $Contact = new Contact();
                if ($Company) {
                    // Create Mock Contact
                    $Contact->first_name = $contact_Jid;
                    $Contact->company_id = $Company->id;
                    $Contact->whatsapp_id = $contact_Jid;
                }
                // else throw new Exception("Error Processing Request", 1);
            }
            $Contact->updated_at = Carbon::now();
            $Contact->save();

            $Chat->contact_id = $Contact->id;
            $Chat->company_id = $Contact->company_id;
            $Chat->save();

        } catch (\Throwable $th) {
            throw $th;
        }
        return $Chat;
    }

    public function sendTextMessage(string $message, Contact $Contact)
    {
        try {
            $client = new \GuzzleHttp\Client();

            $Company = Company::with('rpi')->where(['id' => $Contact->company_id])->first();

            if ($Company) {
                $url = $Company->rpi->api_tunnel . '/SendTextMessage';
            }

            $contact_Jid = "$Contact->whatsapp_id@s.whatsapp.net";

            $response = $client->request('POST', $url, [
                'form_params' => [
                    'RemoteJid' => $contact_Jid,
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
    public function sendFileMessage(string $File, string $file_name, string $file_type, ?string $message, Contact $Contact)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $EndPoint = 'SendDocumentMessage';
            $FileName = 'Document';

            $Company = Company::with('rpi')->where(['id' => $Contact->company_id])->first();

            if ($Company) {
                $url = $Company->rpi->api_tunnel;
            }

            $contact_Jid = "$Contact->whatsapp_id@s.whatsapp.net";
            Log::debug('sendFileMessage to Contact contact_Jid: ', [$contact_Jid]);

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

            $url = $url . "/$EndPoint";
            Log::debug('sendFileMessage to Contact RPi URL: ', [$url]);

            $Contact = Contact::where(['whatsapp_id' => $contact_Jid])->first();
            $response = $client->request('POST', $url, [
                'multipart' => [
                    [
                        'name' => "$FileName",
                        'contents' => $File,
                        'filename' => "$file_name",
                    ],
                    ['name' => "RemoteJid", 'contents' => $contact_Jid],
                    ['name' => "Contact", 'contents' => $Contact],
                    ['name' => "Message", 'contents' => $message],
                ],
            ]);

            Log::debug('sendFileMessage to Contact Response: ', [$response]);
            return $response;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Get Rpi model from logged User
     *
     * @return Rpi|null
     */
    public static function getRPI(): ?Rpi
    {
        $RPI = null;
        try {
            $User = Auth::check() ? Auth::user() : session('logged_user');

            if ($User) {
                $Company = Company::with('rpi')->where(['id' => $User->company_id])->whereHas('rpi')->first();

                $RPI = $Company ? $Company->rpi : null;
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        return $RPI;
    }

    public function tests(string $option)
    {
        app('debugbar')->disable();
        switch ($option) {
            case 'logout':
                $response = '{"Message": "Logout feito"}';
                break;
            default:
                $response = null;
            break;
        }

        return $response;
    }
}
