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

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('pages.user.index');
    }

    public function create()
    {   
        return view('pages.user.create');
    }

    public function getuserrecord()
    {   
        $user = User::all();
        return DataTables::of($user)
            ->addColumn('action',function($user){
                return '<a href="'.route("user.edit",$user->id).'" class="btn btn-sm btn-info" data-userid="'.$user->id.'" data-action="edit" id="btn-edit-user"><i class="fa fa-edit"></i> Edit</a>
                        <a href="" class="btn btn-sm btn-danger" data-userid="'.$user->id.'" data-action="delete" id="btn-delete-user"><i class="fa fa-trash"></i> Delete</a>';
            })
            ->make();
    } 
}
