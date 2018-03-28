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
use App\Models\v1\Outlet;
use App\Services\Interfaces\UserServiceContract;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationMail;
use App\Mail\Fotgotpassword;
use Sichikawa\LaravelSendgridDriver\SendGrid;


class UserController extends ApiController
{
    use SendGrid;

    public function __construct(UserServiceContract $serviceContract)
    {
        $this->service = $serviceContract;
        $this->middleware('jwt.auth', ['except' => ['register', 'login', 'sendCode', 'resetPassword']]);
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
        $data = $this->validateUser($this->rulesUser(), $request);
        if (!is_array($data)) {
            return $data;
        }
        $outlet_id = Outlet::create([
            'name' => $request->name
        ])->id;
        
        $data['outlet_id'] = $outlet_id;
        $data['password'] = Hash::make($request->password);
        $role = $request->role ? $request->role : [3];
        $id = $this->service->store($data);     
        if ($id) {
            $user = $this->service->find($id);
            $user->attachRoles($role);
        }
        $this->sendMail(self::MAIL_1, $request);
        return response()->json([
            'success' => true,
            'status'  => self::SUCCESS
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = $this->service->findByEmail($request->email);
        if ($user) {
            if ($user->is_active == 1) {
                if ($token = JWTAuth::attempt($credentials)) {
                    $roles = $user->roles()->get();
                    $list_role = [];
                    $list_user = [];
                    foreach ($roles as $role) {
                        if ($role->name == 'manager' && isset($user->outlet_id)) {
                            $list_user = $this->getListUserOutlet($user->outlet_id);
                        }
                        array_push($list_role, [
                            'role_id'     => $role->id,
                            'name'        => $role->name,
                            'description' => $role->description,
                        ]);
                    }
                    return $this->respondWithToken($user, $list_role, $token, $list_user);
                }
            }
        }

        return response()->json(['success' => false, 'status' => self::FAILED, 'error' => 'Login không thành công! Vui lòng kiểm tra lại!']);
    }
    
    public function find(Request $request)
    {
        $id = $request->id;
        $user = $this->service->find($id);
        
        return response()->json([
            'success' => true,
            'status'  => self::SUCCESS,
            'data'    => $user
        ]); 
    }
    
    public function detail(Request $request)
    {
        $id = JWTAuth::toUser($request->token)->id;
        $user = $this->service->find($id);
        $roles = $user->roles()->get();
        $list_role = [];
        $list_user = [];
        foreach ($roles as $role) {
            array_push($list_role, [
                'role_id'     => $role->id,
                'name'        => $role->name,
                'description' => $role->description,
            ]);
        }
        if (isset($user->outlet_id)) {
            $list_user = $this->getListUserOutlet($user->outlet_id);
        }
        return response()->json([
            'success' => true,
            'status'  => self::SUCCESS,
            'user'    => $user,
            'list_role' => $list_role,
            'member' => $list_user
        ]);
    }

    public function addUser(Request $request)
    {
        $user_id = JWTAuth::toUser($request->token)->id;

        $user = $this->service->find($user_id);

        $outlet_id = $user->outlet_id;

        $outlet = Outlet::find($outlet_id);

        $data = $this->validateUser($this->rulesUser(), $request);
        if (!is_array($data)) {
            return $data;
        }
        $data['name'] = $outlet->name;
        $data['password'] = Hash::make($request->password);
        $data['outlet_id'] = $outlet->id;

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

    public function sendCode(Request $request)
    {
        $user = $this->service->findByEmail($request->email);
        if (!$user) {
            return response()->json([
                'status' => self::FAILED,
                'message' => 'Email không tồn tại'
            ]);
        }
       
        $code = $this->generate_code();
    
        $user->api_token = $code;
        $user->save();
        $this->sendMailResetPassword($request, $code);

        return response()->json([
            'status' => self::SUCCESS,
            'message' => 'Code đã được gửi tới mail của bạn'
        ]);
    }

    public function resetPassword(Request $request)
    {
        $user = $this->service->findUserByCode($request);
        
        if (!$user) {
            return response()->json([
                'status' => self::FAILED,
                'message' => 'Email hoặc code không chính xác'
            ]);
        }
    
        $user->password = Hash::make($request->password);
        $user->api_token = $this->generate_code();
        if ($user->save()) {
            return response()->json([
                'status' => self::SUCCESS,
                'message' => 'Password được cập nhật thành công. Vui lòng đăng nhập lại!!!'
            ]);
        } else {
            return \response()->json(MessageApi::error(HttpCode::NOT_VALID_INFORMATION, MessageApi::ITEM_DOSE_NOT_EXISTS));
        }
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

    public function changePassword(Request $request)
    {
        $id = JWTAuth::toUser($request->token)->id;
        
        $data = $this->validateData([], $request);
        if (!is_array($data)) {
            return $data;
        }
        $user = $this->service->find($id);
        if (!Hash::check($data['old_password'], $user->password)) {
            return response()->json([
                'status' => 403,
                'message' => 'Password cũ không chính xác'
            ]);
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
            return \response()->json(MessageApi::error(HttpCode::NOT_VALID_INFORMATION, MessageApi::ITEM_DOSE_NOT_EXISTS));
        }
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $data = $this->validateData([], $request);
        if (!is_array($data)) {
            return $data;
        }

        if ($this->service->update($id, $data)) {
            return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => $this->service->find($id)
            ]);
        } else {
            return \response()->json(MessageApi::error(HttpCode::NOT_VALID_INFORMATION, MessageApi::ITEM_DOSE_NOT_EXISTS));
        }
        
    }

    public function getListUserOutlet($outlet_id)
    {
        $users = User::where('outlet_id', $outlet_id)->get();

        return $users;
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($user, $list_role, $token, $list_user)
    {
        return response()->json([
            'success' => true, 
            'status' => self::SUCCESS,
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => $this->guard()->factory()->getTTL() * 60,
            'user'         => $user,
            'role'         => $list_role,
            'member'       => $list_user
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
        'email'       => 'required|email|max:255|unique:users',
        'password'    => 'required|min:6',
        ];
    }

    private function sendMail($email, $request)
    {
        Mail::to($email)->send(new NotificationMail($request));
    }

    private function sendMailResetPassword($request, $code)
    {
        Mail::to($request->email)->send(new Fotgotpassword($code));
    }

    private function generate_code()
    {
        $uniqid = uniqid();
        
        $rand_start = rand(1,5);
        
        $code = substr($uniqid,$rand_start,8);

        return $code;
    }
}
