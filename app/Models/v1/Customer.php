<?php

namespace App\Models\v1;


class Customer extends BaseModel
{
    protected $table = 'customer';

    protected $fillable = [
        'name', 'address', 'email', 'phone', 'created_at', 'created_by',
        'updated_at', 'updated_by', 'is_enable'
    ];
}
