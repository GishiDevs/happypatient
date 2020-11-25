<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalCertificate extends Model
{
    protected $fillable = ['name', 'content'];
}
