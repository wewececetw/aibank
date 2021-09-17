@extends('Front_End.layout.header') @section('content')
<style>
    .loan_btn{
        h
    }
</style>


<div id="main-page">
    <link rel="stylesheet" media="screen" href="/css/loan.css" />
    <link rel="stylesheet" media="screen" href="/css/table.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker3.min.css">

    <div class="loan_banner">
        <div class="container">
            <div class="row">
                <div class="col-md-9 m-auto loan_jpg loan_b" aos="fade-up"><img src="/images/loan1.png" alt="" class="loan_b"></div>
                <div class="col-md-9 m-auto loan_jpg loan_s" aos="fade-up"><img src="/images/loan1_s.png" alt="" class="loan_s"></div>
            </div>
        </div>
    </div>
    <div class="container_bg">
        <div class="container">
            <div class="row">
                <div class="col-md-10 m-auto col-sm-12">
                    <div class="text-center">
                        <div class="title_loan">基本申請條件</div>
                    </div>
                    <div class="bd-example">
                        <div class="table-responsive">
                            <table class="table pc_table">
                                <thead>
                                    <tr>
                                        <th scope="col" class="tb1">個人基本條件</th>
                                        <th scope="col" class="tb1 w28">個人信用貸款</th>
                                        <th scope="col" class="tb1 w28">個人抵押貸款(車輛)</th>
                                        <th scope="col" class="tb1 w28">個人抵押貸款(房屋)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row" class="color7">年齡</th>
                                        <td>20-60</td>
                                        <td>20-65</td>
                                        <td>20-65</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="color7">財力證明</th>
                                        <td>需提供</td>
                                        <td>無需提供</td>
                                        <td>無需提供</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="color7">聯徵信用報告(借款人)</th>
                                        <td>需提供</td>
                                        <td>需提供</td>
                                        <td>需提供</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="color7">抵押品</th>
                                        <td>無需提供</td>
                                        <td>自用轎車
                                        </td>
                                        <td>住宅，商店(接受次順位抵押)
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="m_table"><img src="/images/tablerwd.jpg" alt=""></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-10 m-auto col-sm-12">
                    <div class="bd-example">
                        <div class="table-responsive">
                            <table class="table pc_table">
                                <thead>
                                    <tr>
                                        <th scope="col" class="tb1 w13"></th>
                                        <th scope="col" class="tb1 w28">商業貸款(抵押貸)
                                        </th>
                                        <th scope="col" class="tb1 w28">商業貸款(票據貼現)
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row" class="color7">成立時間
                                        </th>
                                        <td>3年以上
                                        </td>
                                        <td>3年以上
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="color7">負責人年齡
                                        </th>
                                        <td>26~65
                                        </td>
                                        <td>26~65
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="color7">財務報表
                                        </th>
                                        <td>需提供</td>
                                        <td>需提供
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="color7">聯徵信用報告(借款人)</th>
                                        <td>需提供</td>
                                        <td>需提供</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="color7">抵/質押品
                                        </th>
                                        <td>住宅，辦公大樓，商店(接受次順位抵押)</td>
                                        <td>承兌匯票或本票
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="m_table"><img src="/images/tablerwd2.jpg" alt=""></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-10 m-auto col-sm-12 con50">
                    <div class="text-center">
                        <div class="title_loan">貸款額度及期限</div>
                    </div>
                    <div class="bd-example">
                        <div class="table-responsive">
                            <table class="table pc_table">
                                <thead>
                                    <tr>
                                        <th scope="col" class="tb1"> </th>
                                        <th scope="col" class="tb1">個人信用貸款</th>
                                        <th scope="col" class="tb1">個人抵押貸款(車輛)</th>
                                        <th scope="col" class="tb1">個人抵押貸款(房屋)</th>
                                        <th scope="col" class="tb1">商業貸款 (抵押貸)</th>
                                        <th scope="col" class="tb1">商業貸款 (票據貼現)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row" class="color7">額度 (萬)
                                        </th>
                                        <td>30</td>
                                        <td>50</td>
                                        <td>200</td>
                                        <td>200</td>
                                        <td>100</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="color7">貸款期限(月)
                                        </th>
                                        <td>12</td>
                                        <td>24</td>
                                        <td>24</td>
                                        <td>24</td>
                                        <td>6</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="m_table"><img src="/images/tablerwd3.jpg" alt=""></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="btauto m-auto ">
                        <!-- Large modal -->
                        <a target="blank" href="http://loan.pponline.com.tw/" class="btn btbt3 loan_btn">貸款申請</a>

                            {{-- 貸款申請原本的form --}}
                        {{-- <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="loan_form">

                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header header_top1">
                                        <h5 class="modal-title" id="exampleModalLabel">貸款申請</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <form class="nifty_form" id="new_loan" action="/front" accept-charset="UTF-8" method="post">
                                        <input name="utf8" type="hidden" value="&#x2713;" />
                                        <input type="hidden" name="authenticity_token" value="v98xaqJKZA7dbDLtYgBUnvWhyfiag/3RRdLFKyhl9fCCuOfGyQ33Nf9KH71+1azFFhOdCkGKRNm4cgY+dm8qyA==" />
                                        <div class="modal-body">
                                            <div class="nana">申請人基本資料</div>
                                            <div class="form-group">
                                                <label for="recipient-name" class="col-form-label">
                                                    <span class="color7">*</span> 會員姓名
                                                </label>
                                                <input required="required" id="loan_name" class="form-control" type="text" name="loan[name]" />
                                            </div>
                                            <div class="form-group">
                                                <label for="message-text" class="col-form-label">
                                                    <span class="color7">*</span> 出生年月日</label>
                                                <div class="input-group date">
                                                    <input as="string" required="required" id="loan_dob" class="form-control datepicker" type="text" name="loan[dob]" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="recipient-name" class="col-form-label">
                                                    <span class="color7">*</span> 身分證字號
                                                </label>
                                                <input required="required" id="loan_id_number" class="form-control" type="text" name="loan[id_number]" />
                                            </div>
                                            <div class="form-group">
                                                <label for="recipient-name" class="col-form-label">
                                                    <span class="color7">*</span> 行動電話
                                                </label>
                                                <input required="required" id="loan_cellphone_number" class="form-control" type="text" name="loan[cellphone_number]" />
                                            </div>
                                            <div class="form-group">
                                                <label for="recipient-name" class="col-form-label">
                                                    <span class="color7">*</span> 住家電話
                                                </label>
                                                <input required="required" id="loan_telephone_number" class="form-control" type="text" name="loan[telephone_number]" />
                                            </div>
                                            <div class="form-group">
                                                <label for="recipient-name" class="col-form-label">
                                                    <span class="color7">*</span> 居住地
                                                </label>
                                                <input required="required" id="loan_address" value="" class="form-control" type="text" name="loan[address]" />
                                            </div>
                                            <div class="nana">申請人工作資料</div>
                                            <div class="form-group">
                                                <label for="recipient-name" class="col-form-label">
                                                    <span class="color7">*</span> 公司名稱
                                                </label>
                                                <input required="required" id="loan_company_name" class="form-control" type="text" name="loan[company_name]" />
                                            </div>
                                            <div class="form-group">
                                                <label for="recipient-name" class="col-form-label">
                                                    <span class="color7">*</span> 職稱
                                                </label>
                                                <input required="required" id="loan_job_title" class="form-control" type="text" name="loan[job_title]" />
                                            </div>
                                            <div class="form-group">
                                                <label for="recipient-name" class="col-form-label">
                                                    <span class="color7">*</span> 月薪
                                                </label>
                                                <input required="required" id="loan_monthly_salary" class="form-control" type="text" name="loan[monthly_salary]" />
                                            </div>
                                            <div class="form-group">
                                                <label for="recipient-name" class="col-form-label">
                                                    <span class="color7">*</span> 公司電話
                                                </label>
                                                <input required="required" id="loan_company_phone" class="form-control" type="text" name="loan[company_phone]" />
                                            </div>
                                            <div class="nana">貸款種類</div>
                                            <div class="form-group">
                                                <!-- Drop downn section and options -->
                                                <div class="content-selection">
                                                    <select id="loan-select" name="loan_type" class="form-control" onchange="npup.doSelect(this);" style="height: calc(2.25rem + 2px); background-color: #fff">
                                                        <option value="credit" data-id="credit-loan">個人信用貸款</option>
                                                        <option value="houses" data-id="house-loan">個⼈抵押貸(房⼦)</option>
                                                        <option value="car" data-id="car-loan">個⼈抵押貸(車⼦)</option>
                                                        <option value="check" data-id="ticket-stickers">商業貸</option>
                                                    </select>
                                                </div>
                                                <!-- end of content-selection -->
                                                <!-- container for any elements that are to be in the game -->
                                            </div>
                                            <div class="form-group">
                                                <label for="recipient-name" class="col-form-label">
                                                    <span class="color7">*</span> 金額
                                                </label>
                                                <input required="required" id="loan_amount" class="form-control" type="text" name="loan[amount]" />
                                            </div>
                                            <div class="form-group">
                                                <label for="recipient-name" class="col-form-label">
                                                    <span class="color7">*</span> 期數
                                                </label>
                                                <input required="required" id="loan_periods" class="form-control" type="text" name="loan[periods]" />
                                            </div>
                                            <div id="mySpecialElements">
                                                <!--  these have ids that end with and index  for easy retrieval in "findeElement" function  below-->
                                                <!-- <div id="npup0_1" class="loan_select_area hidden"></div> -->
                                                <div id="house-loan" class="loan_select_area hidden">
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="col-form-label">
                                                            <span class="color7">*</span> 房屋座落
                                                        </label>
                                                        <input id="loan_building_location" class="form-control" type="text" name="loan[building_location]" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="col-form-label">
                                                            <span class="color7">*</span> 建號
                                                        </label>
                                                        <input id="loan_building_numbers" class="form-control" type="text" name="loan[building_numbers]" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="col-form-label">
                                                            <span class="color7">*</span> 地號
                                                        </label>
                                                        <input id="loan_land_numbers" class="form-control" type="text" name="loan[land_numbers]" />
                                                    </div>
                                                </div>
                                                <div id="car-loan" class="loan_select_area hidden">
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="col-form-label">
                                                            <span class="color7">*</span> 車輛
                                                        </label>
                                                        <input id="loan_car_type" class="form-control" type="text" name="loan[car_type]" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="col-form-label">
                                                            <span class="color7">*</span> 廠牌
                                                        </label>
                                                        <input id="loan_car_brand" class="form-control" type="text" name="loan[car_brand]" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="col-form-label">
                                                            <span class="color7">*</span> 車型
                                                        </label>
                                                        <input id="loan_car_model" class="form-control" type="text" name="loan[car_model]" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="col-form-label">
                                                            <span class="color7">*</span> 車號
                                                        </label>
                                                        <input id="loan_plate_number" class="form-control" type="text" name="loan[plate_number]" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="col-form-label">
                                                            <span class="color7">*</span> CC數
                                                        </label>
                                                        <input id="loan_car_capacity" class="form-control" type="text" name="loan[car_capacity]" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="col-form-label">
                                                            <span class="color7">*</span> 車色
                                                        </label>
                                                        <input id="loan_car_color" class="form-control" type="text" name="loan[car_color]" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="col-form-label">
                                                            <span class="color7">*</span> 出廠年月
                                                        </label>
                                                        <div class="input-group date">
                                                            <input as="string" id="loan_production_at" class="form-control datepicker" type="text" name="loan[production_at]" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="ticket-stickers" class="loan_select_area hidden">
                                                </div>
                                            </div>

                                            <div>

                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">
                                                        <span class="color7">*</span> 貸款用途
                                                    </label>
                                                    <input required="required" class="form-control" type="text" name="loan[description]" id="loan_description" />
                                                </div>

                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">
                                                        <span class="color7">*</span> 驗證碼
                                                    </label>
                                                    <style type="text/css">
                                                        .simple_captcha {
                                                            border: 1px solid #ccc;
                                                            padding: 5px !important;
                                                        }

                                                        .simple_captcha,
                                                        .simple_captcha div {
                                                            display: table;
                                                        }

                                                        .simple_captcha .simple_captcha_field,
                                                        .simple_captcha .simple_captcha_image {
                                                            border: 1px solid #ccc;
                                                            margin: 0px 0px 2px 0px !important;
                                                            padding: 0px !important;
                                                        }

                                                        .simple_captcha .simple_captcha_image img {
                                                            margin: 0px !important;
                                                            padding: 0px !important;
                                                            width: 110px !important;
                                                        }

                                                        .simple_captcha .simple_captcha_label {
                                                            font-size: 12px;
                                                        }

                                                        .simple_captcha .simple_captcha_field input {
                                                            width: 150px !important;
                                                            font-size: 16px;
                                                            border: none;
                                                            background-color: #efefef;
                                                        }
                                                    </style>

                                                    <div class='simple_captcha'>
                                                        <div class='simple_captcha_image'>
                                                            <img src="http://www.pponline.com.tw/simple_captcha?code=27f582115cb3874f452d7ea3911a19e1b8e3b203&amp;time=1574048474" alt="captcha" id="simple_captcha-27f582115cb" />
                                                        </div>

                                                        <div class='simple_captcha_field'>
                                                            <input type="text" name="captcha" id="captcha" autocomplete="off" autocorrect="off" autocapitalize="off" required="required" placeholder="" />
                                                            <input type="hidden" name="captcha_key" id="simple-captcha-hidden-field-simple_captcha-27f582115cb" value="27f582115cb3874f452d7ea3911a19e1b8e3b203" />
                                                        </div>

                                                        <div class='simple_captcha_label'>
                                                            請輸入驗證碼
                                                        </div>

                                                        <div class='simple_captcha_refresh_button'>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button name="button" type="button" id="button_rewrite" class="btn btn-secondary" style="border-radius:0">重新填寫</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius:0">取消</button>
                                            <button type="submit" class="btn btn-primary" style="border-radius:0">確認送出</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="/assets/front/loan-906ff597880529c08c91dcc582d62420a887e8790b56f72b440f749c75523164.js"></script>
{{-- <script src="/js/select.js"></script> --}}

@endsection
