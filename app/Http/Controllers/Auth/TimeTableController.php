<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\Student;
use App\Models\Subject;
use App\Models\TimeTable;
use App\Models\Payment;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Attendance;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Facades\Excel;


class TimeTableController extends Controller
{
    public function index(Request $request)
    {

        $subjects = Subject::select('id', 'name')->get();
        $timetables = TimeTable::select('ID', 'admissionid', 'studentname', 'day', 'subject', 'timeslot', 'teachers');

        if ($request->ajax()) {
            $timetablesData = collect($timetables)->groupBy('day');

            $tableData = [];

            foreach ($timetablesData as $day => $entries) {
                $subjectTeacher = '';
                $timeslot = '';

                foreach ($entries as $entry) {
                    $subjectTeacher .= $entry->subject . '<br>' . $entry->teachers . '<br>';
                    $timeslot .= $entry->timeslot . '<br>';
                }

                $tableData[] = [
                    'studentname' => $entries->pluck('studentname')->first(),
                    'day' => strtoupper($day),
                    'subject_teacher' => $subjectTeacher,
                    'timeslot' => $timeslot,
                    'action' => '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $entries->pluck('ID')->implode(',') . '" title="Delete" class="btn btn-sm btn-danger deleteButton">Delete</a>',
                ];
            }

            return response()->json(['data' => $tableData]);
        }

        return view('auth.timetable.index', compact('timetables', 'subjects'));

        // $subjects = Subject::select('id', 'name')->get();
        // $timetables = TimeTable::select('ID', 'admissionid' ,'studentname', 'day', 'subject', 'timeslot');
        //     if ($request->ajax()) {
        //         return Datatables::of($timetables)
        //                     ->addIndexColumn()
        //                     ->addColumn('action', function($row){
        //                         $btn = '
        //                         <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->ID.'" title="Delete" class="btn btn-sm btn-danger deleteButton">Delete </a>
        //                            ';
        //                         return $btn;
        //                     })
        //                     ->addColumn('day', function($row){
        //                         return strtoupper($row->day);
        //                     })
        //                     ->addColumn('subject', function($row){
        //                         return $row->subject;
        //                     })
        //                     ->rawColumns(['action', 'id'])
        //                     ->make(true);
        // }
        //     return view('auth.timetable.index', compact('timetables', 'subjects'));
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $day =  strtoupper($request->day);
        $student_name = $request->student_name;
        $family_id = $request->family_id;
        $teacher = $request->teacher_name;

        $timetable = TimeTable::where('admissionid', $family_id)->where('studentname', 'LIKE', '%' . $student_name . '%')->where('day', $day)->first();

        $timetableUpdate = TimeTable::where('admissionid', $family_id)
            ->where('studentname', 'LIKE', '%' . $student_name . '%')
            ->where('day', $day)
            ->update([
                'timeslot' => ($timetable->timeslot ? $timetable->timeslot . ',' : '') . ($request->time ? $request->time : ''),
                'subject' => ($timetable->subject ? $timetable->subject . ',' : '') . ($request->subject ? $request->subject : ''),
                'teachers' => ($timetable->teachers ? $timetable->teachers . ',' : '') . ($teacher ? $teacher : ''),
            ]);
        // TimeTable::create([
        //     'day' => $request->day,
        //     'timeslot' => $request->time,
        //     'subject' => $request->subject,
        //     'studentname' => $request->student_name,
        //     'admissionid' => $request->family_id
        // ]);

        return response()->json([
            'message' => 'Saved'
        ], 201);
    }
    public function findStudents(Request $request)
    {
        // dd($request->all());
        $family_id = $request->family_id;
        $students = Student::where('admissionid', $family_id)->get();
        $student_ids = array();

        foreach ($students as $student) {
            $student_ids[] = $student->admissionid;
        }

        if (count($student_ids) > 0) {
            $students = Student::whereIn('admissionid', $student_ids)->get();
            return response()->json($students);
        } else {
            return response()->json([
                'error' => 'No record found corresponding to this family.'
            ], 404);
        }
    }
    public function destroy($id)
    {
        TimeTable::findOrFail($id)->delete();
        return response()->json('success', 201);
    }
    public function view()
    {
        return view('auth.timetable.show');
    }

