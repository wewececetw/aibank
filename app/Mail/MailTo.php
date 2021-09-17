<?php
namespace App\Mail;
use App\Mail\SampleMail;
use Illuminate\Support\Facades\Mail;
use DB;
use App\User;
use App\UsersRoles;
use App\InboxLetters;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
class MailTo {

    /**
     * 上架信 自動找所有User寄信
     *
     * @return void
     */
    public function claim_collecting_remind(){
        $users = (new User)->getAllNormalUserInfo();
        foreach ($users as $user) {
            try {
                $title = '豬豬在線債權開標提醒';
                $ctx = [
                    '親愛的 '.$user->user_name.' 先生/女士，您好',
                    "豬豬在線新上架債權已準時開標，<a href='https://www.pponline.com.tw' target='_blank'>點此</a>快速進入官網搶標",
                    "<br>",
                    "--",
                    "<span style='font-weight:bold;'>亞太普惠金融科技股份有限公司 / 信任豬股份有限公司</span>",
                    "客服專線 : (02)5562-9111",
                    "客服信箱 : service@pponline.com.tw",
                    "官方LINE : <a href='https://line.me/R/ti/p/%40sub9431m'>點擊前往</a>",
                    "FB粉專 : <a href='https://www.facebook.com/pponline888'>點擊前往粉絲專頁</a>",
                    "豬豬在線官網 : <a href='https://www.pponline.com.tw'>點擊前往官方網站</a>"
                ];
                $this->send($title,$ctx,$user->email);
                $this->saveInbox($user->user_id,$title,$ctx);
                // $logpath = 'logs/sendMail/' . date("Y-m-d H") . '.log';
                // $log = new Logger('pp_Mail');
                // $log->pushHandler(new StreamHandler(storage_path($logpath)), Logger::DEBUG);
                // $log->debug('上架信', [$user->email]);
            } catch (\Throwable $th) {
                // $logpath = 'logs/sendMail/' . date("Y-m-d H") . '.log';
                // $log = new Logger('pp_Mail');
                // $log->pushHandler(new StreamHandler(storage_path($logpath)), Logger::DEBUG);
                // $log->debug('上架信錯誤', [$th]);
                // return false;
            }
        }

    }

