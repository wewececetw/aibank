@extends('Front_End.layout.header')
<?php
session_start();
$c_t = 0;
$link = mysqli_connect("localhost","kqzwlrrm_pp_user",'jCgz91Ib8}uR',"kqzwlrrm_ppo_nline");   
mysqli_query($link,"set names utf8mb4");

if(!empty($_GET["rel"])){
    if(empty($_SESSION["r_code"])){
        $sql = "select * from users where recommendation_code = '".$_GET["rel"]."'";
        $ro = mysqli_query($link,$sql);
        $row = mysqli_fetch_assoc($ro);
        $all = mysqli_num_rows($ro);
        if($all==1 ){
            $_SESSION["r_code"]=$row["recommendation_code"];
            $new_user=$row["recommendation_code"];            
        }
    }else{
        $sql = "select * from users where recommendation_code = '".$_SESSION["r_code"]."'";
        $ro = mysqli_query($link,$sql);
        $row = mysqli_fetch_assoc($ro);
        $new_user=$row["recommendation_code"];    
    }
}
if(!empty($_SESSION["r_code"])){
        $sql = "select * from users where recommendation_code = '".$_SESSION["r_code"]."'";
        $ro = mysqli_query($link,$sql);
        $row = mysqli_fetch_assoc($ro);
        $new_user=$row["recommendation_code"];
}

?>


@section('content')

<link rel="stylesheet" media="screen" href="/css/sign.css" />

<style>
    body {
        /* background-image: url(../images/sign.jpg); */
        background-image: url(../images/20210621-18.png);
        background-size: auto 100%;
        background-repeat: no-repeat; 
        background-position: center;
    }

    #submit {
        border-radius: 0;
        width: 100%;
        background-color: #00a5e4;
        font-size: 13px;
        border-color: #00C1DE;
        color: #fff;
    }
    #password_set{
        width: 95%;
        display: unset;
    }

    .hide {
        display: none;
    }
    .top_line{
            height: auto;
    }
    @media screen and (max-width: 1024px) {
        body {
            background-position: 100%;
        }
    }
    @media screen and (max-width: 768px) {
        body {
            background-position: 85%;
        }
    }
    @media screen and (max-width: 620px) {
        #password_set{
            width: 94%;
        }
    }
    @media screen and (max-width: 540px) {
        body {
            background-position: 75%;
        }
    }
    @media screen and (max-width: 476px) {
        #password_set{
            width: 93%;
        }
    }
    @media screen and (max-width: 430px) {
        #password_set{
            width: 92%;
        }
    }
    @media screen and (max-width: 410px) {
        body {
            background-position: 70%;
        }
    }
    @media screen and (max-width: 396px) {
        #password_set{
            width: 91%;
        }
    }
    @media screen and (max-width: 369px) {
        #password_set{
            width: 90%;
        }
    }
    @media screen and (max-width: 348px) {
        #password_set{
            width: 89%;
        }
    }
    @media screen and (max-width: 330px) {
        #password_set{
            width: 88%;
        }
    }
    @media screen and (max-width: 316px) {
        #password_set{
            width: 87%;
        }
    }
    @media screen and (max-width: 303px) {
        #password_set{
            width: 86%;
        }
    }
    @media screen and (max-width: 293px) {
        #password_set{
            width: 84%;
        }
    }
    
    
</style>

