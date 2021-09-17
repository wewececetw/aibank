@extends('Front_End.layout.header')
@section('content')

<div id="main-page">
    <link rel="stylesheet" media="screen" href="{{asset('/table/css/table.css')}}" />
    <link rel="stylesheet" media="screen" href="{{asset('/css/list.css')}}" />
    <link rel="stylesheet" media="screen" href="{{asset('/css/list_modal.css')}}" />
    <link rel="stylesheet" media="screen" href="{{asset('/css/modal.css')}}" />
    <link rel="stylesheet" media="screen" href="{{asset('/css/claim.css')}}" />
    <link rel="stylesheet" media="screen" href="{{asset('/css/sliderbar.css')}}" />
    <link rel="stylesheet" media="screen" href="{{asset('/css/v.css')}}" />
    <link rel="stylesheet" media="screen" href="{{asset('/css/main.css')}}" />
    <link rel="stylesheet" media="screen" href="{{asset('/css/jquery.dataTables.min.css')}}" />
    <link rel="stylesheet" media="screen"
        href="{{asset('/assets/front/match-ab00adde9a2208fa12a33b86a261b34d9ea621b0ceed421ed9fd13204e088bb4.css')}}" />
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker3.min.css"> -->

    <style>
        .hideloading {
            display: none;
        }

        #submitBtn {
            display: none;
        }
        #larbar_type1,#larbar_type2,#larbar_type3,#larbar_type4,#larbar_type5{
            display: none;
        }
        #labarchange{
            width: 135%;
        }
        @media screen and (max-width: 1024px){
            #labarchange{
                width: 100%;
            }
        }
    </style>
    <div class="container-fluid none" id="loadingBlock">
        <div class="row" style="margin-top:15%">
            <div class="col-md-12  text-center">
                <div class="loader">
                    <div class="loader-inner box1"></div>
                    <div class="loader-inner box2"></div>
                    <div class="loader-inner box3"></div>
                    <div class="loader-inner box4"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="loadingText">豬豬在線努力中</h1>
                <h2 class="loadingText" id="loadText">
                    Loading ...
                </h2>
            </div>
        </div>
    </div>

    <div class="list_banner">
        <div class="container">
            <div class="row">
                <div class="animate-box png">
                    <div class="t-d">
                        <div class="baright">
                            <h2>智能媒合</h2>
                            <br />
                            <p>
                                根據投資人的風險屬性選擇，自動媒合相對應的投資組合，快速進行投資媒合．全台唯一具備專業團隊及金融科技技術可以對轉讓債權進行A-Card申請信用評分及B-Card繳款行為信用評分
                            </p>
                        </div>
                        <div class="match_text">
                            <div class="banner_img"><img src="/images/m1.png" alt=""></div>
                            <div class="banner_img_text"> Step 1
                                <br> <span class="img_text">輸入欲投資金額</span>
                            </div>
                        </div>
                        <div class="match_text ableft300">
                            <div class="banner_img"><img src="/images/m2.png" alt=""></div>
                            <div class="banner_img_text"> Step 2
                                <br> <span class="img_text">選擇智能分組和調整投入比例</span>
                            </div>
                        </div>
                        <div class="match_text ableft600">
                            <div class="banner_img"><img src="/images/m3.png" alt=""></div>
                            <div class="banner_img_text"> Step 3
                                <br> <span class="img_text">開始試算</span>
                            </div>
                        </div>
                        <div class="match_text ableft900">
                            <div class="banner_img"><img src="/images/m4.png" alt=""></div>
                            <div class="banner_img_text"> Step 4
                                <br> <span class="img_text">智能媒合</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class=" h500 ">
        <div class="container  pd40">
            <!-- 更換智能媒合modal -->
            <div class="row taa">
                <div class="col-12 col-padding">
                    <div class="col-md-4 col-6 match-col-style"><span class="f20"><img src="/images/cl1.png" alt=""
                                class="pr5">本周期可投資金額</span> </div>
                    <div class="col-md-8 col-6 match-col-style">
                        <div class="form-group">
                            <div id="investment_limitation" class="modal-col-1" style="font-size:1.5rem; color:red;">
                                500
                            </div>
                            <div class="pf15"><span class="pf15" style="font-size: 20px; color: #00c1de;">萬元整</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-padding">
                    <div class="col-md-4 col-12 match-col-style"><span class="f20"><img src="/images/cl1.png" alt=""
                                class="pr5"> 輸入欲投資金額</span> </div>
                    <div class="col-md-8 col-12 match-col-style">
                        <div class="form-group">
                            <div class="modal-col-1">
                                <input id="input_amount" type="number" class="input_style form-control" min="1" step="1"
                                    value="1" pattern="[\d]{9}" placeholder="請填入整數" />
                            </div>
                        </div>
                        <div class="pf15"><span class="pf15"
                                style="font-size: 20px; color: #00c1de; margin-left: 10px;">萬元整</span> 最小投資金額為1萬元</div>
                    </div>
                </div>
                <div class="col-12 col-padding">
                    <div class="col-md-4 col-12 match-col-style">
                        <span class="f20"><img src="/images/cl2.png" alt="" class="pr5"> 選擇智能分組和調整投入比例</span>
                    </div>
                    <div class="col-md-8 col-12 match-col-style">
                        <div class="w70">
                            <form>
                                <div class="intelligent_block clearAfter current_block">
                                </div>
                            </form>
                        </div>
                        <div id='labarchange'  class="w30 bd-example-modal-lg" >
                            {{-- 穩重謹慎型 --}}
                                    <div class="modal-col-9" id="larbar_type1" style="margin-right: 25px;">
                                        <div class="proportion_block clearAfter">
                                            <div class="space_block"></div>
                                            <div class="slider_style_area">
                                                <span class="f12bb">穩重謹慎型</span>
                                                <div id="roi_id_1_2" disabled="true"></div>
                                                <div class="proportion_bar clearAfter">
                                                    <div class="pull-left">
                                                        <span>A：<span id="val_1_1_2"></span>%</span>
                                                    </div>
                                                    <div class="pull-right">
                                                        <span>B：<span id="val_1_2_2"></span>%</span>
                                                    </div>
                                                </div>
                                                <div class="space_block"></div>
                                            </div>
                                        </div>
                                    </div>
                                {{-- 積極進取型 --}}
                                    <div class="modal-col-9" id="larbar_type2" style="margin-right: 25px;">
                                        <div class="proportion_block clearAfter">
                                            <div class="space_block"></div>
                                            <div class="slider_style_area">
                                                <span class="f12bb">積極進取型</span>
                                                <div id="roi_id_2_2" disabled="true"></div>
                                                <div class="proportion_bar clearAfter">
                                                    <div class="slider-second-C second_bar" style="width: 40%;">C：<span id="val_2_1_2"></span>%
                                                    </div>
                                                    <div class="slider-second-D second_bar t-center" style="width: 30%;">D：<span
                                                            id="val_2_2_2"></span>%</div>
                                                    <div class="slider-second-E second_bar t-right" style="width: 30%;">E：<span
                                                            id="val_2_3_2"></span>%</div>
                                                </div>
                                            </div>
                                            <div class="space_block"></div>
                                        </div>
                                    </div>
                                {{-- 穩健平衡型 --}}
                                    <div class="modal-col-9" id="larbar_type3" style="margin-right: 25px;">
                                        <div class="proportion_block clearAfter">
                                            <div class="average_area">
                                                <span class="f12bb">穩健平衡型</span>
                                                <div class="average_block a-color"></div>
                                                <div class="average_block b-color"></div>
                                                <div class="average_block c-color"></div>
                                                <div class="average_block d-color"></div>
                                                <div class="average_block e-color"></div>
                                            </div>
                                            <div class="average_bar clearAfter">
                                                <div class="bar_block ">A：20%</div>
                                                <div class="bar_block ">B：20%</div>
                                                <div class="bar_block ">C：20%</div>
                                                <div class="bar_block ">D：20%</div>
                                                <div class="bar_block ">E：20%</div>
                                                <div class="clear"></div>
                                            </div>
                                        </div>
                                    </div>
                                {{-- 穩健積極型 --}}
                                    <div class="modal-col-9" id="larbar_type4" style="margin-right: 25px;">
                                        <div class="proportion_block clearAfter">
                                            <div class="slider_style_area">
                                                <span class="f12bb">穩健積極型</span>
                                                <div id="roi_id_4_2" disabled="true"></div>
                                                <div class="proportion_bar clearAfter">
                                                    <div class="pull-left">
                                                        <span id="slider-third-AB-span" class="slider-third-AB-label">A</span>：<span class="slider-third-AB"><span id="val_4_1_2"></span>%</span>
                                                    </div>
                                                    <div class="pull-right">
                                                        <span id="slider_third_CDE_span" class="slider-third-CDE-label">C</span>：<span class="slider-third-CDE"><span id="val_4_2_2"></span>%</span>
                                                    </div>
                                                </div>
                                            </div>
