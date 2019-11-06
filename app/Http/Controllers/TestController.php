<?php

namespace App\Http\Controllers;


use App\Http\Controllers\AppBaseController;
use App\Models\ExtendedChat;
use App\Repositories\ExtendedChatRepository;
use App\Repositories\ExtendedContactRepository;
// use App\Repositories\ExtendedUsersSellerRepository;
// use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use RuntimeException;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $Collection = $this->repository->fullContacts(1, 4);

        dd($Collection[0]['count_unread_messagess']);

        // Bugsnag::notifyException(new RuntimeException("Test error"));

        // $Controller = new ExtendedUsersSellerController($this->repository);

        // dd($Controller->index($request));
        // dd($this->repository->Sellers_User());
    }

}
