<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRpiRequest;
use App\Http\Requests\UpdateRpiRequest;
use App\Repositories\ExtendedRpiRepository;
use Illuminate\Http\Request;
use Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ExtendedRpiController extends RpiController
{

    public function __construct(ExtendedRpiRepository $rpiRepo)
    {
        parent::__construct($rpiRepo);

        $this->rpiRepository = $rpiRepo;
    }
    
    
    public function index(Request $request)
    {
        $User = Auth::check() ? Auth::user() : session('logged_user');
        if ($User->role_id == ExtendedContactsStatusController::MANAGER) {
            $rpis = $this->rpiRepository->rpiOfCompany((int) $User->company_id);            
        }else{            
            // $this->rpiRepository->pushCriteria(new RequestCriteria($request));
            // $rpis = $this->rpiRepository->all();
            $rpis = null;
        }
        return $rpis->toJson();
    }

    

    
}
