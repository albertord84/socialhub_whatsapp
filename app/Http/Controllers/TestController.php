<?php

namespace App\Http\Controllers;

use App\Business\BlingBusiness;
use App\Business\PostofficeBusiness;
use App\Business\SalesBusiness;
use App\Business\TrackingBusiness;
use App\Events\MessageToAttendantEvent;
use App\Events\newMessage;
use App\Http\Controllers\AppBaseController;
use App\Jobs\SendWhatsAppMsg;
use App\Models\Company;
use App\Models\Contact;
use App\Models\ExtendedChat;
use App\Models\Sales;
// use App\Repositories\ExtendedUsersSellerRepository;
// use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use App\Repositories\ExtendedContactRepository;
use App\Repositories\ExtendedChatRepository;
use App\User;
use App\Business\VindiBusiness;
use App\Events\MessageToAttendantEvent;
use App\Events\MyEvent;
use App\Events\NewContactMessageEvent;
use App\Jobs\SendWhatsAppMsgBling;
use App\Jobs\SendWhatsAppMsgTracking;
use App\Models\Chat;
use App\Models\Tracking;
use App\Models\UsersAttendant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use stdClass;

class TestController extends AppBaseController
{
    private $repository;

    /**
     * Create a new controller instance.
     *
     * @param  UserRepository  $repository
     * @return void
     */
    // public function __construct(ExtendedChatRepository $repository)
    public function __construct(ExtendedContactRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request, stdClass $Sale, Company $Company)
    {

        $attendant_id = 4;
        $ExtendedChat = new ExtendedChat();
        $ExtendedChat->table = "$attendant_id";
        $ExtendedChat = $ExtendedChat->find(1);
        // var_dump($ExtendedChat);
        // $event = event(new MyEvent($ExtendedChat->toJson()));
        $event = broadcast(new MessageToAttendantEvent($ExtendedChat));

        // $Seller = User::find(2);
        // $event = broadcast(new MyEvent($Seller->toJson()));

        

        // $company_id = '49';
        // $TrackingModel = new Tracking();
        // $TrackingModel->table = "$company_id";
        // $Tracking = $TrackingModel->find('701-0002365-2406656');
        // dd($Tracking);
        // $event = event(new MyEvent($Tracking->toJson()));


        // $event = broadcast(new MyEvent('test'));
        // $event = broadcast(new NewContactMessageEvent(1, 77));
        // $event = event(new NewContactMessageEvent(1, 7));
        // dd('ok');
        dd($event);



        // Test Correios


        // $Postoffice = new PostofficeBusiness();
        // $Postoffice->importCSV();

        // $TrackingBusiness = new TrackingBusiness();

        // $company_id = '1';
        // $company_id = '49';
        // $TrackingModel = new Tracking();
        // $TrackingModel->table = "$company_id";

        // $Tracking = $TrackingModel->find('701-0002365-2406656');

        // $Tracking = (object)$Tracking;

        // $Company = Company::with('rpi')->find($company_id);
        // $ExternalRPIController = new ExternalRPIController($Company->rpi);
        // $Contact = Contact::find($Tracking->contact_id);
        // $Contact->whatsapp_id = "5521965536174";
        // $trackingJob = new SendWhatsAppMsgTracking($ExternalRPIController, $Contact, $Tracking, 'tracking_update');
        // $trackingJob->handle();

        // $tracking_code = $Tracking->tracking_code;
        // $messageList = $Tracking->messages;
        // $Company = Company::find($company_id);

        // dd($Company);

        // $trackingList = $TrackingBusiness->processTrackingObject($Tracking, $Company);

        // dd($trackingList);
        // dd((object) $trackingList[0]->toArray());
        // dd(json_encode($trackingList));

        // Teste Vindi
        // $this->testVindi();

        // Teste API v1
        // $url = 'http://app.socialhub.local/api/v1/messages';
        // $this->postGuzzleRequest($url);

        // $last_contact_idx = $request->last_contact_idx ?? 0; //54; //101;
        // $company_id = 4;
        // $attendant_id = 30;
        // $attendant_id = 15;
        //$attendant_id = 4;



        // $Contact = Contact::with(['Status', 'latestAttendantContact'])->find(18781);
        // $Contact = Contact::with(['Status', 'latestAttendantContact', 'latestAttendant'])->find(18772);

        // dd($Contact);

        // $extContRepo = new ExtendedContactRepository(app());

        // $Contacts = $extContRepo->fullContacts(1, $attendant_id, 'alb');

        // dd($Contacts);

        // $ExtendedChat = new ExtendedChat();
        // $ExtendedChat->table = "$attendant_id";
        // $ExtendedChat = $ExtendedChat->find(1);

        // $chatRepository = new ExtendedChatRepository(app());

        // $contact_id = 18806;
        // $page = 0;
        // $searchMessageByStringInput = null;
        // $set_as_readed = false;
        // $ContactChats = $chatRepository->contactChatAllAttendants($contact_id, $page, $searchMessageByStringInput, $set_as_readed);

        // dd($ContactChats);

        // $this->contactChatAllAttendants();

        // $ExtendedChat->Contact = $lastContact;
        // dd($ExtendedChat->toJson());
        // $Contacts = $this->repository
        //     ->with(['Status', 'latestAttendantContact', 'latestAttendant'])
        //     ->whereHas('latestAttendantContact', function($query) use ($attendant_id) {
        //         $query->where('attendant_id', $attendant_id);
        //     })
        //     ->orderBy('updated_at', 'asc')
        //     ->findWhere([
        //         'company_id' => $company_id,
        //         // ['updated_at', '>', $lastContact->updated_at]
        //     ]);
        // ->take(env('APP_CONTACTS_PAGE_LENGTH', 30));

        // $Contacts->orderBy('updated_at', 'asc');
        // dd($Contacts);


        // Check contact info by company
        // $ExternalRPIController = new ExternalRPIController($Company->rpi);
        // $checkContact = $ExternalRPIController->getContactInfo("5521986615841");
        // $checkContact = $ExternalRPIController->getContactInfo("5521969791284");
        // $checkContact = $ExternalRPIController->getContactInfo("5521969791284xxx");
        // dd($checkContact);

        // dd(Storage::disk('chats_files'));
        // dd(Storage::disk('chats_files')->getDriver()->getAdapter()->getPathPrefix());

        // var_dump(env('APP_NAME'));
        // var_dump(env('APP_ENV'));

        //testing emails from laravel -Jose R
        // $Company = Company::find(1);
        // $Seller = User::find(2);
        // $UserManager = User::find(5);
        // $UserManager->password = rand(100000,999999);
        // Mail::to($UserManager->email)
        // ->bcc($Seller->email)
        // ->send(new EmailSigninCompany($Seller, $UserManager, $Company));

        // $Manager = User::find(3);
        // $User = User::find(5);
        // $User->password = rand(100000,999999);
        // Mail::to($User->email)
        //     ->send(new EmailSigninAttendant($Manager, $User));

        // TEST WITH REPOSITORY
        // $extContRepo = new ExtendedContactRepository(app());
        // $Contacts = $extContRepo->fullContacts(1, 4);
        // $Attendants = $extContRepo->getAttendants(1);
        // dd($Attendants);

        // $extRepo = new ExtendedRpiRepository(app());
        // $ContactChats = $extRepo->rpiOfCompany(3);
        // dd($ContactChats);

        // $extChatRepo = new ExtendedChatRepository(app());
        // $Contact = $extChatRepo->getBagContact(4);
        // $Count = $extChatRepo->getBagContactsCount();
        // dd($Count);
        // dd($Contact);

        // $ChatsBussines = new ChatsBusiness();
        // return $ChatsBussines->getBagContactsCount(1);

        // FIND CONTACT BY NUMBER
        // $contact_Jid = "5521965536174@s.whatsapp.net";
        // $Contacts = Contact::where(['whatsapp_id' => $contact_Jid])->first();
        // echo $Contacts->toJson();
        // dd($Contacts->toJson());

        // LOGIN TEST
        // $User = Auth::user();
        // if (!$User) {
        //     $User = User::find(4);
        //     Auth::login($User, true);
        // }
        // var_dump($User);

        // NOTIFICATIONS TEST
        // $data = (object) array(
        //     "info" => "test info"
        // );
        // $result = $User->notify(new NewContactMessageEvent($data));
        // var_dump($result);
        // die;
        // $UsersAttendant = User::find(4);
        // Notification::send($User, new NewContactMessageEvent("Test New Contact Message"));

        // BROAD CAST TESTS
        // try {
        //     //code...
        //     $pendingBC = broadcast(new newMessage("{'message':'test 77'}"));
        //     var_dump($pendingBC);
        // } catch (\Throwable $th) {
        //     var_dump($th);
        // }

        // MESSAGE TO ATTENDANT
        // $ExtendedChat = new ExtendedChat();
        // $ExtendedChat->table = '4';
        // $Chat = $ExtendedChat->find(1);
        // $pendingBC = broadcast(new MessageToAttendantEvent($Chat));
        // dd($pendingBC);
        //var_dump($pendingBC);

        // broadcast(new NewContactMessageEvent(1));
        // broadcast(new NewContactMessageEvent($User->company_id));
        // Bugsnag::notifyException(new RuntimeException("Test error"));

        // $Contact = Contact::find($request->contact_id);
        // $Contact->updated_at = time();
        // $Contact->save();
        // broadcast(new NewTransferredContactEvent((int) $User->id, $Contact));

        // TEST CONTROLLERS
        // $Controller = new ExtendedUsersSellerController($this->repository);
        // dd($Controller->index($request));
        // dd($this->repository->Sellers_User());

        // $this->testJobsQueue();
        // $this->testJobsQueue();

        // $this->testCorreiosProblems($request);
        // $this->testBlingJob($request);
    }

