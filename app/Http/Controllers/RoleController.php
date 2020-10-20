<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DataTables;
use Validator;
use DB;
use Auth;
use App\Events\EventNotification;
use App\ActivityLog;

class RoleController extends Controller
{
    public function index()
    {   
        $roles = Role::all();
        $permissions = Permission::all();
        return view('pages.roles.index', compact('permissions'));
    }

    public function getrolerecord()
    {
        $role = Role::all();
        return DataTables::of($role)
            ->addColumn('action',function($role){

                $edit = '';
                $delete = '';

                if(Auth::user()->can('role-edit'))
                {   
                    $edit = '<a href="" class="btn btn-sm btn-info" data-roleid="'.$role->id.'" data-action="edit" id="btn-edit-role" data-toggle="modal" data-target="#modal-role"><i class="fa fa-edit"></i> Edit</a>';     
                }
                
                if(Auth::user()->can('role-delete'))
                {   
                    $delete = '<a href="" class="btn btn-sm btn-danger" data-roleid="'.$role->id.'" data-action="delete" id="btn-delete-role"><i class="fa fa-trash"></i> Delete</a>';
                    
                }
                return $edit . ' ' . $delete;
            })
            ->addIndexColumn()
            ->make();
    }


    public function create()
    {   
        $permissions = Permission::all();
        return view('pages.roles.create', compact('permissions'));
    }


    public function store(Request $request)
    {   
        
        $rules = [
            'role.required' => 'Please enter role',
            'role.unique' => 'Role already exists'
        ];

        $validator = Validator::make($request->all(),[
            'role' => 'required|unique:roles,name'
        ], $rules);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 200);
        }

        $role = new Role();
        $role->name = $request->get('role');
        $role->guard_name = 'web';
        $role->save();
        $role->syncPermissions($request->get('permission'));

        //PUSHER - send data/message if role is created
        event(new EventNotification('create-role', 'roles'));


        //Activity Log
        $activity_log = new ActivityLog();
        $activity_log->object_id = $role->id;
        $activity_log->table_name = 'roles';
        $activity_log->description = 'Create Role';
        $activity_log->action = 'create';
        $activity_log->userid = auth()->user()->id;
        $activity_log->save();

        return response()->json(['success' => 'Record has successfully added'], 200);
    }


    public function edit(Request $request)
    {   
        $roleid = $request->get('roleid');

        $role = Role::find($roleid);

        //if record is empty then display error page
        if(empty($role->id))
        {
            return abort(404, 'Not Found');
        }

        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$roleid)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
        // return view('pages.service.edit', compact('service'));
        return response()->json(['role' => $role, 'permission' => $permission, 'rolePermissions' => $rolePermissions], 200);

    }


    public function update(Request $request)
    {   

        $roleid = $request->get('roleid');

        $rules = [
            'role.required' => 'Please enter role',
            'role.unique' => 'Role already exists'
        ];

        $validator = Validator::make($request->all(),[
            'role' => 'required|unique:roles,name,'.$roleid
        ], $rules);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 200);
        }

        $role = Role::find($roleid);

        //if record is empty then display error page
        if(empty($role->id))
        {
            return abort(404, 'Not Found');
        }

        $role->name = $request->get('role');
        $role->save();

        $role->syncPermissions($request->get('permission'));

        //PUSHER - send data/message if role is updated
        event(new EventNotification('edit-role', 'roles'));


        //Activity Log
        $activity_log = new ActivityLog();
        $activity_log->object_id = $role->id;
        $activity_log->table_name = 'roles';
        $activity_log->description = 'Update Role';
        $activity_log->action = 'update';
        $activity_log->userid = auth()->user()->id;
        $activity_log->save();

        return response()->json(['success' => 'Record has been updated']);
    }


    public function delete(Request $request)
    {   
        $roleid = $request->get('roleid');
        $role = Role::find($roleid);

        //if record is empty then display error page
        if(empty($role->id))
        {
            return abort(404, 'Not Found');
        }

        if($role->name == 'Admin')
        {   
            return abort(401, 'Forbidden');
            // return response()->json(['error' => "You can't delete role Admin"], 200);
        }

        $role->delete();

        //PUSHER - send data/message if role is deleted
        event(new EventNotification('delete-role', 'roles'));

        
        //Activity Log
        $activity_log = new ActivityLog();
        $activity_log->object_id = $role->id;
        $activity_log->table_name = 'roles';
        $activity_log->description = 'Delete Role';
        $activity_log->action = 'delete';
        $activity_log->userid = auth()->user()->id;
        $activity_log->save();

        return response()->json(['success' => 'Record has been deleted'], 200);
    }
}
