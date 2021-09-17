<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;
use App\Exports\UsersExport;

use App\Mail\MailTo;
use App\UsersRoles;
use App\UserBank;
use DB;

class WeeklyController extends Controller
{
    //前台
    public function index()
    {
        $userBankCheck = UserBank::checkUserBank(Auth::user()->user_id);
        
        //銀行是否確認
        if($userBankCheck === false){
            return redirect('/users/tab_two')->with('bank_check', 'Profile updated!');
        }
        $weekly['banned']= false;
        $weekly['permission']= false;
        $weekly['cant_repeat10']= false;

        //是否警示戶
        if (Auth::user()->banned == 1) {
            $weekly['banned']= true;
        }
        //是否為管理者
        $role = UsersRoles::where('user_id', Auth::user()->user_id)->first()->role_id;
        if ($role == 2) {
            $weekly['permission']= true;
        }
        //10分鐘後方可申請
        $weekly_time = DB::select('SELECT * FROM `log_evweekly` WHERE `l_e_user` = ? and  `l_e_updated_at` >=  ADDDATE("'.date('Y-m-d H:i:s').'",INTERVAL -10 minute) AND "'.date('Y-m-d H:i:s').'" >= `l_e_updated_at`', [Auth::user()->user_id]);
        if (!empty($weekly_time)){
            $weekly['cant_repeat10']= true;
        }
        
        if(!Auth::check()){
            if (Auth::user()->user_state !== 1) {
                return Redirect::back()->with('userStateNotAllow', true);
        }
            return Redirect::back()->with('pdferror', true);
        }

        $weekly['weekly'] =  DB::select('SELECT * FROM `log_evweekly` WHERE `l_e_user` = ? and `l_e_check` in (2,4) ',[Auth::user()->user_id]);
        $role = UsersRoles::where('user_id', Auth::user()->user_id)->first()->role_id;
        if(Auth::user()->user_state == 1 && $role !== 2){
            if(empty($weekly['weekly'])){
                $weekly['weekly'] =  DB::select('SELECT * FROM `log_evweekly` WHERE `l_e_user` = ? and `l_e_check` = 0 ',[Auth::user()->user_id]);
                if (!empty($weekly['weekly'])){
                    $weekly['weekly']= true;
                }else{
                    $weekly['weekly']= false;
                }
                return view('Front_End.weekly.weekly_claim_category_panel',$weekly);
            }else{
                return view('Front_End.weekly.weekly_claim_category_audited',$weekly);
            }
        }elseif($role == 2){
            return Redirect::back()->with('user_state_not_consent',true);
        }else{
            return Redirect::back()->with('cannotGoHabit',true);
        }
        
    }

    //申請週週投
    public function insert(Request $requset)
    {
        $m = new MailTo;

        if (Auth::user()->banned == 1) {
            return response()->json([
                'status' => 'banned',
            ]);
        }
        $role = UsersRoles::where('user_id', Auth::user()->user_id)->first()->role_id;
        if ($role == 2) {
            return response()->json([
                'status' => 'permission',
            ]);
        }
        $weekly = DB::select('SELECT * FROM `log_evweekly` WHERE `l_e_user` = ? and  `l_e_updated_at` >=  ADDDATE("'.date('Y-m-d H:i:s').'",INTERVAL -10 minute) AND "'.date('Y-m-d H:i:s').'" >= `l_e_updated_at`', [Auth::user()->user_id]);
        if (!empty($weekly)){
            return response()->json([
                'status' => 'cant_repeat10',
            ]);
        }
        $userBankCheck = UserBank::checkUserBank(Auth::user()->user_id);
        if($userBankCheck === false){
            return redirect('/users/tab_two')->with('bank_check', 'Profile updated!');
        }
        $requset['amount'] = intval($requset['amount']);
        if(Auth::check()){
            if(Auth::user()->user_state == 1){
                if(is_numeric($requset['amount'])){
                    if ($requset['amount']>=5000&&$requset['amount']%1000==0&&$requset['amount']<=30000) {
                        $weekly = DB::select('SELECT * FROM `log_evweekly` WHERE `l_e_user` = ? and `l_e_check` in (0,2)', [Auth::user()->user_id]);
                        if (empty($weekly)) {
                            DB::insert('INSERT INTO `log_evweekly`(`l_e_user`,`l_e_amount`, `l_e_check`, `l_e_ip`, `l_e_time` ,`l_e_updated_at`) VALUES (?,?,?,?,?,?)', [Auth::user()->user_id,$requset['amount'],0,$requset->ip(),date('Y-m-d H:i:s'),date('Y-m-d H:i:s')]);
                            $m->pp_weekly_review(Auth::user()->user_name);
                            $res['status'] = "success";
                        } else {
                            $res['status'] = "repeat";
                        }
                    }else{
                        $res['status'] = "amount_error";
                    }
                }else{
                    $res['status'] = "not_amount";
                }
                
            }else{
                $res['status'] = "no_purview";
            }
        }else{
            $res['status'] = "no_user";
        }

        return response()->json($res);
    }

