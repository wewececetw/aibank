<?php
namespace App\MainFlow;
use App\Claim;
use App\TenderRepayments;
use App\Tenders;
use App\MainFlowLog;
use App\User;
use App\UserBank;
//本金攤還
use App\PayBackCount\equalPrincipalPayment;
//本息攤還
use App\PayBackCount\equalTotalPayment;
use DB;
//寄簡訊
use App\Sms\sendSMS;
//
use App\PusherDetail;
use Log;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

use App\PayBackCount\Common;
use App\Mail\MailTo;
use Illuminate\Support\Arr;


class Main {

    public $dbColName = [
        //claim
        'c' => [
            'id' => 'claim_id',
            ''
        ],
        //tender_document
        'td' => [
            'amount' => 'amount',
        ],
    ];

    public $logState = [];
    public $logCount = 0;
    /**
     * 開始記錄
     */
    public function logg($claim_id,$state,$msg,$isError=false)
    {
        $logpath = 'logs/mainFlow/' . date("Y-m-d H") . '.log';
        $log = new Logger('pp_Main');
        $log->pushHandler(new StreamHandler(storage_path($logpath)), Logger::DEBUG);
        $log->debug($claim_id, [$msg]);

        // Log::debug($msg);
        $this->logCount++;
        $log = new MainFlowLog;
        $log->claim_id = $claim_id;
        $log->state =$state;
        $log->step =$this->logCount;
        $log->msg =$msg;
        if($isError){
            $log->isError = 1;
        }
        $log->created_at =date('Y-m-d H:i:s');
        $log->save();
    }


    // 債權目前投資總額
    public function getClaimTenderTotalAmount($claim_id)
    {
        try {
            $model = DB::table('claims');
            $model = $model->from('claims as c');
            $model = $model->leftJoin('tender_documents as td', 'c.claim_id', '=', 'td.claim_id');
            $model = $model->where('c.claim_id',$claim_id);
            $model = $model->sum('td.amount');
            return $model;
        } catch (\Throwable $th) {
            // dd($th);
            return false;
        }
    }

    // 債權目前投資總額 只有 tender state in 0,1
    public function getClaimTenderStateInTotalAmount($claim_id)
    {
        try {
            $model = DB::table('claims');
            $model = $model->from('claims as c');
            $model = $model->leftJoin('tender_documents as td', 'c.claim_id', '=', 'td.claim_id');
            $model = $model->where('c.claim_id',$claim_id);
            $model = $model->whereIn('td.tender_document_state',[0,1]);
            $model = $model->sum('td.amount');
            return $model;
        } catch (\Throwable $th) {
            // dd($th);
            return false;
        }
    }


