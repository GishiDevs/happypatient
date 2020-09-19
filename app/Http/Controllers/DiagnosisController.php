<?php

namespace App\Http\Controllers;

use App\Diagnosis;
use Illuminate\Http\Request;
use App\PatientServiceItem;
use DB;
use Auth;
use Validator;
use PDF;
use Carbon\Carbon;

class DiagnosisController extends Controller
{

    public function index()
    {
        //
    }


    public function create($ps_item_id)
    {   
        $year_now = date('Y');

        $patient_service = DB::table('patients')
                                  ->join('patient_services', 'patients.id', '=', 'patient_services.patientid')
                                  ->join('patient_service_items', 'patient_services.id', '=', 'patient_service_items.psid')
                                  ->join('provinces', 'patients.province', '=', 'provinces.province_id')
                                  ->join('cities', 'patients.city', '=', 'cities.city_id')
                                  ->join('barangays', 'patients.barangay', '=', 'barangays.id')
                                  ->join('services', 'patient_service_items.serviceid', '=', 'services.id')
                                  ->select('patient_services.id', DB::raw('patient_service_items.id as ps_items_id'), DB::raw("DATE_FORMAT(patient_services.docdate, '%m-%d-%Y') as docdate"), 
                                                                          'patient_services.patientname', 'services.service', DB::raw('services.id as service_id'), 'patients.civilstatus', 'patients.age', 'patients.gender',
                                                                          'patients.mobile', DB::raw("CONCAT(patients.address, ', ',barangays.name, ', ', cities.name,', ', provinces.name) as address"))
                                  ->where('patient_service_items.id', '=', $ps_item_id)
                                  ->orderBy('patient_services.docdate', 'Asc')
                                  ->orderBy('services.service', 'Asc')
                                  ->first();
        
        //if record is empty then display error page
        if(empty($patient_service->id))
        {
            return abort(404);
        }

        //list of diagnosis per service (used to count the rows for creating file_no)
        $dianosis_list_per_service = DB::table('patients')
                                  ->join('patient_services', 'patients.id', '=', 'patient_services.patientid')
                                  ->join('patient_service_items', 'patient_services.id', '=', 'patient_service_items.psid')
                                  ->join('diagnoses', 'patient_service_items.id', '=', 'diagnoses.ps_items_id')
                                  ->join('services', 'patient_service_items.serviceid', '=', 'services.id')
                                  ->select('diagnoses.id')
                                  ->where('services.id', '=', $patient_service->service_id)
                                  ->where(DB::raw('year(patient_services.docdate)'), '=', $year_now)
                                  ->get();
        
        //number of patient of current for the selected service. (for create file #)
        $diagnosis_ctr = count($dianosis_list_per_service) + 1;
        $file_no = date('y') . '-' . sprintf('%05d', $diagnosis_ctr);


        if($patient_service->service == 'Ultrasound')
        {
            if(!Auth::user()->can('patientservices-list-ultrasound'))
            {
                return "You don't have permission";
            }
            else
            {
                return view('pages.diagnosis.create', compact('patient_service', 'ps_item_id', 'file_no'));
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
                return view('pages.diagnosis.create', compact('patient_service', 'ps_item_id', 'file_no'));
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
                return view('pages.diagnosis.create', compact('patient_service', 'ps_item_id', 'file_no'));
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
                return view('pages.diagnosis.create', compact('patient_service', 'ps_item_id', 'file_no'));
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
                return view('pages.diagnosis.create', compact('patient_service', 'ps_item_id', 'file_no'));
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
                return view('pages.diagnosis.create', compact('patient_service', 'ps_item_id', 'file_no'));
            }
        }
        
    }


    public function store(Request $request, $ps_item_id)
    {   
        // return $request;
        $rules = [
            'physician.required' => 'Please enter physician',
            'title.required' => 'Please enter template title',
            'content.required' => 'Please enter template content',
            'content.max' => "Content is too long. Content must not contain images."
        ];

        $validator = Validator::make($request->all(),[
            'physician' => 'required',
            'title' => 'required',
            'content' => 'required|max:65535'
        ], $rules);
        
        if($validator->fails())
        {
            return response()->json($validator->errors(), 200);
        }

        $diagnosis = new Diagnosis();
        $diagnosis->ps_items_id = $ps_item_id;
        $diagnosis->file_no = 1;
        $diagnosis->docdate = Carbon::parse($request->get('docdate'))->format('y-m-d');
        $diagnosis->physician = $request->get('physician');
        $diagnosis->bloodpressure = $request->get('bloodpressure');
        $diagnosis->title = $request->get('title');
        $diagnosis->content = $request->get('content');
        $diagnosis->save();

        $ps_item = PatientServiceItem::findOrFail($ps_item_id);
        $ps_item->status = 'diagnosed';
        $ps_item->save();
        
        return response()->json(['success' => 'Record has successfully added'], 200);
    }

 
    public function print(Diagnosis $diagnosis)
    {   
        $pdf = PDF::loadView('pages.diagnosis.pdf');
        return $pdf->download('invoice.pdf');
        // return view('pages.diagnosis.pdf');
    }


