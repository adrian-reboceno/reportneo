<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NeoClassAttendanceSessionUser extends Model
{
    //
    //protected $table = 'neo_class_attendance_session_users';
    protected $fillable = [
        'session_id',
        'neo_person_id',
        'status',
        'arrived_late',
        'left_early',
        'excused',
        'note'
    ];
}
