<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const SUCCESS = 200;
    const FAILED = 401;

    protected function validateData(array $rules, Request $request)
    {
        $input = $request->all();
        $validator = \Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'  => self::FAILED,
                'message' => $validator->messages(),
            ], self::FAILED);
        } else {
            return $input;
        }
    }
}