    //取消/修改週週投
    public function Front_update(Request $requset)
    {
        $m = new MailTo;

        if (Auth::user()->banned == 1) {
            return response()->json([
                'status' => 'banned',
            ]);
        }
        $role = UsersRoles::where('user_id', Auth::user()->user_id)->first()->role_id;
        if ($role == 2) {
            return response()->json([
                'status' => 'permission',
            ]);
        }
        if ($requset['radio']==2) {
            $weekly = DB::select('SELECT * FROM `log_evweekly` WHERE `l_e_user` = ? and  `l_e_updated_at` >=  ADDDATE("'.date('Y-m-d H:i:s').'",INTERVAL -10 minute) AND "'.date('Y-m-d H:i:s').'" >= `l_e_updated_at`', [Auth::user()->user_id]);
            if (!empty($weekly)) {
                return response()->json([
                'status' => 'cant_repeat10',
            ]);
            }
        }
        $userBankCheck = UserBank::checkUserBank(Auth::user()->user_id);
        if($userBankCheck === false){
            return redirect('/users/tab_two')->with('bank_check', 'Profile updated!');
        }
        $requset['amount'] = intval($requset['amount']);
        if(Auth::check()){
            if(Auth::user()->user_state == 1){
                //取消週週投
                if($requset['radio']==1){
                    DB::update('UPDATE `log_evweekly` SET l_e_check = 3 , l_e_updated_at = ? WHERE l_e_user =? and l_e_id = ?',[date('Y-m-d H:i:s'),Auth::user()->user_id,$requset['id']]);
                    $m->pp_weekly_cancel(Auth::user()->user_id);
                    $res['status'] = "success";
                //恢復週週投    
                }elseif($requset['radio'] == 3){
                    DB::update('UPDATE `log_evweekly` SET l_e_check = 2 , l_e_updated_at = ? WHERE l_e_user =? and l_e_id = ?',[date('Y-m-d H:i:s'),Auth::user()->user_id,$requset['id']]);
                    $res['status'] = "success";
                //暫停週週投    
                }elseif($requset['radio'] == 4){
                    DB::update('UPDATE `log_evweekly` SET l_e_check = 4 , l_e_updated_at = ? WHERE l_e_user =? and l_e_id = ?',[date('Y-m-d H:i:s'),Auth::user()->user_id,$requset['id']]);
                    $res['status'] = "success";
                }else{
                    if (is_numeric($requset['amount'])) {
                        if ($requset['amount']>=5000&&$requset['amount']%1000==0&&$requset['amount']<=30000) {
                            if ($requset['radio']==2) {
                                DB::update('UPDATE `log_evweekly` SET  l_e_amount = ? , l_e_updated_at = ? WHERE l_e_user =? and l_e_id = ?', [$requset['amount'],date('Y-m-d H:i:s'),Auth::user()->user_id,$requset['id']]);
                            }
                            
                            $res['status'] = "success";
                        } else {
                            $res['status'] = "amount_error";
                        }
                    } else {
                        $res['status'] = "not_amount";
                    }
                }
                
                
            }else{
                $res['status'] = "no_purview";
            }
        }else{
            $res['status'] = "no_user";
        }

        return response()->json($res);
    }

