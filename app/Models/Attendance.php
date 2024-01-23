<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

class Attendance extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'attendance';
    public $timestamps = false;
    // protected $fillable = ['family_id', 'student_name', 'teacher', 'subject', 'time', 'session', 'date', 'bk_ch', 'status', 'years_in_school'];
    protected $fillable = [
        'family_id',
        'student_name',
        'student_year_in_school',
        'bk_ch',
        'status',
        'date',
        'teacher_name',
        'subject',
        'time_slot',
        'session_1',
        'session_2',
        'session_3',
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->setDescriptionForEvent(fn(string $eventName) => "Attendance has been {$eventName}")
        ->logOnly(['family_id', 'student_name' ,'teacher_name', 'subject', 'time_slot', 'session_1', 'date', 'bk_ch', 'status', 'student_year_in_school'])
        ->useLogName('Attendance');
    }
    public function tapActivity(Activity $activity)
    {
        $activity->causer_id = auth()->user() ? auth()->id(): 0;
    }
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
