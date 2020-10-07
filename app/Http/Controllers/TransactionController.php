<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use DataTables;
use Carbon\Carbon; 
use App\Service;

class TransactionController extends Controller
{
    public function index()
    {   
        $services = Service::all();

        $transactions =  DB::table('patient_services')
                            ->join('patient_service_items', 'patient_services.id', '=', 'patient_service_items.psid')
                            ->join('services', 'patient_service_items.serviceid', '=', 'services.id')
                            ->join('service_procedures', 'patient_service_items.procedureid', '=', 'service_procedures.id')
                            ->select('patient_services.id', DB::raw('patient_service_items.id as ps_items_id'), DB::raw("DATE_FORMAT(patient_services.docdate, '%m/%d/%Y') as docdate"),
                                     'patient_services.patientname', 'services.service', DB::raw('services.id as serviceid'), 'service_procedures.procedure', 'patient_service_items.price', 'patient_service_items.discount', 
                                     'patient_service_items.discount_amt', 'patient_service_items.total_amount')
                            ->where('patient_services.cancelled', '=', 'N')
                            ->where('patient_services.docdate', '=', Carbon::now()->format('Y-m-d'))
                            ->get();
        
        $grand_total = 0.00;

        foreach($transactions as $transaction)
        {
            $grand_total = $grand_total + $transaction->total_amount;
        }

        return view('pages.transactions.index', compact('transactions', 'grand_total', 'services'));
    }

    public function gettotalamount(Request $request)
    {   

        return $serviceid = $request->get('serviceid');

        return $transactions =  DB::table('patient_services')
                            ->join('patient_service_items', 'patient_services.id', '=', 'patient_service_items.psid')
                            ->join('services', 'patient_service_items.serviceid', '=', 'services.id')
                            ->join('service_procedures', 'patient_service_items.procedureid', '=', 'service_procedures.id')
                            ->select('patient_services.id', DB::raw('patient_service_items.id as ps_items_id'), DB::raw("DATE_FORMAT(patient_services.docdate, '%m/%d/%Y') as docdate"),
                                     'patient_services.patientname', 'services.service', DB::raw('services.id as serviceid'), 'service_procedures.procedure', 'patient_service_items.price', 'patient_service_items.discount', 
                                     'patient_service_items.discount_amt', 'patient_service_items.total_amount')
                            ->where('patient_services.cancelled', '=', 'N')
                            // ->where('services.id', '=', $serviceid)
                            ->where('patient_services.docdate', '=', Carbon::now()->format('Y-m-d'))
                            ->get();
        
        $grand_total = 0.00;

        foreach($transactions as $transaction)
        {
            $grand_total = $grand_total + $transaction->total_amount;
        }

        return response()->json(['grand_total' => $grand_total], 200);
    }


}
