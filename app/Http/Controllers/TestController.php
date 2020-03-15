<?php

namespace App\Http\Controllers;

use App\Business\SalesBusiness;
use App\Http\Controllers\AppBaseController;
use App\Models\Contact;
use App\Models\Company;
use App\Models\ExtendedChat;
use App\Models\Sales;
// use App\Repositories\ExtendedUsersSellerRepository;
// use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use App\Repositories\ExtendedContactRepository;
use App\Repositories\ExtendedUsersAttendantRepository;
use App\Repositories\ExtendedUserRepository;
use App\User;
use Illuminate\Http\Request;
use PhpSigep\Model\AccessData;

class TestController extends AppBaseController
{
    private $repository;

    private $config;

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

    public function testJR(){        
        $extendedUserRepository = new ExtendedUserRepository(app());
        $ExtendedUsersAttendantRepository = new ExtendedUsersAttendantRepository(app());
        $attendantsUser = $ExtendedUsersAttendantRepository->Attendants_User_By_Attendant(1,4);
        
        $attendants = array();
        foreach ($attendantsUser as $key => $attendant) {
            $user = $extendedUserRepository->findWithoutFail($attendant->user_id);
            $attendants[$user->email] = $attendant->user_id;
        }

        dd($attendants);
    }

    public function index(Request $request)
    {
        $last_contact_id = 16;
        $company_id = 1;
        $lastContact = Contact::find($last_contact_id);

        $ExtendedChat = new ExtendedChat();
        $ExtendedChat->table = '4';
        $ExtendedChat = $ExtendedChat->find(1);

        $ExtendedChat->Contact = $lastContact;
        dd($ExtendedChat->toJson());
        $Contacts = $this->repository
            ->with(['Status', 'latestAttendantContact', 'latestAttendant'])
            ->orderBy('updated_at', 'asc')
            ->findWhere([
                'company_id' => $company_id,
                ['updated_at', '>', $lastContact->updated_at]
        ])->take(env('APP_CONTACTS_PAGE_LENGTH', 30));        


        // $Contacts->orderBy('updated_at', 'asc');

        dd($Contacts);

        // Build Bling message by Sales object
        // $Company = Company::with('rpi')->find(1);
        // $SaleModel = new Sales;
        // $SaleModel->table = "$Company->id";
        // $firstSale = $SaleModel->first();
        // $SalesBussines = new SalesBusiness;

        // $message = $SalesBussines->builSaleMessage(json_decode($firstSale->json_data), $Company);

        // dd($message);

        // dd($message);

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
        // $result = $User->notify(new NewContactMessage($data));
        // var_dump($result);
        // die;
        // $UsersAttendant = User::find(4);
        // Notification::send($User, new NewContactMessage("Test New Contact Message"));

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
        // $pendingBC = broadcast(new MessageToAttendant($Chat));
        // dd($pendingBC);
        // var_dump($pendingBC);

        // broadcast(new NewContactMessage(1));
        // broadcast(new NewContactMessage($User->company_id));
        // Bugsnag::notifyException(new RuntimeException("Test error"));

        // $Contact = Contact::find($request->contact_id);
        // $Contact->updated_at = time();
        // $Contact->save();
        // broadcast(new NewTransferredContact((int) $User->id, $Contact));

        // TEST CONTROLLERS
        // $Controller = new ExtendedUsersSellerController($this->repository);
        // dd($Controller->index($request));
        // dd($this->repository->Sellers_User());
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
                    'ttl' => 20,// "time to live" de 10 segundos
                    'cacheDir' => sys_get_temp_dir(), // Opcional. Quando não inforado é usado o valor retornado de "sys_get_temp_dir()"
                ),
            )
        );
        
        \PhpSigep\Bootstrap::start($this->config);
    }

    public function testCorreios(Request $request)
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

    public function testsalesbling(Request $request)
    {
        // Log::debug('\n\rBling Test Sales: ', [$request->all()]);

        // var_dump($p1);
        // var_dump($request->p1);
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
        $request = $client->post($url, [
            'multipart' => [
                [
                    'name' => 'file_name',
                    'contents' => fopen('/path/to/file', 'r'),
                ],
                [
                    'name' => 'csv_header',
                    'contents' => 'First Name, Last Name, Username',
                    'filename' => 'csv_header.csv',
                ],
            ]]);
        $response = $request->send();

        dd($response);
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
 */