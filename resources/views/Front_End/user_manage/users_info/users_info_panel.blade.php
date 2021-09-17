@extends('Front_End.layout.header')

@section('content')

<script id="main-page"></script>
<link rel="stylesheet" media="screen" href="/table/css/table.css" />
<link rel="stylesheet" media="screen" href="/css/list.css" />
<link rel="stylesheet" media="screen" href="/css/list_modal.css" />
<link rel="stylesheet" media="screen" href="/css/modal.css" />
<link rel="stylesheet" media="screen" href="/css/member.css?v=20191016" />
<link rel="stylesheet" media="screen" href="/css/member2.css?v=20181027" />
<link rel="stylesheet" media="screen" href="/css/tender.css" />
<link rel="stylesheet" media="screen" href="/css/file.css" />
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons">

<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.zh-TW.min.js">
</script>

<script>

</script>
<style>
    .fluid_div {
        border: solid 1px #eee;
        height: 150px;
        width: 245px;
        background-size: contain;
        overflow: hidden;
    }

    @media (max-width: 1200px) {
        .fluid_div {
            width: 220px;
        }
    }

    .fluid {

        height: 130px;
        width: auto !important;
        margin: auto;
        display: block !important;
        opacity: 0.8;
        margin-top: 10px;
    }

    input[type="file"] {
        z-index: 0;
    }

</style>

@if (session('check_token'))
<script>
    swal("提示", "驗證碼錯誤！", "error")

</script>
@endif
@if (session('check_time'))
<script>
    swal("提示", "驗證碼已過期！", "error")

</script>
@endif
@if(session('photoError'))
<script>
    swal("提示", "照片格式錯誤!", "error")

</script>
@endif
@if(session('submitSuccess'))
<script>
    // swal("提示", "已提交審核中!", "success")
    swal({
        title: "提示",
        text: '已提交審核中!',
        type: "success",
        showCancelButton: true,
        confirmButtonColor: "#a5dc86",
        confirmButtonText: "前往銀行帳號設定",
        cancelButtonText: "關閉",
    }).then(() => {
        location.href = "{{ url('/users/tab_two') }}";
    });

</script>
@endif
@if(session('id_card_error'))
<script>
    swal("提示", "身分證重複!", "error")

</script>
@endif

@if(session('wait_confirm'))
<script>
    swal("警告", "請等待真實資訊審核!", "warning");
</script>
@endif

@if(session('true_data_to_confirm'))
<script>
    swal("錯誤", "請提交真實資訊以供審核!", "error");
</script>
@endif

<div class="member_banner">
    <div class="container">
        <div class="row">
            <div class="banner_content">

            </div>
        </div>
    </div>
</div>

@component('Front_End.user_manage.account.mobileSelect')
@endcomponent

