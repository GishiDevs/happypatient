<?php

namespace App\Http\Controllers;

use App\PatientService;
use App\Service;
use App\Patient;
use Illuminate\Http\Request;

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
        //
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
