<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class log_internal_letters extends Model
{
    //
    protected $table = 'log_internal_letters';
    protected $primaryKey = 'log_internal_letter_id';
    public $timestamps = false;
    protected $guarded = [];
}
