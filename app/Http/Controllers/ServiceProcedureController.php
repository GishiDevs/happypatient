<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;

class ServiceProcedureController extends Controller
{   
    public function index()
    {
        
    }

    public function create()
    {   
        $services = Service::all();
        return view('pages.service_procedure.create', compact('services'));
    }

    public function store(Request $request)
    {
        return $request;
    }
}
