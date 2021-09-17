@extends('Front_End.layout.header')

@section('content')

<div id="main-page">
    <link rel="stylesheet" media="screen" href="/css/about.css" />
<link rel="stylesheet" media="screen" href="/css/list_modal.css" />
<link rel="stylesheet" media="screen" href="/css/news.css" />

<div id="banner-box">
<div class="banner-list">
<!--活动-->
<li style="background: url(/banner/img/5.jpg) ; background-size: cover;">
  <div class="animate-box png">
    <div class="t-d" aos="fade-right">
      <h2>最新公告</h2>
      <br/>
    </div>
    <div class="animate-img"><img src="{{ asset('/banner/img/a777b23736b812414d59e18810923b54.png') }}" alt=" "></div>
  </div>
  <div class="enter_more2 floating">
    <i class="fa fa-chevron-right" aria-hidden="true"></i>
  </div>
</li>
</div>
</div>


<section class="section section--code ">
<div class="container">
<div class="row news30 newsh450">
  <div class="text_bg5">
    <div class="col-md-6 offset-md-3 text-center t20 aos-init " >
      <div class="text-center">
        <div class="stitle">news</div>
        <div class="title1">最新公告</div>
      </div>
    </div>
  </div>
</div>
<div class="row">

    @foreach ($news as $row)

        <div class="col-md-4 pd5 aos-init " >
          <a href="{{url('/news/news_detail?id='.$row->web_contents_id)}}">
            <div class="linka">
              <div class="news-img">

                  @foreach( $row->news_photo as $image)

                        @if( isset($image->image) )
                            <img src="{{ asset( $image->image ) }}" alt="" >
                        @else

                        @endif

                  @endforeach

              </div>
              <div class="news-title">{{ $row->title }}</div>
              <p class="news-pretext">
                {{ $row->remark }}
              </p>
              <div class="news-created-time  stitle_1apadd">

                @if( isset($row->created_at) )
                    {{ date('Y/m/d',strtotime($row->created_at)) }}
                @else

                @endif

              </div>
            </div>
          </a>
        </div>

    @endforeach

</div>
<div class="row">
<!-- 分頁 -->
<nav aria-label="..." class="m-auto pd2070 page_n">

</nav>

<div class="form-group page_b page_ba">

</div>
</div>
</div>
</section>


    </div>


@endsection
