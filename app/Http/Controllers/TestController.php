<?php

namespace App\Http\Controllers;


use App\Http\Controllers\AppBaseController;
use App\Repositories\ExtendedChatRepository;
// use App\Repositories\ExtendedUsersSellerRepository;
// use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use RuntimeException;

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
    public function __construct(ExtendedChatRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {

        // Bugsnag::notifyException(new RuntimeException("Test error"));

        // $Controller = new ExtendedUsersSellerController($this->repository);
        $Controller = new ExtendedChatController($this->repository);

        dd($Controller->index($request));
        // dd($this->repository->Sellers_User());
    }

}
