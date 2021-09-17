<?
include_once("common/equalPrincipalPayment.php");
include_once("common/equalTotalPayment.php");
include_once("setsql/setdb.php");
include_once("sendmail.php");
$cl[0]="上架預覽";
$cl[1]="募集中";
$cl[2]="結標繳款";
$cl[3]="已流標";
$cl[4]="繳息還款";
$cl[5]="回收結案";
$cl[6]="異常";
/*
staging_amount          債權金額
start_collecting_at     開標日
estimated_close_date    結標日
payment_final_deadline  結標後繳款最後期限
*/
$event= "\n";             //設定動作紀錄變數

$check_email=0;         //預設判斷是否寄開標信變數
$check_order=0;         //預設判斷是否有結標變數

$uo = 0;                //判斷是否為第一筆(USER)
$ur =0;                 //設定USER不重複
$inusql = "";           //設定USERSQL語法

//$all_order[債權][標單][客戶]= 金額;//所有標單記錄用
//$user_order[客戶][債權][標單]=金額;//結標記錄用
//$user_email[客戶][債權][標單]=金額;//流標記錄用

$tr_cnt = 0;            //統計還款的次數
$tr_update ="";         //統計還款的債權
$tr_3_cnt = 0;            //統計還款流標的次數
$tr_3_update ="";         //統計還款流標的債權

