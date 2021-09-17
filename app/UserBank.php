<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBank extends Model
{
    protected $table = 'user_bank';

    protected $primaryKey = 'user_bank_id';

    // protected $keyType = 'string';

    public $incrementing = false;

    public $timestapms = false;

    public function userbank_user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    public function userbank_banklist()
    {
        return $this->belongsTo('App\BankList','bank_id');
    }
    public function getIsActiveAttribute($v)
    {
        switch ($v) {
            case 0:
                return '否';
                break;
            case 1 :
                return "是";
                break;


            default:
                return $v;
                break;
        }
    }
    public function getStateAttribute($v)
    {
        switch ($v) {
            case 0:
                return '待定義';
                break;
            case 1 :
                return "待定義";
                break;


            default:
                return $v;
                break;
        }
    }


    /**
     * 確認使用者銀行帳戶綁定
     *
     * @param  mixed $user_id
     * @return void
     */
    public function scopeCheckUserBank($query,$user_id)
    {
        try {
            $res = $query->where('user_id',$user_id)->where('is_active',1)->count();
            if($res > 0){
                return true;
            }else{
                return false;
            }
        } catch (\Throwable $th) {
            //throw $th;
            return false;
        }
    }
}