    function testCorreiosProblems()
    {
        $Tracking = new \App\Models\Tracking();
        $Tracking->table = "49";
        $POB = new \App\Business\PostofficeBusiness();
        $Trackings = $Tracking->get();

        $TrackingBusiness = new TrackingBusiness();

        foreach ($Trackings as $key => $item) {
            $event = $item->tracking_list ? json_decode($item->tracking_list)[0] : null;
            // var_dump($event);


            if ($event && in_array([$event->tipo, $event->status], $POB->trackingImportantEventList())) {
                var_dump($item);
            }
        };

        dd('fin');
    }

    public function testBlingJob(Request $request)
    {
        // $SalesBussines = new SalesBusiness();

        // $company_id = 20;
        $company_id = 1;
        $contact_id = 25660;
        // $contact_id = 1;
        // $attendant_id = 4;

        $Company = Company::with('rpi')->find($company_id);

        $SaleModel = new Sales();

        $SaleModel->table = "$company_id";
        $SaleModel = $SaleModel->find(2828);
        // $SaleModel = $SaleModel->find(1);

        // $SalesBussines->createSale($SaleModel, $Company);
        // dd("ok testBlingJob");

        $Contact = Contact::find($contact_id);


        $Chat = null;
        // $Chat = new ExtendedChat();        
        // $Chat->table = $attendant_id;
        // $Chat->contact_id = $Contact->id;
        // $Chat->company_id = $company_id;
        // $Chat->source = 1;
        // $Chat->type_id = MessagesTypeController::Text;
        // $Chat->status_id = MessagesStatusController::ROUTED;
        // $Chat->message = "Compra do caralho 2";
        // $Chat->attendant_id = $attendant_id;
        // $Chat->save();

        $ExternalRPIController = new ExternalRPIController($Company->rpi);

        $objSale = (object) $SaleModel->toArray();
        // dd($objSale);
        $objChat = $Chat ? (object) $Chat->toArray() : null;

        // $Contact->company_id = 30;
        SendWhatsAppMsgBling::dispatch($ExternalRPIController, $Contact, $objChat, $objSale, 'blingsales');

        // $blingJob = new SendWhatsAppMsgBling($ExternalRPIController, $Contact, $objChat, $objSale, 'blingsales');
        // dd($blingJob);
        // $blingJob->handle();
    }