    public function fetchIndividual(Request $request)
    {
        $familyId = $request->input('family_id');
        $studentName = $request->input('student_name');

        $timetable = TimeTable::where('admissionid', $familyId)
            // ->where('studentname', $studentName)
            ->where('studentname', 'LIKE', '%' . $studentName . '%')
            ->get();

        return response()->json($timetable);
    }

    public function resetTimetable($id)
    {
        $timetable = TimeTable::find($id);

        if ($timetable) {
            // Update timeslot and subject columns to empty
            $timetableUpdate = TimeTable::where('ID', $id)->update([
                'timeslot' => null,
                'subject' => null,
                'teachers' => null,
            ]);

            $timetabledata = TimeTable::where('ID', $id)->first();

            // Assuming family_id and student_name are available in the $timetable record
            $family_id = $timetabledata->admissionid;
            $student_name = $timetabledata->studentname;

            return response()->json(['message' => 'Timetable reset successfully', 'family_id' => $family_id, 'student_name' => $student_name]);
        } else {
            return response()->json(['error' => 'Timetable not found'], 404);
        }
    }

    public function getTeacherName($name)
    {
        $teachers = \DB::table('teachers_subject')->where('subject', $name)->distinct()->pluck('teacher_name');
        return response()->json($teachers);
    }

    public function getTeacherSchedule(Request $request)
    {
        $searchTeacher = $request->input('teacherName');
        $currentDay = $request->input('selectedDay');

        // Build and execute the query
        $results = \DB::table('timetable')
            ->select('timeslot', 'subject', 'teachers', 'day')
            ->where('teachers', 'LIKE', "%$searchTeacher%")
            ->where('day', 'LIKE', "%$currentDay%")
            ->get();

        // Output the results
        return response()->json($results);
    }

    public function getSubjectSchedule(Request $request)
    {
        $subjectName = $request->input('subjectName');
        $currentDay = $request->input('selectedDay');

        $results = \DB::table('timetable')
            ->select('timeslot', 'subject', 'teachers', 'day')
            ->where('subject', 'LIKE', "%$subjectName%")
            ->where('day', 'LIKE', "%$currentDay%")
            ->get();

        $filteredResults = $results->map(function ($item) use ($subjectName) {
            $timeslots = explode(',', $item->timeslot);
            $subjects = explode(',', $item->subject);
            $teachers = explode(',', $item->teachers);

            // Assuming each array has the same length
            $filteredData = [];

            foreach ($timeslots as $key => $timeslot) {
                // Check if the subject exactly matches the requested subject
                if (isset($subjects[$key]) && $subjects[$key] === $subjectName) {
                    $filteredData[] = [
                        'timeslot' => $timeslot,
                        'subject' => $subjects[$key],
                        'teacher' => isset($teachers[$key]) ? $teachers[$key] : null,
                        'day' => $item->day,
                    ];
                }
            }

            return $filteredData;
        })->flatten(1);

        // Use unique to get only unique rows
        $uniqueResults = $filteredResults->unique();


        return response()->json($uniqueResults);
    }


    public function getDefaulterList()
    {

        $activeAdmissionIDs = \DB::table('admission')
            ->where('familystatus', 'Active')
            ->pluck('familyno')
            ->toArray();

        $paymentRecords = [];

        foreach ($activeAdmissionIDs as $admissionID) {
            $result = \DB::table('payment')
                ->select(
                    'paymentfamilyid',
                    \DB::raw('MAX(paymentdate) AS last_payment_date'),
                    \DB::raw('MAX(paymentto) AS payment_expiry_date'),
                    'balance'
                )
                ->where('paymentfamilyid', 'LIKE', $admissionID)
                ->where('paymentto', '<', now()) // assuming 'paymentto' is a date column
                ->groupBy('paymentfamilyid')
                ->get();

            foreach ($result as $row) {
                // Format paymentto date
                $row->payment_expiry_date = $row->payment_expiry_date; // You may want to format it using Carbon or PHP date functions
                $paymentRecords[] = $row;
            }
        }

        // Return response JSON
        return response()->json(['paymentRecords' => $paymentRecords]);
    }

