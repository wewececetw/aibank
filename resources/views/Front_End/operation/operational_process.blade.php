@extends('Front_End.layout.header')
@section('content')
<link rel="stylesheet" href="/css/guide.css">
<style>
    .cop{
        text-align: justify;
    }
    ul.A {
        list-style-type:decimal;
    }
    .b-about-bg {
        background-position: -150px 100% !important;
    }
    @media screen and (max-width: 768px) {
        .banner-list li .animate-box .t-d {
            max-width: 300px !important;
        }
    }
    @media screen and (max-width: 576px) {
        .banner-list li .animate-box .t-d p{  width: 75%!important;}
        .banner-list li .animate-box .t-d h2 {
            font-size: 25px;
        }
        ul.A {
            padding-left: 15px;
            padding-right: 15px ;
        }
        .index-main-button{
            margin-top: 15px;
            margin: auto;
            margin-bottom: 100px;
        }
    }
</style>

<div id="main-page">
    <div id="banner-box">
        <div class="banner-list">
            <!--活动-->
            <li class="b-about-bg" >
                <div class="animate-box png">
                    <div class="t-d" aos="fade-right">
                        <h2>豬豬在線如何運作</h2>
                        <br/>
                        <p>
                            <span>金融科技(Fintech)浪潮中的一個趨勢，個體對個體的直接借貸行為， 其中也包含(P2B)債權讓與的借貸模式．</span>
                        </p>
                    </div>
                    <div class="animate-img"><img src="{{asset('../banner/img/a777b23736b812414d59e18810923b54.png')}}" alt=" "></div>
                </div>
                <div class="enter_more2 floating">
                    <i class="fa fa-chevron-right" aria-hidden="true"></i>
                </div>
            </li>
        </div>
    </div>
    <div id="sub-nav" class="pro-sub-nav">
        <div class="sub_nav">
            <ul>
                <li><a href="#id1" class="goto">投資專區</a></li>
                <li><a href="#id5" class="goto">資費說明</a></li>
                <li><a href="/front/operation_faq" class="goto">常見問題</a></li>
            </ul>
        </div>
    </div>
    <section class="section section--code bg1">
        <div class="container">
            <div id="id1" class="row con60 tohere">
                <div class="text_bg5">
                    <div class="col-md-6 offset-md-3 text-center ">
                        <div class="text-center pad25">
                            <!--<div class="stitle">Investment</div>-->
                            <div class="title1">投資專區</div>
                            <!--     <p class="cop">金融科技(Fintech)浪潮中的一個趨勢，個體對個體的直接借貸行為， 其中也包含(P2B)債權讓與的借貸模式．
                            </p> -->
                        </div>
                    </div>
                    <div class="title10 text-center">智能媒合項目</div>
                    <div class="img100" aos="fade-up" aos-duration="2000"> <img src="{{asset('../images/5bg.png')}}" alt="" class="mob">
                        <img src="{{asset('../images/100m.png')}}" alt="" class="mob2">
                    </div>
                    <div class="text-center fos2">
                        <div class="fos">簡易認購步驟</div>
                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="about_bg2">
        <div class="container">
            <div class="title11 text-center" aos="fade-up">智能媒合項目操作四步驟</div>
            <div class="row" aos="fade-up">
                <div class="col-md-3 col-33 c-1 col-sm-12 arpd">
                    <div class="heblock"><img src="{{asset('../images/guide_step1.png')}}" alt=""  class="igpd"></div>
                    <h6>STEP<span>01</span></h6>
                    <h2>註冊會員</h2>
                    <span class="fos">完成「實名認證」，通過審核</span>

                </div>
                <div class="col-md-3 col-33 c-1 col-sm-12 arpd">
                    <div class="heblock"><img src="{{asset('../images/guide_step2.png')}}" alt=""  class="igpd"></div>
                    <h6>STEP<span>02</span></h6>
                    <h2>項目媒合</h2>
                    <span class="fos">依據風險屬性，自動媒合投資標的</span>

                </div>
                <div class="col-md-3 col-33 c-1 col-sm-12 arpd">
                    <div class="heblock"><img src="{{asset('../images/guide_step3.png')}}" alt=""  class="igpd"></div>
                    <h6>STEP<span>03</span></h6>
                    <h2>完成繳款</h2>
                    <span class="fos">系統出繳款單，完成繳費作業</span>

                </div>
                <div class="col-md-3 col-33 c-1 col-sm-12 arpd">
                    <div class="heblock"><img src="{{asset('../images/guide_step4.png')}}" alt=""  class="igpd"></div>
                    <h6>STEP<span>04</span></h6>
                    <h2>收取報酬</h2>
                    <span class="fos">依據債權合約說明，每月收取報酬</span>

                </div>
            </div>
        </div>
        <!-- <div class="enter_more2 floating">
    <i class="fa fa-chevron-right" aria-hidden="true" style="margin-left: 12px;"></i>