$sql="select schedule_now from schedule_now where seq=1";
$ro = mysqli_query($link,$sql);
$op = mysqli_fetch_assoc($ro);
if($op["schedule_now"]==0){

$sql="update schedule_now set schedule_now = 1 where seq=1";
$ro = mysqli_query($link,$sql);

$sql="select staging_amount , claim_id , claim_state , start_collecting_at , estimated_close_date , payment_final_deadline , annual_interest_rate , repayment_method , remaining_periods , management_fee_rate , value_date ,commission_interest_rate from claims where claim_state in(0,1,2,4) ;";
$ro = mysqli_query($link,$sql);
$row = mysqli_fetch_assoc($ro);
$ntime=strtotime("now");
do{
    $e1=" 未改變";
    $e2="，狀態：[".$cl[$row["claim_state"]]."] ";
    $e3="";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                   開標
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if($row["claim_state"]==0){                 //確認是否開標
        $ctime=strtotime($row["start_collecting_at"]);  //開標時間
        if($ntime >= $ctime){//判斷是否改變狀態
            $e1=" 轉換";
            $e3="=> ".$cl[1];
            $sql="update claims set claim_state = 1 , updated_at = '".$nt."' where claim_id='".$row["claim_id"]."';";
            mysqli_query($link,$sql);
            $check_email=1;//開起寄開標信功能
        }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                 結標OR流標
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    }elseif($row["claim_state"]==1){            //確認是否結標
        $ctime=strtotime($row["estimated_close_date"]);    //結標時間
        if($ntime >= $ctime){                   //判斷是否改變狀態
            $e1=" 轉換";
            $sql="select user_id,amount,tender_documents_id from tender_documents where claim_id='".$row["claim_id"]."';";
            $nd = mysqli_query($link,$sql);
            $ndr = mysqli_fetch_assoc($nd);
            $sum = 0;
            if(isset($tid)){ unset($tid);}
            do{
                $sum += $ndr["amount"];
                $tid[]= $ndr["tender_documents_id"];
                $all_order[$row["claim_id"]][$ndr["tender_documents_id"]][$ndr["user_id"]]= $ndr["amount"];//所有標單記錄用
            }while($ndr = mysqli_fetch_assoc($nd));
            if($row["staging_amount"]==$sum){
                $clin = 0;              //判斷是否為第一筆
                $insql ="";             //預設SQL語法

                foreach($tid as $a=>$b){
                    if($clin == 0){
                        $insql =" '".$b."'";
                    }else{
                        $insql = $insql .",'".$b."'";
                    }
                    $clin = 1;
                }
                foreach($all_order[$row["claim_id"]] as $i_t =>$i_m){
                    foreach($i_m as $i_u => $i_m){
                        $user_order[$i_u][$row["claim_id"]][$i_t]=$i_m;//結標記錄用
                        if($ur != $i_u){
                            if($uo == 0){
                                $inusql =" '".$i_u."'";
                            }else{
                                $inusql = $inusql .",'".$i_u."'";
                            }
                            $uo = 1;
                            $ur = $i_u;
                        }
                    }
                }
                $e3="=> ".$cl[2];
            }else{
                foreach($all_order[$row["claim_id"]] as $i_t =>$i_m){
                    foreach($i_m as $i_u => $i_m){
                        $user_email[$i_u][$row["claim_id"]][$i_t]=$i_m;//流標記錄用
                    }
                }
                $e3="=> ".$cl[3];
            }
            $check_order =1;
            //echo "cid:".$row["claim_id"]." cm:".$row["staging_amount"]." tm:".$sum." ".$e3.$nt."<br>";
        }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                              結標轉還款
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    }elseif($row["claim_state"]==2){
        $ctime=strtotime($row["payment_final_deadline"]);    //結標時間
        $t_r=0;//判斷流標是否改變狀態
        $check_amount =0;                   //計算總金額
        unset($indb_tr_td_created_at);
        unset($indb_tr_discount_start);
        unset($indb_tr_discount_close);
        unset($indb_tr_discount);
        unset($indb_tr_tender_documents_id);
        unset($indb_tr_c_c_number);
        unset($indb_tr_amount);
        unset($indb_tr_user_id);
        unset($indb_tr_come_from_info_text);
        unset($indb_tr_p_d_user_id);
        $sql="select td.created_at,u.discount_start,u.discount_close,u.discount,u.come_from_info_text,(SELECT u2.user_id FROM users u2 where u.come_from_info_text = u2.recommendation_code and u.come_from_info_text<>'') as p_d_user_id, u.user_id,amount,tender_documents_id,claim_certificate_number from tender_documents td , users u where td.user_id =u.user_id and tender_document_state = 1 and claim_id='".$row["claim_id"]."';";
        //echo $sql."<br>";
        $nd = mysqli_query($link,$sql);
        $ndr = mysqli_fetch_assoc($nd);
        do{
            $indb_tr_td_created_at[]=$ndr["created_at"];
            $indb_tr_discount_start[]=$ndr["discount_start"];
            $indb_tr_discount_close[]=$ndr["discount_close"];
            $indb_tr_discount[]=$ndr["discount"];
            $indb_tr_user_id[]=$ndr["user_id"];
            $indb_tr_tender_documents_id[]=$ndr["tender_documents_id"];
            $indb_tr_c_c_number[]=$ndr["claim_certificate_number"];
            $indb_tr_amount[]=$ndr["amount"];
            $indb_tr_come_from_info_text[]=$ndr["come_from_info_text"];
            $indb_tr_p_d_user_id[] = $ndr["p_d_user_id"];
            $check_amount += $ndr["amount"];
        }while($ndr = mysqli_fetch_assoc($nd));
        $indb_tr_cnt = 0 ;                                  //陣列計數歸0
        if($row["staging_amount"] == $check_amount){
            $e1=" 轉換";
            $e3="=> ".$cl[4];
            if($tr_cnt == 0){                               //統計轉還款的債權
                $tr_update .="'".$row["claim_id"]."'";
                $tr_cnt++;
            }else{
                $tr_update .=",'".$row["claim_id"]."'";
                $tr_cnt++;
            }
            foreach($indb_tr_tender_documents_id as $t => $tr){
                //echo $indb_tr_c_c_number[$indb_tr_cnt]."<br>";
                //echo $indb_tr_cnt."<br>";
                $trinsql = "";                                      //insert into整合歸0
                if ($row['repayment_method'] == '0') {
                    $payment = new equalPrincipalPayment($row['annual_interest_rate'], $row['remaining_periods'],  $indb_tr_amount[$indb_tr_cnt]);
                    $payment = $payment->run();
                } else {
                    $payment = new equalTotalPayment($row['annual_interest_rate'], $row['remaining_periods'], $indb_tr_amount[$indb_tr_cnt]);
                    $payment = $payment->run();
                }
                if (strtotime($indb_tr_discount_start[$indb_tr_cnt]) <= strtotime($indb_tr_td_created_at[$indb_tr_cnt]) && strtotime($indb_tr_discount_close[$indb_tr_cnt]) >= strtotime($indb_tr_td_created_at[$indb_tr_cnt])) {
                    $payment["management_fee_rate"] = thirdPartyManagmentFee($payment['everyMonthInterest'], $row['management_fee_rate'] * $indb_tr_discount[$indb_tr_cnt]);
                }else{
                    $payment["management_fee_rate"] = thirdPartyManagmentFee($payment['everyMonthInterest'],$row['management_fee_rate'] );
                }
                
                $rtsql = "INSERT INTO tender_repayments( tender_repayment_state, tender_documents_id, user_bank_id, target_repayment_date, paid_at, credited_at, amount, period_number, management_fee, created_at, updated_at, per_return_principal, net_amount, per_return_interest, real_return_amount, invoice_at, claims_note, last_contact_pp_time, buying_back_type) VALUES ";
                
                $current_balance =$indb_tr_amount[$indb_tr_cnt];//剩餘本金
                /*
user_id=447&claim_id=1011&amount=110000&tender_documents_id=2942&claim_certificate_number=P000383005S100071                
                */
/////////////////////////////////////生PDF/////////////////////////////////////
                $pdf_reason="生還款";
                $pdf_data="user_id=".$indb_tr_user_id[$indb_tr_cnt]."&claim_id=".$row["claim_id"]."&amount=".$indb_tr_amount["$indb_tr_cnt"]."&tender_documents_id=".$tr."&claim_certificate_number=".$indb_tr_c_c_number["$indb_tr_cnt"];
                $in_pdf_sql="INSERT INTO pdf_log(pdf_reason, pdf_data, tender_documents_id, create_date, update_date, is_run) VALUES ('".$pdf_reason."','".$pdf_data."','".$tr."','".$nt."','".$nt."',0)";
                //echo "<br>".$in_pdf_sql."<br>";
                mysqli_query($link,$in_pdf_sql);
/////////////////////////////////////生還款/////////////////////////////////////
                for($i=0;$i<$row["remaining_periods"];$i++){
                    $ii = $i + 1;
                    $iii = $i + 2;
                    $trinsql = $rtsql."('0','".$tr."','0','".date("Y-m-d H:i:s",strtotime($row["value_date"]."+".$ii."month"))."',null,null,null,'".$ii."','".$payment["management_fee_rate"][$i]."','".$nt."','".$nt."','".$payment["everyMonthPrincipal"][$i]."','".$payment["everyMonthPaidTotal"][$i]."','".$payment["everyMonthInterest"][$i]."','".($payment["everyMonthPaidTotal"][$i]-$payment["management_fee_rate"][$i])."',null,null,null,0)";
                    mysqli_query($link,$trinsql);
                    echo "轉還款".$tr."<br>".$trinsql."<br>";
                    if(!empty($indb_tr_come_from_info_text[$indb_tr_cnt])){
                        //echo "生推手".$tr."<br>";
//*****************************************************************************************************************
//                                               推手                                                             *
//*****************************************************************************************************************
                        $claim_id = $row["claim_id"];
                        $user_id = $indb_tr_user_id[$indb_tr_cnt];
                        $repayment_id = 10;
                        $repayment_id = mysqli_insert_id($link);

                        //剩餘本金 * 債權利率 annual_interest_rate * 債權獎勵 commission_interest_rate 4捨五入
                        //剩餘本金 / 12 * 債權獎勵 commission_interest_rate 4捨五入
                        $benefits_amount =round($current_balance/12*$row["commission_interest_rate"]);
                        //$benefits_amount =round($current_balance*$row["annual_interest_rate"]/100*$row["commission_interest_rate"]);
/*
echo $current_balance."--<br>";
echo ($row["annual_interest_rate"]/100)."--<br>";
echo $row["commission_interest_rate"]."--<br>";
echo "<br>benefits_amount--".$benefits_amount."--<br>";
*/
                        $target_repayment_date = date("Y-m-20 H:i:s",strtotime($row["value_date"]."+".$iii."month"));//日期
                        $claim_certificate_number = $indb_tr_c_c_number[$indb_tr_cnt];
                        $commission_interest_rate = $row["commission_interest_rate"];
                        $p_d_user_id = $indb_tr_p_d_user_id[$indb_tr_cnt];

                        $p_h_sql = "INSERT INTO pusher_detail( claim_id, user_id, repayment_id, current_balance, benefits_amount, paid_at, target_repayment_date, claim_certificate_number, commission_interest_rate, p_d_user_id) VALUES ('".$claim_id."','".$user_id."','".$repayment_id."','". $current_balance."','".$benefits_amount."',NULL,'".$target_repayment_date."','".$claim_certificate_number."','".$commission_interest_rate."','".$p_d_user_id."');";
                        mysqli_query($link,$p_h_sql);
                        //echo '<br>'.$p_h_sql.'<br><br>';
                        $current_balance = $current_balance-$payment["everyMonthPrincipal"][$i];  //剩餘本金-當期還款
//*****************************************************************************************************************
//                                               推手                                                             *
//*****************************************************************************************************************
                    }
                }
                $indb_tr_cnt++;
            }
        }else{
            if($ntime >= $ctime){                   //判斷流標時間是否改變狀態
                $e1=" 轉換";
                $e3="=> ".$cl[3];
                if($tr_3_cnt == 0){                               //統計轉還款流標的債權
                    $tr_3_update .="'".$row["claim_id"]."'";
                    $tr_3_cnt++;
                }else{
                    $tr_3_update .=",'".$row["claim_id"]."'";
                    $tr_3_cnt++;
                }
                /*
                foreach($indb_tr_tender_documents_id as $t => $tr){
                    $all_email[$indb_tr_user_id[$indb_tr_cnt]][$row["claim_id"]][$indb_tr_tender_documents_id[$indb_tr_cnt]][3]=$indb_tr_amount[$indb_tr_cnt];       //結流標信用
                    $indb_tr_cnt++;
                }
                */

            }
        }
        //echo $e3."-<br>";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    }

    $event = $event."Claim_id：".$row["claim_id"].$e1.$e2.$e3."\n";
    //echo $event;
    //in_log($event,"checkAllClaimState",$nt);
}while($row = mysqli_fetch_assoc($ro));
//$event = $event ."==============================================================================================\n";
//結標order

/***********************************結標***********************************/
if(isset($user_order)){
    //echo "結標<br>";
    $usql="select user_id,virtual_account from users where user_id in (".$inusql.");";
    //echo $usql."<br>";
    $uro = mysqli_query($link,$usql);
    $urow = mysqli_fetch_assoc($uro);
    do{
        $user_list[$urow["user_id"]]=$urow["virtual_account"];
    }while($urow = mysqli_fetch_assoc($uro));

    //$all_email[會員][債權][標單][結流標1,3]=金額       //結流標信用
    $io_v = "";             //
    $iclin = 0;             //判斷是否為第一筆(債權)
    $icinsql ="";           //設定流標名單(債權)
    $icr =0;                //設定流標名單不重複(債權)
    $itlin = 0;             //判斷是否為第一筆(標單)
    $itinsql ="";           //設定標單名單(標單)
    foreach($user_order as $i_u =>$i_x){
        $io_a = 0;              //計算ORDER金額
        foreach($i_x as $i_c => $i_xx){
            foreach($i_xx as $i_t => $i_xm){
                echo $i_u."-".$i_c."-".$i_t."=".$i_xm."<br>";
                if($itlin == 0){
                    $itinsql =" '".$i_t."'";
                }else{
                    $itinsql = $itinsql .",'".$i_t."'";
                }
                $itlin = 1;
                $io_a += $i_xm;
                $all_email[$i_u][$i_c][$i_t][1]=$i_xm;
            }
            if($icr != $i_c){
                if($iclin == 0){
                    $icinsql =" '".$i_c."'";
                }else{
                    $icinsql = $icinsql .",'".$i_c."'";
                }
                $iclin = 1;
                $icr = $i_c;
            }
            if($i_xx === end($i_x)){
                $g_o = 0;
                $osql = "INSERT INTO orders( virtual_account, created_at, updated_at, expected_amount, actual_amount, is_send_sms) VALUES ('".$user_list[$i_u]."','".$nt."','".$nt."','".$io_a."',null,0);";
                $get_o = mysqli_query($link,$osql);   //<=======================================2-結標-order
                $g_o = mysqli_insert_id($link);       //<=======================================2-結標-order
                //echo "<br>".$osql."--".$g_o."<br>";
                $itsql = "update tender_documents set tender_document_state = 5 , updated_at = '".$nt."' , order_id ='".$g_o."' , is_order_create = 1 where tender_documents_id in (".$itinsql.");";
                //echo "<br>".$itsql."<br>";
                mysqli_query($link,$itsql);           //<=======================================2-結標-標單
                $itlin = 0;             //重設判斷是否為第一筆(標單)
                $itinsql ="";           //重設標單名單(標單)
            }
        }
    }
}
/***********************************流標***********************************/

if(isset($user_email)){
    //echo "流標<br>";
    $clin = 0;              //判斷是否為第一筆(債權)
    $cinsql ="";            //設定流標名單(債權)
    $cr =0;            //設定流標名單不重複(債權)
    $tlin = 0;              //判斷是否為第一筆(標單)
    $tinsql ="";            //設定流標名單(標單)
    foreach($user_email as $o_u =>$o_x){
        foreach($o_x as $o_c => $o_x){
            foreach($o_x as $o_t => $o_x){
                echo $o_u."-".$o_c."-".$o_t."=".$o_x."<br>";
                if($tlin == 0){
                    $tinsql =" '".$o_t."'";
                }else{
                    $tinsql = $tinsql .",'".$o_t."'";
                }
                $tlin = 1;
                $all_email[$o_u][$o_c][$o_t][3]=$o_x;
            }
            if($cr != $o_c){
                if($clin == 0){
                    $cinsql =" '".$o_c."'";
                }else{
                    $cinsql = $cinsql .",'".$o_c."'";
                }
                $clin = 1;
                $cr = $o_c;
            }
        }
    }
}
if(isset($user_email) or isset($user_order)){

$icsql="update claims set claim_state = 2 , updated_at = '".$nt."' where claim_id in (".$icinsql.");";
$csql="update claims set claim_state = 3 , updated_at = '".$nt."' where claim_id in (".$cinsql.");";
$tsql="update tender_documents set tender_document_state = 3 , updated_at = '".$nt."' where tender_documents_id in (".$tinsql.");";
mysqli_query($link,$icsql);                          //<=======================================2-結標-債權
mysqli_query($link,$csql);                           //<=======================================2-流標-債權
mysqli_query($link,$tsql);                           //<=======================================2-流標-標單
/*
echo $icsql."<br>";
echo $csql."<br>";
echo $tsql."<br>";
/**/
}

if($tr_cnt >0){             //修改執行還款的債權
    $rt_c_sql="update claims set claim_state = 4 , updated_at = '".$nt."' where claim_id in(".$tr_update.");";
    $rt_t_sql="update tender_documents set tender_document_state = 2 , updated_at = '".$nt."' where claim_id in(".$tr_update.");";
    mysqli_query($link,$rt_c_sql);
    mysqli_query($link,$rt_t_sql);
/*
    echo "還款".$rt_c_sql."<br>";
    echo "還款".$rt_t_sql."<br>";
/**/
}
if($tr_3_cnt >0){           //修改執行還款流標的債權
    $rt_c_3_sql="update claims set claim_state = 3 , updated_at = '".$nt."' , is_display = 0 where claim_id in(".$tr_3_update.");";
    $rt_t_3_sql="update tender_documents set tender_document_state = 3 , updated_at = '".$nt."' where claim_id in(".$tr_3_update.");";
    mysqli_query($link,$rt_c_3_sql);
    mysqli_query($link,$rt_t_3_sql);
    /*
    echo "還款流標".$rt_c_3_sql."<br>";
    echo "還款流標".$rt_t_3_sql."<br>";
    */
}


if($check_email==1){    //判斷是否寄開標信
    //echo "開標寄信";
    // send_claim_collecting_remind();               //<=======================================寄開標信
}
if(isset($all_email)){  //判斷是否結流標信
    //echo "結流標寄信";
    document_start_to_Bid_Flow($all_email);       //<=======================================寄出結流標信
}

//echo $event;
in_log($event,"checkAllClaimState",$nt);
in_log("排程結束\n==============================================================================================\n","checkAllClaimState",$nt);
$sql="update schedule_now set schedule_now = 0 where seq=1";
$ro = mysqli_query($link,$sql);
}else{
    in_log("排程運行中此分鐘暫停","checkAllClaimState",$nt);
}


/**
     *計算丙方平台服務費 = (甲方利息*10%)四捨五入後 均分於每期 每期將小數位取出只留整數，將小數位總和加至最後一期
     */
    function thirdPartyManagmentFee($everyMonthArray,$fee_rate)
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

        $res = sumToLastMonth($ar);
        return $res;
    }

    /**
     * 將小數點數字總和至最後一個月並4捨5入取整數
     *
     * @param array amountArray [n月金額,n+1月金額,...]
     */
    function sumToLastMonth($amountArray)
    {
        $result = [];
        $amountLength = count($amountArray);
        $floatTotal = 0;
        for($y=0;$y<$amountLength;$y++){
            $interestObj = getIntAndFloat($amountArray[$y]);
            $floatTotal = $floatTotal + $interestObj['decimalPoint'];
            if($y!= ($amountLength -1 )){
                array_push($result,$interestObj['integer']);
            }else{
                $floatTotal = round( $floatTotal,0);
                $total = $interestObj['integer'] + $floatTotal;
                array_push($result,(int)$total);
            }
        }
        return $result;
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
    function getIntAndFloat($number)
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
?>