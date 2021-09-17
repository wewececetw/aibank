<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Log;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;

use App\CustomSettings;
use App\Tenders;
use App\TenderRepayments;
use App\Claim;
use App\User;
use PDF;

ini_set('memory_limit', '2048M');
class UserAccountController extends Controller
{

    public function account()
    {
        $check = CustomSettings::where('user_id', Auth::user()->user_id)->get();
        if (count($check) == 0 || Auth::user()->user_state != 1) {
            session()->flash('cannotGoHabit', '123');
            return redirect()->back();
        }else{
            $user_id = Auth::user()->user_id;
            $data['ispaid'] = Tenders::accountIsPaid(Auth::user()->user_id);
            $data['user'] = DB::table('users')->where('user_id', $user_id)->first();
            $data['invest_info'] = (new User)->countUserMoneyInfo($user_id);
            return view('Front_End.user_manage.account.myAccount', $data);
        }

    }

    public function account_unpay(){
        $user_id = Auth::user()->user_id;
        $data['ispaid'] = Tenders::accountUnPaid(Auth::user()->user_id);
        //$data['ispaid'] = DB::select("select * from tender_documents td,claims c where user_id ='".Auth::user()->user_id."' and td.claim_id = c.claim_id");
        $data['user'] = DB::table('users')->where('user_id',$user_id)->first();
        $data['invest_info'] = (new User)->countUserMoneyInfo($user_id);
        return view('Front_End.user_manage.account.myAccount_unpay',$data);
    }

