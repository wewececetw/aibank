@extends('Back_End.layout.header')

@section('content')

<script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>

<link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.3/css/bootstrap-datetimepicker.min.css" />
<link rel="stylesheet" type="text/css"
    href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" />

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.min.js">
</script>
<script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.3/js/bootstrap-datetimepicker.min.js">
</script>



<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                @if(isset($edit))
                <h3 class="page-header">編輯{{ $category_ch_name }}</h3>
                @else
                <h3 class="page-header">新增{{ $category_ch_name }}</h3>
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
                        <input type="text" name="category" id="category" value="{{ $category }}" hidden>
                        <div class="detail_1" style="margin-bottom:40px;">

                            <div class="row m-b-15">
                                <div class="col-sm-12">
                                        <label>選擇是否新增名稱</label>
                                        <select id="selectName" class="form-control">
                                            <option value="Y">新增</option>
                                            <option value="N">使用已有名稱</option>
                                        </select>
                                </div>

                                <div class='col-sm-6' id="name_block">
                                    <label for="exampleFormControlTextarea1">名稱</label>
                                    <input type="text" id="name" class="form-control required" name="name" required>
                                </div>

                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">簡介</label>
                                    <input type="text" id="remark" class="form-control required" name="remark" required>
                                </div>
                            </div>

                            <div class="row m-b-15">
                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">狀態</label>
                                    <select name="is_active" class="form-control required_select" id="is_active"
                                        required>
                                        <option value="1">啟用</option>
                                        <option value="0">停用</option>
                                    </select>
                                </div>

                                <div class='col-sm-6'>
                                    <label for="exampleFormControlTextarea1">發布時間</label>
                                    <div class="form-group">
                                        <div class='input-group date' id='datetimepicker1'>
                                            <input type='text' class="form-control" name="launch_at" id="launch_at"/>
                                            <span class="input-group-addon"><span
                                                    class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row m-b-15">

                                <div class='col-sm-12'>
                                    <label for="exampleFormControlTextarea1">圖片上傳</label>
                                    <div>

                                        <img style="height:200px;" class="ui fluid image" id="preview-new-cert1" src="#"
                                            alt="" src="">

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
                                    <input type="text" id="title" class="form-control required" name="title" required>
                                </div>
                            </div>


                            <div class="row m-b-15">
                                <div class='col-sm-12'>
                                    <label for="exampleFormControlTextarea1">內容</label>
                                    <textarea class="form-control required" name="content" id="content" rows="3"
                                        required></textarea>
                                    <script>
                                        CKEDITOR.replace('content');

                                    </script>
                                    <div id="trackingDiv"></div>
                                </div>

                            </div>

                            <div class="col-sm-12" style="margin:20px auto;">
                                @if(isset($edit))
                                <button type="button" id="createBtn"
                                    class="btn btn-info pull-right m-r-5">更新</button>
                                @else
                                <button type="button" id="createBtn"
                                    class="btn btn-info pull-right m-r-5">新增</button>
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
    let nameList = {!! $nameList !!};
    $(function () {
        var bindDatePicker = function () {
            $(".date").datetimepicker({
                format: 'YYYY-MM-DD HH:mm',
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down"
                }
            }).find('input:first').on("blur", function () {
                // check if the date is correct. We can accept dd-mm-yyyy and yyyy-mm-dd.
                // update the format if it's yyyy-mm-dd
                var date = parseDate($(this).val());

                if (!isValidDate(date)) {
                    //create date based on momentjs (we have that)
                    date = moment().format('YYYY-MM-DD HH:mm');
                }

                $(this).val(date).trigger('change');
            });
        }

        var isValidDate = function (value, format) {
            format = format || false;
            // lets parse the date to the best of our knowledge
            if (format) {
                value = parseDate(value);
            }

            var timestamp = Date.parse(value);

            return isNaN(timestamp) == false;
        }

        var parseDate = function (value) {
            var m = value.match(/^(\d{1,2})(\/|-)?(\d{1,2})(\/|-)?(\d{4})$/);
            if (m)
                value = m[5] + '-' + ("00" + m[3]).slice(-2) + '-' + ("00" + m[1]).slice(-2);

            return value;
        }

        bindDatePicker();
    });




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

    function validAll() {
        let allInput = $("#news_form").find('input');
        let pass = true;
        $.each(allInput, function (k, v) {
            let val = $(v).val();
            if (val.length == 0 || val == '' || val === null) {
                if ($(v).prop('id') != 'imgInput') {
                    pass = false;
                    $(v).css('background-color', '#eb547c3b');
                    chgBk($(v));
                }
            } else {
                $(v).css('background-color', '#fff');
            }
        })
        return pass;
    }

    function chgBk(that) {
        that.change(function () {
            let val = $(this).val();
            if (val.length == 0 || val == '' || val === null) {
                $(this).css('background-color', '#eb547c3b');
            } else {
                $(this).css('background-color', '#fff');
            }
        })
    }

    $("#selectName").change(function(){
        let val = $(this).val();
        if(val == "Y"){
            $("#name_block >select").remove();
            $("#name_block >input").remove();
            $("#name_block").append(`<input type="text" id="name" class="form-control required" name="name" required>`);
        }else{
            let opt = '';
            if(nameList.length == 0){
                swal('提示','目前暫無資料，請先新增','info');
            }else{
                let opt = '';
                nameList.map((i) => {
                    opt += `<option value="${i}">${i}</option>`;
                })
                $("#name_block >input").remove();
                $("#name_block >select").remove();
                $("#name_block").append(`<select id="name" name="name" required class="form-control">${opt}</select>`);
            }

        }
    })

