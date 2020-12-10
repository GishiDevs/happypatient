<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiagnosisSignatory extends Model
{
    protected $fillable = ['userid', 'diagnosisid'];

    public function users()
    {
        return $this->belongsTo('App\User', 'userid','id');
        //                 ( <Model>, <id_of_this_model>, <id_of_specified_Model> )
    }

}
