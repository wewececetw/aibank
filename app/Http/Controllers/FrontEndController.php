<?php

namespace App\Http\Controllers;

use App\Claim;
use App\CustomSettings;
use App\Mail\SampleMail;
use App\Match;
use App\PayBackCount\equalPrincipalPayment;
use App\PayBackCount\equalTotalPayment;
use App\PayBackCount\SmartInvestment;
use App\RoiSettings;
use App\SystemVariables;
use App\Tenders;
use App\User;
use App\UsersRoles;
use App\UserBank;
use App\Web_contents;
//智能投資試算
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

//郵件相關
use response;
use Storage;

class FrontEndController extends Controller
{
    public function get_default_rate_table(Request $req)
    {
        // dd($req->year);

        $url = url('/') . '/' . Storage::url('uploads/default_rate_table/dpd30/6/web_2018-06-30_.jpg');
        return response()->json([
            'dpd30' => [
                'url' => $url,
            ],
        ]);
    }
    public function test()
    {
        $all_sql = DB::connection('pponline')->select('SELECT * FROM pusher_detail as p,(SELECT repayment_id,count(*) FROM pusher_detail GROUP by repayment_id HAVING count(1) > 1) d WHERE d.repayment_id=p.repayment_id order by target_repayment_date ')->toArray();
    
        $single_sql = DB::connection('pponline')->select('SELECT repayment_id,count(*) FROM pusher_detail GROUP by repayment_id HAVING count(1) > 1')->toArray();
        $ar = [];
        foreach ($all_sql as $v=>$k){
        $aa = $all_sql[$v]['id'];
        array_push($ar,$aa);
        }
        $br = [];
        foreach ($single_sql as $v=>$k){
        $bb = $single_sql[$v]['id'];
        array_push($br,$aa);
        }
        $end_id =  array_diff($ar,$br);
        $end_id_1 =implode(',',$end_id);
        $end_sql = DB::select('SELECT * FROM pusher_detail WHERE id IN('.$end_id_1.') ');
        print_r($end_sql); 
    }

    //註冊頁面

    public function sign_up()
    {
        return view('Front_End.sign_up_panel');
    }

    //登入頁面

    public function sign_in()
    {
        return view('Front_End.sign_in_panel');
    }

    //忘記密碼頁面

    public function password_new()
    {

        return view('Front_End.forgot_password_panel');
    }

    // 首頁

    public function index()
    {
        $datas = DB::select("select * from data_value");
        $result = array();
        foreach ($datas as $data) {
            if ($data->value_name == 'annualBenefitsRate') {
                $result['annualBenefitsRate'] = $data->value;
            } else if ($data->value_name == 'memberBenefits') {
                $result['memberBenefits'] = $data->value;
            } else if ($data->value_name == 'totalInvestAmount') {
                $result['totalInvestAmount'] = $data->value;
            }
        }
        $result['news'] = Web_contents::Where(['category' => '10', 'is_active' => '1'])->Orderby('launch_at', 'desc')->get();
        if(Auth::check()){
            //重複的sql
            $sql = '(SELECT count(*) FROM `log_internal_letters` bb WHERE bb.internal_letter_id = aa.`internal_letter_id`  and bb.`user_id`= ? and bb.isDisplay = 0 or  bb.read_at is not null and bb.internal_letter_id = aa.`internal_letter_id`  and bb.`user_id`= ?)';
            //查詢是否隱藏的訊息包含自己的身分別、單一屬於自己的信、全部類別信
            $letters = DB::select("SELECT * FROM `internal_letters` aa  where aa.`user_ids` = ?  AND $sql = 0 and aa.isDisplay = 1 and aa.created_at >= ? or aa.`user_ids` = -4 and aa.isDisplay = 1 and aa.created_at >= ?  AND $sql = 0 or aa.`user_ids` = ? and aa.isDisplay = 1 and aa.created_at >= ? AND $sql = 0 ORDER BY aa.created_at desc",[Auth::user()->user_id,Auth::user()->user_id,Auth::user()->user_id,Auth::user()->approved_at,Auth::user()->approved_at,Auth::user()->user_id,Auth::user()->user_id,0-Auth::user()->user_identity,Auth::user()->approved_at,Auth::user()->user_id,Auth::user()->user_id]);
            $result['letters_count'] = count($letters);
        }
        $activity = array();
        if(Auth::check()){
            $activity = DB::SELECT('SELECT elo.* FROM `event_list` el , `event_log` elo WHERE el.`e_l_ing` = 1 and el.`e_l_seq` = elo.`e_l_seq` and elo.user_id = ?',[Auth::user()->user_id]);
        }
        
        if(!empty($activity)){
            $result['activity'] = 'style = display:none';
        }else{
            $result['activity'] = '';
        }
/*
        $banner = Web_contents::bannerUrlList(1);
        $result['banner'] = [
            url('/banner/img/2.gif'),
        ];
        $result['banner'] = array_merge($result['banner'],$banner);
*/      
        $result['defaultRate_name'] =  Web_contents::categoryDistincName(15);
        $result['defaultRate_data'] = (new Web_contents)->getDefaultRateIndexViewData();
        return view('Front_End.home.panel', $result);
    }

