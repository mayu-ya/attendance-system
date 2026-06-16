<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'month',
        'total_work',
        'total_overtime',
        'average_work',
        'behind_time',
        'leaving_early',
        'overtime_day'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
