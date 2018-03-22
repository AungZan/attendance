<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Log;

class Attendance extends Model
{
    protected $fillable = ['company_id', 'user_id', 'origin_in', 'origin_out', 'in', 'out', 'normal', 'overtime'];

    // need to declare this when use coustom accessor.
    protected $appends = ['title', 'allDay', 'start', 'startDate', 'endDate', 'originInTime', 'originOutTime'];

    // for relationship
    protected $with = ['user'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Get title (attendance origin_in/origin_out).
     *
     * @return string
     */
    public function getTitleAttribute()
    {
        $origin_in = date('H:i', strtotime($this->origin_in));
        $origin_out = '';

        if ($this->origin_out != null) {
            $origin_out = date('H:i', strtotime($this->origin_out));
        }

        return "IN : {$origin_in} \n OUT: {$origin_out}";
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
     * Get attendance Start Date.
     *
     * @return string
     */
    public function getStartAttribute()
    {
        $start = date('Y-m-d', strtotime($this->origin_in));

        return "{$start}";
    }

    /**
     * Get attendance Start Date.
     *
     * @return string
     */
    public function getStartDateAttribute()
    {
        $startDate = date('Y-m-d', strtotime($this->origin_in));

        return "{$startDate}";
    }

    /**
     * Get attendance End Date.
     *
     * @return string
     */
    public function getEndDateAttribute()
    {
        $endDate = null;

        if (!empty($this->origin_out)) {
            $endDate = date('Y-m-d', strtotime($this->origin_out));
        }

        return "{$endDate}";
    }

    /**
     * Get attendance origin in time.
     *
     * @return string
     */
    public function getOriginInTimeAttribute()
    {
        $originInTime = date('H:i', strtotime($this->origin_in));

        return "{$originInTime}";
    }

    /**
     * Get attendance origin out time.
     *
     * @return string
     */
    public function getOriginOutTimeAttribute()
    {
        $originOutTime = null;

        if (!empty($this->origin_out)) {
            $originOutTime = date('H:i', strtotime($this->origin_out));
        }

        return "{$originOutTime}";
    }

    /**
     * Validate the attendance data.
     *
     * @return boolean
     */
    public function validation($request)
    {
        $data = $request->all();
        $errors = array();

        $query = Attendance::select();

        $query->where('user_id', $data['user_id'])->where('origin_in', 'LIKE', "%{$data['inDate']}%");

        if (array_key_exists('id', $data)) {
            $query->where('id', '!=', $data['id']);
        }

        $attendance = $query->get()->toArray();

        if (!empty($attendance)) {
            return $errors = ['inDate' => 'The attendance is already created.'];
        }

        $originIn = $data['inDate'] . ' ' . $data['origin_in_time'];
        $originInUnix = strtotime($originIn);

        if (!empty($data['outDate'])) {
            $originOut = $data['outDate'] . ' ' . $data['origin_out_time'];
            $originOutUnix = strtotime($originOut);

            if ($originInUnix > $originOutUnix) {
                return $errors = ['inDate' => 'Check In time cannot be later than Check Out time.'];
            }
        }

        return $errors;
    }

    /**
     * Calculate and normalize the attendance data.
     *
     * @return array
     */
    public function calculate($data, $setting)
    {
        $result = $data->all();

        $originIn = $data['inDate'] . ' ' . $data['origin_in_time'];
        $result['origin_in'] = $originIn; // real check in

        $originInUnix = strtotime($originIn);

        $inUnix = ceil($originInUnix / ($setting['round_time'] * 60)) * $setting['round_time'] * 60;
        $result['in'] = date('Y-m-d H:i:s', $inUnix); // rounded check in

        if (!empty($data['outDate'])) {
            $originOut = $data['outDate'] . ' ' . $data['origin_out_time'];
            $result['origin_out'] = $originOut; // real check out

            $originOutUnix = strtotime($originOut);

            $outUnix = floor($originOutUnix / ($setting['round_time'] * 60)) * $setting['round_time'] * 60;
            $result['out'] = date('Y-m-d H:i:s', $outUnix); // rounded check out
        }

        $result['normal'] = 0;
        $result['overtime'] = 0;

        return $result;
    }
}