    //後台
    public function back_index()
    {
        $data['weekly'] =  DB::select('SELECT u.member_number , u.user_name , wk.*, (SELECT count(td.claim_certificate_number) FROM  tender_documents td  WHERE td.tender_document_state = 0 AND wk.l_e_id = td.l_e_id) as count_c_c , (SELECT sum(td.amount) FROM  tender_documents td  WHERE td.tender_document_state = 0 AND wk.l_e_id = td.l_e_id) as all_amount FROM `log_evweekly` wk , users u  WHERE u.user_id = wk.l_e_user ORDER BY wk.l_e_time DESC limit 0,25');
        $data['weekly2'] =  DB::select('SELECT u.user_name , wk.* FROM `log_evweekly` wk , users u  WHERE u.user_id = wk.l_e_user');
        
        
        foreach ($data['weekly2'] as $k => $v){
            $data['weekly_tenders_sum'][$v->l_e_id] =  DB::select('SELECT count(claim_certificate_number) as count FROM tender_documents WHERE l_e_id = ?',[$v->l_e_id]);
            if($v->l_e_check == 2 || $v->l_e_check == 3){
                $weekly_tenders = DB::select('SELECT claim_certificate_number FROM tender_documents WHERE tender_document_state = 0 AND l_e_id = ?',[$v->l_e_id]);
                if(!empty($weekly_tenders)){
                    $data['weekly_detail'][$v->l_e_id]['claim_certificate_number'] = $weekly_tenders;
                }
                
            }
        }

        $data['page_count'] = ceil(count($data['weekly2'])/25);
        
        $data['checkArray'][0] = '未審';
        $data['checkArray'][1] = '未通過';
        $data['checkArray'][2] = '通過';
        $data['checkArray'][3] = '取消';
        $data['checkArray'][4] = '暫停';

        $data['claims_sum'] = DB::select('SELECT sum(staging_amount) as staging_amount FROM claims WHERE weekly_time is not null and claim_state = 0 and weekly_time >= ?',[date('Y-m-d H:i:s')]);
        $data['weekly_sum'] = DB::select('SELECT sum(l_e_amount) as l_e_amount FROM `log_evweekly` WHERE l_e_check = 2');
        $data['un_weekly_sum'] = DB::select('SELECT sum(amount) as un_amount FROM `tender_documents` WHERE l_e_id is not null and tender_document_state = 0');
        $data['user_count_sum'] = DB::select('SELECT count(l_e_id) as user_count FROM `log_evweekly` WHERE l_e_check = 2');
        
        return view('Back_End.weekly.weekly_panel',$data);
        
        
    }

