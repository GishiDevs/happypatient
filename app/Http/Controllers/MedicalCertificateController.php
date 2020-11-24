<?php

namespace App\Http\Controllers;

use App\MedicalCertificate;
use Illuminate\Http\Request;

class MedicalCertificateController extends Controller
{
    
    public function index()
    {
        //
    }

    
    public function create()
    {
        return view('pages.template_content.medical_certificate.create');
    }

    
    public function store(Request $request)
    {
        return $request->all();
    }

    
    public function show(MedicalCertificate $medicalCertificate)
    {
        //
    }

    
    public function edit(MedicalCertificate $medicalCertificate)
    {
        //
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
