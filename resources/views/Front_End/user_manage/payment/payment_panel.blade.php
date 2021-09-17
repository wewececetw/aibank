@extends('Front_End.layout.header')

@section('content')

<div id="main-page">
    <link rel="stylesheet" media="screen" href="/table/css/table.css" />
    <link rel="stylesheet" media="screen" href="/css/list.css" />
    <link rel="stylesheet" media="screen" href="/css/list_modal.css" />
    <link rel="stylesheet" media="screen" href="/css/modal.css" />
    <link rel="stylesheet" media="screen" href="/css/member.css?v=20191016" />
    <link rel="stylesheet" media="screen" href="/css/member2.css?v=20181027" />
    <link rel="stylesheet" media="screen" href="/css/tender.css" />
    <link rel="stylesheet" media="screen" href="/css/sliderbar.css" />
    <link rel="stylesheet" media="screen" href="/css/claim.css" />
    <link rel="stylesheet" media="screen" href="/assets/front/payment.css" />
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


<div class="container" style="padding-top: 30px;
  min-height: 600px;">
  <div class="row">
  </div>
  <div style="margin:0px" class="row">
    <div class="pr">
      <div class="col-55 f14 fbold" style="padding-top: 15px;">
        投標總金額<span class="ia tender_documents_amount"> {{ number_format($totalAmount) }}元 </span>
        投標總筆數<span class="ia tender_documents_rowcount"> {{ number_format($tenders_count) }}</span>
      </div>
      <div class="col-55 f14 fbold" style="padding-top: 15px;">
        <p class="">
          <i class="fa fa-info-circle" aria-hidden="true"></i>
          您的專屬代收虛擬帳號：彰化銀行（009）{{ $user['virtual_account'] }}
          <br>
          分行(代碼) : 中山北路分行(5081)
          <br>
          繳款戶名 : 信任豬股份有限公司
      </div>
    </div>

    <div class="table-title">
      帳單明細
    </div>
    <table id="keywords" cellspacing="0" cellpadding="0" class="rwd-table tablesorter payment-table">
      <thead>
        <tr class="title_tr">
          <th><span>帳單生成日(結標日)</span></th>
          {{-- <th><span>總投標金額</span></th> --}}
          <th><span>實際成交金額</span></th>
          <th><span>備註</span></th>
          <th><span>下載</span></th>
        </tr>
      </thead>

      <tbody>
<?
  $n_id ="";
  $pay_day="";
  $d1=0;
  $d2=0;
  $cnt_arr=0;

foreach($orders as $order){
  if($pay_day == date('Y-m-d',strtotime($order->cc)) ){
    $d1+=$order->amount;
    $d2++;
  }else{
    if($cnt_arr >0 ){
  ?>
              <tr>
                  <td data-th="帳單生成日(結標日)">{{ $pay_day }}</td>
                  <td data-th="實際成交金額">{{ $d1 }}</td>
                  <td data-th="備註">標單數量:{{ $d2 }}</td>
                  <td data-th="下載">
                      <a href="PaymentNoticePdf/{{ $pay_day }}">
                          <i class="fa fa-fw fa-eye" aria-hidden="true"></i>
                      </a>
                  </td>
              </tr>
  <?
    }
    $cnt_arr++;
    $d1=$order->amount;
    $d2=1;
    $pay_day = date('Y-m-d',strtotime($order->cc));
    $n_id = $order->order_id;
  }

}

if($pay_day <> "" ){
?>
  <tr>
      <td data-th="帳單生成日(結標日)">{{ $pay_day }}</td>
      <td data-th="實際成交金額">{{ $d1 }}</td>
      <td data-th="備註">標單數量:{{ $d2 }}</td>
      <td data-th="下載">
          <a href="PaymentNoticePdf/{{ $pay_day }}">
              <i class="fa fa-fw fa-eye" aria-hidden="true"></i>
          </a>
      </td>
  </tr>
<?
}

?>
      </tbody>
    </table>

  </div>
  <div class="member_footer">
    <!-- <a href="claim3.html"><input type="submit" name="commit" value="繼續投資" class="btn form_bt pull-right footer_btn2" data-disable-with="繼續投資"></a>   -->
  </div>
</div>


</body>
</html>
@endsection
