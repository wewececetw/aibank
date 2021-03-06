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
<?////////////////////////////////////////?????????////////////////////////////////////////?>
<?////////////////////////////////////////?????????////////////////////////////////////////?>
<?////////////////////////////////////////?????????////////////////////////////////////////?>
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
        /*---------------------------------??????------------------------------------------*/
        
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




        /*---------------------------------??????------------------------------------------*/
        /*--------------------------------model-------------------------------------------*/
        @media (min-width: 768px){
            #col_modol{
                flex: 0 0 60%;
                max-width: 60%;
            }
        }
    </style>

    <div id="banner-box">
         <!-- ????????????????????? -->
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
                                <div class="modal-title-c">????????????????????? ?</div>
                                <div class="modal-all-p">
                                    <div class="modal-f1">
                                        ??????????????????????????????????????????????????????????????????????????????A-Card?????????????????????B-Card???????????????????????????????????????????????????????????????????????????????????????
                                    </div>
                                </div>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-6 col-12 modal-title">
                                            <div class="modal-title-d">??????????????????(Application Score)</div>
                                            <div><img src="../images/t1.png" alt="" style="width:100%"></div>
                                        </div>
                                        <div class="col-sm-6 col-12 modal-title">
                                            <div class="modal-title-d">??????????????????(Behavior Score)</div>
                                            <div><img src="../images/t2.png" alt="" style="width:100%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-all-p">
                                    <div class="modal-f1">??????????????????????????????????????????30??????????????????????????????(Bad Account)??? ???????????????????????????
                                        ?????????????????????????????????Credit Risk ??? IRB??????????????????????????????90????????????????????????????????????
                                    </div>
                                    <div class="modal-f1">K-S??????????????????????????????????????????????????????K-S???????????????????????????????????????????????????????????????????????????????????????????????????
                                    </div>
                                    <div class="modal-f1">??????????????????????????????????????????????????????????????????K-S????????????37.2% ??? 61.7%???????????????????????????????????????
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <!--   <button type="button" class="btn btn-secondary" data-dismiss="modal">??????</button> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ????????????????????? -->
            <!--??????-->
            <div id="root">
                <div class="container-banner">
                  <div class="timeline">
                    <div class="swiper-container">
                      <div class="swiper-wrapper">
                        <div class="swiper-slide" style="background-image: url(/banner/bg_sectionjpg.jpg) ; " data-year="GoldenPiggyBank??????????????">
                          <div class="swiper-slide-content">
                            <div class="swiper-left">
                              <h4 class="timeline-title">????????????<br>GoldenPiggyBank<span style="font-size: 22px;position: relative;top: -9px;">??</span><br>???????????????????????????</h4>

                                <span class="timeline-year">??????????????????????????????????????????????????????</span>
                                <span class="timeline-year">???????????????8%?????????????????????????????????</span>

                              <div class="timeline-button-container">
                                <a class="timeline-button" href="/users/sign_up">????????????</a>
                                <a class="timeline-button" href="/front/claim_category/1/9">????????????</a>
                              </div>
                            </div>
                            <div class="swiper-right baimg" style="background-image: url(../banner/img/right_img1.png)">
                            </div>
                          </div>
                        </div>
                        <div class="swiper-slide"  style="background-image: url(/banner/bg_sectionjpg.jpg)" data-year="???????????????????????????">
                          <div class="swiper-slide-content">
                            <div class="swiper-left">
                              <h4 class="timeline-title">????????????????????????????????????<br><span>????????????????????????????????????</span><br>???????????????????????????</h4>

                                <span class="timeline-year">?????????????????????????????????????????????</span>
                                <span class="timeline-year">???????????????????????????????????????????????????</span>
                                <div class="timeline-button-container">
                                    <a class="timeline-button" href="/users/sign_up">????????????</a>
                                    <a class="timeline-button" href="/front/operation">????????????</a>
                                </div>
                            </div>
                            <div class="swiper-right baimg" style="background-image: url(../banner/img/right_img2.png">
                            </div>
                          </div>
                        </div>
                        <div class="swiper-slide" style="background-image: url(/banner/bg_sectionjpg.jpg)" data-year="??????????????????">
                          <div class="swiper-slide-content">
                            <div class="swiper-left">
                              <h4 class="timeline-title">????????????????????????????????????<br><span>????????????????????????????????????</span><br>??????????????????????????????</h4>
                                <span class="timeline-year">??????8??????????????????????????????????????????</span>
                                <span class="timeline-year">?????????????????????????????????????????????????????????</span>
                                <div class="timeline-button-container">
                                    <a class="timeline-button" href="/users/sign_up">????????????</a>
                                    <a class="timeline-button" data-toggle="modal" data-target="#exampleModalLong2" href="#">????????????</a>
                                </div>
                            </div>
                            <div class="swiper-right baimg" style="background-image: url(../banner/img/right_img3.png">
                            </div>
                          </div>
                        </div>
                        <div class="swiper-slide" style="background-image: url(/banner/bg_sectionjpg.jpg)" data-year="??????????????????">
                          <div class="swiper-slide-content">
                            <div class="swiper-left">
                                <h4 class="timeline-title">??????????????????</h4>
                                <span class="timeline-year">1.????????????(??????mail?????????</span>
                                <span class="timeline-year">2.????????????(????????????????????????????????????)</span>
                                <span class="timeline-year">3.??????????????????(??????????????????????????????)</span>
                                <div class="timeline-button-container">
                                    <a class="timeline-button" href="/users/sign_up">????????????</a>
                                    <a class="timeline-button" href="/front/operation_faq">????????????</a>
                                </div>
                            </div>
                            <div class="swiper-right baimg" style="background-image: url(../banner/img/right_img4.png">
                            </div>
                          </div>
                        </div>
                        <div class="swiper-slide" style="background-image: url(/banner/bg_sectionjpg.jpg)" data-year="??????????????????">
                            <div class="swiper-slide-content">
                                <div class="swiper-left">
                                <h4 class="timeline-title">???????????????<br><span>????????????????????????</span></h4>
                                    <span class="timeline-year">???????????????????????????</span>
                                    <span class="timeline-year">???????????????????????????</span>
                                <div class="timeline-button-container">
                                    <a class="timeline-button" href="https://loan.pponline.com.tw/">????????????</a>
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
                      <span class="xw">????????????????????????</span>
                      <div class="xw xb" onclick="window.location.href='/inbox_letters'">????????????</div>
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
                      <span class="xw">????????????????????????????????????????????????</span><br>
                      <div class="xw xb" onclick="window.location.href='/users'">????????????</div>
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
                        //??????
                        observer:true,//??????swiper???????????????????????????????????????swiper
                        observeParents:true,//??????swiper?????????????????????????????????swiper
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
                            <div class="title1">????????????????????????</div>
                            <p class="cop">???????????????????????????????????????????????????????????????????????????????????????</p>
                            <ul class="ul-feature">
                                <li><div class="left-img"><img src="{{asset('../images/profits_1.png')}}"></div>
                                    <div class="right-text"><h4>????????????</h4><p>??????????????????????????????????????????????????????????????????</p></div>
                                </li>
                                <li><div class="left-img"><img src="{{asset('../images/profits_2.png')}}"></div>
                                    <div class="right-text"><h4>????????????</h4><p>??????????????????????????????????????????????????????????????????</p></div>
                                </li>
                                <li><div class="left-img"><img src="{{asset('../images/profits_3.png')}}"></div>
                                    <div class="right-text"><h4>????????????</h4><p>?????????????????????????????????????????????????????????</p></div>
                                </li>
                            </ul>
                        </div>

                    </div>
            </div>
        </div>
    </section>
<!--???????????????-->  
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
<!--???????????????-->    
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
        <!-- ????????????????????? -->
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
                            <div class="modal-title-c">????????????????????? ?</div>
                            <div class="modal-all-p">
                                <div class="modal-f1">?????????????????????????????????????????????????????????????????????????????????????????????????????????
                                </div>
                                <div class="modal-f1">??????????????????????????????????????????????????????????????????????????????????????????1,000?????????????????????????????????????????????????????????P2P??????Lending
                                    Club?????????????????????(??????)??????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????
                                </div>
                            </div>
                            <div class="modal-img"><img src="../images/t3.png" alt=""></div>
                            <div class="modal-all-p">
                                <div class="modal-f1">????????????????????????25??????, ?????????????????????????????????????????????????????????(12%)??? ?????????????????????????????????(-4%),
                                    ???????????????????????????????????????????????????????????????????????????????????? 100, ??????????????????????????????????????? 5%?????????????????????????????????????????????
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!--   <button type="button" class="btn btn-secondary" data-dismiss="modal">??????</button> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ????????????????????? -->
        <div class="container">
            <div class="row con60">
                <div id='pp_show' class="col-md-6 offset-md-3 text-center">
                    <div class="text-center">
                        <div id="detail_title" class="title1 color5">????????????????????????</div>
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
                    <div class="color55">????????????</div>
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
                    <div class="color55">????????????</div>
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
                    <div class="color55 color555">???????????????</div>
                </div>
            </div>
            <div class="index-main-button"   data-toggle="modal" data-target="#exampleModalLong" >?????????????????? </div>
        </div>
    </section>
    <section class="section_icon bg2">
        <div class="container ">
            <div class="con60">
                <div class="text_bg2">
                    <div class="col-md-6 offset-md-3 col-xs-12 text-center " aos="fade-up">
                        <div class="text-center">
                            <div class="title1">????????????</div>
                            <?/*
                            <p class="cop">????????????(Fintech)?????????????????????????????????????????????????????????????????? ???????????????(P2B)??????????????????????????????
                            </p>
                            */?>
                        </div>
                    </div>
                    <div class="row con50 margin-bottom row-xs">
                        <div class="col-md-4 col-sm-12">
                            <div class="bl-all" style="background: url(images/step_bg1.jpg) center no-repeat;">
                                <h2>01</h2>
                                <p>??????????????????</p>
                                <div class="iconcircle">
                                    <img src="{{asset('../images/step_icon1.png')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="bl-all" style="background: url(images/step_bg2.jpg) center no-repeat;">
                                <h2>02</h2>
                                <p>??????????????????</p>
                                <div class="iconcircle">
                                    <img src="{{asset('../images/step_icon2.png')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="bl-all" style="background: url(images/step_bg3.jpg) center no-repeat;">
                                <h2>03</h2>
                                <p>???????????????</p>
                                <div class="iconcircle">
                                    <img src="{{asset('../images/step_icon3.png')}}">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6 offset-md-3 text-center " aos="fade-up">
                        <div class="text-center">
                            <p class="cop">
                                ????????????????????????????????????????????????????????????????????????
                            </p>
                        </div>
                    </div>
                    
                        <? if(Auth::check()){ ?>
                        <a href="/users/pushhand" style="color: #fff;cursor:pointer;"><div class="index-main-button">????????????</div></a>
                        <? }else{ ?>
                        <a href="/users/sign_up" style="color: #fff"><div class="index-main-button">????????????</div></a>
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
                            <div class="title1 color5">?????????????????????(????????????)</div>
                            <p class="cop p-bottom col-md-12 text-center">???????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????A~E????????????(A?????????????????????E???????????????)
                        <div class = "index-main-button button-left" data-toggle = "modal" data-target = "#defaultRateTableModal" >??????????????? </div>
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
                        ?????????A????????????????????????E?????????????????????
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
                            <div class="title1">????????????</div>
                            <? /*<p class="cop">????????????????????????????????????????????????????????????????????????: ??????????????????, ??????????????????</p>*/?>
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
                            <div class="title1">????????????</div>
                            <? /*<p class="cop">????????????????????????????????????????????????????????????</p>*/?>
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
        <!--<div class='container' style="margin-top:15px">??????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????</div>-->
</section>
</div>


<script>
    $('.login_alert').click(function () {
        swal("??????", "???????????????", "warning")
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.4.2/js/swiper.min.js"></script>
<script src="js/banner.js"></script>

@if(isset($emailConfirmSuccess) && $emailConfirmSuccess == true)
<script>
    swal('??????', '?????????Email???????????????????????????????????????', 'success').then(function () {
        location.href = "{{ url('/users/sign_in') }}";
    })
</script>
@elseif(isset($emailConfirmSuccess) && $emailConfirmSuccess == false)
<script>
    swal('??????', 'Email????????????', 'error')
</script>
@endif
@if(isset($emailConfirmError) && $emailConfirmError == true)
<script>
    swal('??????', '?????????????????????', 'error')
</script>
@endif

@endsection