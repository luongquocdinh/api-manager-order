<?php

namespace App\Models\v1;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Carbon\Carbon;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use EntrustUserTrait;
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'outlet_id', 'password', 'address', 'phone', 'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
 
     /**
      * Return a key value array, containing any custom claims to be added to the JWT.
      *
      * @return array
      */
    public function getJWTCustomClaims()
    {
        return [];
    } 

    static function findUser($id)
    {
        $user = self::where("id", $id)->first();

        return $user;
    }

    static function findUserByEmail($email)
    {
        $user = self::where("email", $email)->first();

        return $user;
    }

    public function order()
    {
        return $this->hasMany('App\Models\v1\Order', 'user_id', 'id');
    }

    public function setCreatedAt($value)
    {
        $this->attributes['created_at'] = Carbon::now()->timestamp;
        return $this;
    }

    public function setUpdatedAt($value)
    {
        $this->attributes['updated_at'] = Carbon::now()->timestamp;
        return $this;
    }
}
