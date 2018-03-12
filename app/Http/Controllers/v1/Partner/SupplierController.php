<?php

namespace App\Http\Controllers\v1\Partner;

use App\Helpers\Business;
use App\Helpers\HttpCode;
use App\Helpers\MessageApi;
use App\Http\Controllers\ApiController;
use JWTAuth;
use App\Http\Resources\SupplierResource;
use Illuminate\Http\Request;
use App\Services\Interfaces\SupplierServiceContract;
use App\Services\Interfaces\SupplierProductServiceContract;
use Carbon\Carbon;

class SupplierController extends ApiController
{
    protected $service;

    protected $supplier_product;

    public function __construct(SupplierServiceContract $serviceContract, SupplierProductServiceContract $product)
    {
        $this->service = $serviceContract;
        $this->supplier_product = $product;
        $this->middleware('jwt.auth');
    }

    public function paginate(Request $request)
    {
        $id = JWTAuth::toUser($request->token)->id;
        
        $results = $this->service->paginate(Business::PAGE_NUMBER_DEFAULT, $id);

        return SupplierResource::collection($results)->additional(['status' => HttpCode::SUCCESS, 'message' => 'success']);
    }

    public function getListAll(Request $request)
    {
        $id = JWTAuth::toUser($request->token)->id;

        $results = $this->service->getListAll($id);
        
        return SupplierResource::collection($results)->additional(['status' => HttpCode::SUCCESS, 'message' => 'success']);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($this->rulesSupplier(), $request);
        if (!is_array($data)) {
            return $data;
        }

        $supplier_info = [
            'name' => $request->name,
            'phone' => $request->phone,
            'user_id' => JWTAuth::toUser($request->token)->id,
            'created_by' => JWTAuth::toUser($request->token)->id,
            'note' => $request->note
        ];
        
        $supplier_product = $request->supplier_product;
        
        $id = $this->service->store($supplier_info);
        foreach ($supplier_product as $key => $product) {
            $product['supplier_id'] = $id;
            $product['user_id'] = JWTAuth::toUser($request->token)->id;
            $product['created_by'] = JWTAuth::toUser($request->token)->id;
            $this->supplier_product->store($product);
        }

        $supplier = $this->service->find($id);
        $products = $supplier->supplier_product;
        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $supplier
        ]);
    }

    public function findById(Request $request)
    {
        $id = $request->id;
        $supplier = $this->service->find($id);
        $supplier_product = $supplier->supplier_product;
        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $supplier
        ]);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $data = $this->validateData([], $request);
        
        if (!is_array($data)) {
            return $data;
        }
        
        $data['updated_by'] = JWTAuth::toUser($request->token)->id;

        if ($this->service->update($id, $data)) {
            if ($request->supplier_product) {
                $this->supplier_product->deleteBySupplier($id);
                foreach ($request->supplier_product as $key => $supplier_product) {
                    $supplier_product['supplier_id'] = $id;
                    $supplier_product['user_id'] = JWTAuth::toUser($request->token)->id;
                    $supplier_product['created_by'] = JWTAuth::toUser($request->token)->id;
                    $this->supplier_product->store($supplier_product);
                }
            }
            $supplier = $this->service->find($id);
            $supplier_product = $supplier->supplier_product;
            return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => $supplier
            ]);
        } else {
            return \response()->json(MessageApi::error(HttpCode::NOT_VALID_INFORMATION, [MessageApi::ITEM_DOSE_NOT_EXISTS]));
        }
    } 

    /**
     * @return array
     */
     private function rulesSupplier()
     {
         return [
             'name' => 'required|max:255',
             'phone' => 'required|max:255'
         ];
     }
}