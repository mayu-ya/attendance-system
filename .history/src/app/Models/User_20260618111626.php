<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Attendance_Record;
use App\Models\User;
use App\Models\Comment;
use App\Models\Report;
use App\Notifications\CustomRequestMail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function attendance_records(){
        return $this->hasMany(Attendance_Record::class);
    }

    public function reports(){
        return $this->hasMany(Report::class);
    }

    public function applies(){
        return $this->hasMany(Apply::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomRequestMail());
    }
}
