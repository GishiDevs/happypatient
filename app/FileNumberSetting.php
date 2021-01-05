<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileNumberSetting extends Model
{

    protected $fillable = ['serviceid', 'year', 'start', 'end'];

    public function services()
    {
        return $this->belongsTo('App\Service', 'serviceid','id');
        //                 ( <Model>, <id_of_this_model>, <id_of_specified_Model> )
    }
}
