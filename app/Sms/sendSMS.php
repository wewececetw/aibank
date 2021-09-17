<?php
namespace App\Sms;
use Illuminate\Support\Facades\Log;
class sendSMS{
    /**
     * @var string url = 簡訊API URL (三竹簡訊)
     * @var string username = 簡訊UserName(帳號)
     * @var string password = 簡訊API password(密碼)
     */
    public $url;
    public $username;
    public $password;
    public $config;
    public $trig;
    public $allSuccess;
    public $timeZone;
    /**
     * sendSMS建構子
     *  config[0]['phone'] 電話，必填
     *  config[0]['ctx] 內容，必填
     *  config[0]['bookTime'] datetime '預定發送時間'，選填，有此值且大於系統時間10分鐘，才會預約發送
     *
     * @param array config = 設定檔，二維陣列 config[0] 為第幾筆發送資料
     */
    public function __construct($config)
    {
        $this->url = config('sms.baseUrl');
        $this->username = 'username='.config('sms.username');
        $this->password = 'password='.config('sms.password');
        $this->encoding = 'encoding='.config('sms.encoding');
        $this->timeZone = config('sms.timeZone');
        $this->config = $config;
        $this->allSuccess = true;
        $this->trig = $this->checkType();
        if(!$this->trig){
            return 'send sms fail，input type format is not expected';
        }
    }


    public function checkType()
    {
        $t = true;
        if(gettype($this->config) != 'array'){
            return false;
        }else{
            foreach ($this->config as $value) {
                if(gettype($value)!= 'array'){
                    return false;
                }
            }
        }
        return $t;
    }

    public function run()
    {
        $allSuccess = true;
        foreach ($this->config as $ar) {
            try {
                if(isset($ar['bookTime'])){
                    //有預約發送
                    $s = $this->sendBookTime($ar['phone'],$ar['ctx'],$ar['bookTime']);
                    if(!$s){
                        $allSuccess = false;
                    }
                }else{
                    //立即發送
                    $s = $this->sendNow($ar['phone'],$ar['ctx']);
                    if(!$s){
                        $allSuccess = false;
                    }
                }
            } catch (\Throwable $th) {
                $allSuccess = false;
            }

        }
        return $allSuccess;
    }

    /**
     * 立即發送
     * @param string phone 號碼
     * @param string ctx 內容
     */
    public function sendNow($phone,$ctx)
    {
        try {
            $dstaddr = 'dstaddr='.$phone;
            $smbody =  'smbody='. urlencode($ctx);
            $url = $this->url.$this->username.'&'.$this->password.'&'.$dstaddr.'&'.$smbody.'&'. $this->encoding;
            file_get_contents($url);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * 帶有時間的發送
     * @param string phone 號碼
     * @param string ctx 內容
     * @param dateTime bookTime 內容
     */
    public function sendBookTime($phone,$ctx,$bookTime)
    {
        try {
            // $bookTime = strtotime($bookTime);
            // $bookTime = strtotime($this->timeZone,$bookTime);
            // $bookTime = date('YmdHis',$bookTime);
            $dlvtime = 'dlvtime='.$bookTime ;

            $dstaddr = 'dstaddr='.$phone;
            $smbody =  'smbody='. urlencode($ctx);
            $url = $this->url.$this->username.'&'.$this->password.'&'.$dstaddr.'&'.$smbody.'&'. $this->encoding.'&'.$dlvtime;
            file_get_contents($url);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