    /**
     * 結標(流標信)
     *
     * @param  mixed $user_id User ID
     * @return void
     */
    public function tender_document_start_to_repay($user_id,$user,$tenders,$totalAmount)
    {
        try {
            $users = User::find($user_id);
            if($users->is_receive_letter == 1 || $users->is_receive_letter == '開啟'){
                $title = '豬豬在線債權結(流)標通知';
                $ctx = [
                    '親愛的 '.$users->user_name.' 會員您好:',
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
                                    ".date('Y-m-d',strtotime($tenders[0]['estimated_close_date']))."
                                </td>
                            </tr>
                            <tr>
                                <td class='wd-4'>
                                    結標件數
                                </td>
                                <td>
                                    0
                                </td>
                            </tr>
                            <tr>
                                <td class='wd-4'>
                                    流標件數
                                </td>
                                <td>
                                    ".$tenders[0]['count_liubio']."
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
                                    
                                </td>
                            </tr>
                        </table>
                    </div>",
                    "結標案件明細及繳款通知書下載，請詳見：會員專區 > 我的帳戶 > 繳款",
                    "流標案件明細，請詳見：會員專區 > 我的帳戶 > 已流標",
                    // "您本週購買的債權已成功結標，您可以至豬豬在線<a href='https://www.pponline.com.tw/front/myaccount' target='_blank'>會員專區</a>，查詢及下載債權繳款通知書。",
                    // // "觀看附件請點擊右方連結<a href=".$file_path.">點我</a>",
                    // "請您依照繳款通知書上的資訊於繳款截止日前完成繳款，感謝您的認購。",
                    "<br>",
                    "--",
                    "<span style='font-weight:bold;'>亞太普惠金融科技股份有限公司 / 信任豬股份有限公司</span>",
                    "客服專線 : (02)5562-9111",
                    "客服信箱 : service@pponline.com.tw",
                    "官方LINE : <a href='https://line.me/R/ti/p/%40sub9431m'>點擊前往</a>",
                    "FB粉專 : <a href='https://www.facebook.com/pponline888'>點擊前往粉絲專頁</a>",
                    "豬豬在線官網 : <a href='https://www.pponline.com.tw'>點擊前往官方網站</a>"
                ];
                $this->send($title,$ctx,$users->email);
                $this->saveInbox($users->user_id,$title,$ctx);
            }
        } catch (\Throwable $th) {
            return false;
        }
    }
    /**
     * 結標 2 有附件的那種
     *
     * @param  mixed $user_id User ID
     * @param  mixed $file_path 檔案路徑
     * @return void
     */
    public function tender_document_start_to_repay2($user_id,$user,$tenders,$totalAmount)
    {
        try {
            $users = User::find($user_id);
            if($users->is_receive_letter == 1 || $users->is_receive_letter == '開啟'){
                $title = '豬豬在線債權結(流)標通知';
                $ctx = [
                    '親愛的 '.$users->user_name.' 會員您好:',
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
                                    ".date('Y-m-d',strtotime($tenders[0]['estimated_close_date']))."
                                </td>
                            </tr>
                            <tr>
                                <td class='wd-4'>
                                    結標件數
                                </td>
                                <td>
                                    ".count($tenders)."
                                </td>
                            </tr>
                            <tr>
                                <td class='wd-4'>
                                    流標件數
                                </td>
                                <td>
                                    ".$tenders[0]['count_liubio']."
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
                                    ".date('Y-m-d H:i',strtotime($tenders[0]['should_paid_at']))."
                                </td>
                            </tr>
                        </table>
                    </div>",
                    "結標案件明細及繳款通知書下載，請詳見：會員專區 > 我的帳戶 > 繳款",
                    "流標案件明細，請詳見：會員專區 > 我的帳戶 > 已流標",
                    // "您本週購買的債權已成功結標，您可以至豬豬在線<a href='https://www.pponline.com.tw/front/myaccount' target='_blank'>會員專區</a>，查詢及下載債權繳款通知書。",
                    // // "觀看附件請點擊右方連結<a href=".$file_path.">點我</a>",
                    // "請您依照繳款通知書上的資訊於繳款截止日前完成繳款，感謝您的認購。",
                    "<br>",
                    "--",
                    "<span style='font-weight:bold;'>亞太普惠金融科技股份有限公司 / 信任豬股份有限公司</span>",
                    "客服專線 : (02)5562-9111",
                    "客服信箱 : service@pponline.com.tw",
                    "官方LINE : <a href='https://line.me/R/ti/p/%40sub9431m'>點擊前往</a>",
                    "FB粉專 : <a href='https://www.facebook.com/pponline888'>點擊前往粉絲專頁</a>",
                    "豬豬在線官網 : <a href='https://www.pponline.com.tw'>點擊前往官方網站</a>"
                ];
                $this->send($title,$ctx,$users->email);
                $this->saveInbox($users->user_id,$title,$ctx);
            }
        } catch (\Throwable $th) {
            return false;
        }
    }
    /**
     * 流標信
     *
     * @param  mixed $user_id
     * @return void
     */
    public function floating_email($user_id,$claim_certificate_number)
    {
        try {
            $user = User::find($user_id);
            if($user->is_receive_letter == 1 || $user->is_receive_letter == '開啟'){
                $title = '豬豬在線流標通知';
                $ctx = [
                    "親愛的 ". $user->user_name ." 先生/女士，",
                    "很抱歉，",
                    "<span style='word-wrap:break-word;'>您購買豬豬在線的債權項目已流標：債權憑證號【".$claim_certificate_number."】，</span>",
                    "您可以至豬豬在線會員專區「我的帳戶」查詢流標相關資訊。",
                    "<br>",
                    "--",
                    "<span style='font-weight:bold;'>亞太普惠金融科技股份有限公司 / 信任豬股份有限公司</span>",
                    "客服專線 : (02)5562-9111",
                    "客服信箱 : service@pponline.com.tw",
                    "官方LINE : <a href='https://line.me/R/ti/p/%40sub9431m'>點擊前往</a>",
                    "FB粉專 : <a href='https://www.facebook.com/pponline888'>點擊前往粉絲專頁</a>",
                    "豬豬在線官網 : <a href='https://www.pponline.com.tw'>點擊前往官方網站</a>"
                ];
                $this->send_template($user->email,$title,$ctx);
                $this->saveInbox($user->user_id,$title,$ctx);
            }
        } catch (\Throwable $th) {
            return false;
            //throw $th;
        }
    }

