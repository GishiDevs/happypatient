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

class PatientController extends Controller
{

    public function index()
    {
        $patients = Patient::all();
        return view('pages.patient.index');
    }

    public function create()
    {   
        return view('pages.patient.create');
    }

    public function getpatientrecord()
    {
        $patient = DB::table('patients')
                     ->select('id','lastname', 'firstname', 'middlename', DB::raw("DATE_FORMAT(birthdate, '%m/%d/%Y') as birthdate") , 'gender', 'civilstatus', 'weight', 'mobile')
                     ->orderBy('id', 'Asc')
                     ->get();

        return DataTables::of($patient)
            ->addColumn('action',function($patient){

                $edit = '';
                $delete = '';
                $view = '';

                if(Auth::user()->can('patient-edit'))
                {
                    $edit = '<a href="'.route("patient.edit",$patient->id).'" class="btn btn-sm btn-info" data-patientid="'.$patient->id.'" data-action="edit" id="btn-edit-patient"><i class="fa fa-edit"></i> Edit</a>';
                }

                if(Auth::user()->can('patient-delete'))
                {
                    $delete = '<a href="" class="btn btn-sm btn-danger" data-patientid="'.$patient->id.'" data-action="delete" id="btn-delete-patient"><i class="fa fa-trash"></i> Delete</a>';
                }

                if(Auth::user()->can('patient-history'))
                {
                    $view = '<a href="'.route("patient.history",$patient->id).'" class="btn btn-sm btn-primary" data-patientid="'.$patient->id.'" data-action="history" id="btn-history"><i class="fa fa-eye"></i> History</a>';
                }
                
                return $edit .' '. $delete .' '. $view;
            })
            ->addIndexColumn()
            ->make();
    }

    public function getprovinces()
    {
        $provinces = Province::all()->sortBy('name')->values();

        return response()->json($provinces, 200);
    }

    public function getcities(Request $request)
    {   
        
        $province_id = $request->get('province_id');
        $cities = City::where('province_id', $province_id)->get()->sortBy('name')->values();

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
            'weight.required' => 'Please enter weight',
            'weight.numeric' => 'Please enter a valid value',
            'weight.between' => 'Please enter a valid value',
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
            'weight' => 'required|numeric|between:0,999.99',
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
        $patient->birthdate = Carbon::parse($request->get('birthdate'))->format('y-m-d');
        $patient->weight = $request->get('weight');
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

        return response()->json(['success' => 'Record has successfully added'], 200);
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
            'weight.required' => 'Please enter weight',
            'weight.numeric' => 'Please enter a valid value',
            'weight.between' => 'Please enter a valid value',
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
            'weight' => 'required|numeric|between:0,999.99',
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
        $patient->birthdate = Carbon::parse($request->get('birthdate'))->format('y-m-d');
        $patient->weight = $request->get('weight');
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
                                  ->select('patient_service_items.id', DB::raw("DATE_FORMAT(patient_services.docdate, '%m/%d/%Y') as docdate"), 'patient_services.or_number','services.service', 
                                           'patient_service_items.price', 'patient_service_items.discount', 'patient_service_items.total_amount', 'patient_service_items.status')
                                  ->where('patient_services.cancelled', '=', 'N')
                                  ->where('patients.id', '=', $patientid)
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
                                           DB::raw('diagnoses.id as diagnoses_id'), DB::raw("DATE_FORMAT(diagnoses.docdate, '%m/%d/%Y') as docdate"), 'patient_services.patientname', 'services.service',  
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