<div class="container-fluid bgsign">
    <div class="container">
        <div class="sign_form  ">
            <div class="form_top">

                <div class="sign_top">
                    <a href="/users/sign_in">
                        <div class="sign1">會員登入</div>
                    </a>
                    <a href="/users/sign_up">
                        <div class="sign2 sign_active">註冊會員</div>
                    </a>
                    <a href="/users/password_new">
                        <div class="sign3 ">忘記密碼</div>
                    </a>
                </div>

                <form id="user_registration_form" novalidate="novalidate" class="simple_form new_user p-4"
                    accept-charset="UTF-8" method="post">
                    @csrf
                    <div class="px-4 py-3 px-44">
                        <div class="form-group f14">
                            <label for="exampleDropdownFormEmail1">電子信箱</label><p style="color: red;display: inline;">(貸款會員無須註冊，由此<a href="https://loan.pponline.com.tw/">連結</a>申請)</p>
                            <input class="form-control reg_email" value="" required="required" autofocus="autofocus"
                                style="border-radius: 0;font-size: 14px;padding-top: 8px;padding-bottom: 8px;"
                                type="email" name="email" id="email">

                        </div>

                        <div class="form-group f14">
                            <label for="exampleDropdownFormPassword1">真實姓名</label> <p style="color: red;display: inline;">(限中文)</p>
                            <input class="form-control" required="required"
                                style="border-radius: 0;font-size: 14px;padding-top: 8px;padding-bottom: 8px;"
                                type="text" name="user_name" id="name"/>

                        </div>

                        <div class="form-group f14">
                            <label for="exampleDropdownFormPassword1">手機號碼</label>
                            <input class="form-control" required="required"
                                style="border-radius: 0;font-size: 14px;padding-top: 8px;padding-bottom: 8px;"
                                type="text" name="phone" id="phone_set"  pattern="09\d{2}\-?\d{3}\-?\d{3}"/>

                        </div>

                        <div class="form-group f14">
                            <label for="exampleDropdownFormPassword1">設定密碼</label>
                            <input class="form-control reg_password" id="password_set" required="required"
                                pattern="[A-Za-z0-9]+" minlength="8" maxlength="20" type="password"
                                style="border-radius: 0;font-size: 14px;padding-top: 8px;padding-bottom: 8px;"
                                name="encrypted_password" id="user_password">
                                <i  class="fa fa-eye" aria-hidden="true" onclick='show_pw2()'></i>
                                

                        </div>

                        <div class="for  for_sign f14">
                            <label class="form-check-label" for="dropdownCheck">
                                至少8字，至多20字, 內含英文（大小寫至少各一）及數字, 不能輸入任何特殊字元, 例如 : @, $, &amp; ... !
                            </label>
                        </div>

                        <div class="form-group f14">
                            <label for="exampleDropdownFormPassword1">確認密碼</label>&nbsp;&nbsp;&nbsp;<span
                                id='message'></span>
                            <input class="form-control reg_password_confirmation" id="confirm_password_set"
                                required="required" type="password"
                                style="border-radius: 0;font-size: 14px;padding-top: 8px;padding-bottom: 8px;"
                                name="encrypted_password" id="user_password_confirmation">
                        </div>

