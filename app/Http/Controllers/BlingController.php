<?php

namespace App\Http\Controllers;

use App\Business\BlingBusiness;
use App\Business\MyResponse;
use App\Http\Requests\CreateBlingRequest;
use App\Http\Requests\UpdateBlingRequest;
use App\Repositories\BlingRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash as Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class BlingController extends AppBaseController
{
    /** @var  BlingRepository */
    private $blingRepository;

    public function __construct(BlingRepository $blingRepo)
    {
        $this->blingRepository = $blingRepo;
    }

    public function get_sales_bling(Request $request)
    {
        try {
            $BlingBussines = new BlingBusiness();
            
            $Sales = $BlingBussines->getBlingSales();
            
            // Log::debug('Bling Sales', [$Sales]);


        } catch (\Throwable $tr) {
            return MyResponse::makeExceptionJson($tr);
        }

        return $Sales->toJson();
    }

    /**
     * Display a listing of the Bling.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->blingRepository->pushCriteria(new RequestCriteria($request));
        $blings = $this->blingRepository->all();

        return view('blings.index')
            ->with('blings', $blings);
    }

    /**
     * Show the form for creating a new Bling.
     *
     * @return Response
     */
    public function create()
    {
        return view('blings.create');
    }

    /**
     * Store a newly created Bling in storage.
     *
     * @param CreateBlingRequest $request
     *
     * @return Response
     */
    public function store(CreateBlingRequest $request)
    {
        $input = $request->all();
        // $bling = $this->blingRepository->create($input);

        //1. atualizar campo de companies (llamar el update de companies) e bling_contrated a 1
        $Company = $this->blingRepository->updateCompanyBlingIntegrationField($input["company_id"], $input["bling_apikey"], $input["bling_message"]);
        //2. crear tabla de sales para essa empressa
        $this->blingRepository->createCompanySalesTable($input["company_id"]);

        Flash::success('Bling integration created successfully.');

        // return redirect(route('blings.index'));
        return $Company->toJson();
    }

    /**
     * Display the specified Bling.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $bling = $this->blingRepository->findWithoutFail($id);

        if (empty($bling)) {
            Flash::error('Bling not found');

            return redirect(route('blings.index'));
        }

        return view('blings.show')->with('bling', $bling);
    }

    /**
     * Show the form for editing the specified Bling.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $bling = $this->blingRepository->findWithoutFail($id);

        if (empty($bling)) {
            Flash::error('Bling not found');

            return redirect(route('blings.index'));
        }

        return view('blings.edit')->with('bling', $bling);
    }

    /**
     * Update the specified Bling in storage.
     *
     * @param  int              $id
     * @param UpdateBlingRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBlingRequest $request)
    {
        $bling = $this->blingRepository->findWithoutFail($id);

        if (empty($bling)) {
            Flash::error('Bling not found');

            return redirect(route('blings.index'));
        }

        $bling = $this->blingRepository->update($request->all(), $id);

        Flash::success('Bling updated successfully.');

        return redirect(route('blings.index'));
    }

    /**
     * Remove the specified Bling from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $bling = $this->blingRepository->findWithoutFail($id);

        if (empty($bling)) {
            Flash::error('Bling not found');

            return redirect(route('blings.index'));
        }

        //1. desactivsa campo de contratação do bling   

        $this->blingRepository->delete($id);

        Flash::success('Bling deleted successfully.');

        return redirect(route('blings.index'));
    }

}
