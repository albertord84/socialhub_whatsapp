<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCompaniesBlingsRequest;
use App\Http\Requests\UpdateCompaniesBlingsRequest;
use App\Repositories\CompaniesBlingsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class CompaniesBlingsController extends AppBaseController
{
    /** @var  CompaniesBlingsRepository */
    private $companiesBlingsRepository;

    public function __construct(CompaniesBlingsRepository $companiesBlingsRepo)
    {
        $this->companiesBlingsRepository = $companiesBlingsRepo;
    }

    /**
     * Display a listing of the CompaniesBlings.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->companiesBlingsRepository->pushCriteria(new RequestCriteria($request));
        $companiesBlings = $this->companiesBlingsRepository->all();

        return $companiesBlings->toJson();

        // return view('companies_blings.index')
        //     ->with('companiesBlings', $companiesBlings);
    }

    /**
     * Show the form for creating a new CompaniesBlings.
     *
     * @return Response
     */
    public function create()
    {
        return view('companies_blings.create');
    }

    /**
     * Store a newly created CompaniesBlings in storage.
     *
     * @param CreateCompaniesBlingsRequest $request
     *
     * @return Response
     */
    public function store(CreateCompaniesBlingsRequest $request)
    {
        $input = $request->all();

        $companiesBlings = $this->companiesBlingsRepository->create($input);

        return $companiesBlings->toJson();

        // Flash::success('Companies Blings saved successfully.');

        // return redirect(route('companiesBlings.index'));
    }

    /**
     * Display the specified CompaniesBlings.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $companiesBlings = $this->companiesBlingsRepository->findWithoutFail($id);

        if (empty($companiesBlings)) {
            Flash::error('Companies Blings not found');

            return redirect(route('companiesBlings.index'));
        }

        return view('companies_blings.show')->with('companiesBlings', $companiesBlings);
    }

    /**
     * Show the form for editing the specified CompaniesBlings.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $companiesBlings = $this->companiesBlingsRepository->findWithoutFail($id);

        if (empty($companiesBlings)) {
            Flash::error('Companies Blings not found');

            return redirect(route('companiesBlings.index'));
        }

        return view('companies_blings.edit')->with('companiesBlings', $companiesBlings);
    }

    /**
     * Update the specified CompaniesBlings in storage.
     *
     * @param  int              $id
     * @param UpdateCompaniesBlingsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCompaniesBlingsRequest $request)
    {
        $companiesBlings = $this->companiesBlingsRepository->findWithoutFail($id);

        if (empty($companiesBlings)) {
            Flash::error('Companies Blings not found');

            return redirect(route('companiesBlings.index'));
        }

        $companiesBlings = $this->companiesBlingsRepository->update($request->all(), $id);

        return $companiesBlings->toJson();

        // Flash::success('Companies Blings updated successfully.');

        // return redirect(route('companiesBlings.index'));
    }

    /**
     * Remove the specified CompaniesBlings from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $companiesBlings = $this->companiesBlingsRepository->findWithoutFail($id);

        if (empty($companiesBlings)) {
            Flash::error('Companies Blings not found');

            return redirect(route('companiesBlings.index'));
        }

        $this->companiesBlingsRepository->delete($id);

        // Flash::success('Companies Blings deleted successfully.');

        // return redirect(route('companiesBlings.index'));
    }

    public function saveCompanyBling(Request $request)
    {
        $input = $request->all();

        $companiesBlings = $this->companiesBlingsRepository->saveCompanyBling($input);

        return $companiesBlings->toJson();
    }
}