    public function edit($ps_item_id)
    {   
        $year_now = date('Y');
        
        $patient_service = DB::table('patients')
                                  ->join('patient_services', 'patients.id', '=', 'patient_services.patientid')
                                  ->join('patient_service_items', 'patient_services.id', '=', 'patient_service_items.psid')
                                  ->join('provinces', 'patients.province', '=', 'provinces.province_id')
                                  ->join('cities', 'patients.city', '=', 'cities.city_id')
                                  ->join('barangays', 'patients.barangay', '=', 'barangays.id')
                                  ->join('diagnoses', 'patient_service_items.id', '=', 'diagnoses.ps_items_id')
                                  ->join('services', 'patient_service_items.serviceid', '=', 'services.id')
                                  ->select('patient_services.id', DB::raw('patient_service_items.id as ps_items_id'), DB::raw('patients.id as patient_id'), DB::raw('diagnoses.id as diagnoses_id'), 
                                            DB::raw("DATE_FORMAT(diagnoses.docdate, '%m/%d/%Y') as docdate"), 'patient_services.patientname', 'services.service', DB::raw('services.id as service_id'), 
                                            'patients.civilstatus', 'patients.age', 'patients.gender','patients.mobile', DB::raw("CONCAT(patients.address, ', ',barangays.name, ', ', cities.name,', ', provinces.name) as address"),
                                            'diagnoses.physician', 'diagnoses.bloodpressure', 'diagnoses.title', 'diagnoses.content', 'diagnoses.file_no')
                                  ->where('patient_service_items.id', '=', $ps_item_id)
                                  ->orderBy('patient_services.docdate', 'Asc')
                                  ->orderBy('services.service', 'Asc')
                                  ->first();
        
        if(empty($patient_service->id))
        {
            return abort('404');
        }

        //list of diagnosis per service (used to count the rows for creating file_no)
        $dianosis_list_per_service = DB::table('patients')
                                  ->join('patient_services', 'patients.id', '=', 'patient_services.patientid')
                                  ->join('patient_service_items', 'patient_services.id', '=', 'patient_service_items.psid')
                                  ->join('diagnoses', 'patient_service_items.id', '=', 'diagnoses.ps_items_id')
                                  ->join('services', 'patient_service_items.serviceid', '=', 'services.id')
                                  ->select('diagnoses.id')
                                  ->where('services.id', '=', $patient_service->service_id)
                                  ->where(DB::raw('year(patient_services.docdate)'), '=', $year_now)
                                  ->get();
        
        //number of patient of current for the selected service. (for create file #)
        $diagnosis_ctr = count($dianosis_list_per_service) + 1;
        $file_no = date('y') . '-' . sprintf('%05d', $diagnosis_ctr);

        return view('pages.diagnosis.edit',compact('patient_service'));
    }


    public function update(Request $request, $diagnoses_id)
    {
        $rules = [
            'physician.required' => 'Please enter physician',
            'title.required' => 'Please enter template title',
            'content.required' => 'Please enter template content',
            'content.max' => "Content is too long. Content must not contain images."
        ];

        $validator = Validator::make($request->all(),[
            'physician' => 'required',
            'title' => 'required',
            'content' => 'required|max:65535'
        ], $rules);
        
        if($validator->fails())
        {
            return response()->json($validator->errors(), 200);
        }

        $diagnosis = Diagnosis::find($diagnoses_id);
        $diagnosis->physician = $request->get('physician');
        $diagnosis->bloodpressure = $request->get('bloodpressure');
        $diagnosis->title = $request->get('title');
        $diagnosis->content = $request->get('content');
        $diagnosis->save();
        
        return response()->json(['success' => 'Record has been updated'], 200);
    }


    public function destroy(Diagnosis $diagnosis)
    {
        //
    }
}
