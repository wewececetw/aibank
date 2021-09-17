@extends('Back_End.layout.header')

@section('content')
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">編輯智能媒合設定</h3>
          </div>
        </div>

        <div class="col-md-12">
            <div style="border:solid 1px #1a2732">
                <div style="padding:10px;background-color:#394a59;">
                    <h4 style="color:white;">智能媒合設定</h4>
                </div>
            <div class="panel-body">
                <form class="simple_form new_match_performance" id="new_match_performance" enctype="multipart/form-data" action='{{ url("/admin/roi_settings/update/$roi_settings->roi_settings_id") }}' method="post">
                    @csrf

                    <div class="row m-b-15">
                        <div class='col-sm-12'>
                            <label for="exampleFormControlTextarea1">名稱</label>
                        <input type="text" class="form-control" name="roi_settings[name]" value="{{ $roi_settings->name }}">
                        </div>
                    </div>

                    <div class="row m-b-15">
                        <div class='col-sm-12'>
                            <label for="exampleFormControlTextarea1">說明</label>
                            <textarea class="form-control" name="roi_settings[description]" rows="3">{{ $roi_settings->description }}</textarea>
                        </div>
                    </div>

                    <div class="col-sm-12" style="margin-top:40px;">
                        <a href="{{ url('/admin/roi_settings') }}" class="btn btn-info pull-right m-r-5">返回</a>
                        <button type="submit" class="btn btn-info pull-right m-r-5">儲存</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

      </section>
    </section>

</section>


@endsection
