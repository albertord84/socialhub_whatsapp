<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStatusRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Repositories\StatusRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class StatusController extends AppBaseController
{

    public $STATUS_TRACKING_CORREIOS = array([
        "BDE" => "Baixa de distribuição externa",
        "BDI" => "Baixa de distribuição interna",
        "BDR" => "Baixa de distribuição retroativa",
        "BLQ" => "Bloqueio de objetos",
        "CO"  => "Objeto coletado",
        "DO"  => "Objeto encaminhado",
        // "EST" => "Estorno",
        "EST" => "Favor desconsiderar a informação anterior",
        "FC"  => "Função complementar",
        "LDI" => "Lista de distribuição interna",
        "LDE" => "Lista de distribuição externa",
        "OEC" => "Lista de Objetos Entregues ao Carteiro",
        "PAR" => "Conferência Unidade Internacional",
        "RO"  => "Expedição de Lista de Registro",
        "PO " => "Postagem",
    ]);

    /** @var  StatusRepository */
    private $statusRepository;

    public function __construct(StatusRepository $statusRepo)
    {
        $this->statusRepository = $statusRepo;
    }

    /**
     * Display a listing of the Status.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->statusRepository->pushCriteria(new RequestCriteria($request));
        $statuses = $this->statusRepository->all();

        return view('statuses.index')
            ->with('statuses', $statuses);
    }

    /**
     * Show the form for creating a new Status.
     *
     * @return Response
     */
    public function create()
    {
        return view('statuses.create');
    }

    /**
     * Store a newly created Status in storage.
     *
     * @param CreateStatusRequest $request
     *
     * @return Response
     */
    public function store(CreateStatusRequest $request)
    {
        $input = $request->all();

        $status = $this->statusRepository->create($input);

        Flash::success('Status saved successfully.');

        return redirect(route('statuses.index'));
    }

    /**
     * Display the specified Status.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $status = $this->statusRepository->findWithoutFail($id);

        if (empty($status)) {
            Flash::error('Status not found');

            return redirect(route('statuses.index'));
        }

        return view('statuses.show')->with('status', $status);
    }

    /**
     * Show the form for editing the specified Status.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $status = $this->statusRepository->findWithoutFail($id);

        if (empty($status)) {
            Flash::error('Status not found');

            return redirect(route('statuses.index'));
        }

        return view('statuses.edit')->with('status', $status);
    }

    /**
     * Update the specified Status in storage.
     *
     * @param  int              $id
     * @param UpdateStatusRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateStatusRequest $request)
    {
        $status = $this->statusRepository->findWithoutFail($id);

        if (empty($status)) {
            Flash::error('Status not found');

            return redirect(route('statuses.index'));
        }

        $status = $this->statusRepository->update($request->all(), $id);

        Flash::success('Status updated successfully.');

        return redirect(route('statuses.index'));
    }

    /**
     * Remove the specified Status from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $status = $this->statusRepository->findWithoutFail($id);

        if (empty($status)) {
            Flash::error('Status not found');

            return redirect(route('statuses.index'));
        }

        $this->statusRepository->delete($id);

        Flash::success('Status deleted successfully.');

        return redirect(route('statuses.index'));
    }
}
