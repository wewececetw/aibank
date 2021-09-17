<?php
if (!empty($_SERVER["HTTP_CLIENT_IP"])){
    $ip = $_SERVER["HTTP_CLIENT_IP"];
}elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
    $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
}else{
    $ip = $_SERVER["REMOTE_ADDR"];
}

$link = mysqli_connect("localhost","kqzwlrrm_pp_user","jCgz91Ib8}uR","kqzwlrrm_ppo_nline");
mysqli_query($link,"set names utf8");
$nt = date("Y-m-d H:i:s",strtotime("+8hour"));


function in_log($in,$url,$nt){
    $t1 = "log/".$url."/log_";
    $t2 = date("Y_m_d_H",strtotime("+8hour"));
    $t3 = ".txt";
    $tt = $t1.$t2.$t3;
    $tr=fopen ($tt,"a+");
    $sw = "[".$nt."]";
    $ww = $sw.$in."\n";
    fwrite ($tr,$ww);
    fclose ($tr);
}


?>