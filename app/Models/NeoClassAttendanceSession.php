<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NeoClassAttendanceSession extends Model
{
    //
    /* protected $table = 'neo_class_attendance_sessions'; */
    protected $fillable = [
        'neo_class_id',
        'session_id',
        'started_at',
        'finished_at',
    ];
}
