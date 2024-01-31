<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

class Comment extends Model
{
    use HasFactory, LogsActivity;
    public $timestamps = false;
    protected $table = 'teacher_comments';

    protected $fillable = ['family_id', 'student_name', 'comment'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->setDescriptionForEvent(fn(string $eventName) => "Comment has been {$eventName}")
        ->logOnly(['family_id', 'student_name' ,'comment'])
        ->useLogName('Comment');
    }
    public function tapActivity(Activity $activity)
    {
        $activity->causer_id = auth()->user() ? auth()->id(): 0;
    }
}
