@extends('Back_End.layout.header')

@section('content')

    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">貸款專區</h3>
          </div>
        </div>

        <div class="col-md-12">
            <div style="border:solid 1px #1a2732">
                <div style="padding:10px;background-color:#394a59;">
                    <h4 style="color:white;">貸款專區</h4>
                </div>
            <div class="panel-body">
                <form novalidate="novalidate" class="simple_form new_match_performance" id="update_loan_form" enctype="multipart/form-data" action="/admin/match_performances" accept-charset="UTF-8" method="post"><input name="utf8" type="hidden" value="&#x2713;" />

                    @csrf
                    <div class="detail_1" style="margin-bottom:40px;">

                        <div class="row">
                            <h6 class="form_title">申請人基本資料</h6>
                        </div>

                        <div class="row m-b-15">
                            <div class="col-sm-6">
                                <label for="exampleFormControlTextarea1">姓名</label>
                                <input  name="lender_name" class="form-control" id="lender_name" value="{{$row->lender_name}}" readonly>
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">出生年月日</label>
                                <input type="text" class="datepicker form-control datepicker_style" id="dob"  value="{{$row->dob}}"name="dob" autocomplete="off"  value="<?=date('Y/m/d')?>" readonly>
                            </div>
                        </div>

                        <div class="row m-b-15">
                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">身分證字號</label>
                                <input type="text" class="form-control" id="lender_id_number" name="lender_id_number" value="{{$row->lender_id_number}}" readonly>
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">行動電話</label>
                                <input type="text" class="form-control" id="cellphone_number" name="cellphone_number" value="{{$row->cellphone_number}}" readonly>
                            </div>
                        </div>
                    

                        <div class="row m-b-15">
                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">住家電話</label>
                                <input type="text" class="form-control" id="telephone_number" name="telephone_number" value="{{$row->telephone_number}}" readonly>
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">居住地址</label>
                                <input type="text" class="form-control" id="address" name="address" value="{{$row->address}}" readonly>
                            </div>
                        </div>

                    </div>

                    <div class="detail_2" style="margin-bottom:40px;">
                        <div class="row">
                            <h6 class="form_title">申請人工作資料</h6>
                        </div>

                        <div class="row m-b-15">
                            <div class="col-sm-6">
                                <label for="exampleFormControlTextarea1">公司名稱</label>
                                <input  name="company_name" class="form-control" id="company_name" value="{{$row->company_name}}" readonly>
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">職稱</label>
                                <input type="text" class="form-control" id="job_title"  value="{{$row->job_title}}" name="job_title" autocomplete="off" readonly>
                            </div>
                        </div>

                        <div class="row m-b-15">
                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">月薪</label>
                                <input type="text" class="form-control" id="monthly_salary" value="{{$row->monthly_salary}}" name="monthly_salary" readonly>
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">公司電話</label>
                                <input type="text" class="form-control" id="company_phone" name="company_phone" value="{{$row->company_phone}}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="detail_3">
                        <div class="row">
                            <h6 class="form_title">貸款種類</h6>
                        </div>

                        <div class="row m-b-15">
                            <div class="col-sm-6">
                                <label for="exampleFormControlTextarea1">種類</label>
                                <select name="loan_type" class="form-control" id="loan_type" readonly="readonly">
                                    <option value="0" <?=($row['loan_type']=='個人信用貸款')?' selected':''?>>個人信用貸款</option>
                                    <option value="1" <?=($row['loan_type']=='個人抵押貸(車貸)')?' selected':''?>>個人抵押貸(車貸)</option>
                                    <option value="2" <?=($row['loan_type']=='商業貸')?' selected':''?>>商業貸</option>
                                </select>
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">金額</label>
                                <input type="text" class="form-control" id="amount" value="{{$row->amount}}" name="amount" readonly>
                            </div>
                        </div>


                        <div class="row m-b-15">
                            <div class="col-sm-6">
                                <label for="exampleFormControlTextarea1">期數</label>
                                <input  name="periods" class="form-control" id="periods"  value="{{$row->periods}}"readonly>
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">貸款用途</label>
                                <input type="text" class="form-control" id="description" value="{{$row->description}}" name="description" readonly>
                            </div>
                        </div>

                        <div class="row m-b-15">
                            <div class="col-sm-6">
                                <label for="exampleFormControlTextarea1">是否聯繫</label>
                                <select name="is_contact" class="form-control" id="is_contact" value="" readonly>
                                    <option value="0" <?=($row['is_contact']=='未聯繫')?' selected':''?>>未聯繫</option>
                                    <option value="1" <?=($row['is_contact']=='已聯繫')?' selected':''?>>已聯繫</option>
                                </select>
                            </div>
                        </div>

                        <div class="row m-b-15">

                            <div class='col-sm-12'>
                                <label for="exampleFormControlTextarea1">備註</label>
                            <textarea class="form-control" name="comment" id="comment" rows="3" >{{$row->comment}}</textarea>
                            </div>
                        </div>


                    </div>
                    
                    <div class="col-sm-12">
                        
                        <a class="btn btn-info pull-right" href="/admin/loans">返回</a>
                        <button style="margin-right:10px" type="button" onclick="update_item();" class="btn btn-info pull-right">更新</button>
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
    if($("#update_loan_form").valid()){
      $.ajax({
            type:"POST",
            url:"/admin/loans/loans_update/{{ $row->loan_id }}",
            dataType:"json",
            data:
                $('#update_loan_form').serialize()
            ,
            success:function(data){
                if(data.success){
                    alert("更新成功");
                    location.href='/admin/loans';
                }else{
                    
                }
            }
        });
      }

  }
                


        
    </script>

@endsection             