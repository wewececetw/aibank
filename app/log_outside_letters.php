<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class log_outside_letters extends Model
{
    //
    protected $table = 'log_outside_letters';
    protected $primaryKey = 'log_o_letter_id';
    public $timestamps = false;
    protected $guarded = [];
}
