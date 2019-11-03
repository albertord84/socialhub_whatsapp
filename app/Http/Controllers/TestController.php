<?php

namespace App\Http\Controllers;


use App\Http\Controllers\AppBaseController;
use App\Repositories\ExtendedUsersSellerRepository;
// use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use RuntimeException;

class TestController extends AppBaseController
{
    private $repository;

    /**
     * Create a new controller instance.
     *
     * @param  UserRepository  $repository
     * @return void
     */
    public function __construct(ExtendedUsersSellerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {   

        // Bugsnag::notifyException(new RuntimeException("Test error"));

        $Controller = new ExtendedUsersSellerController($this->repository);

        // dd($Controller->index());
        dd($this->repository->Sellers_User());
    }

}
