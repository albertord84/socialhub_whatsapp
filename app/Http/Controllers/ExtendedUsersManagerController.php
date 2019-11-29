<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUsersManagerRequest;
use App\Http\Requests\UpdateUsersManagerRequest;
use App\Repositories\ExtendedUsersManagerRepository;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Auth;

class ExtendedUsersManagerController extends UsersManagerController
{
    /** @var  UsersManagerRepository */
    private $usersManagerRepository;

    public function __construct(ExtendedUsersManagerRepository $usersManagerRepo)
    {
        parent::__construct($usersManagerRepo);

        $this->usersManagerRepository = $usersManagerRepo;
    }



    public function index(Request $request)
    {
        $this->usersManagerRepository->pushCriteria(new RequestCriteria($request));
        $usersManagers = $this->usersManagerRepository->all();
        return $usersManagers->toJson();
    }

    public function getManager(int $company_id, Request $request)
    {
        $this->usersManagerRepository->pushCriteria(new RequestCriteria($request));
        $usersManagers = $this->usersManagerRepository->Managers_User($company_id);
        return $usersManagers->toJson();
    }

    
}
