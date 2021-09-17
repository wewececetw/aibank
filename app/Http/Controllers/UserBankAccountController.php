<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Log;

// use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;
use App\UserBank;
use App\BankList;
use App\User;
use App\TenderRepayments;
use DB;


class UserBankAccountController extends Controller
{

     public function index(){

        $user_id = Auth::user()->user_id;

        $data['user'] = User::select('virtual_account')->where('user_id',$user_id)->first();

        $data['bank'] = BankList::select('bank_code','bank_name')->distinct()->get();

        $data['user_bank'] = UserBank::with('userbank_banklist')->where('user_id',$user_id)->get();


        return view('Front_End.user_manage.bank_account.bank_account_panel',$data);

    }



    public function bank_account_insert(Request $request)
    {
        //檢查account = 數字 且 10~16字元
        $account_match = preg_match('/^[0-9]{10,16}$/', $request->bank_account);

        //檢查DB是否真有這bankID
        $bank_list = BankList::where('bank_id',$request->bank_id)->count();

        //檢查重複
        $checkRepeat = UserBank::where('bank_account',$request->bank_account)->count();

        if($checkRepeat == 0){

            if($account_match > 0 && $bank_list > 0){
                $user_id = Auth::user()->user_id;

                $data['user_bank'] = UserBank::where('user_id',$user_id)->get();

                $user_bank_num = sizeof($data['user_bank']);


                $account = new UserBank;


                if($user_bank_num == 0){

                    $account->is_active = 1;
                }

                $account->bank_account = $request->bank_account;
                $account->user_id = Auth::user()->user_id;
                $account->bank_id = $request->bank_id;
                $account->created_at = date('Y-m-d H:i:s');
                $account->updated_at = date('Y-m-d H:i:s');

                $account->save();

                $return['success'] = true;
                return response()->json($return);
            }else{
                $return['success'] = false;
                return response()->json($return);
            }
        }else{
            $return['msg'] = 'repeat';
            $return['success'] = false;
            return response()->json($return);
        }

    }


    public function bank_select(Request $request){

        $bank_code = $request->bank_profile;


        $return['ban_opt'] = BankList::where('bank_code',$bank_code)->get();
        $return['success'] = true;


        return response()->json($return);

    }

    public function bank_delete(Userbank $bank_id){

        $bank_id->delete();

        $return_data['success'] = true;
        return response()->json($return_data);
    }


    public function is_active_update(Request $request){


        $user_bank_id = $request->user_bank_id;

        $user_id = Auth::user()->user_id;

        $old_user_bank_id = UserBank::where('user_id',$user_id)->where('is_active','1')->first()->user_bank_id;

        // 前一筆更新成0
        $data['is_active'] = 0;

        UserBank::where('user_id',$user_id)->where('is_active','1')->update($data);



         // 要更新帳號的資料

         $new_data['is_active'] = 1;

         UserBank::where('user_bank_id',$user_bank_id)->update($new_data);

        //更新TenderRepayment
        TenderRepayments::where('user_bank_id',$old_user_bank_id)->whereNull('paid_at')->update([
            'user_bank_id' => $user_bank_id,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $return_data['success'] = true;
        return response()->json($return_data);
    }




}
