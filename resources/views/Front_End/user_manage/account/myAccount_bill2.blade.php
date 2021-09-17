@extends('Front_End.layout.header')

@section('content')
<?
    $s_d_1 = strtotime("2000-01-01");
    $s_d_2 = strtotime("2100-01-01");
    $ins1="";
    $ins2="";
    $st1="";
    $st2="";
    $st3="";
    $st4="";
    $cb ="";
    $t1 ="日期";
    $t2 ="銀行到帳日";
    if(!empty($_GET["b1"])){
        $s_d_1 = strtotime($_GET["b1"]."00:00:00");
        $ins1=" value = '".$_GET["b1"]."'";
    }
    if(!empty($_GET["b2"])){
        $s_d_2 = strtotime($_GET["b2"]." 23:59:59");
        $ins2=" value = '".$_GET["b2"]."'";
    }
    if(!empty($_GET["bt"])){
        if($_GET["bt"]==1){ $st1=" selected='selected' "; }
        if($_GET["bt"]==2){ $st2=" selected='selected' "; }
        if($_GET["bt"]==3){ $st3=" selected='selected' "; }
        if($_GET["bt"]==4){ $st4=" selected='selected' "; }
    }
    if(!empty($_GET["get_money"])){
        $cb ="checked='checked'";
        $t1 ="銀行到帳日";
        $t2 ="預計還款日";
    }
?>
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
<style>
.nh{
    height:0px;
}
.tdh{
    height:unset;
    padding: unset !important;
}
.tdd{
    padding: unset !important;
}
.tdd:before{
    font-size:0px !important;
}
#b1,#b2{
    font-size: 14px;
    border-width: 1px;
    width:150px;
    height:26px;
}
.bd-example-modal-lg{ text-align: left ;}
@media (min-width: 480px){
    .bd-example-modal-lg{ text-align:right  !important;}
    .tdh{
        height:640px;
        overflow: auto;
    }
    .rwd-table th, .rwd-table td {
        padding: 0.6em 5px !important;
    }
}
@media (max-width: 568px){
    .rwd-table th, .rwd-table td {
        margin: 0.2em 0.2em;
    }
}
@media (max-width: 568px){
    #all_n{ display:none;}
}
</style>
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
                        <div class="member_btn">已繳款</div>
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
                        <div class="member_btn list_active">我的帳本</div>
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
            <form>
                <div style="margin:0 0 13px 0">
                    查詢區間<br>
                    <input type="date" name="b1" id="b1" <?=$ins1?>>-<input type="date" name="b2" id="b2"<?=$ins2?>>
                    <select name="bt" style="font-size: 14px;height: 26px;width:150px;margin-right:10px">
                        <option value="0">-</option>
                        <option value="1" {{$st1}} >購買債權</option>
                        <option value="2" {{$st2}} >還款本息</option>
                        <option value="3" {{$st3}} >結清買回</option>
                        <option value="4" {{$st4}} >逾期買回</option>
                    </select>　
                    <input type="submit" value="查詢" class="member_btn list_active" style="margin:13px 0;font-size: 14px;">
                    <br>
                    <input type="checkbox" name="get_money" value="1"<?=$cb?>>
                    <input type="hidden" name="uu" value="<?=$_GET["uu"]?>">
                    以銀行到帳日搜尋
                </div>
            </form>
                <!-- 已繳款 -->
                <div id="all_table">
                <table cellspacing="0" cellpadding="0" class="rwd-table tablesorter t_color ">
                    <thead>
                        <tr class="title_tr">
                            <th align="center" width="20%" style="text-align:center;"><?=$t1?></th>
                            <th align="center" style="text-align:center; color:#f00;" width="95">投資款</th>
                            <th align="center" style="text-align:center;" width="95">收回本金<br>(P)</th>
                            <th align="center" style="text-align:center;" width="95">收回利息<br>(I)</th>
                            <th align="center" style="text-align:center; color:#f00;" width="120">平台手續費<br>(F)</th>
                            <th align="center" style="text-align:center; color:#00f;" width="95">收回總金額<br>(P+I-F)</th>
                            <th align="center" style="text-align:center;" width="100">期數</th>
                            <th align="center" style="text-align:center;" width="117">收益明細</th>
                            <th align="center" style="text-align:center;" width="117"><?=$t2?></th>
                            <th align="center" style="text-align:center;">狀態</th>
                        </tr>
                        <tr class="">
                            <td class="tdd" colspan ="10" style="padding: unset !important;">
                                <div class="tdh">
                <table cellspacing="0" cellpadding="0" class="rwd-table tablesorter t_color ">
                    <tbody>
                    <tr class="nh" style="padding:unset !important">
                        <th class="nh" style="padding:unset !important" width="20%"></td>
                        <th class="nh" style="padding:unset !important" width="95"></td>
                        <th class="nh" style="padding:unset !important" width="95"></td>
                        <th class="nh" style="padding:unset !important" width="95"></td>
                        <th class="nh" style="padding:unset !important" width="120"></td>
                        <th class="nh" style="padding:unset !important" width="95"></td>
                        <th class="nh" style="padding:unset !important" width="100"></td>
                        <th class="nh" style="padding:unset !important" width="117"></td>
                        <th class="nh" style="padding:unset !important" width="117"></td>
                        <th class="nh" style="padding:unset !important"></td>
                    </tr>
                    <tr class="tender_document_detail" style="background-color:#d5e1ff;">
                            <td data-th="總計">
                                <span class="fcolor">總計</span>
                            </td>
                            <td class="bd-example-modal-lg" data-th="投資款">
                                <span class="fbold" id="sum_o" style="color:#f00;"></span>
                            </td>
                            <td class="bd-example-modal-lg" data-th="收回本金">
                                <span class="fbold" id="sum_a"></span>
                            </td>
                            <td class="bd-example-modal-lg" data-th="收回利息">
                                <span class="fbold" id="sum_r"></span>
                            </td>
                            <td class="bd-example-modal-lg" data-th="平台手續費">
                                <span class="fbold" id="sum_o2" style="color:#f00;"></span>
                            </td>
                            <td class="bd-example-modal-lg" data-th="收回總金額">
                                <span class="fbold" id="sum_t" style="color:#00f;"></span>
                            </td>
                            <td colspan ="4" id="all_n"></td>
                    </tr>
