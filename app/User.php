<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\UsersRoles;
use App\UserConfirmLog;
use App\Tenders;
use App\TenderRepayments;
use DB;
// use Laravel\Passport\HasApiTokens;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class User extends Authenticatable
{

    use Notifiable;

    protected $table = 'users';

    protected $primaryKey = 'user_id';

    protected $keyType = 'string';

    public $incrementing = false;

    public $timestapms = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'name', 'email', 'password',
    // ];
    // protected $fillable = [
    //     'email', 'user_name','encrypted_password','confirmation_token','updated_at','user_state','id_back_file_name'
    // ];
    protected $guarded = ['user_id'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['role_id'];
    public function getRoleIdAttribute()
    {
        try {
            $role = UsersRoles::where('user_id',$this->user_id)->first()->role_id;
        } catch (\Throwable $th) {
            $role = 'N';
        }
        return $role;
    }


    public function user_tenders()
    {
        return $this->hasMany('App\Tenders','user_id');
    }

    public function user_letters()
    {
        return $this->hasMany('App\Letters','user_id');
    }
    public function user_banklist()
    {
        return $this->hasManyThrough('App\BankList',
                                     'App\UserBank',
                                     'bank_id',
                                     'bank_id',
                                     'user_id',
                                     'user_id');
    }
    public function user_order()
    {
        return $this->hasManyThrough('App\Order',
                                     'App\Tenders',
                                     'order_id',
                                     'order_id',
                                     'user_id',
                                     'user_id');
    }



    public function user_userbank()
    {
        return $this->hasMany('App\UserBank','user_id');
    }


    public function getTableColumns()
    {
        return $this
            ->getConnection()
            ->getSchemaBuilder()
            ->getColumnListing($this->getTable());
    }
    public function getUserTypeAttribute($v)
    {
        switch ($v) {
            case 0:
                return '???????????????';
                break;
            case 1 :
                return "????????????";
                break;
            case 2 :
                return "??????????????????";
                break;
            case 3 :
                return "????????????";
                break;
            case 4 :
                return "????????????";
                break;
            case 5 :
                return "??????????????????";
                break;
            case 6 :
                return "alert";
                break;

            default:
                return $v;
                break;
        }
    }
    public function getIsReceiveLetterAttribute($v)
    {
        switch($v){
            case 0:
                return '??????';
            break;
            case 1:
                return '??????';
            break;
            default:
                return '????????????';
        break;
        }
    }


    // public function getContactAddressAttribute($v)
    // {
    //     switch ($v) {
    //         case 0:
    //             return '?????????';
    //             break;
    //         case 1 :
    //             return "?????????";
    //             break;
    //         case 2 :
    //             return "?????????";
    //             break;
    //         case 3 :
    //             return "?????????";
    //             break;
    //         case 4 :
    //             return "?????????";
    //             break;
    //         case 5 :
    //             return "?????????";
    //             break;
    //         case 6 :
    //             return "?????????";
    //             break;
    //         case 7:
    //             return '?????????';
    //             break;
    //         case 8 :
    //             return "?????????";
    //             break;
    //         case 9 :
    //             return "?????????";
    //             break;
    //         case 10 :
    //             return "?????????";
    //             break;
    //         case 11 :
    //             return "?????????";
    //             break;
    //         case 12 :
    //             return "?????????";
    //             break;
    //         case 13 :
    //             return "?????????";
    //             break;
    //         case 14:
    //             return '?????????';
    //             break;
    //         case 15 :
    //             return "?????????";
    //             break;
    //         case 16 :
    //             return "?????????";
    //             break;
    //         case 17 :
    //             return "?????????";
    //             break;
    //         case 18 :
    //             return "?????????";
    //             break;
    //         case 19 :
    //             return "?????????";
    //             break;

    //         default:
    //             return $v;
    //             break;
    //     }
    // }
    // public function getResidenceAddressAttribute($v)
    // {
    //     switch ($v) {
    //         case 0:
    //             return '?????????';
    //             break;
    //         case 1 :
    //             return "?????????";
    //             break;
    //         case 2 :
    //             return "?????????";
    //             break;
    //         case 3 :
    //             return "?????????";
    //             break;
    //         case 4 :
    //             return "?????????";
    //             break;
    //         case 5 :
    //             return "?????????";
    //             break;
    //         case 6 :
    //             return "?????????";
    //             break;
    //         case 7:
    //             return '?????????';
    //             break;
    //         case 8 :
    //             return "?????????";
    //             break;
    //         case 9 :
    //             return "?????????";
    //             break;
    //         case 10 :
    //             return "?????????";
    //             break;
    //         case 11 :
    //             return "?????????";
    //             break;
    //         case 12 :
    //             return "?????????";
    //             break;
    //         case 13 :
    //             return "?????????";
    //             break;
    //         case 14:
    //             return '?????????';
    //             break;
    //         case 15 :
    //             return "?????????";
    //             break;
    //         case 16 :
    //             return "?????????";
    //             break;
    //         case 17 :
    //             return "?????????";
    //             break;
    //         case 18 :
    //             return "?????????";
    //             break;
    //         case 19 :
    //             return "?????????";
    //             break;

    //         default:
    //             return $v;
    //             break;
    //     }
    // }

    public function getIsAlertAttribute($v)
    {
        switch ($v) {
            case 0:
                return '???';
                break;
            case 1 :
                return "???";
                break;


            default:
                return $v;
                break;
                    }
    }
    public function getIsUserIdCheckAttribute($v)
    {
        switch ($v) {
            case 0:
                return '????????????';
                break;
            case 1 :
                return "?????????";
                break;


            default:
                return $v;
                break;
                    }
    }
    public function getBannedAttribute($v)
    {
        switch ($v) {
            case 0:
                return '???';
                break;
            case 1 :
                return "???";
                break;


            default:
                return $v;
                break;
            }
        }
    public function getIsSuperPusherAttribute($v)
    {
        switch ($v) {
            case 0:
                return '???';
                break;
            case 1 :
                return "???";
                break;


            default:
                return $v;
                break;
            }
        }

    // public function getUserStateAttribute($v)
    // {
    //     switch ($v) {

    //         case 0:
    //             return "?????????";
    //             break;
    //         case 1 :
    //             return "????????????";
    //             break;
    //         case 2 :
    //             return "?????????????????????";
    //             break;

    //         case -1:
    //             return "??????";
    //             break;
    //         case -2:
    //             return "????????????";
    //             break;
    //         case -3:
    //             return "????????????????????????";
    //             break;
    //         case -4:
    //             return "???";
    //             break;


    //         default:
    //             return $v;
    //             break;
    //     }
    // }



    public function getAuthPassword()
    {
        return $this->encrypted_password;
    }

    /**
     * ?????????????????????????????????
     *
     * @return void
     */
    public function getFullContactAddress()
    {
        $country = ($this->contact_country == '') ? '' : $this->contact_country;
        $district = ($this->contact_district == '') ? '' : $this->contact_district;
        $addr = ($this->contact_address == '') ? '' : $this->contact_address;
        return $country.$district.$addr;
    }

    /**
     * ????????????PP??????Email
     *
     * @return void
     */
    public function getAllAdminUserEmail()
    {
        $result = [];
        $userRoles = UsersRoles::select('user_id')->where('role_id',2)->get();
        foreach ($userRoles as $v) {
            $email = $this->find($v->user_id)->email;
            array_push($result,$email);
        }
        return $result;
    }

    /**
     * ???????????????PP??????Email
     *
     * @return void
     */
    public function getAllNormalUserEmail()
    {
        $result = [];
        $userRoles = UsersRoles::select('user_id')->where('role_id',1)->groupBy('user_id')->get();
        foreach ($userRoles as $v) {
            $email = $this->find($v->user_id)->email;
            array_push($result,$email);
        }
        return $result;
    }
    /**
     * ???????????????PP?????????????????????????????????
     *
     * @return void
     */
    public function getAllNormalUserInfo()
    {
        $result = [];
        $userRoles = UsersRoles::select('user_id')->where('role_id',1)->groupBy('user_id')->get();
        foreach ($userRoles as $v) {
            $u = $this->find($v->user_id);
            if(isset($u)){
                $logpath = 'logs/sendMail_getAll/' . date("Y-m-d H") . '.log';
                $log = new Logger('pp_Mail');
                $log->pushHandler(new StreamHandler(storage_path($logpath)), Logger::DEBUG);
                $log->debug('???????????????', [$u]);

                if($u->is_receive_letter == 1 || $u->is_receive_letter == '??????'){
                    array_push($result,$u);
                }
            }

        }
        return $result;
    }

    /**
     * ?????????????????????????????????
     *
     * @param  mixed $user_id
     * @return void
     */
    public function getUserBankAccountInfo($user_id)
    {
        $data = DB::select("SELECT
                u.user_id as user_id,
                u.member_number as member_number,
                u.virtual_account as virtual_account,
                u.user_name as user_name,
                LPAD(bl.bank_code,3,0) as bank_code,
                bl.bank_name as bank_name,
                bl.bank_branch_code as bank_branch_code,
                bl.bank_branch_name as bank_branch_name,
                ub.bank_account as bank_account
            FROM
                users AS u
            LEFT JOIN user_bank AS ub
            ON
                ub.user_id = u.user_id
            LEFT JOIN bank_lists AS bl
            ON
                bl.bank_id = ub.bank_id
            WHERE
                ub.is_active = 1 AND
                u.user_id = $user_id");
        return collect($data[0]);
    }


    /**
     * ?????????????????????????????????
     * @param int user_id ?????????ID
     * @return void
     */
    public function countUserMoneyInfo($user_id)
    {
        // ???????????????
        $m['total_invest'] = $this->totalInvest($user_id);
        //???????????????
        $m['total_income'] = $this->totalIncome($user_id);
        //?????????????????????
        $m['back_invest_money'] = $this->backInvestMoney($user_id);
        //?????????????????????
        $m['back_invest_income'] = $this->backInvestIncome($user_id);
        
        $total_invest = str_replace(',', '', $m['total_invest']);
        
        $back_invest_money = str_replace(',', '', $m['back_invest_money']);
        //?????????????????????
        $m['not_back_invest_money'] = number_format((float)$total_invest - (float)$back_invest_money);

        $total_income = str_replace(',', '', $m['total_income']);
        
        $back_invest_income = str_replace(',', '', $m['back_invest_income']);
        //?????????????????????
        $m['not_back_invest_income'] = number_format((float)$total_income - (float)$back_invest_income);

        //???????????????
        $IRR = $this->claims($user_id);

        $IRR = json_decode(json_encode($IRR),true);
        
        
        $ar =[];
        foreach($IRR as $k=>$v){
            $Internal_Rate_of_Return = (float)$IRR[$k]['amount']*((float)$IRR[$k]['annual_interest_rate']/100);
            array_push($ar,$Internal_Rate_of_Return);
        }
        $Internal_Rate_of_Return = array_sum($ar);
        $m['Internal_Rate_of_Return'] = $total_invest == 0 ? 0 : round(((float)$Internal_Rate_of_Return/(float)$total_invest)*100,2);
        return $m;
    }

// bk START========================
// SELECT
//     #sum(tr.per_return_principal),
//     #sum(td.amount)
//     #td.amount,
//     td.tender_documents_id,
//     tr.tender_repayment_id,
//     tr.per_return_principal
// FROM
//     tender_repayments AS tr
// LEFT JOIN tender_documents AS td
// ON
//     td.tender_documents_id = tr.tender_documents_id
// WHERE
// 	td.user_id = 3 AND
// 	td.tender_document_state in (1,2,4)
//     #group by td.tender_documents_id
//     #group by td.user_id
// bk END========================

    /**
     * ?????????????????????
     *
     * @param  mixed $uid
     * @return ?????????????????????
     */
    public function notBackInvestIncome($uid)
    {
        try {
            $m = DB::select("SELECT
                    SUM(tr.per_return_interest) AS per_return_interest
                FROM
                    tender_repayments AS tr
                LEFT JOIN tender_documents AS td
                ON
                    td.tender_documents_id = tr.tender_documents_id
                WHERE
                    td.user_id = ? AND tr.paid_at IS NULL", [$uid]);
            return number_format($m[0]->per_return_interest);
        } catch (\Throwable $th) {
            return 0;
        }
    }

    /**
     * ?????????????????????
     *
     * @param  mixed $uid
     * @return ?????????????????????
     */
    public function notBackInvestMoney($uid)
    {
        try {
            $m = DB::select("SELECT
                SUM(tr.per_return_principal) as per_return_principal
                FROM
                    tender_repayments AS tr
                LEFT JOIN tender_documents AS td
                ON
                    td.tender_documents_id = tr.tender_documents_id
                WHERE
                    td.user_id = $uid AND tr.paid_at IS NULL");
            return number_format($m[0]->per_return_principal);
        } catch (\Throwable $th) {
            return 0;
        }
    }


    /**
     * ?????????????????????
     *
     * @param  mixed $uid
     * @return ?????????????????????
     */
    public function backInvestIncome($uid)
    {
        try {
            $m = DB::select("SELECT
                    SUM(tr.per_return_interest) AS per_return_interest
                FROM
                    tender_repayments AS tr
                LEFT JOIN tender_documents AS td
                ON
                    td.tender_documents_id = tr.tender_documents_id
                WHERE
                    td.user_id = ? AND tr.paid_at IS NOT NULL", [$uid]);
            return number_format($m[0]->per_return_interest);
        } catch (\Throwable $th) {
            return 0;
        }
    }

    /**
     * ?????????????????????
     *
     * @param  mixed $uid
     * @return ?????????????????????
     */
    public function backInvestMoney($uid)
    {
        try {
            $m = DB::select("SELECT
                SUM(tr.per_return_principal) as per_return_principal
                FROM
                    tender_repayments AS tr
                LEFT JOIN tender_documents AS td
                ON
                    td.tender_documents_id = tr.tender_documents_id
                WHERE
                    td.user_id = $uid AND tr.paid_at IS NOT NULL");
            return number_format($m[0]->per_return_principal);
        } catch (\Throwable $th) {
            return 0;
        }
    }

    /**
     * ???????????????
     *
     * @param  mixed $uid
     * @return ???????????????
     */
    public function totalIncome($uid)
    {
        try {
            $m = DB::select("SELECT
                    SUM(tr.per_return_interest) as per_return_interest
                FROM
                    tender_repayments as tr
                    left join
                    tender_documents as td  on td.tender_documents_id = tr.tender_documents_id
                WHERE
                    td.user_id = $uid and td.tender_document_state in(4,2,1)");
            return number_format($m[0]->per_return_interest);
        } catch (\Throwable $th) {
            return 0;
        }
    }
    /**
     * ???????????????
     *
     * @param  mixed $uid
     * @return ???????????????
     */
    public function totalInvest($uid)
    {
        try {
            $m = Tenders::select('amount')->whereIn('tender_document_state',[1,2,4])->where('user_id',$uid)->sum('amount');
            $m = number_format($m);
            return $m;
        } catch (\Throwable $th) {
            return 0;
        }

    }
    
    /**
     * ??????????????????
     *
     * @param  mixed $uid
     * @return ??????????????????
     */
    public function claims($uid)
    {
        try {
            $m = DB::select("SELECT
                    td.amount AS amount,
                    cl.annual_interest_rate AS annual_interest_rate
                FROM
                    claims AS cl
                LEFT JOIN tender_documents AS td
                ON
                    td.claim_id = cl.claim_id
                WHERE
                    td.user_id = $uid and td.tender_document_state in(4,2,1)");
            return $m;
        } catch (\Throwable $th) {
            return 0;
        }
    }
// /* -------------------------------------------------------------------------- */
// /*                                 Model???????????????                             */
// /* -------------------------------------------------------------------------- */

    protected static function boot()
    {
        parent::boot();

        // static::updated(function ($model) {
        //     $model_old = $model->getOriginal();
        //     $model_new = $model->getAttributes();

        //     if($model_old['user_state'] != $model_new['user_state']){
        //         $UserConfirmLog = new UserConfirmLog;
        //         foreach ($model_new as $key => $value) {
        //             $UserConfirmLog->$key = $value;
        //         }
        //         $UserConfirmLog->user_old_state = $model_old['user_state'] ;
        //         $UserConfirmLog->user_confirm_log_created_at = date('Y-m-d H:i:s');
        //         $UserConfirmLog->save();
        //     }
        // });
        static::saved(function ($model) {
            $isChanged = $model->getDirty();
            if(isset($isChanged['user_state'])){

                $old_state = $model->getOriginal()['user_state'];

                $model_new = $model->getAttributes();
                $UserConfirmLog = new UserConfirmLog;
                foreach ($model_new as $key => $value) {
                    $UserConfirmLog->$key = $value;
                }
                $UserConfirmLog->user_old_state = $old_state;
                $UserConfirmLog->user_confirm_log_created_at = date('Y-m-d H:i:s');

                $UserConfirmLog->save();
            }

        });

    }
}
