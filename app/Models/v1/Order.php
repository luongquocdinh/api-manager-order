<?php

namespace App\Models\v1;


class Order extends BaseModel
{
    protected $table = 'orders';

    protected $fillable = [
        'customer_id', 'partner_id', 'delivery_date', 'created_at', 'created_by',
        'updated_at', 'updated_by', 'is_enable'
    ];

    public function po_product()
    {
        return $this->hasMany('App\Models\v1\OrderProduct');
    }
}
