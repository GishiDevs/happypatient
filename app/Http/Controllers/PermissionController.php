<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DataTables;
use Validator;
use Auth;
use App\Events\EventNotification;
use App\ActivityLog;

class PermissionController extends Controller
{
    public function index()
    {       
        $permissions = Permission::all();
        return view('pages.permissions.index');
    }

    public function getpermissionrecord()
    {
        $permission = Permission::all();
        return DataTables::of($permission)
            ->addColumn('action',function($permission){

                if(Auth::user()->hasRole('Admin'))
                {
                    return '<a href="" class="btn btn-xs btn-info" data-permissionid="'.$permission->id.'" data-action="edit" id="btn-edit-permission" data-toggle="modal" data-target="#modal-permission"><i class="fa fa-edit"></i> Edit</a>
                            <a href="" class="btn btn-xs btn-danger" data-permissionid="'.$permission->id.'" data-action="delete" id="btn-delete-permission"><i class="fa fa-trash"></i> Delete</a>';
                }
                
            })
            ->addIndexColumn()
            ->make();
    }


    public function create()
    {
        return view('pages.permissions.create');
    }


    public function store(Request $request)
    {   
        
        $rules = [
            'permission.required' => 'Please enter permission',
            'permission.unique' => 'Permission already exists'
        ];

        $validator = Validator::make($request->all(),[
            'permission' => 'required|unique:permissions,name'
        ], $rules);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 200);
        }

        $permission = new Permission();
        $permission->name = $request->get('permission');
        $permission->guard_name = 'web';
        $permission->save();

        //PUSHER - send data/message if permission is created
        event(new EventNotification('create-permission', 'permissions'));


        //Activity Log
        $activity_log = new ActivityLog();
        $activity_log->object_id = $permission->id;
        $activity_log->table_name = 'permissions';
        $activity_log->description = 'Create Permission';
        $activity_log->action = 'create';
        $activity_log->userid = auth()->user()->id;
        $activity_log->save();

        return response()->json(['success' => 'Record has successfully added'], 200);
    }


    public function edit(Request $request)
    {   
        $permissionid = $request->get('permissionid');

        $permission = Permission::find($permissionid);

        //if record is empty then display error page
        if(empty($permission->id))
        {
            return abort(404, 'Not Found');
        }
        
        // return view('pages.service.edit', compact('service'));
        return response()->json($permission, 200);

    }


    public function update(Request $request)
    {   

        $permissionid = $request->get('permissionid');

        $rules = [
            'permission.required' => 'Please enter permission',
            'permission.unique' => 'Permission already exists'
        ];

        $validator = Validator::make($request->all(),[
            'permission' => 'required|unique:permissions,name,'.$permissionid
        ], $rules);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 200);
        }

        $permission = Permission::find($permissionid);

        //if record is empty then display error page
        if(empty($permission->id))
        {
            return abort(404, 'Not Found');
        }

        $permission->name = $request->get('permission');
        $permission->save();

        //PUSHER - send data/message if permission is updated
        event(new EventNotification('edit-permission', 'permissions'));


        //Activity Log
        $activity_log = new ActivityLog();
        $activity_log->object_id = $permission->id;
        $activity_log->table_name = 'permissions';
        $activity_log->description = 'Update Permission';
        $activity_log->action = 'update';
        $activity_log->userid = auth()->user()->id;
        $activity_log->save();

        return response()->json(['success' => 'Record has been updated']);
    }


    public function delete(Request $request)
    {   
        $permissionid = $request->get('permissionid');
        $permission = Permission::find($permissionid);
        
        //if record is empty then display error page
        if(empty($permission->id))
        {
            return abort(404, 'Not Found');
        }

        $permission->delete();

        //PUSHER - send data/message if permission is deleted
        event(new EventNotification('delete-permission', 'permissions'));


        //Activity Log
        $activity_log = new ActivityLog();
        $activity_log->object_id = $permission->id;
        $activity_log->table_name = 'permissions';
        $activity_log->description = 'Delete Permission';
        $activity_log->action = 'delete';
        $activity_log->userid = auth()->user()->id;
        $activity_log->save();

        return response()->json(['success' => 'Record has been deleted'], 200);
    }
}