    public function account_failure(){
         $user_id = Auth::user()->user_id;
         $data['ispaid'] = Tenders::accountFailure(Auth::user()->user_id);
         $data['user'] = DB::table('users')->where('user_id',$user_id)->first();
         $data['invest_info'] = (new User)->countUserMoneyInfo($user_id);
        return view('Front_End.user_manage.account.myAccount_failure',$data);
    }
    public function account_bill(){
        $user_id = Auth::user()->user_id;
        $data['invest_info'] = (new User)->countUserMoneyInfo($user_id);
        $data['user'] = DB::table('users')->where('user_id',$user_id)->first();
        if(!empty($_GET["get_money"])){
            if(!empty($_GET["bt"])){
                if($_GET["bt"]==2){
                    $data['i_bill'] = DB::select("select a.paid_at b_date,'0' b_out,management_fee b_out2,per_return_principal b_int_m,per_return_interest b_int_r,per_return_principal + per_return_interest - management_fee b_int_t,period_number b_cnt,claim_certificate_number b_title,target_repayment_date b_bank_date,'1' b_type , b.tender_documents_id b_id from tender_repayments a, tender_documents b where tender_document_state in (1,2,4) and buying_back_type = 0 and a.tender_documents_id = b.tender_documents_id and user_id = ? ",[$user_id]);
                }elseif($_GET["bt"]==3){
                    $data['i_bill'] = DB::select("select a.paid_at b_date,'0' b_out,management_fee b_out2,per_return_principal b_int_m,per_return_interest b_int_r,per_return_principal + per_return_interest - management_fee b_int_t,period_number b_cnt,claim_certificate_number b_title,target_repayment_date b_bank_date,'3' b_type , b.tender_documents_id b_id from tender_repayments a, tender_documents b where tender_document_state in (1,2,4) and buying_back_type = 1 and a.tender_documents_id = b.tender_documents_id and user_id = ? ",[$user_id]);
                }elseif($_GET["bt"]==4){
                    $data['i_bill'] = DB::select("select a.paid_at b_date,'0' b_out,management_fee b_out2,per_return_principal b_int_m,per_return_interest b_int_r,per_return_principal + per_return_interest - management_fee b_int_t,period_number b_cnt,claim_certificate_number b_title,target_repayment_date b_bank_date,'4' b_type , b.tender_documents_id b_id from tender_repayments a, tender_documents b where tender_document_state in (1,2,4) and buying_back_type = 2 and a.tender_documents_id = b.tender_documents_id and user_id = ? ",[$user_id]);
                }else{
                    $data['i_bill'] = DB::select("select a.paid_at b_date,'0' b_out,management_fee b_out2,per_return_principal b_int_m,per_return_interest b_int_r,per_return_principal + per_return_interest - management_fee b_int_t,period_number b_cnt,claim_certificate_number b_title,target_repayment_date b_bank_date,'1' b_type , b.tender_documents_id b_id from tender_repayments a, tender_documents b where tender_document_state in (9)");
                }
            }else{
                $data['i_bill'] = DB::select("select a.paid_at b_date,'0' b_out,management_fee b_out2,per_return_principal b_int_m,per_return_interest b_int_r,per_return_principal + per_return_interest - management_fee b_int_t,period_number b_cnt,claim_certificate_number b_title,target_repayment_date b_bank_date,'1' b_type , b.tender_documents_id b_id from tender_repayments a, tender_documents b where tender_document_state in (1,2,4) and buying_back_type = 0 and a.tender_documents_id = b.tender_documents_id and user_id = ? ",[$user_id]);
            }
        }else{
            if(!empty($_GET["bt"])){
                if($_GET["bt"]==2){
                    $data['i_bill'] = DB::select("select target_repayment_date b_date,'0' b_out,management_fee b_out2,per_return_principal b_int_m,per_return_interest b_int_r,per_return_principal + per_return_interest - management_fee b_int_t,period_number b_cnt,claim_certificate_number b_title,invoice_at b_bank_date,'1' b_type , b.tender_documents_id b_id from tender_repayments a, tender_documents b where tender_document_state in (1,2,4) and buying_back_type = 0 and a.tender_documents_id = b.tender_documents_id and user_id = ? ",[$user_id]);

                }elseif($_GET["bt"]==1){
                    $data['i_bill'] = DB::select("select paid_at b_date,amount b_out,'0' b_out2,'0' b_int_m,'0' b_int_r,'0' b_int_t,'' b_cnt,claim_certificate_number b_title,'' b_bank_date,'0' b_type , tender_documents_id b_id from tender_documents where tender_document_state in (1,2,4) and user_id = ? ",[$user_id]);
                }elseif($_GET["bt"]==3){
                    $data['i_bill'] = DB::select("select target_repayment_date b_date,'0' b_out,management_fee b_out2,per_return_principal b_int_m,per_return_interest b_int_r,per_return_principal + per_return_interest - management_fee b_int_t,period_number b_cnt,claim_certificate_number b_title,invoice_at b_bank_date,'3' b_type , b.tender_documents_id b_id from tender_repayments a, tender_documents b where tender_document_state in (1,2,4) and buying_back_type = 1 and a.tender_documents_id = b.tender_documents_id and user_id = ? ",[$user_id]);
                }elseif($_GET["bt"]==4){
                    $data['i_bill'] = DB::select("select target_repayment_date b_date,'0' b_out,management_fee b_out2,per_return_principal b_int_m,per_return_interest b_int_r,per_return_principal + per_return_interest - management_fee b_int_t,period_number b_cnt,claim_certificate_number b_title,invoice_at b_bank_date,'4' b_type , b.tender_documents_id b_id from tender_repayments a, tender_documents b where tender_document_state in (1,2,4) and buying_back_type = 2 and a.tender_documents_id = b.tender_documents_id and user_id = ? ",[$user_id]);
                }else{
                    $data['i_bill'] = DB::select("select a.paid_at b_date,'0' b_out,management_fee b_out2,per_return_principal b_int_m,per_return_interest b_int_r,per_return_principal + per_return_interest - management_fee b_int_t,period_number b_cnt,claim_certificate_number b_title,target_repayment_date b_bank_date,'1' b_type , b.tender_documents_id b_id from tender_repayments a, tender_documents b where tender_document_state in (9)");
                }
            }else{
                $data['bill_1'] = DB::select("select target_repayment_date b_date,'0' b_out,management_fee b_out2,per_return_principal b_int_m,per_return_interest b_int_r,per_return_principal + per_return_interest - management_fee b_int_t,period_number b_cnt,claim_certificate_number b_title,invoice_at b_bank_date,'1' b_type , b.tender_documents_id b_id from tender_repayments a, tender_documents b where tender_document_state in (1,2,4) and buying_back_type = 0 and a.tender_documents_id = b.tender_documents_id and user_id = ? ",[$user_id]);
                $data['bill_2'] = DB::select("select target_repayment_date b_date,'0' b_out,management_fee b_out2,per_return_principal b_int_m,per_return_interest b_int_r,per_return_principal + per_return_interest - management_fee b_int_t,period_number b_cnt,claim_certificate_number b_title,invoice_at b_bank_date,'3' b_type , b.tender_documents_id b_id from tender_repayments a, tender_documents b where tender_document_state in (1,2,4) and buying_back_type = 1 and a.tender_documents_id = b.tender_documents_id and user_id = ? ",[$user_id]);
                $data['bill_3'] = DB::select("select target_repayment_date b_date,'0' b_out,management_fee b_out2,per_return_principal b_int_m,per_return_interest b_int_r,per_return_principal + per_return_interest - management_fee b_int_t,period_number b_cnt,claim_certificate_number b_title,invoice_at b_bank_date,'4' b_type , b.tender_documents_id b_id from tender_repayments a, tender_documents b where tender_document_state in (1,2,4) and buying_back_type = 2 and a.tender_documents_id = b.tender_documents_id and user_id = ? ",[$user_id]);
                $data['bill_4'] = DB::select("select paid_at b_date,amount b_out,'0' b_out2,'0' b_int_m,'0' b_int_r,'0' b_int_t,'' b_cnt,claim_certificate_number b_title,'' b_bank_date,'0' b_type , tender_documents_id b_id from tender_documents where tender_document_state in (1,2,4) and user_id = ? ",[$user_id]);
                $data['i_bill'] = array_merge($data['bill_1'],$data['bill_2'],$data['bill_3'],$data['bill_4']);
            }
        }
        //arsort($data['i_bill']);
        asort($data['i_bill']);
       return view('Front_End.user_manage.account.myAccount_bill',$data);
   }


