<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    protected $fillable = ['ps_items_id',
                           'physician',
                           'bloodpressure',
                           'title',
                           'content'];
}
