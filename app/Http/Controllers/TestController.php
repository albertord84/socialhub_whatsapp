<?php

namespace App\Http\Controllers;


use App\Http\Controllers\AppBaseController;
use App\Models\ExtendedChat;
use App\Repositories\ExtendedChatRepository;
use App\Repositories\ExtendedContactRepository;
// use App\Repositories\ExtendedUsersSellerRepository;
// use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use RuntimeException;

use App\Events\newMessage;
use App\Models\UsersAttendant;
use App\Notifications\NewContactMessage;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schema;

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
        $User = Auth::user();
        if (!$User) {
            $User = User::find(4);
            Auth::login($User, true);
        }
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
        broadcast(new newMessage("{'message':'test 77'}"));

        // $Collection = $this->repository->fullContacts(1, 4);

        // dd($Collection[0]['count_unread_messagess']);

        // Bugsnag::notifyException(new RuntimeException("Test error"));

        // $Controller = new ExtendedUsersSellerController($this->repository);

        // dd($Controller->index($request));
        // dd($this->repository->Sellers_User());
    }

}
