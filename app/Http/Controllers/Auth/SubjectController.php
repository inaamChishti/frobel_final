<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Subject\CreateRequest;
use App\Models\Subject;
use App\Models\Attendance;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $subjects = Subject::all();

        if ($request->ajax()) {
            return Datatables::of($subjects)
                        ->addIndexColumn()
                        ->addColumn('action', function($row){
                            $btn = '

                            <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" title="Edit" class="btn btn-sm btn-primary edit editButton">Edit </a>
                            <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" title="Delete" class="btn btn-sm btn-danger del deleteButton">Delete </a>
                               ';
                            return $btn;
                        })

                        ->rawColumns(['action'])
                        ->make(true);
        }

        return view('auth.subjects.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $subjectId = $request->subject_id;

        if ($subjectId) {
            $subject = Subject::find($subjectId);
            $subject->update([
                'name' => $request->name
            ]);
        }
        else {
            Subject::create([
                'name' => $request->name
            ]);
        }

        return response()->json([
            'success' => 'Subject Saved Successfully'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subject = Subject::find($id);

        if (! $subject) {
            return response()->json([
                'error' => 'Record not found, Please refresh the webpage and try again, if still problem persists, contact with administrator'
            ], 404);
        }

        return $subject;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subject = Subject::find($id);

        if (! $subject) {
            return response()->json([
                'error' => 'Record not found, Please refresh the webpage and try again, if still problem persists, contact with administrator'
            ], 404);
        }

        $subject->delete();

        return response()->json([
            'success' => 'Record deleted successfully'
        ], 201);
    }

    public function teacherReport(Request $request)
    {
        // dd($request->all());
        $staffReport = null;
        if($request->report_type == 'staffReport')
        {
            $staffReport = Attendance::where('teacher_name', $request->teacher_name)
            ->whereBetween('date', [
                \Carbon\Carbon::createFromFormat('d/m/Y', $request->fromDate)->startOfDay()->toDateString(),
                \Carbon\Carbon::createFromFormat('d/m/Y', $request->toDate)->endOfDay()->toDateString(),
            ])
            ->get();
        }

        $totalTeacherCount = null;
        $attendence = null;
        $condition = false;
        $teacher = null;
        if($request->report_type == 'staffSession')
        {

            $teacher = $request->teacher_name; // Convert to uppercase
            $fromDate = Carbon::createFromFormat('d/m/Y', $request->fromDate);
            $toDate = Carbon::createFromFormat('d/m/Y', $request->toDate);
            $daysDifference = $toDate->diffInDays($fromDate);
            $dayNames = [];

            for ($i = 0; $i <= $daysDifference; $i++) {
                $dayNames[] = strtoupper($fromDate->copy()->addDays($i)->format('l')); // Convert to uppercase
            }

            // below logic is for general count

            // Search in the database
            // $result = DB::table('timetable')
            //     ->select('teachers', 'day')
            //     ->distinct() // Select distinct rows
            //     ->where(function ($query) use ($teacher, $dayNames) {
            //         $query->whereRaw('FIND_IN_SET(?, teachers)', [$teacher]) // Check if teacher is in the list
            //             ->whereIn(DB::raw('UPPER(day)'), $dayNames);
            //     })
            //     ->count();

            $result = DB::table('timetable')
                ->select('teachers', 'day')
                ->selectRaw("CAST((LENGTH(teachers) - LENGTH(REPLACE(teachers, ?, ''))) / LENGTH(?) AS SIGNED) AS teacher_count", [$teacher, $teacher])
                ->distinct() // Select distinct rows
                ->where(function ($query) use ($teacher, $dayNames) {
                    $query->whereRaw('FIND_IN_SET(?, teachers) > 0', [$teacher]) // Check if teacher is in the list
                    ->whereIn(DB::raw('UPPER(day)'), $dayNames);
                })
                ->get();

                // To get the sum of teacher counts
                $totalTeacherCount = $result->sum('teacher_count');



                $attendence = Attendance::where('teacher_name', $request->teacher_name)
                ->whereBetween('date', [
                    \Carbon\Carbon::createFromFormat('d/m/Y', $request->fromDate)->startOfDay()->toDateString(),
                    \Carbon\Carbon::createFromFormat('d/m/Y', $request->toDate)->endOfDay()->toDateString(),
                ])
                ->count();

                $condition = true;

                // dd($result,$totalTeacherCount,$attendence, $request->all(), $dayNames);
        }
        $teacherNames = \DB::table('teachers_subject')->pluck('teacher_name');
        return view('reports.teacherReport',compact('teacherNames','staffReport','totalTeacherCount','attendence','condition','teacher'));
    }
}
