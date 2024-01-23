<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

class Guardian extends Model
{
    use HasFactory, LogsActivity;
    public $timestamps = false;
    protected $primaryKey = 'Guardianid';
    protected $table = 'guardian';
    protected $fillable = [
        'guardianname',
        'guardianaddress',
        'guardiantel',
        'guardianmob'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->setDescriptionForEvent(fn(string $eventName) => "Guardian has been {$eventName}")
        ->logOnly(['name', 'surname' ,'email', 'mobile', 'address', 'telephone'])
        ->useLogName('Guardian');
    }
    public function tapActivity(Activity $activity)
    {
        $activity->causer_id = auth()->user() ? auth()->id(): 0;
    }
}
