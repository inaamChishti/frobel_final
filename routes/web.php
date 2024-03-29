<?php

use App\Http\Controllers\Auth\AdmissionController;
use App\Http\Controllers\Auth\AttendanceController;
use App\Http\Controllers\Auth\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PaymentController;
use App\Http\Controllers\Auth\RoleController;
use App\Http\Controllers\Auth\StudentController;
use App\Http\Controllers\Auth\StudentTestController;
use App\Http\Controllers\Auth\SubjectController;
use App\Http\Controllers\Auth\SystemLogController;
use App\Http\Controllers\Auth\TimeTableController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NoteController;
use App\Models\User;
use App\Models\Guardian;
use App\Models\Student;
use App\Models\Admission;
use App\Http\Controllers\ParentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('auth.login');
});
Route::get('/rec', function () {
    return view('reports.receipt');

});
Route::get('/logout', function () {
    Auth::logout();

});


Route::middleware(['auth'])->prefix('parent')->group(function () {
    Route::get('view-attendance', [ParentController::class, 'viewAttendance'])->name('view.attendance');
    Route::get('view-tests', [ParentController::class, 'viewTests'])->name('view.tests');

});


Route::get('/oneTimeJob', function () {
    ini_set('max_execution_time', 360000);

    $studentDataForActiveFamilies = DB::table('studentdata')
    ->join(
        DB::raw('(SELECT admissionid, MIN(studentid) as min_studentid FROM studentdata WHERE admissionid IN (SELECT familyno FROM admission WHERE familystatus = "Active") GROUP BY admissionid) as sub'),
        function ($join) {
            $join->on('studentdata.admissionid', '=', 'sub.admissionid')
                ->on('studentdata.studentid', '=', 'sub.min_studentid');
        }
    )
    ->select('studentdata.*')
    ->get();

    $resultCollection = collect();

    foreach ($studentDataForActiveFamilies as $student) {
        $guardians = Guardian::where('Guardianid', $student->guardianid)->select('Guardianid', 'guardiantel')->first();

        if ($guardians) {
            $resultCollection->push([
                'guardianid' => $guardians->Guardianid,
                'guardiantel' => $guardians->guardiantel,
                'family_id' => $student->admissionid,
            ]);
        }
    }

    foreach ($resultCollection as $result) {
        $guardiantel = strpos($result['guardiantel'], '.com') !== false ? $result['guardiantel'] : 'noemail@mail.com';
        $isSent = $guardiantel === 'noemail@mail.com' ? 1 : 0;

        DB::table('email_job')->insert([
            'guardianid' => $result['guardianid'],
            'guardiantel' => $guardiantel,
            'family_id' => $result['family_id'],
            'is_sent' => $isSent,
        ]);
    }

    $insertedData = DB::table('email_job')->get();

    dd($insertedData);


});


Route::get('/secondJob', function () {
    ini_set('max_execution_time', 36000000);

    $insertedData = DB::table('email_job')
        ->where('guardiantel', '<>', 'noemail@mail.com')
        ->where('is_sent', 0)
        ->get();

    foreach ($insertedData as $record) {
        $password = 'fobel' . str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

        $user = new User();
        $user->username = $record->family_id; // Assuming 'family_id' should be used as the username
        $user->password = $password; // Hash the password for security

        $user->email = $record->guardiantel;
        $user->usertype = 'student';
        $user->save();

        if ($user->email != 'noemail@mail.com') {
            $loginUrl = 'https://frobelschoolsystemnew.frobel.co.uk/login';

            $data = [
                'user' => $user,
                'password' => $password,
                'loginUrl' => $loginUrl,
            ];

            // Send email using Laravel Mail with inline Blade template
            Mail::send('emails.login-email', $data, function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Frobel School System - Login Credentials')
                        ->embed(public_path('img/FrobelEducationWhite (1).png'), ['as' => 'logo', 'mime' => 'image/png']);
            });


        }

        // Update 'is_sent' to 1 for the processed record
        // DB::table('email_job')->where('id', $record->id)->update(['is_sent' => 1]);
    }

    dd('Processing complete');
});


Auth::routes([
    // 'register' => false
]);


Route::post('custom-login', [LoginController::class, 'custom_login'])->name('custom.login');

