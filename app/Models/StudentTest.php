<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

class StudentTest extends Model
{
    use HasFactory, LogsActivity;

    protected $dates = ['date'];

    protected $fillable = ['family_id', 'student_name', 'subject', 'book' , 'test_no' , 'attempt', 'test_date' , 'percentage', 'status' , 'tutor', 'updated_by'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->setDescriptionForEvent(fn(string $eventName) => "Student test has been {$eventName}")
        ->logOnly(['family_id', 'student_name', 'subject', 'book', 'test_no', 'attempt', 'percentage', 'date', 'status', 'tutor_updated_by'])
        ->useLogName('Student Test');
    }
    public function tapActivity(Activity $activity)
    {
        $activity->causer_id = auth()->user() ? auth()->id(): 0;
    }

}
