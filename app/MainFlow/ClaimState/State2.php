<?php
namespace App\MainFlow\ClaimState;
use App\MainFlow\Main;
use App\MainFlow\ClaimPdf;

use App\Claim;
use App\Tenders;
use DB;
class State2 extends Main{
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

        try {
            DB::beginTransaction();
            $this->checkTime();

            if($this->setBidFaild){
                $this->setBidFaild($this->claim->claim_id);
                DB::commit();
                return false;
            }

            if($this->trig){
                $this->tendersAllPay();

            }
            if($this->trig){
                $this->trig = false;
                $this->trig = $this->setRepayment();
                
            }

            if($this->trig){
                $this->trig = $this->writeDataToTenderRepayment($this->claim->claim_id);
                
            }
            if($this->trig){
                $this->trig = $this->getPusherDetailData($this->claim->claim_id);
                
            }
            // 20200316 當債權轉為繳息還款時 儲存所有PDF
            if($this->trig){
                $t = true;
                $tenders = Tenders::select('tender_documents_id','user_id','claim_certificate_number','amount')->where('claim_id',$this->claim->claim_id)->get()->toArray();
                foreach ($tenders as $tender) {
                    $data['user_id'] = $tender['user_id'];
                    $data['claim_id'] = $this->claim->claim_id;
                    $data['amount'] = $tender['amount'];
                    $data['tender_documents_id'] = $tender['tender_documents_id'];
                    $data['claim_certificate_number'] = $tender['claim_certificate_number'];
                    $pdf_data = '';
                    foreach($data as $k=>$v){
                        $pdf_data .= "&".$k."=".$v;
                    }
                    $pdf_data =  ltrim($pdf_data,'&');

                    $count = DB::select("select * from pdf_log Where tender_documents_id  = ?",[$tender['tender_documents_id']]);

                    if(count($count) == 0){

                        DB::insert("insert into pdf_log (pdf_reason, pdf_data, 	tender_documents_id, create_date, update_date, is_run) values (?, ?, ?, ?, ?, ?)", ["change_claim_state_to_4", $pdf_data,$tender['tender_documents_id'],date("Y-m-d H:i:s"),date("Y-m-d H:i:s"),0]);

                    }
                }
                // foreach($tenders as $tender){
                //     $claimPdf = new ClaimPdf($tender['user_id'],$this->claim->claim_id,$tender['amount']);
                //     $saveSuccess = $claimPdf->saveClaimTendersPdf($tender['tender_documents_id'],$tender['claim_certificate_number']);
                //     if(!$saveSuccess){
                //         $t = false;
                //     }
                // }

                $this->trig = $t;
                
            }

            if( $this->trig){
                DB::commit();
            }else{
                DB::rollback();
            }
            return false;
        } catch (\Throwable $th) {
            DB::rollback();
            $this->logg($this->claim->claim_id,2,$th,true);
            return false;

        }

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
