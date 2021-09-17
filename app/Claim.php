<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\DataTables;

class Claim extends Model
{
    use DataTables;
    protected $table = 'claims';
    protected $primaryKey = "claim_id";
    public $timestamps = false;

    public function claim_tenders()
    {
        return $this->hasMany('App\Tenders','claim_id');
    }
    public function file_claim()
    {
        return $this->hasMany('App\ClaimFiles','claim_id');
    }



    public function getTableColumns()
    {
        return $this
            ->getConnection()
            ->getSchemaBuilder()
            ->getColumnListing($this->getTable());
    }
    public function getClaimStateAttribute($v){
        switch ($v) {
            case 0:
                return "上架預覽";
                break;
            case 1 :
                return "募集中";
                break;
            case 2 :
                return "結標繳款";
                break;
            case 3 :
                return "已流標";
                break;
            case 4 :
                return "繳息還款";
                break;
            case 5 :
                return "回收結案";
                break;
            case 6 :
                return "異常";
                break;

            default:
                return $v;
                break;
        }
    }
    public function getRepaymentMethodAttribute($v){
        switch ($v) {
            case 0:
                return "先息後本";
                break;
            case 1 :
                return "本息攤還";
                break;


            default:
                return $v;
                break;
        }
    }
    public function getCooperativeCompanyIdAttribute($v){
        switch ($v) {
            case 0:
                return "亞太普惠金融科技有限公司";
                break;


            default:
                return $v;
                break;
        }
    }
    /*
    public function getGenderAttribute($v){
        switch ($v) {
            case 0:
                return "男";
                break;
            case 1 :
                return "女";
                break;
            case 2 :
                return "其他";
                break;


            default:
                return $v;
                break;
        }
    }
    */
    public function getRiskCategoryAttribute($v){
        switch ($v) {
            case 0:
                return "A";
                break;
            case 1 :
                return "B";
                break;
            case 2 :
                return "C";
                break;
            case 3 :
                return "D";
                break;
            case 4 :
                return "E";
                break;
            case 5 :
                return "V";
                break;
            case 6 :
                return "H";
                break;
            case 7 :
                return "M";
                break;
            case 8 :
                return "S";
                break;

            default:
                return $v;
                break;
            }
        }
        public function getForeignAttribute($v){
            switch ($v) {
                case 0:
                    return "報稅";
                    break;
                case 1 :
                    return "不報稅";
                    break;


                default:
                    return $v;
                    break;
            }
        }
        public function getForeignTAttribute($v){
            switch ($v) {
                case 0:
                    return "國內";
                    break;
                case 1 :
                    return "海外";
                    break;


                default:
                    return $v;
                    break;
            }
        }
        public function getLoanTypeAttribute($v){
            switch ($v) {
                case 0:
                    return "應收帳款轉讓";
                    break;



                default:
                    return $v;
                    break;
            }
        }

        // public function getGroupingAttribute($v){
        //     switch ($v) {
        //         case 0:
        //             return "S";
        //             break;
        //         case 1:
        //             return "asdf";
        //             break;

        //         default:
        //             return $v;
        //             break;
        //     }
        // }

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

    /**
     * 判斷是否需要寄送開標信用
     *
     * @param  mixed $query
     * @return bool true = 要寄
     */
    public function scopeNeedBidOpenMail($query)
    {
        $c = $query->where('claim_state',1)->where('is_send_start',0)->count();
        if($c == 0){
            return false;
        }else{
            return true;
        }
    }

    public function scopeUpdateIsSendStart($query)
    {
        return $query->where('claim_state',1)->where('is_send_start',0)->update([
            'is_send_start' => 1
        ]);
    }

    public function scopeFindClaimState($query,$claimId)
    {
        return $query->find($claimId)->getOriginal('claim_state');
    }
    public function scopeFindOriginalClaimAmount($query,$claimId)
    {
        return $query->find($claimId)->original_claim_amount;
    }
}
