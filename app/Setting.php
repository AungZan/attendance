<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Log;

class Setting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'check_in', 'check_out', 'working_hours', 'break_time', 'company_id',
    ];

    public function getCheckInAttribute($value)
    {
        return date('H:i', strtotime($value));
    }

    public function getCheckOutAttribute($value)
    {
        return date('H:i', strtotime($value));
    }
}
