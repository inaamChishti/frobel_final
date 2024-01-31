<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use DataTables;
use App\Models\Comment;
use App\Models\Admission;
use App\Models\User;
use App\Models\Role;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Svg\Tag\Rect;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $comments = Comment::select('id', 'family_id', 'student_name', 'comment')->get();

        if ($request->ajax()) {
            return Datatables::of($comments)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $deleteUrl = url('admin/teacher/commentdestroy', $row->id);
                    $btn = '
                    <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" title="Edit" class="btn btn-sm btn-primary edit editButton">Edit </a>
                    <a href="'.$deleteUrl.'" data-toggle="tooltip"  data-id="'.$row->id.'" title="Delete" class="btn btn-sm btn-danger del deleteButton">Delete </a>
                        ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }


        return view('auth.comment.index');
    }
    public function store(CommentRequest $request)
    {
        $comment = $request->comment;
        $family_id = $request->family_id;
        $student_name = $request->student;
        $commentor = auth()->user()->name;

        try
        {
            if($family_id) {
                Comment::create([
                    'comment' => $comment,
                    'family_id' => $family_id,
                    'student_name' => $student_name,
                    'commentor' => $commentor,

                ]);

                return response()->json([
                    'message' => 'Comment saved successfully.'
                ], 201);
            }
        }
        catch(\Exception $ex){
            return response()->json([
                'message' => $ex
            ], 201);
        }


    }

    public function reports()
    {
        return view('reports.reports');
    }
    public function getReport(Request $request)
    {
        $activeStudents = Admission::where('familystatus', 'Active')->get();

        foreach ($activeStudents as $activeStudent) {
            $students = Student::where('admissionid', $activeStudent->familyno)->get();

            foreach ($students as $student) {
                // Check if studentdob is not empty or invalid before formatting
                if (!empty($student->studentdob) && Carbon::hasFormat($student->studentdob, 'Y-m-d')) {
                    $student->studentdob = Carbon::parse($student->studentdob)->format('d F Y');
                } else {
                    // Handle the case where the date is empty or invalid
                    $student->studentdob = 'N/A';
                }
            }

            $activeStudent->details = $students;
        }

        return response()->json([
            'response' => $activeStudents,
        ]);
    }


    public function getMedicalReport(Request $request)
{
    $admissionIds = Admission::where('familystatus', 'Active')->pluck('familyno');

    $studentsWithCondition = Student::where('medical_condition', 1)
        ->whereIn('admissionid', $admissionIds)
        ->get();

    // Format the studentdob column
    $studentsWithCondition->transform(function ($student) {
        $student->studentdob = Carbon::parse($student->studentdob)->format('d F Y');
        return $student;
    });

    return response()->json([
        'response' => $studentsWithCondition,
    ]);
}

public function getfamilyReport(Request $request, $id)
{
    $activeStudents = Admission::where('familyno', $id)->get();

    foreach ($activeStudents as $activeStudent) {
        $students = Student::where('admissionid', $activeStudent->familyno)->get();

        // Format the studentdob column or set to null if it's null
        $students->transform(function ($student) {
            if ($student->studentdob) {
                $student->studentdob = Carbon::parse($student->studentdob)->format('d F Y');
            } else {
                $student->studentdob = null;
            }
            return $student;
        });

        $activeStudent->details = $students;
    }

    return response()->json([
        'response' => $activeStudents,
    ]);
}
    public function ActiveInactive()
    {
      return view('reports.activeInactiveStudents');
    }

    public function logins(Request $request)
    {
        $users = User::where('usertype', 'student')->get(['id', 'username', 'password','email', 'usertype']);
        // dd($users->take(10));

        $roles = Role::all();
        if ($request->ajax()) {
            return Datatables::of($users)
                        ->addIndexColumn()
                        ->addColumn('action', function($row){
                            // <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" title="View" class="btn btn-sm btn-success view viewButton">View </a>
                            $btn = '

                            <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" title="Edit" class="btn btn-sm btn-primary edit editButton">Edit </a>

                               ';
                            return $btn;
                        })
                        // ->addColumn('id', function($row){

                        //         $roles = $row->load('roles')->roles;
                        //         if($roles->count() <= 0){
                        //             return '<span class="badge badge-pill badge-danger">No Role</span>';
                        //         }
                        //         else
                        //         {
                        //             $roleName = '';
                        //             foreach($roles as $role){
                        //                 $roleName .= ' <span class="badge badge-pill badge-primary">' .$role->name. '</span>';
                        //             }
                        //             return $roleName;
                        //         }
                        // })
                        ->addColumn('password', function($row){
                            if(! $row->password){
                                return '';
                            }
                            else
                            {
                                return $row->password;
                            }
                        })
                        ->rawColumns(['action', 'id'])
                        ->make(true);
        }

        return view('auth.student_logins.index', compact('users','roles'));
    }

}
