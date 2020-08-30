<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;
use Validator;
use DataTables;

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
                return '<div class="btn-group">
                            <button class="btn btn-sm btn-secondary type="button">
                                <i class="fa fa-user-md" aria-hidden="true"></i> 
                                Services
                            </button>
                            <button class="btn btn-sm btn-secondary dropdown-toggle dropdown-icon" type="button" data-toggle="dropdown">
                                <span class="sr-only">Toggle Dropdown</span>
                                <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item" href="#">X-Ray</a>
                                    <a class="dropdown-item" href="#">Ultrasound</a>
                                    <a class="dropdown-item" href="#">Laboratory</a>
                                    <a class="dropdown-item" href="#">Check-up</a>
                                    <a class="dropdown-item" href="#">Physical Therapy</a>
                                    <a class="dropdown-item" href="#">E.C.G</a>
                                </div>
                            </button>
                        </div>
                        
                        <a href="'.route("editservice",$service->id).'" class="btn btn-sm btn-info" data-serviceid="'.$service->id.'" data-action="edit" id="btn-edit-service"><i class="fa fa-edit"></i></a>
                        <a href="" class="btn btn-sm btn-danger" data-serviceid="'.$service->id.'" data-action="edit" id="btn-delete-service"><i class="fa fa-trash"></i></a>';
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


    public function show(Service $service)
    {
        //
    }


    public function edit(Service $service)
    {
        //
    }


    public function update(Request $request, Service $service)
    {
        //
    }


    public function destroy(Service $service)
    {
        //
    }
}
