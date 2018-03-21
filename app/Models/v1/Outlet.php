<?php

namespace App\Models\v1;


class Outlet extends BaseModel
{
    protected $table = 'outlet';

    protected $fillable = [
        'name', 'created_at', 'created_by',
        'updated_at', 'updated_by'
    ];

    public function user()
    {
        return $this->hasMany('App\Models\v1\User', 'outlet_id', 'id');
    }
}
