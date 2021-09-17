<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\InboxLetters;
use App\Order;
use App\TenderRepayments;
use App\Tenders;
use App\Claim;
use App\TenderDocumentsRemove;
use App\User;
use App\SystemVariables;
use App\DataSettingAnnual;

use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

use App\Mail\SampleMail;
use Illuminate\Support\Facades\Mail;
use nusoap_client;
use App\Exports\FinacialExport;
use App\Mail\MailTo;


class TendersController extends Controller
{
    public function index(Tenders $tenders)
    {
        $datasets = Tenders::with(['tenders_user', 'tenders_claim'])->skip(0)->take(25)->get();

        $tender_documents_count = DB::select('select * from tender_documents');
        $row_data = array();
        $page_count = ceil(count($tender_documents_count)/25);
        foreach ($datasets as $dataset) {

            $value = DB::select('SELECT
            sum(tr.per_return_interest) AS return_interest
             FROM
                 tender_documents td , tender_repayments tr 
             where
                td.tender_documents_id = ? and  td.tender_documents_id = tr.tender_documents_id
             group by
                 td.tender_documents_id ',[$dataset->tender_documents_id]);


            if(!empty($value)) { 
                $td_data = $value[0]->return_interest;
            }else{
                $td_data = 0;
            }
            

            $row_data[$dataset->tender_documents_id] = $td_data;

        }

        $data['row'] = $tenders;
        $data['tender_date'] = DB::select("SELECT DATE_FORMAT(target_repayment_date,'%d') as trd FROM `tender_repayments` WHERE `target_repayment_date`>= ? AND `target_repayment_date` <= ? GROUP by `target_repayment_date`",[date('Y-m-01', strtotime('now')),date('Y-m-t', strtotime('now'))]);
        return view('Back_End.tenders.tenders_panel',
            ['datasets' => $datasets,'row_data' => $row_data,'page_count' => $page_count], $data);
    }

    public function search(Request $req)
    {

        
        $download = ((isset($req->download)))?true:false;

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
        $search['claim_number'] = $req->all()['claim_number'];
        $search['claim_certificate_number'] = $req->all()['claim_certificate_number'];
        $search['tender_document_state'] = $req->all()['tender_document_state'];
        $search['order_number'] = $req->all()['order_number'];
        $search['user_name'] = $req->all()['user_name'];
        $search['member_number'] = $req->all()['member_number'];
        $search['id_card_number'] = $req->all()['id_card_number'];
        $search['debtor_transferor'] = $req->all()['debtor_transferor'];
        $search['paid_at_start'] = $req->all()['paid_at_start'];
        $search['paid_at_end'] = $req->all()['paid_at_end'];
        $search['staged_at_start'] = $req->all()['staged_at_start'];
        $search['staged_at_end'] = $req->all()['staged_at_end'];
        $search['created_at_start'] = $req->all()['created_at_start'];
        $search['created_at_end'] = $req->all()['created_at_end'];

        $model = new Tenders;

        $repayment_method = new Claim;

        $sql_claim_number = '';
        $sql_debtor_transferor = '';
        $sql_user_name = '';
        $sql_id_card_number = '';
        $sql_member_number = '';
        $sql_claim_certificate_number = '';
        $sql_tender_document_state = '';
        $sql_order_number = '';
        $sql_paid_at = '';
        $sql_staged_at = '';
        $sql_created_at = '';
  
        if (isset($search['claim_number'])) {
            $sql_claim_number = " and c.claim_number LIKE '%".$search['claim_number']."%'";
        }
        if (isset($search['debtor_transferor'])) {
            $sql_debtor_transferor = " and c.debtor_transferor LIKE '%".$search['debtor_transferor']."%'";
        }
            
        if (isset($search['user_name'])) {
            $sql_user_name = " and u.user_name like '%".$search['user_name']."%'";
        }
        if (isset($search['id_card_number'])) {
            $sql_id_card_number = " and u.id_card_number LIKE '%".$search['id_card_number']."%'";
        }
        if (isset($search['member_number'])) {
            $sql_member_number = " and u.member_number LIKE '%".$search['member_number']."%'";
        }
           
        if (isset($search['claim_certificate_number'])) {
            $sql_claim_certificate_number = " and td.claim_certificate_number LIKE '%".$search['claim_certificate_number']."%'";
        }
        if (isset($search['tender_document_state'])) {
            $sql_tender_document_state = " and td.tender_document_state LIKE '%".$search['tender_document_state']."%'";
        }
        if (isset($search['order_number'])) {
            $sql_order_number= " and td.order_number LIKE '%".$search['order_number']."%'";
        }
        if (isset($search['paid_at_start']) && isset($search['paid_at_end'])) {
            $sql_paid_at = "and td.paid_at Between '".$search['paid_at_start']."' and '".$search['paid_at_end']."'";
        }
        if (isset($search['staged_at_start']) && isset($search['staged_at_end'])) {
            $sql_staged_at = "and c.value_date Between '".$search['staged_at_start']."' and '".$search['staged_at_end']."'";
        }
        if (isset($search['created_at_start']) && isset($search['created_at_end'])) {
            $sql_created_at = "and td.created_at Between '".$search['created_at_start']."' and '".$search['created_at_end']."'";
        }
       
        //暫時存取查詢結果以記頁數
        
        $page_count = DB::select("select td.*,td.created_at as td_created_at ,u.member_number,u.user_name,c.claim_number,c.periods,c.annual_interest_rate,c.repayment_method,(SELECT
        sum(tr.per_return_interest) 
        FROM
             tender_repayments tr 
        where
            td.tender_documents_id = tr.tender_documents_id
        group by
            td.tender_documents_id) AS return_interest from tender_documents td, users u , claims c where td.user_id = u.user_id and td.claim_id = c.claim_id ".$sql_claim_number." ".$sql_debtor_transferor." ".$sql_user_name." ".$sql_id_card_number." ".$sql_member_number." ".$sql_claim_certificate_number." ".$sql_tender_document_state." ".$sql_order_number." ".$sql_paid_at." ".$sql_staged_at." ".$sql_created_at." ");

        $sql_orderby='';

        if(empty($sequence)){
            $sql_orderby='ORDER BY td.created_at DESC';
            
        }elseif($sequence == 1){
            $sql_orderby='ORDER BY td.created_at ASC';
            
        }elseif($sequence == -1){
            $sql_orderby='ORDER BY td.created_at DESC';
            
        }elseif($sequence == 3){
            $sql_orderby='ORDER BY u.member_number ASC';
            
        }elseif($sequence == -3){
            $sql_orderby='ORDER BY u.member_number DESC';
            
        }elseif($sequence == 4){
            $sql_orderby='ORDER BY u.user_name ASC';
            
        }elseif($sequence == -4){
            
            $sql_orderby='ORDER BY u.user_name DESC';
           
        }elseif($sequence == 5){
            $sql_orderby='ORDER BY return_interest ASC';
            
        }elseif($sequence == -5){
            
            $sql_orderby='ORDER BY return_interest DESC';
           
        }

        $searchTrig = false;
        foreach ($search as $v) {
            if (isset($v)) {
                $searchTrig = true;
            }
        }
        if($download){
            //下載
            $tender_documents = $this->excelData($page_count);
            $myFile = Excel::download( new UsersExport($tender_documents), '匯出全標單_'.date('Y-m-d').'.csv');

            return $myFile;
        }else{
            $data = DB::select("select td.*,td.created_at as td_created_at ,u.member_number,u.user_name,c.claim_number,c.periods,c.annual_interest_rate,c.repayment_method,(SELECT
            sum(tr.per_return_interest) 
            FROM
                 tender_repayments tr 
            where
                td.tender_documents_id = tr.tender_documents_id
            group by
                td.tender_documents_id)AS return_interest from tender_documents td, users u , claims c where td.user_id = u.user_id and td.claim_id = c.claim_id ".$sql_claim_number." ".$sql_debtor_transferor." ".$sql_user_name." ".$sql_id_card_number." ".$sql_member_number." ".$sql_claim_certificate_number." ".$sql_tender_document_state." ".$sql_order_number." ".$sql_paid_at." ".$sql_staged_at." ".$sql_created_at." ".$sql_orderby." limit ".$page.",".$number_page." ");
            // dd($data);
            $res = [];
            $count = 0;
            $res['data']= [];
            foreach ($data as $v) {
                $ar = [];
                $a = isset($v->user_id);
                $b = isset($v->claim_id);

                $trig = false;

                if ($a && $b) {
                    $trig = true;
                } elseif ($a && !$b) {
                    $trig = false;
                } elseif (!$a && $b) {
                    $trig = false;
                }
                if (!$searchTrig) {
                    $trig = true;
                }

                if ($trig) {
                    // $value = DB::select('SELECT
                    // sum(tr.per_return_interest) AS return_interest
                    // FROM
                    //     tender_documents td , tender_repayments tr 
                    // where
                    //     td.tender_documents_id = ? and  td.tender_documents_id = tr.tender_documents_id
                    // group by
                    //     td.tender_documents_id ', [$v->tender_documents_id]);


                    // if (!empty($value)) {
                    //     $td_return_interest = $value[0]->return_interest;
                    // } else {
                    //     $td_return_interest = 0;
                    // }
                    $res['data'][$count]['created_at'] = $v->td_created_at;
                    $res['data'][$count]['claim_certificate_number'] = $v->claim_certificate_number;
                    $res['data'][$count]['member_number'] = $v->member_number;
                    $res['data'][$count]['user_name'] = $v->user_name;
                    $res['data'][$count]['order_number'] = $v->order_number;
                    $res['data'][$count]['claim_number'] = $v->claim_number;
                    $res['data'][$count]['tender_document_state'] = $model->getTenderDocumentStateAttribute($v->tender_document_state);
                    $res['data'][$count]['amount'] = $v->amount;
                    $res['data'][$count]['periods'] = $v->periods;
                    $res['data'][$count]['annual_interest_rate'] = $v->annual_interest_rate;
                    $res['data'][$count]['repayment_method'] = $repayment_method->getRepaymentMethodAttribute($v->repayment_method);
                    $res['data'][$count]['td_return_interest'] = $v->return_interest?$v->return_interest:'0';
               
                    $detail_btn = '<a target="_blank" href="/admin/tender_detail/'.$v->tender_documents_id.'" class="btn btn-info"><i style="margin-right: 0px;" class="fa fa-fw fa-eye"></i> </a>';
                
                    $res['data'][$count]['detail_btn'] = $detail_btn;
                    $cer = '"'.$v->claim_certificate_number.'"';

                    if ($v->tender_document_state == 5) {
                        $repay_btn = "<button id = 'paying".$v->tender_documents_id."' class='btn btn-info' onclick='paying($v->tender_documents_id, $cer)'>繳款</button>";
                    } else {
                        $repay_btn = "";
                    }
                    // $repay_btn = '<a href="#" class="btn btn-info">繳款</a>';
                    $res['data'][$count]['repay_btn'] = $repay_btn;
                    // $buyer_btn = '<a href="#" class="btn btn-info">test</a>';
                    // $buyer_btn = '';
                    // array_push($ar, $buyer_btn);

                    if ($v->tender_document_state == 0) {
                        $cancel_btn = "<button id = 'rm_btn".$v->tender_documents_id."' class='btn btn-danger'  onclick='rm_btn($v->tender_documents_id)'>取消</button>";
                    } else {
                        $cancel_btn = "";
                    }
              
                    $res['data'][$count]['cancel_btn'] = $cancel_btn;
                    $count++;
                }
            }
        }
        //計算頁數
        $res{'count'} = ceil(count($page_count)/$number_page);
        return response()->json($res);

    

    }
    public function excelData($Tenders)
    {
        $model = new Tenders;

        $Tenders_export = [
            ['標單建立時間',
             '標單編號',
             '得標人編號',
             '得標人',
             '得標序號',
             '物件編號',
             '狀態',
             '標單金額',
             '期數',
             '年化利率',
             '還款方式',
             '總應實現利潤'
             ]
        ];
        foreach($Tenders as $row)
        {
            // $value = DB::select('SELECT
            //         sum(tr.per_return_interest) AS return_interest
            //         FROM
            //             tender_documents td , tender_repayments tr 
            //         where
            //             td.tender_documents_id = ? and  td.tender_documents_id = tr.tender_documents_id
            //         group by
            //             td.tender_documents_id ', [$row->tender_documents_id]);


            // if (!empty($value)) {
            //     $td_return_interest = $value[0]->return_interest;
            // } else {
            //     $td_return_interest = 0;
            // }
            $repayment_method = new Claim;

            $ar = [$row->td_created_at,
                   $row->claim_certificate_number,
                   $row->member_number,
                   $row->user_name,
                   $row->order_number,
                   $row->claim_number,
                   $model->getTenderDocumentStateAttribute($row->tender_document_state),
                   $row->amount,
                   $row->periods,
                   $row->annual_interest_rate,
                   $repayment_method->getRepaymentMethodAttribute($row->repayment_method),
                   $row->return_interest?$row->return_interest:'0'
                ];
            array_push($Tenders_export,$ar);

        }
        return $Tenders_export;
    }
    public function tender_sql($name, $item, $tender_id)
    {
        $query['total'] = DB::select('
        SELECT
            sum(' . $item . ') AS ' . $name . '
        FROM
            tender_documents AS td
        LEFT JOIN
            tender_repayments AS tr ON td.tender_documents_id = tr.tender_documents_id
        where
            td.tender_documents_id = ' . $tender_id . '
        group by
            td.tender_documents_id;');
        $query['already'] = DB::select('
        SELECT
            sum(' . $item . ') AS ' . $name . '
        FROM
            tender_documents AS td
        LEFT JOIN
            tender_repayments AS tr ON td.tender_documents_id = tr.tender_documents_id
        where
            td.tender_documents_id = ' . $tender_id . '
        AND
            tr.credited_at is not null
        group by
            td.tender_documents_id');

        return ($query);

    }

    public function tender_details(Tenders $tenders)
    {

        $data['row'] = $tenders;
        $tender_id = $tenders->tender_documents_id;
        // foreach($tenders->tenders_repayment as $data){
        //     dd($data);
        // }
        // dd($tenders->tenders_repayment);

        $data['return_principal'] = $this->tender_sql('return_principal', 'tr.per_return_principal', $tender_id);
        $data['return_interest'] = $this->tender_sql('return_interest', 'tr.per_return_interest', $tender_id);
        // dd($tender_id);
        $data['management_fee'] = $this->tender_sql('management_fee', 'tr.management_fee', $tender_id);
        $data['income_amount'] = $this->tender_sql('income_amount', 'tr.per_return_interest-tr.management_fee', $tender_id);
        $data['someDate'] = Tenders::select('tender_withdraw_date','tender_withdraw_amount','transferer_cancel_date','trasferer_cancel_amount','floating_return_at','amount')->find($tender_id);
        return view('Back_End.tenders.tenders_detail', $data);

    }

    public function unpaid_export(Request $request)
    {
        $model = new Tenders;
        // $model = $model->where('tender_document_state','=','0')->orWhere('tender_document_state','=','5');
        $model = $model->whereIn('tender_document_state', ['0', '5'])->whereNotNull('order_id')->orderBy('tender_documents_id', 'asc');
        $data = $model->get();
        $tenders_export = [
            [
                'Order_id',
                '標單編號',
                '物件編號',
                '得標人',
                '得標序號',
                '虛擬帳號',
                '原始期數',
                '年化利率',
                '還款方式',
                '繳款金額',
                '繳款日期',
            ],
            [
                'order_id',
                'tender_documents_id',
                'claim_number',
                'user_name',
                'order_number',
                'virtual_account',
                'periods',
                'annual_interest_rate',
                'repayment_method',
                'amount',
                'paid_at',

            ],
        ];
        foreach ($data as $row) {
            $ar = [
                (isset($row->order_id)) ? $row->order_id : '',
                $row->tender_documents_id,
                (isset($row->tenders_claim->claim_number)) ? $row->tenders_claim->claim_number : 0,
                (isset($row->tenders_user->user_name)) ? $row->tenders_user->user_name : 0,
                $row->order_number,
                (isset($row->tenders_user->virtual_account)) ? (string) $row->tenders_user->virtual_account : '0',
                (isset($row->tenders_claim->periods)) ? $row->tenders_claim->periods : 0,
                (isset($row->tenders_claim->annual_interest_rate)) ? $row->tenders_claim->annual_interest_rate : 0,
                (isset($row->tenders_claim->repayment_method)) ? $row->tenders_claim->repayment_method : 0,
                (isset($row->amount)) ? $row->amount : 0,
            ];
            array_push($tenders_export, $ar);
        }
        $now = date('Y-m-d');
        $myFile = Excel::download(new UsersExport($tenders_export), $now . '_未繳款標單.xlsx');
        return $myFile;
    }
    public function pending_export(Request $req)
    {

        $search['target_repayment_date'] = $req->all()['target_repayment_date'];
        /* ========= 2020-03-27 11:05:38 change by Jason ========= */
        // $model = new TenderRepayments;
        // $model = $model->where('target_repayment_date', 'like', '%' . $search['target_repayment_date'] . '%');
        // $data = $model->get();
        $data = DB::select("SELECT
        tr.tender_documents_id as tender_documents_id,
        tr.tender_repayment_id AS tender_repayment_id,
        c.estimated_close_date AS estimated_close_date,
        u.user_name AS user_name,
        u.member_number AS member_number,
        tr.real_return_amount as real_return_amount,
        tr.period_number as period_number,
        tr.net_amount as net_amount,
        bl.bank_name AS bank_name,
        bl.bank_branch_code AS bank_branch_code,
        bl.bank_branch_name AS bank_branch_name,
        ub.bank_account AS bank_account,
        tr.target_repayment_date as target_repayment_date,
        tr.paid_at as paid_at,
        tr.credited_at as credited_at,
        tr.invoice_at,
        td.claim_certificate_number
    FROM
        tender_repayments AS tr , tender_documents AS td, claims AS c ,  users AS u ,user_bank AS ub ,bank_lists  AS bl 
    WHERE td.tender_document_state = 2
    AND td.tender_documents_id = tr.tender_documents_id
    AND c.claim_id = td.claim_id
    AND u.user_id = td.user_id
    AND ub.is_active = 1
    AND ub.user_id = td.user_id
    AND bl.bank_id = ub.bank_id
    AND tr.paid_at is null
        AND
        tr.target_repayment_date = '".$search['target_repayment_date']."' ORDER BY u.user_name
    ");

        $tenderRepayment_export = [
            ['系統ID',
                '結標日期',
                '姓名',
                '會員編號',
                '債權憑證號',
                '期別',
                '應返還金額',
                '開戶行',
                '代號',
                '帳號',
                '起息還款日',
                '入帳日期',
                '返還日期',
                '發票開立日期'
            ],
            ['tender_repayment_id',
                'estimated_close_date',
                'user_name',
                'member_number',
                'claim_certificate_number',
                'period_number',
                'net_amount',
                'bank_branch_name',
                'bank_branch_code',
                'bank_account',
                'target_repayment_date',
                'paid_at',
                'credited_at',
                'invoice_at'
            ],
        ];
        foreach ($data as $row) {
            $ar = [$row->tender_repayment_id,
                (isset($row->estimated_close_date)) ? $row->estimated_close_date : 0,
                (isset($row->user_name)) ? $row->user_name : 0,
                (isset($row->member_number)) ? $row->member_number : 0,
                (isset($row->claim_certificate_number)) ? $row->claim_certificate_number : 0,
                (string) $row->period_number,
                (isset($row->real_return_amount)) ? $row->real_return_amount : $row->net_amount];
            $bank_name = (isset($row->bank_name)) ? $row->bank_name : '';
            $bank_branch_name = (isset($row->bank_branch_name)) ? $row->bank_branch_name : '';

            $name = $bank_name . '' . $bank_branch_name;

            $bank_branch_code = (isset($row->bank_branch_code)) ? $row->bank_branch_code : '';

            $bank_account = (isset($row->bank_account)) ? "'".$row->bank_account : '' ;
            // $b = (isset($row->bank_account)) ? $row->bank_account : '';
            // $bank_account = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\StringHelper::formatNumber($b))
            // \PhpOffice\PhpSpreadsheet\Cell\DataType::setFormatCode()

            $tender_repayment_date = $row->target_repayment_date;

            array_push($ar, $name);
            array_push($ar, $bank_branch_code);
            array_push($ar, $bank_account);
            array_push($ar, $tender_repayment_date);
            array_push($tenderRepayment_export, $ar);
        }
        // foreach ($data as $row) {
        //     $ar = [$row->tender_repayment_id,
        //         (isset($row->repayment_tenders->tenders_claim->closed_at)) ? $row->repayment_tenders->tenders_claim->closed_at : 0,
        //         (isset($row->repayment_tenders->tenders_user->user_name)) ? $row->repayment_tenders->tenders_user->user_name : 0,
        //         (isset($row->repayment_tenders->tenders_user->member_number)) ? $row->repayment_tenders->tenders_user->member_number : 0,
        //         (isset($row->repayment_tenders->claim_certificate_number)) ? $row->repayment_tenders->claim_certificate_number : 0,
        //         (string) $row->period_number,
        //         $row->real_return_amount];
        //     $bank_name = (isset($row->repayment_tenders->tenders_user->user_banklist->bank_name)) ? $row->repayment_tenders->tenders_user->user_banklist->bank_name : '';
        //     $bank_branch_name = (isset($row->repayment_tenders->tenders_user->user_banklist->bank_branch_name)) ? $row->repayment_tenders->tenders_user->user_banklist->bank_branch_name : '';

        //     $name = $bank_name . '' . $bank_branch_name;

        //     $bank_branch_code = (isset($row->repayment_tenders->tenders_user->user_banklist->bank_branch_code)) ? $row->repayment_tenders->tenders_user->user_banklist->bank_branch_code : '';

        //     $bank_account = (isset($row->repayment_tenders->tenders_user->user_userbank->bank_account)) ? $row->repayment_tenders->tenders_user->user_userbank->bank_account : '';

        //     $tender_repayment_date = $row->target_repayment_date;

        //     array_push($ar, $name);
        //     array_push($ar, $bank_branch_code);
        //     array_push($ar, $bank_account);
        //     array_push($ar, $tender_repayment_date);
        //     array_push($tenderRepayment_export, $ar);
        // }
        $date = date("Y-m-d", strtotime($req->target_repayment_date));
        $myFile = Excel::download(new UsersExport($tenderRepayment_export), '下載待還款資料(' . $date . ').xlsx');
        return $myFile;
    }

    public function paid_import(Request $request)
    {
        $fileTypeName = $request->file('select_file')->getClientOriginalExtension();
        if ($fileTypeName != 'xlsx' && $fileTypeName != 'xls') {
            return Redirect::back()->withErrors(['您所匯入的檔案格式錯誤']);
        }
        $toArray = Excel::toArray(new UsersImport, request()->file('select_file'));
        $header = $toArray[0][1];

        $orderIdArray = [];
        $orderIdAmountArray = [];
        $user_id_for_mail = [];
        try {
            DB::beginTransaction();
            foreach ($toArray[0] as $k => $v) {
                if ($k != 0 && $k != 1) {
                    if ($v[10] != '' && isset($v[10])) {
                        $tender_document_state =  DB::select('select tender_document_state From tender_documents Where tender_documents_id = ? and tender_document_state = 5', [$v[1]]);
                        if (!empty($tender_document_state)) {
                            if (isset($v[0]) && isset($v[10]) && $v[10] != '') {
                                if (!in_array($v[0], $orderIdArray)) {
                                    //當order_id 不再陣列中
                                    array_push($orderIdArray, $v[0]);
                                    $orderIdAmountArray[$v[0]] = $v[9];
                                } else {
                                    $orderIdAmountArray[$v[0]] += $v[9];
                                }
                            }
    
                            if ($v[10] != '' && isset($v[10])) {
                                $tenders = Tenders::find($v[1]);
                                $tenders->paid_at = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($v[10]));
                                $tenders->tender_document_state = 1;
                                $tenders->updated_at = date('Y-m-d H:i:s');
                                $tenders->save();
    
                                array_push($user_id_for_mail, $tenders->user_id);
                            }
                        } else {
                            DB::rollback();
                            return Redirect::back()->withErrors(['標單編號'.$tenders->claim_certificate_number.'狀態非結標待繳']);
                        }
                    }
                    
                }
            }
            foreach ($orderIdAmountArray as $k => $v) {
                $order = Order::find($k);
                $order->actual_amount = $v;
                $order->updated_at = date('Y-m-d H:i:s');
                $order->is_send_sms = 1;
                $order->save();
            }

            $user_id_for_mail = array_unique($user_id_for_mail);
            foreach($user_id_for_mail as $k){
                $m = new MailTo;
                $m->user_paid_confirmed2($k);
            }

            
            DB::commit();
            return Redirect::back();
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            return Redirect::back()->withErrors(['您所匯入的檔案內容錯誤']);
        }
    }


    /**
     * 標單繳款 (tender_repayment) ，會用到鯨要API
     *
     * @param  mixed $request
     * @return void
     */
    public function repay_import(Request $request)
    {
        $fileTypeName = $request->file('select_repayment')->getClientOriginalExtension();
        if ($fileTypeName != 'xlsx' && $fileTypeName != 'xls') {
            return Redirect::back()->withErrors(['您所匯入的檔案格式錯誤']);
        }
        $toArray = Excel::toArray(new UsersImport, request()->file('select_repayment'));
        try {
            
            $uid_tid_fee_array = [];
            foreach ($toArray[0] as $k => $v) {
                if ($k != 0 && $k != 1) {
                        /* ========= 2020-03-31 14:24:35 change by Jason ========= */
                    if ($v[11] != '' && $v[12] != '' && $v[13] != '' ) {
                        $tenders = TenderRepayments::with('repayment_tenders')->find($v[0]);
                        // $tenders->paid_at = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($v[11]));
                        // $tenders->credited_at = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($v[12]));
                        // $tenders->tender_repayment_state = 2;
                        // $tenders->updated_at = date('Y-m-d H:i:s');
                        // $tenders->save();
                        //將同一個User 的 tender_repayment 的 managment_fee 加總再一起
                        //並針對同一個使用者發送一次 鯨要API 發票
                        $user_id = $tenders->repayment_tenders->user_id;

                        // array_push($user_id_mail,$user_id);

                        if(array_key_exists($user_id,$uid_tid_fee_array)){
                            //如果有UID存在
                            $uid_tid_fee_array[$user_id]['management_fee'] += $tenders->management_fee;
                        }else{
                            $uid_tid_fee_array[$user_id] = [];
                            $uid_tid_fee_array[$user_id]['tr_id'] = $v[0];
                            $uid_tid_fee_array[$user_id]['paid_at'] = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($v[11]));
                            $uid_tid_fee_array[$user_id]['management_fee'] = $tenders->management_fee;
                        }
                    }
                }
            }

            // $user_id_mail = array_unique($user_id_mail);
            // foreach ($user_id_mail as $k ){
            //     $m = new MailTo;
            //     $m->income_email($k);
            // }

            $xml_array = $this->makingXmlArray($uid_tid_fee_array);
            //呼叫鯨要API Function
            $this->sendInvoice($xml_array,$toArray);
            //更改management_fee 為0的狀態
            $this->change_management_fee_0($uid_tid_fee_array,$toArray);    
            
            return Redirect::back();
        } catch (\Throwable $th) {
            $this->logg('Error',["ERROR MSG" => $th]);
            return Redirect::back()->withErrors(['您所匯入的檔案內容錯誤']);
        }
    }

    //更改management_fee 為0的狀態
    public function change_management_fee_0($uid_tid_fee_array,$toArray)
    {
        $result = [];
        foreach ($uid_tid_fee_array as $user_id => $ten) {
            if ($ten['management_fee'] == 0) {
                $user = User::find($user_id);
                $ar = [
                    'email' => $user->email,
                ];
                array_push($result,$ar);
            }
        }
       
        $user_id_mail = [];
        foreach ($result as $key => $value) {

            $user = User::where('email',$value['email'])->first();

            foreach ($toArray[0] as $k => $v) {
                if ($k != 0 && $k != 1) {
                    /* ========= 2020-03-31 14:24:35 change by Jason ========= */
                    if ($v[11] != '' && $v[12] != '' && $v[13] != '') {
                        $tenders = TenderRepayments::with('repayment_tenders')->find($v[0]);

                        if($tenders->tender_repayment_state==0){

                            if ($tenders->repayment_tenders->user_id == $user->user_id) {

                                $bank_account=$v[9];
                                $data = DB::select('select * from user_bank where bank_account = ?',[$bank_account]);
                                $tenders->user_bank_id = $data[0]->user_bank_id;
                                if(empty($tenders->real_return_amount)){$tenders->real_return_amount = $v[6];}
                                $tenders->paid_at = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($v[11]));
                                $tenders->credited_at = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($v[12]));
                                $tenders->invoice_at = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($v[13]));
                                $tenders->tender_repayment_state = 2;
                                $tenders->updated_at = date('Y-m-d H:i:s');
                                $tenders->save();

                                $user_id = $tenders->repayment_tenders->user_id;

                                array_push($user_id_mail,$user_id);
    
                            }
                        }

                        
                    }
                }
            }
        }