    public function search(Request $req) {

        $download = ((isset($req->download)))?true:false;

        //紀錄排序
        $sequence = $req->all()['sequence'];
        //紀錄一頁幾筆
        $number_page = $req->all()['number_page'];

        
        if(empty($number_page)){
            $number_page = 25;
        }

        $page = 0;
        if(!empty($req->all()['page'])){
            $page = $req->all()['page']-1;
            $page = $page * $number_page; 
        }
        $search['member_number'] = $req->all()['member_number'];
        $search['user_name'] = $req->all()['user_name'];
        $search['l_e_check'] = $req->all()['l_e_check'];
        $search['l_e_time_start'] = $req->all()['l_e_time_start'];
        $search['l_e_time_end'] = $req->all()['l_e_time_end'];
        $search['l_e_updated_at_start'] = $req->all()['l_e_updated_at_start'];
        $search['l_e_updated_at_end'] = $req->all()['l_e_updated_at_end'];

        $sql_user_name = '';
        $sql_l_e_check = '';
        $sql_paid_at = '';
        $sql_staged_at = '';

        if (isset($search['user_name'])) {
            $sql_user_name = " and u.user_name LIKE '%".$search['user_name']."%'";
        }
        if (isset($search['member_number'])) {
            $sql_user_name = " and u.member_number LIKE '%".$search['member_number']."%'";
        }
        
        if (isset($search['l_e_check'])) {
            $sql_l_e_check = " and wk.l_e_check LIKE '%".$search['l_e_check']."%'";
        }

        if (isset($search['l_e_time_start']) && isset($search['l_e_time_end'])) {
            $sql_paid_at = "and wk.l_e_time Between '".$search['l_e_time_start']."' and '".$search['l_e_time_end']."'";
        }
        if (isset($search['l_e_updated_at_start']) && isset($search['l_e_updated_at_end'])) {
            $sql_staged_at = "and wk.l_e_updated_at Between '".$search['l_e_updated_at_start']."' and '".$search['l_e_updated_at_end']."'";
        }
            
        $page_count = DB::select("SELECT wk.*,u.member_number,u.user_name ,(SELECT count(td.claim_certificate_number)  FROM  tender_documents td  WHERE td.tender_document_state = 0 AND wk.l_e_id = td.l_e_id) as count_c_c , (SELECT sum(td.amount) FROM  tender_documents td  WHERE td.tender_document_state = 0 AND wk.l_e_id = td.l_e_id) as all_amount FROM log_evweekly wk , users u  WHERE  wk.l_e_user = u.user_id  $sql_user_name $sql_l_e_check $sql_paid_at $sql_staged_at GROUP BY wk.l_e_user");
    
        $sql_orderby='';

        if(empty($sequence)){
            $sql_orderby = 'ORDER BY wk.l_e_time DESC';
            
        }elseif($sequence == 1){
            $sql_orderby = 'ORDER BY u.user_name ASC';
            
        }elseif($sequence == -1){
            $sql_orderby = 'ORDER BY u.user_name DESC';
            
        }elseif($sequence == 2){
            $sql_orderby = 'ORDER BY wk.l_e_amount ASC';
            
        }elseif($sequence == -2){
            $sql_orderby = 'ORDER BY wk.l_e_amount DESC';
            
        }elseif($sequence == 3){
            $sql_orderby = 'ORDER BY count_c_c ASC';
            
        }elseif($sequence == -3){
            $sql_orderby = 'ORDER BY count_c_c DESC';
            
        }elseif($sequence == 4){
            $sql_orderby = 'ORDER BY wk.l_e_time ASC';
            
        }elseif($sequence == -4){
            
            $sql_orderby = 'ORDER BY wk.l_e_time DESC';
           
        }elseif($sequence == 5){
            $sql_orderby = 'ORDER BY wk.l_e_updated_at ASC';
            
        }elseif($sequence == -5){
            
            $sql_orderby = 'ORDER BY wk.l_e_updated_at DESC';
           
        }elseif($sequence == 6){
            $sql_orderby = 'ORDER BY all_amount ASC';
            
        }elseif($sequence == -6){
            
            $sql_orderby = 'ORDER BY all_amount DESC';
           
        }elseif($sequence == 7){
            $sql_orderby = 'ORDER BY member_number ASC';
            
        }elseif($sequence == -7){
            
            $sql_orderby = 'ORDER BY member_number DESC';
           
        }
        $checkArray = [];
        $checkArray[0] = '未審';
        $checkArray[1] = '未通過';
        $checkArray[2] = '通過';
        $checkArray[3] = '取消';
        $checkArray[4] = '暫停';


        if($download){
            //下載
            $weekly_excel = $this->excelData($page_count);
            $myFile = Excel::download( new UsersExport($weekly_excel), '匯出週週投名單_'.date('Y-m-d').'.csv');

            return $myFile;
        }else{
            $data = DB::select("SELECT wk.*,u.member_number,u.user_name,(SELECT count(td.claim_certificate_number)  FROM  tender_documents td  WHERE td.tender_document_state = 0 AND  wk.l_e_id = td.l_e_id ) as count_c_c , (SELECT sum(td.amount) FROM  tender_documents td  WHERE td.tender_document_state = 0 AND wk.l_e_id = td.l_e_id) as all_amount FROM log_evweekly wk , users u  WHERE wk.l_e_user = u.user_id  $sql_user_name $sql_l_e_check $sql_paid_at $sql_staged_at $sql_orderby limit $page,$number_page ");
            $count = 0;
            $res = [];
            $res['data']= [];
            if (isset($data[0]->user_name)) {
                foreach ($data as $k => $v) {
                    if ($v->l_e_check == 2) {
                        $button = '<td id = "user_button'.$v->l_e_id.'" onclick="show_user_detail('.$v->l_e_id.')" class="details-control sorting_1"></td>';
                    } else {
                        $button = '<td></td>';
                    }
                    $res['data'][$count]['button'] = $button;
                    $res['data'][$count]['user_name'] = $v->user_name;
                    $res['data'][$count]['member_number'] = $v->member_number;
                    $res['data'][$count]['l_e_amount'] = $v->l_e_amount;
                    $res['data'][$count]['all_amount'] = $v->all_amount?$v->all_amount:'0';
                    $res['data'][$count]['count'] = $v->count_c_c;

                    
                    
                    $res['data'][$count]['button2'] = '<span id="reason_word'.$v->l_e_id.'" style="font-size: 14px">'.$checkArray[$v->l_e_check].'</span>';
                    if($v->l_e_check == 0){
                        $res['data'][$count]['button2'] .='<button id="button_reject'.$v->l_e_id.'" style="margin-left:5px;font-size: 12px;padding: 4px 10px;" class="btn btn-info"
                                                            onclick="update_check_type('.$v->l_e_id.',1)">未通過</button>
                                                        <button id="button_agree'.$v->l_e_id.'" style="margin-left:5px;font-size: 12px;padding: 4px 10px;" class="btn btn-info"
                                                            onclick="update_check_type('.$v->l_e_id.',2)">通過</button>
                                                            <button id="button_cancel'.$v->l_e_id.'" style="margin-left:5px;font-size: 12px;padding: 4px 10px;display:none;" class="btn btn-info"
                                                            onclick="update_check_type('.$v->l_e_id.',3)">取消</button>
                                                        <button id="button_stop'.$v->l_e_id.'" style="margin-left:5px;font-size: 12px;padding: 4px 10px;display:none;" class="btn btn-info"
                                                            onclick="update_check_type('.$v->l_e_id.',4)">暫停</button>';
                    }elseif($v->l_e_check == 2)  {
                        $res['data'][$count]['button2'] .= '<button id="button_reject'.$v->l_e_id.'" style="margin-left:5px;font-size: 12px;padding: 4px 10px;display:none;" class="btn btn-info"
                                                            onclick="update_check_type('.$v->l_e_id.',1)">未通過</button>
                                                        <button id="button_agree'.$v->l_e_id.'" style="margin-left:5px;font-size: 12px;padding: 4px 10px;display:none;" class="btn btn-info"
                                                            onclick="update_check_type('.$v->l_e_id.',2)">通過</button>
                                                            <button id="button_cancel'.$v->l_e_id.'" style="margin-left:5px;font-size: 12px;padding: 4px 10px;" class="btn btn-info"
                                                            onclick="update_check_type('.$v->l_e_id.',3)">取消</button>
                                                        <button id="button_stop'.$v->l_e_id.'" style="margin-left:5px;font-size: 12px;padding: 4px 10px;" class="btn btn-info"
                                                            onclick="update_check_type('.$v->l_e_id.',4)">暫停</button>';
                    }elseif($v->l_e_check == 4)  {
                        $res['data'][$count]['button2'] .= '<button id="button_reject'.$v->l_e_id.'" style="margin-left:5px;font-size: 12px;padding: 4px 10px;display:none;" class="btn btn-info"
                                                            onclick="update_check_type('.$v->l_e_id.',1)">未通過</button>
                                                        <button id="button_agree'.$v->l_e_id.'" style="margin-left:5px;font-size: 12px;padding: 4px 10px;" class="btn btn-info"
                                                            onclick="update_check_type('.$v->l_e_id.',2)">通過</button>
                                                            <button id="button_cancel'.$v->l_e_id.'" style="margin-left:5px;font-size: 12px;padding: 4px 10px;display:none;" class="btn btn-info"
                                                            onclick="update_check_type('.$v->l_e_id.',3)">取消</button>
                                                        <button id="button_stop'.$v->l_e_id.'" style="margin-left:5px;font-size: 12px;padding: 4px 10px;display:none;" class="btn btn-info"
                                                            onclick="update_check_type('.$v->l_e_id.',4)">暫停</button>';
                    }
    
                    $res['data'][$count]['l_e_time'] = $v->l_e_time;
                    $res['data'][$count]['l_e_updated_at'] = $v->l_e_updated_at;
                    $res['data'][$count]['id'] = $v->l_e_id;
                    $res['data'][$count]['claim_certificate_number'] = null;
                    if ($v->l_e_check == 2 || $v->l_e_check == 3) {
                        $weekly_tenders = DB::select('SELECT claim_certificate_number FROM tender_documents WHERE tender_document_state = 0 AND l_e_id = ?', [$v->l_e_id]);
                        if (!empty($weekly_tenders)) {
                            $res['data'][$count]['claim_certificate_number'] = $weekly_tenders;
                        }
                    }
    
                    $count ++;
                }
            }
        
        
            //計算頁數
            $res{'count'} = ceil(count($page_count)/$number_page);
            return response()->json($res);
        }

    }

