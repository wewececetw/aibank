@extends('Front_End.layout.header')

@section('content')
<style>
    @media screen and (max-width: 682px){
        .btn{
            padding: 0px;
        }
        .rwd_td{
            border-top: 0px!important;
        }
    }
</style>
<div id="main-page">
    <link rel="stylesheet" media="screen" href="/table/css/table.css" />
    <link rel="stylesheet" media="screen" href="/css/list.css" />
    <link rel="stylesheet" media="screen" href="/css/list_modal.css" />
    <link rel="stylesheet" media="screen" href="/css/modal.css" />
    <link rel="stylesheet" media="screen" href="/css/v.css" />
    <link rel="stylesheet" media="screen" href="/css/member.css?v=20191016" />
    <link rel="stylesheet" media="screen" href="/css/new_button_mdl.css" />
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    {{-- <script src="/js/star.js"></script> --}}
    {{-- <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" /> --}}
    <link rel="stylesheet" href="{{ asset('/fontawesome-5.13.0/css/all.css') }}">

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




    <div class="container" style="min-height: 500px;">
        <div class="row row100">
            <div class="member_title"> <span class="f28m">我的帳戶</span></div>
            <div class="btn_bottom_nomargin">
                <div class="t100">
                    <a href="/front/myaccount">
                        <div class="member_btn list_active">已繳款</div>
                    </a>
                </div>
                <div class="t100">
                    <a href="/front/myaccount_not_paid">
                        <div class="member_btn ">未繳款</div>
                    </a>
                </div>
                <div class="t100">
                    <a href="/front/myaccount_failure">
                        <div class="member_btn ">已流標</div>
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
                <!-- 已繳款 -->
                <table id="keywords" cellspacing="0" cellpadding="0" class="rwd-table tablesorter t_color ">
                    <thead>
                        <tr class="title_tr">
                            <th data-field="action" data-formatter="ActionFormatter" width="20%"><span>債權憑證號</span></th>
                            <th width=""><span>投資起息日</span></th>
                            <th width=""><span>標單狀態</span></th>
                            <th width=""><span>債權投資金額</span></th>
                            <th width=""><span>年化收益率</span></th>
                            <th width=""><span>未實現本金</span></th>
                            <th width="" style="text-align: center;"><span>收益明細</span></th>
                            <th width="" style="text-align: center;"><span>債權憑證</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ispaid as $v)
                        <tr name="1" class="tender_document_detail">
                            {{-- <td class="lalign bd-example-modal-lg" data-toggle="modal" data-target="#exampleModalLong2"
                                data-th="債權憑證號">
                                <span class="fcolor">{{$v['claim_certificate_number']}}</span>
                            </td> --}}
                            <td class="lalign bd-example-modal-lg showmd rwd_td" data-th="債權憑證號"
                                data-risk="{{ $v['risk_category'] }}" data-id="{{ $v['claim_id'] }}">
                                <span class="fcolor">{{$v['claim_certificate_number']}}</span>
                            </td>
                            <td class="bd-example-modal-lg rwd_td" data-th="投資起息日">
                                <span class="fcolor2 ">{{ $v['value_date'] }}</span>
                            </td>
                            <td class="bd-example-modal-lg rwd_td" data-th="標單狀態">
                                {{ $v['tender_document_state'] }}
                            </td>
                            <td class="bd-example-modal-lg rwd_td" data-th="債權投資金額">
                                <span class="fbold">
                                    {{ $v['amount'] }}
                                </span>
                            </td>
                            <td class="bd-example-modal-lg rwd_td" data-th="年化收益率">
                                {{ $v['annual_interest_rate'] }}%
                            </td>
                            <td class="bd-example-modal-lg rwd_td" data-th="未實現本金">
                                <span class="fbold">{{ $v['not_yet_principal'] }}</span>
                            </td>
                            <td class="bd-example-modal-lg rwd_td" data-th="收益明細">
                                {{-- <div class="center"> --}}
                                    @if($v['tender_document_state'] == '還款中' || $v['tender_document_state'] == '已結案')
                                    <button type="button" class="btn no-btn-style btn_nobg loadbtn" name="1"
                                        onclick="tender_modal({{$v['tender_documents_id']}})"
                                        data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing Order">
                                        <i class="fa fa-eye dt{{$v['tender_documents_id']}}" aria-hidden="true"></i>
                                    </button>
                                    @else
                                    <button type="button" class="btn no-btn-style btn_nobg detailBtn"
                                        data-claimId="{{ $v['claim_id'] }}" data-amount="{{ $v['amount'] }}"
                                        data-tender_id="{{ $v['tender_documents_id'] }}"
                                        data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing Order">
                                        <i class="fa fa-eye dt{{$v['tender_documents_id']}}" aria-hidden="true"></i>
                                    </button>
                                    @endif

                                {{-- </div> --}}
                            </td>
                            <? /*
                            @if(isset($v['claim_pdf_path']) )
                            <td data-th="債權憑證">
                                <div class="center">
                                    <a href="{{ url("/").'/'.$v['claim_pdf_path'] }}" target="_blank">
                                        <i class="fa fa-download" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </td>
                            @else
                            <td data-th="債權憑證">
                                <div class="center">

                                    <a href="{{ url("/test/downloadClaimPdf/$user->user_id").'/'.$v['claim_id'].'/'.str_replace(',','',$v['amount']) }}"
                                        target="_blank">
                                        <i class="fa fa-download" aria-hidden="true"></i>{{ $v['claim_id']}}
                                    </a>
                                </div>
                            </td>
                            @endif
                            */?>
                            <td data-th="債權憑證" class=" rwd_td">
                                {{-- <div class="center"> --}}
                                    @if($v['tender_document_state'] == '還款中' || $v['tender_document_state'] == '已結案')
                                        <a href="/front/myaccount_pdf/{{ $v['tender_documents_id']}}" target="_blank">
                                            <i class="fa fa-download" aria-hidden="true"></i>
                                        </a>
                                    @else
                                        <div class="center">
                                            <a href="{{ url("/test/downloadClaimPdf/$user->user_id").'/'.$v['claim_id'].'/'.str_replace(',','',$v['amount']).'/'.$v['claim_certificate_number']  }}" target="_blank">
                                                <i class="fa fa-download" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    @endif
                                    
                                {{-- </div> --}}
                            </td>
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
    <div class="modal" id="exampleModalLong2"
        style="padding-right: 17px; background: rgba(0, 0, 0, 0.5);;overflow-y: scroll;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="mobg2">
                    <div class="modal-header">
                        <button type="button" class="close close_btn">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="tender_repayment_detail">
                            <table id="" cellspacing="0" cellpadding="0" class="rwd-table tablesorter t_color ">
                                <thead>
                                    <tr class="title_tr">
                                        <th data-field="action" data-formatter="ActionFormatter" width="">
                                            <span>期數</span></th>
                                        <th width=""><span>應返還日</span></th>
                                        <th width=""><span>返還投資金額</span></th>
                                        <th width=""><span>利潤</span></th>
                                        <th width=""><span>手續費</span></th>
                                        <th width=""><span>總應返還</span></th>
                                        <th width=""><span>返還淨值</span></th>
                                        <th width=""><span>入帳日</span></th>
                                        <th width=""><span>返還日</span></th>
                                    </tr>
                                </thead>
                                <tbody id="detail_tbd">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close_btn">關閉</button>
                </div>
            </div>
        </div>
    </div>
    <!-- process image modal-->
    <div class="modal fade" id="process-image" tabindex="-1" role="dialog" aria-labelledby="process-image"
        aria-hidden="true">
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

    <input type="hidden" name="tender_repayment_data" id="tender_repayment_data" value="" />
    <div class="modal fade show" id="claim_de"
        style="padding-right: 17px; display: none;background: rgba(0, 0, 0, 0.5);;overflow-y: scroll;"></div>
    <div class="modal fade show" id="c"
        style="padding-right: 17px;background: rgba(0, 0, 0, 0.5);;overflow-y: scroll;display:none"></div>

</div>

</body>

</html>

<script>
    $(".detailBtn").click(function () {
        let $_this = $(this);
        let claim_id = $_this.data('claimid');
        let amount = $_this.data('amount');
        let tender_id = $_this.data('tender_id');
        tender_modal2(tender_id, claim_id, amount);
    })
    function tender_modal2(id,claim_id,amount) {
        gloid = id;
        btnloadingIcon(id, 'show');

        $("#detail_tbd").empty();
        setModal2(id,claim_id,amount);
        // $('#exampleModalLong2').css('display', 'block');
    }
    function setModal2(id,claim_id,amount) {
        let am='';
        amount.split(',').map(function(i){
            am += i;
        });
        console.log(am);
        $.ajax({
            url: "{{ url('/front/claim_category_counting_c2') }}" + '?amount=' + am + '&c_id='+claim_id + '&t_id='+id,
            type: 'get',
            success: function (d) {
                if (d.status == 'success') {
                    appendDataToModal2(d.data,d.total);
                } else if (d.status == 'UserError') {
                    swal('提示', '請不要嘗試獲取非本人投資債權資料!', 'error');
                } else {
                    swal('提示', '出現未知錯誤!請稍後再試或連繫豬豬在線人員告知!謝謝', 'error');
                }
            },
            error: function (e) {
                swal('提示', '出現未知錯誤!請稍後再試', 'error');
            }
        })
    }
    function appendDataToModal2(data,toltal) {

        let x = 0,
            xlen = data.time.length;
        let tr = '';

        for (x; x < xlen; x++) {
            let fee = data.everyMonthInterest[x] * data.fee_rate / 100;
            let t = `
        <tr>
            <td data-th="期數"><span class="fcolor">${ x+1 }</span></td>
            <td data-th="應返還日"><span>${  data.time[x] }</span> </td>
            <td data-th="還投資金額">${  data.everyMonthPrincipal[x] }</td>
            <td data-th="利潤"><span class="fbold">${  data.everyMonthInterest[x] }</span> </td>
            <td data-th="手續費">${data.thirdPartyManagmentFee[x]}</td>
            <td data-th="總應返還"><span class="fbold">${  data.everyMonthPaidTotal[x] }</span></td>
            <td data-th="返還淨值">${  data.end[x] }</td>
            <td data-th="入帳日"></td>
            <td data-th="返還日"></td>
        </tr>
        `;
            tr += t;
        }

        let t_end = `    
        <tr>
            <td style='display:none;' data-th="期數"><span class="fcolor"></span></td>
            <td colspan='2' style='text-align:center' data-th="應返還日"><span>總計</span></td>
            <td data-th="還投資金額">${  toltal.everyMonthPrincipal }</td>
            <td data-th="利潤"><span class="fbold">${  toltal.everyMonthInterest }</span> </td>
            <td data-th="手續費">${ toltal.thirdPartyManagmentFee }</td>
            <td data-th="總應返還"><span class="fbold">${  toltal.everyMonthPaidTotal }</span></td>
            <td data-th="返還淨值">${ toltal.totala }</td>
            <td data-th="入帳日"></td>
            <td data-th="返還日"></td>
        </tr>    
        `;
        
        
        tr = tr + t_end;

        $("#detail_tbd").append(tr);
        $('#exampleModalLong2').css('display', 'block');
        btnloadingIcon(gloid, 'hide');

    }

    $(".showmd").click(function () {
        let risk = $(this).data('risk');
        let id = $(this).data('id');
        if (risk == '8') {
            category_sp_modal(id);
        } else {

            category_modal(id);
        }
    })

    function category_modal(target) {

        $.ajax({
            type: "POST",
            url: "/front/get_claims_html/" + target,
            dataType: "json",
            data: {
                id: target,
            },
            success: function (data) {
                if (data.success) {
                    $('#claim_de').html(data._claims_html);
                    $('#claim_de').modal('show');
                } else {
                    alert('error');
                }
            }
        });


    }

    function category_sp_modal(target) {

        $.ajax({
            type: "POST",
            url: "/front/get_sp_claims_html/" + target,
            dataType: "json",
            data: {
                id: target,
            },
            success: function (data) {
                if (data.success) {
                    $('#c').html(data._sp_claims_html);
                    $('#c').modal('show');
                } else {
                    alert('error');
                }
            }
        });


    }

</script>
<script type="text/javascript">
    var gloid;

    function btnloadingIcon(id, st) {
        let that = $('.dt' + id)[0];
        if (st == 'show') {
            $(that).toggleClass('fas fa-circle-notch fa-spin', true);
            $(that).toggleClass('fa fa-eye', false);
        } else {
            $(that).toggleClass('fas fa-circle-notch fa-spin', false);
            $(that).toggleClass('fa fa-eye', true);
        }
    }

    function tender_modal(id) {
        gloid = id;
        btnloadingIcon(id, 'show');

        $("#detail_tbd").empty();
        setModal(id);
        // $('#exampleModalLong2').css('display', 'block');

    }

    $('.close_btn').click(function (e) {
        $('#exampleModalLong2').css('display', 'none');
    });

    function setModal(id) {
        // console.log(this);
        $.ajax({
            url: "{{ url('/front/api/getRepaymentDetail/') }}" + '/' + id,
            type: 'get',
            success: function (d) {
                if (d.status == 'success') {
                    appendDataToModal(d.data,d.toltal);
                } else if (d.status == 'UserError') {
                    swal('提示', '請不要嘗試獲取非本人投資債權資料!', 'error');
                } else {
                    swal('提示', '出現未知錯誤!請稍後再試或連繫豬豬在線人員告知!謝謝', 'error');
                }
            },
            error: function (e) {
                swal('提示', '出現未知錯誤!請稍後再試', 'error');
            }
        })
    }

    function appendDataToModal(data,toltal) {

        let x = 0,
            xlen = data.length;
        let tr = '';

        for (x; x < xlen; x++) {
            
            let d = data[x];
            if(d.real_return_amount==null){d.real_return_amount='';}
            let t = `
        <tr>
            <td data-th="期數"><span class="fcolor">${ d.period_number }</span></td>
            <td data-th="應返還日"><span>${ d.target_repayment_date }</span> </td>
            <td data-th="還投資金額">${ d.per_return_principal }</td>
            <td data-th="利潤"><span class="fbold">${ d.per_return_interest }</span> </td>
            <td data-th="手續費">${ d.management_fee }</td>
            <td data-th="總應返還"><span class="fbold">${ d.total  }</span></td>
            <td data-th="返還淨值">${ d.real_return_amount }</td>
            <td data-th="入帳日">${ d.credited_at }</td>
            <td data-th="返還日">${ d.paid_at }</td>
        </tr>
        `;
            tr += t;

        }

            let t_end = `    
        <tr>
            <td style='display:none;' data-th="期數"><span class="fcolor"></span></td>
            <td colspan='2' style='text-align:center' data-th="應返還日"><span>總計</span></td>
            <td data-th="還投資金額">${  toltal.everyMonthPrincipal }</td>
            <td data-th="利潤"><span class="fbold">${  toltal.everyMonthInterest }</span> </td>
            <td data-th="手續費">${ toltal.thirdPartyManagmentFee }</td>
            <td data-th="總應返還"><span class="fbold">${  toltal.everyMonthPaidTotal }</span></td>
            <td data-th="返還淨值">${ toltal.totala }</td>
            <td data-th="入帳日"></td>
            <td data-th="返還日"></td>
        </tr>    
        `;
        tr = tr + t_end;

        $("#detail_tbd").append(tr);
        $('#exampleModalLong2').css('display', 'block');
        btnloadingIcon(gloid, 'hide');

    }

</script>


@endsection
