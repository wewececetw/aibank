@extends('Front_End.layout.header') @section('content')
<?
    $l1=" onclick=window.location=&#39;/front/claim_category_history/".$line_id."/";
    $l2="&#39;";
    $rr[0]="先息後本";
    $rr[1]="本息攤還";
?>

{{-- <link rel="stylesheet" type="text/css" href="/css/dataTables.bootstrap4.min.css"> --}}
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.0.0/css/boxicons.min.css">

{{-- <script src="/js/jquery-3.3.1.min.js"></script> --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/jquery.dataTables.min.js"></script>
{{-- <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script> --}}
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>


<style>
    #claims_paginate{
        float: left;
        margin-left: -100px;
        padding:70px 0px;
    }

    .row{
        width: 100%;
        margin: 0px;
    }

    .col-sm-12{
        padding: 0px;
    }
    #page2{
        display: none;
    }
    .fa{
        display: inline-block;
        font: normal normal normal 14px/1 FontAwesome;
        font-size: inherit;
        text-rendering: auto;
        -webkit-font-smoothing: antialiased;
    }

    @media (max-width: 768px){

        #claims_paginate {
            margin: auto auto auto 15px;
        }
    }

    @media(max-width:650px){

        #claims{
            padding:5px;
        }

        #claims_paginate > ul.pagination > li {
            display:none;
        }

        #claims_paginate > ul.pagination > li:nth-child(1) ,#claims_paginate > ul.pagination > li:last-child {
            display:block !important;
        }
        #page1{
            display: none;
        }
        #page2{
            display:flex;
        }
    }
    #claims > tbody > tr > td ,.rwd-table th, .rwd-table td {
        text-align: center;
        vertical-align:middle;
    }
    .n_tr {
        background-color: #fff !important;
    }
    @media(max-width:480px){
        #claims > tbody > tr > td,.rwd-table th, .rwd-table td {
            padding: 0px;
            border:none;
            border-bottom: none !important;
            margin: .5em 1em !important;
            text-align:left !important;
            /* border-top: 1px solid #ddd; */
        }
        #claims > tbody > tr > td:before ,.rwd-table th, .rwd-table td:before{
            content: attr(data-th) ": ";
            font-weight: bold;
            width: 5em !important;
            display: inline-block;

        }
        #claims > tbody > tr,.rwd-table tr {
            border: 15px solid #ececec;
            background-color: #fff !important;
        }
        .n_tr {
            border: 15px solid #ececec;
        }
        .n_t_td{
            border:none !important;
        }
        .file_link { margin: 0 9px 15px 9px !important; }
    }
    #claims_wrapper{
        width: -webkit-fill-available;
    }

    .sorting:before{
        right: 5px;
    }
    .container{ padding:0px; }
</style>

@if (session('bank_check'))
    <script>
        swal("提示", "目前尚無銀行帳號！", "error")
    </script>
@endif

@if (session('banned_check'))
    <script>
        swal("提示", "帳號停權,無法投標！", "error")
    </script>
@endif


