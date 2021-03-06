<?php

namespace App\Http\Controllers\v1\MasterData;

use App\Helpers\Business;
use App\Helpers\HttpCode;
use App\Helpers\MessageApi;
use App\Http\Controllers\ApiController;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use App\Services\Interfaces\ProductServiceContract;

class ProductController extends ApiController
{
    protected $service;

    public function __construct(ProductServiceContract $serviceContract)
    {
        $this->service = $serviceContract;
    }

    public function getList()
    {
        $results = $this->service->paginate(Business::PAGE_NUMBER_DEFAULT);

        return ProductResource::collection($results)->additional(['status' => HttpCode::SUCCESS, 'message' => 'success']);
    }

    public function getListAll()
    {
        $results = $this->service->getListAll();

        return ProductResource::collection($results)->additional(['status' => HttpCode::SUCCESS, 'message' => 'success']);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($this->rulesProduct(), $request);
        if (!is_array($data)) {
            return $data;
        }
        
        $id = $this->service->store($data);

        return new ProductResource(optional($this->service->find($id)));
    }

    public function findProductById($id)
    {
        return new ProductResource(optional($this->service->find($id)));
    }

    public function update(Request $request, $id)
    {
        $data = $this->validateData([], $request);
        if (!is_array($data)) {
            return $data;
        }

        if ($this->service->update($id, $data)) {
            return new ProductResource(optional($this->service->find($id)));
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
            'name' => 'required|max:255'
        ];
    }
}
