<?php

    include_once("setsql/setdb.php");
    //搜尋所有未寄信的訂單
    $od = 'SELECT
                u.phone_number as phone_number,
                o.order_id as order_id,
                o.expected_amount as expected_amount,
                u.user_name as user_name
            FROM
                orders as o ,users as u
            WHERE
                o.is_send_sms = 0 and u.virtual_account = o.virtual_account';
    $ro = mysqli_query($link,$od);
    // if(!$ro){var_dump(mysqli_error($link));}
    // exit;
    $row = mysqli_fetch_assoc($ro);
    
    
    $order_id = "(";
    do{
            $smbody = '【豬豬在線通知】本週債權已成功認購結標，您本週認購金額為$'.number_format($row['expected_amount']).'元，可至平台繳款專區收取繳款通知書，進行繳費。感謝您的認購！';//信件內容
        // if ($row['phone_number']==='0981953722') {
            $DestName = urlencode($row['user_name']);
            $order_id .= $row['order_id'].",";
            sendSMS($row['phone_number'], $DestName, $smbody);
            

            $title = 'OrderId:'.$row['order_id'];
            if(empty($row['user_name'])){
                in_log('今日無簡訊', 'orderSendSms', $nt);
            }else{
                in_log('[簡訊寄送]'.$title.'->電話號碼:'.$row['phone_number'], 'orderSendSms', $nt);
            } 
            // break;
        // }
    
    }while($row = mysqli_fetch_assoc($ro));

    $order_id = substr($order_id, 0, -1);
    $order_id.=")";
    $order = "UPDATE orders SET is_send_sms = 1 , updated_at = '".$nt."' WHERE order_id in ".$order_id;
    // echo $order;
    $ro1 = mysqli_query($link, $order);
    // if(!$ro1){var_dump(mysqli_error($link));}
    // exit;


    function sendSMS($phone,$DestName,$smbody){
        //發簡訊設定
        $username = "54179376";
        $password = "55629111";

        $sms_url = 'http://smexpress.mitake.com.tw/SmSendGet.asp?username='.$username.'&password='.$password.'&dstaddr='.$phone.'&DestName='.$DestName.'&dlvtime=&vldtime=&encoding=UTF8&smbody='.$smbody;


        // 建立CURL連線
        $ch = curl_init();
        $timeout = 5;

        //設定port
        //curl_setopt($ch, CURLOPT_PORT, 9600);

        // 設定擷取的URL網址
        curl_setopt($ch, CURLOPT_URL, $sms_url);
        curl_setopt($ch, CURLOPT_HEADER, false);

        //將curl_exec()獲取的訊息以文件流的形式返回，而不是直接輸出。
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

        //設定抓取時間
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

        // 執行
        $file_contents = curl_exec($ch);

        // 關閉CURL連線
        curl_close($ch);

        echo $file_contents;
    }