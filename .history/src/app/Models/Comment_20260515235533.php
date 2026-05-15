<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Attendance_Record;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment'
    ];

    protected $guarded = [
        'user_id',
        'attendance_record_id'
    ];

    public function user(){
        return $this->belongsTo('User');
    }

    public function attendance_record(){
        return $this->belongsTo('Attendance_Record');
    }
}
