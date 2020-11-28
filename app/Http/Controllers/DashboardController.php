<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use DataTables;
use Auth;
use DB;


class DashboardController extends Controller
{
    public function index()
    {
        if(Auth::user()->can('patientservices-list-ultrasound') || Auth::user()->can('patientservices-list-ecg') || Auth::user()->can('patientservices-list-checkup') || Auth::user()->can('patientservices-list-laboratory') || Auth::user()->can('patientservices-list-physicaltherapy') || Auth::user()->can('patientservices-list-xray'))
        {
            return view('pages.dashboard.index');
        }
        else
        {
            return view('pages.dashboard.patientinfo');
        }
    }

    public function getpatientlists()
    {
        $patient = DB::table('patients')
                     ->select('id','lastname', 'firstname', 'middlename', DB::raw("DATE_FORMAT(birthdate, '%m/%d/%Y') as birthdate") , 'gender', 'civilstatus', 'weight', 'mobile')
                     ->orderBy('id', 'Asc')
                     ->get();

        return DataTables::of($patient)
            ->addIndexColumn()
            ->make();
    }

    public function getpatientservices($pi_sd, $service_id)
    {
        //pending patients
        $patientservices =  DB::table('patient_services')
                //  ->join('patients', 'patient_services.patientid', '=', 'patients.id')
                 ->join('patient_service_items', 'patient_services.id', '=', 'patient_service_items.psid')
                 ->join('services', 'patient_service_items.serviceid', '=', 'services.id')
                 ->join('service_procedures', 'patient_service_items.procedureid', '=', 'service_procedures.id')
                 ->select('patient_services.id', DB::raw('patient_service_items.id as ps_items_id'), DB::raw("DATE_FORMAT(patient_services.docdate, '%m/%d/%Y') as docdate"), 
                          DB::raw("'' as diagnose_date"), 'patient_services.name', 'services.service', 'service_procedures.procedure', 'patient_service_items.status')
                 ->where('patient_services.id', '=', $pi_sd)
                 ->where('services.id', '=', $service_id)
                 ->get();
        
        return response()->json($patientservices, 200);
    }
}
