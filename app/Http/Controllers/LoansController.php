<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Loan;
use DB;
use Log;


class LoansController extends Controller
{

    public function index()
    {
        // $className = 'App' . '\\' . 'Loan' ;
        $datasets = Loan::select(DB::raw("*,'待補充'as connected"))->orderBy('loan_id','asc')->get();

        return view('Back_End.loans.loans_panel',
                    ['datasets'=>$datasets]);

    }

    public function loans_edit(Loan $loan)
    {
        $data['row'] = $loan;
        return view('Back_End.loans.loans_edit',$data);

    }
    public function loans_update(Request $request, Loan $loan)
    {

        $table_columns = $loan->getTableColumns();
        foreach ($request->all() as $key => $value) {
            if(in_array($key,$table_columns))
            {
                $loan->$key = $value;
            }
        }
        $loan->save();
        $return_data['success'] = true;

        return response()->json($return_data);
    }
    public function search(Request $req)
    {
        $model = new Loan;
        $search = [];
        $createdAt = [
            $req->all()['created_at_begin'],
            $req->all()['created_at_end'],
        ];
        if(isset($createdAt[0]) && isset($createdAt[1])){
            //都有日期時
            $model = $model->whereBetween('created_at',$createdAt);
        }else if( (isset($createdAt[0]) && !isset($createdAt[1])) ){
            //有一個沒日期時
            $model = $model->where('created_at',$createdAt[0]);
        }else if( (!isset($createdAt[0]) && isset($createdAt[1]))){
            $model = $model->where('created_at',$createdAt[1]);
        }else{
            //都沒日期時
        }

        foreach ($req->all() as $key => $value) {
            if($key != 'created_at_begin' && $key != 'created_at_end'){
                $search[$key] = $value;
                if(isset($value)){
                    $model = $model->where($key,'like','%'.$value.'%');
                }
            }
        }

        $data = $model->get();
        $res = [];
        foreach($data as $v)
        {
            $ar = [];
            array_push($ar,$v->lender_name);
            array_push($ar,$v->dob);
            array_push($ar,$v->lender_id_number);
            array_push($ar,$v->cellphone_number);
            array_push($ar,$v->loan_type);
            array_push($ar,$v->amount);
            array_push($ar,$v->periods);
            array_push($ar,$v->connected);
            array_push($ar,$v->comment);
            $button = '<div class="btn-group"><a class="btn btn-info" href="/admin/loans/loans_edit/'.$v->loan_id.'"><i class="fa fa-eye"></i></a>';
            array_push($ar,$button);


            array_push($res,$ar);
        }
        return response()->json($res);

    }
    // public function tableGenerator(Loan $loan)
    // {
    //     $return_data['datas'] = Loan::select(DB::raw("*,'to be added'as connected"))->orderBy('loan_id','asc')->get();
    //     $return_data['shows'] = [
    //                             'lender_name',
    //                             'dob',
    //                             'lender_id_number',
    //                             'cellphone_number',
    //                             'loan_type',
    //                             'amount',
    //                             'periods',
    //                             'connected',
    //                             'comment',
    //                             ];
    //     $return_data['success'] = true;

    //     return response()->json($return_data);


        // $loan = new Loan;
        // $dataset = Loan::select(DB::raw("*,'to be added'as connected"))->orderBy('loan_id','asc')->get();
        // $shows = [
        //         'lender_name',
        //         'dob',
        //         'lender_id_number',
        //         'cellphone_number',
        //         'loan_type',
        //         'amount',
        //         'periods',
        //         'connected',
        //         'comment',
        //         ];
        // $columns = $shows;
        // $attributeArray = $columns;

        // foreach($attributeArray as $key => $val)
        // {
        //     $attributeArray[$val] = $attributeArray[$key];
        //     unset($attributeArray[$key]);
        // }
        // $result = $loan->runDataTables($req->query,$columns,$attributeArray);
        // Log::debug($result);
        // return response()->json($result);

    // }
}
