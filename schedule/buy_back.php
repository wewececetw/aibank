<?
include_once("setsql/setdb.php");
//include_once("sendmail.php");

$event= "\n";             //設定動作紀錄變數
$sql="select schedule_now from schedule_now where seq=5";
$ro = mysqli_query($link,$sql);
$op = mysqli_fetch_assoc($ro);
if($op["schedule_now"]==0){

    $sql="update schedule_now set schedule_now = 1 where seq=5";
    mysqli_query($link,$sql);

    if(date("H") >=15){
        $sql="select * from schedule_buying_back where s_b_b_ok = 0 and paid_at < '".date("Y-m-d H:i:s",strtotime("+0min"))."' order by s_b_b_seq limit 5";
        $ro = mysqli_query($link,$sql);
        $row = mysqli_fetch_assoc($ro);
        $cnt = mysqli_num_rows($ro);
        if($cnt > 0){
            do{
                /////////////////////////////////////////修改前備份/////////////////////////////////////////
                $trsql ="select * from tender_repayments WHERE tender_documents_id = '".$row["s_b_b_td"]."' and target_repayment_date > '".$row["target_repayment_date"]."'";
                $tro = mysqli_query($link,$trsql);
                $trow = mysqli_fetch_assoc($tro);
                do{
    //                echo "<br><br><br>";
                    $cntint = 0;
                    $insql="";
                    $insql="insert into tender_repayments_remove value (";
                    foreach( $trow as $a =>$b ){
                        if($cntint==0){
                            $insql .="'".$b."'";
                        }else{
                            $insql .=",'".$b."'";
                        }
                        $cntint ++;
                    }
                    $insql .=")";
    //                echo $insql;
                    mysqli_query($link,$insql);
                    $uid = $ttrow[""];
                }while($trow = mysqli_fetch_assoc($tro));
                /////////////////////////////////////////修改前備份/////////////////////////////////////////
    //            echo "<br>********************************************<BR>";
                /////////////////////////////////////////買回執行/////////////////////////////////////////
                $tsql ="update tender_repayments set net_amount = per_return_principal , tender_repayment_state = 2 , real_return_amount = per_return_principal , management_fee = '0' , per_return_interest = '0' , target_repayment_date ='".$row["target_repayment_date"]."' , paid_at = '".$row["paid_at"]."' , invoice_at = '".$row["paid_at"]."' , credited_at = '".$row["paid_at"]."' , buying_back_type = '".$row["buying_back_type"]."' , user_bank_id = '".$row["user_bank_id"]."' WHERE tender_documents_id = '".$row["s_b_b_td"]."' and target_repayment_date > '".$row["target_repayment_date"]."'";
    //            ECHO $tsql."<br>";
                mysqli_query($link,$tsql);
                /////////////////////////////////////////買回執行/////////////////////////////////////////
    //            echo "<br>--------------------------------------------<BR>";
                /////////////////////////////////////////推手/////////////////////////////////////////
                $phd = date("d",strtotime($row["target_repayment_date"]));
                if($phd >=20){
                    $phday =date("Y-m-20",strtotime($row["target_repayment_date"]."+2month"));
                }else{
                    $phday =date("Y-m-20",strtotime($row["target_repayment_date"]."+1month"));
                }
                $ppsql="select * from pusher_detail WHERE claim_certificate_number ='".$row["claim_certificate_number"]."' and target_repayment_date > '".$phday."'";
    //            echo $ppsql."<br>---------------------------------------------<br>";

                $pro = mysqli_query($link,$ppsql);
                $prow = mysqli_fetch_assoc($pro);
                $pcnt = mysqli_num_rows($pro);
                if($pcnt > 0){
                    do{
                        echo "<br>";
                        $cntpint = 0;
                        $inpsql="";
                        $inpsql="insert into pusher_detail_remove value (";
                        foreach( $prow as $c =>$d ){
                            if($cntpint==0){
                                $inpsql .="'".$d."'";
                            }else{
                                $inpsql .=",'".$d."'";
                            }
                            $cntpint ++;
                        }
                        $inpsql .=")";
    //                    echo $inpsql."<br>---------------------------------------------<br>";
                        mysqli_query($link,$insql);
                    }while($prow = mysqli_fetch_assoc($pro));
                    $psql ="update pusher_detail set current_balance = 0 , benefits_amount =0 WHERE claim_certificate_number ='".$row["claim_certificate_number"]."' and target_repayment_date >'".$phday."'";
    //                echo $psql."<br>---------------------------------------------<br>";
                    mysqli_query($link,$psql);
                }else{ echo "無推手<br>---------------------------------------------<br>"; }
                /////////////////////////////////////////推手/////////////////////////////////////////
                /////////////////////////////////////////收尾/////////////////////////////////////////
                $dsql ="update tender_documents set tender_document_state = 4  WHERE tender_documents_id ='".$row["s_b_b_td"]."'";
    //            echo $dsql."<br>---------------------------------------------<br>";
                mysqli_query($link,$dsql);
                $dsql ="update schedule_buying_back set s_b_b_ok = 1 WHERE s_b_b_seq  ='".$row["s_b_b_seq"]."'";
    //            echo $dsql."<br>---------------------------------------------<br>";
                mysqli_query($link,$dsql);
                /////////////////////////////////////////收尾/////////////////////////////////////////
                $event .= "執行買回".$row["claim_certificate_number"]."\n";
            }while($row = mysqli_fetch_assoc($ro));
            echo $event;
            in_log($event,"buy_back",date("Y-m-d H:i:s",strtotime("+0min")));
            in_log("排程結束\n==============================================================================================\n","buy_back",date("Y-m-d H:i:s",strtotime("+0min")));
        }
    }

    $sql="update schedule_now set schedule_now = 0 where seq=5";
    mysqli_query($link,$sql);
}