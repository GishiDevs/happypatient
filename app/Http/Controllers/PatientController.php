<?php

namespace App\Http\Controllers;

use App\Patient;
use Illuminate\Http\Request;
use Yajra\Address\Entities\City;
use Yajra\Address\Entities\Region;
use Yajra\Address\Entities\Province;
use Yajra\Address\Entities\Barangay;
use Validator;
use Carbon\Carbon;
use DataTables;
use Auth;
use DB;
use App\Service;
use App\ServiceProcedure;
use App\Events\EventNotification;
use App\PatientService;
use App\ActivityLog;

class PatientController extends Controller
{

    public function index()
    {
        $patients = Patient::all();
        return view('pages.patient.index');
    }

    public function create()
    {   
        $services = Service::all();
        $procedures = ServiceProcedure::all();
        return view('pages.patient.create', compact('services', 'procedures'));
    }

    public function getpatientrecord()
    {
        $patient = DB::table('patients')
                     ->select('id','lastname', 'firstname', 'middlename', DB::raw("DATE_FORMAT(birthdate, '%m/%d/%Y') as birthdate") , 'gender', 'civilstatus', 'weight', 'mobile')
                     ->orderBy('id', 'Desc')
                     ->get();

        return DataTables::of($patient)
            ->addColumn('action',function($patient){

                $edit = '';
                $delete = '';
                $view = '';

                // if(Auth::user()->can('patient-edit'))
                // {
                //     $edit = '<a href="'.route("patient.edit",$patient->id).'" class="btn btn-xs btn-info" data-patientid="'.$patient->id.'" data-action="edit" id="btn-edit-patient"><i class="fa fa-edit"></i></a>';
                // }
                
                $edit = '<a href="'.route("patient.edit",$patient->id).'" class="btn btn-xs btn-info" data-patientid="'.$patient->id.'" data-action="edit" id="btn-edit-patient"><i class="fa fa-edit"></i></a>';

                if(Auth::user()->can('patient-delete'))
                {
                    $delete = '<a href="" class="btn btn-xs btn-danger" data-patientid="'.$patient->id.'" data-action="delete" id="btn-delete-patient"><i class="fa fa-trash"></i></a>';
                }

                if(Auth::user()->can('patient-history'))
                {
                    $view = '<a href="'.route("patient.history",$patient->id).'" class="btn btn-xs btn-primary" data-patientid="'.$patient->id.'" data-action="history" id="btn-history"><i class="fa fa-eye"></i></a>';
                }
                
                return $edit .' '. $delete .' '. $view;
            })
            ->addIndexColumn()
            ->make();
    }

    public function getprovinces()
    {   
        $LU = Province::where('id' , '=', 3)
                      ->select(DB::raw("'01' as grp"), DB::raw('provinces.*'));
                    //   ->get();

        $pangasinan = Province::where('id', '=', 4)
                            ->select(DB::raw("'02' as grp"), DB::raw('provinces.*'));
                            // ->get();
        
        $provinces = Province::whereNotIn('id', [3, 4])
                             ->select(DB::raw("'03' as grp"), DB::raw('provinces.*'))
                             ->union($LU) 
                             ->union($pangasinan)    
                             ->orderBy('grp', 'asc')  
                             ->orderBy('name', 'asc')    
                             ->get();

        return response()->json($provinces, 200);
    }

    public function getcities(Request $request)
    {   
        
        $province_id = $request->get('province_id');
        
        $cities = City::where('province_id', $province_id)->get()->sortBy('name')->values();
        
        //Rosario La Union
        if($province_id == '0133')
        {
            $rosario = City::where('name', 'Rosario')
                       ->where('province_id', '0133')
                       ->select(DB::raw("'01' as grp"), DB::raw('cities.*'));

            $cities = City::where('province_id', $province_id)
                        ->where('name', '!=', 'Rosario')
                        ->select(DB::raw("'02' as grp"), DB::raw('cities.*'))
                        ->union($rosario)
                        ->orderBy('grp', 'asc')
                        ->orderBy('name', 'asc')
                        ->get();
        }

        $city_id = $cities[0]->city_id;
        $barangays = Barangay::where('city_id', $city_id)->get()->sortBy('name')->values();
        return response()->json(['cities' => $cities, 'barangays' => $barangays], 200);
        
    }

