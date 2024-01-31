<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function getFamilyStudents($familyId)
    {

        $students = Student::where('admissionid', $familyId)->get();

        return $students;
    }
}
