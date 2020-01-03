<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUsersSellerRequest;
use App\Http\Requests\UpdateUsersSellerRequest;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Auth;

use App\Repositories\ExtendedUsersSellerRepository;
use stdClass;

class ExtendedUsersSellerController extends UsersSellerController
{

    public function __construct(ExtendedUsersSellerRepository $usersSellerRepo)
    {
        parent::__construct($usersSellerRepo);

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
        $usersSellers = $this->usersSellerRepository->Sellers_User();

        return $usersSellers->toJson();
        // return view('users_sellers.index')
        //     ->with('usersSellers', $usersSellers);
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

    public function cep($cep){
        try{
            $datas = file_get_contents('https://viacep.com.br/ws/'.$cep.'/json/');
            return $datas; //ja esta em json
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Erro validando CEP'], 401);
        }
    }

    // public function cep($cep){
    //     try{
    //         $datas = file_get_contents('https://viacep.com.br/ws/'.$cep.'/json/');
    //         if(!strpos($datas,'erro')>0){
    //             return $datas; //ja esta em json
    //         }else{
    //             $obj = new stdClass();
    //             $obj->message = "CEP not found";
    //             // dd($obj->message);
    //             return $obj->message->toJson();
    //         }
    //     } catch (\Throwable $th) {
    //         $obj = new stdClass();
    //         $obj->message = "An error occurr";
    //         // dd($obj->message);
    //         return $obj->toJson();
    //         // throw $th;
    //     }
    // }
    
}
