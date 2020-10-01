<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientServiceItem extends Model
{
    protected $fillable = ['psid', 'serviceid', 'price', 'discount', 'discount_amt', 'total_amount', 'status'];

    public function PatientServiceItemNames()
    {
        return $this->belongsTo('App\Service', 'serviceid', 'id');
    }

}