<?
    $c_type[0]="購買債權";
    $c_type[1]="還款本息";
    $c_type[3]="結清買回";
    $c_type[4]="逾期買回";
    $c_date= "";
    $n_out = 0;
    $n_out2 = 0;
    $n_int_m = 0;
    $n_int_r = 0;
    $n_int_t = 0;
    $line=0;
    $li_cnt = 1;
    $sum_o =0;
    $sum_o2 =0;
    $sum_a =0;
    $sum_r =0;
    $sum_t =0;
?>
                        @foreach ($i_bill as $v)
<?
if(($s_d_1 <= strtotime($v->b_date)) && ($s_d_2 >= strtotime($v->b_date)) ){
    $sum_o += $v->b_out;
    $sum_o2 += $v->b_out2;
    $sum_a += $v->b_int_m;
    $sum_r += $v->b_int_r;
    $sum_t += $v->b_int_t;
    if(strtotime($v->b_bank_date)>1535040000){ $b_d=date('Y-m-d',strtotime($v->b_bank_date));}else{ $b_d="-";}
    if($c_date == date('Y-m-d',strtotime($v->b_date))){
?>
                        <tr class="tender_document_detail line{{$line}}" style="display:none">
                            <td data-th="<?=$t1?>">
                                <span class="fcolor" height="54">{{ $c_date }}</span>
                            </td>
                            <td class="bd-example-modal-lg" data-th="投資款">
                                <span class="fbold" style="color:#f00;">{{number_format($v->b_out)}}</span>
                            </td>
                            <td class="bd-example-modal-lg" data-th="收回本金">
                                <span class="fbold">{{number_format($v->b_int_m)}}</span>
                            </td>
                            <td class="bd-example-modal-lg" data-th="收回利息">
                                <span class="fbold">{{number_format($v->b_int_r)}}</span>
                            </td>
                            <td class="bd-example-modal-lg" data-th="平台手續費">
                                <span class="fbold" style="color:#f00;">{{number_format($v->b_out2)}}</span>
                            </td>
                            <td class="bd-example-modal-lg" data-th="收回總金額">
                                <span class="fbold" style="color:#00f;">{{number_format($v->b_int_t)}}</span>
                            </td>
                            <td class="bd-example-modal-lg" data-th="期數">
                                <span class="fbold">{{$v->b_cnt}}</span>
                            </td>
                            <td data-th="收益明細">
                                <button type="button" class="btn no-btn-style btn_nobg loadbtn" name="1" onclick="tender_modal({{$v->b_id}},'{{$v->b_title}}')" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing Order">
                                    <i class="fa fa-eye dt3749" aria-hidden="true"></i>
                                </button>
                            </td>
                            <td class="bd-example-modal-lg" data-th="<?=$t2?>" >
                                <span class="fbold">{{$b_d}}</span>
                            </td>
                            <td class="bd-example-modal-lg" data-th="狀態">
                                <span class="fbold">{{$c_type[$v->b_type]}}</span>
                            </td>
                        </tr>
<?
            $n_out += $v->b_out;
            $n_out2 += $v->b_out2;
            $n_int_m += $v->b_int_m;
            $n_int_r += $v->b_int_r;
            $n_int_t += $v->b_int_t;
    }else{
         if($c_date <>""){
            echo "<script>
                document.getElementById('b_date".$line."').innerHTML = '".$c_date."';
                document.getElementById('b_out".$line."').innerHTML = '".number_format($n_out)."';
                document.getElementById('b_out2_".$line."').innerHTML = '".number_format($n_out2)."';
                document.getElementById('b_int_m".$line."').innerHTML = '".number_format($n_int_m)."';
                document.getElementById('b_int_r".$line."').innerHTML = '".number_format($n_int_r)."';
                document.getElementById('b_int_t".$line."').innerHTML = '".number_format($n_int_t)."';
            </script>";
        }
        $n_out = $v->b_out;
        $n_out2 = $v->b_out2;
        $n_int_m = $v->b_int_m;
        $n_int_r = $v->b_int_r;
        $n_int_t = $v->b_int_t;
        $c_date = date('Y-m-d',strtotime($v->b_date));
        $line++;
        if( $li_cnt ==1){
            $inli = "style=background-color:#e1fbde;";
            $li_cnt =2;
        }else{
            $inli = "style=background-color:#f1ffef;";
            $li_cnt =1;
        }
?>
                        <tr class="tender_document_detail" onclick="lin({{$line}})" {{$inli}}>
                            <td data-th="<?=$t1?>">
                                <span class="fcolor" id="b_date{{$line}}"></span>
                            </td>
                            <td class="bd-example-modal-lg" data-th="投資款">
                                <span class="fbold" id="b_out{{$line}}" style="color:#f00;"></span>
                            </td>
                            <td class="bd-example-modal-lg" data-th="收回本金">
                                <span class="fbold" id="b_int_m{{$line}}"></span>
                            </td>
                            <td class="bd-example-modal-lg" data-th="收回利息">
                                <span class="fbold" id="b_int_r{{$line}}"></span>
                            </td>
                            <td class="bd-example-modal-lg" data-th="平台手續費">
                                <span class="fbold" id="b_out2_{{$line}}" style="color:#f00;"></span>
                            </td>
                            <td class="bd-example-modal-lg" data-th="收回總金額">
                                <span class="fbold" id="b_int_t{{$line}}" style="color:#00f;"></span>
                            </td>
                            <td class="bd-example-modal-lg" data-th="狀態" colspan ="4">
                                <span class="fbold">總計(展開)</span>
                            </td>
                        </tr>
                        <tr class="tender_document_detail line{{$line}}" style="display:none">
                            <td data-th="<?=$t1?>">
                                <span class="fcolor" height="54">{{ $c_date }}</span>
                            </td>
                            <td class="bd-example-modal-lg" data-th="投資款">
                                <span class="fbold" style="color:#f00;">{{number_format($v->b_out)}}</span>
                            </td>
                            <td class="bd-example-modal-lg" data-th="收回本金">
                                <span class="fbold">{{number_format($v->b_int_m)}}</span>
                            </td>
                            <td class="bd-example-modal-lg" data-th="收回利息">
                                <span class="fbold">{{number_format($v->b_int_r)}}</span>
                            </td>
                            <td class="bd-example-modal-lg" data-th="平台手續費">
                                <span class="fbold" style="color:#f00;">{{number_format($v->b_out2)}}</span>
                            </td>
                            <td class="bd-example-modal-lg" data-th="收回總金額">
                                <span class="fbold" style="color:#00f;">{{number_format($v->b_int_t)}}</span>
                            </td>
                            <td class="bd-example-modal-lg" data-th="期數">
                                <span class="fbold">{{$v->b_cnt}}</span>
                            </td>
                            <td data-th="收益明細">
                                <button type="button" class="btn no-btn-style btn_nobg loadbtn" name="1" onclick="tender_modal({{$v->b_id}},'{{$v->b_title}}')" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing Order">
                                    <i class="fa fa-eye dt3749" aria-hidden="true"></i>
                                </button>
                            </td>
                            <td class="bd-example-modal-lg" data-th="<?=$t2?>">
                                <span class="fbold">{{$b_d}}</span>
                            </td>
                            <td class="bd-example-modal-lg" data-th="狀態">
                                <span class="fbold">{{$c_type[$v->b_type]}}</span>
                            </td>
                        </tr>
<?
    }
}
    if($c_date <>""){
        echo "<script>
            document.getElementById('b_date".$line."').innerHTML = '".$c_date."';
            document.getElementById('b_out".$line."').innerHTML = '".number_format($n_out)."';
            document.getElementById('b_out2_".$line."').innerHTML = '".number_format($n_out2)."';
            document.getElementById('b_int_m".$line."').innerHTML = '".number_format($n_int_m)."';
            document.getElementById('b_int_r".$line."').innerHTML = '".number_format($n_int_r)."';
            document.getElementById('b_int_t".$line."').innerHTML = '".number_format($n_int_t)."';
            document.getElementById('sum_o').innerHTML = '".number_format($sum_o)."';
            document.getElementById('sum_o2').innerHTML = '".number_format($sum_o2)."';
            document.getElementById('sum_a').innerHTML = '".number_format($sum_a)."';
            document.getElementById('sum_r').innerHTML = '".number_format($sum_r)."';
            document.getElementById('sum_t').innerHTML = '".number_format($sum_t)."';
        </script>";
    }