    // 關於我們

    public function about_index()
    {

        $banner = Web_contents::bannerUrlList(4);
        $data = Web_contents::where('category',4)->where('is_active',1)->orderBy('sort','asc')->get()->toArray();
        return view('Front_End.about.business_model',[
            'banner' => $banner,
            'data' => $data
        ]);
    }

    // 財經專區

    public function about_index_finance()
    {

        $data['fin_news'] = Web_contents::with('news_photo')->Where(['category' => '3', 'is_active' => '1'])->Orderby('sort', 'asc')->get();

        return view('Front_End.about.finance', $data);
    }

    // 新聞
    public function about_index_news()
    {

        $data['news'] = Web_contents::Where(['category' => '10', 'is_active' => '1'])->Orderby('sort', 'asc')->get();

        return view('Front_End.about.news', $data);
    }
    
    //關於豬豬在線
    public function about_pp()
    {
        return view('Front_End.about.pp');
    }

    public function news_details(Request $request)
    {

        $id = $request->id;

        $result['news'] = Web_contents::Where('web_contents_id', '=', $id)->first();

        return view('Front_End.about.news_detail', $result);
    }

    // 操作指南

    public function operation_index()
    {
        return view('Front_End.operation.operational_process');
    }
    public function operation_faq()
    {
        $listGroup = Web_contents::select('name')->Where(['category'=>6,'is_active'=>1])->distinct()->get()->map(function($i){
            return $i->name;
        })->toArray();
        $qa = Web_contents::select('title','content','name')->Where(['category'=>6,'is_active'=>1])->get()->toArray();
        return view('Front_End.operation.faq',[
            'qa' => $qa,
            'listGroup' => $listGroup
        ]);
    }

    /**
     * 使用者的投資設定與default組合
     */
    public function combineUserHabitWithDefault($user_id)
    {
        $default = config('customSettingParams');
        $uData = CustomSettings::select(
            "roi_setting_id",
            "a_percent",
            "b_percent",
            "c_percent",
            "d_percent",
            "e_percent")->where('user_id', $user_id)->orderBy('created_at', 'desc')->first()->toArray();
        $uD = [
            'roi_setting_id' => $uData['roi_setting_id'],
        ];
        foreach ($uData as $k => $u) {
            if ($u !== 0) {
                $uD[$k] = $u;
            }
        }

        foreach ($default as $key => $v) {
            if ($v['roi_setting_id'] == $uD['roi_setting_id']) {
                $default[$key] = $uD;
            }
        }
        return $default;
    }
    function birthday2($birthday){
        list($year,$month,$day) = explode("-",$birthday);
        $year_diff = date("Y") - $year;
        $month_diff = date("m") - $month;
        $day_diff  = date("d") - $day;
        if ($day_diff < 0 || $month_diff < 0)
        $year_diff--;
        return $year_diff;
    }
    //智能媒合

