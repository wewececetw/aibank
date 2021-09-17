<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Log;
use Illuminate\Support\Facades\Storage;
// use DB;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Match;
use App\Claim;
use App\ClaimFiles;
use App\Tenders;
use App\SystemVariables;
use App\Order;
use App\User;
use App\UsersRoles;
use App\UserBank;

//本金攤還
use App\PayBackCount\equalPrincipalPayment;
//本息攤還
use App\PayBackCount\equalTotalPayment;

use App\PayBackCount\Common;

use App\MainFlow\MainFlow;
//郵件相關
use Illuminate\Support\Facades\Mail;
use App\Mail\SampleMail;

class FrontEnd_ClaimsController extends Controller
{
        // 投資認購

        public function claim_category_index( Request $request ){
            $datas = Match::where('value_type','=','frontShow')->get();
            $result = array();
            foreach($datas as $data)
            {
                if($data->value_name == 'annualBenefitsRate')
                {
                    $result['annualBenefitsRate'] = $data->value;
                    continue;
                }
                else if($data->value_name == 'memberBenefits')
                {
                    $result['memberBenefits'] = $data->value;
                    continue;
                }
                else if ($data->value_name == 'totalInvestAmount')
                {
                    $result['totalInvestAmount'] = $data->value;
                    continue;
                }
            }
            //==================轉出陣列變數==================
            $line_id = $request["line_id"];
            //==================轉出陣列變數==================
            //==================計算LIMIT==================
            $line=60;//行數
                /*******************計算總筆數*******************/
            //$result['claims_cnt'] = Claim::orderBy('created_at','desc')->orderBy('claim_id','desc')->where('risk_category',8)->where('is_display','1')->get();
            $result['claims_cnt'] = DB::select("
            SELECT count(*) as cnt
            FROM
             claims 
            where
             risk_category != 8 and is_display=1 and claim_state in(0 ,1, 2)
           "
            );
            foreach ( $result['claims_cnt'] as $aa){
                $line_cnt =$aa->cnt;
            }
            $result["all_page"] = ceil($line_cnt/$line);
                /*******************計算總筆數*******************/
                //--------------------擋不明參數--------------------
            $line_id = (int)$line_id;
            if(!is_int($line_id)){ $line_id =1;}
            if($line_id <= 0 ){ $line_id =1;}
            $result["all_page"] = ceil($line_cnt/$line);
            if($line_id > $result["all_page"] ){ $line_id =1;}
                //--------------------擋不明參數--------------------
            $limit_start=intval($line_id-1)*$line;
            //==================排序==================
            for($i=1;$i<=11;$i++){ $result['c_'.$i] = $i; }
            
            $ordersql = '';
            if($request["cliams_type"]==1){
                $ordersql = ' order by typing ';
                
                $result['c_1']=101;
            }else if($request["cliams_type"]==101){
                $ordersql = ' order by typing Desc';
                
                $result['c_1']=1;
            }else if($request["cliams_type"]==2){
                $ordersql = ' order by pig_credit';
                
                $result['c_2']=102;
            }else if($request["cliams_type"]==102){
                $ordersql = ' order by pig_credit Desc';
                
                $result['c_2']=2;
            }else if($request["cliams_type"]==3){
                $ordersql = ' order by annual_interest_rate';
                
                $result['c_3']=103;
            }else if($request["cliams_type"]==103){
                $ordersql = ' order by annual_interest_rate Desc';
                
                $result['c_3']=3;
            }else if($request["cliams_type"]==4){
                $ordersql = ' order by claim_number';
                
                $result['c_4']=104;
            }else if($request["cliams_type"]==104){
                $ordersql = ' order by claim_number Desc';
                
                $result['c_4']=4;
            }else if($request["cliams_type"]==5){
                $ordersql = ' order by staging_amount';
                
                $result['c_5']=105;
            }else if($request["cliams_type"]==105){
                $ordersql = ' order by staging_amount Desc';
                
                $result['c_5']=5;
            }else if($request["cliams_type"]==6){
                $ordersql = ' order by periods';
                
                $result['c_6']=106;
            }else if($request["cliams_type"]==106){
                $ordersql = ' order by periods Desc';
                
                $result['c_6']=6;
            }else if($request["cliams_type"]==8){
                $ordersql = ' order by start_collecting_at';
                
                $result['c_8']=108;
            }else if($request["cliams_type"]==108){
                $ordersql = ' order by start_collecting_at Desc';
                
                $result['c_8']=8;
            }else if($request["cliams_type"]==9){
                $ordersql = ' order by buying ';
                
                $result['c_9']=109;
            }else if($request["cliams_type"]==109){
                $ordersql = ' order by buying Desc';
                
                $result['c_9']=9;
            }else if($request["cliams_type"]==10){
                $ordersql = ' order by om ';
                
                $result['c_10']=1010;
            }else if($request["cliams_type"]==1010){
                $ordersql = ' order by om Desc';
                
                $result['c_10']=10;
            }else{
                $ordersql = ' order by buying Desc';
                
            }
            
            //==================排序==================
            //==================計算LIMIT==================
            $result['cc'] = DB::select("
            SELECT 
             a.*,
             ( SELECT (SUM(td.amount) / a.staging_amount) * 100 FROM tender_documents AS td WHERE td.claim_id = a.claim_id GROUP BY td.claim_id ) buying,
             ( SELECT (SUM(td.amount) / a.staging_amount) * 100 FROM tender_documents AS td WHERE td.claim_id = a.claim_id and tender_document_state in (1,2,4,6) GROUP BY td.claim_id ) om 
            FROM
             claims a
            where
             risk_category != 8 and is_display=1 and claim_state in(0 ,1, 2)
             $ordersql limit $limit_start , $line");
            //==================計算總頁數==================
            $result["line_id"] = $line_id;
            $result["pre"] = "disabled";
            $result["nex"] = "disabled";
            $result["pl"]="#";
            $result["nl"]="#";
            $nnn = $line_id -1;
            $ppp = $line_id +1;
            if($line_id >1){
                $result["pre"]="xx";
                $result["pl"]="/front/claim_category/".$nnn."/".$request["cliams_type"];
            }
            if($line_id < $result["all_page"]){
                $result["nex"]="xx";
                $result["nl"]="/front/claim_category/".$ppp."/".$request["cliams_type"];
            }
            //==================計算總頁數==================
            //==================排序==================
            $pp = collect($result['cc']);

            $result['claims'] = $pp; 
            $result['claims']->values()->all();
            $result['c_t'] = $request["cliams_type"];
            //==================排序==================
            $claimsIdArray = [];
            foreach ($result['claims'] as $key => $value) {
                array_push($claimsIdArray,$value->claim_id);
            }
            try {
                $result['progress'] = $this->getProgress($claimsIdArray);
                $result['pay'] = $this->payProgress($claimsIdArray);
                $result['rest'] = $this->restProgress($claimsIdArray);
            } catch (\Throwable $th) {
                $result['progress'] = [];
                $result['pay'] = [];
                $result['rest'] = [];
            }
            return view('Front_End.category.claim_category',$result);
        }


        public function claim_category_special(Request $request ){
            $datas = Match::where('value_type','=','frontShow')->get();

            foreach($datas as $data)
            {
                if($data->value_name == 'annualBenefitsRate')
                {
                    $result['annualBenefitsRate'] = $data->value;
                    continue;
                }
                else if($data->value_name == 'memberBenefits')
                {
                    $result['memberBenefits'] = $data->value;
                    continue;
                }
                else if ($data->value_name == 'totalInvestAmount')
                {
                    $result['totalInvestAmount'] = $data->value;
                    continue;
                }
            }
            //==================轉出陣列變數==================
            $line_id = $request["line_id"];
            //==================轉出陣列變數==================
            //==================計算LIMIT==================
            $line=60;//行數
                /*******************計算總筆數*******************/
            $result['claims_cnt'] = DB::select("
            SELECT count(*) as cnt
            FROM
             claims 
            where
             risk_category = 8 and is_display=1 and claim_state in(0 ,1, 2)
           ");
           foreach ( $result['claims_cnt'] as $aa){
            $line_cnt =$aa->cnt;
            }
            $result["all_page"] = ceil($line_cnt/$line);
                /*******************計算總筆數*******************/
                //--------------------擋不明參數--------------------
            $line_id = (int)$line_id;
            if(!is_int($line_id)){ $line_id =1;}
            if($line_id <= 0 ){ $line_id =1;}
            $result["all_page"] = ceil($line_cnt/$line);
            if($line_id > $result["all_page"] ){ $line_id =1;}
                //--------------------擋不明參數--------------------
            $limit_start=intval($line_id-1)*$line;
            //==================計算LIMIT==================
            
           // $result['cc'] = Claim::offset($limit_start)->limit($line)->orderBy('created_at','desc')->orderBy('claim_id','desc')->where('risk_category','!=',8)->where('is_display','1')->get();
            //==================計算總頁數==================
            $result["line_id"] = $line_id;
            $result["pre"] = "disabled";
            $result["nex"] = "disabled";
            $result["pl"]="#";
            $result["nl"]="#";
            $nnn = $line_id -1;
            $ppp = $line_id +1;
            if($line_id >1){
                $result["pre"]="xx";
                $result["pl"]="/front/claim_category_special/".$nnn."/".$request["cliams_type"];
            }
            if($line_id < $result["all_page"]){
                $result["nex"]="xx";
                $result["nl"]="/front/claim_category_special/".$ppp."/".$request["cliams_type"];
            }
            //==================排序==================
            for($i=1;$i<=11;$i++){ $result['c_'.$i] = $i; }
            
            $ordersql = '';
            if($request["cliams_type"]==1){
                $ordersql = ' order by typing ';
                
                $result['c_1']=101;
            }else if($request["cliams_type"]==101){
                $ordersql = ' order by typing Desc';
                
                $result['c_1']=1;
            }else if($request["cliams_type"]==2){
                $ordersql = ' order by pig_credit';
                
                $result['c_2']=102;
            }else if($request["cliams_type"]==102){
                $ordersql = ' order by pig_credit Desc';
                
                $result['c_2']=2;
            }else if($request["cliams_type"]==3){
                $ordersql = ' order by annual_interest_rate';
                
                $result['c_3']=103;
            }else if($request["cliams_type"]==103){
                $ordersql = ' order by annual_interest_rate Desc';
                
                $result['c_3']=3;
            }else if($request["cliams_type"]==4){
                $ordersql = ' order by claim_number';
                
                $result['c_4']=104;
            }else if($request["cliams_type"]==104){
                $ordersql = ' order by claim_number Desc';
                
                $result['c_4']=4;
            }else if($request["cliams_type"]==5){
                $ordersql = ' order by staging_amount';
                
                $result['c_5']=105;
            }else if($request["cliams_type"]==105){
                $ordersql = ' order by staging_amount Desc';
                
                $result['c_5']=5;
            }else if($request["cliams_type"]==6){
                $ordersql = ' order by periods';
                
                $result['c_6']=106;
            }else if($request["cliams_type"]==106){
                $ordersql = ' order by periods Desc';
                
                $result['c_6']=6;
            }else if($request["cliams_type"]==8){
                $ordersql = ' order by start_collecting_at';
                
                $result['c_8']=108;
            }else if($request["cliams_type"]==108){
                $ordersql = ' order by start_collecting_at Desc';
                
                $result['c_8']=8;
            }else if($request["cliams_type"]==9){
                $ordersql = ' order by buying ';
                
                $result['c_9']=109;
            }else if($request["cliams_type"]==109){
                $ordersql = ' order by buying Desc';
                
                $result['c_9']=9;
            }else if($request["cliams_type"]==10){
                $ordersql = ' order by om ';
                
                $result['c_10']=1010;
            }else if($request["cliams_type"]==1010){
                $ordersql = ' order by om Desc';
                
                $result['c_10']=10;
            }else{
                $ordersql = ' order by buying Desc';
                
            }
            
            //==================排序==================
            //==================計算總頁數==================
            $result['cc'] = DB::select("
            SELECT
             a.*,
              ( SELECT (SUM(td.amount) / a.staging_amount) * 100 FROM tender_documents AS td WHERE td.claim_id = a.claim_id GROUP BY td.claim_id ) buying,
              ( SELECT (SUM(td.amount) / a.staging_amount) * 100 FROM tender_documents AS td WHERE td.claim_id = a.claim_id and tender_document_state in (1,2,4,6) GROUP BY td.claim_id ) om
            FROM
             claims a
            where
             risk_category = 8 and is_display=1 and claim_state in(0 ,1, 2)
             $ordersql limit $limit_start , $line");
            $result['c_t'] = $request["cliams_type"];
            //===============================================
            $pp = collect($result['cc']);
            $result['claims'] = $pp; 
            $result['claims']->values()->all();
            
            $claimsIdArray = [];
            foreach ($result['claims'] as $key => $value) {
                array_push($claimsIdArray,$value->claim_id);
            }

            try {
                $result['progress'] = $this->getProgress($claimsIdArray);
                $result['pay'] = $this->payProgress($claimsIdArray);
                $result['rest'] = $this->restProgress($claimsIdArray);
            } catch (\Throwable $th) {
                $result['progress'] = [];
                $result['pay'] = [];
                $result['rest'] = [];
            }

            return view('Front_End.category.claim_category_special',$result);
        }

        public function claim_category_history(Request $request ){
            $datas = Match::where('value_type','=','frontShow')->get();

            foreach($datas as $data)
            {
                if($data->value_name == 'annualBenefitsRate')
                {
                    $result['annualBenefitsRate'] = $data->value;
                    continue;
                }
                else if($data->value_name == 'memberBenefits')
                {
                    $result['memberBenefits'] = $data->value;
                    continue;
                }
                else if ($data->value_name == 'totalInvestAmount')
                {
                    $result['totalInvestAmount'] = $data->value;
                    continue;
                }
            }
            //==================轉出陣列變數==================
            $line_id = $request["line_id"];
            //==================轉出陣列變數==================
            //==================計算LIMIT==================
            $line=60;//行數
                /*******************計算總筆數*******************/
            $result['claims_cnt'] = DB::select("
            SELECT count(*) as cnt
            FROM
             claims 
            where
             is_display=1 and claim_state not in(0 ,1, 2 ,3)
           ");
           foreach ( $result['claims_cnt'] as $aa){
            $line_cnt =$aa->cnt;
            }
            $result["all_page"] = ceil($line_cnt/$line);
                /*******************計算總筆數*******************/
                //--------------------擋不明參數--------------------
            $line_id = (int)$line_id;
            if(!is_int($line_id)){ $line_id =1;}
            if($line_id <= 0 ){ $line_id =1;}
            $result["all_page"] = ceil($line_cnt/$line);
            if($line_id > $result["all_page"] ){ $line_id =1;}
                //--------------------擋不明參數--------------------
            $limit_start=intval($line_id-1)*$line;
            //==================計算LIMIT==================
            
           // $result['cc'] = Claim::offset($limit_start)->limit($line)->orderBy('created_at','desc')->orderBy('claim_id','desc')->where('risk_category','!=',8)->where('is_display','1')->get();
            //==================計算總頁數==================
            $result["line_id"] = $line_id;
            $result["pre"] = "disabled";
            $result["nex"] = "disabled";
            $result["pl"]="#";
            $result["nl"]="#";
            $nnn = $line_id -1;
            $ppp = $line_id +1;
            if($line_id >1){
                $result["pre"]="xx";
                $result["pl"]="/front/claim_category_history/".$nnn."/".$request["cliams_type"];
            }
            if($line_id < $result["all_page"]){
                $result["nex"]="xx";
                $result["nl"]="/front/claim_category_history/".$ppp."/".$request["cliams_type"];
            }
            //==================排序==================
            for($i=1;$i<=11;$i++){ $result['c_'.$i] = $i; }
            
            $ordersql = '';
            if($request["cliams_type"]==1){
                $ordersql = ' order by typing ';
                
                $result['c_1']=101;
            }else if($request["cliams_type"]==101){
                $ordersql = ' order by typing Desc';
                
                $result['c_1']=1;
            }else if($request["cliams_type"]==2){
                $ordersql = ' order by pig_credit';
                
                $result['c_2']=102;
            }else if($request["cliams_type"]==102){
                $ordersql = ' order by pig_credit Desc';
                
                $result['c_2']=2;
            }else if($request["cliams_type"]==3){
                $ordersql = ' order by annual_interest_rate';
                
                $result['c_3']=103;
            }else if($request["cliams_type"]==103){
                $ordersql = ' order by annual_interest_rate Desc';
                
                $result['c_3']=3;
            }else if($request["cliams_type"]==4){
                $ordersql = ' order by claim_number';
                
                $result['c_4']=104;
            }else if($request["cliams_type"]==104){
                $ordersql = ' order by claim_number Desc';
                
                $result['c_4']=4;
            }else if($request["cliams_type"]==5){
                $ordersql = ' order by staging_amount';
                
                $result['c_5']=105;
            }else if($request["cliams_type"]==105){
                $ordersql = ' order by staging_amount Desc';
                
                $result['c_5']=5;
            }else if($request["cliams_type"]==6){
                $ordersql = ' order by periods';
                
                $result['c_6']=106;
            }else if($request["cliams_type"]==106){
                $ordersql = ' order by periods Desc';
                
                $result['c_6']=6;
            }else if($request["cliams_type"]==8){
                $ordersql = ' order by start_collecting_at';
                
                $result['c_8']=108;
            }else if($request["cliams_type"]==108){
                $ordersql = ' order by start_collecting_at Desc';
                
                $result['c_8']=8;
            }else if($request["cliams_type"]==9){
                $ordersql = ' order by buying ';
                
                $result['c_9']=109;
            }else if($request["cliams_type"]==109){
                $ordersql = ' order by buying Desc';
                
                $result['c_9']=9;
            }else if($request["cliams_type"]==10){
                $ordersql = ' order by om ';
                
                $result['c_10']=1010;
            }else if($request["cliams_type"]==1010){
                $ordersql = ' order by om Desc';
                
                $result['c_10']=10;
            }else{
                $ordersql = ' order by buying Desc';
                
            }
            
            //==================排序==================
            //==================計算總頁數==================
            $result['cc'] = DB::select("
            SELECT
             a.*,
              ( SELECT (SUM(td.amount) / a.staging_amount) * 100 FROM tender_documents AS td WHERE td.claim_id = a.claim_id GROUP BY td.claim_id ) buying,
              ( SELECT (SUM(td.amount) / a.staging_amount) * 100 FROM tender_documents AS td WHERE td.claim_id = a.claim_id and tender_document_state in (1,2,4,6) GROUP BY td.claim_id ) om
            FROM
             claims a
            where
             is_display=1 and claim_state not in(0 ,1 ,2 ,3)
            $ordersql limit $limit_start , $line");
            $result['c_t'] = $request["cliams_type"];
            //====================================================
            $pp = collect($result['cc']);
            $result['claims'] = $pp; 
            $result['claims']->values()->all();

            
            
            $claimsIdArray = [];
            foreach ($result['claims'] as $key => $value) {
                array_push($claimsIdArray,$value->claim_id);
            }

            try {
                $result['progress'] = $this->getProgress($claimsIdArray);
                $result['pay'] = $this->payProgress($claimsIdArray);
                $result['rest'] = $this->restProgress($claimsIdArray);
            } catch (\Throwable $th) {
                $result['progress'] = [];
                $result['pay'] = [];
                $result['rest'] = [];
            }

            return view('Front_End.category.claim_category_history',$result);
        }

        public function getProgress($claimsIdArray)
        {
            $ids =implode(',',$claimsIdArray);

            $t = DB::select('
            SELECT
                c.claim_id as claim_id,
                (SUM(amount) / staging_amount) * 100 AS total
            FROM
                tender_documents AS td
            LEFT JOIN claims AS c
            ON
                td.claim_id = c.claim_id
            WHERE
                c.claim_id IN('.$ids.')
            GROUP BY
                c.claim_id
            ');



            $ar = [];
            if(count($t) > 0){
                foreach ($t as $key => $value) {
                    if( isset($value->total) ){
                        $ar[$value->claim_id] = $value->total;
                    }else{
                        $ar[$value->claim_id] = 0;
                    }
                }
            }else{
                foreach ($claimsIdArray as $key => $value) {
                    $ar[$value] = 0;

                }
            }



            return $ar;
        }



        public function payProgress($claimsIdArray)
        {
            $ids = implode(',',$claimsIdArray);

            $t = DB::select('
            SELECT
                c.claim_id as claim_id,
                SUM(td.amount) / c.staging_amount * 100 AS sumAmount
            FROM
            claims AS c
                LEFT JOIN
            tender_documents AS td ON c.claim_id = td.claim_id

            WHERE
                c.claim_id IN ('.$ids.')
                    AND td.tender_document_state in (1,2,4,6)
            GROUP BY
                c.claim_id
                ');



            $ar = [];
            if(count($t) > 0){
                foreach ($t as $key => $value){

                    if(isset($value->sumAmount)){
                        $ar[$value->claim_id] = $value->sumAmount;
                    }else{
                        $ar[$value->claim_id] = 0;
                    }
                }
            }else{
                foreach ($claimsIdArray as $key => $value) {
                    $ar[$value] = 0;
                }
            }

            return $ar;
        }


        public function restProgress($claimsIdArray){

            $ids = implode(',',$claimsIdArray);

            $t = DB::select('
                    SELECT
                        c.claim_id,
                        c.staging_amount - IFNULL(SUM(td.amount),
                        0) AS sumAmount
                    FROM
                        claims AS c LEFT
                    JOIN(
                        SELECT
                            claim_id,
                            amount
                        FROM
                            tender_documents
                        WHERE
                            claim_id IN('.$ids.')
                    ) AS td
                    ON
                        c.claim_id = td.claim_id
                    WHERE
                        c.claim_id IN ('.$ids.')
                    GROUP BY
                        c.claim_id
            ');



            $ar = [];
            if(count($t) > 0){
                foreach ($t as $key => $value){

                    if(isset($value->sumAmount)){
                        $ar[$value->claim_id] = $value->sumAmount;
                    }else{
                        $ar[$value->claim_id] = 0;
                    }
                }
            }else{
                foreach ($claimsIdArray as $key => $value) {
                    $ar[$value] = 0;
                }
            }

            return $ar;
        }



        public function get_sp_claims_html(Request $request,Claim $sp_cliams_id){

                //code...
                $sp_details['row'] = $sp_cliams_id;
                $tenderSql = Tenders::where('claim_id',$sp_cliams_id->claim_id)->orderBy('created_at','desc');
                $sp_details['tenders'] = $tenderSql->get();
                $sp_details['tenders_count'] = $tenderSql->count();
                $sp_details['files'] = ClaimFiles::select('file_path','file_name')->where('claim_id',$sp_cliams_id->claim_id)->orderBy('sort','desc')->get();

                if(isset(Auth::user()->user_id)){

                    $user_id = Auth::user()->user_id;
                    $sp_details['user_roles'] = UsersRoles::select('user_id','role_id')->where('user_id',$user_id)->first();

                }


                $claim_id = $sp_cliams_id->claim_id;
                $sp_details['progress'] = $this->getProgress([$claim_id]);
                $sp_details['pay'] = $this->payProgress([$claim_id]);
                $sp_details['rest'] = $this->restProgress([$claim_id]);


            $data['_sp_claims_html'] = view('Front_End.category.claim_special_details',$sp_details)->render();

            $data['success']= true;
            return response()->json($data);

        }

        public function get_claims_html(Request $request,Claim $cliams_id){

            $_details['row'] = $cliams_id;
            $tenderSql = Tenders::where('claim_id', $cliams_id->claim_id)->orderBy('created_at','desc');
            $_details['tenders'] = $tenderSql->get();
            $_details['tenders_count'] = $tenderSql->count();
            $_details['files'] = ClaimFiles::select('file_path','file_name')->where('claim_id',$cliams_id->claim_id)->orderBy('sort','desc')->get();

            if(isset(Auth::user()->user_id)){

                $user_id = Auth::user()->user_id;
                $_details['user_roles'] = UsersRoles::select('user_id','role_id')->where('user_id',$user_id)->first();

            }

            $claim_id = $cliams_id->claim_id;
            $_details['progress'] = $this->getProgress([$claim_id]);
            $_details['pay'] = $this->payProgress([$claim_id]);
            $_details['rest'] = $this->restProgress([$claim_id]);

            $data['_claims_html'] = view('Front_End.category.claim_details',$_details)->render();

            $data['success']= true;
            return response()->json($data);

        }

        public function get_claims_history_html(Request $request,Claim $cliams_id){

            $_details['row'] = $cliams_id;
            $tenderSql = Tenders::where('claim_id', $cliams_id->claim_id)->orderBy('created_at','desc');
            $_details['tenders'] = $tenderSql->get();
            $_details['tenders_count'] = $tenderSql->count();
            $_details['files'] = ClaimFiles::select('file_path','file_name')->where('claim_id',$cliams_id->claim_id)->orderBy('sort','desc')->get();

            if(isset(Auth::user()->user_id)){

                $user_id = Auth::user()->user_id;
                $_details['user_roles'] = UsersRoles::select('user_id','role_id')->where('user_id',$user_id)->first();

            }

            $claim_id = $cliams_id->claim_id;
            $_details['progress'] = $this->getProgress([$claim_id]);
            $_details['pay'] = $this->payProgress([$claim_id]);
            $_details['rest'] = $this->restProgress([$claim_id]);

            $data['_claims_html'] = view('Front_End.category.claim_history_details',$_details)->render();

            $data['success']= true;
            return response()->json($data);

        }

        public function m_get_claims_html(Request $request,Claim $cliams_id){

            $_details['row'] = $cliams_id;
            $tenderSql = Tenders::where('claim_id', $cliams_id->claim_id)->orderBy('created_at','desc');
            $_details['tenders'] = $tenderSql->get();
            $_details['tenders_count'] = $tenderSql->count();
            $_details['files'] = ClaimFiles::select('file_path','file_name')->where('claim_id',$cliams_id->claim_id)->orderBy('sort','desc')->get();

            if(isset(Auth::user()->user_id)){

                $user_id = Auth::user()->user_id;
                $_details['user_roles'] = UsersRoles::select('user_id','role_id')->where('user_id',$user_id)->first();

            }

            $claim_id = $cliams_id->claim_id;
            $_details['progress'] = $this->getProgress([$claim_id]);
            $_details['pay'] = $this->payProgress([$claim_id]);
            $_details['rest'] = $this->restProgress([$claim_id]);

            $data['_claims_html'] = view('Front_End.category.m_claim_details',$_details)->render();

            $data['success']= true;
            return response()->json($data);

        }

        public function tender_details(Claim $cliams){

            if(isset(Auth::user()->user_id)){
                $birthday = (isset(Auth::user()->birthday))?Auth::user()->birthday : date('Y-m-d');
                $age = $this->birthday2($birthday);
                if($age < 20){
                    return Redirect::back()->with('ageNotAllow', true);
                }

                if(Auth::user()->user_state != 1){
                    return Redirect::back()->with('userStateNotAllow', true);
                }

                if(Auth::user()->banned == '是'){
                    return Redirect::back()->with('banned_check', 'Profile updated!');
                }else{

                    $user_id = Auth::user()->user_id;

                    $data['user_bank'] = UserBank::where('user_id',$user_id)->get();

                    if(count($data['user_bank']) == 0){

                        return Redirect::back()->with('bank_check', 'Profile updated!');

                    }else{
                        $data['row'] =  $cliams;
                        $data['sum'] = 0;
                        $data['member_number']=[];
                        $id= $data['row']->claim_id;
                        $data['rest'] = $this->restProgress([$id]);

                        foreach($data['row']->claim_tenders as $key=>$value)
                        {
                            $data['sum']+= $value->amount;
                            $buff=(isset($value->tenders_user->member_number))?$value->tenders_user->member_number:'not filled';
                            array_push($data['member_number'],$buff);
                        }
                        $data['sub']=$data['row']->staging_amount - $data['sum'];
                        $data['member_number'] = (isset(Auth::user()->member_number))?Auth::user()->member_number:'not filled';
                        $data['user_id'] = Auth::user()->user_id;
                        $data['order_number']= Tenders::with(['tenders_claim'])->where('claim_id',$id)->orderBy('order_number','desc')->first('order_number');
                        $data['payment_deadline']= SystemVariables::where('variable_name','=','payment_deadline')->get('value');
                        $data['url'] = $_SERVER['HTTP_REFERER'];
                        $data['ispaid'] = Tenders::accountUnPaid(Auth::user()->user_id);
                        return view('Front_End.category.cliam_tender',$data);
                    }
                }
            }
            else{
                return Redirect::back()->withErrors(['請先登入後再進行投標']);
            }
        }
        function birthday2($birthday){
            list($year,$month,$day) = explode("-",$birthday);
            $year_diff = date("Y") - $year;
            $month_diff = date("m") - $month;
            $day_diff  = date("d") - $day;
            if ($day_diff < 0 || $month_diff < 0)
            $year_diff--;
            return $year_diff;
        }

        public function tender_create(Request $request,Claim $cliams){

            // dd($request->all());
            $birthday = (isset(Auth::user()->birthday))?Auth::user()->birthday : date('Y-m-d');
            $age = $this->birthday2($birthday);
            if($age < 20){
                $return['ageNotAllow'] = true;
                return response()->json($return);
            }

            if(isset($request->min)){
                $min_value =$request->min;
            }
            else{
                $min_value =$request->pre_min;
            }
            $claim_total_tender_amount = Tenders::where('claim_id',$request->claim_id)->select(DB::raw('IFNULL(SUM(amount),0) as tenderSum'))->get()->toArray()[0]['tenderSum'];

            $claim_amount = Claim::find($request->claim_id)->staging_amount;

            $canThrow = $claim_amount - $claim_total_tender_amount;
            // dd($request->all());

            $is_pre_invest = Claim::find($request->claim_id)->is_pre_invest;
            $claim_state = Claim::find($request->claim_id)->claim_state;
            

            if($request->amount > $request->max || $request->amount < $min_value){

                if(isset($request->pre_min)){

                    $return['min'] = $request->pre_min;
                    }
                    elseif(isset($request->min)){
                        $return['min'] = $request->min;
                    }
                $return['max'] =  $request->max;
                $return['out_of_range'] = true;
            }elseif($request->amount > $canThrow){
                $return['min'] = $request->min;
                $return['max'] =  $canThrow;
                $return['out_of_range'] = true;
            }elseif($claim_state == '上架預覽' && $is_pre_invest == 1 || $claim_state == '募集中') {
                $id = Auth::user()->user_id;
                $claims = Claim::find($request->claim_id);

                $tender = new Tenders;
                $tender->user_id = $request->user_id;
                $tender->claim_id = $request->claim_id;
                //===
                $order_number = Tenders::with(['tenders_claim'])->where('claim_id',$request->claim_id)->orderBy('order_number','desc')->first('order_number');
                if(isset($order_number)){
                    // if(isset($request->order_number)){
                    $tender->order_number = sprintf("%03d",($order_number->order_number)+1);}
                else{
                    $tender->order_number = sprintf("%03d",1);
                }
                // dd($tender->order_number);

                $tender->amount = $request->amount;
                $tender->created_at = date('Y-m-d H:i:s');
                // $tender->claim_certificate_number = $request->member_number.$request->order_number.$request->claim_number;
                $tender->claim_certificate_number = $request->member_number.$tender->order_number.$request->claim_number;
                $tender->should_paid_at =$claims->payment_final_deadline;

                $tender->save();

    /* -------------------------------------------------------------------------- */

                // $user_name = (isset(Auth::user()->user_name))? Auth::user()->user_name : '';
                // $from = false;
                // $title = 'php-PPonline-投資成功通知';
                // $ctx = ['親愛的'.$user_name.'先生/女士',
                //         '您投資債權'.$claims->claim_number.'成功!',
                //         '您本次投標金額為:'.$tender->amount,
                //         '您的【債權憑證號為:' . $tender->claim_certificate_number .'】',
                //         '投標成功時間:'.$tender->created_at,
                //         '標單繳款期限為:'. $tender->should_paid_at
                //         ];

                // $mailTo = [trim(Auth::user()->email)];
                // foreach ($mailTo as $v) {
                //     $canMail = $this->checkUserCanReciveMail($v);
                //     if($canMail){
                //         Mail::to($v)->send(new SampleMail($ctx,$from,$title));
                //     }
                // }

    /* -------------------------------------------------------------------------- */
                /* ========= 2020-03-30 16:48:56 change by Jason ========= */
                // $change = new MainFLow;
                // $change->runCheckClaimChange($request->claim_id);


                $return['success'] = true;


        }else{
            $return['Error'] = true;
        }

        return response()->json($return);
    }

    /**
     *投資試算API
     */
    public function claim_category_counting(Request $req)
    {
        try {
            $reqData = $req->all();
            $claim_id = $reqData['c_id'];
            $amount = $reqData['amount'];
            $claim_info = Claim::select('remaining_periods','annual_interest_rate','repayment_method','value_date','management_fee_rate')->find($claim_id)->toArray();
            if($claim_info['repayment_method'] == 1 || $claim_info['repayment_method'] =='本息攤還'){
                //本息攤還
                $paymentCount = new equalTotalPayment($claim_info['annual_interest_rate'],$claim_info['remaining_periods'],$amount);
            }else if($claim_info['repayment_method'] == 0 || $claim_info['repayment_method'] =='先息後本'){

                //本金攤還
                $paymentCount = new equalPrincipalPayment($claim_info['annual_interest_rate'],$claim_info['remaining_periods'],$amount);
            }else{
                //錯誤
                return response()->json([
                    'status' => 'error',
                ]);
            }
            $paymentCount = $paymentCount->run();
            /**
            *  'everyMonthPrincipal' => 每月應還本金陣列(本金),
            *  'everyMonthPrincipalBalance' => 每月貸款餘額陣列,
            *  'everyMonthInterest' => 每月應還本息陣列 (利潤),
            *  'everyMonthPaidTotal' => 每月應還本息合計陣列(每期回收),
             */

            $paymentCount['PaidTotalSum'] = array_sum($paymentCount['everyMonthPaidTotal']);
            $paymentCount['InterestSum'] = array_sum($paymentCount['everyMonthInterest']);
            $paymentCount['PrincipallSum'] = array_sum($paymentCount['everyMonthPrincipal']);
            $paymentCount['time'] = $this->getPeriodsTimeArrayNew($claim_info['remaining_periods'],$claim_info['value_date']);
            $paymentCount['fee_rate'] = $claim_info['management_fee_rate'];

            $paymentCount['thirdPartyManagmentFee'] =  $this->thirdPartyManagmentFee($paymentCount['everyMonthInterest'],$paymentCount['fee_rate']);

            


            $ar = [];
            
            foreach ($paymentCount['everyMonthPaidTotal'] as $k=>$v){
                $paymentCount['totala'] = round((float)$paymentCount['everyMonthPaidTotal'][$k]  - (float)$paymentCount['thirdPartyManagmentFee'][$k]);
                array_push($ar,$paymentCount['totala']);
            }
            
            $paymentCount['totala'] = $ar;

            $total['everyMonthPrincipal'] = number_format(array_sum($paymentCount['everyMonthPrincipal']));
            $total['everyMonthInterest'] = number_format(array_sum($paymentCount['everyMonthInterest']));
            $total['thirdPartyManagmentFee'] = number_format(array_sum($paymentCount['thirdPartyManagmentFee']));
            $total['everyMonthPaidTotal'] = number_format(array_sum($paymentCount['everyMonthPaidTotal']));
            $total['totala'] = number_format(array_sum($paymentCount['totala']));

            for($i=0;$i<count($paymentCount['everyMonthPrincipal']);$i++){
                $paymentCount['everyMonthPrincipal'][$i] = number_format($paymentCount['everyMonthPrincipal'][$i]);
                $paymentCount['everyMonthInterest'][$i] = number_format($paymentCount['everyMonthInterest'][$i]);
                $paymentCount['thirdPartyManagmentFee'][$i] = number_format($paymentCount['thirdPartyManagmentFee'][$i]);
                $paymentCount['end'][$i] = number_format(round((float)$paymentCount['everyMonthPaidTotal'][$i]  - (float)$paymentCount['thirdPartyManagmentFee'][$i]));
                $paymentCount['everyMonthPaidTotal'][$i] = number_format(round($paymentCount['everyMonthPaidTotal'][$i]));
                
                $paymentCount['totala'][$i] = number_format($paymentCount['totala'][$i]);
            }
            return response()->json([
                'status' => 'success',
                'data' => $paymentCount,
                'total' => $total
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
            return response()->json([
                'status' => 'error',
            ]);
        }

    }

    /**
     *投資試算API
     */
    public function claim_category_counting_c2(Request $req)
    {
        try {
            $reqData = $req->all();
            
            $t_id = $reqData['t_id'];
            $tender = Tenders::find($t_id);
            $created_at = strtotime($tender->created_at);
            
            $claim_id = $reqData['c_id'];
            $amount = $reqData['amount'];
            $claim_info = Claim::select('remaining_periods','annual_interest_rate','repayment_method','value_date','management_fee_rate')->find($claim_id)->toArray();
            if($claim_info['repayment_method'] == 1 || $claim_info['repayment_method'] =='本息攤還'){
                //本息攤還
                $paymentCount = new equalTotalPayment($claim_info['annual_interest_rate'],$claim_info['remaining_periods'],$amount);
            }else if($claim_info['repayment_method'] == 0 || $claim_info['repayment_method'] =='先息後本'){

                //本金攤還
                $paymentCount = new equalPrincipalPayment($claim_info['annual_interest_rate'],$claim_info['remaining_periods'],$amount);
            }else{
                //錯誤
                return response()->json([
                    'status' => 'error',
                ]);
            }
            $paymentCount = $paymentCount->run();
            /**
            *  'everyMonthPrincipal' => 每月應還本金陣列(本金),
            *  'everyMonthPrincipalBalance' => 每月貸款餘額陣列,
            *  'everyMonthInterest' => 每月應還本息陣列 (利潤),
            *  'everyMonthPaidTotal' => 每月應還本息合計陣列(每期回收),
             */

            $paymentCount['PaidTotalSum'] = array_sum($paymentCount['everyMonthPaidTotal']);
            $paymentCount['InterestSum'] = array_sum($paymentCount['everyMonthInterest']);
            $paymentCount['PrincipallSum'] = array_sum($paymentCount['everyMonthPrincipal']);
            $paymentCount['time'] = $this->getPeriodsTimeArrayNew($claim_info['remaining_periods'],$claim_info['value_date']);
            $paymentCount['fee_rate'] = $claim_info['management_fee_rate'];
            if(strtotime(Auth::user()->discount_start) <= $created_at && strtotime(Auth::user()->discount_close) >= $created_at ){
                $paymentCount['thirdPartyManagmentFee'] =  $this->thirdPartyManagmentFee($paymentCount['everyMonthInterest'],$paymentCount['fee_rate'] * Auth::user()->discount);
            }else{
                $paymentCount['thirdPartyManagmentFee'] =  $this->thirdPartyManagmentFee($paymentCount['everyMonthInterest'],$paymentCount['fee_rate']);
            }
            


            $ar = [];
            
            foreach ($paymentCount['everyMonthPaidTotal'] as $k=>$v){
                $paymentCount['totala'] = round((float)$paymentCount['everyMonthPaidTotal'][$k]  - (float)$paymentCount['thirdPartyManagmentFee'][$k]);
                array_push($ar,$paymentCount['totala']);
            }
            
            $paymentCount['totala'] = $ar;

            $total['everyMonthPrincipal'] = number_format(array_sum($paymentCount['everyMonthPrincipal']));
            $total['everyMonthInterest'] = number_format(array_sum($paymentCount['everyMonthInterest']));
            $total['thirdPartyManagmentFee'] = number_format(array_sum($paymentCount['thirdPartyManagmentFee']));
            $total['everyMonthPaidTotal'] = number_format(array_sum($paymentCount['everyMonthPaidTotal']));
            $total['totala'] = number_format(array_sum($paymentCount['totala']));

            for($i=0;$i<count($paymentCount['everyMonthPrincipal']);$i++){
                $paymentCount['everyMonthPrincipal'][$i] = number_format($paymentCount['everyMonthPrincipal'][$i]);
                $paymentCount['everyMonthInterest'][$i] = number_format($paymentCount['everyMonthInterest'][$i]);
                $paymentCount['thirdPartyManagmentFee'][$i] = number_format($paymentCount['thirdPartyManagmentFee'][$i]);
                $paymentCount['end'][$i] = number_format(round((float)$paymentCount['everyMonthPaidTotal'][$i]  - (float)$paymentCount['thirdPartyManagmentFee'][$i]));
                $paymentCount['everyMonthPaidTotal'][$i] = number_format(round($paymentCount['everyMonthPaidTotal'][$i]));
                
                $paymentCount['totala'][$i] = number_format($paymentCount['totala'][$i]);
            }
            return response()->json([
                'status' => 'success',
                'data' => $paymentCount,
                'total' => $total
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
            return response()->json([
                'status' => 'error',
            ]);
        }

    }

    /**
     *計算手續費 = (甲方利息*10%)四捨五入後 均分於每期 每期將小數位取出只留整數，將小數位總和加至最後一期
     */
    public function thirdPartyManagmentFee($everyMonthArray,$fee_rate)
    {

        $total = array_sum($everyMonthArray);

        // $total = (int)round(0.1 * $total);
        $all_total = round($total * $fee_rate) / 100;
        
        //$avg = $total/count($everyMonthArray);

        $ar = [];
        
        // foreach ($everyMonthArray as $key) {
        for($i = 0;$i < count($everyMonthArray);$i ++){
            if ($all_total >= 0 && $i == count($everyMonthArray)-1) {
                $br = round($all_total);
            }elseif($all_total <= 0){
                if($fee_rate == '0'){
                    $ar[-1] = -1;
                }
                if($all_total <= 0 && $ar[$i-1] > 0){
                    $ar[$i-1] = round($ar[$i-1] + $all_total);
                }
                $br = 0;
            }else{

                $brr = ($everyMonthArray[$i] * $fee_rate) / 100;
                $br = round($brr);
                $all_total =  $all_total - $br;
            }
            
            array_push($ar, $br);
        }
        unset($ar[-1]);
        $common = new Common;
        $res = $common->sumToLastMonth($ar);
        return $res;
    }
    //取得分期日期陣列 起息日+1個月開始
    public function getPeriodsTimeArrayNew($periods,$startDay)
    {
        $result = [];
        if($periods == 'NotSet'){
            return $result;
        }else{
            $now = strtotime(date('Y-m-d',strtotime($startDay)));
            $i=1;
            $ilength = (int)$periods + 1;
            for($i;$i<$ilength;$i++){
                array_push($result,date('Y-m-d',strtotime("+".$i." month",$now)));
            }
            return $result;
        }
    }
}
