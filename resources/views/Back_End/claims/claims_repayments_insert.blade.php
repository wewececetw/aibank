@extends('Back_End.layout.header')

@section('content')

    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">新增債權帳務</h3>
          </div>
        </div>

        <div class="col-md-12">
            <div style="border:solid 1px #1a2732">
                <div style="padding:10px;background-color:#394a59;">
                    <h4 style="color:white;">債權帳務</h4>
                </div>
            <div class="panel-body">
                <form novalidate="novalidate" class="simple_form new_match_performance" id="new_match_performance" enctype="multipart/form-data" action="/admin/match_performances" accept-charset="UTF-8" method="post"><input name="utf8" type="hidden" value="&#x2713;" />

                    @csrf
                    <div class="detail_1" style="margin-bottom:40px;">

                        <div class="row">
                            <h6 class="form_title">申請人基本資料</h6>
                        </div>

                        <div class="row m-b-15">
                            <div class="col-sm-6">
                                <label for="exampleFormControlTextarea1">物件編號</label>
                                <select name="" class="form-control" id="">
                                    <option value="">請選擇</option>
                                    <option value="">A1111111</option>
                                    <option value="">B1111111</option>
                                    <option value="">C1111111</option>
                                    <option value="">D1111111</option>
                                </select>
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">繳款日期</label>
                                <input type="text" class="datepicker form-control datepicker_style" name="showDate" autocomplete="off"  value="<?=date('Y/m/d')?>">
                            </div>
                        </div>

                        <div class="row m-b-15">
                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">入帳日</label>
                                <input type="text" class="datepicker form-control datepicker_style" name="showDate" autocomplete="off"  value="<?=date('Y/m/d')?>">
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">還款金額</label>
                                <input type="number" class="form-control" name="" autocomplete="off">
                            </div>
                        </div>
                    

                        <div class="row m-b-15">
                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">期數</label>
                                <input type="number" class="form-control" name="" autocomplete="off">
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">銀行代碼</label>
                                <input type="text" class="form-control" name="" autocomplete="off">
                            </div>
                        </div>

                        <div class="row m-b-15">
                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">銀行帳號</label>
                                <input type="text" class="form-control" name="" autocomplete="off">
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">狀態</label>
                                <select name="" class="form-control" id="">
                                    <option value="">請選擇</option>
                                    <option value="">保留中</option>
                                    <option value="">已沖帳</option>
                                </select>
                            </div>

                        </div>

                        <div class="row m-b-15">
                            <div class='col-sm-12'>
                                <label for="exampleFormControlTextarea1">備註</label>
                                <textarea class="form-control" name="Comment" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="col-sm-12"  style="margin:20px auto;">
                            <a class="btn btn-info pull-right" href="/admin/claim_repayments">返回</a>
                            <button type="button" onclick="update_item();" class="btn btn-info pull-right m-r-5">儲存</button>
                        </div>

                        <hr style="border: solid 0.5px #738a9e;border-style:dashed;">

                        <div class="row">
                            <h6 class="form_title">附件列表</h6>
                            <div class="col-sm-12">
                                <input class="form-control" type="file">
                            </div>
                            
                        </div>
                    
                </form>
            </div>
        </div>
    </div>

      </section>
    </section>


    <script type="text/javascript" src="/js/daterangepicker/moment.min.js"></script>
    <script type="text/javascript" src="/js/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/js/daterangepicker/daterangepicker.css"/>

</section>

    <script>


    var datepicker_setting = {
        autoUpdateInput: false,
        singleDatePicker: true,
        opens: "center",
        drops: "up",
        locale: {
            format: "YYYY/MM/DD",
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
            $(this).val(picker.startDate.format('YYYY/MM/DD'));
        });
    });

        function update_item(){
            $.ajax({
            type:"POST",
            url:"/match_performances/new",
            dataType:"json",
            data:
                $('#new_match_performance').serialize()
            ,
            success:function(data){
                if(data.success){
                    alert("更新成功");
                    location.reload();
                }
            }
        });
    }
                


        
    </script>

@endsection             