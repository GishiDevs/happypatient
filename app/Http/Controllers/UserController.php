<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use DataTables;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Auth;
use App\Events\EventNotification;
use App\ActivityLog;
use App\Service;
use App\ServiceSignatory;

class UserController extends Controller
{
    public function index()
    {   
           
        $users = User::all();
        $user = User::find(Auth::user()->id);

        return view('pages.user.index', compact('users'));
    }

    public function create()
    {   
        $services = Service::all();
        $roles = Role::all();
        return view('pages.user.create', compact('roles', 'services'));
    }

    public function getuserrecord()
    {   
        
        $user = User::all();
        return DataTables::of($user)
            ->addColumn('roles',function($user){
                $roles = '';
                if(!empty($user->getRoleNames()))
                {
                    foreach($user->getRoleNames() as $role)
                    {
                        $roles = $roles . '<span class="badge bg-secondary">'.$role.'</span>';
                    }
                }
                
                return $roles;
            })
            ->addColumn('action',function($user){

                $edit = '';
                $delete = '';

                // if(Auth::user()->hasPermissionTo('user-edit'))
                // {
                //     $edit = '<a href="'.route("user.edit",$user->id).'" class="btn btn-xs btn-info" data-userid="'.$user->id.'" data-action="edit" id="btn-edit-user"><i class="fa fa-edit"></i> Edit</a>';
                // }

                $edit = '<a href="'.route("user.edit",$user->id).'" class="btn btn-xs btn-info" data-userid="'.$user->id.'" data-action="edit" id="btn-edit-user"><i class="fa fa-edit"></i> Edit</a>';

                if(Auth::user()->hasPermissionTo('user-delete'))
                {   
                    if($user->username != 'admin')
                    {
                        $delete = '<a href="" class="btn btn-xs btn-danger" data-userid="'.$user->id.'" data-action="delete" id="btn-delete-user"><i class="fa fa-trash"></i> Delete</a>';
                    }           
                }

                return $edit . ' ' . $delete;
            })
            ->addIndexColumn()
            ->rawColumns(['roles', 'action'])
            ->make();
    } 

    public function store(Request $request)
    {   
        $rules = [
            'name.required' => 'Please enter name',
            'email.email' => 'Please enter a valid email',
            'username.required' => 'Please enter username',
            'username.unique' => 'Username already exists',
            'password.min' => 'Password must be atleast 8 characters',
            'password.same' => 'Password and Confirm Password did not match'
        ];

        $valid_fields = [
            'name' => 'required|string|max:255',
            // 'email' => 'string|email|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:8|same:confirm_password',
        ];

        if($request->get('email'))
        {
            $valid_fields['email'] = 'email';
        }

        $validator = Validator::make($request->all(), $valid_fields, $rules);

        if($validator->fails())
        {   
            return response()->json($validator->errors(), 200);
        }

        $user = new User();
        $user->name = $request->get('name');
        $user->description = $request->get('description');
        $user->license = $request->get('license');
        $user->email = $request->get('email');
        $user->username = $request->get('username');
        $user->password = Hash::make($request->get('password'));
        $user->save();

        $user->assignRole($request->get('roles'));

        $services = $request->get('services');

        if($services)
        {
            for($x=0; $x < count($services); $x++)
            {
                $service_signatory = new ServiceSignatory();
                $service_signatory->userid = $user->id;
                $service_signatory->serviceid = $services[$x];
                $service_signatory->save();

            }
        }


        //PUSHER - send data/message if user is created
        event(new EventNotification('create-user', 'users'));


        //Activity Log
        $activity_log = new ActivityLog();
        $activity_log->object_id = $user->id;
        $activity_log->table_name = 'users';
        $activity_log->description = 'Create User';
        $activity_log->action = 'create';
        $activity_log->userid = auth()->user()->id;
        $activity_log->save();

        return response()->json(['success' => 'Record has successfully added'], 200);
    }

    public function edit($userid)
    {
        $user = User::find($userid);
        $service_signatories = ServiceSignatory::where('userid', $userid)->pluck('serviceid', 'serviceid')->all();
        //if record is empty then display error page
        if(empty($user->id))
        {
            return abort(404, 'Not Found');
        }
        $services = Service::all();
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        return view('pages.user.edit', compact('user', 'roles', 'userRole', 'services', 'service_signatories'));
    }

    public function update(Request $request, $userid)
    {   
        
        $rules = [
            'name.required' => 'Please enter name',
            'email.email' => 'Please enter a valid email',
            'username.required' => 'Please enter username',
            'password.min' => 'Password must be atleast 8 characters',
            'password.same' => 'Password and Confirm Password did not match'
        ];

        $valid_fields = [
            'name' => 'required|string|max:255',
        ];

        if($request->get('email'))
        {
            $valid_fields['email'] = 'email';
        }

        if(!empty($request->get('password')))
        {
            $valid_fields['password'] = 'string|min:8|same:confirm_password';
        }


        $validator = Validator::make($request->all(), $valid_fields, $rules);

        if($validator->fails())
        {   
            return response()->json($validator->errors(), 200);
        }

        $user = User::find($userid);

        //if record is empty then display error page
        if(empty($user->id))
        {
            return abort(404, 'Not Found');
        }

        $user->name = $request->get('name');
        $user->description = $request->get('description');
        $user->license = $request->get('license');
        $user->email = $request->get('email');
        if(!empty($request->get('password')))
        {
            $user->password = Hash::make($request->get('password'));
        }
        $user->save();
        
        DB::table('model_has_roles')->where('model_id',$userid)->delete();
        
        $user->assignRole($request->get('roles'));

        //PUSHER - send data/message if user is updated
        event(new EventNotification('edit-user', 'users'));

        $services = $request->get('services');

        if($services)
        {   
            ServiceSignatory::where('userid', $userid)
                            ->whereNotIn('serviceid', $services)
                            ->delete();

            for($x=0; $x < count($services); $x++)
            {   
                
                $signatory_exists = ServiceSignatory::where('userid', $userid)
                                ->where('serviceid', $services[$x])
                                ->first();

                if(!$signatory_exists)
                {
                    $service_signatory = new ServiceSignatory();
                    $service_signatory->userid = $user->id;
                    $service_signatory->serviceid = $services[$x];
                    $service_signatory->save();
                }
                

            }
            
        }
        else
        {   
            ServiceSignatory::where('userid', $userid)
                            ->delete();
        }

        //Activity Log
        $activity_log = new ActivityLog();
        $activity_log->object_id = $user->id;
        $activity_log->table_name = 'users';
        $activity_log->description = 'Update User';
        $activity_log->action = 'update';
        $activity_log->userid = auth()->user()->id;
        $activity_log->save();

        return redirect('/user/index');
    }

    public function delete(Request $request)
    {
        $user = User::find($request->get('userid'));

        //if record is empty then display error page
        if(empty($user->id))
        {
            return abort(404, 'Not Found');
        }

        if($user->username == 'admin')
        {
            return abort(403, 'Forbidden');
        }

        $user->delete();

        //PUSHER - send data/message if user is deleted
        event(new EventNotification('delete-user', 'users'));

        //Activity Log
        $activity_log = new ActivityLog();
        $activity_log->object_id = $user->id;
        $activity_log->table_name = 'users';
        $activity_log->description = 'Delete User';
        $activity_log->action = 'delete';
        $activity_log->userid = auth()->user()->id;
        $activity_log->save();

        return response()->json(['success' => 'Record has been deleted'], 200);
    }
}
