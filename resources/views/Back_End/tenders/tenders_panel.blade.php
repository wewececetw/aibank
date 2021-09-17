@extends('Back_End.layout.header')

@section('content')
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.zh-TW.min.js">
</script>
<script type="text/javascript" src="/js/daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="/js/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="/js/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />

<style>
    td {
        word-break: break-all !important;
    }

    .c3-axis-y>.tick {
        fill: none; // removes axis labels from y axis
    }

    #target_repayment_date {
        border: solid 1px #ccc;
        border-radius: inherit;
        padding: 2px;
    }
    /*設定div樣式的整體佈局*/
    .page-icon{
		margin:20px 0 0 0;/*設定距離頂部20畫素*/
		/* font-size:5;修復行內元素之間空隙間隔 */
		text-align:center;/*設定內容居中顯示*/
	}
    #background{
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        overflow: hidden;
        outline: 0;
        -webkit-overflow-scrolling: touch;
        background-color: rgb(0, 0, 0);  
        filter: alpha(opacity=60);  
        background-color: rgba(0, 0, 0, 0.6); 
        z-index: 9999;
    }
    .btn-info:hover , .btn-info:active , .btn-info:focus{
        background-color: #f00;
    }
</style>
<section id="main-content">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">標單專區</h3>
            </div>
        </div>

        <div class="an-single-component with-shadow">
            <div class="an-component-header search_wrapper">
                <div class="panel panel-default an-sidebar-search">
                    <div class="collapsed panel-heading" data-toggle="collapse" href="#search_panel"
                        style="cursor:pointer;">
                        <h4 class="panel-title">
                            篩選條件
                        </h4>
                    </div>
                    <div id="search_panel" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                            {{-- <form class="form-group" id="query_form"> --}}
                            @csrf

                            <div class="row">
                                <div class='form-group'>
                                    <label class='col-sm-2 control-label l-h-34'>物件編號</label>
                                    <div class="col-sm-4">
                                        <input type="hidden" id="now_page">
                                        <input type="hidden" id="count_page">
                                        <input type="hidden" id="sequence">
                                        <input type='text' name='claim_number' id="claim_number_search"
                                            placeholder='請輸入物件編號'
                                            class='an-form-control no-redius border-bottom m-0 text_color filter-name'>
                                    </div>

                                    <label class='col-sm-2 control-label l-h-34'>債權憑證號</label>
                                    <div class="col-sm-4">
                                        <input type='text' name='claim_certificate_number'
                                            id="claim_certificate_number_search" placeholder='請輸入債權憑證號'
                                            class='an-form-control no-redius border-bottom m-0 text_color filter-name'>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group">
                                    <label class='col-sm-2 control-label l-h-34'>狀態</label>
                                    <div class='col-sm-4'>
                                        <select name="tender_document_state" id="tender_document_state"
                                            class="select optional form-control select2 filter-loan_type"
                                            include_blank="true">
                                            <option value="" style="color:lightgray">選擇狀態</option>
                                            <option value="0">未繳款</option>
                                            <option value="1">已繳款</option>
                                            <option value="2">還款中</option>
                                            <option value="3">已流標</option>
                                            <option value="4">已結案</option>
                                            <option value="5">待繳款</option>
                                            <option value="6">已退款</option>
                                            <option value="7">異常</option>
                                            <option value="8">棄標</option>
                                        </select>
                                    </div>


                                    <label class='col-sm-2 control-label l-h-34'>得標序號</label>
                                    <div class="col-sm-4">
                                        <input type='text' name='order_number' id="order_number_search"
                                            placeholder='請輸入得標序號'
                                            class='an-form-control no-redius border-bottom m-0 text_color filter-name'>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class='form-group'>
                                    <label class='col-sm-2 control-label l-h-34'>得標人</label>
                                    <div class="col-sm-4">
                                        <input type='text' name='user_name' id="user_name_search" placeholder='請輸入得標人'
                                            class='an-form-control no-redius border-bottom m-0 text_color filter-name'>
                                    </div>

                                    <label class='col-sm-2 control-label l-h-34'>得標人編號</label>
                                    <div class="col-sm-4">
                                        <input type='text' name='member_number' id="member_number_search"
                                            placeholder='請輸入得標人編號'
                                            class='an-form-control no-redius border-bottom m-0 text_color filter-name'>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class='form-group'>
                                    <label class='col-sm-2 control-label l-h-34'>得標人身份證</label>
                                    <div class="col-sm-4">
                                        <input type='text' name='id_card_number' id="id_card_number_search"
                                            placeholder='請輸入得標人身份證'
                                            class='an-form-control no-redius border-bottom m-0 text_color filter-name'>
                                    </div>

                                    <label class='col-sm-2 control-label l-h-34'>債權轉讓人</label>
                                    <div class="col-sm-4">
                                        <input type='text' name='debtor_transferor' id="debtor_transferor_search"
                                            placeholder='請輸入債權轉讓人'
                                            class='an-form-control no-redius border-bottom m-0 text_color filter-name'>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group">
                                    <label class='col-sm-2 control-label l-h-34'>繳款狀態</label>
                                    <div class='col-sm-4'>
                                        <select name="loan_type"
                                            class="select optional form-control select2 filter-loan_type"
                                            include_blank="true" id="loan_loan_type">
                                            <option value="" style="color:lightgray">選擇繳款狀態</option>
                                            <option value="0">未還款</option>
                                            <option value="1">應還款而未還款</option>
                                            <option value="2">已還款</option>
                                        </select>
                                    </div>

                                    <div class="clear"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class='form-group'>
                                    <label class='col-sm-2 control-label l-h-34'>存入時間</label>
                                    <div class='col-sm-10'>
                                        <div class='col-sm-5 no-padding'>
                                            <div class='col-sm-12 no-padding'>
                                                <input type="text" class="datepicker form-control datepicker_style"
                                                    name="paid_at_start" id="paid_at_start_search" placeholder="開始時間">
                                            </div>
                                        </div>
                                        <div class='col-sm-1 no-padding l-h-34 t-center'> ~ </div>
                                        <div class='col-sm-6 no-padding'>
                                            <div class='col-sm-12 no-padding'>
                                                <input type="text" class="datepicker form-control datepicker_style"
                                                    name="paid_at_end" id="paid_at_end_search" placeholder="結束時間">
                                            </div>
                                        </div>
                                    </div>
                                    <div class='clear'></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class='form-group'>
                                    <label class='col-sm-2 control-label l-h-34'>起息還款日</label>
                                    <div class='col-sm-10'>
                                        <div class='col-sm-5 no-padding'>
                                            <div class='col-sm-12 no-padding'>
                                                <input type="text" class="datepicker form-control datepicker_style"
                                                    name="staged_at_start" id="staged_at_start_search"
                                                    placeholder="開始時間">
                                            </div>
                                        </div>
                                        <div class='col-sm-1 no-padding l-h-34 t-center'> ~ </div>
                                        <div class='col-sm-6 no-padding'>
                                            <div class='col-sm-12 no-padding'>
                                                <input type="text" class="datepicker form-control datepicker_style"
                                                    name="staged_at_end" id="staged_at_end_search" placeholder="結束時間">
                                            </div>
                                        </div>
                                    </div>
                                    <div class='clear'></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class='form-group'>
                                    <label class='col-sm-2 control-label l-h-34'>標單建立時間</label>
                                    <div class='col-sm-10'>
                                        <div class='col-sm-5 no-padding'>
                                            <div class='col-sm-12 no-padding'>
                                                <input type="text" class="datepicker form-control datepicker_style"
                                                    name="created_at_start" id="created_at_start_search"
                                                    placeholder="開始時間">
                                            </div>
                                        </div>
                                        <div class='col-sm-1 no-padding l-h-34 t-center'> ~ </div>
                                        <div class='col-sm-6 no-padding'>
                                            <div class='col-sm-12 no-padding'>
                                                <input type="text" class="datepicker form-control datepicker_style"
                                                    name="created_at_end" id="created_at_end_search" placeholder="結束時間">
                                            </div>
                                        </div>
                                    </div>
                                    <div class='clear'></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group pull-right">
                                    <div class="col-sm-12">
                                        <button class="btn btn-default reset-button" id="reset">
                                            清空
                                        </button>
                                        <button class="btn btn-info filter-button" id="submit">
                                            查詢
                                        </button>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </div>
                            {{-- </form> --}}
                        </div>
                    </div>
                </div>
            </div>
