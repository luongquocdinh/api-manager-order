<?php

namespace App\Models\v1;


class Supplier extends BaseModel
{
    protected $table = 'supplier';

    protected $fillable = [
        'name', 'phone', 'user_id', 'note', 'created_at', 'created_by',
        'updated_at', 'updated_by', 'is_enable'
    ];

    public function product()
    {
        return $this->hasMany('App\Models\v1\SupplierProduct', 'supplier_id', 'id');
    }
}
