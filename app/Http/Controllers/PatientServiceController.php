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
                 ->join('patient_service_items', 'patient_services.id', '=', 'patient_service_items.psid')
                 ->leftJoin('services', 'patient_service_items.serviceid', '=', 'services.id')
                 ->select('patient_services.id', DB::raw("DATE_FORMAT(patient_services.docdate, '%m-%d-%Y') as docdate"), 'patient_services.patientname', 'services.service', 'patient_service_items.status')
                 ->orderBy('patient_services.id', 'Asc')
                 ->get();

        return DataTables::of($patientservices)
                     ->addIndexColumn()
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
                 ->leftJoin('services', 'patient_service_items.serviceid', '=', 'services.id')
                 ->select('patient_services.id', DB::raw('patient_service_items.id as ps_items_id'), DB::raw("DATE_FORMAT(patient_services.docdate, '%m-%d-%Y') as docdate"), 'patient_services.patientname', 'services.service', 'patient_service_items.status')
                 ->whereIn('services.service', $services)
                 ->where('patient_service_items.status', '=', 'pending')
                 ->orderBy('patient_services.docdate', 'Asc')
                 ->orderBy('services.service', 'Asc')
                 ->get();

            return DataTables::of($patientservices)
                ->addColumn('status',function($patientservices){
 
                        return '<span class="badge bg-warning">'.$patientservices->status.'</span>';
   
                })
                ->addcolumn('action',function($patientservices){
                    return '<a href="'.route("diagnosis.create",$patientservices->ps_items_id).'" class="btn btn-sm btn-success" data-ps_items_id="'.$patientservices->ps_items_id.'" data-action="create" id="btn-create-diagnosis"><i class="fa fa-edit"></i> Create Diagnosis</a>
                            <a href="" class="btn btn-sm btn-danger" data-ps_items_id="'.$patientservices->ps_items_id.'" data-action="cancel" id="btn-cancel-diagnosis"><i class="fa fa-times"></i> Cancel</a>';
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

        $patientservice  = new PatientService();
        $patientservice->patientid = $request->get('patient');
        $patientservice->patientname = $patient->lastname . ', ' . $patient->firstname . ' ' . $patient->middlename;
        $patientservice->docdate = Carbon::parse($request->get('docdate'))->format('y-m-d');
        $patientservice->or_number = $request->get('patient');
        $patientservice->note = $request->get('note');
        $patientservice->grand_total = $request->get('grand_total');
        // $patientservice->save();

        $ctr = count($request->get('services'));
        $service_id = $request->get('services');
        $price = $request->get('price');
        $discount = $request->get('discount');


        for($x=0; $x < $ctr; $x++)
        {   
            $discounted_amt = ($price[$x] * ($discount[$x] / 100));
            $total_amount = $price[$x] - $discounted_amt;

            $serviceitem = new PatientServiceItem();
            $serviceitem->psid = $patientservice->id;
            $serviceitem->serviceid = $service_id[$x];
            $serviceitem->status = "pending";
            $serviceitem->price = $price[$x];
            $serviceitem->discount = $discount[$x];
            $serviceitem->total_amount = $service_id[$x];

            // $serviceitem->save();
        }

        return response()->json(['success' => 'Record has successfully added'], 200);

    }

    public function show(PatientService $patientService)
    {
        //
    }

    public function edit(PatientService $patientService)
    {
        //
    }

    public function update(Request $request, PatientService $patientService)
    {
        //
    }

    public function destroy(PatientService $patientService)
    {
        //
    }
}
