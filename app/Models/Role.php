<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

class Role extends Model
{
    use HasFactory, LogsActivity;
    protected $table = 'role';
    // public $timestamps = false;
    protected $fillable = ['name'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->setDescriptionForEvent(fn(string $eventName) => "Role has been {$eventName}")
        ->logOnly(['name'])
        ->useLogName('Role');
    }
    public function tapActivity(Activity $activity)
    {
        $activity->causer_id = auth()->user() ? auth()->id(): 0;
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
