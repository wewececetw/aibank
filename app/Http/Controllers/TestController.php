<?php

namespace App\Http\Controllers;

use App\BankApiCtx;
use App\MainFlow\MainFlow;
use Illuminate\Http\Request;

use App\Claim;
use App\User;
use App\Order;
use App\Tenders;
use DB;
use PDF;
use App\MainFlow\ClaimPdf;
use App\MainFlow\PaymentNoticePdf;
use App\MainFlow\PaymentNoticePdf2;

use Illuminate\Support\Facades\Mail;
use App\Mail\SampleMail;
use Sichikawa\LaravelSendgridDriver\SendGrid;

use Carbon\Carbon;
use App\PayBackCount\equalPrincipalPayment;
use App\PayBackCount\equalTotalPayment;


use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

use App\Sms\sendSMS;
use App\Mail\MailTo;

use App\MainFlowLog;

class TestController extends Controller
{

    use SendGrid;
    public $mainFlow;
    public $default;



    public function __construct(Request $req)
    {
        $this->mainFlow = new MainFlow;
        $this->default = [
            'thisTenderAmount' => 500,
            'claim_id' => 12,
        ];
    }
    // public function PaymentPdf()
    // {
    //     $PaymentNoticePdf = (new PaymentNoticePdf)->savePdf();
    //     return $PaymentNoticePdf;
    // }

    // public function MailTo()
    // {
    //     // $msg = 'hello MSG';
    //     // $ctxArray = ['fuck','you'];
    //     // $this->logg($msg,$ctxArray);
    //     // $m = new MailTo;
    //     //上架
    //     // $m->claim_collecting_remind();
    //     //結標
    //     // $m->tender_document_start_to_repay(3);
    //     //流標
    //     // $m->floating_email(3,'P123123');
    //     //繳款
    //     // $m->user_paid_confirmed(3);
    //     //是否需要寄開標信
    //     $needBidOpenMail = Claim::needBidOpenMail();
    //     if($needBidOpenMail){
    //         $m = new MailTo;
    //         $m->claim_collecting_remind();
    //         Claim::updateIsSendStart();
    //         dd("寄了");
    //     }else{
    //         dd('NO');
    //     }

    //     dd((int)100.8);
    //     $a = (new User)->getUserBankAccountInfo(8);
    //     dd($a);
    //     $ctx = ['機掰啦'];
    //     $title = 'FUCK';
    //     $email = 'dennygod1220@gmail.com';
    //     $from = false;
    //     $file_path = url('uploads/ClaimTenderPDF/20200406/2_債權PDF.pdf');
    //     Mail::to($email)->send(new SampleMail($ctx, $from, $title,$file_path));
    // }

    function birthday2($birthday){
        list($year,$month,$day) = explode("-",$birthday);
        $year_diff = date("Y") - $year;
        $month_diff = date("m") - $month;
        $day_diff  = date("d") - $day;
        if ($day_diff < 0 || $month_diff < 0)
        $year_diff--;
        return $year_diff;
    }

    public function check_original_claim_amount_max(Request $req)
    {
        try {
            //現在這標 投注金額
            $thisTenderAmount = (isset($req->thisTenderAmount)) ? $req->thisTenderAmount : $this->default['thisTenderAmount'];
            $claim_id = (isset($req->claim_id)) ? $req->claim_id : $this->default['claim_id'];
            //false = 超標了 ， true 沒超標
            $amountOver = $this->mainFlow->checkTenderAmountOverClaim($claim_id, $thisTenderAmount);
            if ($amountOver) {
                var_dump('可投標');
            } else {
                dd('投資失敗!! 已超過募集金額 !!');
            }
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }

    }


    public function check_claim_state(Request $req)
    {
        try {
            $claim_id = (isset($req->claim_id)) ? $req->claim_id : $this->default['claim_id'];

            $this->mainFlow->checkClaimStateNotTwo($claim_id);

        } catch (\Throwable $th) {
            dd($th);
        }
    }

