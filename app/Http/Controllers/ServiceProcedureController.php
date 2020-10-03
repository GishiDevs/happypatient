<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;

class ServiceProcedureController extends Controller
{   
    public function index()
    {
        return view('pages.service_procedure.index');
    }

    public function getprocedurerecord()
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
            ->addIndexColumn()
            ->make();
    }

    public function create()
    {   
        $services = Service::all();
        return view('pages.service_procedure.create', compact('services'));
    }

    public function store(Request $request)
    {
        return $request;
    }
}
