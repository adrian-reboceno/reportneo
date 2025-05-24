<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class NeoPersonOrganization extends Model
{
    //
    protected $fillable = [
        'neo_organization_id',
        'neo_person_id',
    ];
    public function neoPerson()
    {
        return $this->belongsTo(NeoPerson::class);
    }
    public function neoOrganization()
    {
        return $this->belongsTo(NeoOrganization::class);
    }
}