    //產生標單
    public function addNewTender(Request $req)
    {
        try {
            $claim_id = (isset($req->claim_id)) ? $req->claim_id : $this->default['claim_id'];
            $inputObject = [
                'claim_id' => $claim_id,
                'user_id' => 999,
                'amount' => 100,
            ];

            //新標單
            $newTender = $this->mainFlow->addNewTender($inputObject);
            dd($newTender->toArray());
        } catch (\Throwable $th) {
            // dd($th,'controller');
            abort(555,$th);
        }
    }
    //找差別用
    public function findModelChange($old,$new)
    {
        $res = [];
        foreach ($old as $key => $value) {
            if($value != $new[$key]){
                $res[$key] = $value.'->'.$new[$key];
            }
        }
        return $res;
    }

    //檢查債權狀態
    public function checkClaimState(Request $req)
    {
        $claim_id = (isset($req->claim_id)) ? $req->claim_id : $this->default['claim_id'];
        $claimOld = Claim::find($claim_id)->getAttributes();

        //跑債權檢查流程
        $this->mainFlow->runCheckClaimChange($claim_id);

        $claimNew = Claim::find($claim_id)->getAttributes();

        $change = $this->findModelChange($claimOld,$claimNew);
        if(count($change) == 0){
            return '狀態無變化';
        }else{
            dd('狀態變化',$change);
        }
    }


