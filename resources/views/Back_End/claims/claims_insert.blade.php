@extends('Back_End.layout.header')

@section('content')
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css"> --}}
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap.min.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script> --}}
<script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
{{-- moment js --}}
<script type="text/javascript" src="/js/daterangepicker/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/locale/zh-tw.js"></script>

{{-- date time picker --}}

<link rel="stylesheet" href="{{ asset('/plugin/datetimepicker/build/jquery.datetimepicker.min.css') }}">
<script src="{{ asset('/plugin/datetimepicker/build/jquery.datetimepicker.full.min.js') }}"></script>
<style>
    .error {
        color: red;
    }

    #risk_category {
        color: black
    }

    #cooperative_company_id {
        color: black
    }

    #repayment_method {
        color: black
    }

    #loan_type {
        color: black
    }

    #foreign , #foreign_t{
        color: black
    }


    td {
        word-break: break-all !important;
    }

    .c3-axis-y>.tick {
        fill: none; // removes axis labels from y axis
    }

    .redStar {
        color: red;
    }

    .table-bordered>thead>tr>th {
        color: black;
        font-weight: bold;
    }

</style>


<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">新增債權</h3>
            </div>
        </div>
        {{-- @php
         dd($row[1]['closed']);
        @endphp --}}
        <div class="col-md-12">
            <div style="border:solid 1px #1a2732">
                <div style="padding:10px;background-color:#394a59;">
                    <h4 style="color:white;">債權</h4>
                </div>
                <div class="panel-body">
                    <form class="simple_form new_match_performance" id="insert_claim_form" enctype="multipart/form-data"
                        accept-charset="UTF-8" method="post">
                        <input name="utf8" type="hidden" value="&#x2713;" />

                        @csrf
                        <div class="detail_1" style="margin-bottom:40px;">

                            <div class="row">
                                <h6 class="form_title">申請人基本資料 </h6>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label class="redStar"><span class="redStar">(*)</span>為必填欄位</label>
                            </div>

                            <div class="row m-b-15"
                                style="border:dotted 1px #394a59;border: dotted 1px #394a59; padding: 20px 5px;margin: auto 5px;">

                                <div class='col-sm-2'>
                                    <label for="exampleFormControlTextarea1">風險類別
                                        <span class="redStar"><span class="redStar">(*)</span></span>
                                    </label>
                                    <select name="risk_category" class="form-control required_select" id="risk_category"
                                        required>
                                        <option value="">請選擇</option>
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

                                <div class='col-sm-1' style="margin-top:25px;text-align:center;">
                                    <label for="exampleFormControlTextarea1">+</label>
                                </div>

                                <div class='col-sm-2'>
                                    <label for="exampleFormControlTextarea1">債權號碼
                                        <span class="redStar"><span class="redStar">(*)</span></span>
                                    </label>
                                    <input type="number" id="serial_number" class="form-control required" min="0"
                                        name="serial_number" required />
                                </div>

                                <div class='col-sm-1' style="margin-top:25px;text-align:center;">
                                    <label for="exampleFormControlTextarea1">+</label>
                                </div>

                                <div class='col-sm-2'>
                                    <label for="exampleFormControlTextarea1">上拋次數
                                        <span class="redStar"><span class="redStar">(*)</span></span>
                                    </label>
                                    <input type="number" id="number_of_sales" class="form-control positive required"
                                        min="0" name="number_of_sales" required>
                                </div>

                                <div class='col-sm-1' style="margin-top:25px;text-align:center;">
                                    <label for="exampleFormControlTextarea1">＝</label>
                                </div>

                                <div class='col-sm-2'>
                                    <label for="exampleFormControlTextarea1">債權編號
                                        <span class="redStar"><span class="redStar">(*)</span></span>
                                    </label>
                                    <input type="text" id="claim_number" class="form-control required"
                                        name="claim_number" disabled>
                                </div>



                            </div>

                            <div class="row m-b-15">
                                <div class="col-sm-6">
                                    <label for="exampleFormControlTextarea1">統一編號
                                        <span class="redStar"><span class="redStar">(*)</span></span>
                                    </label>
                                    <input type="number" name="tax_id" class="form-control required" id="tax_id"
                                        required>
                                </div>

                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">標單單筆最大金額
                                        <span class="redStar"><span class="redStar">(*)</span></span>
                                    </label>
                                    <input type="text" class="form-control required" name="max_amount" id="max_amount"
                                        required>
                                </div>
                            </div>

                            <div class="row m-b-15">
                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">分期起始日
                                    </label>
                                    {{-- <input type="text" id="staged_at" name="staged_at"
                                        class="datepicker form-control datepicker_style"> --}}

                                    <input id="staged_at" type="text" class="form-control datepicker" name="staged_at">
                                </div>

                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">分期總金額
                                        <span class="redStar"><span class="redStar">(*)</span></span>
                                    </label>
                                    <input type="number" id="staging_amount" class="form-control positive required"
                                        name="staging_amount" required>
                                </div>
                            </div>


                            <div class="row m-b-15">
                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">原始期數
                                        <span class="redStar"><span class="redStar">(*)</span></span>
                                    </label>
                                    <input type="number" id="periods" class="form-control positive required"
                                        name="periods" required>
                                </div>

                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">剩餘期數
                                        <span class="redStar"><span class="redStar">(*)</span></span>
                                    </label>
                                    <input type="number" id="remaining_periods" class="form-control positive required"
                                        name="remaining_periods" required>
                                </div>
                            </div>

                            <div class="row m-b-15">
                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">特約商<span class="redStar">(*)</span></label>
                                    <select name="cooperative_company_id" class="form-control required_select"
                                        id="cooperative_company_id" required>
                                        <option value="">請選擇</option>
                                        <option value="0">亞太普惠金融科技有限公司</option>
                                    </select>
                                </div>

                            </div>



                            <div class="row m-b-15">
                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">年利率<span class="redStar">(*)</span></label>
                                    <input type="number" id="annual_interest_rate"
                                        class="form-control positive required" name="annual_interest_rate" min="0"
                                        required>
                                </div>

                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">最低標額<span
                                            class="redStar">(*)</span></label>
                                    <input type="number" id="min_amount" class="form-control positive required"
                                        name="min_amount" required>
                                </div>
                            </div>

                            <div class="row m-b-15">
                                {{-- <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">得標總利息<span
                                            class="redStar">(*)</span></label>
                                    <input type="number" id="bid_interest" class="form-control positive required"
                                        name="bid_interest" required>
                                </div> --}}

                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">管理費費率<span
                                            class="redStar">(*)</span></label>
                                    <input type="number" id="management_fee_rate" class="form-control positive required"
                                        name="management_fee_rate" required>
                                </div>
                            </div>

                            <div class="row m-b-15">
                                {{-- <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">總管理費<span
                                            class="redStar">(*)</span></label>
                                    <input type="number" id="management_fee_amount"
                                        class="form-control positive required" name="management_fee_amount" required>
                                </div> --}}
                                {{-- <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">(上架日)</label>
                                    <input type="text" id="launched_at" name="launched_at"
                                        class="datepicker form-control datepicker_style">
                                </div> --}}

                            </div>
                            {{-- <div class="row m-b-15">
                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">(開標日)</label>
                                    <input type="text" id="start_collecting_at"
                                        class="datepicker form-control datepicker_style"
                                        name="start_collecting_at" >
                                </div>
                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">(預計結標日)</label>
                                    <input type="text" id="estimated_close_date"
                                        class="datepicker form-control datepicker_style"
                                        name="estimated_close_date">
                                </div>

                            </div>
                            <div class="row m-b-15">
                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">(結標後最後繳款期限)</label>
                                    <input type="text" id="payment_final_deadline"
                                        class="datepicker form-control datepicker_style"
                                        name="payment_final_deadline">
                                </div>
                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">(起息日)</label>
                                    <input type="text" id="value_date"
                                        class="datepicker form-control datepicker_style" name="value_date">
                                </div>
                            </div> --}}


                            <div class="row m-b-15">
                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">約定買回方<span
                                            class="redStar">(*)</span></label>
                                    <input type="text" id="agreement_buyer" class="form-control required"
                                        name="agreement_buyer" required>
                                </div>
                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">豬豬推手獎金%數<span
                                            class="redStar">(*)</span></label>
                                    <input type="text" id="commission_interest_rate" class="form-control required"
                                        name="commission_interest_rate" required>
                                </div>


                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1"></label>
                                    <input type="number" style="display:none" id="closed_at"
                                        class="datepicker form-control datepicker_style required" autocomplete="off"
                                        value="<?=date('Y-m-d')?>" required>
                                </div>
                            </div>

                            <div class="row m-b-15">
                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">募集群別<span
                                            class="redStar">(*)</span></label>
                                    <input type="text" id="grouping" class="form-control required" name="grouping"
                                        required>
                                </div>

                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">場景類別<span
                                            class="redStar">(*)</span></label>
                                    <input type="text" id="typing" class="form-control required" name="typing" required>
                                </div>
                            </div>

                            <div class="row m-b-15">

                                <div class='col-sm-6'>
                                    <input type="radio" id="is_auto_closed" name="is_auto_closed">
                                    <label for="exampleFormControlTextarea1">自動結標</label>&nbsp;&nbsp;&nbsp;<span
                                        id='message_auto'></span>
                                    <input type="text" class="form-control" id="auto_close_threshold"
                                        name="auto_close_threshold" placeholder="請輸入自動結標門檻" disabled>

                                </div>

                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">還款方式<span
                                            class="redStar">(*)</span></label>
                                    <select name="repayment_method" class="form-control required_select"
                                        id="repayment_method" required>
                                        <option value="">請選擇</option>
                                        <option value="0">先息後本</option>
                                        <option value="1">本息攤還</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row m-b-15">
                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">貸款類型<span
                                            class="redStar">(*)</span></label>
                                    <select name="loan_type" class="form-control required_select" id="loan_type"
                                        required>
                                        <option value="">請選擇</option>
                                        <option value="0">應收帳款轉讓</option>
                                    </select>
                                </div>

                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">債權轉讓人<span
                                            class="redStar">(*)</span></label>
                                    <input type="text" id="debtor_transferor" class="form-control required"
                                        name="debtor_transferor" required>
                                </div>
                            </div>

                            <div class="row m-b-15">
                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">貸款人<span class="redStar">(*)</span></label>
                                    <input type="text" id="borrower" class="form-control required" name="borrower"
                                        required>
                                </div>

                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">身分證號<span
                                            class="redStar">(*)</span></label>
                                    <input type="text" id="id_number" class="form-control required" name="id_number"
                                        required>
                                </div>
                            </div>

                            <div class="row m-b-15">
                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">年齡<span class="redStar">(*)</span></label>
                                    <input type="number" id="age" class="form-control positive required" name="age"
                                        required>
                                </div>

                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">學歷<span class="redStar">(*)</span></label>
                                    <input type="text" id="education" class="form-control required" name="education"
                                        required>
                                </div>
                            </div>

                            <div class="row m-b-15">
                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">婚姻狀況<span
                                            class="redStar">(*)</span></label>
                                    <input type="text" id="marital_state" class="form-control required"
                                        name="marital_state" required>
                                </div>

                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">居住地<span class="redStar">(*)</span></label>
                                    <input type="text" id="place_of_residence" class="form-control required"
                                        name="place_of_residence" required>
                                </div>
                            </div>

                            <div class="row m-b-15">
                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">居住狀況<span
                                            class="redStar">(*)</span></label>
                                    <input type="text" id="living_state" class="form-control required"
                                        name="living_state" required>
                                </div>

                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">行業別<span class="redStar">(*)</span></label>
                                    <input type="text" id="industry" class="form-control required" name="industry"
                                        required>
                                </div>
                            </div>

                            <div class="row m-b-15">
                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">職稱<span class="redStar">(*)</span></label>
                                    <input type="text" id="job_title" class="form-control required" name="job_title"
                                        required>
                                </div>

                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">年資<span class="redStar">(*)</span></label>
                                    <input type="text" id="seniority" class="form-control positive required"
                                        name="seniority" required>
                                </div>
                            </div>

                            <div class="row m-b-15">
                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">月薪<span class="redStar">(*)</span></label>
                                    <input type="text" id="monthly_salary" class="form-control positive required"
                                        name="monthly_salary" required>
                                </div>

                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">連帶保證人<span
                                            class="redStar">(*)</span></label>
                                    <input type="text" id="guarantor" class="form-control required" name="guarantor"
                                        required>
                                </div>
                            </div>

                            <div class="row m-b-15">
                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">豬豬信用<span
                                            class="redStar">(*)</span></label>
                                    <input type="text" id="pig_credit" class="form-control required" name="pig_credit"
                                        required>
                                </div>

                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">有效身分證<span
                                            class="redStar">(*)</span></label>
                                    <input type="text" id="id_number_effective" class="form-control required"
                                        name="id_number_effective" required>
                                </div>
                            </div>

                            <div class="row m-b-15">
                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">同業黑名單<span
                                            class="redStar">(*)</span></label>
                                    <input type="text" id="peer_blacklist" class="form-control required"
                                        name="peer_blacklist" required>
                                </div>

                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">更生清算戶<span
                                            class="redStar">(*)</span></label>
                                    <input type="text" id="rehabilitated_settlement" class="form-control required"
                                        name="rehabilitated_settlement" required>
                                </div>
                            </div>

                            <div class="row m-b-15">
                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">票信狀況<span
                                            class="redStar">(*)</span></label>
                                    <input type="text" id="ticket_state" class="form-control required"
                                        name="ticket_state" required>
                                </div>

                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">重大交通罰款<span
                                            class="redStar">(*)</span></label>
                                    <input type="text" id="major_traffic_fines" class="form-control required"
                                        name="major_traffic_fines" required>
                                </div>
                            </div>

                            <div class="row m-b-15">
                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">一年內同業查詢次數<span
                                            class="redStar">(*)</span></label>
                                    <input type="number" id="peer_query_count" class="form-control positive required"
                                        name="peer_query_count" required>
                                </div>

                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">報稅/不報稅<span
                                            class="redStar">(*)</span></label>
                                    <select name="foreign" class="form-control required_select" id="foreign" required>
                                        <option value="">請選擇</option>
                                        <option value="0">報稅</option>
                                        <option value="1">不報稅</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row m-b-15">
                                <div class='col-sm-6'>
                                    <input type="radio" name="is_pre_invest" id="is_pre_invest">
                                    <label for="exampleFormControlTextarea1">預先投標</label>&nbsp;&nbsp;&nbsp;<span
                                        id='message'></span>

                                    <input type="text" id="pre_invest_min_amount" class="form-control positive "
                                        name="pre_invest_min_amount" placeholder="請輸入預先投標最小值" disabled>
                                </div>

                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">國內/海外<span
                                            class="redStar">(*)</span></label>
                                    <select name="foreign_t" class="form-control required_select" id="foreign_t" required>
                                        <option value="">請選擇</option>
                                        <option value="0">國內</option>
                                        <option value="1">海外</option>
                                    </select>
                                </div>

                            </div>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>上架日</th>
                                        <th>開標日</th>
                                        <th>預計結標日</th>
                                        <th>結標後最後繳款期限</th>
                                        <th>起息日</th>
                                        <th>下標後繳款期限</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <th>上架日</th>
                                        @foreach ($sysvar as $item => $value)
                                        <td>

                                            {{ 'T+'.$value }}

                                        </td>
                                        @endforeach
                                    </tr>
                                </tbody>

                                <tbody>
                                    <tr>
                                        <td>
                                            <input type="text" id="launched_at" name="launched_at"
                                                class="datepicker form-control datepicker_style">
                                        </td>
                                        <td>
                                            <input type="text" id="start_collecting_at"
                                                class="datepicker form-control datepicker_style"
                                                name="start_collecting_at">
                                        </td>
                                        <td>
                                            <input type="text" id="estimated_close_date"
                                                class="datepicker form-control datepicker_style"
                                                name="estimated_close_date">
                                        </td>
                                        <td>
                                            <input type="text" id="payment_final_deadline"
                                                class="datepicker form-control datepicker_style"
                                                name="payment_final_deadline">
                                        </td>
                                        <td>
                                            <input type="text" id="value_date"
                                                class="datepicker form-control datepicker_style" name="value_date">
                                        </td>
                                        <td>
                                            下標後繳款期限
                                        </td>
                                    </tr>
                                </tbody>

                            </table>


                            <div class="row m-b-15">
                                <div class='col-sm-12'>
                                    <label for="exampleFormControlTextarea1">債權說明<span
                                            class="redStar">(*)</span></label>
                                    <textarea class="form-control required" name="description" id="description" rows="3"
                                        required></textarea>
                                    <script>
                                        CKEDITOR.replace('description');

                                    </script>
                                    <div id="trackingDiv"></div>
                                </div>

                            </div>

                            <div class="col-sm-12" style="margin:20px auto;">
                                <a class="btn btn-info pull-right" href="/admin/claims">返回</a>
                                <button type="button" onclick="insert_item();"
                                    class="btn btn-info pull-right m-r-5">儲存</button>
                            </div>

                            <hr style="border: solid 0.5px #738a9e;border-style:dashed;">

                            <div class="row" id="pdf_block">
                                <h6 class="form_title">附件列表</h6>

                                <div class="col">
                                    <a class="btn btn-success" id="add_pdf">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                    <a class="btn btn-danger" id="remove_pdf">
                                        <i class="fas fa-minus"></i>
                                    </a>
                                </div>

                                <div class="col-sm-12">
                                    <small>PDF大小上限:{{ config('fileSizeLimit.claims_create_pdf_max_size') }}MB</small>
                                    <input class="form-control" name="pdf_name[]" id="pdf_name" type="file"
                                        placeholder="請選擇PDF檔">
                                    <label for="files">(請選擇PDF檔)</label>
                                </div>


                            </div>


                    </form>
                </div>
            </div>
        </div>

    </section>