</script>
@if(isset($edit))
<script>
    let oldData = {!!$data!!};
    $("#name").val(oldData.name);
    $("#title").val(oldData.title);
    $("#is_active").val(oldData.is_active);
    $("#launch_at").val(oldData.launch_at);
    $("#remark").val(oldData.remark);
    $("#content").val(oldData.content);
    if(oldData.news_photo[0]){
        $("#preview-new-cert1").prop('src', '{{ url("/") }}' + '/' + oldData.news_photo[0].image);
    }
    $("#createBtn").click(function () {
        if (validAll()) {
            var form_data = new FormData(document.getElementById('news_form'));
            form_data.set('content',CKEDITOR.instances.content.getData());

            $.ajax({
                type: "POST",
                url: '{{ url("$thisBaseUrl") }}' + '/' + oldData.web_contents_id + '/update',
                data: form_data,
                processData: false,
                contentType: false,
                success: function (data) {
                    if (data.status == 'success') {
                        swal('成功', "更新成功!", 'success').then(function () {
                            location.href = '{{ url("$thisBaseUrl") }}';
                        });
                    }
                },
                error: function (e) {
                    swal('提示', '系統異常，請稍後再試!', 'error');
                }
            })
        } else {
            swal('提示', '欄位漏填!', 'error');
        }
    })

</script>
@else
<script>
    $("#createBtn").click(function () {
        if (validAll()) {
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }

            var form_data = new FormData(document.getElementById('news_form'))
            form_data.set('content',CKEDITOR.instances.content.getData());

            $.ajax({
                type: "POST",
                url: '{{ url("$thisBaseUrl") }}',
                data: form_data,
                processData: false,
                contentType: false,
                success: function (data) {
                    if (data.status == 'success') {
                        swal('成功', "新增成功!", 'success').then(function () {
                            location.href = '{{ url("$thisBaseUrl") }}';
                        });
                    }
                },
                error: function (e) {
                    swal('提示', '系統異常，請稍後再試!', 'error');
                }

            });
        } else {
            swal('提示', '欄位漏填!', 'error');
        }
    })

</script>
@endif

@endsection
