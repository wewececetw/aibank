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



<div class="container" style="min-height: 500px">
    <div class="member_title"> <div class="f28m" id="pp_title">豬豬推手</div > <div class="f28m" id='pp_word' style="font-size:21px;margin-left:10px;text-align:center;">推薦碼：{{ $user->recommendation_code }}</div >
         <input id="p_h" value="https://www.pponline.com.tw/users/sign_up?rel={{ $user->recommendation_code }}">
        <div id="share" onclick="copy_ph()">Copy</div>
    </div>

    <hr style="width:100%;margin-top:0px;">

    <ul class="pay_detail menu clearfix">
        <li><a href="/users/pushhand/pay_block" data-target="pay"  ><span>推薦人明細</span></a></li>
        {{-- <li><a href="/users/pushhand/unpay_block" data-target="unpay" class="active"><span>績效明細</span></a></li> --}}
        <li><a href="/users/pushhand/failur_block" data-target="failur"><span>績效總計</span></a></li>
    </ul>

    
    @inject('claimModel','App\Claim')
    @inject('tendersModel','App\Tenders')
    <div class="unpay_block" style="position: relative;">
        <table class="keywords pay_table">
            <thead>

                <tr class="title_tr ttt">
                    <th style="width: 250px;">標單號碼</th>
                    <th style="width: 60px;">標售人</th>
                    <th style="width: 80px;">還款方式</th>
                    <th style="width: 60px;">狀態</th>
                    <th style="width: 80px;">標售金額</th>
                    <th style="width: 80px;">投資餘額</th>
                    <th style="width: 60px;">推手獎金率</th>
                    <th style="width: 40px;">利潤期數</th>
                    <th style="width: 80px;">推手獎金</th>
                    <th style="width: 120px;">應返還日<br>(投資人)</th>
                    <th style="width: 120px;">返還日<br>(投資人)</th>
                    <th style="width: 120px;">預計入帳日<br>(推薦人)</th>
                </tr>
            </thead>

            <tbody>
<?
$cnt = 1;
$now_claim ="";
?>
                @foreach ($resultTwo as $item)
<?
if($now_claim ==$item->claim_certificate_number){
    $cnt++;
}else{
    $cnt = 1;
    $now_claim =$item->claim_certificate_number;
}
?>                
                <tr class="title_tr ttt" role="row">
                    <td>{{ $item->claim_certificate_number }}</td>
                    <td>{{ $resultTwo3[$item->claim_certificate_number]['user_name'] }}</td>
                    <td>{{ $claimModel->getRepaymentMethodAttribute($resultTwo3[$item->claim_certificate_number]['repayment_method']) }}</td>
                    <td>{{ $tendersModel->getTenderDocumentStateAttribute($item->dstate) }}</td>
                    <td>{{ $item->amount }}</td>
                    <td>{{ $item->current_balance }}</td>
                    <td>{{ floatval(($resultTwo3[$item->claim_certificate_number]['commission_interest_rate']) * 100) }}%</td>
                    <td>{{ $cnt }}</td>
                    <td>{{ $item->benefits_amount }}</td>
                    <td>{{ isset($item->r_target_repayment_date)?date("Y-m-d",strtotime($item->r_target_repayment_date)):'' }}</td>
                    <td>{{ isset($item->r_credited_at)?date("Y-m-d",strtotime($item->r_credited_at)):'' }}</td>
                    <td>{{ isset($item->target_repayment_date)?date("Y-m-d",strtotime($item->target_repayment_date )):'' }}</td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>


</div>


</body>
</html>



<script>
 $(document).ready(function(){

    $(".close").click(function(e){
        $(".push_lightbox").fadeOut();
    });

    $(".close_phone").click(function(e){
        $(".push_lightbox").fadeOut();
    });

    //  $('.menu a').click(function(e){

    //     e.preventDefault();
    //     var target = $(this).data('target');

    //     if(!$(this).hasClass('active')){
    //             var now = $('.menu a.active').data('target');
    //             $('.menu a.active').removeClass('active');
    //             $('.'+now+'_block').hide();
    //             $('.'+target+'_block').fadeIn('fast');
    //             $(this).addClass('active');
    //         }
    // });
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
