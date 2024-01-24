<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        if(Auth::user()->usertype == 'student')
        {
            return view('auth.parent.index');
        }
        else
        {
            $engCount = Attendance::where('subject', 'English')->count();
        $scienceCount = Attendance::where('subject', 'Science')->count();
        $physicsCount = Attendance::where('subject', 'Physics')->count();
        $chemistryCount = Attendance::where('subject', 'Chemistry')->count();
        $mathematicsCount = Attendance::where('subject', 'Mathematics')->count();
        $eLanguageCount = Attendance::where('subject', 'E.Language')->count();
        $eLiteratureCount = Attendance::where('subject', 'E.Literature')->count();
        $psychologyCount = Attendance::where('subject', 'Psychology')->count();
        $businessCount = Attendance::where('subject', 'Business')->count();
        $geographyCount = Attendance::where('subject', 'Geography')->count();
        $historyCount = Attendance::where('subject', 'History')->count();
        $biologyCount = Attendance::where('subject', 'Biology')->count();
        $politicsCount = Attendance::where('subject', 'Politics')->count();
        $lawCount = Attendance::where('subject', 'Law')->count();
        $computerScienceCount = Attendance::where('subject', 'Computer Science')->count();
        // $studentz = DB::table('students')->count();
        $family_ids = Admission::where('familystatus','Active')->pluck('familyno');
        $studentz = $studentz = DB::table('studentdata')->whereIn('admissionid',$family_ids)->count();
        return view('auth.home',compact('studentz','engCount', 'scienceCount', 'physicsCount', 'chemistryCount', 'mathematicsCount', 'eLanguageCount', 'eLiteratureCount', 'psychologyCount', 'businessCount', 'geographyCount', 'historyCount', 'biologyCount', 'politicsCount', 'lawCount', 'computerScienceCount'));
        }

    }

}
