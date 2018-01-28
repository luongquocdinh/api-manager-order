<?php

namespace App\Models\v1;


class Customer extends BaseModel
{
    protected $table = 'customers';

    protected $fillable = [
        'name', 'address', 'email', 'phone', 'partner_id', 'note', 'created_at', 'created_by',
        'updated_at', 'updated_by', 'is_delete'
    ];
}
