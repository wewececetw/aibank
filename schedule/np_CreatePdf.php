<?php

include_once("common/equalPrincipalPayment.php");
include_once("common/equalTotalPayment.php");
include_once("setsql/setdb.php");
include_once('dompdf/autoload.inc.php'); 

use Dompdf\Dompdf;

class ClaimPdf
{
    public $User;
    public $Claim;
    public $Payment;
    public $Amount;
    public $managmentFee;
    public $timeArray;
    public $pdf ;
    public $ClaimArray;
    public $thirdPartyManagmentFeeArray;
    /**
     * 建構子
     * @param string|int $user_id 使用者ID
     * @param string|int $claim_id 債權ID
     * @param string|int $amount 投資金額
     * @param string $claim_certificate_number 債權憑證號
     *
     * @return bool 如果出錯回傳false
     */
    public function __construct($user_id, $claim_id, $amount, $claim_certificate_number=false)
    {
        // try {
            ini_set('date.timezone','Asia/Taipei');
            $User_sql = "SELECT * FROM `users` WHERE `user_id` = $user_id";


            $link = mysqli_connect("localhost","kqzwlrrm_pp_user","jCgz91Ib8}uR","kqzwlrrm_ppo_nline");
            mysqli_query($link,"set names utf8");

            $ro = mysqli_query($link,$User_sql);
            // if(!$ro){var_dump(mysqli_error($link));}
            // exit;
            $User_row = mysqli_fetch_assoc($ro); 

            $this->User = $User_row;

            $claim_sql = "SELECT * FROM `claims` WHERE `claim_id` = $claim_id";

            $ro1 = mysqli_query($link,$claim_sql);
            // if(!$ro){var_dump(mysqli_error($link));}
            // exit;
            $Claim_row = mysqli_fetch_assoc($ro1); 
            $this->Claim = $Claim_row;
            $this->Amount = $amount;

            
            $td_sql = 'SELECT tender_documents_id FROM pdf_log WHERE is_run = 0 ORDER BY pdf_id ASC';

            $do = mysqli_query($link,$td_sql);
            // if(!$ro){var_dump(mysqli_error($link));}
            // exit;
            $dow = mysqli_fetch_assoc($do); 

            $td_sql2 = 'SELECT created_at FROM tender_documents WHERE tender_documents_id = '.$dow['tender_documents_id'];
            $do2 = mysqli_query($link,$td_sql2);
            // if(!$ro){var_dump(mysqli_error($link));}
            // exit;
            $dow2 = mysqli_fetch_assoc($do2); 

            // if ($this->Claim && $this->User) {
                if ($this->Claim['repayment_method'] == '0') {
                    $payment = new equalPrincipalPayment($this->Claim['annual_interest_rate'], $this->Claim['remaining_periods'], $amount);
                    $this->Payment = $payment->run();
                } else {
                    $payment = new equalTotalPayment($this->Claim['annual_interest_rate'], $this->Claim['remaining_periods'], $amount);
                    $this->Payment = $payment->run();
                }
                $this->timeArray = $payment->getPeriodsTimeArrayNew($this->Claim['remaining_periods'], $this->Claim['value_date']);

                //計算服務費 每月利息 * managment_fee_rate百分比後 四捨五入
                $managmentFee = [];
                foreach ($this->Payment['everyMonthInterest'] as $k => $v) {
                    $fee = round($v * $this->Claim['management_fee_rate'] * 0.01);
                    array_push($managmentFee, $fee);
                }
                $this->managmentFee = $managmentFee;
                $this->ClaimArray = $this->claimChangeNull();
                if (strtotime($User_row['discount_start']) <= strtotime($dow2['created_at']) && strtotime($User_row['discount_close']) >= strtotime($dow2['created_at'])) {
                    $this->thirdPartyManagmentFeeArray = $this->thirdPartyManagmentFee($this->Payment['everyMonthInterest'], $this->Claim['management_fee_rate'] * $User_row['discount']);
                }else{
                    $this->thirdPartyManagmentFeeArray = $this->thirdPartyManagmentFee($this->Payment['everyMonthInterest'], $this->Claim['management_fee_rate']);
                }
            //$this->thirdPartyManagmentFeeArray = $managmentFee;
            // } else {
            //     return false;
            // }
        // } catch (\Throwable $th) {
        //     return false;
        // }
    }


    /**
     *計算丙方平台服務費 = (甲方利息*10%)四捨五入後 均分於每期 每期將小數位取出只留整數，將小數位總和加至最後一期
     */
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
     * 將Null轉為空值並塞入判斷顯示債權憑證編號
     */
    public function claimChangeNull()
    {
        $c = [];
        foreach ($this->Claim as $key => $value) {
            if(isset($value)){
                $c[$key] = $value;
            }else{
                $c[$key] = '';
            }
        }
        $showClaimNum = ( $c['claim_state'] == 2 )?true:false;
        $c['showClaimNum'] = $showClaimNum;
        return $c;
    }
    
