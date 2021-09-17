<?php

namespace App\Http\Controllers;

use Auth;
use App\Claim;
use App\ClaimFiles;
use App\Tenders;
use App\Exports\UsersExport;
use App\Http\Requests\ClaimInsert;
use App\Imports\UsersImport;
use App\Mail\SampleMail;
use App\SystemVariables;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\MailTo;

class ClaimsController extends Controller
{
    private $variable_name = array('opened', 'closed', 'payment_final_deadline', 'repayment', 'payment_deadline');
    private $variable_open = array('opened');
    private $variable_close = array('closed', 'payment_final_deadline');
    private $variable_value = array('repayment');

    public function index()
    {
        // $datasets = Claim::select(DB::raw("*,(auto_close_threshold*staging_amount) as cal_result,'to be added'as current_amount"))->where('is_display','=','1')->orderBy('claim_id','asc')->get();

        //20200319 OLD
        // $datasets = Claim::select(DB::raw("*,
        // (auto_close_threshold*staging_amount) as cal_result,
        // 'to be added'as current_amount"))->orderBy('claim_id', 'asc')->get();

        $claims_count = DB::select('select * from claims');
        $page_count = ceil(count($claims_count)/25);

        /* 20200319 change by Jason */
        $datasets = Claim::from('claims as c')
            ->select('c.weekly_time','c.foreign_t','c.claim_number','c.serial_number','c.claim_state','c.number_of_sales','c.staging_amount','c.periods','c.claim_id','c.is_display', DB::raw('(SELECT SUM(`amount`) FROM `tender_documents` td WHERE `claim_id` = c.claim_id )as tender_sum_amount'),DB::raw('(SELECT SUM(`amount`) FROM `tender_documents` td WHERE `claim_id` = c.claim_id and `tender_document_state` in (1,2,4,6)) as amount'))
            ->groupBy('c.claim_id')
            ->orderBy('c.claim_id', 'asc')->skip(0)->take(25)
            ->get();
        $row_data =  DB::table("users")->where("is_receive_letter_type",0)
                ->first();
        //計算實際募到的金額
        $current_amount = [];     
        
       
        // foreach ($datasets as $dataset) {

            
        //     $amount = DB::select('SELECT SUM(`amount`) as amount FROM `tender_documents`  WHERE `claim_id` = ? and `tender_document_state` in (1,2,4,6) ',[$dataset->claim_id]);
        //     if(is_null($amount[0]->amount)){
        //         $current_amount[$dataset->claim_id] = 0;
        //     }else{
        //         $current_amount[$dataset->claim_id] = $amount[0]->amount;
        //     }
            
        // }

        $variableArray = array();

        foreach ($this->variable_name as $item) {

            $sv = SystemVariables::where('variable_name', $item)->first();

            array_push($variableArray, array($item => $sv->value));

        }
        // dd($variableArray);

        return view('Back_End.claims.claims_panel', ['datasets' => $datasets, 'data' => $variableArray,'row_data' => $row_data,'current_amount' => $current_amount,'page_count'=>$page_count]);

    }

    public function variables_update(Request $request)
    {
        date_default_timezone_set("Asia/Taipei");
        foreach ($this->variable_name as $item) {

            $value = $request->input($item);

            $sv = SystemVariables::where('variable_name', $item)->first();

            $sv->value = $value;
            $sv->updated_at = date('Y-m-d H:i:s');

            $sv->save();

        }

        return response()->json([
            'success' => true,
            'msg' => '已儲存',
        ]);

    }

    public function claims_create()
    {
        $variableArray = array();
        $sysvar = array();

        foreach ($this->variable_name as $item) {

            $sv = SystemVariables::where('variable_name', $item)->first();

            array_push($variableArray, array($item => date('Y-m-d', strtotime('+' . $sv->value . 'day'))));
            array_push($sysvar, $sv->value);
        }
        return view('Back_End.claims.claims_edit_new', ['row' => $variableArray,
            'sysvar' => $sysvar]);
        // return view('Back_End.claims.claims_insert',['row'=>$variableArray,
        //                                                 'sysvar'=>$sysvar]);

    }
    //存pdf
    public function StorePdf($req, $file)
    {
        $fileName = $this->Del_deputy_file_name($req->file($file)->getClientOriginalName());
        $path = Storage::disk('public_uploads')->putFileAs('claimsPdf/' . date("Ymd"), new File($req->file($file)), $fileName);
        $FilePath = 'uploads/claimsPdf/' . date("Ymd") . '/' . $fileName;
        return $FilePath;
    }
    // public function StorePdf_array($req, $file)
    // {
    //     $fileName = $this->Del_deputy_file_name($file->getClientOriginalName());
    //     $path = Storage::disk('public_uploads')->putFileAs('claimsPdf/' . date("Ymd"), new File($file), $fileName);
    //     $FilePath = 'uploads/claimsPdf/' . date("Ymd") . '/' . $fileName;
    //     return $FilePath;
    // }
    //存圖片
    public function StorePdf_array($req, $file , $claim_id, $claim_number, $claim_count)
    {
        // $id = Auth::user()->user_id;
        $date = date("YmdHis");
        $fileName = 'id_'.$claim_id.'_'.$claim_number.'_'.$date.'_'.$claim_count.'.jpg';
        $path = Storage::disk('public_uploads')->putFileAs('claimsPdf_photo', new File($file),  $fileName);
        $FilePath = 'uploads/claimsPdf_photo/id_'.$claim_id.'_'.$claim_number.'_'.$date.'_'.$claim_count.'.jpg';
        return $FilePath;
    }


    //去副檔名 並且 重新命名
    public function Del_deputy_file_name($file)
    {
        $num = rand(0, 9) . rand(0, 9) . rand(0, 9) . time();
        $fileName = $num . $file;
        $secondFileName = explode('.', $fileName)[1];

        $fileName = md5($fileName) . '.' . $secondFileName;
        return $fileName;
    }

    public function getDefaultDate($startDay, $item)
    {
        $sv = SystemVariables::where('variable_name', $item)->first();
        switch ($item) {
            case 'opened':
                $date = date('Y-m-d 10:00:00', strtotime($startDay . '+' . $sv->value . 'day'));
                break;
            case 'closed':
            case 'payment_final_deadline':
                $date = date('Y-m-d 23:59:59', strtotime($startDay . '+' . $sv->value . 'day'));
                break;
            case 'repayment':
                $date = date('Y-m-d 00:00:00', strtotime($startDay . '+' . $sv->value . 'day'));
                break;
            default:
                $date = date('Y-m-d H:i:s', strtotime($startDay . '+' . $sv->value . 'day'));
                break;
        }
        return $date;
    }

    public function getClaimData(Claim $claim)
    {
        return response()->json($claim->toArray());
    }

