<?php

namespace App\Http\Controllers;

use App\PatientService;
use App\PatientServiceItem;
use App\Service;
use App\ServiceProcedure;
use App\Patient;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use Auth;
use DB;
use DataTables;
use App\Events\EventNotification;
use App\ActivityLog;
use App\Queue;
use App\FileNumberSetting;

class PatientServiceController extends Controller
{   

    public function index()
    {  
        return view('pages.patient_services.index');
    }

    public function serviceslist(Request $request)
    {   
        // return $request;
        $from = $request->get('date_from');
        $to = $request->get('date_to');

        if(!$request->get('date_from'))
        {
            $from = '1/1/1900';
        }

        if(!$request->get('date_to'))
        {
            $to = Carbon::now();
        }

        $date_from = Carbon::make($from)->format('Y-m-d');
        $date_to = Carbon::make($to)->format('Y-m-d');

        $patientservices =  DB::table('patient_services')
                 ->select('patient_services.id', DB::raw("DATE_FORMAT(patient_services.docdate, '%m/%d/%Y') as docdate"), 'patient_services.or_number', 'patient_services.name', 'patient_services.cancelled')
                 ->whereDate('patient_services.docdate', '>=', $date_from)
                 ->whereDate('patient_services.docdate', '<=', $date_to)
                 ->orderBy('patient_services.id', 'Asc')
                 ->get();

        return DataTables::of($patientservices)
                     ->addIndexColumn()
                     ->addColumn('action',function($patientservices){
 
                        return '<a href="'.route('patientservice.edit',$patientservices->id).'" class="btn btn-xs btn-info" data-psid="'.$patientservices->id.'" data-action="view" id="btn-view"><i class="fa fa-eye"></i> View</a>';
   
                     })
                    //  ->rawColumns(['action'])
                     ->make();
    }

    public function servicesperuser()
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

        //previous day transactions to be diagnosed
        $to_diagnose =  DB::table('patient_services')
                ->join('patient_service_items', 'patient_services.id', '=', 'patient_service_items.psid')
                ->join('services', 'patient_service_items.serviceid', '=', 'services.id')
                ->join('service_procedures', 'patient_service_items.procedureid', '=', 'service_procedures.id')
                ->leftJoin('queues', 'patient_services.id' ,'=' ,'queues.psid')
                // ->join('diagnoses', 'diagnoses.ps_items_id', '=', 'patient_service_items.id')
                ->select('patient_services.id', DB::raw('patient_service_items.id as ps_items_id'), DB::raw("DATE_FORMAT(patient_services.docdate, '%m/%d/%Y') as docdate"), 'patient_services.name', DB::raw('services.id as service_id'), 'services.service',
                         DB::raw(" '' as diagnose_date"), 'service_procedures.code', 'service_procedures.procedure', 'patient_service_items.status', 'queues.queue_no', 'patient_service_items.file_no')
                ->distinct()
                ->whereIn('services.service', $services)
                ->where('patient_services.cancelled', '=', 'N')
                ->where('patient_services.type', '=', 'individual')
                // ->where('diagnoses.docdate', '=', Carbon::now()->format('Y-m-d'))
                ->where('service_procedures.to_diagnose', '=', 'Y')
                ->where('patient_service_items.status', '=', 'pending')
                ->where('patient_services.docdate', '<', Carbon::now()->format('Y-m-d'));


        //diagnosed this day
        $diagnosed_today =  DB::table('patient_services')
                ->join('patient_service_items', 'patient_services.id', '=', 'patient_service_items.psid')
                ->join('services', 'patient_service_items.serviceid', '=', 'services.id')
                ->join('service_procedures', 'patient_service_items.procedureid', '=', 'service_procedures.id')
                ->join('diagnoses', 'diagnoses.ps_items_id', '=', 'patient_service_items.id')
                ->leftJoin('queues', 'patient_services.id' ,'=' ,'queues.psid')
                ->select('patient_services.id', DB::raw('patient_service_items.id as ps_items_id'), DB::raw("DATE_FORMAT(patient_services.docdate, '%m/%d/%Y') as docdate"), 'patient_services.name', DB::raw('services.id as service_id'), 'services.service',
                         DB::raw("DATE_FORMAT(diagnoses.docdate, '%m/%d/%Y') as diagnose_date"), 'service_procedures.code', 'service_procedures.procedure', 'patient_service_items.status', 'queues.queue_no', 'patient_service_items.file_no')
                ->whereIn('services.service', $services)
                ->where('patient_services.cancelled', '=', 'N')
                ->where('patient_services.type', '=', 'individual')
                ->where('diagnoses.docdate', '=', Carbon::now()->format('Y-m-d'));        
        