   ////////////////////////////////測試帳本////////////////////////////////
   public function account_bill2(){
    $user_id = Auth::user()->user_id;
    if(!empty($_GET["uu"])){
        $user_id = $_GET["uu"];
    }
    $data['invest_info'] = (new User)->countUserMoneyInfo($user_id);
    $data['user'] = DB::table('users')->where('user_id',$user_id)->first();

    if(!empty($_GET["get_money"])){
        if(!empty($_GET["bt"])){
            if($_GET["bt"]==2){
                $data['i_bill'] = DB::select("select a.paid_at b_date,'0' b_out,management_fee b_out2,per_return_principal b_int_m,per_return_interest b_int_r,per_return_principal + per_return_interest - management_fee b_int_t,period_number b_cnt,claim_certificate_number b_title,target_repayment_date b_bank_date,'1' b_type , b.tender_documents_id b_id from tender_repayments a, tender_documents b where tender_document_state in (1,2,4) and buying_back_type = 0 and a.tender_documents_id = b.tender_documents_id and user_id = ? ",[$user_id]);
            }elseif($_GET["bt"]==3){
                $data['i_bill'] = DB::select("select a.paid_at b_date,'0' b_out,management_fee b_out2,per_return_principal b_int_m,per_return_interest b_int_r,per_return_principal + per_return_interest - management_fee b_int_t,period_number b_cnt,claim_certificate_number b_title,target_repayment_date b_bank_date,'3' b_type , b.tender_documents_id b_id from tender_repayments a, tender_documents b where tender_document_state in (1,2,4) and buying_back_type = 1 and a.tender_documents_id = b.tender_documents_id and user_id = ? ",[$user_id]);
            }elseif($_GET["bt"]==4){
                $data['i_bill'] = DB::select("select a.paid_at b_date,'0' b_out,management_fee b_out2,per_return_principal b_int_m,per_return_interest b_int_r,per_return_principal + per_return_interest - management_fee b_int_t,period_number b_cnt,claim_certificate_number b_title,target_repayment_date b_bank_date,'4' b_type , b.tender_documents_id b_id from tender_repayments a, tender_documents b where tender_document_state in (1,2,4) and buying_back_type = 2 and a.tender_documents_id = b.tender_documents_id and user_id = ? ",[$user_id]);
            }else{
                $data['i_bill'] = DB::select("select a.paid_at b_date,'0' b_out,management_fee b_out2,per_return_principal b_int_m,per_return_interest b_int_r,per_return_principal + per_return_interest - management_fee b_int_t,period_number b_cnt,claim_certificate_number b_title,target_repayment_date b_bank_date,'1' b_type , b.tender_documents_id b_id from tender_repayments a, tender_documents b where tender_document_state in (9)");
            }
        }else{
            $data['i_bill'] = DB::select("select a.paid_at b_date,'0' b_out,management_fee b_out2,per_return_principal b_int_m,per_return_interest b_int_r,per_return_principal + per_return_interest - management_fee b_int_t,period_number b_cnt,claim_certificate_number b_title,target_repayment_date b_bank_date,'1' b_type , b.tender_documents_id b_id from tender_repayments a, tender_documents b where tender_document_state in (1,2,4) and buying_back_type = 0 and a.tender_documents_id = b.tender_documents_id and user_id = ? ",[$user_id]);
        }
    }else{
        if(!empty($_GET["bt"])){
            if($_GET["bt"]==2){
                $data['i_bill'] = DB::select("select target_repayment_date b_date,'0' b_out,management_fee b_out2,per_return_principal b_int_m,per_return_interest b_int_r,per_return_principal + per_return_interest - management_fee b_int_t,period_number b_cnt,claim_certificate_number b_title,invoice_at b_bank_date,'1' b_type , b.tender_documents_id b_id from tender_repayments a, tender_documents b where tender_document_state in (1,2,4) and buying_back_type = 0 and a.tender_documents_id = b.tender_documents_id and user_id = ? ",[$user_id]);

            }elseif($_GET["bt"]==1){
                $data['i_bill'] = DB::select("select paid_at b_date,amount b_out,'0' b_out2,'0' b_int_m,'0' b_int_r,'0' b_int_t,'' b_cnt,claim_certificate_number b_title,'' b_bank_date,'0' b_type , tender_documents_id b_id from tender_documents where tender_document_state in (1,2,4) and user_id = ? ",[$user_id]);
            }elseif($_GET["bt"]==3){
                $data['i_bill'] = DB::select("select target_repayment_date b_date,'0' b_out,management_fee b_out2,per_return_principal b_int_m,per_return_interest b_int_r,per_return_principal + per_return_interest - management_fee b_int_t,period_number b_cnt,claim_certificate_number b_title,invoice_at b_bank_date,'3' b_type , b.tender_documents_id b_id from tender_repayments a, tender_documents b where tender_document_state in (1,2,4) and buying_back_type = 1 and a.tender_documents_id = b.tender_documents_id and user_id = ? ",[$user_id]);
            }elseif($_GET["bt"]==4){
                $data['i_bill'] = DB::select("select target_repayment_date b_date,'0' b_out,management_fee b_out2,per_return_principal b_int_m,per_return_interest b_int_r,per_return_principal + per_return_interest - management_fee b_int_t,period_number b_cnt,claim_certificate_number b_title,invoice_at b_bank_date,'4' b_type , b.tender_documents_id b_id from tender_repayments a, tender_documents b where tender_document_state in (1,2,4) and buying_back_type = 2 and a.tender_documents_id = b.tender_documents_id and user_id = ? ",[$user_id]);
            }else{
                $data['i_bill'] = DB::select("select a.paid_at b_date,'0' b_out,management_fee b_out2,per_return_principal b_int_m,per_return_interest b_int_r,per_return_principal + per_return_interest - management_fee b_int_t,period_number b_cnt,claim_certificate_number b_title,target_repayment_date b_bank_date,'1' b_type , b.tender_documents_id b_id from tender_repayments a, tender_documents b where tender_document_state in (9)");
            }
        }else{
            $data['bill_1'] = DB::select("select target_repayment_date b_date,'0' b_out,management_fee b_out2,per_return_principal b_int_m,per_return_interest b_int_r,per_return_principal + per_return_interest - management_fee b_int_t,period_number b_cnt,claim_certificate_number b_title,invoice_at b_bank_date,'1' b_type , b.tender_documents_id b_id from tender_repayments a, tender_documents b where tender_document_state in (1,2,4) and buying_back_type = 0 and a.tender_documents_id = b.tender_documents_id and user_id = ? ",[$user_id]);
            $data['bill_2'] = DB::select("select target_repayment_date b_date,'0' b_out,management_fee b_out2,per_return_principal b_int_m,per_return_interest b_int_r,per_return_principal + per_return_interest - management_fee b_int_t,period_number b_cnt,claim_certificate_number b_title,invoice_at b_bank_date,'3' b_type , b.tender_documents_id b_id from tender_repayments a, tender_documents b where tender_document_state in (1,2,4) and buying_back_type = 1 and a.tender_documents_id = b.tender_documents_id and user_id = ? ",[$user_id]);
            $data['bill_3'] = DB::select("select target_repayment_date b_date,'0' b_out,management_fee b_out2,per_return_principal b_int_m,per_return_interest b_int_r,per_return_principal + per_return_interest - management_fee b_int_t,period_number b_cnt,claim_certificate_number b_title,invoice_at b_bank_date,'4' b_type , b.tender_documents_id b_id from tender_repayments a, tender_documents b where tender_document_state in (1,2,4) and buying_back_type = 2 and a.tender_documents_id = b.tender_documents_id and user_id = ? ",[$user_id]);
            $data['bill_4'] = DB::select("select paid_at b_date,amount b_out,'0' b_out2,'0' b_int_m,'0' b_int_r,'0' b_int_t,'' b_cnt,claim_certificate_number b_title,'' b_bank_date,'0' b_type , tender_documents_id b_id from tender_documents where tender_document_state in (1,2,4) and user_id = ? ",[$user_id]);
            $data['i_bill'] = array_merge($data['bill_1'],$data['bill_2'],$data['bill_3'],$data['bill_4']);
        }
    }

    //arsort($data['i_bill']);
    asort($data['i_bill']);
   return view('Front_End.user_manage.account.myAccount_bill2',$data);
}   
   
