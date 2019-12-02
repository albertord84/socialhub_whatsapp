<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRpiRequest;
use App\Http\Requests\UpdateRpiRequest;
use App\Repositories\RpiRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class RpiController extends AppBaseController
{
    /** @var  RpiRepository */
    private $rpiRepository;

    public function __construct(RpiRepository $rpiRepo)
    {
        $this->rpiRepository = $rpiRepo;
    }

    /**
     * Display a listing of the Rpi.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->rpiRepository->pushCriteria(new RequestCriteria($request));
        $rpis = $this->rpiRepository->all();

        return view('rpis.index')
            ->with('rpis', $rpis);
    }

    /**
     * Show the form for creating a new Rpi.
     *
     * @return Response
     */
    public function create()
    {
        return view('rpis.create');
    }

    /**
     * Store a newly created Rpi in storage.
     *
     * @param CreateRpiRequest $request
     *
     * @return Response
     */
    public function store(CreateRpiRequest $request)
    {
        $input = $request->all();

        $rpi = $this->rpiRepository->create($input);

        Flash::success('Rpi saved successfully.');

        return redirect(route('rpis.index'));
    }

    /**
     * Display the specified Rpi.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $rpi = $this->rpiRepository->findWithoutFail($id);

        if (empty($rpi)) {
            Flash::error('Rpi not found');

            return redirect(route('rpis.index'));
        }

        return view('rpis.show')->with('rpi', $rpi);
    }

    /**
     * Show the form for editing the specified Rpi.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $rpi = $this->rpiRepository->findWithoutFail($id);

        if (empty($rpi)) {
            Flash::error('Rpi not found');

            return redirect(route('rpis.index'));
        }

        return view('rpis.edit')->with('rpi', $rpi);
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
        $rpi = $this->rpiRepository->findWithoutFail($id);

        if (empty($rpi)) {
            Flash::error('Rpi not found');

            return redirect(route('rpis.index'));
        }

        $rpi = $this->rpiRepository->update($request->all(), $id);

        Flash::success('Rpi updated successfully.');

        return redirect(route('rpis.index'));
    }

    /**
     * Remove the specified Rpi from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $rpi = $this->rpiRepository->findWithoutFail($id);

        if (empty($rpi)) {
            Flash::error('Rpi not found');

            return redirect(route('rpis.index'));
        }

        $this->rpiRepository->delete($id);

        Flash::success('Rpi deleted successfully.');

        return redirect(route('rpis.index'));
    }
}