    function testVindi()
    {
        $Vindi = new VindiBusiness();

        $Client = User::find(1);

        // Adicionar Cliente
        // $result = $Vindi->addClient("Alberto Test", "alberto@test.test");
        // $gateway_client_id  = $result->gateway_client_id;
        $gateway_client_id  = "13729518";
        $Client->gateway_client_id = $gateway_client_id;

        // Adicionar meio de pagamento
        $payment_data = [
            "credit_card_name"      => "Alberto Reyes Diaz",
            "credit_card_exp_month" => "08",
            "credit_card_exp_year"  => "2027",
            "credit_card_number"    => "5429740425386672",
            "credit_card_cvc"       => "293"
        ];
        $result = $Vindi->addClientPayment($Client, $payment_data);

        // Criar cobrança na hora
        // $result = $Vindi->create_payment($Client, VindiBusiness::gateway_prod_1real_id, $amount = 2);

        // Criar recorrencia
        $result = $Vindi->create_recurrency_payment($Client);


        dd($result);
    }

    function testExcel(Request $request)
    {
        $input = $request->all();
        $User = Auth::check() ? Auth::user() : session('logged_user');

        $file = file_get_contents('');
        // Storage::disk('public')->
        // if ($file = $request->file('file')) {
        // Load .xls


        // unlink($file->getRealPath());
        // }
    }

