<?php
namespace App\MainFlow\ClaimState;

use App\Claim;
use App\MainFlow\Main;
//寄簡訊
use App\Sms\sendSMS;

/**
 * @var bool setBidFaild 流標開關
 */
class State1 extends Main
{
    public $trig;
    public $claim;
    public $estimated_close_date;
    public $start_collecting_at;
    public $setBidFaild;
    public $autoCloseToState2;

    public function __construct($claim)
    {
        $this->trig = false;
        $this->claim = $claim;
        $this->setBidFaild = false;
        $this->autoCloseToState2 = false;
    }

    public function init()
    {
        try {
            if (!isset($this->claim->start_collecting_at) || !isset($this->claim->estimated_close_date)) {

                $this->logg($this->claim->claim_id, 1, 'start_collecting_at || estimated_close_date 無資料', true);
                //甚麼都沒做 ， 會直接跑去流標
                // abort(555, 'claim_id= ' . $this->claim->claim_id . ' 資料不完整 start_collecting_at estimated_close_date');
                // exit;
                return false;
            } else {
                $this->start_collecting_at = $this->claim->start_collecting_at;
                $this->estimated_close_date = $this->claim->estimated_close_date;
            }

            //  開標日 <= now < 預計截標日
            $this->checkTime();

            if ($this->setBidFaild) {
                //流標
                $this->setBidFaild($this->claim->claim_id);
            }
            if ($this->autoCloseToState2) {
                //發簡訊
                //20200303 經指示先不用及時發送
                // $this->send1To2SMS($this->claim->claim_id);
                //設定 結標
                $this->changeToState2($this->claim->claim_id);
            }

            if ($this->trig) {
                // 確認投標金額是否有滿足債權
                $this->checkTendersAmountIsFull();
            }


            if ($this->trig) {
                //檢查Claim is_auto_closed = 1
                $this->checkIsAutoClosed();
            }
            if ($this->trig) {
                //發簡訊
                //20200303 經指示先不用及時發送
                // $this->send1To2SMS($this->claim->claim_id);
                //設定 結標
                // $this->changeToState2($this->claim->claim_id);
            }
            return false;
        } catch (\Throwable $th) {
            $this->logg($this->claim->claim_id, 1, $th, true);
            return false;
        }

    }

    /**
     * 開標日 <= 現在時間 < 預計結標日
     */
    public function checkTime()
    {
        $now = date("Y-m-d H:i:s");
        if (($this->start_collecting_at <= $now) && ($now < $this->estimated_close_date)) {
            $this->trig = true;
        } else if ($now >= $this->estimated_close_date) {
            $this->trig = false;
            $this->checkAmountAutoCloseThreshold();
        } else {
            $this->trig = false;
        }
    }

    // //確認投標總金額有滿足債權 (有 auto_close_threshold)
    // public function checkTendersAmountIsFull()
    // {
    //     $totalAmount = $this->getClaimTenderStateInTotalAmount($this->claim->claim_id);

    //     $closedAmountMin = (int) $this->claim->staging_amount * ((int) $this->claim->auto_close_threshold / 100);
    //     $closedAmountMax = (int) $this->claim->staging_amount;

    //     if ($closedAmountMin <= $totalAmount && $totalAmount <= $closedAmountMax) {
    //         $this->trig = true;
    //     } else {
    //         $this->trig = false;
    //     }
    // }
    /**
     * 確認投標總金額有滿足債權
     *
    */
    public function checkTendersAmountIsFull()
    {
        $totalAmount = $this->getClaimTenderStateInTotalAmount($this->claim->claim_id);
        $closedAmountMax = (int) $this->claim->staging_amount;
        if ($totalAmount == $closedAmountMax) {
            $this->trig = true;
        } else {
            $this->trig = false;
        }
    }

    //檢查Claim is_auto_closed = 1
    public function checkIsAutoClosed()
    {
        if ($this->claim->is_auto_closed != 1) {
            $this->trig = false;
        } else {
            $this->trig = true;
        }
    }

    /**
     * 檢查不符合 開標日 <= 現在 < 預計結標日 且 現在 >= 預計結標日
     * 時是否要流標或轉狀態
     *
     */
    public function checkAmountAutoCloseThreshold()
    {
        $totalAmount = $this->getClaimTenderStateInTotalAmount($this->claim->claim_id);
        $closedAmountMin = (int) $this->claim->staging_amount * ((int) $this->claim->auto_close_threshold / 100);
        if ((int) $totalAmount >= (int) $closedAmountMin) {
            // if ($this->claim->is_auto_closed == 1) {
                $this->autoCloseToState2 = true;
            // } else {
                // $this->setBidFaild = true;
            // }
        } else {
            $this->setBidFaild = true;
        }
    }

    /**
     * Claim轉狀態2時發送簡訊的Funciton
     */
    public function send1To2SMS($claim_id)
    {
        $sendDay = config('sms.MainFlow.preDay');
        $sendHour = config('sms.MainFlow.preHour');
        $sendMin = config('sms.MainFlow.preMin');
        $now = date('Y-m-d H:i:s');
        $nextDay = date('Y-m-d', strtotime($sendDay, strtotime($now)));
        $preSendHours = date('YmdHis', strtotime($sendHour, strtotime($nextDay)));
        $preSendMin = date('YmdHis', strtotime($sendMin, strtotime($preSendHours)));

        //nextDay = 隔天早上9點
        //取得tenders id
        $tendersId = $this->getAllTendersIdArray($claim_id);
        $phones = $this->getTendersPhone($tendersId);
        $config = [];

        $ctx = config('sms.MainFlow.State1To2Ctx');
        //判斷預約發送
        $preSendTrig = config('sms.MainFlow.preSendTrig');
        if (!$preSendTrig) {
            foreach ($phones as $phone) {
                $ar = [
                    'phone' => $phone,
                    'ctx' => $ctx,
                ];
                array_push($config, $ar);
            }
        } else {
            foreach ($phones as $phone) {
                $ar = [
                    'phone' => $phone,
                    'ctx' => $ctx,
                    'bookTime' => $preSendMin,
                ];
                array_push($config, $ar);
            }
        }

        $sms = (new sendSMS($config))->run();
    }

}
