<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientService extends Model
{
    protected $fillable = ['patientid', 
                           'patientname', 
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

    public function PatientServiceItems()
    {
        return $this->hasMany('App\PatientServiceItem', 'psid', 'id');
    }
    
}
