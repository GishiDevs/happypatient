<?php

namespace App\Http\Controllers;

use App\PatientService;
use App\Service;
use App\Patient;
use Illuminate\Http\Request;
use Validator;

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

        return response()->json(['success', 'Record has successfully added'], 200);

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
