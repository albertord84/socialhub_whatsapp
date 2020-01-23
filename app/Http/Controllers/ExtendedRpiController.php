<?php

namespace App\Http\Controllers;

use App\Exceptions\MyHandler;
use App\Http\Requests\UpdateRpiRequest;
use App\Models\Company;
use App\Models\Rpi;
use App\Repositories\ExtendedRpiRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\ErrorHandler\ThrowableUtils;
use Throwable;

class ExtendedRpiController extends RpiController
{

    public function __construct(ExtendedRpiRepository $rpiRepo)
    {
        parent::__construct($rpiRepo);

        $this->rpiRepository = $rpiRepo;
    }

    public function index(Request $request)
    {
        try {
            // code...
            $User = Auth::check() ? Auth::user() : session('logged_user');
            if (!$User || $User->role_id > 3) {
                throw new Exception("Method not allowed to user", 1);
            }

            $rpis = $this->rpiRepository->rpiOfCompany((int) $User->company_id);
            if ($rpis) {
                if ($User->role_id == ExtendedContactsStatusController::MANAGER) {
                    $QRCode = ExternalRPIController::getQRCode($rpis);
                    if (!$QRCode) {
                        // throw new Exception('Empty QRCode from whatsapp', 1);
                    }

                    $rpis->QRCode = $QRCode;
                }

                return $rpis->toJson();
            }
        } catch (\Throwable $e) {
            return MyHandler::toJson($e);
        }
        return null;
    }

    /**
     * Update the specified Rpi in storage.
     *
     * @param  int              $id
     * @param UpdateRpiRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRpiRequest $request)
    {
        $input = $request->all();
        $mac = $request->mac;
        $company_id = $request->company_id;
        
        $rpi = null;
        
        if ($mac) {
            $rpi = $this->rpiRepository->model()::where(['mac' => $mac])->first();
            
            if (!$rpi) {
                throw new Exception("Esta MAC (Id do dispositivo) no consta no nosso sistema! Por favor contate supporte!", 1);
            }
            
            if ($rpi->id != $id) { // Tentando atuaizar uma MAC que ja existe
                $id = $rpi->id;
            }
            
        }

        if (!empty($rpi)) {
            $companyMAC = Company::with('rpi')->whereHas('rpi', function ($query) use ($mac) {
                $query->where(['mac' => $mac]);
            })->first();

            if ($companyMAC && $companyMAC->id != $company_id) { // Whether it RPi is assigned to  another comapany
                throw new Exception("Esta MAC (Id do dispositivo) ja esta assinado a outra empressa! Por favor contate supporte!", 2);
            } else {
                // Update RPi data by id
                $input['id'] = $rpi->id;
                $rpi = $this->rpiRepository->update($input, $rpi->id);

                // Update Company RPi id
                $Company = Company::find($company_id);
                if ($Company) {
                    $Company->rpi_id = $id;
                    $Company->save();
                }
            }
        }

        return $rpi ? $rpi->toJson() : null;
    }
}