    function initCorreios(\PhpSigep\Model\AccessData $accessData)
    {
        // $accessData = new \PhpSigep\Model\AccessDataHomologacao();

        $this->config = new \PhpSigep\Config();
        $this->config->setAccessData($accessData);
        $this->config->setEnv(\PhpSigep\Config::ENV_PRODUCTION);
        // $this->config->setEnv(\PhpSigep\Config::ENV_DEVELOPMENT);
        $this->config->setCacheOptions(
            array(
                'storageOptions' => array(
                    // Qualquer valor setado neste atributo será mesclado ao atributos das classes 
                    // "\PhpSigep\Cache\Storage\Adapter\AdapterOptions" e "\PhpSigep\Cache\Storage\Adapter\FileSystemOptions".
                    // Por tanto as chaves devem ser o nome de um dos atributos dessas classes.
                    'enabled' => false,
                    'ttl' => 20, // "time to live" de 10 segundos
                    'cacheDir' => sys_get_temp_dir(), // Opcional. Quando não inforado é usado o valor retornado de "sys_get_temp_dir()"
                ),
            )
        );

        \PhpSigep\Bootstrap::start($this->config);
    }

    public function testCorreiosTrackingObject(Request $request)
    {


        $usuario = '2689761400';
        $senha = 'H1OR;3@Y@M';
        $cnpjEmpresa = '26897614000101';
        $numcontrato = '9912467470';
        $codigoadm = '19185251';
        $cartaopostagem = '0074969366';


        $accessData = new \PhpSigep\Model\AccessDataHomologacao();
        $accessData->setUsuario($usuario);
        $accessData->setSenha($senha);
        // $accessData->setCnpjEmpresa($cnpjEmpresa);
        // $accessData->setCodAdministrativo($codigoadm);
        // $accessData->setNumeroContrato($numcontrato);
        // $accessData->setCartaoPostagem($cartaopostagem);
        // $accessData->setAnoContrato(null);
        // $accessData->setDiretoria(new \PhpSigep\Model\Diretoria(\PhpSigep\Model\Diretoria::DIRETORIA_DR_SAO_PAULO));

        $this->initCorreios($accessData);

        // $accessData = new \PhpSigep\Model\AccessDataHomologacao();

        // $accessData->setUsuario($usuario);// Usuário e senha para teste passado no manual
        // $accessData->setSenha($senha);

        // Solicita as etiquetas
        // $dados_etiquetas = new \PhpSigep\Model\SolicitaEtiquetas();
        // $dados_etiquetas->setAccessData($this->config->getAccessData());
        // $dados_etiquetas->setQtdEtiquetas(1);

        // $dados_etiqueta->setServicoDePostagem(\PhpSigep\Model\ServicoDePostagem::SERVICE_PAC_41068);
        $etiqueta = new \PhpSigep\Model\Etiqueta();
        // $etiqueta->setEtiquetaSemDv('PM499951504BR');
        $etiqueta->setEtiquetaComDv('SI192420171BR');
        // $etiqueta->setEtiquetaComDv('PM499951504BR');

        $params = new \PhpSigep\Model\RastrearObjeto();
        $params->setAccessData($this->config->getAccessData());
        $params->setEtiquetas([$etiqueta]);

        $phpSigep = new \PhpSigep\Services\SoapClient\Real();
        $result = $phpSigep->rastrearObjeto($params);

        dd($result);
        // var_dump((array)$result);
    }

