<?php

namespace App\Http\Controllers\v1\Partner;

use App\Helpers\Business;
use App\Helpers\HttpCode;
use App\Helpers\MessageApi;
use App\Http\Controllers\ApiController;
use App\Http\Resources\OutletProductResource;
use Illuminate\Http\Request;
use App\Services\Interfaces\OutletProductServiceContract;
use JWTAuth;
use Carbon\Carbon;

class OutletProductController extends ApiController
{
    protected $service;

    public function __construct(OutletProductServiceContract $serviceContract)
    {
        $this->service = $serviceContract;
        $this->middleware('jwt.auth');
    }

    public function getList()
    {
        $results = $this->service->paginate(Business::PAGE_NUMBER_DEFAULT);

        return OutletProductResource::collection($results)->additional(['status' => HttpCode::SUCCESS, 'message' => 'success']);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($this->rulesProduct(), $request);
        if (!is_array($data)) {
            return $data;
        }
        $data['user_id'] = JWTAuth::toUser($request->token)->id;
        $data['created_by'] = $request->user()->id;
        $id = $this->service->store($data);

        return new OutletProductResource(optional($this->service->find($id)));
    }

    public function findProductById($id)
    {
        return new OutletProductResource(optional($this->service->find($id)));
    }

    public function update(Request $request, $id)
    {
        $data = $this->validateData([], $request);
        if (!is_array($data)) {
            return $data;
        }

        $data['updated_by'] = $request->user()->id;

        if ($this->service->update($id, $data)) {
            return new OutletProductResource(optional($this->service->find($id)));
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
            'product_id' => 'required|numeric'
        ];
    }
}