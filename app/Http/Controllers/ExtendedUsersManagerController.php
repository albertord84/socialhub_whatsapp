<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUsersManagerRequest;
use App\Http\Requests\UpdateUsersManagerRequest;
use App\Repositories\ExtendedUsersManagerRepository;
use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;

class ExtendedUsersManagerController extends UsersManagerController
{
    
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

    public function update($id, UpdateUsersManagerRequest $request)
    {
        dd($id);
        
        $usersManager = $this->usersManagerRepository->findWithoutFail($id);

        if (empty($usersManager)) {
            // Flash::error('Users Manager not found');

            // return redirect(route('usersManagers.index'));
        }

        $usersManager = $this->usersManagerRepository->update($request->all(), $id);

        // Flash::success('Users Manager updated successfully.');

        return $usersManager->toJson();

        // return redirect(route('usersManagers.index'));
    }

    
}