   ////////////////////////////////已繳款PDF////////////////////////////////
   ////////////////////////////////已繳款PDF////////////////////////////////
   ////////////////////////////////已繳款PDF////////////////////////////////
    public function look_pdf( $pid )
    {
        try {
            $cc = DB::select("select count(*) cct from  tender_documents where tender_document_state in (1,2,4) and tender_documents_id = '".$pid."' and user_id = '".Auth::user()->user_id."'");
            foreach ($cc as $x => $y) {
                $cnt = $y->cct;
            }
            if ($cnt ==1) {
                $r1=date("YmdHis");
                $r2=rand(1000, 9999);
                $ar ="PP_tender".$r1.Auth::user()->user_id.md5($r2);
                $create_date =  DB::SELECT('SELECT create_date FROM `pdf_log` WHERE `tender_documents_id` = ?',[$pid]);

                $year = date("Y",strtotime($create_date[0]->create_date));
                $month = date("m",strtotime($create_date[0]->create_date));

                $pdf_f=$pid."_tender.pdf";
                $file_path = "uploads/ClaimTenderPDF/".$pdf_f;
                $file_path1 = "uploads/ClaimTenderPDF_new/".$year.$month."/".$pdf_f;
                if(file_exists($file_path)){
                    copy($file_path, "uploads/t_p_pdf/".$ar."_".$pdf_f);
                    echo "<script>document.location.href='/uploads/t_p_pdf/".$ar."_".$pid."_tender.pdf';</script>";
                }else{
                    copy($file_path1, "uploads/t_p_pdf/".$ar."_".$pdf_f);
                    echo "<script>document.location.href='/uploads/t_p_pdf/".$ar."_".$pid."_tender.pdf';</script>";
                }
            } else {
                echo "<script>document.location.href='/';</script>";
            }
        } catch (\Throwable $th) {
            session()->flash('pdfloading', '123');
            return redirect()->back();
        }
    }
    /**
     * Api 取收益明細
     */
    public function apiGetRepaymentDetail(Request $req)
    {
        try {
            $tender_id = $req->tenderId;
            $user_id = Auth::user()->user_id;
            $checkTender = Tenders::where('user_id',$user_id)->where('tender_documents_id',$tender_id)->count();

            if($checkTender > 0){
                $data = TenderRepayments::select(
                    'period_number',
                    DB::raw('DATE_FORMAT(target_repayment_date,"%Y-%m-%d") as target_repayment_date'),
                    DB::raw('FORMAT(per_return_principal,0) as per_return_principal'),
                    DB::raw('FORMAT(per_return_interest,0) as per_return_interest'),
                    DB::raw('FORMAT(management_fee,0) as management_fee'),
                    //DB::raw('FORMAT(net_amount + management_fee,0) as total'),
                    //DB::raw('FORMAT(net_amount,0) as total'),
                    DB::raw('FORMAT(per_return_principal + per_return_interest,0) as total'),
                    //DB::raw('FORMAT(net_amount,0) as net_amount') ,
                    DB::raw('FORMAT(net_amount,0) as net_amount') ,
                    //DB::raw('FORMAT(real_return_amount,0) as real_return_amount') ,
                    DB::raw('FORMAT(per_return_principal + per_return_interest - management_fee,0) as real_return_amount') ,
                    DB::raw('IFNULL(DATE_FORMAT(paid_at,"%Y-%m-%d") , "") as paid_at'),
                    DB::raw('IFNULL(DATE_FORMAT(credited_at,"%Y-%m-%d"),"") as credited_at'))
                    ->where('tender_documents_id',$tender_id)
                    ->groupBy('tender_documents_id','period_number','target_repayment_date')
                    ->get()->toArray();
                    $tol_data = array();
                    $tol_data['everyMonthPrincipal']= 0;
                    $tol_data['everyMonthInterest']= 0;
                    $tol_data['thirdPartyManagmentFee'] = 0;
                    $tol_data['everyMonthPaidTotal'] = 0;
                    $tol_data['Total'] = 0;
                    $first_data = array();
                    foreach ($data as $k=>$v) {

                        $first_data[$k]['per_return_principal'] = str_replace(',', '', $data[$k]['per_return_principal']);
                        $first_data[$k]['per_return_interest'] = str_replace(',', '', $data[$k]['per_return_interest']);
                        $first_data[$k]['management_fee'] = str_replace(',', '', $data[$k]['management_fee']);
                        $first_data[$k]['total'] = str_replace(',', '', $data[$k]['total']);
                        $first_data[$k]['real_return_amount'] = str_replace(',', '', $data[$k]['real_return_amount']); 

                        $tol_data['everyMonthPrincipal'] += (float)$first_data[$k]['per_return_principal'];
                        $tol_data['everyMonthInterest'] += (float)$first_data[$k]['per_return_interest'];
                        $tol_data['thirdPartyManagmentFee'] += (float)$first_data[$k]['management_fee'];
                        $tol_data['everyMonthPaidTotal'] += (float)$first_data[$k]['total'];
                        $tol_data['Total'] += (float)$first_data[$k]['real_return_amount'];
                    }
                    $tol_data['everyMonthPrincipal'] = number_format($tol_data['everyMonthPrincipal']);
                    $tol_data['everyMonthInterest'] = number_format($tol_data['everyMonthInterest']);
                    $tol_data['thirdPartyManagmentFee'] = number_format($tol_data['thirdPartyManagmentFee']);
                    $tol_data['everyMonthPaidTotal'] = number_format($tol_data['everyMonthPaidTotal']);
                    $tol_data['totala'] = number_format($tol_data['Total']);
                    // ->toSql();
                    // dd($data);
                return response()->json([
                    'status' => 'success',
                    'data' => $data ,
                    'toltal' => $tol_data
                ]);
            }else{
                return response()->json([
                    'status' => 'UserError'
                ]);
            }
        } catch (\Throwable $th) {
           return response()->json([
               'statue' => 'server error'
           ]);
        }
    }
    //////////////////////////////////////////測試用//////////////////////////////////////////
    //////////////////////////////////////////測試用//////////////////////////////////////////
    //////////////////////////////////////////測試用//////////////////////////////////////////
    public function apiGetRepaymentDetail2(Request $req)
    {
        try {
            $tender_id = $req->tenderId;
            $user_id = $req->uu;
            $checkTender = Tenders::where('user_id',$user_id)->where('tender_documents_id',$tender_id)->count();

            if($checkTender > 0){
                $data = TenderRepayments::select(
                    'period_number',
                    DB::raw('DATE_FORMAT(target_repayment_date,"%Y-%m-%d") as target_repayment_date'),
                    DB::raw('FORMAT(per_return_principal,0) as per_return_principal'),
                    DB::raw('FORMAT(per_return_interest,0) as per_return_interest'),
                    DB::raw('FORMAT(management_fee,0) as management_fee'),
                    DB::raw('FORMAT(per_return_principal + per_return_interest,0) as total'),
                    DB::raw('FORMAT(net_amount,0) as net_amount') ,
                    DB::raw('FORMAT(per_return_principal + per_return_interest - management_fee,0) as real_return_amount') ,
                    DB::raw('IFNULL(DATE_FORMAT(paid_at,"%Y-%m-%d") , "") as paid_at'),
                    DB::raw('IFNULL(DATE_FORMAT(credited_at,"%Y-%m-%d"),"") as credited_at'))
                    ->where('tender_documents_id',$tender_id)
                    ->groupBy('tender_documents_id','period_number','target_repayment_date')
                    ->get()->toArray();
                    $tol_data = array();
                    $tol_data['everyMonthPrincipal']= 0;
                    $tol_data['everyMonthInterest']= 0;
                    $tol_data['thirdPartyManagmentFee'] = 0;
                    $tol_data['everyMonthPaidTotal'] = 0;
                    $tol_data['Total'] = 0;
                    $first_data = array();
                    foreach ($data as $k=>$v) {

                        $first_data[$k]['per_return_principal'] = str_replace(',', '', $data[$k]['per_return_principal']);
                        $first_data[$k]['per_return_interest'] = str_replace(',', '', $data[$k]['per_return_interest']);
                        $first_data[$k]['management_fee'] = str_replace(',', '', $data[$k]['management_fee']);
                        $first_data[$k]['total'] = str_replace(',', '', $data[$k]['total']);
                        $first_data[$k]['real_return_amount'] = str_replace(',', '', $data[$k]['real_return_amount']); 

                        $tol_data['everyMonthPrincipal'] += (float)$first_data[$k]['per_return_principal'];
                        $tol_data['everyMonthInterest'] += (float)$first_data[$k]['per_return_interest'];
                        $tol_data['thirdPartyManagmentFee'] += (float)$first_data[$k]['management_fee'];
                        $tol_data['everyMonthPaidTotal'] += (float)$first_data[$k]['total'];
                        $tol_data['Total'] += (float)$first_data[$k]['real_return_amount'];
                    }
                    $tol_data['everyMonthPrincipal'] = number_format($tol_data['everyMonthPrincipal']);
                    $tol_data['everyMonthInterest'] = number_format($tol_data['everyMonthInterest']);
                    $tol_data['thirdPartyManagmentFee'] = number_format($tol_data['thirdPartyManagmentFee']);
                    $tol_data['everyMonthPaidTotal'] = number_format($tol_data['everyMonthPaidTotal']);
                    $tol_data['totala'] = number_format($tol_data['Total']);
                    // ->toSql();
                    // dd($data);
                return response()->json([
                    'status' => 'success',
                    'data' => $data ,
                    'toltal' => $tol_data
                ]);
            }else{
                return response()->json([
                    'status' => 'UserError'
                ]);
            }
        } catch (\Throwable $th) {
           return response()->json([
               'statue' => 'server error'
           ]);
        }
    }

