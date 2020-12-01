<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['service', 'status'];

    public function patient_service_items()
    {
        return $this->belongsTo('App\PatientServiceItem', 'id', 'serviceid');
        //                 ( <Model>, <id_of_this_model>, <id_of_specified_Model> )
    }

    public function service_procedures()
    {
        return $this->hasMany('App\ServiceProcedure', 'serviceid', 'id');
        //                 ( <Model>, <id_of_specified_Model>, <id_of_this_model> )
    }
}
