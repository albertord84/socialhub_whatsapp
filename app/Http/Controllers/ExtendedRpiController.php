<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateRpiRequest;
use App\Models\Company;
use App\Models\Rpi;
use App\Repositories\ExtendedRpiRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;

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

        $rpi = new stdClass();

        if ($id == 0 && $mac) {
            $rpi = $this->rpiRepository->model()::where(['mac' => $mac])->first();
            // $rpi = Rpi::where(['mac' => $mac])->first();
        }
        else if ($id > 0) {
            $rpi = $this->rpiRepository->findWithoutFail($id);
        }

        if (!empty($rpi)) {
            $input['id'] = $rpi->id;
            $rpi = $this->rpiRepository->update($input, $rpi->id);

            $Company = Company::find($company_id);
            $Company->rpi_id = $rpi->id;
            $Company->save();
        }

        return $rpi ? $rpi->toJson() : null;
    }
}
