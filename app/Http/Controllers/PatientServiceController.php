<?php

namespace App\Http\Controllers;

use App\PatientService;
use App\PatientServiceItem;
use App\Service;
use App\Patient;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;

class PatientServiceController extends Controller
{
    public function index()
    {
        //
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