</div> -->
    </div>
    <section class="section section--code bg3">
        <div class="container">
            <div class="row">
                <div class="text_bg6">
                    <div class="title10a text-center" aos="fade-up">特別投資項目操作四步驟</div>
                    <div class="img100" aos="fade-up" aos-duration="2000"> <img src="{{asset('../images/bg3_1.png')}}" alt="" class="mob">
                        <img src="{{asset('../images/m2_1.png')}}" alt="" class="mob2">
                    </div>
                    <div class="text-center fos2">
                        <div class="fos">簡易認購步驟</div>
                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="about_bg6">
        <div class="container">
            <div class="title11 text-center" aos="fade-up">特別投資項目操作四步驟</div>
            <div class="row" aos="fade-up">
                <div class="col-md-3 col-33 c-1 col-sm-12 arpd">
                    <div class="heblock"><img src="{{asset('../images/guide_step1.png')}}" alt=""  class="igpd"></div>
                    <h6>STEP<span>01</span></h6>
                    <h2>註冊會員</h2>
                    <span class="fos">完成「實名認證」，通過審核</span>

                </div>
                <div class="col-md-3 col-33 c-1 col-sm-12 arpd">
                    <div class="heblock"><img src="{{asset('../images/guide_step5.png')}}" alt=""  class="igpd"></div>
                    <h6>STEP<span>02</span></h6>
                    <h2>項目認購</h2>
                    <span class="fos">選擇投資項目，單筆認購</span>

                </div>
                <div class="col-md-3 col-33 c-1 col-sm-12 arpd">
                    <div class="heblock"><img src="{{asset('../images/guide_step3.png')}}" alt=""  class="igpd"></div>
                    <h6>STEP<span>03</span></h6>
                    <h2>完成繳款</h2>
                    <span class="fos">系統出繳款單，完成繳費作業</span>

                </div>
                <div class="col-md-3 col-33 c-1 col-sm-12 arpd">
                    <div class="heblock"><img src="{{asset('../images/guide_step4.png')}}" alt=""  class="igpd"></div>
                    <h6>STEP<span>04</span></h6>
                    <h2>收取報酬</h2>
                    <span class="fos">依據債權合約說明，每月收取報酬</span>

                </div>
            </div>
        </div>
        <!-- <div class="enter_more2 floating">
    <i class="fa fa-chevron-right" aria-hidden="true" style="margin-left: 12px;"></i>
</div> -->
    </div>
    <section class="section section--code bg1" id="#id5">
        <div class="container">
            <div id="id5" class="row con60 tohere">
                <div class="text_bg5">
                    <div class="col-md-6 offset-md-3 text-center ">
                        <div class="text-center pad25">
                            <!--<div class="stitle">charge</div>-->
                            <div class="title1">資費說明</div>
                            <!--     <p class="cop">金融科技(Fintech)浪潮中的一個趨勢，個體對個體的直接借貸行為， 其中也包含(P2B)債權讓與的借貸模式．
                            </p> -->
                        </div>
                    </div>
                    <div class="container">
                        <div id="id1" class="row con60 tohere">
                            <div class="text_other ">
                                <div class="row text-left m-auto">
                                    <div class="col-md-4 float-left">
                                        <ul class="member-group">
                                            <li><h4>會員註冊費</h4><p>$0</p></li>
                                            <li><h4>投資媒合服務費</h4><p>10%</p><span>投資收益金額</span></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-8 text-left text-group">
                                        <!--<div class="title1">投資產品</div>-->
                                        <ul class="A">
                                            　  <li><p class="cop_text cop">無論您選擇智能媒合或特別投資項目，手續費一律為投資收益的10%，將隨您每月投資收益金額中扣除。</p></li>
                                                <li><p class="cop_text cop">您支付的服務費用，本公司將依您總應收取利息中，四捨五入至整數位後計算本公司總應收服務費金額，並平均攤入每期到期日後收取，平均攤計金額如小於1元，
                                                    則以1元計算；累計當期已收足總應收服務費後，往後期數不再計收服務費。</p></li>
                                                <li><p class="cop_text cop">每次返還給您的投資的本金及利息將需扣除30元銀行匯款手續費，如您提供以下銀行帳戶將可免除該手續費：1.彰化銀行2.合作金庫 3.中國信託 4.元大銀行。(手續費優惠活動將另外公告)</p></li>
                                                <li><p class="cop_text cop">對於您已投標繳款但最後流標的債權申購，我們會將申購的款項退還至您預留的銀行帳號，如銀行帳號非屬於上列銀行，將需扣除30元的銀行匯款手續費。(手續費優惠活動將另外公告)</p></li>
                                        </ul>
                                        <p class="cop_text cop"><div class="index-main-button "><a href="/front/operation_faq">前往Ｑ＆Ａ</a> </div></p>
                                            
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>

</div>
    <!-- js -->

    <script type="text/javascript" src="/menu/nav.js"></script>
    <script type="text/javascript" src="/aos/aos_wy.js"></script>
@endsection    

     