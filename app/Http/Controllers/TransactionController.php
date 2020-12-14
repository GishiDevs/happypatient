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

        $services = Service::whereNotIn('service', ['Physical Therapy', 'Package', 'Profile'])->get();

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
        $service = Service::whereNotIn('service', ['Physical Therapy', 'Package', 'Profile'])->get();
        
        $services = $request->get('services');
        $serviceid = $request->get('serviceid');
        $date_from = Carbon::now()->format('Y-m-d');
        $date_to = Carbon::now()->format('Y-m-d');
        $service_arr;

        if($request->get('date_from'))
        {
            $date_from = Carbon::make($request->get('date_from'))->format('Y-m-d');
        }

        if($request->get('date_to'))
        {
            $date_to = Carbon::make($request->get('date_to'))->format('Y-m-d');
        }

        if(empty($services))
        {   
            foreach($service as $item)
            {
                $service_arr[] = $item->id;
            }
        }
        else
        {
            $service_arr = $services;
        }

        $service_arr;

        $transactions =  DB::table('patient_services')
                            // ->join('patients', 'patient_services.patientid', '=', 'patients.id')
                            ->join('patient_service_items', 'patient_services.id', '=', 'patient_service_items.psid')
                            ->join('services', 'patient_service_items.serviceid', '=', 'services.id')
                            ->join('service_procedures', 'patient_service_items.procedureid', '=', 'service_procedures.id')
                            ->select('patient_services.id', DB::raw('patient_service_items.id as ps_items_id'), DB::raw("DATE_FORMAT(patient_services.docdate, '%m/%d/%Y') as docdate"),
                                     'patient_services.name', 'services.service', DB::raw('services.id as serviceid'), 'service_procedures.procedure', 'service_procedures.code', 
                                     'patient_service_items.price', 'patient_service_items.medicine_amt', 'patient_service_items.discount', 'patient_service_items.discount_amt',
                                     'patient_service_items.total_amount', 'patient_service_items.status')
                            ->where('patient_services.cancelled', '=', 'N')
                            ->whereIn('services.id', $service_arr)
                            ->whereDate('patient_services.docdate', '>=', $date_from)
                            ->whereDate('patient_services.docdate', '<=', $date_to)
                            // ->where('patient_services.docdate', '=', Carbon::now()->format('Y-m-d'))
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

    public function transactions_preview($param)
    {   
        $services = Service::all();
        $service_arr;

        if($param == 'Check-up')
        {
            foreach($services as $service)
            {   
                if($service->service == 'Check-up')
                {
                    $service_arr[] = $service->id;
                }
                
            }
        }
        else
        {
            foreach($services as $service)
            {   
                if($service->service != 'Check-up')
                {
                    $service_arr[] = $service->id;
                }
                
            }
        }
            
        

        return $transactions =  DB::table('patient_services')
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

        return view('pages.transactions.preview', compact('service'));
    }

    public function reports()
    {   

        $services = Service::whereNotIn('service', ['Physical Therapy', 'Package', 'Profile'])->get();

        return view('pages.transactions.reports', compact('services'));
    }

    public function getreports(Request $request)
    {
        $service = Service::whereNotIn('service', ['Physical Therapy', 'Package', 'Profile'])->get();
        
        $services = $request->get('services');
        $serviceid = $request->get('serviceid');
        $date_from = Carbon::now()->format('Y-m-d');
        $date_to = Carbon::now()->format('Y-m-d');
        $service_arr;
        $transactions;

        if($request->get('date_from'))
        {
            $date_from = Carbon::make($request->get('date_from'))->format('Y-m-d');
        }

        if($request->get('date_to'))
        {
            $date_to = Carbon::make($request->get('date_to'))->format('Y-m-d');
        }

        if(empty($services))
        {   
            foreach($service as $item)
            {
                $service_arr[] = $item->id;
            }

            $transactions =  DB::table('patient_services')
                            // ->join('patients', 'patient_services.patientid', '=', 'patients.id')
                            ->join('patient_service_items', 'patient_services.id', '=', 'patient_service_items.psid')
                            ->join('services', 'patient_service_items.serviceid', '=', 'services.id')
                            ->join('service_procedures', 'patient_service_items.procedureid', '=', 'service_procedures.id')
                            ->select(DB::raw("sum(patient_service_items.price) as price"), DB::raw("sum(patient_service_items.medicine_amt) as medicine_amt"), DB::raw("sum(patient_service_items.discount) as discount"), 
                                     DB::raw("sum(patient_service_items.discount_amt) as discount_amt"), DB::raw("sum(patient_service_items.total_amount) as total_amount"), 'services.service', 'service_procedures.code', 
                                     'service_procedures.procedure')
                            ->where('patient_services.cancelled', '=', 'N')
                            ->whereIn('services.id', $service_arr)
                            ->whereDate('patient_services.docdate', '>=', $date_from)
                            ->whereDate('patient_services.docdate', '<=', $date_to)
                            ->groupBy('services.service')
                            ->groupBy('service_procedures.code')
                            ->groupBy('service_procedures.procedure')
                            ->orderBy('services.service', 'asc')
                            ->get();

        }
        else
        {
            $service_arr = $services;

            $service = Service::find($service_arr[0]);
            
            if($service->service == 'Check-up')
            {
                $transactions =  DB::table('patient_services')
                            // ->join('patients', 'patient_services.patientid', '=', 'patients.id')
                            ->join('patient_service_items', 'patient_services.id', '=', 'patient_service_items.psid')
                            ->join('services', 'patient_service_items.serviceid', '=', 'services.id')
                            ->join('service_procedures', 'patient_service_items.procedureid', '=', 'service_procedures.id')
                            ->select(DB::raw("sum(patient_service_items.total_amount) - sum(patient_service_items.medicine_amt) as price"), DB::raw("sum(patient_service_items.medicine_amt) as medicine_amt"), DB::raw("sum(patient_service_items.discount) as discount"), 
                                     DB::raw("sum(patient_service_items.discount_amt) as discount_amt"), DB::raw("sum(patient_service_items.total_amount) as total_amount"), 'services.service', 'service_procedures.code', 
                                     'service_procedures.procedure')
                            ->where('services.id', $service->id)
                            ->whereDate('patient_services.docdate', '>=', $date_from)
                            ->whereDate('patient_services.docdate', '<=', $date_to)
                            ->groupBy('services.service')
                            ->groupBy('service_procedures.code')
                            ->groupBy('service_procedures.procedure')
                            ->orderBy('services.service', 'asc')
                            ->orderBy('service_procedures.procedure', 'asc')
                            ->get();
            }
            else
            {
                $transactions =  DB::table('patient_services')
                            // ->join('patients', 'patient_services.patientid', '=', 'patients.id')
                            ->join('patient_service_items', 'patient_services.id', '=', 'patient_service_items.psid')
                            ->join('services', 'patient_service_items.serviceid', '=', 'services.id')
                            ->join('service_procedures', 'patient_service_items.procedureid', '=', 'service_procedures.id')
                            ->select(DB::raw("sum(patient_service_items.total_amount) as total_amount"), 'patient_services.name', 'services.service')
                            ->where('patient_services.cancelled', '=', 'N')
                            ->whereIn('services.id', $service_arr)
                            ->whereDate('patient_services.docdate', '>=', $date_from)
                            ->whereDate('patient_services.docdate', '<=', $date_to)
                            ->groupBy('patient_services.patientid')
                            ->groupBy('patient_services.name')
                            ->groupBy('services.service')
                            ->orderBy('services.service', 'asc')
                            ->orderBy('patient_services.name', 'asc')
                            ->get();
            }

            
        }
    
        return DataTables::of($transactions)
                            ->addIndexColumn()
                            ->make();
    }

}
