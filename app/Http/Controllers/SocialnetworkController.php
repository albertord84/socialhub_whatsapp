<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSocialnetworkRequest;
use App\Http\Requests\UpdateSocialnetworkRequest;
use App\Repositories\SocialnetworkRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class SocialnetworkController extends AppBaseController
{
    /** @var  SocialnetworkRepository */
    private $socialnetworkRepository;

    public function __construct(SocialnetworkRepository $socialnetworkRepo)
    {
        $this->socialnetworkRepository = $socialnetworkRepo;
    }

    /**
     * Display a listing of the Socialnetwork.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->socialnetworkRepository->pushCriteria(new RequestCriteria($request));
        $socialnetworks = $this->socialnetworkRepository->all();

        return view('socialnetworks.index')
            ->with('socialnetworks', $socialnetworks);
    }

    /**
     * Show the form for creating a new Socialnetwork.
     *
     * @return Response
     */
    public function create()
    {
        return view('socialnetworks.create');
    }

    /**
     * Store a newly created Socialnetwork in storage.
     *
     * @param CreateSocialnetworkRequest $request
     *
     * @return Response
     */
    public function store(CreateSocialnetworkRequest $request)
    {
        $input = $request->all();

        $socialnetwork = $this->socialnetworkRepository->create($input);

        Flash::success('Socialnetwork saved successfully.');

        return redirect(route('socialnetworks.index'));
    }

    /**
     * Display the specified Socialnetwork.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $socialnetwork = $this->socialnetworkRepository->findWithoutFail($id);

        if (empty($socialnetwork)) {
            Flash::error('Socialnetwork not found');

            return redirect(route('socialnetworks.index'));
        }

        return view('socialnetworks.show')->with('socialnetwork', $socialnetwork);
    }

    /**
     * Show the form for editing the specified Socialnetwork.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $socialnetwork = $this->socialnetworkRepository->findWithoutFail($id);

        if (empty($socialnetwork)) {
            Flash::error('Socialnetwork not found');

            return redirect(route('socialnetworks.index'));
        }

        return view('socialnetworks.edit')->with('socialnetwork', $socialnetwork);
    }

    /**
     * Update the specified Socialnetwork in storage.
     *
     * @param  int              $id
     * @param UpdateSocialnetworkRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSocialnetworkRequest $request)
    {
        $socialnetwork = $this->socialnetworkRepository->findWithoutFail($id);

        if (empty($socialnetwork)) {
            Flash::error('Socialnetwork not found');

            return redirect(route('socialnetworks.index'));
        }

        $socialnetwork = $this->socialnetworkRepository->update($request->all(), $id);

        Flash::success('Socialnetwork updated successfully.');

        return redirect(route('socialnetworks.index'));
    }

    /**
     * Remove the specified Socialnetwork from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $socialnetwork = $this->socialnetworkRepository->findWithoutFail($id);

        if (empty($socialnetwork)) {
            Flash::error('Socialnetwork not found');

            return redirect(route('socialnetworks.index'));
        }

        $this->socialnetworkRepository->delete($id);

        Flash::success('Socialnetwork deleted successfully.');

        return redirect(route('socialnetworks.index'));
    }
}
