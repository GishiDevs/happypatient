<?php

namespace App\Http\Controllers;

use App\Diagnosis;
use Illuminate\Http\Request;
use App\PatientServiceItem;
use DB;
use Auth;

class DiagnosisController extends Controller
{

    public function index()
    {
        //
    }


    public function create($ps_item_id)
    {   

        $patient_service = DB::table('patients')
                                  ->join('patient_services', 'patients.id', '=', 'patient_services.patientid')
                                  ->join('patient_service_items', 'patient_services.id', '=', 'patient_service_items.psid')
                                  ->leftJoin('services', 'patient_service_items.serviceid', '=', 'services.id')
                                  ->select('patient_services.id', DB::raw('patient_service_items.id as ps_items_id'), DB::raw("DATE_FORMAT(patient_services.docdate, '%m-%d-%Y') as docdate"), 'patient_services.patientname', 'services.service', 'patients.civilstatus')
                                  ->where('patient_service_items.id', '=', $ps_item_id)
                                  ->orderBy('patient_services.docdate', 'Asc')
                                  ->orderBy('services.service', 'Asc')
                                  ->first();
        

        if($patient_service->service == 'Ultrasound')
        {
            if(!Auth::user()->can('patientservices-list-ultrasound'))
            {
                return "You don't have permission";
            }
            else
            {
                return view('pages.diagnosis.create', compact('patient_service', 'ps_item_id'));
            }
        }

        if($patient_service->service == 'E.C.G')
        {
            if(!Auth::user()->can('patientservices-list-ecg'))
            {
                return "You don't have permission";
            }
            else
            {
                return view('pages.diagnosis.create', compact('patient_service', 'ps_item_id'));
            }
        }

        if($patient_service->service == 'Check-up')
        {
            if(!Auth::user()->can('patientservices-list-checkup'))
            {
                return "You don't have permission";
            }
            else
            {
                return view('pages.diagnosis.create', compact('patient_service', 'ps_item_id'));
            }
        }

        if($patient_service->service == 'Laboratory')
        {
            if(!Auth::user()->can('patientservices-list-laboratory'))
            {
                return "You don't have permission";
            }
            else
            {
                return view('pages.diagnosis.create', compact('patient_service', 'ps_item_id'));
            }
        }

        if($patient_service->service == 'Physical Therapy')
        {
            if(!Auth::user()->can('patientservices-list-physicaltherapy'))
            {
                return "You don't have permission";
            }
            else
            {
                return view('pages.diagnosis.create', compact('patient_service', 'ps_item_id'));
            }
        }

        if($patient_service->service == 'X-Ray')
        {
            if(!Auth::user()->can('patientservices-list-xray'))
            {
                return "You don't have permission";
            }
            else
            {
                return view('pages.diagnosis.create', compact('patient_service', 'ps_item_id'));
            }
        }
        
    }

 
    public function store(Request $request)
    {
        //
    }

 
    public function show(Diagnosis $diagnosis)
    {
        //
    }


    public function edit(Diagnosis $diagnosis)
    {
        //
    }


    public function update(Request $request, Diagnosis $diagnosis)
    {
        //
    }


    public function destroy(Diagnosis $diagnosis)
    {
        //
    }
}