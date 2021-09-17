@extends('Back_End.layout.header')

@section('content')
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap.min.js"></script>
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> --}}

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
{{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> --}}
<style>
    td.details-control {
        background: url(https://twww.pponline.com.tw/images/details_open.png) no-repeat center center;
        cursor: pointer;
    }

    td.details-control-red {
        background: url(https://twww.pponline.com.tw/images/details_close.png) no-repeat center center;
        cursor: pointer;
    }

    td {
        word-break: break-all !important;
    }

    .c3-axis-y>.tick {
        fill: none; // removes axis labels from y axis
    }
    /*設定div樣式的整體佈局*/
    .page-icon{
		margin:20px 0 0 0;/*設定距離頂部20畫素*/
		/* font-size:5;修復行內元素之間空隙間隔 */
		text-align:center;/*設定內容居中顯示*/
	}
    #background{
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        overflow: hidden;
        outline: 0;
        -webkit-overflow-scrolling: touch;
        background-color: rgb(0, 0, 0);  
        filter: alpha(opacity=60);  
        background-color: rgba(0, 0, 0, 0.6); 
        z-index: 9999;
    }
</style>

<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">使用者列表</h3>
            </div>
        </div>


        <div class="an-single-component with-shadow">
            <div class="an-component-header search_wrapper">
                <div class="panel panel-default an-sidebar-search">
                    <div class="collapsed panel-heading" data-toggle="collapse" href="#search_panel"
                        style="cursor:pointer;">
                        <h4 class="panel-title">
                            篩選條件
                        </h4>
                    </div>
                    <div id="search_panel" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                            <form class="form-group" id="insert_product_form">
                                @csrf
                                <div class="row">
                                    <div class="form-group">
                                        <label class='col-sm-2 control-label l-h-34'>姓名</label>
                                        <div class="col-sm-4">
                                            <input type="hidden" id="now_page">
                                            <input type="hidden" id="count_page">
                                            <input type="hidden" id="sequence">
                                            <input type='text' name='name' id="user_name_search" placeholder='請輸入姓名'
                                                class='an-form-control no-redius border-bottom m-0 text_color filter-name'>
                                        </div>

                                        <label class='col-sm-3 control-label l-h-34'>會員身份別</label>
                                        <div class="col-sm-3">
                                            <select name="user_identity" id="user_identity"
                                                class="select required form-control select2 filter-banned"
                                                include_blank="true" id="admin_banned">
                                                <option value="" style="color:lightgray">選擇會員身份別</option>
                                                {{-- <option value="0">尚未提交</option>
                                                <option value="1">已提交</option> --}}
                                                @foreach($identityArray as $k => $v)
                                                <option value="{{$k}}">{{ $v }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="clear"></div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group">

                                        <label class='col-sm-2 control-label l-h-34'>身分證字號</label>
                                        <div class="col-sm-4">
                                            <input type='text' name='id_card_number' id="id_card_number_search"
                                                placeholder='請輸入身分證字號'
                                                class='an-form-control no-redius border-bottom m-0 text_color filter-id_number'>
                                        </div>


                                        <label class='col-sm-2 control-label l-h-34'>業務專員</label>
                                        <div class="col-sm-4">
                                            <input type='text' name='science_professionals' id="science_professionals"
                                                placeholder='請輸入業務專員姓名'
                                                class='an-form-control no-redius border-bottom m-0 text_color filter-id_number'>
                                        </div>

                                        <div class="clear"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group">

                                        <label class='col-sm-2 control-label l-h-34'>電話</label>
                                        <div class="col-sm-4">
                                            <input type='text' name='phone_number' id="phone_number_search"
                                                placeholder='請輸入電話'
                                                class='an-form-control no-redius border-bottom m-0 text_color filter-id_number'>
                                        </div>

                                        <label class='col-sm-2 control-label l-h-34'>會員編號</label>
                                        <div class="col-sm-4">
                                            <input type='text' name='member_number' id="user_id_search"
                                                placeholder='會員編號'
                                                class='an-form-control no-redius border-bottom m-0 text_color filter-id_number'>
                                        </div>

                                        <div class="clear"></div>
                                    </div>
                                </div>

                                <div class="row form-group">

                                    <label class='col-sm-3 control-label l-h-34'>是否停權</label>
                                    <div class='col-sm-3'>
                                        <form novalidate="novalidate" class="simple_form admin" action="/admin/users"
                                            accept-charset="UTF-8" method="post">
                                            <input name="utf8" type="hidden" value="&#x2713;" />
                                            <input type="hidden" name="" value="" />
                                            <select name="banned" id="banned_search"
                                                class="select required form-control select2 filter-banned"
                                                include_blank="true" id="admin_banned">
                                                <option value="" style="color:lightgray">選擇是否被停權</option>
                                                <option value="0">否</option>
                                                <option value="1">是</option>
                                            </select>
                                        </form>
                                    </div>

                                    <label class='col-sm-3 control-label l-h-34'>是否為公司戶</label>
                                        <div class='col-sm-3'>
                                            <form novalidate="novalidate" class="simple_form admin" action="/admin/users" accept-charset="UTF-8" method="post">
                                                <input name="utf8" type="hidden" value="&#x2713;" />
                                                <input type="hidden" name="" value="" />
                                                <select name="banned" class="select required form-control select2 filter-banned" include_blank="true" id="company_name_search">
                                                    <option value="">請選擇</option>
                                                    <option value="1">是</option>
                                                    <option value="0">否</option>
                                                </select>
                                            </form>
                                        </div>
                                    {{-- <label class='col-sm-3 control-label l-h-34'>VIP</label>
                                        <div class='col-sm-3'>
                                            <form novalidate="novalidate" class="simple_form admin" action="/admin/users" accept-charset="UTF-8" method="post">
                                                <input name="utf8" type="hidden" value="&#x2713;" />
                                                <input type="hidden" name="" value="" />
                                                <select name="banned" class="select required form-control select2 filter-banned" include_blank="true" id="admin_banned">
                                                    <option value="">請選擇</option>
                                                    <option value="true">是</option>
                                                    <option value="false">否</option>
                                                </select>
                                            </form>
                                        </div> --}}

                                </div>

                                <div class="row form-group">

                                    <label class='col-sm-3 control-label l-h-34'>警示戶</label>
                                    <div class='col-sm-3'>
                                        <form novalidate="novalidate" class="simple_form admin" action="/admin/users"
                                            accept-charset="UTF-8" method="post">
                                            <input name="utf8" type="hidden" value="&#x2713;" />
                                            <input type="hidden" name="" value="" />
                                            <select name="is_alert" id="is_alert_search"
                                                class="select required form-control select2 filter-banned"
                                                include_blank="true" id="admin_banned">
                                                <option value="" style="color:lightgray">選擇是否為警示戶</option>
                                                <option value="0">否</option>
                                                <option value="1">是</option>
                                            </select>
                                        </form>
                                    </div>

                                    <label class='col-sm-3 control-label l-h-34'>個資已提交</label>
                                    <div class='col-sm-3'>
                                        <form novalidate="novalidate" class="simple_form admin" action="/admin/users"
                                            accept-charset="UTF-8" method="post">
                                            <input name="utf8" type="hidden" value="&#x2713;" />
                                            <input type="hidden" name="" value="" />
                                            <select name="user_state" id="user_state"
                                                class="select required form-control select2 filter-banned"
                                                include_blank="true" id="admin_banned">
                                                <option value="" style="color:lightgray">選擇個資是否提交</option>
                                                {{-- <option value="0">尚未提交</option>
                                                    <option value="1">已提交</option> --}}
                                                @foreach($stateArray as $k => $v)
                                                <option value="{{$k}}">{{ $v }}</option>
                                                @endforeach
                                            </select>
                                        </form>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="form-group pull-right">
                                        <div class="col-sm-12">
                                            <button class="btn btn-default reset-button" id="reset">
                                                清空
                                            </button>
                                            <button class="btn btn-info filter-button" id="submit">
                                                查詢
                                            </button>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <a href="{{ route('users_excel.excel') }}" class="btn btn-success">匯出</a> --}}
            <a class="btn btn-info" id="downloadBtn">匯出</a>
            <button type="button" class="btn btn-info lightbox_btn" id="user_discount_fee">匯入會員手續費比例</button>
            {{-- <button class="btn btn-info filter-button">
                        匯出
                    </button> --}}
        </div>

        <div class="an-component-header search_wrapper">

            <div class="m-b-10">
                <div style=" margin-right: 0;  margin-left:0;" class="container">
                    {{-- <h3 style="text-align:center">Import Excel File in Laravel</h3>
                         <br /> --}}
                    @if(count($errors) > 0)
                    <div class="alert alert-danger">
                        上傳內容驗證錯誤<br><br>
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                </div>
                <div class="clear"></div>

            </div>

            <div class="an-component-header search_wrapper">

                <div class="push_lightbox" style="display: none" id="tender_paid">

                    <div class="" style="display: block;width:600px;margin:auto">
                        
                        <form id="import_tenders_form" enctype="multipart/form-data" method="post"
                            action="{{ url('/admin/user_discount_import') }}">
                            {{ csrf_field() }}
                            <div>
                                <div class="modal-content">
                                    <div class="" style="background:#5bb0bd;padding:20px">
                                        <button type="button" class="close"><span
                                                style="font-size:28px">×</span></button>
                                        <h3 class="modal-title">匯入手續費優惠表</h3>
                                    </div>
                                    <div class="modal-body">
                                        <h4>注意</h4>
                                        <ol>
                                            <li>請依照範例擋格式匯入，前一行請勿刪除。</li>
                                        </ol>
                                        <input required="required" type="file" name="select_file" id="">
                                    </div>
                                    <div class="modal-footer" style="text-shadow:none">
                                        <a class="btn btn-info" href="/admin/user_discount_download">下載手續費優惠範例</a>
                                        <input type="submit" name="commit" value="匯入手續費優惠表" class="btn btn-info"
                                            data-disable-with="匯入手續費優惠表">
                                        <button type="button" class="btn btn-info back">返回</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>



            </div>
        </div>

        <div class="panel" style="margin-left: 20px;">
            <label>選擇一頁</label>
            <select onchange="number_page_change()" name="number_page" id="number_page">
                <option value="">請選擇</option>
                <option value="25">25</option>
                <option value="100">100</option>
            </select>
            <label>筆</label>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <button id="btn-show-all-children" type="button" class="btn btn-success">全部展開</button>
                    <button id="btn-hide-all-children" type="button" class="btn btn-danger">全部收合</button>
                    <table id="user_table" class="table table-striped table-advance table-hover">
                        <thead>
                            <tr>
                                <th></th>
                                <th style="cursor: pointer" onclick="change_sort('mn')" >會員編號</th>
                                <th style="cursor: pointer" onclick="change_sort('un')" >姓名</th>
                                <th style="cursor: pointer" onclick="change_sort('icn')" >身分證字號</th>
                                <th style="cursor: pointer" onclick="change_sort('ia')" >警示戶</th>
                                <th style="cursor: pointer" onclick="change_sort('ui')" >會員身份別</th>
                                <th style="cursor: pointer" onclick="change_sort('sp')" >業務專員</th>
                                <th style="cursor: pointer" onclick="change_sort('us')" >個資審核</th>
                                {{-- <th>銀行帳戶審核</th> --}}
                                <th>操作</th>

                            </tr>
                        </thead>
                        <tbody id='users_tbody'>
                            
                        </tbody>
                    </table>
                    <div class="page-icon">
                        <ul class="pagination">
                        </ul>                            
                    </div>
                    <div style="display: none;" id="background">
                        <p style="margin-top:25%;margin-left:50%;color:white;font-size:25px">頁面讀取中</p>
                    </div>
                </section>
            </div>
        </div>
    </section>
