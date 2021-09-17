@extends('Front_End.layout.header')
@section('content')
<link rel="stylesheet" media="screen" href="/modal/modal.css" />
<div id="main-page">
    <style>
        .timeline .swiper-container {
            height: 670px;
        }
        .logo{
            width:200px;
        }
        .hide {
            display: none;
        }
        .owl-item,
        .owl-lazy {
            height: 700px;
        }
        .news_nav {
            margin: 0 auto 0 auto;
            display: table;
        }
        #banner-box{
            height: auto !important;
        } 
        .news_group {
            padding: 0 13px 20px 13px;
            vertical-align: top;
            display: table-cell;
            text-align: left;
            word-wrap: break-word;
        }

        .new_v {
            width: 360px;
            height: 210px;
        }

        .service_jpg22 {
            background: url(/images/push_pp_baner_wight.jpg);
            background-repeat: no-repeat;
            min-height: 400px;
            width: 100%;
            position: relative;
            background-size: auto 100%;
            background-position: center center;
            background-color: #fff;
        }

        #mb_pp {
            margin-top: 360px;
        }

        .background_banner {
            background-image: url(banner/img/home_banner_6.jpg) !important;
            background-repeat: no-repeat;
            background-size: auto;
            background-position: center;
        }
        .message {
            background-color:#eeb014;
            width: 220px;
            min-height: 80px;
            padding: 5px;
            z-index: 10;
            right: 0px;
            top: 70px;
            position: fixed;
            /* border-radius: 15px; */
            border-radius: 0px;
        }

        .oo {
            width: 13px;
            height: 13px;
            background-color: #ffaf14;
            border-radius: 10px;
            display: inline-block;
        }

        .xx {
            cursor: pointer;
            width: 19px;
            height: 15px;
            right: 5px;
            position: fixed;
            background-size: 100% 100%;
            margin-top: 6px;
        }
        
        .xx1 {
            width: 15px;
            height: 3px;
            background-color: white;
            transform: rotate(45deg);
            position: relative;
            top: 3px;
            left: 0;
        }

        .xx2 {
            width: 15px;
            height: 3px;
            background-color: white;
            transform: rotate(135deg);
            position: relative;
            left: 0px;
            top: 0;
        }

        .xw {
            color: white;
            font-size: 16px;
            font-weight: 700;
        }

        .xb {
            background-color: #807f7c;
            margin: 5px auto;
            width: 100px;
            height: 24px;
            cursor: pointer;
            border-radius: 12px;
        }

        .xxx {
            /* padding-top: 15px; */
            padding-top: 8px;
            text-align: center;
        }
        .ro_margin{
            margin: 0 auto;
        }
        #banner-box{
            height: auto !important;
        } 
        
        #detail_title{
            letter-spacing: 10px;
        }

        #nav-icon4:focus,#nav-icon4:active{
            outline:rgba(255,255,255,0);
        }
        .swiper3 .text_info:last-child {
            margin:0 auto;
        }
        /* #b_b,#b_b_2 {
            width: 100vw;
            height: 100vh;
            position: fixed;
            top: 0px;
            left: 0px;
            z-index: 1000;
            background-color: rgba(255, 255, 255, 0.44);
        }
        #b_i,#b_i_2 {
            width: 823px;
            height: 577px;
            margin: 0 auto 0 auto;
            position: relative;
            top: 18%;
            background-image: url(/banner/img/1.png);
            background-repeat: no-repeat;
            background-position: center center;
            background-size: 100%;
        }
        #b_i_2 {
            background-image: url(/banner/img/BN.png);
        } */
        .b33{
            height: 140px;
        }
        .f50{
            letter-spacing: unset;
        }
        .con60 {
                padding-top: 90px;
        }
        .con601 {
                padding-top: 50px;
        }
        .h250 , .h300{
            height: 140px;
        }
        .bg2{
            padding-bottom: 60px;
        } 
        .bg4{
            padding-bottom: 30px;
        }

        .timeline .swiper-slide-content {
            top: 510px;
        }
        .timeline .swiper-slide .timeline-title {
            margin:unset;
        }
        .timeline-year,.timeline-text{
            word-break: break-all;
        }
        .index-main-button{
            margin-top: 100px;
            font-size: 17px;
            width: 338px;
            height: 50px;
            border-radius: 6px;
            border: none;
        }
        .color55{
            color:#fff;
            width: 90px;
            border-bottom: 1px #fff solid;
            margin: auto;
        }
        .color555{
            width: 110px;
        }
        .index-main-button {
            line-height: 50px;
        }
