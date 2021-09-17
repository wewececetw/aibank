@extends('Front_End.layout.header')

@section('content')

<style>
    .light_btn{
        position: relative!important;
        padding: 10px !important;
        width: 140px!important;
        background-color: #00C1DE!important;
        color: white!important;
        display: inline-block;
        margin-right: 15px;
    }
    #p_h{
        font-size:14px;
        width:49%;
        border:none
    }
    #share{
	    display: inline-block;
	    margin:10px auto 0 auto;
    	width:165px;
	    line-height: 27px;
    	height: 27px;
	    color: #fff;
    	font-size: 14px;
	    border: 1px solid #ddd;
    	text-align: center;
	    background-color:#01c1de
    }
    @media (max-width: 768px) {
        #share{ display: block;}
    }
    .ttt th,.ttt td{ text-align:center !important;}
    .tt th,.tt td{ text-align:center !important;}
    @media (max-width: 568px){
        #pp_word{
            width: 100%;
        }
        #pp_title{
            width: 100%;
        }
        .tt td{ text-align:left !important;}
    }
</style>
<div id="main-page">

    <link rel="stylesheet" media="screen" href="/table/css/table.css" />
    <link rel="stylesheet" media="screen" href="/css/list.css" />
    <link rel="stylesheet" media="screen" href="/css/list_modal.css" />
    <link rel="stylesheet" media="screen" href="/css/modal.css" />
    <link rel="stylesheet" media="screen" href="/css/member.css?v=20191016" />
    <link rel="stylesheet" media="screen" href="/css/member2.css?v=20181027" />
    <link rel="stylesheet" media="screen" href="/css/tender.css" />
    <link rel="stylesheet" media="screen" href="/css/sliderbar.css" />
    <link rel="stylesheet" media="screen" href="/css/cumstom_style.css" />
    <link rel="stylesheet" media="screen" href="/assets/front/match-ab00adde9a2208fa12a33b86a261b34d9ea621b0ceed421ed9fd13204e088bb4.css" />
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <div class="push_lightbox" id="first_push_lightbox" style="display:none">
        <div class="contract_info">
            <p>
            <strong>
                歡迎您註冊成為『豬豬在線』的合格會員；請您先詳細閱讀以下約定條款：
            </strong>
            </p>
            <p>
            <strong>
                本約定條款適用於『豬豬在線』平台的合格會員並同時願意擔任『豬豬在線』的委任業務推廣者（統稱：『豬豬推手』）：
            </strong>
            </p>
            <p>
            <strong>
                本約定條款的目的，是為了保護您及『豬豬在線』的權利，如果您點選「我同意」或類似語意的選項，就表示您事先已經知悉、並同意本約定條款的所有約定，您將取的一個專屬的『豬豬推手』代碼。
                為增進『豬豬在線』的會員數及業務量成長，本於平等互惠及誠信原則，針對『豬豬在線』業務之推廣，特約定如下：
            </strong>
            </p>
            <p>
            <strong>第一條	委任內容</strong><br>
            <ul>
                <li>
                    您同意為『豬豬在線』的委任業務推廣者應就該業務積極推廣，並邀請有投資意願的個人或公司(以下簡稱：投資人)於不違反本約定及法令規範下進行『豬豬在線』平台的會員註冊及協助推廣投資；惟最終投資人的相關配合條件，仍以『豬豬在線』平台的相關規定為準。
                </li>
            </ul>
            </p>
            <p>
            <strong>第二條	委任範圍</strong><br/>
            <ul>
                <li>
                    您不得以多層次傳銷方式為之，若有辦理投資說明會之需要，應事先向『豬豬在線』的相關人員完成報備並將說明內容進行備查審核，『豬豬在線』將派員陪同參與。
                </li>
            </ul>
            </p>
            <p>
            <strong>
                第三條	委任授權限制
            </strong><br>
            <ul>
                <li>
                    未經『豬豬在線』的同意，您不得以『豬豬在線』名義對外執行業務，如有違反，『豬豬在線』得終止您的『豬豬推手』資格。
                    您於業務推廣時，僅限於就會員註冊方式及債權轉讓等相關制式性配合模式做洽談及說明，『豬豬在線』對於不同債權轉讓條件各有不同的規範與約定，您不得對投資人有任何協議、承諾或保證。
                </li>
            </ul>
            </p>
            <p>
            <strong>
                第四條	『豬豬推手』獎金
            </strong><br>
            <ul>
                <li>
                1.	經由您推廣的投資人於會員註冊時，應引導投資人於『豬豬在線』平台上記載您的專屬『豬豬推手』代碼，投資人完成該代碼登錄並完成債權轉讓投資者，始得計入您的推薦績效，並計算『豬豬推手』獎金。若於會員註冊完成時投資人仍未將您的個人專屬『豬豬推手』代碼登錄者，除經由『豬豬在線』核准同意外，該註冊會員之業務推廣權利將歸『豬豬在線』平台所有，您同意不得抗辯。
                </li>
                <li>
                2.	您所推薦的任一投資人，自會員註冊日起或最後一次會員帳戶的投資金額為零起計算，超過12個月未有任何投資行為的紀錄者，則該客戶的業務推廣權將回歸『豬豬在線』所有，且自回歸日起，該投資人的後續任何『豬豬推手』獎金，您將不再擁有。
                </li>
                <li>
                3.	經您推薦的投資人，於該投資人的業務推廣權利仍歸屬於您的『豬豬推手』推薦會員名單下，其業務獎金將依各個債權讓售案件公告的『豬豬推手』獎金年化百分比率，月獎金計算公式：∑（各個案件投資人的投資餘額x對應年化百分利率÷12）
                </li>
            </ul>
            </p>
            <p>
            <strong> 第五條	獎金結算及給付 </strong><br/>
            <ul>
                <li>
                    『豬豬在線』將於每月十日就前個月您的『豬豬推手』獎金作結算核對。
                </li>
                <li>
                1. 您為自然人時：『豬豬在線』於每月二十日將您的『豬豬推手』獎金以兼職業務所得(需代扣所得稅與2代健保)方式扣除匯費後匯入您的會員銀行帳戶中，前揭期限如遇例假日則順延至次一營業日。
                </li>
                <li>
                2.	您為法人機構時：『豬豬在線』於每月十五日前，開具三聯式發票請款。『豬豬在線』於每月二十日將您的『豬豬推手』獎金扣除匯費後匯入您的會員銀行帳戶中，前揭期限如遇例假日則順延至次一營業日。
                </li>
            </ul>
            </p>
            <p>
            <strong>第六條	『豬豬在線』業務窗口及協力義務</strong><br>
            <ul>
                <li>
                    『豬豬在線』設有服務窗口，應協助您對會員客戶的諮詢及處理相關業務，另因本業務推廣而衍生之一切服務與爭議，您也願意盡最大善意協助溝通處理之。
                </li>
            </ul>
            </p>
            <p>
            <strong>第七條	提前解除或終止投資案件之佣金返還</strong><br>
            <ul>
                <li>
                    投資人原則上不可提前解除或終止任何一筆債權轉讓完成之投資，但因投資人以強制、訴訟或調解等方式要求提前解除或終止任何一筆債權轉讓投資者，您同意無條件將該筆投資之『豬豬推手』獎金全數返還。
                </li>
            </ul>
            </p>
            <p>
            <strong>第八條	  應返還『豬豬推手』獎金之結算及給付</strong><br>
            <ul>
                <li>
                    針對前條應返還之『豬豬推手』獎金，應於每月十日做結算核對，您同意於每月二十日前匯款至『豬豬在線』的指定銀行帳戶，前揭期限如遇例假日則順延至次一營業日。
                </li>
            </ul>
            </p>
            <p>
            <strong>第九條	投資人終止投資之通知義務</strong><br>
            <ul>
                <li>
                    『豬豬在線』基於遵守法令規範及其本身的風險考量（如：有違反防制洗錢及打擊資恐法令的疑慮），『豬豬在線』有權隨時通知您，終止任一投資人之投資權利並將其會員帳號停權或註銷。若有經由您的擔保下繼續保留該投資人的『豬豬在線』會員資格，如發生該投資人的投資行為有致使『豬豬在線』產生任何損失時，您須附有連帶賠償責任。
                </li>
            </ul>
            </p>
            <p>
            <strong>第十條	資訊揭露</strong><br>
            <ul>
                <li>
                    您於業務推廣時應秉持誠信原則，針對投資人之所有資訊，應對『豬豬在線』完整忠實揭露，若因資訊揭露不實或不完整而致『豬豬在線』遭受損害時，您應負無過失賠償責任。
                </li>
            </ul>
            </p>
            <p>
            <strong>第十一條	保密義務</strong><br>
            <ul>
                <li>
                    您因本約定條款或履行本約而知悉或取得『豬豬在線』及其所屬會員客戶之相關資料，均為『豬豬在線』之營業機密，您應負完全之保密義務。
                </li>
            </ul>
            </p>
            <p>
            <strong>第十二條	情事變更及解除『豬豬推手』資格</strong><br>
            <ul>
                <li>
                    本約定條款有效期間內，因法令、業務型態、社會或經濟環境發生巨大變化等重大事由，或有任何違反本約定條款，本於誠信及守法原則，『豬豬在線』將隨時進行條文修正並公告，或終止本約定條款，或解除您的『豬豬推手』資格。
                </li>
            </ul>
            </p>
            <p>
            <strong>第十三條	合意管轄</strong><br>
            <ul>
                <li>
                    本約定條款未盡之事項悉依中華民國法律規範之，另因本約定條款所生之ㄧ切爭議，同意以臺灣臺北地方法院（包含簡易庭）為第一審管轄法院。
                </li>
            </ul>
            </p>

            <div style="text-align:center;">
                <a class="light_btn" href="#" onclick="create_recommendation_code({{ Auth::user()->user_id }})"><span>同意</span></a>
                <a class="light_btn" href="/front/myaccount"><span>不同意</span></a>
            </div>


        </div>
    </div>


    @if(isset($user->recommendation_code))

        <div class="push_lightbox">
            <div class="contract_info">
                <h2 style="margin-bottom:20px;">我的推薦碼 {{ $user->recommendation_code }}</h2>
                <button class="close" type="button" >關閉視窗</button>
                <button class="close_phone" type="button" >x</button>

                <p>
                <strong>
                    歡迎您註冊成為『豬豬在線』的合格會員；請您先詳細閱讀以下約定條款：
                </strong>
                </p>
                <p>
                <strong>
                    本約定條款適用於『豬豬在線』平台的合格會員並同時願意擔任『豬豬在線』的委任業務推廣者（統稱：『豬豬推手』）：
                </strong>
                </p>
                <p>
                <strong>
                    本約定條款的目的，是為了保護您及『豬豬在線』的權利，如果您點選「我同意」或類似語意的選項，就表示您事先已經知悉、並同意本約定條款的所有約定，您將取的一個專屬的『豬豬推手』代碼。
                    為增進『豬豬在線』的會員數及業務量成長，本於平等互惠及誠信原則，針對『豬豬在線』業務之推廣，特約定如下：
                </strong>
                </p>
                <p>
                <strong>第一條	委任內容</strong><br>
                <ul>
                    <li>
                        您同意為『豬豬在線』的委任業務推廣者應就該業務積極推廣，並邀請有投資意願的個人或公司(以下簡稱：投資人)於不違反本約定及法令規範下進行『豬豬在線』平台的會員註冊及協助推廣投資；惟最終投資人的相關配合條件，仍以『豬豬在線』平台的相關規定為準。
                    </li>
                </ul>
                </p>
                <p>
                <strong>第二條	委任範圍</strong><br/>
                <ul>
                    <li>
                        您不得以多層次傳銷方式為之，若有辦理投資說明會之需要，應事先向『豬豬在線』的相關人員完成報備並將說明內容進行備查審核，『豬豬在線』將派員陪同參與。
                    </li>
                </ul>
                </p>
                <p>
                <strong>
                    第三條	委任授權限制
                </strong><br>
                <ul>
                    <li>
                        未經『豬豬在線』的同意，您不得以『豬豬在線』名義對外執行業務，如有違反，『豬豬在線』得終止您的『豬豬推手』資格。
                        您於業務推廣時，僅限於就會員註冊方式及債權轉讓等相關制式性配合模式做洽談及說明，『豬豬在線』對於不同債權轉讓條件各有不同的規範與約定，您不得對投資人有任何協議、承諾或保證。
                    </li>
                </ul>
                </p>
                <p>
                <strong>
                    第四條	『豬豬推手』獎金
                </strong><br>
                <ul>
                    <li>
                    1.	經由您推廣的投資人於會員註冊時，應引導投資人於『豬豬在線』平台上記載您的專屬『豬豬推手』代碼，投資人完成該代碼登錄並完成債權轉讓投資者，始得計入您的推薦績效，並計算『豬豬推手』獎金。若於會員註冊完成時投資人仍未將您的個人專屬『豬豬推手』代碼登錄者，除經由『豬豬在線』核准同意外，該註冊會員之業務推廣權利將歸『豬豬在線』平台所有，您同意不得抗辯。
                    </li>
                    <li>
                    2.	您所推薦的任一投資人，自會員註冊日起或最後一次會員帳戶的投資金額為零起計算，超過12個月未有任何投資行為的紀錄者，則該客戶的業務推廣權將回歸『豬豬在線』所有，且自回歸日起，該投資人的後續任何『豬豬推手』獎金，您將不再擁有。
                    </li>
                    <li>
                    3.	經您推薦的投資人，於該投資人的業務推廣權利仍歸屬於您的『豬豬推手』推薦會員名單下，其業務獎金將依各個債權讓售案件公告的『豬豬推手』獎金年化百分比率，月獎金計算公式：∑（各個案件投資人的投資餘額x對應年化百分利率÷12）
                    </li>
                </ul>
                </p>
                <p>
                <strong> 第五條	獎金結算及給付 </strong><br/>
                <ul>
                    <li>
                        『豬豬在線』將於每月十日就前個月您的『豬豬推手』獎金作結算核對。
                    </li>
                    <li>
                    1. 您為自然人時：『豬豬在線』於每月二十日將您的『豬豬推手』獎金以兼職業務所得(需代扣所得稅與2代健保)方式扣除匯費後匯入您的會員銀行帳戶中，前揭期限如遇例假日則順延至次一營業日。
                    </li>
                    <li>
                    2.	您為法人機構時：『豬豬在線』於每月十五日前，開具三聯式發票請款。『豬豬在線』於每月二十日將您的『豬豬推手』獎金扣除匯費後匯入您的會員銀行帳戶中，前揭期限如遇例假日則順延至次一營業日。
                    </li>
                </ul>
                </p>
                <p>
                <strong>第六條	『豬豬在線』業務窗口及協力義務</strong><br>
                <ul>
                    <li>
                        『豬豬在線』設有服務窗口，應協助您對會員客戶的諮詢及處理相關業務，另因本業務推廣而衍生之一切服務與爭議，您也願意盡最大善意協助溝通處理之。
                    </li>
                </ul>
                </p>
                <p>
                <strong>第七條	提前解除或終止投資案件之佣金返還</strong><br>
                <ul>
                    <li>
                        投資人原則上不可提前解除或終止任何一筆債權轉讓完成之投資，但因投資人以強制、訴訟或調解等方式要求提前解除或終止任何一筆債權轉讓投資者，您同意無條件將該筆投資之『豬豬推手』獎金全數返還。
                    </li>
                </ul>
                </p>
                <p>
                <strong>第八條	  應返還『豬豬推手』獎金之結算及給付</strong><br>
                <ul>
                    <li>
                        針對前條應返還之『豬豬推手』獎金，應於每月十日做結算核對，您同意於每月二十日前匯款至『豬豬在線』的指定銀行帳戶，前揭期限如遇例假日則順延至次一營業日。
                    </li>
                </ul>
                </p>
                <p>
                <strong>第九條	投資人終止投資之通知義務</strong><br>
                <ul>
                    <li>
                        『豬豬在線』基於遵守法令規範及其本身的風險考量（如：有違反防制洗錢及打擊資恐法令的疑慮），『豬豬在線』有權隨時通知您，終止任一投資人之投資權利並將其會員帳號停權或註銷。若有經由您的擔保下繼續保留該投資人的『豬豬在線』會員資格，如發生該投資人的投資行為有致使『豬豬在線』產生任何損失時，您須附有連帶賠償責任。
                    </li>
                </ul>
                </p>
                <p>
                <strong>第十條	資訊揭露</strong><br>
                <ul>
                    <li>
                        您於業務推廣時應秉持誠信原則，針對投資人之所有資訊，應對『豬豬在線』完整忠實揭露，若因資訊揭露不實或不完整而致『豬豬在線』遭受損害時，您應負無過失賠償責任。
                    </li>
                </ul>
                </p>
                <p>
                <strong>第十一條	保密義務</strong><br>
                <ul>
                    <li>
                        您因本約定條款或履行本約而知悉或取得『豬豬在線』及其所屬會員客戶之相關資料，均為『豬豬在線』之營業機密，您應負完全之保密義務。
                    </li>
                </ul>
                </p>
                <p>
                <strong>第十二條	情事變更及解除『豬豬推手』資格</strong><br>
                <ul>
                    <li>
                        本約定條款有效期間內，因法令、業務型態、社會或經濟環境發生巨大變化等重大事由，或有任何違反本約定條款，本於誠信及守法原則，『豬豬在線』將隨時進行條文修正並公告，或終止本約定條款，或解除您的『豬豬推手』資格。
                    </li>
                </ul>
                </p>
                <p>
                <strong>第十三條	合意管轄</strong><br>
                <ul>
                    <li>
                        本約定條款未盡之事項悉依中華民國法律規範之，另因本約定條款所生之ㄧ切爭議，同意以臺灣臺北地方法院（包含簡易庭）為第一審管轄法院。
                    </li>
                </ul>
                </p>

            </div>
        </div>

    @else
        <script>

            if(window.confirm('目前尚無推薦碼,請問是否申請成為推手？')){

                var bank_account = '{{$bank_count}}';
                if(bank_account == 0){

                    alert('尚無銀行帳戶，請新增銀行帳戶！')
                    location.href = '{{ url('/users/tab_two')}}';

                }else{

                    $('#first_push_lightbox').css('display','block');
                }

            }else{
                location.href = '{{ url('/front/myaccount')}}';
            }
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






</body>
</html>



<script>
 $(document).ready(function(){

    $(".close").click(function(e){
        window.location.href="/users/pushhand/pay_block";
    });
    $(".close_phone").click(function(e){
        window.location.href="/users/pushhand/pay_block";
    });
})


function create_recommendation_code(target){
    $.ajax({
        type: "POST",
        url: "/user/create_recommendation_code",
        dataType: "json",
        data: {
            user_id: target,
        },
        success: function(data) {
            if(data.success){
                alert('推薦碼新增成功!');
                location.reload();

            }else if(data.no_member_num){
                alert('請填寫資料！');
                location.href = '{{ url('/users')}}';
            }
        }
    });
}

</script>
<script>
function copy_ph(){
    document.getElementById("p_h").select();
    document.execCommand("Copy"); 
    alert("已複製");
}
</script>
@endsection
