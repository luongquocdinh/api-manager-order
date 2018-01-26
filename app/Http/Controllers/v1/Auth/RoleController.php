<?php

namespace App\Http\Controllers\v1\Auth;

use App\Helpers\HttpCode;
use App\Permission;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use JWTAuth;
use Validator;
use App\Models\v1\Role;

class RoleController extends Controller
{
    public function __construct(Role $role)
    {
        $this->role = $role;
        $this->middleware('jwt.auth');
    }

    public function addRole(Request $request)
    {
        $rules = [
            'name'        => 'required|max:255',
            'description' => 'required|max:255',
        ];

        $input = $request->only(
            'name',
            'description'
        );

        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $error = $validator->messages();

            return response()->json(['success' => false, 'status' => self::FAILED, 'error' => $error]);
        }

        $name = $request->name;
        $description = $request->description;

        $role = Role::create([
            'name'        => $name,
            'description' => $description,
        ]);

        return response()->json([
            'status'  => self::SUCCESS,
            'message' => 'success',
            'data'    => $role,
        ]);
    }

    public function listRole()
    {
        $roles = Role::getlistRole();

        return response()->json([
            'status'  => HttpCode::SUCCESS,
            'message' => 'success',
            'errors'  => $roles,
        ]);
    }
}