<?////////////////////////////////////////ＲＷＤ////////////////////////////////////////?>
<?////////////////////////////////////////ＲＷＤ////////////////////////////////////////?>
<?////////////////////////////////////////ＲＷＤ////////////////////////////////////////?>
        @media (max-width: 1530px) {
            .news_group {
                width: 300px;
            }
            .new_v {
                width: 300px;
                height: 175px;
            }
        }
        @media screen and (max-width: 1400px)and (min-width: 1281px){
            .swiper-width {
                width: 93%;
            }
        }
        @media (max-width: 1300px) {
            .news_group {
                width: 210px;
            }

            .new_v {
                width: 210px;
                height: 122.5px;
            }
        }
        .text_bg4,.text_bg2  {
            background-image:none;
        }
/************************************************** banner **************************************************/
        .baimg{
            width:644px;
            height:664px;
            background-repeat:no-repeat;
            background-size:100% auto;
            background-position:center top;
            float:unset;
        }
        @media screen and (min-width: 1440px) and (max-width: 1680px){
            .timeline .swiper-pagination {
                padding-top: 245px;
            }
            .timeline .swiper-slide-content {
                top: 385px;
            }
            .baimg{
                width:400px;
                height:412px;
            }
        }
        @media screen and (min-width: 1180px) and (max-width: 1440px){
            .timeline .swiper-slide-content {
                top: 380px;
            }
            .baimg {
                width:380px;
                height:392px;
            }
        }
        @media screen and (min-width: 769px) and (max-width: 1180px){
            .timeline .swiper-slide-content {
                top: 310px;
            }
            .timeline .swiper-pagination {
                padding-top: 180px;
            }
            .baimg{
                display:none;
                width:358px;
                height:370px;
            }
        }
        @media screen and (min-width: 280px) and (max-width: 768px){
            .timeline .swiper-container {
                height: 100vh;
                min-height: unset;
                max-height: unset;
            }
            .timeline .swiper-slide-content {
                top: 280px;
            }
            .timeline .swiper-slide-active .timeline-text {
                display: block;
                font-size: 14px;
            }
        }
        @media (min-width: 560px) and (max-width: 768px){
            .baimg{
                display:block;
                width: 664px;
                position: absolute;
                top:350px;
            }
        }
        @media screen and (min-width: 280px) and (max-width: 559px){
            .baimg{
                display:block;
                width: 100vw;
                position: absolute;
                right: -38px;
                top:250px;
            }
        }
/************************************************** banner **************************************************/
/************************************************** banner2 **************************************************/
        .banner2{
                background-image:url(images/feature.png);
                background-repeat:no-repeat;
                background-size:100% auto;
                background-position:bottom center;
        }
        @media  (min-width: 991px) {
            .banner2{
                width:580px;
                height:458px;
            }
        }
        @media  (max-width: 991px) {
            .banner2{
                width:400px;
                height:316px;
            }
        }
        @media (max-width: 768px){
            .banner2{}
        }
