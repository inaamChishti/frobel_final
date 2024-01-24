<?php

namespace App\Http\Controllers\Auth;

use DataTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StudentTestRequest;
use App\Imports\StudentTestImport;
use App\Models\Student;
use App\Models\StudentTest;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Arr;



class StudentTestController extends Controller
{
    public function index(Request $request)
    {
        $students = Student::all();
        $student_tests = StudentTest::select('family_id', 'student_name', 'subject', 'book', 'test_no', 'attempt', 'test_date', 'percentage', 'status', 'tutor', 'tutor_updated_by');
        if ($request->ajax()) {
            return Datatables::of($student_tests)
                ->addIndexColumn()
                ->addColumn('test_date', function($row){
                    return date('d-m-Y', strtotime($row->date));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
            // dd($students);
        return view('auth.student.test.index', compact('student_tests', 'students'));
    }
    public function create()
    {
        return view('auth.student.test.create');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');

        if ($file) {
            try {
                // Specify the sheet index if your Excel file has multiple sheets
                $importedData = Excel::toArray(null, $file)[0];

                // Transform each row into a new array with the desired structure
                $dataArray = [];

                foreach ($importedData as $index => $row) {
                    // Skip the first row
                    if ($index === 0) {
                        continue;
                    }

                    // Skip empty rows
                    if (empty(array_filter($row))) {
                        continue;
                    }

                    // Check if the row has at least 10 columns
                    if (count($row) >= 10) {
                        if(!empty($row[3]))
                        {
                        $dataArray[] = [
                            'family_id' => intval($row[0] ?? null),
                            'student_name' => $row[1] ?? null,
                            'book' => $row[2] ?? null,
                            'test_no' => $row[3] ?? null,
                            'attempt' => $row[4] ?? null,
                            'test_date' => $row[5] ?? null,
                            'percentage' => is_numeric($row[6]) ? ($row[6] * 100) . '%' : null,

                            'status' => $row[7] ?? null,
                            'subject' => $row[8] ?? null,
                            'tutor' => $row[9] ?? null,
                            'tutor_updated_by' => $row[10] ?? null,
                        ];
                    }
                    }
                }

                // Insert data into the database in chunks to avoid memory issues
                $chunkSize = 100; // You can adjust this value based on your needs
                $dataArrayChunks = array_chunk($dataArray, $chunkSize);
                // dd($dataArrayChunks);

                foreach ($dataArrayChunks as $chunk) {
                    DB::table('student_tests')->insert($chunk);
                }

                $request->session()->flash('alert-success', 'Import added successfully');
            } catch (\Exception $ex) {
                dd($ex->getMessage());
                // return redirect()->back()->withErrors('Please adjust your columns in the sheet');
            }
        }

        return redirect()->back();
    }



    public function downloadSampleSheet()
    {
        $file= public_path(). "/assets/excelsheet/sample_excel_sheet.xlsx";

        $headers = array(
                'Content-Type: application/vnd.ms-excel',
                );
        return Response::download($file, 'sample_excel_sheet.xlsx', $headers);
    }

    public function openManualCreatePage()
    {
        $subjects = Subject::all();
        $students = Student::all();
        return view('auth.student.test.manual.create', compact('students', 'subjects'));
    }

    public function storeManualTest(StudentTestRequest $request)
    {
        try {
            StudentTest::create([
                'family_id' => $request->family_id,
                'student_name' => $request->student_name,
                'book' => $request->book,
                'test_no' => $request->test_no,
                'attempt' => $request->attempt,
                'date' => $request->date,
                'percentage' => $request->percentage,
                'status' => $request->status,
                'tutor' => $request->tutor,
                'updated_by' => $request->updated_by,
                'subject' => $request->subject
            ]);

            $request->session()->flash('alert-success', 'Test added successfully');
        }
        catch(\Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }

        return redirect()->back();
    }
}
