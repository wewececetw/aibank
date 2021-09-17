@extends('Front_End.layout.header')
@section('content')


<div id="main-page">

    <link rel="stylesheet" media="screen" href="/css/tender.css" />
    <link rel="stylesheet" media="screen" href="/table/css/table.css" />
    <link rel="stylesheet" media="screen" href="/css/list.css" />
    <link rel="stylesheet" media="screen" href="/css/list_modal.css" />
    <link rel="stylesheet" media="screen" href="/css/member.css" />
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker3.min.css"> -->

    <div class="tender_banner">
        <div class="container">
            <div class="row">
            </div>
        </div>
    </div>
    <div class="tender_link">
        <div class="container">
            <div class="row">
                <div class="li_more">
                    <span class="fbold l1"> 投標</span> <i class="fa fa-angle-right" aria-hidden="true"></i> 完成投標 <i
                        class="fa fa-angle-right" aria-hidden="true"></i> 繳款
                </div>
            </div>
        </div>
    </div>
    <form novalidate="novalidate" class="simple_form new_match_performance" id="insert_claim_tender_form"
        enctype="multipart/form-data" action="/admin/match_performances" accept-charset="UTF-8" method="post"><input
            name="utf8" type="hidden" value="&#x2713;" />
        @csrf
        <div class="container tender1">
            <div class="row">
                <div class=" bg_color2">
                    <div class="bg_all">
                        <div class="list_t">
                            <span class="translation_missing" title="">{{  $row->typing }}</span>
                            {{ $row->claim_number}}
                        </div>
                        <div class="list_tt2">
                        </div>
                    </div>
                    <div class="bg_a">
                        <div class="money_item4">
                            <div><span class="list_1">債權出讓人</span> </div>
                            <div><span class="lsit_name">{{ $row->debtor_transferor }}</span> </div>
                        </div>
                        <div class="money_item">
                            <div><span class="list_1">本次債權讓與額度</span> </div>
                            <div>
                                <span class="list_2"> {{ $row->staging_amount }}</span> 元
                            </div>
                        </div>
                        <div class="money_item2">
                            <div><span class="list_1">期數</span></div>
                            <div><span class="list_5">{{ $row->remaining_periods }}</span>期</div>
                        </div>
                        <div class="money_item3">
                            <div><span class="list_1">年化收益</span></div>
                            <div><span class="list_6  ">{{ $row->annual_interest_rate}}</span>%</div>
                        </div>
                        <div class="money_item">
                            <div><span class="list_1">剩餘金額</span></div>
                            <div><span class="list_2">
                                    <?php
                                if(isset($rest[$row->claim_id])){
                                    $pro =  $rest[$row->claim_id];
                                    echo  $pro;
                                }

                            ?>
                                </span>元</div>
                        </div>
                        <div class="money_item5">
                            <div>
                                <span class="list_1">
                                    <span class="item_data2">上架日期</span>
                                    <span class="item_data">{{ date('Y-m-d',strtotime($row->launched_at)) }}</span>
                                </span>
                            </div>
                            <div>
                                <span class="list_1">
                                    <span class="item_data2">預計結標日</span>
                                    <span
                                        class="item_data">{{ date('Y-m-d',strtotime( $row->estimated_close_date ))}}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="both"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <div class="col-md-6 col-xs-12" style="padding-left:5px; float:left">
                        <div class="field">
                            <div class="field_left">投標金額</div>
                            <input type="text" class="form-control" min="{{ $row->min_amount }}" max="{{$sub}}"
                                placeholder="" name="amount" id="amount">

                            <input style="display:none" type="text" value="{{$row->claim_id}}" name="claim_id">
                            <input style="display:none" type="text" value="{{$user_id}}" name="user_id">
                            <input style="display:none" type="text" value="{{$member_number}}" name="member_number">
                            <input style="display:none" type="text" value="{{$row->claim_number}}" name="claim_number">
                            <input style="display:none" type="text"
                                value="{{(isset($order_number->order_number))?$order_number->order_number:''}}"
                                name="order_number">
                            <input style="display:none" type="text" value="{{$payment_deadline[0]->value}}"
                                name="payment_deadline">
                            <input style="display:none" type="text" value="{{$sub}}" name="max">
                            

                            {{-- <input type="text" value="{{$row->claim_tenders->order_number}}"> --}}

                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12" style="padding-left:5px; float:left">
                        <span class="f14 pp">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                            @if($row->getOriginal('claim_state') == 0 && $row->is_pre_invest == 1)
                            最小投標金額 {{ $row->pre_invest_min_amount }} 元
                            <input style="display:none" type="text" value="{{ $row->pre_invest_min_amount }}"
                                name="pre_min">
                            @elseif($row->getOriginal('claim_state') == 1 )
                            最小投標金額 {{ $row->min_amount }} 元
                            <input style="display:none" type="text" value="{{$row->min_amount}}" name="min">
                            @endif
                            最大投標金額{{$sub}}元
                            

                            <input style="display:none" type="text" value="{{$sub}}" name="max">
                        </span>

                    </div>
                </div>
                <div class="col-md-12">
                    <div class="w100 f14 fbold pd30">
                        應投總本金<span class="ia" id='put_in_amount'>0</span>
                        總應繳本金<span class="ia" id='payment_amount'>0</span>
                        投資期數 <span class="ia">{{ $row->remaining_periods }}期</span>
                        年化利率 <span class="ia">{{ $row->annual_interest_rate}}％</span>
                        <br>
                        <span class="">
                            {{-- <a href='/test/downloadClaimPdf/{{$user_id}}/{{$row->claim_id}}/' id='download_pdf'
                            target="_blank">
                            <i class="fa fa-file-pdf-o" aria-hidden="true"></i> 債權讓售協議書
                            </a> --}}
                            <a id='download_pdf' href="#">
                                <i class="fa fa-file-pdf-o" aria-hidden="true"></i> 債權讓售協議書
                            </a>

                            <!-- <div class="col-sm-9"><a id='download_pdf' class="btn btn-success">審閱</a></div> -->
                        </span>
                    </div>
                </div>
            </div>
            <div class="member_footer">
                <a href="#" id="tender_btn" disabled>
                    <button type="button" onclick="insert_item();"
                        class="btn form_bt pull-right footer_btn">確認投標</button>
                    {{-- <input type="submit" name="commit" value="確認投標" class="btn form_bt pull-right footer_btn" data-disable-with="確認投標"> --}}
                    <span class="f14 ppb"></a>
                <label>
                    <input type="checkbox" id="notice_checkbox" required> 本人已詳閱「債權讓售協議書」與應注意事項，並同意且接受「協議書」及應注意事項所有條款無誤。
                </label>
                </span>
            </div>
        </div>
    </form>
    {{-- <input type="hidden" name="claim_id" id="claim_id" value="276" />
    <input type="hidden" name="min_investment_amount" id="min_investment_amount" value="1000" />
    <input type="hidden" name="max_investment_amount" id="max_investment_amount" value="79000" /> --}}

