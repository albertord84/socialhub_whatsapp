<?php

namespace App\Http\Controllers;

use App\Repositories\ExtendedRpiRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Criteria\RequestCriteria;

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
            
            $QRCode = ExternalRPIController::getQRCode($rpis);

            $rpis->QRCode = $QRCode;
        }else{            
            // $this->rpiRepository->pushCriteria(new RequestCriteria($request));
            // $rpis = $this->rpiRepository->all();
            $rpis = null;
        }
        return $rpis->toJson();
    }
    
}