    public function getbarangays(Request $request)
    {
        $city_id = $request->get('city_id');
        $barangays = Barangay::where('city_id', $city_id)->get()->sortBy('name')->values();

        return response()->json($barangays, 200);

    }

 
    public function store(Request $request)
    {   
        
        $rules = [
            'lastname.required' => 'Please enter lastname',
            'firstname.required' => 'Please enter firstname',
            'birthdate.required' => 'Please enter birthdate',
            // 'weight.required' => 'Please enter weight',
            // 'weight.numeric' => 'Please enter a valid value',
            // 'weight.between' => 'Please enter a valid value',
            // 'landline.numeric' => 'Please enter a valid value',
            // 'mobile.numeric' => 'Please enter a valid value',
            'province.required' => 'Please select province',
            'city.required' => 'Please select city',
            'barangay.required' => 'Please select barangay',
        ];

        $valid_fields = [
            'lastname' => 'required',
            'firstname' => 'required',
            'birthdate' => 'required',
            // 'weight' => 'required|numeric|between:0,999.99',
            'province' => 'required',
            'city' => 'required',
            'barangay' => 'required',
        ];

        // if($request->get('landline'))
        // {
        //     $valid_fields['landline'] = 'numeric';
        // }
        // if($request->get('mobile'))
        // {
        //     $valid_fields['mobile'] = 'numeric';
        // }
        if($request->get('email'))
        {
            $valid_fields['email'] = 'email';
        }

        $validator = Validator::make($request->all(), $valid_fields, $rules);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 200);
        }

        $patient = new Patient();
        $patient->lastname = $request->get('lastname');
        $patient->firstname = $request->get('firstname');
        $patient->middlename = $request->get('middlename');
        $patient->birthdate = Carbon::parse($request->get('birthdate'))->format('Y-m-d');
        // $patient->weight = $request->get('weight');
        $patient->gender = $request->get('gender');
        $patient->age = $request->get('age');
        $patient->civilstatus = $request->get('civilstatus');
        $patient->landline = $request->get('landline');
        $patient->mobile = $request->get('mobile');
        $patient->email = $request->get('email');
        $patient->address = $request->get('address');
        $patient->province = $request->get('province');
        $patient->city = $request->get('city');
        $patient->barangay = $request->get('barangay');
        $patient->save();

        //PUSHER - send data/message if patients is created
        event(new EventNotification('create-patient', 'patients'));


        //Activity Log
        $activity_log = new ActivityLog();
        $activity_log->object_id = $patient->id;
        $activity_log->table_name = 'patients';
        $activity_log->description = 'Create Patient';
        $activity_log->action = 'create';
        $activity_log->userid = auth()->user()->id;
        $activity_log->save();

        return response()->json(['success' => 'Record has successfully added', 'patientid' => $patient->id], 200);
    }

    public function edit($patientid)
    {       
        $patient = Patient::find($patientid);

        //if record is empty then display error page
        if(empty($patient->id))
        {
            return abort(404, 'Not Found');
        }

        $birthdate = Carbon::parse($patient->birthdate)->format('m-d-Y');
        return view('pages.patient.edit', compact('patient', 'birthdate'));
    }

    public function update(Request $request, $patientid)
    {
        
        $rules = [
            'lastname.required' => 'Please enter lastname',
            'firstname.required' => 'Please enter firstname',
            'birthdate.required' => 'Please enter birthdate',
            'age.numeric' => 'Please enter a valid value',
            // 'weight.required' => 'Please enter weight',
            // 'weight.numeric' => 'Please enter a valid value',
            // 'weight.between' => 'Please enter a valid value',
            // 'landline.numeric' => 'Please enter a valid value',
            // 'mobile.numeric' => 'Please enter a valid value',
            'province.required' => 'Please select province',
            'city.required' => 'Please select city',
            'barangay.required' => 'Please select barangay',
        ];

        $valid_fields = [
            'lastname' => 'required',
            'firstname' => 'required',
            'birthdate' => 'required',
            'age' => 'sometimes|numeric',
            // 'weight' => 'required|numeric|between:0,999.99',
            'province' => 'required',
            'city' => 'required',
            'barangay' => 'required',
        ];

        // if($request->get('landline'))
        // {
        //     $valid_fields['landline'] = 'numeric';
        // }
        // if($request->get('mobile'))
        // {
        //     $valid_fields['mobile'] = 'numeric';
        // }
        if($request->get('email'))
        {
            $valid_fields['email'] = 'email';
        }

        $validator = Validator::make($request->all(), $valid_fields, $rules);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 200);
        }

        $patient = Patient::find($patientid);

        //if record is empty then display error page
        if(empty($patient->id))
        {
            return abort(404, 'Not Found');
        }

        $patient->lastname = $request->get('lastname');
        $patient->firstname = $request->get('firstname');
        $patient->middlename = $request->get('middlename');
        $patient->birthdate = Carbon::parse($request->get('birthdate'))->format('Y-m-d');
        // $patient->weight = $request->get('weight');
        $patient->gender = $request->get('gender');
        $patient->age = $request->get('age');
        $patient->civilstatus = $request->get('civilstatus');
        $patient->landline = $request->get('landline');
        $patient->mobile = $request->get('mobile');
        $patient->email = $request->get('email');
        $patient->address = $request->get('address');
        $patient->province = $request->get('province');
        $patient->city = $request->get('city');
        $patient->barangay = $request->get('barangay');
        $patient->save();

        //update patient_services 'name' column
        $name = $patient->lastname . ', ' . $patient->firstname . ' ' . $patient->middlename;
        PatientService::where('patientid' , '=', $patientid)
                      ->update(['name' => $name]);
        
        
        //PUSHER - send data/message if patients is updated
        event(new EventNotification('edit-patient', 'patients'));


        //Activity Log
        $activity_log = new ActivityLog();
        $activity_log->object_id = $patient->id;
        $activity_log->table_name = 'patients';
        $activity_log->description = 'Update Patient';
        $activity_log->action = 'update';
        $activity_log->userid = auth()->user()->id;
        $activity_log->save();

        return redirect('patient/index');
    }

    public function delete(Request $request)
    {   
        $patient = Patient::find($request->get('patientid'));

        //if record is empty then display error page
        if(empty($patient->id))
        {
            return abort(404, 'Not Found');
        }

        $patient->delete();

        //PUSHER - send data/message if patients is deleted
        event(new EventNotification('delete-patient', 'patients'));

        //Activity Log
        $activity_log = new ActivityLog();
        $activity_log->object_id = $patient->id;
        $activity_log->table_name = 'patients';
        $activity_log->description = 'Delete Patient';
        $activity_log->action = 'delete';
        $activity_log->userid = auth()->user()->id;
        $activity_log->save();

        return response()->json(['success' => 'Record has been deleted'], 200);
    }

    public function history($patientid)
    {   
        $patient = DB::table('patients')
                        ->join('provinces', 'patients.province', '=', 'provinces.province_id')
                        ->join('cities', 'patients.city', '=', 'cities.city_id')
                        ->join('barangays', 'patients.barangay', '=', 'barangays.id')
                        ->select('patients.id', 'patients.lastname', 'patients.firstname', 'patients.middlename', 'patients.age', 'patients.gender', 'patients.civilstatus','patients.weight',
                                 DB::raw("DATE_FORMAT(patients.birthdate, '%m/%d/%Y') as birthdate"), 'patients.landline', 'patients.mobile', 'patients.email', 'patients.address',
                                 DB::raw('provinces.name as province'), DB::raw('cities.name as city'), DB::raw('barangays.name as barangay'))
                        ->where('patients.id', '=', $patientid)
                        ->first();
        //if record is empty then display error page
        if(empty($patient->id))
        {
            return abort(404, 'Not Found');
        }

        $patientservices = DB::table('patients')
                                  ->join('patient_services', 'patients.id', '=', 'patient_services.patientid')
                                  ->join('patient_service_items', 'patient_services.id', '=', 'patient_service_items.psid')
                                  ->join('services', 'patient_service_items.serviceid', '=', 'services.id')
                                  ->join('service_procedures', 'patient_service_items.procedureid', '=', 'service_procedures.id')
                                  ->select('patient_service_items.id', DB::raw("DATE_FORMAT(patient_services.docdate, '%m/%d/%Y') as docdate"), 'patient_services.or_number','services.service', 'service_procedures.procedure', 
                                           'service_procedures.code', 'patient_service_items.price', 'patient_service_items.medicine_amt', 'patient_service_items.discount', 'patient_service_items.discount_amt', 
                                           'patient_service_items.total_amount', 'patient_service_items.status', 'service_procedures.is_multiple', 'patient_service_items.description')
                                  ->where('patient_services.cancelled', '=', 'N')
                                  ->where('patients.id', '=', $patientid)
                                  ->orderBy('patient_services.docdate', 'Asc')
                                  ->orderBy('services.service', 'Asc')
                                  ->get();

        return view('pages.patient.history', compact('patient', 'patientservices'));
    }

    public function diagnosis($ps_item_id)
    {
        $patient_service = DB::table('patients')
                                  ->join('patient_services', 'patients.id', '=', 'patient_services.patientid')
                                  ->join('patient_service_items', 'patient_services.id', '=', 'patient_service_items.psid')
                                  ->join('provinces', 'patients.province', '=', 'provinces.province_id')
                                  ->join('cities', 'patients.city', '=', 'cities.city_id')
                                  ->join('barangays', 'patients.barangay', '=', 'barangays.id')
                                  ->join('diagnoses', 'patient_service_items.id', '=', 'diagnoses.ps_items_id')
                                  ->join('services', 'patient_service_items.serviceid', '=', 'services.id')
                                  ->select(DB::raw('patients.id as patient_id') ,DB::raw('patient_services.id as patient_services_id'), DB::raw('patient_service_items.id as ps_items_id'), DB::raw('patients.id as patient_id'), 
                                           DB::raw('diagnoses.id as diagnoses_id'), DB::raw("DATE_FORMAT(diagnoses.docdate, '%m/%d/%Y') as docdate"), 'patient_services.name', 'services.service',  
                                           DB::raw('services.id as service_id'), 'patients.civilstatus', 'patients.age', 'patients.gender','patients.mobile', 
                                           DB::raw("CONCAT(patients.address, ', ',barangays.name, ', ', cities.name,', ', provinces.name) as address"),'diagnoses.physician', 
                                           'diagnoses.bloodpressure', 'diagnoses.title', 'diagnoses.content', 'diagnoses.file_no')
                                  ->where('patient_service_items.id', '=', $ps_item_id)
                                  ->first();
        
        //if record is empty then display error page
        if(empty($patient_service->patient_id))
        {
            return abort(404, 'Not Found');
        }

        return view('pages.patient.diagnosis',compact('patient_service'));
        
    }
}
