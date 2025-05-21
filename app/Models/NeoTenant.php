<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NeoTenant extends Model
{
    //
    protected $fillable = [
        'status_id',
        'idportal',
        'school_name',
        'url',
        'privatekey'
    ];
    
    public function status(): HasOne
    {
        return $this->hasOne(Status::class, 'id', 'status_id');        
    }
    public function api()
    {
        return $this->hasOne(NeoApi::class);
    }
}
