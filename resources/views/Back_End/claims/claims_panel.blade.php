@extends('Back_End.layout.header')

@section('content')
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> --}}
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.zh-TW.min.js">
</script>

<script type="text/javascript" src="/js/daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="/js/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="/js/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />


<style>
    input {
        border: none;
    }

    .date_input {
        border: solid 1px #ddd;
        margin: auto 15px auto 5px;
    }

    .status_edit_inp {
        border: solid 1px #eee;
    }

    td {
        word-break: break-all !important;
    }

    .c3-axis-y>.tick {
        fill: none; // removes axis labels from y axis
    }
    .push_lightbox2 {
        padding: 30px;
        padding-top: 60px;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(51, 51, 51, 0.85);
        z-index: 9999;
        overflow-y: scroll;
    }
    .push_lightbox3 {
        padding: 30px;
        padding-top: 60px;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(51, 51, 51, 0.85);
        z-index: 9999;
        overflow-y: scroll;
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
                <h3 class="page-header">債權列表</h3>
            </div>
        </div>
        <div class="an-single-component with-shadow">
            {{-- <div class="an-component-header search_wrapper">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="interestRatePanel">
                        <h4 class="panel-title" style="display:inline;f">年利率(依風險類別)</h4>
                        <a class="btn btn-info" id="interestRate_edit"
                            style="display:inline-block;float:right;margin-top: 3px;"
                            onclick="edit_table('interestRate');">
                            編輯
                        </a>

                        <button class="btn btn-info" id="interestRate_edit_finish"
                            style="display:none;float:right;margin-top: 3px;" onclick="edit_finish('interestRate');">
                            完成
                        </button>
                    </div>

                    <div class="panel-body">
                        <h3> > 12 期 </h3>
                        <table class="table table-bordered table-breaking interestRate_table">
                            <thead>
                                <tr>
                                    <th>A</th>
                                    <th>B</th>
                                    <th>C</th>
                                    <th>D</th>
                                    <th>E</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>
                                        <input name="" type="number" min="0" max="10" step="0.01" value="7.25" class=""
                                            disabled="">
                                    </td>
                                    <td>
                                        <input name="" type="number" min="0" max="10" step="0.01" value="7.25" class=""
                                            disabled="">
                                    </td>
                                    <td>
                                        <input name="" type="number" min="0" max="10" step="0.01" value="7.25" class=""
                                            disabled="">
                                    </td>
                                    <td>
                                        <input name="" type="number" min="0" max="10" step="0.01" value="7.25" class=""
                                            disabled="">
                                    </td>
                                    <td>
                                        <input name="" type="number" min="0" max="10" step="0.01" value="7.25" class=""
                                            disabled="">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <h3>
                            <= 12 期 </h3> <table class="table table-bordered table-breaking interestRate_table">
                                <thead>
                                    <tr>
                                        <th>A</th>
                                        <th>B</th>
                                        <th>C</th>
                                        <th>D</th>
                                        <th>E</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>
                                            <input name="" type="number" min="0" max="10" step="0.01" value="7.25"
                                                class="" disabled>
                                        </td>
                                        <td>
                                            <input name="" type="number" min="0" max="10" step="0.01" value="7.25"
                                                class="" disabled>
                                        </td>
                                        <td>
                                            <input name="" type="number" min="0" max="10" step="0.01" value="7.25"
                                                class="" disabled>
                                        </td>
                                        <td>
                                            <input name="" type="number" min="0" max="10" step="0.01" value="7.25"
                                                class="" disabled>
                                        </td>
                                        <td>
                                            <input name="" type="number" min="0" max="10" step="0.01" value="7.25"
                                                class="" disabled>
                                        </td>
                                    </tr>
                                </tbody>
                                </table>
                    </div>

                </div>

            </div> --}}

            {{-- <div class="an-component-header search_wrapper">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="commissionTab">
                        <h4 class="panel-title" style="display:inline">標單佣金回饋金 (每萬元)</h4>

                        <a class="btn btn-info" id="commission_edit"
                            style="display:inline-block;float:right;margin-top: 3px;"
                            onclick="edit_table('commission');">
                            編輯
                        </a>

                        <button class="btn btn-info" id="commission_edit_finish"
                            style="display:none;float:right;margin-top: 3px;" onclick="edit_finish('commission');">
                            完成
                        </button>
                    </div>

                    <div class="panel-body">

                        <table class="table table-bordered table-breaking commission_table">
                            <thead>
                                <tr>
                                    <th> &lt; 6 期 </th>
                                    <th> &gt;= 6 &amp;&amp; &lt; 12 期 </th>
                                    <th> &gt;= 12 &amp;&amp; &lt; 18 期 </th>
                                    <th> &gt;= 18 期 </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input name="" type="number" min="0" max="10" step="0.01" value="7.25" class=""
                                            disabled>
                                    </td>
                                    <td>
                                        <input name="" type="number" min="0" max="10" step="0.01" value="7.25" class=""
                                            disabled>
                                    </td>
                                    <td>
                                        <input name="" type="number" min="0" max="10" step="0.01" value="7.25" class=""
                                            disabled>
                                    </td>
                                    <td>
                                        <input name="" type="number" min="0" max="10" step="0.01" value="7.25" class=""
                                            disabled>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>


                </div>
            </div> --}}
        @php
            $check = DB::select("select a_l_l_seq from admin_lv_log where user_id ='".Auth::user()->user_id."' and a_l_l_seq = 2");   
            if(!empty($check)){$check = true;}else{$check = false;}
        @endphp

        @if(!empty($check))
            <div class="an-component-header search_wrapper">
                <div class="panel panel-default">

                    <div class="panel-heading" role="tab" id="statusPanel">
                        <h4 class="panel-title" style="display:inline">物件狀態切換天數(T = 檔案上拋日)</h4>
                        <a class="btn btn-info" id="status_edit"
                            style="display:inline-block;float:right;margin-top: 3px;" onclick="edit_table('status');">
                            編輯
                        </a>

                        <button class="btn btn-info" id="status_edit_finish"
                            style="display:none;float:right;margin-top: 3px;" onclick="edit_finish('status');">
                            完成
                        </button>

                    </div>

                    <div class="panel-body">
                        <table class="table table-bordered table-breaking">
                            <thead>
                                <tr>
                                    <th>開標</th>
                                    <th>預計結標日</th>
                                    <th>結標後最後繳款期限</th>
                                    <th>起息日</th>
                                    <th>下標後繳款期限</th>
                                </tr>
                            </thead>
                            <form id="new_variables">
                                <tbody>
                                    <tr>
                                        @foreach ($data as $item => $value)
                                        <td>

                                            @foreach ($value as $k =>$v)

                                            {{ 'T+'.$v }}
                                            @endforeach

                                        </td>
                                        @endforeach
                                    </tr>

                                    <tr id="status_edit_tr" style="display:none;">

                                        @csrf
                                        @foreach ($data as $item => $value)
                                        <td>
                                            @foreach ($value as $k =>$v)
                                            <input name="{{ $k }}" type="number" min="0" max="10" step="1"
                                                value="{{ $v }}" class="status_edit_inp"> 天
                                            @endforeach
                                        </td>
                                        @endforeach


                                    </tr>

                                </tbody>
                            </form>
                        </table>
                    </div>

                </div>

            </div>
        @endif    
            <div class="">
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
                {{-- <form method="post" enctype="multipart/form-data" action="{{ url('/admin/claim_import') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <table class="table">
                        <tr>
                            <td width="40%" text-align="right"><label>Select File for Upload</label></td>
                            <td width="30">
                                <input type="file" name="select_file" />
                            </td>
                            <td width="30%" text-align="left">
                                <input type="submit" name="upload" class="btn btn-primary" value="Upload">
                            </td>
                        </tr>
                        <tr>
                            <td width="40%" text-align="right"></td>
                            <td width="30"><span class="text-muted">.xls, .xlsx</span></td>
                            <td width="30%" text-align="left"></td>
                        </tr>
                    </table>
                </div>
                </form> --}}

                <br />


                <div class="an-component-header search_wrapper">
                    {{-- <a class="an-btn an-btn-primary" href="/admin/claim_download">下載債權範例</a> --}}
                    <div class="m-b-10">
                        
                    @if(!empty($check))
                        <a class="btn btn-info" href="/admin/claims_create">新增債權</a>
                        {{--
/* -------------------------------------------------------------------------- */
/*                                   匯入按鈕在此                                   */
/* -------------------------------------------------------------------------- */ --}}

                        <button class="btn btn-info lightbox_btn">匯入</button>
                        {{--
/* -------------------------------------------------------------------------- */
/*                                   匯入按鈕在此                                   */
/* -------------------------------------------------------------------------- */ --}}
                        @if($row_data->is_receive_letter == 0)
                        <button class="btn btn-success" onclick="is_receive_letter(1)">開啟寄信功能</button>
                        @else
                        <button class="btn btn-info" onclick="is_receive_letter(0)">關閉寄信功能</button>
                        @endif
                        <button class="btn btn-info buy_s_tenderer">預先投標</button>
                        <button class="btn btn-info change_s_tenderer">匯入更改得標人</button>
                        {{-- <a class = "an-btn an-btn-primary" id="downloadBtn">匯出流標應還款項</a> --}}
                        {{-- <button type="button" class="an-btn an-btn-primary" id="export-floating">匯出流標應還款項</button>
                        <button type="button" class="an-btn an-btn-primary" data-toggle="modal" data-target="#import-floating">匯入流標還款</button> --}}
                    @endif    
                    </div>

                    <div class="m-b-10" style="width: 100%; background-color: white; padding: 10px; border: 1px dotted">
                        <form class="form-inline">
                            <div class="form-group">
                                <label>
                                    開始時間:
                                </label>
                                <input type="text" class="date_input datepicker datepicker_style" name=""
                                    id="value_date_start" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>
                                    結束時間:
                                </label>
                                <input type="text" class="date_input datepicker datepicker_style" name=""
                                    id="value_date_end" placeholder="">
                            </div>
                            <div class="form-group">
                                <a class="btn btn-info form-control" id="downloadBtn">匯出債權狀態</a>
                            </div>
                        </form>
                    </div>

                    <div class="panel panel-default an-sidebar-search">
                        <div class="panel-heading" role="tab" id="headingTwo">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" href="#search_panel">篩選條件</a>
                            </h4>
                        </div>
                        <div id="search_panel" class="panel-collapse collapse" role="tabpanel"
                            aria-labelledby="headingTwo">
                            <div class="panel-body" id="target_panel">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label l-h-34">物件編號</label>
                                    <div class="col-sm-4">
                                        <input type="hidden" id="now_page">
                                        <input type="hidden" id="count_page">
                                        <input type="hidden" id="sequence">
                                        <input type="text" name="claim_number" id="claim_number_search"
                                            placeholder="請輸入物件編號"
                                            class="an-form-control no-redius border-bottom m-0 text_color filter-claim_number">
                                    </div>

                                    <label class="col-sm-2 control-label l-h-34">對應流水號</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="serial_number" id="tax_id_search"
                                            placeholder="請輸入對應流水號"
                                            class="an-form-control no-redius border-bottom m-0 text_color filter-serial_number">
                                    </div>
                                    <div class="clear"></div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label l-h-34">狀態</label>
                                    <div class="col-sm-4">
                                        <form novalidate="novalidate" class="simple_form new_claim" id="new_claim"
                                            action="/admin/claims" accept-charset="UTF-8" method="post">
                                            <input name="utf8" type="hidden" value="&#x2713;" />
                                            <input type="hidden" name="authenticity_token"
                                                value="1QYfonZ9cVAvJyCwH8M9XCXuxXyDsvdb8JHJJIDQK9nY5HlzdYIRrAhdc8Jv5ENuGhrjyRhCE2WepTGVEnW7gA==" />
                                            <select name="claim_state" id="claim_state_search"
                                                class="select required form-control select2 filter-state"
                                                include_blank="true" id="claim_state">
                                                <option value="" style="color:lightgray">選擇狀態</option>
                                                <option value="0">上架預覽</option>
                                                <option value="1">募集中</option>
                                                <option value="2">結標繳款</option>
                                                <option value="3">已流標</option>
                                                <option value="4">繳息還款</option>
                                                <option value="5">回收結案</option>
                                                <option value="6">異常</option>
                                            </select>
                                    </div>

                                    <label class="col-sm-2 control-label l-h-34">募集群別</label>
                                    <div class="col-sm-4">
                                        <select name="grouping" id="grouping_search"
                                            class="select optional form-control select2 filter-grouping"
                                            include_blank="true" id="claim_grouping">
                                            <option value="">選擇募集群別</option>
                                            <option value="0">S</option>
                                            <option value="1">asdf</option>
                                        </select>
                                    </div>

                                    <div class="clear"></div>
                                    <label class="col-sm-2 control-label l-h-34">風險類別</label>
                                    <div class="col-sm-4">
                                        <select name="risk_category" id="risk_category_search"
                                            class="select required form-control select2 filter-risk_category"
                                            include_blank="true" id="claim_risk_category">
                                            <option value="" style="color:lightgray">選擇風險類別</option>
                                            <option value="0">A</option>
                                            <option value="1">B</option>
                                            <option value="2">C</option>
                                            <option value="3">D</option>
                                            <option value="4">E</option>
                                            <option value="5">V</option>
                                            <option value="6">H</option>
                                            <option value="7">M</option>
                                            <option value="8">S</option>
                                        </select>
                                    </div>
                                    <label class="col-sm-2 control-label l-h-34">場景類別</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="typing" id="typing_search" placeholder="請輸入場景類別"
                                            class="an-form-control no-redius border-bottom m-0 text_color filter-typing">
                                        </form>
                                    </div>
                                    <div class="clear"></div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label l-h-34">顯示日</label>
                                    <div class="col-sm-10">
                                        <div class="col-sm-5 no-padding">
                                            <div class="col-sm-12 no-padding">
                                                <input type="text" class="datepicker form-control datepicker_style"
                                                    name="launched_at_start" id="launched_at_start_search"
                                                    placeholder="開始時間">
                                            </div>
                                        </div>
                                        <div class="col-sm-1 no-padding l-h-34 t-center"> ~ </div>
                                        <div class="col-sm-6 no-padding">
                                            <div class="col-sm-12 no-padding">
                                                <input type="text" class="datepicker form-control datepicker_style"
                                                    name="launched_at_end" id="launched_at_end_search"
                                                    placeholder="結束時間">
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="clear"></div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label l-h-34">結標日</label>
                                    <div class="col-sm-10">
                                        <div class="col-sm-5 no-padding">
                                            <div class="col-sm-12 no-padding">
                                                <input type="text" class="datepicker form-control datepicker_style"
                                                    name="closed_at_start" id="closed_at_start_search"
                                                    placeholder="開始時間">
                                            </div>
                                        </div>
                                        <div class="col-sm-1 no-padding l-h-34 t-center"> ~ </div>
                                        <div class="col-sm-6 no-padding">
                                            <div class="col-sm-12 no-padding">
                                                <input type="text" class="datepicker form-control datepicker_style"
                                                    name="closed_at_end" id="closed_at_end_search" placeholder="結束時間">
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="clear"></div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label l-h-34">國內/海外</label>
                                    <div class="col-sm-4">
                                            <select name="foreign_t" id="foreign_t_search"
                                                class="select required form-control select2 filter-state"
                                                include_blank="true" id="foreign_t">
                                                <option value="" style="color:lightgray">選擇國內外</option>
                                                <option value="0">國內</option>
                                                <option value="1">海外</option>
                                            </select>
                                    </div>
                                    <div class="clear"></div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label l-h-34">週週投排程日</label>
                                    <div class="col-sm-10">
                                        <div class="col-sm-5 no-padding">
                                            <div class="col-sm-12 no-padding">
                                                <input type="text" class="datepicker form-control datepicker_style"
                                                    name="value_date_start" id="weekly_time_start_search"
                                                    placeholder="開始時間">
                                            </div>
                                        </div>
                                        <div class="col-sm-1 no-padding l-h-34 t-center"> ~ </div>
                                        <div class="col-sm-6 no-padding">
                                            <div class="col-sm-12 no-padding">
                                                <input type="text" class="datepicker form-control datepicker_style"
                                                    name="value_date_end" id="weekly_time_end_search" placeholder="結束時間">
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="clear"></div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label l-h-34">即將到期日</label>
                                    <div class="col-sm-10">
                                        <div class="col-sm-5 no-padding">
                                            <div class="col-sm-12 no-padding">
                                                <input type="text" class="datepicker form-control datepicker_style"
                                                    name="value_date_start" id="value_date_start_search"
                                                    placeholder="開始時間">
                                            </div>
                                        </div>
                                        <div class="col-sm-1 no-padding l-h-34 t-center"> ~ </div>
                                        <div class="col-sm-6 no-padding">
                                            <div class="col-sm-12 no-padding">
                                                <input type="text" class="datepicker form-control datepicker_style"
                                                    name="value_date_end" id="value_date_end_search" placeholder="結束時間">
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="clear"></div>
                                </div>

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
                        </div>
                    </div>
                    <div class="clear">
                    </div>
                </div>
                @if(!empty($check))
                <div class="push_lightbox" style="display: none">
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

                        <form id="import_claims_form" enctype="multipart/form-data" method="post"
                            action="{{ url('/admin/claim_import') }}">
                            {{ csrf_field() }}
                            <div>
                                <div class="modal-content">
                                    <div class="" style="background:#5bb0bd;padding:20px">
                                        <button type="button" class="close"><span
                                                style="font-size:28px">×</span></button>
                                        <h3 class="modal-title">匯入物件資料</h3>
                                    </div>
                                    <div class="modal-body">
                                        <h4>注意</h4>
                                        <ol>
                                            <li>請依照範例擋格式匯入，前兩行請勿刪除。</li>
                                        </ol>
                                        <input required="required" type="file" name="select_file" id="">
                                    </div>
                                    <div class="modal-footer" style="text-shadow:none">
                                        <a class="btn btn-info" href="/admin/claim_download">下載匯入範例</a>
                                        <input type="submit" name="commit" value="匯入" class="btn btn-info"
                                            data-disable-with="匯入">
                                        {{-- <button  class="btn btn-info" type="submit">匯入</button> --}}
                                        <button type="button" class="btn btn-info back">返回</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- 預先投標 --}}
                <div class="push_lightbox2" style="display: none">
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

                        <form id="import_buy_tenderer_form" enctype="multipart/form-data" method="post"
                            action="{{ url('/admin/buy_tenderer_import') }}">
                            {{ csrf_field() }}
                            <div>
                                <div class="modal-content">
                                    <div class="" style="background:#5bb0bd;padding:20px">
                                        <button type="button" class="close"><span
                                                style="font-size:28px">×</span></button>
                                        <h3 class="modal-title">匯入預先投標資料</h3>
                                    </div>
                                    <div class="modal-body">
                                        <h4>注意</h4>
                                        <ol>
                                            <li>請依照範例擋格式匯入，前兩行請勿刪除。</li>
                                        </ol>
                                        <input required="required" type="file" name="select_file" id="">
                                    </div>
                                    <div class="modal-footer" style="text-shadow:none">
                                        <a class="btn btn-info" href="/admin/buy_tenderer_download">下載匯入範例</a>
                                        <input type="submit" name="commit" value="匯入" class="btn btn-info"
                                            data-disable-with="匯入">
                                        {{-- <button  class="btn btn-info" type="submit">匯入</button> --}}
                                        <button type="button" class="btn btn-info back2">返回</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- 匯入更改得標人 --}}
                <div class="push_lightbox3" style="display: none">
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

                        <form id="import_change_tenderer_form" enctype="multipart/form-data" method="post"
                            action="{{ url('/admin/change_tenderer_import') }}">
                            {{ csrf_field() }}
                            <div>
                                <div class="modal-content">
                                    <div class="" style="background:#5bb0bd;padding:20px">
                                        <button type="button" class="close"><span
                                                style="font-size:28px">×</span></button>
                                        <h3 class="modal-title">匯入更改得標人資料</h3>
                                    </div>
                                    <div class="modal-body">
                                        <h4>注意</h4>
                                        <ol>
                                            <li>請依照範例擋格式匯入，前兩行請勿刪除。</li>
                                        </ol>
                                        <input required="required" type="file" name="select_file" id="">
                                    </div>
                                    <div class="modal-footer" style="text-shadow:none">
                                        <a class="btn btn-info" href="/admin/change_tenderer_download">下載匯入範例</a>
                                        <input type="submit" name="commit" value="匯入" class="btn btn-info"
                                            data-disable-with="匯入">
                                        {{-- <button  class="btn btn-info" type="submit">匯入</button> --}}
                                        <button type="button" class="btn btn-info back2">返回</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @endif
            </div>

            <div class="panel" style="margin-left: 20px;">
                <label>選擇一頁</label>
                <select onchange="number_page_change()" name="number_page" id="number_page">
                    <option value="">請選擇</option>
                    <option value="25">25</option>
                    <option value="100">100</option>
                </select>
                <label>筆</label>
            </div>

            <table id="claims_table" class="table table-bordered table_breaking m-b-10">
                <thead>
                    <tr>
                        <th style="cursor: pointer" onclick="change_sort('cn')" class="all">物件編號</th>
                        <th style="cursor: pointer" onclick="change_sort('sn')" class="all">對應流水號</th>
                        <th style="cursor: pointer" onclick="change_sort('cs')" class="all">狀態</th>
                        <th style="cursor: pointer" onclick="change_sort('nos')" class="all">上拋次數</th>
                        <th style="cursor: pointer" onclick="change_sort('sa')" class="all">預計募集金額</th>
                        <th style="cursor: pointer" onclick="change_sort('p')" class="all">原始期數</th>
                        <th style="cursor: pointer" onclick="change_sort('tsa')" class="all">總標單金額</th>
                        <th style="cursor: pointer" onclick="change_sort('a')" class="all">實際募集金額</th>
                        <th style="cursor: pointer" onclick="change_sort('p_t')" class="all">國內/海外</th>
                        <th style="cursor: pointer" onclick="change_sort('w_t')" class="all">週週排程日</th>
                        <th class="all">詳細資料</th>
                    @if(!empty($check))
                        <th class="all">強制流標</th>
                        <th class="all">提前結標</th>
                        <th style="cursor: pointer" onclick="change_sort('i_d')" class="all">顯示/隱藏</th>
                    @endif
                    </tr>
                </thead>
                <tbody id='claim_tbody'>
                    @foreach($datasets as $dataset)
                    <tr>
                        <!-- 物件編號 -->
                        <td>{{$dataset->claim_number}}</td>
                        <!-- 對應流水號 -->
                        <td>{{$dataset->serial_number}}</td>
                        <!-- 狀態 -->
                        <td>{{$dataset->claim_state}}</td>
                        <!-- 上拋次數 -->
                        <td>{{$dataset->number_of_sales}}</td>
                        <!-- 預計募集金額 -->
                        <td>{{$dataset->staging_amount}}</td>
                        <!-- 原始期數 -->
                        <td>{{$dataset->periods}}</td>

                        {{--  ========= 2020-03-27 10:33:49 change by Jason START=========  --}}
                        <!-- 總標單金額 -->
                        @if($dataset->getOriginal('claim_state') == 3 )
                        <td>0</td>
                        <td>0</td>
                        @else
                        <td>{{$dataset->tender_sum_amount}}</td>
                        <td>{{$dataset->amount}}</td>
                        @endif
                        <td>{{$dataset->foreign_t}}</td>
                        <td>{{$dataset->weekly_time?$dataset->weekly_time:'非週週投債權'}}</td>
                        {{--  ========= 2020-03-27 10:33:49 change by Jason END=========  --}}

                        <td class="editable col-state">
                            <a target="_blank" href="/admin/claim_details/{{$dataset->claim_id}}"
                                class="btn btn-info"><i style="margin-right: 0px;" class="fa fa-fw fa-eye"></i> </a>
                        </td>
                        <!-- 實際募集金額 -->
                    @if(!empty($check))    
                        <td>{{$dataset->current_amount}}</td>
                        <td>{{$dataset->current_amount}}</td>
                    
                        <!-- 顯示/隱藏 -->
                        @if($dataset->is_display == 0)
                        <td class="editable col-state">
                            <button id="no_display{{$dataset->claim_id}}" class="btn btn-success" onclick="is_display({{$dataset->claim_id}},1)">解除隱藏</button>
                            <button style="display: none" id="is_display{{$dataset->claim_id}}" class="btn btn-info" onclick="is_display({{$dataset->claim_id}},0)">隱藏</button>
                        </td>
                        @else
                        <td class="editable col-state">
                            <button id="is_display{{$dataset->claim_id}}" class="btn btn-info" onclick="is_display({{$dataset->claim_id}},0)">隱藏</button>
                            <button style="display: none" id="no_display{{$dataset->claim_id}}" class="btn btn-success" onclick="is_display({{$dataset->claim_id}},1)">解除隱藏</button>
                        </td>
                        @endif
                    @endif
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