    //取得債權最大金額及目前總金額
    public function getClaimMaxAndTotalAmount($claim_id)
    {
        //債權最大金額
        // $original_claim_amount = Claim::findOriginalClaimAmount($claim_id);
        $staging_amount = Claim::find($claim_id);
        if(isset($staging_amount)){
            $staging_amount = $staging_amount->staging_amount;
        }else{
            abort(555,'找不到此債權');
        }

        //目前債權投資總金額
        $totalAmount = $this->getClaimTenderTotalAmount($claim_id);

        return [
            'max' => $staging_amount,
            'total' => $totalAmount
        ];
    }
    //取得Claim State
    public function getClaimState($claim_id)
    {
        try {
            return Claim::findClaimState($claim_id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    //取得分期數
    public function getClaimPeriods($claim_id)
    {
        // $periods = Claim::find($claim_id)->periods;
        // return (isset($periods)) ? $periods:'NotSet';
        $periods = Claim::find($claim_id)->remaining_periods;
        return (isset($periods)) ? $periods:'NotSet';
    }
    //取得分期日期陣列
    public function getPeriodsTimeArray($periods)
    {
        $result = [];
        //21號是寫死的@@
        if($periods == 'NotSet'){
            return $result;
        }else{
            $now = strtotime(date('Y-m-21'));
            $i=1;
            $ilength = (int)$periods + 1;
            for($i;$i<$ilength;$i++){
                array_push($result,date('Y-m-d',strtotime("+".$i." month",$now)));
            }
            return $result;
        }
    }
    //新增標單
    public function addNewTender($inputObject)
    {
        try {
            if(!array_key_exists('created_at', $inputObject)){
                $inputObject['created_at'] = date('Y-m-d H:i:s');
            }
            if(!array_key_exists('updated_at', $inputObject)){
                $inputObject['updated_at'] = date('Y-m-d H:i:s');
            }
            if(!array_key_exists('tender_document_state', $inputObject)){
                $inputObject['tender_document_state'] = 0;
            }
            if(!array_key_exists('should_paid_at', $inputObject)){
                // $inputObject['state'] = 0;
                // 下單當下時間 + N
            }

            $tender = new Tenders;
            foreach ($inputObject as $key => $value) {
                $tender->setAttribute($key, $value);
            }
            $tender->save();

            return $tender;
        } catch (\Throwable $th) {
            // dd($th);
            $this->logg(0,2,$th,true);
            return false;
        }
    }

    //取得Claim底下所有標單id (return [id,id2])
    public function getAllTendersIdArray($claim_id)
    {
        $idArray = [];
        $Claim = Claim::with('claim_tenders')->find($claim_id);
        foreach ($Claim->claim_tenders as $tender) {
            array_push($idArray,$tender->tender_documents_id);
        }
        return $idArray;
    }
    //claim狀態轉2
    public function changeToState2($claim_id)
    {
        $tendersId = $this->getAllTendersIdArray($claim_id);
        foreach ($tendersId as $tenderId) {
            $tender = Tenders::find($tenderId);
            $tender->tender_document_state = 5;
            $tender->save();
            // $m = new MailTo;
            //結標信
            // $m->tender_document_start_to_repay($tender->user_id);
        }

        $claim = Claim::find($claim_id);
        $claim->claim_state = 2;
        $claim->closed_at = date('Y-m-d H:i:s');
        $claim->save();
    }
    //claim狀態轉5
    public function changeToState5($claim_id)
    {
        $tendersId = $this->getAllTendersIdArray($claim_id);
        foreach ($tendersId as $tenderId) {
            $tender = Tenders::find($tenderId);
            $tender->tender_document_state = 4;
            $tender->save();
        }
        $claim = Claim::find($claim_id);
        $claim->claim_state = 5;
        $claim->save();
    }

    //設定流標
    public function setBidFaild($claim_id)
    {
        $tendersId = $this->getAllTendersIdArray($claim_id);
        
        $liublio_mail = [];
        $liublio_user = [];
        $count = 0;
        $now_usid = '';

        foreach ($tendersId as $tenderId) {
            $tender = Tenders::find($tenderId);
            $tender->tender_document_state = 3;
            $tender->updated_at = date('Y-m-d H:i:s');
            $tender->save();


            // if($now_usid == $tender->user_id){
            //     $count ++;
            // }else{
            //     $now_usid = $tender->user_id;
            //     $count = 0;
            // }
            

            // if ($count == 0) {
            //     $liublio_mail[$tender->user_id] = '';

            //     $liublio_mail[$tender->user_id] = $tender->claim_certificate_number;
            
            // }else{
            //     $liublio_mail[$tender->user_id] =  $liublio_mail[$tender->user_id].' , '.$tender->claim_certificate_number;
            // }

            
            // array_push($liublio_user, $tender->user_id);
        }

        // $liublio_user = array_unique($liublio_user);

        // foreach ($liublio_user as $k){

        //     $m = new MailTo;
        //     //流標信
        //     $m->floating_email($k,$liublio_mail[$k]);
        // }
        


        $claim = Claim::find($claim_id);
        $claim->claim_state = 3;
        $claim->closed_at = date('Y-m-d H:i:s');
        $claim->updated_at = date('Y-m-d H:i:s');
        $claim->save();
    }

    //取得分期日期陣列 起息日+1個月開始
    public function getPeriodsTimeArrayNew($periods,$startDay)
    {
        $result = [];
        if($periods == 'NotSet'){
            return $result;
        }else{
            $now = strtotime(date('Y-m-d',strtotime($startDay)));
            $i=1;
            $ilength = (int)$periods + 1;
            for($i;$i<$ilength;$i++){
                array_push($result,date('Y-m-d',strtotime("+".$i." month",$now)));
            }
            return $result;
        }
    }

    //抄寫資料到tender_repayment
    public function writeDataToTenderRepayment($claim_id)
    {
        try {
        $claim = Claim::find($claim_id);

           //取得總分期數
        $periods = $this->getClaimPeriods($claim_id);
        $value_date = $claim->value_date;
        $timeArray = $this->getPeriodsTimeArrayNew($periods,$value_date);

        $tendersId = $this->getAllTendersIdArray($claim_id);
        //取得債權還款方式
        $repaymentMethod = $claim->getOriginal('repayment_method');
        //利息%數
        $fee_rate = $claim->management_fee_rate;
        //年利率
        $rate = $claim->annual_interest_rate;



        foreach ($tendersId as $tenderId) {
            $thisTender = Tenders::find($tenderId);
            //貸款金額
            $tenderAmount = $thisTender->amount;
            if($repaymentMethod == 1){
                //本息攤還
                $paymentCount = new equalTotalPayment($rate,$periods,$tenderAmount);
            }else if($repaymentMethod == 0){
                //本金攤還
                $paymentCount = new equalPrincipalPayment($rate,$periods,$tenderAmount);
            }
            $paymentCount = $paymentCount->run();
            $mf = $this->thirdPartyManagmentFee($paymentCount['everyMonthInterest'],$fee_rate);
            $totalInterest = array_sum($paymentCount['everyMonthInterest']);
            $totalFee = round(($totalInterest * $fee_rate) / 100);
            $count = 0;
            foreach ($timeArray as $time) {
                $check_repayments = DB::select('select * from tender_repayments where tender_documents_id = ? and period_number = ?',[$tenderId,($count+1)]);
                if (empty($check_repayments)) {
                    $TenderRepayments = new TenderRepayments;
                    $TenderRepayments->tender_documents_id = $tenderId;
                    $TenderRepayments->tender_repayment_state = 0;
                    $TenderRepayments->target_repayment_date = $time;
                    $TenderRepayments->created_at = date('Y-m-d H:i:s');
                    $TenderRepayments->updated_at = date('Y-m-d H:i:s');

                    $user_bank_id = UserBank::select('user_bank_id')->where('user_id', $thisTender->user_id)->where('is_active', 1)->first();
                    $TenderRepayments->user_bank_id = $user_bank_id;

                    //$mf = ($paymentCount['everyMonthInterest'][$count] * $fee_rate) / 100;
                    //$yf = ($paymentCount['everyMonthInterest'][$count+1] * $fee_rate) / 100;
                    //好像怪怪的，跟Alvin確認一下我是不是昏頭寫錯
                    // $mf = pow($mf,0);
                    /* ========= 2020-04-01 01:29:04 change by Jason ========= */
                    /* A 暫時沒給我答案，先改成四捨五入好了，至少比0次方更像正確的 */
                    // $mf = round($mf);
                    $last = count($timeArray) -1 ;
                    // if($count == $last&&$totalFee>=0 ){
                    //     // $TenderRepayments->management_fee = $mf;
                    //     // $totalInterest = $totalInterest - $mf;
                    //     $TenderRepayments->management_fee = round($totalFee);
                    // }elseif($totalFee<=0){
                
                    //     if($totalFee<=0&&$ar[$i-1]>0){
                    //         $ar[$i-1] = round($ar[$i-1] + $all_total);
                    //     }
                    //     $TenderRepayments->management_fee = 0;
                    
                    // }else{
                    //     $TenderRepayments->management_fee = round($fee);
                    //     $totalFee = $totalFee - $fee;
                    // }
                    // $TenderRepayments->management_fee = $mf;
                
                    $TenderRepayments->management_fee = $mf[$count];
                    $TenderRepayments->per_return_principal = $paymentCount['everyMonthPrincipal'][$count];
                    $TenderRepayments->net_amount = $paymentCount['everyMonthPaidTotal'][$count];
                    $TenderRepayments->per_return_interest = $paymentCount['everyMonthInterest'][$count];
                    //02-27 新增欄位 real_return_amount = 本息合計
                    if ($count == $last) {
                        $TenderRepayments->real_return_amount = $paymentCount['everyMonthPaidTotal'][$count] - $mf[$last];
                    } else {
                        $TenderRepayments->real_return_amount = $paymentCount['everyMonthPaidTotal'][$count] - $mf[$count];
                    }
                    $TenderRepayments->period_number = ($count+1);
                    $TenderRepayments->save();
                    $count++;
                }else{
                    $this->logg($claim_id,2,'標單'.$tenderId.'的第'.($count+1).'期重複',true);
                    return false;
                }
            }
        }
            return true;
        } catch (\Throwable $th) {
            $this->logg($claim_id,2,$th,true);
            return false;
        }

    }
    public function thirdPartyManagmentFee($everyMonthArray,$fee_rate)
    {

        $total = array_sum($everyMonthArray);

        // $total = (int)round(0.1 * $total);
        $all_total = round($total * $fee_rate) / 100;
        
        //$avg = $total/count($everyMonthArray);

        $ar = [];
        
        // foreach ($everyMonthArray as $key) {
        for($i = 0;$i < count($everyMonthArray);$i ++){
            if ($all_total >= 0 && $i == count($everyMonthArray)-1) {
                $br = round($all_total);
            }elseif($all_total <= 0){
                if($fee_rate == '0'){
                    $ar[-1] = -1;
                }
                if($all_total <= 0 && $ar[$i-1] > 0){
                    $ar[$i-1] = round($ar[$i-1] + $all_total);
                }
                $br = 0;
            }else{

                $brr = ($everyMonthArray[$i] * $fee_rate) / 100;
                $br = round($brr);
                $all_total =  $all_total - $br;
            }
            
            array_push($ar, $br);
        }
        unset($ar[-1]);

        $common = new Common;
        $res = $common->sumToLastMonth($ar);
        return $res;
    }

    /**
     * 寄送簡訊funciton
     * @param string phoneNumber 電話號碼
     * @param string ctx 簡訊內容
     * @param timestamp preSendTime 指定發送時間，必須大於目前時間10分鐘才會指定發送時間，否則立即發送
     * @param timestamp preSendTime 格式為YYYYMMDDHHIISS
     *
     */
    public function sendSms($phoneNumber,$ctx,$preSendTime=false)
    {
        //指定時間
        // $sendTime = date('Ymdhis',strtotime("2020-02-20 09:00:00"));
        // $url = "http://smexpress.mitake.com.tw/SmSendGet.asp?";

        $url = config('sms.baseUrl');
        $username = 'username='.config('sms.username');
        $password = 'password='.config('sms.password');

        $dstaddr = 'dstaddr='.$phoneNumber;
        $encoding = 'encoding=UTF8';

        $smbody =  'smbody='. urlencode($ctx);

        if($preSendTime != false){
            $sendTime = date('Ymdhis',strtotime($preSendTime));
            $dlvtime = 'dlvtime='.$sendTime ;
            $url .= $username.'&'.$password.'&'.$dstaddr.'&'.$smbody.'&'.$dlvtime .'&'. $encoding;
        }else{
            $url .= $username.'&'.$password.'&'.$dstaddr.'&'.$smbody.'&'. $encoding;
        }

        file_get_contents($url);

    }

    //假裝是tender_document的投標人電話號碼(發簡訊測試用)
    public function pretendTenderDocumentUser()
    {
        return ['0930597708','0987786275'];
    }


    /**
     * 取得tenders ID Array 每個 電話號碼
     */
    public function getTendersPhone($tendersId)
    {
        $res = [];
        foreach($tendersId as $t)
        {
            $uid = Tenders::find($t)->user_id;
            $phone = User::find($uid)->phone_number;
            array_push($res,$phone);
        }
        return $res;
    }
    /**
     * Claim轉狀態2時發送簡訊的Funciton
     */
    public function sendState2Sms($claim_id)
    {
        $now = date('Y-m-d H:i:s');
        $nextDay = date('Y-m-d',strtotime('+1 days',strtotime($now)));
        $nextDay = date('YmdHis',strtotime('+9 hours',strtotime($nextDay)));
        //nextDay = 隔天早上9點
        //取得tenders id
        $tendersId = $this->getAllTendersIdArray($claim_id);
        $phones = $this->getTendersPhone($tendersId);
        $config = [];
        $ctx = '恭喜您投標的債權已成功結標，'.chr(6).'請您至平臺繳款專區'.chr(6).'http://www.pponline.com.tw/front/payment 或電子郵箱中下載繳款通知書。';
        foreach ($phones as $phone) {
            $ar = [
                'phone'=> $phone,
                'ctx' => $ctx
            ];
            array_push($config,$ar);
        }
        $sms = (new sendSMS($config))->run();
    }

    /**
     * 抄寫資料到pusher_detail
     */
    public function getPusherDetailData($claim_id)
    {
        try {
            $tendersId = $this->getAllTendersIdArray($claim_id);
            foreach ($tendersId as $tenderid) {
                $pusherData = $this->runPusherSQL($tenderid);
                if(count($pusherData) > 0){
                    $this->proccessSavePuser($pusherData);
                }
            }
            return true;
        } catch (\Throwable $th) {
            $this->logg($claim_id,2,$th,true);
            return false;
        }


    }

    /**
     * 將一坨資料處理後存進pusher_detail
     */
    public function proccessSavePuser($dirtyData)
    {
        try {
                    //浮點數總和
        $floatSum = 0;

        //最大日期
        //====S 這段可能不需要做 因為SQL會依照日期排序了(應該)
        $maxDate = '1990-12-20 00:00:00';
        foreach($dirtyData as $k => $v)
        {
            if($v->target_repayment_date > $maxDate){
                $maxDate = $v->target_repayment_date;
            }
        }
        //====E

        foreach($dirtyData as $k => $v)
        {
            // if($v->target_repayment_date == $maxDate){
            //     //最後一期時，將所有浮點數加到interest中並做四捨五入
            //     $interestWithFloat = $this->getIntAndFloat($v->PusherBenefits);
            //     $interest = (int)$interestWithFloat['integer'];
            //     $floatSum = $floatSum + $interestWithFloat['decimalPoint'];
            //     $interest = $interest + $floatSum;
            //     $interest = round($interest,0);
            // }else{
            //     $interestWithFloat = $this->getIntAndFloat($v->PusherBenefits);
            //     $interest = (int)$interestWithFloat['integer'];
            //     $floatSum = $floatSum + $interestWithFloat['decimalPoint'];
            // }
            $pusherDetail = new PusherDetail;
            $pusherDetail->claim_id = $v->claim_id;
            $pusherDetail->user_id = $v->uid;
            $pusherDetail->repayment_id = $v->rid;
            $pusherDetail->current_balance = $v->currentBalance;
            $pusherDetail->paid_at = $v->paid_at;
            $pusherDetail->target_repayment_date = $v->target_repayment_date;
            $pusherDetail->claim_certificate_number = $v->claim_certificate_number;
            $pusherDetail->commission_interest_rate = $v->ci_rate;

            $pusherDetail->benefits_amount = round($v->PusherBenefits);
            // $pusherDetail->benefits_amount = $interest;

            $pusherDetail->save();
        }
            return true;
        } catch (\Throwable $th) {
            $this->logg('12',2,$th,true);
            return false;
        }


    }

    /**
     * 判斷數字是否含有小數
     * 有的話將小數取出
     * @param String|Int|Float $number = 要判斷的數字
     * @return array
     *  [
     *    'integer' => 整數部分,
     *    'decimalPoint' => 小數點部分
     *  ]
     */
    public function getIntAndFloat($number)
    {
        if(is_int($number)){
            $flo = 0.0;
            $integer = $number;
        }else{
            $integer = (int)floor($number);
            $flo = $number-$integer;
        }
        $result = [
            'integer' => $integer,
            'decimalPoint' => $flo
        ];
        return $result;
    }

    /**
     * 跑 pusher SQL
     */
    public function runPusherSQL($tid)
    {
        $d = DB::select("SELECT
        result.*,
        @rpd:=CASE
            WHEN @t <> result.tid THEN 1
            ELSE @rpd + 1
        END AS rank,
        @t:=result.tid AS clset
    FROM
        (SELECT @rpd:=- 1) s,
        (SELECT @t:=- 1) c,
        (SELECT
            t.claim_certificate_number,
                u.member_number,
                u.user_id AS uid,
                t.repayment_method,
                u.user_name,
                t.tid,
                t.ci_rate,
                t.tender_document_state AS dstate,
                t.total,
                t.currentBalance,
                (CASE
                    WHEN ci_rate <> 0 THEN t.currentBalance * ci_rate / 12
                    ELSE 0
                END) AS PusherBenefits,
                CONVERT( CONCAT(CONVERT( YEAR(DATE_ADD(t.target_repayment_date, INTERVAL 1 MONTH)) , CHAR), '-', CONVERT( MONTH(DATE_ADD(t.target_repayment_date, INTERVAL 1 MONTH)) , CHAR), '-20') , DATETIME) AS target_repayment_date,
                t.paid_at,
                t.credited_at,
                t.claim_id,
                t.rid
        FROM
            (SELECT
            *
        FROM
            users
        WHERE
            come_from_info_text IN (SELECT
                    recommendation_code
                FROM
                    users)) AS u
        LEFT JOIN (SELECT
            d.*,
                c.ci_rate,
                c.repayment_method,
                r.target_repayment_date,
                d.total - r.subtotal AS currentBalance,
                r.rid,
                r.paid_at,
                r.credited_at
        FROM
            (SELECT
            d.user_id,
                d.tender_documents_id AS tid,
                d.claim_id,
                d.Amount AS total,
                d.claim_certificate_number,
                d.tender_document_state
        FROM
            tender_documents AS d
        WHERE
            d.tender_document_state IN (2,5) AND d.tender_documents_id = ".$tid.") AS d
        LEFT JOIN (SELECT
            claim_id AS cid,
                commission_interest_rate AS ci_rate,
                repayment_method
        FROM
            claims) AS c ON c.cid = d.claim_id
        LEFT JOIN (SELECT
            r1.tender_repayment_id AS rid,
                r1.tender_documents_id,
                r1.target_repayment_date,
                SUM(r2.per_return_principal) AS subTotal,
                r1.paid_at,
                r1.credited_at
        FROM
            tender_repayments AS r1, tender_repayments AS r2
        WHERE
            r1.tender_documents_id = r2.tender_documents_id
                AND r2.target_repayment_date < r1.target_repayment_date
        GROUP BY r1.tender_documents_id , r1.target_repayment_date UNION (SELECT
            MIN(r1.tender_repayment_id) AS rid,
                r1.tender_documents_id,
                MIN(r1.target_repayment_date) AS target_repayment_date,
                0 AS subTotal,
                CASE
                    WHEN MIN(r1.paid_at) IS NULL THEN NULL
                    ELSE MIN(r1.paid_at)
                END AS paid_at,
                CASE
                    WHEN MIN(r1.credited_at) IS NULL THEN NULL
                    ELSE MIN(r1.credited_at)
                END AS credited_at
        FROM
            tender_repayments AS r1
        GROUP BY r1.tender_documents_id) ORDER BY tender_documents_id , target_repayment_date) AS r ON r.tender_documents_id = d.tid
        WHERE
            c.ci_rate IS NOT NULL AND c.ci_rate > 0
        ORDER BY d.tid , r.subtotal) AS t ON t.user_id = u.user_id
        ORDER BY tid , target_repayment_date) AS result
    WHERE
        result.claim_certificate_number IS NOT NULL");
        return $d;
    }


    public function changeOfIsDisplay($claim){

       $claim->is_display = 0;
       $claim->updated_at = date('Y-m-d H:i:s');

       $claim->save();


    }
}