<?
/////////////////////////////////////////////權限判斷//////////////////////////////////////////////////////////////
$a_list = DB::select("select * from admin_lv_log where user_id ='".Auth::user()->user_id."' and a_l_l_seq = 3");
//echo Auth::user()->user_id;
  if( count($a_list) > 0 ){
?>
            <div class="an-component-header search_wrapper">
                <div class="container">
                    {{-- <h3 style="text-align:center">Import Excel File in Laravel</h3>
                         <br /> --}}
                    @if(count($errors) > 0)
                    <div class="alert alert-danger">
                        上傳內容驗證錯誤<br><br>
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                </div>
                <div class="m-b-10">
                    {{-- <a class="an-btn an-btn-primary" href="/admin/claims/new">全標單資料</a> --}}
                    <a href="/admin/tender_documents_export/unpaid" style="margin-left: 1px;" class="btn btn-info">匯出已結標未繳款標單</a>
                    <button type="button" class="btn btn-info lightbox_btn"
                        id="lightbox_tender_paid">標單繳款</button>
                <div class="clear"></div>

            </div>

            {{-- <div class="an-component-header search_wrapper">
                <div class="m-b-10" style="width: 100%; background-color: white; padding: 10px; border: 1px dotted">
                    <h3>2代健保及代扣所得起徵點設定及下載</h3>
                    <hr>
                    <div class="form-group">
                        <span>請選擇年分</span>
                        <select id="select_health_year" class="form-control">
                            <option value="N">請選擇</option>

                            @for($i = 0; $i <= 5; $i++)
                                @php
                                    $now = 2019;
                                    $year = $now + $i;
                                @endphp
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group hide" id="health1_block">
                        <label>兼職所得2代健保起徵點</label>
                        <input type="text" id="health1" class="form-control">
                    </div>
                    <div class="form-group hide" id="health2_block">
                        <label>代扣所得起徵點</label>
                        <input type="text" id="health2" class="form-control">
                    </div>
                    <button type="button" class="btn btn-info hide" id="setHealthSafe">送出</button>
                </div>

            </div> --}}

            <div class="an-component-header search_wrapper">
                <div class="m-b-10" style="width: 100%; background-color: white; padding: 10px; border: 1px dotted">
                    <span>請選擇年分</span>
                    <select id="select_year" class="form-group">
                        @for($i = 0; $i <= 10; $i++)
                            @php
                                $now = date('Y');
                                $year = $now - $i;
                            @endphp
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endfor
                    </select>
                    <span>請選擇月份</span>
                    <select id="select_month" class="form-group">
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}">{{ $i.'月' }}</option>
                        @endfor
                    </select>
                    <button type="button" class="btn btn-info" id="downloadTax">下載信任豬報稅資料</button>
                    <button type="button" class="btn btn-info" id="downloadTax_yatai">下載亞太報稅資料</button>
                    {{-- <button type="button" class="btn btn-info" id="downloadTax_yatai2">下載亞太第二季報稅資料</button>
                    <button type="button" class="btn btn-info" id="downloadTax_yatai3">下載亞太第三季報稅資料</button>
                    <button type="button" class="btn btn-info" id="downloadTax_yatai4">下載亞太第四季報稅資料</button> --}}
                </div>
            </div>

            <div class="an-component-header search_wrapper">

                <div class="m-b-10" style="width: 100%; background-color: white; padding: 10px; border: 1px dotted">
                    請選擇日期
                    <input type="text" class="datepicker  datepicker_style " id="target_repayment_date"
                        name="target_repayment_date" autocomplete="off" value="">
                    <button type="button" class="btn btn-info" id="downloadBtn">下載待還款資料</button>
                    <span>
                        <button type="button" class="btn btn-info lightbox_btn"
                        id="lightbox_tender_repay">標單還款</button>
                    </span>
                    <span>
                        <a class="btn btn-info downloadFinacial" data-id="0">下載財務報表(報稅)</a>
                        <a class="btn btn-info downloadFinacial" data-id="1">下載財務報表(不報稅)</a>
                    </span>
                    <div class="m-b-10" style="margin-top:15px;">
                            還款起息日:
                            @foreach ( $tender_date as $date)

                                {{ $date->trd }}

                            @endforeach
                    </div>

                </div>

                {{-- <button type="button" class="btn btn-info" id="downloadTax">報稅資料下載</button> --}}
                <div class="clear"></div>

            </div>



            <div class="an-component-header search_wrapper">

                <div class="push_lightbox" style="display: none" id="tender_paid">

                    <div class="" style="display: block;width:600px;margin:auto">
                        @if(count($errors) > 0)
                        <div class="alert alert-danger">
                            上傳內容驗證錯誤<br><br>
                            <ul>
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        @if($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                        @endif
                        <form id="import_tenders_form" enctype="multipart/form-data" method="post"
                            action="{{ url('/admin/tender_documents_import/paid') }}">
                            {{ csrf_field() }}
                            <div>
                                <div class="modal-content">
                                    <div class="" style="background:#5bb0bd;padding:20px">
                                        <button type="button" class="close"><span
                                                style="font-size:28px">×</span></button>
                                        <h3 class="modal-title">標單批次繳款</h3>
                                    </div>
                                    <div class="modal-body">
                                        <h4>注意</h4>
                                        <ol>
                                            <li>繳款日期若未填入，則該筆資料會略過不處理。</li>
                                            <li>若該筆標單狀態已繳款，則略過不進行處理。</li>
                                            <li>繳款日期格式範例：2018/04/28 或 2018-04-28，請依照此格式輸入。</li>
                                        </ol>
                                        <input required="required" type="file" name="select_file" id="">
                                    </div>
                                    <div class="modal-footer" style="text-shadow:none">

                                        <input type="submit" name="commit" value="匯入繳款資料" class="btn btn-info"
                                            data-disable-with="匯入繳款資料">
                                        <button type="button" class="btn btn-info back">返回</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="push_lightbox" style="display: none" id="tender_repay">

                    <div class="" style="display: block;width:600px;margin:auto">
                        @if(count($errors) > 0)
                        <div class="alert alert-danger">
                            上傳內容驗證錯誤<br><br>
                            <ul>
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        @if($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                        @endif
                        <form enctype="multipart/form-data" method="post"
                            action="{{ url('/admin/tender_documents_import/repay') }}">
                            {{ csrf_field() }}
                            <div>
                                <div class="modal-content">
                                    <div class="" style="background:#5bb0bd;padding:20px">
                                        <button type="button" class="close"><span
                                                style="font-size:28px">×</span></button>
                                        <h3 class="modal-title">匯入還款資料</h3>
                                    </div>
                                    <div class="modal-body">
                                        <h4>注意</h4>
                                        <ol>
                                            <li>請依照範例匯入，第一行請勿刪除。</li>
                                            <li>日期格式為YYYY-MM-DD，2018年4月18日 請輸入 2018-4-18。</li>
                                            <li>金額不需加上千分位符號。</li>
                                            <li>若要修改，則該標單的同一期資料再次匯入即可。</li>
                                            <li>系統ID請勿更動。</li>
                                        </ol>
                                        <input required="required" type="file" name="select_repayment">
                                    </div>
                                    <div class="modal-footer" style="text-shadow:none">

                                        <input type="submit" name="commit" value="匯入繳款資料" class="btn btn-info"
                                            data-disable-with="匯入繳款資料">
                                        <button type="button" class="btn btn-info back">返回</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


            </div>


            <div class="panel" style="margin-left: 20px;">
                <button class="btn btn-info" onclick="download_excel()">匯出全標單資料</button>
            </div>
<?
}
/////////////////////////////////////////////權限判斷//////////////////////////////////////////////////////////////
?>
            <div class="panel" style="margin-left: 20px;">
                <label>選擇一頁</label>
                <select onchange="number_page_change()" name="number_page" id="number_page">
                    <option value="">請選擇</option>
                    <option value="25">25</option>
                    <option value="100">100</option>
                </select>
                <label>筆</label>
            </div>

            <table id="tender_table" class="table table-bordered table_breaking m-b-10">
                <thead>
                    <tr>
                        <th style="cursor: pointer" onclick="change_sort('ca')" class='all'>標單建立時間</th>
                        <th class='all'>標單編號</th>
                        <th style="cursor: pointer" onclick="change_sort('mn')" class='all'>得標人編號</th>
                        <th style="cursor: pointer" onclick="change_sort('un')" class='all'>得標人</th>
                        <th class='all'>得標序號</th>
                        <th class='all'>物件編號</th>
                        <th class='all'>狀態</th>
                        <th class='all'>標單金額</th>
                        <th class='all'>上拋期數</th>
                        <th class='all'>年化利率</th>
                        <th class='all'>還款方式</th>
                        <th style="cursor: pointer" onclick="change_sort('ri')" class='all'>總應實現利潤</th>
                        <th class='all'>檢視</th>
                        <th class='all'>繳款</th>
                        {{-- <th class='all'>公司買</th> --}}
                        <th class='all'>取消</th>
                    </tr>
                </thead>
                <tbody id= "tender_table2">
                    @foreach($datasets as $dataset)
                    <tr>
                        <td>{{$dataset->created_at}}</td>
                        <td>{{$dataset->claim_certificate_number}}</td>
                        <td>{{ (isset($dataset->tenders_user->member_number))?$dataset->tenders_user->member_number:'無資料' }}</td>
                        <td>{{ (isset($dataset->tenders_user->user_name))?$dataset->tenders_user->user_name : '無資料'}}</td>
                        <td>{{$dataset->order_number}}</td>
                        <td>{{ (isset($dataset->tenders_claim->claim_number))?$dataset->tenders_claim->claim_number : '無資料'}}</td>
                        <td>{{$dataset->tender_document_state}}</td>
                        <td>{{$dataset->amount}}</td>
                        <td>{{ (isset($dataset->tenders_claim->periods))?$dataset->tenders_claim->periods : '無資料'}}</td>
                        <td>{{ (isset($dataset->tenders_claim->annual_interest_rate))?$dataset->tenders_claim->annual_interest_rate : '無資料'}}</td>
                        <td>{{ (isset($dataset->tenders_claim->repayment_method))?$dataset->tenders_claim->repayment_method : '無資料'}}</td>
                        <td>{{ (isset($row_data[$dataset->tender_documents_id]))?$row_data[$dataset->tender_documents_id] : '無資料'}}</td>
                        {{-- <a class="btn btn-primary insert_btn" href="#"></a> --}}
                        <td class="editable col-state">
                            <a target="_blank" href="/admin/tender_detail/{{$dataset->tender_documents_id}}" class="btn btn-info">
                            <i style="margin-right: 0px;" class="fa fa-fw fa-eye"></i></a>
                        </td>
                        {{--  ========= 2020-03-19 10:50:07 change by Jason START=========  --}}

                        @if($dataset->getOriginal('tender_document_state') == 5)
                            <td class="editable col-state">
                                <button class="btn btn-info" id = "paying{{$dataset->tender_documents_id}}."
                                    onclick="paying({{$dataset->tender_documents_id}},'{{$dataset->claim_certificate_number}}')">繳款</button>
                            </td>
                        @else
                            <td class="editable col-state"></td>
                        @endif
                        {{--  ========= 2020-03-19 10:50:07 change by Jason END=========  --}}
                        {{-- <td class="editable col-state">
                            <a href="#" class="btn btn-info">test</a>
                        </td> --}}
                        <td>
                            @if($dataset->getOriginal('tender_document_state') == 0)
                                <button id = "rm_btn{{$dataset->tender_documents_id}}." data-id="{{ $dataset->tender_documents_id }}" class="btn btn-danger rmTender" onclick="rm_btn({{ $dataset->tender_documents_id }})">
                                    取消
                                </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
            <div class="page-icon">
                <ul class="pagination">
                </ul>                            
            </div>
            <div style="display: none;" id="background">
                <p style="margin-top:25%;margin-left:50%;color:white;font-size:25px">頁面讀取中</p>
            </div>
    </section>
</section>

{{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> --}}

<script>
    function rm_btn(td_id){
            $.ajax({
                url:'{{ url("/admin/tender_documents/remove") }}',
                type:'POST',
                data:{
                    id : td_id
                },
                success:function(d){
                    if(d.status == 'success'){
                        swal('成功','已取消','success').then(()=>{
                            $("#rm_btn"+td_id).hide();
                        });
                    }else{
                        swal('錯誤','系統異常，請稍後再試','error').then(()=>{
                            location.reload();
                        });
                    }
                },
                error:function(e){
                    swal('錯誤','系統異常，請稍後再試','error').then(()=>{
                        location.reload();
                    });
                }
            });
    }

    $(document).ready(function () {

        $(function () {
            // $('.datepicker').datepicker({
            //     autoUpdateInput: false,
            //     locale: {
            //         format: "YYYY-MM-DD",
            //     },
            //     // autoUpdateInput: false,
            //     singleDatePicker: true,
            //     showDropdowns: true,
            //     minYear: 1901,
            //     maxYear: 3000,
            // });

            $('.datepicker').datepicker({
                format: "yyyy-mm-dd",
                language: 'zh-TW',
            })
            $('.datepicker').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD'));
            });

        });


        // $('#tender_table').DataTable({
        //     // sDom: 'lrtip',
        //     dom: 'Blfrtip',
        //     lengthChange: true,
        //     buttons: [{
        //         extend: 'excel',
        //         className: 'btn btn-info',
        //         text: '匯出全標單資料',
        //         filename: moment().format('YYYYMMDD') + '_全標單資料'
        //     }, ],
        //     iDisplayLength: 8,
        //     responsive: true,
        //     "autoWidth": false,
        //     searching: false,
        //     paging: true,
        //     info: false,
        //     order: [0, "asc"],
        //     "language": {
        //         "emptyTable": "------無相關資料符合------"
        //     }
        // });
        show_page();
        function show_page(){
            $("#now_page").val(1);
            $(".pagination").empty();
            let count = {{$page_count}};
            $("#count_page").val(count);
            let tmp = count_page(count);
            $(".pagination").append(tmp);
            $(".a_color").css("background-color","#fff");
            $("#a_color1").css("background-color","#EFF0ED");
        }
        //計算換頁分頁
        function count_page(count){
            //當前頁數
            let now_page = parseInt($("#now_page").val());
            let t = `<li><a class="a_color-1" onclick = "back_page()" href="#">&laquo;上一頁</a></li>
                                    <li onclick ="change_page(1)"><a class="a_color" id="a_color1" href="#">1</a></li>`;
            if(count>10){
                //當前頁數小於等於4
                if(now_page<4){
                    for(let x=2 ; x <= 4; x++){
                        t+=`<li onclick = "change_page(${x})"><a class="a_color" id="a_color${x}" href="#">`+x+`</a></li>`;
                    }
                    t+=`<li><a href="#">....</a></li>`;
                    for(let y=count-4 ; y <= count; y++){
                        t+=`<li onclick = "change_page(${y})"><a class="a_color" id="a_color${y}" href="#">`+y+`</a></li>`;
                    }
                }else if(now_page>=count-4){
                    t+=`<li><a href="#">....</a></li>`;
                    for( let x=count-5 ; x <= count; x++){
                        t+=`<li onclick = "change_page(${x})"><a class="a_color" id="a_color${x}" href="#">`+x+`</a></li>`;
                    }
                }else{
                    let x1 = now_page-2;
                    let x2 = now_page+2;
                    t+=`<li><a href="#">....</a></li>`;
                    for( let x=x1 ; x <= x2; x++){
                        t+=`<li onclick = "change_page(${x})"><a class="a_color" id="a_color${x}" href="#">`+x+`</a></li>`;
                    }
                    t+=`<li><a href="#">....</a></li>`;
                    
                    t+=`<li onclick = "change_page(${count})"><a href="#">`+count+`</a></li>`;
                    
                }
            }else if(count>=2){
                for(let x=2 ; x <= count; x++){
                    t+=`<li onclick = "change_page(${x})"><a href="#" class="a_color" id="a_color${x}" >`+x+`</a></li>`;
                }
            }                    
            
            t+=`<li><a class="a_color-2" onclick = "next_page()" href="#">下一頁&raquo;</a></li>`;
            return t;
        }

        $("#submit").click(function () {
            $("#background").show();
            //初始當前頁數
            $("#now_page").val(1);
            let data = getFliterData();
            $.ajax({
                url: "{{ url('/admin/tender_documents/search') }}",
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                success: function (d) {
                    redrawTable(d.data);
                    //初始當前頁數
                    $("#now_page").val(1);
                    //紀錄頁數
                    $("#count_page").val(d.count);
                    //顯示分頁
                    $(".pagination").empty();
                    let tmp = count_page(d.count);
                    $(".pagination").append(tmp);
                    $(".a_color").css("background-color","#fff");
                    $("#a_color1").css("background-color","#EFF0ED");
                    $("#background").hide();
                },
                error: function (e) {
                    console.log(e);
                }
            })
        });


         //重畫Table
         function redrawTable(obj){
            $("#tender_table2").empty();
            let tmp = '';
            $.each(obj,function(k,v){
                tmp += trTemp(v);
            })
            $("#tender_table2").append(tmp);
        }

        //TR 的模板
        function trTemp(d){
            let t = `
            <tr>
                <td>${d.created_at}</td>
                <td>${d.claim_certificate_number}</td>
                <td>${d.member_number}</td>
                <td>${d.user_name}</td>
                <td>${d.order_number}</td>
                <td>${d.claim_number}</td>
                <td>${d.tender_document_state}</td>
                <td>${d.amount}</td>
                <td>${d.periods}</td>
                <td>${d.annual_interest_rate}</td>
                <td>${d.repayment_method}</td>
                <td>${d.td_return_interest}</td>
                <td>${d.detail_btn}</td>
                <td>${d.repay_btn}</td>
                <td>${d.cancel_btn}</td>
            </tr>
            `
            return t;
        }


        $("#downloadBtn").click(function () {
            let target_repayment_date = $("#target_repayment_date").val();
            if (target_repayment_date == '') {
                alert('請選擇日期');
            } else {
                let data = {
                    target_repayment_date: target_repayment_date,
                }
                let url = "{{ url('/admin/tender_documents_export/pending') }}" + "?" + $.param(data);
                window.location = url;
            }
        })

        $(".downloadFinacial").click(function(){
            let foreign = $(this).attr('data-id');
            let target_repayment_date = $("#target_repayment_date").val();
            if (target_repayment_date == '') {
                alert('請選擇日期');
            } else {
                let data = {
                    target_repayment_date: target_repayment_date,
                    foreign:foreign
                }
                let url = "{{ url('/admin/tender_documents_export/finacialExport') }}" + "?" + $.param(data);
                window.location = url;
            }
        })

    });

    
    //上一頁
    function back_page(){
        let now_page =  parseInt($("#now_page").val());
        if(now_page == 1){
            $(".a_color-1").css("background-color","#fff");
        }else{
            change_page(now_page-1);
        }
    }
    //下一頁
    function next_page(){
        let now_page =  parseInt($("#now_page").val());
        let count_page = parseInt($("#count_page").val());
        if(now_page == count_page){
            $(".a_color-2").css("background-color","#fff");
        }else{
            change_page(now_page+1);
        }
    }

    //單頁更換
    function change_page(c){
        $("#background").show();
        $("#now_page").val(c);
        let data = getFliterData();
        $.ajax({
            url: "{{ url('/admin/tender_documents/search') }}",
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,
            success: function (d) {
            redrawTable(d.data);
            //初始當前頁數
            $("#now_page").val("");
            $("#now_page").val(c);
            //紀錄當前頁數
            $("#count_page").val(d.count);
            //顯示分頁
            $(".pagination").empty();
            let tmp = count_page2(d.count);
            $(".pagination").append(tmp);
            $(".a_color").css("background-color","#fff");
            $("#a_color"+c+"").css("background-color","#EFF0ED");
            $("#background").hide();
        },
        error: function (e) {
            console.log(e);
        }
    })
    }

    //重畫Table
    function redrawTable(obj){
                $("#tender_table2").empty();
                let tmp = '';
                $.each(obj,function(k,v){
                    tmp += trTemp(v);
                })
                $("#tender_table2").append(tmp);
    }

    //TR 的模板
    function trTemp(d){
            let t = `
            <tr>
                <td>${d.created_at}</td>
                <td>${d.claim_certificate_number}</td>
                <td>${d.member_number}</td>
                <td>${d.user_name}</td>
                <td>${d.order_number}</td>
                <td>${d.claim_number}</td>
                <td>${d.tender_document_state}</td>
                <td>${d.amount}</td>
                <td>${d.periods}</td>
                <td>${d.annual_interest_rate}</td>
                <td>${d.repayment_method}</td>
                <td>${d.td_return_interest}</td>
                <td>${d.detail_btn}</td>
                <td>${d.repay_btn}</td>
                <td>${d.cancel_btn}</td>
            </tr>
            `
            return t;
        }

     //計算換頁分頁
     function count_page2(count){
        //當前頁數
        let now_page = parseInt($("#now_page").val());
        let t = `<li><a class="a_color-1" onclick = "back_page()" href="#">&laquo;上一頁</a></li>
                                <li onclick ="change_page(1)"><a class="a_color" id="a_color1" href="#">1</a></li>`;
        if(count>10){
            //當前頁數小於等於4
            if(now_page<4){
                for(let x=2 ; x <= 4; x++){
                    t+=`<li onclick = "change_page(${x})"><a class="a_color" id="a_color${x}" href="#">`+x+`</a></li>`;
                }
                t+=`<li><a href="#">....</a></li>`;
                for(let y=count-4 ; y <= count; y++){
                    t+=`<li onclick = "change_page(${y})"><a class="a_color" id="a_color${y}" href="#">`+y+`</a></li>`;
                }
            }else if(now_page>=count-4){
                t+=`<li><a href="#">....</a></li>`;
                for( let x=count-5 ; x <= count; x++){
                    t+=`<li onclick = "change_page(${x})"><a class="a_color" id="a_color${x}" href="#">`+x+`</a></li>`;
                }
            }else{
                let x1 = now_page-2;
                let x2 = now_page+2;
                t+=`<li><a href="#">....</a></li>`;
                for( let x=x1 ; x <= x2; x++){
                    t+=`<li onclick = "change_page(${x})"><a class="a_color" id="a_color${x}" href="#">`+x+`</a></li>`;
                }
                t+=`<li><a href="#">....</a></li>`;
                
                t+=`<li onclick = "change_page(${count})"><a href="#">`+count+`</a></li>`;
                
            }
        }else if(count>=2){
            for(let x=2 ; x <= count; x++){
                t+=`<li onclick = "change_page(${x})"><a href="#" class="a_color" id="a_color${x}" >`+x+`</a></li>`;
            }
        }                    
        
        t+=`<li><a class="a_color-2" onclick = "next_page()" href="#">下一頁&raquo;</a></li>`;
        return t;
    }
    //變換排序
    function change_sort(th){
        let sequence = $("#sequence").val();
        $("#background").show();
        
        //三種排序欄位
        if(th == "ca"){
            //三種排序可能前置條件
            if(sequence != 1 && sequence != -1){
                $("#sequence").val(1);

            }else if(sequence == 1){
                $("#sequence").val(-1);

            }else if(sequence == -1){
                $("#sequence").val(1);

            }   
        }else if(th == "mn"){
            if(sequence != 3 && sequence != -3){
                $("#sequence").val(3);

            }else if(sequence == 3){
                $("#sequence").val(-3);

            }else if(sequence == -3){
                $("#sequence").val(3);

            }   
        }else if(th == "un"){
            if(sequence != 4 && sequence != -4){
                $("#sequence").val(4);

            }else if(sequence == 4){
                $("#sequence").val(-4);

            }else if(sequence == -4){
                $("#sequence").val(4);

            }   
        }else if(th == "ri"){
            if(sequence != 5 && sequence != -5){
                $("#sequence").val(5);

            }else if(sequence == 5){
                $("#sequence").val(-5);

            }else if(sequence == -5){
                $("#sequence").val(5);

            }  
        }
        let now_page = $("#now_page").val();
        let data = getFliterData();
        $.ajax({
            url: "{{ url('/admin/tender_documents/search') }}",
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,
            success: function (d) {
                redrawTable(d.data);
                //紀錄當前頁數
                $("#count_page").val(d.count);
                //顯示分頁
                $(".pagination").empty();
                let tmp = count_page2(d.count);
                $(".pagination").append(tmp);
                $(".a_color").css("background-color","#fff");
                $("#a_color"+now_page+"").css("background-color","#EFF0ED");
                $("#background").hide();
            },
            error: function (e) {
                console.log(e);
            }
        });
    }
    function number_page_change(){
        $("#background").show();
        let now_page = $("#now_page").val();
        let data = getFliterData();
        $.ajax({
            url: "{{ url('/admin/tender_documents/search') }}",
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,
            success: function (d) {
                redrawTable(d.data);
                //紀錄當前頁數
                $("#count_page").val(d.count);
                //顯示分頁
                $(".pagination").empty();
                let tmp = count_page2(d.count);
                $(".pagination").append(tmp);
                $(".a_color").css("background-color","#fff");
                $("#a_color"+now_page+"").css("background-color","#EFF0ED");
                $("#background").hide();
                if(now_page > d.count){$("#now_page").val(d.count);number_page_change()}
            },
            error: function (e) {
                console.log(e);
            }
        });
    }

    //下載excel
    function download_excel(type, fn, dl) {
        let data = getFliterData();
        console.log(data);
        let url = "{{ url('/admin/tender_documents/search/yes') }}" + "?" + $.param(data);
        // var url = "{{URL::to('downloadExcel_location_details')}}?" + $.param(query)
        window.location = url;
    }
    //取篩選值
    function getFliterData() {
            let sequence = $("#sequence").val();
            let number_page = $("#number_page").val();
            if(number_page==''){ number_page = 25;}
            let page = $("#now_page").val();
            let claim_certificate_number = $("#claim_certificate_number_search").val();
            let claim_number = $("#claim_number_search").val();
            let tender_document_state = $("#tender_document_state").val();
            let order_number = $("#order_number_search").val();
            let user_name = $("#user_name_search").val();
            let member_number = $("#member_number_search").val();
            let id_card_number = $("#id_card_number_search").val();
            let debtor_transferor = $("#debtor_transferor_search").val();
            let paid_at_start = $("#paid_at_start_search").val();
            let paid_at_end = $("#paid_at_end_search").val();
            let staged_at_start = $("#staged_at_start_search").val();
            let staged_at_end = $("#staged_at_end_search").val();
            let created_at_start = $("#created_at_start_search").val();
            let created_at_end = $("#created_at_end_search").val();
            let data = {
                claim_certificate_number: claim_certificate_number,
                claim_number: claim_number,
                tender_document_state: tender_document_state,
                order_number: order_number,
                user_name: user_name,
                member_number: member_number,
                id_card_number: id_card_number,
                debtor_transferor: debtor_transferor,
                paid_at_start: paid_at_start,
                paid_at_end: paid_at_end,
                staged_at_start: staged_at_start,
                staged_at_end: staged_at_end,
                created_at_start: created_at_start,
                created_at_end: created_at_end,
                sequence:sequence,
                number_page:number_page,
                page:page
            }
        return data;
    }
    //健保代扣 選擇年分
        $("#select_health_year").change(function(){
            let v = $(this).val();
            if(v == "N"){
                $("#health1_block").toggleClass('hide',true);
                $("#health2_block").toggleClass('hide',true);
                $("#setHealthSafe").toggleClass('hide',true);
            }else{
                $("#health1_block").toggleClass('hide',false);
            }
        })
        $("#health1").keyup(function(){
            if($(this).val().trim() == ''){
                $("#health2_block").toggleClass('hide',true);
                $("#setHealthSafe").toggleClass('hide',true);
            }else{
                $("#health2_block").toggleClass('hide',false);
            }
        })
        $("#health2").keyup(function(){
            if($(this).val().trim() == ''){
                $("#setHealthSafe").toggleClass('hide',true);
            }else{
                $("#setHealthSafe").toggleClass('hide',false);
            }
        })

        $("#setHealthSafe").click(function(){
            let year = $("#select_health_year").val();
            let health1 = $("#select_health_year").val();
            let health2 = $("#select_health_year").val();
            let data = {
                year:year,
                health1:health1,
                health2:health2
            }
            $.ajax({
                url:"{{ url('/admin/tender_documents/setHealthSafe') }}",
                type:"POST",
                success:function(d){
                    if(d.status != 'success'){
                        swal('系統異常','系統異常，請重新整理後再試，或通知系統管理員!','error');
                    }else{
                        swal('成功','2代健保設定成功!','success');
                    }
                },error:function(e){
                    swal('系統異常','系統異常，請重新整理後再試，或通知系統管理員!','error');
                }
            })
        })


        $("#downloadTax").click(function () {
            // let target_repayment_date = $("#target_repayment_date").val();
            let target_repayment_date = $("#select_year").val();
            let target_repayment_date_month = $("#select_month").val();
            if (target_repayment_date == '' || target_repayment_date_month == '') {
                alert('請選擇日期');
            } else {
                let data = {
                    target_repayment_date: target_repayment_date,
                    target_repayment_date_month:target_repayment_date_month
                }
                let url = "{{ url('/admin/tender_documents_export/taxExport') }}" + "?" + $.param(data);
                window.location = url;
            }
        })

        $("#downloadTax_yatai").click(function () {
            // let target_repayment_date = $("#target_repayment_date").val();
            let target_repayment_date = $("#select_year").val();
            let target_repayment_date_month = $("#select_month").val();
            if (target_repayment_date == '' || target_repayment_date_month == '') {
                alert('請選擇日期');
            } else {
                let data = {
                    target_repayment_date: target_repayment_date,
                    target_repayment_date_month: target_repayment_date_month
                }
                let url = "{{ url('/admin/tender_documents_export/taxExport_yatai') }}" + "?" + $.param(data);
                window.location = url;
            }
        })
        // $("#downloadTax_yatai2").click(function () {
        //     // let target_repayment_date = $("#target_repayment_date").val();
        //     let target_repayment_date = $("#select_year").val();
        //     if (target_repayment_date == '') {
        //         alert('請選擇日期');
        //     } else {
        //         let data = {
        //             target_repayment_date: target_repayment_date,
        //         }
        //         let url = "{{ url('/admin/tender_documents_export/taxExport_yatai2') }}" + "?" + $.param(data);
        //         window.location = url;
        //     }
        // })
        // $("#downloadTax_yatai3").click(function () {
        //     // let target_repayment_date = $("#target_repayment_date").val();
        //     let target_repayment_date = $("#select_year").val();
        //     if (target_repayment_date == '') {
        //         alert('請選擇日期');
        //     } else {
        //         let data = {
        //             target_repayment_date: target_repayment_date,
        //         }
        //         let url = "{{ url('/admin/tender_documents_export/taxExport_yatai3') }}" + "?" + $.param(data);
        //         window.location = url;
        //     }
        // })
        // $("#downloadTax_yatai4").click(function () {
        //     // let target_repayment_date = $("#target_repayment_date").val();
        //     let target_repayment_date = $("#select_year").val();
        //     if (target_repayment_date == '') {
        //         alert('請選擇日期');
        //     } else {
        //         let data = {
        //             target_repayment_date: target_repayment_date,
        //         }
        //         let url = "{{ url('/admin/tender_documents_export/taxExport_yatai4') }}" + "?" + $.param(data);
        //         window.location = url;
        //     }
        // })


    $(function () {
        $('#reset').click(function () {
            $("#claim_certificate_number_search").val("");
            $("#claim_number_search").val("");
            $("#tender_document_state").val("");
            $("#order_number_search").val("");
            $("#user_name_search").val("");
            $("#member_number_search").val("");
            $("#id_card_number_search").val("");
            $("#debtor_transferor_search").val("");
            $("#paid_at_start_search").val("");
            $("#paid_at_end_search").val("");
            $("#staged_at_start_search").val("");
            $("#staged_at_end_search").val("");
            $("#created_at_start_search").val("");
            $("#created_at_end_search").val("");
        });
    });

    $('.close,.back').click(function () {
        $('#tender_paid').fadeOut();
    })

    $('#lightbox_tender_paid').click(function () {
        $('#tender_paid').fadeIn();
    })
    $('.close,.back').click(function () {
        $('#tender_repay').fadeOut();
    })

    $('#lightbox_tender_repay').click(function () {
        $('#tender_repay').fadeIn();
    })

    function paying(target, number) {
        if (window.confirm('你確定要將' + number + '設為已繳款?')) {
            $.ajax({
                type: "POST",
                url: '/admin/tender_documents/paying',
                dataType: "json",
                data: {
                    id: target,
                    num: number,
                },

                success: function (data) {

                    if (data.success) {
                        alert('已將' + number + '設為己繳款');
                        $("#paying"+target).hide();
                    }

                }
            });
        }


    }
</script>

@if(Session::has('finacialExportError'))
<script>
    swal('提示', '系統錯誤!請聯絡系統管理員排除狀況', 'error');
</script>
@elseif(Session::has('finacialExportRequestFail'))
<script>
    swal('提示', '系統錯誤!請確認輸入資料是否有誤，或是請不要嘗試跳過畫面輸入!', 'error');
</script>
@endif
@endsection
