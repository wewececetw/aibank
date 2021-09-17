@extends('Front_End.layout.header')

    @section('content')

    <link rel="stylesheet" media="screen" href="/css/sign.css" />


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
                position: absolute;
                bottom: 0px;
                width: 100%;
            }
        }
    </style>

        
        <div class="container-fluid bgsign">
            <div class="container">
                <div class="sign_form  ">
                    <div class="form_top">
                        
                        <div class="sign_top">
                            
                            {{-- <a href="/users/newpassword_setting">
                                <div class="sign2 sign_active">密碼修改</div>
                            </a> --}}
                           
                        </div>

                        <form id="resent_confirmation_form" novalidate="novalidate" class="simple_form new_user" accept-charset="UTF-8" method="post">
                            @csrf
                            <div class="px-4 py-3 px-44">
                                <div class="form-group f14">
                                    <label for="exampleDropdownFormEmail1">重新發送驗證信</label>
                                    {{-- <input type="text" class="form-control" name="email" placeholder="Username" autofocus> --}}
                                    <input class="form-control reg_email" value="" required="required" autofocus="autofocus" style="border-radius: 0;font-size: 14px;padding-top: 8px;padding-bottom: 8px;" type="email" name="email" id="email">
                        
                                </div>
                                
                                <div class="m-auto" >
                                    <button class="btn btn-primary" type="button" onclick="sending()"   style="border-radius: 0;width: 100%; background-color: #00a5e4; font-size: 13px;border-color: #00C1DE; ">重新發送驗證信至Email</button>
                                </div>
                                
                            </div>
                            

                                
                                </form>
                    
                        </div>
                               
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
        if(window.confirm('確定重發驗證信?')){
            $.ajax({
            type:"POST",
            url:"/users/resent_confirmation",
            dataType:"json",
            data:
                $('#resent_confirmation_form').serialize()
            ,
            success:function(data){
                if(data.success){
                    alert("已重發");
                    location.href='/users/sign_in';
                }
                if(data.register){
                    alert("您已完成驗證或是尚未註冊會員");
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
            }
            else if(!re.test(String(email).toLowerCase())){
                alert('您所輸入的Email格式有誤')
                
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
