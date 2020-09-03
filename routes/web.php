<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('auth.login');
});


Auth::routes();

//Patient Route
Route::group(['prefix' => 'patient', 'middleware' => ['auth','patient_crud']], function(){
    Route::get('/index', [
        'uses' => 'PatientController@index',
        'as' => 'patient.index',
    ]);
    Route::get('/create', [
        'uses' => 'PatientController@create',
        'as' => 'patient.create',
    ]);
    Route::post('/store', [
        'uses' => 'PatientController@store',
        'as' => 'patient.store',
    ]);
    Route::get('/patients', [
        'uses' => 'PatientController@getpatientrecord',
        'as' => 'getpatientrecord',
    ]);
    Route::get('/view/{id}', [
        'uses' => 'PatientController@view',
        'as' => 'patient.view',
    ]);
    Route::get('/edit/{id}', [
        'uses' => 'PatientController@edit',
        'as' => 'patient.edit',
    ]);
    Route::post('/update/{id}', [
        'uses' => 'PatientController@edit',
        'as' => 'patient.update',
    ]);
    
    Route::post('/delete', [
        'uses' => 'PatientController@delete',
        'as' => 'patient.delete',
    ]);
});



//Addresses Route
Route::get('provinces', 'PatientController@getprovinces')->name('getprovinces');
Route::post('cities', 'PatientController@getcities')->name('getcities');
Route::post('barangays', 'PatientController@getbarangays')->name('getbarangays');

//Services Route
Route::group(['prefix' => 'service', 'middleware' => ['auth','service_crud']], function(){
    Route::get('/index', [
        'uses' => 'ServiceController@index',
        'as' => 'service.index',
    ]);
    Route::get('/create', [
        'uses' => 'ServiceController@create',
        'as' => 'service.create',
    ]);
    Route::post('/store', [
        'uses' => 'ServiceController@store',
        'as' => 'service.store',
    ]);
    Route::get('/services', [
        'uses' => 'ServiceController@getservicerecord',
        'as' => 'getservicerecord',
    ]);
    Route::post('/edit', [
        'uses' => 'ServiceController@edit',
        'as' => 'service.edit',
    ]);
    Route::post('/update', [
        'uses' => 'ServiceController@update',
        'as' => 'service.update',
    ]);
    Route::post('/delete', [
        'uses' => 'ServiceController@delete',
        'as' => 'service.delete',
    ]);

});

//Patient Services
Route::group(['prefix' => 'patientservice', 'middleware' => ['auth','patient_service']], function(){
    Route::get('/create', [
        'uses' => 'PatientServiceController@create',
        'as' => 'patientservice.create',
    ]);
    Route::get('/store', [
        'uses' => 'PatientServiceController@store',
        'as' => 'patientservice.store',
    ]);
});
