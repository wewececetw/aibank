<?php
namespace App\MainFlow\ClaimState;
use App\MainFlow\Main;
use App\Claim;
use App\Tenders;
use App\TenderRepayments;
use DB;

class State4 extends Main{
    public $trig;
    public $claim;
    public $setBidFaild;
    public $repaymentHas1;
    public $allTenderId;
    public $repaymentHas1Ids;
    public function __construct($claim)
    {
        $this->trig = false;
        $this->setBidFaild = false;
        $this->claim = $claim;
        $this->repaymentHas1 = false;
        $this->allTenderId = $this->getAllTendersIdArray($this->claim->claim_id);
        $this->repaymentHas1Ids = [];
    }

    public function init()
    {
        try {
            DB::beginTransaction();
            $this->checkUnderRepaymentIsState2();
            if($this->trig){
                //set 回收結案
                $this->changeToState5($this->claim->claim_id);
            }else{
                //檢查repayment state 有無 1
                $this->checkUnderRepaymentIsState1();
                if($this->repaymentHas1){
                    //如果repayment 有 state = 1
                    //檢查 state =1 的 且 last_contact_pp_time != 今天 取出 repayment_id
                    $emailRepaymentIds = $this->checkPPtime();
                    //寄信給PP人員
                    // SendEmailToPPRepaymentIds($emailRepaymentIds);
                    dd('寄信給PP人員',$emailRepaymentIds);
                }

            }
            DB::commit();
            return false;

        } catch (\Throwable $th) {
            DB::rollback();
            $this->logg($this->claim->claim_id,5,$th,true);
            return false;

        }

    }

    //檢查 state =1 的 且 last_contact_pp_time != 今天
    //目前沒做null判斷 如果 last_contact_pp_time = null 也會當作不等於今天 發送信件
    public function checkPPtime()
    {
        $needMailRepaymentIds = [];
        $today = date('Y-m-d');
        foreach ($this->repaymentHas1Ids as $id => $lastPPTime) {
            $lastPPTime = date('Y-m-d',strtotime($lastPPTime));
            if($lastPPTime != $today){
                array_push($needMailRepaymentIds,$id);
            }
        }
        return $needMailRepaymentIds;
    }
    //檢查Claim 底下的所有 tender_repayment = 2
    public function checkUnderRepaymentIsState2()
    {
        $this->trig = true;
        $this->trig = $this->checkAllRepaymentState($this->allTenderId,2);
    }

    //檢查底下repayment 有無 state =1 ，有的話將取出 obj ['id']=last_contact_pp_time
    public function checkUnderRepaymentIsState1()
    {
        $this->repaymentHas1 = false;

        foreach ($this->allTenderId as $tenderId) {
            $repayment = TenderRepayments::where('tender_documents_id',$tenderId)->get();
            foreach ($repayment as $key => $value) {
                $state = $value->tender_repayment_state;
                if((int)$state == 1){
                    $this->repaymentHas1 = true;
                    $this->repaymentHas1Ids[$value->tender_repayment_id] = $value->last_contact_pp_time ;
                }
            }

        }

    }


    public function checkAllRepaymentState($tenderIdArray,$checkState)
    {
        $trigres = true;
        foreach ($tenderIdArray as $tenderId) {
            $repayment = TenderRepayments::where('tender_documents_id',$tenderId)->get();
            foreach ($repayment as $key => $value) {
                $state = $value->tender_repayment_state;
                if((int)$state != (int)$checkState){
                    $trigres = false;
                }
            }

        }
        return $trigres;
    }

}
