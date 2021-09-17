<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankList extends Model
{
    protected $table = 'bank_lists';

    protected $primaryKey = 'bank_id';

    // protected $keyType = 'string';

    public $incrementing = false;

    public $timestapms = false;

    
}
