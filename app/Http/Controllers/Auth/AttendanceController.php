<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\Subject;
use App\Models\TimeTable;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        $subjects = Subject::select('id', 'name')->get();
        return view('auth.attendance.index',compact('subjects'));
    }
    public function search(Request $request)
    {
        $time = $request->time;
        $date = date('Y-m-d', strtotime($request->date));
        // dd($request->all(),$date);
        $teacher = $request->teacher;
        $subject = $request->subject;
        $student = Student::where('studentname', $request->student_name)->where('admissionid', $request->stu_idd)->first();
        // dd($time,$date,$teacher,$subject ,$student);

        $existingAttendance = Attendance::where([
            'family_id' => $request->stu_idd,
            'student_name' => $student->studentname,
            'teacher_name' => $teacher,
            'subject' => $subject,
            'date' => $date,
            'time_slot' =>  $time,
        ])->first();
            // dd($existingAttendance,$student);
        // If an existing entry is found, return a 203 response
        if ($existingAttendance) {
            return response()->json(['message' => 'Attendance entry already exists'], 203);
        }


        if($student){

            $years_in_school = $student->studentyearinschool;
            $timeTable = TimeTable::where('studentname', 'like', '%' . $request->student_name . '%')
            ->where('admissionid',$request->stu_idd)
            ->first();


            // dd($timeTable,$request->student_name);

        }
        // $attendance = TimeTable::where(['student_id' => $student_id, 'subject' => $subject])->get();
        if(! $timeTable){
            return response()->json([
                'error' => 'No record found'
            ], 404);
        }
        return response()->json([
            'timetable' => $timeTable,
            'years_in_school' => $years_in_school
        ], 201);


    }
    public function store(Request $request)
    {

        $date = date('Y-m-d', strtotime($request->date));

        // try {
            // $att = Attendance::create([
            //     'family_id' => $request->family_id,
            //     'student_name' => $request->student_name,
            //     'teacher_name' => $request->teacher,
            //     'subject' => $request->subject,
            //     'time_slot' => $request->time,
            //     'session_1' => $request->session,
            //     'student_year_in_school' => $request->years_in_school,
            //     'date' => $date,
            //     'bk_ch' => $request->bk_ch,
            //     'status' => $request->status
            // ]);

            // Check if an attendance entry already exists for the given criteria
            $existingAttendance = Attendance::where([
                'family_id' => $request->family_id,
                'student_name' => $request->student_name,
                'teacher_name' => $request->teacher,
                'subject' => $request->subject,
                'date' => $date,
                'time_slot' => $request->time,
            ])->first();


            // If an existing entry is found, return a 203 response
            if ($existingAttendance) {
                return response()->json(['message' => 'Attendance entry already exists'], 203);
            }

            // If no existing entry is found, create a new one
            $att = Attendance::create([
                'family_id' => $request->family_id,
                'student_name' => $request->student_name,
                'teacher_name' => $request->teacher,
                'subject' => $request->subject,
                'time_slot' => $request->time,
                'session_1' => $request->session,
                'student_year_in_school' => $request->years_in_school,
                'date' => $date,
                'bk_ch' => $request->bk_ch,
                'status' => $request->status
            ]);

// Return a success response
return response()->json(['message' => 'Attendance entry created successfully'], 200);


        return response()->json('Success', 201);
    }
    public function viewz(Request $request)
    {
        //  dd($request->all());

        $family_id = $request->columns[0]['search']['value'];
        $selectedValue = $request->input('selectedValue');
        // $fromDate = Carbon::createFromFormat('d/m/Y', $request->input('from_date'))->format('Y-m-d');
        // $toDate = Carbon::createFromFormat('d/m/Y', $request->input('to_date'))->format('Y-m-d');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        if ($request->ajax()) {
            $query = Attendance::query();
            $query->select('id', 'family_id', 'student_name','student_year_in_school as year', 'teacher_name', 'subject', 'bk_ch', 'session_1', 'date');
            $attendances = $query->where('family_id', $family_id)
            // ->where('student_name', 'like', $selectedValue . '%')
            ->where('student_name', 'like', '%' . $selectedValue . '%')

            ->whereBetween('date', [$fromDate, $toDate])
            ->get();


            return Datatables::of($attendances)
                ->addIndexColumn()
                ->addColumn('date', function($row){
                    if(! $row->date){
                        return '';
                    }
                    else
                {
                    // $date = str_replace('/', '-', date('d-m-Y', strtotime($row->date)));
                    $date = $row->date;
                    return $date;
                }
                })
                ->rawColumns(['action'])
                ->make(true);

    }
}

    public function view(Request $request)
    {


            $fromDate = $request->from_date;
            $toDate = $request->to_date;
            $attendances = array();

            if ($request->ajax()) {

            $query = Attendance::query();
            $query->select('id', 'family_id', 'student_name', 'student_year_in_school as year', 'teacher_name', 'subject', 'bk_ch', 'session_1', 'date');

            // $attendances = $query;
            $attendances = $query->orderBy('date', 'desc');



            return Datatables::of($attendances)
                ->addIndexColumn()
                ->addColumn('date', function($row){
                    if(! $row->date){
                        return '';
                    }
                    else
                    {
                        // $date = str_replace('/', '-', date('d-m-Y', strtotime($row->date)));
                        $date = $row->date;
                        return $date;
                    }
                })
                ->rawColumns(['action'])
                ->make(true);

        }

        return view('auth.attendance.view', compact('attendances'));
    }
    public function show(Request $request)
    {
        $student_id = $request->student_id;
        $family_id = $request->family_id;

        $attendances = Attendance::where(['family_id' => $family_id, 'student_id' => $student_id])->get();

        return Datatables::of($attendances)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }
    public function findSubjects(Request $request)
    {
        // dd($request->all());
        $student_name = $request->student_name;
        $subjects = Subject::all();

        return $subjects;
    }
}
