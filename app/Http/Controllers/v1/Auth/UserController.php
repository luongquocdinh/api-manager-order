<?php

namespace App\Http\Controllers\v1\Auth;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use JWTAuth;
use Hash;
use Validator;
use JWTAuthException;
use App\Models\v1\User;
use App\Models\v1\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['register', 'login']]);
    }

    /**
     * API Register
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $rules = [
            'name'        => 'required|max:255',
            'email'           => 'required|email|max:255|unique:users',
            'password'        => 'required|min:6',
        ];
        $input = $request->only(
            'name',
            'email',
            'password',
            'role'
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $error = $validator->messages()->toJson();

            return response()->json(['success' => false, 'status' => self::FAILED, 'error' => $error]);
        }
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $role = isset($request->role) ? $request->role : [];
        $user = User::create([
            'name' => $name,
            'email'    => $email,
            'password' => Hash::make($password),
        ]);
        if ($user) {
            $user = User::findUserByEmail($email);
            $user->attachRoles($role);
        }

        return response()->json([
            'success' => true,
            'status'  => self::SUCCESS,
            'data'    => $user,
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::findUserByEmail($request->email);
        // if ($user->is_active == 1) {
            if ($token = JWTAuth::attempt($credentials)) {
                return $this->respondWithToken($token);
            }
        // }

        return response()->json(['success' => false, 'status' => self::FAILED, 'error' => 'Unauthorized']);
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json($this->guard()->user());
    }

    public function getAuthUser(Request $request)
    {
        $user = JWTAuth::toUser($request->token);
        if ($user) {
            return response()->json(['result' => $user]);
        }

        return response()->json([
            'success' => false,
            'status'  => self::FAILED,
        ]);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => $this->guard()->factory()->getTTL() * 60,
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard('api');
    }
}
