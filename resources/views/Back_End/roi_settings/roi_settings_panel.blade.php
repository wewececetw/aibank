@extends('Back_End.layout.header')

@section('content')


<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">智能媒合設定列表</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <table id="customer" class="table table-striped table-advance table-hover">
                        <thead>
                            <tr>
                                <th style="width:30%;">名稱</th>
                                <th>說明</th>
                                <th>編輯</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $d)
                            <tr>
                                <td>
                                    {{ $d->name }}
                                </td>
                                <td>
                                    {{ $d->description }}
                                </td>
                                <td>
                                    <a class="btn btn-success"
                                        href="/admin/roi_settings/edit/{{ $d->roi_settings_id }}"><i
                                            class="fa fa-pencil"></i></a>
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


@if(isset($updateSuccess))
<script>
    swal('提示','更新成功','success');
</script>
@elseif(isset($updateFail))
<script>
    swal('提示','更新失敗','error');
</script>
@endif

@endsection
