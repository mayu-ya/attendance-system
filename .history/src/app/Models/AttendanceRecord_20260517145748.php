<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\BreakTime;

class AttendanceRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'start_time',
        'end_time',
        'work_total',
        'content'
    ];

    protected $guarded = [
        'user_id'
    ];

    public function user(){
        return $this->belongsTo('User');
    }

    public function breaks(){
        return $this->hasMany('BreakTime');
    }

    public function attendance_records(){
        return $this->hasMany('Attendance_record');
    }
}
