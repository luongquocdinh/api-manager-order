<?php

namespace App\Http\Controllers\v1\Auth;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Helpers\Business;
use App\Helpers\HttpCode;
use App\Helpers\MessageApi;
use JWTAuth;
use Hash;
use Validator;
use JWTAuthException;
use App\Models\v1\User;
use App\Models\v1\Role;
use App\Services\Interfaces\UserServiceContract;


class UserController extends ApiController
{
    public function __construct(UserServiceContract $serviceContract)
    {
        $this->service = $serviceContract;
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
        $data = $this->validateData($this->rulesUser(), $request);
        if (!is_array($data)) {
            return $data;
        }
        $data['password'] = Hash::make($request->password);
        $role = $request->role ? $request->role : [2];
        $id = $this->service->store($data);     
        if ($id) {
            $user = $this->service->find($id);
            $user->attachRoles($role);
        }

        return response()->json([
            'success' => true,
            'status'  => self::SUCCESS,
            'data'    => $this->service->find($id)
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = $this->service->findByEmail($request->email);
        if ($user) {
            if ($user->is_active == 1) {
                if ($token = JWTAuth::attempt($credentials)) {
                    return $this->respondWithToken($user, $token);
                }
            }
        }

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

    public function update(Request $request)
    {
        $id = JWTAuth::toUser($request->token)->id;
        
        $data = $this->validateData([], $request);
        if (!is_array($data)) {
            return $data;
        }
        
        $data['password'] = Hash::make($request->password);
        $data['updated_by'] = $id;

        if ($this->service->update($id, $data)) {
            return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => $this->service->find($id)
            ]);
        } else {
            return \response()->json(MessageApi::error(HttpCode::NOT_VALID_INFORMATION, [MessageApi::ITEM_DOSE_NOT_EXISTS]));
        }
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($user, $token)
    {
        return response()->json([
            'success' => true, 
            'status' => self::SUCCESS,
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => $this->guard()->factory()->getTTL() * 60,
            'user'         => $user
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

    /**
     * @return array
     */
     private function rulesUser()
     {
         return [
            'name'        => 'required|max:255',
            'email'       => 'required|email|max:255|unique:users',
            'password'    => 'required|min:6',
         ];
     }
}
