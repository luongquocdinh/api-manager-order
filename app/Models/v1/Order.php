<?php

namespace App\Models\v1;


class Order extends BaseModel
{
    protected $table = 'orders';

    protected $fillable = [
        'customer_id', 'user_id', 'delivery_date', 'note', 'created_at', 'created_by',
        'updated_at', 'updated_by'
    ];

    public function po_product()
    {
        return $this->hasMany('App\Models\v1\OrderProduct', 'order_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\v1\User', 'id', 'user_id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\v1\Customer', 'id', 'customer_id');
    }
}
