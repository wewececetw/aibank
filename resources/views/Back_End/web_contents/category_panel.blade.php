@extends('Back_End.layout.header')

@section('content')


    <section id="main-content">
      <section class="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">選擇編輯頁面</h3>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                  <section class="panel">
                        <table id="customer" class="table table-striped table-advance table-hover">
                            <thead>
                                <tr>
                                <th style="width:70%">名稱</th>
                                <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        首頁　Banner
                                    </td>

                                    <td>
                                        <div class="btn-group">
                                            <a class="btn btn-success" href="{{ url('/web_contents/IndexBanner/contents') }}"><i class="fa fa-pencil"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        財經專欄　文案
                                    </td>

                                    <td>
                                        <div class="btn-group">
                                            <a class="btn btn-success" href="{{ url('/web_contents/financial/contents') }}"><i class="fa fa-pencil"></i></a>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        最新消息　文案
                                    </td>

                                    <td>
                                        <div class="btn-group">
                                            <a class="btn btn-success" href="{{url('/web_contents/news')}}"><i class="fa fa-pencil"></i></a>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        團隊成員
                                    </td>

                                    <td>
                                        <div class="btn-group">
                                            <a class="btn btn-success" href="{{ url('/web_contents/team/contents') }}"><i class="fa fa-pencil"></i></a>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        常見問題　文案
                                    </td>

                                    <td>
                                        <div class="btn-group">
                                            <a class="btn btn-success" href="{{ url('/web_contents/qa/contents') }}"><i class="fa fa-pencil"></i></a>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                  </section>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">

                        <table id="customer" class="table table-striped table-advance table-hover">
                            <thead>
                                <tr>
                                <th style="width:70%">名稱</th>
                                <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        違約率表格
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="btn btn-success" href="{{ url('/web_contents/defaultRate/contents') }}"><i class="fa fa-pencil"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </section>
                </div>
            </div>

      </section>
    </section>

  </section>




@endsection