    public function claim_match()
    {
        if (Auth::check()) {
            $birthday = (isset(Auth::user()->birthday))?Auth::user()->birthday : date('Y-m-d');
            $age = $this->birthday2($birthday);
            if($age < 20){
                return redirect()->back()->with('ageNotAllow', true);
            }
            if(Auth::user()->user_state != 1){
                return redirect()->back()->with('userStateNotAllow', true);
            }
            //後台使用者阻擋
            $role = UsersRoles::where('user_id', Auth::user()->user_id)->first()->role_id;
            if ($role == 2) {
                return redirect('/')->with('claimMatchPermission', true);
            }
            //沒銀行帳號阻擋
            $userBankCheck = UserBank::checkUserBank(Auth::user()->user_id);
            if($userBankCheck === false){
                return redirect('/users/tab_two')->with('claimMatchUserBank', true);
            }

            $roiSetData = RoiSettings::all()->toArray();
            try {
                $defaultSetting = $this->combineUserHabitWithDefault(Auth::user()->user_id);
                $roi_id = CustomSettings::where('user_id', Auth::user()->user_id)->orderBy('created_at', 'desc')->first()->roi_setting_id;
            } catch (\Throwable $th) {
                $defaultSetting = config('customSettingParams');
                $roi_id = 1;

            }

            return view('Front_End.category.claim_match', [
                'defaultSetting' => json_encode($defaultSetting),
                'roi_id' => $roi_id,
                'roiSetData' => $roiSetData,
            ]);
        } else {
            return redirect('/login')->with('claimMatch', true);
        }

    }

