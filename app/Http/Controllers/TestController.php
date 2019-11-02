<?php

namespace App\Http\Controllers;


use App\Http\Controllers\AppBaseController;
use App\Repositories\ExtendedUsersSellerRepository;
use Illuminate\Http\Request;
use Response;

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

        $Controller = new ExtendedUsersSellerController($this->repository);

        // dd($Controller->index());
        dd($this->repository->Sellers_User());
    }

}
