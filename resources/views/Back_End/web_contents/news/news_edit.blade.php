@extends('Back_End.layout.header')

@section('content')

<script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.3/css/bootstrap-datetimepicker.min.css" />
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" />

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.3/js/bootstrap-datetimepicker.min.js"></script>



<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                @if(isset($news->name))
                    <h3 class="page-header">編輯最新消息</h3>
                @else
                    <h3 class="page-header">新增最新消息</h3>
                @endif
            </div>
        </div>

        <div class="col-md-12">
            <div style="border:solid 1px #1a2732">
                <div style="padding:10px;background-color:#394a59;">
                    <h4 style="color:white;"></h4>
                </div>
                <div class="panel-body">
                    <form id="news_form">
                        @csrf
                        <div class="detail_1" style="margin-bottom:40px;">

                            <div class="row m-b-15">
                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">名稱</label>
                                    <input type="text" id="name" class="form-control required" name="name" value="<?=(isset($news->name))? $news->name : '' ;?>" required>
                                </div>

                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">簡介</label>
                                    <input type="text" id="remark" class="form-control required" name="remark" value="<?=(isset($news->remark))? $news->remark : '' ;?>" required>
                                </div>
                            </div>

                            <div class="row m-b-15">
                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">狀態</label>
                                    <select name="is_active" class="form-control required_select" id="is_active" required>

                                        @if(isset($news->name))
                                            <option value="1" <?=(isset($news['is_active'])=='1')?' selected':''?>>啟用</option>
                                            <option value="0" <?=(isset($news['is_active'])=='0')?' selected':''?>>停用</option>
                                        @else
                                            <option value="1">啟用</option>
                                            <option value="0">停用</option>
                                        @endif
                                        
                                    </select>
                                </div>

                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">發布時間</label>
                                    <div class="form-group">
                                        <div class='input-group date' id='datetimepicker1'>
                                            <input type='text' class="form-control" name="launch_at" value="<?=(isset($news->launch_at))?  date('Y-m-d H:s',strtotime($news->launch_at))  : '' ;?>"/>
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                      </div>
                                </div>
                            </div>

                            <div class="row m-b-15">

                                <div class='col-sm-12'>
                                    <label for="exampleFormControlTextarea1">圖片上傳</label>
                                    <div>

                                        @if(isset($news->name ))
                                            @foreach ($news->news_photo as $item)
                                                <img style="height:200px;"   src="{{ asset($item->image) }}" alt="">
                                            @endforeach
                                        @else
                                            <img style="height:200px;" class="ui fluid image" id="preview-new-cert1" src="#" alt="" src="">
                                        @endif
                                        
                                    </div>
                                    
                                    <input style="width:100%" class="m_t_2" name="image" data-type="cert1" id="imgInput"
                                        onchange="readURL(this)" type="file">

                                    <div class="color_file">
                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                        建議尺寸為{{config('fileSizeLimit.users_info_id_file')}}MB以下
                                    </div>
                                </div>
                            </div>


                            <div class="row m-b-15">

                                <div class='col-sm-12'>
                                    <label for="exampleFormControlTextarea1">標題</label>
                                    <input type="text" id="title" class="form-control required" name="title" value="<?=(isset($news->title))? $news->title : '' ;?>" required>
                                </div>
                            </div>


                            <div class="row m-b-15">
                                <div class='col-sm-12'>
                                    <label for="exampleFormControlTextarea1">內容</label>
                                    <textarea class="form-control required" name="content" id="content" rows="3" required><?=(isset($news->content))? $news->content : '' ;?></textarea>
                                    <script>
                                        CKEDITOR.replace('content');

                                    </script>
                                    <div id="trackingDiv"></div>
                                </div>

                            </div>

                            <div class="col-sm-12" style="margin:20px auto;">
                                @if(isset($news->name))
                                    <button type="button" onclick="update_news();" class="btn btn-info pull-right m-r-5">更新</button>
                                @else
                                    <button type="button" onclick="insert_news();" class="btn btn-info pull-right m-r-5">新增</button>
                                @endif
                            </div>

                    </form>
                </div>
            </div>
        </div>

    </section>
</section>

</section>




<script>

$(function () {
   var bindDatePicker = function() {
		$(".date").datetimepicker({
        format:'YYYY-MM-DD HH:mm',
			icons: {
				time: "fa fa-clock-o",
				date: "fa fa-calendar",
				up: "fa fa-arrow-up",
				down: "fa fa-arrow-down"
			}
		}).find('input:first').on("blur",function () {
			// check if the date is correct. We can accept dd-mm-yyyy and yyyy-mm-dd.
			// update the format if it's yyyy-mm-dd
			var date = parseDate($(this).val());

			if (! isValidDate(date)) {
				//create date based on momentjs (we have that)
				date = moment().format('YYYY-MM-DD HH:mm');
			}

			$(this).val(date);
		});
	}
   
   var isValidDate = function(value, format) {
		format = format || false;
		// lets parse the date to the best of our knowledge
		if (format) {
			value = parseDate(value);
		}

		var timestamp = Date.parse(value);

		return isNaN(timestamp) == false;
   }
   
   var parseDate = function(value) {
		var m = value.match(/^(\d{1,2})(\/|-)?(\d{1,2})(\/|-)?(\d{4})$/);
		if (m)
			value = m[5] + '-' + ("00" + m[3]).slice(-2) + '-' + ("00" + m[1]).slice(-2);

		return value;
   }
   
   bindDatePicker();
 });




    function update_news(){

        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        
        var form_data = new FormData(document.getElementById('news_form'))

        var web_id = '<?= isset($news->web_contents_id)?$news->web_contents_id:''; ?>'


        $.ajax({
            type:"POST",
            url:"{{ url('/news/update') }}"+'/'+web_id,
            data:form_data,
            processData: false,
            contentType : false,

            success:function(data){
                if(data.success){
                    alert("更新成功");
                    location.href="{{ url('/web_contents/news') }}";
                }
            }
        });
    }

    function insert_news(){

        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }

        var form_data = new FormData(document.getElementById('news_form'))

        $.ajax({
            type:"POST",
            url:"{{ url('/news/insert') }}",
            data:form_data,
            processData: false,
            contentType : false,
            // dataType:"json",
            // data:
            //     $('#news_form').serialize()
            // ,
            success:function(data){
                if(data.success){
                    alert("新增成功");
                    location.href="{{ url('/web_contents/news') }}";
                }
            }
        });
    }

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#preview-new-' + $(input).data('type')).attr('src', e.target.result);
                $('#preview-new-' + $(input).data('type')).show();
                $('#preview-new-' + $(input).data('type')).attr('hidden', false);
                $('#preview-' + $(input).data('type')).hide();
            }

            reader.readAsDataURL(input.files[0]);
        }
    }


</script>

@endsection
