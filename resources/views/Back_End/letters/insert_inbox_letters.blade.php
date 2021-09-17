@extends('Back_End.layout.header')

@section('content')
<script src="{{ asset('/js/ckeditor4/ckeditor.js') }}"></script>

    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">新增站外信</h3>
          </div>
        </div>

        <div class="col-md-12">
            <div style="border:solid 1px #1a2732">
                <div style="padding:10px;background-color:#394a59;">
                    <h4 style="color:white;">站外信</h4>
                </div>
            <div class="panel-body">
                <form novalidate="novalidate" class="simple_form new_match_performance" id="insert_letters_form" enctype="multipart/form-data" action="/admin/match_performances" accept-charset="UTF-8" method="post"><input name="utf8" type="hidden" value="&#x2713;" />
                    @csrf

                    <div class="row m-b-15">
                        <div class='col-sm-12'>
                            <label for="exampleFormControlTextarea1">標題</label>
                            <input type="text" class="form-control" name="title" id="title" >
                        </div>
                    </div>

                    <div class="row m-b-15">
                        <div class='col-sm-12'>
                            <label for="exampleFormControlTextarea1">內容</label>
                            <textarea class="form-control" id="ckeditor" name="ckeditor"></textarea>
                        </div>
                    </div>

                    <div class="row m-b-15">
                        <div class="col-sm-12">
                            <label for="exampleFormControlTextarea1">收件人</label>
                            <select name="user_ids"  id="user_ids" onchange="show_email()" >
                                <option value="" style="color:lightgray">請選擇類型</option>
                                <option value="4" style="">選擇單一使用者</option>
                                    @foreach($identityArray as $k => $v)
                                        <option value="{{$k}}">{{ $v }}</option>
                                    @endforeach
                            </select>
                            
                            
                        </div>
                        <div class="col-sm-12" id='email_div' style="display: none">
                            <label for="exampleFormControlTextarea1">請輸入email</label>
                            <input type="text" id="user_email" >
                        </div>

                    </div>
                
                    <div class="col-sm-12" style="margin-top:40px;">
                        <a class="btn btn-info pull-right" href="/admin/internal_letters">返回</a>
                        <button type="button" onclick="insert_item();" class="btn btn-info pull-right m-r-5">送出</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>

      </section>
    </section>




</section>

    <script>
    CKEDITOR.replace( 'ckeditor', {
        filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
        filebrowserBrowseUrl: "{{asset('/admin/internal_letters/image_browse')}}",
        filebrowserUploadMethod: 'form',
        extraPlugins: 'colorbutton,colordialog,font,justify,smiley,emoji,autocomplete,textmatch,ajax,floatpanel,panelbutton,xml,textwatcher'
    });
    </script>

    <script>

        function show_email() {
            let user_ids = $("#user_ids").val();
            if(user_ids == 4){
                $('#email_div').show();
            }else{
                $('#email_div').hide();
                $("#user_email").val('');
            }
        }

        function insert_item(){
            let title = $("#title").val();
            let ckeditor = CKEDITOR.instances.ckeditor.getData();
            let user_email = $("#user_email").val();
            let user_ids = $("#user_ids").val();
            if (user_ids == 4 && user_email==''){
                swal('提示', 'email欄位為空', 'error');
            }else if(title == '' ){
                swal('提示', '標題欄位為空', 'error');
            }else if( ckeditor == '' ){
                swal('提示', '內容欄位為空', 'error');
            }else if( user_ids == '' ){
                swal('提示', '身份別欄位未選擇', 'error');
            }else{
            if (user_ids == 4){user_ids=null;}
            let data = {
                title:title,
                ckeditor:ckeditor,
                user_email:user_email,
                user_ids:user_ids
            };
                $.ajax({
                type:"POST",
                url:"/admin/inbox_letters_store",
                dataType:"json",
                data:data
                ,
                success:function(data){
                    if(data.success){
                        alert("已成功送出");
                        location.href='/admin/outside_letters';
                    }
                }
            });
            }
    }
    


        
    </script>

@endsection             