    /**
     * 儲存所有的債權憑證
     * @param string|int $id tender_id
     */
    public function saveClaimTendersPdf($id,$claim_certificate_number)
    {
        // try {

            
            $dompdf = new DOMPDF();

            $firstPartyTotal = array_sum($this->Payment['everyMonthPrincipal']) + array_sum($this->Payment['everyMonthInterest']);
            $user = $this->User;
            $claim = $this->ClaimArray;
            $amount = $this->Amount;
            $money = $this->Payment;
            $managmentFee = $this->managmentFee;
            $timeArray = $this->timeArray;
            $firstPartyTotal = $firstPartyTotal;
            $thirdPartyManagmentFeeArray = $this->thirdPartyManagmentFeeArray;
            $thirdPartyManagmentFeeTotal = array_sum($this->thirdPartyManagmentFeeArray);
            $claim_certificate_number = $claim_certificate_number;
            $all_everyMonthPrincipal = array_sum($this->Payment['everyMonthPrincipal']);
            $all_everyMonthInterest = array_sum($this->Payment['everyMonthInterest']);

            $html = "<html>

<head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <meta http-equiv='Content-Style-Type' content='text/css' />
    <meta name='generator' content='Aspose.Words for .NET 17.1.0.0' />
    <title>信任豬智能債權媒合平台</title>
    <style>
        body{
            font-family: 'simsun';
            font-size: 12pt;
            white-space:normal;
            margin:0;
            line-height:12pt ;
        }
        td {
            border-style: solid;
            border-width: 0.75pt;
            vertical-align: middle;
            display:table-cell;
        }
        td > p {
            margin-left:5pt;
            margin-right:5pt;
        }
        table {
            border-collapse: collapse
        }

        .specialText {
            font-size: 10pt;
            color: #0070c0;
            height: 10pt;
            margin: 0pt;
        }

        .title {
            margin:0pt 140.5pt 0pt 142.5pt;
            text-align:center;
            line-height:25.55pt;
            widows:0;
            orphans:0;
        }
        .title_w { font-size:22pt; }
        .td ,.td2{
            width:122.2pt;
            border-style:solid;
            border-width:0.75pt;
            padding-right:5.03pt;
            padding-left:5.03pt;
            vertical-align:middle;
        }
        .td2{ width:386pt;}
        .p_typ_1{
            margin-top:1.3pt;
            margin-right:10pt;
            margin-bottom:0pt;
            line-height:113%;
        }
        .td_2,.td2_2,.td2_2_sp{
            width:200.2pt;
            border-style:solid;
            border-width:0.75pt;
            padding-right:5.03pt;
            padding-left:5.03pt;
            vertical-align:unset;
        }
        .td2_2{ 
            width: 288pt; 
            word-wrap:break-word; 
        }
        .hidden_td ,.hidden_td2{
            width:12.2pt;
            /* border-style:solid;  */
            border-width:0pt;
            /* padding-right:5.03pt; */
            /* padding-left:5.03pt; */
            word-wrap:break-word;
            vertical-align:unset;
        }
        .hidden_td2{ width:352pt;}
        /*一行內中文字標題*/
        .hidden_td_titl_sp{
            width:28.2pt;
            /* border-style:solid;  */
            border-width:0pt;
            /* padding-right:5.03pt; */
            /* padding-left:5.03pt; */
            word-wrap:break-word;
            vertical-align:unset;
        }
        /*一行以上中文字標題*/
        .hidden_td_sp{
            width:18.2pt;
            /* border-style:solid;  */
            border-width:0pt;
            /* padding-right:5.03pt; */
            /* padding-left:5.03pt; */
            word-wrap:break-word;
            vertical-align:unset;
        }
        .td_3, .td2_3, .td3_3 , .td4_3, .td5_3{
            width:14.2pt;
            border-style:solid;
            border-width:0.75pt;
            padding-right:5.03pt;
            padding-left:5.03pt;
            vertical-align:unset;
            text-align:center
        }
        .td2_3{width:60pt;}
        .td3_3{width:40pt;}
        .td4_3{width:40pt;}
        .td5_3{width:30pt;}
    </style>
</head>

<body>
    <div>
        <p class='title'>
            <span class='title_w'>信任豬智能債權媒合平台</span><br />
            <span class='title_w'>債權讓售協議書</span>
        </p>
        <p style='margin:0;font-size:17pt'>
            <span>  </span>
             ";
        if (isset($claim_certificate_number)) {
            $html.="<span>債權憑證編號</span>
            <span>:</span>
            <span class='specialText'>";$html.=(isset($claim_certificate_number))?$claim_certificate_number:'' ."</span>
            ";
        }

       $html.= "</p>
        <p style='margin:0pt 0 10pt 22.5pt; text-indent:-22.5pt;'>壹、當事人</p>
        <p style='margin:0;'></p>
        <table cellspacing='0' cellpadding='10' style='border-collapse:collapse'>
            <tr style='height:53.7pt'>
                <td class='td'>買受人(即受讓人)</td>
                <td class='td2'>
                    <span class='specialText'>".$user['user_name']."</span>(下稱甲方)<br>
                    豬豬在線帳號：<a href='mailto:".$user['email']."'><span class='specialText'>".$user['email']."</span></a><br>
                    證件字號：<span class='specialText'>".$user['id_card_number']."</span>
                </td>
            </tr>
            <tr style='height:70.75pt'>
                <td class='td'>出賣人(即讓與人)</td>
                <td class='td2'>
                    <span class='specialText'>".$claim['seller_name']."</span>（下稱乙方）<br>
                    地址：<span class='specialText'>".$claim['seller_address']."</span><br>
                    負責人：<span class='specialText'>".$claim['seller_responsible_person']."</span><br>
                    證件字號：<span class='specialText'>".$claim['seller_id_number']."</span>
                </td>
            </tr>
            <tr style='height:63.3pt'>
                <td class='td'>債權讓售代理人</td>
                <td class='td2'>
                    <span class='specialText'>".$claim['agent_name']."</span><br>
                    地址：<span class='specialText'>".$claim['agent_address']."</span><br>
                    負責人：<span class='specialText'>".$claim['agent_responsible_person']."</span><br>
                    證件字號：<span class='specialText'>".$claim['agent_id_number']."</span>
                </td>
            </tr>
            <tr style='height:76.95pt'>
                <td class='td'>居間人</td>
                <td class='td2'>
                    信任豬股份有限公司（下稱丙方）<br>
                    網站平台名稱：豬豬在線債權媒合平台 (<a href='http://www.pponline.com.tw' style='color:#0000ff'>www.pponline.com.tw</a>)<br>                    
                    地址：台北市中山區南京東路二段216號6樓<br>
                    負責人：李家福<br>
                    證件字號：54179376
                </td>
            </tr>
            <tr style='height:63.2pt'>
                <td class='td'>逾期債權受託催理人</td>
                <td class='td2'>
                    亞洲信用管理股份有限公司<br>地址：新北市汐止區新台五路 1 段 106 號 8 樓<br>負責人：李元正<br>證件字號：70559817
                </td>
            </tr>
        </table>
        <p class='p_typ_1'>&#xa0;</p>
        <p class='p_typ_1'>貳、前  言</p>
        <br>
        <table cellspacing='0' cellpadding='6' style='border-collapse:collapse'>
            <tr style='height:75pt'>
                <td class='hidden_td_sp'>一、</td>
                <td class='hidden_td2'>豬豬在線債權媒合平台網站(www.pponline.com.tw)為丙方所開發及擁有，提供信用諮詢、債權買賣讓與、債權交易居間媒合及其他相關聯之服務。乙方擬將標的債權(定義詳本協議約定條款第二條標的債權之內容)出售並轉讓與甲方，甲方則擬買受並受讓標的債權。</td>
            </tr>
            <tr style='height:40pt'>
                <td class='hidden_td_sp'>二、</td>
                <td class='hidden_td2'>甲方透過豬豬在線債權媒合平台網站有關之規則和說明，進行標的債權之購買等相關操作，並同意及確認本協議之所有約定。</td>
            </tr>
            <tr style='height:20pt'>
                <td class='hidden_td_sp'>三、</td>
                <td class='hidden_td2'>甲乙丙三方爰約定條款如下，俾資遵循。</td>
            </tr>
        </table>
        <br>
        <table cellspacing='0' cellpadding='6' style='border-collapse:collapse'>
            <tr style='height:20pt'>
                <td colspan='2' class='hidden_td'>參、約定條款</td>
            </tr>
        </table>

        <table cellspacing='0' cellpadding='6' style='border-collapse:collapse'>
            <tr style='height:20pt'>
                <td class='hidden_td_titl_sp'>一、</td>
                <td class='hidden_td2'>債權讓與媒合說明：</td>
            </tr>
        </table>
    
        <table cellspacing='0' cellpadding='6' style='border-collapse:collapse'>
            <tr style='height:20pt'>
                <td class='hidden_td'>
                    1.
                </td>
                <td class='hidden_td2'>
                    本協議書（下稱“本協議”）由甲乙丙三方於中華民國 
                    <span style=' color:#0070c0; '>
                        ".(date('Y',strtotime($claim['value_date'])))."
                    </span>
                    年 
                    <span style=' color:#0070c0; '>
                        ".(date('m',strtotime($claim['value_date'])))."
                    </span>
                    月 
                    <span style=' color:#0070c0; '>
                        ".(date('d',strtotime($claim['value_date'])))."
                    </span>
                    日所約定。
                </td>
            </tr>
            <tr style='height:40pt'>
                <td class='hidden_td'>
                    2.
                </td>
                <td class='hidden_td2'>
                    本協議係由甲乙丙三方使用丙方所設立之豬豬在線債權媒合平台網站的債權讓與服務，根據豬豬在線債權媒合平台服務合約、隱私條款及其他相關協議自願達成約定。
                </td>
            </tr>
            <tr style='height:20pt'>
                <td class='hidden_td'>
                    3.
                </td>
                <td class='hidden_td2'>
                    使用本協議之甲方與乙方已事先閱讀、充分了解並認可豬豬在線債權媒合平台所提供之本協議。
                </td>
            </tr>
            <tr style='height:20pt'>
                <td class='hidden_td'>
                    4.
                </td>
                <td class='hidden_td2'>
                    本協議採用電子合約形式，其效力受中華民國法律保護，與紙本合約有同一效力。
                </td>
            </tr>
            <tr style='height:40pt'>
                <td class='hidden_td'>
                    5.
                </td>
                <td class='hidden_td2'>
                    甲方及乙方茲各自聲明與保證，其為具有民法上完全行為能力之自然人，或合法設立登記之法人或團體，並承諾其提供給丙方的資訊是完全真實，無任何虛偽或隱瞞。
                </td>
            </tr>
        </table>
        <br>
        <table cellspacing='0' cellpadding='6' style='border-collapse:collapse'>
            <tr style='height:40pt'>
                <td class='hidden_td_sp'>二、</td>
                <td class='hidden_td2'>買賣標的債權(下稱標的債權)為於豬豬在線債權媒合平台網站揭示之編號[ <span style=' color:#0070c0; '>".($claim['claim_number'])."</span> ]債權(下稱原債權)之一部，其相關資訊如下：</td>
            </tr>
        </table>
        
        <table cellspacing='0' cellpadding='2' style='border-collapse:collapse;'>
            <tr style='height:20pt'>
                <td class='td_2'>
                    原債權之金額、債務人、擔保品等
                </td>
                <td class='td2_2'>
                        <span style=' color:#0070c0; '>";
                            $name = number_format((float)$claim['original_claim_amount'], 0, '.', ',') . '、';
                            $name .= mb_substr($claim['borrower'],0,1,'utf-8');
                            $starCount = mb_strlen($claim['borrower'],'utf-8')-1;
                            for ($x=0;$x < $starCount;$x++) {
                                $name .= '*';
                            }
                            $html.= $name."
                        </span>
                </td>
            </tr>
            <tr style='height:20pt'>
                <td class='td_2'>
                    原債權金額出售範圍
                </td>
                <td class='td2_2'>
                        <span style=' color:#0070c0; '>".number_format($claim['max_amount'], 0, '.', ',')."</span>
                    
                </td>
            </tr>
            <tr style='height: 20pt'>
                <td class='td_2'>
                    標的債權之買賣價金
                </td>
                <td class='td2_2'>
                        <span style=' color:#0070c0; '>".number_format($amount, 0, '.', ',')."</span>
                </td>
            </tr>
            <tr style='height: 20pt'>
                <td class='td_2'>
                    標的債權占原債權之比例
                </td>
                <td class='td2_2'>
                    
                        <span style=' color:#0070c0; '>";
                            if (isset($claim['original_claim_amount']) && $claim['original_claim_amount'] !== '') {
                                $html.=round(($amount/$claim['original_claim_amount'])*100, 4)."%";
                            }else{ 
                                $html.="0%";
                            } 
                            $html.="</span>
                </td>
            </tr>
            <tr style='height: 20pt'>
                <td class='td_2'>
                   標的債權讓與日期(交割日)
                </td>
                <td class='td2_2'>
                    <span style=' color:#0070c0;' >
                        ";$html.=(date('Y-m-d',strtotime($claim['value_date'])))."
                    </span>
                </td>
            </tr>
            <tr style='height: 20pt'>
                <td class='td_2'>
                    標的債權之回收期間
                </td>
                <td class='td2_2'>
                        <span style=' color:#0070c0;' >";$html.=date('Y-m-d',strtotime($claim['value_date']))."~".date('Y-m-d', strtotime('+'.$claim['periods'].' month', strtotime($claim['value_date'])))."</span>
                </td>
            </tr>
            <tr style='height: 20pt'>
                <td class='td_2'>
                   標的債權年化收益
                </td>
                <td class='td2_2'>
                   <span style=' color:#0070c0; '>";$html.=$claim['annual_interest_rate']."%</span>
                </td>
            </tr>";
            // <tr style='height: 20pt'>
            //     <td class='td_2'>
            //         VIP 專屬回饋
            //     </td>
            //     <td class='td2_2'>
            //         <span style=' color:red; '>";$html.=$claim['major_traffic_fines']."</span>
            //     </td>
            // </tr>
            $html.="<tr style='height: 20pt'>
                <td class='td_2'>
                    甲方預定回收之標的債權本金及利息總額
                </td>
                <td class='td2_2'>
                    <span style=' color:#0070c0; '>";if(isset($firstPartyTotal)){$html.=number_format($firstPartyTotal, 0, '.', ',');}else{$html.= 0;} $html.="</span>
                </td>
            </tr>
            <tr style='height: 20pt'>
                <td class='td_2'>
                    給付方式
                </td>
                <td class='td2_2'>
                    <span style=' color:#0070c0; '>金融機構匯款</span>
                </td>
            </tr>
            <tr style='height: 20pt'>
                <td class='td_2'>
                    丙方之平台服務費
                </td>
                <td class='td2_2'>
                    <span style=' color:#0070c0; '>";$html.=$thirdPartyManagmentFeeTotal."</span>
                </td>
            </tr>
            <tr style='height: auto'>
                <td class='td_2'>
                   買回條款
                </td>
                <td class='td2_2'>
                    <span style='color:#0070c0;'>
                        1.逾期債權買回結算日為逾期起始的第40日。<br>2.買回給付日為逾期起始的第45日內。<br>3.剩餘債權本金100%買回，給付原始債權逾期起始日至<br>債權買回結算日的利息，未滿一期以一期計算。<br>4.原債權案件債務人提前全數清償時，結算剩餘本金100%買回，利息不足一期以一期計算，於清償日後5日內<br>結算買回。
                    </span>
                </td>
            </tr>
            <tr  style='height: 20pt'>
                <td colspan='2'>
                    乙方代收標的債權後，按附表一(下稱明細表)所示金額經由丙方給付甲方。
                </td>
            </tr>
        </table>

        <br>
        <br>
        <table cellspacing='0' cellpadding='6' style='border-collapse:collapse'>
            <tr style='height:20pt'>
                <td class='hidden_td_titl_sp'>三、</td>
                <td class='hidden_td2'>各方權利和義務：</td>
            </tr>
        </table>
        <table cellspacing='0' cellpadding='6' style='border-collapse:collapse'>
            <tr style='height:40pt'>
                <td class='hidden_td'>
                    1.
                </td>
                <td class='hidden_td2'>
                    甲方同意以上述標的債權之買賣價金向乙方購買標的債權，並應於丙方指定之期間將價金交付丙方，由丙方轉付乙方。
                </td>
            </tr>
            <tr style='height:40pt'>
                <td class='hidden_td'>
                    2.
                </td>
                <td class='hidden_td2'>
                    有下列任一狀況發生時，視為本協議解除條件之成就，本協議書失其效力，若當時甲方已支付買賣價金者，乙方應自行或指示丙方(於丙方已經收取甲方給付之買賣價金但尚未交付乙方之情形)返還甲方。
                </td>
            </tr>
            <tr style='height:40pt'>
                <td class='hidden_td'>
                    2.1
                </td>
                <td class='hidden_td2'>
                    於豬豬在線債權媒合平台網站所揭示之原債權之認購期間內，實際總認購金額未達該網頁揭示之最低金額者。
                </td>
            </tr>
            <tr style='height:40pt'>
                <td class='hidden_td'>
                    2.2
                </td>
                <td class='hidden_td2'>
                    實際總認購金額雖達該網頁揭示之最低金額，惟於買賣價金繳納期限內甲方及/或其他債權認購人有未足額繳納買賣價金之情事。
                </td>
            </tr>
            <tr style='height:40pt'>
                <td class='hidden_td'>
                    3.
                </td>
                <td class='hidden_td2'>
                    甲方享有標的債權之相關權利及依本協議約定所得享有之收益，並應主動向稅捐機關申報及繳納前述收益所產生的所得稅費。
                </td>
            </tr>
            <tr style='height:80pt'>
                <td class='hidden_td'>
                    4.
                </td>
                <td class='hidden_td2'>
                    甲方同意乙方代其收取買賣標的債權之每期本金及利息，按期給付甲方如明細表所示之各項金額，並由乙方先行交付丙方或丙方指定第三人，再依據上開明細表所載於扣除甲方應給付丙方之平台服務費後交付甲方。甲方同意乙方自標的債權之債務人所收取超過明細表所示各項金額之餘款，逕行抵充甲方應給付乙方之委任報酬款。
                </td>
            </tr>
            <tr style='height:40pt'>
                <td class='hidden_td'>
                    5.
                </td>
                <td class='hidden_td2'>
                    甲方於受讓標的債權後，甲乙雙方同意標的債權及其擔保、從屬、隨附之權利及所產生之請求權由甲方全數委託乙方仍以債權人之身分主張之。
                </td>
            </tr>
            <tr style='height:80pt'>
                <td class='hidden_td'>
                    6.
                </td>
                <td class='hidden_td2'>
                    甲方同意乙方有權代甲方在必要時對債務人進行標的債權的違約提醒及催收工作，包括但不限於電話通知、上門通知、發律師函、發支付命令、執行本票裁定及強制執行、對債務人提起訴訟、拍賣擔保品等。甲方在此確認委託乙方為其進行以上工作，並同意授權乙方及丙方得將此工作再行委託給其他專業合法的催收公司或資產管理公司進行標的債權保全等必要措施。
                </td>
            </tr>
            <tr style='height:60pt'>
                <td class='hidden_td'>
                    7.
                </td>
                <td class='hidden_td2'>
                    甲方於持有標的債權之期間內，無條件同意不得將標的債權再行轉讓予乙、丙以外之第三人，但經由乙方及丙方同意者不在此限。如有違反，甲方除應就乙方因而所生之一切損害，負擔賠償責任外，並應給付相當於標的債權金額二倍之懲罰性違約金予乙方。
                </td>
            </tr>
            <tr style='height:40pt'>
                <td class='hidden_td'>
                    8.
                </td>
                <td class='hidden_td2'>
                    甲方承諾其對依據本協議獲得的乙方、丙方及債務人之資訊或資料應予以保密，無正當理由，不得向外披露。
                </td>
            </tr>
            <tr style='height:40pt'>
                <td class='hidden_td'>
                    9.
                </td>
                <td class='hidden_td2'>
                    於乙方因任何情事發生而無法繼續執行本協議的各項權利及義務時，甲方同意乙方委託亞洲信用管理股份有限公司或其他專業合法的資產管理公司全權代乙方處理之。
                </td>
            </tr>
            <tr style='height:40pt'>
                <td class='hidden_td'>
                    10.
                </td>
                <td class='hidden_td2'>
                    甲方充分了解債務人享有分期之利益，故自受讓標的債權後，除債務人主動提前清償外，甲方不得以任何理由要求債務人提前償還或要求解除本債權讓售協議。
                </td>
            </tr>
            <tr style='height:40pt'>
                <td class='hidden_td'>
                    11.
                </td>
                <td class='hidden_td2'>
                    乙方同意由丙方代為收取甲方應給付予乙方之標的債權買賣價金，丙方於收取後最遲三個營業日內應如數轉付給乙方。
                </td>
            </tr>
            <tr style='height:20pt'>
                <td class='hidden_td'>
                    12.
                </td>
                <td class='hidden_td2'>
                    乙方應擔保標的債權於本協議約定時並無一權二賣之重複買賣情事、設定負擔或其他權利瑕疵之情事。
                </td>
            </tr>
            <tr style='height:20pt'>
                <td class='hidden_td'>
                    13.
                </td>
                <td class='hidden_td2'>
                    標的債權之債務人如有未依約或遲延償還之情事，乙方應立即通知甲方。
                </td>
            </tr>
            <tr style='height:180pt'>
                <td class='hidden_td'>
                    14.
                </td>
                <td class='hidden_td2'>
                    如乙方於豬豬在線債權媒合平台網站中載明其願於標的債權之債務人有遲延償還之情事時以特定金額附條件買回標的債權者，乙方有權並應依照其揭示之買回日期向甲方買回未獲清償之標的債權，乙方買回之價金為本協議中標的債權如明細表所示之尚未回收本金金額之一定成數(該成數以乙方於豬豬在線債權媒合平台網站中揭示者為準，併參本協議約定條款二)，並應給付結算至標的債權買回日止如明細表所示的利息給甲方(利息未滿一期者以一期計算之)。若於豬豬在線債權媒合平台網站中未揭示前述之附條件買回條款者，甲方同意就前述已陷於遲延之標的債權及其擔保、從屬、隨附之權利及所產生之請求權，全數委由乙方以債權人身分協同丙方共同轉委託給亞洲信用管理股份有限公司，而由該公司以債權人之受託人身分(即“逾期債權受託催理人”)主張及處理後續債權催收、保全、回收及後續通知分配等事項，甲方並同意支付債權回收金額的30%予亞洲信用管理股份有限公司為其提供上開服務之報酬。
                </td>
            </tr>
            <tr style='height:120pt'>
                <td class='hidden_td'>
                    15.
                </td>
                <td class='hidden_td2'>
                    亞洲信用管理股份有限公司為本協議之“逾期債權受託催理人”，如乙方因對投資人有附條件買回債權約定而提供債權買回擔保金額若干，亞洲信用管理股份有限公司對上述擔保定存質押單無請求、監督、管束之責、亦無要求提供擔保定存單若干金額之權利，僅為受託保管該擔保定存單。<br>因非可歸責甲方事由，乙方未依約或已無法買回逾期債權時，乙方或乙方指定之清算人應以正式文件通知亞洲信用管理股份有限公司，共同將擔保定存單解除質押設定，並經乙方或乙方指定之清算人簽認同意後，由亞洲信用管理股份有限公司依照乙方或其指定之清算人所供之投資人損失分配表，支付予投資人。 
                </td>
            </tr>
            <tr style='height:20pt'>
                <td class='hidden_td'>
                    16.
                </td>
                <td class='hidden_td2'>
                    乙方違反前兩項約定，致甲方或丙方之權益受有損害者，乙方應負損害賠償之責。
                </td>
            </tr>
            <tr style='height:80pt'>
                <td class='hidden_td'>
                    17.
                </td>
                <td class='hidden_td2'>
                    如標的債權之債務人自願提前清償者，乙方應於最後一次收取標的債權之本金及利息後，依明細表所載給付甲方尚未回收本金之金額，及截至乙方最後一次收取標的債權本金及利息之日止之利息(其中，利息未滿一期者以一期計算之)。為杜疑義，除本協議另有約定外，於標的債權之債務人提前清償之日後，甲方就明細表所載之權利均視為拋棄。
                </td>
            </tr>
        </table>


        <br>
        <br>
        <table cellspacing='0' cellpadding='6' style='border-collapse:collapse'>
            <tr style='height:20pt'>
                <td class='hidden_td_titl_sp'>四、</td>
                <td class='hidden_td2'>服務費：</td>
            </tr>
        </table>
     
        <table cellspacing='0' cellpadding='6' style='border-collapse:collapse'>
            <tr style='height:40pt'>
                <td class='hidden_td'>
                    1.
                </td>
                <td class='hidden_td2'>
                    在本協議中，因丙方為甲方提供債權資訊諮詢、債權信用及還款評估、還款代收、還款特殊情況溝通報告及訂約等相關服務(統稱“債權轉讓媒合服務”)及帳戶管理之服務，甲方同意支付丙方服務費。
                </td>
            </tr>
            <tr style='height:60pt'>
                <td class='hidden_td'>
                    2.
                </td>
                <td class='hidden_td2'>
                    在本協議中，使用會員是指與丙方訂定服務合約，註冊於豬豬在線債權媒合平台網站，得以丙方所核發之豬豬在線債權媒合平台網路帳戶使用丙方所提供之交易、代收、代付、居間媒合服務及其他經主管機關核准業務之成員。
                </td>
            </tr>
            <tr style='height:40pt'>
                <td class='hidden_td'>
                    3.
                </td>
                <td class='hidden_td2'>
                    丙方有權就所提供之服務向相對應之甲方及乙方收取各項居間仲介費、管理費和(或)服務費。各種收費項目，依豬豬在線債權媒合平台網站所載或相應方之協議為之。
                </td>
            </tr>
            <tr style='height:80pt'>
                <td class='hidden_td'>
                    4.
                </td>
                <td class='hidden_td2'>
                    甲方使用本服務時，丙方向甲方收取之平台服務費將自明細表中之各期應給付利息中扣除，此平台服務費，丙方將依本協議明細表中的總利息金額，以約定費率(10%)，四捨五入至整數位後計算總應收服務費金額，並平均攤入明細表中每期利息支付日時扣取，各個當期的平均攤計服務費金額如小於新台幣1元，則以新台幣1元計算，逐期累計的服務費金額已等於總應收服務費後，往後期數則不再計收服務費。
                </td>
            </tr>
            <tr style='height:60pt'>
                <td class='hidden_td'>
                    5.
                </td>
                <td class='hidden_td2'>
                    丙方有權隨時調整本服務之各項服務費，調整後之服務費將公告刊載於本服務相關網頁上，並自其所訂定之生效日期起生效，不另行個別通知。若會員不同意調整後之服務費，應即停止使用本服務，如使用會員繼續使用本服務，即視為已同意調整後之服務費。
                </td>
            </tr>
        </table> 

        <br>
        <br>
        <table cellspacing='0' cellpadding='6' style='border-collapse:collapse'>
            <tr style='height:20pt'>
                <td class='hidden_td_titl_sp'>五、</td>
                <td class='hidden_td2'>違約責任：</td>
            </tr>
        </table>

        <table cellspacing='0' cellpadding='6' style='border-collapse:collapse'>
            <tr style='height:40pt'>
                <td class='hidden_td'>
                    1.
                </td>
                <td class='hidden_td2'>
                    本協議各方均應嚴格履行本協議約定之義務，非經各方協商一致或依照本協議約定，任何一方不得解除本協議。
                </td>
            </tr>
            <tr style='height:80pt'>
                <td class='hidden_td'>
                    2.
                </td>
                <td class='hidden_td2'>
                    任何一方違約，違約方應承擔因違約使得其他各方產生的費用和損失，包括但不限於調查、訴訟費、律師費等，應由違約方承擔。因可歸責於甲方之事由致甲方或乙方提前解除本協議時，乙方有權要求甲方支付因此產生的相關費用，乙方得從應按期給付給甲方之標的債權本金及利息中扣除相關費用後給付予甲方。(費用內容依豬豬在線債權媒合平台網站所載)
                </td>
            </tr>
        </table> 

        
        <br>
        <br>
        <table cellspacing='0' cellpadding='6' style='border-collapse:collapse'>
            <tr style='height:20pt'>
                <td class='hidden_td_titl_sp'>六、</td>
                <td class='hidden_td2'>法律適用及爭議解決：</td>
            </tr>
        </table>


        <table cellspacing='0' cellpadding='6' style='border-collapse:collapse'>
            <tr style='height:20pt'>
                <td class='hidden_td'>
                    1.
                </td>
                <td class='hidden_td2'>
                    本協議如有未盡事宜，悉依中華民國民法及其他相關法令解決之。
                </td>
            </tr>
            <tr style='height:20pt'>
                <td class='hidden_td'>
                    2.
                </td>
                <td class='hidden_td2'>
                    本協議的約定、履行、終止、解釋均適用中華民國法律。
                </td>
            </tr>
            <tr style='height:40pt'>
                <td class='hidden_td'>
                    3.
                </td>
                <td class='hidden_td2'>
                    本協議在履行過程中，如發生任何爭執或糾紛，各方應友好協商解決；若協商不成，因本協議所生之一切爭議，合約當事人同意以臺灣臺北地方法院為第一審合意管轄法院。
                </td>
            </tr>
            <tr style='height:20pt'>
                <td class='hidden_td'>
                    4.
                </td>
                <td class='hidden_td2'>
                    丙方擁有對本協議的最終解釋權。
                </td>
            </tr>
        </table> 

        <br>
        <br>
        <table cellspacing='0' cellpadding='6' style='border-collapse:collapse'>
            <tr style='height:20pt'>
                <td class='hidden_td_titl_sp'>七、</td>
                <td class='hidden_td2'>附則：</td>
            </tr>
        </table>
        

        <table cellspacing='0' cellpadding='6' style='border-collapse:collapse'>
            <tr style='height:40pt'>
                <td class='hidden_td'>
                    1.
                </td>
                <td class='hidden_td2'>
                    各方可經由協議對本協議作出修改和補充。本協議的修改和補充經過各方之同意後具有契約同等的法律效力。
                </td>
            </tr>
            <tr style='height:120pt'>
                <td class='hidden_td'>
                    2.
                </td>
                <td class='hidden_td2'>
                    本協議及其修改或補充均採用透過豬豬在線債權媒合平台網站以電子合約形式製成，可以有一份或多份，並且每份具有同等法律效力，並永久保存在丙方為此設立的專用伺服器(或雲端伺服器)上備查和保管。各方均同意該形式之協議效力，如對協議內容有爭議，各方均同意以豬豬在線債權媒合平台網站資料庫上所保留文檔版本解釋為準。甲乙丙三方並同意本債權讓售協議書及相關債權法律文件亦將以電子合約形式保存於亞洲信用管理股份有限公司所設立的專用伺服器(或雲端伺服器)上供備查和保管，並為後續債權保全及催收等使用。
                </td>
            </tr>
            <tr style='height:40pt'>
                <td class='hidden_td'>
                    3.
                </td>
                <td class='hidden_td2'>
                    如果本協議中的任何條款違反適用的法律或法規，則該條將被視為無效，但該無效條款並不影響本協議其他條款的效力。
                </td>
            </tr>
        </table> 



        <br>
        <br>
        <table cellspacing='0' cellpadding='6' style='border-collapse:collapse'>
            <tr style='height:20pt'>
                <td class='hidden_td_titl_sp'>八、</td>
                <td class='hidden_td2'>特別聲明：</td>
            </tr>
        </table>

        <table cellspacing='0' cellpadding='6' style='border-collapse:collapse'>
            <tr style='height:80pt'>
                <td colspan='2' class='hidden_td2'>
                    豬豬在線債權媒合平台僅單純提供使用會員認購債權之媒合服務，並不自行或協助債權讓與人向不特定人收受存款或受託經理信託資金，債權讓與人及使用會員均不得利用本平台從事違反銀行法第29條第1項規定：除法律另有規定者外，非銀行不得經營收受存款、受託經理信託資金、公眾財產或辦理國內外匯兌業務之行為，否則應自負相關法律責任！
                </td>
            </tr>
        </table>

        <br>
        <br>
        <table cellspacing='0' cellpadding='0' style='border-collapse:collapse'>
            <tr style='height:79.15pt'>
                <td style='text-align:center'>
                    <p
                        style='margin-top:1.3pt; margin-right:0.95pt; margin-bottom:0pt; line-height:117%;'>
                        居間人用印章：</p>
                </td>
                <td
                    style='width:130pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;text-align:center'>
                    <p
                        style='margin-top:1.3pt; margin-right:0.95pt; margin-bottom:0pt; line-height:117%;text-align:center'>
                        <span >  <img src='https://www.pponline.com.tw/images/seal1.png'></span></p>
                </td>
                <td
                    style='text-align:center'>
                    <p
                        style='margin-top:1.3pt; margin-right:0.95pt; margin-bottom:0pt; line-height:117%;'>
                        債權管理人用印章：</p>
                </td>
                <td
                    style='width:130pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;text-align:center'>
                    <p
                        style='margin-top:1.3pt; margin-right:0.95pt; margin-bottom:0pt; line-height:117%;text-align:center'>
                        <span >  <img src='https://www.pponline.com.tw/images/seal2.png'></span></p>
                </td>
            </tr>
        </table>

        <p style='margin-top:1.3pt; margin-right:5.95pt; margin-bottom:0pt; line-height:117%;'>
            <span >&#xa0;</span></p>
        <p style='margin-top:1.3pt; margin-right:5.95pt; margin-bottom:0pt; line-height:117%;'>
            <span >附表一：標的債權回收明細表</span></p>
        <table cellspacing='0' cellpadding='0' style='border-collapse:collapse;'>
            <tr>
                <td class='td_3'>期數</td>
                <td class='td2_3'>日期</td>
                <td class='td3_3'>甲方就標的債權回收之本金</td>
                <td class='td4_3'>甲方就標的債權回收之利息</td>
                <td class='td5_3'>丙方之平台服務費</td>
            </tr>";
            foreach($money['everyMonthPrincipal'] as $k => $v) { 
            $html.="<tr>
                <td class='td_3'>".($k+1)."</td>
                <td class='td2_3'>".$timeArray[$k]."</td>
                <td class='td3_3'>".$money['everyMonthPrincipal'][$k]."</td>
                <td class='td4_3'>".$money['everyMonthInterest'][$k]."</td>
                <td class='td5_3'>".$thirdPartyManagmentFeeArray[$k]."</td>
            </tr>";
            } 
            $html.="
            <tr>
                <td colspan='2' class='td_3'>總計</td>
                <td class='td3_3'>".$all_everyMonthPrincipal."</td>
                <td class='td4_3'>".$all_everyMonthInterest."</td>
                <td class='td5_3'>".$thirdPartyManagmentFeeTotal."</td>
            </tr>
        </table>
        <p
            style='margin-top:1.3pt; margin-right:5.95pt; margin-bottom:0pt; line-height:117%;'>
            <span >&#xa0;</span></p>


    </div>
</body>

</html>
";

// echo $html;exit;

            $link = mysqli_connect("localhost","kqzwlrrm_pp_user","jCgz91Ib8}uR","kqzwlrrm_ppo_nline");
            mysqli_query($link,"set names utf8");


            $dompdf->set_option('isHtml5ParserEnabled', true);
            $dompdf->load_html($html);
            $dompdf->render();

            $output = $dompdf->output();

            $created_sql = 'SELECT create_date FROM `pdf_log` WHERE `tender_documents_id` ='.$id;
            $ro_c = mysqli_query($link,$created_sql);
            $cow = mysqli_fetch_assoc($ro_c); 

            $year = date("Y",strtotime($cow['create_date']));
            $month = date("m",strtotime($cow['create_date']));


            $file_path = "../public/uploads/ClaimTenderPDF_new/".$year.$month."/";

            if(file_exists($file_path)){
                
                $path = $file_path.$id.'_tender.pdf';
                file_put_contents($path, $output);
                
    
                $path2 = "uploads/ClaimTenderPDF_new/".$year.$month."/".$id.'_tender.pdf';
    
                ini_set('date.timezone','Asia/Taipei');
                $nt = date("Y-m-d H:i:s");
    
                $Tenders_sql = "UPDATE  tender_documents SET claim_pdf_path = '".$path2."' , updated_at = '".$nt."'  WHERE tender_documents_id = $id";
    
                $ro = mysqli_query($link,$Tenders_sql);
                // if(!$ro){var_dump(mysqli_error($link));}
                // exit;
                
                
                return true;
         
            }else{
                mkdir($file_path);
                return false;
            }
            

    }
}
    
    
    
    // try {

            $data = 'SELECT * FROM pdf_log WHERE is_run = 0 ORDER BY pdf_id ASC';

            $ro = mysqli_query($link,$data);
            // if(!$ro){var_dump(mysqli_error($link));}
            // exit;
            $row = mysqli_fetch_assoc($ro);  

            $t = true;

            if(!empty($row['pdf_data'])){

                parse_str($row['pdf_data'],$row_data);
                $claimPdf = new ClaimPdf($row_data['user_id'],$row_data['claim_id'],$row_data['amount']);
                $saveSuccess = $claimPdf->saveClaimTendersPdf($row_data['tender_documents_id'],$row_data['claim_certificate_number']);
                if(!$saveSuccess){
                    $t = false;
                }
                if($t){
                    $update = "update pdf_log set is_run = 1 , update_date = '".$nt."' where pdf_id = ".$row['pdf_id'];
                    $ro1 = mysqli_query($link,$update);
                    // if(!$ro){var_dump(mysqli_error($link));}
                    // exit;
                }

            }
            
        
        
    // } catch (\Throwable $th) {
    // 
    //     in_log($th,"createPDF",$nt);

    // }