        //pending patients with check-up services
        $check_up =  DB::table('patient_services')
                 ->join('patient_service_items', 'patient_services.id', '=', 'patient_service_items.psid')
                 ->join('services', 'patient_service_items.serviceid', '=', 'services.id')
                 ->join('service_procedures', 'patient_service_items.procedureid', '=', 'service_procedures.id')
                 ->leftJoin('diagnoses', 'patient_service_items.id', '=', 'diagnoses.ps_items_id')
                 ->leftJoin('queues', 'patient_services.id' ,'=' ,'queues.psid')
                 ->select('patient_services.id', DB::raw('patient_service_items.id as ps_items_id'), DB::raw("DATE_FORMAT(patient_services.docdate, '%m/%d/%Y') as docdate"), 'patient_services.name', DB::raw('services.id as service_id'), 'services.service',
                          DB::raw("DATE_FORMAT(diagnoses.docdate, '%m/%d/%Y') as diagnose_date"), 'service_procedures.code', 'service_procedures.procedure', 'patient_service_items.status', 'queues.queue_no', 'patient_service_items.file_no')
                 ->where('patient_services.cancelled', '=', 'N')
                 ->where('patient_services.type', '=', 'individual')
                 ->where('patient_service_items.status', '=', 'pending')
                 ->where('service_procedures.to_diagnose', '=', 'N')
                 ->where('services.service', '=', 'Check-up')
                 ->whereIn('services.service', $services)
                 ->where('patient_services.docdate', '=', Carbon::now()->format('Y-m-d'));    

        //pending patients
        $transaction_today =  DB::table('patient_services')
                 ->join('patient_service_items', 'patient_services.id', '=', 'patient_service_items.psid')
                 ->join('services', 'patient_service_items.serviceid', '=', 'services.id')
                 ->join('service_procedures', 'patient_service_items.procedureid', '=', 'service_procedures.id')
                 ->leftJoin('diagnoses', 'patient_service_items.id', '=', 'diagnoses.ps_items_id')
                 ->leftJoin('queues', 'patient_services.id' ,'=' ,'queues.psid')
                 ->select('patient_services.id', DB::raw('patient_service_items.id as ps_items_id'), DB::raw("DATE_FORMAT(patient_services.docdate, '%m/%d/%Y') as docdate"), 'patient_services.name', DB::raw('services.id as service_id'), 'services.service',
                          DB::raw("DATE_FORMAT(diagnoses.docdate, '%m/%d/%Y') as diagnose_date"), 'service_procedures.code', 'service_procedures.procedure', 'patient_service_items.status', 'queues.queue_no', 'patient_service_items.file_no')
                 ->whereIn('services.service', $services)
                 ->where('patient_services.cancelled', '=', 'N')
                 ->where('patient_services.type', '=', 'individual')
                 ->where('service_procedures.to_diagnose', '=', 'Y')
                 ->where('patient_services.docdate', '=', Carbon::now()->format('Y-m-d'))
                //  ->union($to_diagnose)
                 ->union($check_up)
                //  ->union($diagnosed_today)
                 ->orderBy('id', 'asc')
                 ->orderBy('service', 'asc')
                 ->orderBy('diagnose_date', 'asc')
                 ->orderBy('procedure', 'asc')
                //  ->groupBy('patient_services.id', 'patient_services.name', 'services.id', 'services.service', 'patient_services.docdate')
                 ->get();

            return DataTables::of($transaction_today)
                ->addIndexColumn()
                ->make();

