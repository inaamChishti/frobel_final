<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

class Note extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['ref_no', 'name', 'message', 'message_for', 'received_by'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->setDescriptionForEvent(fn(string $eventName) => "Note has been {$eventName}")
        ->logOnly(['ref_no', 'name', 'message', 'message_for', 'received_by'])
        ->useLogName('Note');
    }
    public function tapActivity(Activity $activity)
    {
        $activity->causer_id = auth()->user() ? auth()->id(): 0;
    }
}
