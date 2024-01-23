<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

class Kin extends Model
{
    use HasFactory, LogsActivity;
    public $timestamps = false;
    protected $primaryKey = 'kinid';
    protected $table = 'kin';
    protected $fillable = [
        'kinname',
        'kinaddress',
        'kintel',
        'kinmob'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->setDescriptionForEvent(fn(string $eventName) => "Kin has been {$eventName}")
        ->logOnly(['name', 'email', 'mobile', 'address'])
        ->useLogName('Kin');
    }
    public function tapActivity(Activity $activity)
    {
        $activity->causer_id = auth()->user() ? auth()->id(): 0;
    }
}
