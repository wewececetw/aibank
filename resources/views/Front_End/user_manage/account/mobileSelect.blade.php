<style>
    @media screen and (max-width: 1024px){
        .menu_link {
            display: none;
        }
        .se {
            display: block;
        }
        .title-se3{
            margin-left: 30px
        }
    }

</style>

<div class="se se3 title-se3">
    <span class="f28m">會員專區</span>
</div>


<div class="se se3" style="width: 90%;margin: 0 auto;">
    <select id="menu" class="dropdown form-control">
        <option value="/front/myaccount"> 我的帳戶</option>
        <option value="/users"> 個人真實資訊 </option>
        <option value="/users/tab_two"> 銀行帳號 </option>
        <!-- <option value="/users/tab_three">會員風險評量 </option> -->
        <option value="/users/tab_four"> 投資習慣設定 </option>
        <option value="/users/tab_five"> 修改密碼 </option>
        <option value="/front/payment"> 繳款 </option>
        {{-- <option value="/users/favorite">我的收藏 </option> --}}
        <option value="/users/pushhand"> 豬豬推手 </option>
        <option value="/users/weekly_claim_category"> 系統自動投 </option>
    </select>
</div>


<script>
    window.onload = function () {
        var url = window.location.pathname
        $("#menu").val(url);
        switch (url) {
            case "/users":
                $("#users").addClass("menu_active2")
                break;
            case "/front/myaccount":
                $("#myaccount").addClass("menu_active2")
                break;
            case "/users/tab_two":
                $("#tab-two").addClass("menu_active2")
                break;
            case "/users/tab_three":
                $("#tab-three").addClass("menu_active2")
                break;
            case "/users/tab_four":
                $("#tab-four").addClass("menu_active2")
                break;
            case "/users/tab_five":
                $("#tab-five").addClass("menu_active2")
                break;
            case "/front/payment":
                $("#payment").addClass("menu_active2")
                break;
            case "/users/favorite":
                $("#favorite").addClass("menu_active2")
                break;
            case "/users/recommendation":
                $("#recommend").addClass("menu_active2")
                break;
            case "/users/pushhand/pay_block":
                $("#pushhand").addClass("menu_active2")
                break;
            case "/users/pushhand/unpay_block":
                $("#pushhand").addClass("menu_active2")
                break;
            case "/users/pushhand/failur_block":
                $("#pushhand").addClass("menu_active2")
                break;
            case "/users/weekly_claim_category":
                $("#weekly_claim_category").addClass("menu_active2")
                break;
            default:
        }
    }
    $(function(){
      // bind change event to select
      $('#menu').on('change', function () {
          var url = $(this).val(); // get selected value
          if (url) { // require a URL
              window.location = url; // redirect
          }
          return false;
      });
    });

</script>



<div class="menu_link">
    <div class="container">
        <div class="row" style="margin-left:150px">
            <div class="se2">
                <div id="myaccount" class="user_header_item f14 center_c menu_list">
                    <a href="/front/myaccount">我的帳戶</a>
                </div>
                <div id="users" class="user_header_item f14  center_c menu_list">
                    <a href="/users"> 個人真實資訊 </a>
                </div>
                <div id="tab-two" class="user_header_item f14  center_c menu_list ">
                    <a href="/users/tab_two"> 銀行帳號 </a>
                </div>
                <!-- <div id="tab-three" class="user_header_item f14  center_c menu_list">
                    <a href="/users/tab_three">會員風險評量 </a>
                    </div> -->
                <div id="tab-four" class="user_header_item f14  center_c menu_list">
                    <a href="/users/tab_four"> 投資習慣設定 </a>
                </div>
                <div id="tab-five" class="user_header_item f14  center_c menu_list">
                    <a href="/users/tab_five"> 修改密碼 </a>
                </div>
                <div id="payment" class="user_header_item f14  center_c menu_list">
                    <a href="/front/payment"> 繳款 </a>
                </div>
                {{-- <div id="favorite" class="user_header_item f14  center_c menu_list">
                    <a href="/users/favorite"> 我的收藏 </a>
                </div> --}}
                <div id="pushhand" class="user_header_item f14  center_c menu_list">
                    <a href="/users/pushhand"> 豬豬推手 </a>
                </div>
                <div id="weekly_claim_category" class="user_header_item f14  center_c menu_list">
                    <a href="/users/weekly_claim_category"> 系統自動投 </a>
                </div>
            </div>
        </div>
    </div>
</div>
