<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ServiceProcedure;
use App\Service;
use Validator;
use Auth;
use DB;
use DataTables;
use App\Events\EventNotification;
use App\ActivityLog;
use App\TemplateContent;

class ServiceProcedureController extends Controller
{   
    public function index()
    {   
        $services = Service::all();

        return view('pages.service_procedure.index', compact('services'));
    }

    public function getprocedurerecord()
    {   
        $services = [];

        if(Auth::user()->can('patientservices-list-ultrasound'))
        {
            $services[] = 'Ultrasound';
        }

        if(Auth::user()->can('patientservices-list-ecg'))
        {
            $services[] = 'E.C.G';
        }

        if(Auth::user()->can('patientservices-list-checkup'))
        {
            $services[] = 'Check-up';
        }

        if(Auth::user()->can('patientservices-list-laboratory'))
        {
            $services[] = 'Laboratory';
        }

        if(Auth::user()->can('patientservices-list-physicaltherapy'))
        {
            $services[] = 'Physical Therapy';
        }

        if(Auth::user()->can('patientservices-list-xray'))
        {
            $services[] = 'X-Ray';
        }    

        $serviceprocedures = DB::table('services')
                               ->join('service_procedures', 'services.id', '=', 'service_procedures.serviceid')
                               ->leftJoin('template_contents', 'service_procedures.id', '=', 'template_contents.procedureid')
                               ->select('service_procedures.id', 'services.service', 'service_procedures.code', 'service_procedures.procedure', 'service_procedures.price', 'service_procedures.to_diagnose',
                                        'service_procedures.is_multiple', DB::raw("DATE_FORMAT(template_contents.updated_at, '%m/%d/%Y') as template_last_update"))
                               ->whereIn('services.service', $services) 
                               ->get();
        return DataTables::of($serviceprocedures)
            ->addColumn('action',function($serviceprocedures){
                
                $add = '<a href="'.route('content.create', $serviceprocedures->id).'" class="btn btn-xs btn-primary" data-procedureid="'.$serviceprocedures->id.'" data-action="add" id="btn-add-content"><i class="fa fa-edit"></i> Template</a>';
                $edit = '';
                $delete = '';

                if(Auth::user()->can('serviceprocedure-edit'))
                {
                    $edit = '<a href="" class="btn btn-xs btn-info" data-procedureid="'.$serviceprocedures->id.'" data-action="edit" id="btn-edit-procedure"><i class="fa fa-edit"></i> Edit</a>';
                }

                if(Auth::user()->can('serviceprocedure-delete'))
                {
                    $delete = '<a href="" class="btn btn-xs btn-danger" data-procedureid="'.$serviceprocedures->id.'" data-action="delete" id="btn-delete-procedure"><i class="fa fa-trash"></i> Delete</a>';
                }
                
                return $add . ' ' . $edit . ' ' . $delete;
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

        // return $request->all();

        $rules = [
            'service.required' => 'Please enter service',  
            'code.required' => 'Code Name is required',
            'code.*.required' => 'Code Name is required',
            'code.*.unique' => 'Code Name already exists',
            'procedure.required' => 'Procedure is required',
            'procedure.*.required' => 'Procedure is required',
            'price.required' => 'Price is required',
            'price.*.required' => 'Price is required',
            'price.*.numeric' => 'Enter a valid value',
            'price.*.between' => 'Enter a valid value',
        ];

        $validator = Validator::make($request->all(),[
            'service' => 'required',
            'code' => 'required|unique:service_procedures,code',
            'code.*' => 'required|unique:service_procedures,code',
            'procedure' => 'required',
            'procedure.*' => 'required',
            'price' => 'required',
            'price.*' => 'required|numeric|between:1, 999999.99',
            
        ], $rules);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 200);
        }

        $ctr = count($request->get('procedure'));
        $code = $request->get('code');
        $procedure = $request->get('procedure');
        $price = $request->get('price');
        $to_diagnose = $request->get('to_diagnose');
        $is_multiple = $request->get('is_multiple');
        $codeIsNull = false;
        $procedureIsNull = false;
        $priceIsNull = false;

        //Validate procedure and price if null
        for($x=0; $x < $ctr; $x++)
        {
            
            if(empty($procedure[$x]))
            {
                $codeIsNull = true;
            }
            
            if(empty($procedure[$x]))
            {
                $procedureIsNull = true;
            }

            if(empty($price[$x]))
            {
                $priceIsNull = true;
            }

        }

        //validated if procedure or price is null
        if($procedureIsNull == true || $priceIsNull == true)
        {
            return response()->json(['procedures' => 'Procedure and Price is required'], 200);
        }

        for($x=0; $x < $ctr; $x++)
        {
            $service = new ServiceProcedure();
            $service->serviceid = $request->get('service');
            $service->code = $code[$x];
            $service->procedure = $procedure[$x];
            $service->price = $price[$x];
            $service->to_diagnose = $to_diagnose[$x];
            $service->is_multiple = $is_multiple[$x];
            $service->save();


            //Template Content
            $template_content = new TemplateContent();
            $template_content->procedureid = $service->id;
            $template_content->content = '';
            $template_content->save();

            //Activity Log
            $activity_log = new ActivityLog();
            $activity_log->object_id = $service->id;
            $activity_log->table_name = 'service_procedures';
            $activity_log->description = 'Create Service Procedure';
            $activity_log->action = 'create';
            $activity_log->userid = auth()->user()->id;
            $activity_log->save();

        }

        //PUSHER - send data/message if service procedure is created
        event(new EventNotification('create-procedure', 'service_procedures'));

        return response()->json(['success' => 'Record has successfully added'], 200);
    }

