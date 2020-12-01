<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceProcedure extends Model
{
    protected $fillable = ['serviceid', 'code', 'procedure', 'price', 'to_diagnose'];

    public function services()
    {
        return $this->belongsTo('App\Service', 'serviceid','id');
        //                 ( <Model>, <id_of_this_model>, <id_of_specified_Model> )
    }

    public function patient_service_items()
    {
        return $this->belongsTo('App\PatientServiceItem', 'proceudreid','id');
        //                 ( <Model>, <id_of_this_model>, <id_of_specified_Model> )
    }
}
