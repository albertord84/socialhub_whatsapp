<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUsersManagerRequest;
use App\Http\Requests\UpdateUsersManagerRequest;
use App\Mail\EmailSigninCompany;
use App\Models\Company;
use App\User;
use App\Repositories\ExtendedUsersManagerRepository;
use Illuminate\Http\Request;
use Auth;
use Prettus\Repository\Criteria\RequestCriteria;
use Laracasts\Flash\Flash;
use Exception;

use Illuminate\Support\Facades\Mail;

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

    public function store(CreateUsersManagerRequest $request)
    {
        $input = $request->all();

        $usersManager = $this->usersManagerRepository->create($input);

        Flash::success('Users Manager saved successfully.');
        
        //enviar email de cadastro de companhia e manager para o manager e o seller que está fazendo a venda
        $Seller = Auth::check()? Auth::user():session('logged_user');
        $User = User::find($input['user_id']);
        $User->password = rand(100000,999999);
        
        $Company = Company::find($User->company_id);
        Mail::to($User->email)
        ->bcc($Seller->email)
        ->send(new EmailSigninCompany($Seller, $User, $Company));
        $User->password = bcrypt($User->password);
        $User->save();

        return ($User)? $User->toJson() : null;

    }

    public function update($id, UpdateUsersManagerRequest $request)
    {
                
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

    public function destroy($id)
    {
        $usersManager = $this->usersManagerRepository->findWithoutFail($id);
        // dd($usersManager);
    
        if (empty($usersManager)) {
            Flash::error('Users Manager not found');

            // return redirect(route('usersManagers.index'));
        }

        $this->usersManagerRepository->delete($id);

        Flash::success('Users Manager deleted successfully.');

        // return redirect(route('usersManagers.index'));
    }
    
}
