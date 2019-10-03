<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUsersAttendantRequest;
use App\Http\Requests\UpdateUsersAttendantRequest;
use App\Repositories\UsersAttendantRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class UsersAttendantController extends AppBaseController
{
    /** @var  UsersAttendantRepository */
    private $usersAttendantRepository;

    public function __construct(UsersAttendantRepository $usersAttendantRepo)
    {
        $this->usersAttendantRepository = $usersAttendantRepo;
    }

    /**
     * Display a listing of the UsersAttendant.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->usersAttendantRepository->pushCriteria(new RequestCriteria($request));
        $usersAttendants = $this->usersAttendantRepository->all();
        return $usersAttendants->toJson();
        // return view('users_attendants.index')
        //     ->with('usersAttendants', $usersAttendants);
    }

    /**
     * Show the form for creating a new UsersAttendant.
     *
     * @return Response
     */
    public function create()
    {
        return view('users_attendants.create');
    }

    /**
     * Store a newly created UsersAttendant in storage.
     *
     * @param CreateUsersAttendantRequest $request
     *
     * @return Response
     */
    public function store(CreateUsersAttendantRequest $request)
    {
        $input = $request->all();

        $usersAttendant = $this->usersAttendantRepository->create($input);

        Flash::success('Users Attendant saved successfully.');

        return redirect(route('usersAttendants.index'));
    }

    /**
     * Display the specified UsersAttendant.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $usersAttendant = $this->usersAttendantRepository->findWithoutFail($id);

        if (empty($usersAttendant)) {
            Flash::error('Users Attendant not found');

            return redirect(route('usersAttendants.index'));
        }

        return view('users_attendants.show')->with('usersAttendant', $usersAttendant);
    }

    /**
     * Show the form for editing the specified UsersAttendant.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $usersAttendant = $this->usersAttendantRepository->findWithoutFail($id);

        if (empty($usersAttendant)) {
            Flash::error('Users Attendant not found');

            return redirect(route('usersAttendants.index'));
        }

        return view('users_attendants.edit')->with('usersAttendant', $usersAttendant);
    }

    /**
     * Update the specified UsersAttendant in storage.
     *
     * @param  int              $id
     * @param UpdateUsersAttendantRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUsersAttendantRequest $request)
    {
        $usersAttendant = $this->usersAttendantRepository->findWithoutFail($id);

        if (empty($usersAttendant)) {
            Flash::error('Users Attendant not found');

            return redirect(route('usersAttendants.index'));
        }

        $usersAttendant = $this->usersAttendantRepository->update($request->all(), $id);

        Flash::success('Users Attendant updated successfully.');

        return redirect(route('usersAttendants.index'));
    }

    /**
     * Remove the specified UsersAttendant from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $usersAttendant = $this->usersAttendantRepository->findWithoutFail($id);

        if (empty($usersAttendant)) {
            Flash::error('Users Attendant not found');

            return redirect(route('usersAttendants.index'));
        }

        $this->usersAttendantRepository->delete($id);

        Flash::success('Users Attendant deleted successfully.');

        return redirect(route('usersAttendants.index'));
    }
}
