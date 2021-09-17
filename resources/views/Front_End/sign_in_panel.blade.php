@extends('Front_End.layout.header')

   

    @section('content')

    <link rel="stylesheet" media="screen" href="/css/sign.css" />


    <style>
        body{
            /* background-image: url(../images/sign.jpg); */
            background-image: url(../images/20210621-18.png);
        }
        #password2{
            width: 95%;
            display: unset;
        }
        .top_line{
            height: auto;
        }
        @media screen and (max-width: 620px) {
            #password2{
                width: 94%;
            }
        }
        @media screen and (max-width: 476px) {
            #password2{
                width: 93%;
            }
        }
        @media screen and (max-width: 430px) {
            #password2{
                width: 92%;
            }
        }
        @media screen and (max-width: 396px) {
            #password2{
                width: 91%;
            }
        }
        @media screen and (max-width: 369px) {
            #password2{
                width: 90%;
            }
        }
        @media screen and (max-width: 348px) {
            #password2{
                width: 89%;
            }
        }
        @media screen and (max-width: 330px) {
            #password2{
                width: 88%;
            }
        }
        @media screen and (max-width: 316px) {
            #password2{
                width: 87%;
            }
        }
        @media screen and (max-width: 303px) {
            #password2{
                width: 86%;
            }
        }
        @media screen and (max-width: 293px) {
            #password2{
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
                                <div class="sign1 sign_active">會員登入</div>
                            </a>
                            <a href="/users/sign_up">
                                <div class="sign2 ">註冊會員</div>
                            </a>
                            <a href="/users/password_new">
                                <div class="sign3">忘記密碼</div>
                            </a>
                        </div>

                        <form class="p-4" id="page-signup-form" role="form" method="POST" action="{{ url('/login') }}">
                            {{ csrf_field() }}

                            <input name="utf8" type="hidden" value="✓">
                            <input type="hidden" name="authenticity_token" value="TVeP/F6bZicqNY3zaA/NZNPdOz82bSO9LA/8JzU3EaDVAJRdIcO48yHfddJkpEWIJ7G8cVtGeyMF+Gfns9nGtg==">

                            <div class="px-4 py-3 px-44">
                                
                                @if (session('emailConfirm'))
                                <div class="form-group f14">
                                    <div class="alert alert-danger">
                                        請完成Email驗證後再進行登入
                                    </div>
                                </div>
                                @endif

                                <div class="form-group f14">
                                    <label for="exampleDropdownFormEmail1">電子信箱</label>

                                        <div class="page-signup-icon text-muted"><i class="ion-person"></i></div>
                                        <input id="username" type="text" class="page-signup-form-control form-control" placeholder="帳號" name="email" value="{{ old('username') }}" required autofocus>
                                        @if ($errors->has('username'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('username') }}</strong>
                                            </span>
                                        @endif
                                </div>

                                <div class="form-group f14">
                                    <label for="exampleDropdownFormPassword1">密碼</label>

                                        <div class="page-signup-icon text-muted"><i class="ion-asterisk"></i></div>
                                        <input id="password2" type="password" class="page-signup-form-control form-control" placeholder="密碼" name="password" required>
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                        <i  class="fa fa-eye" aria-hidden="true" onclick='show_pw2()'></i>
                                </div>

                                <div class="for  for_sign f14">
                                    <i class="fa fa-question-circle" aria-hidden="true"></i>
                                    <label class="form-check-label" for="dropdownCheck">
                                        <a href="#" class="forget_pwd">
                                        </a><a href="/users/password_new">忘記密碼</a>

                                    </label>
                                    <i class="fa fa-envelope" aria-hidden="true" style="    padding-left: 20px;"></i>
                                    <label class="form-check-label" for="dropdownCheck">
                                        <a href="#">
                                        </a><a href="/users/resent_validation">重寄驗證信</a>

                                    </label>
                                </div>
                                <div style="padding-top: 15px; padding-bottom: 15px;">
                                    <button type="submit"  class="btn btn-primary" style=" border-radius: 0;width: 100%; background-color: #00a5e4; font-size: 13px;border-color: #00C1DE; ">登入</button>
                                </div>
                            </div>
                            @if($errors->any())
                                @foreach ($errors->all() as $error)
                                <span class="help-block" style="color:red" >
                                    <strong>您所輸入的資料有誤請重新檢查</strong>
                                </span>
                                    {{-- <h4>您所輸入的資料有誤請重新檢查</h4> --}}
                                @endforeach
                            @endif
                        </form>

                    </div>
                </div>
            </div>
            <div class="member_footer">
            </div>
        </div>

    </section>


<script>

function sending(){
            var password = $('#password').val();
            var confirm_password_set = $('#confirm_password_set').val();
            var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20}$/;
            if(password == confirm_password_set  && password.match(passw)){
        if(window.confirm('確定設定新密碼?')){
            $.ajax({
            type:"POST",
            url:"/users/newpassword_confirmation",
            dataType:"json",
            data:
                $('#newpassword_confirmation_form').serialize()
            ,
            success:function(data){
                if(data.success){
                    alert("已成功更改為新密碼");
                    location.href='/users/sign_in';
                }
                // if(data.incorrect){
                //     alert("您所輸入的Email有誤");
                //     // location.href='/users/sign_in';
                // }
            }
            // error:function(data){
            //     if(data.error){
            //         alert("請先註冊會員");
            //         location.href='/users/sign_up';
            //     }
            // }
        });
    }
            }
            else if(password!= confirm_password_set){
                alert('您輸入的密碼不相符請重新輸入')

            }

            else if(!password.match(passw)){
                alert('您輸入的密碼格式有誤請重新輸入')

            }
       }
       function show_pw2(){
            var t = $('#password2').attr("type");
            if(t=='password'){
                $('#password2').attr('type', 'text');
            }else{
                $('#password2').attr('type', 'password');
            }
            
        }

</script>

@endsection



