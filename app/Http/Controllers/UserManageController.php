<?php

namespace App\Http\Controllers;

use App\BankList;
use App\CustomSettings;
use App\RoiSettings;
use App\User;
use App\UserBank;
use App\InboxLetters;
use App\log_internal_letters;
use App\Letters;
use App\Order;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserManageController extends Controller
{
    /**
     * 使用者的投資設定與default組合
     */
    public function combineUserHabitWithDefault($user_id)
    {
        $default = config('customSettingParams');
        $uData = CustomSettings::select(
            "roi_setting_id",
            "a_percent",
            "b_percent",
            "c_percent",
            "d_percent",
            "e_percent")->where('user_id', $user_id)->orderBy('created_at', 'desc')->first()->toArray();
        $uD = [
            'roi_setting_id' => $uData['roi_setting_id'],
        ];
        foreach ($uData as $k => $u) {
            if ($u !== 0) {
                $uD[$k] = $u;
            }
        }

        foreach ($default as $key => $v) {
            if ($v['roi_setting_id'] == $uD['roi_setting_id']) {
                $default[$key] = $uD;
            }
        }
        return $default;
    }

    //投資習慣設定
    public function habit()
    {
        /* ========= 2020-03-19 17:59:44 change by Jason START========= */
        $check = CustomSettings::where('user_id', Auth::user()->user_id)->get();
        if (count($check) == 0 || Auth::user()->user_state != 1) {
            session()->flash('cannotGoHabit', '123');
            return redirect()->back();
        } else {
                $roiSetData = RoiSettings::all()->toArray();
            try {
                $defaultSetting = $this->combineUserHabitWithDefault(Auth::user()->user_id);
                $roi_id = CustomSettings::where('user_id', Auth::user()->user_id)->orderBy('created_at', 'desc')->first()->roi_setting_id;
            } catch (\Throwable $th) {
                $defaultSetting = config('customSettingParams');
                $roi_id = 1;

            }

            return view('Front_End.user_manage.habit.habit_panel', [
                'defaultSetting' => json_encode($defaultSetting),
                'roi_id' => $roi_id,
                'roiSetData' => $roiSetData
            ]);
        }
        /* ========= 2020-03-19 17:59:44 change by Jason END========= */
    }

    /**
     * 儲存投資習慣設定
     */
    public function habitSave(Request $req)
    {
        try {
            $reqAll = $req->all();
            $cus_id = CustomSettings::select('custom_settings_id')->where('user_id', Auth::user()->user_id)->first()->custom_settings_id;
            $model = CustomSettings::find($cus_id);
            foreach ($reqAll as $key => $value) {
                $model[$key] = $value;
            }
            $model->updated_at = date('Y-m-d H:i:s');
            $model->save();
            return response()->json([
                'status' => 'success',
                'roi_setting_id' => $model['roi_setting_id'],
                'a_percent' => $model['a_percent'],
                'b_percent' => $model['b_percent'],
                'c_percent' => $model['c_percent'],
                'd_percent' => $model['d_percent'],
                'e_percent' => $model['e_percent'],
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error'
            ]);
        }

    }
    //修改密碼
    public function change_password()
    {

        return view('Front_End.user_manage.change_password.change_password_panel');

    }
    public function change_confirmation(Request $request)
    {
        $id = Auth::user()->user_id;
        $user = DB::table('users')->where('user_id', $id)->first();

        $ori = $user->encrypted_password;

        $ori_password = $request->origin_password;
        if (Hash::check($ori_password, $ori)) {

            // $check = User::where('encrypted_password',$ori_password)->get();
            // dd( $ori_password);
            $row_data['encrypted_password'] = Hash::make($request->password_set);
            $row_data['updated_at'] = date('Y-m-d H:i:s');
            DB::table('users')->where('user_id', $id)->update($row_data);
            $return['success'] = true;
        } else {
            $return['wrong'] = true;
        }

        return response()->json($return);

    }

    //繳款
    public function payment(User $user)
    {
        $nt=date("Y-m-d");
        $check = CustomSettings::where('user_id', Auth::user()->user_id)->get();
        $user_id = Auth::user()->user_id;
        $data['user'] = DB::select('SELECT
                                    u.user_id as user_id,
                                    u.member_number as member_number,
                                    u.virtual_account as virtual_account,
                                    u.user_name as user_name,
                                    LPAD(bl.bank_code,3,0) as bank_code,
                                    bl.bank_name as bank_name,
                                    bl.bank_branch_code as bank_branch_code,
                                    bl.bank_branch_name as bank_branch_name,
                                    ub.bank_account as bank_account
                                FROM
                                    users AS u
                                LEFT JOIN user_bank AS ub
                                ON
                                    ub.user_id = u.user_id
                                LEFT JOIN bank_lists AS bl
                                ON
                                    bl.bank_id = ub.bank_id
                                WHERE
                                    ub.is_active = 1 AND
                                    u.user_id = '.$user_id.'');
        if (!empty($data['user'])) {
            if (count($check) == 0 || Auth::user()->user_state != 1) {
                session()->flash('cannotGoHabit', '123');
                return redirect()->back();
            } else {
                $user_id = Auth::user()->user_id;

                $data['bank'] = BankList::select('bank_code', 'bank_name')->distinct()->get();

                $data['user_bank'] = UserBank::with('userbank_banklist')->where('user_id', $user_id)->get();

                // $data['user'] = User::select('virtual_account')->where('user_id', $user_id)->first();
                $data['user'] = (new User)->getUserBankAccountInfo($user_id);
            
                //$data['orders'] = (new Order)->getUserOrder($user_id);
                $data['orders'] = DB::select("select *,o.created_at cc from orders o,tender_documents td  where td.order_id =o.order_id and td.user_id = '".$user_id."' and td.tender_document_state in(1,2,4,5) and td.should_paid_at >'".$nt."' order by o.created_at desc");
                $data['totalAmount'] = 0;
                $data['tenders_count'] = 0;
                $nid = '';
                foreach ($data['orders'] as $v) {
                    //echo $v->order_id."-".$v->expected_amount."==".$data['totalAmount']."<br>";
                    if ($v->order_id != $nid) {
                        $data['totalAmount'] += $v->expected_amount;
                        $nid = $v->order_id;
                    }
                    $data['tenders_count'] ++;
                }

                return view('Front_End.user_manage.payment.payment_panel', $data);
            }
        }else{
            session()->flash('cannotGobank', '123');

            return redirect('users/tab_two');
        }
    }

    //我的收藏
    public function favorite()
    {

        return view('Front_End.user_manage.favorite.favorite_panel');

    }

     //會員信件
     public function inbox_letters()
     {
        //重複的sql
        $sql = '(SELECT count(*) FROM `log_internal_letters` WHERE internal_letter_id = aa.`internal_letter_id` and `user_id`= ? and isDisplay = 0)';
        //查詢是否隱藏的訊息包含自己的身分別、單一屬於自己的信、全部類別信
        $letters = DB::select("SELECT * FROM `internal_letters` aa  where aa.`user_ids` = ?  AND $sql = 0 and aa.isDisplay = 1 and aa.created_at  >=  ADDDATE(?,INTERVAL -1 minute) or aa.`user_ids` = -4 and aa.isDisplay = 1 and aa.created_at  >=  ADDDATE(?,INTERVAL -1 minute)  AND $sql = 0 or aa.`user_ids` = ? and aa.isDisplay = 1 and aa.created_at  >=  ADDDATE(?,INTERVAL -1 minute) AND $sql = 0 ORDER BY aa.created_at desc",[Auth::user()->user_id,Auth::user()->user_id,Auth::user()->approved_at,Auth::user()->approved_at,Auth::user()->user_id,0-Auth::user()->user_identity,Auth::user()->approved_at,Auth::user()->user_id]);
        //帶入log紀錄中的觀看時間
        $read_at = [];
        foreach ($letters as $k){

            $sql_read = DB::select("SELECT read_at FROM `log_internal_letters` WHERE internal_letter_id = ? and `user_id`= ? and isDisplay = 1",[$k->internal_letter_id,Auth::user()->user_id]);
            //存在帶入data不存在帶入空值
            if(!empty($sql_read)){
                $read_at[$k->internal_letter_id] = $sql_read[0]->read_at;
            }else{
                $read_at[$k->internal_letter_id] = null;
            }
            
        }
        
        return view('Front_End.user_manage.inbox_letters.inbox_letters_panel',[
            'letters' => $letters ,'read_at'=> $read_at
        ]);
     }

     public function check_letters(Letters $letter)
     {
        //查詢是否有觀看log
        $log_letters2 = DB::select(" SELECT * FROM `log_internal_letters` WHERE `internal_letter_id` = ? and `user_id` = ? ",[$letter->internal_letter_id,Auth::user()->user_id]);

        if($letter->isDisplay != 1){
            return redirect()->back();
        }else{
            //存在的話修改觀看時間
            if (!empty($log_letters2)) {
                if ($log_letters2[0]->isDisplay != 1) {
                    return redirect()->back();
                } else {
                    if ($letter->user_ids != Auth::user()->user_id && $letter->user_ids != 0-Auth::user()->user_identity && $letter->user_ids != -4) {
                        return redirect()->back();
                    // ->with('dontReadOtherPeopleMail',true);
                    } else {
                    
                    //存在的話修改觀看時間
                        
                        DB::update(" UPDATE `log_internal_letters` SET `read_at` = ?, `updated_at` = ?  WHERE `internal_letter_id` = ? and `user_id` = ? ", [date('Y-m-d H:i:s'),date('Y-m-d H:i:s'),$letter->internal_letter_id,Auth::user()->user_id]);
                        
                        //查詢log表中的觀看時間
                        $sql_read = DB::select("SELECT read_at FROM `log_internal_letters` WHERE `internal_letter_id` = ? and `user_id`= ? and isDisplay = 1", [$letter->internal_letter_id,Auth::user()->user_id]);
        
                        //存在帶入data不存在帶入空值
                        if (!empty($sql_read)) {
                            $read_at = $sql_read[0]->read_at;
                        } else {
                            $read_at = null;
                        }
                    
                        return view('Front_End.user_manage.inbox_letters.check_letters_panel', [
                        'letter' => $letter , 'read_at'=> $read_at
                    ]);
                    }
                }
            }else{
                if ($letter->user_ids != Auth::user()->user_id && $letter->user_ids != 0-Auth::user()->user_identity && $letter->user_ids != -4) {
                    return redirect()->back();
                // ->with('dontReadOtherPeopleMail',true);
                } else {
                    //不存在的話新增log
                    $log_letters = new log_internal_letters;
                    $log_letters->user_id = Auth::user()->user_id;
                    $log_letters->internal_letter_id = $letter->internal_letter_id;
                    $log_letters->read_at = date('Y-m-d H:i:s');
                    $log_letters->isDisplay = 1;
                    $log_letters->created_at = date('Y-m-d H:i:s');
                    $log_letters->updated_at = date('Y-m-d H:i:s');
                    $log_letters->save();

                    //查詢log表中的觀看時間
                    $sql_read = DB::select("SELECT read_at FROM `log_internal_letters` WHERE `internal_letter_id` = ? and `user_id`= ? and isDisplay = 1", [$letter->internal_letter_id,Auth::user()->user_id]);
        
                    //存在帶入data不存在帶入空值
                    if (!empty($sql_read)) {
                        $read_at = $sql_read[0]->read_at;
                    } else {
                        $read_at = null;
                    }
                
                    return view('Front_End.user_manage.inbox_letters.check_letters_panel', [
                        'letter' => $letter , 'read_at'=> $read_at
                    ]);
                }
            }
        }
        
     }

     public function del_inbox_letters(Letters $letter)
     {
        //查詢是否有隱藏log
        $log_letters2 = DB::select("SELECT * FROM `log_internal_letters` WHERE `internal_letter_id` = ? and `user_id` = ?",[$letter->internal_letter_id,Auth::user()->user_id]);
        if ($letter->isDisplay != 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'notYours'
            ]);
        }else{
            //存在的話修改隱藏狀態
            if (!empty($log_letters2)) {
                if ($log_letters2[0]->isDisplay != 1) {
                    return response()->json([
                    'status' => 'error',
                    'message' => 'notYours'
                ]);
                } else {
                    if ($letter->user_ids != Auth::user()->user_id && $letter->user_ids != 0-Auth::user()->user_identity && $letter->user_ids != -4) {
                        return response()->json([
                        'status' => 'fail',
                        'message' => 'notYours'
                    ]);
                    } else {
                    
                    //存在的話修改隱藏狀態
                        DB::update("UPDATE `log_internal_letters` SET `isDisplay` = 0, `updated_at` = ?  WHERE `internal_letter_id` = ? and `user_id` = ?", [date('Y-m-d H:i:s'),$letter->internal_letter_id,Auth::user()->user_id]);
                    
                        return response()->json([
                        'status' => 'success',
                    ]);
                    }
                }
            }else{
                if ($letter->user_ids != Auth::user()->user_id && $letter->user_ids != 0-Auth::user()->user_identity && $letter->user_ids != -4) {
                        return response()->json([
                        'status' => 'fail',
                        'message' => 'notYours'
                    ]);
                } else{
                    //不存在的話新增log
                    $log_letters = new log_internal_letters;
                    $log_letters->user_id = Auth::user()->user_id;
                    $log_letters->internal_letter_id = $letter->internal_letter_id;
                    $log_letters->isDisplay = 0;
                    $log_letters->created_at = date('Y-m-d H:i:s');
                    $log_letters->updated_at = date('Y-m-d H:i:s');
                    $log_letters->save();


                    return response()->json([
                    'status' => 'success',
                    ]);
                }
                    
            }
        }
        
     }

     public function inbox_letters_search(Request $req)
     {
        $data = $req->all();
        $title_like = '';
        $content_like = '';
        //標題like條件
        if(isset($data['title'])){
            $title_like = "and title like '%".$data['title']."%'";
        }
        //內容like條件
        if(isset($data['ctx'])){
            $content_like = "and content like '%".$data['ctx']."%'";
        }
        //重複的sql
        $sql = '(SELECT count(*) FROM `log_internal_letters` WHERE internal_letter_id = aa.`internal_letter_id` and `user_id`= ? and isDisplay = 0)';
        //查詢是否隱藏的訊息包含自己的身分別、單一屬於自己的信、全部類別信
        $letters = DB::select("SELECT * FROM `internal_letters` aa  where aa.`user_ids` = ?  AND $sql = 0 and aa.isDisplay = 1 and aa.created_at  >=  ADDDATE(?,INTERVAL -1 minute) $title_like $content_like or aa.`user_ids` = -4 and aa.isDisplay = 1 and aa.created_at  >=  ADDDATE(?,INTERVAL -1 minute) AND $sql = 0 $title_like $content_like or aa.`user_ids` = ? and aa.isDisplay = 1 and aa.created_at  >=  ADDDATE(?,INTERVAL -1 minute) AND $sql = 0 $title_like $content_like ORDER BY aa.created_at desc ",[Auth::user()->user_id,Auth::user()->user_id,Auth::user()->approved_at,Auth::user()->approved_at,Auth::user()->user_id,0-Auth::user()->user_identity,Auth::user()->approved_at,Auth::user()->user_id]);
        //舉一個陣列做塞值用
        $end_letters = [];
        //舉一個變數坐陣列索引鍵用
        $count = 0;
        foreach($letters as $k){
            $end_letters[$count]['title'] = $k->title;
            $end_letters[$count]['created_at'] = $k->created_at;
            $end_letters[$count]['internal_letter_id'] = $k->internal_letter_id;
            //查詢觀看時間
            $sql_read = DB::select("SELECT read_at FROM `log_internal_letters` WHERE `internal_letter_id` = ? and `user_id`= ? and isDisplay = 1",[$k->internal_letter_id,Auth::user()->user_id]);

            //存在帶入data不存在帶入空值
            if(!empty($sql_read)){
                $read_at = $sql_read[0]->read_at;
            }else{
                $read_at = '未讀';
            }
            $end_letters[$count]['read_at'] = $read_at;
            $count++;
        }
        return response()->json($end_letters);
     }

}
