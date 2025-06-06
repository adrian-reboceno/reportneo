<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NeoOrganization extends Model
{
    //
    protected $fillable = [
        'parent_id',
        'type',
        'neo_tenant_id',
        'lms_organization',
        'name_organization',
    ];
    
    public function neoTenant()
    {
        return $this->belongsTo(NeoTenant::class);
    }
    /**
     * Organización padre.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(NeoOrganization::class,'parent_id','lms_organization');
    }

    /**
     * Organizaciones hijas.
     */
    public function children(): HasMany
    {
        return $this->hasMany(NeoOrganization::class, 'parent_id');
    }
    public function classes()
    {
        return $this->hasMany(NeoClass::class);
    }
    

    /**
     * Acceso al LMS asociado (si necesitas modelo relacionado).
     */
    /*  public function lms()
    {
        return $this->belongsTo(Lms::class, 'lms_organization');
    } */ 
}
