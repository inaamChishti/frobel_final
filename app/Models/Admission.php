<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

class Admission extends Model
{
    use HasFactory, LogsActivity;
    public $timestamps = false;
     protected $primaryKey = 'admissionid';
    protected $table = 'admission';

    protected $fillable = [
        'familyno',
        'formfilingdate',
        'joiningdate',
        'medicalcondition',
        'feedetail',
        'timing',
        'familystatus',
        'meetingdetail',
        'payment_method',
        'add_comment'
       ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->setDescriptionForEvent(fn(string $eventName) => "Admission has been {$eventName}")
        ->logOnly(['joining_date', 'medical_condition' ,'timing', 'family_status', 'meeting_detail', 'family_id', 'form_filling_date'])
        ->useLogName('Admission');
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