</section>

</section>

<script>
    var pdfCount = 1;
    var lastPdf = '';
    //新增PDF 的html
    function addPdf() {
        pdfCount ++;
        let tmp = `
        <div class="col-sm-12">
            <small>PDF大小上限:{{ config('fileSizeLimit.claims_create_pdf_max_size') }}MB</small>
            <input class="form-control pdf" name="pdf_name[]" type="file" id="pdf_${pdfCount}"
                placeholder="請選擇PDF檔">
            <label for="files">(請選擇PDF檔)</label>
        </div>
        `;
        lastPdf = `pdf_${pdfCount}`;
        $("#pdf_block").append(tmp);
    }
    //刪除PDF 的HTML
    function removePdf(){
        $("#"+lastPdf).parent().remove();
    }
    //新增PDF 點擊事件listener
    $("#add_pdf").click(function(){
        addPdf();
    })
    //刪除PDF點擊listener
    $("#remove_pdf").click(function(){
        removePdf();
    })

    function getExtension(filename) {
        var parts = filename.split('.');
        return parts[parts.length - 1];
    }

    function isPDF(filename) {
        var ext = getExtension(filename);
        switch (ext.toLowerCase()) {
            case 'pdf':
                return true;
        }
        return false;
    }
    $(function () {
        function something_happens(input) {
            input.replaceWith(input.val('').clone(true));
        };

        $('#pdf_name').on('change', function () {
            console.log($('#pdf_name').val());

            function failValidation(msg) {
                alert(msg); // just an alert for now but you can spice this up later
                return false;
            }

            var file = $('#pdf_name');
            if (!isPDF(file.val())) {
                something_happens($('#pdf_name'));
                return failValidation('您所選擇上傳的檔案格式有誤，請選擇PDF檔進行上傳');
            }

            let fileSize = (file[0].files[0].size / 1024 / 1024);
            //當檔案大小大於系統指定大小
            if (fileSize > "{{ config('fileSizeLimit.claims_create_pdf_max_size') }}") {
                something_happens($('#pdf_name'));
                return failValidation('您所選擇上傳的檔案大小超過上限');
            }


            // alert('您所選擇上傳的檔案格式有誤，請選擇PDF檔進行上傳');
            // return false;
        });

    });

    $(function () {

        $(".datepicker").datetimepicker({
            format: 'Y-m-d H:i:s',
            step: 5,
        });
    });


    function insert_item() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        console.log($('#description').val());
        var form = document.getElementById("insert_claim_form");
        var formData = new FormData(form);

        /* -------------------------------------------------------------------------- */

        if ($("#insert_claim_form").valid()) {
        /* -------------------------------------------------------------------------- */

        $.ajax({
            type: "POST",
            url: "{{ url('/admin/claims_insert') }}",
            dataType: "json",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if (data.success) {
                    alert("新增成功");
                    location.href = '{{ url("/admin/claims") }}';
                }
                if (data.wrong) {
                    alert("上架日必須於開標日之前，\n且開標日必須於起息日之前，\n請再次檢查修改");
                }
                if(data.fileError){
                    alert('請確認PDF是否格式或大小有誤');
                }
            }
        });
        /* -------------------------------------------------------------------------- */

        } else {
            alert('必填欄位未填');
        }
        /* -------------------------------------------------------------------------- */

    }


    $('.positive').on('change', function () {

        var positive = $(this).val();
        if (positive < 0) {
            alert('請輸入正數');
        }
    });

    $('#periods, #remaining_periods').on('change', function () {

        var periods = $('#periods').val();
        var remaining_periods = $('#remaining_periods').val();
        if (periods < remaining_periods) {
            alert('原始期數必須大於或等於剩餘期數');
        }


    });



    $('#serial_number, #number_of_sales,#risk_category').on('keyup mouseup change', function () {

        var cl_a = $('#risk_category').children(':selected').text();
        var cl_b = $('#serial_number').val();
        var cl_c = $('#number_of_sales').val();

        if (cl_a == '請選擇') {
            cl_a = '';
        }


        $('#claim_number').val(cl_a + cl_b + cl_c);

    });

    (function ($) {
        $.fn.uncheckableRadio = function () {
            var $root = this;
            $root.each(function () {
                var $radio = $(this);
                if ($radio.prop('checked')) {
                    $radio.data('checked', true);
                } else {
                    $radio.data('checked', false);
                }

                $radio.click(function () {
                    var $this = $(this);
                    if ($this.data('checked')) {
                        $this.prop('checked', false);
                        $this.data('checked', false);
                        $this.trigger('change');
                    } else {
                        $this.data('checked', true);
                        $this.closest('form').find('[name="' + $this.prop('name') + '"]').not(
                            $this).data('checked', false);
                    }
                });
            });
            return $root;
        };
    }(jQuery));

    $('[type=radio]').uncheckableRadio();


    $('#is_auto_closed').on('click', function () {
        if ($('#is_auto_closed').prop('checked')) {
            $('#is_auto_closed').data('checked', true);
            $('#auto_close_threshold').removeAttr('disabled');
            $('#message_auto').html('開啟').css('color', 'green');
        } else {
            $('#is_auto_closed').data('checked', false);
            $('#message_auto').html('關閉').css('color', 'red');
            $('#auto_close_threshold').attr('disabled', true);
        }

    });


    $('#is_pre_invest').on('click', function () {
        if ($('#is_pre_invest').prop('checked')) {
            $('#is_pre_invest').data('checked', true);
            $('#pre_invest_min_amount').removeAttr('disabled');
            $('#message').html('開啟').css('color', 'green');
        } else {
            $('#is_pre_invest').data('checked', false);
            $('#pre_invest_min_amount').attr('disabled', true);
            $('#message').html('關閉').css('color', 'red');
        }

    });
    jQuery.extend(jQuery.validator.messages, {
        required: "必填",
        remote: "Please fix this field.",
        email: "Please enter a valid email address.",
        url: "Please enter a valid URL.",
        date: "Please enter a valid date.",
        dateISO: "Please enter a valid date (ISO).",
        number: "請輸入數字",
        digits: "Please enter only digits.",
        creditcard: "Please enter a valid credit card number.",
        equalTo: "Please enter the same value again.",
        accept: "Please enter a value with a valid extension.",
        maxlength: jQuery.validator.format("Please enter no more than {0} characters."),
        minlength: jQuery.validator.format("Please enter at least {0} characters."),
        rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
        range: jQuery.validator.format("Please enter a value between {0} and {1}."),
        max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
        min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
    });

</script>

@endsection
