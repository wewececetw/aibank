<!DOCTYPE html>
<html lang="zh-TW">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>豬豬在線管理後台</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap theme -->
    <link href="/css/bootstrap-theme.css" rel="stylesheet">
    <!--external css-->
    <!-- font icon -->
    <link href="/css/cumstom_style.css" rel="stylesheet" />
    <link href="/css/elegant-icons-style.css" rel="stylesheet" />
    <link href="/css/font-awesome.min.css" rel="stylesheet" />
    <link href="/css/daterangepicker.css" rel="stylesheet" />
    <link href="/css/bootstrap-datepicker.css" rel="stylesheet" />
    <!-- Custom styles -->
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/main_style.css" rel="stylesheet">
    <link href="/css/style-responsive.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/fontawesome5/all.css">
    <link rel="stylesheet" media="all" href="/assets/admin-a2d9679cd876b77306b69505b283d25f085563d38451d0785e8d72886a9fc0e1.css" />

    <script src="/js/jquery-3.3.1.min.js"></script>
    <script src="/js/jquery.js"></script>
    <script src="/js/bootstrap.min.js"></script>


    <script type="text/javascript" src="/js/jquery-validation/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/js/jquery-validation/localization/messages_zh_TW.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.10.3/sweetalert2.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.10.3/sweetalert2.js" type="text/javascript"></script>
    <script src="/js/jquery.loading.min.js"></script

    <!-- custom form validation script for this page-->
    <!--custome script for all page-->
    <script src="/js/scripts.js"></script>
    <script src="/js/jscolor.js"></script>
    <style>
      @media (max-width: 480px){
        .notification-row{
          display: block !important;
        }
      }
      </style>
    <script>
    $(document).ready(function(){
      $.ajaxSetup({
        headers:{
          'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
      });


    // $(".btn :not(form > .btn)").on('click',function(){
    //     console.log('aaa');

    //         let that = $(this);
    //         that.attr('disabled',true);
    //         setTimeout(() => {
    //             that.attr('disabled',false);
    //         },1000)
    //     })
    });

    </script>
    <style>
      .LogRecord{
        text-align: right;
        color: #bdbdbd;
      }
      .dialog-button{
          margin: 0 0 5px 0;
          width: 25px;
          height: 22px;
          background: red;
          position: relative;
          border-radius: 5px;
          color: white;
          text-align: center;
          font-size: 17px;
          font-weight: bolder;
          line-height: 22px;
          display: inline-block;
          vertical-align: middle;
          cursor:pointer;
      }
      .dialog-animate{
          animation: bring_rw 2s infinite;
      }
      .dialog-button::after{
          border-color: red transparent transparent red;
          border-style: solid solid solid solid;
          border-width: 3px 5px 2px 4px;
          bottom: -5px;
          content: "";
          height: 0px;
          left: 7px;
          position: absolute;
          width: 0px; 
      }
      .dialog-animate::after{
          animation: bring_rw_after 2s infinite;
      }
      .black_cloth{
          position: fixed;
          width: 100vw;
          height: 100vh;
          background-color: rgba(0,0,0,.5);
          top: 0;
          left: 0;
          display:none;
          z-index:1;
      }
      .cloth_frame{
          width: 30vw;
          position: absolute;
          height: 50vh;
          background-color: white;
          top: 50%;
          left: 50%;
          margin: -25vh 0 0 -15vw;
          border-radius: 10px;
          padding: 30px 20px;
          color: red;
      }
      .cloth_btn{
          width: 30px;
          height: 30px;
          position: absolute;
          right: 0;
          top: 0;
          line-height: 30px;
          text-align: center;
          color:black;
          transition: color .5s linear;
          cursor:pointer;
      }
      .cloth_btn:hover{
        color:red;
      }
      @keyframes bring_rw {
        0% {background:red;}
        12.5% {background:white;}
        25% {background:red;}
        37.5% {background:white;}
        50% {background:red;}
        62.5% {background:white;}
        75% {background:red;}
        87.5% {background:white;}
        100% {background:red;}
      }
      @keyframes bring_rw_after {
        0% {border-color:red transparent transparent red;}
        12.5% {border-color:white transparent transparent white;}
        25% {border-color:red transparent transparent red;}
        37.5% {border-color:white transparent transparent white;}
        50% {border-color:red transparent transparent red;}
        62.5% {border-color:white transparent transparent white;}
        75% {border-color:red transparent transparent red;}
        87.5% {border-color:white transparent transparent white;}
        100% {border-color:red transparent transparent red;}
      }
    </style>
</head>

{{ csrf_field() }}

<?php
    
    if(empty($_SERVER["HTTPS"])) {
        $https_login = "https://" . $_SERVER["SERVER_NAME"] ;
        header("Location: $https_login");
        exit();
    }    
    $sql = "SELECT ll.login_time ,ll.login_ip
            from login_log ll,users u
            where ll.user_email = u.email
              and ll.user_email = ?
              and ll.login_type = 2
              and ll.login_time > u.log_readtime";  
    $LoginLog = DB::select($sql,[Auth::user()->email]);
?>    
<body>
  <!-- container section start -->
  <section id="container" class="">
    <!--header start-->
    <header class="header dark-bg">
      <div class="toggle-nav">
        <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"><i class="icon_menu"></i></div>
      </div>

      <!--logo start-->
      <a href="/" class="logo">豬豬在線 <span class="lite">管理者後台</span></a>
      <!--logo end-->

      {{-- <div class="nav search-row" id="top_menu">
      </div> --}}

      <div class="top-nav notification-row">
        <!-- notificatoin dropdown start-->
        <ul class="nav pull-right top-menu">

          <!-- user login dropdown start-->
          <!-- login information -->
          <li class="LogRecord">
              上次登入：<?=(!empty(Auth::user()->last_sign_in_at) ? Auth::user()->last_sign_in_at : "")?><br>
              IP：<?=(!empty(Auth::User()->current_sign_in_ip) ? Auth::User()->current_sign_in_ip : "")?>
          </li>
          <li style="padding:8px">
              <div class="dialog-button <?=(!empty($LoginLog)?"dialog-animate":"")?>"></div>
          </li>
          <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
              <span class="username"><?=( isset( Auth::user()->user_name ) )? Auth::user()->user_name :'';?></span>
              <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
              <div class="log-arrow-up"></div>
              <li>
                <a  class="btn btn-outline-success my-2 my-sm-0" href="/">
                  豬豬首頁
                </a>
                {{-- <a  class="btn btn-outline-success my-2 my-sm-0" href="/front/myaccount">
                  使用者後台
                </a> --}}
                <a class="btn btn-outline-success my-2 my-sm-0" href="{{ url('/logout') }}" onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                  登出
                </a>


                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
                </form>
              </li>

            </ul>
          </li>
          <!-- user login dropdown end -->
        </ul>
        <!-- notificatoin dropdown end-->
      </div>
    </header>
    <!--header end-->
    <div class="black_cloth" >
        <div class="cloth_frame">
            <p style="border-bottom: 1px solid red;">登錄錯誤紀錄：</p>
              @if(!empty($LoginLog))
                  @foreach($LoginLog as $log)
                      <p class="LogLine">{{$log->login_time}} 登錄失敗，IP:{{$log->login_ip}}</p>
                  @endforeach
              @else
                <p>目前無紀錄</p>
              @endif
            <div class="cloth_btn">
                <i class="fas fa-times"></i>
            </div>
        </div>
    </div>
    <script>
      $(".dialog-button").on("click",function(){
          $.ajax({
              url:'/log/UpdUserRead',
              type:'post',
              // dataType:'json',
              data:{"_token":$("meta[name='csrf-token']").attr("content")},
              success:function(response){
                  if(response.result){
                      if($(".dialog-button").hasClass("dialog-animate"))
                          $(".dialog-button").removeClass("dialog-animate");
                      $(".black_cloth").fadeIn("slow");
                  }else
                      console.log(response.message);
              },
              error:function(){
                console.log("系統錯誤，請聯絡IT");
              }
          });
      });
      $(".black_cloth .cloth_btn").on("click",function(){
          $(".black_cloth").fadeOut("slow");
      });
    </script>
    <!--sidebar start-->
    <aside>
      <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu">
<?

  $admin_list = DB::select("select a_l_l.* from admin_lv_log a_l_l , admin_lv_list a_l_li where a_l_li.a_l_l_seq = a_l_l.a_l_l_seq and user_id='".Auth::user()->user_id."' order by a_l_li.a_l_l_sort");
  foreach( $admin_list as $a){
    if($a -> a_l_l_seq == 1){
?>
          <li >
            <a href="/admin/loans">
                  <i class="icon_menu-square_alt2" ></i>
                  <span>貸款專區</span>
              </a>
          </li>
<?
    }
    if($a -> a_l_l_seq == 2){
?>
          <li >
            <a href="{{ url('/admin/claims') }}">
                  <i class="icon_menu-square_alt2" ></i>
                  <span>管理債權(全)</span>
              </a>
          </li>
<?
    }
    if($a -> a_l_l_seq == 15){
?>
          <li >
            <a href="{{ url('/admin/claims') }}">
                  <i class="icon_menu-square_alt2" ></i>
                  <span>管理債權</span>
              </a>
          </li>
          
          
<?
    }
    if($a -> a_l_l_seq == 3 ){
?>
                <li>
                  <a class="" href="/admin/tender_documents">
                      <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                      <span>標單專區(全)</span>
                  </a>
                </li>
<?
    }
    if($a -> a_l_l_seq == 4 ){
?>
          <li>
            <a class="" href="/admin/tender_documents">
                <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                <span>標單專區</span>
            </a>
          </li>
<?
    }
    if($a -> a_l_l_seq == 5){
?>
                <li class="sub-menu">
                  <a class="" href="/admin/users">
                      <i class="fa fa-user"></i>
                      <span>管理會員</span>
                  </a>
                </li>
<?
    }
    if($a -> a_l_l_seq == 6){
?>
                <li class="sub-menu">
                  <a class="" href="/admin/staffs">
                      <i class="fa fa-user"></i>
                      <span>管理員工</span>
                  </a>
                </li>
<?
    }
    if($a -> a_l_l_seq == 7){
?>
          <li class="sub-menu">
            <a class="" href="javascript:;">
                <i class="fa fa-envelope"></i>
                <span>站內信</span>
                <span class="menu-arrow arrow_carrot-right"></span>
            </a>
              <ul class="sub">
                <li><a class="" href="/admin/internal_letters">站內信</a></li>
                <li><a class="" href="/admin/outside_letters">站外信</a></li>
              </ul>
          </li>
<?
    }
    if($a -> a_l_l_seq == 8){
?>
          <li class="sub-menu">
            <a class="" href="/admin/reports">
                <i class="icon_house_alt"></i>
                <span>系統現況</span>
            </a>
          </li>
<?
    }
    if($a -> a_l_l_seq == 9){
?>
          <li>
            <a class="" href="/admin/roi_settings">
                <i class="fa fa-link"></i>
                <span>智能媒合設定</span>
            </a>
          </li>
<?
    }
    if($a -> a_l_l_seq == 10){
?>
                <li>
                  <a class="" href="/admin/buying_back">
                      <i class="fa fa-buysellads"></i>
                      <span>買回專區</span>
                  </a>
                </li>
<?
    }
    if($a -> a_l_l_seq == 11){
?>
                <li class="sub-menu" >
                  <a class="" href="javascript:;">
                      <i class="fa fa-buysellads"></i>
                      <span>一鍵買回</span>
                      <span class="menu-arrow arrow_carrot-right"></span>
                  </a>
                  <ul class="sub">
                    <li><a class="" href="/admin/buying_back_o_c">一鍵買回</a></li>
                    <li><a class="" href="/admin/buying_back_c_p">取消一鍵買回</a></li>
                  </ul>
                </li>
<?
    }
    if($a -> a_l_l_seq == 12){
?>
          <li>
            <a class="" href="/admin/domestic_buyback">
                <i class="fa fa-money"></i>
                <span>遲繳專區</span>
            </a>
          </li>
<?
    }
    if($a -> a_l_l_seq == 13){
?>
          <li>
            <a class="" href="/admin/weekly_audited">
                <i class="fa fa-telegram"></i>
                <span>週週投專區</span>
            </a>
          </li>
<?
    }
    if($a -> a_l_l_seq == 14){
?>
          <li class="sub-menu">
            <a href="javascript:;" class="">
                          <i class="fa fa-user"></i>
                          <span>前端管理</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
            <ul class="sub">
              <li><a class="" href="/web_contents/web_category">編輯前台資料</a></li>
              <li><a class="" href="/match_performances/new">媒合表現數據設定</a></li>
            </ul>
          </li>
<? }?>
<? }?>
        </ul>
        <!-- sidebar menu end-->
      </div>
    </aside>


@yield('content')




