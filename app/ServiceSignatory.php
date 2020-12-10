<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceSignatory extends Model
{
    protected $fillable = ['userid', 'serviceid'];

    public function services()
    {
        return $this->belongsTo('App\Service', 'serviceid','id');
        //                 ( <Model>, <id_of_this_model>, <id_of_specified_Model> )
    }

    public function users()
    {
        return $this->belongsTo('App\User', 'userid','id');
        //                 ( <Model>, <id_of_this_model>, <id_of_specified_Model> )
    }

}