    public function excelData($data)
    {
        $Tenders_export = [];
        $Tenders_export[0][0] = '申請人';
        $Tenders_export[0][1] = '申請金額';
        $Tenders_export[0][2] = '這週已媒合金額';
        $Tenders_export[0][3] = '這週媒合件數';
        $Tenders_export[0][4] = '創建時間';
        $Tenders_export[0][5] = '修改時間';
        $Tenders_export[0][6] = '標單編號';
    
        
        $count = 1;
        foreach($data as $row)
        {
            $Tenders_export[$count][0] = $row->user_name;
            $Tenders_export[$count][1] = $row->l_e_amount;
            $Tenders_export[$count][2] = $row->count_c_c?$row->count_c_c:'0';
            $Tenders_export[$count][3] = $row->all_amount?$row->all_amount:'0';
            $Tenders_export[$count][4] = $row->l_e_time;
            $Tenders_export[$count][5] = $row->l_e_updated_at;
            $count2 = 6;
            if ($row->l_e_check == 2 || $row->l_e_check == 3) {
                $weekly_tenders = DB::select('SELECT claim_certificate_number FROM tender_documents WHERE l_e_id = ?', [$row->l_e_id]);
                if (!empty($weekly_tenders)) {
                    foreach($weekly_tenders as $k => $v){
                        $Tenders_export[$count][$count2] = $v->claim_certificate_number;
                        $count2++;
                    }
                }
            }
            
            $count++;

        }
        return $Tenders_export;
    }

    public function update(Request $req){

        $m = new MailTo;

        $req['id'];
        $req['l_e_check'];
        $res['success'] = false;
        
        if(!empty($req['id'])){
            if(isset($req['l_e_check'])){

                $user = DB::select('SELECT * FROM `log_evweekly` WHERE l_e_id = ? and  l_e_check <> ?',[$req['id'],$req['l_e_check']]);

                if(!empty($user)){

                    $res['success'] = DB::update('UPDATE `log_evweekly` SET l_e_check = ? , l_e_updated_at = ? WHERE l_e_id =?',[$req['l_e_check'],date('Y-m-d H:i:s'),$req['id']]);

                
                    //審核通過
                    if($req['l_e_check']==2 && $user[0]->l_e_check!==4){
                        $m->pp_weekly_agree($user[0]->l_e_user);
                    //駁回
                    }elseif($req['l_e_check']==1){
                        $m->pp_weekly_reject($user[0]->l_e_user);
                    }
    
                    if(!empty($res['success'])) { $res['success'] = true;}        

                }

            }
        }
        return response()->json($res);
    }
}
