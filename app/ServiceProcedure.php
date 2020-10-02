<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceProcedure extends Model
{
    protected $fillable = ['serviceid', 'procedure', 'price'];
}