    /**
     * 已繳款
     *
     * @param  mixed $user_id
     * @return void
     */
    public function user_paid_confirmed($user_id,$claim_certificate_number)
    {
        try {
            $user = User::find($user_id);
            if($user->is_receive_letter == 1 || $user->is_receive_letter == '開啟'){
                $ctx = [
                    "親愛的 ". $user->user_name ." 先生/女士，",
                    "【債權憑證號： $claim_certificate_number 】",
                    "已收到您本次認購債權的款項，",
                    "您的債權讓售協議書及約定報酬起算日將於債權項目結標及完成債權出讓手續後統一計算，",
                    "並將相關資訊發送至您的電子郵件信箱。您也可以至豬豬在線會員專區「我的帳戶」查詢投資明細，",
                    "感謝您的購買。",
                    "<br>",
                    "--",
                    "<span style='font-weight:bold;'>亞太普惠金融科技股份有限公司 / 信任豬股份有限公司</span>",
                    "客服專線 : (02)5562-9111",
                    "客服信箱 : service@pponline.com.tw",
                    "官方LINE : <a href='https://line.me/R/ti/p/%40sub9431m'>點擊前往</a>",
                    "FB粉專 : <a href='https://www.facebook.com/pponline888'>點擊前往粉絲專頁</a>",
                    "豬豬在線官網 : <a href='https://www.pponline.com.tw'>點擊前往官方網站</a>"
                ];
                $ctx2 = [
                    "【債權憑證號： $claim_certificate_number 】",
                    "已收到您本次認購債權的款項，",
                    "您的債權讓售協議書及約定報酬起算日將於債權項目結標及完成債權出讓手續後統一計算，",
                    "並將相關資訊發送至您的電子郵件信箱。您也可以至豬豬在線會員專區「我的帳戶」查詢投資明細，",
                    "感謝您的購買。"
                ];
                $title = '豬豬在線匯款成功通知';
                
                $content = '';
                foreach ($ctx2 as $v){
                    $content .= "<p>".$v."</p>";
                }
                $this->send_inside_mail_for_log($user->user_id, $title, $content);//站內信
                $this->send_template($user->email,$title,$ctx);
                $this->saveInbox($user->user_id,$title,$ctx);
            }
        } catch (\Throwable $th) {
            return false;
            //throw $th;
        }
    }
    /**
     * 已繳款
     *
     * @param  mixed $user_id
     * @return void
     */
    public function user_paid_confirmed2($user_id)
    {
        try {
            $user = User::find($user_id);
            if($user->is_receive_letter == 1 || $user->is_receive_letter == '開啟'){
                $ctx = [
                    "親愛的 ". $user->user_name ." 先生/女士，您好",
                    // "【債權憑證號： $claim_certificate_number 】",
                    "已收到您本次認購債權的款項，",
                    "您的債權讓售協議書及約定報酬起算日將於債權項目結標及完成債權出讓手續後統一計算，",
                    "並將相關資訊發送至您的電子郵件信箱。您也可以至豬豬在線會員專區「我的帳戶」查詢投資明細，",
                    "感謝您的購買。",
                    "<br>",
                    "--",
                    "<span style='font-weight:bold;'>亞太普惠金融科技股份有限公司 / 信任豬股份有限公司</span>",
                    "客服專線 : (02)5562-9111",
                    "客服信箱 : service@pponline.com.tw",
                    "官方LINE : <a href='https://line.me/R/ti/p/%40sub9431m'>點擊前往</a>",
                    "FB粉專 : <a href='https://www.facebook.com/pponline888'>點擊前往粉絲專頁</a>",
                    "豬豬在線官網 : <a href='https://www.pponline.com.tw'>點擊前往官方網站</a>"
                ];
                $ctx2 = [
                    // "【債權憑證號： $claim_certificate_number 】",
                    "已收到您本次認購債權的款項，",
                    "您的債權讓售協議書及約定報酬起算日將於債權項目結標及完成債權出讓手續後統一計算，",
                    "並將相關資訊發送至您的電子郵件信箱。您也可以至豬豬在線會員專區「我的帳戶」查詢投資明細，",
                    "感謝您的購買。"
                ];
                $title = '豬豬在線匯款成功通知';
                $content = '';
                foreach ($ctx2 as $v){
                    $content .= "<p>".$v."</p>";
                }
                $this->send_inside_mail_for_log($user->user_id, $title, $content);//站內信
                $this->send_template($user->email,$title,$ctx);
                $this->saveInbox($user->user_id,$title,$ctx);
            }
        } catch (\Throwable $th) {
            return false;
            //throw $th;
        }
    }