<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($new_user)){
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>
                        <input type="hidden" name="come_from_info" id="user_come_from_info" value="4">
                        <input type="hidden" name="come_from_info_text" id="user_come_from_info_text" value="<?=$new_user?>">
<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>
                        <div class="form-group f14 come_from_info_text">
                            <label for="recommendation_code">得知管道</label>
                            <select class="form-control" name="come_from_info" id="user_come_from_info">
                                <option value="0">搜尋網站廣告(Google/Yahoo)</option>
                                <option value="1">FB粉絲團</option>
                                <option value="2">親友推薦</option>
                                <option value="3">電話行銷</option>
                                <option value="4">業務推薦</option>
                                <option value="5">其他</option>
                            </select>
                        </div>
                        <div class="form-group f14 hide" id="come_from_info_block">
                            <label for="recommendation_code">推薦代碼  </label><span id="formatS" class="hide" style="color:red">格式不符</span>
                            <input class="form-control" name="come_from_info_text" id="user_come_from_info_text" placeholder="請填寫服務人員代碼">
                        </div>
<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>
                        <div style="padding-top: 15px; padding-bottom: 15px;">
                            <button type="button" id="submit"
                                style="border-radius: 0;width: 100%; background-color: #00a5e4; font-size: 13px;border-color: #00C1DE;padding:6px; ">申請註冊</button>
                        </div>

                    </div>
                </form>


            </div>
        </div>
    </div>
    <div class="member_footer">
    </div>
</div>
<script>
    $("#user_come_from_info").change(function () {
        let $this = $(this);
        let thisVal = $this.val();
        if (thisVal !== '0' && thisVal !== '1' && thisVal !== '5') {
            $("#come_from_info_block").toggleClass('hide', false);
            if(thisVal == '2'){
                $("#user_come_from_info_text").attr("placeholder", "請填寫親友推薦代碼");
            }else{
                $("#user_come_from_info_text").attr("placeholder", "請填寫服務人員代碼");
            }
        } else {
            $("#come_from_info_block").toggleClass('hide', true);
        }
    })
    //PP代號監聽
    $("#user_come_from_info_text").on('keyup', function () {
        let $this = $(this);
        let val = $this.val();
        let trig = checkPP_format(val);

        if(trig === false){
            $("#formatS").toggleClass('hide',false);
            $("#submit").attr('disabled',true);
        }else{
            $("#formatS").toggleClass('hide',true);
            $("#submit").attr('disabled',false);
        }
    })

    //檢查PP代碼格式
    function checkPP_format(val){
        var NumReg = /^[0-9]$/;
        let trig = true;
        let x = 0,
            xlen = val.length;
        for (x; x < xlen; x++) {
            let thisWord = val[x];
            switch (x) {
                case 0:
                    if (thisWord !== 'R') {
                        trig = false;
                    }
                    break;
                case 1:
                case 2:
                case 3:
                case 4:
                    if (!NumReg.test(thisWord)) {
                        trig = false;
                    }
                    break;
                case 5:
                case 6:
                if (thisWord !== 'P') {
                        trig = false;
                    }
                    break;
                default:
                trig = false;
                    break;
            }
        }
        return trig;
    }

    document.querySelector('#submit').addEventListener('click', function (e) {
        e.preventDefault();
        register();
    }, false);


    function register() {
        var password_set = $('#password_set').val();
        var name_set = $('#name').val();
        var phone_set = $('#phone_set').val();
        var confirm_password_set = $('#confirm_password_set').val();
        var email = $("#email").val();
        var re = /^\S+@\S+\.[A-Za-z]+$/;
        var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20}$/;
        var namew = /^[\u4e00-\u9fa5]{0,}$/;
        var phonew = /^09\d{8}$/;

        if (password_set == confirm_password_set && re.test(String(email).toLowerCase()) && password_set.match(passw) && name_set.match(namew) && name_set.length > 1 && phone_set.match(phonew)) {
            $("#submit").attr('disabled',true);
            $.ajax({
                type: "Post",
                url: "{{ url('/users/sign_up/define') }}",
                dataType: "json",
                data: $('#user_registration_form').serialize(),
                success: function (data) {
                    if (data.duplicate) {
                        // alert("此帳號已有註冊紀錄，請直接前往登入");

                        swal("提示", "此帳號已有註冊紀錄，請直接前往登入", "error").then(function () {
                            location.href = "{{ url('/users/sign_in') }}";
                        })
                        // $("#swalBtn").unbind().click(function () {
                        //     location.href = "{{ url('/users/sign_in') }}";
                        // })

                    }
                    if (data.register) {
                        // alert("已將驗證信件寄至您的信箱，請前往進行驗證");
                        // location.href = "{{ url('/users/sign_in') }}";

                        swal("提示", "已將驗證信件寄至您的信箱，請前往進行驗證", "success").then(function () {
                            location.href = "{{ url('/users/sign_in') }}";
                        })

                    }
                    if(data.NoCode){
                        swal("提示", "找不到此推薦代碼，請重新輸入", "error");
                        $("#submit").attr('disabled',false);
                    }
                    if(data.PPcodeError){
                        swal("提示", "推薦代碼格式錯誤，請重新輸入", "error");
                        $("#submit").attr('disabled',false);
                    }
                },
                error: function (data) {
                    console.log(data);

                    // if(data.error){
                    //     alert("請先註冊會員");
                    //     location.href='/users/sign_up';
                    // }
                }
            });
        } else if (password_set != confirm_password_set) {
            // alert('您輸入的密碼不相符請重新輸入')

            swal("提示", "您輸入的密碼不相符請重新輸入", "error")

        } else if (!re.test(String(email).toLowerCase())) {
            // alert('您輸入的Email格式有誤請重新輸入')

            swal("提示", "您輸入的Email格式有誤請重新輸入", "error")

        } else if (!password_set.match(passw)) {
            // alert('您輸入的密碼格式有誤請重新輸入')

            swal("提示", "您輸入的密碼格式有誤請重新輸入", "error")
        } else if (name_set.length == 1||name_set.length == 0){

            swal("提示", "您輸入的真實姓名不可少於兩個字請重新輸入", "error")
        } else if (!name_set.match(namew)) {
            // alert('您輸入的密碼格式有誤請重新輸入')

            swal("提示", "因會員為實名制，請輸入中文姓名", "error")
        } else if (!phone_set.match(phonew)){

            swal("提示", "您輸入的手機號碼格式不正確請重新輸入", "error")
        }
    }



    $('#password_set, #confirm_password_set').on('keyup', function () {
        if ($('#password_set ').val() == $('#confirm_password_set').val()) {
            $('#message').html('密碼相符合').css('color', 'green');

        } else
            $('#message').html('密碼不符合').css('color', 'red');

    });

    $('.close,.back').click(function () {
        $('#register_submit').fadeOut();
    })

    $('#lightbox_tender_paid').click(function () {
        $('#register_submit').fadeIn();
    })
    function show_pw2(){
        var t = $('#password_set').attr("type");
        if(t=='password'){
            $('#password_set').attr('type', 'text');
        }else{
            $('#password_set').attr('type', 'password');
        }
        
    }

</script>






@endsection
