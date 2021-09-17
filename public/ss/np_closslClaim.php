<?
include_once("setsql/setdb.php");

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

$sql="select claim_id,claim_state from claims where claim_state =4 ;";
$ro = mysqli_query($link,$sql);
$row = mysqli_fetch_assoc($ro);
do{
    $e1=" 未改變";
    $e2="，狀態：[".$cl[$row["claim_state"]]."] ";
    $e3="";
    $sql="SELECT * FROM tender_documents td, tender_repayments tr WHERE td.claim_id =".$row["claim_id"]." and td.tender_documents_id = tr.tender_documents_id and tender_repayment_state =0;";
    $ro1 = mysqli_query($link,$sql);
    $tr_cnt = mysqli_num_rows($ro1);

    if($tr_cnt==0){                 //確認是否開標
        $e1=" 轉換";
        $e3="=> 結案";
        $sql="update claims set claim_state = 5 , updated_at = '".date("Y-m-d H:i:s",strtotime("+8hour"))."' where claim_id='".$row["claim_id"]."';";
        echo $sql."<br>";
        //mysqli_query($link,$sql);
        $sql="update tender_documents set tender_document_state = 4 , updated_at = '".date("Y-m-d H:i:s",strtotime("+8hour"))."' where claim_id='".$row["claim_id"]."';";
        //mysqli_query($link,$sql);
        echo $sql."結案<br>";
    }

    echo "Claim_id：".$row["claim_id"]."-".$tr_cnt."<br>";
    $event = $event."Claim_id：".$row["claim_id"].$e1.$e2.$e3."\n";
}while($row = mysqli_fetch_assoc($ro));
//echo $event;
in_log($event,"clossClaim",$nt);
in_log("排程結束\n==============================================================================================\n","clossClaim",$nt);

?>