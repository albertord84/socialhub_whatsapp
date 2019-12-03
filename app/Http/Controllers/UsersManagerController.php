<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUsersManagerRequest;
use App\Http\Requests\UpdateUsersManagerRequest;
use App\Repositories\UsersManagerRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class UsersManagerController extends AppBaseController
{
    /** @var  UsersManagerRepository */
    private $usersManagerRepository;

    public function __construct(UsersManagerRepository $usersManagerRepo)
    {
        $this->usersManagerRepository = $usersManagerRepo;
    }

    /**
     * Display a listing of the UsersManager.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->usersManagerRepository->pushCriteria(new RequestCriteria($request));
        $usersManagers = $this->usersManagerRepository->all();

        return $usersManagers->toJson();

        // return view('users_managers.index')
        //     ->with('usersManagers', $usersManagers);
    }

    /**
     * Show the form for creating a new UsersManager.
     *
     * @return Response
     */
    public function create()
    {
        return view('users_managers.create');
    }

    /**
     * Store a newly created UsersManager in storage.
     *
     * @param CreateUsersManagerRequest $request
     *
     * @return Response
     */
    public function store(CreateUsersManagerRequest $request)
    {
        $input = $request->all();

        $usersManager = $this->usersManagerRepository->create($input);

        Flash::success('Users Manager saved successfully.');

        return $usersManager->toJson();

        // return redirect(route('usersManagers.index'));
    }

    /**
     * Display the specified UsersManager.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $usersManager = $this->usersManagerRepository->findWithoutFail($id);

        if (empty($usersManager)) {
            Flash::error('Users Manager not found');

            return redirect(route('usersManagers.index'));
        }

        return view('users_managers.show')->with('usersManager', $usersManager);
    }

    /**
     * Show the form for editing the specified UsersManager.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $usersManager = $this->usersManagerRepository->findWithoutFail($id);

        if (empty($usersManager)) {
            Flash::error('Users Manager not found');

            return redirect(route('usersManagers.index'));
        }

        return view('users_managers.edit')->with('usersManager', $usersManager);
    }

    /**
     * Update the specified UsersManager in storage.
     *
     * @param  int              $id
     * @param UpdateUsersManagerRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUsersManagerRequest $request)
    {
        
        
        $usersManager = $this->usersManagerRepository->findWithoutFail($id);

        if (empty($usersManager)) {
            // Flash::error('Users Manager not found');

            // return redirect(route('usersManagers.index'));
        }

        $usersManager = $this->usersManagerRepository->update($request->all(), $id);

        // Flash::success('Users Manager updated successfully.');

        return $usersManager->toJson();

        // return redirect(route('usersManagers.index'));
    }

    /**
     * Remove the specified UsersManager from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $usersManager = $this->usersManagerRepository->findWithoutFail($id);

        if (empty($usersManager)) {
            Flash::error('Users Manager not found');

            return redirect(route('usersManagers.index'));
        }

        $this->usersManagerRepository->delete($id);

        Flash::success('Users Manager deleted successfully.');

        return redirect(route('usersManagers.index'));
    }
}
