<?php

namespace App\Models\v1;


class SupplierProduct extends BaseModel
{
    protected $table = 'supplier_product';

    protected $fillable = [
        'name', 'suppplier_id', 'user_id', 'note', 'created_at', 'created_by',
        'updated_at', 'updated_by'
    ];

    public function supplier()
    {
        return $this->belongTo('App\Models\v1\Supplier', 'id', 'supplier_id');
    }
}
