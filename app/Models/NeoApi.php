<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NeoApi extends Model
{
    protected $fillable = [
        'neo_tenant_id',
        'status_id',
        'hostapi',
        'apikey',
        'version',
    ];
    
    public function neoTenant()
    {
        return $this->belongsTo(NeoTenant::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }   
}