<script>
    window.onload = function () {
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
                $("#pushhand").addClass("menu_active2")
                break;
        }

        $('#menu').on('change', function (e) {
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

@if(isset($id_fail))
<script>
    swal("提示", `上傳的照片格式錯誤`, "error");

</script>
@endif

<form class="simple_form form-horizontal" id="mobile_form" action="{{ url('/users/update_info') }}"
    enctype="multipart/form-data" accept-charset="UTF-8" method="post">

    @csrf

    <div class="container" style="min-height: 500px">
        <div class="row">
            <div class="member_content">

                <div class="member_title"> <span class="f28m">個人真實資訊</span></div>
                <div class="col-55 f20m ">
                    <div class="f20mborder"><img src="/images/member1.png" alt=""> 個人資料名稱</div>
                    <div class="field">
                        <div class="f16 f16txt">真實姓名</div>
                        <input class="string required w90 string required form-control" type="text"
                            value="{{ $user->user_name }}" name="user_name" id="user_name"
                            <?=($user->user_state == '2' || $user->user_state == '1')?'disabled' :'' ;?> required>

                    </div>
                    <div class="field">
                        <div class="f16 f16txt">身分證字號（第一個英文字需大寫）</div>
                        <input class="string optional w90 string required form-control" type="text"
                            value="{{ $user->id_card_number}}" name="id_card_number" id="id_card_number"
                            <?=($user->user_state == '2' || $user->user_state == '1')?'disabled' :'' ;?> maxlength="10"
                            required>

                    </div>
                    <div class="field">
                        <div class="f16 f16txt">出生日期</div>
                        <input type="text" id="birthday" name="birthday"
                            class=" w90 datepicker form-control datepicker_style" value="{{ $user->birthday}}"
                            <?=($user->user_state == '2' || $user->user_state == '1')?'disabled' :'' ;?> required>

                        <br>
                        <span class="f14">
                            <i class="fa fa-info-circle" aria-hidden="true"></i> 若您未滿 20 歲，將無法認購債權。
                        </span>
                    </div>
                    <div class="field">
                        <div class="f16 f16txt">戶籍地址</div>
                        <div class="place-select">
                            <select data-type="residence"
                                class="select optional select optional form-control add_select" name="residence_country"
                                id="residence_country"
                                <?=($user->user_state == '2' || $user->user_state == '1')?'disabled' :'' ;?> required>
                            </select>
                        </div>
                        <div class="place-select">
                            <select class="select optional select optional form-control" name="residence_district"
                                id="residence_district"
                                <?=($user->user_state == '2' || $user->user_state == '1')?'disabled' :'' ;?> required>

                            </select>
                        </div>
                        <div class="place-input">
                            <input class="form-control" type="text" value="{{ $user->residence_address }}"
                                name="residence_address" id="residence_address"
                                <?=($user->user_state == '2' || $user->user_state == '1')?'disabled' :'' ;?> required>
                        </div>

                    </div>
                    <div class="field">
                        <div class="f16 f16txt">通訊地址
                            <label class="f14">
                                <input id="the_same_address" type="checkbox" value=""
                                    <?=($user->user_state == '2')?'disabled' :'' ;?>> 通訊地址同戶籍地址
                            </label>
                        </div>
                        <div class="place-select">
                            <select data-type="contact" class="select optional select optional form-control  add_select"
                                value="{{ $user->contact_country }}" name="contact_country" id="contact_country"
                                <?=($user->user_state == '2')?'disabled' :'' ;?> required>

                            </select>
                        </div>
                        <div class="place-select">
                            <select class="select optional select optional form-control" name="contact_district"
                                id="contact_district" <?=($user->user_state == '2')?'disabled' :'' ;?> required>

                            </select>
                        </div>
                        <div class="place-input">
                            <input class="form-control" type="text" value="{{ $user->contact_address }}"
                                name="contact_address" id="contact_address"
                                <?=($user->user_state == '2')?'disabled' :'' ;?> required>
                        </div>

                    </div>
                </div>

                <div class="col-55 ">
                    <div class="f20m f20mborder"><img src="/images/member2.png" alt=""> 上傳身分證</div>
                    <div class="file_wrap">

                        <div class="upload-wrap">
                            <div class="file_bold"> 上傳身分證正面</div>

                            <div class="fluid_div" style="background-image: url({{ asset('/images/fileup.png') }});">
                                @if($user->user_state==1)  
                                <img class="ui fluid image" id="preview-new-cert1" alt=""
                                    src="/users/font_img<?//=($user->user_state > 0 && $user->user_state != 3)? asset($user->id_front_file_name) :'';?>">
                                @else  
                                <img class="ui fluid image" id="preview-new-cert1" alt=""
                                    src="/users/font_img_r_2<?//=($user->user_state > 0 && $user->user_state != 3)? asset($user->id_front_file_name) :'';?>">  
                                @endif

                            </div>
                            {{-- //20200304 Jason 修改S --}}

                            <div class="form-group file required user_id_back">
                                <input class="m_t_2" name="id_front_file_name" data-type="cert1"
                                    onchange="readURL(this)" type="file" {{$userPictureAttr}}>
                            </div>

                            <div class="btn btn-secondary" style="display: block; margin: auto;">點擊上傳</div>
                            {{-- <div class="color_file"><i class="fa fa-info-circle" aria-hidden="true"></i> 圖片尺寸需至少
                                    1024 x786 以上</div> --}}
                            <div class="color_file">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                {{config('fileSizeLimit.users_info_id_file')}}MB以下
                            </div>
                            {{-- //20200304 Jason 修改E --}}

                        </div>

                    </div>

                    <div class="file_wrap">

                        <div class="upload-wrap">
                            <div class="file_bold"> 上傳身分證背面</div>

                            <div class="fluid_div" style="background-image: url({{ asset('/images/fileup2.png') }});">
                                @if($user->user_state==1)  
                                <img class="ui fluid image" id="preview-new-cert2" alt=""
                                    src="/users/back_img<?//=($user->user_state > 0 && $user->user_state != 3)? asset($user->id_back_file_name) :'';?>">
                                @else
                                <img class="ui fluid image" id="preview-new-cert2" alt=""
                                    src="/users/back_img_r_2<?//=($user->user_state > 0 && $user->user_state != 3)? asset($user->id_back_file_name) :'';?>">
                                @endif    
                            </div>

                            {{-- //20200304 Jason 修改S --}}
                            <div class="form-group file required user_id_back">
                                <input class="m_t_2" name="id_back_file_name" data-type="cert2" onchange="readURL(this)"
                                    type="file" {{$userPictureAttr}}>
                            </div>
                            <div class="btn btn-secondary" style="display: block; margin: auto;">點擊上傳</div>

                            {{-- <div class="color_file">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i> 圖片尺寸需至少
                                    1024 x786 以上
                                </div> --}}
                            <div class="color_file">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                {{config('fileSizeLimit.users_info_id_file')}}MB以下
                            </div>

                            {{-- //20200304 Jason 修改E --}}

                        </div>

                    </div>

                </div>

                {{-- <form id="mobile_form">
                    @csrf --}}
                @if($user->user_state!==1)   
                <div class="col-55 pd40">
                    <div class="f20m f20mborder "><img src="/images/member3.png" alt=""> 手機號碼驗證</div>

                    <div class="field">
                        <div class="f16 f16txt">
                            手機號碼
                            <p style="color:red;">驗證碼將於發送 5 分鐘內失效</p>
                        </div>

                        {{-- <input class="form-control w30"
                                style="text-align: center; padding-left: 12px; margin: auto 5px auto 0px;padding-top: 10px;"
                                type="text" value="+886" name="" id="" disabled> --}}
                        <input class="form-control w60" style="width: 70%; float:left" type="text"
                            value="{{ $user->phone_number }}" maxlength="10" name="phone_number" id="phone_number"
                            <?=($user->user_state == '2')?'disabled' :'' ;?> required>

                        <div class="w30 w31" style="display:inline-block" id="mobile_check_btn_area">

                        </div>
                    </div>

                    <div class="field" id="mobile_check_token_area">

                    </div>

                </div>
                @endif
                {{-- </form> --}}

            </div>
            <div class="member_footer">
                @if($user->user_state!==1) 
                <button type="submit" class="btn form_bt pull-left m-r-5 footer_btn"
                    <?=($user->user_state == '2')?'disabled' :'' ;?>><?=($user->user_state == '2')?'審核中' :'提交審核' ;?></button>
                
                <span class="f14 pp">
                    <p id="status_message" style="color:red;"></p>
                </span>
                
                <span class="f14 pp">
                    <i class="fa fa-info-circle" aria-hidden="true"></i> 您的個人資料與交易有關，如需修改請洽客服專線：02-5562-9111
                </span>
                @elseif($user->user_state==1)
                <span class="f14">
                    <i class="fa fa-info-circle" aria-hidden="true"></i> 您的個人資料與交易有關，如需修改請洽客服專線：02-5562-9111
                </span>
                @endif

            </div>


        </div>
    </div>
</form>

</div>


</body>

</html>





<script type="text/javascript" src="/js/daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="/js/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="/js/daterangepicker/daterangepicker.css" />

@if(isset($add_success) && $add_success == true)
<script>
    swal('提示', '新增成功，審核中！', 'success');

</script>
@endif
<script>
    var u_state = "{{ Auth::user()->user_state }}";
    var u_phone = "{{ $user->phone_number }}";

    switch (u_state) {
        case "3":
            show_confirm_mobile();
            break;
        case "2":
            //disabled
            break;
        default:
            phone_change_listen();
            break;
    }

    //顯示
    function show_confirm_mobile() {
        let btn = confirm_mobile_btn_area_temp();
        $("#mobile_check_btn_area").append(btn);
        let input = confirm_mobile_token_area_temp();
        $("#mobile_check_token_area").append(input);
        // mobile_check_btn_listen();
    }

    function confirm_mobile_btn_area_temp() {
        return `
        <button name="button" type="button" id="mobile-check" class="btn form_bt m-r-10 pull-left">發送驗證碼</button>
        `;
    }

    function confirm_mobile_token_area_temp() {
        return `
            <div class="f16 f16txt">驗證碼</div>
            <input type="text" id="mobile_check_token" name="check_token" class="form-control w90" placeholder="" required>
        `;
    }

    function checkIsShowing() {
        let obj = $("#mobile-check");
        if (obj.length > 0) {
            return true;
        } else {
            return false;
        }
    }
    //phone listener
    function phone_change_listen() {
        $("#phone_number").keyup(function () {
            if ($(this).val().length == 10) {
                if ($(this).val() != u_phone) {
                    if (!checkIsShowing()) {
                        show_confirm_mobile();
                    }
                } else {
                    $("#mobile_check_btn_area").empty();
                    $("#mobile_check_token_area").empty();
                }
            }

        })
    }

    $("#mobile_form").submit(function () {

        var id_num = /^[A-Z][12]\d{8}$/;
        var phone_num = /^[0-9]*$/;

        var user_id_num = $('#id_card_number').val();
        var user_phone_num = $('#phone_number').val();

        if (!id_num.test(user_id_num)) {

            swal('提示', '身分證格式錯誤！', 'error');
            return false


        } else if (!phone_num.test(user_phone_num)) {

            swal('提示', '手機號碼格式錯誤！', 'error');

            return false

        } else if (user_phone_num.length < 9) {

            swal('提示', '手機號碼字數錯誤！', 'error');

            return false

        }
    });

    // function mobile_check_btn_listen() {
        $('#mobile-check').click(function () {

            var phone_num = /^[0-9]*$/;
            var user_phone_num = $('#phone_number').val();

            if (user_phone_num == '') {

                swal('提示', '請填寫手機號碼！', 'error');

            } else if (!phone_num.test(user_phone_num)) {

                swal('提示', '手機號碼格式錯誤！', 'error');

            } else if (user_phone_num.length < 9) {

                swal('提示', '手機號碼字數錯誤！', 'error');


            } else {

                $.ajax({
                    type: "POST",
                    url: "/user/sendPhoneMsg",
                    dataType: "json",
                    data: $('#mobile_form').serialize(),
                    success: function (data) {
                        if (data.success) {
                            swal('提示', '已寄送', 'success');
                        }else{
                            swal('提示', "五分鐘內只可提交二次", 'info');
                            // swal('提示', "五分鐘內只可提交二次</br>24小時內最多只能提交10次", 'error');
                        }
                    }
                });
            }
        });
    // }
    // mobile_check_btn_listen();



    $(function () {
        $(".datepicker").unbind().datepicker({
            autoUpdateInput: false,
            format: "yyyy-mm-dd",
            singleDatePicker: true,
            showDropdowns: true,
            language: 'zh-TW',
            todayHighlight: true, //是否今日高亮
            startDate: moment().subtract(100, 'year').toDate(), //最小日期，100年
            endDate: moment().toDate() //最晚月份
        });

        // $('.datepicker').daterangepicker({
        //     autoUpdateInput: false,
        //     locale: {
        //         format: "YYYY-MM-DD",
        //     },
        //     singleDatePicker: true,
        //     showDropdowns: true,
        //     minYear: 1901,
        //     maxYear: 3000,
        // });

        $('.datepicker').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD'));
        });

    });


    function readURL(input) {
        let fileSize = ($(input)[0].files[0].size / 1024 / 1024).toFixed(2);
        //當檔案大小大於系統指定大小
        if (fileSize > "{{ config('fileSizeLimit.users_info_id_file') }}") {
            something_happens($(input));
            swal("提示", `您所選擇上傳的檔案大小為 ${fileSize}MB 超過上限 ({{config('fileSizeLimit.users_info_id_file')}}MB)`, "error");
            return false;
        }

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#preview-new-' + $(input).data('type')).attr('src', e.target.result);
                $('#preview-new-' + $(input).data('type')).show();
                $('#preview-new-' + $(input).data('type')).attr('hidden', false);
                $('#preview-' + $(input).data('type')).hide();
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function something_happens(input) {
        input.replaceWith(input.val('').clone(true));
    };

    $(document).ready(function () {
        let districtList = {
            '請選擇': [],
            '臺北市': [
                '中正區', '大同區', '中山區', '萬華區', '信義區', '松山區', '大安區', '南港區', '北投區', '內湖區', '士林區', '文山區'
            ],
            '新北市': [
                '板橋區', '新莊區', '泰山區', '林口區', '淡水區', '金山區', '八里區', '萬里區', '石門區', '三芝區', '瑞芳區', '汐止區',
                '平溪區', '貢寮區', '雙溪區', '深坑區', '石碇區', '新店區', '坪林區', '烏來區', '中和區', '永和區', '土城區', '三峽區',
                '樹林區', '鶯歌區', '三重區', '蘆洲區', '五股區'
            ],
            '基隆市': [
                '仁愛區', '中正區', '信義區', '中山區', '安樂區', '暖暖區', '七堵區'
            ],
            '桃園市': [
                '桃園區', '中壢區', '平鎮區', '八德區', '楊梅區', '蘆竹區', '龜山區', '龍潭區', '大溪區', '大園區', '觀音區', '新屋區',
                '復興區'
            ],
            '新竹縣': [
                '竹北市', '竹東鎮', '新埔鎮', '關西鎮', '峨眉鄉', '寶山鄉', '北埔鄉', '橫山鄉', '芎林鄉', '湖口鄉', '新豐鄉', '尖石鄉',
                '五峰鄉'
            ],
            '新竹市': [
                '東區', '北區', '香山區'
            ],
            '苗栗縣': [
                '苗栗市', '通霄鎮', '苑裡鎮', '竹南鎮', '頭份鎮', '後龍鎮', '卓蘭鎮', '西湖鄉', '頭屋鄉', '公館鄉', '銅鑼鄉', '三義鄉',
                '造橋鄉', '三灣鄉', '南庄鄉', '大湖鄉', '獅潭鄉', '泰安鄉'
            ],
            '臺中市': [
                '中區', '東區', '南區', '西區', '北區', '北屯區', '西屯區', '南屯區', '太平區', '大里區', '霧峰區', '烏日區', '豐原區',
                '后里區', '東勢區', '石岡區', '新社區', '和平區', '神岡區', '潭子區', '大雅區', '大肚區', '龍井區', '沙鹿區', '梧棲區',
                '清水區', '大甲區', '外埔區', '大安區'
            ],
            '南投縣': [
                '南投市', '埔里鎮', '草屯鎮', '竹山鎮', '集集鎮', '名間鄉', '鹿谷鄉', '中寮鄉', '魚池鄉', '國姓鄉', '水里鄉', '信義鄉',
                '仁愛鄉'
            ],
            '彰化縣': [
                '彰化市', '員林鎮', '和美鎮', '鹿港鎮', '溪湖鎮', '二林鎮', '田中鎮', '北斗鎮', '花壇鄉', '芬園鄉', '大村鄉', '永靖鄉',
                '伸港鄉', '線西鄉', '福興鄉', '秀水鄉', '埔心鄉', '埔鹽鄉', '大城鄉', '芳苑鄉', '竹塘鄉', '社頭鄉', '二水鄉', '田尾鄉',
                '埤頭鄉', '溪州鄉'
            ],
            '雲林縣': [
                '斗六市', '斗南鎮', '虎尾鎮', '西螺鎮', '土庫鎮', '北港鎮', '莿桐鄉', '林內鄉', '古坑鄉', '大埤鄉', '崙背鄉', '二崙鄉',
                '麥寮鄉', '臺西鄉', '東勢鄉', '褒忠鄉', '四湖鄉', '口湖鄉', '水林鄉', '元長鄉'
            ],
            '嘉義縣': [
                '太保市', '朴子市', '布袋鎮', '大林鎮', '民雄鄉', '溪口鄉', '新港鄉', '六腳鄉', '東石鄉', '義竹鄉', '鹿草鄉', '水上鄉',
                '中埔鄉', '竹崎鄉', '梅山鄉', '番路鄉', '大埔鄉', '阿里山鄉'
            ],
            '嘉義市': [
                '東區', '西區'
            ],
            '臺南市': [
                '中西區', '東區', '南區', '北區', '安平區', '安南區', '永康區', '歸仁區', '新化區', '左鎮區', '玉井區', '楠西區', '南化區',
                '仁德區', '關廟區', '龍崎區', '官田區', '麻豆區', '佳里區', '西港區', '七股區', '將軍區', '學甲區', '北門區', '新營區',
                '後壁區', '白河區', '東山區', '六甲區', '下營區', '柳營區', '鹽水區', '善化區', '大內區', '山上區', '新市區', '安定區'
            ],
            '高雄市': [
                '楠梓區', '左營區', '鼓山區', '三民區', '鹽埕區', '前金區', '新興區', '苓雅區', '前鎮區', '小港區', '旗津區', '鳳山區',
                '大寮區', '鳥松區', '林園區', '仁武區', '大樹區', '大社區', '岡山區', '路竹區', '橋頭區', '梓官區', '彌陀區', '永安區',
                '燕巢區', '田寮區', '阿蓮區', '茄萣區', '湖內區', '旗山區', '美濃區', '內門區', '杉林區', '甲仙區', '六龜區', '茂林區',
                '桃源區', '那瑪夏區'
            ],
            '屏東縣': [
                '屏東市', '潮州鎮', '東港鎮', '恆春鎮', '萬丹鄉', '長治鄉', '麟洛鄉', '九如鄉', '里港鄉', '鹽埔鄉', '高樹鄉', '萬巒鄉',
                '內埔鄉', '竹田鄉', '新埤鄉', '枋寮鄉', '新園鄉', '崁頂鄉', '林邊鄉', '南州鄉', '佳冬鄉', '琉球鄉', '車城鄉', '滿州鄉',
                '枋山鄉', '霧台鄉', '瑪家鄉', '泰武鄉', '來義鄉', '春日鄉', '獅子鄉', '牡丹鄉', '三地門鄉'
            ],
            '宜蘭縣': [
                '宜蘭市', '羅東鎮', '蘇澳鎮', '頭城鎮', '礁溪鄉', '壯圍鄉', '員山鄉', '冬山鄉', '五結鄉', '三星鄉', '大同鄉', '南澳鄉'
            ],
            '花蓮縣': [
                '花蓮市', '鳳林鎮', '玉里鎮', '新城鄉', '吉安鄉', '壽豐鄉', '秀林鄉', '光復鄉', '豐濱鄉', '瑞穗鄉', '萬榮鄉', '富里鄉',
                '卓溪鄉'
            ],
            '臺東縣': [
                '臺東市', '成功鎮', '關山鎮', '長濱鄉', '海端鄉', '池上鄉', '東河鄉', '鹿野鄉', '延平鄉', '卑南鄉', '金峰鄉', '大武鄉',
                '達仁鄉', '綠島鄉', '蘭嶼鄉', '太麻里鄉'
            ],
            '澎湖縣': [
                '馬公市', '湖西鄉', '白沙鄉', '西嶼鄉', '望安鄉', '七美鄉'
            ],
            '金門縣': [
                '金城鎮', '金湖鎮', '金沙鎮', '金寧鄉', '烈嶼鄉', '烏坵鄉'
            ],
            '連江縣': [
                '南竿鄉', '北竿鄉', '莒光鄉', '東引鄉'
            ]
        };


        // let districtList = {
        //     "請選擇": [],
        //     "臺北市": [],
        //     "新北市": [],
        //     "桃園市": [],
        //     "臺中市": [],
        //     "臺南市": [],
        //     "高雄市": [],
        //     "基隆市": [],
        //     "新竹市": [],
        //     "嘉義市": [],
        //     "新竹縣": [],
        //     "苗栗縣": [],
        //     "彰化縣": [],
        //     "南投縣": [],
        //     "雲林縣": [],
        //     "嘉義縣": [],
        //     "屏東縣": [],
        //     "宜蘭縣": [],
        //     "花蓮縣": [],
        //     "臺東縣": [],
        //     "澎湖縣": [],
        //     "金門縣": [],
        //     "連江縣": []
        // }




        // districtList["基隆市"].push("仁愛區");
        // districtList["基隆市"].push("信義區");
        // districtList["基隆市"].push("中正區");
        // districtList["基隆市"].push("中山區");
        // districtList["基隆市"].push("安樂區");
        // districtList["基隆市"].push("暖暖區");
        // districtList["基隆市"].push("七堵區");

        // districtList["臺北市"].push("中正區");
        // districtList["臺北市"].push("大同區");
        // districtList["臺北市"].push("中山區");
        // districtList["臺北市"].push("松山區");
        // districtList["臺北市"].push("大安區");
        // districtList["臺北市"].push("萬華區");
        // districtList["臺北市"].push("信義區");
        // districtList["臺北市"].push("士林區");
        // districtList["臺北市"].push("北投區");
        // districtList["臺北市"].push("內湖區");
        // districtList["臺北市"].push("南港區");
        // districtList["臺北市"].push("文山區");


        // districtList["新北市"].push("萬里區");
        // districtList["新北市"].push("金山區");
        // districtList["新北市"].push("板橋區");
        // districtList["新北市"].push("汐止區");
        // districtList["新北市"].push("深坑區");
        // districtList["新北市"].push("石碇區");
        // districtList["新北市"].push("瑞芳區");
        // districtList["新北市"].push("平溪區");
        // districtList["新北市"].push("雙溪區");
        // districtList["新北市"].push("貢寮區");
        // districtList["新北市"].push("新店區");
        // districtList["新北市"].push("坪林區");
        // districtList["新北市"].push("烏來區");
        // districtList["新北市"].push("永和區");
        // districtList["新北市"].push("中和區");
        // districtList["新北市"].push("土城區");
        // districtList["新北市"].push("三峽區");
        // districtList["新北市"].push("樹林區");
        // districtList["新北市"].push("鶯歌區");
        // districtList["新北市"].push("三重區");
        // districtList["新北市"].push("新莊區");
        // districtList["新北市"].push("泰山區");
        // districtList["新北市"].push("林口區");
        // districtList["新北市"].push("蘆洲區");
        // districtList["新北市"].push("五股區");
        // districtList["新北市"].push("八里區");
        // districtList["新北市"].push("淡水區");
        // districtList["新北市"].push("三芝區");
        // districtList["新北市"].push("石門區");

        // districtList["桃園市"].push("中壢區");
        // districtList["桃園市"].push("平鎮區");
        // districtList["桃園市"].push("龍潭區");
        // districtList["桃園市"].push("楊梅區");
        // districtList["桃園市"].push("新屋區");
        // districtList["桃園市"].push("觀音區");
        // districtList["桃園市"].push("桃園區");
        // districtList["桃園市"].push("龜山區");
        // districtList["桃園市"].push("八德區");
        // districtList["桃園市"].push("大溪區");
        // districtList["桃園市"].push("復興區");
        // districtList["桃園市"].push("大園區");
        // districtList["桃園市"].push("蘆竹區");

        // districtList["新竹市"].push("東區");
        // districtList["新竹市"].push("北區");
        // districtList["新竹市"].push("香山區");

        // districtList["新竹縣"].push("竹北市");
        // districtList["新竹縣"].push("湖口鄉");
        // districtList["新竹縣"].push("新豐鄉");
        // districtList["新竹縣"].push("新埔鎮");
        // districtList["新竹縣"].push("關西鎮");
        // districtList["新竹縣"].push("芎林鄉");
        // districtList["新竹縣"].push("寶山鄉");
        // districtList["新竹縣"].push("竹東鎮");
        // districtList["新竹縣"].push("五峰鄉");
        // districtList["新竹縣"].push("橫山鄉");
        // districtList["新竹縣"].push("尖石鄉");
        // districtList["新竹縣"].push("北埔鄉");
        // districtList["新竹縣"].push("峨眉鄉");

        // districtList["苗栗縣"].push("竹南鎮");
        // districtList["苗栗縣"].push("頭份市");
        // districtList["苗栗縣"].push("三灣鄉");
        // districtList["苗栗縣"].push("南庄鄉");
        // districtList["苗栗縣"].push("獅潭鄉");
        // districtList["苗栗縣"].push("後龍鎮");
        // districtList["苗栗縣"].push("通霄鎮");
        // districtList["苗栗縣"].push("苑裡鎮");
        // districtList["苗栗縣"].push("苗栗市");
        // districtList["苗栗縣"].push("造橋鄉");
        // districtList["苗栗縣"].push("頭屋鄉");
        // districtList["苗栗縣"].push("公館鄉");
        // districtList["苗栗縣"].push("大湖鄉");
        // districtList["苗栗縣"].push("泰安鄉");
        // districtList["苗栗縣"].push("銅鑼鄉");
        // districtList["苗栗縣"].push("三義鄉");
        // districtList["苗栗縣"].push("西湖鄉");
        // districtList["苗栗縣"].push("卓蘭鎮");

        // districtList["臺中市"].push("中區");
        // districtList["臺中市"].push("東區");
        // districtList["臺中市"].push("南區");
        // districtList["臺中市"].push("西區");
        // districtList["臺中市"].push("北區");
        // districtList["臺中市"].push("北屯區");
        // districtList["臺中市"].push("西屯區");
        // districtList["臺中市"].push("南屯區");
        // districtList["臺中市"].push("太平區");
        // districtList["臺中市"].push("大里區");
        // districtList["臺中市"].push("霧峰區");
        // districtList["臺中市"].push("烏日區");
        // districtList["臺中市"].push("豐原區");
        // districtList["臺中市"].push("后里區");
        // districtList["臺中市"].push("石岡區");
        // districtList["臺中市"].push("東勢區");
        // districtList["臺中市"].push("和平區");
        // districtList["臺中市"].push("新社區");
        // districtList["臺中市"].push("潭子區");
        // districtList["臺中市"].push("大雅區");
        // districtList["臺中市"].push("神岡區");
        // districtList["臺中市"].push("大肚區");
        // districtList["臺中市"].push("沙鹿區");
        // districtList["臺中市"].push("龍井區");
        // districtList["臺中市"].push("梧棲區");
        // districtList["臺中市"].push("清水區");
        // districtList["臺中市"].push("大甲區");
        // districtList["臺中市"].push("外埔區");
        // districtList["臺中市"].push("大安區");

        // districtList["彰化縣"].push("彰化市");
        // districtList["彰化縣"].push("芬園鄉");
        // districtList["彰化縣"].push("花壇鄉");
        // districtList["彰化縣"].push("秀水鄉");
        // districtList["彰化縣"].push("鹿港鎮");
        // districtList["彰化縣"].push("福興鄉");
        // districtList["彰化縣"].push("線西鄉");
        // districtList["彰化縣"].push("和美鎮");
        // districtList["彰化縣"].push("伸港鄉");
        // districtList["彰化縣"].push("員林市");
        // districtList["彰化縣"].push("社頭鄉");
        // districtList["彰化縣"].push("永靖鄉");
        // districtList["彰化縣"].push("埔心鄉");
        // districtList["彰化縣"].push("溪湖鎮");
        // districtList["彰化縣"].push("大村鄉");
        // districtList["彰化縣"].push("埔鹽鄉");
        // districtList["彰化縣"].push("田中鎮");
        // districtList["彰化縣"].push("北斗鎮");
        // districtList["彰化縣"].push("田尾鄉");
        // districtList["彰化縣"].push("埤頭鄉");
        // districtList["彰化縣"].push("溪州鄉");
        // districtList["彰化縣"].push("竹塘鄉");
        // districtList["彰化縣"].push("二林鎮");
        // districtList["彰化縣"].push("大城鄉");
        // districtList["彰化縣"].push("芳苑鄉");
        // districtList["彰化縣"].push("二水鄉");

        // districtList["南投縣"].push("南投市");
        // districtList["南投縣"].push("中寮鄉");
        // districtList["南投縣"].push("草屯鎮");
        // districtList["南投縣"].push("國姓鄉");
        // districtList["南投縣"].push("埔里鎮");
        // districtList["南投縣"].push("仁愛鄉");
        // districtList["南投縣"].push("名間鄉");
        // districtList["南投縣"].push("集集鎮");
        // districtList["南投縣"].push("水里鄉");
        // districtList["南投縣"].push("魚池鄉");
        // districtList["南投縣"].push("信義鄉");
        // districtList["南投縣"].push("竹山鎮");
        // districtList["南投縣"].push("鹿谷鄉");

        // districtList["雲林縣"].push("斗南鎮");
        // districtList["雲林縣"].push("大埤鄉");
        // districtList["雲林縣"].push("虎尾鎮");
        // districtList["雲林縣"].push("土庫鎮");
        // districtList["雲林縣"].push("褒忠鄉");
        // districtList["雲林縣"].push("東勢鄉");
        // districtList["雲林縣"].push("臺西鄉");
        // districtList["雲林縣"].push("崙背鄉");
        // districtList["雲林縣"].push("麥寮鄉");
        // districtList["雲林縣"].push("斗六市");
        // districtList["雲林縣"].push("林內鄉");
        // districtList["雲林縣"].push("古坑鄉");
        // districtList["雲林縣"].push("莿桐鄉");
        // districtList["雲林縣"].push("西螺鎮");
        // districtList["雲林縣"].push("二崙鄉");
        // districtList["雲林縣"].push("北港鎮");
        // districtList["雲林縣"].push("水林鄉");
        // districtList["雲林縣"].push("口湖鄉");
        // districtList["雲林縣"].push("四湖鄉");
        // districtList["雲林縣"].push("元長鄉");

        // districtList["嘉義市"].push("東區");
        // districtList["嘉義市"].push("西區");

        // districtList["嘉義縣"].push("番路鄉");
        // districtList["嘉義縣"].push("梅山鄉");
        // districtList["嘉義縣"].push("竹崎鄉");
        // districtList["嘉義縣"].push("阿里山鄉");
        // districtList["嘉義縣"].push("中埔鄉");
        // districtList["嘉義縣"].push("大埔鄉");
        // districtList["嘉義縣"].push("水上鄉");
        // districtList["嘉義縣"].push("鹿草鄉");
        // districtList["嘉義縣"].push("太保市");
        // districtList["嘉義縣"].push("朴子市");
        // districtList["嘉義縣"].push("東石鄉");
        // districtList["嘉義縣"].push("六腳鄉");
        // districtList["嘉義縣"].push("新港鄉");
        // districtList["嘉義縣"].push("民雄鄉");
        // districtList["嘉義縣"].push("大林鎮");
        // districtList["嘉義縣"].push("溪口鄉");
        // districtList["嘉義縣"].push("義竹鄉");
        // districtList["嘉義縣"].push("布袋鎮");

        // districtList["臺南市"].push("中西區");
        // districtList["臺南市"].push("東區");
        // districtList["臺南市"].push("南區");
        // districtList["臺南市"].push("北區");
        // districtList["臺南市"].push("安平區");
        // districtList["臺南市"].push("安南區");
        // districtList["臺南市"].push("永康區");
        // districtList["臺南市"].push("歸仁區");
        // districtList["臺南市"].push("新化區");
        // districtList["臺南市"].push("左鎮區");
        // districtList["臺南市"].push("玉井區");
        // districtList["臺南市"].push("楠西區");
        // districtList["臺南市"].push("南化區");
        // districtList["臺南市"].push("仁德區");
        // districtList["臺南市"].push("關廟區");
        // districtList["臺南市"].push("龍崎區");
        // districtList["臺南市"].push("官田區");
        // districtList["臺南市"].push("麻豆區");
        // districtList["臺南市"].push("佳里區");
        // districtList["臺南市"].push("西港區");
        // districtList["臺南市"].push("七股區");
        // districtList["臺南市"].push("將軍區");
        // districtList["臺南市"].push("學甲區");
        // districtList["臺南市"].push("北門區");
        // districtList["臺南市"].push("新營區");
        // districtList["臺南市"].push("後壁區");
        // districtList["臺南市"].push("白河區");
        // districtList["臺南市"].push("東山區");
        // districtList["臺南市"].push("六甲區");
        // districtList["臺南市"].push("下營區");
        // districtList["臺南市"].push("柳營區");
        // districtList["臺南市"].push("鹽水區");
        // districtList["臺南市"].push("善化區");
        // districtList["臺南市"].push("大內區");
        // districtList["臺南市"].push("山上區");
        // districtList["臺南市"].push("新市區");
        // districtList["臺南市"].push("安定區");

        // districtList["高雄市"].push("新興區");
        // districtList["高雄市"].push("前金區");
        // districtList["高雄市"].push("苓雅區");
        // districtList["高雄市"].push("鹽埕區");
        // districtList["高雄市"].push("鼓山區");
        // districtList["高雄市"].push("旗津區");
        // districtList["高雄市"].push("前鎮區");
        // districtList["高雄市"].push("三民區");
        // districtList["高雄市"].push("楠梓區");
        // districtList["高雄市"].push("小港區");
        // districtList["高雄市"].push("左營區");
        // districtList["高雄市"].push("仁武區");
        // districtList["高雄市"].push("大社區");
        // districtList["高雄市"].push("東沙群島");
        // districtList["高雄市"].push("南沙群島");
        // districtList["高雄市"].push("岡山區");
        // districtList["高雄市"].push("路竹區");
        // districtList["高雄市"].push("阿蓮區");
        // districtList["高雄市"].push("田寮區");
        // districtList["高雄市"].push("燕巢區");
        // districtList["高雄市"].push("橋頭區");
        // districtList["高雄市"].push("梓官區");
        // districtList["高雄市"].push("彌陀區");
        // districtList["高雄市"].push("永安區");
        // districtList["高雄市"].push("湖內區");
        // districtList["高雄市"].push("鳳山區");
        // districtList["高雄市"].push("大寮區");
        // districtList["高雄市"].push("林園區");
        // districtList["高雄市"].push("鳥松區");
        // districtList["高雄市"].push("大樹區");
        // districtList["高雄市"].push("旗山區");
        // districtList["高雄市"].push("美濃區");


        var add_opt = '';

        $.each(districtList, function (k, v) {

            add_opt += "<option value='" + k + "'>" + k + "</option>";

        });

        $('#residence_country').html(add_opt);
        $('#contact_country').html(add_opt);



        $('.add_select').change(function () {

            var add = $(this).attr('data-type');

            var re_cou = $("#" + add + "_country").val();
            var cou_opt = '';

            $.each(districtList[re_cou], function (k, v) {

                cou_opt += "<option value='" + v + "'>" + v + "</option>";


            });

            $("#" + add + "_district").html(cou_opt);


        })



    });


    $('#the_same_address').prop('checked', false) // 預設不勾

    $('#the_same_address').click(function () {

        var isCheck = $('#the_same_address').prop('checked');

        var residence_country = $('#residence_country').html();
        var residence__c_select = $("#residence_country").val();

        var residence_district = $('#residence_district').html();
        var residence_d_select = $("#residence_district").val();


        var residence_address = $('#residence_address').val();


        if (isCheck == true) {

            $('#contact_country').html(residence_country);
            $('#contact_country').val(residence__c_select);


            $('#contact_district').html(residence_district);
            $('#contact_district').val(residence_d_select);


            $('#contact_address').val(residence_address);

        } else {

            $('#contact_address').val('');
            $('#contact_district').html("<option value='請選擇'>請選擇</option>");
            $('#contact_country').html(residence_country);

        }



    });

</script>


@if(isset($user->residence_country))
{{-- 當residence_country有資料 --}}
<script>
    setTimeout(function () {

        var user_residence_country = '{{ $user->residence_country }}';
        var user_residence_district = '{{ $user->residence_district}}';

        var user_contact_country = '{{ $user->contact_country }}';
        var user_contact_district = '{{ $user->contact_district}}';

        $("#residence_country").val(user_residence_country).change();
        $("#residence_district").val(user_residence_district);

        $("#contact_country").val(user_contact_country).change();
        $("#contact_district").val(user_contact_district);


    }, 100);

</script>
@else

@endif

@endsection
