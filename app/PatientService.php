<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientService extends Model
{
    protected $fillable = ['type',
                           'patientid', 
                           'name',
                           'docdate', 
                           'bloodpressure', 
                           'weight',
                           'temperature',
                           'or_number', 
                           'note', 
                           'grand_total', 
                           'status', 
                           'cancelled',
                           'canceldate'];

    public function patient_service_items()
    {
        return $this->hasMany('App\PatientServiceItem', 'psid', 'id');
        //                 ( <Model>, <id_of_specified_Model>, <id_of_this_model> )
    }
    
}
