<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class NeoPersonProfile extends Model
{
    //
    protected $fillable = [
        'neo_person_id',
        'neo_profile_id',        
    ];
    public function neoPerson()
    {
        return $this->belongsTo(NeoPerson::class);
    }
    public function neoProfile()
    {
        return $this->belongsTo(NeoProfile::class);
    }
    public function neoPersonOrganization()
    {
        return $this->hasMany(NeoPersonOrganization::class);
    }
    public function neoPersonProfile()
    {
        return $this->hasMany(NeoPersonProfile::class);
    }
}
