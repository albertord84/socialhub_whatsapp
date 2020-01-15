<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUsersAttendantRequest;
use App\Http\Requests\UpdateUsersAttendantRequest;
use App\Mail\EmailSigninAttendant;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Auth;

use App\User;

use App\Repositories\ExtendedUsersAttendantRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ExtendedUsersAttendantController extends UsersAttendantController
{
    public function __construct(ExtendedUsersAttendantRepository $usersAttendantRepo)
    {
        parent::__construct($usersAttendantRepo);

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
        
        $User = Auth::check()? Auth::user():session('logged_user');
        if($User->role_id==ExtendedContactsStatusController::MANAGER){
            //get attendants of loggued manager            
            $usersAttendants = $this->usersAttendantRepository->Attendants_User((int)$User->id);
        }
        else
        if($User->role_id==ExtendedContactsStatusController::ATTENDANT){
            //get attendants of the same company of loggued attendant
            $usersAttendants = $this->usersAttendantRepository->Attendants_User_By_Attendant((int)$User->company_id, (int)ExtendedContactsStatusController::ATTENDANT);
        }
        
        
        // $usersAttendants = $this->usersAttendantRepository->Attendants_User((int)$User->id);
        
        return ($usersAttendants)? $usersAttendants->toJson() : null;
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

            // return redirect(route('usersAttendants.index'));
        }
        $request->updated_at = time();
        $usersAttendant = $this->usersAttendantRepository->update($request->all(), $id);

        Flash::success('Users Attendant updated successfully.');

        return $usersAttendant->toJson();

        // return redirect(route('usersAttendants.index'));
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
        $usersAttendantController = new UsersAttendantController($this->usersAttendantRepository);
        $usersAttendantController->store($request);

        //enviar email de cadastro de atendente
        $Manager = Auth::check()? Auth::user():session('logged_user');
        $User = new User();
        $User = User::find($request['user_id']);
        $User->password = rand(100000,999999);
        Mail::to($User->email)
            ->send(new EmailSigninAttendant($Manager, $User));
        $User->password = bcrypt($User->password);
        $User->save();

        $input = $request->all();
        $this->usersAttendantRepository->createAttendantChatTable($input['user_id']);

        return ($User)? $User->toJson() : null;
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
        
        // return redirect(route('usersAttendants.index'));
    }
}
