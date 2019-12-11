<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Repositories\ExtendedCompanyRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use stdClass;

class ExtendedCompanyController extends CompanyController
{
    
    public function __construct(ExtendedCompanyRepository $companyRepo)
    {
        parent::__construct($companyRepo);

        $this->companyRepository = $companyRepo;
    }

    /**
     * Display a listing of the Company.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->companyRepository->pushCriteria(new RequestCriteria($request));
        $companies = new stdClass();
        $User = Auth::check()? Auth::user():session('logged_user');
        if($User->role_id==ExtendedContactsStatusController::SELLER){
            $companies = $this->companyRepository->allBySeller($User->id);
        }
        else if ($User->role_id==ExtendedContactsStatusController::ADMIN) {
            $companies = $this->companyRepository->all();
        }

        return $companies->toJson();
        
        // return view('companies.index')
        //     ->with('companies', $companies);
    }

    public function store(CreateCompanyRequest $request)
    {
        $input = $request->all();

        // dd($request);

        $company = $this->companyRepository->create($input);

        Flash::success('Company saved successfully.');

        return $company->toJson();
        // return redirect(route('companies.index'));
    }

    public function update($id, UpdateCompanyRequest $request)
    {
        $company = $this->companyRepository->findWithoutFail($id);

        if (empty($company)) {
            // Flash::error('Company not found');

            return redirect(route('companies.index'));
        }

        $company = $this->companyRepository->update($request->all(), $id);

        // Flash::success('Company updated successfully.');

        // return redirect(route('companies.index'));
    }


    public function destroy($id)
    {
        $company = $this->companyRepository->findWithoutFail($id);

        if (empty($company)) {
            Flash::error('Company not found');

            // return redirect(route('companies.index'));
        }

        $this->companyRepository->delete($id);

        Flash::success('Company deleted successfully.');

        // return redirect(route('companies.index'));
    }


}
