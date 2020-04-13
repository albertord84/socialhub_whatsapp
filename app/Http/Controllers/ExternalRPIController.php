<?php

namespace App\Http\Controllers;

use App\Business\ChatsBusiness;
use App\Business\FileUtils;
use App\Business\MyException;
use App\Business\MyResponse;
use App\Business\Response;
use App\Events\MessageToAttendant;
use App\Events\NewContactMessage;
use App\Events\WhatsappLoggedIn;
use App\Models\Company;
use App\Models\Contact;
use App\Models\ExtendedChat;
use App\Models\Rpi;
use App\Models\UsersAttendant;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use stdClass;

class ExternalRPIController extends Controller
{
    private $Rpi = null;

    public function __construct(?Rpi $Rpi = null)
    {
        parent::__construct();

        $this->Rpi = (!$Rpi || $Rpi->id == 0) ? $this->getRPI() : $Rpi;
    }

    public function index(Request $request)
    {

    }

    /**
     * Display a listing of the Chat.
     * @param Request $request
     * @return Response
     */
    public function test(Request $request)
    {
        return response()->json([
            'status' => true,
        ]);
    }

    /**
     * Update or Register RPi.
     *
     * @tested
     * @param Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $rpiMAC = $request->MAC;
        $apiUser = $request->user;
        $apiPass = $request->password;

        $Company = Company::with('rpi')->whereHas('rpi', function ($query) use ($rpiMAC) {
            $query->where(['mac' => $rpiMAC]);
        })->first();

        if (!$Company) { // Whether not found RPI associated to a company
            $RPI = Rpi::where(['mac' => $rpiMAC])->first();
            if (!$RPI) { // Whether not found RPI
                $RPI = $this->registerNewRPI($rpiMAC, $apiUser, $apiPass);
            }
        } else {
            $Company->rpi->mac = $rpiMAC;
            $Company->rpi->api_user = $apiUser;
            $Company->rpi->api_password = $apiPass;
            $Company->rpi->save();
        }

        return json_encode($Company);
    }

    /**
     * Register New RPI function
     *
     * @tested
     * @param string $MAC
     * @param string $apiUser
     * @param string $apiPass
     * @return void
     */
    public function registerNewRPI(string $MAC = null, string $apiUser = null, string $apiPass = null)
    {
        $RPI = new Rpi();
        try {
            $RPI->mac = $MAC;
            $RPI->api_user = $apiUser;
            $RPI->api_password = $apiPass;
            return $RPI->save();
        } catch (\Throwable $th) {
            MyResponse::makeExceptionJson($th);
        }
    }

    /**
     * Force RPi Update
     *
     * @tested
     * @param Rpi|null $Rpi
     * @return Json {"message": "Atualizado"}
     */
    public static function sai_rpi_to_update(?Rpi $Rpi = null): stdClass
    {
        $response = new stdClass();
        try {
            $client = new \GuzzleHttp\Client();
            $Rpi = $Rpi ?? self::getRPI();
            $url = $Rpi->api_tunnel . '/update';

            $response = $client->request('POST', $url);
            $response = $response->getBody()->getContents();
            $response = json_decode($response);
        } catch (\Throwable $th) {
            MyResponse::makeExceptionJson($th);
        }
        return $response;
    }

    /**
     * Logged in from GoMain whatsapp handler
     *
     * @tested
     * @param Request $request
     * @return void
     */
    public function loggedin(Request $request)
    {
        $response = new stdClass();
        try {
            $input = $request->all();
            $request->CompanyPhone = str_replace("@c.us", "", $request->CompanyPhone);
            $Company = Company::where('whatsapp', $request->CompanyPhone)->first();
            $User = $Company->manager()->manager;
            if ($User) {
                $response->LoggedUser = $User;
                if (!isset($input['Testing'])) {
                    broadcast(new WhatsappLoggedIn($User->id));
                }
                // Log::debug('\n\rWhatsappLoggedIn Event to: ', [$User]);
            }

        } catch (\Throwable $th) {
            MyResponse::makeExceptionJson($th);
        }

        return $response;
    }

    /**
     * Log Out from whatsapp
     *
     * @tested
     * @param Rpi|null $Rpi
     * @return Json {"message": "Logout feito"}
     */
    public static function logout(?Rpi $Rpi = null) // : stdClass

    {
        $response = new stdClass();
        try {
            $client = new \GuzzleHttp\Client();
            $Rpi = $Rpi ?? self::getRPI();
            $url = $Rpi->api_tunnel . '/logout';

            $response = $client->request('POST', $url);
            $response2 = $response->getBody()->getContents();
            $response2 = json_decode($response2);
        } catch (\Throwable $th) {
            MyResponse::makeExceptionJson($th);
        }

        return $response;
    }

