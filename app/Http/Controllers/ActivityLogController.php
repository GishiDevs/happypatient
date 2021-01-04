<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ActivityLog;
use DataTables;
use DB;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.activity_log.index');
    }

    public function getlogs()
    {
        $activity_logs = DB::table('activity_logs')
                           ->join('users', 'activity_logs.userid', '=', 'users.id')
                           ->select('activity_logs.object_id', DB::raw("DATE_FORMAT(activity_logs.created_at, '%m/%d/%Y - %H:%i')  as created_at"), 'activity_logs.table_name', 'activity_logs.description', 'activity_logs.action', 'users.username')
                           ->orderBy('activity_logs.created_at', 'Desc')
                           ->get();

        return DataTables::of($activity_logs)->addIndexColumn()->make();
    }
   
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //
    }

  
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }
}
