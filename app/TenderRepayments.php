<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Tenders;
use App\User;
use DB;

class TenderRepayments extends Model
{
    protected $table = 'tender_repayments';
    protected $primaryKey = "tender_repayment_id";
    public $timestamps = false;

    public function repayment_tenders()
    {
        return $this->belongsTo('App\Tenders','tender_documents_id');
    }
    // public function getUserTypeAttribute($v)
    // {
    //     switch ($v) {
    //         case 0:
    //             return '未還款';
    //             break;
    //         case 1 :
    //             return "應還款而未還款";
    //             break;
    //         case 2 :
    //             return "已還款";
    //             break;


    //         default:
    //             return $v;
    //             break;
    //     }
    // }
    /**
     * 未繳款
     */
    public function account_not_pay()
    {
        // $data = $this->from('tender_repayments as tr')
        // ->leftJoin('tender_documents as td','td.tender_documents_id','tr.tender_documents_id')
        // ->leftJoin('users as u','u.user_id','td.user_id')
        // ->whereNull('tr.paid_at')

    }

    /**
     * findUser
     *
     * @return void
     */
    // public function scopeFindUser($query)
    // {
    //     return $this->with('repayment_tenders')
    // }
}
