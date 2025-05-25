<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NeoClass extends Model
{
    //
    protected $fillable = [
        'neo_tenant_id',
        'neo_organization_id', 
        'neo_status_id' ,
        'lms_class' ,
        'parent_id',
        'name' ,
        'access_code',
        'creator_id',
        'createdat',
        'language',
        'subject',
        'used_seats',
        'style',
        'start_at',
        'finish_at',
        'time_zone',
        'section_code'
    ];
}
