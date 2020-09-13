<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientService extends Model
{
    protected $fillable = ['patientid', 'patientname', 'docdate', 'or_number', 'note', 'grand_total'];

    public function PatientServiceItems()
    {
        return $this->hasMany('App\PatientServiceItem', 'psid', 'id');
    }
    
}
