<?php

namespace App\Http\Controllers;

use App\MedicalCertificate;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use Auth;
use DB;
use DataTables;
use App\Events\EventNotification;
use App\ActivityLog;

class MedicalCertificateController extends Controller
{
    
    public function index()
    {
        return view('pages.template_content.medical_certificate.index');
    }

    public function gettemplatelist()
    {
        $certificates = MedicalCertificate::all();
        return DataTables::of($certificates)
            ->addColumn('action',function($certificates){

                $edit = '';
                $delete = '';

                if(Auth::user()->can('certificate-edit'))
                {
                    $edit = '<a href="'.route("certificate.template.edit",$certificates->id).'" class="btn btn-sm btn-info" data-certificateid="'.$certificates->id.'" data-action="edit" id="btn-edit-certificate" data-toggle="modal" data-target="#modal-certificate"><i class="fa fa-edit"></i> Edit</a>';
                }

                if(Auth::user()->can('certificate-delete'))
                {
                    $delete = '<a href="" class="btn btn-sm btn-danger" data-certificateid="'.$certificates->id.'" data-action="delete" id="btn-delete-certificate"><i class="fa fa-trash"></i> Delete</a>';
                }
                
                return $edit . ' ' . $delete;
            })
            ->addIndexColumn()
            ->make();
    }
    
    public function create()
    {
        return view('pages.template_content.medical_certificate.create');
    }

    
    public function store(Request $request)
    {
        // return $request->all();

         
        $rules = [
            'template_name.required' => 'Please enter template name',
            'template_name.unique' => 'Template Name already exists',
            'content.required' => 'Please enter name',
        ];

        $validator = Validator::make($request->all(),[
            'template_name' => 'required|unique:medical_certificates,name',
            'content' => 'required|max:65535',
        ], $rules);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 200);
        }

        $medical_certificate = new MedicalCertificate();
        $medical_certificate->name = $request->get('template_name');
        $medical_certificate->content = $request->get('content');
        $medical_certificate->save();

        //Activity Log
        $activity_log = new ActivityLog();
        $activity_log->object_id = $medical_certificate->id;
        $activity_log->table_name = 'medical_certificates';
        $activity_log->description = 'Create Medical Certificate';
        $activity_log->action = 'create';
        $activity_log->userid = auth()->user()->id;
        $activity_log->save();

        return response()->json(['success' => 'Record has been added'], 200);
    }

    
    public function show(MedicalCertificate $medicalCertificate)
    {
        //
    }

    
    public function edit($certificate_id)
    {   return view('pages.template_content.medical_certificate.edit');
        $certificate = MedicalCertificate::find($certificate_id);

    }

    
    public function update(Request $request, MedicalCertificate $medicalCertificate)
    {
        //
    }

    
    public function destroy(MedicalCertificate $medicalCertificate)
    {
        //
    }
}
