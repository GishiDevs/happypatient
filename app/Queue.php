<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    protected $fillable = ['psid', 'queue_no'];

    public function patient_services()
    {   
        return $this->belongsTo('App\PatientService', 'psid','id');
        //                 ( <Model>, <id_of_this_model>, <id_of_specified_Model> )
    }
}
