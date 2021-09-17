@extends('Back_End.layout.header')

@section('content')



<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>

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
</style>
<section id="main-content">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">買回專區</h3>
            </div>
        </div>

        <div class="an-single-component with-shadow">


            <div class="an-component-header search_wrapper">

                <div class="m-b-10">
                    <div style=" margin-right: 0;  margin-left:0;" class="container">
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
                    <button type="button" class="btn btn-info lightbox_btn" id="lightbox_tender_paid">買回標單</button>
                    <div class="clear"></div>

                </div>

                <div class="an-component-header search_wrapper">

                    <div class="push_lightbox" style="display: none" id="tender_paid">

                        <div class="" style="display: block;width:600px;margin:auto">
                            
                            <form id="import_tenders_form" enctype="multipart/form-data" method="post"
                                action="{{ url('/admin/buying_back/update') }}">
                                {{ csrf_field() }}
                                <div>
                                    <div class="modal-content">
                                        <div class="" style="background:#5bb0bd;padding:20px">
                                            <button type="button" class="close"><span
                                                    style="font-size:28px">×</span></button>
                                            <h3 class="modal-title">標單批次買回</h3>
                                        </div>
                                        <div class="modal-body">
                                            <h4>注意</h4>
                                            <ol>
                                                <li>資料請連貫，不可有空白列。</li>
                                                <li>請在最後一欄填寫(逾期買回，或是結清買回)。</li>
                                            </ol>
                                            <input required="required" type="file" name="select_file" id="">
                                        </div>
                                        <div class="modal-footer" style="text-shadow:none">
                                            <a class="btn btn-info" href="/admin/buying_back_download">下載買回範例</a>
                                            <input type="submit" name="commit" value="匯入買回資料" class="btn btn-info"
                                                data-disable-with="匯入買回資料">
                                            <button type="button" class="btn btn-info back">返回</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>



                </div>
            </div>

            <div class="panel panel-default an-sidebar-search">
                <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" href="#search_panel">篩選條件</a>
                    </h4>
                </div>
                <div id="search_panel" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">
                        @csrf
                        <div class="row">
                            <div class='form-group'>
                                <label class='col-sm-2 control-label l-h-34'>標單憑證號</label>
                                    <div class="col-sm-4">
                                        <input type='text' name='claim_certificate_number'
                                            id="claim_certificate_number_search" placeholder='請輸入標單憑證號'
                                            class='an-form-control no-redius border-bottom m-0 text_color filter-name'>
                                    </div>
                                <div class="clear"></div>
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
                    </div>
                </div>
            </div>
        </div>

        <label class='col-sm-2 control-label l-h-34'>標單還款細項</label>
        <table id="tender_table" class="table table-bordered table_breaking m-b-10">
            <thead>
                <tr>
                    <th>標單狀態</th>
                    <th>期數</th>
                    <th>應返還日</th>
                    <th>應收投資金額</th>
                    <th>應收利潤</th>
                    <th>應付手續費</th>
                    <th>返還投資金額</th>
                    <th>實際到帳日</th>
                    <th>實際返還日</th>
                    <th>發票開立日</th>
                    <th>買回類型</th>
                </tr>
            </thead>
            <tbody id= "tender_table2">
                
            </tbody>

        </table>

        <div class="clear"></div>
        <label class='col-sm-2 control-label l-h-34'>推手細項</label>
        <table id="pusher_table" class="table table-bordered table_breaking m-b-10">
            <thead>
                <tr>
                    <th>標單號碼</th>
                    <th>標售人</th>
                    <th>還款方式</th>
                    <th>狀態</th>
                    <th>標售金額</th>
                    <th>投資餘額</th>
                    <th>推手獎金率</th>
                    <th>利潤期數</th>
                    <th>推手獎金</th>
                    <th>應返還日<br>(投資人)</th>
                    <th>返還日<br>(投資人)</th>
                    <th>預計入帳日<br>(推薦人)</th>
                </tr>
            </thead>
            <tbody id= "pusher_table2">
                
            </tbody>

        </table>

        <div style="display: none;" id="background">
            <p style="margin-top:25%;margin-left:50%;color:white;font-size:25px">頁面讀取中</p>
        </div>


    </section>
</section>

{{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> --}}

<script>
    $('.close,.back').click(function () {
        $('#tender_paid').fadeOut();
    })

    $('#lightbox_tender_paid').click(function () {
        $('#tender_paid').fadeIn();
    })
    $("#submit").click(function () {
        $("#background").show();
        let claim_certificate_number = $("#claim_certificate_number_search").val();
        let data = {
            claim_certificate_number: claim_certificate_number
        }
        $.ajax({
            url: "{{ url('/admin/buying_back/search') }}",
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,
            success: function (d) {
                $("#background").hide();
                redrawTable(d.tender);
                redrawTable2(d.pusher);
            },
            error: function (e) {
                console.log(e);
            }
        })
    })
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
                <td>${d.tender_document_state}</td>
                <td>${d.period_number}</td>
                <td>${d.target_repayment_date}</td>
                <td>${d.per_return_principal}</td>
                <td>${d.per_return_interest}</td>
                <td>${d.management_fee}</td>
                <td>${d.real_return_amount}</td>
                <td>${d.paid_at}</td>
                <td>${d.credited_at}</td>
                <td>${d.invoice_at}</td>
                <td>${d.buying_back_type}</td>
            </tr>
            `
            return t;
        }
        //重畫Table
    function redrawTable2(obj){
                $("#pusher_table2").empty();
                let tmp = '';
                $.each(obj,function(k,v){
                    tmp += trTemp2(v);
                })
                $("#pusher_table2").append(tmp);
    }

    //TR 的模板
    function trTemp2(d){
            let t = `
            <tr>
                <td>${ d.claim_certificate_number }</td>
                <td>${ d.user_name }</td>
                <td>${ d.repayment_method }</td>
                <td>${ d.dstate }</td>
                <td>${ d.amount }</td>
                <td>${ d.current_balance }</td>
                <td>${ d.commission_interest_rate }%</td>
                <td>${ d.period_number }</td>
                <td>${ d.benefits_amount }</td>
                <td>${ d.r_target_repayment_date }</td>
                <td>${ d.r_credited_at }</td>
                <td>${ d.target_repayment_date }</td>
            </tr>
            `
            return t;
        }
</script>


@endsection