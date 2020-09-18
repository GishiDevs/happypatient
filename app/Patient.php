<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = ['lastname',
                           'firstname',
                           'middlename',
                           'birthdate',
                           'weight',
                           'gender',
                           'age',
                           'civilstatus',
                           'landline',
                           'mobile',
                           'email',
                           'address',
                           'province',
                           'city',
                           'barangay'];
}
