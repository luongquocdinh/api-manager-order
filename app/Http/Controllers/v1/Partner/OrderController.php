<?php

namespace App\Http\Controllers\v1\Partner;

use App\Helpers\Business;
use App\Helpers\HttpCode;
use App\Helpers\MessageApi;
use App\Http\Controllers\ApiController;
use JWTAuth;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;
use App\Services\Interfaces\OrderServiceContract;
use App\Services\Interfaces\OrderProductServiceContract;

class OrderController extends ApiController
{
    protected $service;

    public function __construct(OrderServiceContract $serviceContract, OrderProductServiceContract $po_product)
    {
        $this->service = $serviceContract;
        $this->po_product = $po_product;
        $this->middleware('jwt.auth');
    }

    public function getList()
    {
        $results = $this->service->paginate(Business::PAGE_NUMBER_DEFAULT);

        return OrderResource::collection($results)->additional(['status' => HttpCode::SUCCESS, 'message' => 'success']);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($this->rulesProduct(), $request);
        if (!is_array($data)) {
            return $data;
        }

        $order_info = [
            "customer_id" => $request->customer_id,
            "user_id" => JWTAuth::toUser($request->token)->id,
            "delivery_date" => Carbon::parser($request->delivery_date)->timestamp,
            "created_by" => JWTAuth::toUser($request->token)->id,
        ];

        $po_product = $request->po_product;
        
        $id = $this->service->store($order_info);
        foreach ($po_product as $key => $product) {
            $product['order_id'] = $id;
            $product['created_by'] = JWTAuth::toUser($request->token)->id;
            $this->po_product->store($product);
        }

        return new OrderResource(optional($this->service->find($id)));
    }

    public function findProductById($id)
    {
        return new OrderResource(optional($this->service->find($id)));
    }

    public function update(Request $request, $id)
    {
        $data = $this->validateData([], $request);
        if (!is_array($data)) {
            return $data;
        }

        $data['updated_by'] = JWTAuth::toUser($request->token)->id;

        if ($this->service->update($id, $data)) {
            return new OrderResource(optional($this->service->find($id)));
        } else {
            return \response()->json(MessageApi::error(HttpCode::NOT_VALID_INFORMATION, [MessageApi::ITEM_DOSE_NOT_EXISTS]));
        }
    }

    public function destroy($id)
    {
        $product = $this->service->find($id);
        if ($product) {
            $this->service->destroy($id);

            return \response()->json(MessageApi::success([]), HttpCode::SUCCESS);
        }

        return \response()->json(MessageApi::error(HttpCode::NOT_VALID_INFORMATION, [MessageApi::ITEM_DOSE_NOT_EXISTS]));
    }

    /**
     * @return array
     */
    private function rulesProduct()
    {
        return [
            'customer_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'delivery_date' => 'required|numeric'
        ];
    }
}