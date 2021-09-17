@extends('Front_End.layout.header')

@section('content')

<div id="main-page">
    <link rel="stylesheet" media="screen" href="/css/qa.css" />
    <link rel="stylesheet" media="screen" href="/css/table.css" />

    <div id="banner-box">
        <div class="banner-list">
            <li style="background: url(/banner/img/33.jpg);">
                <div class="animate-box png">
                    <div class="t-d" aos="fade-right" aos-duration="1000">
                        <h2>卓越風險管理<br>小額多元投資<br>快速安全理財</h2>
                        <br>
                    </div>
                    <div class="animate-img"><img src="/banner/img/a777b23736b812414d59e18810923b54.png"></div>
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
                {{-- <li><a style="outline:none" href="#id0" class="goto active">關於豬豬在線</a></li>
                <li><a style="outline:none" href="#id1" class="goto active">關於登入／註冊</a></li>
                <li><a style="outline:none" href="#id2" class="goto active">關於投資</a></li>
                <li><a style="outline:none" href="#id3" class="goto active">關於貸款</a></li>
                <li><a style="outline:none" href="#id4" class="goto active">關於資料安全 / 瀏覽器</a></li>
                <li><a style="outline:none" href="#id5" class="goto active">豬豬推手</a></li> --}}
                 @foreach ($listGroup as $k => $groupTitle)
                    <li><a style="outline:none" href="#l_{{$k}}" class="goto active">{{$groupTitle}}</a></li>
                 @endforeach
            </ul>
        </div>
    </div>
    <div class="container_bg">
        <div class="container">
            <div class="row">
                <div id="accordion">
                    <div class="to20 tohere">
                        @foreach ($listGroup as $k => $groupTitle)
                        <div class="bgbg" id="l_{{$k}}">
                            <span class="color5  tbg">{{ $groupTitle }}</span>
                        </div>
                        @foreach ($qa as $q)
                        @if($q['name'] == $groupTitle)
                        <div class="card">
                            <div class="card-header" id="heading0">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>{{ $q['title'] }}</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse0" class="collapse" aria-labelledby="heading0" data-parent="#accordion">
                                <div class="card-body">
                                    {!! $q['content'] !!}
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach

                        @endforeach
                        {{-- <div class="bgbg">
                            <span id="#id0" class="color5  tbg">關於豬豬在線</span>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading0">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>什麼是「債權轉讓」</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse0" class="collapse" aria-labelledby="heading0" data-parent="#accordion">
                                <div class="card-body">
                                    <p>依照民法第294條，債權人得將債權讓與（全部或部分）給第三人。豬豬在線平台所媒合的債權皆為合法可轉讓的完整債權，您可以安心投資。</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading1">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>豬豬在線是什麼樣的平台？</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse1" class="collapse" aria-labelledby="heading1" data-parent="#accordion">
                                <div class="card-body">
                                    <p>豬豬在線是隸屬於亞太普惠金融科技集團 <a href="http://www.amfc.com.tw/" rel="noopener noreferrer"
                                            target="_blank">http://www.amfc.com.tw/</a>
                                        旗下信任豬股份有限公司經營的債權轉讓智能媒合投資平台。亞太普惠金融科技集團憑藉著過去5年的穩健經營績效與經驗，以及有多年國際金融機構服務經驗的資深管理團隊，一起攜手創立了信任豬股份有限公司，志在實現金融科技普惠大眾的願景，創造一個共享互利的互聯網平台。豬豬在線平台主要以最新的智能媒合科技並結合真實驗證的信用風險評分模型，提供給廣大投資人輕鬆方便的理財新體驗。
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading2">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>豬豬在線的運營模式為何？</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse2" class="collapse" aria-labelledby="heading2" data-parent="#accordion">
                                <div class="card-body">
                                    <p>在法律的規範下，放款人（債權人）
                                        與借款人簽訂借款協議，資金先行出借給借款人（債務人）並取得相應的債權，豬豬在線再將放款人擁有的債權進行整理並上架至媒合平台，通過債權轉讓的方式供投資大眾（債權受讓人）投標買受。在這個模式中，基本的法律主體有四個：投資人、放款人、借款人及媒合平台。其中，放款人與借款人之間是民間借貸法律關係、放款人與投資人之間是債權讓受關係、媒合平台則為相應交易提供居間進行必要的信用及風險評估、資金交易及債權轉讓媒合的服務。此種創新模式可以很好的解決了&ldquo;P2P點對點&rdquo;模式中投資人與借款人不好匹配的問題。
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading3">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>豬豬在線為何是你最佳的投資平台</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse3" class="collapse" aria-labelledby="heading3" data-parent="#accordion">
                                <div class="card-body">
                                    <p>平台會定期且頻繁地提供新的債權上架，成為豬豬在線會員後，可以使用智能媒合科技輕鬆快速地完成最合適自我風險喜好的債權投資組合，當然也可以根據不同的風險評級、自我喜好與債權期限等，選擇單一債權個案進行投資，可以有效地提高閒置資金的利用率並獲得較高的理財報酬。另外，還有以下的優點：<br>1、穩定的高收益率：
                                        近年來，銀行一年的定存利率約在 1%，央行5年期公債殖利率約為
                                        0.7%，股票與基金投資的報酬率的高低變化可能達到正負15%，甚至更大；在優質的風險管控下，豬豬在線的報酬率則可以穩定地落在年化收益率3%-9%，遠高於銀行定存利率及央行公債，穩定度也相對優於股票與基金的投資。<br>2、較低的投資門檻：
                                        銀行的理財商品，保險及證券等投資門檻大多數都設定100 萬，並非一般小資大衆可以達到的；豬豬在線的智能媒合投資門檻最低為
                                        3萬元，單一債權項目投資每筆下限為1萬元，適合各類型的投資人，輕鬆滿足投資理財生活。<br>3、債權產品多元：
                                        豬豬在線將定期及頻繁地上架新的債權物件，各種期別的債權物件供選擇，讓投資會員的資金運用更靈活。</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="id1" class="to20 tohere">
                        <div class="bgbg">
                            <span id="#id1" class="color5  tbg">關於登入／註冊</span>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading4">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>如何「註冊會員」</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse4" class="collapse" aria-labelledby="heading4" data-parent="#accordion">
                                <div class="card-body">
                                    <p>只要您是中華民國國民且年滿20歲即可註冊成為會員。</p>
                                    <p>註冊流程：<br>Step1、點擊「登入/註冊」-&gt;「註冊會員」後，書戶您的E-mail、真實姓名、身分證字號、手機、密碼，系統將自動發送「電郵認證信」至您的電子信箱，直接點選連結網址即可進行會員資料設定。<br>Step2、登入「會員專區」填寫個人基本資料（個人真實資訊、銀行帳號、會員風險評估、投資習慣設定），資料審核後才可進行線上投資。
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading7">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>如何設定「個人真實資訊」</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse7" class="collapse" aria-labelledby="heading7" data-parent="#accordion">
                                <div class="card-body">
                                    <p>點擊「個人真實資訊」填寫①個人資料名稱②上傳身分證③手機號碼驗證後，即可提交審核，完成設定。</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading9">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>如何設定「銀行帳戶」</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse9" class="collapse" aria-labelledby="heading9" data-parent="#accordion">
                                <div class="card-body">
                                    <p>點擊「銀行帳戶」，填寫您需新增的銀行帳戶，輸入完成後，點擊「新增銀行帳戶」即可完成設定。</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading11">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>如何設定「會員風險評量」</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse11" class="collapse" aria-labelledby="heading11" data-parent="#accordion">
                                <div class="card-body">
                                    <p>點擊「會員風險評量」，完成填寫問卷後點擊「更新風險評量」，系統將出現您評量分數及建議的投資風險屬性。</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading13">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>如何設定「投資習慣設定」</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse13" class="collapse" aria-labelledby="heading13" data-parent="#accordion">
                                <div class="card-body">
                                    <p>點擊「投資習慣設定」，
                                        可以參考「會員風險評量」結果建議的投資風險屬性或自行選擇適合的投資屬性，也可點選每一種投資屬性下方的説明進一步了解投資組合的調整。確定投資風險屬性後，點擊「儲存」即可完成設定。
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading14">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>如何了解自己的「投資風險屬性」</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse14" class="collapse" aria-labelledby="heading14" data-parent="#accordion">
                                <div class="card-body">
                                    <p>進行投資交易之前，建議您前往「會員專區」點擊「會員資料設定」，完成「會員風險評量」問卷後，將可以看到風險評量結果及風險屬性類型，做為您投資習慣設定的參考。</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading17">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>加入會員需要收費嗎？</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse17" class="collapse" aria-labelledby="heading17" data-parent="#accordion">
                                <div class="card-body">
                                    <p>註冊成為豬豬在線會員「完全免費」，只有在您完成投資媒合，匯款並獲得投資收益時，平台才會向您收取手續費。</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading19">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>註冊後的會員資料可以修改嗎？</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse19" class="collapse" aria-labelledby="heading19" data-parent="#accordion">
                                <div class="card-body">
                                    <p>只能修改通訊地址、手機號碼。</p>
                                    <p>進點擊「會員專區-&gt;我的帳戶-&gt;個人真實資料」中修改(需點擊&ldquo;發送驗證碼&rdquo;即可完成提交審核；如果您需要更改戶籍地址，請您將新的身分證正反面拍照並送至
                                        service@pponline.com.tw 或加入<a href="https://goo.gl/i2iZZB">官方line客服</a>
                                        ，客服人員將儘快為您處理。</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading22">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>註冊後的銀行帳戶可以修改嗎？</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse22" class="collapse" aria-labelledby="heading22" data-parent="#accordion">
                                <div class="card-body">
                                    <p>可以的！</p>
                                    <p>點擊「會員專區-&gt;我的帳戶-&gt;銀行帳號」新增或刪除您的銀行帳戶資料。</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading24">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>會員風險評量可以更新嗎？</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse24" class="collapse" aria-labelledby="heading24" data-parent="#accordion">
                                <div class="card-body">
                                    <p>可以的！</p>
                                    <p>您可以定期進入「會員專區-&gt;會員風險評量」，更新您的投資風險屬性。</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading27">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>註冊後的投資習慣設定可以修改嗎？</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse27" class="collapse" aria-labelledby="heading27" data-parent="#accordion">
                                <div class="card-body">
                                    <p>可以的！</p>
                                    <p>您可點擊「會員專區-&gt;我的帳戶-&gt;投資習慣設定」更改您投資習慣設定。</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading28">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>註冊後的密碼可以修改嗎？</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse28" class="collapse" aria-labelledby="heading28" data-parent="#accordion">
                                <div class="card-body">
                                    <p>可以的！</p>
                                    <p>您可點擊「會員專區-&gt;我的帳戶-&gt;密碼修改」。</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="id2" class="to20 tohere">
                        <div class="bgbg">
                            <span id="id2" class="color5  tbg">關於投資</span>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading5">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>投資金額有限制嗎？</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse5" class="collapse" aria-labelledby="heading5" data-parent="#accordion">
                                <div class="card-body">
                                    <p>有的！智能媒合投資下限為3萬元，上限為200 萬元；若爲特別投資項目，每筆投資下限及上限將依照個別債權物件制定。</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading6">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>認購債權後如何繳款？</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse6" class="collapse" aria-labelledby="heading6" data-parent="#accordion">
                                <div class="card-body">
                                    <p>您投標的債權確認完成結標後，平台將「繳款通知書」傳至您的電子信箱，您需於匯款截止日前依照繳款通知書指示，將款項匯入您個人的指定虛擬帳號中。<br>※
                                        您也可至銀行設定約定轉帳，方便日後線上繳費作業喔。</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading8">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>投資有保證金或手續費嗎？</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse8" class="collapse" aria-labelledby="heading8" data-parent="#accordion">
                                <div class="card-body">
                                    <p>平台投資不需繳交任何保證金。手續費為每次投資收益的10%，隨每月投資配息時一併扣除並收取。</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading10">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>於投資繳款截止日沒有完成匯款會有罰則嗎？</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse10" class="collapse" aria-labelledby="heading10" data-parent="#accordion">
                                <div class="card-body">
                                    <p>若您在一個月内有「兩次」逾期未繳費紀錄，未來三個月將無法在平台進行任何投資。</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading12">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>什麼是投資媒合的程序</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse12" class="collapse" aria-labelledby="heading12" data-parent="#accordion">
                                <div class="card-body">
                                    <p>首先您需註冊會員並完成個人真實信息、銀行帳戶資料及投資習慣的設定，接下來即可以進入智能媒合項目或特別投資項目。<br>【智能媒合項目】<br>a.點選「投資認購」<br>b.點選「智能媒合項目」<br>c.點選「智能投資」<br>d.輸入投資金額<br>e.依照設定的風險屬性選擇智能組合，亦可調整組合中每一個風險評等的投入比例，或點選「更換智能組合」<br>f.點選「試算」<br>g.點選「投標」<br>h.勾選「本人已詳閱所有債權讓售協議書與應注意事項，並同意且接受合約及應注意事項所有條款無誤」<br>i.完成投標
                                    </p>
                                    <p><br>【特別投資項目】<br>a.點選「投資認購」<br>b.點選「特別投資項目」<br>c.可點選任一個「物件編號」進行瀏覽與評估自行判斷投資標的<br>d.點選「投資試算」，即可快速查看每期回收金額、本金與投資利息<br>e.
                                        點選「投標」進行認購<br>f.勾選「本人已詳閱債權讓售協議書與應注意事項，並同意且接受協議書及應注意事項所有條款無誤」<br>g.完成投標</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading15">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>什麼是「智能媒合」</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse15" class="collapse" aria-labelledby="heading15" data-parent="#accordion">
                                <div class="card-body">
                                    <p>根據投資人的風險屬性選擇，自動媒合相對應的投資組合，快速進行投資媒合。
                                        豬豬在線首創債權轉讓智能媒合，依照您挑選的投資風險屬性，系統將以1,000元為最小單位進行隨機分配。以美國著名的P2P平台Lending
                                        Club的資料驗證為例(<a
                                            href="/#showClaimMatch">如圖</a>)，當投資標的物的數量愈來愈多時，投資風險及報酬的波動率會逐漸趨於穩定與一致，其投資收益率和壞帳率將接近平台整體的平均表現。
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading16">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>什麼是「特別投資項目」</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse16" class="collapse" aria-labelledby="heading16" data-parent="#accordion">
                                <div class="card-body">
                                    <p>特別債權是針對較大金額債權所設計的，對原本就擁有較多資產的投資人可以方便其進行單一債權的投資，最低投資金額將根據個別項目訂定，債權種類通常是不動產抵押貸款及商業貸款。
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading18">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>除智能媒合外，可以自行選擇投資組合嗎？</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse18" class="collapse" aria-labelledby="heading18" data-parent="#accordion">
                                <div class="card-body">
                                    <p>可以的！除了智能媒合提供的5種產品組合，您也可以根據自身可承受的風險喜好程度，自行調整期數及風險比重。</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading20">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>什麼是「信用評分」</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse20" class="collapse" aria-labelledby="heading20" data-parent="#accordion">
                                <div class="card-body">
                                    <p><a href="/hometest#showCreditScore">信用評分</a>最初是由美國的一家信用評分公司FICO (Fair Issac &amp;
                                        Company) 於1989年推出，信用評分旨在通過考慮個人財務歷史中的各種因素來衡量違約風險。 從FICO的經驗中，披露了信用評等主要參考以下的內容：
                                        1)付款記錄、2)債務負擔、3)信用記錄的時間、4)使用的貸款產品類型（信用貸款，抵押貸款等）、5)近期對信用的查詢次數等。貸款人（如銀行）使用信用評分來評估借款人並降低因壞帳而造成損失的潛在風險。貸款人使用信用評分來確定誰有資格獲得貸款、利率和信用額度。基本上，分數越高代表信用風險越低，相對的借款人的利率也會越低。
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading21">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>什麼是「豬豬信用評分」</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse21" class="collapse" aria-labelledby="heading21" data-parent="#accordion">
                                <div class="card-body">
                                    <p>豬豬在線依據過去5年累積約8萬筆的數據，與專業的第三方建模公司共同開發自身的債權模型，從60多個申請人的特徵因子，經過統計分析，根據5個構面(申請人資料/產品分期資訊/工作財力狀況/相關繳款紀錄/信用查詢資料)，最終選定關聯係數最強的10個特徵因子分佈於5個構面進入信用模型建置，
                                        模型區隔力KS值為37%，與擁有大量數據與信用資料的大型銀行KS值約在40%相比，違約鑑別能力已具備一定的強度可提供參考。</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading23">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>如何查詢投資收益？</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse23" class="collapse" aria-labelledby="heading23" data-parent="#accordion">
                                <div class="card-body">
                                    <p>登入會員後，點擊「會員中心-&gt;我的帳戶-&gt;收益明細」，進行查看投資收益金額與狀態。<br>平台將每日更新投資人的收益資訊，若投資受益的返還日期遇到國定節假日，入帳日期將順延至工作日。
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading25">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>如何可以了解債權物件的詳細資訊？</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse25" class="collapse" aria-labelledby="heading25" data-parent="#accordion">
                                <div class="card-body">
                                    <p>投資人可以至債權專區查閱，每一筆債權物件都會充分揭露借款人的基本資料及信用資料報告提供會員參考，平台上並不會完全揭露借款人真實姓名個資訊息，如需審閱原始案件資料，投資人可與客服人員預約，攜帶您的身分證親臨信任豬股份有限公司，查閱相關債權物件的數位資料檔案。
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading26">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>什麼是「逾期債權買回條件」 </span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse26" class="collapse" aria-labelledby="heading26" data-parent="#accordion">
                                <div class="card-body">
                                    <p>現行逾期債權買回結算日為逾期起始的第40日，買回給付日為逾期起始日的第45天，並根據不同的風險評級分別有不同的債權買回條件：</p>
                                    <p>1. 風險評級A： 剩餘債權本金100%買回，給付原始債權逾期起始日至債權買回結算日的利息，未滿一期以一期計算。</p>
                                    <p>2. 風險評級B： 剩餘債權本金100%買回，給付原始債權逾期起始日後一期的利息。</p>
                                    <p>3. 風險評級C： 剩餘債權本金95%買回，不再計付任何利息。</p>
                                    <p>4. 風險評級D： 剩餘債權本金90%買回，不再計付任何利息。</p>
                                    <p>5. 風險評級E： 剩餘債權本金85%買回，不再計付任何利息。</p>
                                    <p>您可以參考平台中個別債權物件&ldquo;申貸資訊&rdquo;中的公告或參考債權讓受協議書上的逾期債權買回條件内容。</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading29">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>完成繳款後，什麼時候開始起息？</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse29" class="collapse" aria-labelledby="heading29" data-parent="#accordion">
                                <div class="card-body">
                                    <p>完成繳款後，債權起算的時間將於全數認購人繳費完成及完成債權讓售程序後，債權立即起算，並將發送至您的電子郵件信箱中。</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading30">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>如何知道投資債權的配息狀況？</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse30" class="collapse" aria-labelledby="heading30" data-parent="#accordion">
                                <div class="card-body">
                                    <p>登入會員後，點擊「會員中心-&gt;我的帳戶」，<span
                                            style='color: rgb(0, 0, 0); font-family: "Noto Sans TC", 微軟正黑體, 黑體-繁, 新細明體, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;'>中參考標單狀態查閱投資利息與本金返還明細。</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading31">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>債權物件有區分為「本息攤還」及「先息後本」的還款方式，這兩種方式的利息與本金返還如何給付呢？</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse31" class="collapse" aria-labelledby="heading31" data-parent="#accordion">
                                <div class="card-body">
                                    <p>您可選擇任何一個債權物件，點擊「投資試算」並輸入投資金額，即可查看本息攤還或先息後本的每一期別的投資利息及返還本金的金額。</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading32">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>投資報酬的匯款需要手續費嗎？</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse32" class="collapse" aria-labelledby="heading32" data-parent="#accordion">
                                <div class="card-body">
                                    <p>每次返還給您的投資的本金及利息將需扣除15元銀行匯款手續費，如您提供以下銀行帳戶將可免除該手續費：<br>1. 彰化銀行<br>2. 合作金庫<br>3.
                                        中國信託<br>4. 元大銀行</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading33">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>如果已繳款但最後流標，款項會退回嗎？</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse33" class="collapse" aria-labelledby="heading33" data-parent="#accordion">
                                <div class="card-body">
                                    <p>會的！對於您已繳款但最後流標，我們將會退還該款項至您預留的銀行帳號，如您的銀行非平台指定的銀行，將需扣除必要的匯款手續費15元。</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading34">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>如何知道您的投資風險屬性？</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse34" class="collapse" aria-labelledby="heading34" data-parent="#accordion">
                                <div class="card-body">
                                    註冊會員時，平台將建議您填寫投資風險屬性評估表，完成評估後，我們將告訴您的投資風險屬性，並建議您適合的投資組合。
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading35">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>投資智能媒合債權項目的風險如何判斷？</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse35" class="collapse" aria-labelledby="heading35" data-parent="#accordion">
                                <div class="card-body">
                                    <p>完成會員風險評量後，可以在會員資料中的&ldquo;投資習慣設定&rdquo;點選您適合的投資風險屬性類型進行智能媒合：<br>穩重謹慎型：適合風險承受度較低，期望避免投資本金的損失<br>(選擇A及B級風險組合，可於10％到90％的區間內調整個別風險等級的投資比重)<br>積極進取型：願意承受較高的風險，以追求高的投資報酬<br>(選擇C及D及E級風險組合，可於10％到40％的區間內調整個別風險等級的投資比重)<br>穩健平衡型：適合承受少量的風險，以最求合理的投資報酬<br>穩健積極型：適合在穩健中願意承受相當程度的風險，追求較高的投資報酬<br>(A或B擇一及C或D或E擇一的風險組合，可於40％到60％的區間內調整個別風險等級的投資比重)<br>足智多謀型：適合各類投資，自身有充分判斷風險的能力
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading36">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>投資所得需要繳稅嗎？</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse36" class="collapse" aria-labelledby="heading36" data-parent="#accordion">
                                <div class="card-body">
                                    您的收益屬於國內利息收入，依照中華民國稅法需要申報個人綜合所得稅。如果您是投資海外債權，利息所得在100萬以上才需要申報個人所得稅。
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading37">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>平台手續費會開立發票嗎？</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse37" class="collapse" aria-labelledby="heading37" data-parent="#accordion">
                                <div class="card-body">
                                    <p>會的！平台向您收取的手續費都會開立電子發票並發送至您的電子郵箱中。</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading38">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>如果發生債務人逾期繳款及催收進行時，投資本金及利息會受影響嗎？</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse38" class="collapse" aria-labelledby="heading38" data-parent="#accordion">
                                <div class="card-body">
                                    <p>針對債權物件有標示「發生借款人逾期交款時，將由債權讓與人買回」，當發生債權逾期違約的情況時，剩餘的債權將由債權轉讓人一次性買回，並返還給投資人剩餘未返還的投資本金金額及並結算標的債權於買回日期時所相對應的應付未付的利息金額；反之，當發生債權逾期違約的物件，將依照債權讓售協議書的約定，委託「亞洲信用管理股份有限公司」以債權人之身分主張及處理後續債權保全、債權催收回收及後續通知分配等事項，並同意支付債權回收金額的30%為其代理催收服務勞務費。
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="id3" class="to20 tohere">
                        <div class="bgbg">
                            <span id="id3" class="color5  tbg">關於貸款</span>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading39">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>可以在線上媒合貸款嗎？</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse39" class="collapse" aria-labelledby="heading39" data-parent="#accordion">
                                <div class="card-body">
                                    <p>可以的！您需「註冊會員」並線上填寫「貸款申請書」後，專員直接與您聯繫。</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading40">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>提供哪些貸款方案？</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse40" class="collapse" aria-labelledby="heading40" data-parent="#accordion">
                                <div class="card-body">
                                    <p>1、個人信用貸款：以個人消費分期為主的信用貸款，適合上班族、學生及家庭主婦
                                        。<br>2、個人抵押貸款：適合有車有房的一般個人或企業的零活資金運用貸款。<br>3、商業貸款：適合中小企業營運資金週轉的信用或抵押貸款。<br><br>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="id4" class="to20 tohere">
                        <div class="bgbg">
                            <span id="id4" class="color5  tbg">關於資料安全 / 瀏覽器</span>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading41">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>如何保障個人隱私與資料安全？</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse41" class="collapse" aria-labelledby="heading41" data-parent="#accordion">
                                <div class="card-body">
                                    <p>平台為保障您個人隱私與資料安全，遵循「中華民國個人資料保護法及相關法令規定」之精神，制定隱私保護及網站安全政策，說明對您個人資料的取得、運用及保護方式，只就其特定目的，做為承辦所提供服務之用，不會任意對其他第三者揭露或做非法使用；本平台不會將其做為超出蒐集之特定目的以外的用途，亦不會任意對其他第三者揭露。<br>※
                                        您可參考「隱私權政策」</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading42">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>瀏覽器規格限制</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse42" class="collapse" aria-labelledby="heading42" data-parent="#accordion">
                                <div class="card-body">
                                    <p>您可以參考瀏覽器的版本，建議如下：<br><br>Chrome 版本 67.0.3396.62 (正式版本)<br><br>Safari 版本 11.1
                                        (13605.1.33.1.4)<br><br>IE 11.112.17134.0<br><br>Edge
                                        42.17134.1.0<br><br>Firefox 版本 60.0.1</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="id5" class="to20 tohere">
                        <div class="bgbg">
                            <span id="id5" class="color5  tbg">豬豬推手</span>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading43">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>什麼是「豬豬推手」</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse43" class="collapse" aria-labelledby="heading43" data-parent="#accordion">
                                <div class="card-body">
                                    <p>全民皆可成為「豬豬推手」，您只要通過資格即可成為推手，凡經由您推廣的投資者，認購的每一筆金額皆可享有額外獎金，分享越多獎金拿越多唷！</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading44">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>怎麼申請「豬豬推手」</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse44" class="collapse" aria-labelledby="heading44" data-parent="#accordion">
                                <div class="card-body">
                                    <p>「豬豬推手」申請資格如下：<br>Step1、註冊「豬豬在線」會員<br>Step2、點擊「會員中心-&gt;我的帳戶-&gt;豬豬推手」同意成為「豬豬推手」後，您會有一組專屬推薦碼<br>Step3、經由您推廣的投資人於會員註冊時，應引導投資人於『豬豬在線』平台上記載您的專屬『豬豬推手』推薦碼，投資人完成該代碼登錄並完成債權轉讓投資者，始得計入您的推薦績效，並計算『豬豬推手』獎金。<br>※推薦資訊標註於「推薦人明細」中。
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading45">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>推薦獎金如何計算</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse45" class="collapse" aria-labelledby="heading45" data-parent="#accordion">
                                <div class="card-body">
                                    <p>獎金將依各個債權讓售案件公告的「豬豬推手」獎金年化百分比率計算<br>※獎金比例可參考個別債權上架公告。</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading46">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed"
                                        style="white-space: normal;text-align: left;">
                                        <img src="/images/qq.jpg" alt="">
                                        <span>推薦獎金如何結算及返還</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse46" class="collapse" aria-labelledby="heading46" data-parent="#accordion">
                                <div class="card-body">
                                    <p>『豬豬推手』獎金於「每月十日」做結算核對，若確認無誤，於「每月二十日」前匯款至您指定的銀行帳戶（如遇例假日則順延至次一工作日）。<br>※獎金計算標註於「績效明細」中。
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>


</div>



<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
    integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<script src="/aos/aos_wy.js"></script>
<script src="/assets/front/faq-6bda0c06fd4f23bc16247bff726cac41315a780508d75c584ba27967d53bd045.js"></script>
<script src="/menu/jquery.SuperSlide.2.1.1.js"></script>
<script src="/menu/nav.js?v=20181026"></script>

</body>

</html>
@endsection
