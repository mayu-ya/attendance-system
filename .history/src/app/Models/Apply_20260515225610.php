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
        'status'
    ];

    protected $guarded = [
        'user_id',
        'admin_id'
    ];

    public function user(){
        return $this->belongsTo('User');
    }

    public function admin(){
        return $this->belongsTo('Admin');
    }
}
