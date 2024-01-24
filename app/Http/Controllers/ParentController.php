<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\Attendance;
use App\Models\StudentTest;
use App\Models\Student;
use Illuminate\Http\Request;
use Auth;
use DataTables;
use Illuminate\Support\Facades\DB;

class ParentController extends Controller
{
    public function viewAttendance(Request $request)
    {


        $fromDate = $request->from_date;
        $toDate = $request->to_date;
        $attendances = array();

        if ($request->ajax()) {
            $query = Attendance::where('family_id', Auth::user()->username)->select('id', 'family_id', 'student_name', 'student_year_in_school as year', 'teacher_name', 'subject', 'bk_ch', 'session_1', 'date');

            $attendances = $query->orderBy('date', 'desc')->get();

            return Datatables::of($attendances)
                ->addIndexColumn()
                ->addColumn('date', function ($row) {
                    if (!$row->date) {
                        return '';
                    } else {
                        $date = $row->date;
                        return $date;
                    }
                })
                ->rawColumns(['date'])
                ->make(true);
        }


    return view('auth.parent.index', compact('attendances'));
}

public function viewTests(Request $request)
{
    $students = Student::all();
    $student_tests = StudentTest::where('family_id', Auth::user()->username)->select('family_id', 'student_name', 'subject', 'book', 'test_no', 'attempt', 'test_date', 'percentage', 'status', 'tutor', 'tutor_updated_by');
    if ($request->ajax()) {
        return Datatables::of($student_tests)
            ->addIndexColumn()
            ->addColumn('test_date', function($row){
                return date('d-m-Y', strtotime($row->date));
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    return view('auth.parent.tests', compact('student_tests', 'students'));
}
}
