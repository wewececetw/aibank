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
    <link rel="stylesheet" media="screen"
        href="/assets/front/match-ab00adde9a2208fa12a33b86a261b34d9ea621b0ceed421ed9fd13204e088bb4.css" />
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
        <div class="row">
            <div class="member_title col-sm-12"> <span class="f28m">修改密碼</span></div>
            <form style="width: 100%" id="change_password_form">
                <div class="form-horizontal">
                    <div class="form-group ">
                        <label for="originalPassword" class="col-sm-12 control-label"></label>
                        <div class="col-sm-6">
                            <p>密碼請以8碼以上20碼以下至少一大寫一小寫英文加上數字混合輸入</p> &nbsp;&nbsp;&nbsp;<span id='message'></span>
                        </div>
                    </div>
                    <div class="form-group w-4">
                        <label for="originalPassword" class="col-sm-12 control-label f16 f16txt">原始密碼：</label>
                        <div class="col-sm-12 set_margin">
                            <input type="password" class="form-control t0" id="origin_password" name="origin_password"
                                required="">
                        </div>
                    </div>
                    <div class="form-group w-4">
                        <label for="newPassword" class="col-sm-12 control-label f16 f16txt">新密碼：</label>
                        <div class="col-sm-12 set_margin">
                            <input type="password" class="form-control t0" id="password_set" name="password_set"
                                required="">
                        </div>
                    </div>
                    <div class="form-group w-4">
                        <label for="checkNewPassword" class="col-sm-12 control-label f16 f16txt">確認新密碼：</label>
                        <div class="col-sm-12 set_margin">
                            <input type="password" class="form-control t0" id="confirm_password_set"
                                name="confirm_password_set" required="">
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div class="form-group " style="padding-top: 30px; padding-bottom: 30px;">
                        <div class="col-sm-10">
                            <a id="showPass" class="btn form_bt pull-left footer_btn2 pb20" style="line-height: 2.5;">顯示密碼</a>
                            <button id="edit_password_btn" onclick="sending()"
                                class="btn form_bt pull-left save_custom_setting_btn footer_btn">確定修改</button>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>


</body>

</html>
<script>
    $("#showPass").click(function (e) {
        e.preventDefault();
        showPass($("#origin_password"));
        showPass($("#password_set"));
        showPass($("#confirm_password_set"));
    })
    function showPass(ele){
        if (ele.attr('type') === "password") {
            ele.attr('type','text');
        } else {
            ele.attr('type','password');
        }
    }

    document.querySelector('#edit_password_btn').addEventListener('click', function (e) {
        e.preventDefault();
    }, false);

    function sending() {
        var password_set = $('#password_set').val();
        var confirm_password_set = $('#confirm_password_set').val();
        var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20}$/;
        if (password_set == confirm_password_set && password_set.match(passw)) {
            if (window.confirm('確定修改密碼?')) {
                $.ajax({
                    type: "POST",
                    url: "/users/changepassword_confirmation",
                    dataType: "json",
                    data: $('#change_password_form').serialize(),
                    success: function (data) {
                        if (data.success) {
                            alert("已成功修改為新密碼");
                            location.href = '/users/tab_five';
                        }
                        if (data.wrong) {
                            alert("您的原始密碼有誤");
                            // location.href='/users/sign_in';
                        }
                    }
                    // error:function(data){
                    //     if(data.error){
                    //         alert("請先註冊會員");
                    //         location.href='/users/sign_up';
                    //     }
                    // }
                });
            }
        } else if (password_set != confirm_password_set) {
            alert('您輸入的密碼不相符請重新輸入')

        } else if (!password_set.match(passw)) {
            alert('您輸入的密碼格式有誤請重新輸入')

        }
    }






    $('#password_set, #confirm_password_set').on('keyup', function () {
        if ($('#password_set').val() == $('#confirm_password_set').val()) {
            $('#message').html('密碼相符合').css('color', 'green');

        } else
            $('#message').html('密碼不符合').css('color', 'red');

    });

</script>
@endsection
