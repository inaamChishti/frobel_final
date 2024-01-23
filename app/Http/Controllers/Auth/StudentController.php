<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function getFamilyStudents($familyId)
    {
        $students = Student::where('admission_id', $familyId)->get();
        return $students;
    }
}
