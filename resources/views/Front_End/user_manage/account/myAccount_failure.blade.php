@extends('Front_End.layout.header')

@section('content')

<div id="main-page">
    <link rel="stylesheet" media="screen" href="/table/css/table.css" />
    <link rel="stylesheet" media="screen" href="/css/list.css" />
    <link rel="stylesheet" media="screen" href="/css/list_modal.css" />
    <link rel="stylesheet" media="screen" href="/css/modal.css" />
    <link rel="stylesheet" media="screen" href="/css/v.css" />
    <link rel="stylesheet" media="screen" href="/css/member.css?v=20191016" />
    <link rel="stylesheet" media="screen" href="/css/new_button_mdl.css" />
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <div class="member_banner">
        <div class="container">
            <div class="row">
                <div class="banner_content">
                    <div class="member_id"><span class="f30">Hi, {{ $user->user_name }}</span> </div>
                    <div class="m-col-2">
                        <div class="circular">
                            <div class="circular_text">
                                <span class="f38">
                                    {{ $invest_info['Internal_Rate_of_Return'] }}
                                </span>
                                <span class="f16">%</span>
                            </div>
                            <div class="circular_text2">年化報酬率<br><span style="font-size:10px">(未扣除服務費)</span></div>
                        </div>
                    </div>
                    <div class="m-col-8">
                        <div class="m-col-33">
                            <div class="banner_content_t">
                                <p class="f14 color_member">總投資金額</p>
                                <p class="f25">
                                    {{ $invest_info['total_invest'] }}
                                    <span class="f14">元</span>
                                </p>
                            </div>
                        </div>
                        <div class="m-col-33">
                            <div class="banner_content_t">
                                <p class="f14 color_member">已取回投資金額</p>
                                <p class="f25">
                                    {{ $invest_info['back_invest_money'] }}
                                    <span class="f14">元</span>
                                </p>
                            </div>
                        </div>
                        <div class="m-col-33">
                            <div class="banner_content_t">
                                <p class="f14 color_member">未取回投資金額</p>
                                <p class="f25">
                                    {{ $invest_info['not_back_invest_money'] }}
                                    <span class="f14">元</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="m-col-8 top30">
                        <div class="m-col-33">
                            <div class="banner_content_t">
                                <p class="f14 color_member">總投資收益<span style="font-size:9px">(未扣除手續費)</span></p>
                                <p class="f25">
                                    {{ $invest_info['total_income'] }}
                                    <span class="f14">元</span>
                                </p>
                            </div>
                        </div>
                        <div class="m-col-33">
                            <div class="banner_content_t">
                                <p class="f14 color_member">已實現投資收益<span style="font-size:9px">(未扣除手續費)</span></p>
                                <p class="f25">
                                    {{ $invest_info['back_invest_income'] }}
                                    <span class="f14">元</span>
                                </p>
                            </div>
                        </div>
                        <div class="m-col-33">
                            <div class="banner_content_t">
                                <p class="f14 color_member">未實現投資收益<span style="font-size:9px">(未扣除手續費)</span></p>
                                <p class="f25">
                                    {{ $invest_info['not_back_invest_income'] }}
                                    <span class="f14">元</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @component('Front_End.user_manage.account.mobileSelect')
    @endcomponent


    <script>
        window.onload = function() {
            var url = window.location.pathname
            $("#menu").val(url);
            switch (url) {
                case "/users":
                    $("#users").addClass("menu_active2")
                    break;
                case "/front/myaccount":
                    $("#myaccount").addClass("menu_active2")
                    break;
                case "/users/tab_two":
                    $("#tab-two").addClass("menu_active2")
                    break;
                case "/users/tab_three":
                    $("#tab-three").addClass("menu_active2")
                    break;
                case "/users/tab_four":
                    $("#tab-four").addClass("menu_active2")
                    break;
                case "/users/tab_five":
                    $("#tab-five").addClass("menu_active2")
                    break;
                case "/front/payment":
                    $("#payment").addClass("menu_active2")
                    break;
                case "/users/favorite":
                    $("#favorite").addClass("menu_active2")
                    break;
                case "/users/recommendation":
                    $("#recommend").addClass("menu_active2")
                    break;
            }

            $('#menu').on('change', function(e) {
                var optionElem = $(this).find('option:selected');
                var submitForm = $(optionElem).data('submit-form');

                if (submitForm) {
                    var $form = $(submitForm);
                    e.preventDefault();
                    e.stopPropagation();

                    $form.attr('target', '_self')
                        .submit();
                    return false
                }
            });
        }
    </script>

    <div class="container" style="min-height: 500px;">
        <div class="row row100">
            <div class="member_title"> <span class="f28m">我的帳戶</span></div>
            <div class="btn_bottom_nomargin">
                <div class="t100">
                    <a href="/front/myaccount">
                        <div class="member_btn ">已繳款</div>
                    </a>
                </div>
                <div class="t100">
                    <a href="/front/myaccount_not_paid">
                        <div class="member_btn ">未繳款</div>
                    </a>
                </div>
                <div class="t100">
                    <a href="/front/myaccount_failure">
                        <div class="member_btn list_active" >已流標</div>
                    </a>
                </div>
                <div class="t100">
                    <a href="/front/myaccount_bill">
                        <div class="member_btn ">我的帳本</div>
                    </a>
                </div>
                {{-- 查看投標流程 --}}
                {{-- <div id="invest" class="btn_right_R mem_btn_R">
                    <div class="btn_3 active_2">
                        <button id="send_tender" data-toggle="modal" data-target="#process-image" style="cursor: pointer;">
                            <i class="fa fa-sitemap" aria-hidden="true"></i>查看投標流程
                        </button>
                    </div>
                </div> --}}
            </div>    

