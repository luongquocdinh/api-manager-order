<?php

namespace App\Models\v1;


class OrderProduct extends BaseModel
{
    protected $table = 'order_product';

    protected $fillable = [
        'order_id', 'user_id', 'name', 'quantity', 'uom', 'price', 'amount', 'note', 'created_at', 'created_by',
        'updated_at', 'updated_by'
    ];

    public function order()
    {
        return $this->belongsTo('App\Models\v1\Order', 'id', 'order_id');
    }
}