?>
                        @endforeach

                    </tbody>
                </table>
                                <div>
                            </td>
                        </tr>
                    </thead>
                </table>
                </div>
                <!-- 已未繳款 -->
            </div>
            <!-- 分頁 -->
            <nav aria-label="..." class="m-auto pd2070 page_n"></nav>
            <div class="form-group page_b page_ba"></div>
        </div>
    </div>
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
</div>
<div class="modal" id="exampleModalLong2"
        style="padding-right: 17px; background: rgba(0, 0, 0, 0.5);;overflow-y: scroll;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="mobg2">
                    <div class="modal-header">
                        債權憑證號：
                        <span id="t_id"></span>
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
</body>

</html>

<script>
function lin(x){
    $(".line"+x).toggle();
}
</script>

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
            url: "{{ url('/front/claim_category_counting') }}" + '?amount=' + am + '&c_id='+claim_id,
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

    function tender_modal(id,t_id) {
        gloid = id;
        btnloadingIcon(id, 'show');

        $("#detail_tbd").empty();
        $("#t_id").html(t_id);
        setModal(id);
    }

    $('.close_btn').click(function (e) {
        $('#exampleModalLong2').css('display', 'none');
    });

    function setModal(id) {
        $.ajax({
            url: "{{ url('/front/api/getRepaymentDetail2/') }}" + '/' + id + '/<?=$_GET["uu"]?>',
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
