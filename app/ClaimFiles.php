<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimFiles extends Model
{
    protected $table = 'claim_files';
    protected $primaryKey = "claim_files_id";
    public $timestamps = false;

    public function file_claim()
    {
        return $this->belongsTo('App\Claim','claim_id');
    }
}
