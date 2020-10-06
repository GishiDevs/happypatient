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

    public function edit(Request $request)
    {   
        $procedure_id = $request->get('procedure_id');

        $procedure = DB::table('services')
                       ->join('service_procedures', 'services.id', '=', 'service_procedures.serviceid')
                       ->select('service_procedures.id', 'service_procedures.serviceid', 'services.service', 'service_procedures.procedure', 'service_procedures.price')
                       ->where('service_procedures.id', '=', $procedure_id)
                       ->first();

        //if record is empty then display error page
        if(empty($procedure->id))
        {
            return abort(404, 'Not Found');
        }

        return response()->json(['procedure' => $procedure], 200);
    }

    public function update(Request $request)
    {   
        $procedure_id = $request->get('procedure_id');

        $procedure = ServiceProcedure::find($procedure_id);
        $procedure->serviceid = $request->get('service');
        $procedure->procedure = $request->get('procedure');
        $procedure->price = $request->get('price');
        $procedure->save();

        return response()->json(['success' => 'Record has been updated'], 200);
    }

    public function delete(Request $request)
    {   
        $procedure_id = $request->get('procedure_id');
        $procedure = ServiceProcedure::find($procedure_id);

        //if record is empty then display error page
        if(empty($procedure->id))
        {
            return abort(404, 'Not Found');
        }

        $procedure->delete();

        return response()->json(['success' => 'Record has been deleted'], 200);
    }
}
