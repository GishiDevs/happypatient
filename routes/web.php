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





Auth::routes();

// Route::group(['prefix' => '/', 'middleware' => ['auth','dashboard']], function(){
//     Route::get('', [
//         'uses' => 'DashboardController@index',
//         'as' => 'dashboard.index',
//     ]);
//     Route::get('/patient-information', [
//         'uses' => 'DashboardController@getpatientrecord',
//         'as' => 'dashboard.getpatientrecord',
//     ]);
// });

Route::get('/', 'DashboardController@index')->name('dashboard.index')->middleware('auth');
Route::get('/patient-information', 'DashboardController@getpatientlists')->name('getpatientlists')->middleware('auth');

Route::post('/check_patient_transaction', 'TransactionController@check_patient_transaction')->name('check_patient_transaction')->middleware('auth');
Route::get('/transactions_preview/{param}', 'TransactionController@transactions_preview')->name('transactions_preview')->middleware('auth');;


Route::group(['prefix' => 'transactions', 'middleware' => ['auth', 'transactions']], function(){
    Route::get('/', 'TransactionController@index')->name('transactions.index');
    Route::post('/gettransactions', 'TransactionController@gettransactions')->name('gettransactions');
    Route::get('/reports', 'TransactionController@reports')->name('reports');
});


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
    Route::get('/history/{id}', [
        'uses' => 'PatientController@history',
        'as' => 'patient.history',
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

    Route::get('/diagnosis/{id}', [
        'uses' => 'PatientController@diagnosis',
        'as' => 'patient.diagnosis',
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

//Services Procedure Route
Route::group(['prefix' => 'serviceprocedure', 'middleware' => ['auth','service_procedure_crud']], function(){
    Route::get('/index', [
        'uses' => 'ServiceProcedureController@index',
        'as' => 'serviceprocedure.index',
    ]);
    Route::get('/create', [
        'uses' => 'ServiceProcedureController@create',
        'as' => 'serviceprocedure.create',
    ]);
    Route::post('/store', [
        'uses' => 'ServiceProcedureController@store',
        'as' => 'serviceprocedure.store',
    ]);
    Route::get('/procedures', [
        'uses' => 'ServiceProcedureController@getprocedurerecord',
        'as' => 'getprocedurerecord',
    ]);
    Route::post('/serviceprocedures', [
        'uses' => 'ServiceProcedureController@serviceprocedures',
        'as' => 'serviceprocedures',
    ]);
    Route::post('/edit', [
        'uses' => 'ServiceProcedureController@edit',
        'as' => 'serviceprocedure.edit',
    ]);
    Route::post('/update', [
        'uses' => 'ServiceProcedureController@update',
        'as' => 'serviceprocedure.update',
    ]);
    Route::post('/delete', [
        'uses' => 'ServiceProcedureController@delete',
        'as' => 'serviceprocedure.delete',
    ]);
    Route::get('/content/create/{id}', [
        'uses' => 'ServiceProcedureController@content_create',
        'as' => 'content.create',
    ]);
    Route::post('/content/update/{id}', [
        'uses' => 'ServiceProcedureController@content_update',
        'as' => 'content.update',
    ]);
    Route::get('/content/preview/{id}', [
        'uses' => 'ServiceProcedureController@content_preview',
        'as' => 'content.preview',
    ]);

});


//Patient Services
Route::group(['prefix' => 'patientservice', 'middleware' => ['auth','patient_service']], function(){
    
    Route::get('/index', [
        'uses' => 'PatientServiceController@index',
        'as' => 'patientservice.index',
    ]);

    Route::get('/create', [
        'uses' => 'PatientServiceController@create',
        'as' => 'patientservice.create',
    ]);
    Route::post('/store', [
        'uses' => 'PatientServiceController@store',
        'as' => 'patientservice.store',
    ]);
    Route::get('/edit/{id}', [
        'uses' => 'PatientServiceController@edit',
        'as' => 'patientservice.edit',
    ]);
    Route::post('/update/{id}', [
        'uses' => 'PatientServiceController@update',
        'as' => 'patientservice.update',
    ]);
    Route::post('/update_price', [
        'uses' => 'PatientServiceController@update_price',
        'as' => 'patientservice.update_price',
    ]);
    Route::post('/cancel/{id}', [
        'uses' => 'PatientServiceController@cancel',
        'as' => 'patientservice.cancel',
    ]);
    Route::post('/add_item/{id}', [
        'uses' => 'PatientServiceController@add_item',
        'as' => 'patientservice.add_item',
    ]);
    Route::post('/remove_item', [
        'uses' => 'PatientServiceController@remove_item',
        'as' => 'patientservice.remove_item',
    ]);
    Route::get('/services-list-per-user', [
        'uses' => 'PatientServiceController@servicesperuser',
        'as' => 'patientservice.servicesperuser',
    ]);
    Route::post('/services-list', [
        'uses' => 'PatientServiceController@serviceslist',
        'as' => 'patientservice.serviceslist',
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


//Diagnosis Route
Route::group(['prefix' => 'diagnosis', 'middleware' => ['auth', 'diagnosis']], function(){
    Route::get('/create/{id}', [
        'uses' => 'DiagnosisController@create',
        'as' => 'diagnosis.create',
    ]);

    Route::post('/store/{id}', [
        'uses' => 'DiagnosisController@store',
        'as' => 'diagnosis.store',
    ]);

    Route::get('/edit/{id}', [
        'uses' => 'DiagnosisController@edit',
        'as' => 'diagnosis.edit',
    ]);

    Route::post('/update/{id}', [
        'uses' => 'DiagnosisController@update',
        'as' => 'diagnosis.update',
    ]);

    Route::post('/view_history/{id}', [
        'uses' => 'DiagnosisController@update',
        'as' => 'diagnosis.update',
    ]);

    Route::get('/print/{id}', [
        'uses' => 'DiagnosisController@print',
        'as' => 'diagnosis.print',
    ]);

});

Route::get('/diagnosis/pdf', function(){
    // $pdf = PDF::loadView('pages.diagnosis.pdf');
    // return $pdf->download('invoice.pdf');
    return view('pages.diagnosis.pdf');
});


//Medical Certificate Template Route
Route::group(['prefix' => 'certificate/template', 'middleware' => ['auth']], function(){

    Route::get('/index', [
        'uses' => 'MedicalCertificateController@index',
        'as' => 'certificate.template.index',
    ]);

    Route::get('/certificate_templates', [
        'uses' => 'MedicalCertificateController@gettemplatelist',
        'as' => 'gettemplatelist',
    ]);
    
    Route::get('/create', [
        'uses' => 'MedicalCertificateController@create',
        'as' => 'certificate.template.create',
    ]);

    Route::post('/store', [
        'uses' => 'MedicalCertificateController@store',
        'as' => 'certificate.template.store',
    ]);

    Route::get('/edit/{id}', [
        'uses' => 'MedicalCertificateController@edit',
        'as' => 'certificate.template.edit',
    ]);

    Route::post('/update/{id}', [
        'uses' => 'MedicalCertificateController@update',
        'as' => 'certificate.template.update',
    ]);

    Route::post('/delete', [
        'uses' => 'MedicalCertificateController@delete',
        'as' => 'certificate.template.delete',
    ]);

    Route::get('/preview/{id}', [
        'uses' => 'MedicalCertificateController@preview',
        'as' => 'certificate.template.preview',
    ]);

});

Route::group(['prefix' => 'logs', 'middleware' => ['auth', 'activity_log']], function(){
    Route::get('/', 'ActivityLogController@index')->name('logs');
    Route::get('/getlogs', 'ActivityLogController@getlogs')->name('getlogs');
});