    /**
     * 後台站外信
     *
     * @param  mixed $user_id
     * @return void
     */
    public function send_outbox_mail($user_id,$title,$content)
    {
        try {
            $user = User::find($user_id);
            if($user->is_receive_letter == 1 || $user->is_receive_letter == '開啟'){
                $ctx = [
                    $content,
                    "--",
                    "<span style='font-weight:bold;'>亞太普惠金融科技股份有限公司 / 信任豬股份有限公司</span>",
                    "客服專線 : (02)5562-9111",
                    "客服信箱 : service@pponline.com.tw",
                    "官方LINE : <a href='https://line.me/R/ti/p/%40sub9431m'>點擊前往</a>",
                    "FB粉專 : <a href='https://www.facebook.com/pponline888'>點擊前往粉絲專頁</a>",
                    "豬豬在線官網 : <a href='https://www.pponline.com.tw'>點擊前往官方網站</a>"
                ];
                $cont = '';
                foreach ($ctx as $v){
                    $cont .= "<p>".$v."</p>";
                }
                $ctx2 = [
                    $content
                ];
                $cont2 = '';
                foreach ($ctx2 as $v){
                    $cont2 .= "<p>".$v."</p>";
                }
                // $this->send_template($user->email,$title,$ctx);
                // $this->saveInbox($user->user_id,$title,$ctx);
                $this->send_outside_mail_for_log($user->user_id, $title, $cont);//站外信排程
                $this->send_inside_mail_for_log($user->user_id, $title, $cont2);//站內信
            }
            
        } catch (\Throwable $th) {
            return false;
            //throw $th;
        }
    }

    /**
     * 後台站外信to群組
     *
     * @param  mixed $user_id
     * @return void
     */
    public function send_outbox_mail_for_class($user_id,$title,$content)
    {
        try {
            // $user = User::find($user_id);
            // if($user->is_receive_letter == 1 || $user->is_receive_letter == '開啟'){
                $ctx = [
                    $content,
                    "--",
                    "<span style='font-weight:bold;'>亞太普惠金融科技股份有限公司 / 信任豬股份有限公司</span>",
                    "客服專線 : (02)5562-9111",
                    "客服信箱 : service@pponline.com.tw",
                    "官方LINE : <a href='https://line.me/R/ti/p/%40sub9431m'>點擊前往</a>",
                    "FB粉專 : <a href='https://www.facebook.com/pponline888'>點擊前往粉絲專頁</a>",
                    "豬豬在線官網 : <a href='https://www.pponline.com.tw'>點擊前往官方網站</a>"
                ];
                $cont = '';
                foreach ($ctx as $v){
                    $cont .= "<p>".$v."</p>";
                }
                $ctx2 = [
                    $content
                ];
                $cont2 = '';
                foreach ($ctx2 as $v){
                    $cont2 .= "<p>".$v."</p>";
                }
                // $this->send_template($user->email,$title,$ctx);
                // $this->saveInbox($user->user_id,$title,$ctx);
                $this->send_outside_mail_for_log($user_id, $title, $cont);//站外信排程
                $this->send_inside_mail_for_log($user_id, $title, $cont2);//站內信
            // }
            
        } catch (\Throwable $th) {
            return false;
            //throw $th;
        }
    }


