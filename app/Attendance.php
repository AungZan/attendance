<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Log;
// use App\Attendance;

class Attendance extends Model
{
    protected $fillable = ['company_id', 'user_id', 'origin_in', 'origin_out', 'in', 'out', 'normal', 'overtime'];

    // need to declare this when use coustom accessor.
    protected $appends = ['title', 'allDay', 'startDate', 'endDate', 'originInTime', 'originOutTime'];

    // for relationship
    protected $with = ['user'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

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
    public function calculate($data)
    {
        $result = $data->all();

        $originIn = $data['inDate'] . ' ' . $data['origin_in_time'];
        $originInUnix = strtotime($originIn);
        $result['origin_in'] = $originIn;
        $result['in'] = $result['origin_in'];

        if (!empty($data['outDate'])) {
            $originOut = $data['outDate'] . ' ' . $data['origin_out_time'];
            $originOutUnix = strtotime($originOut);
            $result['origin_out'] = $originOut;
            $result['out'] = $result['origin_out'];
        }

        $result['normal'] = null;
        $result['overtime'] = null;

        return $result;
    }
}
