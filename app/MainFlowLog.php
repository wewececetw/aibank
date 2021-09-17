<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MainFlowLog extends Model
{
    protected $table = 'mainflow_log';
    protected $primaryKey = 'mainflow_id';
    public $timestamps = false;
}
