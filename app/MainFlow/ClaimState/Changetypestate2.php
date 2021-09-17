<?php
namespace App\MainFlow\ClaimState;
use App\MainFlow\Main;
use App\MainFlow\ClaimPdf;

use App\Claim;
use App\Tenders;
use DB;
class Changetypestate2 extends Main{
    public $trig;
    public $claim;
    public $setBidFaild;
    public function __construct($claim)
    {
        $this->trig = false;
        $this->setBidFaild = false;
        $this->claim = $claim;
    }

    public function init()
    {

        //try {
            DB::beginTransaction();
            $this->checkTime();
            echo 0;
            if($this->setBidFaild){
                $this->setBidFaild($this->claim->claim_id);
                DB::commit();
                return false;
                echo 1;
            }

            if($this->trig){
                $this->tendersAllPay();
                echo 2;
            }
            if($this->trig){
                $this->trig = false;
                $this->trig = $this->setRepayment();
                echo 3;
            }

            if($this->trig){
                $this->trig = $this->writeDataToTenderRepayment($this->claim->claim_id);
                echo 4;
            }
            if($this->trig){
                $this->trig = $this->getPusherDetailData($this->claim->claim_id);
                echo 5;
            }
            // 20200316 當債權轉為繳息還款時 儲存所有PDF
            if($this->trig){
                $t = true;
                // $tenders = Tenders::select('tender_documents_id','user_id','claim_certificate_number','amount')->where('claim_id',$this->claim->claim_id)->get()->toArray();
                // foreach($tenders as $tender){
                //     $claimPdf = new ClaimPdf($tender['user_id'],$this->claim->claim_id,$tender['amount']);
                //     $saveSuccess = $claimPdf->saveClaimTendersPdf($tender['tender_documents_id'],$tender['claim_certificate_number']);
                //     if(!$saveSuccess){
                //         $t = false;
                //     }
                // }

                $this->trig = $t;
                echo 6;
            }

            if( $this->trig){
                DB::commit();
            }else{
                DB::rollback();
            }
        //     return false;
        // } catch (\Throwable $th) {
        //     DB::rollback();
        //     $this->logg($this->claim->claim_id,2,$th,true);
        //     return false;

        // }

    }

    public function checkTime()
    {
        //預計結標日 <= now < 結標後最後繳款期限
        $closed_at = $this->claim->closed_at;
        $now = date('Y-m-d H:i:s');
        $paymentFinalDeadLine = $this->claim->payment_final_deadline;

        if(($closed_at <= $now) && ($now < $paymentFinalDeadLine)){
            $this->trig = true;
        }else if($now >= $paymentFinalDeadLine){
            $this->trig = false;
            $this->setBidFaild = true;
        }else{
            // dd('Claim狀態與時間不對吧');
            $this->logg($this->claim->claim_id,2,'closed_at='.$closed_at.'|now='.$now.'|paymentFinalDeadLine='.$paymentFinalDeadLine.' || Claim狀態與時間不對吧',true);
            $this->trig = false;
        }
    }

    //確認所有人都繳款了
    public function tendersAllPay()
    {
        $this->trig = true;
        $tenders = $this->getAllTendersIdArray($this->claim->claim_id);
        foreach ($tenders as $tenderid) {
            try {
                $state = Tenders::find($tenderid)->getOriginal('tender_document_state');
            } catch (\Throwable $th) {
                $state = Tenders::find($tenderid)->tender_document_state;
            }
            if((int)$state != 1){
                $this->trig = false;
            }
        }
    }
    //設定繳息還款 state =4 並 將 tender 壓成2
    public function setRepayment()
    {
        try {
            $tendersId = $this->getAllTendersIdArray($this->claim->claim_id);
            foreach ($tendersId as $tenderId) {
                $tender = Tenders::find($tenderId);
                $tender->tender_document_state = 2;
                $tender->save();
            }
            $this->claim->claim_state = 4;
            $this->claim->save();
            return true;
        } catch (\Throwable $th) {
            //throw $th;
            $this->logg($this->claim->claim_id,2,$th,true);
            return false;
        }

    }

}
