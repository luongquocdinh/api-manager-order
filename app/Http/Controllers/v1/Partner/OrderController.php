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

    public function getList(Request $request)
    {
        $id = JWTAuth::toUser($request->token)->id;

        $results = $this->service->paginate(Business::PAGE_NUMBER_DEFAULT, $id);

        return OrderResource::collection($results)->additional(['status' => HttpCode::SUCCESS, 'message' => 'success']);
    }

    public function getListAll(Request $request)
    {
        $id = JWTAuth::toUser($request->token)->id;

        $results = $this->service->getListAll($id);
        
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
            'amount' => $request->amount,
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

        $order = $this->service->find($id);
        $po = $order->po_product;
        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $order
        ]);
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
        if ($request->delivery_date) {
            $data['delivery_date'] = Carbon::parse($request->delivery_date)->timestamp;
        }
        $data['updated_by'] = JWTAuth::toUser($request->token)->id;
        $this->service->update($id, $data);
        if ($request->po_product) {
            $this->po_product->deleteByOrder($id);
            foreach ($request->po_product as $key => $po_product) {
                $po_product['order_id'] = $id;
                $po_product['user_id'] = JWTAuth::toUser($request->token)->id;
                $po_product['created_by'] = JWTAuth::toUser($request->token)->id;
                $this->po_product->store($po_product);
            }
        }
        if ($this->service->update($id, $data)) {
            $order = $this->service->find($id);
            $po_product = $order->po_product;
            return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => $order
            ]);
        } else {
            return \response()->json(MessageApi::error(HttpCode::NOT_VALID_INFORMATION, [MessageApi::ITEM_DOSE_NOT_EXISTS]));
        }
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $order = $this->service->find($id);
        $po_product = $order->po_product;
        if ($order) {
            $this->service->destroy($id);
            foreach($po_product as $product) {
                $this->po_product->destroy($product->id);
            }
            return \response()->json(MessageApi::success([]), HttpCode::SUCCESS);
        }

        return \response()->json(MessageApi::error(HttpCode::NOT_VALID_INFORMATION, [MessageApi::ITEM_DOES_NOT_EXISTS]));
    }

    public function getListOrderByCustomer(Request $request)
    {
        $customer_id = $request->customer_id;
        $results = $this->service->findByCustomer($customer_id);
        
        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $results
        ]);
    }

    public function getOrderByDate(Request $request)
    {
        $id = JWTAuth::toUser($request->token)->id;
        
        $results = $this->service->getOrderByDate($id, $request);

        return OrderResource::collection($results)->additional(['status' => HttpCode::SUCCESS, 'message' => 'success']);
    }

    /**
     * @return array
     */
    private function rulesProduct()
    {
        return [
            
        ];
    }
}