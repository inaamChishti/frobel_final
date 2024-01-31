<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Admission\UpdateRequest;
use App\Http\Requests\Auth\AdmissionRequest;
use App\Models\Admission;
use App\Models\Guardian;
use App\Models\Kin;
use App\Models\Payment;
use App\Models\User;
use App\Models\Student;
use App\Models\TimeTable;
use App\Models\Subject;
use App\Models\medical_condition;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Support\Facades\Mail;

use function GuzzleHttp\Promise\all;

class AdmissionController extends Controller
{
    public function index(Request $request)
    {

        $students = Student::select('id', 'name', 'surname', 'dob', 'gender', 'years_in_school', 'hours', 'admission_id', 'created_at');

        // if ($request->ajax()) {
        //     return Datatables::of($students)
        //         ->addIndexColumn()
        //         ->addColumn('action', function($row){
        //             // <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" title="View" class="btn btn-sm btn-success view viewButton">View </a>
        //             $btn = '

        //               <div class="btn-group">
        //                 <a href="'.route('admin.admission.show', $row->id).'" data-toggle="tooltip"  data-id="'.$row->id.'" title="View" class="btn btn-sm btn-success view viewButton  ml-1">View </a>
        //                 <a href="'.route('admin.admission.edit', $row->id).'" data-toggle="tooltip"  data-id="'.$row->id.'" title="Edit" class="btn btn-sm btn-primary edit editButton  ml-1">Edit </a>
        //                 <form method="POST" action="'.route('admin.admission.destroy').'">
        //                     <input type="hidden" name="_token" value="'. csrf_token() .'">
        //                     <input type="hidden" name="student_id" value="'.$row->id.'">
        //                     <button class="btn btn-sm btn-danger del deleteButton ml-1">Delete</button>
        //                 </form>
        //               </div>

        //                 ';
        //             return $btn;

        //         })
        //         ->addColumn('dob', function($row){
        //             $dob = null;
        //             if($row->dob != null) {
        //                 if($row->dob != '//') {
        //                     $dob = date('d-m-Y', strtotime(str_replace('/', '-', $row->dob)));
        //                     return $dob;
        //                 }
        //             }
        //             return $row->dob;
        //         })
        //         ->addColumn('created_at', function($row){
        //             if(! $row->created_at){
        //                 return '';
        //             }
        //             else
        //             {
        //                 return $row->created_at->diffForHumans();
        //             }
        //         })
        //         ->rawColumns(['action'])
        //         ->make(true);
        // }
        return view('auth.admission.index');
    }
    public function getadmissions(Request $request)
    {
        $keyword = $request->search;
        if ($request->option == 'student_name') {

            $students =  Student::where(function ($query) use ($keyword) {
                $query->where('studentname', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('studentsur', 'LIKE', '%' . $keyword . '%');
            })->get();
                // dd($students);

        }

        if ($request->option == 'parent_name') {
            $parents = Guardian::where(function ($query) use ($keyword) {
                $query->where('guardianname', 'LIKE', '%' . $keyword . '%');
                //   ->orWhere('surname', 'LIKE', '%'.$keyword.'%');
            })->pluck('Guardianid');
            $students = Student::whereIn('guardianid', $parents)->get();
        }
        if ($request->option == 'phone') {
            $parents = Guardian::where('guardianmob', $keyword)->orWhere('guardiantel', $keyword)->pluck('Guardianid');
            $students = Student::whereIn('guardianid', $parents)->get();
        }
        if ($request->option == 'postCode') {
            $parents = Guardian::where('postal_code', $keyword)->pluck('Guardianid');
            $students = Student::whereIn('guardian_id', $parents)->get();
        }
        if ($request->option == 'family_id') {
            $students = Student::where('admissionid', $request->search)->get();
        }
            // dd('');
        return view('auth.admission.index', compact('students'));
    }
    public function create(Request $request)
    {
        $studentFamilyIdd = Admission::orderBy('admissionid', 'desc')->first();
        $studentFamilyId = $studentFamilyIdd->familyno;

        $family_id = 0;

        if (!$studentFamilyId) {
            $family_id = 1;
        } else {
            $family_id = $studentFamilyId + 1;
        }
        $student = Admission::where('familyno', $family_id)->first();

        if ($student) {
            return view('auth.admission.create')->withErrors([
                'message' => "Family Id already exists. You can't add any students",
            ]);
        } else {
            return view('auth.admission.create', compact('family_id'));
        }
    }
    public function store(AdmissionRequest $request)
    {
        // dd($request->family_id,$request->guardian_email);

        try {
            DB::transaction(function () use ($request) {
                $family_id =  $request->family_id;
                $family_status = $request->family_status;
                $joining_date = $request->joining_date;
                $studentData = array();
                $hours = json_decode($request->hourz[0], true);

                $guardianData = Guardian::create([
                    'guardianname' => $request->guardian_name,
                    'guardianaddress' => $request->guardian_address,
                    'guardiantel' => $request->guardian_email,
                    'guardianmob' => $request->guardian_mobile,

                ]);

                $kinDetails = Kin::create([
                    'kinname' => $request->kin_name,
                    'kinaddress' => $request->kin_address,
                    'kintel' => $request->kin_email,
                    'kinmob' => $request->kin_mobile,
                ]);

                $admission = new Admission();
                $admission->familyno = $request['family_id'];
                $admission->formfilingdate = date('Y-m-d', strtotime(str_replace('/', '-', $request['form_date'])));
                $admission->joiningdate = date('Y-m-d', strtotime(str_replace('/', '-', $request['joining_date'])));
                $admission->medicalcondition = $request['medical_condition'];
                $admission->feedetail = $request['fee_detail'];
                $admission->familystatus = $request['family_status'];
                $admission->payment_method = $request['payment_method'];
                $admission->add_comment = $request['add_comment'];
                $admission->save();

                $admission_id = $admission->admissionid;
                $kin_id = $kinDetails->kinid;
                $guardian_id = $guardianData->Guardianid;

                $hours = json_decode($request->hourz[0], true) ?? [];
                $firstNames = $request['first_name'] ?? [];
                $surnames = $request['surname'] ?? [];
                $dobs = $request['dob'] ?? [];
                $genders = $request['gender'] ?? [];
                $yearsInSchool = $request['years_in_school'] ?? [];
                $studentStatuses = $request['student_status'] ?? [];

                $count = count($firstNames);
                $studentIds = [];
                $studentName = [];
                $doctorNames = $request['doctor_name'] ?? [];
                $doctorNumbers = $request['doctor_number'] ?? [];
                $medicalAddresses = $request['maddress'] ?? [];

                for ($i = 0; $i < $count; $i++) {
                    $student = Student::create([
                        'student_status' => $studentStatuses[$i] ?? null,
                        'studentname' => $firstNames[$i] ?? null,
                        'studentsur' => $surnames[$i] ?? null,
                        'studentdob' => date('Y-m-d', strtotime(str_replace('/', '-', $dobs[$i] ?? ''))),
                        'studentgender' => $genders[$i] ?? null,
                        'studenthours' => $hours[$i] ?? null,
                        'studentyearinschool' => $yearsInSchool[$i] ?? null,
                        'admissionid' => $family_id,
                        'kinid' => $kin_id,
                        'guardianid' => $guardian_id,
                        'medical_condition' => ($doctorNames[$i] !== null && $doctorNumbers[$i] !== null && $doctorNames[$i] !== '' && $doctorNumbers[$i] !== '') ? 1 : null,
                    ]);
                    $studentIds[] = $student->studentid;
                    $studentName[] = $firstNames[$i].' '.$surnames[$i];

                }



                $count = count($doctorNames);

                for ($i = 0; $i < $count; $i++) {
                    medical_condition::create([
                        'guardianid' => $guardian_id,
                        'family_id' => $family_id,
                        'student_id' => $studentIds[$i],
                        'drName' => $doctorNames[$i] ?? null,
                        'drNumber' => $doctorNumbers[$i] ?? null,
                        'medicalDetails' => $medicalAddresses[$i] ?? null,
                    ]);
                }

                foreach ($studentName as $studentNamez) {
                    // Create records for each day of the week
                    for ($dayIndex = 0; $dayIndex < 7; $dayIndex++) {
                        $day = strtoupper(date('l', strtotime("Sunday +{$dayIndex} days"))); // Get day name (Monday to Sunday)

                        // Create a new record in the TimeTable model
                        TimeTable::create([
                            'studentname' => $studentNamez,
                            'admissionid' => $request->family_id, // You may need to adjust this based on your requirements
                            'day' => $day,
                            // Add other required fields
                        ]);
                    }
                }

            });

            // $user = new User;
            // $user->username = $request->family_id;
            // $user->email = $request->guardian_email;
            // $randomPassword = 'frobel' . rand(1000, 9999);
            // $user->password = $randomPassword;
            // $user->usertype = 'student';
            // $user->save();

            // $loginUrl = 'https://frobelschoolsystemnew.frobel.co.uk/login';
            // $subject = 'Welcome to Frobel School System - Your Login Credentials';
            // $mailContent = "<p>Dear Parent,</p>";
            // $mailContent .= "<p>We are delighted to welcome you to Frobel School System.</p>";
            // $mailContent .= "<p>Your login credentials for accessing details about your child are as follows:</p>";
            // $mailContent .= "<p><strong>Username:</strong> $user->username</p>";
            // $mailContent .= "<p><strong>Password:</strong> $randomPassword</p>";
            // $mailContent .= "<p>Please click the following button to log in:</p>";
            // $mailContent .= "<a href='$loginUrl'><button style='padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;'>Login Now</button></a>";
            // $mailContent .= "<p>If you have any questions or concerns, feel free to contact our support team.</p>";
            // $mailContent .= "<p>Best regards,<br>Frobel School System</p>";
            // Mail::to($user->email)->send(['html' => $mailContent])->subject($subject);

        } catch (\Exception $e) {
            dd($e);
        }

        session()->flash('alert-success', 'Students registered successfully.');

        return redirect()->route('admin.admission.index');
    }
    public function edit($student_id)
    {
        //dd($student_id);
        $student = Student::with('guardian', 'kin', 'admission')->where('studentid', $student_id)
            ->firstOrFail();
        @$admission = Admission::where('familyno', @$student->admissionid)->first();
        @$payment = Payment::where('paymentfamilyid', @$admission->guardianid)->first();
        @$guardianData = Guardian::where('Guardianid', @$student->guardianid)->first();
        @$kinDetails = Kin::where('kinid', @$student->kinid)->first();
        @$medicalCondition = medical_condition::where('student_id', @$student_id)->first();
        // dd($medicalCondition,$student_id);

        if ($payment) {
            $package = $payment->package;
            $payment_method = $payment->payment_method;
            $paid = $payment->paid;
            $comment = $payment->comment;
            $paid_up_to_date = $payment->paymentto;
            $payment_id = $payment->paymentid;
            // $initial_payment = $payment->initial_payment;
        } else {
            // $initial_payment = null;
            $package = null;
            $payment_method = null;
            $paid = null;
            $comment = null;
            $paid_up_to_date = null;
            $payment_id = null;
        }

        $medical_info = null;
        $hour =  $student->hours;

        return view('auth.admission.edit', compact('medicalCondition', 'admission', 'payment', 'medical_info', 'hour', 'student', 'package', 'payment_method', 'paid', 'paid_up_to_date', 'comment', 'payment_id', 'admission', 'guardianData', 'kinDetails'));
    }
    public function update(UpdateRequest $request)
    {
        // dd($request->all(),$request->student_status[0]);


        $updatedRows = TimeTable::where('admissionid', $request->family_id)
        ->where('studentname', 'LIKE', '%' . $request->old_name_first . '%')
        ->update([
            'studentname' => $request->first_name_1[0] . ' ' . $request->surname_1[0],
        ]);

        $admission = Admission::where('admissionid', $request->admission_id)->update([
            'formfilingdate' => date('Y-m-d', strtotime(str_replace('/', '-', $request->form_date))),
            'joiningdate' => date('Y-m-d', strtotime(str_replace('/', '-', $request->joining_date))),
            'medicalcondition' => $request->medical_condition,
            'feedetail' => $request->fee_detail,
            'familystatus' => $request->family_status,
            'payment_method' => $request->payment_method,
            'add_comment' => $request->add_comment
        ]);

        $student = Student::where('studentid', $request->student_id)->update([
            'student_status' => $request->student_status[0],
            'studentname' => $request->first_name_1[0],
            'studentsur' => $request->surname_1[0],
            'studentdob' =>  date('Y-m-d', strtotime(str_replace('/', '-', $request->dob_1[0]))),
            'studentgender' => $request->gender_1[0],
            'studenthours' => $request->hours[0],
            'studentyearinschool' => $request->years_in_school_1[0],
            'medical_condition' => ($request->msurname !== null && $request->mfirst_name !== null && $request->msurname !== '' && $request->mfirst_name !== '') ? 1 : null,
        ]);



        $medicalCondition = medical_condition::where('student_id', @$request->student_id)->update([
            'drName' => $request->msurname,
            'drNumber' => $request->mfirst_name,
            'medicalDetails' => $request->maddress,
        ]);

        $kinDetails = Kin::where('kinid', $request->kin_id)->update([
            'kinname' => $request->kin_name,
            'kinaddress' => $request->kin_address,
            'kintel' => $request->kin_email,
            'kinmob' => $request->kin_mobile,
        ]);

        $guardianData = Guardian::where('Guardianid', @$request->guardian_id)->update([
            'guardianname' => $request->guardian_name,
            'guardianaddress' => $request->guardian_address,
            'guardiantel' => $request->guardian_email,
            'guardianmob' => $request->guardian_mobile,

        ]);


        // // create new recrods
        // $studentId = $request->input('student_id');
        $familyId = $request->input('family_id');
        $guardianId = $request->input('guardian_id');
        $studentStatuses = $request->input('student_status');
        $firstNames = $request->input('first_name_1');
        $surnames = $request->input('surname_1');
        $dobs = $request->input('dob_1');
        $genders = $request->input('gender_1');
        $hours = $request->input('hours');
        $yearsInSchools = $request->input('years_in_school_1');
        $doctorNames = $request->input('doctor_name_arr');
        $doctorNumbers = $request->input('doctor_number_arr');
        $medicalAddresses = $request->input('maddresss_arr');

        // Loop through the arrays starting from the second record
        $student_idz = [];
        for ($i = 1; $i < count($firstNames); $i++) {
            // Update student record
            $student = Student::create([
               'student_status' => $studentStatuses[$i] ?? null,
                'studentname' => $firstNames[$i] ?? null,
                'studentsur' => $surnames[$i] ?? null,
                'studentdob' => $dobs[$i] ? date('Y-m-d', strtotime(str_replace('/', '-', $dobs[$i]))) : null,
                'studentgender' => $genders[$i] ?? null,
                'studenthours' => $hours[$i] ?? null,
                'studentyearinschool' => $yearsInSchools[$i] ?? null,
                'medical_condition' => ($doctorNames[$i] !== null && $doctorNumbers[$i] !== null && $doctorNames[$i] !== '' && $doctorNumbers[$i] !== '') ? 1 : null,
                'admissionid' => $familyId,
                'kinid' => $guardianId,
                'guardianid' => $guardianId,


            ]);

            // $student_idz[] = $student->studentid;
            if ($doctorNames[$i] !== null || $doctorNumbers[$i] !== null || $medicalAddresses[$i] !== null) {
                // Create medical condition record
                $medicalCondition = medical_condition::create([
                    'guardianid' => $guardianId,
                    'family_id' => $familyId,
                    'student_id' =>  $student->studentid, // Use the null coalescing operator to handle any potential issues
                    'drName' => $doctorNames[$i],
                    'drNumber' => $doctorNumbers[$i],
                    'medicalDetails' => $medicalAddresses[$i],
                ]);
            }

            // Create medical condition record


            // Loop through the days of the week
            for ($dayIndex = 0; $dayIndex < 7; $dayIndex++) {
                $day = strtoupper(date('l', strtotime("Sunday +{$dayIndex} days")));

                // Create timetable record
                TimeTable::create([
                    'studentname' => $firstNames[$i] . ' ' . $surnames[$i],
                    'admissionid' => $familyId,
                    'day' => $day,
                    // Add other required fields
                ]);
            }

            }

            // dd($student_idz);
            // for ($i = 0; $i < count($doctorNames); $i++) {
            //     // Check if the values are not null before creating medical_condition
            //     if ($doctorNames[$i] !== null || $doctorNumbers[$i] !== null || $medicalAddresses[$i] !== null) {
            //         // Create medical condition record
            //         $medicalCondition = medical_condition::create([
            //             'guardianid' => $guardianId,
            //             'family_id' => $familyId,
            //             'student_id' => $student_idz[$i] ?? null, // Use the null coalescing operator to handle any potential issues
            //             'drName' => $doctorNames[$i],
            //             'drNumber' => $doctorNumbers[$i],
            //             'medicalDetails' => $medicalAddresses[$i],
            //         ]);
            //     }
            // }



        session()->flash('alert-success', 'Student updated successfully');

        return redirect()->route('admin.admission.index');
    }
    public function destroy(Request $request)
    {
        $student_id = $request->student_id;
        $student = Student::with('guardian', 'kin', 'admission')->findOrFail($student_id);
        if ($student) {
            $admission = Admission::where('family_id', $student->admission_id)->first();
            $guardian_id = $student->guardian->id;
            $admission_id = $admission->id;
            $admission_familyId = $admission->family_id;
            $kin_id = $student->kin->id;

            $students = Student::where('admission_id', $student->admission_id)->get();
            DB::transaction(function () use ($guardian_id, $kin_id, $admission_familyId, $student, $admission_id, $students) {
                if ($guardian_id) {
                    $students_having_familyId = Student::where('guardian_id', $guardian_id)->get();
                    if (count($students_having_familyId) > 1) {
                    } else {
                        $guardian = Guardian::findOrFail($guardian_id)->delete();
                    }
                }

                if ($admission_id) {
                    $students_having_familyId = Student::where('admission_id', $student->admission_id)->get();
                    if (count($students_having_familyId) > 1) {
                    } else {
                        $admission = Admission::findOrFail($admission_id)->delete();
                    }
                }
                // dd($payment_id);
                if (isset($students)) {
                    if (count($students) > 1) {
                    } else {
                        $payment = Payment::where('family_id', $student->admission_id)->first();
                        if ($payment) {
                            $payment->delete();
                        }
                    }
                }

                if ($kin_id) {
                    $students_having_familyId = Student::where('kin_id', $kin_id)->get();
                    if (count($students_having_familyId) > 1) {
                    } else {
                        $kin = Kin::findOrFail($kin_id)->delete();
                    }
                }
            });
        }
        if ($student_id) {
            Student::findOrFail($student_id)->delete();
        }
        session()->flash('alert-success', 'Student deleted successfully!');
        return redirect()->back();
    }
    public function show($id)
    {

        $student_id = $id;

        $student = Student::with('guardian', 'kin', 'admission')->where('studentid', $student_id)
            ->firstOrFail();


        @$guardianData = Guardian::where('Guardianid', @$student->guardianid)->first();
        @$kinDetails = Kin::where('kinid', @$student->kinid)->first();
        // dd($kinDetails);


        @$admission = Admission::where('familyno', @$student->admissionid)->first();
        // dd($student);
        $family_id = $admission->familyno;
        @$payment = Payment::where('paymentfamilyid', @$family_id)->first();
        @$paymentComment = DB::table('payment_comments')->where('family_id', @$family_id)->first();
        // dd($payment);
        if ($payment) {
            $package = $payment->package;
            $payment_method = $payment->payment_method;
            $paid = $payment->paid;
            $comment = $paymentComment->comments; //$payment->comment;
            $paid_up_to_date = $payment->paymentdate;
            $payment_id = $payment->paymentid;
        } else {
            $package = null;
            $payment_method = null;
            $paid = null;
            $comment = null;
            $paid_up_to_date = null;
            $payment_id = null;
        }

        $total_students = Student::where('admissionid', $student->admissionid)->get();

        return view('auth.admission.show', compact('kinDetails', 'guardianData', 'student', 'package', 'payment_method', 'paid', 'comment', 'paid_up_to_date', 'total_students', 'admission'));
    }
    public function teacherRoster(Request $request)
    {
        $subjects = Subject::all();
        $rosters = DB::table('teachers_subject')->get();

        return view('teacher.index',compact('subjects','rosters'));
    }

    public function teacherRosterStore(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'joining_date' => 'required|string',
            'subject' => [
                'required',
                'string',
                Rule::unique('teachers_subject')->where(function ($query) use ($request) {
                    return $query->where('teacher_name', $request->name);
                }),
            ],
        ];

        $messages = [
            'subject.unique' => 'The combination of teacher name and subject already exists.',
        ];

        $request->validate($rules, $messages);

        DB::table('teachers_subject')->insert([
            'teacher_name' => $request->name,
            'subject' => $request->subject,
            'joining_date' => $request->joining_date,
        ]);

        return redirect()->back()->with('success', 'Teacher roster added successfully!');
    }

