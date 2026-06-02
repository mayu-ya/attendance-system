<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Admin;

class Apply extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admin_id',
        'attendance_record_id',
        'date',
        'start_time',
        'end_time',
        'work_total',
        'duration'
        'content',
        'status'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function admin(){
        return $this->belongsTo(Admin::class);
    }

    public function attendance_record(){
        return $this->belongsTo(Attendance_record::class);
    }

    public function rests(){
        return $this->hasMany(Rest::class);
    }
}