    public function getActiveInactive(Request $request)
    {
        $status = $request->input('status');

        if ($status == 'active') {
            $studentData = \DB::table('studentdata')
                ->join('admission', 'studentdata.admissionid', '=', 'admission.familyno')
                ->where('admission.familystatus', '=', 'Active')
                ->select('studentdata.*', \DB::raw('"Active" as recordType'))
                ->get();

                foreach ($studentData as $student) {
                    // Check if the date is empty, null, or one of the specified values
                    $invalidDateValues = ['//', 'N/A', null, ''];

                    if (!in_array($student->studentdob, $invalidDateValues)) {
                        // Use Carbon to parse the date only if it's not empty, null, or one of the specified values
                        $student->studentdob = Carbon::parse($student->studentdob)->format('d F Y');
                    } else {
                        // If the date is invalid, you may want to set it to a default value or skip further processing
                        $student->studentdob = null; // Set to null or any other default value
                    }
                }

            return response()->json(['paymentRecords' => $studentData]);
        }

        if ($status == 'inactive') {
            $studentData = \DB::table('studentdata')
                ->join('admission', 'studentdata.admissionid', '=', 'admission.familyno')
                ->where('admission.familystatus', '=', 'De-Active')
                ->select('studentdata.*', \DB::raw('"Inactive" as recordType'))
                ->get();
                foreach ($studentData as $student) {
                    // Check if the date is empty, null, or one of the specified values
                    $invalidDateValues = ['//', 'N/A', null, ''];

                    if (!in_array($student->studentdob, $invalidDateValues)) {
                        // Use Carbon to parse the date only if it's not empty, null, or one of the specified values
                        $student->studentdob = Carbon::parse($student->studentdob)->format('d F Y');
                    } else {
                        // If the date is invalid, you may want to set it to a default value or skip further processing
                        $student->studentdob = null; // Set to null or any other default value
                    }
                }
            return response()->json(['paymentRecords' => $studentData]);
        }

    }

    public function getIndividualReceipt($id)
    {
        $latestPayment = Payment::where('paymentid', $id)

                        ->first();


                        $pdf = new Dompdf();
                        $pdf->setOptions(new Options([
                            'isPhpEnabled' => true,
                            'isRemoteEnabled' => true,
                            'isHtml5ParserEnabled' => true,
                            'margin-top' => '0mm',
                            'margin-right' => '0mm',
                            'margin-bottom' => '0mm',
                            'margin-left' => '0mm',
                        ]));
                        $date = $currentDate = Carbon::now()->format('Y-m-d');

                        $timestamp = time();
                        $rand_num = rand(10, 999);
                        $random = $timestamp . $rand_num;

                        $year = date('y');
                        $day = date('d');
                        $month = date('m');
                        $hour = date('H');
                        $minute = date('i');
                        $random = rand(0, 999);
                        $random = $year . $day . $month . $hour . $minute;

                        $from = $latestPayment->paymentfrom;
                        $to = $latestPayment->paymentto;

                        $receivedfrom = $latestPayment->paymentfamilyid;
                        $receivedto = $latestPayment->collector;


                        function numberToWords($number) {
                            $words = [
                                0 => 'zero', 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
                                7 => 'seven', 8 => 'eight', 9 => 'nine', 10 => 'ten', 11 => 'eleven', 12 => 'twelve',
                                13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen', 16 => 'sixteen', 17 => 'seventeen',
                                18 => 'eighteen', 19 => 'nineteen', 20 => 'twenty', 30 => 'thirty', 40 => 'forty',
                                50 => 'fifty', 60 => 'sixty', 70 => 'seventy', 80 => 'eighty', 90 => 'ninety'
                            ];

                            $number = str_replace(',', '', $number);
                            $number = (int) $number;

                            if ($number < 21) {
                                return $words[$number];
                            }

                            if ($number < 100) {
                                $tens = (int) ($number / 10) * 10;
                                $units = $number % 10;
                                return $words[$tens] . ($units ? '-' . $words[$units] : '');
                            }

                            if ($number < 1000) {
                                $hundreds = (int) ($number / 100);
                                $remainder = $number % 100;
                                return $words[$hundreds] . ' hundred' . ($remainder ? ' and ' . numberToWords($remainder) : '');
                            }

                            if ($number < 1000000) {
                                $thousands = (int) ($number / 1000);
                                $remainder = $number % 1000;
                                return numberToWords($thousands) . ' thousand' . ($remainder ? ' ' . numberToWords($remainder) : '');
                            }

                            if ($number < 1000000000) {
                                $millions = (int) ($number / 1000000);
                                $remainder = $number % 1000000;
                                return numberToWords($millions) . ' million' . ($remainder ? ' ' . numberToWords($remainder) : '');
                            }

                            throw 'Number is too large to convert to words';
                        }

                        $paid = $latestPayment->paid;
                        $amount_in_words = numberToWords($paid);
                        // dd($amount_in_words);
                        $feeAmount = $latestPayment->package;
                        $thisPayment = $latestPayment->paid;
                        $thisbalance = $latestPayment->balance = str_replace('-', '+', $latestPayment->balance);
                        $paymentMethod = $latestPayment->payment_method;

                        $date = date('d F Y', strtotime($latestPayment->paymentdate));
                        $from = date('d F Y', strtotime($from));
                        $to = date('d F Y', strtotime($to));

                        // $cash =  $latestPayment->payment_method == 'Cash Payment' ? 'Yes' : '';
                        // $adjustment = $latestPayment->payment_method == 'Adjustment' ? 'Yes' : '';

                        $data = ['date'=> $date,'random'=>$random,'from'=>$from,'to'=>$to,
                        'receivedfrom' => $receivedfrom,'receivedto'=>$receivedto,'amount_in_words'=>$amount_in_words,
                        'feeAmount'=>$feeAmount,'thisPayment'=>$thisPayment, 'thisbalance'=>$thisbalance,'paymentMethod'=>$paymentMethod,
                        // 'cash'=>$cash,'adjustment'=>$adjustment,
                        'paid'=>$paid,
                        ];

                        $pdf->loadHtml(view('reports.receipt', $data));
                        $pdf->render();
                        $pdfOutput = $pdf->output();

                        $pdfDataUri = 'data:application/pdf;base64,' . base64_encode($pdfOutput);

                        return response()->json(['pdfDataUri' => $pdfDataUri]);
    }

