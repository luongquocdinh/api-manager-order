<?php

namespace App\Models\v1;


class Product extends BaseModel
{
    protected $table = 'product';

    protected $fillable = [
        'name', 'price', 'note', 'created_at', 'created_by',
        'updated_at', 'updated_by', 'is_enable'
    ];
}
