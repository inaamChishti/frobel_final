<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

class TimeTable extends Model
{
    use HasFactory, LogsActivity;


    protected $table = 'timetable';
    public $timestamps = false;

    protected $fillable = ['studentname', 'admissionid', 'day', 'timeslot', 'subject'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->setDescriptionForEvent(fn(string $eventName) => "Time Table has been {$eventName}")
        ->logOnly(['admissionid', 'day', 'day', 'timeslot', 'subject'])
        ->useLogName('Time table');
    }
    public function tapActivity(Activity $activity)
    {
        $activity->causer_id = auth()->user() ? auth()->id(): 0;
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