<? /*?>
            <button class="process-button" data-toggle="modal" data-target="#process-image">
                查看投標流程
            </button>
<? */?>
            <div class="member_content_noline">
                <!-- 已未繳款 -->
                <table id="keywords" cellspacing="0" cellpadding="0" class="rwd-table tablesorter t_color ">
                    <thead>
                        <tr class="title_tr">
                            <th data-field="action" data-formatter="ActionFormatter" width="20%"><span>債權憑證號</span></th>
                            <th width=""><span>投資起息日</span></th>
                            <th width=""><span>標單狀態</span></th>
                            <th width=""><span>債權投資金額</span></th>
                            <th width=""><span>年化收益率</span></th>
                            <th width=""><span>未實現本金</span></th>
                            {{-- <th width="" style="text-align: center;"><span>收益明細</span></th>
                            <th width="" style="text-align: center;"><span>債權憑證</span></th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ispaid as $v)
                        <tr name="1" class="tender_document_detail">
                            <td class="lalign bd-example-modal-lg showmd" data-th="債權憑證號"  data-risk="{{ $v['risk_category'] }}" data-id="{{ $v['claim_id'] }}">
                                <span class="fcolor">{{$v['claim_certificate_number']}}</span>
                            </td>
                            <td class="bd-example-modal-lg" data-th="投資起息日">
                            <span class="fcolor2 ">{{ $v['value_date'] }}</span>
                            </td>
                            <td class="bd-example-modal-lg" data-th="標單狀態">
                                {{ $v['tender_document_state'] }}
                            </td>
                            <td class="bd-example-modal-lg" data-th="債權投資金額">
                                <span class="fbold">
                                    {{ $v['amount'] }}
                                </span>
                            </td>
                            <td class="bd-example-modal-lg" data-th="年化收益率">
                                {{ $v['annual_interest_rate'] }}%
                            </td>
                            <td class="bd-example-modal-lg" data-th="未實現本金">
                                <span class="fbold">{{ $v['not_yet_principal'] }}</span>
                            </td>
                            {{-- <td class="bd-example-modal-lg" data-th="收益明細">
                                <div class="center">
                                    @if($v['tender_document_state'] == '還款中' || $v['tender_document_state'] == '已結案')
                                    <button type="button" class="btn no-btn-style btn_nobg" name="1" onclick="tender_modal()">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </button>
                                    @endif

                                </div>
                            </td>
                            <td data-th="債權憑證">
                                <div class="center">
                                    <button type="button" id="downloadClaimPdf" data-tender_document_id="1" class="btn no-btn-style redemption_bt js-myaccount_download_tender btn_nobg" data-amount="4000000">
                                        <i class="fa fa-download" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- 已未繳款 -->
            </div>

            <!-- 分頁 -->
            <nav aria-label="..." class="m-auto pd2070 page_n">

            </nav>

            <div class="form-group page_b page_ba">

            </div>
        </div>
    </div>

    <!-- 已未繳款modal -->
    <!-- modal -->
    <div class="modal fade" id="exampleModalLong2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="mobg2">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="claim_detail"></div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <!-- modal    -->
    <!-- modal -->
    <div class="modal fade" id="TenderRepayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="mobg2">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="tender_repayment_detail"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal  -->
    <!-- process image modal-->
    <div class="modal fade" id="process-image" tabindex="-1" role="dialog" aria-labelledby="process-image" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:1150px;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="process-image-source" src="/images/process_image.png" width="100%" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- /modal  -->
    <div class="modal fade show" id="claim_de"  style="padding-right: 17px; display: none;background: rgba(0, 0, 0, 0.5);;overflow-y: scroll;"></div>
    <div class="modal fade show" id="c"  style="padding-right: 17px;background: rgba(0, 0, 0, 0.5);;overflow-y: scroll;display:none"></div>

    <input type="hidden" name="tender_repayment_data" id="tender_repayment_data" value="" />
</div>

<script>
    $(".showmd").click(function(){
        let risk = $(this).data('risk');
        let id = $(this).data('id');
        if(risk == '8'){
            category_sp_modal(id);
        }else{

        category_modal(id);
        }
    })
    function category_modal(target){

$.ajax({
    type:"POST",
    url:"/front/get_claims_html/"+target,
    dataType:"json",
    data:{
        id:target,
    }
    ,
    success:function(data){
        if(data.success){
            $('#claim_de').html(data._claims_html);
            $('#claim_de').modal('show');
        }else{
            alert('error');
        }
    }
});


}
function category_sp_modal(target){

$.ajax({
    type:"POST",
    url:"/front/get_sp_claims_html/"+target,
    dataType:"json",
    data:{
        id:target,
    }
    ,
    success:function(data){
        if(data.success){
            $('#c').html(data._sp_claims_html);
            $('#c').modal('show');
        }else{
            alert('error');
        }
    }
});


}
</script>
</body>
</html>
@endsection