    /**
     * 投標 一次多筆
     *
     * @param  mixed $req
     * @return void
     */
    public function multipleCreateTender(Request $req)
    {
        try {
            if (Auth::user()->banned == 1) {
                return response()->json([
                    'status' => 'banned',
                ]);
            }
            $role = UsersRoles::where('user_id', Auth::user()->user_id)->first()->role_id;
            if ($role == 2) {
                return response()->json([
                    'status' => 'permission',
                ]);
            }
            DB::beginTransaction();
            $reqAll = $req->all()['data'];
            $min = 1000;
            $payment_deadline = SystemVariables::where('variable_name', '=', 'payment_deadline')->get('value')[0]->value;
            $user_id = Auth::user()->user_id;
            $member_number = Auth::user()->member_number;
            $user_name = (isset(Auth::user()->user_name)) ? Auth::user()->user_name : '';
            $email = trim(Auth::user()->email);

            foreach ($reqAll as $c) {
                $claim_total_tender_amount = Tenders::where('claim_id', $c['claim_id'])->select(DB::raw('IFNULL(SUM(amount),0) as tenderSum'))->get()->toArray()[0]['tenderSum'];
                $claim_amount = Claim::find($c['claim_id'])->staging_amount;
                $is_pre_invest = Claim::find($c['claim_id'])->is_pre_invest;
                $claim_state = Claim::find($c['claim_id'])->claim_state;
                $canThrow = $claim_amount - $claim_total_tender_amount;
                if ($claim_state == '上架預覽' && $is_pre_invest == 1 || $claim_state == '募集中') {
                    if ($c['throwAmount'] <= $canThrow && $c['throwAmount'] >= $min) {
                        $claims = Claim::find($c['claim_id']);

                        $tender = new Tenders;
                        $tender->user_id = $user_id;
                        $tender->claim_id = $c['claim_id'];
                        $order_number = Tenders::with(['tenders_claim'])->where('claim_id', $c['claim_id'])->orderBy('order_number', 'desc')->first('order_number');
                        if (isset($order_number)) {
                            $tender->order_number = sprintf("%03d", ($order_number->order_number) + 1);
                        } else {
                            $tender->order_number = sprintf("%03d", 1);
                        }
                        $tender->amount = $c['throwAmount'];
                        $tender->created_at = date('Y-m-d H:i:s');
                        $tender->claim_certificate_number = $member_number . $tender->order_number . $c['claim_number'];
                        $tender->should_paid_at = $claims->payment_final_deadline;
                        $tender->save();
                    // $from = false;
                    // $title = 'php-PPonline-投資成功通知';
                    // $ctx = ['親愛的' . $user_name . '先生/女士',
                    //     '您投資債權' . $claims->claim_number . '成功!',
                    //     '您本次投標金額為:' . $tender->amount,
                    //     '您的【債權憑證號為:' . $tender->claim_certificate_number .'】',
                    //     '投標成功時間:' . $tender->created_at,
                    //     '標單繳款期限為:' . $tender->should_paid_at,
                    // ];

                    // $mailTo = [$email];
                    // foreach ($mailTo as $v) {
                    //     $canMail = $this->checkUserCanReciveMail($v);
                    //     if ($canMail) {
                    //         Mail::to($v)->send(new SampleMail($ctx, $from, $title));
                    //     }
                    // }
                    } else {
                        DB::rollback();
                        return response()->json([
                        'status' => 'amountOver',
                    ]);
                        // return response()->json([
                    //     'status' => 'fail',
                    // ]);
                    }
                } else {
                    DB::rollback();
                    return response()->json([
                    'status' => 'claimError',
                ]);
                    // return response()->json([
                //     'status' => 'fail',
                // ]);
                }
            }
            DB::commit();
            return response()->json([
                'status' => 'success',
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            dd($th);
        }
    }

    // 貸款專區

    public function loan_index()
    {
        return view('Front_End.loan.panel');
    }

    /**
     * 服務合約
     */
    public function service_contract()
    {
        return view('Front_End.service_contract');
    }
    /**
     * 隱私權政策
     */
    public function privacy()
    {
        return view('Front_End.privacy');
    }
    /**
     * 服務合約
     */
    public function risk()
    {
        return view('Front_End.risk');
    }

    /**
     * 智能投資試算
     */
    public function totalSplits(Request $req)
    {
        try {
            $user_id = Auth::user()->user_id;
            $reqAll = $req->all();
            //投資金額
            $amount = (int) $reqAll['amount'] * 10000;
            //期數(陣列)
            $peroids = $reqAll['periods'];
            //投資設定
            $investment_setting = CustomSettings::beautifulSetting($reqAll['methods']);
            $SmartInvestment = new SmartInvestment($amount, $peroids, $investment_setting);
            $SmartInvestment = $SmartInvestment->getResult();
            // print_r($investment_setting);exit;
            
            if ($SmartInvestment == 'amountOverLoad') {
                return response()->json([
                    'status' => 'amountOverLoad',
                ]);
            } else if ($SmartInvestment == 'noClaim') {
                return response()->json([
                    'status' => 'noClaim',
                ]);
            } else if (gettype($SmartInvestment) == 'array') {
                if (!isset($SmartInvestment['success'])) {
                    return response()->json([
                        'status' => 'someSetOverLoad',
                        'data' => implode(',', $SmartInvestment),
                    ]);
                }
            }
            $selectArray = [
                'claim_id',
                'risk_category',
                'annual_interest_rate',
                'claim_number',
                'staging_amount',
                'remaining_periods',
                'launched_at',
                'estimated_close_date',
                'repayment_method',
            ];
            $result = [];
            $idMethods = [];
            // return print_r($SmartInvestment['result']);
            foreach ($SmartInvestment['result'] as $key => $value) {
                $d = Claim::select($selectArray)->find($value['claim_id'])->toArray();
                $d['throwAmount'] = $value['throwAmount'];
                $d['max_amount'] = $value['max_amount'];
                $d['progress'] = floor($value['progress']);
                $d['pdf_url'] = url("/test/downloadClaimPdf/$user_id") . '/' . $d['claim_id'] . '/' . $value['throwAmount'];
                $ar = [
                    'rate' => $d['annual_interest_rate'],
                    'peroid' => $d['remaining_periods'],
                    'amount' => $value['throwAmount'],
                    'method' => $d['repayment_method'],
                ];
                array_push($idMethods, $ar);
                array_push($result, $d);
            }
            $intrestSum = 0;
            $principalSum = 0;
            foreach ($idMethods as $v) {
                if ($v['method'] == '先息後本') {
                    $equalPrincipalPayment = new equalPrincipalPayment($v['rate'], $v['peroid'], $v['amount']);
                    $money = $equalPrincipalPayment->run();
                } else {
                    $equalTotalPayment = new equalTotalPayment($v['rate'], $v['peroid'], $v['amount']);
                    $money = $equalTotalPayment->run();
                }
                $intrestSum += array_sum($money['everyMonthInterest']);
                $principalSum += array_sum($money['everyMonthPrincipal']);
            }
            return response()->json([
                'status' => 'success',
                'result' => $result,
                'intrestSum' => $intrestSum,
                'principalSum' => $principalSum,
            ]);
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function randomTotalSplits(Request $req)
    {
        
        try {
            $user_id = Auth::user()->user_id;
            $reqAll = $req->all();
            //投資金額
            $amount = (int) $reqAll['amount'] * 10000;

            $peroids = $this->maxPeriods();

            $SmartInvestment = new SmartInvestment($amount, $peroids, []);
            $SmartInvestment = $SmartInvestment->getRandomResult();

            if ($SmartInvestment == 'amountOverLoad') {
                return response()->json([
                    'status' => 'amountOverLoad',
                ]);
            } else if ($SmartInvestment == 'noClaim') {
                return response()->json([
                    'status' => 'noClaim',
                ]);
            } else if (gettype($SmartInvestment) == 'array') {
                if (!isset($SmartInvestment['success'])) {
                    return response()->json([
                        'status' => 'someSetOverLoad',
                        'data' => implode(',', $SmartInvestment),
                    ]);
                }
            }
// 跟一班的智能媒合重複 S
            $selectArray = [
                'claim_id',
                'risk_category',
                'annual_interest_rate',
                'claim_number',
                'staging_amount',
                'remaining_periods',
                'launched_at',
                'estimated_close_date',
                'repayment_method',
            ];
            $result = [];
            $idMethods = [];
            foreach ($SmartInvestment['result'] as $key => $value) {
                if($value['throwAmount'] != 0){
                    $d = Claim::select($selectArray)->find($value['claim_id'])->toArray();
                    $d['throwAmount'] = $value['throwAmount'];
                    $d['max_amount'] = $value['max_amount'];
                    $d['progress'] = floor($value['progress']);
                    $d['pdf_url'] = url("/test/downloadClaimPdf/$user_id") . '/' . $d['claim_id'] . '/' . $value['throwAmount'];
                    $ar = [
                        'rate' => $d['annual_interest_rate'],
                        'peroid' => $d['remaining_periods'],
                        'amount' => $value['throwAmount'],
                        'method' => $d['repayment_method'],
                    ];
                    array_push($idMethods, $ar);
                    array_push($result, $d);
                }
            }
            $intrestSum = 0;
            $principalSum = 0;
            foreach ($idMethods as $v) {
                if ($v['method'] == '先息後本') {
                    $equalPrincipalPayment = new equalPrincipalPayment($v['rate'], $v['peroid'], $v['amount']);
                    $money = $equalPrincipalPayment->run();
                } else {
                    $equalTotalPayment = new equalTotalPayment($v['rate'], $v['peroid'], $v['amount']);
                    $money = $equalTotalPayment->run();
                }
                $intrestSum += array_sum($money['everyMonthInterest']);
                $principalSum += array_sum($money['everyMonthPrincipal']);
            }
            return response()->json([
                'status' => 'success',
                'result' => $result,
                'intrestSum' => $intrestSum,
                'principalSum' => $principalSum,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }
    }

    public function maxPeriods()
    {
        $sql = Claim::select(DB::raw('MAX(remaining_periods) as maxPeriods'))->where('claim_state', 1)->first()->maxPeriods;
        $result = [];
        for ($x = 1; $x < $sql + 1; $x++) {
            array_push($result, $x);
        }
        return $result;
    }
    /**
     * 隨機媒合的核心 (新的)
     *
     * @param  mixed $amount
     * @return void
     */
    public function randomRisk($amount)
    {
        $sql = DB::select("SELECT DISTINCT
                                (c.risk_category),
                                c.staging_amount - IFNULL(SUM(td.amount),
                                0) AS MAX
                            FROM
                                claims AS c
                            LEFT JOIN tender_documents AS td
                            ON
                                td.claim_id = c.claim_id
                            WHERE
                                c.claim_state = 1 AND c.risk_category != 8
                            GROUP BY
                                c.risk_category");
        $sql = $this->getArray($sql);
        $riskCount = count($sql);

        $res = [];
        $percent = 100;
        for ($x = 0; $x < 10; $x++) {
            for ($y = 0; $y < $riskCount; $y++) {
                $risk = $sql[$y]['risk_category'];
                $max = $sql[$y]['MAX'];
                if (!isset($res[$risk])) {
                    $res[$risk] = 0;
                }
                $nowAmountCount = ($res[$risk] / 100) * $amount;
                if ($nowAmountCount != $max && $percent != 0) {
                    $res[$risk] += 10;
                    $percent -= 10;
                }

            }
        }
        // dd($res);
        return $res;
    }
    /**
     * 隨機媒合的核心 (舊的 依照比例)
     *
     * @param  mixed $amount
     * @return void
     */
    public function randomRisk_bk($amount)
    {
        $sql = DB::select("SELECT DISTINCT
                                (c.risk_category),
                                c.staging_amount - IFNULL(SUM(td.amount),
                                0) AS MAX
                            FROM
                                claims AS c
                            LEFT JOIN tender_documents AS td
                            ON
                                td.claim_id = c.claim_id
                            WHERE
                                c.claim_state = 1 AND c.risk_category != 8
                            GROUP BY
                                c.risk_category");
        $sql = $this->getArray($sql);
        $riskCount = count($sql);

        $res = [];
        $percent = 100;
        for ($x = 0; $x < 10; $x++) {
            for ($y = 0; $y < $riskCount; $y++) {
                $risk = $sql[$y]['risk_category'];
                $max = $sql[$y]['MAX'];
                if (!isset($res[$risk])) {
                    $res[$risk] = 0;
                }
                $nowAmountCount = ($res[$risk] / 100) * $amount;
                if ($nowAmountCount != $max && $percent != 0) {
                    $res[$risk] += 10;
                    $percent -= 10;
                }

            }
        }
        return $res;
    }


    public function rule (Request $request){

        
        $data = DB::SELECT('SELECT * FROM `event_list` WHERE `e_l_seq` = ?',[$request['type']]);
        $check = DB::SELECT('SELECT * FROM `event_log` WHERE `user_id` = ? and `e_l_seq` = ?' ,[Auth::user()->user_id,$request['type']]);

        if(empty($check)){
            DB::insert('INSERT INTO `event_log`(`user_id`, `e_l_seq`, `e_log`, `e_log_date`, `e_log_ip`) VALUES (?,?,?,?,?) ',[Auth::user()->user_id,$data[0]->e_l_seq,'同意',date("Y-m-d H:i:s"),$request->ip()]);
        }
        



    }

    

    /**
     * 把DB::select 轉成陣列用類似 model->toArray()
     * 但DB好像沒有toArray()(應該吧)
     *
     * @param  mixed $collection
     * @return void
     */
    private function getArray($collection)
    {
        $res = [];
        foreach ($collection as $k => $v) {
            array_push($res, (array) $v);
        }
        return $res;
    }

}
