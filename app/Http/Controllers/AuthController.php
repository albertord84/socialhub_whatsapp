<?php

namespace App\Http\Controllers;

use App\Events\PasswordResetEvent;
use App\Events\RegisterUserEvent;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'passwordReset', 'passwordSave', 'deleteUser']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);
        User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password'))
        ]);
        event(new RegisterUserEvent($request->all()));
        return response()->json(['success' => 'success'], 200);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);
        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }

    /**
     * send mail for password reset mail
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function passwordReset()
    {
        $user = User::where('email', request(['email']))->first();
        if (is_null($user)) {
            return response()->json(['error' => 'No user exists'], 401);
        }
        $token = str_random(16);
        DB::table('password_resets')->insert(['token' => $token, 'email' => $user->email]);

        $data = ['email' => $user->email, 'token' => $token, 'name' => $user->name];
        event(new PasswordResetEvent($data));

        return response()->json(['success' => 'Success'], 200);
    }

    /**
     * password save
     */
    public function passwordSave(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);
        $password_reset = DB::table('password_resets')
            ->where('token', $request->get('token'))
            ->first();

        if ($password_reset) {
            User::where('email', $password_reset->email)->first()
                ->update(['password' => bcrypt($request->get('password'))]);
            DB::table('password_resets')->where('token', $request->get('token'))->delete();
            return response()->json(['success' => 'success'], 200);
        } else {
            return response()->json(['error' => 'not_valid_token'], 200);
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * user list
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function user_list()
    {
        $users = User::all();
        return response()->json(['users' => $users]);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'user' => $this->guard()->user(),
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60


        ]);
    }

    /**
     * Make new user
     */
    public function addUser(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);
        User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password'))
        ]);
        return response()->json(['success' => 'success'], 200);
    }

    /**
     * Get user info
     */
    public function getUser($user_id)
    {
        $user = User::findOrFail($user_id);
        return response()->json($user, 200);
    }

    /**
     * Edit user info
     */
    public function editUser(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $request->get('user_id'),
            'user_id' => 'required',
        ]);
        $user = User::findOrFail($request->get('user_id'));
        $user->update([
            'email' => $request->get('email'),
            'name' => $request->get('name')
        ]);
        return response()->json(['success' => 'success'], 200);
    }
    /**
     * Delete user
     */
    public function deleteUser($user_id)
    {
        User::findOrFail($user_id)->delete();
        return redirect('/#/users_list');
    }


    public function guard()
    {
        return \Auth::Guard('api');
    }
}
