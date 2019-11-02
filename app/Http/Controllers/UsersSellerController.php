<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUsersSellerRequest;
use App\Http\Requests\UpdateUsersSellerRequest;
use App\Repositories\UsersSellerRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class UsersSellerController extends AppBaseController
{
    /** @var  UsersSellerRepository */
    private $usersSellerRepository;

    public function __construct(UsersSellerRepository $usersSellerRepo)
    {
        $this->usersSellerRepository = $usersSellerRepo;
    }

    /**
     * Display a listing of the UsersSeller.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->usersSellerRepository->pushCriteria(new RequestCriteria($request));
        $usersSellers = $this->usersSellerRepository->all();

        //return $usersSellers->toJson();
         return view('users_sellers.index')
             ->with('usersSellers', $usersSellers);
    }

    /**
     * Show the form for creating a new UsersSeller.
     *
     * @return Response
     */
    public function create()
    {
        return view('users_sellers.create');
    }

    /**
     * Store a newly created UsersSeller in storage.
     *
     * @param CreateUsersSellerRequest $request
     *
     * @return Response
     */
    public function store(CreateUsersSellerRequest $request)
    {
        $input = $request->all();

        $usersSeller = $this->usersSellerRepository->create($input);

        Flash::success('Users Seller saved successfully.');

        return redirect(route('usersSellers.index'));
    }

    /**
     * Display the specified UsersSeller.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $usersSeller = $this->usersSellerRepository->findWithoutFail($id);

        if (empty($usersSeller)) {
            Flash::error('Users Seller not found');

            return redirect(route('usersSellers.index'));
        }

        return view('users_sellers.show')->with('usersSeller', $usersSeller);
    }

    /**
     * Show the form for editing the specified UsersSeller.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $usersSeller = $this->usersSellerRepository->findWithoutFail($id);

        if (empty($usersSeller)) {
            Flash::error('Users Seller not found');

            return redirect(route('usersSellers.index'));
        }

        return view('users_sellers.edit')->with('usersSeller', $usersSeller);
    }

    /**
     * Update the specified UsersSeller in storage.
     *
     * @param  int              $id
     * @param UpdateUsersSellerRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUsersSellerRequest $request)
    {
        $usersSeller = $this->usersSellerRepository->findWithoutFail($id);

        if (empty($usersSeller)) {
            Flash::error('Users Seller not found');

            return redirect(route('usersSellers.index'));
        }

        $usersSeller = $this->usersSellerRepository->update($request->all(), $id);

        Flash::success('Users Seller updated successfully.');

        return redirect(route('usersSellers.index'));
    }

    /**
     * Remove the specified UsersSeller from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $usersSeller = $this->usersSellerRepository->findWithoutFail($id);

        if (empty($usersSeller)) {
            Flash::error('Users Seller not found');

            return redirect(route('usersSellers.index'));
        }

        $this->usersSellerRepository->delete($id);

        Flash::success('Users Seller deleted successfully.');

        return redirect(route('usersSellers.index'));
    }
}
