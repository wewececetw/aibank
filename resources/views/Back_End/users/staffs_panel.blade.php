@extends('Back_End.layout.header')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
<style>
    td.details-control {
        background: url(https://datatables.net/examples/resources/details_open.png) no-repeat center center;
        cursor: pointer;
}
    tr.shown td.details-control {
        background: url(https://datatables.net/examples/resources/details_close.png) no-repeat center center;
    }
    
    td {
        word-break: break-all !important;
    }
    .c3-axis-y > .tick{
fill: none;                // removes axis labels from y axis
}
</style>
    <section id="main-content">
      <section class="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">員工列表</h3>
                </div>
            </div>

            <a href="/admin/staffs_create" class="btn btn-info filter-button">
                新增員工
            </a>
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
                                {{-- <form class="form-group" id="insert_product_form"> --}}
                                    @csrf
                                    <div class="row">
                                        <div class="form-group">

                                          <label class='col-sm-2 control-label l-h-34'>工號</label>
                                          <div class="col-sm-4">
                                            <input type='text' name='member_number' id="member_number_search" placeholder='請輸入工號' class='an-form-control no-redius border-bottom m-0 text_color filter-id_number'>
                                          </div>

                                          <label class='col-sm-2 control-label l-h-34'>姓名</label>
                                          <div class="col-sm-4">
                                            <input type='text' name='user_name' id="user_name_search" placeholder='請輸入姓名' class='an-form-control no-redius border-bottom m-0 text_color filter-id_number'>
                                          </div>

                                          <div class="clear"></div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group">

                                          <label class='col-sm-2 control-label l-h-34'>Email</label>
                                          <div class="col-sm-4">
                                            <input type='text' name='email' id="email_search" placeholder='請輸入Email' class='an-form-control no-redius border-bottom m-0 text_color filter-id_number'>
                                          </div>

                                          <label class='col-sm-2 control-label l-h-34'>電話</label>
                                          <div class="col-sm-4">
                                            <input type='text' name='phone_number' id="phone_number_search" placeholder='請輸入電話' class='an-form-control no-redius border-bottom m-0 text_color filter-id_number'>
                                          </div>

                                          <div class="clear"></div>
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
                    <section class="panel">
                        <button id="btn-show-all-children" type="button" class="btn btn-success">全部展開</button>
                        <button id="btn-hide-all-children" type="button" class="btn btn-danger">全部收合</button>
                        <table id="staff_table" class="table table-striped table-advance table-hover">

                            <thead>
                                <tr>
                                    <th></th>
                                    <th>工號</th>
                                    <th>姓名</th>
                                    <th>Email</th>
                                    <th>電話</th>
                                    <th>操作</th>
                                </tr>
                            </thead>

                            {{-- <tbody>
                                @foreach($datasets as $dataset)
                                <tr>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn_toogle" name="changeValue" onclick="toggle_list(this)" ><i class="fa fa-plus"></i></button>
                                        </div>
                                        g
                                    </td>
                                    <td>{{$dataset->member_number}}</td>
                                    <td>{{$dataset->user_name}}</td>
                                    <td>{{$dataset->email}}</td>
                                    <td>{{$dataset->phone_number}}</td>
                                    

                                    <td>
                                        <div class="btn-group">
                                            <a class="btn btn-success" href="/admin/staffs_edit"><i class="fa fa-pencil"></i></a>
                                            <button class="btn btn-danger" name="changeValue" onClick="#" ><i class="fa fa-trash-o"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr class="detail_list" style="display:none">
                                    <td colspan="10">
                                        <table class="table table-bordered table-striped table-hover">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>登入次數</th>
                                                    <th>上次登入於</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <td>{{$dataset->sign_in_count}}</td>
                                                    <td>{{$dataset->last_sign_in_at}}</td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody> --}}
                            
                        </table>

                    </section>
                </div>
            </div>
      </section>
    </section>

  </section>

  <script>

    function toggle_list(btn){
        $(btn).closest('tr').next('.detail_list').toggle();
    
    }
    $.ajax()
    
    
    function format (d) {
    return '<table cellpadding="10" cellspacing="0" border="0" style="padding-left:100px;">'+
        '<tr>'+
            '<td>登入次數:</td>'+
            '<td>'+d.sign_in_count+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>上次登入於:</td>'+
            '<td>'+d.last_sign_in_at+'</td>'+
        '</tr>'+
        '</table>';
    }


    $(document).ready( function () {
    $.fn.dataTable.ext.errMode = () => console.log();
    var table = $('#staff_table').DataTable({
        ajax: "{{ url('/admin/staffs/detail') }}",
        sDom: 'lrtip',
        iDisplayLength: 8,
        responsive: true,
        "autoWidth": false,
        searching: true,
        paging: true,
        info: false,
        order: [0, "asc"],
        "language": {
                      "emptyTable": "------無相關資料符合------"
                    },
        columns : [
      {
        className      : 'details-control',
        defaultContent : '',
        data           : null,
        orderable      : false
      },
        { "data": "member_number" },
        { "data": "user_name" },
        { "data": "email" },
        { "data": "phone_number" },
        // { "data": "id_back_content_type" },
        {"mData": "user_id",
         "mRender":function (data){
             return `<a href="/admin/staffs_edit/${data}" class="btn btn-info"><i style="margin-right: 0px;" class="fa fa-fw fa-eye"></i> </a>
             <button class="btn btn-danger" name="changeValue" onClick="delete_letter(${data})" ><i class="fa fa-trash-o"></i></button>`
         }},
        
    ],
    });

    $('#staff_table  tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } );
    $('#btn-show-all-children').on('click', function(){
            
            table.rows().every(function(){
                
                if(!this.child.isShown()){
                    
                    this.child(format(this.data())).show();
                    $(this.node()).addClass('shown');
                }
            });
        });

    
    $('#btn-hide-all-children').on('click', function(){
        
        table.rows().every(function(){
            
            if(this.child.isShown()){
                
                this.child.hide();
                $(this.node()).removeClass('shown');
            }
        });
    });
} );


    $("#submit").click(function(){
          let member_number = $("#member_number_search").val();
          let user_name = $("#user_name_search").val();
          let email = $("#email_search").val();
          let phone_number = $('#phone_number_search').val();
          let data = {
            member_number:member_number,
            user_name:user_name,
            email:email,
            phone_number:phone_number,
          }
          $.ajax({
            url:"{{ url('/admin/staffs/search') }}",
            type: 'post',
            headers:{
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:data,
            success: function(d){
              var table = $("#staff_table").DataTable();
              table.clear().rows.add(d).draw();
            },
            error: function(e){
              console.log(e);
            }
          })
});

// function isDisplay_letter(target){
//         if(window.confirm('你確定要刪除嗎?')){
//             $.ajax({
//             type:"POST",
//             url:'/admin/staffs_display',
//             dataType:"json",
//             data:{
//                 id:target,
//             },
//                 success:function(data){
//                     if(data.success){
//                         alert("刪除成功");
//                         location.reload();
//                     }
//                 }
//             });
//         }
        
//     }
function delete_letter(target){
        if(window.confirm('你確定要刪除嗎?')){
            $.ajax({
            type:"POST",
            url:'/admin/staffs_delete/'+target,
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


$(function(){  
   $('#reset').click(function(){  
    $("#member_number_search").val(""); 
    $("#user_name_search").val("");
    $("#email_search").val("");
    $('#phone_number_search').val("");
   });   
 });
 



</script>



@endsection        