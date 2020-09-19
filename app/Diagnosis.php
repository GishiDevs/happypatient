<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    protected $fillable = ['ps_items_id',
                           'file_no',
                           'docdate',
                           'physician',
                           'bloodpressure',
                           'title',
                           'content'];
}