    public function claims_update(Request $request, Claim $claim)
    {
        $claim->claim_number = $request->claim_number;
        $claim->number_of_sales = $request->number_of_sales;
        //權限設定 (user.user_type)
        $claim->tax_id = $request->tax_id;
        $claim->serial_number = $request->serial_number;
        $claim->staged_at = $request->staged_at;
        $claim->staging_amount = $request->staging_amount;
        $claim->periods = $request->periods;
        $claim->remaining_periods = $request->remaining_periods;
        $claim->annual_interest_rate = $request->annual_interest_rate;
        $claim->min_amount = $request->min_amount;
        $claim->bid_interest = $request->bid_interest;
        $claim->management_fee_rate = $request->management_fee_rate;
        $claim->management_fee_amount = $request->management_fee_amount;
        $claim->description = $request->description;
        $claim->agreement_buyer = $request->agreement_buyer;
        $claim->launched_at = $request->launched_at;
        $claim->estimated_close_date = $request->estimated_close_date;
        $claim->repayment_method = $request->repayment_method;
        // 累標總額
        // 標售率
        // 標單數
        // 是否結標
        $claim->closed_at = $request->closed_at;
        $claim->payment_final_deadline = $request->payment_final_deadline;
        // 已收款
        // 收款率
        $claim->value_date = $request->value_date;

        // 流標日
        // 流標投資款匯回日
        $claim->debtor_transferor = $request->debtor_transferor;
        $claim->borrower = $request->borrower;
        $claim->id_number = $request->id_number;
        $claim->gender = $request->gender;
        $claim->age = $request->age;
        $claim->education = $request->education;
        $claim->marital_state = $request->marital_state;
        $claim->place_of_residence = $request->place_of_residence;
        $claim->living_state = $request->living_state;
        $claim->job_title = $request->job_title;
        $claim->seniority = $request->seniority;
        $claim->monthly_salary = $request->monthly_salary;
        $claim->guarantor = $request->guarantor;
        $claim->risk_category = $request->risk_category;
        $claim->id_number_effective = $request->id_number_effective;
        $claim->peer_blacklist = $request->peer_blacklist;
        $claim->rehabilitated_settlement = $request->rehabilitated_settlement;
        $claim->ticket_state = $request->ticket_state;
        $claim->major_traffic_fines = $request->major_traffic_fines;
        $claim->peer_query_count = $request->debtor_transferor;
        $claim->foreign = $request->foreign;

        $claim->save();

        $return['success'] = true;
        return response()->json($return);
    }