</div>

<script src="/assets/front/tender-3698106213cde93190b22e34303686872ae1e8aa702f4afbb2949a7993295dec.js"></script>

</body>

</html>

<?
    $all=0;
    foreach ($ispaid as $vv){
        $all+=str_replace(',', '', $vv['amount']);
    }
?>

<script>
    var all_money ={{$all}};
    $('#notice_checkbox').on('change', function () {
        console.log($('#notice_checkbox').val());
    });

    function insert_item() {
        var amount = $('#amount').val();
        console.log(amount % 1000);
        if (amount % 1000 == 0 && amount > 0) {
            if (window.confirm('當期已投標金額：'+all_money+'\n本次投標金額：'+now_money+'\n總計投標金額：'+next_money+'\n你確定要投標?')) {
                if ($('#notice_checkbox').prop('checked')) {
                    $.ajax({
                        type: "POST",
                        url: "/front/claim_tender/{{$row->claim_id}}/insert",
                        dataType: "json",
                        data: $('#insert_claim_tender_form').serialize(),
                        success: function (data) {
                            if (data.success) {
                                swal("提示", "投標成功", "success").then(function () {
                                    // history.go(-2);
                                    // location.reload();
                                    location.href = "{{$url}}" ;
                                })
                                // alert("投標成功");
                                // location.href = '/front/claim_category_special';
                            }
                            if (data.out_of_range) {
                                // alert("注意!!! 投標金額有誤，最小投標金額為" + data.min + "，\n最大投標金額為" + data.max);
                                swal("提示", "注意!!! 投標金額有誤，最小投標金額為" + data.min + "，\n最大投標金額為" + data.max, "info")
                                // location.href='/front/claim_category_special';
                            }
                            if(data.ageNotAllow){
                                swal("提示", "您未滿 20 歲，無法認購債權", "error")
                            }
                            if(data.Error){
                                swal("提示", "此債權未開放投標，無法認購此債權", "error")
                            }
                        }
                    });
                } else {
                    // alert('請詳閱「債權讓售協議書」與應注意事項，並同意且接受「協議書」及應注意事項所有條款無誤')
                    swal("提示", "請詳閱「債權讓售協議書」與應注意事項，並同意且接受「協議書」及應注意事項所有條款無誤", "info")

                }
            }
        } else {
            // alert('投標金額需以千為單位請重新改');
            swal("提示", "投標金額需以千為單位請重新改", "info")

        }
    }
    $('#amount').on('change', function () {
        $('#download_pdf').attr('href', '/test/downloadClaimPdf/{{$user_id}}/{{$row->claim_id}}/' + $('#amount').val());

    })

    $('#amount').keyup(function(){
        now_money = parseInt($('#amount').val(),10);
        next_money = all_money + now_money;
        $('#put_in_amount').html($('#amount').val());
        $('#payment_amount').html($('#amount').val())
    })

    $("#download_pdf").click(function (e) {
        event.preventDefault();


        let amount = $('#amount').val();
        if (amount != 0 && !isNaN(parseInt(amount))) {
            window.open('/test/downloadClaimPdf/{{$user_id}}/{{$row->claim_id}}/' + amount, '_blank');
        } else {
            swal("錯誤", "請輸入正確投標金額後再查看債權讓售協議書", "error");
            return false;
        }
    })
    // href='/test/downloadClaimPdf/{{$user_id}}/{{$row->claim_id}}/'

</script>
@endsection
