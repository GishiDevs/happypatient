<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;
use Validator;
use DataTables;
use Auth;
use App\Events\EventNotification;
use App\ActivityLog;

class ServiceController extends Controller
{

    public function index()
    {       
        $services = Service::all();
        return view('pages.service.index');
    }
    public function getservicerecord()
    {
        $service = Service::all();
        return DataTables::of($service)
            ->addColumn('action',function($service){

                $edit = '';
                $delete = '';

                if(Auth::user()->can('service-edit'))
                {
                    $edit = '<a href="" class="btn btn-xs btn-info" data-serviceid="'.$service->id.'" data-action="edit" id="btn-edit-service" data-toggle="modal" data-target="#modal-service"><i class="fa fa-edit"></i> Edit</a>';
                }

                if(Auth::user()->can('service-delete'))
                {
                    $delete = '<a href="" class="btn btn-xs btn-danger" data-serviceid="'.$service->id.'" data-action="delete" id="btn-delete-service"><i class="fa fa-trash"></i> Delete</a>';
                }
                
                return $edit . ' ' . $delete;
            })
            ->addIndexColumn()
            ->make();
    }


    public function create()
    {
        return view('pages.service.create');
    }


    public function store(Request $request)
    {   
        
        $rules = [
            'service.required' => 'Please enter service',
            'service.unique' => 'Service already exists'
        ];

        $validator = Validator::make($request->all(),[
            'service' => 'required|unique:services,service'
        ], $rules);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 200);
        }

        $service = new Service();
        $service->service = $request->get('service');
        $service->status = $request->get('status');
        $service->save();

        //PUSHER - send data/message if service is created
        event(new EventNotification('create-service', 'services'));


        //Activity Log
        $activity_log = new ActivityLog();
        $activity_log->object_id = $service->id;
        $activity_log->table_name = 'services';
        $activity_log->description = 'Create Service';
        $activity_log->action = 'create';
        $activity_log->userid = auth()->user()->id;
        $activity_log->save();

        return response()->json(['success' => 'Record has successfully added', 'service' => $service], 200);
    }


    public function edit(Request $request)
    {   
        $serviceid = $request->get('serviceid');

        $service = Service::find($serviceid);

        //if record is empty then display error page
        if(empty($service->id))
        {
            return abort(404, 'Not Found');
        }
        
        // return view('pages.service.edit', compact('service'));
        return response()->json($service, 200);

    }


    public function update(Request $request)
    {   
        $serviceid = $request->get('serviceid');

        $rules = [
            'service.required' => 'Please enter service',
            'service.unique' => 'Service already exists'
        ];

        $validator = Validator::make($request->all(),[
            'service' => 'required|unique:services,service,'.$serviceid
        ], $rules);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 200);
        }

        $service = Service::find($serviceid);

        //if record is empty then display error page
        if(empty($service->id))
        {
            return abort(404, 'Not Found');
        }

        $service->service = $request->get('service');
        $service->status = $request->get('status');
        $service->save();

        //PUSHER - send data/message if service is updated
        event(new EventNotification('edit-service', 'services'));


        //Activity Log
        $activity_log = new ActivityLog();
        $activity_log->object_id = $service->id;
        $activity_log->table_name = 'services';
        $activity_log->description = 'Update Service';
        $activity_log->action = 'update';
        $activity_log->userid = auth()->user()->id;
        $activity_log->save();

        return response()->json(['success' => 'Record has been updated']);
    }


    public function delete(Request $request)
    {   
        $serviceid = $request->get('serviceid');
        $service = Service::find($serviceid);

        //if record is empty then display error page
        if(empty($service->id))
        {
            return abort(404, 'Not Found');
        }

        $service->delete();

        //PUSHER - send data/message if service is deleted
        event(new EventNotification('delete-service', 'services'));


        //Activity Log
        $activity_log = new ActivityLog();
        $activity_log->object_id = $service->id;
        $activity_log->table_name = 'services';
        $activity_log->description = 'Delete Service';
        $activity_log->action = 'delete';
        $activity_log->userid = auth()->user()->id;
        $activity_log->save();
        
        return response()->json(['success' => 'Record has been deleted'], 200);
    }
}
