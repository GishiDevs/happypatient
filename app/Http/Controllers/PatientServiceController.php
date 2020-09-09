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
                 ->select('patient_services.id', DB::raw("DATE_FORMAT(patient_services.docdate, '%m-%d-%Y') as docdate"), 'patient_services.patientname', 'services.service', 'patient_service_items.status')
                 ->whereIn('services.service', $services)
                 ->where('patient_service_items.status', '=', 'pending')
                 ->orderBy('services.service', 'Asc')
                 ->orderBy('patient_services.docdate', 'Asc')
                 ->get();


        $patient = DB::table('patients')
                 ->select('id','lastname', 'firstname', 'middlename', DB::raw("DATE_FORMAT(birthdate, '%m-%d-%Y') as birthdate") , 'gender', 'weight', 'mobile')
                 ->orderBy('id', 'Asc')
                 ->get();


        if(Auth::user()->can('patientservices-list-ultrasound') || Auth::user()->can('patientservices-list-ecg') || Auth::user()->can('patientservices-list-checkup') || Auth::user()->can('patientservices-list-laboratory') || Auth::user()->can('patientservices-list-physicaltherapy') || Auth::user()->can('patientservices-list-xray'))
        {
            return DataTables::of($patientservices)
                ->addColumn('status',function($patientservices){
 
                        return '<span class="badge bg-warning">'.$patientservices->status.'</span>';
   
                })
                ->addIndexColumn()
                ->rawColumns(['status'])
                ->make();
        }
        else
        {
            return DataTables::of($patient)
                ->addColumn('action',function($patient){

                        $edit = '';
                        $delete = '';

                        if(Auth::user()->can('patient-edit'))
                        {
                            $edit = '<a href="'.route("patient.edit",$patient->id).'" class="btn btn-sm btn-info" data-patientid="'.$patient->id.'" data-action="edit" id="btn-edit-patient"><i class="fa fa-edit"></i> Edit</a>';
                        }

                        if(Auth::user()->can('patient-delete'))
                        {
                            $delete = '<a href="" class="btn btn-sm btn-danger" data-patientid="'.$patient->id.'" data-action="delete" id="btn-delete-patient"><i class="fa fa-trash"></i> Delete</a>';
                        }
                        
                        return $edit .' '. $delete;
                })
                ->addIndexColumn()
                ->make();
        }

        

        

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
        $patientservice->save();

        $ctr = count($request->get('services'));
        $services = $request->get('services');

        for($x=0; $x < $ctr; $x++)
        {
            $serviceitem = new PatientServiceItem();
            $serviceitem->psid = $patientservice->id;
            $serviceitem->serviceid = $services[$x];
            $serviceitem->status = "pending";
            $serviceitem->save();
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
