<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Attendance_Record;

class BreakTime extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_record_id'
        'rest_start',
        'rest_end',
        'rest_total'
    ];

    protected $table = 'breaks';

    public function attendance_record(){
        return $this->belongsTo('Attendance_Record');
    }
}
