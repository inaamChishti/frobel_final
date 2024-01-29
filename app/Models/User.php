<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

class User extends Authenticatable
{
    use HasFactory, Notifiable, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'user_role';
    public $timestamps = false;
    protected $fillable = [
        'username',
        'email',
        'password',
        'usertype',
        'is_sent',

        // 'custom_password'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        // 'custom_password'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'custom_password' => 'encrypted'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->setDescriptionForEvent(fn(string $eventName) => "User has been {$eventName}")
        ->logOnly(['name', 'email', 'username'])
        ->dontLogIfAttributesChangedOnly(['password'])
        ->useLogName('User');
    }
    public function tapActivity(Activity $activity)
    {
        $activity->causer_id = auth()->user() ? auth()->id(): 0;
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = $password;
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
