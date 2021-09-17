<?php
namespace App\MainFlow\ClaimState;

use App\Claim;
use App\MainFlow\Main;
//寄簡訊
use App\Sms\sendSMS;
use App\Mail\MailTo;


class State0 extends Main
{
    public $claim;
    public $trig;

    public function __construct($claim)
    {
        $this->claim = $claim;
        $this->trig = false;
    }

    public function init()
    {
        try {
            //now < 開標日
            $this->checkTime();

            if ($this->trig) {
                $this->checkIsPre();
            }

            if ($this->trig) {
                $this->checkPreTenderAmount();
            }

            if ($this->trig) {
                //發簡訊
                //20200303 經指示先不用及時發送
                // $this->send0To2SMS($this->claim->claim_id);
                //轉為state 2
                // $this->changeToState2($this->claim->claim_id);
            }
            if ($this->trig) {
                // return true;
            } else {
                // return false;
            }
        } catch (\Throwable $th) {
            $this->logg($this->claim->claim_id,0,$th,true);
            return false;
        }

    }

    /**
     * 檢查現在時間小於開鰾日
     * @param datetime claim.start_collecting_at 開標日
     */
    public function checkTime()
    {
        if (isset($this->claim->start_collecting_at)) {
            $now = date("Y-m-d H:i:s");
            if ($now < $this->claim->start_collecting_at) {
                $this->trig = true;
            } else {
                //超過開標日 轉狀態
                $this->claim->claim_state = 1;
                $this->claim->save();
                // $m = new MailTo;
                // $m->claim_collecting_remind();
            }
        }
    }
    /**
     * 預投標檢查
     * 檢查 is_pre_invest == 1
     * @param int claim.is_pre_invest 預先投標開關
     * @return boolean $this->trig
     */
    public function checkIsPre()
    {
        if ($this->claim->is_pre_invest == 1) {
            $this->trig = true;
        } else {
            $this->trig = false;
        }
    }

    /**
     * 檢查預先投標金額等於目前投標金額
     * 且自動結標=1
     * @param int claim.staging_amount 預先投標上限金額
     * @param int claim.is_auto_closed 自動結標開關
     * @var int total claim下的Tenders投標總額
     * @var bool needChange 函式中的轉狀態開關
     */
    public function checkPreTenderAmount()
    {
        $total = (int) $this->getClaimTenderTotalAmount($this->claim->claim_id);
        $closedAmountMax = (int) $this->claim->staging_amount;

        $needChange = false;

        if ($total == $closedAmountMax) {
            // dd('要改', $total , $closedAmountMax );
            $needChange = true;
        }
        // else {
        //     dd('不再範圍內', $total , $closedAmountMax );
        // }

        if ($needChange && $this->claim->is_auto_closed == 1) {
            $this->trig = true;
        } else {
            $this->trig = false;
        }
    }

    // //檢查 預先投標金額 is_auto_closed = 1
    // public function checkPreTenderAmount_BK_with_auto_close_threshold()
    // {
    //     $total = (int) $this->getClaimTenderTotalAmount($this->claim->claim_id);
    //     $closedAmountMin = (int) $this->claim->staging_amount * ((int) $this->claim->auto_close_threshold / 100);
    //     $closedAmountMax = (int) $this->claim->staging_amount;

    //     $needChange = false;

    //     if ($closedAmountMin <= $total && $total <= $closedAmountMax) {
    //         // dd('要改',$closedAmountMin , $total , $closedAmountMax );
    //         $needChange = true;
    //     } else {
    //         // dd('不再範圍內',$closedAmountMin , $total , $closedAmountMax );
    //     }

    //     if ($needChange && $this->claim->is_auto_closed == 1) {
    //         $this->trig = true;
    //     } else {
    //         $this->trig = false;
    //     }
    // }

        /**
     * Claim轉狀態2時發送簡訊的Funciton
     */
    public function send0To2SMS($claim_id)
    {
        $sendDay = config('sms.MainFlow.preDay');
        $sendHour = config('sms.MainFlow.preHour');
        $sendMin = config('sms.MainFlow.preMin');
        $now = date('Y-m-d H:i:s');
        $nextDay = date('Y-m-d',strtotime($sendDay,strtotime($now)));
        $preSendHours = date('YmdHis',strtotime($sendHour,strtotime($nextDay)));
        $preSendMin = date('YmdHis',strtotime($sendMin,strtotime($preSendHours)));

        //nextDay = 隔天早上9點
        //取得tenders id
        $tendersId = $this->getAllTendersIdArray($claim_id);
        $phones = $this->getTendersPhone($tendersId);
        $config = [];

        $ctx = config('sms.MainFlow.State0To2Ctx');
        //判斷預約發送
        $preSendTrig = config('sms.MainFlow.preSendTrig');
        if(!$preSendTrig){
            foreach ($phones as $phone) {
                $ar = [
                    'phone'=> $phone,
                    'ctx' => $ctx,

                ];
                array_push($config,$ar);
            }
        }else{
            foreach ($phones as $phone) {
                $ar = [
                    'phone'=> $phone,
                    'ctx' => $ctx,
                    'bookTime' => $preSendMin
                ];
                array_push($config,$ar);
            }
        }

        $sms = (new sendSMS($config))->run();
    }
}
