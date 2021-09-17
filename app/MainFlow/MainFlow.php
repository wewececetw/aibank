<?php
namespace App\MainFlow;
use App\MainFlow\ClaimStateLogic;
use App\Claim;

class MainFlow extends Main{

    //檢查 此次投標 投注金額 是否 超過債權上限
    public function checkTenderAmountOverClaim($claim_id,$this_tender_amount)
    {
        try {
            $claimAmount = $this->getClaimMaxAndTotalAmount($claim_id);

            if(($claimAmount['total'] + $this_tender_amount) <= (int)$claimAmount['max']){
                return true;
            }else{
                return false;
            }
        } catch (\Throwable $th) {
            dd($th);
        }

    }

    //檢查 Claim state != 2
    public function checkClaimStateNotTwo($claim_id)
    {
        $claimState = (new ClaimStateLogic($claim_id))->state;

        if((int)$claimState != 2){
            return true;
        }else{
            return false;
        }
    }


    //跑檢查債權狀態轉換流程   if狀態有變化將 遞迴檢查 直到狀態相同
    public function runCheckClaimChange($claim_id)
    {
        $claimOldState = Claim::find($claim_id)->getOriginal('claim_state');

        $claimCheck = new ClaimStateLogic($claim_id);
        $claimCheck->check();

        $claimNewState = Claim::find($claim_id)->getOriginal('claim_state');

        if($claimOldState != $claimNewState){
            $this->runCheckClaimChange($claim_id);
        }
    }

}
