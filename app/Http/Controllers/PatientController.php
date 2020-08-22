<?php

namespace App\Http\Controllers;

use App\Patient;
use Illuminate\Http\Request;
use Yajra\Address\Entities\City;
use Yajra\Address\Entities\Region;
use Yajra\Address\Entities\Province;
use Yajra\Address\Entities\Barangay;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

   
    public function create()
    {   
        return view('pages.patient.create');
    }

    public function getprovinces()
    {
        $provinces = Province::all()->sortBy('name')->values();

        return response()->json($provinces, 200);
    }

    public function getcities(Request $request)
    {   

        $province_id = $request->get('province_id');
        $cities = City::where('province_id', $province_id)->get()->sortBy('name')->values();

        return response()->json($cities, 200);
        
    }

    public function getbarangays(Request $request)
    {
        $city_id = $request->get('city_id');
        $barangays = Barangay::where('city_id', $city_id)->get()->sortBy('name')->values();

        return response()->json($barangays, 200);

    }

 
    public function store(Request $request)
    {
        //
    }


    public function show(Patient $patient)
    {
        //
    }


    public function edit(Patient $patient)
    {
        //
    }


    public function update(Request $request, Patient $patient)
    {
        //
    }


    public function destroy(Patient $patient)
    {
        //
    }
}