</section>

</section>

<script>
    function format(d) {
        return `<tr class ="c_user_detail" id = "user_detail${d.btn.id}">
            <td colspan="9">
            <table  class="table table-bordered" cellpadding="10" cellspacing="0" border="0" style="padding-left:100px;">
            <tr> 
            <td>Email:&nbsp;&nbsp;&nbsp; ${ d.email } </td> 
            <td>登入次數:&nbsp;&nbsp;&nbsp; ${ d.sign_in_count } </td> 
            <td>現在登入狀態開始於:&nbsp;&nbsp;&nbsp; ${ d.current_sign_in_at } </td> 
            </tr> 
            <tr> 
            <td>通訊地址:&nbsp;&nbsp;&nbsp; ${ d.contact_country + d.contact_district + d.contact_address } </td> 
            <td>戶籍地址:&nbsp;&nbsp;&nbsp; ${ d.residence_country + d.residence_district + d.residence_address } </td> 
            <td>電話:&nbsp;&nbsp;&nbsp; ${ d.phone_number } </td> 
            </tr> 
            <tr> 
            <td>出生日期:&nbsp;&nbsp;&nbsp; ${ d.birthday } </td> 
            </tr> 
            </table>
            </td>
            </tr>`;
    }

    function tbody(d) {
        let button = '';
        d.science_professionals = (d.science_professionals==null)?'':d.science_professionals;
        d.member_number = (d.member_number==null)?'':d.member_number;
        d.id_card_number = (d.id_card_number==null)?'':d.id_card_number;
        if(d.btn.banned == '1') { 
            button = `<a target="_blank" href="/admin/users_details/${d.btn.id}" class="btn btn-info"><i style="margin-right: 0px;" class="fa fa-fw fa-eye"></i> </a>&nbsp;
             <button class="btn btn-success delete_btn" type="button"  onclick="banned_cancel(${d.btn.id})">恢復</button>`;
        } else { 
            button = `<a target="_blank" href="/admin/users_details/${d.btn.id}" class="btn btn-info"><i
                                style="margin-right: 0px;" class="fa fa-fw fa-eye"></i> </a>&nbsp;
                        <button class="btn btn-danger delete_btn" type="button"
                            onclick="banned(${d.btn.id})">停權</button>`;
        } 
        return `<tr role="row" class="odd">
                    <td id = "user_button${d.btn.id}" onclick="show_user_detail(${d.btn.id})" class="details-control sorting_1"></td>
                    <td>${d.member_number}</td>
                    <td>${d.user_name}</td>
                    <td>${d.id_card_number}</td>
                    <td>${d.is_alert}</td>
                    <td>${d.user_identity}</td>
                    <td>${d.science_professionals}</td>
                    <td>${d.user_state}</td>
                    <td> `+ button + `
                    </td>
                </tr>
                `;
    }


    $(document).ready(function () {

        let f_data = {};
        $("#background").show();
        $.ajax({
            url: "{{ url('/admin/users/detail') }}",
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:f_data,
            success: function (d) {
                redrawTable(d.data);
                //初始當前頁數
                $("#now_page").val(1);
                //紀錄頁數
                $("#count_page").val(d.page_count);
                //顯示分頁
                $(".pagination").empty();
                let tmp = count_page(d.page_count);
                $(".pagination").append(tmp);
                $(".a_color").css("background-color","#fff");
                $("#a_color1").css("background-color","#EFF0ED");
                $("#background").hide();
                $(".c_user_detail").hide();
            },
            error: function (e) {
                console.log(e);
            }
        });
        
        show_page();
        function show_page(){
            $("#now_page").val(1);
            $(".pagination").empty();
            let tmp = count_page($("#count_page").val());
            $(".pagination").append(tmp);
            $(".a_color").css("background-color","#fff");
            $("#a_color1").css("background-color","#EFF0ED");
        }
        
        //計算換頁分頁
        function count_page(count){
            //當前頁數
            let now_page = parseInt($("#now_page").val());
            let t = `<li><a class="a_color-1" onclick = "back_page()" href="#">&laquo;上一頁</a></li>
                                    <li onclick ="change_page(1)"><a class="a_color" id="a_color1" href="#">1</a></li>`;
            if(count>10){
                //當前頁數小於等於4
                if(now_page<4){
                    for(let x=2 ; x <= 4; x++){
                        t+=`<li onclick = "change_page(${x})"><a class="a_color" id="a_color${x}" href="#">`+x+`</a></li>`;
                    }
                    t+=`<li><a href="#">....</a></li>`;
                    for(let y=count-4 ; y <= count; y++){
                        t+=`<li onclick = "change_page(${y})"><a class="a_color" id="a_color${y}" href="#">`+y+`</a></li>`;
                    }
                }else if(now_page>=count-4){
                    t+=`<li><a href="#">....</a></li>`;
                    for( let x=count-5 ; x <= count; x++){
                        t+=`<li onclick = "change_page(${x})"><a class="a_color" id="a_color${x}" href="#">`+x+`</a></li>`;
                    }
                }else{
                    let x1 = now_page-2;
                    let x2 = now_page+2;
                    t+=`<li><a href="#">....</a></li>`;
                    for( let x=x1 ; x <= x2; x++){
                        t+=`<li onclick = "change_page(${x})"><a class="a_color" id="a_color${x}" href="#">`+x+`</a></li>`;
                    }
                    t+=`<li><a href="#">....</a></li>`;
                    
                    t+=`<li onclick = "change_page(${count})"><a href="#">`+count+`</a></li>`;
                    
                }
            }else if(count>=2){
                for(let x=2 ; x <= count; x++){
                    t+=`<li onclick = "change_page(${x})"><a href="#" class="a_color" id="a_color${x}" >`+x+`</a></li>`;
                }
            }                    
            
            t+=`<li><a class="a_color-2" onclick = "next_page()" href="#">下一頁&raquo;</a></li>`;
            return t;
        }
        
        //重畫Table
        function redrawTable(obj){
            $("#users_tbody").empty();
            let tmp = '';
            $.each(obj,function(k,v){
                tmp += tbody(v)+format(v);
            })
            $("#users_tbody").append(tmp);
        }
        


        // $('#user_table  tbody').on('click', 'td.details-control', function () {
        //     var tr = $(this).closest('tr');
        //     var row = table.row(tr);

        //     if (row.child.isShown()) {
        //         row.child.hide();
        //         tr.removeClass('shown');
        //     } else {
        //         // Open this row
        //         row.child(format(row.data())).show();
        //         tr.addClass('shown');
        //     }
        // });
        $('#btn-show-all-children').on('click', function () {

            $(".details-control").attr('class', 'details-control-red sorting_1');

            $(".c_user_detail").show();
        });


        $('#btn-hide-all-children').on('click', function () {

            $(".details-control-red").attr('class', 'details-control sorting_1');

            $(".c_user_detail").hide();
        });
    });

    function show_user_detail(c){

        var user_detail = document.getElementById('user_detail'+c);
        
        if (user_detail.style.display == 'none') {
            user_detail.style.display = '';
            $("#user_button"+c).attr('class', 'details-control-red sorting_1');
        } else {
            user_detail.style.display = 'none';
            $("#user_button"+c).attr('class', 'details-control sorting_1');
        }

    }   


      
    //上一頁
    function back_page(){
        let now_page =  parseInt($("#now_page").val());
        if(now_page == 1){
            $(".a_color-1").css("background-color","#fff");
        }else{
            change_page(now_page-1);
        }
    }
    //下一頁
    function next_page(){
        let now_page =  parseInt($("#now_page").val());
        let count_page = parseInt($("#count_page").val());
        if(now_page == count_page){
            $(".a_color-2").css("background-color","#fff");
        }else{
            change_page(now_page+1);
        }
    }
    //單頁更換
    function change_page(c){
        $("#background").show();
        let data = getFliterData(c);
        $.ajax({
            url: "{{ url('/admin/users/search') }}",
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,
            success: function (d) {
                redrawTable(d.data);
                //初始當前頁數
                $("#now_page").val("");
                $("#now_page").val(c);
                //紀錄當前頁數
                $("#count_page").val(d.count);
                //顯示分頁
                $(".pagination").empty();
                let tmp = count_page2(d.count);
                $(".pagination").append(tmp);
                $(".a_color").css("background-color","#fff");
                $("#a_color"+c+"").css("background-color","#EFF0ED");
                $("#background").hide();
                $(".c_user_detail").hide();
            },
            error: function (e) {
                console.log(e);
            }
        });
    }

    //重畫Table
    function redrawTable(obj){
        $("#users_tbody").empty();
        let tmp = '';
        $.each(obj,function(k,v){
            tmp += tbody(v)+format(v);
        })
        $("#users_tbody").append(tmp);
    }

    
     //計算換頁分頁
     function count_page2(count){
        //當前頁數
        let now_page = parseInt($("#now_page").val());
        let t = `<li><a class="a_color-1" onclick = "back_page()" href="#">&laquo;上一頁</a></li>
                                <li onclick ="change_page(1)"><a class="a_color" id="a_color1" href="#">1</a></li>`;
        if(count>10){
            //當前頁數小於等於4
            if(now_page<4){
                for(let x=2 ; x <= 4; x++){
                    t+=`<li onclick = "change_page(${x})"><a class="a_color" id="a_color${x}" href="#">`+x+`</a></li>`;
                }
                t+=`<li><a href="#">....</a></li>`;
                for(let y=count-4 ; y <= count; y++){
                    t+=`<li onclick = "change_page(${y})"><a class="a_color" id="a_color${y}" href="#">`+y+`</a></li>`;
                }
            }else if(now_page>=count-4){
                t+=`<li><a href="#">....</a></li>`;
                for( let x=count-5 ; x <= count; x++){
                    t+=`<li onclick = "change_page(${x})"><a class="a_color" id="a_color${x}" href="#">`+x+`</a></li>`;
                }
            }else{
                let x1 = now_page-2;
                let x2 = now_page+2;
                t+=`<li><a href="#">....</a></li>`;
                for( let x=x1 ; x <= x2; x++){
                    t+=`<li onclick = "change_page(${x})"><a class="a_color" id="a_color${x}" href="#">`+x+`</a></li>`;
                }
                t+=`<li><a href="#">....</a></li>`;
                
                t+=`<li onclick = "change_page(${count})"><a href="#">`+count+`</a></li>`;
                
            }
        }else if(count>=2){
            for(let x=2 ; x <= count; x++){
                t+=`<li onclick = "change_page(${x})"><a href="#" class="a_color" id="a_color${x}" >`+x+`</a></li>`;
            }
        }                    
        
        t+=`<li><a class="a_color-2" onclick = "next_page()" href="#">下一頁&raquo;</a></li>`;
        return t;
    }

    $("#submit").click(function () {
        $("#background").show();
        let data = getFliterData(1);
        $.ajax({
            url: "{{ url('/admin/users/search') }}",
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,
            success: function (d) {
                redrawTable(d.data);
                //初始當前頁數
                $("#now_page").val(1);
                //紀錄頁數
                $("#count_page").val(d.count);
                //顯示分頁
                $(".pagination").empty();
                let tmp = count_page2(d.count);
                $(".pagination").append(tmp);
                $(".a_color").css("background-color","#fff");
                $("#a_color1").css("background-color","#EFF0ED");
                $("#background").hide();
                $(".c_user_detail").hide();
            },
            error: function (e) {
                console.log(e);
            }
        })

    });

    //變換排序
    function change_sort(th){
        let sequence = $("#sequence").val();
        $("#background").show();
        
        //三種排序欄位
        if(th == "mn"){
            //三種排序可能前置條件
            if(sequence != 1 && sequence != -1){
                $("#sequence").val(1);

            }else if(sequence == 1){
                $("#sequence").val(-1);

            }else if(sequence == -1){
                $("#sequence").val(1);

            }   
        }else if(th == "un"){
            if(sequence != 2 && sequence != -2){
                $("#sequence").val(2);

            }else if(sequence == 2){
                $("#sequence").val(-2);

            }else if(sequence == -2){
                $("#sequence").val(2);

            }    
        }else if(th == "icn"){
            if(sequence != 3 && sequence != -3){
                $("#sequence").val(3);

            }else if(sequence == 3){
                $("#sequence").val(-3);

            }else if(sequence == -3){
                $("#sequence").val(3);

            }   
        }else if(th == "ia"){
            if(sequence != 4 && sequence != -4){
                $("#sequence").val(4);

            }else if(sequence == 4){
                $("#sequence").val(-4);

            }else if(sequence == -4){
                $("#sequence").val(4);

            }   
        }else if(th == "ui"){
            if(sequence != 5 && sequence != -5){
                $("#sequence").val(5);

            }else if(sequence == 5){
                $("#sequence").val(-5);

            }else if(sequence == -5){
                $("#sequence").val(5);

            }   
        }else if(th == "sp"){
            if(sequence != 6 && sequence != -6){
                $("#sequence").val(6);

            }else if(sequence == 6){
                $("#sequence").val(-6);

            }else if(sequence == -6){
                $("#sequence").val(6);

            }   
        }else if(th == "us"){
            if(sequence != 7 && sequence != -7){
                $("#sequence").val(7);

            }else if(sequence == 7){
                $("#sequence").val(-7);

            }else if(sequence == -7){
                $("#sequence").val(7);

            }   
        }
        let now_page = $("#now_page").val();
        let data = getFliterData($("#now_page").val());

        $.ajax({
            url: "{{ url('/admin/users/search') }}",
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,
            success: function (d) {
                redrawTable(d.data);
                //紀錄當前頁數
                $("#count_page").val(d.count);
                //顯示分頁
                $(".pagination").empty();
                let tmp = count_page2(d.count);
                $(".pagination").append(tmp);
                $(".a_color").css("background-color","#fff");
                $("#a_color"+now_page+"").css("background-color","#EFF0ED");
                $("#background").hide();
                $(".c_user_detail").hide();
            },
            error: function (e) {
                console.log(e);
            }
        });
    }
    function number_page_change(){
        $("#background").show();
        let now_page = $("#now_page").val();
        let data = getFliterData($("#now_page").val());
        $.ajax({
            url: "{{ url('/admin/users/search') }}",
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,
            success: function (d) {
                redrawTable(d.data);
                //紀錄當前頁數
                $("#count_page").val(d.count);
                //顯示分頁
                $(".pagination").empty();
                let tmp = count_page2(d.count);
                $(".pagination").append(tmp);
                $(".a_color").css("background-color","#fff");
                $("#a_color"+now_page+"").css("background-color","#EFF0ED");
                $("#background").hide();
                $(".c_user_detail").hide();
                if($("#now_page").val() > $("#count_page").val()){$("#now_page").val(d.count);number_page_change()}
            },
            error: function (e) {
                console.log(e);
            }
        });
    }

    $("#downloadBtn").click(function () {
        let query = getFliterData();
        console.log(query);
        let url = "{{ url('/admin/users/search/yes') }}" + "?" + $.param(query);
        // var url = "{{URL::to('downloadExcel_location_details')}}?" + $.param(query)
        window.location = url;

    })
    //取篩選值
    function getFliterData(c) {
        let sequence = $("#sequence").val();
        let number_page = $("#number_page").val();
        let page = c;
        let company_name_search = $("#company_name_search").val();
        let user_name = $("#user_name_search").val();
        let id_card_number = $("#id_card_number_search").val();
        let phone_number = $('#phone_number_search').val();
        let member_number = $('#user_id_search').val();
        let banned = $('#banned_search').val();
        let is_alert = $('#is_alert_search').val();
        let is_user_id_check = $('#is_user_id_check_search').val();
        let user_state = $('#user_state').val();
        let science_professionals = $('#science_professionals').val();
        let user_identity = $('#user_identity').val();

        let data = {
            user_name: user_name,
            id_card_number: id_card_number,
            phone_number: phone_number,
            member_number: member_number,
            banned: banned,
            is_alert: is_alert,
            is_user_id_check: is_user_id_check,
            user_state: user_state,
            science_professionals: science_professionals,
            user_identity: user_identity,
            sequence:sequence,
            number_page:number_page,
            page:page,
            company_name:company_name_search
        }
        return data;
    }

    $(function () {
        $('#reset').click(function () {
            $("#user_name_search").val("");
            $("#id_card_number_search").val("");
            $('#phone_number_search').val("");
            $('#user_id_search').val("");
            $('#banned_search').val("");
            $('#is_alert_search').val("");
            $('#is_user_id_check_search').val("");
            $('#user_state').val("");
            $('#science_professionals').val("");
            $('#user_identity').val("");
        });
    });




    function banned(target) {
        if (window.confirm('你確定要停權此會員?')) {
            $.ajax({
                type: "POST",
                url: "/admin/users_banned",
                dataType: "json",
                data: {
                    id: target,
                },
                success: function (data) {
                    if (data.success) {
                        alert("已停權此會員");
                        location.reload();
                    }
                }
            });
        }

    }

    function banned_cancel(target) {
        if (window.confirm('你確定要恢復此會員權限?')) {
            $.ajax({
                type: "POST",
                url: "/admin/users_banned",
                dataType: "json",
                data: {
                    id: target,
                },
                success: function (data) {
                    if (data.success) {
                        alert("成功恢復使用者權限");
                        location.reload();
                    }
                }
            });
        }

    }

    $('.close,.back').click(function () {
        $('.push_lightbox').fadeOut();
    })

    $('#user_discount_fee').click(function () {
        $('.push_lightbox').fadeIn();
    })
</script>





@endsection