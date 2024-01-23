<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

class Student extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'studentdata';
    protected $primaryKey = 'studentid';
    public $timestamps = false;

    protected $dates = [
        'created_at',
        'updated_at',
        // your other new column
    ];

    protected $fillable = ['studentname', 'studentsur', 'studentdob', 'studentgender','medical_condition',
    'studentyearinschool', 'studenthours','guardianid','kinid','admissionid','student_status'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->setDescriptionForEvent(fn(string $eventName) => "Student has been {$eventName}")
        ->logOnly(['name', 'surname', 'dob', 'gender', 'years_in_school', 'hours'])
        ->useLogName('Student');
    }
    public function tapActivity(Activity $activity)
    {
        $activity->causer_id = auth()->user() ? auth()->id(): 0;
    }
    public function guardian()
    {
        return $this->belongsTo(Guardian::class);
    }
    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }
    public function kin()
    {
        return $this->belongsTo(Kin::class);
    }
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
