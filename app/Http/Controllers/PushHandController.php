<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\User;
use App\UserBank;

class PushHandController extends Controller
{

    public function index(){

        $id = Auth::user()->user_id;
        $data['user_bank'] = UserBank::where('user_id',$id)->get();
        $data['bank_count'] = count($data['user_bank']);

        $data['user'] = User::where('user_id',$id)->first();

        if($data['user']->user_state == 2){
            return redirect('/users')->with('wait_confirm', 'Profile updated!');
        }
        if($data['user']->user_state != 1){
            return redirect('/users')->with('true_data_to_confirm', 'Profile updated!');
        }

        if($data['bank_count'] == 0){

            return redirect('/users/tab_two')->with('bank_check', 'Profile updated!');

        }else{



            return view('Front_End.user_manage.push_hand.push_hand_panel',$data);


        }

    }
    public function pay_block(){

        $id = Auth::user()->user_id;
        $data['user_bank'] = UserBank::where('user_id',$id)->get();
        $data['bank_count'] = count($data['user_bank']);

        $data['user'] = User::where('user_id',$id)->first();

        if($data['user']->user_state == 2){
            return redirect('/users')->with('wait_confirm', 'Profile updated!');
        }
        if($data['user']->user_state != 1){
            return redirect('/users')->with('true_data_to_confirm', 'Profile updated!');
        }

        if($data['bank_count'] == 0){

            return redirect('/users/tab_two')->with('bank_check', 'Profile updated!');

        }else{

            $data['result'] = DB::select('

                SELECT
                ut.user_name, ut.created_at, ut.user_state, (CASE
                WHEN ut.InvestSum = 0 THEN FALSE
                WHEN ut.InvestSum > 0 THEN TRUE
                ELSE False
            END) AS IsInvest ,ut.InvestSum
                FROM
                (SELECT
                    u.user_name, u.created_at, u.user_state, t.InvestSum
                FROM
                    (SELECT
                    user_id,user_name,created_at,user_state
                FROM
                    users
                WHERE
                    come_from_info_text IN (SELECT
                            recommendation_code
                        FROM
                            .users
                        WHERE
                            user_id = '.$id.')) AS u
                LEFT JOIN (SELECT
                    d.user_id, sum(d.amount) as InvestSum
                FROM
                    tender_documents as d
                WHERE
                    d.tender_document_state IN (1,2,4 )
                GROUP BY d.user_id) AS t ON t.user_id = u.user_id) AS ut
            ');





            return view('Front_End.user_manage.push_hand.push_hand_pay_block',$data);


        }

    }
    public function unpay_block(){

        $id = Auth::user()->user_id;
        $data['user_bank'] = UserBank::where('user_id',$id)->get();
        $data['bank_count'] = count($data['user_bank']);

        $data['user'] = User::where('user_id',$id)->first();

        if($data['user']->user_state == 2){
            return redirect('/users')->with('wait_confirm', 'Profile updated!');
        }
        if($data['user']->user_state != 1){
            return redirect('/users')->with('true_data_to_confirm', 'Profile updated!');
        }

        if($data['bank_count'] == 0){

            return redirect('/users/tab_two')->with('bank_check', 'Profile updated!');

        }else{

            

            $data['resultTwo'] = DB::select('

                    SELECT
                    p.claim_certificate_number,
                    
                    td.tender_document_state as dstate,
                    td.amount,
                    p.current_balance,
                    
                    rd.period_number,
                    p.benefits_amount,
                    rd.target_repayment_date as r_target_repayment_date,
                    rd.credited_at as r_credited_at,
                    p.target_repayment_date
                FROM
                     pusher_detail p,  tender_documents td , tender_repayments rd

                WHERE p.p_d_user_id = "'.$id.'" 
                and td.claim_certificate_number = p.claim_certificate_number 
                and rd.tender_repayment_id = p.repayment_id and td.tender_document_state IN (1,2,4)
                ORDER BY claim_certificate_number , period_number

            ');

            $data['resultTwo2'] = DB::select('

                    SELECT
                    p.claim_certificate_number,
                    u.user_name,
                    c.repayment_method,
                    c.commission_interest_rate
                FROM
                    users u, pusher_detail p, claims c

                WHERE p.p_d_user_id = "'.$id.'" and u.user_id = p.user_id 
                and c.claim_id = p.claim_id 
            ');

            foreach ($data['resultTwo2'] as $k => $v ){
                $data['resultTwo3'][$v->claim_certificate_number]['user_name'] = $v->user_name;
                $data['resultTwo3'][$v->claim_certificate_number]['repayment_method'] = $v->repayment_method;
                $data['resultTwo3'][$v->claim_certificate_number]['commission_interest_rate'] = $v->commission_interest_rate;
                
            }
            

            



            return view('Front_End.user_manage.push_hand.push_hand_unpay_block',$data);


        }

    }
    public function failur_block(){

        $id = Auth::user()->user_id;
        $data['user_bank'] = UserBank::where('user_id',$id)->get();
        $data['bank_count'] = count($data['user_bank']);

        $data['user'] = User::where('user_id',$id)->first();

        if($data['user']->user_state == 2){
            return redirect('/users')->with('wait_confirm', 'Profile updated!');
        }
        if($data['user']->user_state != 1){
            return redirect('/users')->with('true_data_to_confirm', 'Profile updated!');
        }

        if($data['bank_count'] == 0){

            return redirect('/users/tab_two')->with('bank_check', 'Profile updated!');

        }else{


            // $data['resultThree'] = DB::select('

                
            //     SELECT
            //     p.target_repayment_date,p.paid_at,sum(p.benefits_amount) as sum
            //     FROM
            //         pusher_detail p, tender_documents td
            //     WHERE 
            //     p.claim_certificate_number = td.claim_certificate_number
            //     and
            //     p.user_id IN (SELECT
            //         user_id
            //     FROM
            //         users
            //     WHERE
            //         come_from_info_text IN (SELECT
            //             recommendation_code
            //         FROM
            //             users
            //         WHERE
            //         user_id = '.$id.')) and td.tender_document_state IN (1,2,4)
            //         group by p.target_repayment_date,p.paid_at


            //     ');

            // $tender_documents =  DB::select('select claim_certificate_number from tender_documents where tender_document_state IN (1,2,4)'); 
            // $data['tender_documents'] = "('";
            // foreach ($tender_documents as $key => $value) {
            //     $data['tender_documents'] .= $value->claim_certificate_number."','";
            // }
            // $data['tender_documents'] = substr($data['tender_documents'], 0, -2);
            // $data['tender_documents'].= ')';

            return view('Front_End.user_manage.push_hand.push_hand_failur_block',$data);


        }

    }

    public function create_recommendation_code(Request $req){

        $id = $req->user_id;
        $user = User::where('user_id',$id)->first();

        if(isset($user->approved_at)){

            $m = $user->member_number;
            $recommendation_code  = 'R'.substr($m, -4).'PP';

            $row_data['recommendation_code'] = $recommendation_code;
            $row_data['recommendation_agreed_at'] = date('Y-m-d H:i:s');

            $user->update($row_data);

            $return_data['success'] = true;


        }else{

            $return_data['no_member_num'] = true;
        }

        return response()->json($return_data);

    }

}
