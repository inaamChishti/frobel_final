<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class medical_condition extends Model
{
    public $timestamps = false;

    protected $table = 'medical_condition';
    use HasFactory;
    protected $fillable = [
        'guardianid',
        'student_id',
        'family_id',
        'drName',
        'drNumber',
        'medicalDetails'];
}