    public function testCorreiosTrackingObjectList(Request $request)
    {
        $usuario = '2689761400';
        $senha = 'H1OR;3@Y@M';
        $cnpjEmpresa = '26897614000101';
        $numcontrato = '9912467470';
        $codigoadm = '19185251';
        $cartaopostagem = '0074969366';

        $accessData = new \PhpSigep\Model\AccessDataHomologacao();
        $accessData->setUsuario($usuario);
        $accessData->setSenha($senha);
        // $accessData->setCnpjEmpresa($cnpjEmpresa);
        // $accessData->setCodAdministrativo($codigoadm);
        // $accessData->setNumeroContrato($numcontrato);
        // $accessData->setCartaoPostagem($cartaopostagem);
        // $accessData->setAnoContrato(null);
        // $accessData->setDiretoria(new \PhpSigep\Model\Diretoria(\PhpSigep\Model\Diretoria::DIRETORIA_DR_SAO_PAULO));

        $this->initCorreios($accessData);

        $plp  = new \PhpSigep\Model\SolicitaXmlPlpResult();
        // $_file_plp = 'plp.pdf';
        // $pdf->render('F', $_file_plp);

        dd($plp);
        // var_dump((array)$result);
    }

    function contactChatAllAttendants()
    {
        $contact_id = 18806;
        $page = 0;
        $searchMessageByStringInput = null;
        $set_as_readed = false;

        $chatRepository = new ExtendedChatRepository(app());

        $ContactChats = new Collection();
        try {
            $extAttContRepo = new ExtendedContactRepository(app());

            $Attendants = $extAttContRepo->getAttendants($contact_id);

            foreach ($Attendants as $key => $Attendant) {
                $contactAttChats = $chatRepository->contactChat($Attendant->attendant_id, $contact_id, $page, $searchMessageByStringInput, $set_as_readed);

                $ContactChats = $ContactChats->concat($contactAttChats);
            }

            dd($ContactChats->unique('id')->sortBy('created_at'));

            // $ContactChats

            $Collection = new Collection();
        } catch (\Throwable $th) {
            throw $th;
        }

        // return $ContactChats;
        // return $Collection;
    }

