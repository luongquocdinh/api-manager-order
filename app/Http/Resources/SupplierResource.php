<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\Helpers\HttpCode;

class SupplierResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    public function with($request)
    {
        return [
            'status'  => HttpCode::SUCCESS,
            'message' => 'success',
        ];
    }
}
