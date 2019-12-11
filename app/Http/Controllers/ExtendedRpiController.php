<?php

namespace App\Http\Controllers;

use App\Repositories\ExtendedRpiRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $rpis = $this->rpiRepository->rpiOfCompany((int) $User->company_id); 
        if ($rpis) {
            if ($User->role_id == ExtendedContactsStatusController::MANAGER) {
                $QRCode = ExternalRPIController::getQRCode($rpis);

                $rpis->QRCode = $QRCode;
            }

            return $rpis->toJson();
        } 

        return null;
    }
    
}
