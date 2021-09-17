@extends('Back_End.layout.header')

@section('content')


    <section id="main-content">
      <section class="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">報表</h3>
                </div>
            </div>

            <div >
                <div class="panel-body">
                    <form class="form-group" id="insert_product_form">
                        @csrf
                        <div class="row">
                            <div class='form-group'>
                                <div class='col-sm-4'>
                                  <input type="text" class="datepicker form-control datepicker_style" name="showDate" autocomplete="off"  value="<?=date('Y/m/d')?>">
                                </div>
                                <div class='col-sm-4'>
                                    <button type="button" class="btn btn-info">搜尋</button>
                                </div>
                                <div class='clear'></div>
                            </div>
                        </div>

                        <div class="row" style="margin-top:20px;">
                            <div class="col-lg-12">
                                <section class="panel">
                                    <div class="panel-body">

                                        <div class="row">
                                            <div class="col-lg-12">

                                                <header class="panel-heading tab-bg-info">

                                                    <ul class="nav nav-tabs">

                                                        <li class="active">
                                                            <a data-toggle="tab" href="#home">
                                                                客戶資料分析
                                                            </a>
                                                        </li>

                                                        <li class="">
                                                            <a data-toggle="tab" href="#menu1">
                                                                債權募集分析
                                                            </a>
                                                        </li>

                                                        {{-- <li class="">
                                                            <a data-toggle="tab" href="#menu2">
                                                                匯款截止日未還款清單
                                                            </a>
                                                        </li>

                                                        <li class="">
                                                            <a data-toggle="tab" href="#menu3">
                                                                貸款資料
                                                            </a>
                                                        </li> --}}

                                                        <li class="">
                                                            <a data-toggle="tab" href="#menu4">
                                                                推薦碼分析
                                                            </a>
                                                        </li>

                                                    </ul>

                                                </header>

                                                <div class="panel-body">
                                                    <div class="tab-content">

                                                        <!-- home -->
                                                        <div id="home" class="tab-pane active">

                                                            <section class="panel">
                                                                <div class="panel-body bio-graph-info" style="border:none;">
                                                                    <form class="form-horizontal " id="">
                                                                        @csrf
                                                                        <div class="form-group" style="border-bottom:none;">

                                                                            <div class="row">
                                                                                <div class='col-sm-4'>
                                                                                    <label for="exampleFormControlTextarea1">起始日期</label>
                                                                                    <input type="text" class="datepicker form-control datepicker_style" name="showDate" autocomplete="off"  value="<?=date('Y/m/d')?>">
                                                                                </div>
                                                                                <div class='col-sm-4'>
                                                                                    <label for="exampleFormControlTextarea1">結束日期</label>
                                                                                    <input type="text" class="datepicker form-control datepicker_style" name="showDate" autocomplete="off"  value="<?=date('Y/m/d')?>">
                                                                                </div>
                                                                                <div class='col-sm-4'>
                                                                                    <button style="margin-top:23px;" type="button" class="btn btn-info">匯出</button>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </form>

                                                                    <table id="claims_datatable" class="table table-bordered table_breaking m-b-10">

                                                                        <thead>
                                                                            <tr>
                                                                                <th class='all'>當日</th>
                                                                                <th class='all'>註冊人數</th>
                                                                                <th class='all'>信箱未驗證人數</th>
                                                                                <th class='all'>個資未完成人數</th>
                                                                                <th class='all'>帳戶未完成人數</th>
                                                                                <th class='all'>完成註冊人數</th>
                                                                            </tr>
                                                                        </thead>

                                                                        <tbody>
                                                                                <tr id="1" role="row"  dtat-id="1">
                                                                                    <td>1</td>
                                                                                    <td>1</td>
                                                                                    <td>1</td>
                                                                                    <td>1</td>
                                                                                    <td>1</td>
                                                                                    <td>1</td>
                                                                                </tr>
                                                                        </tbody>

                                                                        <thead>
                                                                            <tr>
                                                                                <th class='all'>當月</th>
                                                                                <th class='all'>註冊人數</th>
                                                                                <th class='all'>信箱未驗證人數</th>
                                                                                <th class='all'>個資未完成人數</th>
                                                                                <th class='all'>帳戶未完成人數</th>
                                                                                <th class='all'>完成註冊人數</th>
                                                                            </tr>
                                                                        </thead>

                                                                        <tbody>
                                                                                <tr id="1" role="row" dtat-id="1">
                                                                                    <td>1</td>
                                                                                    <td>1</td>
                                                                                    <td>1</td>
                                                                                    <td>1</td>
                                                                                    <td>1</td>
                                                                                    <td>1</td>
                                                                                </tr>
                                                                        </tbody>

                                                                        <thead>
                                                                            <tr>
                                                                                <th class='all'>當年度</th>
                                                                                <th class='all'>註冊人數</th>
                                                                                <th class='all'>信箱未驗證人數</th>
                                                                                <th class='all'>個資未完成人數</th>
                                                                                <th class='all'>帳戶未完成人數</th>
                                                                                <th class='all'>完成註冊人數</th>
                                                                            </tr>
                                                                        </thead>

                                                                        <tbody>
                                                                                <tr id="1" role="row" dtat-id="1">
                                                                                    <td>1</td>
                                                                                    <td>1</td>
                                                                                    <td>1</td>
                                                                                    <td>1</td>
                                                                                    <td>1</td>
                                                                                    <td>1</td>
                                                                                </tr>
                                                                        </tbody>

                                                                    </table>

                                                                </div>
                                                            </section>

                                                        </div>
                                                        <!-- menu1 -->
                                                        <div id="menu1" class="tab-pane">
                                                            <section class="panel">
                                                                <div class="panel-body bio-graph-info" style="border:none;">
                                                                    <div class="form-group" style="border-bottom:none;">

                                                                        <div class="row">
                                                                            <div class='col-sm-4'>
                                                                                <a style="margin-top:23px;" class="btn btn-info" href="/admin/reports/investExport">匯出</a>
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                    <table id="claims_datatable" class="table table-bordered table_breaking m-b-10">

                                                                        <thead>
                                                                            <tr>
                                                                                <th class='all'>當日</th>
                                                                                <th class='all'>上拋債權件數</th>
                                                                                <th class='all'>上拋債權金額</th>
                                                                                <th class='all'>投標人數</th>
                                                                                <th class='all'>投標金額</th>
                                                                                <th class='all'>募集金額</th>
                                                                                <th class='all'>募集成功率</th>
                                                                            </tr>
                                                                        </thead>

                                                                        <tbody>
                                                                         
                                                                                <tr id="1" role="row"  dtat-id="1">
                                                                                    <td>{{ $invest[0]->exp_type  }}</td>
                                                                                    <td>{{ $invest[0]->create_count  }}</td>
                                                                                    <td>{{ $invest[0]->staging_amount  }}</td>
                                                                                    <td>{{ $invest[0]->invest_amount  }}</td>
                                                                                    <td>{{ $invest[0]->invest_count  }}</td>
                                                                                    <td>{{ $invest[0]->paid_amount  }}</td>
                                                                                    <td>{{ $invest[0]->paid_rate  }}</td>
                                                                                </tr>
                                                                       
                                                                        </tbody>

                                                                        <thead>
                                                                            <tr>
                                                                                <th class='all'>當月</th>
                                                                                <th class='all'>上拋債權件數</th>
                                                                                <th class='all'>上拋債權金額</th>
                                                                                <th class='all'>投標人數</th>
                                                                                <th class='all'>投標金額</th>
                                                                                <th class='all'>募集金額</th>
                                                                                <th class='all'>募集成功率</th>
                                                                            </tr>
                                                                        </thead>

                                                                        <tbody>
                                                                            <?php 
                                                                                $ar = $invest;
                                                                                array_shift($ar);
                                                                            ?>

                                                                            @foreach ($ar as $item)
                                                                                <tr id="1" role="row" dtat-id="1">
                                                                                    <td>{{ $item->exp_type  }}</td>
                                                                                    <td>{{ $item->create_count  }}</td>
                                                                                    <td>{{ $item->staging_amount  }}</td>
                                                                                    <td>{{ $item->invest_amount  }}</td>
                                                                                    <td>{{ $item->invest_count  }}</td>
                                                                                    <td>{{ $item->paid_amount  }}</td>
                                                                                    <td>{{ $item->paid_rate  }}</td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>

                                                                </div>
                                                            </section>
                                                        </div>

                                                        <!-- menu2 -->
                                                        {{-- <div id="menu2" class="tab-pane">
                                                            <section class="panel">
                                                                <div class="panel-body bio-graph-info" style="border:none;">
                                                                    <div class="form-group" style="border-bottom:none;">

                                                                        <div class="row">
                                                                            <div class='col-sm-4'>
                                                                                <button style="margin-top:23px;" type="button" class="btn btn-primary">匯出</button>
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                    <table id="claims_datatable" class="table table-bordered table_breaking m-b-10">

                                                                        <thead>
                                                                            <tr>
                                                                                <th class='all'>債權憑證號</th>
                                                                                <th class='all'>會員編號</th>
                                                                                <th class='all'>投標日</th>
                                                                                <th class='all'>投標金額</th>
                                                                                <th class='all'>匯款金額</th>
                                                                                <th class='all'>匯款截止日</th>
                                                                            </tr>
                                                                        </thead>

                                                                        <tbody>
                                                                                <tr id="1" role="row"  dtat-id="1">
                                                                                    <td>2019-12-12</td>
                                                                                    <td>1</td>
                                                                                    <td>1元</td>
                                                                                    <td>1元</td>
                                                                                    <td>1元</td>
                                                                                    <td>1%</td>
                                                                                </tr>
                                                                        </tbody>

                                                                    </table>

                                                                </div>
                                                            </section>
                                                        </div> --}}

                                                        <!-- menu3 -->
                                                        {{-- <div id="menu3" class="tab-pane">

                                                            <section class="panel">
                                                                <div class="panel-body bio-graph-info" style="border:none;">
                                                                    <form class="form-horizontal " id="">
                                                                        @csrf
                                                                        <div class="" style="border-bottom:none;">

                                                                            <div class="row">
                                                                                <div class='col-sm-4'>
                                                                                    <select name="" class="form-control" id="">
                                                                                        <option value="">請選擇</option>
                                                                                        <option value="">個人信用貸款</option>
                                                                                        <option value="">個人抵押貸(房子)</option>
                                                                                        <option value="">個人抵押貸(車子)</option>
                                                                                        <option value="">商業貸</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class='col-sm-4'>
                                                                                    <button type="button" class="btn btn-primary">匯出</button>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </form>

                                                                    <table id="claims_datatable" class="table table-bordered table_breaking m-b-10" style="margin-top:15px">

                                                                        <thead>
                                                                            <tr>
                                                                                <th class='all'>當日</th>
                                                                                <th class='all'>申請件數</th>
                                                                                <th class='all'>申請金額</th>
                                                                            </tr>
                                                                        </thead>

                                                                        <tbody>
                                                                                <tr id="1" role="row"  dtat-id="1">
                                                                                    <td>1</td>
                                                                                    <td>1</td>
                                                                                    <td>1</td>
                                                                                </tr>
                                                                        </tbody>

                                                                        <thead>
                                                                            <tr>
                                                                                <th class='all'>當日</th>
                                                                                <th class='all'>申請件數</th>
                                                                                <th class='all'>申請金額</th>
                                                                            </tr>
                                                                        </thead>

                                                                        <tbody>
                                                                                <tr id="1" role="row" dtat-id="1">
                                                                                    <td>1</td>
                                                                                    <td>1</td>
                                                                                    <td>1</td>
                                                                                </tr>
                                                                        </tbody>

                                                                    </table>

                                                                </div>
                                                            </section>

                                                        </div> --}}

                                                         <!-- menu4 -->
                                                         <div id="menu4" class="tab-pane ">

                                                            <section class="panel">
                                                                <div class="panel-body bio-graph-info" style="border:none;">
                                                                    <form class="form-horizontal " id="">
                                                                        @csrf
                                                                        <div class="" style="border-bottom:none;">

                                                                            <div class="row">
                                                                                <div class='col-sm-4'>
                                                                                    <label for="exampleFormControlTextarea1">起始日期</label>
                                                                                    <input type="text" class="datepicker form-control datepicker_style" name="showDate" autocomplete="off"  value="<?=date('Y/m/d')?>">
                                                                                </div>
                                                                                <div class='col-sm-4'>
                                                                                    <label for="exampleFormControlTextarea1">結束日期</label>
                                                                                    <input type="text" class="datepicker form-control datepicker_style" name="showDate" autocomplete="off"  value="<?=date('Y/m/d')?>">
                                                                                </div>
                                                                                <div class='col-sm-4'>
                                                                                    <a style="margin-top:23px;" class="btn btn-info" href="">匯出</a>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </form>

                                                                    <table id="claims_datatable" class="table table-bordered table_breaking m-b-10" style="margin-top:15px">

                                                                        <thead>
                                                                            <tr>
                                                                                <th class='all'>當日</th>
                                                                                <th class='all'>完成註冊人數</th>
                                                                                <th class='all'>投資金額</th>
                                                                                <th class='all'>佣金</th>
                                                                            </tr>
                                                                        </thead>

                                                                        <tbody>
                                                                                <tr id="1" role="row"  dtat-id="1">
                                                                                    <td>1</td>
                                                                                    <td>1</td>
                                                                                    <td>1</td>
                                                                                    <td>1</td>
                                                                                </tr>
                                                                        </tbody>

                                                                        <thead>
                                                                            <tr>
                                                                                <th class='all'>當月</th>
                                                                                <th class='all'>完成註冊人數</th>
                                                                                <th class='all'>投資金額</th>
                                                                                <th class='all'>佣金</th>
                                                                            </tr>
                                                                        </thead>

                                                                        <tbody>
                                                                                <tr id="1" role="row" dtat-id="1">
                                                                                    <td>1</td>
                                                                                    <td>1</td>
                                                                                    <td>1</td>
                                                                                    <td>1</td>
                                                                                </tr>
                                                                        </tbody>

                                                                        <thead>
                                                                            <tr>
                                                                                <th class='all'>當年度</th>
                                                                                <th class='all'>完成註冊人數</th>
                                                                                <th class='all'>投資金額</th>
                                                                                <th class='all'>佣金</th>
                                                                            </tr>
                                                                        </thead>

                                                                        <tbody>
                                                                                <tr id="1" role="row" dtat-id="1">
                                                                                    <td>1</td>
                                                                                    <td>1</td>
                                                                                    <td>1</td>
                                                                                    <td>1</td>
                                                                                </tr>
                                                                        </tbody>

                                                                    </table>

                                                                </div>
                                                            </section>

                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

      </section>
    </section>

  </section>


<script type="text/javascript" src="/js/daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="/js/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="/js/daterangepicker/daterangepicker.css"/>

<script>

    var datepicker_setting = {
        autoUpdateInput: false,
        singleDatePicker: true,
        opens: "center",
        drops: "up",
        locale: {
            format: "YYYY-MM-DD",
            applyLabel : "確定",
            cancelLabel : "取消",
            fromLabel : "開始日期",
            toLabel : "結束日期",
            customRangeLabel : "自訂日期區間",
            daysOfWeek : [ "日", "一", "二", "三", "四", "五", "六" ],
            monthNames : [ "1月", "2月", "3月", "4月", "5月", "6月",
            "7月", "8月", "9月", "10月", "11月", "12月" ],
            firstDay : 1,
        }
    };

    $(document).ready(function(){
        $('.datepicker').daterangepicker(datepicker_setting);

        $('.datepicker').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD'));
        });
    });


</script>



@endsection