    //寫資料到tender_repayment
    public function writeDataToTenderRepayment(Request $req)
    {
        try {
            $claim_id = (isset($req->claim_id)) ? $req->claim_id : $this->default['claim_id'];
            $this->mainFlow->writeDataToTenderRepayment($claim_id);
        } catch (\Throwable $th) {
            abory(555,$th);
        }

    }
    /**
     *儲存Claim下所有Tender的債權PDF
    */
    public function saveClaimTendersPdf(Request $req)
    {
        $claim_id = (isset($req->claim_id)) ? $req->claim_id : 12;

        $tenders = Tenders::select('tender_documents_id','user_id','claim_certificate_number','amount')->where('claim_id',$claim_id)->get()->toArray();
        foreach($tenders as $tender){
            $claimPdf = new ClaimPdf($tender['user_id'],$claim_id,$tender['amount']);
            $claimPdf->saveClaimTendersPdf($tender['tender_documents_id'],$tender['claim_certificate_number']);
        }
    }
    /* 繳款PDF  */
    public function payPdf(Request $req)
    {
        $pay_day = $req->pay_day;
        $PaymentNoticePdf = new PaymentNoticePdf($pay_day);
        if($PaymentNoticePdf){
            return $PaymentNoticePdf->savePdf();
        }else{
            return '錯誤';
        }
    }
    /* 繳款PDF->for->admin  */
    public function payPdf2(Request $req)
    {
        $pay_day = $req->pay_day;
        $user_number = $req->user_number;
        $PaymentNoticePdf = new PaymentNoticePdf2($pay_day,$user_number);
        if($PaymentNoticePdf){
            return $PaymentNoticePdf->savePdf();
        }else{
            return '錯誤';
        }
    }
    /**
     *下載債權憑證 新
    */
    public function downloadClaimPdf(Request $req)
    {
            $user_id = (isset($req->user_id)) ? $req->user_id : 17;
            $claim_id = (isset($req->claim_id)) ? $req->claim_id : 12;
            $amount = (isset($req->amount)) ? $req->amount : 10000;
            $claim_certificate_number =  (isset($req->claim_certificate_number)) ? $req->claim_certificate_number : null;
            $claimPdf = new ClaimPdf($user_id,$claim_id,$amount,$claim_certificate_number);
            
            if($claimPdf){
                return $claimPdf->stream();
            }else{
                return '錯誤';
            }
    }
    //下載債權憑證
    public function downloadClaimPdf_OLD(Request $req)
    {
        // dd(date('Y-m-d H:i:s',43873.73194444));
        // dd(Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(43873.73194444)));

        $user_id = (isset($req->user_id)) ? $req->user_id : 17;
        $claim_id = (isset($req->claim_id)) ? $req->claim_id : 12;
        $amount = (isset($req->amount)) ? $req->amount : 10000;
        $user = User::find($user_id);
        $claim = Claim::find($claim_id);

        if($claim->repayment_method == 0){
            $equalPrincipalPayment = new equalPrincipalPayment($claim->annual_interest_rate,$claim->periods,$amount);
            $money = $equalPrincipalPayment->run();
        }else{
            $equalTotalPayment = new equalTotalPayment($claim->annual_interest_rate,$claim->periods,$amount);
            $money = $equalTotalPayment->run();
        }

        // $timeArray = $this->getPeriodsTimeArray($claim->periods);
        $value_date = $claim->value_date;
        $timeArray = $this->getPeriodsTimeArrayNew($claim->periods,$value_date);


        $managmentFee = [];
        //計算服務費 看起來應該是 每月利息 * managment_fee_rate百分比後 四捨五入
        foreach ($money['everyMonthInterest'] as $k => $v) {
            $fee = round($v*$claim->management_fee_rate*0.01);
            array_push($managmentFee , $fee);
        }
        // dd($managmentFee);
        /*
        *  'everyMonthPrincipal' => 每月應還本金陣列,
        *  'everyMonthPrincipalBalance' => 每月貸款餘額陣列,
        *  'everyMonthInterest' => 每月應還本息陣列,
        *  'everyMonthPaidTotal' => 每月應還本息合計陣列,
*/
        $pdf = PDF::loadView('pdf.sample',[
            'user' => $user,
            'claim' => $claim,
            'amount' => $amount,
            'money' => $money,
            'managmentFee' => $managmentFee,
            'timeArray' => $timeArray
        ]);
        // return $pdf->download('sample.pdf');
        return $pdf->stream('sample.pdf');
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

    public function rawSql()
    {
        $test = DB::select('
            select * from claims;
        ');
        $md = DB::table('claims');

        dd($test);
    }

    public function ss()
    {
        $tid = 1;
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
            d.tender_document_state IN (1 , 2, 4, 5) AND d.tender_documents_id = ".$tid.") AS d
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
        dd(count($d));
        foreach ($d as $key => $value) {
            // dd($key,$value->total);
            var_dump($value->total,$value->cid);
        }

    }

    public function testMail()
    {
        // $from = ['address' => 'pponlineJason@gmail.com', 'name' => 'pponline_jason'];
        $from = false;
        // $title = false;
        $title = 'PPonline Sample Test Mail';
        $ctx = ['Hello 你好!','這是PPonline的模板測試信件','有title和預設寄件來源','祝您有愉快的一天!'];

        $mailTo = ['alvin.liu@intersense.com.tw','jamey.chaung@intersense.com.tw','jason.hsu@intersense.com.tw','ray.wu@intersense.com.tw'];
            Mail::to('jasongood1220@gmail.com')->send(new SampleMail($ctx,$from,$title));

        // foreach ($mailTo as $v) {
        //     // $canMail = $this->checkUserCanReciveMail($v);
        //     $canMail = $this->checkUserCanReciveMail('jasongood1220@gmail.com');
        //     dd($canMail);
        //     // Mail::to($v)->send(new SampleMail($ctx,$from,$title));
        // }
    }

/* -------------------------------------------------------------------------- */
/*                                   彰銀API相關 Start                        */
/* -------------------------------------------------------------------------- */

    public function bankSend()
    {

        return View('test.bankSend');
    }

    public function bankSendEncrypt(Request $req)
    {
        // $key = 'pponline';
        $key = 'PPONLINE';
        $iv = 'INT';
        $key = $this->encodeASCII($key);
        $iv = $this->encodeASCII($iv);
        $all = $req->all();
        $sampleValue = '';
        //組合出假裝的明文
        foreach ($all as $k => $value) {
            if($k != '_token'){
                $sampleValue .= $k.'='.$value.'&';
            }
        }
        $sampleValue = substr($sampleValue,0,-1);
        $smapleData = $this->encodeASCII($sampleValue);

        $data = $this->encrypt3DES($smapleData,$key,$iv);
        $data = str_replace('+','%2b',$data);
        $data = str_replace('-','%2c',$data);
        return View('test.bankSend2',[
            'v' => $data
        ]);
    }
    //密文解密
    public function bankSendDecrypt(Request $req)
    {
        try {
            $req_ip = $req->ip();
            $key = 'PPONLINE';
            $iv = 'INT';
            $key = $this->encodeASCII($key);
            $iv = $this->encodeASCII($iv);

            $secrect = $req->all()['result'];

            $data = str_replace('%2b','+',$secrect);
            $data = str_replace('%2c','-',$data);
            //解密轉base64
            $asc = $this->decrypt3DES($data,$key,$iv);

            $res = $this->decodeASCII($asc);

            $bankApiCtx = new BankApiCtx;
            $bankApiCtx->secrect_ctx = $secrect;
            $bankApiCtx->plan_text = $res;
            $bankApiCtx->request_ip = $req_ip;
            $bankApiCtx->save();
            return 'OK';
        } catch (\Throwable $th) {
            return 'fail';
        }



    }

    //轉ASCII
    public function encodeASCII($string)
    {
        $newStr = '';
        for($i = 0; $i < strlen($string); $i++)
        {
            if($i == strlen($string)-1){
                $newStr .= ord($string[$i]);
            }else{
                $newStr .= ord($string[$i]). ' ';
            }
        }
        return $newStr;
    }
    //解ASCII
    public function decodeASCII($string)
    {
        $newStr = '';
        $strArray = explode(' ',$string);
        foreach ($strArray as $v) {
            $newStr.= chr($v);
        }
        return $newStr;
    }

    //加密
    public function encrypt3DES($input,$key,$iv)
    {

        // $data= openssl_encrypt($input, 'des-ede3-cbc', $key, 0, $iv);
        // return $data;
        return base64_encode(openssl_encrypt($input, 'des-ede3-cbc', $key, OPENSSL_RAW_DATA, $iv));

    }
    //解密
    public function decrypt3DES($encrypted,$key,$iv)
    {
        return openssl_decrypt(base64_decode($encrypted), 'des-ede3-cbc', $key, OPENSSL_RAW_DATA, $iv);

        // return openssl_decrypt($encrypted, 'des-ede3-cbc', $key, 0, $iv);
    }

    /**
     * 彰銀API明文解密
     */
    public function bankSendPlanText(Request $req)
    {
        try {
            $req_ip = $req->ip();
            $all = $req->all();
            $sampleValue = '';
            //組合出假裝的明文
            foreach ($all as $k => $value) {
                if($k != '_token'){
                    $sampleValue .= $k.'='.$value.'&';
                }
            }
            $sampleValue = substr($sampleValue,0,-1);

            $bankApiCtx = new BankApiCtx;
            $bankApiCtx->plan_text = $sampleValue;
            $bankApiCtx->request_ip = $req_ip;
            $bankApiCtx->save();
            return "OK";
        } catch (\Throwable $th) {
            return "Server ERROR";
        }

    }

/* -------------------------------------------------------------------------- */
/*                                 彰銀API相關 End                                */
/* -------------------------------------------------------------------------- */

    // //發簡訊
    // public function sendPhoneMsg()
    // {
    //     return View('test.sendPhoneMsg');
    // }
    // public function postSendPhoneMsg(Request $req)
    // {
    //     $input = $req->all();
    //     if($input['dlvtime'] == ''){
    //         $input['dlvtime'] = 0;
    //     }
    //     //指定時間
    //     $sendTime = date('Ymdhis',strtotime("2020-02-20 09:00:00"));


    //     $url = "http://smexpress.mitake.com.tw/SmSendGet.asp?";
    //     $username = 'username=54179376';
    //     $password = 'password=66178828';
    //     $dstaddr = 'dstaddr='.$input['dstaddr'];
    //     $encoding = 'encoding=UTF8';

    //     $smbody =  'smbody='. urlencode($input['smbody']);
    //     // $dlvtime = 'dlvtime='.$input['dlvtime'] ;
    //     $dlvtime = 'dlvtime='.$sendTime ;
    //     // $dlvtime = 'dlvtime=2020 02 19 22 11 00' ;

    //     $url .= $username.'&'.$password.'&'.$dstaddr.'&'.$smbody.'&'.$dlvtime .'&'. $encoding;
    //     $content = file_get_contents($url);
    //     dd($content);
    // }
//     def send_sms(message, phone_number, options = {})
//     require 'rest-client'
//     message = URI.encode(message)
//     params = {
//       username: '54179376',
//       password: '66178828',
//       dstaddr: phone_number,
//       encoding: 'UTF8',
//       dlvtime: options[:dlvtime]||0
//     }
//     url = "http://smexpress.mitake.com.tw/SmSendGet.asp?smbody=#{message}"
//     RestClient.get url, {params: params}
// end


//本金攤還
    public function equalPrincipalPaymentView()
    {
        return View('test.equalPrincipalPayment');
    }
    public function equalPrincipalPayment(Request $req)
    {
        $in = $req->all();
        $equalPrincipalPayment = new equalPrincipalPayment($in['rate'],$in['totalMonth'],$in['amount']);
        $result = $equalPrincipalPayment->run();
        return response()->json($result);
    }

 // 本息攤還
// ＝{[(1＋月利率)^月數]×月利率}÷{[(1＋月利率)^月數]－1}

// (公式中：月利率 ＝ 年利率／12 ； 月數=貸款年期 ｘ 12)
    public function equalTotalPaymentView()
    {
        return View('test.equalTotalPaymentView');
    }
    public function equalTotalPayment(Request $req)
    {
        $in = $req->all();
        $equalTotalPayment = new equalTotalPayment($in['rate'],$in['totalMonth'],$in['amount']);
        $result = $equalTotalPayment->run();
        return response()->json($result);
    }




/* -------------------------------------------------------------------------- */
    // public function uploadTest()
    // {
    //     return View('test.uploadTest');
    // }
    // public function postUploadTest(Request $req)
    // {
    //     $certificate_image = $this->StoreImg($req, 'certificate_image');
    //     dd($req->mytext , $certificate_image);
    // }

    //     //存圖片
    //     public function StoreImg($req, $file)
    //     {
    //         $fileName = $this->Del_deputy_file_name($req->file($file)->getClientOriginalName());
    //         $path = Storage::putFileAs('public/User_Id_Photo/' . date("Ymd"), new File($req->file($file)), $fileName);
    //         $FilePath = 'User_Id_Photo/' .date("Ymd") . '/' . $fileName;
    //         return $FilePath;
    //     }


    // //去副檔名 並且 重新命名
    // public function Del_deputy_file_name($file)
    // {
    //     $num = rand(0, 9) . rand(0, 9) . rand(0, 9) . time();
    //     $fileName = $num . $file;
    //     $secondFileName = explode('.',$fileName)[1];
    //     // if (false !== $pos = strripos($fileName, '.')) {
    //     //     dd($fileName);
    //     //     $fileName = substr($fileName, 0, $pos);

    //     // }
    //     $fileName = md5($fileName).'.'.$secondFileName;
    //     return $fileName;
    // }
/* -------------------------------------------------------------------------- */

    /**
     * 寄簡訊 Class版
     */
    public function sendSMS()
    {
        $config = [
            [
                'phone'=>'0930597708',
                'ctx' => '立即送達簡訊'
            ],
            [
                'phone' => '0930597708',
                'ctx' => '這是及時發送'.chr(6).'現在時間'.date('YmdHis').chr(6).'預計送達時間'.date('YmdHis',strtotime('+ 8 hours 11 minutes',strtotime(date('YmdHis')))),
                'bookTime' => date('YmdHis',strtotime('+ 11 minutes',strtotime(date('YmdHis'))))
            ]
        ];

        $sms = (new sendSMS($config))->run();
        if($sms){
            return response()->json(['status'=>'success']);
        }else{
            return response()->json(['statue' => 'some sms fail']);
        }
    }

    public function varDbCol()
    {
        $mainFlow = [
            'model'=>'MainFlowLog',
            'mainFlowId' => 'mainflow_id',
            'claim_id' => 'claim_id',
            'st' => 'state',
            'm' => 'msg',
            'isE' => 'isError',
            'creatTime' => 'created_at'
        ];

        $OS = microtime(true);
        $md = new MainFlowLog;
        $md->claim_id = 1;
        $md->state = 1;
        $md->msg = 'hello';
        $md->isError = 0;
        $md->created_at = date('Y-m-d H:i:s');
        $md->save();
        $OE = microtime(true);


        $VS = microtime(true);
        $model =  'App'.'\\' . $mainFlow['model'];
        $model = new $model;
        $model->{$mainFlow['claim_id']} = 1;
        $model->{$mainFlow['st']} = 1;
        $model->{$mainFlow['m']} = 'hello';
        $model->{$mainFlow['isE']} = 0;
        $model->{$mainFlow['creatTime']} = date('Y-m-d H:i:s');
        $model->save();
        $VE = microtime(true);



        $V = $VE-$VS;
        $O = $OE-$OS;
        dd($V,$O);
    }

    public function claimToOrder()
    {
        try {
            DB::beginTransaction();

            $tenderIdArray = [];
            $tenderIdsData = DB::select('SELECT
                td.tender_documents_id
            FROM
                tender_documents AS td
            LEFT JOIN claims AS c
            ON
                c.claim_id = td.claim_id
            WHERE
            c.claim_state = 2 AND td.is_order_create = 0');

            foreach ($tenderIdsData as $key => $value) {
                array_push($tenderIdArray,$value->tender_documents_id);
            }

            $orderData = DB::select('SELECT
                                            SUM(td.amount) as expected_amount,
                                            u.virtual_account as virtual_account,
                                            u.user_id as user_id
                                        FROM
                                            tender_documents AS td
                                        LEFT JOIN claims AS c
                                        ON
                                            c.claim_id = td.claim_id
                                        LEFT JOIN users AS u
                                        ON
                                            u.user_id = td.user_id
                                        WHERE
                                            c.claim_state = 2 AND td.is_order_create = 0
                                        GROUP BY
                                            u.user_id');

            foreach ($orderData as $k => $v) {
                $od = new Order;
                $od->virtual_account = $v->virtual_account;
                $od->expected_amount = $v->expected_amount;
                $od->created_at = date('Y-m-d H:i:s');
                $od->updated_at = date('Y-m-d H:i:s');
                $od->save();
                $td = Tenders::select('tender_documents_id')->where('user_id',$v->user_id)->get();
                foreach ($td as $key => $value) {
                    if(in_array($value->tender_documents_id,$tenderIdArray)){
                        //如果這個user_id 找出來的tender 是需要轉換的 tender
                        $tender = Tenders::find($value->tender_documents_id);
                        $tender->order_id = $od->order_id;
                        $tender->is_order_create = 1;
                        $tender->updated_at = date('Y-m-d H:i:s');
                        $tender->save();
                    }
                }
            }
            DB::commit();

            // dd($orderData,$tenderIdArray);
            dd('success');
        } catch (\Throwable $th) {
            DB::rollback();
            dd('fail');
        }

    }

    public function orderSendSms()
    {
        try {
            $od = DB::select('SELECT
                                u.phone_number as phone_number,
                                o.order_id as order_id
                            FROM
                                orders as o
                                left join users as u on u.virtual_account = o.virtual_account
                            WHERE
                                o.is_send_sms = 0');
            $config = [];
            $ctx = config('sms.MainFlow.sendByOrderCtx');
            foreach($od as $v){
                if(isset($v->phone_number)){
                    $ar = [
                        'phone'=> $v->phone_number,
                        'ctx' => $ctx
                    ];
                    array_push($config,$ar);
                    $order = Order::find($v->order_id);
                    $order->is_send_sms = 1;
                    $order->updated_at = date('Y-m-d H:i:s');
                    $order->save();
                }
            }


            $sms = (new sendSMS($config))->run();
            if($sms){
                return response()->json(['status'=>'success']);
            }else{
                return response()->json(['status' => 'some sms fail']);
            }
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
