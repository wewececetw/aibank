<?php

        include_once("setsql/setdb.php");
        include_once("sendmail.php");

        // $user_tenders[會員id][債權id] = 金額
        // $claims_staging_amount[債權流水號] = 最大可投資金額
        // $claims_claim_number[債權流水號] = 債權編號
        // $claims_payment_final_deadline[債權流水號] = 最後繳款日期
        // $claims_sum_amount[債權流水號] = 標單總金額
        // $claim_tenders[債權流水號] = 剩餘可認購金額
        // $user_member_number[會員流水號] = 會員編號
        // $user_l_e_id[會員流水號] = 週週投流水號
        // $tenders_order_number[債權流水號] = 債權底下有多少個標單
        
        //開關
        $sql="select schedule_now from schedule_now where seq=2";
        $ro = mysqli_query($link,$sql);
        $op = mysqli_fetch_assoc($ro);
        
        if($op["schedule_now"]==0){

        $sql="update schedule_now set schedule_now = 1 ,schedule_now_time = '".$nt."' where seq=2";
        $ro = mysqli_query($link,$sql);
        //搜尋所有通過審核的週週投會員
        $sql = 'SELECT wk.*,u.member_number FROM `log_evweekly` wk , `users` u WHERE  wk.`l_e_check` = 2 and wk.`l_e_user` = u.user_id order by  wk.l_e_updated_at ';

        $ro =  mysqli_query($link,$sql);
        // if(!$ro){var_dump(mysqli_error($link));}
        // exit;
        $row = mysqli_fetch_assoc($ro);

        //初始化sql標單筆數 
        $sql_count = 1;
        

        //搜尋所有週週投債權(有可能撈出滿標得)
        $sql2 = 'SELECT
                    claim_id,
                    staging_amount,
                    claim_number,
                    payment_final_deadline
                FROM
                    claims 
                WHERE
                    claim_state = 0 AND foreign_t = 0 AND weekly_time >=  ADDDATE("'.$nt.'",INTERVAL -1 minute) AND "'.$nt.'" >= weekly_time';
        $ro2 =  mysqli_query($link,$sql2);
        // if(!$ro2){var_dump(mysqli_error($link));}
        // exit;
        $row2 = mysqli_fetch_assoc($ro2);

        
        $cliam_id  = '';
        //紀錄控制值
        $t = 0;
        //紀錄過幾關
        $y = 0;
        do {
            //紀錄週週投債權的claim_id
            $cliam_id .= $row2['claim_id'].',' ;
            //紀錄週週投債權的最大投資金額
            $claims_staging_amount[$row2['claim_id']] = $row2['staging_amount'];
            //紀錄週週投債權編號
            $claims_claim_number[$row2['claim_id']] = $row2['claim_number'];
            //紀錄週週投最後繳款日期
            $claims_payment_final_deadline[$row2['claim_id']] = $row2['payment_final_deadline'];
            //當排程器走過確定有尚未媒合的週週投債權時開關開啟
            if(!empty($row2['claim_id'])){
                $t ++;
                $y = 1;
            }
        } while ($row2 = mysqli_fetch_assoc($ro2));
        
        if($t>0){
            $cliam_id = substr($cliam_id, 0, -1);

            $sql3 = "SELECT
                        IFNULL(SUM(amount),0)as sum_amount,
                        claim_id
                    FROM
                        tender_documents 
                    WHERE
                        claim_id in (".$cliam_id.")  GROUP BY claim_id";
            // echo $sql3;exit;            
            $ro3 =  mysqli_query($link,$sql3);
            // if(!$ro3){var_dump(mysqli_error($link));}
            // exit;
            $row3 = mysqli_fetch_assoc($ro3);
            //債權關聯標單的金額$claims_sum_amount            
                        
            do{         
                //計算債權關聯標單的金額
                $claims_sum_amount[$row3['claim_id']] = $row3['sum_amount'];
                
                if($y==1){
                    $y = 2;
                }
            }while($row3 = mysqli_fetch_assoc($ro3));    
            
            foreach($claims_staging_amount as $k => $v){
                //當前債權標單總金額不存在時初始債權標單總金額
                if(empty($claims_sum_amount[$k])){
                    $claims_sum_amount[$k] = 0;
                }
    
                //計算債權剩餘可認購金額
                $amount = $v - $claims_sum_amount[$k];
    
                if ($amount>0) {
    
                    $claim_tenders[$k] = $amount;
                    if ($y==2) {
                        $y = 3;
                    }
                    
    
                }
            }   
            $amount2 = 0;//顯示用計算全部週週頭總金額
            $tenders_number = 0;//顯示用計算週週投標單數
            $count_number = 0;//計算迴圈跑幾次
            $user_count = 0;//計算有多少會員$sendmail_user_id的索引鍵值
            do{
                //加總會員剩餘週週投總金額 
                $total_amount = $row['l_e_amount']; 
                //不一定每筆債權的金額一樣如果要精算for迴圈需要跑幾次估計邏輯會死亡(每個會員應該要跑幾次迴圈PS:以一千為單位計算)
                $l_e_amount_count = $row['l_e_amount']/1000;
                // echo'次數->'.$l_e_amount_count."<br>";
                $user_member_number[$row['l_e_user']] = $row['member_number'];
                $user_l_e_id[$row['l_e_user']] = $row['l_e_id'];
                //紀錄所有週週投會員流水號
                $sendmail_user_id[$user_count] = $row['l_e_user'];
    
                for ( $x=0 ; $x < $l_e_amount_count ; $x++) {
                    foreach($claim_tenders as $k => $v){
                        //初始剩餘債權總金額
                        if(!isset($claims_total)){
                            $claims_total = array_sum($claim_tenders);
                        }
                        //初始化每筆債權剩餘可投標金額
                        if(!isset($claim_tenders_r[$k])){
                            $claim_tenders_r[$k] = $v;
                        }
                        //會員剩餘週週投總金額 <= 剩餘債權總金額 && 會員剩餘週週投總金額 > 0 && 每筆債權剩餘可投標金額 > 0
                        if($total_amount <= $claims_total && $total_amount > 0 && $claim_tenders_r[$k] > 0){
                            
                            //當下計數user_id claim_id 不存在時一切初始化
                            if (empty($count[$row['l_e_user']][$k])) {
                                $tenders_number ++;
                                $count[$row['l_e_user']][$k] = 1;
                                $user_tenders[$row['l_e_user']][$k] = 0;
                            } else {
                                //反之累加計數
                                $count[$row['l_e_user']][$k] ++;
                            }
    
    
                            //  會員的已投標當筆債權總金額 < 當筆債權剩餘可投注金額
                            // if ( $user_tenders[$row['l_e_user']][$k] < $v) {
                                //將通過審核的週週投會員以變數user_tenders紀錄user_id以及債權編號還有申請金額
                                $user_tenders[$row['l_e_user']][$k] += 1000;
                                //計算剩餘債權總金額
                                $claims_total = $claims_total - 1000;
                                $total_amount -= 1000;
                                $claim_tenders_r[$k] -= 1000;
                                $amount2 += 1000;
                                $count_number ++;
                                if($y==3){
                                    $y = 4;
                                }
                                
                                // echo'</br>'.$claim_tenders_r[$k].'->'.$k.'</br>';
                            // }
                        
                            
                        }
                        
                    }
                }

                $user_count++;
                
            }while($row = mysqli_fetch_assoc($ro));

            $sql4 = "SELECT
                        td.order_number,
                        td.claim_id
                    FROM
                        tender_documents td , claims c
                    WHERE
                       c.claim_id in (".$cliam_id.") and c.claim_id = td.claim_id order by td.order_number desc";
            // echo $sql4;exit;            
            $ro4 =  mysqli_query($link,$sql4);
            // if(!$ro4){var_dump(mysqli_error($link));}
            // exit;
            $row4 = mysqli_fetch_assoc($ro4);
        
            do{    
                //標單關聯債權order編號
                $tenders_order_number[$row4['claim_id']] = $row4['order_number'];
                if($y==4){
                   $y = 5; 
                }
                
            }while($row4 = mysqli_fetch_assoc($ro4));
        
           

            
            //新增標單sql字串
            if (!empty($user_tenders)) {
                foreach ($user_tenders as $k => $vt) {
                    foreach ($vt as $k1 => $v) {
                        if (empty($c_v)) {
                            $sql_log[floor($sql_count/100)] = "\n user_id：".$k."\n";
                            $c_v = $k;
                        }elseif($c_v != $k){
                            $sql_log[floor($sql_count/100)] .= "\n user_id：".$k."\n";
                            $c_v = $k;
                        }
                        if ($sql_count%100==1) {
                            $sql_string[floor($sql_count/100)] = '';
                        }
                        $tender['user_id'] = $k;
                        $tender['claim_id'] = $k1;
                
                        if (isset($tenders_order_number[$k1])) {
                            $tender['order_number'] = sprintf("%03d", ($order_number)+1);
                        } else {
                            $tender['order_number'] = sprintf("%03d", 1);
                        }
                

                        $tender['amount'] = $v;
                        $tender['created_at'] = $nt;
                
                        $tender['claim_certificate_number'] = $user_member_number[$k].$tender['order_number'].$claims_claim_number[$k1];
                        $tender['should_paid_at'] =$claims_payment_final_deadline[$k1];
                        $tender['l_e_id'] = $user_l_e_id[$k];

                        if ($sql_count%100 == 0) {
                            $sql_string[floor($sql_count/100)-1] .= '('. $tender['user_id'].','. $tender['claim_id'].',"'. $tender['order_number'].'",'. $tender['amount'].',"'. $tender['created_at'].'","'. $tender['claim_certificate_number'].'","'. $tender['should_paid_at'].'",'. $tender['l_e_id'].')';
                        } else {
                            $sql_string[floor($sql_count/100)] .= '('. $tender['user_id'].','. $tender['claim_id'].',"'. $tender['order_number'].'",'. $tender['amount'].',"'. $tender['created_at'].'","'. $tender['claim_certificate_number'].'","'. $tender['should_paid_at'].'",'. $tender['l_e_id'].'),';
                        }
                        
                        $sql_log[floor($sql_count/100)] .= "user_id：".$tender['user_id'].",'claim_id->". $tender['claim_id'].",'order_number->". $tender['order_number'].",'amount->". $tender['amount'].",'created_at->". $tender['created_at'].",'claim_certificate_number->". $tender['claim_certificate_number'].",'should_paid_at->".$tender['should_paid_at'].",'l_e_id->". $tender['l_e_id']."\n"; 
                        if($y==5){
                            $y = 6;
                        }
                        
                        $sql_count++;
                    }
                }
            }
        }
        if($sql_count>1){
            if($sql_count%100>0){
                $sql_string[floor($sql_count/100)] = substr($sql_string[floor($sql_count/100)], 0, -1);
            }
            $user_r_c = 0;
            for($x = 0 ; $x <= floor($sql_count/100) ; $x++){
                $sql5 = 'INSERT INTO tender_documents(user_id,claim_id,order_number,amount,created_at,claim_certificate_number,should_paid_at,l_e_id)VALUES'.$sql_string[$x];
                // echo $sql5."<br>";
                if(empty($event)){
                    $event = "\n";
                }
                $event .= $sql_log[$x];
                $ro5 =  mysqli_query($link,$sql5);
                // if(!$ro5){var_dump(mysqli_error($link));}
                // exit;
                if($y==6){
                    $y = 7;
                }
                
            }
            $user_tenders_count = 0;//計算已媒合會員的索引鍵值
            foreach($user_tenders as $k => $v){
                // echo'->'.$k.'->'.number_format(array_sum($v)).'<br>';
                $dont_sendmail_user[$user_tenders_count] = $k;
                send_weekly_claim_accept($k,number_format(array_sum($v)));
                $user_tenders_count ++;
                if($y==7){
                    $y = 8;
                }
                
                $user_r_c++;
            }

            //寄出媒合失敗的變數
            $dont_sendmail_user =  array_diff($sendmail_user_id,$dont_sendmail_user);
            foreach($dont_sendmail_user as $k => $v){
                send_weekly_claim_reject($v,0);
                if($y==8){
                   $y = 9; 
                }
                
            }
            // print_r($dont_sendmail_user);
            // print_r($sendmail_user_id);
        }
        
        if(empty($event)){
            $event = "\n";
        }
        // send_weekly_claim_accept(1669,"1,000");
        // send_for_test(1669);
        
        // print_r($user_tenders);
        $event .='標單數->'.$tenders_number.'迴圈數->'.$count_number.'總投注金額->'.$amount2."\n";
        $event .='過關數->'.$y."\n";
        $event .='實際通過申請人數量->'.$user_r_c."\n";
        in_log($event,"weekly_randomClaim",$nt);
        in_log("排程結束\n==============================================================================================\n","weekly_randomClaim",$nt);
        $sql="update schedule_now set schedule_now = 0 ,schedule_now_time = '".$nt."' where seq=2";
        $ro = mysqli_query($link,$sql);
    }else{
        in_log("排程運行中此分鐘暫停","weekly_randomClaim",$nt);
    }

        
































?>
