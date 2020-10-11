<?php

namespace App\Http\Controllers;

use App\PatientService;
use App\PatientServiceItem;
use App\Service;
use App\Patient;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use Auth;
use DB;
use DataTables;
use App\Events\EventNotification;

class PatientServiceController extends Controller
{   


    public function index()
    {   
        return view('pages.patient_services.index');
    }

    public function serviceslist()
    {   
        $patientservices =  DB::table('patient_services')
                 ->select('patient_services.id', DB::raw("DATE_FORMAT(patient_services.docdate, '%m/%d/%Y') as docdate"), 'patient_services.or_number', 'patient_services.name', 'patient_services.cancelled')
                 ->orderBy('patient_services.id', 'Asc')
                 ->get();

        return DataTables::of($patientservices)
                     ->addIndexColumn()
                     ->addColumn('action',function($patientservices){
 
                        // return '<a href="'.route('patientservice.edit',$patientservices->id).'">'.$patientservices->id.'</a>';
                        return '<a href="'.route('patientservice.edit',$patientservices->id).'" class="btn btn-sm btn-info" data-psid="'.$patientservices->id.'" data-action="view" id="btn-view"><i class="fa fa-eye"></i> View</a>';
   
                     })
                    //  ->rawColumns(['action'])
                     ->make();
    }

