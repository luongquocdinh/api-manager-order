<?php

namespace App\Models\v1;


class Product extends BaseModel
{
    protected $table = 'products';

    protected $fillable = [
        'name', 'price', 'uom', 'note', 'created_at', 'created_by',
        'updated_at', 'updated_by', 'is_enable'
    ];
}