// Custom routes
Route::middleware(['auth'])->prefix('admin')->as('admin.')->group(function(){



    // {{ route('admin.teacher.roster') }}
    Route::get('teacher/roster', [AdmissionController::class, 'teacherRoster'])->name('teacher.roster');
    Route::post('teacher/roster/store', [AdmissionController::class, 'teacherRosterStore'])->name('teacher.roster.store');
    Route::get('teacher/roster/delete/{id}', [AdmissionController::class, 'deleteRoster'])->name('teacher.roster.delete');
    Route::post('teacher/roster/update', [AdmissionController::class, 'updateRoster']);

    // Roles routes
    Route::get('roles', [RoleController::class, 'index'])->name('role.index');
    Route::post('roles', [RoleController::class, 'store'])->name('role.store');
    Route::post('role/update', [RoleController::class, 'update'])->name('role.update');
    Route::get('roles/{id}/edit', [RoleController::class, 'edit'])->name('role.edit');
    Route::delete('roles/delete/{id}', [RoleController::class, 'destroy'])->name('role.destroy');

     // Admission routes
    Route::middleware('StudentFee')->group(function() {
        Route::get('payments/create', [PaymentController::class, 'create'])->name('payment.create');
        Route::post('payments/store', [PaymentController::class, 'store'])->name('payment.store');
        Route::get('payments/show', [PaymentController::class, 'show'])->name('payment.show');
        Route::get('old/payments', [PaymentController::class, 'oldPayments'])->name('payment.old');
        Route::get('old/payments/find', [PaymentController::class, 'findExistingSystemPayments'])->name('payment.old.find');
        Route::delete('PrevDelete/{id}',[PaymentController::class, 'PrevDelete']);
        Route::get('pdfGenerate/{id}',[PaymentController::class, 'pdfGenerate']);

        // previous payments
        Route::get('previous/payments', [PaymentController::class, 'previousPaymentForm'])->name('payment.previous');
        Route::get('previous/payments/show', [PaymentController::class, 'previousPaymentShow'])->name('payment.previous.show');

        //payment/exports
        Route::get('payments/export', [PaymentController::class, 'paymentExportForm'])->name('payment.export');
        Route::get('payments/export/view', [PaymentController::class, 'showExportPayments'])->name('payment.export.show');
        Route::get('defaulter/list', [PaymentController::class, 'defaulterList'])->name('defaulter.list');



        // Payment Logs
        Route::get('payments/logs', [PaymentController::class, 'paymentLogForm'])->name('payment.log.form');
        Route::get('payments/logs/show', [PaymentController::class, 'paymentLogShow'])->name('payment.log.show');

        //export
        Route::get('old/payments/export', [PaymentController::class, 'exportPayments'])->name('payment.old.export');
    });

    Route::middleware('TimeTable')->group(function() {
            Route::get('timetables', [TimeTableController::class, 'index'])->name('timetable.index');
            Route::post('timetables/store', [TimeTableController::class, 'store'])->name('timetable.store');
            Route::delete('timetables/delete/{id}', [TimeTableController::class, 'destroy'])->name('timetable.destroy');
            Route::get('timetables/view', [TimeTableController::class, 'view'])->name('timetable.view');
    });
    Route::middleware('Attendance')->group(function() {
            Route::get('attendances', [AttendanceController::class, 'index'])->name('attendance.index');
            Route::get('attendances/search', [AttendanceController::class, 'search'])->name('attendance.search');
            Route::post('attendances', [AttendanceController::class, 'store'])->name('attendance.store');
            Route::get('attendances/view', [AttendanceController::class, 'view'])->name('attendance.view');
            Route::get('attendances/viewz', [AttendanceController::class, 'viewz'])->name('attendance.viewz');
            Route::get('attendances/show', [AttendanceController::class, 'show'])->name('attendance.show');
    });

    // General Search routes
    Route::post('search/family', [TimeTableController::class, 'findStudents'])->name('search.family');
    Route::get('search/subject', [AttendanceController::class, 'findSubjects'])->name('search.subject');



    Route::middleware('isSuperAdmin')->group(function(){
        Route::get('users', [UserController::class, 'index'])->name('user.index');
        Route::post('users', [UserController::class, 'store'])->name('user.store');
        Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::delete('users/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    });

    Route::middleware('isAdmin')->group(function() {
        // home route for admin and super admin as well as.
        Route::get('home', [HomeController::class, 'index'])->name('home');

        Route::get('admissions', [AdmissionController::class, 'index'])->name('admission.index');
        Route::get('getadmissions', [AdmissionController::class, 'getadmissions'])->name('admission.getadmissions');
        Route::post('admissions', [AdmissionController::class, 'store'])->name('admission.store');
        Route::get('admissions/create', [AdmissionController::class, 'create'])->name('admission.create');
        Route::get('admissions/{id}/edit', [AdmissionController::class, 'edit'])->name('admission.edit');
        Route::post('admissions/search', [AdmissionController::class, 'search'])->name('admission.search');
        Route::get('admissions/{id}/show', [AdmissionController::class, 'show'])->name('admission.show');
        Route::post('admissions/update', [AdmissionController::class, 'update'])->name('admission.update');
        Route::post('admissions/destroy', [AdmissionController::class, 'destroy'])->name('admission.destroy');

        // Teacher Comments
        Route::get('teacher/comment', [CommentController::class, 'index'])->name('comment.index');
        Route::post('teacher/comment', [CommentController::class, 'store'])->name('comment.store');
        Route::get('teacher/commentdestroy/{id}', [StudentTestController::class, 'commentdestroy']);
        Route::get('teacher/getcomments', [StudentTestController::class, 'getcomments']);
        Route::post('teacher/commentstore', [StudentTestController::class, 'commentstore']);
        Route::get('teacher/getStudents', [StudentTestController::class, 'getStudents']);


        // Student Tests


        Route::get('student/tests', [StudentTestController::class, 'index'])->name('student.test.index');
        Route::get('student/tests/create', [StudentTestController::class, 'create'])->name('student.test.create');
        Route::post('student/tests', [StudentTestController::class, 'import'])->name('student-test.import');
        Route::post('download-sample-sheet', [StudentTestController::class, 'downloadSampleSheet'])->name('download.sample.sheet');
        Route::get('student/tests/manual/create', [StudentTestController::class, 'openManualCreatePage'])->name('student.test.manual.create');
        Route::post('student/tests/manual/store', [StudentTestController::class, 'storeManualTest'])->name('student.test.manual.store');

        Route::get('logs', [SystemLogController::class, 'systemLogs'])->name('system.log');
        Route::get('logs/show', [SystemLogController::class, 'showSystemLogs'])->name('system.log.show');

    });


});

// general user urls
Route::middleware('auth')->group(function() {
    Route::get('user/home', [UserController::class, 'home'])->name('user.home');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('users/note', [NoteController::class, 'index'])->name('user.note.index');
    Route::post('users/note/store', [NoteController::class, 'store'])->name('user.note.store');
    Route::delete('users/note/delete/{id}', [NoteController::class, 'destroy'])->name('user.note.delete');

    Route::post('get-students/{family_id}', [StudentController::class, 'getFamilyStudents'])->name('get-family-students');

    Route::get('teacher/report', [SubjectController::class, 'teacherReport'])->name('teacher.report');

    Route::resource('subjects', SubjectController::class)->except('create', 'show', 'update');
    Route::get('student/report',[CommentController::class,'reports'])->name('student.report');
    Route::get('getReport',[CommentController::class,'getReport']);
    Route::get('getMedicalReport',[CommentController::class,'getMedicalReport']);
    Route::get('getfamilyReport/{id}',[CommentController::class,'getfamilyReport']);
    Route::get('student/ActiveInactive',[CommentController::class,'ActiveInactive'])->name('student.ActiveInactive');
    Route::get('student/logins',[CommentController::class,'logins'])->name('student.logins');



});


Route::post('fetchIndividual', [TimeTableController::class, 'fetchIndividual'])->name('fetchIndividual');
Route::get('getTeacherName/{name}', [TimeTableController::class, 'getTeacherName'])->name('getTeacherName');
Route::get('resetTimetable/{id}', [TimeTableController::class, 'resetTimetable'])->name('resetTimetable');
Route::post('getTeacherSchedule', [TimeTableController::class, 'getTeacherSchedule'])->name('getTeacherSchedule');
Route::post('getSubjectSchedule',[TimeTableController::class, 'getSubjectSchedule'])->name('getSubjectSchedule');
Route::get('getDefaulterList', [TimeTableController::class, 'getDefaulterList'])->name('getDefaulterList');
Route::get('get-active-inactive', [TimeTableController::class, 'getActiveInactive'])->name('getActiveInactive');
Route::get('getIndividualReceipt/{id}',[TimeTableController::class, 'getIndividualReceipt'])->name('getIndividualReceipt');
Route::get('resetWholeTimetable',[TimeTableController::class, 'resetWholeTimetable'])->name('resetWholeTimetable');

Route::get('/insert-record', function () {
    return view('testing.index');
});

Route::post('/upload', [TimeTableController::class, 'upload'])->name('upload');
