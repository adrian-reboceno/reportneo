<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NeoClassStudent extends Model
{
    //
    protected $fillable = [
        'neo_class_id',
        'neo_person_id',
        'enrolled_at',
        'enroll_type',
        'enrolled_by_id',
        'started',
        'started_at',
        'completed',
        'unenrolled',
        'deactivated',
        'transferred',
        'class_archived',
        'user_archived',
        'percent',
        'grade',
        'override_percent',
        'override_comment',
        'override_by_id',
        'override_at',
        'time_spent',
        'last_visited_at',
        'order_item_id'
    ];


    public function neoClass()
    {
        return $this->belongsTo(NeoClass::class, 'neo_class_id');
    }
    public function neoPerson()
    {
        return $this->belongsTo(NeoPerson::class, 'neo_person_id');
    }
}
