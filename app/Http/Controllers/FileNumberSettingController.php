<?php

namespace App\Http\Controllers;

use App\FileNumberSetting;
use Illuminate\Http\Request;
use Validator;
use DataTables;
use Auth;
use App\Events\EventNotification;
use App\ActivityLog;
use DB;

class FileNumberSettingController extends Controller
{
 
    public function index()
    {
        return view('pages.file_no_setting.index');
    }

    public function getsettings()
    {
        $settings = DB::table('services')
                     ->leftJoin('file_number_settings', 'services.id', '=', 'file_number_settings.serviceid')
                     ->select('file_number_settings.id', 'services.service', DB::raw('services.id as serviceid'), 'file_number_settings.year', 'file_number_settings.start', 'file_number_settings.end', 'file_number_settings.status')
                     ->get();

        return DataTables::of($settings)
            ->addColumn('action',function($settings){

                $edit = '';
                $delete = '';

                if(Auth::user()->can('service-edit'))
                {
                    $edit = '<a href="" class="btn btn-xs btn-info" data-serviceid="'.$settings->serviceid.'" data-action="edit" id="btn-edit-setting" data-toggle="modal" data-target="#modal-file-no-setting"><i class="fa fa-edit"></i> Edit</a>';
                }

                return $edit;
            })
            ->addIndexColumn()
            ->make();
    }


    public function edit(Request $request)
    {   
        $serviceid = $request->get('serviceid');

        $setting = DB::table('services')
                     ->leftJoin('file_number_settings', 'services.id', '=', 'file_number_settings.serviceid')
                     ->select('file_number_settings.id','services.service', DB::raw('services.id as serviceid'), 'file_number_settings.year', 'file_number_settings.start', 'file_number_settings.end', 'file_number_settings.status')
                     ->where('services.id' ,'=', $serviceid)
                     ->first();
        
        return response()->json($setting, 200);

    }

    public function update(Request $request)
    {   
        $serviceid = $request->get('serviceid');
        $settings = FileNumberSetting::all()->where('serviceid', '=', $serviceid)->count();

        if(!$settings)
        {
            $setting = new FileNumberSetting();
            $setting->serviceid = $request->get('serviceid');
            $setting->year = date('Y');
            $setting->start = sprintf('%04d', $request->get('start'));
            $setting->end = sprintf('%04d', $request->get('start'));
            $setting->status = $request->get('status');
            $setting->save();
        }
        else
        {
            FileNumberSetting::where('serviceid', '=', $serviceid)
                             ->update(['start' => sprintf('%04d', $request->get('start')), 'status' => $request->get('status')]);
           
        }

        //PUSHER - send data/message if patient services is created
        event(new EventNotification('update-file-no-setting', 'file_number_settings'));

        return response()->json(['success' => 'Record has been updated'], 200);

    }

}
