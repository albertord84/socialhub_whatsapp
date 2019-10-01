<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUsersStatusRequest;
use App\Http\Requests\UpdateUsersStatusRequest;
use App\Repositories\UsersStatusRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class UsersStatusController extends AppBaseController
{
    /** @var  UsersStatusRepository */
    private $usersStatusRepository;

    public function __construct(UsersStatusRepository $usersStatusRepo)
    {
        $this->usersStatusRepository = $usersStatusRepo;
    }

    /**
     * Display a listing of the UsersStatus.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->usersStatusRepository->pushCriteria(new RequestCriteria($request));
        $usersStatuses = $this->usersStatusRepository->all();

        return view('users_statuses.index')
            ->with('usersStatuses', $usersStatuses);
    }

    /**
     * Show the form for creating a new UsersStatus.
     *
     * @return Response
     */
    public function create()
    {
        return view('users_statuses.create');
    }

    /**
     * Store a newly created UsersStatus in storage.
     *
     * @param CreateUsersStatusRequest $request
     *
     * @return Response
     */
    public function store(CreateUsersStatusRequest $request)
    {
        $input = $request->all();

        $usersStatus = $this->usersStatusRepository->create($input);

        Flash::success('Users Status saved successfully.');

        return redirect(route('usersStatuses.index'));
    }

    /**
     * Display the specified UsersStatus.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $usersStatus = $this->usersStatusRepository->findWithoutFail($id);

        if (empty($usersStatus)) {
            Flash::error('Users Status not found');

            return redirect(route('usersStatuses.index'));
        }

        return view('users_statuses.show')->with('usersStatus', $usersStatus);
    }

    /**
     * Show the form for editing the specified UsersStatus.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $usersStatus = $this->usersStatusRepository->findWithoutFail($id);

        if (empty($usersStatus)) {
            Flash::error('Users Status not found');

            return redirect(route('usersStatuses.index'));
        }

        return view('users_statuses.edit')->with('usersStatus', $usersStatus);
    }

    /**
     * Update the specified UsersStatus in storage.
     *
     * @param  int              $id
     * @param UpdateUsersStatusRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUsersStatusRequest $request)
    {
        $usersStatus = $this->usersStatusRepository->findWithoutFail($id);

        if (empty($usersStatus)) {
            Flash::error('Users Status not found');

            return redirect(route('usersStatuses.index'));
        }

        $usersStatus = $this->usersStatusRepository->update($request->all(), $id);

        Flash::success('Users Status updated successfully.');

        return redirect(route('usersStatuses.index'));
    }

    /**
     * Remove the specified UsersStatus from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $usersStatus = $this->usersStatusRepository->findWithoutFail($id);

        if (empty($usersStatus)) {
            Flash::error('Users Status not found');

            return redirect(route('usersStatuses.index'));
        }

        $this->usersStatusRepository->delete($id);

        Flash::success('Users Status deleted successfully.');

        return redirect(route('usersStatuses.index'));
    }
}
