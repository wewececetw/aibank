@extends('Back_End.layout.header')

@section('content')

    <section id="main-content">
      <section class="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">最新消息列表</h3>
                    <a class="btn btn-info" href="{{  url('/news/insert') }}" style="margin-bottom:10px">新增</a>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">

                        <table id="user_table" class="table table-striped table-advance table-hover">
                            <thead>
                                <tr>
                                    <th>名稱</th>
                                    <th>狀態</th>
                                    <th>排序</th>
                                    <th>簡介</th>
                                    <th>操作</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($news as $row)
                                    <tr>
                                        <td>{{  $row->name  }}</td>
                                        <td>{{  $row->is_active  }}</td>
                                        <td>{{  $row->sort  }}</td>
                                        <td>{{ $row->remark }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a class="btn btn-info" href="{{ url('/news/edit/'.$row->web_contents_id) }}"><i class="fa fa-eye"></i></a>
                                                <a class="btn btn-danger" onclick="delete_news({{ $row->web_contents_id }});"><i class="fa fa-trash-o"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                
                            </tbody>

                        </table>

                    </section>
                </div>
            </div>

      </section>
    </section>

  </section>



<script>

function delete_news(target){

    // swal({
    //     title: "Are you sure?",
    //     text: "You will not be able to recover this imaginary file!",
    //     type: "warning",
    //     showCancelButton: true,
    //     confirmButtonColor: "#DD6B55",
    //     confirmButtonText: "Yes, delete it!",
    //     cancelButtonText: "No, cancel plx!",
    //     closeOnConfirm: false,
    //     closeOnCancel: false
    // },
    // function(isConfirm){
    //     if (isConfirm) {
    //         swal("Deleted!", "Your imaginary file has been deleted.", "success");
    //     } else {
    //         swal("Cancelled", "Your imaginary file is safe :)", "error");
    //     }
    // });

    if(window.confirm('你確定要刪除嗎?')){
        $.ajax({
            type:"POST",
            url:"{{ url('/news/delete') }}"+'/'+target,
            dataType:"json",
            data:{
                    id:target,
            },
            success:function(data){
                if(data.success){
                    swal ("刪除成功");
                    location.reload();
                }
            }
        });
    }
    
}

</script>





@endsection
