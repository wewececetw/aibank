<?php 
    include_once("setsql/setdb.php");
    include_once("sendmail.php");
    
//開關
$sql="select schedule_now from schedule_now where seq=3";
$ro = mysqli_query($link,$sql);
$op = mysqli_fetch_assoc($ro);
//初始寄出人數
$count = 0;
if($op["schedule_now"]==0){
    $sql="update schedule_now set schedule_now = 1 ,schedule_now_time = '".$nt."' where seq=3";
    $ro = mysqli_query($link,$sql);
    //搜尋寄信排程
    $sql = 'SELECT * FROM `schedule_letters` WHERE `is_run` = 0 and class_type = 0 order by created_at limit 1 ';
    
    $ro = mysqli_query($link,$sql);
    $log_row = mysqli_fetch_assoc($ro);

    if(!empty($log_row)){

        foreach ($log_row as $k => $v){
            $$k = $v;
        }
        //非全部類型的user
        if($type_id <= 0 && $type_id != -4){
            $user_class_id = abs($type_id);
            $sql = 'SELECT u.`email`,u.`user_id` FROM `users` u ,`users_roles` ur WHERE u.`user_id` = ur.`user_id` and ur.role_id = 1 and u.`user_identity` = '.$user_class_id.' and u.`is_receive_letter` = 1 and u.`user_id` > '.$run_user.' group by ur.`user_id` order by u.`user_id`  limit 10';
            $sql_end = 'SELECT u.`email`,u.`user_id` FROM `users` u ,`users_roles` ur WHERE u.`user_id` = ur.`user_id` and ur.role_id = 1 and u.`user_identity` = '.$user_class_id.' and u.`is_receive_letter` = 1 and u.`user_id` > '.$run_user.' group by ur.`user_id` order by u.`user_id` desc limit 1';
        }else{
            $sql = 'SELECT u.`email`,u.`user_id` FROM `users` u ,`users_roles` ur WHERE u.`user_id` = ur.`user_id` and ur.role_id = 1 and u.`is_receive_letter` = 1 and u.`user_id` > '.$run_user.' group by ur.`user_id` order by u.`user_id` limit 10';
            $sql_end = 'SELECT u.`email`,u.`user_id` FROM `users` u ,`users_roles` ur WHERE u.`user_id` = ur.`user_id` and ur.role_id = 1 and u.`is_receive_letter` = 1 and u.`user_id` > '.$run_user.' group by ur.`user_id` order by u.`user_id` desc limit 1';
        }
        $user_ro = mysqli_query($link,$sql);
        $user_row = mysqli_fetch_assoc($user_ro);

        $user_end_ro = mysqli_query($link,$sql_end);
        $user_end_row = mysqli_fetch_assoc($user_end_ro);
        
        //初始log
        if(empty($event)){
            $event = "\n";
        }
        //寄信
        do{
            send_template_for_log($user_row['email'],$title,$content);
            saveInbox_for_log($user_row['user_id'],$title,$content);
            $user_end_id = $user_row['user_id'];
            $event .= "user_id:".$user_row['user_id'].",'email->".$user_row['email'].",'s_l_id->".$s_l_id."\n";
            $count ++;
        }while($user_row = mysqli_fetch_assoc($user_ro));
        
        if(empty($user_end_row)){
            $user_end_id = 1;
        }
        //當排程跑到最後一個user時
        if($user_end_id == $user_end_row['user_id'] || empty($user_end_row)){
            $sql = 'UPDATE `schedule_letters` SET `run_user` = '.$user_end_id.',`update_at` = "'.$nt.'",`is_run` = 1 WHERE s_l_id = '.$s_l_id;
            $s_l_end_ro = mysqli_query($link,$sql);
        //當排程跑到100個user時    
        }else{
            $sql = 'UPDATE `schedule_letters` SET `run_user` = '.$user_end_id.',`update_at` = "'.$nt.'" WHERE s_l_id = '.$s_l_id;
            $s_l_end_ro = mysqli_query($link,$sql);
        }
        echo $sql.'<br>';
    
    }
    $event.='寄出人數->'.$count."\n";
    in_log($event,"class_mail_log",$nt);
    in_log("排程結束\n==============================================================================================\n","class_mail_log",$nt);
    $sql="update schedule_now set schedule_now = 0 ,schedule_now_time = '".$nt."' where seq=3";
    $ro = mysqli_query($link,$sql);
}else{
    in_log("排程運行中此分鐘暫停","class_mail_log",$nt);
}
    
?>