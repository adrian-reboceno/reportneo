<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    public function attendanceSessions()
    {
        return $this->hasMany(NeoClassAttendanceSession::class);
    }
    public function organization()
    {
        return $this->belongsTo(NeoOrganization::class, 'neo_organization_id');
    }
    public function teachers()
    {
        return $this->hasMany(NeoClassTeacher::class);
    }
    public function students()
    {
        return $this->hasMany(NeoClassStudent::class);
    }
}