/************************************************** banner2 **************************************************/
        @media  (max-width: 992px) {
            .f50 {
                font-size: 30px;
            }
            .news_group {
                margin: 0 auto 40px auto;
                float: none;
                width: 100%;
                padding: 0;
                text-align: center;
                display: unset;
            }
            .new_v {
                width: 100vw;
                height: 210px;
                padding: 0 0 20px 0;
            }
            .service_jpg2 {
                min-height: 480px;
            }
        }
        @media (min-width: 768px){
            #pp_show {
                margin-left: unset;
            }
            #pp_show {
                -webkit-box-flex: 0;
                -ms-flex: 0 0 50%;
                flex: 0 0 100%;
                max-width: 100%;
            }
        }
        @media screen and (max-width: 830px) {
            /* #b_i,#b_i_2 {
                width: 97%;
                height: 577px;
            } */
        }
        @media (max-width: 768px){
            .col-md-4 {
                -webkit-box-flex: unset;
                -ms-flex: unset;
                flex: unset;
                max-width: unset;
            }
            .index-main-button{
                margin-top: 23px;
            }
            .con60 {
                padding-top: 30px;
            }
            .h250 {
                height: 125px;
            }
            .b33{
                height: 130px;
            }
            .bg2{
                padding-bottom: 45px;
            }
            .bg4{
                padding-bottom: 20px;
            }
            .bored:after {
                display: none;
            }
            .margin-bottom {
                margin-bottom: unset;
            }
            .index-main-button{
                width: 250px;
            }
            .banner2{}
        }
        @media screen and (max-width: 682px) {
            /* #b_i,#b_i_2 {
                width: 97%;
                height: 460px;
            } */
        }
        @media (max-width: 576px){
            .index-main-button{
                margin-top: 50px;
            }
        }
        @media (max-width: 414px) {
            .service_jpg22 {
                background: url(/images/mb_push_pp_baner_wight.jpg);
                background-size: 100% auto;
                min-height: auto;
                background-repeat: no-repeat;
            }

            #mb_pp {
                margin-top: 145%;
            }
        }
        @media screen and (max-width: 300px) {
            .navbar-toggler { width: 30px;}
        }
        /*---------------------------------廣告------------------------------------------*/
        
        /* #b_b, #b_b_2{
            width:100vw;
            height:100vh;
            position:fixed;
            top:0px;
            left:0px;
            z-index: 9999;
            background-color:rgba(255,255,255,0.44);
        }
        #b_i, #b_i_2{
            
            width: 600px;
            height: 775px;
            margin: 0 auto 0 auto;
            position:relative;
            top:8%;
            background-image:url(/banner/img/1.png);
            background-repeat:no-repeat;
            background-position:center center;
            background-size:100%;
            overflow-y: auto;
           
        }
        #b_i_2{ background-image:url(/banner/img/pigonline_20210629_pc1.jpg);}
        @media screen and (max-width: 830px){
            #b_i, #b_i_2{
                width:70%;
                height: 1180px;
                top:-8%;
            }
        }
        @media screen and (max-width: 682px){
            #b_i, #b_i_2{
                background-image:url(/banner/img/pigonline_20210629_mob1.jpg);
                width:80%;
                height: 800px;
            }
        }
        @media screen and (max-width: 540px){
            #b_i, #b_i_2{
                width:95%;
                height: 800px;
                top:0%;
                background-position: top;
            }
        }
        @media screen and (max-width: 414px){
            #b_i, #b_i_2{
                height: 800px;
            }
        } */

        #b_i_mb{
            display: none;
        }
        #b_b, #b_b_2{
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0px;
            left: 0px;
            z-index: 9999;
            overflow: hidden;
            overflow-y: auto;
            background-color:rgba(255,255,255,0.44);

        }

        #b_i, #b_i_2 {
            width: 100%;
            max-width: 815px;
            /* max-width: 600px; */
            height: 800px;
            margin: 0 auto 0 auto;
            position: relative;
            top: 8%;
            overflow: hidden;
            overflow-y: auto;
        }
        @media screen and (max-width: 768px){
            #b_i, #b_i_2 {
                max-width: 79%;
                height: 800px;
            }
            #b_i_pc{
                display: none;
            }
            #b_i_mb{
                display: block;
            }
        }
        @media screen and (max-width: 540px){
            #b_i, #b_i_2 {
                height: 600px;
            }
            #b_i_mb{
                width: 100%;
            }
            #b_i, #b_i_2 {
                max-width: 95%;
            }
        }




        /*---------------------------------廣告------------------------------------------*/
        /*--------------------------------model-------------------------------------------*/
        @media (min-width: 768px){
            #col_modol{
                flex: 0 0 60%;
                max-width: 60%;
            }
        }
    </style>

    <div id="banner-box">
         <!-- 什麼是信用評分 -->
            <div class="modal fade" id="exampleModalLong2" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="mobg2">
                            <div class="modal-header">
                                <!--  <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5> -->
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="modal-title-b">Credit Score</div>
                                <div class="modal-title-c">什麼是信用評分 ?</div>
                                <div class="modal-all-p">
                                    <div class="modal-f1">
                                        全台唯一具備專業團隊及金融科技技術可以對轉讓債權進行A-Card申請信用評分及B-Card繳款行為信用評分，並定期公告各級信用評分債權的違約率品質。
                                    </div>
                                </div>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-6 col-12 modal-title">
                                            <div class="modal-title-d">進件信用評分(Application Score)</div>
                                            <div><img src="../images/t1.png" alt="" style="width:100%"></div>
                                        </div>
                                        <div class="col-sm-6 col-12 modal-title">
                                            <div class="modal-title-d">行為信用評分(Behavior Score)</div>
                                            <div><img src="../images/t2.png" alt="" style="width:100%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-all-p">
                                    <div class="modal-f1">豬豬在線的信用評分模型以逾期30天以上定義為違約帳戶(Bad Account)” 遠較巴塞爾協定中的
                                        信用風險－内部評等法（Credit Risk － IRB）中一般性定義以逾期90天以上視爲違約更加謹慎。
                                    </div>
                                    <div class="modal-f1">K-S值表示好客戶壞客戶累積機率的差值，若K-S值愈高，則代表兩者的差距愈大，即模型評分可區隔好壞客戶的能力愈強。
                                    </div>
                                    <div class="modal-f1">豬豬在線的債權模型區隔力進件與行爲信用評分的K-S值分別為37.2% 與 61.7%，皆有充分鑑別違約的能力。
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <!--   <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 什麼是信用評分 -->
            <!--活动-->
            <div id="root">
                <div class="container-banner">
                  <div class="timeline">
                    <div class="swiper-container">
                      <div class="swiper-wrapper">
                        <div class="swiper-slide" style="background-image: url(/banner/bg_sectionjpg.jpg) ; " data-year="GoldenPiggyBank®豬豬在線">
                          <div class="swiper-slide-content">
                            <div class="swiper-left">
                              <h4 class="timeline-title">豬豬在線<br>GoldenPiggyBank<span style="font-size: 22px;position: relative;top: -9px;">®</span><br>最佳的理財服務平台</h4>

                                <span class="timeline-year">透過智能媒合與合法的借貸債權轉讓機制</span>
                                <span class="timeline-year">提供投資人8%以上的年化報酬穩定收益</span>

                              <div class="timeline-button-container">
                                <a class="timeline-button" href="/users/sign_up">登入註冊</a>
                                <a class="timeline-button" href="/front/claim_category/1/9">立即投資</a>
                              </div>
                            </div>
                            <div class="swiper-right baimg" style="background-image: url(../banner/img/right_img1.png)">
                            </div>
                          </div>
                        </div>
                        <div class="swiper-slide"  style="background-image: url(/banner/bg_sectionjpg.jpg)" data-year="什麼是借貸債權投資">
                          <div class="swiper-slide-content">
                            <div class="swiper-left">
                              <h4 class="timeline-title">自己作主選擇風險承受等級<br><span>每個借貸債權資訊揭露清楚</span><br>分散投資的最佳選擇</h4>

                                <span class="timeline-year">小額分散投資、確實揭露債權資訊</span>
                                <span class="timeline-year">大幅降低投資分險，是您投資的好夥伴</span>
                                <div class="timeline-button-container">
                                    <a class="timeline-button" href="/users/sign_up">登入註冊</a>
                                    <a class="timeline-button" href="/front/operation">操作指南</a>
                                </div>
                            </div>
                            <div class="swiper-right baimg" style="background-image: url(../banner/img/right_img2.png">
                            </div>
                          </div>
                        </div>
                        <div class="swiper-slide" style="background-image: url(/banner/bg_sectionjpg.jpg)" data-year="豬豬信用評分">
                          <div class="swiper-slide-content">
                            <div class="swiper-left">
                              <h4 class="timeline-title">二十年以上的風控管理團隊<br><span>每個借貸債權都有信用評分</span><br>堅強的風險管理保護傘</h4>
                                <span class="timeline-year">運用8年數據累積，獨家研發兩套模型</span>
                                <span class="timeline-year">擁有最堅強的資產保全服務做您投資的後盾</span>
                                <div class="timeline-button-container">
                                    <a class="timeline-button" href="/users/sign_up">登入註冊</a>
                                    <a class="timeline-button" data-toggle="modal" data-target="#exampleModalLong2" href="#">信用評分</a>
                                </div>
                            </div>
                            <div class="swiper-right baimg" style="background-image: url(../banner/img/right_img3.png">
                            </div>
                          </div>
                        </div>
                        <div class="swiper-slide" style="background-image: url(/banner/bg_sectionjpg.jpg)" data-year="投資會員註冊">
                          <div class="swiper-slide-content">
                            <div class="swiper-left">
                                <h4 class="timeline-title">簡單註冊三步</h4>
                                <span class="timeline-year">1.註冊帳號(綁定mail信箱）</span>
                                <span class="timeline-year">2.信箱認證(未來訊息會透過此信箱通知)</span>
                                <span class="timeline-year">3.實名會員認證(身分證上傳＋銀行帳戶)</span>
                                <div class="timeline-button-container">
                                    <a class="timeline-button" href="/users/sign_up">登入註冊</a>
                                    <a class="timeline-button" href="/front/operation_faq">常見問題</a>
                                </div>
                            </div>
                            <div class="swiper-right baimg" style="background-image: url(../banner/img/right_img4.png">
                            </div>
                          </div>
                        </div>
                        <div class="swiper-slide" style="background-image: url(/banner/bg_sectionjpg.jpg)" data-year="申請小額信貸">
                            <div class="swiper-slide-content">
                                <div class="swiper-left">
                                <h4 class="timeline-title">小額快速貸<br><span>讓資金運用更彈性</span></h4>
                                    <span class="timeline-year">申請簡便、快速撥款</span>
                                    <span class="timeline-year">輕鬆滿足您資金需求</span>
                                <div class="timeline-button-container">
                                    <a class="timeline-button" href="https://loan.pponline.com.tw/">貸款專區</a>
                                </div>
                                </div>
                                <div class="swiper-right baimg" style="background-image: url(../banner/img/right_img5.png">
                                </div>
                            </div>
                        </div>
                      </div>
                      <div class="swiper-button-prev"></div>
                      <div class="swiper-button-next"></div>
                      <div class="swiper-pagination"></div>

                    </div>
                    <div class="enter_more2 floating" style="display:none">
                        <i class="fa fa-chevron-down" aria-hidden="true"></i>
                      </div>
                  </div>
                </div>
            </div>
              @if(Auth::check())
              @if($letters_count>0 && Auth::user()->user_state == 1)
              <div class="message" id="message_u">
                  <div class="xx" onclick="close_message('u')">
                      <div class='xx1'></div>
                      <div class='xx2'></div>
                  </div>
                  <div class="xxx">
                      <!-- <div class="oo"></div> -->
                      <span class="xw">您尚有未讀訊息。</span>
                      <div class="xw xb" onclick="window.location.href='/inbox_letters'">立即前往</div>
                  </div>
      
              </div>
              @elseif(Auth::user()->user_state != 1 && Auth::user()->user_state != 2)
              <div class="message" id="message_u">
                  <div class="xx" onclick="close_message('u')">
                      <div class='xx1'></div>
                      <div class='xx2'></div>
                  </div>
                  <div class="xxx">
                      <div class="oo"></div>
                      <span class="xw">您仍資料未完成，將無法認購債權。</span><br>
                      <div class="xw xb" onclick="window.location.href='/users'">立即前往</div>
                  </div>
              </div>
              @endif
              @endif  
    </div>
    <script>
        /*
        jQuery(document).ready(function ($) {
            $('.owl-carousel').owlCarousel({
                items: 1,
                lazyLoad: true,
                lazyLoadEager: 1,
                loop: true,
                margin: 10,
                autoHeight: false,
                autoplay: true,
                autoplayTimeout: 5000,
                autoplayHoverPause: true
            });
        });
        */
            var t =  document.body.clientWidth;
            aa();
            function aa (){
                if(t<=768){
                    var mySwiper = new Swiper('.swiper-container',{
                        pagination : '.swiper-pagination',
                        //……
                        observer:true,//修改swiper自己或子元素时，自动初始化swiper
                        observeParents:true,//修改swiper的父元素时，自动初始化swiper
                    })
                }
        
            }
        
        
        function close_message(v) {
            switch (v) {
                case 'u':
                    $("#message_u").hide();
                    break;
                case 'm':
                    $("#message_m").hide();
                    break;
                default:
            }

        }
    </script>
    <section class="section section--code">
        <div class="container">
            <div class="row con60">
                    <div class="col-md-12   text-center">
                        <div class="banner2 col-md-6 float-left text-bg feature-img">
                            <?/*
                            <img src="{{asset('../images/feature.png')}}">
                            */?>
                        </div>
                        <div class="col-md-6 float-left text-left">
                            <div class="title1">豬豬在線三大特色</div>
                            <p class="cop">透過智能媒合與合法的借貸債權轉讓，提供投資者快速的加薪神器</p>
                            <ul class="ul-feature">
                                <li><div class="left-img"><img src="{{asset('../images/profits_1.png')}}"></div>
                                    <div class="right-text"><h4>快速媒合</h4><p>以信用評分、智能媒合的方式，快速完成最佳投標</p></div>
                                </li>
                                <li><div class="left-img"><img src="{{asset('../images/profits_2.png')}}"></div>
                                    <div class="right-text"><h4>風險控管</h4><p>定期公告信用評分模型、違約率品質，投資有保障</p></div>
                                </li>
                                <li><div class="left-img"><img src="{{asset('../images/profits_3.png')}}"></div>
                                    <div class="right-text"><h4>債權多元</h4><p>提供多種類型債權項目，多元投資分散風險</p></div>
                                </li>
                            </ul>
                        </div>

                    </div>
            </div>
        </div>
    </section>
<!--活動標記頭-->  
<?/*    
    @if(Auth::check()) 
    <a href="#" onclick="c_b_2(1)">
    <!--<div id="b_b_2" style="width:100vw;height:100vh;position:fixed;top:0px;left:0px;z-index: 9999;" >
        <div id="b_i_2"></div>
    </div>-->
    <div id="b_b_2" {{$activity}} >
            <div id="b_i_2">
                <img id='b_i_pc' src="{{asset('../banner/img/pigonline_20210629_pc1.jpg')}}">
                <img id='b_i_mb' src="{{asset('../banner/img/pigonline_20210629_mob1.jpg')}}">
            </div>
        </div>
    </a>
        <script>
            function c_b_2(x){
                $("#b_b_2").hide();
                let data = {
                    type : x
                };
                $.ajax({
                url: "{{ url('/users/activity/rule') }}",
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                success: function (d) {

                }
                });
            }
        </script>
    @else
    <a href="#" onclick="c_b_2(1)">
    <div id="b_b_2">
            <div id="b_i_2">
                <img id='b_i_pc' src="/event/20210716/20210716_w.png">
                <img id='b_i_mb' src="/event/20210716/20210716_m.png">
            </div>
        </div>
    </a>
        <script>
            function c_b_2(x){
                $("#b_b_2").hide();
            }
        </script>
    @endif
*/?>
<!--活動標記底-->    
<?/*
    <a href="#" onclick="c_b_2(1)">

        <div id="b_b_2">
            <div id="b_i_2">
                <img id='b_i_pc' src="/event/error/20210721system.png">
                <img id='b_i_mb' src="/event/error/20210721system.png">
            </div>
        </div>
    </a>
    <script>
        function c_b_2(x){
            $("#b_b_2").hide();
        }
    </script>
*/?>
    <section class="service_jpg2">
        <!-- 什麼是智能媒合 -->
        <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="mobg">
                        <div class="modal-header">
                            <!--  <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5> -->
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="modal-title-b">Smart Matching</div>
                            <div class="modal-title-c">什麼是智能媒合 ?</div>
                            <div class="modal-all-p">
                                <div class="modal-f1">根據投資人的風險屬性選擇，自動媒合相對應的投資組合，快速進行投資媒合。
                                </div>
                                <div class="modal-f1">豬豬在線首創債權轉讓智能媒合，依照您挑選的風險屬性，系統將以1,000元為最小單位進行隨機分配。以美國著名的P2P平台Lending
                                    Club的資料驗證為例(如圖)，當投資標的物的數量愈來愈多時，投資報酬的波動率會逐漸趨於穩定與一致，其投資收益率和壞帳率將接近整體平台的平均表現。
                                </div>
                            </div>
                            <div class="modal-img"><img src="../images/t3.png" alt=""></div>
                            <div class="modal-all-p">
                                <div class="modal-f1">當投資案件數小於25件時, 平均年化報酬率將有機會創造超額的報酬率(12%)： 也有可能產生投資損失率(-4%),
                                    表示風險變化度極大，投資損益很難預測，但當投資案件數超過 100, 其投資報酬率將趨近於中位數 5%，也就是平台整體的平均報酬率。
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!--   <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 什麼是智能媒合 -->
        <div class="container">
            <div class="row con60">
                <div id='pp_show' class="col-md-6 offset-md-3 text-center">
                    <div class="text-center">
                        <div id="detail_title" class="title1 color5">豬豬在線媒合表現</div>
                    </div>
                </div>
                <div class="col-md-4 text-center  ">
                    <h1 class="color5 f50 "><span>$</span>
                        <span class="counter animated fadeInDownBig">
                            <?
                                if(!empty($memberBenefits)){
                                    echo number_format($memberBenefits);
                                }else{
                                    echo 0;
                                }
                            ?>
                        </span>
                    </h1>
                    <div class="color55">會員收益</div>
                </div>
                <div class="col-md-4 text-center bored">
                    <h1 class="color5 f50"><span>$</span>
                        <span class="counter animated fadeInDownBig" style="font-family:'Arial'" ;>
                            <?
                                if(!empty($totalInvestAmount)){
                                    echo number_format($totalInvestAmount);
                                }else{
                                    echo 0;
                                }
                            ?>
                        </span>
                    </h1>
                    <div class="color55">投資總額</div>
                </div>
                <div class="col-md-4 text-center bored">
                    <h1 class="color5 f50">
                        <span class="counter animated fadeInDownBig" style="font-family:'Arial'" ;>
                            <?
                                if(!empty($annualBenefitsRate)){
                                    $annualBenefitsRate_end=explode('.', $annualBenefitsRate);
                                    echo $annualBenefitsRate_end[0];
                                }else{
                                    echo 0;
                                }
                            ?></span>
                        <? if(!empty($annualBenefitsRate_end[1])){ echo ".";} ?><span
                            class="counter animated fadeInDownBig" style="font-family:'Arial'" ;>
                            <?
                                if(!empty($annualBenefitsRate_end[1])){
                                    echo substr((string)$annualBenefitsRate_end[1],0, 2);
                                }
                            ?>
                        </span>
                        <span>%</span>
                    </h1>
                    <div class="color55 color555">年平均報酬</div>
                </div>
            </div>
            <div class="index-main-button"   data-toggle="modal" data-target="#exampleModalLong" >了解智能媒合 </div>
        </div>
    </section>
    <section class="section_icon bg2">
        <div class="container ">
            <div class="con60">
                <div class="text_bg2">
                    <div class="col-md-6 offset-md-3 col-xs-12 text-center " aos="fade-up">
                        <div class="text-center">
                            <div class="title1">豬豬推手</div>
                            <?/*
                            <p class="cop">金融科技(Fintech)浪潮中的一個趨勢，個體對個體的直接借貸行為， 其中也包含(P2B)債權讓與的借貸模式．
                            </p>
                            */?>
                        </div>
                    </div>
                    <div class="row con50 margin-bottom row-xs">
                        <div class="col-md-4 col-sm-12">
                            <div class="bl-all" style="background: url(images/step_bg1.jpg) center no-repeat;">
                                <h2>01</h2>
                                <p>註冊成為會員</p>
                                <div class="iconcircle">
                                    <img src="{{asset('../images/step_icon1.png')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="bl-all" style="background: url(images/step_bg2.jpg) center no-repeat;">
                                <h2>02</h2>
                                <p>成為豬豬推手</p>
                                <div class="iconcircle">
                                    <img src="{{asset('../images/step_icon2.png')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="bl-all" style="background: url(images/step_bg3.jpg) center no-repeat;">
                                <h2>03</h2>
                                <p>分享賺獎金</p>
                                <div class="iconcircle">
                                    <img src="{{asset('../images/step_icon3.png')}}">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6 offset-md-3 text-center " aos="fade-up">
                        <div class="text-center">
                            <p class="cop">
                                朋友只要輸入你的專屬推薦碼，就可以獲得額外的獎金
                            </p>
                        </div>
                    </div>
                    
                        <? if(Auth::check()){ ?>
                        <a href="/users/pushhand" style="color: #fff;cursor:pointer;"><div class="index-main-button">立即加入</div></a>
                        <? }else{ ?>
                        <a href="/users/sign_up" style="color: #fff"><div class="index-main-button">立即加入</div></a>
                        <? } ?>
                    
                </div>
            </div>
        </div>
    </section>


    <section>
        <style>
            .img {
                width: 100%;
            }
        </style>
        <section class="service_jpg3">
            <div class="container">
                <div class="row con60">
                    <div class="col-md-12 text-left">
                        <div class="text-left">
                            <div class="title1 color5">何謂違約率品質(信用評分)</div>
                            <p class="cop p-bottom col-md-12 text-center">指投資者所認購的債權案件中無法如期兌付本金及利息機率。平台依據不同的風險屬性區分為A~E五個等級(A代表品質較好、E代表較不好)
                        <div class = "index-main-button button-left" data-toggle = "modal" data-target = "#defaultRateTableModal" >違約率品質 </div>
                    </div>
                </div>

            </div>
        </section>

        <div class="modal fade bd-example-modal-lg" id="defaultRateTableModal" tabindex="-1" role="dialog"
            aria-labelledby="defaultRateTableModalitle" aria-hidden="true">
            <div class="modal-dialog" role="document" style="max-width:600px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @foreach ($defaultRate_name as $name)
                        <button class="option-btn" data-name="{{ $name }}">{{ $name }}</button>
                        @endforeach
                        <div id="img-box" style="margin-top:10px;">
                            <div class="row" id="dfRateImgBlock">
                                @foreach ($defaultRate_data as $d)
                                @if($d['name'] == $defaultRate_name[0])
                                <div id="col_modol" class="col-md-4 col-12" style="position:relative;">
                                    <div class="color_white">{!! $d['title'] !!}</div>
                                    <img style="padding-top: 20px;" class="img dfrateImg" src="{{ $d['photo_path'] }}">
                                    <div class="image-title">{!! $d['content'] !!}</div>
                                </div>
                                @endif

                                @endforeach

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="justify-content: flex-start;">
                        備註：A代表風險等級低、E代表風險等級高
                    </div>
                </div>
            </div>
        </div>
        <script>
            let dfRateData = {!! json_encode($defaultRate_data) !!};
            $('.option-btn').on('click', function () {
                let name = $(this).data('name');
                let img_html = '';
                $("#dfRateImgBlock").empty();
                dfRateData.map((v,k)=>{
                    if(v.name == name){
                        img_html += `
                        <div id="col_modol" class="col-md-4 col-12" style="position:relative;">
                                    <div class="color_white">${v.title}</div>
                                    <img style="padding-top: 20px;" class="img dfrateImg"
                                        src="${v.photo_path}">
                                    <div class="image-title">${v.content}</div>
                                </div>
                        `;
                    }
                })
                $("#dfRateImgBlock").append(img_html);
            })
        </script>

    </section>
    <section class="section section--code bg2">
        <div class="container b33">
            <div class="row con601 h250">
                <div class="text_bg4">
                    <div class="col-md-6 offset-md-3 text-center t20" aos="fade-up">
                        <div class="text-center">
                            <div class="title1">影片介紹</div>
                            <? /*<p class="cop">什麼是豬豬在線、信用評分及智能媒合、投資運行模式: 智能媒合項目, 特別投資項目</p>*/?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row swiper-width ro_margin swiper2-out" >
        <!-- Swiper -->
            <div class="swiper-container swiper2">
                <div class="swiper-wrapper">
                    <div class="swiper-slide"><iframe  width="560" height="315" src="https://www.youtube.com/embed/R5Yjisz0eOk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
                    <div class="swiper-slide"><iframe  width="560" height="315" src="https://www.youtube.com/embed/bTUzcwhIr3E" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
                    <div class="swiper-slide"><iframe  width="560" height="315" src="https://www.youtube.com/embed/imGaGm4I0y4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
                    <div class="swiper-slide"><iframe  width="560" height="315" src="https://www.youtube.com/embed/juugvBQAZlk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
                    <div class="swiper-slide"><iframe  width="560" height="315" src="https://www.youtube.com/embed/R5Yjisz0eOk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
                </div>

                <!-- pagination -->
                <div class="swiper-pagination"></div>
                 <!-- Add Arrows -->
                 <div class="swiper-button-next"  id="swiper-button-next2"></div>
                 <div class="swiper-button-prev"  id="swiper-button-prev2"></div>               
            </div>
        </div>
        
    </section>
    <section class="section section--code bg4">
        <div class="container b33">
            <div class="row con601 h300">
                <div class="text_bg4">
                    <div class="col-md-6 offset-md-3 text-center t20" aos="fade-up">
                        <div class="text-center">
                            <div class="title1">最新公告</div>
                            <? /*<p class="cop">提供優惠訊和隨時提供最即時和最迅速的訊息</p>*/?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-width ro_margin swiper3-out">
            <!-- Swiper -->
            <div class="swiper-container swiper3">
                <div class="swiper-wrapper">
                    @php
                        $count = 1;
                    @endphp 
                    @if(isset($news))
                    @foreach ($news as $row)
                    
                    <div class="swiper-slide">
                        <a href="/news/news_detail?id={{ $row->web_contents_id }}">
                        @if($count==1)    
                        <div class="col-md-4 text_info bg-style1">
                                @foreach( $row->news_photo as $image)
                                @if( isset($image->image) )
                                <img src="{{ asset( $image->image ) }}" alt="">
                                @endif
                                @endforeach
                                <p class="news-pretext">{{ $row->remark }}</p>
                                <h4>{{ $row->title }}</h4>
                                <div style="color: #fff" class="news-created-time  stitle_1apadd">
                                    {{ date('Y/m/d',strtotime($row->launch_at)) }}
                                </div>
                        </div>
                        @else
                        <div class="col-md-4 text_info bg-style2">
                                @foreach( $row->news_photo as $image)
                                @if( isset($image->image) )
                                <img src="{{ asset( $image->image ) }}" alt="">
                                @endif
                                @endforeach
                                <p class="news-pretext">{{ $row->remark }}</p>
                                <h4>{{ $row->title }}</h4>
                                <div style="color: #fff" class="news-created-time  stitle_1apadd">
                                    {{ date('Y/m/d',strtotime($row->launch_at)) }}
                                </div>
                        </div>
                        @endif
                        </a>
                    </div>
                    @php
                       $count++;
                       if($count==3){$count=1;} 
                    @endphp    
                    @endforeach
                    @endif
                </div>    
                <!-- pagination -->
                <div class="swiper-pagination"></div>
                <!-- Add Arrows -->    
                
                <div class="swiper-button-next"  id="swiper-button-next3"></div>
                <div class="swiper-button-prev"  id="swiper-button-prev3"></div>
            </div>
        </div>
        <!--<div class='container' style="margin-top:15px">申購債權前請先詳閱豬豬在線「債權投資風險揭露」及「豬豬在線債權媒合平台服務合約」，投資一定有風險，投資前請審慎評估。</div>-->
</section>
</div>


<script>
    $('.login_alert').click(function () {
        swal("提示", "您已經登入", "warning")
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.4.2/js/swiper.min.js"></script>
<script src="js/banner.js"></script>

@if(isset($emailConfirmSuccess) && $emailConfirmSuccess == true)
<script>
    swal('提示', '已透過Email成功驗證此帳號，請重新登入', 'success').then(function () {
        location.href = "{{ url('/users/sign_in') }}";
    })
</script>
@elseif(isset($emailConfirmSuccess) && $emailConfirmSuccess == false)
<script>
    swal('提示', 'Email驗證失敗', 'error')
</script>
@endif
@if(isset($emailConfirmError) && $emailConfirmError == true)
<script>
    swal('提示', '此驗證信已過期', 'error')
</script>
@endif

@endsection