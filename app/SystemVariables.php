<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemVariables extends Model
{
    protected $table = 'system_variables';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
