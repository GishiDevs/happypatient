<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use DataTables;
use Carbon\Carbon; 
use App\Service;
use App\ServiceProcedure;
use App\PatientService;
use App\PatientServiceItem;
use App\Events\EventNotification;

class TransactionController extends Controller
{
    public function index()
    {   
        // $patient_services = PatientService::with('patient_service_items', 'patient_service_items.services', 'patient_service_items.service_procedures')
        //                                   ->get();
        // $patient_service_items = PatientServiceItem::with('patient_service')->get();

        // $services = Service::with('service_procedures')->get();

        // $service_procedures = ServiceProcedure::with('services')->get();

        // return response()->json($patient_services);

        // event(new EventNotification('view-transaction', 'transactions'));

        $services = Service::all();

        $transactions =  DB::table('patient_services')
                            // ->join('patients', 'patient_services.patientid', '=', 'patients.id')
                            ->join('patient_service_items', 'patient_services.id', '=', 'patient_service_items.psid')
                            ->join('services', 'patient_service_items.serviceid', '=', 'services.id')
                            ->join('service_procedures', 'patient_service_items.procedureid', '=', 'service_procedures.id')
                            ->select('patient_services.id', DB::raw('patient_service_items.id as ps_items_id'), DB::raw("DATE_FORMAT(patient_services.docdate, '%m/%d/%Y') as docdate"),
                                     'patient_services.name', 'services.service', DB::raw('services.id as serviceid'), 'service_procedures.code','service_procedures.procedure',
                                     'patient_service_items.price', 'patient_service_items.discount', 'patient_service_items.discount_amt', 'patient_service_items.total_amount',
                                     'patient_service_items.status')
                            ->where('patient_services.cancelled', '=', 'N')
                            // ->where('patient_services.docdate', '=', Carbon::now()->format('Y-m-d'))
                            ->get();
        
        $grand_total = 0.00;

        foreach($transactions as $transaction)
        {
            $grand_total = $grand_total + $transaction->total_amount;
        }

        return view('pages.transactions.index', compact('transactions', 'grand_total', 'services'));
    }

    public function gettransactions(Request $request)
    {   
        // return $request;
        $services = Service::all();
        
        $serviceid = $request->get('serviceid');
        $date_from = Carbon::make($request->get('date_from'))->format('Y-m-d');
        $date_to = Carbon::make($request->get('date_to'))->format('Y-m-d');
        $service_arr;

        if(empty($serviceid))
        {   
            foreach($services as $service)
            {
                $service_arr[] = $service->id;
            }
        }
        else
        {
            $service_arr[] = $request->get('serviceid');
        }

        $transactions =  DB::table('patient_services')
                            // ->join('patients', 'patient_services.patientid', '=', 'patients.id')
                            ->join('patient_service_items', 'patient_services.id', '=', 'patient_service_items.psid')
                            ->join('services', 'patient_service_items.serviceid', '=', 'services.id')
                            ->join('service_procedures', 'patient_service_items.procedureid', '=', 'service_procedures.id')
                            ->select('patient_services.id', DB::raw('patient_service_items.id as ps_items_id'), DB::raw("DATE_FORMAT(patient_services.docdate, '%m/%d/%Y') as docdate"),
                                     'patient_services.name', 'services.service', DB::raw('services.id as serviceid'), 'service_procedures.procedure', 'service_procedures.code', 
                                     'patient_service_items.price', 'patient_service_items.discount', 'patient_service_items.discount_amt', 'patient_service_items.total_amount',
                                     'patient_service_items.status')
                            ->where('patient_services.cancelled', '=', 'N')
                            ->whereIn('services.id', $service_arr)
                            // ->whereDate('patient_services.docdate', '>=', $date_from)
                            // ->whereDate('patient_services.docdate', '<=', $date_to)
                            ->where('patient_services.docdate', '=', Carbon::now()->format('Y-m-d'))
                            ->orderBy('id', 'asc')
                            ->orderBy('service', 'asc')
                            ->orderBy('procedure', 'asc')
                            ->get();
        
        $grand_total = 0.00;

        foreach($transactions as $transaction)
        {
            $grand_total = $grand_total + $transaction->total_amount;
        }
        
        return DataTables::of($transactions)
                        ->addIndexColumn()
                        ->make();
    }

    public function check_patient_transaction(Request $request)
    {
        
        $patient_service = PatientService::where('patientid', '=', $request->get('patient_id'))
                                         ->where('docdate' ,'=', Carbon::now()->format('Y-m-d'))->get();   

        return response()->json(['patient_service' => $patient_service], 200);
    }


}
