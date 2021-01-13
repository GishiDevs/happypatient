<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientServiceItem extends Model
{
    protected $fillable = ['psid', 
                           'serviceid', 
                           'description',
                           'price', 
                           'medicine_amt', 
                           'discount', 
                           'discount_amt', 
                           'total_amount', 
                           'status'];

    public function patient_services()
    {   
        return $this->belongsTo('App\PatientService', 'psid','id');
        //                 ( <Model>, <id_of_this_model>, <id_of_specified_Model> )
    }

    public function services()
    {
        return $this->hasOne('App\Service', 'id', 'serviceid');
        //                 ( <Model>, <id_of_specified_Model>, <id_of_this_model> )
    }

    public function service_procedures()
    {
        return $this->hasOne('App\ServiceProcedure', 'id', 'procedureid');
        //                 ( <Model>, <id_of_specified_Model>, <id_of_this_model> )
    }

}
