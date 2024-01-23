<?php

namespace App\Http\Controllers\Auth;
use DataTables;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class SystemLogController extends Controller
{
    public function systemLogs()
    {
        $users = User::all();
        return view('auth.log.index', compact('users'));
    }
    public function showSystemLogs(Request $request)
    {
        $users = User::all();
        $request->validate([
            'users' => 'required',
            'date' => 'required'
        ]);

        $date = date('Y-m-d', strtotime(str_replace('/', '-', $request->date)));
        $selectedUsers = $request->users;
        $allLogs = array();

        $count = 0;
        if(count($selectedUsers) > 0){
            foreach($selectedUsers as $key => $user){
                if($user == 'all'){
                    // select('id', 'log_name', 'description', 'event', 'causer_id', 'properties' ,'created_at')
                    // $allLogs = Activity::where('created_at', '>=' , $date)->select('id', 'log_name', 'description', 'event', 'causer_id', 'properties' ,'created_at')->get();
                    $allLogs = Activity::whereDate('created_at',$date)->select('id', 'log_name', 'description', 'event', 'causer_id', 'properties' ,'created_at')->get();
                    // dd($allLogs);
                    $count++;
                }
                else
                {
                    // it's checking that if all is selected will not execute else
                    if($count == 0){
                        $allLogs = Activity::whereDate('causer_id', $user)->where('created_at', '>=' , $date)->get();
                        // $allLogs = Activity::where('causer_id', $user)->where('created_at', '>=' , $date)->get();
                    }
                }
            }

        }


        return view('auth.log.index', compact('users', 'allLogs'));
    }
}
