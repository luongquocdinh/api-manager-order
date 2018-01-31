<?php 
namespace App\Models\v1;

use Zizaco\Entrust\EntrustRole;

class RoleUser extends EntrustRole
{
    protected $table = 'role_user';
    protected $fillable = [
        'user_id', 'role_id'
    ];
}