    public function servicesperuser()
    {   

        $services;

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

        //diagnosed patients
        $diagnosed =  DB::table('patient_services')
                ->join('patient_service_items', 'patient_services.id', '=', 'patient_service_items.psid')
                ->join('services', 'patient_service_items.serviceid', '=', 'services.id')
                ->join('service_procedures', 'patient_service_items.procedureid', '=', 'service_procedures.id')
                ->join('diagnoses', 'patient_service_items.id' , '=', 'diagnoses.ps_items_id')
                ->select('patient_services.id', DB::raw('patient_service_items.id as ps_items_id'), DB::raw("DATE_FORMAT(patient_services.docdate, '%m/%d/%Y') as docdate"), 
                         DB::raw("DATE_FORMAT(diagnoses.docdate, '%m/%d/%Y') as diagnose_date"), 'patient_services.name', 'services.service', 
                         'service_procedures.procedure', 'patient_service_items.status')
                ->whereIn('services.service', $services)
                ->where('patient_services.cancelled', '=', 'N')
                ->where('patient_services.type', '=', 'individual')
                ->where('patient_service_items.status', '=', 'diagnosed')
                ->where('diagnoses.docdate', '=', Carbon::now()->format('Y-m-d'));
 

        //pending patients
        $patientservices =  DB::table('patient_services')
                 ->join('patient_service_items', 'patient_services.id', '=', 'patient_service_items.psid')
                 ->join('services', 'patient_service_items.serviceid', '=', 'services.id')
                 ->join('service_procedures', 'patient_service_items.procedureid', '=', 'service_procedures.id')
                 ->select('patient_services.id', DB::raw('patient_service_items.id as ps_items_id'), DB::raw("DATE_FORMAT(patient_services.docdate, '%m/%d/%Y') as docdate"), 
                          DB::raw("'' as diagnose_date"), 'patient_services.name', 'services.service', 'service_procedures.procedure', 'patient_service_items.status')
                 ->whereIn('services.service', $services)
                 ->where('patient_services.cancelled', '=', 'N')
                 ->where('patient_services.type', '=', 'individual')
                 ->where('patient_service_items.status', '=', 'pending')
                 ->union($diagnosed)
                 ->get();

            return DataTables::of($patientservices)
                ->addcolumn('action',function($patientservices){
                    return '<a href="'.route("diagnosis.create",$patientservices->ps_items_id).'" class="btn btn-sm btn-success" data-ps_items_id="'.$patientservices->ps_items_id.'" data-action="create" id="btn-create-diagnosis"><i class="fa fa-edit"></i> Diagnose</a>';
                            // <a href="" class="btn btn-sm btn-danger" data-ps_items_id="'.$patientservices->ps_items_id.'" data-action="cancel" id="btn-cancel-diagnosis"><i class="fa fa-times"></i> Cancel</a>';
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make();
       
        // return $services_ultrasound = PatientService::where('id','1')
        //                                             ->with('PatientServiceItems.PatientServiceItemNames')
        //                                             ->get();
    }

    public function create()
    {   
        $services = Service::all();
        $patients = Patient::all();
        return view('pages.patient_services.create', compact('services', 'patients'));
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

        $name;
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
        $patientservice->docdate = Carbon::parse($request->get('docdate'))->format('y-m-d');
        $patientservice->bloodpressure = $request->get('bloodpressure');
        $patientservice->temperature = $request->get('temperature');
        $patientservice->weight = $request->get('weight');
        $patientservice->or_number = $request->get('or_number');
        $patientservice->note = $request->get('note');
        $patientservice->grand_total = $request->get('grand_total');
        $patientservice->status = 'O'; //status Open
        $patientservice->cancelled = 'N'; //cancelled (No)
        $patientservice->save();

        $ctr = count($request->get('services'));
        $service_id = $request->get('services');
        $procedure_id = $request->get('procedures');
        $price = $request->get('price');
        $discount = $request->get('discount');
        $discount_amt = $request->get('discount_amt');
        $service_price = 0.00;
        $service_discount = 0.00;
        $service_discount_amt = 0.00;
        // return $discount[];
        for($x=0; $x < $ctr; $x++)
        {   

            if($price[$x])
            {
                $service_price = $price[$x];
            }
            else
            {
                $service_price = 0.00;
            }

            if($discount[$x])
            {
                $service_discount = $discount[$x];
            }
            else
            {
                $service_discount = 0.00;
            }

            if($discount_amt[$x])
            {
                $service_discount_amt = $discount_amt[$x];
            }
            else
            {
                $service_discount_amt = 0.00;
            }

            $discounted_price = ($price[$x] * ($service_discount / 100));
            $total_amount = $price[$x] - $discounted_price - $discount_amt[$x];

            $serviceitem = new PatientServiceItem();
            $serviceitem->psid = $patientservice->id;
            $serviceitem->serviceid = $service_id[$x];
            $serviceitem->procedureid = $procedure_id[$x];
            $serviceitem->status = "pending";
            $serviceitem->price = $service_price;
            $serviceitem->discount = $service_discount;
            $serviceitem->discount_amt = $service_discount_amt;
            $serviceitem->total_amount = $total_amount;

            $serviceitem->save();
        }

        //PUSHER - send data/message if patient services is created
        event(new EventNotification('create-patient-services', 'patient_services'));

        return response()->json(['success' => 'Record has successfully added'], 200);

    }

    public function edit($psid)
    {   

        $services;

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
                 ->select('patient_service_items.id', 'services.service', 'patient_service_items.price', 'patient_service_items.discount', 'service_procedures.procedure',
                          'patient_service_items.discount_amt', 'patient_service_items.total_amount', 'patient_service_items.status', 'patient_services.docdate', 'patient_services.type')
                 ->whereIn('services.service', $services)
                 ->where('patient_service_items.psid', '=', $psid)
                 ->orderBy('patient_service_items.id', 'Asc')
                 ->get();
        
        return view('pages.patient_services.edit', compact('patientservice', 'patientserviceitems'));
    }   

    public function update(Request $request, $psid)
    {
        $patientservice = PatientService::find($psid);

        //if record is empty then display error page
        if(empty($patientservice->id))
        {
            return abort(404, 'Not Found');
        }
        
        $patientservice->docdate = Carbon::parse($request->get('docdate'))->format('y-m-d');
        $patientservice->name = $request->get('organization');
        $patientservice->bloodpressure = $request->get('bloodpressure');
        $patientservice->temperature = $request->get('temperature');
        $patientservice->weight = $request->get('weight');
        $patientservice->or_number = $request->get('or_number');
        $patientservice->note = $request->get('note');
        $patientservice->save();

        //PUSHER - send data/message if patient services is updated from table patient_services
        event(new EventNotification('edit-patient-services', 'patient_services'));

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

        $patientserviceitem->price = $request->get('price');
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

        return redirect('patientservice/index');

    }

    public function destroy(PatientService $patientService)
    {
        //
    }
}
