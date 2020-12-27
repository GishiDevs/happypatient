<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TemplateContent extends Model
{
    protected $fillable = ['procedureid', 'content'];

    public function service_procedures()
    {
        return $this->belongsTo('App\ServiceProcedure', 'procedureid','id');
        //                 ( <Model>, <id_of_this_model>, <id_of_specified_Model> )
    }

}
