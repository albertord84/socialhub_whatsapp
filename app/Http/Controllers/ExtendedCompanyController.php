<?php

namespace App\Http\Controllers;

use App\Repositories\ExtendedCompanyRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
        else if ($User->role_id==ExtendedContactsStatusController::ADMIN){
            $companies = $this->companyRepository->all();
        }
        else if($User->role_id==ExtendedContactsStatusController::MANAGER){
            $companies = $this->companyRepository->getCompany($User->company_id);
        }
        // return $companies->toJson();

        return ($companies instanceof Collection) ? $companies->toJson() : null;
        
        // return view('companies.index')
        //     ->with('companies', $companies);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        
        $company = $this->companyRepository->create($input);
        
        Flash::success('Company saved successfully.');

        //JR: creating Queue table
        $this->companyRepository->createCompanyQueueTable($company->id);

        return $company->toJson();
        // return redirect(route('companies.index'));
    }

    public function update($id, Request $request)
    {
        $company = $this->companyRepository->findWithoutFail($id);
        

        if (empty($company)) {
            // Flash::error('Company not found');

            return redirect(route('companies.index'));
        }

        $company = $this->companyRepository->update($request->all(), $id);

        // Flash::success('Company updated successfully.');

        return $company->toJson();
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
