@extends('Front_End.layout.header')
@section('content')
<div id="main-page">
    <link rel="stylesheet" href="/css/about.css" />
    <link rel="stylesheet" media="screen" href="/modal/modal.css" />
    <script type='text/javascript' src="/20210601/ajax/bootstrap-datepicker/1.8.0/bootstrap-datepicker.min.js"></script>
    <script type='text/javascript' src="/20210601/ajax/jquery.tablesorter/2.28.14/jquery.tablesorter.min.js"></script>
    <div id="banner-box">
        <!--  <div class="banner-nav banner-nav-abs">
            <div class="banner-inner png">
                <ul>
                    <li>
                        <div></div><a href="javascript:;" class="bg1"><span class="png"></span>营销型网站建设</a></li>
                    <li>
                        <div></div><a href="javascript:;" class="bg2"><span class="png"></span>全能网站建设</a></li>
                    <li>
                        <div></div><a href="javascript:;" class="bg3"><span class="png"></span>移动APP</a></li>
                    <li>
                        <div></div><a href="javascript:;" class="bg4"><span class="png"></span>微网站建设</a></li>
                    <li>
                        <div></div><a href="javascript:;" class="bg5"><span class="png"></span>企业增值服务</a></li>
                    <li>
                        <div></div><a href="javascript:;" class="bg6"><span class="png"></span>SEO全网营销</a></li>
                </ul>
            </div>
        </div> -->
        <div class="banner-list">
            <!--活动-->
            <li class="b-about-bg">
                <div class="animate-box png">
                    <div class="t-d" aos="fade-right">
                        <h2>亞太普惠金融科技公司</h2>
                        <p>
                            Asia Money Fintech Company
                        </p>
                    </div>
                    <div class="animate-img"><img src="{{asset('../banner/img/a777b23736b812414d59e18810923b54.png')}}"
                            alt=" "></div>
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
                <li><a href="#id1" class="goto">公司介紹</a></li>
                <li><a href="#id2" class="goto">創辦人</a></li>
                <li><a href="#id3" class="goto">法律顧問</a></li>
                {{-- <li><a href="#id4" class="goto">關於豬豬在線</a></li> --}}
            </ul>
        </div>
    </div>
    <section class="section section--code  about-bg1">
        <div class="container">
            <div id="id1" class="row con60 tohere row-xs">
                <div class="text_other ">
                    <div class="row text-left m-auto row-xs">
                        <div class="col-md-4 col-sm-12 float-left mob-display">
                            <img src="{{asset('../images/about_img_1.png')}}" width="320" style="margin: auto;">
                        </div>
                        <div class="col-md-8 col-sm-12 text-left ">
                            <div class="stitle_1 stitle_3">Company Profile</div>
                            <div class="title1">公司介紹及理念</div>
                            <p class="cop_year">亞太普惠金融科技公司（Asia Money Fintech Company）成立於2013年</p>
                            <p style="text-align: justify;" class="cop_text">經營團隊擁有20年以上金融高階經理人的資歷及豐富的信用風險管理技術，多年來專注於經營消費商品分期金融業務，
                                累積服務的客戶數已經超過10萬筆，總管理資產超過新台幣55億元。
                                經營團隊憑藉著過去多年穩健經營實力與經驗，發展了信賴度頗高的信用評分及風控模型，更注入了許多自動化金融科技
                                元素。持續秉持著公司經營理念「創新」、「專業」、「效率」、「誠信」，期許能夠繼續在普惠金融的場景中，為社會
                                所有階層和群體提供最合適及最便捷的金融產品及服務。我們的專業及效率，堅守最佳風險管理下，業務穩健成長、
                                企業永續經營，期許成為一個成功的金融科技創新服務公司！

                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- <section class="section section--code bg_gary" id="id2">
        <div class="container">
            <div   class="row con60 tohere">
                <div class="text_other">
                    <div class="col-md-7  text-center m-auto">
                        <div class="text-center">
                            <div class="stitle_1">Company Profile</div>
                            <div class="title1">經營團隊</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <section id="id2" class="bb" style="background-color: #d3d3d3;">
        <div class="container pd0">
            <div class="about_0">
                <div class="row row-xs">
                    <div class="text_other2">
                        <div class="col-md-12   col-sm-12 text-left m-auto">
                            <div class="col-md-7 col-sm-12 text-left float-left ">
                                <div class="stitle_2">CEO執行長</div>
                                <div class="title2">唐正峰 Kevin Tang</div>
                                <ul class="ul-about">
                                    <li>
                                        <h3>國立政治大學</h3>
                                        <p>EMBA企業管理碩士</p>
                                    </li>
                                    <li>
                                        <h3>星展銀行(台灣)</h3>
                                        <p>個人金融處 董事總經理</p>
                                    </li>
                                    <li>
                                        <h3>美商友邦集團(台灣)</h3>
                                        <p>消費金融事業 台灣區總經理</p>
                                    </li>
                                    <li>
                                        <h3>美商奇異集團(台灣)</h3>
                                        <p>消費金融事業 台灣區營運長</p>
                                    </li>
                                </ul>

                            </div>
                            <div class="col-md-5 col-sm-12 float-left">
                                <img src="{{asset('../images/t6.jpg')}}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="id3">
        <div class="container-fluid pd0">
            <div class="about_bg">
                <div class=" con60">
                    <div class="text_other">
                        <div class="col-md-12  text-center m-auto">
                            <div class="text-center">
                                <div class="title3 color4">法律顧問<br><span>鴻安律師事務所</span></div>
                                <p class="text-center"><img src="{{asset('../images/about8.jpg')}}"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--舊-->
    {{-- <section id="id4">
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
        <!-- 投資運行模式 -->
        <div class="modal fade " id="exampleModalLong3" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog w-modal-content" role="document">
                <div class="modal-content  ">
                    <div class="mobg3">
                        <div class="modal-header">
                            <!--  <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5> -->
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="modal-title-b text-center">Operating Mode</div>
                            <div class="modal-title-c text-center">投資運行模式</div>
                            <div class="modal-all-p">
                                <div class="modal-f1">
                                    <img src="../images/index_open.png" alt="" width="100%">
                                    <div class="" style="width: 100%;text-align: center;">
                                        <img src="../images/scroll.png" alt="">
                                    </div>
                                    <div class="index-modal-open">
                                        <div class="open2"><img src="../images/index_open2.png" alt=""></div>
                                        <div class="indext20">
                                            <div class="f23m">智能媒合項目</div>
                                            <div class="index-3">
                                                <div class="heblock">
                                                    <img src="../images/n1.png" alt="" width="22" class="igpd">
                                                </div>
                                                <span class="fos">完成註冊登入會員</span>
                                            </div>
                                            <div class="index-3">
                                                <div class="heblock">
                                                    <img src="../images/n2.png" alt="" width="22" class="igpd">
                                                </div>
                                                <span class="fos">自行風險屬性評估
                                                </span>
                                            </div>
                                            <div class="index-3">
                                                <div class="heblock">
                                                    <img src="../images/n3.png" alt="" width="22" class="igpd">
                                                </div>
                                                <span class="fos">挑選最適的個人投資風險等級的組合
                                                </span>
                                            </div>
                                            <div class="index-3">
                                                <div class="heblock">
                                                    <img src="../images/n4.png" alt="" width="22" class="igpd">
                                                </div>
                                                <span class="fos">審閱債權案件及投資條件
                                                </span>
                                            </div>
                                            <div class="index-3">
                                                <div class="heblock">
                                                    <img src="../images/n5.png" alt="" width="22" class="igpd">
                                                </div>
                                                <span class="fos">進行智能媒合（依照風險組合進行案件媒合挑選）
                                                </span>
                                            </div>
                                            <div class="index-3">
                                                <div class="heblock">
                                                    <img src="../images/n6.png" alt="" width="22" class="igpd">
                                                </div>
                                                <span class="fos">完成投資及繳費，完成線上投資憑證合約
                                                </span>
                                            </div>
                                            <div class="index-3">
                                                <div class="heblock">
                                                    <img src="../images/n7.png" alt="" width="22" class="igpd">
                                                </div>
                                                <span class="fos">開始享受每月固定投資利息
                                                </span>
                                            </div>
                                            <div class="index-3">
                                                <div class="heblock">
                                                    <img src="../images/n8.png" alt="" width="22" class="igpd">
                                                </div>
                                                <span class="fos">豬豬在線僅收取雙方的媒合手續費
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="" style="width: 100%;text-align: center;">
                                        <img src="../images/scroll.png" alt="">
                                    </div>
                                    <div class="index-modal-open">
                                        <div class="open2"><img src="../images/index_open3.png" alt=""></div>
                                        <div class="indext20">
                                            <div class="f23m">特別投資項目</div>
                                            <div class="index-3">
                                                <div class="heblock">
                                                    <img src="../images/n1.png" alt="" width="22" class="igpd">
                                                </div>
                                                <span class="fos">完成註冊登入會員</span>
                                            </div>
                                            <div class="index-3">
                                                <div class="heblock">
                                                    <img src="../images/n2.png" alt="" width="22" class="igpd">
                                                </div>
                                                <span class="fos">審閱債權案件及投資條件
                                                </span>
                                            </div>
                                            <div class="index-3">
                                                <div class="heblock">
                                                    <img src="../images/n3.png" alt="" width="22" class="igpd">
                                                </div>
                                                <span class="fos">進行特別個案挑選及投標
                                                </span>
                                            </div>
                                            <div class="index-3">
                                                <div class="heblock">
                                                    <img src="../images/n4.png" alt="" width="22" class="igpd">
                                                </div>
                                                <span class="fos">完成投資申購及繳費，完成線上投資憑證合約
                                                </span>
                                            </div>
                                            <div class="index-3">
                                                <div class="heblock">
                                                    <img src="../images/n5.png" alt="" width="22" class="igpd">
                                                </div>
                                                <span class="fos">開始享受每月固定投資利息
                                                </span>
                                            </div>
                                            <div class="index-3">
                                                <div class="heblock">
                                                    <img src="../images/n6.png" alt="" width="22" class="igpd">
                                                </div>
                                                <span class="fos">豬豬在線僅收取雙方的媒合手續費
                                                </span>
                                            </div>
                                        </div>
                                    </div>
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
        <!-- 投資運行模式 -->
        <!-- 豬豬再現服務項目 -->
        <div class="modal fade" id="exampleModalLong4" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLongTitle" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="mobg4">
                        <div class="modal-header modal-header2 hader-2">
                            <!--  <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5> -->
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body b1">
                            <div class="modal-all-p b1p">
                                <div class="modal-title-b" style="padding-top: 0px;">About</div>
                                <div class="modal-title-c f23ma">豬豬在線服務</div>
                                <div class="f140 tp20">
                                    豬豬在線是隸屬於亞太普惠金融科技集團旗下信任豬股份有限公司經營的債權轉讓智能媒合投資平台，主要產品為媒合各類優質的消費商品分期債權，客戶數量多且分散，内容涵蓋了醫學美容、教育學習、生活3C用品等實際消費場景；平台也以提昇台灣的消費經濟、互利普惠金融及建立信用環境為運營的宗旨！
                                </div>
                                <div class="f140 tp20">
                                    亞太普惠金融科技集團憑藉著過去5年的穩健經營績效與經驗，以及有多年國際金融機構服務經驗的資深管理團隊，一起攜手創立了信任豬股份有限公司，志在實現金融科技普惠大眾的願景，創造一個共享互利的互聯網平台。豬豬在線平台主要以最新的智能媒合科技並結合真實驗證的信用風險評分模型，提供給普惠大眾輕鬆方便的理財新體驗。
                                </div>
                            </div>
                        </div>
                        <div class="modal-body b2">
                            <!-- <div class="modal-title-ba">Service</div> -->
                            <div class="modal-all-p b1p b1pr">
                                <div class="modal-title-c f23ma" style="color: #fff">豬豬在線債權轉讓模式特點</div>
                                <div class="f140 tp20" style="color: #fff"> 在法律的規範下，放款人（債權人）
                                    與借款人簽訂借款協議，資金先行出借給借款人（債務人）並取得相應的債權，豬豬在線再將放款人擁有的債權進行整理並上架至網貸平台，通過債權轉讓的方式供投資大眾（債權受讓人）投標買受。在這個模式中，基本的法律主體有四個：投資人、放款人、借款人及網貸平台。其中，放款人與借款人之間是民間借貸法律關係、放款人與投資人之間是債權讓受關係、網貸平台則為相應交易提供居間進行必要的信用及風險評估、資金交易及債權轉讓媒合的服務。此種創新模式可以很好的解決了“P2P點對點”模式中投資人與借款人不好匹配的問題。
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="modal-body b3">
                            <div class="w450">
                                <div class="modal-title-c f23ma">豬豬在線會員好處</div>
                                <div class="f140 tp20 tp202">
                                    豬豬在線會定期且頻繁地提供新的債權上架，成為豬豬在線會員後，可以使用智能媒合科技輕鬆快速地完成最合適自我風險喜好的債權投資組合，當然也可以根據不同的風險評級、自我喜好與債權期限等，選擇單一債權個案進行投資，可以有效地提高閒置資金的利用率並獲得較高的理財報酬。
                                </div>
                                <div class="modal-title-c f23ma top0">成為會員無需支付任何費用</div>
                                <div class="f140 tp20 tp202"> 註冊成為豬豬在線會員是完全免費的，只有在您完成投資媒合，匯款並獲得收益時，平台才會向您收取手續費。</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--舊-->
        <!-- 豬豬再現服務項目 -->
        <div class="modal fade" id="exampleModalLong4 id3" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLongTitle" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="mobg4">
                        <div class="modal-header modal-header2 hader-2">
                            <!--  <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5> -->
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body b1">
                            <!--     <div class="modal-title-ba">Service</div> -->
                            <div class="modal-all-p b1p">
                                <div class="modal-title-c f23ma">豬豬在線服務項目</div>
                                <div class="f140 tp20"> 豬豬在線是隸屬於亞太普惠金融集團旗下信任豬股份有限公司經營的債權轉讓媒合平台。</div>
                                <div class="f140 tp20">
                                    2016年，亞太普惠金融集團憑藉著超過10年商品分期的穩健實力與經驗，加上有國際金融機構服務經驗的資深管理團隊創立了信任豬股份有限公司志在實現金融科技普惠於大眾的願景，創造共享互利的平台。
                                </div>
                                <div class="f140 tp20"> 豬豬在線平台主要依託最新的智能媒合科技技術並結合信用風險評分模型，提供給廣大個人投資人輕鬆方便的投資體驗。</div>
                            </div>
                        </div>
                        <div class="modal-body b2">
                            <!--     <div class="modal-title-ba">Service</div> -->
                            <div class="modal-all-p b1p b1pr">
                                <div class="modal-title-c f23ma" style="color: #fff">豬豬在線債權轉讓模式特點</div>
                                <div class="f140 tp20" style="color: #fff">
                                    豬豬在線的債權轉讓模式中，專業放款人(債權人)與借款人簽訂相應借款協議，並將資金先出借給融資客戶(借款人)取得相應債權，專業放款人取得相應債權後，網貸媒合平台將專業放款人手裡的債權進行拆分（金額或期限或二者兼而有之)借助網貸平台通過債權轉讓的方式轉讓給投資人（債權受讓人)。
                                </div>
                            </div>
                        </div>

                        <div class="modal-body b3">


                            <div class="w450">
                                <div class="modal-title-c f23ma">信任豬會員好處</div>
                                <div class="f140 tp20 tp202">
                                    豬豬在線每日都將提供新的債權上架，成為豬豬在線會員後，您可以使用智能科技媒合輕鬆快速幫您完成最合適的債權組合，您也可以根據不同的風險評級與債權期限，選擇單一債權進行投資，如此可以有效提高資金的利用率並獲得較高的回報。
                                </div>


                                <div class="modal-title-c f23ma top0">成為會員無需支付任何費用</div>
                                <div class="f140 tp20 tp202"> 註冊成為豬豬在線會員是完全免費的, 只有在您完成投資媒合，匯款並獲得收益時,平台才會向您收取手續費。</div>

                            </div>






                        </div>




                    </div>
                </div>
            </div>
        </div>
        <!-- 豬豬再現服務項目 -->
        <div class="container" id="id4">
            <div class="row con60 row-xs">
                <div class="text_bg3">
                    <div class="col-md-6 offset-md-3 text-center " aos="fade-up">
                        <div class="text-center">
                            <div class="stitle">pigpigonline</div>
                            <div class="title4">關於豬豬在線</div>
                            <!-- <p class="cop">什麼是豬豬在線、信用評分及智能媒合、投資運行模式: 智能媒合項目, 特別投資項目
                            </p> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <div class="container-fluid  service_jpg" aos="fade-up">
                <div class="service_line"></div>
                <div class="service_line2"></div>
                <div class="service_line3"></div>
                <div class="row row-xs group-ul ">
                    <div class="col-md-3 col-sm-6 mouse_row group-li">
                        <div class="col-md-9 mx-auto p20" data-toggle="modal" data-target="#exampleModalLong4">
                            <div class="stitle_1">Service</div>
                            <div class="title1_1">豬豬在線服務</div>
                            <p class="cop_1">運用最新的智能媒合科技、安全的債權讓與、穩健有效的信用評分模型，提供便捷的普惠金融服務，讓您輕鬆體驗理財樂趣！
                            </p>
                            <a href="#">
                                <div class="about_enter_more">
                                    閱讀更多
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mouse_row2 group-li">
                        <div class="col-md-9 mx-auto p20" data-toggle="modal" data-target="#exampleModalLong2">
                            <div class="stitle_1">Credit score</div>
                            <div class="title1_1">什麼是信用評分?</div>
                            <p class="cop_1">信用評分最初是由美國的一家信用評分公司FICO(Fair Issac & Company)
                                於1989年推出，信用評分旨在通過考慮個人財務歷史中的各種因素來衡量違約風險。
                            </p>
                            <a href="#">
                                <div class="about_enter_more">
                                    閱讀更多
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mouse_row3 group-li">
                        <div class="col-md-9 mx-auto p20 " data-toggle="modal" data-target="#exampleModalLong">
                            <div class="stitle_1">Smart matching</div>
                            <div class="title1_1">什麼是智能媒合</div>
                            <p class="cop_1">根據投資人的風險屬性選擇，自動媒合相對應的投資組合，快速進行投資媒合。
                            </p>
                            <a href="#">
                                <div class="about_enter_more group-li">
                                    閱讀更多
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mouse_row4 group-li">
                        <div class="col-md-9 mx-auto p20" data-toggle="modal" data-target="#exampleModalLong3">
                            <div class="stitle_1">Operating Mode</div>
                            <div class="title1_1">投資運行模式</div>
                            <p class="cop_1">借投媒合成立、債權讓與及按期投資報酬給付
                            </p>
                            <a href="#">
                                <div class="about_enter_more">
                                    閱讀更多
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- js -->
    <!-- Custom styles for this template -->
    <!-- 往下滾依序出現 -->
    <script type="text/javascript" src="/menu/nav.js"></script>
    <script type="text/javascript" src="/aos/aos_wy.js"></script>
</div>
@endsection