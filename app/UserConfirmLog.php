<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserConfirmLog extends Model
{
    protected $table = 'users_confirm_log';
    protected $primaryKey = 'users_confirm_log_id';
    public $timestapms = false;
}
