<?php

namespace App\Http\Controllers;

use App\Business\ChatsBusiness;
use App\Events\MessageToAttendant;
use App\Events\newMessage;
use App\Http\Controllers\AppBaseController;
use App\Mail\EmailSigninCompany;
use App\Mail\EmailSigninAttendant;
use App\Models\Company;
use App\Models\Contact;
use App\Models\ExtendedChat;
use App\Repositories\ExtendedChatRepository;
// use App\Repositories\ExtendedUsersSellerRepository;
// use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use App\Repositories\ExtendedContactRepository;
use App\Repositories\ExtendedRpiRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use Faker\Generator as Faker;

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

    public function index(Request $request)
    { 
        //testing emails from laravel -Jose R
        $Company = Company::find(1); 
        $Seller = User::find(2); 
        $UserManager = User::find(5); 
        $UserManager->password = rand(100000,999999);
        Mail::to($UserManager->email)
            // ->bcc($Seller->email)
            ->send(new EmailSigninCompany($Seller, $UserManager, $Company));
        
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
