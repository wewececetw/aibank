<?php
namespace App\MainFlow\ClaimState;
use App\MainFlow\Main;
use App\MainFlow\ClaimPdf;

use App\Claim;
use App\Tenders;
use DB;
class CreatePdf extends Main{
    public $trig;
    public function __construct()
    {
        $this->trig = false;
    }

    public function init()
    {

        try {


                $data = DB::table("pdf_log")
                    ->where("is_run",0)
                    ->first();

                if(!empty($data)){

                    parse_str($data->pdf_data,$row_data);
                
                    $claimPdf = new ClaimPdf($row_data['user_id'],$row_data['claim_id'],$row_data['amount']);
                    $saveSuccess = $claimPdf->saveClaimTendersPdf($row_data['tender_documents_id'],$row_data['claim_certificate_number']);
                    if(!$saveSuccess){
                        $t = false;
                    }
    
                    DB::update("update pdf_log set is_run = 1 where pdf_id = ?",[$data->pdf_id]);
                    $t = true;
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
            $this->logg($row_data['claim_id'],2,$th,true);
            return false;

        }

    }

}
