<?php

namespace App\Http\Controllers\v1\Partner;

use App\Helpers\Business;
use App\Helpers\HttpCode;
use App\Helpers\MessageApi;
use App\Http\Controllers\ApiController;
use JWTAuth;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;
use App\Services\Interfaces\OrderProductServiceContract;
use Carbon\Carbon;

class StatisticController extends ApiController
{
    protected $service;
    protected $po_product;

    public function __construct(OrderProductServiceContract $po_product)
    {
        $this->po_product = $po_product;
        $this->middleware('jwt.auth');
    }

    public function byDate(Request $request)
    {
        $id = JWTAuth::toUser($request->token)->id;
        $order = $this->po_product->byDate($request, $id);

        return response()->json([
            'status' => HttpCode::SUCCESS,
            'message' => 'success',
            'data' => $order
        ]);
    }

    public function byMonth(Request $request)
    {
        $id = JWTAuth::toUser($request->token)->id;
        $order = $this->po_product->byMonth($request, $id);

        return response()->json([
            'status' => HttpCode::SUCCESS,
            'message' => 'success',
            'data' => $order
        ]);
    }

    public function byYear(Request $request)
    {
        $id = JWTAuth::toUser($request->token)->id;
        $order = $this->po_product->byYear($request, $id);

        return response()->json([
            'status' => HttpCode::SUCCESS,
            'message' => 'success',
            'data' => $order
        ]);
    }
}