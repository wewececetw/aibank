
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="mobg2">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="claim_detail">
                    <style>
                        .warning-text {
                            text-align: center;
                            color: red;
                        }

                        .favorite_star {
                            display: inline-block;
                            margin-bottom: 10px;
                            margin-right: 5px;
                        }

                        .file_link{
                            text-align: center;
                            display: inline-block;
                            height: 43px;
                            background-color: #f8f8f8;
                            font-size: 14px;
                            color: #6e6e6e;
                            border: solid 1px #eee;
                            margin:0 3.75px 15px 3.75px;
                            padding:0;
                            float:left;
                        }
                        .file_link img{
                            height:150px;
                            width:100px;
                        }
                        @media (max-width: 768px)
                        {
                            .td_co img{
                                height: unset !important;
                                width: 95% !important;
                            }
                        }
                    </style>
                    <div class="container">
                        <div class="row taa">
                            <div class="col-md-12 pd0">
                                <div class=" bg_color2">
                                    <div class="bg_all">
                                        <div class="list_t">
                                            <img class="favorite_star" src="/images/unfavorited.png" alt="">
                                            <span class="translation_missing" title="">{{ $row->typing }}</span> {{ $row->claim_number }}
                                        </div>
                                        <div class="list_tt2">
                                             {{-- ＃send_tender js判斷有無登入 onclick="send_tender_button(); --}}

                                            @if($row->getOriginal('claim_state') == 2 || $row->getOriginal('claim_state') == 4)

                                                <a id="send_tender" href="#" style="cursor: default;">
                                                    <div class="btbt5 "> <i class="fa fa-bars" aria-hidden="true"></i> 還款中
                                                    </div>
                                                </a>

                                            @elseif($row->getOriginal('claim_state') == 3 || $row->getOriginal('claim_state') == 5 || $row->getOriginal('claim_state') == 6)

                                                <a id="send_tender" href="#" style="cursor: default;">
                                                    <div class="btbt5 "> <i class="fa fa-bars" aria-hidden="true"></i> 已結案
                                                    </div>
                                                </a>

                                            @endif

                                            


                                            {{-- <a href="#calculation" id="calculation_link">
                                                <div class="btbt6"><i class="fa fa-table" aria-hidden="true"></i> 投資試算 </div>
                                            </a> --}}
                                        </div>
                                        <!-- lightbox -->
                                        <div class="lightbox fancy" id="calculation">
                                            <div id="pending"></div>
                                            <div>
                                                <div class="">
                                                    <div class="panel-heading">
                                                        <h3 class="panel-title calc-title rel"></h3>
                                                    </div>
                                                    <div class="panel-body p-0">
                                                        <div class="calc-bd-tabs jCalcBdTabs">
                                                            <div class="cal-bd-tab jCalBdTab">
                                                                <div class="row mt-15">
                                                                    <div class="col-md-12">
                                                                        <input type="text" id="c_id" value="{{$row->claim_id}}" hidden>
                                                                        <div class="col-xs-4 calc-label">投資金額</div>
                                                                        <div class="col-xs-8">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control" style="width: 125px;" id="investment_amount" placeholder="">
                                                                                <div class="input-group-addon calc-addon">元</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 col-sm-12 mt-md-10  mt-sm-10  mt-xs-10 col-xs-12">
                                                                        <div class="col-xs-4 calc-label">年利率</div>
                                                                        <div class="col-xs-8">
                                                                            <div class="input-group">
                                                                                <input type="text" name="nhlv" id="nhlv" class="form-control" value="{{ $row->annual_interest_rate}}%" readonly="">
                                                                                <div class="input-group-addon calc-addon">%</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 col-sm-12 mt-10">
                                                                        <div class="col-xs-4 calc-label">期數</div>
                                                                        <div class="col-xs-8">
                                                                            <div class="input-group">
                                                                                <input type="text" name="nyy" id="jkqx" class="form-control" style="width: 81px;" value="{{ $row->remaining_periods }}期" readonly="">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="row mt-15">
                                                                    <div class="col-md-12 tc" style="margin-top:-20px;margin-bottom: 20px;">
                                                                        <div class="col-xs-6 tc" style="text-align: center;">
                                                                            <button id="count_btn" class="sub1">計算</button>
                                                                        </div>
                                                                        <div class="col-xs-6 tc" style="text-align: center;">
                                                                            <input type="button" value="清除" class="reset" id="btn-reset" onclick="clearCountTable();">
                                                                            <span id="expect-profit"></span>
                                                                        </div>
                                                                    </div>
                                                                    <!-- <div class="col-md-12" style="margin-top: 10px;;">
                                                                        <div class="col-md-6">
                                                                        <span class="spanfont">投資金額： </span><span class="spanje" id="tzjexs"></span><span class="spanfont"> 元</span>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                        <span class="spanfont">貸款期數：</span><span class="spanje" id="tzqxxs"></span><span class="spanfont"> 期</span>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                        <span class="spanfont">利息收益： </span><span class="spanje" id="lxsy"></span><span class="spanfont"> 元</span>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                        <span class="spanfont">本息合計：</span><span class="spanje" id="bxhj"></span><span class="spanfont"> 元</span>
                                                                        </div>
                                                                    </div> -->
                                                                </div>
                                                            </div>
                                                            <div class="cal-bd-tab hidden jCalBdTab">
                                                            </div>
                                                        </div>
                                                        <div class="calc-tps mt-20 text-center"><strong></strong></div>
                                                        <br>
                                                        <div class="table-responsive"></div>
                                                        <div id="bxmx" style="overflow:auto; height: 120vh">
                                                            <table class="table table-striped table-hover carl-record" id="repayplan">
                                                                <tbody>
                                                                    <tr style="height: 40px;" align="center">
                                                                        <th width="16%">期數</th>
                                                                        <th width="28%">每期回收</th>
                                                                        <th width="28%">本金</th>
                                                                        <th width="28%">利潤</th>
                                                                    </tr>
                                                                </tbody>
                                                                <tbody id="appendTag" style="display: table-row-group;text-align:center" class="appendTag">
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="#pending" style="position: absolute; right: 10px; top: 10px; color: #000"><i class="fa fa-times" aria-hidden="true"></i></a>
                                        </div>
                                        <!-- lightbox -->
                                    </div>
                                    <div class="bg_a">
                                        <div class="money_item4">
                                            <div><span class="list_1">債權出讓人</span> </div>
                                            <div><span class="lsit_name">{{ $row->debtor_transferor }}</span> </div>
                                        </div>
                                        <div class="money_item">
                                            <div><span class="list_1">本次債權讓與額度</span> </div>
                                            <div>
                                                <span class="list_2"> {{ $row->staging_amount }}</span>元
                                            </div>
                                        </div>
                                        <div class="money_item2">
                                            <div><span class="list_1">債權總期數</span></div>
                                            <div><span class="list_5">{{ $row->remaining_periods }}期</span></div>
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
                                            <div><span class="list_1"><span class="item_data2">上架日期</span> <span class="item_data">
                                                @php
                                                    if(isset($row->launched_at)){
                                                        echo date('Y-m-d',strtotime($row->launched_at));
                                                    }else{
                                                        echo'無';
                                                    };
                                                @endphp
                                            </span> </span>
                                            </div>
                                            <div><span class="list_1  "><span class="item_data2">預計結標日</span> <span class="item_data">
                                                @php
                                                    if(isset($row->estimated_close_date)){
                                                        echo date('Y-m-d',strtotime($row->estimated_close_date));
                                                    }else{
                                                        echo'無';
                                                    };
                                                @endphp

                                            </span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg_b">
                                        <div class="pro_b">
                                            <div class="pro">
                                                <div class="list_3">認購進度</div>

                                               <div class="progress">
                                                    <div class="progress-bar progress-barpp" role="progressbar" style="width: <?php if(isset($progress[$row->claim_id])){$pro = $progress[$row->claim_id]; echo $pro;}else{ echo '0'; }
                                                        ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">

                                                        <?php
                                                            if(isset($progress[$row->claim_id])){
                                                                $pro = $progress[$row->claim_id];
                                                                echo floor($pro).'％';
                                                            }else{
                                                                echo '0%';
                                                            }
                                                        ?>
                                                    </div>
                                                </div>

                                                <div class="both"></div>
                                            </div>
                                            <div class="pro2">
                                                <div class="list_3">繳款進度</div>
                                                <div class="progress">
                                                    <div class="progress-bar progress-barpp2" role="progressbar" style="width: <?php if(isset($pay[$row->claim_id])){$pro = $pay[$row->claim_id]; echo $pro;}else{ echo '0'; }
                                                        ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                        <?php
                                                        if(isset($pay[$row->claim_id])){
                                                            $pro = $pay[$row->claim_id];
                                                            echo floor($pro).'％';
                                                        }else{
                                                            echo '0%';
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="both"></div>
                                </div>
                            </div>
                            <div class="col-md-12 pd0">
                                <div class=" bg_color3">
                                    <div class="bg_d">
                                        <div class="td_title ">
                                            申貸資訊
                                        </div>
                                        <div class="list_table list_table_od row">
                                            <div class="td-2 td_a">債權類型</div>
                                            <div class="td-2">
                                                {{ $row->loan_type }}
                                            </div>

                                            <div class="td-2 td_a">還款方式</div>
                                            <div class="td-2">{{ $row->repayment_method }}</div>
                                            <div class="td-2 td_a">總投人數*</div>
                                            <div class="td-2">{{ $tenders_count }}</div>
                                            <div class="td-2 td_a">關注次數</div>
                                            <div class="td-2">{{ $row->attention_times }}</div>
                                            <div class="td-2 td_a">約定買回方</div>
                                            <div class="td-2">{{ $row->agreement_buyer }}</div>
                                            <div class="td-2 td_a">買回條款</div>
                                            <div class="td-2">{{ $row->agreement_buyer_clause }}</div>
                                        </div>
                                        <div class="td_title ">
                                            債權介紹
                                        </div>
                                        <div class="td_co">
                                            {{-- {!! $row->description !!} --}}
                                            @if(strtotime($row->created_at)<=strtotime('2020-11-13 12:30:00'))
                                            {!! nl2br($row->description) !!} 
                                            @else
                                            <?php echo($row->description); ?>
                                            @endif
                                            {{-- <p><span style="color: rgb(184, 49, 47);">【抵押權硬卡登記說明】*:&nbsp;</span></p>
                                            <p>係根據借款合同及抵押權合同，由借款人土地於硬卡上登記設定給出借人，借款額為200萬美元，土地抵押號碼1384。 本抵押權相關擔保權利將隨債權移轉依比例轉予各投資人。&nbsp;</p>
                                            <p><span style="color: rgb(184, 49, 47);">【債權上架說明】*:&nbsp;</span></p>
                                            <p>此筆債權第六次融資，上架金額新台幣500萬元，年利率9%，結標日預計為2019/12/25，得標者需於2019/12/27前將得標款匯入投資人的專屬帳號，配息日為每月28號。&nbsp;</p>
                                            <p><span style="color: rgb(184, 49, 47);">【豬豬推手回饋】:&nbsp;</span></p>
                                            <p>每月回饋=被推薦人投資本債權每月月底投資餘額*年利率 {{ $row->commission_interest_rate*100 }}% /12。</p> --}}
                                        </div>

                                        <div class="td_title ">
                                            原始債權基本資料
                                        </div>

                                        @if(Auth::check())
                                            <div class="list_table row">
                                                <div class="td-2 td_a">貸款人</div>

                                                <div class="td-2">

                                                    @php
                                                        $str = $row->borrower ;
                                                        $arr = mb_str_split($str);

                                                        if(!isset($arr[0])){
                                                            $arr[0] = '無';
                                                            print_r($arr[0]);
                                                        }else{
                                                            print_r($arr[0].'**');
                                                        }

                                                    @endphp

                                                </div>

                                                <div class="td-2 td_a">身分證字號</div>

                                                <div class="td-2">
                                                    @php
                                                        $str = $row->id_number  ;
                                                        $arr = mb_str_split($str);

                                                        if(count($arr) < 10){
                                                            //小於10碼的身分證
                                                        }else{
                                                            if(!isset($arr[0])){
                                                                $arr[0] = '無';
                                                                print_r($arr[0]);
                                                            }else{
                                                                print_r($arr[0].$arr[1].$arr[2].'******'.$arr[9]);
                                                            }
                                                        }


                                                    @endphp
                                                </div>

                                                <div class="td-2 td_a">性別</div>
                                                <div class="td-2">{{ $row->gender }}</div>
                                                <div class="td-2 td_a">年齡</div>
                                                <div class="td-2">{{ $row->age}}</div>
                                                <div class="td-2 td_a">學歷</div>
                                                <div class="td-2">{{ $row->education }}</div>
                                                <div class="td-2 td_a">婚姻狀況</div>
                                                <div class="td-2">{{ $row->marital_state }}</div>
                                                <div class="td-2 td_a">居住地</div>
                                                <div class="td-2">{{ $row->place_of_residence }}</div>
                                                <div class="td-2 td_a">居住狀況</div>
                                                <div class="td-2">{{ $row->living_state }}</div>
                                                <div class="td-2 td_a">行業別</div>
                                                <div class="td-2">{{ $row->industry }}</div>
                                                <div class="td-2 td_a">職稱</div>
                                                <div class="td-2">{{ $row->job_title }}</div>
                                                <div class="td-2 td_a">年資</div>
                                                <div class="td-2">{{ $row->seniority }}</div>
                                                <div class="td-2 td_a">月薪</div>
                                                <div class="td-2"> {{ $row->monthly_salary }}</div>
                                                <div class="td-2 td_a">原始債權總金額</div>
                                                <div class="td-2"> {{ $row->original_claim_amount }}</div>
                                                <div class="td-2 td_a">原始債權總期數</div>
                                                <div class="td-2">{{ $row->periods }}</div>
                                                <div class="td-2 td_a">連帶保證人</div>
                                                <div class="td-2">{{ $row->guarantor }}</div>
                                                <div class="td-2 td_a">備註</div>
                                                <div class="td-2">{{ $row->note }}</div>
                                            </div>
                                        @else
                                            <div class="warning-text">
                                                請<a href="/users/sign_in">登入</a>會員後，方能查看
                                            </div>
                                        @endif


                                        <div class="td_title ">
                                            貸款信用狀況
                                        </div>

                                        @if(Auth::check())
                                            <div class="list_table row">
                                                <div class="td-2 td_a">豬豬信用</div>
                                                <div class="td-2">{{ $row->pig_credit }}</div>
                                                <div class="td-2 td_a">有效身分證</div>
                                                <div class="td-2">{{ $row->id_number_effective }}</div>
                                                <div class="td-2 td_a">同業黑名單：</div>
                                                <div class="td-2">{{ $row->peer_blacklist }}</div>
                                                <div class="td-2 td_a">更生清算戶：</div>
                                                <div class="td-2">{{ $row->rehabilitated_settlement }}</div>
                                                <div class="td-2 td_a">票信狀況</div>
                                                <div class="td-2">{{ $row->ticket_state }}</div>
                                                <div class="td-2 td_a">重大交通罰款</div>
                                                <div class="td-2">{{ $row->major_traffic_fines }}</div>
                                                <div class="td-2 td_a">一年內同業查詢次數</div>
                                                <div class="td-2 last_c">{{ $row->peer_query_count}}</div>
                                            </div>
                                        @else
                                            <div class="warning-text">
                                                請<a href="/users/sign_in">登入</a>會員後，方能查看
                                            </div>
                                        @endif


                                        <div class="td_title ">
                                            債權文件
                                        </div>

                                        @if(Auth::check())
                                            <div style="padding: 20px;text-align: center;">

                                                @if(count($files) == 0)
                                                    目前暫無文件
                                                @else
                                                    @foreach ($files as $item)
                                                    <a class="file_link" target="blank" href='{{ url("/$item->file_path") }}' style="height: 150px;">
                                                        <img src="{{ url("/$item->file_path") }}" alt="文件消失了">
                                                    </a>
                                                        {{-- <a class="file_link" target="blank" href="{{ url($item->file_path) }}">{{ $item->file_name }}</a> --}}
                                                    @endforeach
                                                @endif

                                            </div>
                                        @else
                                            <div class="warning-text">
                                                請<a href="/users/sign_in">登入</a>會員後，方能查看
                                            </div>
                                        @endif

                                    </div>
                                    <div class="both"></div>
                                </div>
                            </div>
                            <div class="col-md-12 pd0">
                                <div class=" bg_color3 ovt" style="height: unset;">
                                    <div class="bg_d">
                                        <div class="td_title" style="background-color: #feaa11;">
                                            購買記錄
                                        </div>

                                        @if(Auth::check())
                                            <table cellspacing="0" cellpadding="0" class="rwd-table ">
                                                <thead>
                                                <tr class="title_tr">
                                                    <th><span>投標人</span></th>
                                                    <th><span>金額</span></th>
                                                    <th><span>投標時間</span></th>
                                                    <th><span>繳款時間</span></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @if(Auth::check())
                                                    @foreach ($tenders as $tender)
                                                        <tr class="n_tr">
                                                            <td class="n_t_td" data-th="投標人">
                                                            <span class="fcolor2 ">
                                                                <?php
                                                                if(isset($tender->tenders_user->email)){
                                                                //echo $tender->tenders_user->email;
                                                                    $warr = explode("@", $tender->tenders_user->email);
                                                                    $w1 = strlen($warr[1])-1;
                                                                    $w0 = strlen($warr[0])-1;
                                                                    echo substr($tender->tenders_user->email, 0,1);
                                                                    for($i=0;$i<$w0;$i++){ echo "*";}
                                                                    echo "@";
                                                                    for($i=0;$i<$w1;$i++){ echo "*";}
                                                                    echo substr($tender->tenders_user->email, -1);
                                                                }
?>
                                                            </span>
                                                            </td>

                                                            <td data-th="金額">
                                                            <span class="fbold">
                                                                {{ $tender->amount }}
                                                            </span>
                                                            </td>
                                                            <td data-th="投標時間">
                                                            <span class="fbold">
                                                                {{ date('Y-m-d H:i:s',strtotime($tender->created_at ))}}
                                                            </span>
                                                            </td>
                                                            <td data-th="繳款時間">
                                                            <span class="fbold">
                                                            @if(!isset($tender->paid_at))
                                                            未繳款
                                                            @else
                                                                {{ date('Y-m-d H:i:s',strtotime($tender->paid_at)) }}
                                                                @endif
                                                            </span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    @else
                                                            <div class="warning-text">
                                                                請<a href="/users/sign_in">登入</a>會員後，方能查看
                                                            </div>
                                                    @endif
                                                </tbody>
                                            </table>
                                        @else
                                            <div class="warning-text">
                                                請<a href="/users/sign_in">登入</a>會員後，方能查看
                                            </div>
                                        @endif

                                    </div>
                                    <div class="both"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
        </div>
    </div>
</div>

<script>
        /**edit by J start
     * 計算 按鈕點擊事件**/
     $("#count_btn").click(function () {
        let params = getParamsUrl();
        if (!params) {} else {
            clearCountTable();

            call_counting_api(params);
        }
    });
    //組合API參數
    function getParamsUrl() {
        let amount = $("#investment_amount").val();
        let c_id = $("#c_id").val();
        if (!amount || amount == '') {
            alert('請輸入投資金額後再進行計算');
            return false;
        } else if (amount < 0 || amount == '-0') {
            alert('投資金額不能為負數');
            return false;
        } else {
            return `?amount=${amount}&c_id=${c_id}`;
        }
    }
    //呼叫計算的API
    function call_counting_api(params) {
        $.ajax({
            url: "{{ url('/front/claim_category_counting') }}" + encodeURI(params),
            type: 'get',
            success: function (res) {
                // $("#appendTag")
                if (res.status == 'success') {
                    showCountingTable(res.data);
                } else {
                    showError();
                }
            },
            error: function (e) {
                console.log(e);
                showError();
            }
        })
    }
    //處理資料並長出table
    function showCountingTable(d) {
        let thtml = '';
        let x = 0,
            xlen = d.everyMonthPrincipal.length;
        for (x; x < xlen; x++) {
            let td = `
                <td>${x+1}</td>
                <td>${d.everyMonthPaidTotal[x]}元</td>
                <td>${d.everyMonthPrincipal[x]}元</td>
                <td>${d.everyMonthInterest[x]}元</td>
            `;
            let tr = `<tr>${td}</tr>`;
            thtml += tr;
        }
        thtml += `<tr>
                <td>總計:</td>
                <td>${toThousands(d.PaidTotalSum)}元</td>
                <td>${toThousands(d.PrincipallSum)}元</td>
                <td>${toThousands(d.InterestSum)}元</td>
            </tr>`;

        $("#appendTag").append(thtml);
    }
    //千分位
    function toThousands(num) {
        var num = (num || 0).toString(),
            result = '';
        while (num.length > 3) {
            result = ',' + num.slice(-3) + result;
            num = num.slice(0, num.length - 3);
        }
        if (num) {
            result = num + result;
        }
        return result;
    }

    function clearCountTable() {
        $("#appendTag").empty();
    }

    function showError() {
        alert('發生錯誤!請稍後再試');
    }

</script>
