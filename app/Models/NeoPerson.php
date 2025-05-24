<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class NeoPerson extends Model
{
    //
    protected $fillable = [
        'neo_tenant_id',
        'neo_status_id',
        'lms_id',
        'sisid',
        'first_name',
        'last_name',
        'studentID',
        'teacherID',
        'email',
        'joined_at',
        'first_login_at',
        'last_login_at',
        'last_login_ip',
        'educational_program'
    ];
    public function neoTenant()
    {
        return $this->belongsTo(NeoTenant::class);
    }
    public function neoStatus()
    {
        return $this->belongsTo(NeoStatus::class);
    }
    public function neoPersonProfile()
    {
        return $this->hasMany(NeoPersonProfile::class);
    }
    public function neoPersonOrganization()
    {
        return $this->hasMany(NeoPersonOrganization::class);
    }
}
