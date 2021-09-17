@extends('Back_End.layout.header')

@section('content')

    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">編輯員工</h3>
          </div>
        </div>

        <div class="col-md-12">
            <div style="border:solid 1px #1a2732">
                <div style="padding:10px;background-color:#394a59;">
                    <h4 style="color:white;">員工</h4>
                </div>
            <div class="panel-body">
                <form novalidate="novalidate" class="simple_form new_match_performance" id="update_staff_form" enctype="multipart/form-data" action="/admin/match_performances" accept-charset="UTF-8" method="post"><input name="utf8" type="hidden" value="&#x2713;" />
                    @csrf
                        <div class="row m-b-15">
                            <div class="col-sm-6">
                                <label for="exampleFormControlTextarea1">工號</label>
                                <input type="number" class="form-control" value="{{$row->member_number}}" name="member_number" autocomplete="off" >
                                <input style="display:none" type="number" class="form-control" value="{{$row->user_id}}" name="user_id" autocomplete="off" >
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">姓名</label>
                                <input type="text" class="form-control" value="{{$row->user_name}}" name="user_name" autocomplete="off">
                            </div>
                        </div>

                        <div class="row m-b-15">
                            <div class="col-sm-6">
                                <label for="exampleFormControlTextarea1">E-mail</label>
                                <input type="text" class="form-control" value="{{ $row->email }}" name="email" autocomplete="off">
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">電話</label>
                                <input type="number" class="form-control" value="{{$row->phone_number}}" name="phone_number" autocomplete="off">
                            </div>
                        </div>

                        <hr style="border: solid 0.5px #738a9e;border-style:dashed;">

                        <h6 class="change_password">如需修改密碼，請填入以下欄位資料：</h6>
                        <span id='message'></span>
                        <div class="row m-b-15">
                            <div class="col-sm-6">
                                <label for="exampleFormControlTextarea1">密碼</label>
                                <input type="password" id="password_set" class="form-control" value="{{$row->encrypted_password}}" name="encrypted_password" required>
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">再次確認密碼</label>
                                <input type="password" id="confirm_password_set"  class="form-control" value="{{$row->encrypted_password}}" name="encrypted_password" required>
                            </div>
                        </div>

                        <div class="row m-b-15">

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">權限設定</label>
                                <select name="user_type" class="select optional form-control select2 filter-loan_type" include_blank="true" id="user_type">
                                    <option value="0" <?=($row['user_type']=='系統管理者')?' selected':''?>>系統管理者</option>
                                    <option value="1" <?=($row['user_type']=='財務專員')?' selected':''?>>財務專員</option>
                                    <option value="2" <?=($row['user_type']=='資料分析人員')?' selected':''?>>資料分析人員</option>
                                    <option value="3" <?=($row['user_type']=='運營主管')?' selected':''?>>運營主管</option>
                                    <option value="4" <?=($row['user_type']=='客服專員')?' selected':''?>>客服專員</option>
                                    <option value="5" <?=($row['user_type']=='產品行銷人員')?' selected':''?>>產品行銷人員</option>
                                    <option value="6" <?=($row['user_type']=='alert')?' selected':''?>>alert</option>
                                    
                                  </select>
                            </div>
                        </div>
                       
                    
                        <div class="col-sm-12" style="margin-top:40px;">
                            <a class="btn btn-info pull-right" href="/admin/staffs">返回</a>
                            <button id="submit" type="button" onclick="update_item();" class="btn btn-info pull-right m-r-5" >儲存</button>
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
    let password = $('#password').val();
    let confirm_password = $('#confirm_password').val();
    if(password == confirm_password){
    if($("#update_staff_form").valid()){
      $.ajax({
            type:"POST",
            url:"/admin/staffs_update/{{ $row->user_id }}",
            dataType:"json",
            data:
                $('#update_staff_form').serialize()
            ,
            success:function(data){
                if(data.success){
                    alert("更新成功");
                    location.href='/admin/staffs';
                }else{
                    
                }
            }
        });
      }
    }

  }
  $('#password_set, #confirm_password_set').on('keyup', function () {
            if ($('#password_set ').val() == $('#confirm_password_set').val()) {
            $('#message').html('密碼相符合').css('color', 'green');

            } else 
            $('#message').html('密碼不符合').css('color', 'red');
    
            });

        
    </script>

@endsection             