<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use DataTables;
use Carbon\Carbon; 

class TransactionController extends Controller
{
    public function index()
    {   
        $transactions =  DB::table('patient_services')
                            ->join('patient_service_items', 'patient_services.id', '=', 'patient_service_items.psid')
                            ->join('services', 'patient_service_items.serviceid', '=', 'services.id')
                            ->join('service_procedures', 'patient_service_items.procedureid', '=', 'service_procedures.id')
                            ->select('patient_services.id', DB::raw('patient_service_items.id as ps_items_id'), DB::raw("DATE_FORMAT(patient_services.docdate, '%m/%d/%Y') as docdate"),
                                     'patient_services.patientname', 'services.service', 'service_procedures.procedure', 'patient_service_items.price', 'patient_service_items.discount', 
                                     'patient_service_items.discount_amt', 'patient_service_items.total_amount')
                            ->where('patient_services.cancelled', '=', 'N')
                            ->where('patient_services.docdate', '=', Carbon::now()->format('Y-m-d'))
                            ->get();
        
        $grand_total = 0.00;

        foreach($transactions as $transaction)
        {
            $grand_total = $grand_total + $transaction->total_amount;
        }

        return view('pages.transactions.index', compact('transactions', 'grand_total'));
    }


}