    public function claim_details(Claim $claim)
    {
        $data['row'] = $claim;
        $claim_id = $claim->claim_id;
        // if ($claim->state == 0 || $claim->state == 1) {
        $endT_state = [2,3,4,5];
        if (in_array($claim->getOriginal('claim_state'),$endT_state)) {
            $data['endtender'] = '已結標';
        } else {
            $data['endtender'] = '未結標';
        }
        $data['total_amount'] = DB::select('
        SELECT
            sum(td.amount) AS total_amount
        FROM
            claims AS c
        LEFT JOIN
            tender_documents AS td ON c.claim_id = td.claim_id
        where
            c.claim_id = ' . $claim_id . '
        group by
            c.claim_id;
        ');

        $data['tenderNum'] = Tenders::where('claim_id',$claim_id)->count();
        // dd($this->getProgress($claim_id));
        $data['progress'] = (count($this->getProgress($claim_id)) > 0 ) ?  $this->getProgress($claim_id)[0]->total : 0;
        $data['isPaidMoney'] = $this->isPaidMoney($claim_id);
        if(!isset($data['isPaidMoney']) || count($data['isPaidMoney']) == 0){
            $data['isPaidMoney'] = [
                'amount' => 0,
                'percent' => '0%',
            ];
        }else{
            $data['isPaidMoney'] = $data['isPaidMoney'][0];
            $ar = [];
            foreach($data['isPaidMoney']as $k => $v){
                $ar[$k] = $v;
            }
            $ar['percent'] = $ar['percent'] . '%';
            $data['isPaidMoney'] = $ar;
        }

        return view('Back_End.claims.claims_detail', $data);

    }
    public function isPaidMoney($claim_id)
    {
        $t = DB::select("SELECT
            SUM(td.amount) as amount,
            FLOOR((SUM(amount) / staging_amount) * 100) AS percent
        FROM
            tender_documents AS td
        LEFT JOIN claims AS c
        ON
            td.claim_id = c.claim_id
        WHERE
            c.claim_id = $claim_id
        AND
            td.tender_document_state in (1,2,4)
        GROUP BY
            c.claim_id");

        return $t;
    }

    public function getProgress($id)
    {

        $t = DB::select("SELECT
            c.claim_id as claim_id,
            FLOOR((SUM(amount) / staging_amount) * 100) AS total
        FROM
            tender_documents AS td
        LEFT JOIN claims AS c
        ON
            td.claim_id = c.claim_id
        WHERE
            c.claim_id = $id
        GROUP BY
            c.claim_id");

        return $t;
    }

    public function repayments_index()
    {

        return view('Back_End.claims.claim_repayments_panel');

    }

    public function claim_repayments_insert()
    {

        return view('Back_End.claims.claims_repayments_insert');

    }
    public function search(Request $req)
    {

        $model = new Claim;
        $model = $model->from('claims as c');

        $needBetween = false;
        $search = [];
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
        if(!empty($req->all()['sty_type'])){
            $sty_type = 1;
        }
        
        $data =  $req->except(['sequence','number_page','page','sty_type']);
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
                        $model = $model->where($key, 'like', '%' . $value . '%');
                        break;
                }
            }
        }
        if ($needBetween) {
            if (isset($search['launched_at_start']) && isset($search['launched_at_end'])) {
                $model = $model->whereBetween('launched_at', [$search['launched_at_start'], $search['launched_at_end']]);
            }
            if (isset($search['closed_at_start']) && isset($search['closed_at_end'])) {
                $model = $model->whereBetween('estimated_close_date', [$search['closed_at_start'], $search['closed_at_end']]);
            }
            if (isset($search['value_date_start']) && isset($search['value_date_end'])) {
                $model = $model->whereBetween( 'value_date',[$search['value_date_start'],$search['value_date_end']]);
            }
            if (isset($search['weekly_time_start']) && isset($search['weekly_time_end'])) {
                $model = $model->whereBetween('weekly_time', [$search['weekly_time_start'], $search['weekly_time_end']]);
            }
        }

        $model = $model->select('c.value_date','c.weekly_time','c.foreign_t','c.claim_number','c.serial_number','c.claim_state','c.number_of_sales','c.staging_amount','c.periods','c.claim_id','c.is_display','c.created_at', DB::raw('(SELECT SUM(`amount`) FROM `tender_documents` td WHERE `claim_id` = c.claim_id )as tender_sum_amount'),DB::raw('(SELECT SUM(`amount`) FROM `tender_documents` td WHERE `claim_id` = c.claim_id and `tender_document_state` in (1,2,4,6)) as amount'))->groupBy('c.claim_id');

        //暫時存取查詢結果以記頁數
        $page_sql = $model;
        $page_count = $page_sql->get();

        if(empty($sequence)){
            $data = $model->orderBy('created_at', 'desc')->skip($page)->take($number_page)->get();
        }elseif($sequence == 1){
            $data = $model->orderBy('claim_number', 'asc')->skip($page)->take($number_page)->get();
        }elseif($sequence == -1){
            $data = $model->orderBy('claim_number', 'desc')->skip($page)->take($number_page)->get();
        }elseif($sequence == 2){
            $data = $model->orderBy('serial_number', 'asc')->skip($page)->take($number_page)->get();
        }elseif($sequence == -2){
            $data = $model->orderBy('serial_number', 'desc')->skip($page)->take($number_page)->get();
        }elseif($sequence == 3){
            $data = $model->orderBy('claim_state', 'asc')->skip($page)->take($number_page)->get();
        }elseif($sequence == -3){
            $data = $model->orderBy('claim_state', 'desc')->skip($page)->take($number_page)->get();
        }elseif($sequence == 4){
            $data = $model->orderBy('number_of_sales', 'asc')->skip($page)->take($number_page)->get();
        }elseif($sequence == -4){
            $data = $model->orderBy('number_of_sales', 'desc')->skip($page)->take($number_page)->get();
        }elseif($sequence == 5){
            $data = $model->orderBy('staging_amount', 'asc')->skip($page)->take($number_page)->get();
        }elseif($sequence == -5){
            $data = $model->orderBy('staging_amount', 'desc')->skip($page)->take($number_page)->get();
        }elseif($sequence == 6){
            $data = $model->orderBy('periods', 'asc')->skip($page)->take($number_page)->get();
        }elseif($sequence == -6){
            $data = $model->orderBy('periods', 'desc')->skip($page)->take($number_page)->get();
        }elseif($sequence == 7){
            $data = $model->orderBy('tender_sum_amount', 'asc')->skip($page)->take($number_page)->get();
        }elseif($sequence == -7){
            $data = $model->orderBy('tender_sum_amount', 'desc')->skip($page)->take($number_page)->get();
        }elseif($sequence == 8){
            $data = $model->orderBy('is_display', 'asc')->skip($page)->take($number_page)->get();
        }elseif($sequence == -8){
            $data = $model->orderBy('is_display', 'desc')->skip($page)->take($number_page)->get();
        }elseif($sequence == 9){
            $data = $model->orderBy('foreign_t', 'asc')->skip($page)->take($number_page)->get();
        }elseif($sequence == -9){
            $data = $model->orderBy('foreign_t', 'desc')->skip($page)->take($number_page)->get();
        }elseif($sequence == 10){
            $data = $model->orderBy('weekly_time', 'asc')->skip($page)->take($number_page)->get();
        }elseif($sequence == -10){
            $data = $model->orderBy('weekly_time', 'desc')->skip($page)->take($number_page)->get();
        }elseif($sequence == 11){
            $data = $model->orderBy('amount', 'asc')->skip($page)->take($number_page)->get();
        }elseif($sequence == -11){
            $data = $model->orderBy('amount', 'desc')->skip($page)->take($number_page)->get();
        }
        
        $res = [];
        $count = 0;
        $current_amount = [];
        $res['data']= [];
        foreach ($data as $v) {
            $res['data'][$count]['claim_number'] = $v->claim_number;
            $res['data'][$count]['serial_number'] = $v->serial_number;
            $res['data'][$count]['claim_state'] = $v->claim_state;
            $res['data'][$count]['number_of_sales'] = $v->number_of_sales;
            $res['data'][$count]['staging_amount'] = $v->staging_amount;
            $res['data'][$count]['periods'] = $v->periods;
            $res['data'][$count]['tender_sum_amount'] = $v->tender_sum_amount?$v->tender_sum_amount:'0';
            $res['data'][$count]['current_amount'] = $v->amount?$v->amount:'0';
            $res['data'][$count]['foreign_t'] = $v->foreign_t;
            $res['data'][$count]['weekly_time'] = ($v->weekly_time)?$v->weekly_time:'非週週投債權';
            if(!empty($sty_type)){
                $res['data'][$count]['value_date'] = $v->value_date;
                $res['data'][$count]['t_g_r_d_input'] = '<input type="date" value="'.date('Y-m-d').'" id="t_g_r_d_input'.$v->claim_id.'"  >';
                $res['data'][$count]['p_d_input'] = '<input type="date" value="'.date('Y-m-d').'"  id="p_d_input'.$v->claim_id.'" >';
                $res['data'][$count]['b_b_type_input'] = '<select id="b_b_type_input'.$v->claim_id.'"><option value="" style="color:lightgray">選擇買回類別</option>
                <option value="1">結清買回</option>
                <option value="2">逾期買回</option></select>';
                $res['data'][$count]['sty_type_bt1'] = '<button  class="btn btn-success" onclick="buy_back(' . $v->claim_id .')">一鍵買回</button>';
                $res['data'][$count]['sty_type_bt2'] = '<button  class="btn btn-success" onclick="buy_back_ex1(' . $v->claim_id .')">對帳報表</button>';
                $res['data'][$count]['sty_type_bt3'] = '<button  class="btn btn-success" onclick="buy_back_ex2(' . $v->claim_id .')">銀行報表</button>';
            }
            $detail_button = '<a target="_blank" href="/admin/claim_details/' . $v->claim_id . '" class="btn btn-info"><i style="margin-right: 0px;" class="fa fa-fw fa-eye"></i> </a>';
            $res['data'][$count]['detail_button'] = $detail_button;
            $res['data'][$count]['current_amount2'] = '';
            $res['data'][$count]['current_amount3'] = '';
            if ($v->is_display == 0) {
                $visible_button = '<button id="no_display'.$v->claim_id.'" class="btn btn-success" onclick="is_display(' . $v->claim_id . ',1)">解除隱藏</button>';
                $visible_button .= '<button style="display:none" id="is_display'.$v->claim_id.'" class="btn btn-info" onclick="is_display(' . $v->claim_id . ',0)">隱藏</button>';
            } else {
                $visible_button = '<button id="is_display'.$v->claim_id.'" class="btn btn-info" onclick="is_display(' . $v->claim_id . ',0)">隱藏</button>';
                $visible_button .= '<button style="display:none" id="no_display'.$v->claim_id.'" class="btn btn-success" onclick="is_display(' . $v->claim_id . ',1)">解除隱藏</button>';
            }
            // $visible_button = '<a href="#" class="btn btn-info">隱藏</a>';
            $res['data'][$count]['visible_button'] = $visible_button;
            $count++;
        }
        //計算頁數
        $res{'count'} = ceil(count($page_count)/$number_page) ;
        return response()->json($res);

    }
    public function info_export(Request $req)
    {
        $model = new Claim;

        $model = $model->from('claims as c');

        $needBetween = false;
        $search = [];
        //紀錄排序
        $sequence = $req->all()['sequence'];
        //紀錄一頁幾筆
        
        $data =  $req->except(['sequence','number_page','page']);
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
                        $model = $model->where($key, 'like', '%' . $value . '%');
                        break;
                }
            }
        }
        if ($needBetween) {
            if (isset($search['launched_at_start']) && isset($search['launched_at_end'])) {
                $model = $model->whereBetween('launched_at', [$search['launched_at_start'], $search['launched_at_end']]);
            }
            if (isset($search['closed_at_start']) && isset($search['closed_at_end'])) {
                $model = $model->whereBetween('estimated_close_date', [$search['closed_at_start'], $search['closed_at_end']]);
            }
            if (isset($search['value_date_start']) && isset($search['value_date_end'])) {
                $model = $model->whereRaw( "value_date >= ADDDATE(?,INTERVAL -(periods) month)  AND value_date <= ADDDATE(?,INTERVAL -(periods) month) and  claim_state = 4",[$search['value_date_start'],$search['value_date_end']]);
            }
            if (isset($search['weekly_time_start']) && isset($search['weekly_time_end'])) {
                $model = $model->whereBetween('weekly_time', [$search['weekly_time_start'], $search['weekly_time_end']]);
            }
        }

        $model = $model->select('c.weekly_time','c.annual_interest_rate','c.foreign_t','c.claim_number','c.value_date','c.serial_number','c.claim_state','c.number_of_sales','c.staging_amount','c.periods','c.claim_id','c.is_display','c.created_at',  DB::raw('(SELECT SUM(`amount`) FROM `tender_documents` td WHERE `claim_id` = c.claim_id )as tender_sum_amount'),DB::raw('(SELECT SUM(`amount`) FROM `tender_documents` td WHERE `claim_id` = c.claim_id and `tender_document_state` in (1,2,4,6)) as amount'))->groupBy('c.claim_id');

        //暫時存取查詢結果以記頁數
        $page_sql = $model;
        $page_count = $page_sql->get();

        if(empty($sequence)){
            $data = $model->orderBy('created_at', 'desc')->get();
        }elseif($sequence == 1){
            $data = $model->orderBy('claim_number', 'asc')->get();
        }elseif($sequence == -1){
            $data = $model->orderBy('claim_number', 'desc')->get();
        }elseif($sequence == 2){
            $data = $model->orderBy('serial_number', 'asc')->get();
        }elseif($sequence == -2){
            $data = $model->orderBy('serial_number', 'desc')->get();
        }elseif($sequence == 3){
            $data = $model->orderBy('claim_state', 'asc')->get();
        }elseif($sequence == -3){
            $data = $model->orderBy('claim_state', 'desc')->get();
        }elseif($sequence == 4){
            $data = $model->orderBy('number_of_sales', 'asc')->get();
        }elseif($sequence == -4){
            $data = $model->orderBy('number_of_sales', 'desc')->get();
        }elseif($sequence == 5){
            $data = $model->orderBy('staging_amount', 'asc')->get();
        }elseif($sequence == -5){
            $data = $model->orderBy('staging_amount', 'desc')->get();
        }elseif($sequence == 6){
            $data = $model->orderBy('periods', 'asc')->get();
        }elseif($sequence == -6){
            $data = $model->orderBy('periods', 'desc')->get();
        }elseif($sequence == 7){
            $data = $model->orderBy('tender_sum_amount', 'asc')->get();
        }elseif($sequence == -7){
            $data = $model->orderBy('tender_sum_amount', 'desc')->get();
        }elseif($sequence == 8){
            $data = $model->orderBy('is_display', 'asc')->get();
        }elseif($sequence == -8){
            $data = $model->orderBy('is_display', 'desc')->get();
        }elseif($sequence == 9){
            $data = $model->orderBy('foreign_t', 'asc')->get();
        }elseif($sequence == -9){
            $data = $model->orderBy('foreign_t', 'desc')->get();
        }elseif($sequence == 10){
            $data = $model->orderBy('weekly_time', 'asc')->get();
        }elseif($sequence == -10){
            $data = $model->orderBy('weekly_time', 'desc')->get();
        }elseif($sequence == 11){
            $data = $model->orderBy('amount', 'asc')->get();
        }elseif($sequence == -11){
            $data = $model->orderBy('amount', 'desc')->get();
        }
        

        $claim_export = $this->excelData($data);
        $now = date('Ymd');
        $myFile = Excel::download(new UsersExport($claim_export), $now . '_債權狀態.csv');

        return $myFile;
    }
    public function excelData($claim)
    {
        $claim_export = [
            ['物件編號',
                '流水號',
                '狀態',
                '上拋次數',
                '投資起息日',
                '年化報酬率',
                '上拋金額',
                '實際募集金額',
                '原始期數',
                '國內/海外',
                '是否為週週投'
            ],
        ];
        foreach ($claim as $row) {
            // //計算實際募到的金額
            // $amount = DB::select('SELECT SUM(`amount`) as amount FROM `tender_documents`  WHERE `claim_id` = ?  and `tender_document_state` in (1,2,4,6) ',[$row->claim_id]);
            // if(is_null($amount[0]->amount)){
            //     $current_amount[$row->claim_id] = 0;
            // }else{
            //     $current_amount[$row->claim_id] = $amount[0]->amount;
            // }
            $ar = [$row->claim_number,
                $row->serial_number,
                $row->claim_state,
                $row->number_of_sales,
                $row->value_date,
                $row->annual_interest_rate,
                $row->staging_amount,
                $row->amount?$row->amount:'0',
                $row->periods,
                $row->foreign_t,
                $row->weekly_time
            ];
            array_push($claim_export, $ar);

        }
        return $claim_export;
    }

    /**
     * 匯入債權EXCEL
     *
     * @param  mixed $request
     * @return void
     */
    public function import(Request $request)
    {

        $check = DB::select("select a_l_l_seq from admin_lv_log where user_id ='".Auth::user()->user_id."' and a_l_l_seq = 2");

        if(empty($check)){return Redirect::back()->withErrors(['注意權限不足!']);}


        $fileTypeName = $request->file('select_file')->getClientOriginalExtension();
        if ($fileTypeName != 'xlsx' && $fileTypeName != 'xls') {
            return Redirect::back()->withErrors(['您所匯入的檔案格式錯誤']);
        }
        //匯入前所有的claim_number 陣列
        $beforeClaimNumberArray = Claim::select('claim_number')->get()->toArray();
        //本次匯入的所有流水號
        $thisClaimNumberArray = [];
        $thisClaimNumberArray_new = [];

        $toArray = Excel::toArray(new UsersImport, request()->file('select_file'));
        //欄位名稱 陣列
        $header = $toArray[0][1];

        //流水號相關的欄位
        $claim_num_attr = [
            'risk_category',
            'serial_number',
            'number_of_sales',
        ];
        //日期欄位
        $claim_date_attr = [
            'staged_at',
            'launched_at',
            'estimated_close_date',
            'start_collecting_at',
            'payment_final_deadline',
            'value_date',
            'weekly_time'
        ];
        $claim_num_attr_key_array = $this->getHtmlHeaderKey($header, $claim_num_attr);
        //日期欄位對應 toArray 中的 key 陣列
        $claim_date_attr_key_array = $this->getHtmlHeaderKey($header, $claim_date_attr);
        try {
            DB::beginTransaction();
            foreach ($toArray[0] as $k => $v) {

                if ($k != 0 && $k != 1) {
                    $weeklytime = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($v[61]));
                    $launched_at = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($v[14]));
                    if($v[61] == '' || $v[61] != '' && $v[14] != '' && strtotime($weeklytime) < strtotime($launched_at)){
                        $claim_number = [
                            'risk_category' => $this->getHtmlHeaderKey($header, ['risk_category']),
                            'serial_number' => $this->getHtmlHeaderKey($header, ['serial_number']),
                            'number_of_sales' => $this->getHtmlHeaderKey($header, ['number_of_sales']),
                        ];
                        $claim = new Claim;
                        //判斷Excel 中的日期欄位有沒有沒戴上日期的
                        $excelDateNull = $this->checkExcelDateNull($v,$claim_date_attr_key_array);
                        if($excelDateNull){
                            //有日期沒戴上
                            //日期欄位預設資料
                            $defaultDateArray = $this->makeDefaultDateArray($claim_date_attr,$header,$v);
                        }
                        foreach ($v as $key => $value) {
                            $column_value = Claim::nameSwitch($header[$key], $value);
                            if (isset($header[$key])) {
                                //取出計算流水號要用的
                                if (in_array($key, $claim_num_attr_key_array)) {
                                    foreach ($claim_number as $head => $headKey) {
                                        if ($headKey[0] == $key) {
                                            if ($head == 'risk_category') {
                                                $claim_number[$head] = (new Claim)->getRiskCategoryAttribute($column_value);
                                            } else {
                                                $claim_number[$head] = $column_value;
                                            }
                                        }
                                    }
                                } else if (in_array($key, $claim_date_attr_key_array)) {
                                    //日期欄位
                                    if($excelDateNull){
                                        $claim->setAttribute($header[$key], $defaultDateArray[$header[$key]]);
                                    }else{
                                        $d = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($column_value)->format('Y-m-d H:i:s');
                                        $claim->setAttribute($header[$key], $d);
                                    }
                                } else {
                                    $claim->setAttribute($header[$key], $column_value);
                                }
                            }
                        }
    
                       
                        $claim->gender = $v[22];
                        $claim->note = $v[44];
    
                        $claim->risk_category = Claim::nameSwitch('risk_category', $claim_number['risk_category']);
    
                        $claim->serial_number = $claim_number['serial_number'];
                        $claim->number_of_sales = $claim_number['number_of_sales'];
                        $claim->claim_number = $claim_number['risk_category'] . $claim_number['serial_number'] . $claim_number['number_of_sales'];
                        
                        
                        $claim_count = Claim::where('serial_number',$claim_number['serial_number'])->count();
    
                        $claim_number_new = $claim->claim_number;
    
                        if($claim_count > 0){
    
                            $claim_serial_number = Claim::where('serial_number',$claim_number['serial_number'])->orderBy('claim_id','DESC')->first()->toArray();
    
                            $thisClaimNumberArray_new[$claim_number_new] = $claim_serial_number['claim_state'];
    
                        }
                        
    
    
                        array_push($thisClaimNumberArray,$claim->claim_number);
                        
    
                        $claim->updated_at = date('Y-m-d H:i:s');
                        $claim->created_at = date('Y-m-d H:i:s');
                        $claim->save();
                    }else{
                        DB::rollback();
                        return Redirect::back()->withErrors(['您所匯入的檔案'.$v[15].'流水號上架日不可早於週週投排程日']);
                    }
                    
                }
            }
            //判斷本次匯入是否有與之前相同的流水號
            $checkClaimNumber = $this->checkClaimNumber($beforeClaimNumberArray,$thisClaimNumberArray);
            if(!$checkClaimNumber['error']){
                DB::rollback();
                return Redirect::back()->withErrors(['您所匯入的檔案'.$checkClaimNumber['value'].'債權編號重複']);
            }

            $checkClaimState = $this->checkClaimState($beforeClaimNumberArray,$thisClaimNumberArray,$thisClaimNumberArray_new);
            if(!$checkClaimState){
                DB::rollback();
                return Redirect::back()->withErrors(['您所匯入的流水號重複，且最新狀態非已流標、還款中、已結案']);
            }

            // $m = new MailTo;
            // $m->claim_collecting_remind();
            DB::commit();
            return redirect('admin/claims')->with('import_success');
        } catch (\Throwable $th) {
            DB::rollback();
            if ($th->getMessage() == 'A non well formed numeric value encountered') {
                return Redirect::back()->withErrors(['您所匯入的檔案日期格式有誤!']);
            } else {
                return Redirect::back()->withErrors(['您所匯入的檔案內容錯誤']);
            }
        }
    }

    /*預先投標*/
    public function buy_tenderer_import(Request $request)
    {

        $check = DB::select("select a_l_l_seq from admin_lv_log where user_id ='".Auth::user()->user_id."' and a_l_l_seq = 2");

        if(empty($check)){return Redirect::back()->withErrors(['注意權限不足!']);}

        $fileTypeName = $request->file('select_file')->getClientOriginalExtension();
        if ($fileTypeName != 'xlsx' && $fileTypeName != 'xls') {
            return Redirect::back()->withErrors(['您所匯入的檔案格式錯誤']);
        }
        try {
            DB::beginTransaction();
            $check = [];
            $claims = [];
            $claim_count = [];
            $claim_number = [];
            $toArray = Excel::toArray(new UsersImport, request()->file('select_file'));
            foreach ($toArray[0] as $k => $v) {
                if ($k != 0) {
                    if ($v[0] !='' && $v[1] !='' && $v[2] !='') {
                        $claims = DB::table("claims")
                        ->where("claim_number", $v[2])
                        ->first();

                        if (empty($claim_number[$v[2]])) {
                            $claim_number[$v[2]] = '';
                        }
                    
                        if ($claim_number[$v[2]] == $v[2]) {
                            $claim_count[$v[2]] ++;
                        } else {
                            $claim_number[$v[2]] = $v[2];
                            $claim_count[$v[2]] = 1;
                        }

                        if ($claim_count[$v[2]] == 1) {
                            $check[$v[2]] = 0;
                        }

                        $check[$v[2]] += $v[1];
                        $datasets = DB::select("select (SUM(amount))as tender_sum_amount from tender_documents where claim_id = ? ", [$claims->claim_id]);
                        if (empty($datasets)) {
                            $datasets[0]->tender_sum_amount = 0;
                        }
                        $canThrow = $claims->staging_amount - $datasets[0]->tender_sum_amount;
                        if ($claims->claim_state == 1 || $claims->claim_state == 0) {
                            if ($datasets[0]->tender_sum_amount != $claims->staging_amount) {
                                if ($v[1] <= $canThrow && $v[1] >= $claims->min_amount) {
                                    $users = DB::table("users")
                            ->where("member_number", $v[0])
                            ->first();
                                    $tender = new Tenders;
                                    $tender->user_id = $users->user_id;
                                    $tender->claim_id = $claims->claim_id;
                                    $order_number = Tenders::with(['tenders_claim'])->where('claim_id', $claims->claim_id)->orderBy('order_number', 'desc')->first('order_number');
                                    if (isset($order_number)) {
                                        $tender->order_number = sprintf("%03d", ($order_number->order_number) + 1);
                                    } else {
                                        $tender->order_number = sprintf("%03d", 1);
                                    }

                                    $tender->amount = $v[1];
                                    $tender->created_at = date('Y-m-d H:i:s');
                                    $tender->claim_certificate_number = $v[0] . $tender->order_number . $v[2];
                                    $tender->should_paid_at = $claims->payment_final_deadline;
                                    $tender->save();
                                } else {
                                    DB::rollback();
                                    return Redirect::back()->withErrors(["投資債權".$v[2]."的第".$claim_count[$v[2]]."次未達最低金額或是總投資金額超標"]);
                                }
                            } else {
                                DB::rollback();
                                return Redirect::back()->withErrors(["投資債權".$v[2]."已達標總投資金額不可再投資"]);
                            }
                        } else {
                            DB::rollback();
                            return Redirect::back()->withErrors(['投資債權'.$claims->claim_number.'尚未募集中']);
                        }
                    }
                }
            }
            DB::commit();
            return redirect('admin/claims')->with('import_success');
        } catch (\Throwable $th) {
            DB::rollback();
            return Redirect::back()->withErrors(['您所匯入的檔案內容錯誤']);
        }
    }
    /*匯入更改得標人*/
    public function change_tenderer_import(Request $request)
    {

        $check = DB::select("select a_l_l_seq from admin_lv_log where user_id ='".Auth::user()->user_id."' and a_l_l_seq = 2");

        if(empty($check)){return Redirect::back()->withErrors(['注意權限不足!']);}

        $fileTypeName = $request->file('select_file')->getClientOriginalExtension();
        if ($fileTypeName != 'xlsx' && $fileTypeName != 'xls') {
            return Redirect::back()->withErrors(['您所匯入的檔案格式錯誤']);
        }
        try {
            DB::beginTransaction();
            $check = [];
            $tenders = [];
            $tenders_count = [];
            $tenders_number = [];
            $toArray = Excel::toArray(new UsersImport, request()->file('select_file'));
            foreach ($toArray[0] as $k => $v) {
                if ($k != 0) {
                    if ($v[0] !='' && $v[1] !='' && $v[2] !='') {

                        $tenders = DB::select('SELECT * FROM `tender_documents` WHERE `claim_certificate_number` = ? and `tender_document_state` = 0 and `user_id` = (SELECT `user_id` FROM `users` WHERE `member_number` = ?)',[$v[1],$v[0]]);

                        if(empty($tenders_number[$v[1]])){
                            $tenders_number[$v[1]] = '';
                        }

                        if ($tenders_number[$v[1]] == $v[1]) {
                            $tenders_count[$v[1]] ++;
                        } else {
                            $tenders_number[$v[1]] = $v[1];
                            $tenders_count[$v[1]] = 1;
                        }
                        if (!empty($tenders)) {
                            //將tender_documents轉陣列
                            $temp1_d= json_encode($tenders);
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

                        
                            if ($tenders_count[$v[1]]==1) {
                                $tender_documents_b_b = DB::insert("INSERT INTO `tender_documents_remove` VALUES $data_d");

                                DB::update('UPDATE `tender_documents` SET `user_id` = ( SELECT `user_id` FROM `users` WHERE `member_number` = ?) WHERE `claim_certificate_number` = ? and `user_id` = ( SELECT `user_id` FROM `users` WHERE `member_number` = ? )', [$v[2],$v[1],$v[0]]);
                            } else {
                                DB::rollback();
                                return Redirect::back()->withErrors(['標單'.$v[1].'不可重複匯入'.$tenders_count[$v[1]].'次']);
                            }
                        }else{
                            DB::rollback();
                            return Redirect::back()->withErrors(['標單'.$v[1].'資料錯誤']);
                        }

                         
                    }
                }
            }
            DB::commit();
            return redirect('admin/claims')->with('import_success');
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            return Redirect::back()->withErrors(['您所匯入的檔案內容錯誤']);
        }
    }


    /**
     * 取得HTML格子內容的Key
     * @param array header_array Excel帶有欄位的陣列
     * @param array find_array 期望找到的欄位陣列
     * @return array
     */
    public function getHtmlHeaderKey($header_array, $find_array)
    {
        $key_array = [];
        foreach ($find_array as $find) {
            array_push($key_array, array_keys($header_array, $find)[0]);
        }
        return $key_array;
    }

    /**
     * 檢查本次匯入的claim_number是否重複
     *
     * @param  array $beforeClaimNumberArray = 匯入前claim所有流水號陣列(二微陣列 claim->toArray())
     * @param  array $thisClaimNumberArray = 本次匯入的流水號陣列
     * @return void
     */
    public function checkClaimNumber($beforeClaimNumberArray,$thisClaimNumberArray)
    {
        $result['error'] = true;
        $oldArray = [];
        foreach ($beforeClaimNumberArray as $o_claim_number) {
            array_push($oldArray,$o_claim_number['claim_number']);
        }

        foreach ($thisClaimNumberArray as $value) {
            if(in_array($value,$oldArray)){
                $result['error'] = false;
                $result['value'] = $value;
                return $result;
            }
        }
        if (count($thisClaimNumberArray) != count(array_unique($thisClaimNumberArray))) {
            $result['error'] = false;
            return $result;
        }
        return $result;
    }

     /**
     * 檢查本次匯入的claim_number是否重複
     *
     * @param  array $beforeClaimNumberArray = 匯入前claim所有流水號陣列(二微陣列 claim->toArray())
     * @param  array $thisClaimNumberArray = 本次匯入的流水號陣列
     * @return void
     */
    public function checkClaimState($beforeClaimNumberArray,$thisClaimNumberArray,$thisClaimNumberArray_new)
    {
        $result = true;
        $oldArray = [];
        foreach ($beforeClaimNumberArray as $o_claim_number) {
            array_push($oldArray,$o_claim_number['claim_number']);
        }

        foreach ($thisClaimNumberArray as $value) {

            if (!empty($thisClaimNumberArray_new[$value])) {
                if ($thisClaimNumberArray_new[$value] != '已流標' && $thisClaimNumberArray_new[$value] != '繳息還款' && $thisClaimNumberArray_new[$value] != '回收結案') {
                    $result = false;
                    return $result;
                }
            }
        }

        return $result;
    }

    /**
     * 檢查Excel 匯入的單一資料陣列中，日期欄位有沒有空值或沒戴值
     *
     * @param  mixed $excelRowData
     * @param  mixed $claim_date_attr_key_array 日期欄位對應的Key Array
     * @return bool true = 有空值 false = 日期都有戴上
     */
    public function checkExcelDateNull($excelRowData,$claim_date_attr_key_array)
    {
        foreach ($claim_date_attr_key_array as $excelDateKey) {
            if(!isset($excelRowData[$excelDateKey]) || is_null($excelRowData[$excelDateKey]) || empty($excelRowData[$excelDateKey])){
                return true;
            }
        }
        return false;
    }

    /**
     * 製作預設日期陣列，有戴上日期的將不改變
     *
     * @param  mixed $claim_date_attr
     * @param  mixed $header
     * @param  mixed $excelRowData
     * @return void
     */
    public function makeDefaultDateArray($claim_date_attr,$header,$excelRowData)
    {
        $result = [];
        foreach ($claim_date_attr as $dateColName) {
            $result[$dateColName] = null;
            $thisDataColInExcelDataKey = array_keys($header, $dateColName)[0];
            if(!isset($excelRowData[$thisDataColInExcelDataKey]) || is_null($excelRowData[$thisDataColInExcelDataKey]) || empty($excelRowData[$thisDataColInExcelDataKey])){
                $result[$dateColName] = null;
            }else{
                try {
                    $result[$dateColName] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($excelRowData[$thisDataColInExcelDataKey])->format('Y-m-d H:i:s');
                } catch (\Throwable $th) {
                    $result[$dateColName] = null;
                }
            }
        }
        $result = $this->checkDate($result);
        return $result;
    }

    // dd('stop');
    // Excel::import(new UsersImport, request()->file('select_file'));
    //  $path = $request->file('select_file')->getRealPath();
    //  $data = Excel::import($path)->get();
    //     dd($data);
    //  if($data->count() > 0)
    //  {
    //   foreach($data->toArray() as $key => $value)
    //   {
    //    foreach($value as $row)
    //    {
    //     $insert_data[] = array(
    //      '狀態'  => $row['state'],
    //      '分期起始日'   => $row['staged_at'],
    //      '原始債權總金額'   => $row['original_claim_amount'],
    //      '原始債權總期數'    => $row['periods'],
    //      '債權總金額'  => $row['staging_amount'],
    //      '剩餘債權總期數'   => $row['remaining_periods'],
    //      '風險評級'  => $row['risk_category'],
    //      '年化收益率'   => $row['annual_interest_rate'],
    //      '最低標額'   => $row['min_amount'],
    //      '最高標額'    => $row['max_amount'],
    //      '管理費費率'  => $row['management_fee_rate'],
    //      '貸款用途說明'   => $row['description'],
    //      '約定買回方'  => $row['agreement_buyer'],
    //      '買回條款'   => $row['agreement_buyer_clause'],
    //      '上架日'   => $row['launched_at'],
    //      '對應流水號'    => $row['serial_number'],
    //      '上抛次數'  => $row['number_of_sales'],
    //      '商品類別'   => $row['typing'],
    //      '還款方式'  => $row['repayment_method'],
    //      '自動結標'   => $row['auto_close_threshold'],
    //      '債權轉讓人'   => $row['debtor_transferor'],
    //      '借款人'    => $row['borrower'],
    //      '身分證號'  => $row['id_number'],
    //      '性別'   => $row['gender'],
    //      '年齡'  => $row['age'],
    //      '學歷'   => $row['education'],
    //      '婚姻狀況'   => $row['marital_state'],
    //      '居住地'    => $row['place_of_residence'],
    //      '居住狀況'  => $row['living_state'],
    //      '行業別'   => $row['industry'],
    //      '職稱'  => $row['job_title'],
    //      '年資'   => $row['seniority'],
    //      '月薪'   => $row['monthly_salary'],
    //      '連帶保證人'    => $row['guarantor'],
    //      '豬豬信用'  => $row['pig_credit'],
    //      '有效身分證'   => $row['id_number_effective'],
    //      '同業黑名單'  => $row['peer_blacklist'],
    //      '更生清算戶'   => $row['rehabilitated_settlement'],
    //      '票信狀況'   => $row['ticket_state'],
    //      '重大交通罰款'    => $row['major_traffic_fines'],
    //      '一年內同業查詢次數'  => $row['peer_query_count'],
    //      '海外'   => $row['foreign'],
    //      '出賣人名稱'  => $row['seller_name'],
    //      '出賣人地址'   => $row['seller_address'],
    //      '出賣人負責人'   => $row['seller_responsible_person'],
    //      '出賣人證件號'    => $row['seller_id_number'],
    //      '代理人名稱'  => $row['agent_name'],
    //      '代理人地址'   => $row['agent_address'],
    //      '代理人負責人'  => $row['agent_responsible_person'],
    //      '代理人字號'   => $row['agent_id_number'],
    //     );
    //    }
    //   }

    //   if(!empty($insert_data))
    //   {
    //    DB::table('claims')->insert($insert_data);
    //   }
    //  }
    //  return back()->with('success', '您所選擇的檔案匯入成功');
    // }
    public function buy_tenderer_download()
    {
        $file = public_path() . "/downloadable/預先投標匯入範例.xlsx";
        $headers = array(
            'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        );

        return response()->download($file, '預先投標匯入範例.xlsx', $headers);
    }
    public function change_tenderer_download()
    {
        $file = public_path() . "/downloadable/更改得標人匯入範例.xlsx";
        $headers = array(
            'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        );

        return response()->download($file, '更改得標人匯入範例.xlsx', $headers);
    }
    public function download()
    {
        $file = public_path() . "/downloadable/債權匯入範例(更改).xlsx";
        $headers = array(
            'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        );

        return response()->download($file, '債權匯入範例(更改).xlsx', $headers);
    }
    public function is_display(Request $request)
    {
        $id = $request->id;
        $chgTo = $request->chgTo;
        $check = DB::select("select a_l_l_seq from admin_lv_log where user_id ='".Auth::user()->user_id."' and a_l_l_seq = 2");
        if (!empty($check)) {
            $data['row'] = DB::table('claims')->where('claim_id', $id)->first();
            $row_data['is_display'] = !($data['row']->is_display);
            DB::table('claims')->where('claim_id', $id)->update($row_data);

            if ($chgTo == 1) {
                //通知所有前台 有開 接收信件的 使用者
                $email_array = $this->getCanReciveMailUserEmailAll();
                $from = false;
                $title = 'PPonline-債權上架通知';
                $ctx = ['親愛的PP用戶先生/女士',
                'PPonline有新的債權上架囉!',
            ];

                // $mailTo = [trim($user->email)];
                foreach ($email_array as $v) {
                    //no need 20200406
                // Mail::to($v)->send(new SampleMail($ctx, $from, $title));
                }
            }

            $return_data['success'] = true;
        } else {
            $return_data['error'] = true;
        }

        return response()->json($return_data);
    }

    public function is_receive_letter(Request $request)
    {
        $chgTo = $request->chgTo;
        //$data['row'] = DB::table('claims')->where('claim_id', $id)->first();
        //$row_data['is_display'] = !($data['row']->is_display);
        //DB::table('claims')->where('claim_id', $id)->update($row_data);
        $check = DB::select("select a_l_l_seq from admin_lv_log where user_id ='".Auth::user()->user_id."' and a_l_l_seq = 2");
        if(!empty($check)){

            if ($chgTo == 1) {
                $row_data['is_receive_letter'] = 1;
                DB::table('users')->where('is_receive_letter_type',0)->update($row_data);
            }else{
                $row_data['is_receive_letter'] = 0;
                DB::table('users')->update($row_data);
            }

            $return_data['success'] = true;
        }else{
            $return_data['error'] = true;
        }


        return response()->json($return_data);
    }

    /**
     * 更新債權頁面
     */
    public function claims_edit(Claim $claim)
    {
        $variableArray = array();
        $sysvar = array();

        $claimPdf = ClaimFiles::select('claim_files_id', 'file_name', 'file_path', 'sort')->where('claim_id', $claim->claim_id)->orderBy('sort', 'desc')->get();

        $claimFileObj = [];
        foreach ($claimPdf as $v) {
            $ar = [
                'isNew' => false,
                'id' => $v->claim_files_id,
                'sort' => $v->sort,
            ];
            array_push($claimFileObj, $ar);
        }

        foreach ($this->variable_name as $item) {
            $sv = SystemVariables::where('variable_name', $item)->first();
            array_push($variableArray, array($item => date('Y-m-d', strtotime('+' . $sv->value . 'day'))));
            array_push($sysvar, $sv->value);
        }


        $check = DB::select("select a_l_l_seq from admin_lv_log where user_id ='".Auth::user()->user_id."' and a_l_l_seq = 2");

        if(!empty($check)){
            return view('Back_End.claims.claims_edit_new', [
                'row' => $variableArray,
                'sysvar' => $sysvar,
                'editClaims' => $claim->claim_id,
                'claimPdf' => $claimPdf,
                'claimFileObj' => json_encode($claimFileObj),
            ]);
        }else{
            return redirect('admin/claims');
        }
        
    }
    /**
     * 新增債權
     */
    public function claims_store_BK(ClaimInsert $req, Claim $claim)
    {
        $validated = $req->validated();
        if ($validated) {
            $reqAll = $req->all();
            $reqAll = $this->checkDate($reqAll);
            // 上架日 < 開標日 且 開標日 < 起息日
            if ($reqAll['launched_at'] < $reqAll['start_collecting_at'] && $reqAll['start_collecting_at'] < $reqAll['value_date']) {
                try {
                    $claim = new Claim;
                    $reqAll = $this->preProccessData($reqAll, $claim);
                    DB::beginTransaction();
                    //檢查債權PDF是否要刪除
                    $reqAll = $this->checkDelClaimPdf($reqAll);
                    //開始儲存資料 Claim
                    foreach ($reqAll as $k => $v) {
                        $claim[$k] = $v;
                    }
                    $claim->save();

                    //債權PDF 新增
                    if ($req->file('pdf_name')) {
                        $savePdf = $this->saveClaimPdf($req, 'pdf_name', $claim->claim_id, $claim->claim_number);
                        if ($savePdf == false) {
                            DB::rollback();
                            $return['fileError'] = true;
                            return response()->json($return);
                        }
                    }

                    DB::commit();
                    $return['success'] = true;
                } catch (\Throwable $th) {
                    DB::rollback();
                    dd($th);
                    $return['wrong'] = true;
                }
            } else {
                $return['wrong'] = true;
            }
            return response()->json($return);
        }
    }

    /**
     * 儲存或更新債權Main Function
     * @param object $req 就是 Request整陀進來
     * @param string $trig 判斷更新或新增債權的參數 update | create
     * @return string 依照原先的人寫的丟回去
     */
    public function createOrUpdateClaim($req, $trig)
    {
        $reqAll = $req->all();
        $reqAll = $this->checkDate($reqAll);
        // 上架日 < 開標日 且 開標日 < 起息日
        if ($reqAll['launched_at'] < $reqAll['start_collecting_at'] && $reqAll['start_collecting_at'] < $reqAll['value_date']) {
            try {
                if ($trig == 'update') {
                    $claim = Claim::find($reqAll['claim_id']);
                    $ori_display = $claim->is_display;
                } else {
                    $claim = new Claim;
                }
                $reqAll = $this->preProccessData($reqAll, $claim);

                if ($trig == 'update') {
                    $reqAll['is_display'] = $ori_display;
                }else{
                    $reqAll['created_at'] = date('Y-m-d H:i:s');
                }
                DB::beginTransaction();
                //檢查債權PDF是否要刪除
                $reqAll = $this->checkDelClaimPdf($reqAll);

                $check = DB::select("select a_l_l_seq from admin_lv_log where user_id ='".Auth::user()->user_id."' and a_l_l_seq = 2");

                if(empty($check)){
                    DB::rollback();
                    return 'wrong_lv';
                }

                $claimReq = $reqAll;
                unset($claimReq['pdf_name']);
                //開始儲存資料 Claim
                foreach ($claimReq as $k => $v) {
                    $claim[$k] = $v;
                }
                $claim->save();
                //債權PDF 新增
                if ($req->file('pdf_name')) {
                    $savePdf = $this->saveClaimPdf($req, 'pdf_name', $claim->claim_id, $claim->claim_number);
                    if ($savePdf == false) {
                        DB::rollback();
                        return 'fileError';
                    }
                }
                DB::commit();
                return 'success';
            } catch (\Throwable $th) {
                DB::rollback();
                dd($th);
                return 'wrong';
            }
        } else {
            return 'wrong';
        }
    }

    /**
     * 新增債權
     */
    public function claims_store(ClaimInsert $req, Claim $claim)
    {
        $validated = $req->validated();
        if ($validated) {
            $res = $this->createOrUpdateClaim($req, 'create');
            $return[$res] = true;
            // $m = new MailTo;
            // $m->claim_collecting_remind();
            return response()->json($return);
        }
    }
    /**
     * 更新債權
     */
    public function updateClaim(ClaimInsert $req)
    {
        $validated = $req->validated();
        if ($validated) {
            $res = $this->createOrUpdateClaim($req, 'update');
            $return[$res] = true;
            return response()->json($return);
        }
    }

    /**
     * 檢查刪除債權PDF
     */
    public function checkDelClaimPdf($reqAll)
    {
        if (isset($reqAll['removePdf'])) {
            $claimFileIdArray = $reqAll['removePdf'];
            $claimFileIdArray = explode(',', $claimFileIdArray);
            foreach ($claimFileIdArray as $claim_file_id) {
                if (isset($claim_file_id)) {
                    $claim_file = ClaimFiles::find($claim_file_id);
                    if (isset($claim_file)) {
                        $claim_file->delete();
                    }
                }
            }
            unset($reqAll['removePdf']);
            return $reqAll;
        } else {
            if (array_key_exists("removePdf", $reqAll)) {
                unset($reqAll['removePdf']);
                return $reqAll;
            } else {
                return $reqAll;
            }
        }
    }
    /**
     * 儲存債權PDF
     */
    public function saveClaimPdf_BK_real_PDF($req, $inputFileName, $claim_id)
    {
        foreach ($req->file($inputFileName) as $ff) {
            $fileSize = ($ff->getSize()) / 1024 / 1024;
            $fileTypeName = $ff->getClientOriginalExtension();
            if ($fileTypeName != 'pdf' || $fileSize > config('fileSizeLimit.claims_create_pdf_max_size')) {
                return false;
            }
        }
        foreach ($req->file($inputFileName) as $fi) {
            $fileTypeName = $fi->getClientOriginalExtension();
            $filePath = $this->StorePdf_array($req, $fi);
            $claim_file = new ClaimFiles;
            $claim_file->file_path = $filePath;
            $claim_file->claim_id = $claim_id;
            $claim_file->file_name = $fi->getClientOriginalName();
            $claim_file->create_at = date('Y-m-d H:i:s');
            $claim_file->save();
        }
        return true;
    }

    /**
     * 儲存債權 圖片
     */
    public function saveClaimPdf($req, $inputFileName, $claim_id, $claim_number)
    {
        foreach ($req->file($inputFileName) as $ff) {

            $fileSize = ($ff->getSize()) / 1024 / 1024;
            $fileTypeName = $ff->getClientOriginalExtension();
            if (($fileTypeName != 'jpg' && $fileTypeName != 'png'&& $fileTypeName != 'jpeg') || $fileSize > config('fileSizeLimit.claims_create_pdf_max_size')) {
                return false;
            }
        }
        $claim_count = 1;
        foreach ($req->file($inputFileName) as $fi) {
            $fileTypeName = $fi->getClientOriginalExtension();
            $filePath = $this->StorePdf_array($req, $fi, $claim_id, $claim_number, $claim_count);
            $claim_file = new ClaimFiles;
            $claim_file->file_path = $filePath;
            $claim_file->claim_id = $claim_id;
            $claim_file->file_name = $fi->getClientOriginalName();
            $claim_file->create_at = date('Y-m-d H:i:s');
            $claim_file->save();
            $claim_count ++;
        }
        return true;
    }
    /**
     * 儲存債權時對請求資料做一些前處理
     * @param array $request = Request $req->all()
     * @param object $claim = 債權的model實例
     */
    public function preProccessData($reqAll, $claim)
    {
        if (isset($reqAll['utf8'])) {
            unset($reqAll['utf8']);
        }
        if (isset($reqAll['_token'])) {
            unset($reqAll['_token']);
        }
        //流水後
        $risk = $claim->getRiskCategoryAttribute($reqAll['risk_category']);
        $reqAll['claim_number'] = $risk . $reqAll['serial_number'] . $reqAll['number_of_sales'];
        //豬豬推手獎金%數
        // $reqAll['commission_interest_rate'] = ($reqAll['commission_interest_rate']) / 100;
        //自動結標
        $reqAll['is_auto_closed'] = (isset($reqAll['is_auto_closed'])) ? '1' : '0';
        //如果自動結標 = 1 將 auto_close_threshold 設為100
        if ($reqAll['is_auto_closed'] == '0') {
            $reqAll['auto_close_threshold'] = 100;
        } else {
            if (!isset($reqAll['auto_close_threshold']) || $reqAll['auto_close_threshold'] == '') {
                $reqAll['auto_close_threshold'] = 100;
            }
        }
        //預先投標
        $reqAll['is_pre_invest'] = (isset($reqAll['is_pre_invest'])) ? '1' : '0';
        //債權說明
        // $edit=  str_replace('<p>','',$reqAll['description']);
        // $reqAll['description'] =  str_replace('</p>','',$edit);
        //隱藏
        $reqAll['is_display'] = 0;

        $reqAll['updated_at'] = date('Y-m-d H:i:s');
        return $reqAll;
    }

    /**
     * 用來處理請求中的日期用
     * @param array $request = Request $req->all()
     */
    public function checkDate($request)
    {
        // launched_at = 上架日
        // opened = 開標 start_collecting_at
        // closed = 預計結標日 estimated_close_date
        // payment_final_deadline = 結標後最後繳款期限 payment_final_deadline
        // repayment = 起息日 value_date
        $now = date("Y-m-d H:i:s");
        $request['staged_at'] = (isset($request['staged_at'])) ? $request['staged_at'] : $now;
        //上架日 沒有就帶現在時間
        $request['launched_at'] = (isset($request['launched_at'])) ? $request['launched_at'] : $now;
        $request['start_collecting_at'] = (isset($request['start_collecting_at'])) ? $request['start_collecting_at'] : $this->getDefaultDate($request['launched_at'], 'opened');
        $request['estimated_close_date'] = (isset($request['estimated_close_date'])) ? $request['estimated_close_date'] : $this->getDefaultDate($request['launched_at'], 'closed');
        $request['payment_final_deadline'] = (isset($request['payment_final_deadline'])) ? $request['payment_final_deadline'] : $this->getDefaultDate($request['launched_at'], 'payment_final_deadline');
        $request['value_date'] = (isset($request['value_date'])) ? $request['value_date'] : $this->getDefaultDate($request['launched_at'], 'repayment');
        return $request;
    }
}