    public function findUserTenderClaim($user_id)
    {
    //     SELECT
    //     td.claim_certificate_number,
    //     c.value_date,
    //     td.tender_document_state,
    //     td.amount,
    //     c.annual_interest_rate
    // FROM
    //     tender_documents AS td
    // LEFT JOIN claims AS c
    // ON
    //     c.claim_id = td.claim_id
    // LEFT JOIN users AS u
    // ON
    //     u.user_id = td.user_id
    // WHERE
    //     u.user_id = 17
        $model = DB::table('tender_documents')->from('tender_documents AS td')
            ->leftJoin('claims AS c','c.claim_id', '=', 'td.claim_id')
            ->leftJoin('users AS u','u.user_id', '=', 'td.user_id')
            ->select(DB::raw('c.claim_id,
            td.claim_certificate_number,
            c.value_date,
            td.tender_document_state,
            td.amount,
            c.annual_interest_rate'))
            ->where('u.user_id',$user_id)->get()->toArray();
            return $model;

    }

    public function downloadClaimPdf()
    {
        $user_id = (isset($req->user_id)) ? $req->user_id : 17;
        $claim_id = (isset($req->claim_id)) ? $req->claim_id : 12;
        $amount = (isset($req->amount)) ? $req->amount : 10000;
        $user = User::find($user_id);
        $claim = Claim::find($claim_id);

        $pdf = PDF::loadView('pdf.sample',[
            'user' => $user,
            'claim' => $claim,
            'amount' => $amount
        ]);
        // return $pdf->download('sample.pdf');
        return $pdf->stream('sample.pdf');
    }



}
