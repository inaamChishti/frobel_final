<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

class Payment extends Model
{
    use HasFactory, LogsActivity;
    protected $table = 'payment';
    protected $primaryKey = 'paymentid';
    public $timestamps = false;
    protected $fillable = ['cash_payment','card_payment','adjustment','bank_transfer', 'paymentfamilyid','paymentfrom', 'paymentto', 'paymentdate','to', 'paid', 'paid_up_to_date', 'last_payment_date', 'package', 'collector', 'balance', 'comment', 'payment_method', 'payment_detail','created_at','updated_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->setDescriptionForEvent(fn(string $eventName) => "Payment has been {$eventName}")
        ->logOnly(['family_id', 'from', 'to', 'paid', 'paid_up_to_date', 'last_payment_date', 'package', 'collector', 'balance', 'comment', 'payment_method', 'payment_detail' ])
        ->useLogName('Payment');
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
