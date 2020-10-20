<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = ['object_id', 'table_name', 'description', 'action', 'userid'];
}
