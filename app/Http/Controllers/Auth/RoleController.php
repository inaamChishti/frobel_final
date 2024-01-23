<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RoleRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use DataTables;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::select('id', 'name', 'created_at');
        if ($request->ajax()) {
            return Datatables::of($roles)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" title="View" class="btn btn-sm btn-success view viewButton">View </a>
                    $btn = '

                            <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" title="Edit" class="btn btn-sm btn-primary edit editButton">Edit </a>

                               ';
                    // <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" title="Delete" class="btn btn-sm btn-danger del deleteButton">Delete </a>
                    return $btn;
                })
                ->addColumn('created_at', function ($row) {
                    if (!$row->created_at) {
                        return '';
                    } else {
                        return $row->created_at->diffForHumans();
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('auth.role.index', compact('roles'));
    }
    public function store(RoleRequest $request)
    {

        $role = $request->name;
        $roleId = $request->role_id;

        $role = Role::where('name', $role)->first();
        if ($role) {
            return redirect()->back()->withErrors(['error' => 'Role already exists.']);
        } else {
            $storeRole =  Role::create(['name' => $request->name]);
            if ($storeRole) {
                return redirect()->back()->withErrors(['success' => 'Role created successfully']);
            } else {
                dd('error');
            }
        }

        // if($roleId){
        //     $role = Role::where('name',$role)->where('id', '!=' ,$role)->first();

        //     if($role == null){
        //             $role = Role::findOrFail($roleId);
        //             if($role->id == $roleId){

        //                 $role->update([
        //                     'name' => $request->name
        //                 ]);
        //             }
        //     }else
        //     {
        //         return response()->json([
        //             'message' => 'Role already exists.'
        //         ], 422);
        //     }
        // }
        // else{
        //     $existing_role = Role::where('name', $role)->first();

        //     if($existing_role){
        //         return response()->json([
        //             'message' => 'Role already exists.'
        //         ], 422);
        //     }
        //     else{
        //         Role::create([
        //             'name' => $request->name
        //         ]);
        //     }
        // }

        return response()->json([
            'message' => 'Role saved successfully.'
        ], 201);
    }
    public function edit($id)
    {

        $role = Role::findOrFail($id);
        return response()->json($role);
    }
    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        if ($role->users->count('role_id') > 0) {
            return response()->json([
                'message' => 'You can not delete the role, because role have some user.'
            ], 403);
        } else {
            $role->delete();
            return response()->json([
                'message' => 'User deleted'
            ], 201);
        }
    }

    public function update(Request $request)
    {
        $role = Role::find($request->editable);

        if ($role) {
            $role->name = $request->name;
            $role->save();
            return redirect()->back()->withErrors(['success' => 'Role updated successfully.']);
        } else {
            return redirect()->back()->withErrors(['error' => 'Role not found.']);
        }
    }


}
