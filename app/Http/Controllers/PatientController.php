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
        $patient = Patient::all();
        return DataTables::of($patient)
            ->addColumn('action',function($patient){
                return '<div class="btn-group">
                            <button class="btn btn-sm btn-secondary type="button">
                                <i class="fa fa-user-md" aria-hidden="true"></i> 
                                Services
                            </button>
                            <button class="btn btn-sm btn-secondary dropdown-toggle dropdown-icon" type="button" data-toggle="dropdown">
                                <span class="sr-only">Toggle Dropdown</span>
                                <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item" href="#">X-Ray</a>
                                    <a class="dropdown-item" href="#">Ultrasound</a>
                                    <a class="dropdown-item" href="#">Laboratory</a>
                                    <a class="dropdown-item" href="#">Check-up</a>
                                    <a class="dropdown-item" href="#">Physical Therapy</a>
                                    <a class="dropdown-item" href="#">E.C.G</a>
                                </div>
                            </button>
                        </div>
                        <a href="'.route("viewpatient",$patient->id).'" class="btn btn-sm btn-primary" data-patientid="'.$patient->id.'" data-action="edit" id="btn-view-patient"><i class="fa fa-eye"></i></a>
                        <a href="'.route("editpatient",$patient->id).'" class="btn btn-sm btn-info" data-patientid="'.$patient->id.'" data-action="edit" id="btn-edit-patient"><i class="fa fa-edit"></i></a>
                        <a href="" class="btn btn-sm btn-danger" data-patientid="'.$patient->id.'" data-action="edit" id="btn-delete-patient"><i class="fa fa-trash"></i></a>';
            })
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
            'landline.numeric' => 'Please enter a valid value',
            'mobile.numeric' => 'Please enter a valid value',
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

        if($request->get('landline'))
        {
            $valid_fields['landline'] = 'numeric';
        }
        if($request->get('mobile'))
        {
            $valid_fields['mobile'] = 'numeric';
        }
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


    public function view(Request $request)
    {
        return view('pages.patient.view');
    }


    public function edit($patientid)
    {       
        $patient = Patient::findOrFail($patientid);
        $birthdate = Carbon::parse($patient->birthdate)->format('m-d-y');
        return view('pages.patient.edit', compact('patient', 'birthdate'));
    }

    public function update(Request $request)
    {
        $rules = [
            'lastname.required' => 'Please enter lastname',
            'firstname.required' => 'Please enter firstname',
            'birthdate.required' => 'Please enter birthdate',
            'weight.required' => 'Please enter weight',
            'weight.numeric' => 'Please enter a valid value',
            'weight.between' => 'Please enter a valid value',
            'landline.numeric' => 'Please enter a valid value',
            'mobile.numeric' => 'Please enter a valid value',
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

        if($request->get('landline'))
        {
            $valid_fields['landline'] = 'numeric';
        }
        if($request->get('mobile'))
        {
            $valid_fields['mobile'] = 'numeric';
        }
        if($request->get('email'))
        {
            $valid_fields['email'] = 'email';
        }

        $validator = Validator::make($request->all(), $valid_fields, $rules);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 200);
        }

        $patient = Patient::findOrFail($request->get('patientid'));
        $patient->lastname = $request->get('lastname');
        $patient->firstname = $request->get('firstname');
        $patient->middlename = $request->get('middlename');
        $patient->birthdate = Carbon::parse($request->get('birthdate'))->format('y-m-d');
        $patient->weight = $request->get('weight');
        $patient->gender = $request->get('gender');
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

    public function delete(Request $request)
    {   
        $patient = Patient::findOrFail($request->get('patientid'));
        $patient->delete();

        return response()->json(['success' => 'Record has been deleted'], 200);
    }
}
