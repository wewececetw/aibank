<?php 
    include_once("setsql/setdb.php");
    include_once("sendmail.php");
    
//開關
$sql="select schedule_now from schedule_now where seq=4";
$ro = mysqli_query($link,$sql);
$op = mysqli_fetch_assoc($ro);
//初始寄出人數
$count = 0;
if($op["schedule_now"]==0){
    $sql="update schedule_now set schedule_now = 1 ,schedule_now_time = '".$nt."' where seq=4";
    $ro = mysqli_query($link,$sql);
    //搜尋寄信排程
    $sql = 'SELECT sl.*,u.`email`,u.`user_id` FROM `schedule_letters` sl ,`users` u  WHERE sl.`is_run` = 0 and sl.class_type = 1 and u.`is_receive_letter` = 1 and sl.`type_id` = u.`user_id` order by sl.created_at limit 10 ';
    
    $ro = mysqli_query($link,$sql);
    $log_row = mysqli_fetch_assoc($ro);

    if(!empty($log_row)){

        //初始log
        if(empty($event)){
            $event = "\n";
        }
        //寄信
        $s_l_id = '(';
        do{
            
            $s_l_id .= $log_row['s_l_id'].',';
            send_template_for_log($log_row['email'],$log_row['title'],$log_row['content']);
            saveInbox_for_log($log_row['user_id'],$log_row['title'],$log_row['content']);
            $event .= "user_id:".$log_row['user_id'].",'email->".$log_row['email'].",'s_l_id->".$log_row['s_l_id']."\n";
            $count ++;
        }while($log_row = mysqli_fetch_assoc($ro));
        
        $s_l_id = substr($s_l_id,0,-1);
        $s_l_id.= ')';
        // echo $s_l_id;exit;
        //寄出後更改狀態
        $sql = 'UPDATE `schedule_letters` SET `update_at` = "'.$nt.'",`is_run` = 1 WHERE s_l_id in '.$s_l_id;
        $s_l_end_ro = mysqli_query($link,$sql);
    
    }
    $event.='寄出人數->'.$count."\n";
    in_log($event,"single_mail_log",$nt);
    in_log("排程結束\n==============================================================================================\n","single_mail_log",$nt);
    $sql="update schedule_now set schedule_now = 0 ,schedule_now_time = '".$nt."' where seq=4";
    $ro = mysqli_query($link,$sql);
}else{
    in_log("排程運行中此分鐘暫停","single_mail_log",$nt);
}
    

?>