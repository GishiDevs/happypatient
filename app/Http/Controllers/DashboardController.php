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
        $services = [];

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

        //previous day transactions to be diagnosed
        $to_diagnose =  DB::table('patient_services')
                ->join('patient_service_items', 'patient_services.id', '=', 'patient_service_items.psid')
                ->join('services', 'patient_service_items.serviceid', '=', 'services.id')
                ->join('service_procedures', 'patient_service_items.procedureid', '=', 'service_procedures.id')
                // ->join('diagnoses', 'diagnoses.ps_items_id', '=', 'patient_service_items.id')
                ->select('patient_services.id', DB::raw('patient_service_items.id as ps_items_id'), DB::raw("DATE_FORMAT(patient_services.docdate, '%m/%d/%Y') as docdate"), 'patient_services.name', DB::raw('services.id as service_id'), 'services.service',
                         DB::raw(" '' as diagnose_date"), 'service_procedures.procedure', 'patient_service_items.status')
                ->distinct()
                ->whereIn('services.service', $services)
                ->where('patient_services.cancelled', '=', 'N')
                ->where('patient_services.type', '=', 'individual')
                // ->where('diagnoses.docdate', '=', Carbon::now()->format('Y-m-d'))
                ->where('service_procedures.to_diagnose', '=', 'Y')
                ->where('patient_service_items.status', '=', 'pending')
                ->where('patient_services.docdate', '<', Carbon::now()->format('Y-m-d'));


        //diagnosed this day
        $diagnosed_today =  DB::table('patient_services')
                ->join('patient_service_items', 'patient_services.id', '=', 'patient_service_items.psid')
                ->join('services', 'patient_service_items.serviceid', '=', 'services.id')
                ->join('service_procedures', 'patient_service_items.procedureid', '=', 'service_procedures.id')
                ->join('diagnoses', 'diagnoses.ps_items_id', '=', 'patient_service_items.id')
                ->select('patient_services.id', DB::raw('patient_service_items.id as ps_items_id'), DB::raw("DATE_FORMAT(patient_services.docdate, '%m/%d/%Y') as docdate"), 'patient_services.name', DB::raw('services.id as service_id'), 'services.service',
                         DB::raw("DATE_FORMAT(diagnoses.docdate, '%m/%d/%Y') as diagnose_date"), 'service_procedures.procedure', 'patient_service_items.status')
                ->whereIn('services.service', $services)
                ->where('patient_services.cancelled', '=', 'N')
                ->where('patient_services.type', '=', 'individual')
                ->where('diagnoses.docdate', '=', Carbon::now()->format('Y-m-d'));        
        
        //pending patients with check-up services
        $check_up =  DB::table('patient_services')
                 ->join('patient_service_items', 'patient_services.id', '=', 'patient_service_items.psid')
                 ->join('services', 'patient_service_items.serviceid', '=', 'services.id')
                 ->join('service_procedures', 'patient_service_items.procedureid', '=', 'service_procedures.id')
                 ->leftJoin('diagnoses', 'patient_service_items.id', '=', 'diagnoses.ps_items_id')
                 ->select('patient_services.id', DB::raw('patient_service_items.id as ps_items_id'), DB::raw("DATE_FORMAT(patient_services.docdate, '%m/%d/%Y') as docdate"), 'patient_services.name', DB::raw('services.id as service_id'), 'services.service',
                          DB::raw("DATE_FORMAT(diagnoses.docdate, '%m/%d/%Y') as diagnose_date"), 'service_procedures.procedure', 'patient_service_items.status')
                 ->where('patient_services.cancelled', '=', 'N')
                 ->where('patient_services.type', '=', 'individual')
                //  ->where('patient_service_items.status', '=', 'pending')
                 ->where('service_procedures.to_diagnose', '=', 'N')
                 ->where('services.service', '=', 'Check-up')
                 ->whereIn('services.service', $services);    

        //pending patients
        $patient_services =  DB::table('patient_services')
                 ->join('patient_service_items', 'patient_services.id', '=', 'patient_service_items.psid')
                 ->join('services', 'patient_service_items.serviceid', '=', 'services.id')
                 ->join('service_procedures', 'patient_service_items.procedureid', '=', 'service_procedures.id')
                 ->leftJoin('diagnoses', 'patient_service_items.id', '=', 'diagnoses.ps_items_id')
                 ->select('patient_services.id', DB::raw('patient_service_items.id as ps_items_id'), DB::raw("DATE_FORMAT(patient_services.docdate, '%m/%d/%Y') as docdate"), 'patient_services.name', DB::raw('services.id as service_id'), 'services.service',
                          DB::raw("DATE_FORMAT(diagnoses.docdate, '%m/%d/%Y') as diagnose_date"), 'service_procedures.procedure', 'patient_service_items.status')
                 ->whereIn('services.service', $services)
                 ->where('patient_services.cancelled', '=', 'N')
                 ->where('patient_services.type', '=', 'individual')
                 ->where('service_procedures.to_diagnose', '=', 'Y')
                 ->where('patient_services.docdate', '=', Carbon::now()->format('Y-m-d'))
                 ->union($to_diagnose)
                 ->union($check_up)
                 ->union($diagnosed_today)
                 ->orderBy('id', 'asc')
                 ->orderBy('service', 'asc')
                 ->orderBy('diagnose_date', 'asc')
                 ->orderBy('procedure', 'asc')
                
                //  ->groupBy('patient_services.id', 'patient_services.name', 'services.id', 'services.service', 'patient_services.docdate')
                 ->get();

        if(Auth::user()->can('patientservices-list-ultrasound') || Auth::user()->can('patientservices-list-ecg') || Auth::user()->can('patientservices-list-checkup') || Auth::user()->can('patientservices-list-laboratory') || Auth::user()->can('patientservices-list-physicaltherapy') || Auth::user()->can('patientservices-list-xray'))
        {
            return view('pages.dashboard.index', compact('patient_services'));
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
}
