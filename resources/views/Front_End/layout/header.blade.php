<!DOCTYPE html>
<html lang="tw" data-livestyle-extension="available">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="">
    <!-- Bootstrap -->
    <!--
    <link href="/css/elegant-icons-style.css" rel="stylesheet" /> -->
    <!-- <link type="text/css" rel="stylesheet" href="stylesheets/home.css?<?=time()?>"> -->
    <link rel="stylesheet" media="screen" href="/css/cumstom_style.css">
    <link rel="stylesheet" media="screen" href="/css/swiper.min.css">
    <link rel="stylesheet" media="screen" href="/css/banner.css">
    <link rel="stylesheet" media="screen" href="/css/hamburger.css" />
    <link rel="stylesheet" media="screen" href="/css/revision.css">
    <link rel="stylesheet" media="screen" href="/css/bootstrap.min.css">
    <link rel="stylesheet" media="screen" href="/css/bootstrap.css">
    <link rel="stylesheet" media="screen" href="/aos/aos.css">
    <link rel="stylesheet" media="screen" href="/css/footer.css">
    <link rel="stylesheet" media="screen" href="/css/main.css">
    <link rel="stylesheet" media="screen" href="/menu/style.css">
    <link rel="stylesheet" media="screen" href="/banner/css/style.css">
    <link rel="stylesheet" media="screen" href="/icon/css/font-awesome.min.css">
    <link rel="stylesheet" media="screen" href="/css/animate/animate.css">
    <link rel="stylesheet" media="screen" href="/css/normalize.css">
    <link rel="stylesheet" media="all" href="/css/application.css" data-turbolinks-track="reload"> <!-- aos動畫設定 -->
    <link href="/20210601/dist/aos/2.3.1/aos.css" rel="stylesheet">
    <script src="/20210601/dist/aos/2.3.1/aos.js"></script>

    <script type="application/javascript">
        (function (w, d, t, r, u) {
            w[u] = w[u] || [];
            w[u].push({
                'projectId': '10000',
                'properties': {
                    'pixelId': '10137964'
                }
            });
            var s = d.createElement(t);
            s.src = r;
            s.async = true;
            s.onload = s.onreadystatechange = function () {
                var y, rs = this.readyState,
                    c = w[u];
                if (rs && rs != "complete" && rs != "loaded") {
                    return
                }
                try {
                    y = YAHOO.ywa.I13N.fireBeacon;
                    w[u] = [];
                    w[u].push = function (p) {
                        y([p])
                    };
                    y(c)
                } catch (e) {}
            };
            var scr = d.getElementsByTagName(t)[0],
                par = scr.parentNode;
            par.insertBefore(s, scr)
        })(window, document, "script", "https://s.yimg.com/wi/ytc.js", "dotq");
    </script>
    <!-- Global site tag (gtag.js) - Google Ads: 650063903 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-650063903"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'AW-650063903');
    </script>

    <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}">

    <link rel="stylesheet" media="all"
        href="/assets/jquery/jquery.datetimepicker-687fd1e22bd02562a9edbd430eca033e571a906b22f03dc62156165bd34a1f64.css" />
    <!-- font awsome -->
    <!-- <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" /> -->
    <link rel="stylesheet" href="{{ asset('/fontawesome-5.13.0/css/all.css') }}">

    <!-- loading mask -->
    <link rel="stylesheet" href="{{ asset('css/cus-loading.css') }}">
    <title>豬豬在線</title>

    <meta name="csrf-param" content="authenticity_token" />
    <meta name="csrf-token"
        content="SX78TzL3VoriVxEm1TQExPM1KySIDQ/78G2hrPrmHNV0GSrjWbDFscBxPHbJ4fyfEId/1lMEtvMNzWK5pOzD7Q==" />
    <script src="/assets/application-5ca4b8eed6916a9f7317a002595ee96d299973a9e0ff3f0b399300210f30e9ce.js" data-turbolinks-track="reload"></script>
    <script src="/banner/js/jquery.js"></script>
    <script src="/aos/aos.js"></script>
    <script src="/menu/jquery.SuperSlide.2.1.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="/menu/nav.js?v=20181026"></script>
    <script src="/20210601/js/bootstrap/4.0.0/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type='text/javascript' src="/20210601/js/dataTables/1.10.19/jquery.dataTables.min.js"></script>
    <script src="/20210601/dist/infinite-scroll.pkgd.js"></script>
    <script src="/20210601/ajax/handlebars/4.0.11/handlebars.min.js"></script>
    <script src="/banner/js/slides.jquery.js"></script>
    <script src="/banner/js/main.js"></script>
    <script src="/js/goodpopup.min.js"></script>
    <script src="/20210601/js/Swiper/3.4.2/swiper.min.js"></script>
    
    <script src="/assets/jquery/jquery.datetimepicker.full-78d292ac53a74a4f2a40611d4e329de1be284d6b15a0c024d093edb6ef08f785.js"></script>

    <link rel="stylesheet" href="/20210601/ajax/Sweetalert2/6.10.3/sweetalert2.css" />
    <script src="/20210601/ajax/Sweetalert2/6.10.3/sweetalert2.js"
        type="text/javascript"></script>
    <script src="/js/jquery.loading.min.js"></script>
    <!-- Google Tag Manager -->

    <style>
        .dropdown_userMenu {
            border-radius: 0px;
            padding: 0px;
            margin: 0px;
            position: absolute;
            transform: translate3d(29px, 60px, 0px);
            top: 0px;
            left: 0px;
            will-change: transform;
        }
        .logo{ 
            width:200px;
        }
        #password {
            width: 87%;
            display: unset;
        }
        #nav-icon4:focus,#nav-icon4:active{
            outline:rgba(255,255,255,0);
        }
        @media (min-width: 768px){
            #footer_col8 {
                -webkit-box-flex: 0;
                -ms-flex: 0 0 59.666667%;
                flex: 0 0 59.666667%;
                max-width: 59.666667%;
                /* padding-left:210px; */
            }
            #footer_col4 {
                -webkit-box-flex: 0;
                -ms-flex: 0 0 40.333333%;
                flex: 0 0 40.333333%;
                max-width: 40.333333%;
                /* padding-right: 210px; */
            }
        }
        @media (max-width: 768px){
            #footer_col8 {
                padding-left:0px;
            }
            .c_d4 {
                text-align: left !important;
                margin-left: 10.5%;
            }
            #footer_col4 {
                padding-right: 0px;
            }
            .p12 {
                text-align: center;
            }
            #footer_col4 {
                -webkit-box-flex: unset;
                -ms-flex:unset;
                flex: unset;
                max-width: unset;
                padding-right: 30px;
            }
        }
        @media (max-width: 576px)
        {
            .c_d4 {
                text-align: left !important;
                margin-left: 10.5%;
            }
            .s_nav .nav-item {
                padding-top: 3px;
                padding-bottom: 3px;
            }
        }


    </style>

    <script>
        (function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-K95WMBG');
    </script>
    <!-- End Google Tag Manager -->
    <!-- Event snippet for 轉換_申請註冊完成 conversion page
        In your html page, add the snippet and call gtag_report_conversion when someone clicks on the chosen link or button. -->
    <script>
        function gtag_report_conversion(url) {
            var callback = function () {
                if (typeof (url) != 'undefined') {
                    window.location = url;
                }
            };
            gtag('event', 'conversion', {
                'send_to': 'AW-795592888/zBvjCKjhjYgBELiRr_sC',
                'event_callback': callback
            });
            return false;
        }

        function trackingGaEvent() {}

        trackingGaEvent()
    </script>

    <script>
        /* -------------------------------------------------------------------------- */
        /*                                 Login Mask                                 */
        /* -------------------------------------------------------------------------- */
        function loadingMask(show, text = false, textStyle = false) {
            if (text) {
                // loadText
                if (show == 'show') {
                    $("#loadingBlock").toggleClass('none', false);
                    $("#loadText").text(text);
                    if (textStyle) {
                        $("#loadText").attr('style', textStyle);
                    }
                } else if (show == 'hide') {
                    $("#loadingBlock").toggleClass('none', true);
                }
            } else {
                if (show == 'show') {
                    $("#loadingBlock").toggleClass('none', false);
                } else if (show == 'hide') {
                    $("#loadingBlock").toggleClass('none', true);
                }
            }
        }
    </script>
</head>
{{ csrf_field() }}

<?php
    
    if(empty($_SERVER["HTTPS"])) {
        $https_login = "https://" . $_SERVER["SERVER_NAME"] ;
        header("Location: $https_login");
        exit();
    }    
?>

<body>

    <div id="user_id" style="display:none"></div>

    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K95WMBG" height="0" width="0"
            style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->
<?
    if($_SERVER['REQUEST_URI'] =="/"){
        ?>
    <?/////////////////////////////////////////202107活動/////////////////////////////////////////?>
    <div class="fix_icon" style="top: 105px;">
        <a href="tel:0255629111" style="display:inline-block"><img src="{{asset('/images/tel.png')}}" width="40" alt="" style="display:block"></a>
        <a href="https://line.me/R/ti/p/%40sub9431m" target="_blank"><img src="{{asset('/images/line.png')}}" width="40" alt=""></a>
        <a href="https://m.me/pponline888?fbclid=IwAR3lUJZZYeN9WA175tbDehfFgp1sk84coSkBsuzCffFU0st3_5zjSYOHYqo" target="_blank"><img src="{{asset('/images/fb-message.png')}}" width="40" alt=""></a>
        <style>
            .event20210701{
                position: relative;
                left: -260px;
                top: 0px;
                animation:oo 3s infinite;
                animation-timing-function:linear /*速度曲線*/;
                animation-direction: alternate-reverse;
                animation-play-state:running;
            }
            @keyframes oo{ 100%{ top:200px; }}
            .e20210701w{ display:block;}
            .e20210701m{ display:none;}
            @media (max-width: 768px){
                .event20210701{
                    left:-67px;
                }
                .e20210701w{ display:none;}
                .e20210701m{ display:block;}
            }
        </style>
        <a href="/event/20210701/" target="_blank" class="event20210701"><img src="/event/20210701/banner.png"  alt="" class="e20210701w"><img src="/event/20210701/banner_m.png"  alt="" class="e20210701m"></a>
    </div>
    <?/////////////////////////////////////////202107活動/////////////////////////////////////////?>
    <?/////////////////////////////////////////202108豬豬在線2.0/////////////////////////////////////////?>
<style>
    .event_pp20{
        width:200px;
        height:200px;
        position:fixed;

        left:0%;
        bottom:0%;
        z-index:11;
        /* animation:pp20x 10s forwards ; */
        animation-timing-function:linear;
        animation-play-state:running;

    }
    .event_pp20_1{
        width:200px;
        height:200px;
        background-image:url(/event/20/star01.png);
        background-repeat:no-repeat;
        background-position:center center;
        background-size:100% 100%;
        position:absolute;
        /* animation:pp201x 10s forwards; */
        animation-timing-function:linear;
    }
    .event_pp20_2{
        width:200px;
        height:200px;
        background-image:url(/event/20/star.png);
        background-repeat:no-repeat;
        background-position:center center;
        background-size:100% 100%;
        position:absolute;
        /* animation:pp201x 10s forwards; */
        animation-timing-function:linear;
    }
    @media (max-width: 768px){
        .event_pp20{
            width:150px;
            height:150px;
        }
        .event_pp20_1{
            width:150px;
            height:150px;
            /* animation:pp202x 10s forwards; */
        }
        .event_pp20_2{
            width:150px;
            height:150px;
            /* animation:pp202x 10s forwards; */
        }
    }
    @media (max-width: 540px){
        .event_pp20{
            /* animation:pp21x 10s forwards ; */
        }
    }
    @keyframes pp20x {
        0% {
            left:0%;
            bottom:0%;
        }
        30% {
            left:0%;
            bottom:0%;
        }

        40% {
            left:55%;
            bottom:80%;
        }
        55% {
            left:80%;
            bottom:60%;
        }
        70%{
            left:0%;
            bottom:0%;
        }
        100%{
            left:0%;
            bottom:0%;
        }
    }
    @keyframes pp21x {
        0% {
            left:0%;
            bottom:0%;
        }
        30% {
            left:0%;
            bottom:0%;
        }
        40% {
            left:25%;
            bottom:70%;
        }
        55% {
            left:25%;
            bottom:60%;
        }
        70%{
            left:0%;
            bottom:0%;
        }
        100%{
            left:0%;
            bottom:0%;
        }
    }
    @keyframes pp201x {
        0% {
            width:200px;
            height:200px;
        }
        30% {
            width:200px;
            height:200px;
        }
        60% {
            width:400px;
            height:400px;
        }
        70%{
            width:200px;
            height:200px;
        }
        100%{
            width:200px;
            height:200px;
        }
    }
    @keyframes pp202x {
        0% {
            width:150px;
            height:150px;
        }
        30% {
            width:150px;
            height:150px;
        }
        60% {
            width:300px;
            height:300px;
        }
        70%{
            width:150px;
            height:150px;
        }
        100%{
            width:150px;
            height:150px;
        }
    }
</style>
    <a target="blank" href="/event/20/">
        <div class="event_pp20">
            <div class="event_pp20_1"></div>
            <div class="event_pp20_2"></div>
        </div>
    </a>
    <?/////////////////////////////////////////202108豬豬在線2.0/////////////////////////////////////////?>
        <?
    }else{
        ?>
    <div class="fix_icon" style="top: 205px;">
        <a href="tel:0255629111" style="display:inline-block"><img src="{{asset('/images/tel.png')}}" width="40" alt="" style="display:block"></a>
        <a href="https://line.me/R/ti/p/%40sub9431m" target="_blank"><img src="{{asset('/images/line.png')}}" width="40" alt=""></a>
        <a href="https://m.me/pponline888?fbclid=IwAR3lUJZZYeN9WA175tbDehfFgp1sk84coSkBsuzCffFU0st3_5zjSYOHYqo" target="_blank"><img src="{{asset('/images/fb-message.png')}}" width="40" alt=""></a>
    </div>
        <?
    }
 ?>
    <!--MobileHead-->
        <div class="mobile_nav">
            <nav class="navbar  fixed-top navbar-dark bg-dark s_nav navbar-fixed-top">
                <a class="navbar-brand" href="/"><img src="{{asset('../images/logo.png')}}" width="180" alt=""/></a>
                <button id="nav-icon4"class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample01" aria-controls="navbarsExample01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    <span class="navbar-toggler-icon"></span>
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarsExample01">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item home1">
                            <a href="/"><i class="fa fa-home" aria-hidden="true"></i> 首頁</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="/front/claim_category_special/1/9" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-usd" aria-hidden="true"></i> 投資認購</a>
                            <div class="dropdown-menu dobg" aria-labelledby="dropdown01">
                                <a class="dropdown-item" href="/front/claim_category_special/1/9">特別投資項目</a>
                                <a class="dropdown-item" href="/front/claim_category/1/9">智能媒合項目</a>
                                <a class="dropdown-item" href="/front/claim_category_history/1/108">已完成投資項目</a>

                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="/front/operation" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i> 操作指南</a>
                            <div class="dropdown-menu" aria-labelledby="dropdown01">
                                <a class="dropdown-item" href="/front/operation">投資專區</a>
                                <a class="dropdown-item" href="/front/operation#id3">資費說明</a>
                                <a class="dropdown-item" href="/front/operation_faq">常見問題</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="{{url('/front/about')}}" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-th-large" aria-hidden="true"></i> 關於我們</a>
                            <div class="dropdown-menu" aria-labelledby="dropdown01">
                                <a class="dropdown-item" href="/front/about">公司介紹</a>
                            <a class="dropdown-item" href="/front/about#id2">創辦人</a>
                            <a class="dropdown-item" href="/front/about#id3">法律顧問</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="https://loan.pponline.com.tw/" id="dropdown01" >
                            <!-- <i class="fa fa-file-text-o" aria-hidden="true"></i> -->
                            <i class="far fa-file-alt"></i>
                            貸款專區
                        </a>
                            <!-- <div class="dropdown-menu dobg" aria-labelledby="dropdown01">
                                <a class="dropdown-item" href="loan.html">貸款專區</a>
                                <a class="dropdown-item" href="loan.html#loan_from">貸款申請書</a>
                            </div> -->
                        </li>
                        <li class="nav-item dropdown">
                            @if(isset(Auth::user()->role_id) && Auth::user()->role_id == '1')
                            <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user-circle"></i>
                                {{Auth::user()->user_name}} 會員專區
                            </a>
                            <div class="dropdown-menu dobg" aria-labelledby="dropdown01">
                                <a class="dropdown-item" href="{{url('/front/myaccount')}}">我的帳戶</a>
                                <a class="dropdown-item" href="{{url('/users')}}">個人真實資訊</a>
                                <a class="dropdown-item" href="{{url('/users/tab_two')}}">銀行帳號</a>
                                <a class="dropdown-item" href="{{url('/users/tab_four')}}">投資習慣設定</a>
                                <a class="dropdown-item" href="{{url('/users/tab_five')}}">修改密碼</a>
                                <a class="dropdown-item" href="{{url('/front/payment')}}">繳款專區</a>
                                <a class="dropdown-item" href="{{url('/inbox_letters')}}">會員訊息</a>
                                <a class="dropdown-item" href="{{url('/users/pushhand')}}">豬豬推手</a>
                                <a class="dropdown-item" href="{{url('/users/weekly_claim_category')}}">系統自動投</a>
                                <a class="dropdown-item" href="{{url('/logout')}}">登出</a>
                            </div>
                            @elseif(isset(Auth::user()->role_id) && Auth::user()->role_id == '2')
                            <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user-circle"></i>
                                管理者 會員專區
                            </a>
                            <div class="dropdown-menu dobg" aria-labelledby="dropdown01">
                                <a class="dropdown-item m-dropdown-tiem  col-5" href="{{url('/home')}}">管理者後台</a>
                                <a class="dropdown-item m-dropdown-tiem  col-5" href="{{url('/logout')}}">登出</a>
                            </div>
                            @else
                            <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <!-- <i class="fa fa-user-circle-o" aria-hidden="true"></i> -->
                                <i class="fas fa-user-circle"></i>
                                會員登入 / 註冊
                            </a>
                            <div class="dropdown-menu dobg" aria-labelledby="dropdown01">
                                <a class="dropdown-item" href="{{ url('/users/sign_in') }}">會員登入</a>
                                <a class="dropdown-item" href="{{ url('/users/sign_up') }}">註冊會員</a>
                                <a class="dropdown-item"
                                    href="{{ url('/users/password_new') }}">忘記密碼</a>
                            </div>
                            @endif

                    </li>

                    </ul>
                    <!-- <form class="form-inline my-2 my-md-0">
              <input class="form-control" type="text" placeholder="Search" aria-label="Search">
            </form> -->
                </div>
            </nav>
        </div>
        <!--MobileHeadEnd-->
        <!--TopHead-->
        <div class="top-head" id="headdiv">
             <nav class="navbar navbar-dark bg-dark s_nav">
          <a class="navbar-brand" href="#"><img src="{{asset('../images/logo.png')}}" width="180" alt=""  /></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample01" aria-controls="navbarsExample01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarsExample01">
            <ul class="navbar-nav mr-auto" >
                 <li class="nav-item home1">
                <a href="/">首頁</a> 
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="/front/claim_category_special/1/9" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">投資認購</a>
                <div class="dropdown-menu dobg" aria-labelledby="dropdown01">
                  <a class="dropdown-item" href="/front/claim_category/1/9">智能媒合項目</a>
                  <a class="dropdown-item" href="/front/claim_category_special/1/9">特別投資項目</a>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="/front/operation" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">操作指南</a>
                <div class="dropdown-menu" aria-labelledby="dropdown01">
                    <a class="dropdown-item" href="/front/operation">投資專區</a>
                    <a class="dropdown-item" href="/front/operation_faq">常見問題</a>
                    <a class="dropdown-item" href="/front/operation#id3">資費說明</a>
                </div>
              </li>
             <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="/front/about" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">關於我們</a>
                <div class="dropdown-menu" aria-labelledby="dropdown01">
                    <a class="dropdown-item" href="/front/about">公司介紹</a>
                    <a class="dropdown-item" href="/front/about#id2">創辦人</a>
                    <a class="dropdown-item" href="/front/about#id3">法律顧問</a>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="{{url('/front/payment')}}" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">貸款專區</a>
                <div class="dropdown-menu dobg" aria-labelledby="dropdown01">
                  <a class="dropdown-item" href="https://loan.pponline.com.tw/">貸款專區</a>
                  <a class="dropdown-item" href="/front/loan#loan_form">貸款申請書</a>

                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">會員登入 / 註冊</a>
                <div class="dropdown-menu dobg" aria-labelledby="dropdown01">
                  <a class="dropdown-item" href="#">我的投資帳戶</a>
                  <a class="dropdown-item" href="#">會員資料設定</a>
                  <a class="dropdown-item" href="#">登出</a>
                </div>
              </li>
            </ul>
            <!-- <form class="form-inline my-2 my-md-0">
              <input class="form-control" type="text" placeholder="Search" aria-label="Search">
            </form> -->
          </div>
        </nav>
        <div class="top02" style="background-color:#fff;">
            <div class="top02_center" style="width:1200px;margin:0 auto;">
                <div class="logo">
                    <span class="logoa"><a href="/"><img src="{{asset('../images/logo.png')}}" width="200" alt="" /></a></span>
                    <span class="logob">

                        <a href="/"><img src="{{asset('../images/logo2.png')}}" width="200" alt="" /></a>

                    </span>
                </div>
                <div class="nav2">
                    <main>
                        <!-- <div class="btn-group" style="width:220px;" > -->
                        <div class="btn-group" style="width:220px">

                            <div class="dropdown show" style="width:100%">
                                <a class="btn btn-primary dropdown-toggle h60" href="#" role="button"
                                    id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"
                                    style="background: #ffb22c;border-radius: 0px; font-size: 14px;border-color: #ffb22c; width:100%;padding-top: 15px;">
                                    <img src="{{asset('../images/vip.png')}}" alt="" class="member">

                                    @if(isset(Auth::user()->role_id) && Auth::user()->role_id == '1')
                                        <?=Auth::user()->user_name?> 會員專區
                                    @elseif(isset(Auth::user()->role_id) && Auth::user()->role_id == '2')
                                        管理者 會員專區
                                    @else
                                        會員登入 / 註冊
                                    @endif
                                </a>
                                <div class="dropdown_userMenu dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                    @if(isset(Auth::user()->role_id) && Auth::user()->role_id == '1')
                                        <a class="dropdown-item" href="{{url('/front/myaccount')}}">
                                            <button class="dropdown-item vip_item" type="button">
                                                <i class="fa fa-line-chart" aria-hidden="true" style="color: #4887c7;padding-right: 10px;">
                                                    </i> 我的帳戶
                                            </button>
                                        </a>
                                        <a class="dropdown-item" href="{{url('/users')}}">
                                            <button class="dropdown-item vip_item" type="button">
                                                <i class="fa fa-address-card" aria-hidden="true" style="color: #4887c7;padding-right: 10px;">
                                                    </i> 個人真實資訊
                                            </button>
                                        </a>
                                        <a class="dropdown-item" href="{{url('/users/tab_two')}}">
                                            <button class="dropdown-item vip_item" type="button">
                                                <i class="fa fa-university" aria-hidden="true" style="color: #4887c7;padding-right: 10px;">
                                                    </i> 銀行帳號
                                            </button>
                                        </a>
                                        <a class="dropdown-item" href="{{url('/users/tab_four')}}">
                                            <button class="dropdown-item vip_item" type="button">
                                                <i class="fa fa-tasks" aria-hidden="true" style="color: #4887c7;padding-right: 10px;">
                                                    </i> 投資習慣設定
                                            </button>
                                        </a>
                                        <a class="dropdown-item" href="{{url('/users/tab_five')}}">
                                            <button class="dropdown-item vip_item" type="button">
                                                <i class="fa fa-ellipsis-h" aria-hidden="true" style="color: #4887c7;padding-right: 10px;">
                                                    </i> 修改密碼
                                            </button>
                                        </a>
                                        <a class="dropdown-item" href="{{url('/front/payment')}}">
                                            <button class="dropdown-item vip_item" type="button">
                                                <i class="fa fa-bar-chart" aria-hidden="true" style="color: #4887c7;padding-right: 10px;">
                                                    </i> 繳款專區
                                            </button>
                                        </a>
                                        <a class="dropdown-item" href="{{url('/inbox_letters')}}">
                                            <button class="dropdown-item vip_item" type="button">
                                                <i class="fa fa-circle" aria-hidden="true" style="color: #ffaf14;padding-right: 10px;">
                                                    </i> 會員訊息
                                            </button>
                                        </a>
                                        <a class="dropdown-item" href="{{url('/users/pushhand')}}">
                                            <button class="dropdown-item vip_item" type="button">
                                                <i class="fa fa-thumbs-up" aria-hidden="true" style="color: #4887c7;padding-right: 10px;">
                                                    </i> 豬豬推手
                                            </button>
                                        </a>
                                        <a class="dropdown-item" href="{{url('/users/weekly_claim_category')}}">
                                            <button class="dropdown-item vip_item" type="button">
                                                <i class="fa fa-hand-paper-o" aria-hidden="true" style="color: #4887c7;padding-right: 10px;">
                                                    </i> 系統自動投
                                            </button>
                                        </a>
                                        <a class="dropdown-item" href="{{url('/logout') }}">
                                            <button class="dropdown-item vip_item" type="button" style="color: #ffaf14;">
                                                <i class="fa fa-power-off" aria-hidden="true" style="color: #ffaf14;padding-right: 10px;">
                                                    </i>登出
                                            </button>
                                        </a>
                                    @elseif(isset(Auth::user()->role_id) && Auth::user()->role_id == '2')
                                
                                        <a class="dropdown-item" href="{{url('/home') }}">
                                            <button class="dropdown-item vip_item" type="button"  style="color: #00c1de;">
                                                <i class="fa fa-line-chart" aria-hidden="true" style="color: #00c1de;padding-right: 10px;">
                                                    </i>管理者後台
                                            </button>
                                        </a>
                                        <a class="dropdown-item" href="{{url('/logout') }}">
                                            <button class="dropdown-item vip_item" type="button"  style="color: #ffaf14;">
                                                <i class="fa fa-power-off" aria-hidden="true" style="color: #ffaf14;padding-right: 10px;">
                                                    </i>登出
                                            </button>
                                        </a>
                                    @else
                                        <form class="simple_form login-panel"  id="new_user" action="{{ url('/login') }}" method="POST" style="width:300px">
                                            {{ csrf_field() }}

                                            <input name="utf8" type="hidden" value="✓">
                                            <input type="hidden" name="authenticity_token" value="LN46/0C6LSh3Q6+wirjOwbPXyt8IgQtBbwI3blkw/K81VPV0m6qhCVMlpvdx2m5jHCbddj9htdJ6CMIS/pgTGg==">

                                            <div class="px-4 py-3">

                                                @if (session('emailConfirm'))
                                                    <div class="form-group f14">
                                                        <div class="alert alert-danger">
                                                            請完成Email驗證後再進行登入
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="form-group">
                                                    <label for="exampleDropdownFormEmail1">電子信箱</label>
                                                    <input id="username" type="text" class="page-signup-form-control form-control" placeholder="帳號" name="email" value="{{ old('username') }}" style="border-radius: 0;font-size: 14px;padding-top: 8px;padding-bottom: 8px;" required autofocus>
                                                    @if ($errors->has('username'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('username') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleDropdownFormPassword1">密碼</label>
                                                    <input id="password" type="password" class="page-signup-form-control form-control" placeholder="密碼" name="password" style="border-radius: 0;font-size: 14px;padding-top: 8px;padding-bottom: 8px;" required>
                                                    @if ($errors->has('password'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('password') }}</strong>
                                                        </span>
                                                    @endif
                                                    <i  class="fa fa-eye" aria-hidden="true" onclick='show_pw()'></i>
                                                </div>

                                                <div class="for">
                                                    <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                    <label class="form-check-label" for="dropdownCheck">
                                                        <a href="#" class="forget_pwd">
                                                        </a><a href="/users/password_new">忘記密碼</a>

                                                    </label>

                                                    <i class="fa fa-user-plus" aria-hidden="true" style="padding-left: 20px;"></i>
                                                    <label class="form-check-label" for="dropdownCheck">
                                                        <a href="/users/sign_up">註冊會員</a>
                                                    </label>

                                                </div>

                                                <div style="padding-top: 15px;">
                                                    <button type="submit" class="btn btn-primary login_bt" style="border-radius: 0;width: 100%; background-color: #00a5e4;
                                                            font-size: 13px;border-color: #00C1DE; ">登入</button>
                                                </div>
                                            </div>
                                            @if($errors->any())
                                                @foreach ($errors->all() as $error)
                                                <span class="help-block" style="color:red" >
                                                    <strong style="margin-left: 40px;s">您所輸入的資料有誤請重新檢查</strong>
                                                </span>
                                                    <!-- <h4>您所輸入的資料有誤請重新檢查</h4> -->
                                                @endforeach
                                            @endif

                                        </form>

                                    @endif
                                </div>
                            </div>


                            <!-- 未登入狀態 登入先拿掉-->
                            <div class="dropdown-menu"
                                style="display:none;border-radius: 0px; width: 300px;margin: 0; font-size: 14px; ">
                            </div>
                            <!-- 未登入狀態 -->

                        </div>
                    </main>
                        <ul>
                            <li id="m1" class="m"><a href="/" class="aa1 mmm">首頁</a></li>
                            <li id="m3" class="m"><a href="/front/claim_category_special/1/9" class="aa3 mmm">投資認購</a>
                                <div class="sub">
                                    <div class="nav_xiao">
                                        <div class="xiao_three">
                                            <ul>
                                                <li>
                                                    <a href="/front/claim_category_special/1/9"><img src="{{asset('../images/特別投資項目.jpg')}}" alt="" />特別投資項目
                                                </a>
                                                </li>
                                                <li>
                                                    <a href="/front/claim_category/1/9"><img src="{{asset('../images/智能媒合項目.jpg')}}" alt="" />智能媒合項目
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="/front/claim_category_history/1/108">
                                                        <img src="{{asset('../images/已完成投資項目.jpg')}}" alt="" />已完成投資項目
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li id="m3" class="m"><a href="/front/operation" class="aa3 mmm">操作指南</a>
                                <div class="sub">
                                    <div class="nav_xiao">
                                        <div class="xiao_three">
                                            <ul>
                                                <li><a href="/front/operation"><img src="{{asset('images/投資專區.jpg')}}" alt="" />投資專區</a></li>
                                                <li><a href="/front/operation#id3"><img src="{{asset('../images/資費說明.jpg')}}" alt="" />資費說明</a></li>
                                                <li><a href="/front/operation_faq"><img src="{{asset('../images/常見問題.jpg')}}" alt="" />常見問題</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li id="m3" class="m"><a href="/front/about" class="aa3 mmm">關於我們</a>
                                <div class="sub">
                                    <div class="nav_xiao">
                                        <div class="xiao_three">
                                            <ul>
                                            <li><a href="/front/about"><img src="{{asset('../images/公司介紹.jpg')}}" alt="" />公司介紹</a>
                                            </li>
                                            <!-- <li><a href="about.html#id2"><img src="images/nav_web2.jpg" alt="" />執行長</a> -->
                                            </li>
                                            <li><a href="/front/about#id2"><img src="{{asset('../images/創辦人.jpg')}}" alt="" />創辦人</a>
                                            </li>
                                            <li><a href="/front/about#id3"><img src="{{asset('../images/法律顧問.jpg')}}" alt="" />法律顧問</a>
                                            </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <!--   <li id="m3" class="m"><a href="#" class="aa3 mmm">會員專區</a>
                                <div class="sub">
                                    <div class="nav_xiao">
                                        <div class="xiao_three">
                                            <ul>
                                                <li><a href="#"><img src="images/nav_web9.jpg" alt="" />會員資料設定</a></li>
                                                <li><a href="#"><img src="images/nav_web10.jpg" alt="" />我的投資帳戶</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li> -->
                            <li id="m3" class="m"><a href="https://loan.pponline.com.tw/" class="aa3 mmm">貸款專區</a>
                                <!-- <div class="sub">
                                    <div class="nav_xiao">
                                        <div class="xiao_three">
                                            <ul>
                                                <li><a href="#"><img src="images/nav_web11.jpg" alt="" />貸款專區</a></li>
                                                <li><a href="#"><img src="images/nav_web12.jpg" alt="" />貸款申請書</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div> -->
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="shadow"></div>
        </div>
        <!--TopHeadEnd-->
   <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>

    @yield('content')



    <footer>
        
        <div class="container">
            <div class="row h240 footer_bg">
        <div class="col-md-12 mx-auto color1 footerli pd40">
            <div style="text-align: center"><span class="big_t">申購債權前請先詳閱豬豬在線「債權投資風險揭露」及「豬豬在線債權媒合平台服務合約」，投資一定有風險，投資前請審慎評估。</span>

            </div>
        </div>

        <div class="fl top_line">
            <div id="footer_col8" class="col-md-8">
                <div class="color4 c_d4">公司地址：台北市中山區南京東路二段216號6樓<br>服務時間：10:00AM ~ 6:00PM (週一至週五)<br>客服專線：02-5562-9111<br>公司信箱：service@pponline.com.tw</div>
                <div class="p12 color3">本網站文字圖片版權所有：信任豬股份有限公司轉載必究</div>
            </div>
            <div id="footer_col4" class="col-md-4">
                <div class="text-right color3 ">
                    <a href="{{url('/front/service')}}">服務合約</a> |
                    <a href="{{url('/front/privacy')}}">隱私權政策</a> |
                    <a href="{{url('/front/risk')}}">債權投資風險揭露</a></div>
            </div>
        </div>
        </div>
        </div>
    </footer>

    <!-- js -->
    <!-- 往下滾依序出現 -->
    
    <script src="/js/banner.js"></script>
    <script type="text/javascript" src="/js/hamburger.js"></script>
    <script type="text/javascript">
        $(window).scroll(function () {
            //控制导航
            if ($(window).scrollTop() < 0) {
                $('#headdiv').stop().animate({
                    "top": "0px"
                }, 200);

                $('.nav2 .mmm').css("padding-top", "20px");
                $('.nav2 .sub').css("top", "0px");
                $('.top02').css("height", "60px");

            } else {
                $('#headdiv').stop().animate({
                    "top": "0px"
                }, 200);
                $('.top02').css("height", "60px");

                $('.nav2 .mmm').css("padding-top", "20px");
                $('.nav2 .sub').css("top", "60px");
            }
        });
    </script>
    <script type="text/javascript">
        jQuery(".nav2").slide({
            type: "menu",
            titCell: ".m",
            targetCell: ".sub",
            effect: "slideDown",
            delayTime: 300,
            triggerTime: 100,
            returnDefault: true
        });
    </script>
    <script>
        AOS.init({
            easing: 'ease-out-back',
            duration: 1000
        });
    </script>
    <script>
        $(document).ready(function () {

            $('.top02').css("background-color", "rgba(255, 255, 255, 0.07)");

            $(".top02").mouseover(function () {
                $(".top02").css("background-color", "rgba(255, 255, 255, 0.2)");
            });
            $(".top02").mouseout(function () {
                $(".top02").css({
                    "background-color": "rgba(255, 255, 255, 0.07)"
                });

            });

        });


        $(function () {
            $(window).scroll(function () {
                var winTop = $(window).scrollTop();
                if (winTop >= 30) {
                    $(".top02").addClass("sticky_h");
                } else {
                    $(".top02").removeClass("sticky_h");
                } //if-else
            }); //win func.
        }); //ready func.


        $(function () {
            $(window).scroll(function () {
                var winTop = $(window).scrollTop();
                if (winTop >= 30) {
                    $(".logo").addClass("logo_2");
                } else {
                    $(".logo").removeClass("logo_2");
                } //if-else
            }); //win func.
        }); //ready func.
    </script>
    <script type="text/javascript">
        $(window).scroll(function () {
            //控制导航
            if ($(window).scrollTop() < 30) {

                $('.logoa').css("display", "block");
                $('.logob').css("display", "none");


            } else {
                $('.logoa').css("display", "none");

                $('.logob').css("display", "block");
            }
        });


        $(document).ready(function () {



            $(".mouse_row").mouseover(function () {
                $(".mouse_row").css("background-color", "rgba(69, 72, 144, 0.3)");
            });
            $(".mouse_row").mouseout(function () {
                $(".mouse_row").css({
                    "background-color": "rgba(69, 72, 144, 0)",
                    "height": "500px"
                });


            });

        });




        $(document).ready(function () {



            $(".mouse_row2").mouseover(function () {
                $(".mouse_row2").css("background-color", "rgba(69, 72, 144, 0.3)");
            });
            $(".mouse_row2").mouseout(function () {
                $(".mouse_row2").css({
                    "background-color": "rgba(69, 72, 144, 0)",
                    "height": "500px"
                });


            });

        });



        $(document).ready(function () {



            $(".mouse_row3").mouseover(function () {
                $(".mouse_row3").css("background-color", "rgba(69, 72, 144, 0.3)");
            });
            $(".mouse_row3").mouseout(function () {
                $(".mouse_row3").css({
                    "background-color": "rgba(69, 72, 144, 0)",
                    "height": "500px"
                });


            });

        });




        $(document).ready(function () {



            $(".mouse_row4").mouseover(function () {
                $(".mouse_row4").css("background-color", "rgba(69, 72, 144, 0.3)");
            });
            $(".mouse_row4").mouseout(function () {
                $(".mouse_row4").css({
                    "background-color": "rgba(69, 72, 144, 0)",
                    "height": "500px"
                });


            });

        });
    </script>
    <script>
        AOS.init();
        // Pop up notice when users click the function which we need them on login state
        function loginNoticeAlert() {
            swal({
                title: "提示",
                text: "請您登入 / 註冊會員後才能操作",
                icon: "warning",
                buttons: {
                    cancel: "取消",
                    login_button: "登入",
                    register_button: "註冊",
                },
            }).then((value) => {
                switch (value) {
                    case "login_button":
                        location.pathname = "/users/sign_in";
                        break;
                    case "register_button":
                        location.pathname = "/users/sign_up";
                        break;
                    default:
                }
            });
        }

        // If user's browser is IE series and older than IE 10, pop up notice
        function detectOldBrowser() {
            var ua = window.navigator.userAgent;
            var msie = ua.indexOf('MSIE ');
            if (msie > 0) {
                swal({
                    title: "提示",
                    text: "您使用的瀏覽器過於老舊\n我們推薦使用 Chrome 瀏覽器獲得最佳瀏覽體驗",
                    icon: "warning",
                    buttons: {
                        cancel: "我知道了",
                    }
                })
                $(".swal-text").css("text-align", "center")
            }
        }

        function fmoney(s, n) {
            n = n > 0 && n <= 20 ? n : 2;
            s = parseFloat((s + "").replace(/[^\d\.-]/g, "")).toFixed(n) + "";
            var l = s.split(".")[0].split("").reverse(),
                r = s.split(".")[1];
            t = "";
            for (i = 0; i < l.length; i++) {
                t += l[i] + ((i + 1) % 3 == 0 && (i + 1) != l.length ? "," : "");
            }
            return t.split("").reverse().join("");
        }
        (function () {
            // Execute default js function
            detectOldBrowser();
        })()

        // Make body background unscrollable when user open modal on mobile device
        $('.modal').on('shown.bs.modal', function (e) {
            $('html').addClass('freezePage');
            $('body').addClass('freezePage');
        });
        $('.modal').on('hidden.bs.modal', function (e) {
            $('html').removeClass('freezePage');
            $('body').removeClass('freezePage');
        });

        // Hide navbar when touchmoving screen on mobile
        $("#main-page").on("touchmove", function () {
            $(".navbar-collapse.collapse.show").removeClass("show");
        })

        function show_pw() {
            var t = $('#password').attr("type");
            if (t == 'password') {
                $('#password').attr('type', 'text');
            } else {
                $('#password').attr('type', 'password');
            }

        }
    </script>

    <script type="text/javascript" src="/20210601/libs/waypoints/2.0.4/waypoints.min.js">
    </script>
    <script type="text/javascript" src="/20210601/jquery.counterup/1.0/jquery.counterup.min.js"></script>
    <script type="text/javascript" src="/js/mockupclaims.js"></script>
    <script type="text/javascript"
        src="/20210601/libs/moment/2.22.2/moment-with-locales.min.js"></script>
    <!-- <script src="/js/star.js"></script> -->
    <script src="/assets/front/index-26ee3a1753ebc793392af1ba1b0674a6fda2068ecffa71523dd24e114f60a76e.js"></script>
    <!-- 往下滾依序出現 -->
    <script>
    </script>

    <!--  ========= 2020-03-19 17:59:56 change by Jason START=========  -->
    @if(Session::has('cannotGoHabit'))
    <script>
        swal('提示', '需真實身分認證後，才可使用本功能!', 'error');
    </script>
    @endif
    <!--  ========= 2020-03-24 22:54:57 change by Jason START=========  -->
    @if(Session::has('claimMatch'))
    <script>
        swal('提示', '需登入後才能進行智能媒合試算!', 'error');
    </script>
    @endif
    @if(Session::has('claimMatchPermission'))
    <script>
        swal('提示', '帳號權限錯誤，管理者無法進行智能媒合投資!', 'error');
    </script>
    @endif
    <!--  ========= 2020-03-30 10:22:25 change by Jason =========  -->
    @if(Session::has('claimMatchUserBank'))
    <script>
        swal('提示', '請先綁定銀行帳號後再進行智能投資!', 'error');
    </script>
    @endif

    @if(Session::has('user_state_not_consent'))
    <script>
        swal('提示', '帳號權限錯誤，管理者無法使用此功能!', 'error');
    </script>
    @endif

    @if(Session::has('ageNotAllow'))
    <script>
        swal('提示', '您未滿 20 歲，無法認購債權!', 'error');
    </script>
    @endif

    @if(Session::has('userStateNotAllow'))
    <script>
        swal('提示', '帳號尚未審核通過!', 'error');
    </script>
    @endif
    @if(Session::has('dontReadOtherPeopleMail'))
    <script>
        swal('提示', '請不要嘗試偷看他人信件!', 'error');
    </script>
    @endif
    @if($errors->any())
    <script>
        swal('提示', "您所輸入的資料有誤請重新檢查!", 'error');
    </script>
    @endif
    @if(Session::has('pdferror'))
    <script>
        swal('提示', '請先登入帳號方可觀看謝謝!', 'error');
    </script>
    @endif
    @if(Session::has('pdfloading'))
    <script>
        swal('提示', '債權憑證尚在生成請稍後嘗試謝謝!', 'error');
    </script>
    @endif
    @if(Session::has('cannotGobank'))
    <script>
        swal('提示', '請先新增銀行帳戶方可使用此功能!', 'error');
    </script>
    @endif
    @if(Session::has('TokenExpired'))
    <script>
        swal('提示', '此連結已過期，請重新申請!', 'error');
    </script>
    @endif
</body>

</html>