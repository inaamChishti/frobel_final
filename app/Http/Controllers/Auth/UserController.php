<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Http\Requests\Auth\UserRequest;
use App\Models\User;
use App\Models\Role;
use App\Repositories\Auth\UserRepository;
use DataTables;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function home()
    {
        return view('user.home');
    }
    public function index(Request $request)
    {

        $users = User::where('usertype', '!=', 'student')
                    ->select('id', 'username', 'password', 'email', 'usertype');

        $roles = Role::all();
        if ($request->ajax()) {
            return Datatables::of($users)
                        ->addIndexColumn()
                        ->addColumn('action', function($row){
                            // <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" title="View" class="btn btn-sm btn-success view viewButton">View </a>
                            $btn = '

                            <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" title="Edit" class="btn btn-sm btn-primary edit editButton">Edit </a>
                            <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" title="Delete" class="btn btn-sm btn-danger del deleteButton">Delete </a>
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
        return view('auth.user.index', compact('users','roles'));
    }
    public function store(UserRequest $request)
    {
        $data = $request->all();
        $data['usertype'] = $data['role'];
        unset($data['role']);
        if ($data['user_id']) {
            $user = User::find($data['user_id']);
            $user->update($data);
        } else {
            User::create($data);
        }
        return redirect()->back();
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);

        // Rename the password attribute to custom_pw
        $user->custom_pw = $user->password;
        unset($user->password);

        $roles = Role::all();

        return [
            'user' => $user,
            'roles' => $roles,
        ];
    }
    public function destroy($id)
    {

        $user = User::find($id);
        // if($user->roles->count() > 0){
        //   $user->roles()->detach();
        // }
          $user->delete();
        return response()->json([
            'message' => 'User deleted successfully.'
        ], 201);
    }
}
