<?php

namespace App\Http\Controllers;

use App\Diagnosis;
use Illuminate\Http\Request;
use App\PatientServiceItem;
use App\Service;
use DB;
use Auth;
use Validator;
use PDF;
use Carbon\Carbon;
use Session;
use App\Events\EventNotification;
use App\ActivityLog;
use App\ServiceSignatory;
use App\DiagnosisSignatory;
use App\ServiceProcedure;

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
                                  ->join('service_procedures', 'patient_service_items.procedureid', 'service_procedures.id')
                                  ->join('template_contents', 'service_procedures.id', '=', 'template_contents.procedureid')
                                  ->select('patient_services.id', DB::raw('patient_service_items.id as ps_items_id'), DB::raw("DATE_FORMAT(patient_services.docdate, '%m/%d/%Y') as docdate"),
                                           'patient_services.bloodpressure', 'patient_services.name', 'services.service', DB::raw('services.id as service_id'), 'patients.civilstatus',
                                           'patients.age', 'patients.gender', 'patients.mobile', 'patients.address', DB::raw("CONCAT(barangays.name, ', ', cities.name,', ', provinces.name) as location"),
                                           DB::raw("DATE_FORMAT(patients.birthdate, '%m/%d/%Y') as birthdate"), 'patient_services.temperature', 'patient_services.weight', 'service_procedures.procedure',
                                           'template_contents.content', 'patient_services.note', 'patient_services.physician', 'patient_services.patientid', DB::raw("DATE_FORMAT(patient_services.lmp, '%m/%d/%Y') as lmp"),
                                           'patient_services.o2_sat', 'patient_services.pulserate', 'patient_service_items.file_no', 'service_procedures.is_multiple', 'patient_service_items.description')
                                  ->where('patient_service_items.id', '=', $ps_item_id)
                                  ->orderBy('patient_services.docdate', 'Asc')
                                  ->orderBy('services.service', 'Asc')
                                  ->first();

        $patient_service_history =  DB::table('patient_service_items')
                                  ->join('services', 'patient_service_items.serviceid', '=', 'services.id')
                                  ->join('service_procedures', 'patient_service_items.procedureid', '=', 'service_procedures.id')
                                  ->join('patient_services', 'patient_service_items.psid', '=', 'patient_services.id')
                                  ->join('diagnoses', 'patient_service_items.id', '=', 'diagnoses.ps_items_id')
                                  ->select('patient_service_items.id', 'services.service', 'patient_service_items.price', 'patient_service_items.discount', 'service_procedures.code', 'service_procedures.procedure',
                                          'patient_service_items.discount_amt', 'patient_service_items.total_amount', 'patient_service_items.status', 'patient_services.docdate', 'patient_services.type',
                                          'service_procedures.to_diagnose', 'patient_service_items.medicine_amt', DB::raw('diagnoses.id as diagnoses_id'), DB::raw("DATE_FORMAT(patient_services.docdate, '%m/%d/%Y') as docdate"),
                                          'service_procedures.is_multiple', 'patient_service_items.description')
                                //   ->whereIn('services.service', $services)
                                  ->where('patient_services.patientid', '=', $patient_service->patientid)
                                  ->orderBy('patient_services.docdate', 'Asc')
                                  ->orderBy('patient_services.id', 'Asc')
                                  ->orderBy('services.service', 'Asc')
                                  ->orderBy('service_procedures.code', 'Asc')
                                  ->get();

        //if record is empty then display error page
        if(empty($patient_service->id))
        {
            return abort(404, 'Not Found');
        }

        //list of diagnosis per service (used to count the rows for creating file_no)
        // $dianosis_list_per_service = DB::table('patients')
        //                           ->join('patient_services', 'patients.id', '=', 'patient_services.patientid')
        //                           ->join('patient_service_items', 'patient_services.id', '=', 'patient_service_items.psid')
        //                           ->join('diagnoses', 'patient_service_items.id', '=', 'diagnoses.ps_items_id')
        //                           ->join('services', 'patient_service_items.serviceid', '=', 'services.id')
        //                           ->select('diagnoses.id')
        //                           ->where('services.id', '=', $patient_service->service_id)
        //                           ->where(DB::raw('year(patient_services.docdate)'), '=', $year_now)
        //                           ->get();

        //number of patient of current for the selected service. (for create file #)
        // $diagnosis_ctr = count($dianosis_list_per_service) + 1;
        // $file_no = date('y') . '-' . sprintf('%05d', $diagnosis_ctr);


        if($patient_service->service == 'Ultrasound')
        {
            if(!Auth::user()->can('patientservices-list-ultrasound'))
            {
                return abort(401, 'Unauthorized');
            }
        }

        if($patient_service->service == 'E.C.G')
        {
            if(!Auth::user()->can('patientservices-list-ecg'))
            {
                return abort(401, 'Unauthorized');
            }
        }

        if($patient_service->service == 'Check-up')
        {
            if(!Auth::user()->can('patientservices-list-checkup'))
            {
                return abort(401, 'Unauthorized');
            }
        }

        if($patient_service->service == 'Laboratory')
        {
            if(!Auth::user()->can('patientservices-list-laboratory'))
            {
                return abort(401, 'Unauthorized');
            }
        }

        if($patient_service->service == 'Physical Therapy')
        {
            if(!Auth::user()->can('patientservices-list-physicaltherapy'))
            {
                return abort(401, 'Unauthorized');
            }
        }

        if($patient_service->service == 'X-Ray')
        {
            if(!Auth::user()->can('patientservices-list-xray'))
            {
                return abort(401, 'Unauthorized');
            }
        }


        $service_signatories = ServiceSignatory::with('users', 'services')
                                               ->where('serviceid', $patient_service->service_id)
                                               ->where('userid', '!=', auth()->user()->id)
                                                ->get();
        $procedure_codes = explode(',',$patient_service->description);

        $contents = "";

        // if Service Procedure is set for Multiple procedures, then concat all the template contents
        if($patient_service->is_multiple == 'Y')
        {
            for($x=0 ; $x < count($procedure_codes); $x++)
            {   
                $contents = $contents . ServiceProcedure::with('template_contents')
                                            ->where('code', '=', $procedure_codes[$x])->first()
                                            ->template_contents
                                            ->content;
            }
        }

        return view('pages.diagnosis.create', compact('patient_service', 'ps_item_id', 'patient_service_history', 'service_signatories', 'contents'));

    }


    public function store(Request $request, $ps_item_id)
    {
        // return $request;

        $year_now = date('Y');

        $patient_service = DB::table('patient_service_items')
                                  ->join('services', 'patient_service_items.serviceid', '=', 'services.id')
                                  ->select(DB::raw('services.id as service_id'), 'services.service', 'patient_service_items.file_no')
                                  ->where('patient_service_items.id', '=', $ps_item_id)
                                  ->first();

        //if record is empty then display error page
        if(empty($patient_service->service_id))
        {
            return abort(404, 'Not Found');
        }

        //list of diagnosis per service (used to count the rows for creating file_no)
        // $dianosis_list_per_service = DB::table('patients')
        //                           ->join('patient_services', 'patients.id', '=', 'patient_services.patientid')
        //                           ->join('patient_service_items', 'patient_services.id', '=', 'patient_service_items.psid')
        //                           ->join('diagnoses', 'patient_service_items.id', '=', 'diagnoses.ps_items_id')
        //                           ->join('services', 'patient_service_items.serviceid', '=', 'services.id')
        //                           ->select('diagnoses.id')
        //                           ->where('services.id', '=', $patient_service->service_id)
        //                           ->where(DB::raw('year(patient_services.docdate)'), '=', $year_now)
        //                           ->get();

        //number of patient of current for the selected service. (for create file #)
        // $diagnosis_ctr = count($dianosis_list_per_service) + 1;
        // $file_no = date('y') . '-' . sprintf('%05d', $diagnosis_ctr);

        // return $request;
        $rules = [
            // 'physician.required' => 'Please enter physician',
            'title.required' => 'Please enter template title',
            'content.required' => 'Please enter template content',
            'content.max' => "Content is too long. Content must not contain images."
        ];

        $validator = Validator::make($request->all(),[
            // 'physician' => 'required',
            'title' => 'required',
            // 'content' => 'required|max:65535'
        ], $rules);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 200);
        }

        $ps_item = PatientServiceItem::find($ps_item_id);

        //if record is empty then display error page
        if(empty($ps_item->id))
        {
            return abort(404, 'Not Found');
        }

        if($patient_service->service == 'Check-up')
        {
            $ps_item->status = 'receipted';
        }
        else
        {
            $ps_item->status = 'diagnosed';
        }

        $ps_item->save();

        $diagnosis = new Diagnosis();
        $diagnosis->ps_items_id = $ps_item_id;
        $diagnosis->file_no = $ps_item->file_no;
        $diagnosis->docdate = Carbon::parse($request->get('docdate'))->format('Y-m-d');
        $diagnosis->physician = $request->get('physician');
        // $diagnosis->bloodpressure = $request->get('bloodpressure');
        $diagnosis->title = $request->get('title');
        $diagnosis->content = $request->get('content');
        $diagnosis->save();

        //create session for download pdf
        // Session::flash('download_pdf', $ps_item_id);

        $signatories = $request->get('signatories');

        //store diagnosis signatories
        if($signatories)
        {
            for($x=0; $x < count($signatories); $x++)
            {
                $service_signatory = new DiagnosisSignatory();
                $service_signatory->userid = $signatories[$x];
                $service_signatory->diagnosisid = $diagnosis->id;
                $service_signatory->save();

            }
        }

        //PUSHER - send data/message if diagnosis is created
        event(new EventNotification('create-diagnosis', 'diagnoses'));


        //Activity Log
        $activity_log = new ActivityLog();
        $activity_log->object_id = $diagnosis->id;
        $activity_log->table_name = 'diagnoses';
        $activity_log->description = 'Create Diagnosis';
        $activity_log->action = 'create';
        $activity_log->userid = auth()->user()->id;
        $activity_log->save();

        return response()->json(['success' => 'Record has successfully added', 'ps_item_id' => $ps_item_id], 200);

        // return redirect('/');
    }


    public function print($ps_item_id)
    {
        $patient_service = DB::table('patients')
                                  ->join('patient_services', 'patients.id', '=', 'patient_services.patientid')
                                  ->join('patient_service_items', 'patient_services.id', '=', 'patient_service_items.psid')
                                  ->join('provinces', 'patients.province', '=', 'provinces.province_id')
                                  ->join('cities', 'patients.city', '=', 'cities.city_id')
                                  ->join('barangays', 'patients.barangay', '=', 'barangays.id')
                                  ->join('diagnoses', 'patient_service_items.id', '=', 'diagnoses.ps_items_id')
                                  ->join('services', 'patient_service_items.serviceid', '=', 'services.id')
                                  ->select(DB::raw('patients.id as patient_id') ,DB::raw('patient_services.id as patient_services_id'), DB::raw('patient_service_items.id as ps_items_id'), DB::raw('patients.id as patient_id'),
                                           DB::raw('diagnoses.id as diagnoses_id'), DB::raw("DATE_FORMAT(diagnoses.docdate, '%m/%d/%Y') as docdate"), 'patient_services.name', 'services.service',
                                           DB::raw('services.id as service_id'), 'patients.civilstatus', 'patients.age', 'patients.gender','patients.mobile',
                                           'patients.address', DB::raw("CONCAT(barangays.name, ', ', cities.name,', ', provinces.name) as location"),'diagnoses.physician',
                                           'patient_services.bloodpressure', 'patient_services.temperature', 'patient_services.weight', 'diagnoses.title', 'diagnoses.content', 'diagnoses.file_no',
                                           DB::raw("DATE_FORMAT(patients.birthdate, '%m/%d/%Y') as birthdate"))
                                  ->where('patient_service_items.id', '=', $ps_item_id)
                                  ->first();

        // // service id (1)
        // if($patient_service->service == 'Ultrasound')
        // {
        //     $pdf = PDF::loadView('pages.diagnosis.template.uts', compact('patient_service'));
        //     return $pdf->download($patient_service->name.'-Ultrasound'.Carbon::now()->timestamp.'.pdf');
        // }
        // // service id (2)
        // else if($patient_service->service == 'E.C.G')
        // {
        //     $pdf = PDF::loadView('pages.diagnosis.template.ecg', compact('patient_service'));
        //     return $pdf->download($patient_service->name.'-ECG'.Carbon::now()->timestamp.'.pdf');
        // }
        // // service id (3)
        // else if($patient_service->service == 'Check-up')
        // {
        //     $pdf = PDF::loadView('pages.diagnosis.template.checkup', compact('patient_service'));
        //     return $pdf->download($patient_service->name.'-Checkup'.Carbon::now()->timestamp.'.pdf');
        // }
        // // service id (4)
        // else if($patient_service->service == 'Laboratory')
        // {
        //     $pdf = PDF::loadView('pages.diagnosis.template.laboratory', compact('patient_service'));
        //     return $pdf->download($patient_service->name.'-Laboratory'.Carbon::now()->timestamp.'.pdf');
        // }
        // // service id (5)
        // else if($patient_service->service == 'Physical Therapy')
        // {
        //     $pdf = PDF::loadView('pages.diagnosis.template.physical_therapy', compact('patient_service'));
        //     return $pdf->download($patient_service->name.'-PhysicalTherapy'.Carbon::now()->timestamp.'.pdf');
        // }
        // // service id (6)
        // else if($patient_service->service == 'X-Ray')
        // {
        //     $pdf = PDF::loadView('pages.diagnosis.template.xray', compact('patient_service'));
        //     return $pdf->download($patient_service->name.'-Xray'.Carbon::now()->timestamp.'.pdf');
        // }

        // $pdf = PDF::loadView('pages.diagnosis.pdf', compact('patient_service'));
        // return $pdf->download(Carbon::now()->timestamp.'-'.$patient_service->service.'.pdf');

        //Activity Log
        $activity_log = new ActivityLog();
        $activity_log->object_id = $patient_service->diagnoses_id;
        $activity_log->table_name = '';
        $activity_log->description = 'Print Diagnosis';
        $activity_log->action = 'print';
        $activity_log->userid = auth()->user()->id;
        $activity_log->save();

        $diagnosis_signatories = DiagnosisSignatory::with('users')
                                                ->where('diagnosisid', $patient_service->diagnoses_id)
                                                ->get();

        return view('pages.diagnosis.pdf', compact('patient_service', 'diagnosis_signatories'));;
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
                                  ->join('service_procedures', 'patient_service_items.procedureid', 'service_procedures.id')
                                  ->select('patient_services.id', DB::raw('patient_service_items.id as ps_items_id'), DB::raw('patients.id as patient_id'), DB::raw('diagnoses.id as diagnoses_id'),
                                            DB::raw("DATE_FORMAT(diagnoses.docdate, '%m/%d/%Y') as docdate"), 'patient_services.name', 'services.service', DB::raw('services.id as service_id'),
                                            'patients.civilstatus', 'patients.age', 'patients.gender','patients.mobile', 'patients.address', DB::raw("CONCAT(barangays.name, ', ', cities.name,', ', provinces.name) as location"),
                                            'diagnoses.physician', 'diagnoses.bloodpressure', 'patient_services.temperature', 'patient_services.weight', 'diagnoses.title', 'diagnoses.content', 'diagnoses.file_no', 'service_procedures.procedure',
                                            DB::raw("DATE_FORMAT(patients.birthdate, '%m/%d/%Y') as birthdate"), 'patient_services.note', DB::raw("DATE_FORMAT(patient_services.lmp, '%m/%d/%Y') as lmp"),
                                            'patient_services.o2_sat', 'patient_services.pulserate')
                                  ->where('patient_service_items.id', '=', $ps_item_id)
                                  ->orderBy('patient_services.docdate', 'Asc')
                                  ->orderBy('services.service', 'Asc')
                                  ->first();

        if(empty($patient_service->id))
        {
            return abort(404, 'Not Found');
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

        $diagnosis_signatories = DiagnosisSignatory::with('users')
                                                ->where('diagnosisid', $patient_service->diagnoses_id)
                                                ->pluck('userid', 'userid')
                                                ->all();

        $service_signatories = ServiceSignatory::with('users', 'services')
                                               ->where('serviceid', $patient_service->service_id)
                                               ->where('userid', '!=', auth()->user()->id)
                                               ->get();

        return view('pages.diagnosis.edit',compact('patient_service', 'service_signatories', 'diagnosis_signatories'));
    }


    public function update(Request $request, $diagnoses_id)
    {
        $rules = [
            // 'physician.required' => 'Please enter physician',
            'title.required' => 'Please enter template title',
            'content.required' => 'Please enter template content',
            'content.max' => "Content is too long. Content must not contain images."
        ];

        $validator = Validator::make($request->all(),[
            // 'physician' => 'required',
            'title' => 'required',
            // 'content' => 'required|max:65535'
        ], $rules);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 200);
        }

        $diagnosis = Diagnosis::find($diagnoses_id);

        if(empty($diagnosis->id))
        {
            return abort(404, 'Not Found');
        }

        $diagnosis->physician = $request->get('physician');
        // $diagnosis->bloodpressure = $request->get('bloodpressure');
        $diagnosis->title = $request->get('title');
        $diagnosis->content = $request->get('content');
        $diagnosis->save();


        $signatories = $request->get('signatories');

        //store diagnosis signatories
        if($signatories)
        {
            DiagnosisSignatory::where('diagnosisid', $diagnosis->id)
                            ->whereNotIn('userid', $signatories)
                            ->delete();

            for($x=0; $x < count($signatories); $x++)
            {

                $signatory_exists = DiagnosisSignatory::where('diagnosisid', $diagnosis->id)
                                ->where('userid', $signatories[$x])
                                ->first();

                if(!$signatory_exists)
                {
                    $service_signatory = new DiagnosisSignatory();
                    $service_signatory->userid = $signatories[$x];
                    $service_signatory->diagnosisid = $diagnosis->id;
                    $service_signatory->save();
                }

            }

        }
        else
        {
            DiagnosisSignatory::where('diagnosisid', $diagnosis->id)
                            ->delete();
        }


        //PUSHER - send data/message if diagnosis is updated
        event(new EventNotification('edit-diagnosis', 'diagnoses'));


        //Activity Log
        $activity_log = new ActivityLog();
        $activity_log->object_id = $diagnoses_id;
        $activity_log->table_name = 'diagnoses';
        $activity_log->description = 'Update Diagnosis';
        $activity_log->action = 'update';
        $activity_log->userid = auth()->user()->id;
        $activity_log->save();

        return response()->json(['success' => 'Record has been updated'], 200);
    }

    public function view_history($patient_id)
    {
        $patientservices =  DB::table('patient_service_items')
                            ->join('services', 'patient_service_items.serviceid', '=', 'services.id')
                            ->join('service_procedures', 'patient_service_items.procedureid', '=', 'service_procedures.id')
                            ->join('patient_services', 'patient_service_items.psid', '=', 'patient_services.id')
                            ->select('patient_service_items.id', 'services.service', 'patient_service_items.price', 'patient_service_items.discount', 'service_procedures.code', 'service_procedures.procedure',
                                    'patient_service_items.discount_amt', 'patient_service_items.total_amount', 'patient_service_items.status', 'patient_services.docdate', 'patient_services.type',
                                    'service_procedures.to_diagnose', 'patient_service_items.medicine_amt')
                            ->whereIn('services.service', $services)
                            ->where('patient_services.patientid', '=', $patient_id)
                            ->orderBy('patient_services.id', 'Asc')
                            ->orderBy('services.service', 'Asc')
                            ->orderBy('service_procedures.code', 'Asc')
                            ->get();

        return response()->json(['patientservices' => $patientservices], 200);
    }

    public function preview_diagnosis($param)
    {

    }

    public function destroy(Diagnosis $diagnosis)
    {
        //
    }
}
