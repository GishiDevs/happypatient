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
        $roles = Role::all();
        return view('pages.user.create', compact('roles'));
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

                if(Auth::user()->hasPermissionTo('user-edit'))
                {
                    $edit = '<a href="'.route("user.edit",$user->id).'" class="btn btn-sm btn-info" data-userid="'.$user->id.'" data-action="edit" id="btn-edit-user"><i class="fa fa-edit"></i> Edit</a>';
                }

                if(Auth::user()->hasPermissionTo('user-delete'))
                {
                    $delete = '<a href="" class="btn btn-sm btn-danger" data-userid="'.$user->id.'" data-action="delete" id="btn-delete-user"><i class="fa fa-trash"></i> Delete</a>';
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

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'string|email|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:8|same:confirm_password',
        ], $rules);

        if($validator->fails())
        {   
            return response()->json($validator->errors(), 200);
        }

        $user = new User();
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->username = $request->get('username');
        $user->password = Hash::make($request->get('password'));
        $user->save();

        $user->assignRole($request->get('roles'));

        //PUSHER - send data/message if user is created
        event(new EventNotification('create-user', 'users'));

        return response()->json(['success' => 'Record has successfully added'], 200);
    }

    public function edit($userid)
    {
        $user = User::find($userid);

        //if record is empty then display error page
        if(empty($user->id))
        {
            return abort(404, 'Not Found');
        }

        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        return view('pages.user.edit', compact('user', 'roles', 'userRole'));
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
            'email' => 'string|email|max:255',
        ];
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

        $user->delete();

        //PUSHER - send data/message if user is deleted
        event(new EventNotification('delete-user', 'users'));

        return response()->json(['success' => 'Record has been deleted'], 200);
    }
}
