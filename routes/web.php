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
    return view('pages.patient.create');
});


Auth::routes();

//Patient Route
Route::get('patient/create', 'PatientController@create')->name('createpatient');
Route::post('patient/store', 'PatientController@store')->name('storepatient');
Route::get('patient/record', 'PatientController@index')->name('patientrecord');
Route::get('patients', 'PatientController@getpatientrecord')->name('getpatientrecord');
Route::get('patient/view/{id}', 'PatientController@view')->name('viewpatient');
Route::get('patient/edit/{id}', 'PatientController@edit')->name('editpatient');
Route::post('patient/update/{id}', 'PatientController@update')->name('updatepatient');
Route::post('patient/delete', 'PatientController@delete')->name('deletepatient');

//Addresses Route
Route::get('provinces', 'PatientController@getprovinces')->name('getprovinces');
Route::post('cities', 'PatientController@getcities')->name('getcities');
Route::post('barangays', 'PatientController@getbarangays')->name('getbarangays');

//Services Route
Route::get('service/record', 'ServiceController@index')->name('servicerecord');
Route::get('service/create', 'ServiceController@create')->name('createservice');
Route::post('service/store', 'ServiceController@store')->name('storeservice');
Route::get('services', 'ServiceController@getservicerecord')->name('getservicerecord');
Route::post('service/edit', 'ServiceController@edit')->name('editservice');
Route::post('service/update', 'ServiceController@update')->name('updateservice');
Route::post('service/delete', 'ServiceController@delete')->name('deleteservice');

//Patient Services
Route::get('patientservices/create', 'PatientServiceController@create')->name('createpatientservice');