<div id="main-page">
    <link rel="stylesheet" media="screen" href="/table/css/table.css" />
    <link rel="stylesheet" media="screen" href="/css/modal.css" />
    <link rel="stylesheet" media="screen" href="/css/v.css" />
    <link rel="stylesheet" media="screen" href="/css/list.css" />
    <link rel="stylesheet" media="screen" href="/css/list_modal.css" />
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <div class="list_banner">
        <div class="container">
            <div class="row">
                <div class="animate-box png">
                    <div class="t-d" aos="fade-right" aos-duration="1000">
                        <h2>債權項目</h2>
                        <br/>
                        <p>
                            提供多種類型債權轉讓項目及投資周期選擇，資金運用有彈性，投資組合更豐富。
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="w100 top500 h115 m_none">
            <div class="container">
                <div class="row ">
                    <div class="col-md-4">
                        <div class="icon_left"><img src="/images/con1.png" alt=""></div>
                        <div class="icon_right">
                            <div class="f28">
                                {{ number_format($memberBenefits) }}
                            </div>
                            <div class="f15"> 會員收益</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="icon_left"><img src="/images/con2.png" alt=""></div>
                        <div class="icon_right">
                            <div class="f28">
                                {{ number_format($totalInvestAmount) }}
                            </div>
                            <div class="f15"> 投資總額</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="icon_left"><img src="/images/con3.png" alt=""></div>
                        <div class="icon_right">
                            <div class="f28">
                                {{ number_format($annualBenefitsRate,2) }} %
                            </div>
                            <div class="f15"> 年平均報酬</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        @if(count($errors) > 0)
                     <div class="alert alert-danger">
                        未登入<br><br>
                      <ul>
                       @foreach($errors->all() as $error)
                       <li>{{ $error }}</li>
                       @endforeach
                      </ul>
                     </div>
                    @endif

                    {{-- @if($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                     <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                    </div>
                    @endif --}}
        <div class="row taa">
            <div class="btn_bottom btn_bottom_a btn_20">
                <div class="btn_left">
                    <div class="btn_1 ">
                        <a href="/front/claim_category_special/1/9">
                        <i class="fa fa-bar-chart" aria-hidden="true"></i> 特別投資項目
                        </a>
                    </div>
                </div>
                <div class="btn_left">
                    <div class="btn_1 ">
                        <a href="/front/claim_category/1/9">
                            <i class="fa fa-align-left" aria-hidden="true"></i> 智能媒合項目
                        </a>
                    </div>
                </div>
                <div class="btn_left">
                    <div class="btn_1  w0 active_2">
                        <a href="/front/claim_category_history/1/108">
                        <i class="fa fa-book" aria-hidden="true"></i> 已完成投資項目
                        </a>
                    </div>
                </div>

            </div>

            <table id="claims" style="width:100%;" class="table table-striped table-bordered table table-striped table-bordered rwd-table tablesorter tablesorter-default " >
                <thead>
                <tr class="title_tr">
                        <th style="width:200px;text-align: center;" <?=$l1.$c_1.$l2?>><span>債權總類</span></th>
                        <!-- <th style="width:75px;text-align: center;" <?=$l1.$c_2.$l2?> ><span>風險等級</span></th> -->
                        <th style="width:112.5px;text-align: center;" <?=$l1.$c_3.$l2?> ><span>年化收益</span></th>
                        <th style="width:112px;text-align: center;" <?=$l1.$c_4.$l2?>><span>物件編號</span></th>
                        <th style="width:90px;text-align: center;" <?=$l1.$c_5.$l2?>><span>債權額度</span></th>
                        <th style="width:60px;text-align: center" <?=$l1.$c_6.$l2?>><span>期數</span></th>
                        <th style="width:90px;text-align: center;" ><span>剩餘金額</span></th>
                        <th style="width:112px;text-align: center;" <?=$l1.$c_8.$l2?>>開標日<span style="color: #a9a9a9;">▼</span></th>
                        <th style="width:140px;text-align: center;" <?=$l1.$c_9.$l2?>>認購進度<span style="color: #a9a9a9;">▼</span></th>
                        <th style="width:140px;text-align: center;" <?=$l1.$c_10.$l2?>><span>繳款進度</span></th>
                        <th style="width:112.5px;text-align: center;" ><span>還款方式</span></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($claims as $item)
                        <tr class="n_tr" onclick="category_modal({{ $item->claim_id }})">
                            <td class="n_t_td" data-th="債權總類">
                                <span class="fcolor">
                                    {{ $item->typing }}
                                </span>
                            </td>
                            {{-- <td data-th="風險等級" >
                                <span class="fcolor">
                                    {{ $item->pig_credit }}
                                </span>
                            </td> --}}
                            <td data-th="年化收益">
                                <span class="fcolor2 ">{{ $item->annual_interest_rate }} %</span>
                            </td>
                            <td data-th="物件編號">{{ $item->claim_number }}</td>
                            <td data-th="債權額度">
                                <span class="fbold">
                                    {{ number_format($item->staging_amount) }}
                                </span>
                            </td>
                            <td data-th="期數">{{ $item->remaining_periods }} 期</td>
                            <td data-th="剩餘金額">
                                <span class="fbold">
                                <?
                                        if(isset($rest[$item->claim_id])){
                                            $pro =  $rest[$item->claim_id];
                                            echo  number_format($pro);
                                        }
                                    ?>
                                </span>
                            </td>
                            <td data-th="開標日">
                                @php
                                    if(isset($item->start_collecting_at)){
                                        echo date('Y-m-d',strtotime($item->start_collecting_at));
                                    }else{
                                        echo'無';
                                    };
                                @endphp

                            </td>
                            <td data-th="認購進度">
                                <div class="progress ">
                                    <div class="progress-bar progress-barpp" role="progressbar" style="width: <? if(isset($item->buying)){ echo $item->buying;}else{ echo '0'; }
                                    ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                        <?
                                            if(isset($item->buying)){
                                                echo floor($item->buying).'％';
                                            }else{
                                                echo '0%';
                                            }
                                        ?>
                                    </div>
                                </div>
                            </td>
                            <td data-th="繳款進度">
                                <div class="progress ">
                                    <div class="progress-bar progress-barpp2" role="progressbar" style="width: <?php if(isset($item->om)){$pro = $item->om; echo $pro;}else{ echo '0'; }
                                        ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                        <?php
                                        if(isset($item->om)){
                                            $pro = $item->om;
                                            echo  floor($pro).'％';
                                        }else{
                                            echo '0%';
                                        }
                                    ?>
                                    </div>
                                </div>
                            </td>
                            <td data-th="還款方式">{{ $rr[$item->repayment_method] }}</td>
                        </tr>

                    @endforeach

                </tbody>
            </table>
        <!-- 分頁 -->

        </nav>
        <div style="padding: 70px 0px;margin: 0 auto;">
            <ul class="pagination" id='page1'>
                <li class="paginate_button page-item previous {{$pre}}">
                    <a href="{{$pl}}" aria-controls="claims" data-dt-idx="0" tabindex="0" class="page-link">上一頁</a>
                </li>

                <li class="paginate_button page-item <? if($line_id==1){ ?>active<? }?>">
                    <a href="/front/claim_category_history/1/{{$c_t}}" aria-controls="claims" data-dt-idx="1" tabindex="0" class="page-link">1</a>
                </li>
<?
if($all_page>5){
        $ll = $line_id -3;
        if($all_page > $line_id +3){
            $i = $line_id +3;
        }else{
            $i = $all_page -1;
        }

        if($line_id >5){
            ?><li class="paginate_button page-item"><a href="#" aria-controls="claims" data-dt-idx="3" tabindex="0" class="page-link">...</a></li><?
        }
        for($ll;$ll<=$i;$ll++){
            if($ll > 1){
                ?><li class="paginate_button page-item <? if($ll==$line_id){ ?>active<? }?>">
                    <a href="/front/claim_category_history/{{$ll}}/{{$c_t}}" aria-controls="claims" data-dt-idx="{{$ll}}" tabindex="0" class="page-link">{{$ll}}</a>
                </li><?
            }
        }
        if($i < $all_page -1){
                ?><li class="paginate_button page-item"><a href="#" aria-controls="claims" data-dt-idx="3" tabindex="0" class="page-link">...</a></li><?
        }
}else{
    for($ll=2;$ll<=$all_page-1;$ll++){
?>
                <li class="paginate_button page-item <? if($ll==$line_id){ ?>active<? }?>">
                    <a href="/front/claim_category_history/{{$ll}}/{{$c_t}}" aria-controls="claims" data-dt-idx="{{$ll}}" tabindex="0" class="page-link">{{$ll}}</a>
                </li>
<?
    }
}
if($all_page>1){
?>
                <li class="paginate_button page-item <? if($ll==$line_id){ ?>active<? }?>">
                    <a href="/front/claim_category_history/{{$all_page}}/{{$c_t}}" aria-controls="claims" data-dt-idx="{{$all_page}}" tabindex="0" class="page-link">{{$all_page}}</a>
                </li>
<? }?>
                <li class="paginate_button page-item next {{$nex}}">
                    <a href="{{$nl}}" aria-controls="claims" data-dt-idx="3" tabindex="0" class="page-link">下一頁</a>
                </li>

            </ul>
            <ul class="pagination" id='page2'>
                <li class="paginate_button page-item <? if($line_id==1){ ?>active<? }?>">
                    <a href="/front/claim_category_history/1/{{$c_t}}" aria-controls="claims" data-dt-idx="1" tabindex="0" class="page-link">第一頁</a>
                </li>

                <li class="paginate_button page-item previous {{$pre}}">
                    <a href="{{$pl}}" aria-controls="claims" data-dt-idx="0" tabindex="0" class="page-link"><i class='fa fa-caret-left'></i> 上一頁</a>
                </li>

                <li class="paginate_button page-item next {{$nex}}">
                    <a href="{{$nl}}" aria-controls="claims" data-dt-idx="3" tabindex="0" class="page-link">下一頁 <i class='fa fa-caret-right'></i></a>
                </li>

                <li class="paginate_button page-item <? if($ll==$line_id){ ?>active<? }?>">
                    <a href="/front/claim_category_history/{{$all_page}}/{{$c_t}}" aria-controls="claims" data-dt-idx="{{$all_page}}" tabindex="0" class="page-link">最末頁</a>
                </li>            
            </ul>   
        </div>

    </div>
</div>


<!-- modal -->
<div class="modal fade show" id="c"  style="padding-right: 17px;background: rgba(0, 0, 0, 0.5);;overflow-y: scroll;display:none">

</div>
<script type="text/javascript">
    function category_modal(target){
        $.ajax({
            type:"POST",
            url:"/front/get_claims_history_html/"+target,
            dataType:"json",
            data:{
                id:target,
            }
            ,
            success:function(data){
                if(data.success){
                    $('#c').html(data._claims_html);
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
