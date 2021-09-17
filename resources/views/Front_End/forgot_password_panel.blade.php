@extends('Front_End.layout.header')

    <link rel="stylesheet" media="screen" href="/css/sign.css" />


    

    @section('content')
    <style>
        body{
            /* background-image: url(../images/sign.jpg); */
            background-image: url(../images/20210621-18.png);
        }
        .top_line{
            height: auto;
        }
        
        @media screen and (max-width: 576px) {
            footer {
                /* position: absolute;
                bottom: 0px;
                width: 100%; */
                margin-top: 100px;
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
                                <div class="sign2 ">註冊會員</div>
                            </a>
                            <a href="/users/password_new">
                                <div class="sign3 sign_active">忘記密碼</div>
                            </a>
                        </div>


                        <form class="form-horizontal" id="forget_password_form"  >
                            @csrf

                            <div class="px-4 py-3">
                                <div class="form-group f14">

                                    <label for="exampleDropdownFormEmail1"> 電子信箱</label>
                                    <div class="form-group email required user_email">
                                        <input class="form-control string email required" autofocus="autofocus" required="required" aria-required="true"  value="" name="email" id="email" >
                                    </div>
                                </div>
                                <div style="padding-top: 15px; padding-bottom: 15px;">
                                    <button type="button" onclick="sending()" class="btn btn-default btn btn-primary" style=" border-radius: 0;width: 100%; background-color: #00a5e4; font-size: 13px;border-color: #00C1DE; ">發送重設密碼至Email</button>
                                    {{-- <input type="submit" name="commit" value="發送重設密碼至Email" class="btn btn-default btn btn-primary" style=" border-radius: 0;width: 100%; background-color: #00a5e4; font-size: 13px;border-color: #00C1DE; " data-disable-with="發送重設密碼至Email"> --}}
                                </div>
                            </div>
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
         var email = $("#email").val();
         var re = /^\S+@\S+$/;
         if(re.test(String(email).toLowerCase())){
        if(window.confirm('你確定要發送重設密碼信件?')){
            $.ajax({
            type:"POST",
            url:"/users/forget_password",
            dataType:"json",
            data:
                $('#forget_password_form').serialize()
            ,
            success:function(data){
                if(data.success){
                    swal('成功',"已發送",'success').then(()=>{
                        location.href='/users/password_new';
                    });
                }
                if(data.revalid){
                    swal('錯誤',"請先至您的信箱點擊驗證信",'error').then(()=>{
                        location.href='/users/password_new';
                    });
                }
                if(data.notuser){
                    swal('錯誤',"請先註冊會員",'error').then(()=>{
                        location.href='/users/password_new';
                    });
                }
                if(data.email_confirm_first){
                    swal('錯誤',"請至您的信箱啟動驗證信，或是重發驗證信",'error').then(()=>{
                        location.href='/users/password_new';
                    });
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
         }
         else if(!re.test(String(email).toLowerCase())){
                // alert('您輸入的Email格式有誤請重新輸入')
                swal('錯誤',"您輸入的Email格式有誤請重新輸入",'error');
            }
       }
    </script>

@endsection
