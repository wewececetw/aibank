@extends('Front_End.layout.header')

@section('content')


<div class="tender_banner">
    <div class="container">
      <div class="row">
      </div>
    </div>
  </div>
  <div class="tender_link">
    <div class="container">
      <div class="row">
        <div class="li_more ">
          <a href="#" onclick="javascript:history.back(-1);">
            <img src="{{ asset('/images/arrow-alt-left.svg') }}" width="17px;" 
            style="margin-right: 5px; margin-top: -1px; ">回上一頁
          </a>
        </div>
      </div>
    </div>
  </div>



<link rel="stylesheet" media="screen" href="/css/tender.css" />
<link rel="stylesheet" media="screen" href="/table/css/table.css" />
<link rel="stylesheet" media="screen" href="/css/list.css" />
<link rel="stylesheet" media="screen" href="/css/list_modal.css" />
<link rel="stylesheet" media="screen" href="/css/modal.css" />
<link rel="stylesheet" media="screen" href="/css/v.css" />
<link rel="stylesheet" media="screen" href="/css/member.css" />
<link rel="stylesheet" media="screen" href="/css/news.css" />
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons">



<div class="container" style="padding-top: 30px;min-height: 600px;padding-bottom: 100px;">

    <div class="row">
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="pr">
                <div class="col-55 f14 fbold date_news2" style="width: 100%">

                    @if( isset($news->launch_at) )
                      {{ date('Y/m/d',strtotime($news->launch_at)) }}
                    @else
                        
                    @endif

                    <img src="{{ asset('/images/newspaper.svg')}}" width="20px;" style="margin-left:5px;margin-top:-1px; ">
                </div>

                <div class="col-55 f14 fbold">
                </div>

                <div>
                    <div class="f28m222">{{ $news->title }}</div>
                        <div class="web-content-content">
                            {!! nl2br($news->content) !!}
                        </div>
                        <hr class="hr_line222">
                            <a href="#" onclick="javascript:history.back(-1);">
                                <div class="button_re22">返回列表</div>
                            </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection