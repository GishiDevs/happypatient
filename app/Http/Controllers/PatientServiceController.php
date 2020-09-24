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

class PatientServiceController extends Controller
{   


    public function index()
    {
        return view('pages.patient_services.index');
    }

    public function serviceslist()
    {   
        $patientservices =  DB::table('patient_services')
                 ->select('patient_services.id', DB::raw("DATE_FORMAT(patient_services.docdate, '%m/%d/%Y') as docdate"), 'patient_services.or_number', 'patient_services.patientname', 'patient_services.cancelled')
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

        $patientservices =  DB::table('patient_services')
                 ->join('patient_service_items', 'patient_services.id', '=', 'patient_service_items.psid')
                 ->join('services', 'patient_service_items.serviceid', '=', 'services.id')
                 ->select('patient_services.id', DB::raw('patient_service_items.id as ps_items_id'), DB::raw("DATE_FORMAT(patient_services.docdate, '%m/%d/%Y') as docdate"), 'patient_services.patientname', 'services.service', 'patient_service_items.status')
                 ->whereIn('services.service', $services)
                 ->where('patient_services.cancelled', '=', 'N')
                 ->where('patient_service_items.status', '=', 'pending')
                 ->orderBy('patient_services.docdate', 'Asc')
                 ->orderBy('services.service', 'Asc')
                 ->orderBy('patient_service_items.id', 'Asc')
                 ->get();

            return DataTables::of($patientservices)
                ->addColumn('status',function($patientservices){
 
                        return '<span class="badge bg-warning">'.$patientservices->status.'</span>';
   
                })
                ->addcolumn('action',function($patientservices){
                    return '<a href="'.route("diagnosis.create",$patientservices->ps_items_id).'" class="btn btn-sm btn-success" data-ps_items_id="'.$patientservices->ps_items_id.'" data-action="create" id="btn-create-diagnosis"><i class="fa fa-edit"></i> Create Diagnosis</a>';
                            // <a href="" class="btn btn-sm btn-danger" data-ps_items_id="'.$patientservices->ps_items_id.'" data-action="cancel" id="btn-cancel-diagnosis"><i class="fa fa-times"></i> Cancel</a>';
                })
                ->addIndexColumn()
                ->rawColumns(['status','action'])
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
            'docdate.required' => 'Please enter document date',
            'docdate.date' => 'Please enter a valid date',
            'services.required' => 'Please select at least 1 service'
        ];

        $validator = Validator::make($request->all(),[
            'patient' => 'required',
            'docdate' => 'required|date',
            'services' => 'required'
        ], $rules);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 200);
        }

        $patient = Patient::find($request->get('patient'));

        //if record is empty then display error page
        if(empty($patient->id))
        {
            return abort(404, 'Not Found');
        }

        $patientservice  = new PatientService();
        $patientservice->patientid = $request->get('patient');
        $patientservice->patientname = $patient->lastname . ', ' . $patient->firstname . ' ' . $patient->middlename;
        $patientservice->docdate = Carbon::parse($request->get('docdate'))->format('y-m-d');
        $patientservice->bloodpressure = $request->get('bloodpressure');
        $patientservice->or_number = $request->get('or_number');
        $patientservice->note = $request->get('note');
        $patientservice->grand_total = $request->get('grand_total');
        $patientservice->cancelled = 'N';
        $patientservice->save();

        $ctr = count($request->get('services'));
        $service_id = $request->get('services');
        $price = $request->get('price');
        $discount = $request->get('discount');
        $service_price = 0.00;
        $service_discount = 0.00;
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

            $discounted_amt = ($price[$x] * ($service_discount / 100));
            $total_amount = $price[$x] - $discounted_amt;

            $serviceitem = new PatientServiceItem();
            $serviceitem->psid = $patientservice->id;
            $serviceitem->serviceid = $service_id[$x];
            $serviceitem->status = "pending";
            $serviceitem->price = $service_price;
            $serviceitem->discount = $service_discount;
            $serviceitem->total_amount = $total_amount;

            $serviceitem->save();
        }

        return response()->json(['success' => 'Record has successfully added'], 200);

    }

    public function show(PatientService $patientService)
    {
        //
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

        $patientservice = PatientService::find($psid);

        //if record is empty then display error page
        if(empty($patientservice->id))
        {
            return abort(404, 'Not Found');
        }

        $patientserviceitems =  DB::table('patient_service_items')
                 ->join('services', 'patient_service_items.serviceid', '=', 'services.id')
                 ->select('patient_service_items.id', 'services.service', 'patient_service_items.price', 'patient_service_items.discount', 'patient_service_items.total_amount', 'patient_service_items.status')
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

        $patientservice->bloodpressure = $request->get('bloodpressure');
        $patientservice->or_number = $request->get('or_number');
        $patientservice->note = $request->get('note');
        $patientservice->save();

        return redirect('patientservice/index');

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
        $patientservice->save();

        return redirect('patientservice/index');

    }

    public function destroy(PatientService $patientService)
    {
        //
    }
}