<? /*
                                            <div class="proportion_select left8" >
                                                <select class="form-control js-change-color" id="roi_id_4_left_select_2"
                                                    data-id="proportion-slider-third" data-target="first">
                                                    <option value="a-color">A</option>
                                                    <option value="b-color">B</option>
                                                </select>
                                            </div>
                                            <div class="proportion_select right right8 ">
                                                <select class="form-control js-change-color" id="roi_id_4_right_select_2"
                                                    data-id="proportion-slider-third" data-target="second">
                                                    <option value="c-color">C</option>
                                                    <option value="d-color">D</option>
                                                    <option value="e-color">E</option>
                                                </select>
                                            </div>
*/ ?>
                                        </div>
                                    </div>
                                {{-- 足智多謀型 --}}
                                    <div class="modal-col-9" id="larbar_type5" style="margin-right: 25px;">
                                        <div class="proportion_block clearAfter">
                                            <div class="slider_style_area">
                                                <span class="f12bb">足智多謀型</span>
                                                <div class="unique_area ">
                                                    <div id="unique_block" class="unique_block a-color h40">A：100%</div>
                                                </div>
                                            </div>
                                            <div class="proportion_select left8 p25">
<? /*
                                                <select class="form-control js-change-color" data-id="proportion-slider-forth"
                                                    id="roi_id_5_select_2">
                                                    <option value="a-color">A</option>
                                                    <option value="b-color">B</option>
                                                    <option value="c-color">C</option>
                                                    <option value="d-color">D</option>
                                                    <option value="e-color">E</option>
                                                </select>
*/ ?>
                                                </div>
                                        </div>
                                    </div>
                            <div><span data-toggle="modal" data-target="#ChangeIntelligentModal" id='larbarbtn' class="fbold btn16"><i class="fa fa-pie-chart" aria-hidden="true"></i>
                                    更換智能組合</span></div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-padding">
                    <div class="col-md-4 col-12 match-col-style">
                        <span class="f20"><img src="/images/cl3.png" alt="" class="pr5"> 期數</span>
                    </div>
                    <div class="col-md-8 col-12 match-col-style">
                        <div class="modal-col-4">
                            {{-- <div class="form-check">
                                <label class="form-check-label" for="input_period" style="font-size:16px;"> <span
                                        class="custom-checkbox" id="q1Yes">
                                        <input type="checkbox" class="input-period form-check-input"
                                            name="input_period[]" value="3" data-period="3">
                                        <span class="box">3 期</span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="input_period" style="font-size:16px;"> <span
                                        class="custom-checkbox" id="q1Yes">
                                        <input type="checkbox" class="input-period form-check-input"
                                            name="input_period[]" value="6" data-period="6">
                                        <span class="box">6 期</span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="input_period" style="font-size:16px;"> <span
                                        class="custom-checkbox" id="q1Yes">
                                        <input type="checkbox" class="input-period input-period-9 form-check-input"
                                            name="input_period[]" value="9" data-period="9">
                                        <span class="box">9 期</span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="input_period" style="font-size:16px;"> <span
                                        class="custom-checkbox" id="q1Yes">
                                        <input type="checkbox" class="input-period form-check-input"
                                            name="input_period[]" value="10" data-period="10">
                                        <span class="box">10 期</span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="input_period" style="font-size:16px;"> <span
                                        class="custom-checkbox" id="q1Yes">
                                        <input type="checkbox" class="input-period form-check-input"
                                            name="input_period[]" value="12" data-period="12">
                                        <span class="box">12 期</span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="input_period" style="font-size:16px;"> <span
                                        class="custom-checkbox" id="q1Yes">
                                        <input type="checkbox" class="input-period form-check-input"
                                            name="input_period[]" value="18" data-period="18">
                                        <span class="box">18 期</span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="input_period" style="font-size:16px;"> <span
                                        class="custom-checkbox" id="q1Yes">
                                        <input type="checkbox" class="input-period form-check-input"
                                            name="input_period[]" value="24" data-period="24">
                                        <span class="box">24 期</span>
                                    </span>
                                </label>
                            </div> --}}
                            <div class="form-check">
                                <label class="form-check-label" for="input_period" style="font-size:16px;"> <span
                                        class="custom-checkbox" id="q1Yes">
                                        <input type="radio" class="rad form-check-input input_period"
                                            name="input_period[]" value="<=6">
                                        <span class="box">&lt;=6 期</span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="input_period" style="font-size:16px;"> <span
                                        class="custom-checkbox" id="q1Yes">
                                        <input type="radio" class="rad form-check-input input_period"
                                            name="input_period[]" value="<=12">
                                        <span class="box">&lt;=12 期</span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="input_period" style="font-size:16px;"> <span
                                        class="custom-checkbox" id="q1Yes">
                                        <input type="radio" id="rad18" class="rad form-check-input input_period"
                                            name="input_period[]" value="<=18">
                                        <span class="box">&lt;=18 期</span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="input_period" style="font-size:16px;"> <span
                                        class="custom-checkbox" id="q1Yes">
                                        <input type="radio" id="rad24" class="rad form-check-input input_period"
                                            name="input_period[]" value="<=24">
                                        <span class="box">&lt;=24 期</span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="button" class="btn btn-primary" id="batch-selected" value="全選"
                                    style="width:95px;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-padding">
                    <div class="col-md-4 col-12 match-col-style"><span class="f20"><img src="/images/cl3.png" alt=""
                                class="pr5"> 開始試算</span> </div>
                    <div class="col-md-8 col-6 offset-md-0 offset-3 match-col-style">
                        <button id='trial_income_btn' class="start_btn no-btn-style" type="button">
                            <span class="fbold btn16">
                                <i class="fa fa-calculator" aria-hidden="true"></i>
                                開始試算
                                {{-- <i class="fas fa-circle-notch fa-spin" id="loading"></i> --}}
                            </span>

                        </button>
                    </div>
                </div>
                <div class="col-12 col-padding">
                    <div class="col-md-4 col-5 match-col-style" styl><span class="f20"><img src="/images/cl4.png" alt=""
                                class="pr5"> <span>實際投入金額</span> </span>
                    </div>
                    <div class="col-md-8 col-7 match-col-style">
                        <div class="">
                            <span class="f14 claim_left"> </span>
                            <div id='real-reward' class="f35 claim_left"> ? </div>
                            <div class="claim_left"> 元</div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-padding">
                    <div class="col-md-4 col-5 match-col-style"><span class="f20"><img src="/images/cl4.png" alt=""
                                class="pr5"> <span>預估收益(未扣除手續費)</span><div data-toggle="tooltip" style="cursor: pointer;display: inline-block;" onclick="show_explanation()">
                                    <span style="color: #00a5e4;">說明<span>
                                </div> </span>
                    </div>
                    <div class="col-md-8 col-7 match-col-style">
                        <div class="">
                            <div id='reward-benefit' class="f35 claim_left"> ? </div>
                            <div class="claim_left"> 元 </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 更換智能媒合modal -->
        <div class="modal fade change_intelligent_modal" id="ChangeIntelligentModal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="mobg2">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.href='/front/claim_match'">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @component('Front_End.user_manage.habit._habit_setting',[
                            'defaultSetting' => $defaultSetting,
                            'roi_id' => $roi_id,
                            'roiSetData' => $roiSetData
                            ])

                            @endcomponent

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success btn_modal" id="submitBtn2">儲存
                                <span id="loading" class="hideloading">
                                    <i class="fas fa-circle-notch fa-spin"></i>
                                </span>
                            </button>
                            <button type="button" class="btn btn-secondary btn_modal" data-dismiss="modal" onclick="window.location.href='/front/claim_match'">關閉</button>
                            {{-- <button type="button" class="btn btn_modal btn00c change_check"
                                data-dismiss="modal">確定</button> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pd40" style="background: #f7f7f7" id="tbl_block">
            <div class="container">
                <div class="row allre">
                    <div class="claim_table_area tabe-responsive">
                        <table id="claim-intelligent-table" cellspacing="0" cellpadding="0"
                            class="rwd-table tablesorter match-result-table">
                            <thead>
                                <tr class="title_tr">
                                    <th data-field="action" data-formatter="ActionFormatter" width="11%"><span class="an1"> 同意協議書</span></th>
                                    <th width=""><span>風險等級</span></th>
                                    <th width=""><span>年化收益</span></th>
                                    <th width=""><span>物件編號</span></th>
                                    <th width=""><span>債權額度</span></th>
                                    <th width=""><span>期數</span></th>
                                    <th width=""><span>剩餘金額</span></th>
                                    <th width="9%"><span>上架日期</span></th>
                                    <th width="9%"><span>預計結標日</span></th>
                                    <th width=""><span>認購進度</span></th>
                                    <th width=""><span>還款方式</span></th>
                                    <th width=""><span>投資金額</span></th>
                                    <th width=""><span>刪除</span></th>
                                </tr>
                            </thead>
                            <tbody id="resultTbl">

                            </tbody>
                        </table>
                    </div>
                    <div class="m-b-10" style="padding:10px;width:100%">
                        <label>
                            <input type="checkbox" id="isRead" class="check_all_agreement">
                            本人已詳閱所有"債權讓售協議書"與應注意事項，並同意且接受"協議書"及應注意事項所有條款無誤。
                        </label>
                    </div>
                    <div class="col-md-3 col-6">
                        <input id='buy_intelligent_claims' class="btn btn-block btn-info " disabled type="button"
                            value="確認購買">
                    </div>
                    <div class="col-md-3 col-6">
                        <button class="btn btn-block btn-secondary" onClick="window.history.back();">上一步</button>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- modal -->
    <div class="modal fade" id="exampleModalLong2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
        aria-hidden="true">
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

    <!-- 列印繳款單訊息 Modal -->
    <div class="modal fade" id="ClaimDeleteModal" tabindex="-1" role="dialog" aria-labelledby="ClaimDeleteModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <h4 class="modal-title" id="">刪除</h4><br />
                    確定要刪除此項目？
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-danger confirm-delete-btn" data-dismiss="modal">確定刪除</button>
                </div>
            </div>
        </div>
    </div>

    <div id="check_user_info" style="display:none">您的帳號目前尚未審核通過。</div>


    </body>

    </html>
<?
    $in =DB::select(" SELECT * FROM custom_settings WHERE user_id ='".Auth::user()->user_id."'");
    foreach ($in as $d_in){
        $r1 = $d_in->roi_setting_id;
        $p1 = $d_in->a_percent;
        $p2 = $d_in->b_percent;
        $p3 = $d_in->c_percent;
        $p4 = $d_in->d_percent;
        $p5 = $d_in->e_percent;
    }
?>
    <script>

function show_explanation() {

    swal("", "手續費為每次投資收益的10%，隨每月投資配息時一併扣除並收取");

}
function keyFunction() {
	if (event.keyCode==27) {
        window.location.href='/front/claim_match';
	}
}
document.onkeydown=keyFunction;

    var defaultOBJ = {
        a_percent: {{$p1}},
        b_percent: {{$p2}},
        c_percent: {{$p3}},
        d_percent: {{$p4}},
        e_percent: {{$p5}},
        roi_setting_id: {{$r1}}
    };

        setTimeout(() => {
            //設定選擇組別
            var default_roi_id = '{{ $roi_id }}';
            $('#groupingRadios' + default_roi_id).prop('checked', true).click();
            // console.log(default_roi_id, $('#groupingRadios' + default_roi_id));
        }, 1000);


        $('#batch-selected').click(function () {

            var input_value_check = $(this).val();
            // console.log($(this).val());


            if (input_value_check == '全選') {

                $(this).val('全不選');
                $("#rad24").prop('checked', true);
                // $('.input-period').prop("checked", true);
                // $('.rad').attr('checked', false);


            } else {

                $(this).val('全選');
                $('.input_period').attr("checked", false);
                // $('.rad').attr('checked', false);

            }

        });



        //radTrig 控制開關
        var radTrig = '';

        $('.rad').click(function () {
            let period = $(this).val();

            if (period == radTrig) {
                //重複
                $('.rad').attr('checked', false);
                $(".input-period").attr('disabled', false);
                radTrig = '';
            } else {
                switch (period) {
                    case '<=6':
                        radTrig = '<=6';
                        input_period_change(6);
                        break;
                    case '<=12':
                        radTrig = '<=12';
                        input_period_change(12);
                        break;
                    case '<=18':
                        radTrig = '<=18';
                        input_period_change(18);
                        break;
                    case '<=24':
                        radTrig = '<=24';
                        input_period_change(24);
                        break;
                    default:
                        break;
                }
            }

            function input_period_change(v) {
                let all = $(".input-period");
                let x = 0,
                    xlen = all.length;

                for (x; x < xlen; x++) {
                    let originalVal = $(all[x]).val();
                    let classVal = parseInt(originalVal);
                    if (classVal > v) {
                        $(all[x]).attr('disabled', true);
                        $(all[x]).attr('checked', false);
                    } else {
                        $(all[x]).attr('disabled', false);
                    }
                }
            }
        });
        //去重
        function unique(arr) {
            return Array.from(new Set(arr))
        }
        //取得選擇的期數
        function getInputPeriodsValue() {
            let default_period = [3, 6, 9, 10, 12, 18, 24];

            let input_periods = $("input[name*='input_period']");
            let value_array = [1];

            $.each(input_periods, function (k, v) {
                if ($(v).prop('checked')) {
                    var v = $(v).val();

                    switch (v) {
                        case "<=6":
                            // var moreThen6 = default_period.filter(function (item, index, array) {
                            //     return item <= 6;
                            // });
                            // value_array.concat(moreThen6);
                            // $.each(moreThen6, function (k, v) {
                            //     value_array.push(v);
                            // })
                            for (let x = 1; x < 7; x++) {
                                value_array.push(x);
                            }
                            break;

                        case "<=12":
                            // var moreThen12 = default_period.filter(function (item, index, array) {
                            //     return item <= 12;
                            // });
                            // value_array.concat(moreThen12);
                            // $.each(moreThen12, function (k, v) {
                            //     value_array.push(v);
                            // })
                            for (let x = 1; x < 13; x++) {
                                value_array.push(x);
                            }
                            break;
                        case "<=18":
                            // var moreThen18 = default_period.filter(function (item, index, array) {
                            //     return item <= 18;
                            // });
                            // value_array.concat(moreThen18);
                            // $.each(moreThen18, function (k, v) {
                            //     value_array.push(v);
                            // })
                            for (let x = 1; x < 19; x++) {
                                value_array.push(x);
                            }

                            break;
                        case "<=24":
                            // var moreThen18 = default_period.filter(function (item, index, array) {
                            //     return item <= 18;
                            // });
                            // value_array.concat(moreThen18);
                            // $.each(moreThen18, function (k, v) {
                            //     value_array.push(v);
                            // })
                            for (let x = 1; x < 25; x++) {
                                value_array.push(x);
                            }

                            break;
                        default:
                            value_array.push(parseInt(v));
                            break;
                    }
                }
            })
            return unique(value_array);
        }
        var ResultData;
        //開始試算 點擊
        $("#trial_income_btn").click(function () {
            ResultData = '';
            $("#resultTbl").empty();
            $("#real-reward").text('?');
            $("#reward-benefit").text('?');
            $("#buy_intelligent_claims").attr('disabled', true);
            let periodChecked = false;
            $.each($("input[name*='input_period[]']"), function (k, v) {
                if ($(v).prop('checked')) {
                    periodChecked = true;
                }
            })
            if (!periodChecked) {
                swal('提示', '請先選擇期數後再進行試算，謝謝!', 'info');
                return false;
            }

            //選擇的投資方式
            let intelligentChoise = defaultOBJ;
            //期數
            let input_periods = getInputPeriodsValue();
            //投資金額
            let amount = $("#input_amount").val();

            $('html, body').animate({
                scrollTop: ($("#trial_income_btn").offset().top) - 200
            }, 700);

            $.ajax({
                url: "{{ url('/front/claim_match/api/totalSplits') }}",
                type: 'post',
                async: false,
                data: {
                    methods: intelligentChoise,
                    periods: input_periods,
                    amount: amount
                },
                success: function (d) {
                    if (d.status == 'amountOverLoad') {
                        // swal('提示', '您投資的金額超過目前可投資債權投資總額!請調整投資金額', 'error');
                        swal({
                            title: "提示",
                            // text: '您投資的金額超過目前可投資債權投資總額!請調整投資金額',
                            text: '目前無符合您的投資組合，可讓系統隨機媒合或重新設定',
                            type: "info",
                            showCancelButton: true,
                            confirmButtonColor: "#00cddf",
                            confirmButtonText: "隨機媒合",
                            cancelButtonText: "重新設定",
                        }).then(() => {
                            randomTotalSplits(amount);
                            // alert("功能暫停中");
                        });
                    } else if (d.status == 'noClaim') {
                        // swal('提示', '目前無債權可投資，請更換投資組合或調整期數後再投資!', 'error');
                        swal({
                            title: "提示",
                            text: '目前無符合您的投資組合，可讓系統隨機媒合或重新設定',
                            // text: "媒合後，目前無債權可投資，請更換投資組合或調整期數後再投資！",
                            type: "info",
                            showCancelButton: true,
                            confirmButtonColor: "#00cddf",
                            confirmButtonText: "隨機媒合",
                            cancelButtonText: "重新設定",
                        }).then(() => {
                            randomTotalSplits(amount);
                            // alert("功能暫停中");
                        });

                    } else if (d.status == 'someSetOverLoad') {
                        // swal('提示', '您投資的' + d.data + '類債權，剩餘可投資金額不足，重新調整占比或是調整投資金額', 'error');
                        swal({
                            title: "提示",
                            text: '目前無符合您的投資組合，可讓系統隨機媒合或重新設定',
                            // text: '您投資的' + d.data + '類債權，剩餘可投資金額不足，重新調整占比或是調整投資金額',
                            type: "info",
                            showCancelButton: true,
                            confirmButtonColor: "#00cddf",
                            confirmButtonText: "隨機媒合",
                            cancelButtonText: "重新設定",
                        }).then(() => {
                            randomTotalSplits(amount);
                            // alert("功能暫停中");
                        });
                    } else if (d.status == 'success') {
                        $("#real-reward").text(d.principalSum);
                        $("#reward-benefit").text(d.intrestSum);
                        ResultData = d.result;
                        appendDataToTbl(d.result);
                        $("#buy_intelligent_claims").attr('disabled', false);
                    }
                },
                error: function (e) {

                }
            })

        })
        //隨機媒合
        function randomTotalSplits(amount) {
            $.ajax({
                url: "{{ url('/front/claim_match/api/randomTotalSplits') }}",
                type: 'post',
                async: false,
                data: {
                    amount: amount
                },
                success: function (d) {
                    if (d.status == 'amountOverLoad') {
                        swal('提示', '您投資的金額超過目前可投資債權投資總額!請調整投資金額', 'error');
                    } else if (d.status == 'noClaim') {
                        swal('提示', '目前無債權可投資，請更換投資組合或調整期數後再投資!', 'error');
                    } else if (d.status == 'someSetOverLoad') {
                        swal('提示', '您投資的' + d.data + '類債權，剩餘可投資金額不足，重新調整占比或是調整投資金額', 'error');
                    } else if (d.status == 'success') {
                        $("#real-reward").text(d.principalSum);
                        $("#reward-benefit").text(d.intrestSum);
                        ResultData = d.result;
                        appendDataToTbl(d.result);
                        $("#buy_intelligent_claims").attr('disabled', false);
                    }
                },
                error: function (e) {

                }
            })

        }
        //塞資料到 tbl
        function appendDataToTbl(data) {
            let x = 0,
                xlen = data.length;
            // $("#resultTbl")
            let html = '';
            for (x; x < xlen; x++) {
                let d = data[x];
                html += `
                <tr id="result_tr_${d.claim_id}">
                    <td style="text-align: center;"  data-th="同意協議書">
                        <a target="_blank" href="${d.pdf_url}">
                            <i class="far fa-file-pdf fa-2x"></i>
                        </a>
                    </td>
                    <td data-th="風險等級"><span>${d.risk_category}</span></td>
                    <td data-th="年化收益"><span>${d.annual_interest_rate}</span></td>
                    <td data-th="物件編號"><span>${d.claim_number}</span></td>
                    <td data-th="債權額度"><span>${d.staging_amount}</span></td>
                    <td data-th="期數"><span>${d.remaining_periods}</span></td>
                    <td data-th="剩餘金額"><span>${d.max_amount}</span></td>
                    <td data-th="上架日期"><span>${d.launched_at}</span></td>
                    <td data-th="預計結標日"><span>${d.estimated_close_date}</span></td>
                    <td data-th="認購進度">
                        <div class="progress">
                            <div class="progress-bar progress-barpp" role="progressbar" style="width:${d.progress}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                ${d.progress}%
                            </div>
                        </div>
                    </td>
                    <td data-th="還款方式"><span>${d.repayment_method}</span></td>
                    <td data-th="投資金額"><span>${d.throwAmount}</span></td>
                    <td data-th="刪除"><span class="removeClaim" data-id="${d.claim_id}">刪除</span></td>
                </tr>
                `;
            }
            $("#resultTbl").append(html);
            removeListen();
        }

        function removeListen() {
            $(".removeClaim").unbind();
            $(".removeClaim").on('click', function () {
                let claim_id = $(this).data('id');
                ResultData.map((k, v) => {
                    if(k.claim_id == claim_id){
                        ResultData.splice(v,1);
                        $("#result_tr_"+k.claim_id).remove();
                    }
                })
            })
        }


        $("#buy_intelligent_claims").click(function () {
            loadingMask('show');
            if ($("#isRead").prop('checked') == false) {
                loadingMask('hide');
                swal('提示', `請確認"協議書"後再進行投標，謝謝!`, 'info');
            } else {
                $.ajax({
                    url: '{{ url("/front/multipleCreateTender") }}',
                    type: 'post',
                    data: {
                        data: ResultData
                    },
                    success: function (d) {
                        loadingMask('hide');
                        if (d.status == 'success') {
                            swal('提示', '投標成功!', 'success').then(function () {
                                location.reload();
                            })
                        } else if (d.status == 'banned') {
                            swal('提示', '您的帳號目前違停權狀態!', 'error').then(function () {
                                location.reload();
                            })
                        } else if (d.status == 'permission') {
                            swal('提示', '您的帳號權限錯誤!', 'error').then(function () {
                                location.reload();
                            })
                        } else if (d.status == 'amountOver') {
                            swal('提示', '因部分債權剩餘可投標金額異動，請重新試算智能媒合!', 'error').then(function () {
                                location.reload();
                            })
                        } else if (d.status == 'claimError') {
                            swal('提示', '因部分債權未開放投標，請重新試算智能媒合!', 'error').then(function () {
                                location.reload();
                            })
                        } else {
                            swal('提示', '系統錯誤!請重新操作', 'error').then(function () {
                                location.reload();
                            })
                        }
                    },
                    error: function (e) {
                        loadingMask('hide');
                        swal('提示', '系統錯誤!請重新操作', 'error').then(function () {
                            location.reload();
                        })
                    }
                })
            }

        })


        //儲存按鈕
        $("#submitBtn2").click(function () {
            $(this).attr('disabled', true);
            $("#loading").toggleClass('hideloading', false);
            $.ajax({
                url: '{{ url("/users/tab_four/save") }}',
                type: 'post',
                data: defaultOBJ,
                success: function (d) {
                    $("#loading").toggleClass('hideloading', true);

                    if (d.status == 'success') {
                        swal('提示', '修改成功!', 'success').then(function () {
                            $("#submitBtn2").attr('disabled', false);
                        });
                        // switch (d.roi_setting_id) {
                        //     case "1":
                        //         $("#larbar_type1").show();
                        //         $("#larbar_type2").hide();
                        //         $("#larbar_type3").hide();
                        //         $("#larbar_type4").hide();
                        //         $("#larbar_type5").hide();
                        //         break;
                        //     case "2":
                        //         $("#larbar_type1").hide();
                        //         $("#larbar_type2").show();
                        //         $("#larbar_type3").hide();
                        //         $("#larbar_type4").hide();
                        //         $("#larbar_type5").hide();
                        //         break;
                        //     case "3":
                        //         $("#larbar_type1").hide();
                        //         $("#larbar_type2").hide();
                        //         $("#larbar_type3").show();
                        //         $("#larbar_type4").hide();
                        //         $("#larbar_type5").hide();
                        //         break;
                        //     case "4":
                        //         $("#larbar_type1").hide();
                        //         $("#larbar_type2").hide();
                        //         $("#larbar_type3").hide();
                        //         $("#larbar_type4").show();
                        //         $("#larbar_type5").hide();
                        //         if(d.a_percent>0){
                        //             $('#roi_id_4_left_select_2').val('a-color'); 
                        //         }else if(d.b_percent>0){
                        //             $('#roi_id_4_left_select_2').val('b-color');
                        //         }else if(d.c_percent>0){
                        //             $('#roi_id_4_right_select_2').val('c-color');
                        //         }else if(d.d_percent>0){
                        //             $('#roi_id_4_right_select_2').val('d-color');
                        //         }else if(d.e_percent>0){
                        //             $('#roi_id_4_right_select_2').val('e-color');
                        //         }
                        //         break;
                        //     case "5":
                        //         $("#larbar_type1").hide();
                        //         $("#larbar_type2").hide();
                        //         $("#larbar_type3").hide();
                        //         $("#larbar_type4").hide();
                        //         $("#larbar_type5").show();
                        //         if(d.a_percent>0){
                        //             $('#roi_id_5_select_2').val('a-color');
                        //         }else if(d.b_percent>0){
                        //             $('#roi_id_5_select_2').val('b-color');
                        //         }else if(d.c_percent>0){
                        //             $('#roi_id_5_select_2').val('c-color');
                        //         }else if(d.d_percent>0){
                        //             $('#roi_id_5_select_2').val('d-color');
                        //         }else if(d.e_percent>0){
                        //             $('#roi_id_5_select_2').val('e-color');
                        //         }
                        //         break;
                        //     default:
                        //         break;
                        // }
                        
                    } else {
                        swal('提示', '修改失敗，請聯絡系統管理員排除問題!', 'error');
                    }
                },
                error: function (e) {
                    $("#loading").toggleClass('hideloading', true);

                    swal('提示', '修改失敗，請聯絡系統管理員排除問題!', 'error').then(function () {
                        location.reload();
                    })
                },
            })
        })


        $("#input_amount").change(function () {
            alertAmount($(this).val());
        })

        function alertAmount(amount) {
            if (amount > 500) {
                swal('提示', '請投資金額超過本周期可投資金額，請重新輸入，謝謝!', 'info');
                $("#input_amount").val(1);
                return false;
            }
            if (amount < 1) {
                swal('提示', '最小資金額為1萬元，請重新輸入，謝謝!', 'info');
                $("#input_amount").val(1);
                return false;
            }
        }

    
    
    // 開始頁面的拉霸script
/*    
    var defaultOBJ = {
        a_percent: {{$p1}},
        b_percent: {{$p2}},
        c_percent: {{$p3}},
        d_percent: {{$p4}},
        e_percent: {{$p5}},
        roi_setting_id: {{$r1}}
    };
*/
    $(function () {
        var endDefaultUpdate = false;
        var default_roi_id = '{{ $roi_id }}';
        // var defaultOBJ = {
        //     a_percent: 0,
        //     b_percent: 0,
        //     c_percent: 0,
        //     d_percent: 0,
        //     e_percent: 0,
        //     roi_setting_id: 0,
        // };

        var dataObj = {
            roi_setting_id: 1,
            select: {},

        };
        /* -------------------------------------------------------------------------- */
        //穩重謹慎型 slibar設定
        var roi_id_1_2 = document.getElementById('roi_id_1_2');
        var val_1_1_2 = document.getElementById('val_1_1_2');
        var val_1_2_2 = document.getElementById('val_1_2_2');

        noUiSlider.create(roi_id_1_2, {
            padding: 10,
            start: 90,
            step: 10,
            connect: true,
            range: {
                'min': 0,
                'max': 100
            },
        });
        //調整數值時
        roi_id_1_2.noUiSlider.on('update', function (values, handle) {
            let r1a = Math.floor(values[handle]);
            let r1b = (100 - r1a);
            val_1_1_2.innerHTML = r1a;
            val_1_2_2.innerHTML = r1b;
            if (endDefaultUpdate) {
                updateDoingThing(1, [r1a, r1b]);
            }
        });
        /* -------------------------------------------------------------------------- */
        // 積極進取型 slibar設定
        var roi_id_2_2 = document.getElementById('roi_id_2_2');
        var val_2_1_2 = $('#val_2_1_2');
        var val_2_2_2 = $('#val_2_2_2');
        var val_2_3_2 = $('#val_2_3_2');

        noUiSlider.create(roi_id_2_2, {
            padding: 10,
            start: [10, 20],
            step: 10,
            margin: 10,
            connect: true,
            range: {
                'min': 0,
                'max': 100
            },
        });
        roi_id_2_2.noUiSlider.on('update', function (values, handle) {
            var c2 = Math.floor(values[0]);
            var d2 = Math.floor(values[1]) - c2;
            var e2 = 100 - d2 - c2;
            val_2_1_2.text(c2);
            val_2_2_2.text(d2);
            val_2_3_2.text(e2);
            if (endDefaultUpdate) {
                updateDoingThing(2, [c2, d2, e2]);
            }
        });
        /* -------------------------------------------------------------------------- */
        // 穩健積極型 slibar設定
        var roi_id_4_2 = document.getElementById('roi_id_4_2');
        var val_4_1_2 = $('#val_4_1_2');
        var val_4_2_2 = $('#val_4_2_2');

        noUiSlider.create(roi_id_4_2, {
            padding: 10,
            start: 10,
            step: 10,
            margin: 10,
            connect: true,
            range: {
                'min': 0,
                'max': 100
            },
        });
        roi_id_4_2.noUiSlider.on('update', function (values, handle) {
            let x41 = Math.floor(values[handle]);
            let x42 = 100 - x41;
            val_4_1_2.text(x41);
            val_4_2_2.text(x42);
            if (endDefaultUpdate) {
                updateDoingThing(4, [x41, x42]);
            }
        });
        /* Some Setting Function -------------------------------------------------------------------------- */
        function updateDoingThing(roi_setting_id, value_array) {
            changeSelect(roi_setting_id);
            let obj = getObjectTemp(roi_setting_id, value_array);
            changeDefaultObj(obj);
        }

        function getObjectTemp(roi_id, numArray) {
            let obj = {
                roi_setting_id: roi_id,
            };
            switch (roi_id) {
                case 1:
                    obj['a_percent'] = numArray[0];
                    obj['b_percent'] = numArray[1];
                    return obj;
                    break;
                case 2:
                    obj['c_percent'] = numArray[0];
                    obj['d_percent'] = numArray[1];
                    obj['e_percent'] = numArray[2];
                    return obj;
                    break;
                case 3:
                    obj['a_percent'] = numArray[0];
                    obj['b_percent'] = numArray[0];
                    obj['c_percent'] = numArray[0];
                    obj['d_percent'] = numArray[0];
                    obj['e_percent'] = numArray[0];
                    return obj;
                    break;
                case 4:
                    let n1 = selectValueToKey($("#roi_id_4_left_select_2").val());
                    let n2 = selectValueToKey($("#roi_id_4_right_select_2").val());
                    obj[n1] = numArray[0];
                    obj[n2] = numArray[1];
                    return obj;
                    break;
                case 5:
                    let n3 = selectValueToKey($("#roi_id_5_select_2").val());
                    obj[n3] = numArray[0];
                    return obj;
                    break;
                default:
                    break;
            }
        }
        //切換Radio選擇
        function changeSelect(id) {
            $('#groupingRadios' + id).prop('checked', true);
        };
        //select 的 value 對應 object key
        function selectValueToKey(val) {
            let array = {
                'a-color': 'a_percent',
                'b-color': 'b_percent',
                'c-color': 'c_percent',
                'd-color': 'd_percent',
                'e-color': 'e_percent',
            };
            return array[val];
        }
        // radio選擇事件監聽
        $("input[name='groupingRadios']").on('click', function () {
            let thisRadioValue = $(this).val();
            switch (thisRadioValue) {
                case "1":
                    let roi_1_val = roi_id_1_2.noUiSlider.get();
                    let r1a = Math.floor(roi_1_val);
                    let r1b = (100 - r1a);
                    updateDoingThing(1, [r1a, r1b]);
                    break;
                case "2":
                    let roi_2_val = roi_id_2_2.noUiSlider.get();
                    let r2c = Math.floor(roi_2_val[0]);
                    let r2d = Math.floor(roi_2_val[1]) - r2c;
                    let r2e = 100 - r2d - r2c;
                    updateDoingThing(2, [r2c, r2d, r2e]);
                    break;
                case "3":
                    updateDoingThing(3, [20]);
                    break;
                case "4":
                    let roi_4_val = roi_id_4_2.noUiSlider.get();
                    let x41 = Math.floor(roi_4_val);
                    let x42 = 100 - x41;
                    updateDoingThing(4, [x41, x42]);
                    break;
                case "5":
                    updateDoingThing(5, [100]);
                    break;
                default:
                    break;
            }
        })

        //那三個下拉選單的監聽
        $("#roi_id_4_left_select_2 , #roi_id_4_right_select_2").change(function () {
            let roi_4_val = roi_id_4_2.noUiSlider.get();
            let x41 = Math.floor(roi_4_val);
            let x42 = 100 - x41;
            updateDoingThing(4, [x41, x42]);
        })
        $("#roi_id_5_select_2").change(function () {
            updateDoingThing(5, [100]);
        })

        //修改OBJ
        function changeDefaultObj(obj) {
/*
            $.each(defaultOBJ, function (k, v) {
                if (obj[k] == null) {
                    defaultOBJ[k] = 0;
                } else {
                    defaultOBJ[k] = obj[k];
                }
            })
*/
        }
        /* 跑預設值-------------------------------------------------------------------------- */
        var defaultSetting = JSON.parse('{!! $defaultSetting !!}');
        console.log("MyOutput: defaultSetting", defaultSetting)
        let x = 0,
            xlen = defaultSetting.length;
        //設定預設的progress bar值
        for (x; x < xlen; x++) {
            switch (x) {
                case 0:
                    roi_id_1_2.noUiSlider.set(defaultSetting[x].a_percent);
                    set_default_obj(defaultSetting[x]);
                    break;
                case 1:
                    let d_p = defaultSetting[x].c_percent + defaultSetting[x].d_percent;
                    roi_id_2_2.noUiSlider.set([defaultSetting[x].c_percent, d_p]);
                    set_default_obj(defaultSetting[x]);
                    break;
                case 2:
                    //晚點做
                    set_default_obj(defaultSetting[x]);
                    break;
                case 3:
                    roi_id4_proccess(defaultSetting[x]);
                    set_default_obj(defaultSetting[x]);
                    break
                case 4:
                    roi_id5_proccess(defaultSetting[x]);
                    set_default_obj(defaultSetting[x]);
                default:
                    break;
            }
            if (x == (xlen - 1)) {
                endDefaultUpdate = true;
            }
        }

        function roi_id4_proccess(data) {
            let right = $("#roi_id_4_right_select_2");
            let left = $("#roi_id_4_left_select_2");
            if (data.hasOwnProperty('a_percent') && data.a_percent != 0) {
                left.val('a-color').change();
                roi_id_4_2.noUiSlider.set(data.a_percent);
            } else {
                left.val('b-color').change();
                roi_id_4_2.noUiSlider.set(data.b_percent);
            }
            if (data.hasOwnProperty('c_percent') && data.c_percent != 0) {
                right.val('c-color').change();
            } else if (data.hasOwnProperty('d_percent') && data.d_percent != 0) {
                right.val('d-color').change();
            } else {
                right.val('e-color').change();
            }
        }

        function roi_id5_proccess(data) {
            $.each(data, function (k, v) {
                let sel = $("#roi_id_5_select_2");
                if (k != 'roi_setting_id' && k != 0) {
                    let kv = k.split('_')[0];
                    sel.val(kv + "-color").change();
                }
            })
        }
        //設定預設Object
        function set_default_obj(defaultSettingObj) {
            let roi_setting_id = defaultSettingObj.roi_setting_id;
            if (roi_setting_id == default_roi_id) {
                $.each(defaultSettingObj, function (k, v) {
                    defaultOBJ[k] = v;
                });
            }
        }

        //設定選擇組別
        $('#groupingRadios' + default_roi_id).prop('checked', true);
/*
        //儲存按鈕
        $("#buy_intelligent_claims").mouseover(function () {
            $(this).attr('disabled', true);
            $("#loading").toggleClass('hideloading', false);
            $.ajax({
                url: '{{ url("/users/tab_four/save") }}',
                type: 'post',
                data: defaultOBJ,
                success: function (d) {
                    $("#loading").toggleClass('hideloading', true);

                    if (d.status == 'success') {
                        swal('提示', '修改成功!', 'success').then(function () {
                            location.reload();
                        })
                    } else {
                        swal('提示', '修改失敗，請聯絡系統管理員排除問題!', 'error').then(function () {
                            location.reload();
                        })
                    }
                },
                error: function (e) {
                    $("#loading").toggleClass('hideloading', true);

                    swal('提示', '修改失敗，請聯絡系統管理員排除問題!', 'error').then(function () {
                        location.reload();
                    })
                },
            })
        })
*/
    })
function iin(){
    var rrr ="{{$r1}}";
    var p1 ="{{$p1}}";
    var p2 ="{{$p2}}";
    var p3 ="{{$p3}}";
    var p4 ="{{$p4}}";
    var p5 ="{{$p5}}";

                        switch (rrr) {
                            case "1":
                                $("#larbar_type1").show();
                                $("#larbar_type2").hide();
                                $("#larbar_type3").hide();
                                $("#larbar_type4").hide();
                                $("#larbar_type5").hide();
                                // bar1();
                                // $(".noUi-base").attr("disabled", "disabled");
                                break;
                            case "2":
                                $("#larbar_type1").hide();
                                $("#larbar_type2").show();
                                $("#larbar_type3").hide();
                                $("#larbar_type4").hide();
                                $("#larbar_type5").hide();
                                break;
                            case "3":
                                $("#larbar_type1").hide();
                                $("#larbar_type2").hide();
                                $("#larbar_type3").show();
                                $("#larbar_type4").hide();
                                $("#larbar_type5").hide();
                                break;
                            case "4":
                                $("#larbar_type1").hide();
                                $("#larbar_type2").hide();
                                $("#larbar_type3").hide();
                                $("#larbar_type4").show();
                                $("#larbar_type5").hide();

                                if( p1>0){
                                    $('#slider-third-AB-span').html('A'); 
                                }else if( p2>0){
                                    $('#slider-third-AB-span').html('B');
                                }
                                if( p3>0){
                                    $('#slider_third_CDE_span').html('C');
                                }else if( p4>0){
                                    $('#slider_third_CDE_span').html('D');
                                }else if( p5>0){
                                    $('#slider_third_CDE_span').html('E');
                                }

                                break;
                            case "5":
                                $("#larbar_type1").hide();
                                $("#larbar_type2").hide();
                                $("#larbar_type3").hide();
                                $("#larbar_type4").hide();
                                $("#larbar_type5").show();

                                if( p1>0){
                                    $('#unique_block').html('A：100%');
                                }else if( p2>0){
                                    $('#unique_block').html('B：100%');
                                }else if( p3>0){
                                    $('#unique_block').html('C：100%');
                                }else if( p4>0){
                                    $('#unique_block').html('D：100%');
                                }else if( p5>0){
                                    $('#unique_block').html('E：100%');
                                }

                                break;
                            default:
                                break;
                        }
//                         switch (rrr) {
//                             case "1":
//                                 $("#larbar_type1").show();
//                                 $("#larbar_type2").hide();
//                                 $("#larbar_type3").hide();
//                                 $("#larbar_type4").hide();
//                                 $("#larbar_type5").hide();
//                                 break;
//                             case "2":
//                                 $("#larbar_type1").hide();
//                                 $("#larbar_type2").show();
//                                 $("#larbar_type3").hide();
//                                 $("#larbar_type4").hide();
//                                 $("#larbar_type5").hide();
//                                 break;
//                             case "3":
//                                 $("#larbar_type1").hide();
//                                 $("#larbar_type2").hide();
//                                 $("#larbar_type3").show();
//                                 $("#larbar_type4").hide();
//                                 $("#larbar_type5").hide();
//                                 break;
//                             case "4":
//                                 $("#larbar_type1").hide();
//                                 $("#larbar_type2").hide();
//                                 $("#larbar_type3").hide();
//                                 $("#larbar_type4").show();
//                                 $("#larbar_type5").hide();
// /*
//                                 if( p1>0){
//                                     $('#roi_id_4_left_select_2').val('a-color'); 
//                                 }else if( p2>0){
//                                     $('#roi_id_4_left_select_2').val('b-color');
//                                 }else if( p3>0){
//                                     $('#roi_id_4_right_select_2').val('c-color');
//                                 }else if( p4>0){
//                                     $('#roi_id_4_right_select_2').val('d-color');
//                                 }else if( p5>0){
//                                     $('#roi_id_4_right_select_2').val('e-color');
//                                 }
// */
//                                 break;
//                             case "5":
//                                 $("#larbar_type1").hide();
//                                 $("#larbar_type2").hide();
//                                 $("#larbar_type3").hide();
//                                 $("#larbar_type4").hide();
//                                 $("#larbar_type5").show();
// /*
//                                 if( p1>0){
//                                     $('#roi_id_5_select_2').val('a-color');
//                                 }else if( p2>0){
//                                     $('#roi_id_5_select_2').val('b-color');
//                                 }else if( p3>0){
//                                     $('#roi_id_5_select_2').val('c-color');
//                                 }else if( p4>0){
//                                     $('#roi_id_5_select_2').val('d-color');
//                                 }else if( p5>0){
//                                     $('#roi_id_5_select_2').val('e-color');
//                                 }
// */
//                                 break;
//                             default:
//                                 break;
//                         }
}
iin();


</script>


    @endsection
