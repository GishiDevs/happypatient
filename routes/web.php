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
    return view('pages.patient.index');
})->middleware('auth');

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
        'uses' => 'PatientController@update',
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

//Permissions
Route::group(['prefix' => 'permission', 'middleware' => ['auth','permission_crud']], function(){
    Route::get('/index', [
        'uses' => 'PermissionController@index',
        'as' => 'permission.index',
    ]);
    Route::get('/create', [
        'uses' => 'PermissionController@create',
        'as' => 'permission.create',
    ]);
    Route::post('/store', [
        'uses' => 'PermissionController@store',
        'as' => 'permission.store',
    ]);
    Route::get('/permissions', [
        'uses' => 'PermissionController@getpermissionrecord',
        'as' => 'getpermissionrecord',
    ]);
    Route::post('/edit', [
        'uses' => 'PermissionController@edit',
        'as' => 'permission.edit',
    ]);
    Route::post('/update', [
        'uses' => 'PermissionController@update',
        'as' => 'permission.update',
    ]);
    Route::post('/delete', [
        'uses' => 'PermissionController@delete',
        'as' => 'permission.delete',
    ]);

});

//Roles
Route::group(['prefix' => 'role', 'middleware' => ['auth','role_crud']], function(){
    Route::get('/index', [
        'uses' => 'RoleController@index',
        'as' => 'role.index',
    ]);
    Route::get('/create', [
        'uses' => 'RoleController@create',
        'as' => 'role.create',
    ]);
    Route::post('/store', [
        'uses' => 'RoleController@store',
        'as' => 'role.store',
    ]);
    Route::get('/roles', [
        'uses' => 'RoleController@getrolerecord',
        'as' => 'getrolerecord',
    ]);
    Route::post('/edit', [
        'uses' => 'RoleController@edit',
        'as' => 'role.edit',
    ]);
    Route::post('/update', [
        'uses' => 'RoleController@update',
        'as' => 'role.update',
    ]);
    Route::post('/delete', [
        'uses' => 'RoleController@delete',
        'as' => 'role.delete',
    ]);

});

//User Route
Route::group(['prefix' => 'user', 'middleware' => ['auth','user_crud']], function(){
    Route::get('/index', [
        'uses' => 'UserController@index',
        'as' => 'user.index',
    ]);
    Route::get('/create', [
        'uses' => 'UserController@create',
        'as' => 'user.create',
    ]);
    Route::post('/store', [
        'uses' => 'UserController@store',
        'as' => 'user.store',
    ]);
    Route::get('/users', [
        'uses' => 'UserController@getuserrecord',
        'as' => 'getuserrecord',
    ]);
    Route::get('/view/{id}', [
        'uses' => 'UserController@view',
        'as' => 'user.view',
    ]);
    Route::get('/edit/{id}', [
        'uses' => 'UserController@edit',
        'as' => 'user.edit',
    ]);
    Route::post('/update/{id}', [
        'uses' => 'UserController@update',
        'as' => 'user.update',
    ]);
    
    Route::post('/delete', [
        'uses' => 'UserController@delete',
        'as' => 'user.delete',
    ]);
});