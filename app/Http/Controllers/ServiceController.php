<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;
use Validator;

class ServiceController extends Controller
{

    public function index()
    {       
        return $services = Service::all();
        return view('pages.service.index');
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
