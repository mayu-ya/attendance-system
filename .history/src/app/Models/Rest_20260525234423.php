<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rest extends Model
{
    use HasFactory;

    protected $fillable = [
        'apply_id',
        'rest_start',
        'rest_end',
        'rest_total'
    ];

    public function apply(){
        return $this->belongsTo(Apply::class);
    }
}