    public function invoiceMailToUser($email)
    {
        try {
            $user = User::where('email',$email)->first();
            if($user->is_receive_letter == 1 || $user->is_receive_letter == '開啟'){
                $title = '系統通知';
                $ctx = [
                    '手續費的發票稍晚會發送至您的電子信箱，如有任何疑問請聯繫<a href="https://line.me/R/ti/p/%40sub9431m">官方line</a>，或洽客服專員 02-55629111，我們將竭誠爲您服務。',
                    "<br>",
                    "--",
                    "<span style='font-weight:bold;'>亞太普惠金融科技股份有限公司 / 信任豬股份有限公司</span>",
                    "客服專線 : (02)5562-9111",
                    "客服信箱 : service@pponline.com.tw",
                    "官方LINE : <a href='https://line.me/R/ti/p/%40sub9431m'>點擊前往</a>",
                    "FB粉專 : <a href='https://www.facebook.com/pponline888'>點擊前往粉絲專頁</a>",
                    "豬豬在線官網 : <a href='https://www.pponline.com.tw'>點擊前往官方網站</a>"
                ];
                $ctx2 = [
                    '手續費的發票稍晚會發送至您的電子信箱，如有任何疑問請聯繫<a href="https://line.me/R/ti/p/%40sub9431m">官方line</a>，或洽客服專員 02-55629111，我們將竭誠爲您服務。',
                ];
                $content = '';
                foreach ($ctx2 as $v){
                    $content .= "<p>".$v."</p>";
                }
                $this->send_inside_mail_for_log($user->user_id, $title, $content);//站內信
                $this->send($title,$ctx,$email);
                $this->saveInbox($user->user_id,$title,$ctx);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * 收益返還信
     *
     * @param  mixed $user_id
     * @return void
     */
    public function income_email($user_id)
    {
        try {
            $user = User::find($user_id);
            if($user->is_receive_letter == 1 || $user->is_receive_letter == '開啟'){

                $title = '豬豬在線投資收益返還通知';
                $ctx = [
                    "親愛的 ". $user->user_name ." 先生/女士，您好",
                    "我們已於 ". date("m") . "月".date("d")."號"." 將本期應返還之收益匯款給您，",
                    "您可以至豬豬在線會員專區「我的帳戶」並點擊「我的帳本」查詢相關資訊，感謝您的認購。",
                    "<br>",
                    "--",
                    "<span style='font-weight:bold;'>亞太普惠金融科技股份有限公司 / 信任豬股份有限公司</span>",
                    "客服專線 : (02)5562-9111",
                    "客服信箱 : service@pponline.com.tw",
                    "官方LINE : <a href='https://line.me/R/ti/p/%40sub9431m'>點擊前往</a>",
                    "FB粉專 : <a href='https://www.facebook.com/pponline888'>點擊前往粉絲專頁</a>",
                    "豬豬在線官網 : <a href='https://www.pponline.com.tw'>點擊前往官方網站</a>"
                ];
                $ctx2 = [
                    "我們已於 ". date("m") . "月".date("d")."號"." 將本期應返還之收益匯款給您，",
                    "您可以至豬豬在線會員專區「我的帳戶」並點擊「我的帳本」查詢相關資訊，感謝您的認購。"
                ];
                $content = '';
                foreach ($ctx2 as $v){
                    $content .= "<p>".$v."</p>";
                }
                $this->send_inside_mail_for_log($user->user_id, $title, $content);//站內信
                // $this->send_template($user->email,$title,$ctx);
                $this->send_template($user->email,$title,$ctx);
                $this->saveInbox($user->user_id,$title,$ctx);
            }
            
        } catch (\Throwable $th) {
            return false;
            //throw $th;
        }
    }

    /**
     * 會員驗證通過信
     *
     * @param  mixed $user_id
     * @return void
     */
    public function pp_member_review($user_id)
    {
        try {
            $user = User::find($user_id);
            // if($user->is_receive_letter == 1 || $user->is_receive_letter == '開啟'){

                $title = '豬豬在線審核通過通知';
                $ctx = [
                    "親愛的". $user->user_name ."會員，您好",
                    "您的個人真實資訊已審核通過，請您繼續完成「銀行帳戶」，即可開始體驗債權投資的魅力。",
                    "<br>",
                    "--",
                    "<span style='font-weight:bold;'>亞太普惠金融科技股份有限公司 / 信任豬股份有限公司</span>",
                    "客服專線 : (02)5562-9111",
                    "客服信箱 : service@pponline.com.tw",
                    "官方LINE : <a href='https://line.me/R/ti/p/%40sub9431m'>點擊前往</a>",
                    "FB粉專 : <a href='https://www.facebook.com/pponline888'>點擊前往粉絲專頁</a>",
                    "豬豬在線官網 : <a href='https://www.pponline.com.tw'>點擊前往官方網站</a>"
                ];
                $ctx2 = [
                    "您的個人真實資訊已審核通過，請您繼續完成「銀行帳戶」，即可開始體驗債權投資的魅力。"
                ];
                $content = '';
                foreach ($ctx2 as $v){
                    $content .= "<p>".$v."</p>";
                }
                $this->send_inside_mail_for_log($user->user_id, $title, $content);//站內信
                $this->send_template($user->email,$title,$ctx);
                $this->saveInbox($user->user_id,$title,$ctx);
            // }
            
        } catch (\Throwable $th) {
            return false;
            //throw $th;
        }
    }

    /**
     * 週週投申請通知信(to管理員)
     *
     * @param  mixed $user_id
     * @return void
     */
    public function pp_weekly_review($user_name)
    {
        try {
            $adminUserArray = UsersRoles::select('user_id')->where('role_id',2)->get();
            foreach ($adminUserArray as $key => $value) {
                if($value->user_id != 1483){
                    $user = User::find($value->user_id);
                    if (isset($user->email)) {

                        $admin_name = (isset($user->user_name))? $user->user_name : '';
                        
                        $title = '使用者開啟「週週投」審核提交通知';
                        $ctx = ['親愛的系統管理員',
                                '會員'.$user_name.'先生/女士，已申請系統自動「週週投」功能，請速至系統審核。'
                                ];
    
                        $mailTo = [$user];
                        foreach ($mailTo as $v) {
                            $this->send_template($v->email,$title,$ctx);
                            $this->saveInbox($v->user_id,$title,$ctx);
                        }
                    }
                }
            }
            
        } catch (\Throwable $th) {
            return false;
            //throw $th;
        }
    }

     /**
     * 週週投申請通過信(to申請者)
     *
     * @param  mixed $user_id
     * @return void
     */
    public function pp_weekly_agree($user_id)
    {
        try {
            $user = User::find($user_id);
            if($user->is_receive_letter == 1 || $user->is_receive_letter == '開啟'){

                $title = '豬豬在線「週週投」審核通知';
                $ctx = [
                    "親愛的". $user->user_name ."會員，您好",
                    "已收到您申請GoldenPigggyBank的「週週投」功能，本週的預購期間系統會自動幫您進行債權投標配案，後續會與您做確認通知。",
                    "若有任何問題，可加入<a href='https://line.me/R/ti/p/%40sub9431m'>官方LINE</a>，客服人員將協助您處理。",
                    "<br>",
                    "--",
                    "<span style='font-weight:bold;'>亞太普惠金融科技股份有限公司 / 信任豬股份有限公司</span>",
                    "客服專線 : (02)5562-9111",
                    "客服信箱 : service@pponline.com.tw",
                    "官方LINE : <a href='https://line.me/R/ti/p/%40sub9431m'>點擊前往</a>",
                    "FB粉專 : <a href='https://www.facebook.com/pponline888'>點擊前往粉絲專頁</a>",
                    "豬豬在線官網 : <a href='https://www.pponline.com.tw'>點擊前往官方網站</a>"
                ];
                $ctx2 = [
                    "已收到您申請GoldenPigggyBank的「週週投」功能，本週的預購期間系統會自動幫您進行債權投標配案，後續會與您做確認通知。",
                    "若有任何問題，可加入<a href='https://line.me/R/ti/p/%40sub9431m'>官方LINE</a>，客服人員將協助您處理。"
                ];
                $content = '';
                foreach ($ctx2 as $v){
                    $content .= "<p>".$v."</p>";
                }
                $this->send_inside_mail_for_log($user->user_id, $title, $content);//站內信
                $this->send_template($user->email,$title,$ctx);
                $this->saveInbox($user->user_id,$title,$ctx);
            }
            
        } catch (\Throwable $th) {
            return false;
            //throw $th;
        }
    }

     /**
     * 週週投申請駁回信(to申請者)
     *
     * @param  mixed $user_id
     * @return void
     */
    public function pp_weekly_reject($user_id)
    {
        try {
            $user = User::find($user_id);
            if($user->is_receive_letter == 1 || $user->is_receive_letter == '開啟'){

                $title = '豬豬在線「週週投」審核駁回通知';
                $ctx = [
                    "親愛的". $user->user_name ."會員，您好",
                    "已收到您申請GoldenPiggyBank的「週週投」功能，因您提交的訊息有誤，我們將無法為您開通此功能。",
                    "請加入<a href='https://line.me/R/ti/p/%40sub9431m'>官方LINE</a>，客服人員將協助您處理。",
                    "<br>",
                    "--",
                    "<span style='font-weight:bold;'>亞太普惠金融科技股份有限公司 / 信任豬股份有限公司</span>",
                    "客服專線 : (02)5562-9111",
                    "客服信箱 : service@pponline.com.tw",
                    "官方LINE : <a href='https://line.me/R/ti/p/%40sub9431m'>點擊前往</a>",
                    "FB粉專 : <a href='https://www.facebook.com/pponline888'>點擊前往粉絲專頁</a>",
                    "豬豬在線官網 : <a href='https://www.pponline.com.tw'>點擊前往官方網站</a>"
                ];
                $ctx2 = [
                    "已收到您申請GoldenPiggyBank的「週週投」功能，因您提交的訊息有誤，我們將無法為您開通此功能。",
                    "請加入<a href='https://line.me/R/ti/p/%40sub9431m'>官方LINE</a>，客服人員將協助您處理。"
                ];
                $content = '';
                foreach ($ctx2 as $v){
                    $content .= "<p>".$v."</p>";
                }
                $this->send_inside_mail_for_log($user->user_id, $title, $content);//站內信
                $this->send_template($user->email,$title,$ctx);
                $this->saveInbox($user->user_id,$title,$ctx);
            }
            
        } catch (\Throwable $th) {
            return false;
            //throw $th;
        }
    }

    /**
     * 週週投申請取消信(to申請者)
     *
     * @param  mixed $user_id
     * @return void
     */
    public function pp_weekly_cancel($user_id)
    {
        try {
            $user = User::find($user_id);
            if($user->is_receive_letter == 1 || $user->is_receive_letter == '開啟'){

                $title = '豬豬在線「週週投」功能取消通知';
                $ctx = [
                    "親愛的". $user->user_name ."會員，您好",
                    "已收到您申請取消GoldenPiggyBank的「週週投」功能。後續您可以登入平台自行選購債權。",
                    "若有任何問題，可加入<a href='https://line.me/R/ti/p/%40sub9431m'>官方LINE</a>，客服人員將協助您處理。",
                    "<br>",
                    "--",
                    "<span style='font-weight:bold;'>亞太普惠金融科技股份有限公司 / 信任豬股份有限公司</span>",
                    "客服專線 : (02)5562-9111",
                    "客服信箱 : service@pponline.com.tw",
                    "官方LINE : <a href='https://line.me/R/ti/p/%40sub9431m'>點擊前往</a>",
                    "FB粉專 : <a href='https://www.facebook.com/pponline888'>點擊前往粉絲專頁</a>",
                    "豬豬在線官網 : <a href='https://www.pponline.com.tw'>點擊前往官方網站</a>"
                ];
                $ctx2 = [
                    "已收到您申請取消GoldenPiggyBank的「週週投」功能。後續您可以登入平台自行選購債權。",
                    "若有任何問題，可加入<a href='https://line.me/R/ti/p/%40sub9431m'>官方LINE</a>，客服人員將協助您處理。"
                ];
                $content = '';
                foreach ($ctx2 as $v){
                    $content .= "<p>".$v."</p>";
                }
                $this->send_inside_mail_for_log($user->user_id, $title, $content);//站內信
                $this->send_template($user->email,$title,$ctx);
                $this->saveInbox($user->user_id,$title,$ctx);
            }
            
        } catch (\Throwable $th) {
            return false;
            //throw $th;
        }
    }

    //寄站外信log模板
    public function send_outside_mail_for_log($user_id,$title,$ctx)
    {
        // ini_set('date.timezone','Asia/Taipei');
        $nt = date("Y-m-d H:i:s");

        if($user_id <= 0){
            $class_type = 0;
        }else{
            $class_type = 1;
        }

        DB::insert('INSERT INTO `schedule_letters`( `type_id`, `title`, `content`, `created_at`, `update_at`, `is_run`, `run_user`, `class_type`) VALUES (?, ?, ?, ?, ?,0,1,?)',[$user_id,$title,$ctx,$nt,$nt,$class_type]);
        
    }
    //寄站內信log模板
    public function send_inside_mail_for_log($user_id,$title,$ctx)
    {
        // ini_set('date.timezone','Asia/Taipei');
        $nt = date("Y-m-d H:i:s");

        DB::insert('INSERT INTO `internal_letters`(`user_id`, `title`, `content`, `deleted_at`, `created_at`, `updated_at`, `user_ids`, `isDisplay`) VALUES (1,? , ?, NULL ,?, ?, ? , 1)',[$title,$ctx,$nt,$nt,$user_id]);
        
    }

    // public function

    public function saveInbox($user_id,$title,$ctx)
    {
        $InboxLetters = new InboxLetters;
        $InboxLetters->user_id = $user_id;
        $InboxLetters->title = $title;
        $content = '';
        foreach($ctx as $v){
            $content .= $v;
        }
        $InboxLetters->content = $content;
        $InboxLetters->created_at = date('Y-m-d H:i:s');
        $InboxLetters->updated_at = date('Y-m-d H:i:s');
        $InboxLetters->save();
    }

    public function send($title,$ctx,$email,$file_path=false)
    {
        $from = false;
        if($file_path == false){
            Mail::to($email)->send(new SampleMail($ctx, $from, $title));
        }else{
            Mail::to($email)->send(new SampleMail($ctx, $from, $title,$file_path));
        }
    }

    public function send_template($email,$subj,$ctx){
        $headers = array(
            'Content-Type: application/json',
            'Accept: application/json',
            'x-api-key:'. env('MAIL_API_KEY')
        );
        
        
        $cont = `<!DOCTYPE html>
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
                        $cont.= "<p>".$v."</p>";
                    }
            $cont.=`</body>
                </html>
                `;//內文
        
                $data = array(
                    "subject" => $subj,
                    "fromName"=> env('MAIL_FROM_NAME'),
                    "fromAddress"=> env('MAIL_FROM_ADDRESS'),
                    "content" => $cont,
                    "recipients" => [array(
                        "name" => $email,
                        "address"=> $email
                    )],
                );
                // print_r(json_encode($data));
        
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL,env('MAIL_URL'));
        curl_setopt ($ch, CURLOPT_POST, true);
        curl_setopt ($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        // return($response);
    }
    
}
