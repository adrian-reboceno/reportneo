<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NeoClassTeacher extends Model
{
    //
   // protected $table = 'neo_class_teachers';
    protected $fillable = [
        'neo_class_id',
        'neo_person_id',
        'coteacher',
        'last_visited_at',
    ];
    public function neoClass()
    {
        return $this->belongsTo(NeoClass::class, 'class_id');
    }
    public function neoPerson()
    {
         return $this->belongsTo(NeoPerson::class,'neo_person_id'); // Usa el nombre real del modelo
    }   
   /*  public function person()
    {
        return $this->belongsTo(NeoPerson::class);
    } */
}
