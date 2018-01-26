<?php

namespace App\Models\v1;


class Order extends BaseModel
{
    protected $table = 'order';

    protected $fillable = [
        'customer_id', 'user_id', 'delivery_date', 'created_at', 'created_by',
        'updated_at', 'updated_by', 'is_enable'
    ];
}
