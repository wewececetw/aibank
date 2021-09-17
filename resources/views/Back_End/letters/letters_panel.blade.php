@extends('Back_End.layout.header')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>


<style>
    td {
        word-break: break-all !important;
    }
    .c3-axis-y > .tick{
    fill: none;                // removes axis labels from y axis
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
                    <h3 class="page-header">站內信列表</h3>
                </div>
            </div>

            <div class="an-single-component with-shadow">
                <div class="an-component-header search_wrapper">
                    <div class="panel panel-default an-sidebar-search">
                        <div class="collapsed panel-heading"  data-toggle="collapse" href="#search_panel" style="cursor:pointer;">
                            <h4 class="panel-title">
                                篩選條件
                            </h4>
                        </div>
                        <div id="search_panel" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                            <div class="panel-body">
                                
                                    @csrf
                                    <div class="row">
                                        <div class='form-group'>
                                            <div class="col-sm-2">
                                                <label class='control-label'>標題</label>
                                            </div>
                                            <div class='col-sm-10'>
                                                <input type="hidden" id="now_page">
                                                <input type="hidden" id="count_page">
                                                <input type="hidden" id="sequence">
                                                <input type='text' name='content' id="title_search" placeholder='請輸入標題' class='an-form-control no-redius border-bottom'>
                                            </div>
                                            <div class='clear'></div>
                                        </div>
                                    </div>
{{-- 
                                    <div class="row">
                                        <div class='form-group'>
                                            <div class="col-sm-2">
                                                <label class='control-label'>內容</label>
                                            </div>
                                            <div class='col-sm-10'>
                                                <input type='text' name='content' id="content_search" placeholder='請輸入內容' class='an-form-control no-redius border-bottom '>
                                            </div>
                                            <div class='clear'></div>
                                        </div>
                                    </div> --}}

                                    <div class="row" id="email_div" style="display: none">
                                        <div class='form-group'>
                                            <div class="col-sm-2">
                                                <label class='control-label'>email</label>
                                            </div>
                                            <div class='col-sm-10'>
                                                <input type='text' name='email' id="email_search" placeholder='請輸入信箱' class='an-form-control no-redius border-bottom '>
                                            </div>
                                            <div class='clear'></div>
                                        </div>
                                    </div>

                                    <div class="row form-group">

                                        <label class='col-sm-3 control-label l-h-34'>選擇身份別</label>
                                        <div class='col-sm-3'>
                                            <select name="banned" 
                                                class="select required form-control select2 filter-banned"
                                                include_blank="true" id="id_search" >
                                                <option value="" style="color:lightgray">ALL</option>
                                                @foreach($identityArray as $k => $v)
                                                    <option value="{{$k}}">{{ $v }}</option>
                                                @endforeach
                                                <option value="4">單一使用者</option>
                                            </select>
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
                                     
                                
                            </div>
                        </div>
                    </div>
                </div>
                   
            </div>

            <div class="row">
                
                <div class="col-lg-12">
                    <a href="/admin/internal_letters_create" style="margin-bottom:10px; margin-left: 23px;"  class="btn btn-info">新增站內信</a>
                    <form action ="{{url('/andmin/internal_letters_send')}}" method="POST">
                        {{ csrf_field()}}
                        
                    </form>
                    <section class="panel">
                        <table id="letter_table" class="table table-striped table-advance table-hover">

                            <thead>
                                <tr>
                                    <th style="cursor: pointer" onclick="change_sort('e')" >email</th>
                                    <th style="cursor: pointer" onclick="change_sort('t')" >標題</th>
                                    {{-- <th>內容</th> --}}
                                    <th style="cursor: pointer" onclick="change_sort('s_t')" >發送時間</th>
                                    <th style="width:20%">操作</th>
                                </tr>
                            </thead>

                            <tbody id='mail_tbody'>
                                @forelse($datasets as $dataset)
                                <tr>
                                    <td>{{$row_data[$dataset->user_ids]}}</td>
                                    <td>{{$dataset->title}}</td>
                                    {{-- <td>//echo "$dataset->content"?></td> --}}
                                    <td>{{$dataset->created_at}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="btn btn-info" href="/admin/internal_letters_details/{{$dataset->internal_letter_id}}"><i class="fa fa-eye"></i></a>
                                            <button class="btn btn-danger" name="changeValue" onClick="isDisplay_letter({{$dataset->internal_letter_id}})" ><i class="fa fa-trash-o"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4"><span class="fbold">--無相關資料符合--</span></td>
                                </tr>    
                                @endforelse
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

$(document).ready( function () {
    // $('#letter_table').DataTable({
    //     sDom: 'lrtip',
    //     iDisplayLength: 8,
    //     responsive: true,
    //     "autoWidth": false,
    //     searching: true,
    //     paging: true,
    //     info: false,
    //     order: [3, "asc"],
    //     "language": {
    //                     "emptyTable": "------無相關資料符合------"
    //                 }
    // });
    //顯示分頁
    show_page();
    function show_page(){
        $("#now_page").val(1);
        $(".pagination").empty();
        let count = {{$page_count}};
        $("#count_page").val(count);
        let tmp = count_page(count);
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
    $("#submit").click(function(){
            $("#background").show();
            let sequence = $("#sequence").val();
            let title = $("#title_search").val();
            // let content = $("#content_search").val();
            let email = $("#email_search").val();
            let id_search = $("#id_search").val();
            if (id_search == 4){id_search=null;}
            let data = {
            title:title,
            // content:content,
            email:email,
            id_search:id_search,
            sequence:sequence
            }
            $.ajax({
            url:"{{ url('/admin/internal_letters/search') }}",
            type: 'post',
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:data,
            success: function(d){
                redrawTable(d.data);
                //初始當前頁數
                $("#now_page").val(1);
                //紀錄頁數
                $("#count_page").val(d.count);
                //顯示分頁
                $(".pagination").empty();
                let tmp = count_page(d.count);
                $(".pagination").append(tmp);
                $(".a_color").css("background-color","#fff");
                $("#a_color1").css("background-color","#EFF0ED");
                $("#background").hide();
            },
            error: function(e){
                console.log(e);
            }
            })
});


        //重畫Table
        function redrawTable(obj){
            $("#mail_tbody").empty();
            let tmp = '';
            $.each(obj,function(k,v){
                tmp += trTemp(v);
            })
            $("#mail_tbody").append(tmp);
        }

        //TR 的模板
        function trTemp(d){
            let t = `
            <tr>
                <td>${d.email}</td>
                <td>${d.title}</td>
                <td>${d.created_at}</td>
                <td>
                    ${d.button}
                </td>
            </tr>
            `
            return t;
        }

        //選擇單一信件時顯示input其餘選項清空值並隱藏
        $("#id_search").change(function() {
            let id_search = $("#id_search").val();
            if(id_search == 4){
                $("#email_div").show();
            }else{
                $("#email_div").hide();
                $("#email_search").val("");
            }
        });
        

    });

$(function(){  
    $('#reset').click(function(){  
        $("#title_search").val("");
        // $("#content_search").val("");
        $("#id_search")
    });   
    });    

    // function delete_letter(target){
    //     if(window.confirm('你確定要刪除嗎?')){
    //         $.ajax({
    //         type:"POST",
    //         url:'/admin/internal_letters_delete/'+target,
    //         dataType:"json",
    //         data:{
    //             id:target,
    //         },
    //             success:function(data){
    //                 if(data.success){
    //                     alert("刪除成功");
    //                     location.reload();
    //                 }
    //             }
    //         });
    //     }
        
    // }
    function isDisplay_letter(target){
        if(window.confirm('你確定要刪除嗎?')){
            $.ajax({
            type:"POST",
            url:'/admin/internal_letters_display',
            dataType:"json",
            data:{
                id:target,
            },
                success:function(data){
                    if(data.success){
                        alert("刪除成功");
                        location.reload();
                    }
                }
            });
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
        let sequence = $("#sequence").val();
        let page = c;
        let title = $("#title_search").val();
        // let content = $("#content_search").val();
        let email = $("#email_search").val();
        let id_search = $("#id_search").val();
        if (id_search == 4){id_search=null;}
        let data = {
        title:title,
        // content:content,
        email:email,
        id_search:id_search,
        page:page,
        sequence:sequence
        }
        $.ajax({
        url:"{{ url('/admin/internal_letters/search') }}",
        type: 'post',
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data:data,
        success: function(d){
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
            },
            error: function(e){
                console.log(e);
            }
        })

    }
    //重畫Table
    function redrawTable(obj){
                $("#mail_tbody").empty();
                let tmp = '';
                $.each(obj,function(k,v){
                    tmp += trTemp(v);
                })
                $("#mail_tbody").append(tmp);
    }

    //TR 的模板
    function trTemp(d){
        let t = `
        <tr>
            <td>${d.email}</td>
            <td>${d.title}</td>
            <td>${d.created_at}</td>
            <td>
                ${d.button}
            </td>
        </tr>
        `
        return t;
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
    //變換排序
    function change_sort(th){
        let sequence = $("#sequence").val();
        $("#background").show();
        //三種排序欄位
        if(th == "e"){
            //三種排序可能前置條件
            if(sequence == '' || sequence == 2 || sequence == -2 || sequence == 3 || sequence == -3 ){
                $("#sequence").val(1);

            }else if(sequence == 1){
                $("#sequence").val(-1);

            }else if(sequence == -1){
                $("#sequence").val(1);

            }   
        }else if(th == "t"){
            if(sequence == '' || sequence == 1 || sequence == -1 || sequence == 3 || sequence == -3){
                $("#sequence").val(2);

            }else if(sequence == 2){
                $("#sequence").val(-2);

            }else if(sequence == -2){
                $("#sequence").val(2);

            }    
        }else if(th == "s_t"){
            if(sequence == '' || sequence == 2 || sequence == -2 || sequence == 1 || sequence == -1){
                $("#sequence").val(3);

            }else if(sequence == 3){
                $("#sequence").val(-3);

            }else if(sequence == -3){
                $("#sequence").val(3);

            }   
        }
        let sequence2 = $("#sequence").val();
        let now_page = $("#now_page").val();
        let title = $("#title_search").val();
        // let content = $("#content_search").val();
        let email = $("#email_search").val();
        let id_search = $("#id_search").val();
        if (id_search == 4){id_search=null;}
        let data = {
        title:title,
        // content:content,
        email:email,
        id_search:id_search,
        page:now_page,
        sequence:sequence2
        }
        $.ajax({
        url:"{{ url('/admin/internal_letters/search') }}",
        type: 'post',
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data:data,
        success: function(d){
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
            },
            error: function(e){
                console.log(e);
            }
        })

    }




</script>



@endsection        