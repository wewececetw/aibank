@extends('Back_End.layout.header')

@section('content')

    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">新增員工</h3>
          </div>
        </div>

        <div class="col-md-12">
            <div style="border:solid 1px #1a2732">
                <div style="padding:10px;background-color:#394a59;">
                    <h4 style="color:white;">員工</h4>
                </div>
            <div class="panel-body">
                <form novalidate="novalidate" class="simple_form new_match_performance" id="insert_staff_form" enctype="multipart/form-data" action="/admin/match_performances" accept-charset="UTF-8" method="post"><input name="utf8" type="hidden" value="&#x2713;" />
                    @csrf
                        <div class="row m-b-15">
                            <div class="col-sm-6">
                                <label for="exampleFormControlTextarea1">工號</label>
                                <input type="text" class="form-control" name="member_number" autocomplete="off">
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">姓名</label>
                                <input type="text" class="form-control" name="user_name" autocomplete="off">
                            </div>
                        </div>

                        <div class="row m-b-15">
                            <div class="col-sm-6">
                                <label for="exampleFormControlTextarea1">E-mail</label>
                                <input type="text" class="form-control" name="email" autocomplete="off">
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">電話</label>
                                <input type="text" class="form-control" name="phone_number" autocomplete="off">
                            </div>
                        </div>

                        <hr style="border: solid 0.5px #738a9e;border-style:dashed;">


                        <div class="row m-b-15">
                            
                            <div class="col-sm-6">
                                
                                <label for="exampleFormControlTextarea1">密碼</label>&nbsp;&nbsp;&nbsp;<span id='message'></span>
                                <input type="password" id="password" class="form-control" name="encrypted_password" >
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">再次確認密碼</label>
                                <input type="password" id="confirm_password" class="form-control" name="encrypted_password">
                            </div>
                        </div>

                        <div class="row m-b-15">

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">權限設定</label>
                                <select name="user_type" class="select optional form-control select2 filter-loan_type" include_blank="true" id="loan_loan_type">
                                    <option value="">請選擇</option>
                                    <option value="0">系統管理者</option>
                                    <option value="1">財務專員</option>
                                    <option value="2">資料分析人員</option>
                                    <option value="3">運營主管</option>
                                    <option value="4">客服專員</option>
                                    <option value="5">產品行銷人員</option>
                                    <option value="6">alert</option>

                                  </select>
                            </div>
                        </div>
                       
                    
                        <div class="col-sm-12" style="margin-top:40px;">
                            <a class="btn btn-info pull-right" href="/admin/staffs">返回</a>
                            <button type="button" onclick="insert_item();" class="btn btn-info pull-right m-r-5">儲存</button>
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

    function insert_item(){
            $.ajax({
            type:"POST",
            url:"/admin/staffs_store",
            dataType:"json",
            data:
                $('#insert_staff_form').serialize()
            ,
            success:function(data){
                if(data.success){
                    alert("新增成功");
                    location.href='/admin/staffs';
                }
            }
        });
    }
                

    $('#password, #confirm_password').on('keyup', function () {
  if ($('#password').val() == $('#confirm_password').val()) {
    $('#message').html('密碼相符合').css('color', 'green');
    
  } else 
    $('#message').html('密碼不符合').css('color', 'red');
    
});
        
    </script>

@endsection             