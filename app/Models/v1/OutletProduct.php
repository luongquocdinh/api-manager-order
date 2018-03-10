<?php

namespace App\Models\v1;


class OutletProduct extends BaseModel
{
    protected $table = 'outlet_product';

    protected $fillable = [
        'user_id', 'product_id', 'name', 'uom', 'description', 'stock_balance', 'created_at', 'created_by',
        'updated_at', 'updated_by'
    ];

    public function user()
    {
        return $this->hasMany('App\Models\v1\User', 'id', 'user_id');
    }

    public function product()
    {
        return $this->hasMany('App\Models\v1\Product', 'id', 'product_id');
    }
}