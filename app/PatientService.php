<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientService extends Model
{
    protected $fillable = ['patientid', 'patientname', 'docdate'];
}
