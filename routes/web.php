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


Route::get('patient/create', 'PatientController@create')->name('createpatient');
Route::post('patient/store', 'PatientController@store')->name('storepatient');
Route::get('patient/record', 'PatientController@index')->name('patientrecord');
Route::get('patients', 'PatientController@getpatientrecord')->name('getpatientrecord');
Route::post('patient/view', 'PatientController@view')->name('viewpatient');
Route::post('patient/edit', 'PatientController@edit')->name('editpatient');
Route::post('patient/delete', 'PatientController@delete')->name('deletepatient');

Route::get('provinces', 'PatientController@getprovinces')->name('getprovinces');
Route::post('cities', 'PatientController@getcities')->name('getcities');
Route::post('barangays', 'PatientController@getbarangays')->name('getbarangays');