    /**
     * Get QRCode
     *
     * @tested
     * @param Rpi|null $Rpi
     * @return stdClass
     */
    public static function getQRCode(?Rpi $Rpi = null): stdClass
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
            MyResponse::makeExceptionJson($th);
        }
        return $QRCode;
    }

    /**
     * Get Contact Info
     *
     * @tested
     * @param string $contact_id
     * @param Rpi|null $Rpi
     * @return void
     */
    public function getContactInfo(string $contact_id = '', ?Rpi $Rpi = null) //: stdClass

    {
        $contactInfo = new stdClass();
        try {
            $client = new \GuzzleHttp\Client();
            $Rpi = $Rpi ?? ($this->Rpi ?? self::getRPI());
            $url = $Rpi->api_tunnel . '/GetContact';

            $contactInfo = $client->request('GET', $url, [
                'query' => ['RemoteJid' => $contact_id],
            ]);

            $contactInfo = $contactInfo->getBody()->getContents();
            // $contactInfo = json_decode($contactInfo); // Isso viaja para VUE entao nao pode ir como objeto
            // Log::debug('\n\rgetContactInfo Response: ', [$contactInfo]);
        } catch (\Throwable $th) {
            MyResponse::makeExceptionJson($th);
        }
        return $contactInfo;
    }

    /**
     * Recive Text Message
     *
     * @tested
     * @param Request $request
     * @return Response
     */
    public function reciveTextMessage(Request $request)
    {
        try {
            $input = $request->all();
            Log::debug('\n\r\n\rreciveTextMessage: ', [$input]);

            $input['Jid'] = str_replace("@s.whatsapp.net", "", $input['Jid']);
            $input['CompanyPhone'] = str_replace("@c.us", "", $input['CompanyPhone']);

            $contact_Jid = $input['Jid'];
            $company_phone = $input['CompanyPhone'];

            $Company = Company::where(['whatsapp' => $company_phone])->first();
            if (!$Company) {
                Log::debug('\n\r rreciveTextMessage to Company (company not found): ', [$input]);
                throw new MyException("Company phone ($company_phone) not found", MyException::$COMPANY_PHONE_NOT_FOUND);
            }
            // $Company = Company::where(['whatsapp' => $company_phone])->first();

            $Contact = Contact::with(['Status', 'latestAttendantContact', 'latestAttendant'])
                ->where(['whatsapp_id' => $contact_Jid, 'company_id' => $Company->id])
                ->first();
            Log::debug('\n\rreciveTextMessage to Contact: ', [$Contact]);

            $Chat = $this->messageToChatModel($input, $Contact);
            if (!$Chat) {
                return "Error saving text message!";
            }

            $Chat->save();
            Log::debug('\n\r Contact chat2: ', [$Chat]);

            if ($Contact) {
                // Send event to attendants with new chat message
                if (!isset($input['Testing'])) {
                    $Chat->Contact = $Contact;
                    broadcast(new MessageToAttendant($Chat));
                }
            } else {
                // Send event to all attendants with new bag contact count
                $bagContactsCount = (new ChatsBusiness())->getBagContactsCount($Company->id);
                if (!isset($input['Testing'])) {
                    broadcast(new NewContactMessage($Company->id, $bagContactsCount));
                }

            }
        } catch (\Throwable $th) {
            return MyResponse::makeExceptionJson($th);
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
        try {
            $input = $request->all();
            // Log::debug('\n\rreciveFileMessage: ', [$input]);

            $input['Jid'] = str_replace("@s.whatsapp.net", "", $input['Jid']);
            $input['CompanyPhone'] = str_replace("@c.us", "", $input['CompanyPhone']);

            $contact_Jid = $input['Jid'];
            $company_phone = $input['CompanyPhone'];

            $Company = Company::where(['whatsapp' => $company_phone])->first();
            if (!$Company) {
                Log::debug('\n\r reciveFileMessage to Company (company not found): ', [$input]);
                throw new MyException("Company phone ($company_phone) not found", MyException::$COMPANY_PHONE_NOT_FOUND);
            }

            $Contact = Contact::with(['Status', 'latestAttendantContact', 'latestAttendant'])
                ->where(['whatsapp_id' => $contact_Jid, 'company_id' => $Company->id])
                ->first();

            $Chat = $this->messageToChatModel($input, $Contact);
            if (!$Chat) {
                throw new MyException("Error saving file message!", MyException::$ERROR_SAVING_FILE_MSG_FOUND);
            }

            $Chat->attendant_id = $Chat->attendant_id ? $Chat->attendant_id : "NULL";

            // $envFilePath = env('APP_FILE_PATH', 'external_files');
            // Log::debug('\n\rStorage Disk: ', [Storage::disk('chats_files')]);
            // $envFilePath = Storage::disk('chats_files')->root;

            $filePath = "companies/$Company->id/contacts/$Chat->contact_id/chat_files";
            Log::debug('\n\rreciveFileMessage File Path: ', [$filePath]);

            $file_response = FileUtils::SavePostFile($request->file('File'), $filePath, $Chat->id);
            Log::debug('\n\rreciveFileMessage File Response: ', [$file_response]);

            $Chat->data = json_encode($file_response);
            $Chat->save();

            if ($Contact) {
                // Send event to attendants with new chat message
                // Send event to attendants with new chat message
                if (!isset($input['Testing'])) {
                    broadcast(new MessageToAttendant($Chat));
                }
            } else {
                // Send event to all attendants with new contact
                $bagContactsCount = (new ChatsBusiness())->getBagContactsCount($Company->id);
                // Send event to attendants with new chat message
                if (!isset($input['Testing'])) {
                    broadcast(new NewContactMessage($Company->id, $bagContactsCount));
                }
            }
        } catch (\Throwable $th) {
            return MyResponse::makeExceptionJson($th);
        }

        $Chat->Contact = $Contact;
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
        $AttendantsContact = $Contact ? $Contact->latestAttendantContact : null;

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
            case 'video':
                $type_id = 4;
                break;
            case 'document':
                $type_id = 5;
                break;
        }

        $Chat = new ExtendedChat();

        try {

            $Chat->source = 1;
            $Chat->message = $input['Msg'];
            $Chat->type_id = $type_id;
            $Chat->status_id = MessagesStatusController::UNREADED;
            $Attendnat = isset($AttendantsContact->attendant_id) ? UsersAttendant::find($AttendantsContact->attendant_id) : null;
            //************************TODO: descomentar depois del quebragalho
            if ($Attendnat && $Contact && $Attendnat->selected_contact_id == $Contact->id) {
                $Chat->status_id = MessagesStatusController::READED;
            }
            //*********************
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
                $Company = Company::where(['whatsapp' => $company_phone])->first();

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
            Log::debug('\n\r Contact chat: ', [$Chat]);
            $Chat->save();

        } catch (\Throwable $th) {
            MyResponse::makeExceptionJson($th);
        }
        return $Chat;
    }

    /**
     * Send Text Message
     *
     * @tested
     * @param string $message
     * @param string $phone
     * @param string [$first_name]
     * @param string [$email]
     * @return void
     */
    public function sendTextMessageByNumber(string $message, string $phone, Request $request)
    {
        // Check if the Contact already exist for this company
        $User = User::where('api_token', $request->api_token)->first();

        $Contact = Contact::where([
            'company_id' => $User->company_id,
            'whatsapp_id' => $phone,
        ])->first();

        if (!$Contact) { // if not exist insert the contact
            $Contact = new Contact();
            $Contact->company_id = $User->company_id;
            $Contact->first_name = $request->first_name ?? $phone;
            $Contact->whatsapp_id = $phone;
            $Contact->email = $request->email ?? null;
            $Contact->save();
        }

        $response = $this->sendTextMessage($message, $Contact);

        return $response;
    }

    /**
     * Send Text Message
     *
     * @tested
     * @param string $message
     * @param Contact $Contact
     * @return void
     */
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
                    'Contact' => $Contact,
                ],
            ]);

            return $response->getBody()->getContents();
        } catch (\Throwable $th) {
            MyResponse::makeExceptionJson($th);
        }
    }

    // public function sendFileMessage(File $File, string $file_type, string $message, string $contact_Jid)
    // public function sendFileMessage(string $File, string $file_name, string $file_type, ?string $message, Contact $Contact)
    public function sendFileMessage(string $file_name, string $file_type, ?string $message, Contact $Contact)
    {
        try {

            $File = Storage::disk('chats_files')->get($file_name); // Retrive file like file_get_content(...)

            $client = new \GuzzleHttp\Client();
            $EndPoint = 'SendDocumentMessage';
            $FileName = 'Document';

            $Company = Company::with('rpi')->where(['id' => $Contact->company_id])->first();

            if ($Company) {
                $url = $Company->rpi->api_tunnel;
            }

            $contact_Jid = "$Contact->whatsapp_id@s.whatsapp.net";
            Log::debug('\n\rsendFileMessage to Contact contact_Jid: ', [$contact_Jid]);

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
            Log::debug('\n\rsendFileMessage to Contact RPi URL: ', [$url]);

            // $Contact = Contact::where(['whatsapp_id' => $contact_Jid])->first();
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

            Log::debug('\n\rsendFileMessage to Contact Response: ', [$response]);
            return $response->getBody()->getContents();
        } catch (\Throwable $th) {
            MyResponse::makeExceptionJson($th);
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
            MyResponse::makeExceptionJson($th);
        }

        return $RPI;
    }

    /**
     * Used for tests purpose only
     *
     * @param string $option
     * @return void
     */
    public function tests(string $option)
    {
        // Log::debug('\n\rExternalRPIController tests: ', [$option]);
        app('debugbar')->disable();
        switch ($option) {
            case 'logout':
                $response = '{"message": "Logout feito"}';
                // $response = '{"message": "Sessao deletada"}';
                break;
            case 'update':
                $response = '{"message": "Atualizado"}';
                break;
            case 'qrcode':
                $response = '{"message": "Ja logado"}';
                break;
            case 'GetContact':
                $response = '{"name": "name", "picurl": "url"}';
                break;
            case 'SendTextMessage':
                $response = '{"MsgID": "MsgID"}';
                break;
            default:
                $response = null;
                break;
        }

        return $response;
    }
}
