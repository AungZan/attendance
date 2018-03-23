<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendanceChanges extends Model
{
    protected $fillable = ['user_id', 'attendance_id', 'origin_in', 'origin_out', 'status'];

    public function attendance()
    {
        return $this->belongsTo('App\Attendance', 'attendance_id');
    }
}
