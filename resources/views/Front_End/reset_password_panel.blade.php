@extends('Front_End.layout.header')

    <link rel="stylesheet" media="screen" href="/css/sign.css" />


    <style>
        body{
            background-image: url(../images/sign.jpg);
        }
    </style>

    @section('content')


        <div class="container-fluid bgsign">
            <div class="container">
                <div class="sign_form  ">
                    <div class="form_top">

                        <div class="sign_top">

                            <a href="/users/newpassword_setting">
                                <div class="sign2 sign_active">密碼修改</div>
                            </a>

                        </div>

                        <form id="newpassword_confirmation_form" novalidate="novalidate" class="simple_form new_user" accept-charset="UTF-8" method="post">
                            @csrf
                            {{-- <input name="utf8" type="hidden" value="✓">
                            <input type="hidden" name="authenticity_token" value="uPu2vs23xOoBPhRxbHIErfnnajmvaL9ChksHrvfXBp8grK0fsu8aPgrU7FBg2YxBDYvtd8JD59yvvJxucTnRiQ=="> --}}
                            <div class="px-4 py-3 px-44">
                                <input type="text" name="reset_password_token" style="display:none" value="{{$row->reset_password_token}}">

                                {{-- <div class="form-group f14">
                                    <label for="exampleDropdownFormEmail1">電子信箱</label>
                                    <input type="text" class="form-control" name="email" placeholder="Username" autofocus>

                                    <input class="form-control reg_email" value="" required="required" autofocus="autofocus" style="border-radius: 0;font-size: 14px;padding-top: 8px;padding-bottom: 8px;" type="text" name="email" >

                                </div> --}}

                                <div class="form-group f14">
                                    <label for="exampleDropdownFormPassword1">設定新密碼</label>
                                    <input class="form-control reg_password" id="password_set" required="required" title="至少8字的英數組合" hint="8 characters minimum" type="password" style="border-radius: 0;font-size: 14px;padding-top: 8px;padding-bottom: 8px;" name="encrypted_password" >

                                </div>
                                <div class="for  for_sign f14">
                                    <label class="form-check-label" for="dropdownCheck">
                                        至少8字，至多20字, 內含英文（大小寫至少各一）及數字, 不能輸入任何特殊字元, 例如 : @, $, &amp; ... !
                                    </label>
                                </div>

                                <div class="form-group f14">
                                    <label for="exampleDropdownFormPassword1">確認密碼</label>&nbsp;&nbsp;&nbsp;<span id='message'></span>
                                    <input class="form-control reg_password_confirmation" id="confirm_password_set" required="required" type="password" style="border-radius: 0;font-size: 14px;padding-top: 8px;padding-bottom: 8px;" name="encrypted_password" >
                                    {{-- <input  value="{{$row}}"> --}}
                                </div>
                                {{-- <div class="form-group f14">
                                    <label for="exampleDropdownFormPassword1">得知管道</label>
                                    <select id="user_come_from_info" class="form-control come_from_info" name="user[come_from_info]" required="">
                                        <option value="website_advertisement">搜尋網站廣告(Google/Yahoo)</option>
                                        <option value="facebook">FB粉絲團</option>
                                        <option value="recommendation">親友推薦</option>
                                        <option value="phone_sales">電話行銷</option>
                                        <option value="recommendation_from_sales">業務推薦</option>
                                        <option value="others">其他</option>
                                    </select>
                                </div> --}}
                                <div class="form-group f14 come_from_info_text" style="display:none">
                                    <label for="recommendation_code">推薦代碼</label>
                                    <input class="form-control" name="user[come_from_info_text]" id="user_come_from_info_text" placeholder="請填寫服務人員代號">
                                </div>
                                <div style="padding-top: 15px; padding-bottom: 15px;">
                                    <button class="btn btn-primary" type="button" onclick="sending()"   style="border-radius: 0;width: 100%; background-color: #00a5e4; font-size: 13px;border-color: #00C1DE; ">設定新密碼</button>
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
            var password_set = $('#password_set').val();
            var confirm_password_set = $('#confirm_password_set').val();
            var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20}$/;
            if(password_set == confirm_password_set  && password_set.match(passw)){
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
                    // alert("已成功更改為新密碼");

                    swal('成功','已成功更改為新密碼','success').then(() => {
                        location.href= "{{ url('/users/sign_in') }}";
                    })
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
            else if(password_set!= confirm_password_set){
                // alert('您輸入的密碼不相符請重新輸入')
                swal('錯誤','您輸入的密碼不相符請重新輸入','error');
            }

            else if(!password_set.match(passw)){
                // alert('您輸入的密碼格式有誤請重新輸入')
                swal('錯誤','您輸入的密碼格式有誤請重新輸入','error');

            }
       }





            $('#password_set, #confirm_password_set').on('keyup', function () {
            if ($('#password_set').val() == $('#confirm_password_set').val()) {
                $('#message').html('密碼相符合').css('color', 'green');

            } else
                $('#message').html('密碼不符合').css('color', 'red');

            });

            $('.close,.back').click(function(){
                $('#register_submit').fadeOut();
            })

            $('#lightbox_tender_paid').click(function(){
                $('#register_submit').fadeIn();
            })


        </script>






@endsection
