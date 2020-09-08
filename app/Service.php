<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['service', 'status'];

    public function patientserviceitemnames()
    {
        return $this->hasMany('App\PatientServiceItem', 'serviceid', 'id');
    }
}
