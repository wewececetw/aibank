<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Tenders extends Model
{
    protected $table = 'tender_documents';
    protected $primaryKey = 'tender_documents_id';
    public $timestamps = false;

    public function tenders_user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    public function tenders_claim()
    {
        return $this->belongsTo('App\Claim','claim_id');
    }
    public function tenders_repayment()
    {
        return $this->hasMany('App\TenderRepayments','tender_documents_id');
    }
    public function tenders_order()
    {
        return $this->hasOne('App\Order','order_id');
    }

    public function scopeFilter($query,$filter_query)
    {
        foreach($filter_query as $key => $value)
        {
            $targetTable = str_split($key,'.')[0];
            $column = str_split($key,'.')[1];
            if($value != '')
            {
                $query-> whereHas($targetTable  , function($q)
                {
                    $q->where($column,'like','%'.$value.'%');
                });
            }
        }
    }

    public function getTenderDocumentStateAttribute($v){
        switch ($v) {
            case 0:
                return '未繳款';
                break;
            case 1 :
                return "已繳款";
                break;
            case 2 :
                return "還款中";
                break;
            case 3 :
                return "已流標";
                break;
            case 4 :
                return "已結案";
                break;
            case 5 :
                return "待繳款";
                break;
            case 6 :
                return "已退款";
                break;
            case 7 :
                return "異常";
                break;
            case 8 :
                return "棄標";
                break;
            default:
                return $v;
                break;
        }
    }
    public static function nameSwitch($column,$v){
        if($column == 'risk_category'){
            switch ($v) {
                case 'A':
                    return 0;
                    break;
                case 'B':
                    return 1;
                    break;
                case 'C':
                    return 2;
                    break;
                case 'D':
                    return 3;
                    break;
                case 'E':
                    return 4;
                    break;
                case 'V':
                    return 5;
                    break;
                case 'H':
                    return 6;
                    break;
                case 'M':
                    return 7;
                    break;
                case 'S':
                    return 8;
                    break;
                default:
                    return $v;
                    break;
        }
                }

        else if($column == 'repayment_method'){
            switch ($v) {
                case '先息後本':
                    return 0;
                    break;
                case '本息攤還':
                    return 1;
                    break;
                default:
                    return $v;
                    break;
        }
                }
        else if($column == 'claim_state'){
            switch ($v) {
                case '上架預覽':
                    return 0;
                    break;
                case '募集中':
                    return 1;
                    break;
                case '結標繳款':
                    return 2;
                    break;
                case '已流標':
                    return 3;
                    break;
                case '繳息還款':
                    return 4;
                    break;
                case '回收結案':
                    return 5;
                    break;

                default:
                    return $v;
                    break;
        }
                }
        else if($column == 'foreign'){
            switch ($v) {
                case '報稅':
                    return 0;
                    break;
                case '不報稅':
                    return 1;
                    break;
                default:
                    return $v;
                    break;
        }
                }
        else if($column == 'foreign_t'){
            switch ($v) {
                case '國內':
                    return 0;
                    break;
                case '海外':
                    return 1;
                    break;
                default:
                    return $v;
                    break;
        }
                }
        else
        {return $v;}


    }

    public function getTableColumns()
    {
        return $this
            ->getConnection()
            ->getSchemaBuilder()
            ->getColumnListing($this->getTable());
    }



    /**
     * 取得KYC我的帳戶資料
     */
    public function getAccountTenderData($query,$user_id,$stateArray)
    {
        return $query->from('tender_documents as td')
            ->leftJoin('claims as c','c.claim_id','td.claim_id')
            ->leftJoin('tender_repayments as tr','tr.tender_documents_id','td.tender_documents_id')
            ->where('td.user_id',$user_id)
            ->whereIn('td.tender_document_state',$stateArray)
            ->select('c.risk_category',
                    'td.tender_documents_id',
                    'td.claim_id',
                    'td.claim_certificate_number',
                    DB::raw('DATE_FORMAT(c.value_date,"%Y-%m-%d") as value_date'),
                    'td.tender_document_state',
                    DB::raw('FORMAT(td.amount,0) as amount'),
                    'c.annual_interest_rate',
                    'c.claim_state',
                    DB::raw('FORMAT(td.amount - SUM(
                                 CASE WHEN tr.paid_at IS NOT NULL THEN tr.per_return_principal ELSE 0
                             END
                    ),0) AS not_yet_principal'),
                    'td.claim_pdf_path'
            )
            ->groupBy('td.user_id','td.tender_documents_id')
            ->orderBy('c.value_date','desc')
            ->get();
    }
    /**
     * kyc account 已繳款
     */
    public function scopeAccountIsPaid($query,$user_id)
    {
        $data = $this->getAccountTenderData($query,$user_id,[1,2,4]);
        return $data->toArray();
    }
    /**
     * kyc account 未繳款
     */
    public function scopeAccountUnPaid($query,$user_id)
    {
        $data = $this->getAccountTenderData($query,$user_id,[0,5]);
        return $data->toArray();
    }
    /**
     * kyc account 流標
     */
    public function scopeAccountFailure($query,$user_id)
    {
        $data = $this->getAccountTenderData($query,$user_id,[3]);
        return $data->toArray();
    }
/* ----------------------Main Flow Function Start---------------------------------------------------- */

/* ----------------------Main Flow Function End---------------------------------------------------- */

}
