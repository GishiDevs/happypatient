<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;
use Validator;
use DataTables;
use Auth;

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
                    $edit = '<a href="" class="btn btn-sm btn-info" data-serviceid="'.$service->id.'" data-action="edit" id="btn-edit-service" data-toggle="modal" data-target="#modal-service"><i class="fa fa-edit"></i> Edit</a>';
                }

                if(Auth::user()->can('service-delete'))
                {
                    $delete = '<a href="" class="btn btn-sm btn-danger" data-serviceid="'.$service->id.'" data-action="delete" id="btn-delete-service"><i class="fa fa-trash"></i> Delete</a>';
                }
                return $edit . ' ' . $delete;
            })
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

        return response()->json(['success' => 'Record has successfully added'], 200);
    }


    public function edit(Request $request)
    {   
        $serviceid = $request->get('serviceid');

        $service = Service::findOrFail($serviceid);
        
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

        $service = Service::findOrFail($serviceid);
        $service->service = $request->get('service');
        $service->status = $request->get('status');
        $service->save();

        return response()->json(['success' => 'Record has been updated']);
    }


    public function delete(Request $request)
    {   
        $serviceid = $request->get('serviceid');
        $service = Service::findOrFail($serviceid);
        $service->delete();

        return response()->json(['success' => 'Record has been deleted'], 200);
    }
}
