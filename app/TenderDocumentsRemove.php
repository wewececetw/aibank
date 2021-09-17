<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TenderDocumentsRemove extends Model
{
    protected $table = 'tender_documents_remove';
    protected $primaryKey = 'tender_documents_id';
    public $timestamps = false;
    protected $guarded = [];

}
