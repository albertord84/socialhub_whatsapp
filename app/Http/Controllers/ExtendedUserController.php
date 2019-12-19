<?php

namespace App\Http\Controllers;


use App\Business\FileUtils;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\ExtendedUserRepository;
use App\User;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Auth;

// use App\Models\User;

class ExtendedUserController extends UserController
{

    public function __construct(ExtendedUserRepository $userRepository)
    {
        parent::__construct($userRepository);
        $this->userRepository = $userRepository;
        
        $this->APP_FILE_PATH = env('APP_FILE_PATH');
    }

    /**
     * Display a listing of the User.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->userRepository->pushCriteria(new RequestCriteria($request));
        $users = $this->userRepository->all();

        return view('users.index')
            ->with('users', $users);
    }

    /**
     * Show the form for creating a new User.
     *
     * @return Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created User in storage.
     *
     * @param CreateUserRequest $request
     *
     * @return Response
     */
    public function store(CreateUserRequest $request)
    {
        $input = $request->all();

        $input['password'] = bcrypt('123456');

        $user = $this->userRepository->create($input);

        Flash::success('User saved successfully.');

        return $user->toJson();
    }

    /**
     * Display the specified User.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        return view('users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified User.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        return view('users.edit')->with('user', $user);
    }

    /**
     * Update the specified User in storage.
     *
     * @param  int              $id
     * @param UpdateUserRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserRequest $request)
    {
        if(isset($request['password']))
            $request['password'] = bcrypt($request['password']);
        else 
            unset($request['password']);
        $user = $this->userRepository->findWithoutFail($id);
        if (empty($user)) {
            Flash::error('User not found');
            
            return redirect(route('users.index'));
        }
        
        $user = $this->userRepository->update($request->all(), $id);
        
        Flash::success('User updated successfully.');

        return $user->toJson();
        //return redirect(route('users.index'));
    }

    /**
     * Remove the specified User from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('User not found');

            // return redirect(route('users.index'));
        }

        $this->userRepository->delete($id);

        Flash::success('User deleted successfully.');

        // return redirect(route('users.index'));
    }
    
    public function update_image($id, Request $request)
    {
        try {
            $User = User::find($id);
            if ($file = $request->file('file')) {

                $company_id = $User->company_id;
                $files_path = $this->APP_FILE_PATH;

                $image_path = "companies/$company_id/users/$User->id/profile/";
                $image_name = "$User->id";
                
                $json_data = FileUtils::SavePostFile($request->file, $image_path, $image_name);
                if ($json_data) {
                    // TODO : coger assi -> env('APP_FILE_PATH', 'external_files')
                    $User->image_path = 'external_files/companies/'."$company_id/users/$User->id/profile/".$image_name.".".$file->getClientOriginalExtension();
                    // $User->image_path = env('APP_FILE_PATH', 'external_files').'/companies/'."$company_id/users/$User->id/profile/".$image_name.".".$file->getClientOriginalExtension();
                    $User->save();
                    return $User->image_path;
                }
            } else {
                abort(302, "Error uploading file!");
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    



}
