<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $table = 'data_value';
    protected $primaryKey = "value_name";
    public $timestamps = false;
    protected $keyType = 'string';
    public $incrementing = false;
}