        // return response()->json(['patient_services' => $transaction_today], 200);
    }

    public function create()
    {   
        $services = Service::all();
        $procedures = ServiceProcedure::all();
        $patients = Patient::all();
        return view('pages.patient_services.create', compact('services', 'patients', 'procedures'));
    }

    public function store(Request $request)
    {   
        // return $request;

        $rules = [
            'patient.required' => 'Please select patient',
            'organization.required' => 'Please enter organization name',
            'docdate.required' => 'Please enter document date',
            'docdate.date' => 'Please enter a valid date',
            'services.required' => 'Please select at least 1 service'
        ];

        $valid_fields = [
            'docdate' => 'required|date',
            'services' => 'required'
        ];

        //if service type is individual or group
        if($request->get('type') == 'individual')
        {
            $valid_fields['patient'] = 'required';
        }
        else
        {
            $valid_fields['organization'] = 'required';
        }

        $validator = Validator::make($request->all(), $valid_fields, $rules);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 200);
        }

        $patient = Patient::find($request->get('patient'));

        $name = '';
        //if record is empty then display error page
        if($request->get('type') == 'individual')
        {   
            $name = $patient->lastname . ', ' . $patient->firstname . ' ' . $patient->middlename;

            if(empty($patient->id))
            {
                return abort(404, 'Not Found');
            }
        }
        else
        {
            $name = $request->get('organization');
        }
        

        $patientservice  = new PatientService();
        $patientservice->type = $request->get('type');
        $patientservice->patientid = $request->get('patient');
        $patientservice->name = $name;
        if($request->get('type') == 'group')
        {
            $patientservice->organization = $request->get('organization');
        }
        $patientservice->docdate = Carbon::parse($request->get('docdate'))->format('Y-m-d');
        $patientservice->bloodpressure = $request->get('bloodpressure');
        $patientservice->temperature = $request->get('temperature');
        $patientservice->weight = $request->get('weight');
        $patientservice->or_number = $request->get('or_number');
        $patientservice->physician = $request->get('physician');
        $patientservice->pulserate = $request->get('pulserate');
        $patientservice->o2_sat = $request->get('o2_sat');
        if($request->get('lmp'))
        {
            $patientservice->lmp = Carbon::parse($request->get('lmp'))->format('Y-m-d');
        }
        $patientservice->note = $request->get('note');
        $patientservice->grand_total = $request->get('grand_total');
        $patientservice->status = 'O'; //status Open
        $patientservice->cancelled = 'N'; //cancelled (No)
        $patientservice->save();

        $queues = DB::table('queues')
                    ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as created_at"))->get();

        //count all queues for the day
        $queue_no = $queues->where('created_at', '=', Carbon::parse($request->get('docdate'))->format('Y-m-d'))->count() + 1;
        
        $queue = new Queue();
        $queue->psid = $patientservice->id;
        $queue->queue_no = $queue_no;
        $queue->save();

        $ctr = count($request->get('services'));
        $service_id = $request->get('services');
        $procedure_id = $request->get('procedures');
        $description = $request->get('descriptions');
        $price = $request->get('price');
        $medicine_amt = $request->get('medicine_amt');
        $discount = $request->get('discount');
        $discount_amt = $request->get('discount_amt');
        
        // return $discount[];
        for($x=0; $x < $ctr; $x++)
        {   
            // get the last file_no of the specific Service
            $latest_file_no = PatientServiceItem::where('serviceid', '=', $service_id[$x])
                                                ->orderBy('id', 'Desc')
                                                ->first();
            $file_no_setting = FileNumberSetting::where('serviceid', '=', $service_id[$x])->first();
            $file_no = "";

            if($latest_file_no)
            {   
                if($latest_file_no->file_no)
                {
                    $file_no_explode = explode('-', $latest_file_no->file_no);
                    $get_last_no = (int) $file_no_explode[1];
                    $next_no = $get_last_no + 1;
                    $file_no = date('y') . '-' . sprintf('%04d', $next_no); 
                }
                else
                {
                    $file_no = date('y') . '-0001';
                }
                
            }
            else
            {
                // if latest file_no is null - set default starting file number
                $file_no = date('y') . '-0001';
            }
                
            //if file number setting for this Service is active then set the starting file number
            if($file_no_setting->status == 'active')
            {
                $file_no = date('y') . '-' . $file_no_setting->start;

                // update file number setting status into inactive
                FileNumberSetting::where('serviceid', '=', $service_id[$x])
                                 ->update(['status' => 'inactive']);

            }

            $service_price = 0.00;
            $service_medicine_amt = 0.00;
            $service_discount = 0.00;
            $service_discount_amt = 0.00;

            if($price[$x])
            {
                $service_price = $price[$x];
            }

            if($medicine_amt[$x])
            {
                $service_medicine_amt = $medicine_amt[$x];
            }

            if($discount[$x])
            {
                $service_discount = $discount[$x];
            }

            if($discount_amt[$x])
            {
                $service_discount_amt = $discount_amt[$x];
            }


            $discounted_price = ($price[$x] * ($service_discount / 100));
            $total_amount = $price[$x] + $medicine_amt[$x] - $discounted_price - $discount_amt[$x];

            $serviceitem = new PatientServiceItem();
            $serviceitem->psid = $patientservice->id;
            $serviceitem->serviceid = $service_id[$x];
            $serviceitem->procedureid = $procedure_id[$x];
            $serviceitem->description = $description[$x];
            $serviceitem->status = "pending";
            $serviceitem->price = $service_price;
            $serviceitem->medicine_amt = $service_medicine_amt;
            $serviceitem->discount = $service_discount;
            $serviceitem->discount_amt = $service_discount_amt;
            $serviceitem->total_amount = $total_amount;
            $serviceitem->file_no = $file_no;
            $serviceitem->save();
        }

        //PUSHER - send data/message if patient services is created
        event(new EventNotification('create-patient-services', 'patient_services'));

        //Activity Log
        $activity_log = new ActivityLog();
        $activity_log->object_id = $patientservice->id;
        $activity_log->table_name = 'patient_services';
        $activity_log->description = 'Create Patient Services';
        $activity_log->action = 'create';
        $activity_log->userid = auth()->user()->id;
        $activity_log->save();

        return response()->json(['success' => 'Record has successfully added'], 200);

    }

    public function edit($psid)
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

        if(Auth::user()->can('patientservices-list-package'))
        {
            $services[] = 'Package';
        }

        if(Auth::user()->can('patientservices-list-profile'))
        {
            $services[] = 'Profile';
        }

        $patientservice = PatientService::find($psid);

        //if record is empty then display error page
        if(empty($patientservice->id))
        {
            return abort(404, 'Not Found');
        }

        $patientserviceitems =  DB::table('patient_service_items')
                 ->join('services', 'patient_service_items.serviceid', '=', 'services.id')
                 ->join('service_procedures', 'patient_service_items.procedureid', '=', 'service_procedures.id')
                 ->join('patient_services', 'patient_service_items.psid', '=', 'patient_services.id')
                 ->select('patient_service_items.id', 'services.service', 'patient_service_items.price', 'patient_service_items.discount', 'service_procedures.code', 'service_procedures.procedure',
                          'patient_service_items.discount_amt', 'patient_service_items.total_amount', 'patient_service_items.status', 'patient_services.docdate', 'patient_services.type',
                          'service_procedures.to_diagnose', 'patient_service_items.medicine_amt')
                 ->whereIn('services.service', $services)
                 ->where('patient_service_items.psid', '=', $psid)
                 ->orderBy('patient_service_items.id', 'Asc')
                 ->get();

        $services_all = Service::all();
        $procedures_all = ServiceProcedure::all();         
        
        return view('pages.patient_services.edit', compact('patientservice', 'patientserviceitems', 'services_all', 'procedures_all'));
    }   

    public function update(Request $request, $psid)
    {
        $patientservice = PatientService::find($psid);

        //if record is empty then display error page
        if(empty($patientservice->id))
        {
            return abort(404, 'Not Found');
        }
        
        $patientservice->docdate = Carbon::parse($request->get('docdate'))->format('Y-m-d');
        if($patientservice->type == 'group')
        {
            $patientservice->name = $request->get('organization');
        }
        $patientservice->bloodpressure = $request->get('bloodpressure');
        $patientservice->temperature = $request->get('temperature');
        $patientservice->weight = $request->get('weight');
        $patientservice->or_number = $request->get('or_number');
        $patientservice->physician = $request->get('physician');
        $patientservice->pulserate = $request->get('pulserate');
        $patientservice->o2_sat = $request->get('o2_sat');
        if($request->get('lmp'))
        {
            $patientservice->lmp = Carbon::parse($request->get('lmp'))->format('Y-m-d');
        }
        $patientservice->note = $request->get('note');
        $patientservice->save();

        //PUSHER - send data/message if patient services is updated from table patient_services
        event(new EventNotification('edit-patient-services', 'patient_services'));

        //Activity Log
        $activity_log = new ActivityLog();
        $activity_log->object_id = $patientservice->id;
        $activity_log->table_name = 'patient_services';
        $activity_log->description = 'Update Patient Services';
        $activity_log->action = 'update';
        $activity_log->userid = auth()->user()->id;
        $activity_log->save();

        return redirect('patientservice/index');

    }

    public function update_price(Request $request)
    {   

        $ps_item_id = $request->get('ps_item_id');
        $patientserviceitem = PatientServiceItem::find($ps_item_id);

        //if record is empty then display error page
        if(empty($patientserviceitem->id))
        {
            return abort(404, 'Not Found');
        }

        $rules = [
            'price.required' => 'Price is required',
        ];

        $validator = Validator::make($request->all(), [
            'price' => 'required',
        ], $rules);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 200);
        }

  
        $patientserviceitem->price = $request->get('price');
        $patientserviceitem->medicine_amt = $request->get('medicine_amt');
        $patientserviceitem->discount = $request->get('discount');
        $patientserviceitem->discount_amt = $request->get('discount_amt');
        $patientserviceitem->total_amount = $request->get('total_amount');
        $patientserviceitem->save();

        $service_amounts = PatientServiceItem::where('psid', $patientserviceitem->psid)->get();
        $grand_total = 0;

        foreach($service_amounts as $service_amount)
        {
            $grand_total = $grand_total + $service_amount->total_amount;
        }

        $patientservice = PatientService::find($patientserviceitem->psid);

        //if record is empty then display error page
        if(empty($patientservice->id))
        {
            return abort(404, 'Not Found');
        }

        $patientservice->grand_total = $grand_total;

        $patientservice->save();

        //PUSHER - send data/message if service procedure price is updated
        event(new EventNotification('edit-service-amount', 'patient_service_items'));

        //Activity Log
        $activity_log = new ActivityLog();
        $activity_log->object_id = $patientserviceitem->id;
        $activity_log->table_name = 'patient_service_items';
        $activity_log->description = 'Update Service Amount';
        $activity_log->action = 'udpate';
        $activity_log->userid = auth()->user()->id;
        $activity_log->save();

        return response()->json(['success' => 'Record has been updated'], 200);

    }

    public function cancel(Request $request, $psid)
    {
        $patientservice = PatientService::find($psid);

        //if record is empty then display error page
        if(empty($patientservice->id))
        {
            return abort(404, 'Not Found');
        }

        $patientservice->or_number = $request->get('or_number');
        $patientservice->note = $request->get('note');
        $patientservice->cancelled = 'Y';
        $patientservice->canceldate = Carbon::now()->format('Y-m-d');
        $patientservice->save();

        //PUSHER - send data/message if transaction/services is cancelled
        event(new EventNotification('cancel-patient-services', 'patient_services'));

        //Activity Log
        $activity_log = new ActivityLog();
        $activity_log->object_id = $patientservice->id;
        $activity_log->table_name = 'patient_services';
        $activity_log->description = 'Cancel Patient Services';
        $activity_log->action = 'cancel';
        $activity_log->userid = auth()->user()->id;
        $activity_log->save();

        return redirect('patientservice/index');

    }

    public function add_item(Request $request, $psid)
    {   

        $rules = [
            'new-service.required' => 'Please select service',   
            'new-procedure.required' => 'Please select procedure',
            'new-price.required' => 'Please enter price',
            'new-price.numeric' => 'Enter a valid value',
        ];

        $validator = Validator::make($request->all(),[
            'new-service' => 'required',
            'new-procedure' => 'required',
            'new-price' => 'required|numeric|between:0, 999999999999.999999999999',
        ], $rules);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 200);
        }

        // get the last file_no of the specific Service
        $latest_file_no = PatientServiceItem::where('serviceid', '=', $request->get('new-service'))
                                            ->orderBy('id', 'Desc')
                                            ->first();
        $file_no_setting = FileNumberSetting::where('serviceid', '=', $request->get('new-service'))->first();
        $file_no = "";

        if($latest_file_no)
        {   
            if($latest_file_no->file_no)
            {
                $file_no_explode = explode('-', $latest_file_no->file_no);
                $get_last_no = (int) $file_no_explode[1];
                $next_no = $get_last_no + 1;
                $file_no = date('y') . '-' . sprintf('%04d', $next_no); 
            }
            else
            {
                $file_no = date('y') . '-0001';
            }
                
        }
        else
        {
            // if latest file_no is null - set default starting file number
            $file_no = date('y') . '-0001';
        }
            
        //if file number setting for this Service is active then set the starting file number
        if($file_no_setting->status == 'active')
        {
            $file_no = date('y') . '-' . $file_no_setting->start;

            // update file number setting status into inactive
            FileNumberSetting::where('serviceid', '=', $request->get('new-service'))
                             ->update(['status' => 'inactive']);

        }
        
        $price = 0.00;
        $medicine_amt = 0.00;
        $discount = 0.00;
        $discount_amt = 0.00;

        if($request->get('new-price'))
        {
            $price = $request->get('new-price');
        }

        if($request->get('new-medicine_amt'))
        {
            $medicine_amt = $request->get('new-medicine_amt');
        }

        if($request->get('new-discount'))
        {
            $discount = $request->get('new-discount');
        }

        if($request->get('new-discount_amt'))
        {
            $discount_amt = $request->get('new-discount_amt');
        }

        $patientserviceitem = new PatientServiceItem();
        $patientserviceitem->psid = $psid;
        $patientserviceitem->serviceid = $request->get('new-service');
        $patientserviceitem->procedureid = $request->get('new-procedure');
        $patientserviceitem->price = $price;
        $patientserviceitem->medicine_amt = $medicine_amt;
        $patientserviceitem->discount = $discount;
        $patientserviceitem->discount_amt = $discount_amt;
        $patientserviceitem->total_amount = $request->get('total_amount');
        $patientserviceitem->status = 'pending';
        $patientserviceitem->file_no = $file_no;
        $patientserviceitem->save();

        $service_amounts = PatientServiceItem::where('psid', $psid)->get();
        $grand_total = 0;

        foreach($service_amounts as $service_amount)
        {
            $grand_total = $grand_total + $service_amount->total_amount;
        }

        $patientservice = PatientService::find($psid);

        //if record is empty then display error page
        if(empty($patientservice->id))
        {
            return abort(404, 'Not Found');
        }

        $patientservice->grand_total = $grand_total;

        $patientservice->save();

        //PUSHER - send data/message if service procedure price is updated
        event(new EventNotification('add-service-item', 'patient_service_items'));

        //Activity Log
        $activity_log = new ActivityLog();
        $activity_log->object_id = $patientserviceitem->id;
        $activity_log->table_name = 'patient_service_items';
        $activity_log->description = 'Add Service Item';
        $activity_log->action = 'create';
        $activity_log->userid = auth()->user()->id;
        $activity_log->save();

        $service_item =  DB::table('patient_services')
                        ->join('patient_service_items', 'patient_services.id', '=', 'patient_service_items.psid')
                        ->join('services', 'patient_service_items.serviceid', '=', 'services.id')
                        ->join('service_procedures', 'patient_service_items.procedureid', '=', 'service_procedures.id')
                        ->select('patient_service_items.id', 'patient_services.type','patient_services.name', 'services.service', DB::raw('services.id as serviceid'), 'service_procedures.code','service_procedures.procedure',    
                                'patient_service_items.price','patient_service_items.medicine_amt', 'patient_service_items.discount', 'patient_service_items.discount_amt', 'patient_service_items.total_amount', 'service_procedures.to_diagnose')
                        ->where('patient_service_items.id', '=', $patientserviceitem->id)
                        ->first();

        return response()->json(['success' => 'Record has been updated', 'service_item' => $service_item], 200);
    }

    public function remove_item(Request $request)
    {
        $ps_items_id = $request->get('ps_items_id');

        $service_item = PatientServiceItem::find($ps_items_id);
        $service_item->delete();

        $service_amounts = PatientServiceItem::where('psid', $service_item->psid)->get();
        $grand_total = 0;

        foreach($service_amounts as $service_amount)
        {
            $grand_total = $grand_total + $service_amount->total_amount;
        }

        $patientservice = PatientService::find($service_item->psid);

        //if record is empty then display error page
        if(empty($patientservice->id))
        {
            return abort(404, 'Not Found');
        }

        $patientservice->grand_total = $grand_total;

        $patientservice->save();

        //PUSHER - send data/message if service procedure price is updated
        event(new EventNotification('remove-service-item', 'patient_service_items'));

        //Activity Log
        $activity_log = new ActivityLog();
        $activity_log->object_id = $service_item->id;
        $activity_log->table_name = 'patient_service_items';
        $activity_log->description = 'Remove Service Item';
        $activity_log->action = 'remove';
        $activity_log->userid = auth()->user()->id;
        $activity_log->save();

        return response()->json(['success' => 'Item has been removed'], 200);

    }
}
