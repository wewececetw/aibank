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
                        <div class="sign1">????????????</div>
                    </a>
                    <a href="/users/sign_up">
                        <div class="sign2 sign_active">????????????</div>
                    </a>
                    <a href="/users/password_new">
                        <div class="sign3 ">????????????</div>
                    </a>
                </div>

                <form id="user_registration_form" novalidate="novalidate" class="simple_form new_user p-4"
                    accept-charset="UTF-8" method="post">
                    @csrf
                    <div class="px-4 py-3 px-44">
                        <div class="form-group f14">
                            <label for="exampleDropdownFormEmail1">????????????</label><p style="color: red;display: inline;">(?????????????????????????????????<a href="https://loan.pponline.com.tw/">??????</a>??????)</p>
                            <input class="form-control reg_email" value="" required="required" autofocus="autofocus"
                                style="border-radius: 0;font-size: 14px;padding-top: 8px;padding-bottom: 8px;"
                                type="email" name="email" id="email">

                        </div>

                        <div class="form-group f14">
                            <label for="exampleDropdownFormPassword1">????????????</label> <p style="color: red;display: inline;">(?????????)</p>
                            <input class="form-control" required="required"
                                style="border-radius: 0;font-size: 14px;padding-top: 8px;padding-bottom: 8px;"
                                type="text" name="user_name" id="name"/>

                        </div>

                        <div class="form-group f14">
                            <label for="exampleDropdownFormPassword1">????????????</label>
                            <input class="form-control" required="required"
                                style="border-radius: 0;font-size: 14px;padding-top: 8px;padding-bottom: 8px;"
                                type="text" name="phone" id="phone_set"  pattern="09\d{2}\-?\d{3}\-?\d{3}"/>

                        </div>

                        <div class="form-group f14">
                            <label for="exampleDropdownFormPassword1">????????????</label>
                            <input class="form-control reg_password" id="password_set" required="required"
                                pattern="[A-Za-z0-9]+" minlength="8" maxlength="20" type="password"
                                style="border-radius: 0;font-size: 14px;padding-top: 8px;padding-bottom: 8px;"
                                name="encrypted_password" id="user_password">
                                <i  class="fa fa-eye" aria-hidden="true" onclick='show_pw2()'></i>
                                

                        </div>

                        <div class="for  for_sign f14">
                            <label class="form-check-label" for="dropdownCheck">
                                ??????8????????????20???, ????????????????????????????????????????????????, ??????????????????????????????, ?????? : @, $, &amp; ... !
                            </label>
                        </div>

                        <div class="form-group f14">
                            <label for="exampleDropdownFormPassword1">????????????</label>&nbsp;&nbsp;&nbsp;<span
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
                            <label for="recommendation_code">????????????</label>
                            <select class="form-control" name="come_from_info" id="user_come_from_info">
                                <option value="0">??????????????????(Google/Yahoo)</option>
                                <option value="1">FB?????????</option>
                                <option value="2">????????????</option>
                                <option value="3">????????????</option>
                                <option value="4">????????????</option>
                                <option value="5">??????</option>
                            </select>
                        </div>
                        <div class="form-group f14 hide" id="come_from_info_block">
                            <label for="recommendation_code">????????????  </label><span id="formatS" class="hide" style="color:red">????????????</span>
                            <input class="form-control" name="come_from_info_text" id="user_come_from_info_text" placeholder="???????????????????????????">
                        </div>
<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>
                        <div style="padding-top: 15px; padding-bottom: 15px;">
                            <button type="button" id="submit"
                                style="border-radius: 0;width: 100%; background-color: #00a5e4; font-size: 13px;border-color: #00C1DE;padding:6px; ">????????????</button>
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
                $("#user_come_from_info_text").attr("placeholder", "???????????????????????????");
            }else{
                $("#user_come_from_info_text").attr("placeholder", "???????????????????????????");
            }
        } else {
            $("#come_from_info_block").toggleClass('hide', true);
        }
    })
    //PP????????????
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

    //??????PP????????????
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
                        // alert("???????????????????????????????????????????????????");

                        swal("??????", "???????????????????????????????????????????????????", "error").then(function () {
                            location.href = "{{ url('/users/sign_in') }}";
                        })
                        // $("#swalBtn").unbind().click(function () {
                        //     location.href = "{{ url('/users/sign_in') }}";
                        // })

                    }
                    if (data.register) {
                        // alert("????????????????????????????????????????????????????????????");
                        // location.href = "{{ url('/users/sign_in') }}";

                        swal("??????", "????????????????????????????????????????????????????????????", "success").then(function () {
                            location.href = "{{ url('/users/sign_in') }}";
                        })

                    }
                    if(data.NoCode){
                        swal("??????", "??????????????????????????????????????????", "error");
                        $("#submit").attr('disabled',false);
                    }
                    if(data.PPcodeError){
                        swal("??????", "??????????????????????????????????????????", "error");
                        $("#submit").attr('disabled',false);
                    }
                },
                error: function (data) {
                    console.log(data);

                    // if(data.error){
                    //     alert("??????????????????");
                    //     location.href='/users/sign_up';
                    // }
                }
            });
        } else if (password_set != confirm_password_set) {
            // alert('??????????????????????????????????????????')

            swal("??????", "??????????????????????????????????????????", "error")

        } else if (!re.test(String(email).toLowerCase())) {
            // alert('????????????Email???????????????????????????')

            swal("??????", "????????????Email???????????????????????????", "error")

        } else if (!password_set.match(passw)) {
            // alert('?????????????????????????????????????????????')

            swal("??????", "?????????????????????????????????????????????", "error")
        } else if (name_set.length == 1||name_set.length == 0){

            swal("??????", "????????????????????????????????????????????????????????????", "error")
        } else if (!name_set.match(namew)) {
            // alert('?????????????????????????????????????????????')

            swal("??????", "?????????????????????????????????????????????", "error")
        } else if (!phone_set.match(phonew)){

            swal("??????", "??????????????????????????????????????????????????????", "error")
        }
    }



    $('#password_set, #confirm_password_set').on('keyup', function () {
        if ($('#password_set ').val() == $('#confirm_password_set').val()) {
            $('#message').html('???????????????').css('color', 'green');

        } else
            $('#message').html('???????????????').css('color', 'red');

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