{{--
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> --}}

<script>
    var check = {{json_encode($check)}};
    $(document).ready(function () {
        $(function () {
            $('.datepicker').datepicker({
                autoUpdateInput: false,
                format: "yyyy-mm-dd",
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 1901,
                maxYear: 3000,
                language: 'zh-TW',
            });
        });

        // $('#claims_table').DataTable({
        //     sDom: 'lrtip',
        //     iDisplayLength: 8,
        //     responsive: true,
        //     "autoWidth": false,
        //     searching: true,
        //     paging: true,
        //     info: false,
        //     order: [0, "asc"],
        //     "language": {
        //         "emptyTable": "------無相關資料符合------"
        //     }
        // });
         //顯示分頁
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
        $("#downloadBtn").click(function () {
            let data = getFliterData();
            let url = "{{ url('/admin/claim_export') }}" + "?" + $.param(data);
            window.location = url;
        })

        $("#submit").click(function () {
            $("#background").show();
            //初始當前頁數
            $("#now_page").val(1);
            let data = getFliterData();
            $.ajax({
                url: "{{ url('/admin/claims/search') }}",
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
            $("#claim_tbody").empty();
            let tmp = '';
            if(check){
                $.each(obj,function(k,v){
                    tmp += trTemp(v);
                })
            }else{
                $.each(obj,function(k,v){
                    tmp += trTemp_1(v);
                })
            }

            $("#claim_tbody").append(tmp);
        }

        //TR 的模板
        function trTemp(d){
            let t = `
            <tr>
                <td>${d.claim_number}</td>
                <td>${d.serial_number}</td>
                <td>${d.claim_state}</td>
                <td>${d.number_of_sales}</td>
                <td>${d.staging_amount}</td>
                <td>${d.periods}</td>
                <td>${d.tender_sum_amount}</td>
                <td>${d.current_amount}</td>
                <td>${d.foreign_t}</td>
                <td>${d.weekly_time}</td>
                <td>${d.detail_button}</td>
                <td>${d.current_amount2}</td>
                <td>${d.current_amount3}</td>
                <td>${d.visible_button}</td>
            </tr>
            `
            return t;
        }
        //TR 的模板
        function trTemp_1(d){
            let t = `
            <tr>
                <td>${d.claim_number}</td>
                <td>${d.serial_number}</td>
                <td>${d.claim_state}</td>
                <td>${d.number_of_sales}</td>
                <td>${d.staging_amount}</td>
                <td>${d.periods}</td>
                <td>${d.tender_sum_amount}</td>
                <td>${d.current_amount}</td>
                <td>${d.foreign_t}</td>
                <td>${d.weekly_time}</td>
                <td>${d.detail_button}</td>
            </tr>
            `
            return t;
        }
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
            url: "{{ url('/admin/claims/search') }}",
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
    };
     //重畫Table
     function redrawTable(obj){
                $("#claim_tbody").empty();
                let tmp = '';
                if(check){
                    $.each(obj,function(k,v){
                        tmp += trTemp(v);
                    })
                }else{
                    $.each(obj,function(k,v){
                        tmp += trTemp_2(v);
                    })
                }
                $("#claim_tbody").append(tmp);
    }

    //TR 的模板
    function trTemp(d){
        let t = `
            <tr>
                <td>${d.claim_number}</td>
                <td>${d.serial_number}</td>
                <td>${d.claim_state}</td>
                <td>${d.number_of_sales}</td>
                <td>${d.staging_amount}</td>
                <td>${d.periods}</td>
                <td>${d.tender_sum_amount}</td>
                <td>${d.current_amount}</td>
                <td>${d.foreign_t}</td>
                <td>${d.weekly_time}</td>
                <td>${d.detail_button}</td>
                <td>${d.current_amount2}</td>
                <td>${d.current_amount3}</td>
                <td>${d.visible_button}</td>
            </tr>
        `
        return t;
    }

    //TR 的模板
    function trTemp_2(d){
        let t = `
            <tr>
                <td>${d.claim_number}</td>
                <td>${d.serial_number}</td>
                <td>${d.claim_state}</td>
                <td>${d.number_of_sales}</td>
                <td>${d.staging_amount}</td>
                <td>${d.periods}</td>
                <td>${d.tender_sum_amount}</td>
                <td>${d.current_amount}</td>
                <td>${d.foreign_t}</td>
                <td>${d.weekly_time}</td>
                <td>${d.detail_button}</td>
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
        if(th == "cn"){
            //三種排序可能前置條件
            if(sequence != 1 && sequence != -1){
                $("#sequence").val(1);

            }else if(sequence == 1){
                $("#sequence").val(-1);

            }else if(sequence == -1){
                $("#sequence").val(1);

            }   
        }else if(th == "sn"){
            if(sequence != 2 && sequence != -2){
                $("#sequence").val(2);

            }else if(sequence == 2){
                $("#sequence").val(-2);

            }else if(sequence == -2){
                $("#sequence").val(2);

            }    
        }else if(th == "cs"){
            if(sequence != 3 && sequence != -3){
                $("#sequence").val(3);

            }else if(sequence == 3){
                $("#sequence").val(-3);

            }else if(sequence == -3){
                $("#sequence").val(3);

            }   
        }else if(th == "nos"){
            if(sequence != 4 && sequence != -4){
                $("#sequence").val(4);

            }else if(sequence == 4){
                $("#sequence").val(-4);

            }else if(sequence == -4){
                $("#sequence").val(4);

            }   
        }else if(th == "sa"){
            if(sequence != 5 && sequence != -5){
                $("#sequence").val(5);

            }else if(sequence == 5){
                $("#sequence").val(-5);

            }else if(sequence == -5){
                $("#sequence").val(5);

            }   
        }else if(th == "p"){
            if(sequence != 6 && sequence != -6){
                $("#sequence").val(6);

            }else if(sequence == 6){
                $("#sequence").val(-6);

            }else if(sequence == -6){
                $("#sequence").val(6);

            }   
        }else if(th == "tsa"){
            if(sequence != 7 && sequence != -7){
                $("#sequence").val(7);

            }else if(sequence == 7){
                $("#sequence").val(-7);

            }else if(sequence == -7){
                $("#sequence").val(7);

            }   
        }else if(th == "i_d"){
            if(sequence != 8 && sequence != -8){
                $("#sequence").val(8);

            }else if(sequence == 8){
                $("#sequence").val(-8);

            }else if(sequence == -8){
                $("#sequence").val(8);

            }   
        }else if(th == "p_t"){
            if(sequence != 9 && sequence != -9){
                $("#sequence").val(9);

            }else if(sequence == 9){
                $("#sequence").val(-9);

            }else if(sequence == -9){
                $("#sequence").val(9);

            }   
        }else if(th == "w_t"){
            if(sequence != 10 && sequence != -10){
                $("#sequence").val(10);

            }else if(sequence == 10){
                $("#sequence").val(-10);

            }else if(sequence == -10){
                $("#sequence").val(10);

            }   
        }else if(th == "a"){
            if(sequence != 11 && sequence != -11){
                $("#sequence").val(11);

            }else if(sequence == 11){
                $("#sequence").val(-11);

            }else if(sequence == -11){
                $("#sequence").val(11);

            }   
        }
        let now_page = $("#now_page").val();
        let data = getFliterData();
        $.ajax({
            url: "{{ url('/admin/claims/search') }}",
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
            url: "{{ url('/admin/claims/search') }}",
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
                if($("#now_page").val() > $("#count_page").val()){$("#now_page").val(d.count);number_page_change()}
            },
            error: function (e) {
                console.log(e);
            }
        });
    }
    //取篩選值
    function getFliterData() {
        let sequence = $("#sequence").val();
        let number_page = $("#number_page").val();
        if(number_page==''){ number_page = 25;}
        let now_page = $("#now_page").val();
        let claim_number = $("#claim_number_search").val();
        let tax_id = $("#tax_id_search").val();
        let claim_state = $("#claim_state_search").val();
        let grouping = $('#grouping_search').val();
        let risk_category = $('#risk_category_search').val();
        let typing = $('#typing_search').val();
        let launched_at_start = $('#launched_at_start_search').val();
        let launched_at_end = $('#launched_at_end_search').val();
        let closed_at_start = $('#closed_at_start_search').val();
        let closed_at_end = $('#closed_at_end_search').val();
        let value_date_start = $('#value_date_start_search').val();
        let value_date_end = $('#value_date_end_search').val();
        let foreign_t = $('#foreign_t_search').val();
        let weekly_time_start = $('#weekly_time_start_search').val();
        let weekly_time_end = $('#weekly_time_end_search').val();
        let data = {
            claim_number: claim_number,
            serial_number: tax_id,
            claim_state: claim_state,
            grouping: grouping,
            risk_category: risk_category,
            typing: typing,
            launched_at_start: launched_at_start,
            launched_at_end: launched_at_end,
            closed_at_start: closed_at_start,
            closed_at_end: closed_at_end,
            value_date_start: value_date_start,
            value_date_end: value_date_end,
            sequence:sequence,
            number_page:number_page,
            page:now_page,
            foreign_t:foreign_t,
            weekly_time_start: weekly_time_start,
            weekly_time_end: weekly_time_end
        }
        return data;
    }

    $(function () {
        $('#reset').click(function () {
            $("#claim_number_search").val("");
            $("#tax_id_search").val("");
            $("#claim_state_search").val("");
            $('#grouping_search').val("");
            $('#risk_category_search').val("");
            $('#typing_search').val("");
            $('#launched_at_start_search').val("");
            $('#launched_at_end_search').val("");
            $('#closed_at_start_search').val("");
            $('#closed_at_end_search').val("");
            $('#foreign_t_search').val("");
            $('#weekly_time_start_search').val("");
            $('#weekly_time_end_search').val("");
            $('#value_date_start_search').val("");
            $('#value_date_end_search').val("");
        });
    });

    //  改變編輯樣式
    function edit_table(target) {
        if (target == 'status') {
            $("#status_edit_tr").show();
        }
        $("." + target + "_table input").css('border', 'solid 1px #eee');
        $("." + target + "_table input").removeAttr('disabled');
        $("#" + target + "_edit").hide();
        $("#" + target + "_edit_finish").show();
    }
    function edit_finish(target) {
        if (target == 'status') {
            $("#status_edit_tr").hide();

            $.ajax({
                type: "POST",
                url: "/admin/variables_update",
                dataType: "json",
                data: $('#new_variables').serialize(),
                success: function (data) {
                    if (data.success) {
                        alert("更新成功");
                        location.reload();
                    }
                }
            });
        }

        $("." + target + "_table input").css('border', 'none');
        $("." + target + "_table input").attr('disabled');
        $("#" + target + "_edit").show();
        $("#" + target + "_edit_finish").hide();
    }

    $('.close,.back').click(function () {
        $('.push_lightbox').fadeOut();
    })

    $('.lightbox_btn').click(function () {
        $('.push_lightbox').fadeIn();
    })

    $('.close,.back2').click(function () {
        $('.push_lightbox2').fadeOut();
    })

    $('.buy_s_tenderer').click(function () {
        $('.push_lightbox2').fadeIn();
    })

    $('.close,.back2').click(function () {
        $('.push_lightbox3').fadeOut();
    })

    $('.change_s_tenderer').click(function () {
        $('.push_lightbox3').fadeIn();
    })

    function is_display(target, v) {
        if (v == 1) {
            if (window.confirm('你確定要解除此項目隱藏?')) {
                $.ajax({
                    type: "POST",
                    url: "/admin/claim_display",
                    dataType: "json",
                    data: {
                        id: target,
                        chgTo: v
                    },
                    success: function (data) {
                        if (data.success) {
                            alert("已解除此項目隱藏");
                            $("#no_display"+target).hide();
                            $("#is_display"+target).show();
                        }
                        if (data.error) {
                            alert("權限不足!")
                        }
                    }
                });
            }
        } else {
            if (window.confirm('你確定要隱藏此項目?')) {
                $.ajax({
                    type: "POST",
                    url: "/admin/claim_display",
                    dataType: "json",
                    data: {
                        id: target,
                        chgTo: v
                    },
                    success: function (data) {
                        if (data.success) {
                            alert("已隱藏此項目");
                            $("#no_display"+target).show();
                            $("#is_display"+target).hide();
                        }
                        if (data.error) {
                            alert("權限不足!")
                        }
                    }
                });
            }
        }
    }
    //開啟信件功能
    function is_receive_letter(v) {
        if (v == 1) {
            if (window.confirm('你確定要開啟所有使者寄信功能?')) {
                $.ajax({
                    type: "POST",
                    url: "/admin/is_receive_letter",
                    dataType: "json",
                    data: {
                        chgTo: v
                    },
                    success: function (data) {
                        if (data.success) {
                            alert("已開啟");
                            location.reload();
                        }
                        if (data.error) {
                            alert("權限不足!")
                        }
                    }
                });
            }
        } else {
            if (window.confirm('你確定要關閉所有使者寄信功能?')) {
                $.ajax({
                    type: "POST",
                    url: "/admin/is_receive_letter",
                    dataType: "json",
                    data: {
                        chgTo: v
                    },
                    success: function (data) {
                        if (data.success) {
                            alert("已關閉");
                            location.reload();
                        }
                        if (data.error) {
                            alert("權限不足!")
                        }
                    }
                });
            }
        }
    }
</script>
@endsection