    public function edit(Request $request)
    {   
        $procedure_id = $request->get('procedure_id');

        $procedure = DB::table('services')
                       ->join('service_procedures', 'services.id', '=', 'service_procedures.serviceid')
                       ->select('service_procedures.id', 'service_procedures.serviceid', 'services.service', 'service_procedures.code', 
                       'service_procedures.procedure', 'service_procedures.price', 'service_procedures.to_diagnose', 'service_procedures.is_multiple')
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
        $rules = [
            'service.required' => 'Please enter service',   
            'code.required' => 'Please enter code',
            'procedure.required' => 'Please add at least 1 service procedure on the table'
        ];

        $validator = Validator::make($request->all(),[
            'service' => 'required',
            'code' => 'required',
            'procedure' => 'required'
        ], $rules);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 200);
        }

        $procedure_id = $request->get('procedure_id');

        $procedure = ServiceProcedure::find($procedure_id);
        $procedure->serviceid = $request->get('service');
        $procedure->code = $request->get('code');
        $procedure->procedure = $request->get('procedure');
        $procedure->price = $request->get('price');
        if($request->get('to_diagnose'))
        {
            $procedure->to_diagnose = $request->get('to_diagnose');
        }
        else
        {
            $procedure->to_diagnose = 'N';
        }
        if($request->get('is_multiple'))
        {
            $procedure->is_multiple = $request->get('is_multiple');
        }
        else
        {
            $procedure->is_multiple = 'N';
        }
        $procedure->save();

        //PUSHER - send data/message if service procedure is updated
        event(new EventNotification('edit-procedure', 'service_procedures'));


        //Activity Log
        $activity_log = new ActivityLog();
        $activity_log->object_id = $procedure->id;
        $activity_log->table_name = 'service_procedures';
        $activity_log->description = 'Update Service Procedure';
        $activity_log->action = 'update';
        $activity_log->userid = auth()->user()->id;
        $activity_log->save();

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

        //PUSHER - send data/message if service procedure is deleted
        event(new EventNotification('delete-procedure', 'service_procedures'));

        //Activity Log
        $activity_log = new ActivityLog();
        $activity_log->object_id = $procedure->id;
        $activity_log->table_name = 'service_procedures';
        $activity_log->description = 'Delete Service Procedure';
        $activity_log->action = 'delete';
        $activity_log->userid = auth()->user()->id;
        $activity_log->save();

        return response()->json(['success' => 'Record has been deleted'], 200);
    }


    public function content_create($procedure_id)
    {   
        $template_content = TemplateContent::where('procedureid', '=', $procedure_id)->first();

        //if record is empty then display error page
        if(empty($template_content->id))
        {
            return abort(404, 'Not Found');
        }

        return view('pages.template_content.service_procedure.create', compact('template_content'));
    }

    public function content_update(Request $request, $procedure_id)
    {   
        // return $request->all();
        
        $template_content = TemplateContent::where('procedureid', '=', $procedure_id)
                                           ->update(['content' => $request->get('content')]);
        
        //Activity Log
        $activity_log = new ActivityLog();
        $activity_log->object_id = $template_content;
        $activity_log->table_name = 'template_contents';
        $activity_log->description = 'Create Service Procedure Template';
        $activity_log->action = 'create';
        $activity_log->userid = auth()->user()->id;
        $activity_log->save();

        // return response()->json(['success' => 'Record has been updated'], 200);

        return response()->json(['success' => 'Record has been added'], 200);

    }


    public function content_preview($procedure_id)
    {   
        $template_content = TemplateContent::where('procedureid', '=', $procedure_id)->first();
        return view('pages.template_content.service_procedure.preview', compact('template_content'));
    }

}