        $user_id_mail = array_unique($user_id_mail);

        foreach ($user_id_mail as $k ){
            $m = new MailTo;
            $m->income_email($k);
        }
    }


    /**
     * 組合出sendInvoice Function 能吃的Array
     *
     * @param  mixed $uid_tid_fee_array = [user_id => [ 'tr_id' => tender_repayment_id , 'management_fee' => '總額' ] ,...];
     * @return void
     */
    public function makingXmlArray($uid_tid_fee_array)
    {
        $result = [];
        foreach ($uid_tid_fee_array as $user_id => $ten) {
            if($ten['management_fee'] != 0){
                $tenders = TenderRepayments::with('repayment_tenders')->find($ten['tr_id']);
                $user = User::find($user_id);
                $check_cp = DB::select('SELECT * FROM `company_user` WHERE `user_id` = ?',[$user->user_id]);
                if(!empty($check_cp)){$BuyerIdentifier = $user->id_card_number;}else{$BuyerIdentifier = '';}
                $xml_temp = '<?xml version="1.0" encoding="UTF-8"?>
                <Invoice XSDVersion="2.8">
                    <OrderId>'.$tenders->repayment_tenders->claim_certificate_number.date('Ymd').'</OrderId>
                    <OrderDate>'.date('Y/m/d',strtotime($ten["paid_at"])).'</OrderDate>
                    <BuyerIdentifier>'.$BuyerIdentifier.'</BuyerIdentifier>
                    <BuyerName>'.$user->user_name.'</BuyerName>
                    <BuyerEmailAddress>'.$user->email.'</BuyerEmailAddress>
                    <BuyerAddress>'.$user->getFullContactAddress().'</BuyerAddress>
                    <DonateMark>0</DonateMark>
                    <InvoiceType>07</InvoiceType>
                    <TaxType>1</TaxType>
                    <PayWay>2</PayWay>
                    <Details>
                        <ProductItem>
                            <ProductionCode>'.$tenders->tender_documents_id.'</ProductionCode>
                            <Description>手續費</Description>
                            <Quantity>1</Quantity>
                            <UnitPrice>'.$ten['management_fee'].'</UnitPrice>
                        </ProductItem>
                    </Details>
                </Invoice>';
                $xml_temp=str_replace('\"','"',$xml_temp);
                $ar = [
                    'email' => $user->email,
                    'xml' => $xml_temp,
                    'claim_certificate_number' => $tenders->repayment_tenders->claim_certificate_number
                ];
                array_push($result,$ar);
            }
        }
        return $result;
    }
    
    // /**
    //  * 寄發票API (鯨耀)
    //  *
    //  * @param  mixed $data
    //  * @return void
    //  */
    // public function sendInvoice($data)
    // {
    //     $url = config('app.invoiceUrl');
    //     $apiKey = config('app.invoiceApiKey');

    //     $errorMsg = ['有問題的訂單如下:'];
    //     $successMsg = ['成功發票如下:'];
    //     foreach ($data as $key => $value) {
    //         try {
    //             $param = array(
    //                 'hastax' => '1',
    //                 'rentid' => '54179376',
    //                 'source' => $apiKey,
    //                 'invoicexml' => $value['xml'],
    //             );

    //             $serverpath = $url;
    //             $client = new nusoap_client($serverpath, 'wsdl');

    //             $err = $client->getError();
    //             if ($err){
    //                 array_push($errorMsg,$value['claim_certificate_number']."Call 鯨耀發票API失敗A");
    //             }else{
    //                 $result = $client->call("CreateInvoiceV3", $param);
    //                 if(isset($result['return']) && strlen($result['return']) == 15){
    //                     // $this->invoiceMailToUser($value['email']);
    //                     $m = new MailTo;
    //                     $m->invoiceMailToUser($value['email']);
    //                     $invoice = explode(';',$result['return'])[0];
    //                     $successMsgText = $value['claim_certificate_number'] . '，發票號碼:'. $invoice;
    //                     array_push($successMsg,$successMsgText);
    //                 }else{
    //                     $errorText = $this->invoiceApiErrorMsg($result['return']);
    //                     array_push($errorMsg,$value['claim_certificate_number'].'，'.$errorText);
    //                 }
    //             }
    //         } catch (\Throwable $th) {
    //             // dd($th);
    //             $this->logg('Error',["ERROR MSG" => $th]);
    //             array_push($errorMsg,$value['claim_certificate_number']."Call 鯨耀發票API失敗");
    //         }
    //     }
    //     $toPPMailMsg = array_merge($successMsg,$errorMsg);
    //     $this->invoiceToPPMail($toPPMailMsg);
    // }


    /**
     * 寄發票API (鯨耀)
     *
     * @param  mixed $data
     * @return void
     */
    public function sendInvoice($data,$toArray)
    {
        $url = config('app.invoiceUrl');
        $apiKey = config('app.invoiceApiKey');

        $errorMsg = ['有問題的訂單如下:'];
        $successMsg = ['成功發票如下:'];
        $user_id_mail = [];
        
        foreach ($data as $key => $value) {
            try {
                $param = array(
                    'hastax' => '1',
                    'rentid' => '54179376',
                    'source' => $apiKey,
                    'invoicexml' => $value['xml'],
                );
                
                $serverpath = $url;

                libxml_disable_entity_loader(false);
                $client = new \SoapClient($serverpath, array('encoding'=>'UTF-8'));
                
                
                $result = $client->__soapCall('CreateInvoiceV3', array($param));
                
                $errorcode = $result->return;
                
                // return print_r($errorcode); exit;
                if(strlen($errorcode) == 15 && isset($errorcode)){

                    // $m = new MailTo;
                    // $m->invoiceMailToUser($value['email']);
                    $invoice = explode(';',$errorcode)[0];
                    $successMsgText = $value['claim_certificate_number'] . '，發票號碼:'. $invoice;
                    array_push($successMsg,$successMsgText);
                    
                    $user = User::where('email',$value['email'])->first();
                    

                    //驗證有問題
                    foreach ($toArray[0] as $k => $v) {

                        if ($k != 0 && $k != 1) {
                            /* ========= 2020-03-31 14:24:35 change by Jason ========= */
                            if ($v[11] != '' && $v[12] != '' && $v[13] != '') {

                                $tenders = TenderRepayments::with('repayment_tenders')->find($v[0]);

                                if($tenders->repayment_tenders->user_id == $user->user_id){


                                    $bank_account=$v[9];
                                    $data = DB::select('select * from user_bank where bank_account = ?',[$bank_account]);
                                    $tenders->user_bank_id = $data[0]->user_bank_id;
                                    if(empty($tenders->real_return_amount)){$tenders->real_return_amount = $v[6];}
                                    $tenders->paid_at = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($v[11]));
                                    $tenders->credited_at = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($v[12]));
                                    $tenders->invoice_at = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($v[13]));
                                    $tenders->tender_repayment_state = 2;
                                    $tenders->updated_at = date('Y-m-d H:i:s');
                                    $tenders->save();

                                    $user_id = $tenders->repayment_tenders->user_id;

                                    array_push($user_id_mail,$user_id);
                                }
                                
                            }
                        }
                    }

                    
                    
                }else{
                    $errorText = $this->invoiceApiErrorMsg($errorcode);
                    array_push($errorMsg,$value['claim_certificate_number'].'，'.$errorText);
                }
            } catch (\Throwable $th) {
                // dd($th);
                $this->logg('Error',["ERROR MSG" => $th]);
                array_push($errorMsg,$value['claim_certificate_number']."Call 鯨耀發票API失敗");
            }
        }
        
        $user_id_mail = array_unique($user_id_mail);

        foreach ($user_id_mail as $k ){
            $m = new MailTo;
            $m->income_email($k);
        }

        $toPPMailMsg = array_merge($successMsg,$errorMsg);
        $this->invoiceToPPMail($toPPMailMsg);
    
    }

    public function invoiceToPPMail($msg)
    {
        $title = '豬豬在線電子發票列表';
        
        $data = DB::SELECT("SELECT u.email,u.user_id FROM admin_lv_log a_l_l , users u WHERE u.user_id = a_l_l.user_id  and a_l_l.a_l_l_seq = 3 and u.user_id in (2663,1483)"); 
            
        foreach ($data as $k => $v){

            $from = false;

            // Mail::to($email)->send(new SampleMail($msg, $from, $title));
            $this->saveInbox($v->user_id, $title, $msg);

            $m = new MailTo;
            $m->send_template($v->email, $title, $msg);

        }    
            

            

    }

    public function saveInbox($user_id,$title,$ctx)
    {
        $InboxLetters = new InboxLetters;
        $InboxLetters->user_id = $user_id;
        $InboxLetters->title = $title;
        $content = '';
        foreach($ctx as $v){
            $content .= $v;
        }
        $InboxLetters->content = $content;
        $InboxLetters->created_at = date('Y-m-d H:i:s');
        $InboxLetters->updated_at = date('Y-m-d H:i:s');
        $InboxLetters->save();
    }
    // public function invoiceMailToUser($email)
    // {
    //     $from = false;
    //     $title = '系統通知';
    //     $ctx = ['手續費的發票稍晚會發送至您的電子信箱，如有任何疑問，請聯繫客服專員，我們將竭誠爲您服務'];
    //     Mail::to($email)->send(new SampleMail($ctx, $from, $title));
    // }
    public function invoiceApiErrorMsg($code)
    {
        switch ($code) {
            case "S1":
                $text = "Error 資料庫發生錯誤";
                return $text;
            break;
            case "S2":
                $text = "Error 訂單日期超過開立發票日期";
                return $text;
            break;
            case "S3":
                $text = "Error 未在發票申報期內";
                return $text;
            break;
            case "S4":
                $text = "Error 未取得發票號碼";
                return $text;
            break;
            case "S5":
                $text = "Error 發票號碼已使用完畢";
                return $text;
            break;
            case "S6":
                $text = "Error 超過租賃張數限制";
                return $text;
            break;
            case "S7":
                $text = "Error 訂單號碼已存在";
                return $text;
            break;
            default:
                $text = "Error 資料本身有問題";
                return $text;
            break;
                break;
        }
    }

    public function paying(Request $request)
    {
        $id = $request->id;
        $number = $request->num;

        $row_data['tender_document_state'] = 1;
        $row_data['paid_at'] = date('Y-m-d H:i:s');
        $row_data['updated_at'] = date('Y-m-d H:i:s');
        DB::table('tender_documents')->where('tender_documents_id', $id)->update($row_data);
        // $dbGet = DB::table('tender_documents')->where('tender_documents_id',$id)->get('claim_certificate_number');
        // $return_data['claim_certificate_number'] = get_object_vars($dbGet[0]);
        // dd($return_data);
        $tenders = Tenders::find($id);

        if(isset($tenders->order_id)){
            $order = Order::find($tenders->order_id);
            $actual_amount = $order->actual_amount + $tenders->amount;
            $order->actual_amount =$actual_amount;
            if($order->expected_amount == $actual_amount){$order->is_send_sms = 1;}
            $order->updated_at = date('Y-m-d H:i:s');
            $order->save();
        }

        // $m = new MailTo;
        // $m->user_paid_confirmed($tenders->user_id,$tenders->claim_certificate_number);

        $return_data['success'] = true;

        return response()->json($return_data);
    }

    /**
     * 匯出財務報表
     *
     * @param  mixed $req 至少需要 foreign 和 target_repayment_date
     * @return void
     */
    public function finacialExport(Request $req)
    {
        try {
            $reqAll = $req->all();
            $date = date("Y-m-d", strtotime($req->target_repayment_date));
            if(!isset($reqAll['foreign']) || !isset($reqAll['target_repayment_date'])){
                throw new \Exception('finacialExportRequestFail');
            }else{
                $fileName = ($reqAll['foreign'] == 0)? '財務報表(報稅)_' . $date . '.xlsx':'財務報表(不報稅)_' . $date . '.xlsx';
                return (new FinacialExport($reqAll))->download($fileName);
            }

        } catch (\Throwable $th) {
            if($th->getMessage() == 'finacialExportRequestFail'){
                return redirect()->back()->with('finacialExportRequestFail',true);
            }else{
                return redirect()->back()->with('finacialExportError',true);
            }
        }

    }

    public function taxExport(Request $req)
    {
        $search['target_repayment_date'] = $req->all()['target_repayment_date'];
        $search['target_repayment_date_month'] = $req->all()['target_repayment_date_month'];
        // $Year = date('Y',strtotime($search['target_repayment_date']));
        $Year =$search['target_repayment_date'];
        $month =$search['target_repayment_date_month'];
        
        $oldYear = ($Year).'-'.$month.'-01';
        if($month == 12){
            $newYear = ($Year+1).'-01-19';
        }else{
            $newYear = ($Year).'-'.($month+1).'-19';
        }
        $data = DB::select("
        SELECT
        '54179376' AS CompanyCode,
        '' AS companyShortName,
        3 AS suitTarget,
        '' AS departmentName,
        '' AS stuffNumber,
        '' AS costCenterName,
        '' AS outMember,
        u.id_card_number,
        u.user_name as name,
        u.birthday,
        u.contact_country,
        u.contact_district,
        u.contact_address,
        'TW' AS countryCode,
        '0' AS numberType,
        CONCAT(YEAR(p.target_repayment_date),
                '-',
                MONTH(p.target_repayment_date)) AS incomeYM,
        p.target_repayment_date,
        50 AS incomeType,
        '' AS incomeReduction,
        '兼職所得' AS comment,
        '' AS comment2,
        '' AS note,
        '' AS reduceTax,
        '' AS isReward,
        '' AS commonCol1,
        '' AS commonCol2,
        '0' AS freeTax,
        '0' AS FoodFeeInclude,
        SUM(p.benefits_amount) AS benefits_amount
    FROM
        tender_documents td , pusher_detail p ,users u 
        WHERE td.tender_document_state IN (2,4) and p.p_d_user_id = u.user_id
        and td.claim_certificate_number = p.claim_certificate_number and p.target_repayment_date >= '".$oldYear."'
        and p.target_repayment_date <= '".$newYear."'
        Group by p.p_d_user_id , p.target_repayment_date
    ORDER BY p.target_repayment_date , p.claim_certificate_number
    ");

    // dd($data);
        $header = "\xEF\xBB\xBF";
        $header .= "公司統編,公司簡稱,適用對象,員工編號,部門名稱,成本中心名稱,外部人員編號,身份證字號,姓名,生日,地址,國別代碼,證號別,所得月份,給付日期,所得類別代碼,所得扣繳類型代碼,備註,備註二,註記,扣抵稅額註記,屬於獎金性質,共同欄位一,共同欄位二,免稅額,內含伙食津貼,所得總額,扣繳稅率,扣繳稅額\n";
        $header .= "CompanyCode,companyShortName,suitTarget,stuffNumber,departmentName,costCenterName,outMember,id_card_number,name,birthday,contact_country,countryCode,numberType,incomeYM,target_repayment_date,incomeType,incomeReduction,comment,comment2,note,reduceTax,isReward,commonCol1,commonCol2,freeTax,FoodFeeInclude,benefits_amount,counter_num,counter_instead\n";
        foreach ($data as $row) {
            if ($row->benefits_amount != 0) {
                $header .=$row->CompanyCode.','.$row->companyShortName.','.$row->suitTarget.','.$row->stuffNumber.','.$row->departmentName.','.$row->costCenterName.','.$row->outMember.','.$row->id_card_number.','.$row->name.','."'".$row->birthday.','.$row->contact_country.$row->contact_district.$row->contact_address.','.$row->countryCode.','.$row->numberType.','."'".$row->incomeYM.','."'".date('Y-m-d', strtotime($row->target_repayment_date)).','.$row->incomeType.','.$row->incomeReduction.','.$row->comment.','.$row->comment2.','.$row->note.','.$row->reduceTax.','.$row->isReward.','.$row->commonCol1.','.$row->commonCol2.','.$row->freeTax.','.$row->FoodFeeInclude.','.$row->benefits_amount;
                // get Year的值
                $data = DataSettingAnnual::where('year', $Year)->get()->toArray();

                foreach ($data as $a_rows) {
                    // get Year的值
                    $total = $row->benefits_amount;
                    $instead = $a_rows['InsteadIncome'];

                    $counter_instead = 0;
                    if ($total > $instead) {
                        $counter_instead = $total*0.05;
                    } else {
                        $counter_instead = '0';
                    }

                    $counter_num = 0;
                    if ($counter_instead  > 0) {
                        $counter_num = '0.05';
                    } else {
                        $counter_num = '0';
                    }
                    $header .= ','.$counter_num.',';
                    $header .= (string)floor($counter_instead)."\n";
                }
            }
        }
        
        \header("Content-type:text/x-csv;charset=utf-8");
        \header("Content-Disposition: attachment; filename=信任豬報稅資料表(".$oldYear.").csv");
        // $header = mb_convert_encoding($header , "big5", "UTF-8");
        
        echo $header;
        exit;
        return redirect('admin/tender_documents');
        
        // // $date = date("Y", strtotime($Year));
        // $myFile = Excel::download(new UsersExport($tax_export), '信任豬報稅資料表(' . $Year . ').xlsx');
        // return $myFile;
    }

    public function taxExport_yatai(Request $req)
    {
        $search['target_repayment_date'] = $req->all()['target_repayment_date'];
        $search['target_repayment_date_month'] = $req->all()['target_repayment_date_month'];
        // $Year = date('Y',strtotime($search['target_repayment_date']));
        $Year =$search['target_repayment_date'];
        $month =$search['target_repayment_date_month'];
        $oldYear = ($Year).'-'.$month.'-01';
        if($month == 12){
            $newYear = ($Year+1).'-01-01';
        }else{
            $newYear = ($Year).'-'.($month+1).'-01';
        }
        
        $data = DB::select("
        SELECT
        '54188852' AS CompanyCode,
        '' AS companyShortName,
        3 AS suitTarget,
        '' AS departmentName,
        '' AS stuffNumber,
        '' AS costCenterName,
        '' AS outMember,
        u.id_card_number,
        u.user_name as name,
        u.birthday,
        u.contact_country,
        u.contact_district,
        u.contact_address,
        'TW' AS countryCode,
        '0' AS numberType,
        tr.credited_at,
        '5B' AS incomeType,
        '' AS incomeReduction,
        '利息所得' AS comment,
        '' AS comment2,
        '' AS note,
        '' AS reduceTax,
        '' AS isReward,
        '' AS commonCol1,
        '' AS commonCol2,
        '0' AS freeTax,
        '0' AS FoodFeeInclude,
        tr.per_return_interest,
        '0' AS counter_num,
        '0' AS counter_instead
    FROM
        tender_repayments as tr,tender_documents as td, users as u , claims as c
            WHERE tr.tender_documents_id = td.tender_documents_id and td.tender_document_state IN (2,4)
            and u.user_id = td.user_id  and c.`foreign` = 0 and c.claim_id = td.claim_id 
             and   '".$oldYear."'  <= tr.credited_at and tr.credited_at < '".$newYear."'
            and u.user_id not in(SELECT ifnull(user_id,null) FROM company_user cu  WHERE cu.user_id = u.user_id)  ORDER BY tr.credited_at

    ");

    // dd($data);
        $header = "\xEF\xBB\xBF";
        $header .= "公司統編,公司簡稱,適用對象,員工編號,部門名稱,成本中心名稱,外部人員編號,身份證字號,姓名,生日,地址,國別代碼,證號別,所得月份,給付日期,所得類別代碼,所得扣繳類型代碼,備註,備註二,註記,扣抵稅額註記,屬於獎金性質,共同欄位一,共同欄位二,免稅額,內含伙食津貼,所得總額,扣繳稅率,扣繳稅額\n";
        $header .="CompanyCode,companyShortName,suitTarget,stuffNumber,departmentName,costCenterName,outMember,id_card_number,name,birthday,contact_country,countryCode,numberType,credited_at,credited_at,incomeType,incomeReduction,comment,comment2,note,reduceTax,isReward,commonCol1,commonCol2,freeTax,FoodFeeInclude,per_return_interest,counter_num,counter_instead\n";
        foreach ($data as $row) {
            if ($row->per_return_interest != 0) {
                $header .= $row->CompanyCode.",".$row->companyShortName.",".$row->suitTarget.",".$row->stuffNumber.",".$row->departmentName.",".$row->costCenterName.",".$row->outMember.",".$row->id_card_number.",".$row->name.","."'".$row->birthday.",".$row->contact_country.$row->contact_district.$row->contact_address.",".$row->countryCode.",".$row->numberType.","."'".date('Y-m', strtotime($row->credited_at)).","."'".date('Y-m-d', strtotime($row->credited_at)).",".$row->incomeType.",".$row->incomeReduction.",".$row->comment.",".$row->comment2.",".$row->note.",".$row->reduceTax.",".$row->isReward.",".$row->commonCol1.",".$row->commonCol2.",".$row->freeTax.",".$row->FoodFeeInclude.",".$row->per_return_interest.",".$row->counter_num.",".$row->counter_instead."\n";
            }
        }

        \header("Content-type:text/x-csv;charset=utf-8");
        \header("Content-Disposition: attachment; filename=亞太報稅資料表(".$oldYear.").csv");
        // $header = mb_convert_encoding($header , "big5", "UTF-8");
        
        echo $header;
        exit;
        return redirect('admin/tender_documents');
        
        // $date = date("Y", strtotime($Year));
        // $myFile = Excel::download(new UsersExport($tax_export), '亞太報稅資料表(' . $Year . ')第一季.csv');
        // return $myFile;
    }
    
    public function taxExport_yatai2(Request $req)
    {
        $search['target_repayment_date'] = $req->all()['target_repayment_date'];
        // $Year = date('Y',strtotime($search['target_repayment_date']));
        $Year =$search['target_repayment_date'];
        $oldYear = $Year.'-03-01';
        $data = DB::select("
        SELECT
        '54188852' AS CompanyCode,
        '' AS companyShortName,
        3 AS suitTarget,
        '' AS departmentName,
        '' AS stuffNumber,
        '' AS costCenterName,
        '' AS outMember,
        dd.id_card_number,
        dd.user_name as name,
        dd.birthday,
        dd.contact_country,
        dd.contact_district,
        dd.contact_address,
        'TW' AS countryCode,
        '0' AS numberType,
        dd.credited_at,
        '5B' AS incomeType,
        '' AS incomeReduction,
        '利息所得' AS comment,
        '' AS comment2,
        '' AS note,
        '' AS reduceTax,
        '' AS isReward,
        '' AS commonCol1,
        '' AS commonCol2,
        '0' AS freeTax,
        '0' AS FoodFeeInclude,
        dd.per_return_interest,
        '0' AS counter_num,
        '0' AS counter_instead
    FROM
        (SELECT
            ud.credited_at,
            ud.per_return_interest,
            ud.id_card_number,
            ud.user_name,
            ud.birthday,
            ud.contact_country,
            ud.contact_district,
            ud.contact_address    
        FROM
            (SELECT 
                tr.credited_at,
             	tr.per_return_interest,
                tr.tender_documents_id,
                u.id_card_number,
                u.user_name,
                u.birthday,
                u.contact_country,
                u.contact_district,
                u.contact_address
            FROM
                tender_repayments as tr
            INNER JOIN
                (SELECT 
                    tender_documents_id,
                    user_id,
                    claim_id
                FROM    
                    tender_documents) as td on tr.tender_documents_id = td.tender_documents_id
            INNER JOIN         
                (SELECT 
                 id_card_number,
                 user_name,
                 birthday,
                 contact_country,
                 contact_district,
                 contact_address,
                 user_id
                 FROM users) as u on u.user_id = td.user_id 
            INNER JOIN
                (SELECT
                    claim_id
                FROM
                    claims
                WHERE
                    `foreign` = 0    
                )as c on c.claim_id = td.claim_id   
            WHERE 
            last_day('".$oldYear."')  < credited_at and credited_at < '".$Year."-07-01'
            )as ud)as dd ORDER BY credited_at

    ");

    // dd($data);

        $header = "\xEF\xBB\xBF";
        $header .= "公司統編,公司簡稱,適用對象,員工編號,部門名稱,成本中心名稱,外部人員編號,身份證字號,姓名,生日,地址,國別代碼,證號別,所得月份,給付日期,所得類別代碼,所得扣繳類型代碼,備註,備註二,註記,扣抵稅額註記,屬於獎金性質,共同欄位一,共同欄位二,免稅額,內含伙食津貼,所得總額,扣繳稅率,扣繳稅額\n";
        $header .="CompanyCode,companyShortName,suitTarget,stuffNumber,departmentName,costCenterName,outMember,id_card_number,name,birthday,contact_country,countryCode,numberType,credited_at,credited_at,incomeType,incomeReduction,comment,comment2,note,reduceTax,isReward,commonCol1,commonCol2,freeTax,FoodFeeInclude,per_return_interest,counter_num,counter_instead\n";
        foreach ($data as $row) {
            if ($row->per_return_interest != 0) {
                $header .= $row->CompanyCode.",".$row->companyShortName.",".$row->suitTarget.",".$row->stuffNumber.",".$row->departmentName.",".$row->costCenterName.",".$row->outMember.",".$row->id_card_number.",".$row->name.","."'".$row->birthday.",".$row->contact_country.$row->contact_district.$row->contact_address.",".$row->countryCode.",".$row->numberType.","."'".date('Y-m', strtotime($row->credited_at)).","."'".date('Y-m-d', strtotime($row->credited_at)).",".$row->incomeType.",".$row->incomeReduction.",".$row->comment.",".$row->comment2.",".$row->note.",".$row->reduceTax.",".$row->isReward.",".$row->commonCol1.",".$row->commonCol2.",".$row->freeTax.",".$row->FoodFeeInclude.",".$row->per_return_interest.",".$row->counter_num.",".$row->counter_instead."\n";
            }
        }

        \header("Content-type:text/x-csv;charset=utf-8");
        \header("Content-Disposition: attachment; filename=亞太報稅資料表(".$Year.")第二季.csv");
        // $header = mb_convert_encoding($header , "big5", "UTF-8");
        
        echo $header;
        exit;
        return redirect('admin/tender_documents');

        // $date = date("Y", strtotime($Year));
        // $myFile = Excel::download(new UsersExport($tax_export), '亞太報稅資料表(' . $Year . ')第二季.csv');
        // return $myFile;
    }

    public function taxExport_yatai3(Request $req)
    {
        $search['target_repayment_date'] = $req->all()['target_repayment_date'];
        // $Year = date('Y',strtotime($search['target_repayment_date']));
        $Year =$search['target_repayment_date'];
        $oldYear = $Year.'-06-01';
        $data = DB::select("
        SELECT
        '54188852' AS CompanyCode,
        '' AS companyShortName,
        3 AS suitTarget,
        '' AS departmentName,
        '' AS stuffNumber,
        '' AS costCenterName,
        '' AS outMember,
        dd.id_card_number,
        dd.user_name as name,
        dd.birthday,
        dd.contact_country,
        dd.contact_district,
        dd.contact_address,
        'TW' AS countryCode,
        '0' AS numberType,
        dd.credited_at,
        '5B' AS incomeType,
        '' AS incomeReduction,
        '利息所得' AS comment,
        '' AS comment2,
        '' AS note,
        '' AS reduceTax,
        '' AS isReward,
        '' AS commonCol1,
        '' AS commonCol2,
        '0' AS freeTax,
        '0' AS FoodFeeInclude,
        dd.per_return_interest,
        '0' AS counter_num,
        '0' AS counter_instead
    FROM
        (SELECT
            ud.credited_at,
            ud.per_return_interest,
            ud.id_card_number,
            ud.user_name,
            ud.birthday,
            ud.contact_country,
            ud.contact_district,
            ud.contact_address    
        FROM
            (SELECT 
                tr.credited_at,
             	tr.per_return_interest,
                tr.tender_documents_id,
                u.id_card_number,
                u.user_name,
                u.birthday,
                u.contact_country,
                u.contact_district,
                u.contact_address
            FROM
                tender_repayments as tr
            INNER JOIN
                (SELECT 
                    tender_documents_id,
                    user_id,
                    claim_id
                FROM    
                    tender_documents) as td on tr.tender_documents_id = td.tender_documents_id
            INNER JOIN         
                (SELECT 
                 id_card_number,
                 user_name,
                 birthday,
                 contact_country,
                 contact_district,
                 contact_address,
                 user_id
                 FROM users) as u on u.user_id = td.user_id
            INNER JOIN
                (SELECT
                    claim_id
                FROM
                    claims
                WHERE
                    `foreign` = 0    
                )as c on c.claim_id = td.claim_id    
            WHERE 
            last_day('".$oldYear."')  < credited_at and credited_at < '".$Year."-10-01'
            )as ud)as dd ORDER BY credited_at

    ");

        // dd($data);
        $header = "\xEF\xBB\xBF";
        $header .= "公司統編,公司簡稱,適用對象,員工編號,部門名稱,成本中心名稱,外部人員編號,身份證字號,姓名,生日,地址,國別代碼,證號別,所得月份,給付日期,所得類別代碼,所得扣繳類型代碼,備註,備註二,註記,扣抵稅額註記,屬於獎金性質,共同欄位一,共同欄位二,免稅額,內含伙食津貼,所得總額,扣繳稅率,扣繳稅額\n";
        $header .="CompanyCode,companyShortName,suitTarget,stuffNumber,departmentName,costCenterName,outMember,id_card_number,name,birthday,contact_country,countryCode,numberType,credited_at,credited_at,incomeType,incomeReduction,comment,comment2,note,reduceTax,isReward,commonCol1,commonCol2,freeTax,FoodFeeInclude,per_return_interest,counter_num,counter_instead\n";
        foreach ($data as $row) {
            if ($row->per_return_interest != 0) {
                $header .= $row->CompanyCode.",".$row->companyShortName.",".$row->suitTarget.",".$row->stuffNumber.",".$row->departmentName.",".$row->costCenterName.",".$row->outMember.",".$row->id_card_number.",".$row->name.","."'".$row->birthday.",".$row->contact_country.$row->contact_district.$row->contact_address.",".$row->countryCode.",".$row->numberType.","."'".date('Y-m', strtotime($row->credited_at)).","."'".date('Y-m-d', strtotime($row->credited_at)).",".$row->incomeType.",".$row->incomeReduction.",".$row->comment.",".$row->comment2.",".$row->note.",".$row->reduceTax.",".$row->isReward.",".$row->commonCol1.",".$row->commonCol2.",".$row->freeTax.",".$row->FoodFeeInclude.",".$row->per_return_interest.",".$row->counter_num.",".$row->counter_instead."\n";
            }
        }

        \header("Content-type:text/x-csv;charset=utf-8");
        \header("Content-Disposition: attachment; filename=亞太報稅資料表(".$Year.")第三季.csv");
        // $header = mb_convert_encoding($header , "big5", "UTF-8");
        
        echo $header;
        exit;
        return redirect('admin/tender_documents');
        // $date = date("Y", strtotime($Year));
        // $myFile = Excel::download(new UsersExport($tax_export), '亞太報稅資料表(' . $Year . ')第三季.csv');
        // return $myFile;
    }

    public function taxExport_yatai4(Request $req)
    {
        $search['target_repayment_date'] = $req->all()['target_repayment_date'];
        // $Year = date('Y',strtotime($search['target_repayment_date']));
        $Year =$search['target_repayment_date'];
        $oldYear = $Year.'-09-01';
        $data = DB::select("
        SELECT
        '54188852' AS CompanyCode,
        '' AS companyShortName,
        3 AS suitTarget,
        '' AS departmentName,
        '' AS stuffNumber,
        '' AS costCenterName,
        '' AS outMember,
        dd.id_card_number,
        dd.user_name as name,
        dd.birthday,
        dd.contact_country,
        dd.contact_district,
        dd.contact_address,
        'TW' AS countryCode,
        '0' AS numberType,
        dd.credited_at,
        '5B' AS incomeType,
        '' AS incomeReduction,
        '利息所得' AS comment,
        '' AS comment2,
        '' AS note,
        '' AS reduceTax,
        '' AS isReward,
        '' AS commonCol1,
        '' AS commonCol2,
        '0' AS freeTax,
        '0' AS FoodFeeInclude,
        dd.per_return_interest,
        '0' AS counter_num,
        '0' AS counter_instead
    FROM
        (SELECT
            ud.credited_at,
            ud.per_return_interest,
            ud.id_card_number,
            ud.user_name,
            ud.birthday,
            ud.contact_country,
            ud.contact_district,
            ud.contact_address    
        FROM
            (SELECT 
                tr.credited_at,
             	tr.per_return_interest,
                tr.tender_documents_id,
                u.id_card_number,
                u.user_name,
                u.birthday,
                u.contact_country,
                u.contact_district,
                u.contact_address
            FROM
                tender_repayments as tr
            INNER JOIN
                (SELECT 
                    tender_documents_id,
                    user_id,
                    claim_id
                FROM    
                    tender_documents) as td on tr.tender_documents_id = td.tender_documents_id
            INNER JOIN         
                (SELECT 
                 id_card_number,
                 user_name,
                 birthday,
                 contact_country,
                 contact_district,
                 contact_address,
                 user_id
                 FROM users) as u on u.user_id = td.user_id
            INNER JOIN
                (SELECT
                    claim_id
                FROM
                    claims
                WHERE
                    `foreign` = 0    
                )as c on c.claim_id = td.claim_id    
            WHERE 
            last_day('".$oldYear."')  < credited_at and credited_at <= last_day('".$Year."-12-01')
            )as ud)as dd ORDER BY credited_at

    ");

        // dd($data);
        $header = "\xEF\xBB\xBF";
        $header .= "公司統編,公司簡稱,適用對象,員工編號,部門名稱,成本中心名稱,外部人員編號,身份證字號,姓名,生日,地址,國別代碼,證號別,所得月份,給付日期,所得類別代碼,所得扣繳類型代碼,備註,備註二,註記,扣抵稅額註記,屬於獎金性質,共同欄位一,共同欄位二,免稅額,內含伙食津貼,所得總額,扣繳稅率,扣繳稅額\n";
        $header .="CompanyCode,companyShortName,suitTarget,stuffNumber,departmentName,costCenterName,outMember,id_card_number,name,birthday,contact_country,countryCode,numberType,credited_at,credited_at,incomeType,incomeReduction,comment,comment2,note,reduceTax,isReward,commonCol1,commonCol2,freeTax,FoodFeeInclude,per_return_interest,counter_num,counter_instead\n";
        foreach ($data as $row) {
            if ($row->per_return_interest != 0) {
                $header .= $row->CompanyCode.",".$row->companyShortName.",".$row->suitTarget.",".$row->stuffNumber.",".$row->departmentName.",".$row->costCenterName.",".$row->outMember.",".$row->id_card_number.",".$row->name.","."'".$row->birthday.",".$row->contact_country.$row->contact_district.$row->contact_address.",".$row->countryCode.",".$row->numberType.","."'".date('Y-m', strtotime($row->credited_at)).","."'".date('Y-m-d', strtotime($row->credited_at)).",".$row->incomeType.",".$row->incomeReduction.",".$row->comment.",".$row->comment2.",".$row->note.",".$row->reduceTax.",".$row->isReward.",".$row->commonCol1.",".$row->commonCol2.",".$row->freeTax.",".$row->FoodFeeInclude.",".$row->per_return_interest.",".$row->counter_num.",".$row->counter_instead."\n";
            }
        }

        \header("Content-type:text/x-csv;charset=utf-8");
        \header("Content-Disposition: attachment; filename=亞太報稅資料表(".$Year.")第四季.csv");
        // $header = mb_convert_encoding($header , "big5", "UTF-8");
        
        echo $header;
        exit;
        return redirect('admin/tender_documents');
        // $date = date("Y", strtotime($Year));
        // $myFile = Excel::download(new UsersExport($tax_export), '亞太報稅資料表(' . $Year . ')第四季.csv');
        // return $myFile;
    }

    /**
     * 二代健保設定
     *
     * @param  mixed $req
     * @return void
     */
    public function setHealthSafe(Request $req)
    {
        try {
            return response()->json([
                'status' => 'success'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error'
            ]);
        }
        // SystemVariables::find();

    }

    public function remove(Request $req)
    {
        try {
            $tender = Tenders::find($req->id);
            TenderDocumentsRemove::create($tender->toArray());
            $tender->delete();
            return response()->json([
                'status' => 'success'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'fail'
            ],500);
        }
    }
}

// public function tableGenerator(Tenders $tenders,Request $request)
// {
//     $return_data['show'] = [
//                     'claim_certificate_number',
//                     'member_number',
//                     'user_name',
//                     'order_number',
//                     'claim_number',
//                     'tender_document_state',
//                     'amount',
//                     'period',
//                     'annual_interest_rate',
//                     'repayment_method'
//                      ];
//     $filter_query = $request['filter_query']->excepts(['_token']);
//     Log::debug($filter_query);
//     $Tender = Tenders::with(['tenders_user','tenders_claim'])->filter($filter_query)->get();
//     $tenderArray = [];
//     $columns = $tenders->getTableColumns();
//     foreach ($Tender as $key => $value) {
//         $ar = [] ;
//         foreach($columns as $v){
//             $ar[$v] = $value[$v];
//         }
//         $ar['member_number'] = (isset($value->tenders_user->member_number))?$value->tenders_user->member_number:null;
//         $ar['user_name'] = (isset($value->tenders_user->user_name))?$value->tenders_user->user_name:null;
//         $ar['claim_number'] = (isset($value->tenders_claim->claim_number))?$value->tenders_claim->claim_number:null;
//         $ar['period'] = (isset($value->tenders_claim->period))?$value->tenders_claim->period:null;
//         $ar['annual_interest_rate'] = (isset($value->tenders_claim->annual_interest_rate))?$value->tenders_claim->annual_interest_rate:null;
//         $ar['repayment_method'] = (isset($value->tenders_claim->repayment_method))?$value->tenders_claim->repayment_method:null;
//         array_push($tenderArray,$ar);
//     }

//     $return_data['dataset'] = $tenderArray;
//     $return_data['success'] = true;

//     return response()->json($return_data);

// }
