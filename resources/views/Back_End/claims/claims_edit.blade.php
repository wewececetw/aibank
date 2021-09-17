@extends('Back_End.layout.header')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>

<style>
    td {
        word-break: break-all !important;
    }
    .c3-axis-y > .tick{
fill: none;                // removes axis labels from y axis
}
</style>
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">編輯債權</h3>
          </div>
        </div>

        <div class="col-md-12">
            <div style="border:solid 1px #1a2732">
                <div style="padding:10px;background-color:#394a59;">
                    <h4 style="color:white;">債權{{$row->claim_number}}</h4>
                </div>
            <div class="panel-body">
                <form novalidate="novalidate" class="simple_form new_match_performance" id="update_claim_form" enctype="multipart/form-data" action="/admin/match_performances" accept-charset="UTF-8" method="post"><input name="utf8" type="hidden" value="&#x2713;" />
                    @csrf
                        <div class="row m-b-15">
                            <div class="col-sm-6">
                                <label for="exampleFormControlTextarea1">物件編號</label>
                            <input type="text" class="form-control" name="claim_number" autocomplete="off" value="{{$row->claim_number}}">
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">權限設定</label>
                                <select name="loan_type" class="select optional form-control select2 filter-loan_type" include_blank="true" id="loan_loan_type" >
                                    <option value="">請選擇</option>
                                    <option value="0">產品行銷人員</option>
                                    <option value="1">客服專員</option>
                                    <option value="2">營運主管</option>
                                    <option value="3">財務專員</option>
                                </select>
                            </div>
                        </div>

                        <div class="row m-b-15">
                            <div class="col-sm-6">
                                <label for="exampleFormControlTextarea1">統一編號</label>
                                <input type="text" class="form-control" name="tax_id" autocomplete="off" value="{{$row->tax_id}}">
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">對應流水號</label>
                                <input type="text" class="form-control" name="serial_number" autocomplete="off" value="{{$row->serial_number}}">
                            </div>
                        </div>

                        <div class="row m-b-15">
                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">分期起始日</label>
                                <input type="text" id="staged_at" class="form-control" name="staged_at" value="{{$row->staged_at}}">
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">分期總金額</label>
                                <input type="number" class="form-control" name="staging_amount" autocomplete="off" value="{{$row->staging_amount}}">
                            </div>
                        </div>

                        <div class="row m-b-15">
                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">原始期數</label>
                                <input type="number" class="form-control" name="periods" autocomplete="off" value="{{$row->periods}}">
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">剩餘期數</label>
                                <input type="number" class="form-control" name="remaining_periods" autocomplete="off" value="{{$row->remaining_periods}}">
                            </div>
                        </div>

                        <div class="row m-b-15">
                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">年利率</label>
                                <input type="number" class="form-control" name="annual_interest_rate" autocomplete="off" value="{{$row->annual_interest_rate}}">
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">最低標額</label>
                                <input type="number" class="form-control" name="min_amount" autocomplete="off" value="{{$row->min_amount}}">
                            </div>
                        </div>

                        <div class="row m-b-15">
                            {{-- <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">得標總利息</label>
                                <input type="number" class="form-control" name="bid_interest" autocomplete="off" value="{{$row->bid_interest}}">
                            </div> --}}

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">管理費費率</label>
                                <input type="number" class="form-control" name="management_fee_rate" autocomplete="off" value="{{$row->management_fee_rate}}">
                            </div>
                        </div>

                        <div class="row m-b-15">
                            {{-- <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">總管理費</label>
                                <input type="number" class="form-control" name="management_fee_amount" autocomplete="off" value="{{$row->management_fee_amount}}">
                            </div> --}}

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">債權說明</label>
                                <input type="text" class="form-control" name="description" autocomplete="off" value="{{$row->description}}">
                            </div>
                        </div>

                        <div class="row m-b-15">
                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">約定買回方</label>
                                <input type="text" class="form-control" name="agreement_buyer" autocomplete="off" value="{{$row->agreement_buyer}}">
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">上架日</label>
                                <input type="text" id="launched_at" class="form-control" name="launched_at" value="{{$row->launched_at}}">
                            </div>
                        </div>

                        <div class="row m-b-15">
                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">預計結標日</label>
                                <input type="text" class="form-control" name="estimated_close_date" id="estimated_close_date" value="{{$row->estimated_close_date}}">
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">還款方式</label>
                                <select name="repayment_method" class="select optional form-control select2 filter-loan_type" include_blank="true"  >
                                    <option value="0" <?=($row['repayment_method']=='先息後本')?' selected':''?>>先息後本</option>
                                    <option value="1" <?=($row['repayment_method']=='本息攤還')?' selected':''?>>本息攤還</option>


                                </select>
                            </div>
                        </div>

                        <div class="row m-b-15">
                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">累標總額</label>
                                <input type="number" class="form-control" name="" autocomplete="off" value="" readonly >
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">標售率</label>
                                <input type="number" class="form-control" name="" autocomplete="off" value="" readonly>
                            </div>
                        </div>

                        <div class="row m-b-15">
                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">標單數</label>
                                <input type="text" class="form-control" name="" autocomplete="off" value="" readonly>
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">是否結標</label>
                                <select name="loan_type" class="select optional form-control select2 filter-loan_type" include_blank="true" id="loan_loan_type"  value="" readonly>
                                    <option value="">請選擇</option>
                                    <option value="0">是</option>
                                    <option value="1">否</option>
                                </select>
                            </div>
                        </div>

                        <div class="row m-b-15">
                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">結標日</label>
                                <input type="text"  class="form-control" name="closed_at" id="closed_at" value="{{$row->closed_at}}">
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">帳單繳款期限</label>
                                <input type="text" class="form-control" name="payment_final_deadline" id="payment_final_deadline" value="{{$row->payment_final_deadline}}">
                            </div>
                        </div>

                        <div class="row m-b-15">
                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">已收款</label>
                                <input type="text" class="form-control" name="" autocomplete="off" value="" readonly>
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">收款率</label>
                                <input type="text" class="form-control" name="" autocomplete="off" value="" readonly>
                            </div>
                        </div>

                        <div class="row m-b-15">
                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">起息還款日</label>
                                <input type="text" class="datepicker form-control datepicker_style" name="value_date" id="value_date" value="{{$row->value_date}}" readonly>
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">流標日</label>
                                <input type="text" class="datepicker form-control datepicker_style" name="showDate" id="" value="" readonly>
                            </div>
                        </div>

                        <div class="row m-b-15">
                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">流標投資款匯回日</label>
                                <input type="text" class="datepicker form-control datepicker_style" name="showDate" id="" value="" readonly>
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">債權轉讓人</label>
                                <input type="text" class="form-control" name="debtor_transferor" autocomplete="off" value="{{$row->debtor_transferor}}">
                            </div>
                        </div>

                        <div class="row m-b-15">
                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">貸款人</label>
                                <input type="text" class="form-control" name="borrower" autocomplete="off" value="{{$row->borrower}}">
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">身分證號</label>
                                <input type="text" class="form-control" name="id_number" autocomplete="off" value="{{$row->id_number}}">
                            </div>
                        </div>

                        <div class="row m-b-15">
                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">性別</label>
                                <select name="gender" class="select optional form-control select2 filter-loan_type" include_blank="true"  >
                                    <option value="0" <?=($row['gender']=='男')?' selected':''?>>男</option>
                                    <option value="1" <?=($row['gender']=='女')?' selected':''?>>女</option>
                                    <option value="2" <?=($row['gender']=='其他')?' selected':''?>>其他</option>


                                </select>
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">年齡</label>
                                <input type="text" class="form-control" name="age" autocomplete="off" value="{{$row->age}}">
                            </div>
                        </div>

                        <div class="row m-b-15">
                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">學歷</label>
                                <input type="text" class="form-control" name="education" autocomplete="off" value="{{$row->education}}">
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">婚姻狀況</label>
                                <input type="text" class="form-control" name="marital_state" autocomplete="off" value="{{$row->marital_state}}">
                            </div>
                        </div>

                        <div class="row m-b-15">
                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">居住地</label>
                                <input type="text" class="form-control" name="place_of_residence" autocomplete="off" value="{{$row->place_of_residence}}">
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">居住狀況</label>
                                <input type="text" class="form-control" name="living_state" autocomplete="off" value="{{$row->living_state}}">
                            </div>
                        </div>

                        <div class="row m-b-15">
                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">行業別</label>
                                <input type="text" class="form-control" name="industry" autocomplete="off" value="{{$row->industry}}">
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">職稱</label>
                                <input type="text" class="form-control" name="job_title" autocomplete="off" value="{{$row->job_title}}">
                            </div>
                        </div>

                        <div class="row m-b-15">
                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">年資</label>
                                <input type="text" class="form-control" name="seniority" autocomplete="off" value="{{$row->seniority}}">
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">月薪</label>
                                <input type="text" class="form-control" name="monthly_salary" autocomplete="off" value="{{$row->monthly_salary}}">
                            </div>
                        </div>

                        <div class="row m-b-15">
                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">連帶保證人</label>
                                <input type="text" class="form-control" name="guarantor" autocomplete="off" value="{{$row->guarantor}}">
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">風險評級</label>
                                <select name="risk_category" class="select optional form-control select2 filter-loan_type" include_blank="true"  >
                                    <option value="0" <?=($row['risk_category']=='A')?' selected':''?>>A</option>
                                    <option value="1" <?=($row['risk_category']=='B')?' selected':''?>>B</option>
                                    <option value="2" <?=($row['risk_category']=='C')?' selected':''?>>C</option>
                                    <option value="3" <?=($row['risk_category']=='D')?' selected':''?>>D</option>
                                    <option value="4" <?=($row['risk_category']=='E')?' selected':''?>>E</option>
                                    <option value="5" <?=($row['risk_category']=='V')?' selected':''?>>V</option>
                                    <option value="6" <?=($row['risk_category']=='H')?' selected':''?>>H</option>
                                    <option value="7" <?=($row['risk_category']=='M')?' selected':''?>>M</option>
                                    <option value="8" <?=($row['risk_category']=='S')?' selected':''?>>S</option>
                                </select>
                            </div>
                        </div>

                        <div class="row m-b-15">
                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">有效身分證</label>
                                <input type="text" class="form-control" name="id_number_effective" autocomplete="off" value="{{$row->id_number_effective}}">
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">同業黑名單</label>
                                <input type="text" class="form-control" name="peer_blacklist" autocomplete="off" value="{{$row->peer_blacklist}}">
                            </div>
                        </div>

                        <div class="row m-b-15">
                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">更生清算戶</label>
                                <input type="text" class="form-control" name="rehabilitated_settlement" autocomplete="off" value="{{$row->rehabilitated_settlement}}">
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">票信狀況</label>
                                <input type="text" class="form-control" name="ticket_state" autocomplete="off" value="{{$row->ticket_state}}">
                            </div>
                        </div>

                        <div class="row m-b-15">
                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">重大交通罰款</label>
                                <input type="number" class="form-control" name="major_traffic_fines" autocomplete="off" value="{{$row->major_traffic_fines}}">
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">一年內同業查詢次數</label>
                                <input type="number" class="form-control" name="peer_query_count" autocomplete="off" value="{{$row->peer_query_count}}">
                            </div>
                        </div>

                        <div class="row m-b-15">
                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">國內/海外</label>
                                <select name="foreign" class="select optional form-control select2 filter-loan_type" include_blank="true"  >
                                    <option value="0" <?=($row['foreign']=='國內')?' selected':''?>>國內</option>
                                    <option value="1" <?=($row['foreign']=='海外')?' selected':''?>>海外</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-sm-12" style="margin-top:40px;">
                            <a class="btn btn-info pull-right" href="/admin/claims">返回</a>
                            <button type="button" onclick="update_item();" class="btn btn-info pull-right m-r-5">儲存</button>
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
    if($("#update_claim_form").valid()){
      $.ajax({
            type:"POST",
            url:"/admin/claims_update/{{ $row->claim_id }}",
            dataType:"json",
            data:
                $('#update_claim_form').serialize()
            ,
            success:function(data){
                if(data.success){
                    alert("更新成功");
                    location.href='/admin/claims';
                }else{

                }
            }
        });
      }

  }

$('#staged_at').datepicker({ format: 'yyyy-mm-dd'});
$('#launched_at').datepicker({ format: 'yyyy-mm-dd'});
$('#estimated_close_date').datepicker({ format: 'yyyy-mm-dd'});
$('#closed_at').datepicker({ format: 'yyyy-mm-dd'});


    </script>

@endsection
