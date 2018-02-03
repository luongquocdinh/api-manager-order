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
use Carbon\Carbon;

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
            'customer_id' => $request->customer_id,
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'user_id' => JWTAuth::toUser($request->token)->id,
            'delivery_date' => Carbon::parse($request->delivery_date)->timestamp,
            'created_by' => JWTAuth::toUser($request->token)->id,
            'note' => $request->note
        ];
        
        $po_product = $request->po_product;
        
        $id = $this->service->store($order_info);
        foreach ($po_product as $key => $product) {
            $product['order_id'] = $id;
            $product['user_id'] = JWTAuth::toUser($request->token)->id;
            $product['created_by'] = JWTAuth::toUser($request->token)->id;
            $this->po_product->store($product);
        }

        return new OrderResource(optional($this->service->find($id)));
    }

    public function findProductById($id)
    {
        $order = $this->service->find($id);
        $po_product = $order->po_product;
        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $order
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $this->validateData([], $request);
        
        if (!is_array($data)) {
            return $data;
        }
        $data['updated_by'] = JWTAuth::toUser($request->token)->id;
        $this->service->update($id, $data);
        if ($request->po_product) {
            $this->po_product->deleteByPartner($id);
            foreach ($request->address as $key => $address) {
                $address['partner_info_id'] = $id;
                $address['created_by'] = JWTAuth::toUser($request->token)->id;
                $this->address->store($address);
            }
        }
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
            'delivery_date' => 'required'
        ];
    }
}