<?php 
namespace App\Models\v1;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    protected $table = 'roles';
    protected $fillable = [
        'name', 'description', 'created_at', 'created_by', 'updated_at',
        'updated_by',
    ];
}