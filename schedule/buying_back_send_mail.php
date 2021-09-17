<?php
include_once("setsql/setdb.php");
include_once("sendmail.php");

$event= "\n";             //設定動作紀錄變數
$run_time =  date('Y-m-d',strtotime($nt));
$sql = "SELECT sbb.s_b_b_seq,sbb.buying_back_type,sbb.claim_certificate_number,sbb.target_repayment_date,u.user_name,u.email,u.user_id FROM `schedule_buying_back` sbb ,  users u , tender_documents td WHERE sbb.s_b_b_td = td.tender_documents_id and u.user_id = td.user_id and sbb.paid_at = '".$run_time."' and  sbb.`s_b_b_mail` = 0 ORDER BY sbb.s_b_b_seq ASC ";
$ro = mysqli_query($link,$sql);
// if(!$ro){var_dump(mysqli_error($link));}
// exit;
$row = mysqli_fetch_assoc($ro); 


$b_id = '';
$data = [];
//紀錄買回狀態
$count = 0;
if (!empty($row['claim_certificate_number'])) {
    do {
        // $user_data = "SELECT u.user_id,user_name,email FROM users u , tender_documents td WHERE u.user_id = td.user_id and td.tender_documents_id =".$row['s_b_b_td'];
        
        // $uo = mysqli_query($link, $user_data);
        // // if(!$ro){var_dump(mysqli_error($link));}
        // // exit;
        // $uow = mysqli_fetch_assoc($uo);
        
        
        if(!empty($data[$count][$row['user_id']])){
            $count++;
        }
        
        $data[$count][$row['user_id']]['buying_back_type'] = $row['buying_back_type'];
        $data[$count][$row['user_id']]['claim_certificate_number'] = $row['claim_certificate_number'];
        $data[$count][$row['user_id']]['target_repayment_date'] = $row['target_repayment_date'];
        $data[$count][$row['user_id']]['user_name'] = $row['user_name'];
        $data[$count][$row['user_id']]['email'] = $row['email'];
        
        
        // echo $row['claim_certificate_number'].'->'.$row['buying_back_type'].'->'.date("Y-m-d".'->'.strtotime($row['target_repayment_date'])).'->'.$uow['user_name'].'->'.$uow['email'];exit;
        
        $b_id .= $row['s_b_b_seq'].',';
        

    } while ($row = mysqli_fetch_assoc($ro));

    // print_r ($data);exit;

    foreach ($data as $k => $v) {

        foreach($v as $k1 => $v1){
            buy_back_mail($v1['claim_certificate_number'],$v1['buying_back_type'],date("Y-m-d",strtotime($v1['target_repayment_date'])),$v1['user_name'],$v1['email']);
            $event .= "會員名稱->".$v1['user_name'].",排進log時間->".$nt."\n";
        }
        
        
    }
    

    $b_id = substr($b_id, 0, -1);

    $sql = " UPDATE `schedule_buying_back` SET `s_b_b_mail` = 1 WHERE s_b_b_seq in ($b_id)" ;
    // echo$sql;
    // exit;
    $ro = mysqli_query($link,$sql);
    // if(!$ro){var_dump(mysqli_error($link));}
    // exit;
    $event .= "買回寄信索引->".$b_id.",更改狀態時間->".$nt."\n";
}

in_log($event,"buy_back_mail",$nt);
in_log("排程結束\n==============================================================================================\n","buy_back_mail",$nt);





























?>