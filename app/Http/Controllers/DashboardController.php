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
                     ->select('id','lastname', 'firstname', 'middlename', DB::raw("DATE_FORMAT(birthdate, '%m-%d-%Y') as birthdate") , 'gender', 'civilstatus', 'weight', 'mobile')
                     ->orderBy('id', 'Asc')
                     ->get();

        return DataTables::of($patient)
            ->addIndexColumn()
            ->make();
    }
}
