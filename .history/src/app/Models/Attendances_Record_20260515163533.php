<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BreakTime;

class Attendances_Record extends Model
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

    public function break(){
        return $this->belongsTo('BreakTime');
    }

}