    public function resetWholeTimetable(Request $request)
    {
        $studentId1 = $request->input('studentId1');
        $studentId2 = $request->input('studentId2');

        $results = \DB::table('timetable')
            ->where('admissionid', $studentId2)
            ->where('studentname', 'like', '%' . $studentId1 . '%')
            ->update([
                'timeslot' => '',
                'subject' => '',
                'teachers' => '',
            ]);

        // Check if the update was successful
        if ($results) {
            return response()->json(['success' => true, 'message' => 'Timetable updated successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to update timetable']);
        }
    }

    public function upload(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx',
        ]);

        $file = $request->file('excel_file');

        // Load the Excel file
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();

        // Get the highest row number
        $highestRow = $sheet->getHighestRow();

        // Loop through rows and insert into the database
        for ($row = 2; $row <= $highestRow; ++$row) {
            // Check if all cells in the row are empty
            $isEmptyRow = true;
            foreach (range('A', 'J') as $column) {
                if ($sheet->getCell($column . $row)->getValue() != null) {
                    $isEmptyRow = false;
                    break;
                }
            }

            // If the row is not empty, collect data
            if (!$isEmptyRow) {
                // Assuming the columns are in the same order as in your database
                $dataToInsert[] = [
                    'family_id' => $sheet->getCell('B' . $row)->getValue(),
                    'student_name' => $sheet->getCell('C' . $row)->getValue(),
                    'student_year_in_school' => $sheet->getCell('E' . $row)->getValue(),
                    'bk_ch' => $sheet->getCell('D' . $row)->getValue(),
                    'status' => $sheet->getCell('F' . $row)->getValue(),
                    'date' => Date::excelToDateTimeObject($sheet->getCell('A' . $row)->getValue())->format('Y-m-d'),
                    'teacher_name' => $sheet->getCell('G' . $row)->getValue(),
                    'subject' => $sheet->getCell('I' . $row)->getValue(),
                    'time_slot' => $sheet->getCell('H' . $row)->getValue(),
                    'session_1' => $sheet->getCell('J' . $row)->getValue(),
                ];
            }
        }

        Attendance::insert($dataToInsert);
        dd($dataToInsert);
    }

}
