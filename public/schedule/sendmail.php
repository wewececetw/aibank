<?php
    
    // send_claim_collecting_remind();
    // document_start_to_Bid_Flow(0);

    send_for_test(1304);
    send_for_test(917);
    

    //結流標流程
    function document_start_to_Bid_Flow($user_order){

        // $user_order = [];
        // //$user_order[客戶][債權][標單][1=>結標，3=>流標]=金額
        // $user_order[1304][1384][3790][1] = 31000;
        // $user_order[1689][1384][3788][3] = 30000; 
        // $user_order[1304][1384][3789][1] = 10000;      
        // $user_order[1304][1384][3788][3] = 30000; 
        
        //拆解四維陣列
        foreach ($user_order as $user => $user_value) {
            foreach ($user_value as $claim => $claim_value){
                foreach ($claim_value as $tender_document => $tender_document_value) {
                    foreach ($tender_document_value as $tender_document_state => $tender_document_s_v) {

                        if ($user_count[$user]==$user) {
                            
                            $user_count_ct[$user] ++;
                            
                        }else{
                            $user_count[$user] = $user;
                            $user_count_ct[$user] = 0;
                            $tendersArray[$user] = '(';
                            $totalAmount[$user] = 0;
                            $count_Bid[$user] = 0;
                            $count_Flow[$user] = 0;
                        }

                        if ($user_count_ct[$user]==0) {
                            $User_sql = 'SELECT virtual_account , member_number , user_name , email , user_id , is_receive_letter FROM users  WHERE user_id = '.$user;
                            $link = mysqli_connect("localhost","kqzwlrrm_pp_user","jCgz91Ib8}uR","kqzwlrrm_ppo_nline");
                            mysqli_query($link,"set names utf8");
                            $uro = mysqli_query($link,$User_sql);
                            $urow = mysqli_fetch_assoc($uro);
                        }

                        if ($tender_document_state == 1) {
                            $count_Bid[$user] ++;
                            $totalAmount[$user] += $tender_document_s_v;
                        } else {
                            $count_Flow[$user] ++;
                            
                        }
                        $pdf_data[$user] = [
                            // 'order_id' => $od->order_id,
                            'user' => $urow,
                            'tenders' => [],
                            'totalAmount' => $totalAmount[$user],
                            'count_Bid' => $count_Bid[$user],
                            'count_Flow' => $count_Flow[$user]
                        ];
                        
                        $tendersArray[$user] .= $tender_document.',';
                        
                    }
                }
                
            }

        }
        foreach ($pdf_data as $key => $value) {


            if ($pdf_count[$key]==$key) {
                            
                $pdf_count_ct1[$key] ++;
                
            }else{

                $pdf_count[$key] = $key;
                $pdf_count_ct[$key] = 0;
                $tendersArray[$user] = substr($tendersArray[$user], 0, -1);
                $tendersArray[$user].=")";
                
                $tenders_sql = 'SELECT td.should_paid_at , c.estimated_close_date FROM claims c , tender_documents td  WHERE c.claim_id = td.claim_id and td.tender_documents_id in '.$tendersArray[$user];
                $link = mysqli_connect("localhost","kqzwlrrm_pp_user","jCgz91Ib8}uR","kqzwlrrm_ppo_nline");
                mysqli_query($link,"set names utf8");
                $tro = mysqli_query($link,$tenders_sql);
                $trow = mysqli_fetch_assoc($tro);

                if($pdf_data[$key]['count_Bid']>0){
                    $t_ar = [
                        'should_paid_at' => $trow['should_paid_at'],
                        'estimated_close_date' => $trow['estimated_close_date']
                    ];
                }else{
                    $t_ar = [
                        'estimated_close_date' => $trow['estimated_close_date']
                    ];
                }
            }
            
            array_push($pdf_data[$key]['tenders'],$t_ar);
        }

        foreach ($pdf_data as $key => $value) {
            document_start_to_Bid_Flow2($value['user'],$value['tenders'],$value['totalAmount'],$value['count_Bid'],$value['count_Flow']);
        }
    }

    //結流標模組
    function document_start_to_Bid_Flow2($user,$tenders,$totalAmount,$count_Bid,$count_Flow){
        if ($user['is_receive_letter'] == 1) {

            if(isset($tenders[0]['should_paid_at'])){$should_paid_at = date('Y-m-d H:i', strtotime($tenders[0]['should_paid_at']));}else{$should_paid_at = '';}
            $title = '豬豬在線債權結(流)標通知';
            $ctx = [
                    '親愛的 '.$user['user_name'].' 會員，您好:',
                    '附上本次「結(流)標及繳款通知書」，如有成功結標案件，請您依照繳款通知書上的資訊於繳款截止日前完成繳款，感謝您的認購。',
                    "<div class='row center'>
                        <h2><strong>結(流)標及繳款通知書</strong></h2>
                    </div>",
                    "<div class='row'>
                        <table class='table'>
                            <tr>
                                <td class='wd-4'>
                                    會員編號
                                </td>
                                <td>
                                    ".$user['member_number']."
                                </td>
                            </tr>
                            <tr>
                                <td class='wd-4'>
                                    會員姓名
                                </td>
                                <td>
                                    ".$user['user_name']."
                                </td>
                            </tr>
                            <tr>
                                <td class='wd-4'>
                                    結標時間
                                </td>
                                <td>
                                    ".date('Y-m-d', strtotime($tenders[0]['estimated_close_date']))."
                                </td>
                            </tr>
                            <tr>
                                <td class='wd-4'>
                                    結標件數
                                </td>
                                <td>
                                    ".$count_Bid."
                                </td>
                            </tr>
                            <tr>
                                <td class='wd-4'>
                                    流標件數
                                </td>
                                <td>
                                    ".$count_Flow."
                                </td>
                            </tr>
                            <tr>
                                <td class='wd-4'>
                                    應繳結標總金額
                                </td>
                                <td>
                                    ".$totalAmount."
                                </td>
                            </tr>
                            <tr>
                                <td class='wd-4'>
                                    繳款戶名
                                </td>
                                <td>
                                    信任豬股份有限公司
                                </td>
                            </tr>
                            <tr>
                                <td class='wd-4'>
                                    繳款銀行(代碼)
                                </td>
                                <td>
                                    彰化銀行(009)
                                </td>
                            </tr>
                            <tr>
                                <td class='wd-4'>
                                    分行(代碼)
                                </td>
                                <td>
                                    中山北路分行(5081)
                                </td>
                            </tr>
                            <tr>
                                <td class='wd-4'>
                                    繳款帳號
                                </td>
                                <td>
                                    ".$user['virtual_account']."
                                </td>
                            </tr>
                            <tr>
                                <td class='wd-4'>
                                    購買債權
                                </td>
                                <td>
                                    請參考債權明細表
                                </td>
                            </tr>
                            <tr>
                                <td class='wd-4'>
                                    繳款截止日
                                </td>
                                <td>
                                    ".$should_paid_at."
                                </td>
                            </tr>
                        </table>
                    </div>",
                    "結標案件明細及繳款通知書下載，請詳見：會員專區 > 我的帳戶 > 繳款",
                    "流標案件明細，請詳見：會員專區 > 我的帳戶 > 已流標",
                    "<br>",
                    "--",
                    "<span style='font-weight:bold;'>亞太普惠金融科技股份有限公司 / 信任豬股份有限公司</span>",
                    "客服專線 : (02)5562-9111",
                    "客服信箱 : service@pponline.com.tw",
                    "官方LINE : <a href='https://line.me/R/ti/p/%40sub9431m'>點擊前往</a>",
                    "FB粉專 : <a href='https://www.facebook.com/pponline888'>點擊前往粉絲專頁</a>",
                    "豬豬在線官網 : <a href='https://www.pponline.com.tw'>點擊前往官方網站</a>"
                ];
        
            send_template($user['email'], $title, $ctx);//寄信
            saveInbox($user['user_id'], $title, $ctx);//寄信備份
        }
    }

    function send_claim_collecting_remind(){
        
        //查詢開啟信件會員
        $User_sql = "SELECT * FROM `users` WHERE `is_receive_letter` = 1";
        $link = mysqli_connect("localhost","kqzwlrrm_pp_user","jCgz91Ib8}uR","kqzwlrrm_ppo_nline");
        mysqli_query($link,"set names utf8");
        $ro = mysqli_query($link,$User_sql);
        // if(!$ro){var_dump(mysqli_error($link));}
        // exit;
        $User_row = mysqli_fetch_assoc($ro); 
        do{
            if ($User_row['is_receive_letter'] == 1) {
                // if ($User_row['email'] == 'wewececetw@gmail.com') {
                    $ctx = [
                        '親愛的 '.$User_row['user_name'].' 先生/女士，您好',
                        "豬豬在線新上架債權已準時開標，<a href='https://www.pponline.com.tw' target='_blank'>點此</a>快速進入官網搶標",
                        "<br>",
                        "--",
                        "<span style='font-weight:bold;'>亞太普惠金融科技股份有限公司 / 信任豬股份有限公司</span>",
                        "客服專線 : (02)5562-9111",
                        "客服信箱 : service@pponline.com.tw",
                        "官方LINE : <a href='https://line.me/R/ti/p/%40sub9431m'>點擊前往</a>",
                        "FB粉專 : <a href='https://www.facebook.com/pponline888'>點擊前往粉絲專頁</a>",
                        "豬豬在線官網 : <a href='https://www.pponline.com.tw'>點擊前往官方網站</a>"
                    ];//內容
                    $subj = '豬豬在線債權開標提醒';//標題
                    send_template($User_row['email'], $subj, $ctx);//寄信
                    saveInbox($User_row['user_id'], $subj, $ctx);//寄信備份
                // }
            }
        }while($User_row = mysqli_fetch_assoc($ro));   
    }

    function send_for_test($user_id){
        
        //查詢開啟週週投信件會員
        $User_sql = "SELECT * FROM `users` WHERE `user_id` = ".$user_id;
        $link = mysqli_connect("localhost","kqzwlrrm_pp_user","jCgz91Ib8}uR","kqzwlrrm_ppo_nline");
        mysqli_query($link,"set names utf8");
        $ro = mysqli_query($link,$User_sql);
        // if(!$ro){var_dump(mysqli_error($link));}
        // exit;
        $User_row = mysqli_fetch_assoc($ro); 
        do{
            if ($User_row['is_receive_letter'] == 1) {
                // if ($User_row['email'] == 'wewececetw@gmail.com') {
                    $ctx = [
                        '<img src="https://twww.pponline.com.tw/images/details_close.png" alt="">'
                    ];//內容
                    $subj = 'test';//標題
                    send_template($User_row['email'], $subj, $ctx);//寄信
                    saveInbox($User_row['user_id'], $subj, $ctx);//寄信備份
                // }
            }
        }while($User_row = mysqli_fetch_assoc($ro));   
    }
    
    // function send_template($email,$subj,$ctx){

    //     $headers = array(
    //         'Authorization: Bearer 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',
    //         'Content-Type: application/json'
    //     );
        
        
    //     $cont = `<!DOCTYPE html>
    //             <html lang="zh-TW">
    //             <head>
    //                 <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    //                 <meta name="viewport" content="width=device-width, initial-scale=1.0">
    //                 <meta http-equiv="X-UA-Compatible" content="ie=edge">
    //             </head>
    //             <style>
    //                 *{
    //                     font-family: 'simsun';
    //                 }
    //                 .wd-4 {
    //                     width: 40%;
    //                 }
    //                 .container {
    //                     font-family: 'simsun';
    //                     /* font-weight: 600; */
    //                     font-weight: bold;
    //                     width: 100%;
    //                 }
    //                 .container .row {
    //                     width: 45%;
    //                     margin-left: 5%;
    //                     font-family: 'simsun';
    //                 }
                
    //                 .table {
    //                     border: 2px black solid;
    //                     width: 100%;
    //                     border-collapse: collapse;
    //                 }
                
    //                 .table tr {
    //                     width: 100%;
    //                 }
                
    //                 .table tr td {
    //                     padding-left: 4px;
    //                     border: 2px black solid;
    //                     font-family: 'simsun';
    //                 }
    //                 td{
    //                     font-family: 'simsun';
    //                 }
    //                 @media (max-width: 768px){
    //                 .container .row {
    //                     width: 90%;
    //                     margin-left: 5%;
    //                     font-family: 'simsun';
    //                 }
    //                 }
    //             </style>
    //             <body>`;
    //                 foreach ($ctx as $v) {
    //                     $cont.= "<p>".$v."</p>";
    //                 }
    //         $cont.=`</body>
    //             </html>
    //             `;//內文

    //     $data = array(
    //         "personalizations" => array(
    //             array(
    //                 "to" => array(
    //                     array(
    //                         "email" => $email
    //                     )
    //                 )
    //             )
    //         ),
    //         "from" => array(
    //             "email" => "service@pponline.com.tw",
    //             "name" => "信任豬股份有限公司"
    //         ),
    //         "subject" => $subj,
    //         "content" => array(
    //             array(
    //                 "type" => "text/html",
    //                 "value" => $cont
    //             )
    //         )
    //     );
        
    //     $ch = curl_init();
    //     curl_setopt ($ch, CURLOPT_URL,"https://api.sendgrid.com/v3/mail/send");
    //     curl_setopt ($ch, CURLOPT_POST, true);
    //     curl_setopt ($ch, CURLOPT_POSTFIELDS, json_encode($data));
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     $response = curl_exec($ch);
    //     curl_close($ch);
    //     // print_r($response);
    // }

    function send_template($email, $subj, $ctx)
    {
        mb_internal_encoding('UTF-8'); //編碼

        $to = $email;
        $subject = $subj;
        $subject = mb_encode_mimeheader($subject, 'UTF-8');
        $msg = `<!DOCTYPE html>
                <html lang="zh-TW">
                <head>
                    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <meta http-equiv="X-UA-Compatible" content="ie=edge">
                </head>
                <style>
                    *{
                        font-family: 'simsun';
                    }
                    .wd-4 {
                        width: 40%;
                    }
                    .container {
                        font-family: 'simsun';
                        /* font-weight: 600; */
                        font-weight: bold;
                        width: 100%;
                    }
                    .container .row {
                        width: 45%;
                        margin-left: 5%;
                        font-family: 'simsun';
                    }
                
                    .table {
                        border: 2px black solid;
                        width: 100%;
                        border-collapse: collapse;
                    }
                
                    .table tr {
                        width: 100%;
                    }
                
                    .table tr td {
                        padding-left: 4px;
                        border: 2px black solid;
                        font-family: 'simsun';
                    }
                    td{
                        font-family: 'simsun';
                    }
                    @media (max-width: 768px){
                    .container .row {
                        width: 90%;
                        margin-left: 5%;
                        font-family: 'simsun';
                    }
                    }
                </style>
                <body>`;
                    foreach ($ctx as $v) {
                        $msg.= "<p>".$v."</p>";
                    }
            $msg.=`</body>
                </html>
                `;//內文
        /*
        信件內容如果需要CSS效果只能使用STYLE行內標籤設定
        <div style="color:#foo">紅字</div>
        無法使用style標籤及link設定CSS
         */
        $webname = '信任豬股份有限公司';
        $headers = "MIME-Version:1.0\r\n";
        $headers .= "Content-type:text/html;charset=utf-8\r\n";
        $headers .= "From:" . mb_encode_mimeheader($webname, 'UTF-8') . "<service@pponline.com.tw>\r\n";
        $headers .= "Replay-To:" . mb_encode_mimeheader($webname, 'UTF-8') . "<service@pponline.com.tw>\r\n";
        $headers .= "Return-Path:" . mb_encode_mimeheader($webname, 'UTF-8') . "<service@pponline.com.tw>\r\n";
        if (mail("$to", "$subject", "$msg", "$headers")):
        echo "信件發送成功";
        else:
        echo "發送失敗";
        endif;
    }

    function saveInbox($user_id,$title,$ctx)
    {
        $content = '';
        foreach($ctx as $v){
            $content .= $v;
        }
        $nt = date("Y-m-d H:i:s",strtotime("+8hour"));

        $sql = 'INSERT INTO inbox_letters (user_id, title, content, created_at, updated_at) VALUES ('.$user_id.', "'.$title.'", "'.$content.'", "'.$nt.'", "'.$nt.'")';
        
        $link = mysqli_connect("localhost","kqzwlrrm_pp_user","jCgz91Ib8}uR","kqzwlrrm_ppo_nline");
        mysqli_query($link,"set names utf8");
        $ro = mysqli_query($link,$sql);
        // if(!$ro){var_dump(mysqli_error($link));}
        // exit;
    }

    