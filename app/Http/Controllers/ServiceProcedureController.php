<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ServiceProcedure;
use App\Service;
use Validator;
use Auth;
use DB;
use DataTables;

class ServiceProcedureController extends Controller
{   
    public function index()
    {   
        $services = Service::all();

        return view('pages.service_procedure.index', compact('services'));
    }

    public function getprocedurerecord()
    {
        $serviceprocedures = DB::table('services')
                               ->join('service_procedures', 'services.id', '=', 'service_procedures.serviceid')
                               ->select('service_procedures.id', 'services.service', 'service_procedures.procedure', 'service_procedures.price')
                               ->get();
        return DataTables::of($serviceprocedures)
            ->addColumn('action',function($serviceprocedures){

                $edit = '';
                $delete = '';

                if(Auth::user()->can('serviceprocedure-edit'))
                {
                    $edit = '<a href="" class="btn btn-sm btn-info" data-procedureid="'.$serviceprocedures->id.'" data-action="edit" id="btn-edit-procedure"><i class="fa fa-edit"></i> Edit</a>';
                }

                if(Auth::user()->can('serviceprocedure-delete'))
                {
                    $delete = '<a href="" class="btn btn-sm btn-danger" data-procedureid="'.$serviceprocedures->id.'" data-action="delete" id="btn-delete-procedure"><i class="fa fa-trash"></i> Delete</a>';
                }
                
                return $edit . ' ' . $delete;
            })
            ->addIndexColumn()
            ->make();
    }

    public function serviceprocedures(Request $request)
    {   
        $service_id = $request->get('service_id');
        $procedures = ServiceProcedure::where('serviceid', '=', $service_id)->get();

        return response()->json(['procedures' => $procedures], 200);
    }

    public function create()
    {   
        $services = Service::all();
        return view('pages.service_procedure.create', compact('services'));
    }

    public function store(Request $request)
    {
        $rules = [
            'service.required' => 'Please enter service'
        ];

        $validator = Validator::make($request->all(),[
            'service' => 'required'
        ], $rules);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 200);
        }

        $ctr = count($request->get('procedure'));
        $procedure = $request->get('procedure');
        $price = $request->get('price');

        for($x=0; $x < $ctr; $x++)
        {
            $service = new ServiceProcedure();
            $service->serviceid = $request->get('service');
            $service->procedure = $procedure[$x];
            $service->price = $price[$x];
            $service->save();

        }

        return response()->json(['success' => 'Record has successfully added'], 200);
    }

    public function edit($procedure_id)
    {
        return response()->json($procedure_id, 200);
    }
}
