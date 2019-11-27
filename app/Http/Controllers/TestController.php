<?php

namespace App\Http\Controllers;

use App\Events\MessageToAttendant;
use App\Http\Controllers\AppBaseController;
use App\Models\Contact;
use App\Models\ExtendedChat;
// use App\Repositories\ExtendedUsersSellerRepository;
// use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use App\Repositories\ExtendedContactRepository;
use App\User;
use Illuminate\Http\Request;

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

        // $extContRepo = new ExtendedContactRepository(app());

        // $Contacts = $extContRepo->fullContacts(1, 4);

        $contact_Jid = "5521965536174@s.whatsapp.net";
        $Contacts = Contact::where(['whatsapp_id' => $contact_Jid])->first();
        echo $Contacts->toJson();
        // dd($Contacts->toJson());

        // $User = Auth::user();
        // if (!$User) {
        //     $User = User::find(4);
        //     Auth::login($User, true);
        // }
        // var_dump($User);

        // $data = (object) array(
        //     "info" => "test info"
        // );
        // $result = $User->notify(new NewContactMessage($data));
        // var_dump($result);
        // die;
        // $UsersAttendant = User::find(4);
        // Notification::send($User, new NewContactMessage("Test New Contact Message"));

        // broadcast(new newMessage("{'message':'test 77'}"));

        // $ExtendedChat = new ExtendedChat();
        // $ExtendedChat->table = '4';
        // $Chat = $ExtendedChat->find(1);
        // broadcast(new MessageToAttendant($Chat));

        // broadcast(new NewContactMessage(1));
        // broadcast(new NewContactMessage($User->company_id));

        // $Collection = $this->repository->fullContacts(1, 4);

        // dd($Collection[0]['count_unread_messagess']);

        // Bugsnag::notifyException(new RuntimeException("Test error"));

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