    public function deleteRoster($id)
    {
        DB::table('teachers_subject')->where('id', $id)->delete();

        // Optionally, you can retrieve the deleted record or check if the deletion was successful
        $deletedRecord = DB::table('teachers_subject')->find($id);

        if (!$deletedRecord) {
            // Deletion successful
            return redirect()->back()->with('success', 'Roster entry deleted successfully.');
        } else {
            // Deletion failed or record still exists
            return redirect()->back()->with('error', 'Failed to delete roster entry.');
        }
    }

    public function updateRoster(Request $request)
    {
        $teacherId = $request->input('teacherId');
        $newTeacherName = $request->input('teacherName');
        $joiningDate = $request->input('joining_date');

        // Check if both "teacherName" and "joining_date" are null, then do nothing
        if ($newTeacherName === null && $joiningDate === null) {
            return redirect()->back()->with('warning', 'No updates were made.');
        }

        // Set the fields to update
        $updateFields = [];

        // Check if the teacherName is not null, then add it to the update fields
        if ($newTeacherName !== null) {
            $updateFields['teacher_name'] = $newTeacherName;
        }

        // Check if the joiningDate is not null, then add it to the update fields
        if ($joiningDate !== null) {
            $updateFields['joining_date'] = $joiningDate;
        }

        // Update the record in the "teachers_subject" table
        DB::table('teachers_subject')->where('id', $teacherId)->update($updateFields);

        return redirect()->back()->with('success', 'Roster entry updated successfully.');
    }




}