    public function testJobsQueue()
    {
        $company_id = 35;
        $Company = Company::with('rpi')->find($company_id);
        $ExternalRPIController = new ExternalRPIController($Company->rpi);

        $contact_id = 1;
        $Contact = Contact::find($contact_id);

        $message = ['Teste queue job message 1'];

        $sendWAMsg = new SendWhatsAppMsg($ExternalRPIController, $Contact, $message, null);

        // dd($sendWAMsg);

        // $sendWAMsg->connection = 'database';

        // $pending =  SendWhatsAppMsg::withChain([$sendWAMsg])->dispatch();
        // $pending =  $sendWAMsg->dispatch();

        $pending = SendWhatsAppMsg::dispatch($ExternalRPIController, $Contact, $message);

        dd($pending);

        // $BlingController->

        // $SaleModel = new Sales();
        // $SaleModel->table = "$Company->id";
        // $firstSale = $SaleModel->first();
        // $SalesBussines = new SalesBusiness;
        // $message = $SalesBussines->builSaleMessage(json_decode($firstSale->json_data), $Company);

        // dd($message);
    }

    public function getGuzzleRequest()
    {
        $client = new \GuzzleHttp\Client();
        $request = $client->get('http://myexample.com');
        $response = $request->getBody();

        dd($response);
    }

    public function postGuzzleRequest(string $url)
    {
        $client = new \GuzzleHttp\Client();
        $url = $url ?? "http://myexample.com/api/posts";

        // $myBody['name'] = "Demo";
        // $request = $client->post($url, [
        //     'multipart' => [
        //         [
        //             'name' => 'file_name',
        //             'contents' => fopen('/path/to/file', 'r'),
        //         ],
        //         [
        //             'name' => 'csv_header',
        //             'contents' => 'First Name, Last Name, Username',
        //             'filename' => 'csv_header.csv',
        //         ],
        //     ]]);
        // $response = $request->send();

        $file_name = 'robots.txt';
        $FileName = 'Document';
        $File = Storage::disk('chats_files_1')->get($file_name); // Retrive file like file_get_content(...)
        $phone = '5521965536174';
        $message = 'Test API';
        $api_token = 'Rc5MP7yhENpjzk8jhW3L25YYX5Wj9sHQ1ibd8nFoa8u1QIkSQlI3f24ldVnm';

        // $Controller = App::make('App\Http\Controllers\ApiController');
        // $Request = new Request();
        // $Request->phone = $phone;
        // $Request->message = $message;
        // $Request->api_token = $api_token;
        // $Controller->store($Request);
        // $Controller = new ApiController($this->repository);

        $response = $client->request('POST', $url, [
            'multipart' => [
                // [
                //     'name' => "$FileName",
                //     'contents' => $File,
                //     'filename' => "$file_name",
                // ],
                ['name' => "phone", 'contents' => $phone],
                ['name' => "message", 'contents' => $message],
                ['name' => "api_token", 'contents' => $api_token],
            ],
        ]);

        dd($response->getBody()->getContents());
        // dd(json_decode($response->getBody()->getContents()));
    }

    public function putGuzzleRequest()
    {
        $client = new \GuzzleHttp\Client();
        // PUT
        $client->put('http://www.example.com/user/4', [
            'body' => [
                'email' => 'test@gmail.com',
                'name' => 'Test user',
                'password' => 'testpassword',
            ],
            'timeout' => 5,
        ]);

        // DELETE
        $client->delete('http://www.example.com/user');

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
}

/**
 * 
 * 
CNPJ : 26.897.614/0001-01
AN8 (ERP) : 43963279
Razão Social : COMERCIAL HORUS EIRELI

        $cnpjEmpresa = '26897614000101';
        $numcontrato = '9912467470';
        $codigoadm = '19185251';
        $cartaopostagem = '0074969366';
        
Omologation:
    User: 2689761400
    Root: H1OR;3@Y@M


https://apps.correios.com.br/cas/login
Usuario: horusgi18
senha: manu1202


Contrato Comercial Loja Horus:

Contrato: 9912467470

Cartão de postagem: 0074969366

Acesso sigep web: Usuario: 26897614

Senha: 46zili

 

Contrato Megaju Comercio de eletronicos

 

Contrato: 9912475537

Cartão de postagem: 0075186390

Acesso sigep web: Usuario: 34900061000127

senha: 1w5r38



Sigep:

acesso - 19185251

senha: k0L82


Sigep Master


 */
