<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BreakTime extends Model
{
    use HasFactory;

    protected $fillable = [
        'rest_start',
        'rest_end',
        'rest_total'
    ];

    protected $guarded = [
        'attendance_record_id'
    ];

    public function attendance_records(){
        return $this->hasMany('Attendance_Record');
    }
}
