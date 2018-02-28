<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Log;

class Attendance extends Model
{
    protected $fillable = ['company_id', 'user_id', 'origin_in', 'origin_out', 'in', 'out', 'normal', 'overtime'];

    // need to declare this when use coustom accessor.
    protected $appends = ['title', 'start', 'allDay', 'inHours', 'inMinutes', 'outHours', 'outMinutes'];

    /**
     * Get title (attendance in/out).
     *
     * @return string
     */
    public function getTitleAttribute()
    {
        $in = date('H:i', strtotime($this->in));
        $out = '';

        if ($this->out != null) {
            $out = date('H:i', strtotime($this->out));
        }

        return "IN : {$in} \n OUT: {$out}";
    }

    /**
     * Get attendance Start date.
     *
     * @return string
     */
    public function getStartAttribute()
    {
        $startDate = date('Y-m-d', strtotime($this->in));

        return "{$startDate}";
    }

    /**
     * Get attendance all day.
     *
     * @return boolean
     */
    public function getAllDayAttribute()
    {
        return "{true}";
    }

    /**
     * Get attendance in hour.
     *
     * @return string
     */
    public function getInHoursAttribute()
    {
        $in = explode(':', date('H:i', strtotime($this->in)));
        $inHour = $in[0];

        return "{$inHour}";
    }

    /**
     * Get attendance in minute.
     *
     * @return string
     */
    public function getInMinutesAttribute()
    {
        $in = explode(':', date('H:i', strtotime($this->in)));
        $inMinute = $in[1];

        return "{$inMinute}";
    }

    /**
     * Get attendance out hour.
     *
     * @return string
     */
    public function getOutHoursAttribute()
    {
        $outHour = null;

        if ($this->out != null) {
            $out = explode(':', date('H:i', strtotime($this->out)));
            $outHour = $out[0];
        }

        return "{$outHour}";
    }

    /**
     * Get attendance out minute.
     *
     * @return string
     */
    public function getOutMinutesAttribute()
    {
        $outMinute = null;

        if ($this->out != null) {
            $out = explode(":", date('H:i', strtotime($this->out)));
            $outMinute = $out[1];
        }

        return "{$outMinute}";
    }
}
