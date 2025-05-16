<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NeoOrganization extends Model
{
    //
     protected $fillable = [
        'neo_tenant_id',
        'lms_organization',
        'name_organization',
    ];
    
    public function neoTenant()
    {
        return $this->belongsTo(NeoTenant::class);
    }

   
    
}
