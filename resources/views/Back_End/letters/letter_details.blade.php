@extends('Back_End.layout.header')

@section('content')
<script src="{{ asset('/js/ckeditor4/ckeditor.js') }}"></script>

    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">檢視站內信</h3>
          </div>
        </div>

        <div class="col-md-12">
            <div style="border:solid 1px #1a2732">
                <div style="padding:10px;background-color:#394a59;">
                    <h4 style="color:white;">站內信</h4>
                </div>
            <div class="panel-body">
                <form novalidate="novalidate" class="simple_form new_match_performance" id="new_match_performance" enctype="multipart/form-data" action="/admin/match_performances" accept-charset="UTF-8" method="post"><input name="utf8" type="hidden" value="&#x2713;" />
                    @csrf

                    <div class="row m-b-15">
                        <div class='col-sm-12'>
                            <label for="exampleFormControlTextarea1">標題</label>
                            <input type="hidden" name="letter_id" id="letter_id" value="{{$row->internal_letter_id}}">
                            <input type="text" class="form-control" name="title" id="title" value="{{$row->title}}" >
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
                            <input type="text" class="form-control" name="user_email" id="" value="{{$user_email}}" readonly>
                        </div>
                    </div>

                    <div class="row m-b-15">
                        <div class='col-sm-12'>
                            <label for="exampleFormControlTextarea1">發送時間</label>
                            <span class="form-control">{{$row->created_at}}</span>
                        </div>
                    </div>
                
                    <div class="col-sm-12" style="margin-top:40px;">
                        <a href="/admin/internal_letters" class="btn btn-info pull-right m-r-5">返回</a>
                        <button type="button" onclick="insert_item();" class="btn btn-info pull-right m-r-5">儲存</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>

      </section>
    </section>


    <script type="text/javascript" src="/js/daterangepicker/moment.min.js"></script>
    <script type="text/javascript" src="/js/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/js/daterangepicker/daterangepicker.css"/>

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


    var datepicker_setting = {
        autoUpdateInput: false,
        singleDatePicker: true,
        opens: "center",
        drops: "up",
        locale: {
            format: "YYYY/MM/DD",
            applyLabel : "確定",
            cancelLabel : "取消",
            fromLabel : "開始日期",
            toLabel : "結束日期",
            customRangeLabel : "自訂日期區間",
            daysOfWeek : [ "日", "一", "二", "三", "四", "五", "六" ],
            monthNames : [ "1月", "2月", "3月", "4月", "5月", "6月",
            "7月", "8月", "9月", "10月", "11月", "12月" ],
            firstDay : 1,
        }
    };

    $(document).ready(function(){
        CKEDITOR.instances.ckeditor.setData(`<?php echo html_entity_decode($row->content); ?>`);
        $('.datepicker').daterangepicker(datepicker_setting);

        $('.datepicker').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY/MM/DD'));
        });
    });

    function insert_item(){
            let letter_id = $("#letter_id").val();
            let title = $("#title").val();
            let ckeditor = CKEDITOR.instances.ckeditor.getData();
            let data = {
                title:title,
                ckeditor:ckeditor,
                letter_id:letter_id
            };
            $.ajax({
            type:"POST",
            url:"/admin/internal_letters_update",
            dataType:"json",
            data:data
            ,
            success:function(data){
                if(data.success){
                    alert("更新成功");
                    location.href='/admin/internal_letters_details/'+letter_id;
                }
            }
        });
    }


        
    </script>

@endsection             