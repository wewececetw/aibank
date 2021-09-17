<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;
use App\Imports\UsersImport;
use Carbon\Carbon;
use App\Tenders;
use App\Claim;
use Lang;
use DB;

class Buying_backController extends Controller
{
    public function index()
    {

        return view('Back_End.buying_back.buying_back_panel');
    }
    public function index_o_c()
    {
        $page_count = 1;
        return view('Back_End.buying_back.buying_back_o_c_panel',['page_count'=>$page_count]);
    }

    public function index_c_p()
    {
        $page_count = 1;
        return view('Back_End.buying_back.buying_back_c_p_panel',['page_count'=>$page_count]);
    }

    public function update(Request $request)
    {

        $fileTypeName = $request->file('select_file')->getClientOriginalExtension();
        if ($fileTypeName != 'xlsx' && $fileTypeName != 'xls') {
            return Redirect::back()->withErrors(['您所匯入的檔案格式錯誤']);
        }
        $buying_back_l = Lang::get('buying_back');
        $buying_back = [];
        foreach ($buying_back_l as $k => $v){
            $buying_back[$v] = $k;
        }
        
        DB::beginTransaction();
        $toArray = Excel::toArray(new UsersImport, request()->file('select_file'));
        $count_cc = [];
        $count_c = [];
        try {
            foreach ($toArray[0] as $k => $v) {
                if ($k != 0) {
                    if ($v[0] !='' && $v[1] !='' && $v[2] !='' && $v[3] !='' && $v[4] !== '' && $v[5] !== '' && $v[6] !== '' && $v[7] !=='' && $v[8] !='') {
                        
                        if (empty($count_cc[$v[0]])) {
                            $count_cc[$v[0]] = $v[0];
                            $count_c[$v[0]] = 0;
                        }

                        if ($count_cc[$v[0]] == $v[0]) {
                            $count_c[$v[0]] ++;
                        }

                        $target_repayment_date = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($v[1]));
                        $paid_at = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($v[2]));

                        $user_bank_id =  DB::select('SELECT ub.user_bank_id FROM `user_bank` ub ,`tender_documents` td WHERE ub.user_id = td.user_id and ub.is_active = 1 and td.`claim_certificate_number` = ? ', [$v[0]]);

                        $tender_documents =  DB::select('SELECT * FROM `tender_documents` WHERE `claim_certificate_number` = ? ', [$v[0]]);

                        $tender_documents_b_b_remove =  DB::select('SELECT * FROM `tender_documents_b_b_remove` WHERE `claim_certificate_number` = ? ', [$v[0]]);
                        // print_r($tender_documents_b_b_remove);exit;

                        $tender_repayments = DB::select('SELECT * FROM `tender_repayments` WHERE `tender_documents_id` = (SELECT `tender_documents_id` FROM `tender_documents` WHERE `claim_certificate_number` = ?) and `period_number` = ? ', [$v[0],$v[3]]);
                    
                        $tender_repayments_remove = DB::select('SELECT * FROM `tender_repayments_remove` WHERE `tender_documents_id` = (SELECT `tender_documents_id` FROM `tender_documents` WHERE `claim_certificate_number` = ?) and `period_number` = ? ', [$v[0],$v[3]]);
                        
                        // if (empty($tender_documents_b_b_remove)&&$count_c[$v[0]] >= 1) {
                        
                            if (!empty($tender_documents)) {

                            //將tender_documents轉陣列
                                $temp1_d= json_encode($tender_documents);
                                $temp2_d= json_decode($temp1_d);

                                $data_d = "('";
                                foreach ($temp2_d[0] as $k => $y) {
                                    if ($k == 'l_e_id' && $y === null) {
                                        $data_d = substr($data_d, 0, -1);
                                        $data_d .= "NULL)";
                                    } elseif ($k == 'l_e_id') {
                                        $data_d .= $y."')";
                                    } elseif ($y === null) {
                                        $data_d = substr($data_d, 0, -1);
                                        $data_d .= "NULL,'";
                                    } else {
                                        $data_d .= $y."','";
                                    }
                                }
                                if ($count_c[$v[0]] == 1) {
                                    $tender_documents_b_b = DB::insert("INSERT INTO `tender_documents_b_b_remove` VALUES $data_d");
                                    echo $tender_documents_b_b;
                                }

                                if (empty($tender_repayments_remove)) {
                                    if (!empty($tender_repayments)) {
                                        $pusher_detail = DB::select('SELECT * FROM `pusher_detail` WHERE `repayment_id` = ?', [$tender_repayments[0]->tender_repayment_id]);
                                        //將tender_repayments轉陣列
                                        $temp1_r= json_encode($tender_repayments);
                                        $temp2_r= json_decode($temp1_r);

                                        $data_r = "('";
                                        foreach ($temp2_r[0] as $k => $y) {
                                            if ($k == 'buying_back_type') {
                                                $data_r .= $y."')";
                                            } elseif ($y === null) {
                                                $data_r = substr($data_r, 0, -1);
                                                $data_r .= "NULL,'";
                                            } else {
                                                $data_r .= $y."','";
                                            }
                                        }
                                        $tender_repayments_r = DB::insert("INSERT INTO `tender_repayments_remove` VALUES $data_r");
                                        echo $tender_repayments_r;

                                        if (!empty($pusher_detail)) {

                                        //將pusher_detail轉陣列
                                            $temp1_p= json_encode($pusher_detail);
                                            $temp2_p= json_decode($temp1_p);

                                            $data_p = "('";
                                            foreach ($temp2_p[0] as $k => $y) {
                                                if ($k == 'p_d_user_id') {
                                                    $data_p .= $y."')";
                                                } elseif ($y === null) {
                                                    $data_p = substr($data_p, 0, -1);
                                                    $data_p .= "NULL,'";
                                                } else {
                                                    $data_p .= $y."','";
                                                }
                                            }
                                            $pusher_detail_r = DB::insert("INSERT INTO `pusher_detail_remove` VALUES $data_p");
                                            echo $pusher_detail_r;

                                            $pusher_detail_up = DB::update('update pusher_detail set current_balance = 0 , benefits_amount =0 WHERE repayment_id = ?',[$tender_repayments[0]->tender_repayment_id]);
                                            echo $pusher_detail_up;

                                           
                                        }
                                        if ($count_c[$v[0]] == 1) {
                                            $tender_documents_up =  DB::update('update `tender_documents` set tender_document_state = 4 WHERE `claim_certificate_number` = ?', [$v[0]]);
                                            echo$tender_documents_up;
                                        }

                                        $tender_repayments_up =  DB::update('update `tender_repayments` set user_bank_id = ? , tender_repayment_state = 2 , net_amount = per_return_principal , per_return_principal = ? , real_return_amount = ? , management_fee = ? , per_return_interest = ? , target_repayment_date = ? , paid_at = ? , invoice_at = ? , credited_at = ? , buying_back_type = ? WHERE `tender_documents_id` in(SELECT tender_documents_id FROM `tender_documents` WHERE `claim_certificate_number` = ?) and `period_number` = ?', [$user_bank_id[0]->user_bank_id,$v[5],$v[7],$v[4],$v[6], $target_repayment_date, $paid_at, $paid_at, $paid_at , $buying_back[$v[8]], $v[0], $v[3]]);
                                        echo $tender_repayments_up;
                                    } else {
                                        DB::rollback();
                                        return Redirect::back()->withErrors(['標單'.$v[0].'第'.$v[3].'期查無資訊，請重新檢查']);
                                    }
                                } else {
                                    DB::rollback();
                                    return Redirect::back()->withErrors(['標單'.$v[0].'第'.$v[3].'期已買回過']);
                                }
                            } else {
                                DB::rollback();
                                return Redirect::back()->withErrors(['標單'.$v[0].'查無資料']);
                            }
                        // } else {
                        //     DB::rollback();
                        //     return Redirect::back()->withErrors(['標單'.$v[0].'已買回過']);
                        // }
                    } else {
                        DB::rollback();
                        return Redirect::back()->withErrors(['有欄位為空白']);
                    }
                }
            }
        DB::commit();
        return redirect('admin/buying_back')->with('import_success');
        } catch (\Throwable $th) {
            $this->logg('Error',["ERROR MSG" => $th]);
            DB::rollback();
            return Redirect::back()->withErrors(['標單'.$v[0].'第'.$v[3].'期內容有誤']);
        }
    }
    public function download(){

        $file = public_path() . "/downloadable/買回範例.xlsx";
        $headers = array(
            'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        );

        return response()->download($file, '買回範例.xlsx', $headers);

    }

    public function search(Request $request){
        $buying_back_Array = Lang::get('buying_back');
        if(!empty($request['claim_certificate_number'])){
            $count = 0;
            $row_data =  DB::select('SELECT * FROM `tender_repayments` WHERE `tender_documents_id` = (SELECT `tender_documents_id` FROM `tender_documents` WHERE `claim_certificate_number` = ?)',[$request['claim_certificate_number']]);
            foreach ($row_data as $key => $value) {
                $Tenders = new Tenders;
                $tender_document_state = DB::select('SELECT `tender_document_state` FROM `tender_documents` WHERE `tender_documents_id` = ?',[$value->tender_documents_id]);
                $res['tender'][$count]['tender_document_state'] = $Tenders->getTenderDocumentStateAttribute($tender_document_state[0]->tender_document_state);
                $res['tender'][$count]['period_number'] = $value->period_number;
                $res['tender'][$count]['target_repayment_date'] = $value->target_repayment_date;
                $res['tender'][$count]['per_return_principal'] = $value->per_return_principal;
                $res['tender'][$count]['per_return_interest'] = $value->per_return_interest;
                $res['tender'][$count]['management_fee'] = $value->management_fee;
                $res['tender'][$count]['real_return_amount'] = $value->real_return_amount;
                $res['tender'][$count]['paid_at'] = $value->paid_at;
                $res['tender'][$count]['credited_at'] = $value->credited_at;
                $res['tender'][$count]['invoice_at'] = $value->invoice_at;
                $res['tender'][$count]['buying_back_type'] = $buying_back_Array{$value->buying_back_type};
                $count++;
            }
            $count_p = 0;
            $row_data_p = DB::select('select td.claim_certificate_number,
                                    u.user_name,
                                    c.repayment_method,
                                    td.tender_document_state,
                                    td.amount,
                                    p.current_balance,
                                    p.commission_interest_rate,
                                    tr.period_number,
                                    p.benefits_amount,
                                    tr.target_repayment_date,
                                    tr.credited_at,
                                    p.target_repayment_date
                                    FROM pusher_detail p , 
                                        users u,
                                        claims c,
                                        tender_documents td,
                                        tender_repayments tr
                                    where p.claim_certificate_number = ? and p.repayment_id = tr.tender_repayment_id and td.claim_certificate_number = p.claim_certificate_number and c.claim_id = p.claim_id and p.user_id = u.user_id',[$request['claim_certificate_number']]);
            foreach ($row_data_p as $key => $value) {
                $Claim = new Claim;
                $Tenders = new Tenders;
                $res['pusher'][$count_p]['claim_certificate_number'] = $value->claim_certificate_number;
                $res['pusher'][$count_p]['user_name'] = $value->user_name;
                $res['pusher'][$count_p]['repayment_method'] = $Claim->getRepaymentMethodAttribute($value->repayment_method);
                $res['pusher'][$count_p]['dstate'] = $Tenders->getTenderDocumentStateAttribute($value->tender_document_state);
                $res['pusher'][$count_p]['amount'] = $value->amount;
                $res['pusher'][$count_p]['current_balance'] = $value->current_balance;
                $res['pusher'][$count_p]['commission_interest_rate'] = floatval(($value->commission_interest_rate) * 100);
                $res['pusher'][$count_p]['period_number'] = $value->period_number;
                $res['pusher'][$count_p]['benefits_amount'] = $value->benefits_amount;
                $res['pusher'][$count_p]['r_target_repayment_date'] = $value->target_repayment_date;
                $res['pusher'][$count_p]['r_credited_at'] = $value->credited_at;
                $res['pusher'][$count_p]['target_repayment_date'] = $value->target_repayment_date;
                $count_p++;
            }
           
        }
        return response()->json($res);
    }

    //取消一鍵買回查詢
    public function search_c_p(Request $request){

        $buying_back_l = Lang::get('buying_back');
        $Claim = new Claim;
        //紀錄排序
        $sequence = $request->all()['sequence'];
        //紀錄一頁幾筆
        $number_page = $request->all()['number_page'];
        
        
        if(empty($number_page)){
            $number_page = 25;
        }

        $needBetween = false;
        $page = 0;
        if (!empty($request->all()['page'])) {
            $page = $request->all()['page']-1;
            $page = $page * $number_page;
        }

        $data =  $request->except(['sequence','number_page','page']);
        $sqlstr = '';
        foreach ($data as $key => $value) {
            if (isset($value)) {
                $search[$key] = $value;
                switch ($key) {
                    case 'launched_at_start':
                    case 'launched_at_end':
                    case 'closed_at_start':
                    case 'closed_at_end':
                    case 'value_date_start':
                    case 'value_date_end':
                    case 'weekly_time_start':
                    case 'weekly_time_end':    
                        $needBetween = true;
                        break;

                    default:
                        $sqlstr .= ' and c.'.$key. ' like "%' . $value . '%"';
                        break;
                }
            }
        }

        if ($needBetween) {
            if (isset($search['launched_at_start']) && isset($search['launched_at_end'])) {
                $sqlstr.= ' and c.launched_at BETWEEN "'.$search['launched_at_start'].'" and "'.$search['launched_at_end'].'"';
            }
            if (isset($search['closed_at_start']) && isset($search['closed_at_end'])) {
                $sqlstr.= ' and c.estimated_close_date BETWEEN "'.$search['closed_at_start'].'" and "'.$search['closed_at_end'].'"';
            }
            if (isset($search['value_date_start']) && isset($search['value_date_end'])) {
                $sqlstr.= " and c.value_date BETWEEN '".$search['value_date_start']."' AND '".$search['value_date_end']."' ";
            }
            if (isset($search['weekly_time_start']) && isset($search['weekly_time_end'])) {
                $sqlstr.= ' and c.weekly_time BETWEEN "'.$search['weekly_time_start'].'" and "'.$search['weekly_time_start'].'"';
            }
        }
        $oderdata = '';
        if(empty($sequence)){
            $oderdata = ' order by c.created_at desc limit '.$page.','.$number_page;
        }elseif($sequence == 1){
            $oderdata = ' order by c.claim_number asc limit '.$page.','.$number_page;
        }elseif($sequence == -1){
            $oderdata = ' order by c.claim_number desc limit '.$page.','.$number_page;
        }elseif($sequence == 2){
            $oderdata = ' order by c.serial_number asc limit '.$page.','.$number_page;
        }elseif($sequence == -2){
            $oderdata = ' order by c.serial_number desc limit '.$page.','.$number_page;
        }elseif($sequence == 3){
            $oderdata = ' order by c.claim_state asc limit '.$page.','.$number_page;
        }elseif($sequence == -3){
            $oderdata = ' order by c.claim_state desc limit '.$page.','.$number_page;
        }elseif($sequence == 4){
            $oderdata = ' order by c.number_of_sales asc limit '.$page.','.$number_page;
        }elseif($sequence == -4){
            $oderdata = ' order by c.number_of_sales desc limit '.$page.','.$number_page;
        }elseif($sequence == 5){
            $oderdata = ' order by c.staging_amount asc limit '.$page.','.$number_page;
        }elseif($sequence == -5){
            $oderdata = ' order by c.staging_amount desc limit '.$page.','.$number_page;
        }elseif($sequence == 6){
            $oderdata = ' order by c.periods asc limit '.$page.','.$number_page;
        }elseif($sequence == -6){
            $oderdata = ' order by c.periods desc limit '.$page.','.$number_page;
        }elseif($sequence == 7){
            $oderdata = ' order by tender_sum_amount asc limit '.$page.','.$number_page;
        }elseif($sequence == -7){
            $oderdata = ' order by tender_sum_amount desc limit '.$page.','.$number_page;
        }elseif($sequence == 8){
            $oderdata = ' order by c.is_display asc limit '.$page.','.$number_page;
        }elseif($sequence == -8){
            $oderdata = ' order by c.is_display desc limit '.$page.','.$number_page;
        }elseif($sequence == 9){
            $oderdata = ' order by c.foreign_t asc limit '.$page.','.$number_page;
        }elseif($sequence == -9){
            $oderdata = ' order by c.foreign_t desc limit '.$page.','.$number_page;
        }elseif($sequence == 10){
            $oderdata = ' order by c.weekly_time asc limit '.$page.','.$number_page;
        }elseif($sequence == -10){
            $oderdata = ' order by c.weekly_time desc limit '.$page.','.$number_page;
        }elseif($sequence == 11){
            $oderdata = ' order by t_amount asc limit '.$page.','.$number_page;
        }elseif($sequence == -11){
            $oderdata = ' order by t_amount desc limit '.$page.','.$number_page;
        }

        $page_count = DB::SELECT("SELECT c.claim_number,c.serial_number,c.claim_state,c.number_of_sales,c.periods,(SELECT SUM(`amount`) FROM `tender_documents` td WHERE `claim_id` = c.claim_id and `tender_document_state` in (1,2,4,6)) as t_amount,c.foreign_t,c.weekly_time,sbb.target_repayment_date,sbb.paid_at,sbb.buying_back_type,c.claim_id,c.value_date,sbb.s_b_b_ok  FROM claims c , schedule_buying_back sbb WHERE sbb.s_b_b_claims = c.claim_id $sqlstr group by sbb.s_b_b_claims");

        $data = DB::SELECT("SELECT c.claim_number,c.serial_number,c.claim_state,c.number_of_sales,c.periods,(SELECT SUM(`amount`) FROM `tender_documents` td WHERE `claim_id` = c.claim_id and `tender_document_state` in (1,2,4,6)) as t_amount,c.foreign_t,c.weekly_time,sbb.target_repayment_date,sbb.paid_at,sbb.buying_back_type,c.claim_id,c.value_date,sbb.s_b_b_ok FROM claims c , schedule_buying_back sbb WHERE sbb.s_b_b_claims = c.claim_id $sqlstr group by sbb.s_b_b_claims $oderdata");
        $res = [];
        $count = 0;
        $res['data']= [];
        $b_b_ok[0] = '未執行';
        $b_b_ok[1] = '已執行';
        foreach ($data as $k => $v){
            $res['data'][$count]['claim_number'] = $v->claim_number;
            $res['data'][$count]['serial_number'] = $v->serial_number;
            $res['data'][$count]['claim_state'] = $Claim->getClaimStateAttribute($v->claim_state);
            $res['data'][$count]['current_amount'] = $v->t_amount?$v->t_amount:'0';
            $res['data'][$count]['foreign_t'] = $Claim->getForeignTAttribute($v->foreign_t);
            $res['data'][$count]['weekly_time'] = ($v->weekly_time)?$v->weekly_time:'非週週投債權';
            $res['data'][$count]['value_date'] = $v->value_date;
            $res['data'][$count]['t_g_r_d_input'] = $v->target_repayment_date;
            $res['data'][$count]['p_d_input'] = $v->paid_at;
            $res['data'][$count]['b_b_type_input'] = $buying_back_l[$v->buying_back_type];
            if($v->s_b_b_ok == 0){
                $b_b_cancel_bt = '<button  class="btn btn-success" onclick="buy_back_cancel(' . $v->claim_id .')">取消</button>';
            }else{
                $b_b_cancel_bt = '';
            }
            $res['data'][$count]['b_b_cancel_bt'] = $b_b_cancel_bt;
            $res['data'][$count]['b_b_ok'] = $b_b_ok[$v->s_b_b_ok];
            $res['data'][$count]['detail_button'] = '<a target="_blank" href="/admin/claim_details/' . $v->claim_id . '" class="btn btn-info"><i style="margin-right: 0px;" class="fa fa-fw fa-eye"></i> </a>';
            $count++;
        }

        //計算頁數
        $res{'count'} = ceil(count($page_count)/$number_page) ;
        return response()->json($res);
        
    }

    //一鑑買回
    public function o_c_post(Request $request){
        $error =0;
        if(empty($request['claim_id'])){ $error =1; }
        if(empty($request['password'])){ $error =2; }
        if(empty($request['t_g_r_d_input'])){ $error =3; }
        if(empty($request['p_d_input'])){ $error =4; }
        if(empty($request['b_b_type_input'])){ $error =5; }
        if($error == 0 ){
            if( strtotime($request['t_g_r_d_input']) < strtotime($request['p_d_input'])){ $error =10; }
        }
        if($error == 0 ){
            $user_data =  DB::select('SELECT * FROM account where a_password =?',[$request['password']]);
            if(count($user_data) > 0 ){
                foreach ($user_data as $key => $value) {
                    $claim_schedule_data =  DB::select('SELECT * FROM schedule_buying_back where s_b_b_ok = 0 and s_b_b_claims  =?',[$request['claim_id']]);
                    if(count($claim_schedule_data) > 0 ){ $error =9;}
                    $claim_data =  DB::select('SELECT * FROM claims where claim_state = 4 and claim_id =?',[$request['claim_id']]);
                    if(count($claim_data) <= 0 ){ $error =7;}
                    if($error == 0 ){
                        foreach ($claim_data as $c => $cvalue) {
                            DB::insert("INSERT INTO log_event (l_e_who,l_e_event,l_e_ip,l_e_time) VALUES (?,?,?,?)",[ $value->a_name,"買回債權-".$cvalue->claim_number,$_SERVER["REMOTE_ADDR"],date("Y-m-d H:i:s",strtotime("+0min"))]);
                        }
                    }
                }
            }else{ $error =6;}
        }
        if($error == 0 ){
            $td_data = DB::select('SELECT * FROM tender_documents where tender_document_state = 2 and claim_id =?',[$request['claim_id']]);
            if(count($td_data) > 0 ){
                foreach ($td_data as $td => $tdvalue) {
                    $u_data = DB::select('SELECT user_bank_id FROM user_bank where user_id =?',[$tdvalue->user_id]);
                    foreach ($u_data as $u => $uu) {
                        $ubid = $uu->user_bank_id;
                    }
                    DB::insert("INSERT INTO schedule_buying_back (s_b_b_claims,s_b_b_td,buying_back_type,target_repayment_date,paid_at,s_b_b_creat,s_b_b_update,claim_certificate_number,user_bank_id) VALUES (?,?,?,?,?,?,?,?,?)",[ $request['claim_id'] , $tdvalue->tender_documents_id,$request['b_b_type_input'],$request['t_g_r_d_input'],$request['p_d_input'],date("Y-m-d H:i:s",strtotime("+0min")) , "0000-00-00 00:00:00", $tdvalue->claim_certificate_number,$ubid]);
                }
            }else{ $error =8;}
            if($error == 0 ){
                echo "成功買回債權-".$cvalue->claim_number;
            }
        }
        if($error == 1 ){ echo "資料錯誤";}
        if($error == 2 ){ echo "請輸入買回密碼";}
        if($error == 3 ){ echo "請輸入預定入帳日";}
        if($error == 4 ){ echo "請輸入實際入帳日";}
        if($error == 5 ){ echo "請輸入買回類別";}
        if($error == 6 ){ echo "買回密碼錯誤";}
        if($error == 7 ){ echo "債權無法被買回";}
        if($error == 8 ){ echo "無可買回標單";}
        if($error == 9 ){ echo "債權已被買回";}
        if($error == 10 ){ echo "實際入帳日不得比預定入帳日晚";}
    }

    //取消一鑑買回
    public function c_p_post(Request $request)
    {
        $t = 0;
        if(empty($request['claim_id'])){ $t =1; }
        if(empty($request['password'])){ $t =2; }

            if($t==0){
                $user_data = DB::SELECT("SELECT * FROM `account` WHERE `a_password` = ? ",[$request['password']]);
                if(!empty($user_data)){
                    foreach ($user_data as $key => $value){
                        $check =  DB::select('SELECT * FROM `schedule_buying_back` where `s_b_b_claims`  =?',[$request['claim_id']]);
                        if(empty($check)){$t = 6;}
                        $claim_schedule_data =  DB::select('SELECT * FROM `schedule_buying_back` where `s_b_b_ok` = 1 and `s_b_b_claims`  =?',[$request['claim_id']]);
                        if(!empty($claim_schedule_data)){$t = 4;}
                        $claim_data = DB::SELECT("SELECT `claim_number` FROM `claims` where `claim_state` = 4 and `claim_id` = ? ",[$request['claim_id']]);
                        if(empty($claim_data)){$t = 5;}
                        if($t==0){
                            DB::DELETE("DELETE FROM `schedule_buying_back` WHERE `s_b_b_ok` = 0 and `s_b_b_claims` = ?",[$request['claim_id']]);
                            foreach ($claim_data as $k => $v){
                                DB::insert("INSERT INTO `log_event` (`l_e_who`,`l_e_event`,`l_e_ip`,`l_e_time`) VALUES (?,?,?,?)",[ $value->a_name,"取消買回債權-".$v->claim_number,$request->ip(),date("Y-m-d H:i:s",strtotime("+0min"))]);
                            }
                        }
                        
                    }
                }else{
                    $t = 3;
                }
            }
            if($t == 0 ){
                echo "成功取消買回債權-".$claim_data[0]->claim_number;
            }

        if($t == 1 ){ echo "資料錯誤";}
        if($t == 2 ){ echo "請輸入買回密碼";}
        if($t == 3 ){ echo "買回密碼錯誤";}
        if($t == 4 ){ echo "買回已執行不可取消";}
        if($t == 5 ){ echo "債權狀態已結案不可取消";}
        if($t == 6 ){ echo "查無此買回";}
    }
    
    //對帳報表
    public function ex1_get(Request $request)
    {
        $data = DB::SELECT("SELECT 
                        td.`claim_certificate_number`,
                        c.claim_number,
                        c.serial_number,
                        c.remaining_periods,
                        u.member_number,
                        u.user_name,
                        tr.target_repayment_date,
                        tr.period_number,
                        tr.management_fee,
                        tr.per_return_principal,
                        tr.per_return_interest,
                        tr.real_return_amount
                    FROM `tender_repayments` tr , `tender_documents` td, `claims` c , `users` u 
                    WHERE td.`tender_documents_id` = tr.`tender_documents_id` and c.claim_state in(4,5) and td.tender_document_state in(2,4) and
                    c.`claim_id` = td.`claim_id` and td.`user_id` = u.`user_id`
                    and tr.target_repayment_date >= '".$request['t_g_r_d_input']."' and c.`claim_id` = ".$request['claim_id']);
            $st = '<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />';
            $per_return_principal = 0;
            $count = 0;


            /////////////////////命名檔案名稱///////////////////////
            if($request['b_b_type_input']==1){
                $f_t = '結清買回';
            }else{
                $f_t = '逾期買回';
            }
            
            /////////////////////命名檔案名稱///////////////////////
            if(!empty($data)){
                foreach($data as $k => $v){
                    if($count == 0 && $v->period_number == $data[0]->period_number){
                        $st .= $this->table_moblie_haeder();
                        $st .= $this->table_moblie_detail_h($v);
                        $periods1 = $v->period_number+1;
                    }else{
                        if(date('Y-m-d H:i:s',strtotime($request['t_g_r_d_input']))==$data[0]->target_repayment_date){
                            $per_return_principal += $v->per_return_principal;
                            $st .= $this->table_moblie_detail($v,$v->period_number,$request['t_g_r_d_input'],$request['p_d_input'],$periods1,$per_return_principal);
                        }else{
                            $st .= $this->table_moblie_error($request['t_g_r_d_input'],$data[0]->target_repayment_date);
                        }
                    }
                    $count++;
                    if($v->remaining_periods == $v->period_number){
                        $count=0;
                        $per_return_principal = 0;
                    }
                }   
                $filename = $data[0]->serial_number.$f_t."出帳明細.xls"; 
            }else{
                $st .= $this->table_moblie_haeder();
                $st .='<tr>
                            <td colspan="14" style="color:red">  
                            查無資料預定入帳日有誤請檢查'.$request['t_g_r_d_input'].'
                            </td>
                       </tr>
                       </table>';
                $filename = "輸入預定入帳日錯誤出帳明細.xls"; 
            }

            
            
            // exit;
            
            \header("Content-Type: application/vnd.ms-excel; name='excel'");
            \header("Content-type: application/octet-stream");
            \header("Content-Disposition: attachment; filename=" . $filename);
            \header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            \header("Pragma: no-cache");
            \header("Expires: 0");
            
             // $header = mb_convert_encoding($header , "big5", "UTF-8");
             echo $st;
            //  echo $header;
            //  exit;
            //  return redirect('admin/buying_back_o_c');

    }

    //銀行報表
    public function ex2_get(Request $request)
    {
        $data = DB::SELECT("SELECT 
                        td.`claim_certificate_number`,
                        c.serial_number,
                        c.remaining_periods,
                        tr.per_return_principal,
                        u.user_name,
                        u.user_id,
                        tr.target_repayment_date,
                        tr.period_number,
                        u.id_card_number
                    FROM `tender_repayments` tr , `tender_documents` td, `claims` c , `users` u 
                    WHERE td.`tender_documents_id` = tr.`tender_documents_id`
                     and c.claim_state in(4,5) and td.tender_document_state in(2,4) 
                     and c.`claim_id` = td.`claim_id` and td.`user_id` = u.`user_id`
                    and tr.target_repayment_date >= '".$request['t_g_r_d_input']."' and c.`claim_id` = ".$request['claim_id']." ");

        $user_id = [];            
        foreach ($data as $k => $v){
            $user_id[$v->user_id] = $v->user_id;
        }

        $user_st = '';
        foreach ($user_id as $k => $v){
            $user_st .= $k.',';
        }
        $user_st = substr($user_st,0,-1);
        $user_bank = DB::SELECT("SELECT 
                                LPAD(bl.bank_code,3,0) as bank_code,
                                LPAD(bl.bank_branch_code,4,0) as bank_branch_code,
                                u.user_id,
                                ub.bank_account
                                FROM  `users` u , `user_bank` ub , `bank_lists` bl
                                WHERE  ub.`bank_id` = bl.`bank_id` and ub.is_active = 1 and ub.`user_id` = u.`user_id` and u.`user_id` in ($user_st)");
        $user_bank_data = [];                        
        foreach ($user_bank as $k => $v){
            $bank_account[$v->user_id] = $v->bank_account; 
            $bank_code[$v->user_id] = $v->bank_code; 
            $bank_branch_code[$v->user_id] = $v->bank_branch_code; 
        }
        
        $count = 0;
        $user_data = [];
        $header = "\xEF\xBB\xBF";
        $header .= "標單編號,出款日期,收款金額,收款帳號,收款戶名,收款總行,收款分行,識別碼類別,識別碼,手續費負擔別,通知方式,FAX傳真號碼,E-mail,Address,FXML,URL,銷帳參考資料,附言\n";

        //會員計數
        $user_count = 0;
        if(!empty($data)){
            foreach($data as $k => $v){
                if ($count==0 && $v->period_number == $data[0]->period_number) {

                    if(!empty($user_data[$user_count][$v->user_id])){
                        $user_count++; 
                    }

                    $user_data[$user_count][$v->user_id]['claim_certificate_number'] = $v->claim_certificate_number;
                    $user_data[$user_count][$v->user_id]['bank_account'] = $bank_account[$v->user_id];
                    $user_data[$user_count][$v->user_id]['user_name'] = $v->user_name;
                    $user_data[$user_count][$v->user_id]['bank_code'] = $bank_code[$v->user_id];
                    $user_data[$user_count][$v->user_id]['bank_branch_code'] = $bank_branch_code[$v->user_id];
                    $user_data[$user_count][$v->user_id]['id_card_number'] = $v->id_card_number;
                    $user_data[$user_count][$v->user_id]['per_return_principal'] = 0;
                }else{
                    $user_data[$user_count][$v->user_id]['per_return_principal'] += $v->per_return_principal;
                }
                $count++;
                if ($v->remaining_periods == $v->period_number) {
                    $count = 0;
                }
            }     
    
            // print_r($user_data);
            
            if(date('Y-m-d H:i:s',strtotime($request['t_g_r_d_input']))==$data[0]->target_repayment_date){
                foreach ($user_data as $k => $v) {
                    foreach ($v as $key => $value) {
                        $header .= $value['claim_certificate_number'].','.$request['p_d_input'].','.$value['per_return_principal'].",'".$value['bank_account'].",".$value['user_name'].",'".$value['bank_code'].",'".$value['bank_branch_code'].',53'.','.$value['id_card_number'].',15'.',0'."\n";
                    }
                }
            }else{
                $header .= "輸入的預定入帳日有誤您輸入的為->".$request['t_g_r_d_input']."債權資料的為->".$data[0]->target_repayment_date;
            }
            $serial_number = $data[0]->serial_number;
        }else{
            $header .= "查無資料輸入的預定入帳日有誤您輸入的為->".$request['t_g_r_d_input'];
            $serial_number = '輸入預定入帳日錯誤';
        }
        
        
        \header("Content-type:text/x-csv;charset=utf-8");
        \header("Content-Disposition: attachment; filename=".$serial_number."元大銀行付款轉換檔.csv");
        // $header = mb_convert_encoding($header , "big5", "UTF-8");
        
        echo $header;
        exit;



    }
    //報表table_header
    public function table_moblie_haeder () {


        
        return'
        <table cellspacing="0" cellpadding="10" border="1">
            <tr>
            <td width="140" align="center" valign="center">標單編號</td>
            <td width="140" align="center" valign="center">債權編號</td>
            <td width="140" align="center" valign="center">會員名稱</td>
            <td width="140" align="center" valign="center">流水號</td>
            <td width="140" align="center" valign="center">會員編號</td>
            <td width="140" align="center" valign="center">預計還款日</td>
            <td width="140" align="center" valign="center">銀行入帳日</td>
            <td width="140" align="center" valign="center">實際還款日</td>
            <td width="140" align="center" valign="center">期數</td>
            <td width="140" align="center" valign="center">手續費</td>
            <td width="140" align="center" valign="center">本金</td>
            <td width="140" align="center" valign="center">利息</td>
            <td width="140" align="center" valign="center">淨利</td>
            <td width="140" align="center" valign="center">發票開立日期</td>
            <td width="140" align="center" valign="center">是否退款</td>
            </tr>';

        
    }

    //報表table_detail_開頭
    public function table_moblie_detail_h ($data) {


      
        
        return'<tr>
            <td align="center" valign="center">'.$data->claim_certificate_number.'</td>
            <td align="center" valign="center">'.$data->claim_number.'</td>
            <td align="center" valign="center">'.$data->user_name.'</td>
            <td align="center" valign="center">'.$data->serial_number.'</td>
            <td align="center" valign="center">'.$data->member_number.'</td>
            <td align="center" valign="center">'.$data->target_repayment_date.'</td>
            <td align="center" valign="center"></td>
            <td align="center" valign="center"></td>
            <td align="center" valign="center">'.$data->period_number.'</td>
            <td align="center" valign="center">'.$data->management_fee.'</td>
            <td align="center" valign="center">'.$data->per_return_principal.'</td>
            <td align="center" valign="center">'.$data->per_return_interest.'</td>
            <td align="center" valign="center">'.$data->real_return_amount.'</td>
            <td align="center" valign="center"></td>
            <td align="center" valign="center"></td>
        </tr>';

        
    }

    //報表table_detail_防呆錯誤訊息
    public function table_moblie_error ($t_g_r_d_input,$target_repayment_date) {


      
        
        return'<tr>
            <td colspan="15" align="center" valign="center">輸入的預定入帳日有誤您輸入的為->'.$t_g_r_d_input.'債權資料的為->'.$target_repayment_date.'</td>
        </tr>';

        
    }

    //報表table_detail
    function table_moblie_detail ($data,$count,$t_g_r_d_input,$p_d_input,$periods1,$principal_total) {


      
        
        $st = '<tr>
            <td align="center" valign="center">'.$data->claim_certificate_number.'</td>
            <td align="center" valign="center">'.$data->claim_number.'</td>
            <td align="center" valign="center">'.$data->user_name.'</td>
            <td align="center" valign="center">'.$data->serial_number.'</td>
            <td align="center" valign="center">'.$data->member_number.'</td>
            <td align="center" valign="center" style="color:red">'.date('Y-m-d H:i:s',strtotime($t_g_r_d_input)).'</td>
            <td align="center" valign="center" style="color:red">'.date('Y-m-d H:i:s',strtotime($p_d_input)).'</td>
            <td align="center" valign="center" style="color:red">'.date('Y-m-d H:i:s',strtotime($p_d_input)).'</td>
            <td align="center" valign="center">'.$data->period_number.'</td>
            <td align="center" valign="center" style="color:red">0</td>
            <td align="center" valign="center">'.$data->per_return_principal.'</td>
            <td align="center" valign="center" style="color:red">0</td>
            <td align="center" valign="center" style="color:red">'.$data->per_return_principal.'</td>
            <td align="center" valign="center" style="color:red">'.date('Y-m-d H:i:s',strtotime($p_d_input)).'</td>
            <td align="center" valign="center">x</td>
        </tr>';

        
        if($count==$data->remaining_periods){
            $st .='
                <tr style="border:0px">
                    <td align="center" style="border:0px" valign="center" colspan = "9"></td>
                    <td align="center" style="border:0px" valign="center" >退還'.$periods1.'~'.$data->remaining_periods.' 期本金</td>
                    <td align="center" style="border:0px" valign="center" >'.$principal_total.'</td>
                    <td align="center" style="border:0px" valign="center"></td>
                    <td align="center" style="border:0px" valign="center"></td>
                    <td align="center" style="border:0px" valign="center"></td>
                    <td align="center" style="border:0px" valign="center"></td>
                </tr>    
            </table> <br>';
            
        
        }
        return $st;
    }
}



