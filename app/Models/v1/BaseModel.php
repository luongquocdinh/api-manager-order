<?php
/**
 * Created by Visual Studio Code.
 * User: dinhlq
 * Date: 21/1/2018
 * Time: 13:27 PM
 */

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'deleted_at' => 'timestamp'
    ];

    public function scopeDeletedAt($query)
    {
        return $query->where('deleted_at', null);
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