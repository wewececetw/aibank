@extends('Front_End.layout.header')

@section('content')

<style>
    @media (max-width: 768px)
    {
        .conten img{
            height: unset !important;
            width: 95% !important;
        }
    }
    p a{
        color: blue !important;
    }
</style>

<div id="main-page">
    <link rel="stylesheet" media="screen" href="/css/tender.css" />
    <link rel="stylesheet" media="screen" href="/table/css/table.css" />
    <link rel="stylesheet" media="screen" href="/css/list.css" />
    <link rel="stylesheet" media="screen" href="/css/news.css" />
    <link rel="stylesheet" media="screen" href="/css/list_modal.css" />
    <link rel="stylesheet" media="screen" href="/css/modal.css" />
    <link rel="stylesheet" media="screen" href="/css/v.css" />
    <link rel="stylesheet" media="screen" href="/css/member.css" />
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker3.min.css">

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
                    <a href="{{asset('/inbox_letters')}}" >
                        <img src="/images/arrow-alt-left.svg" width="17px;" style="margin-right: 5px; margin-top: -1px; ">回上一頁
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="container" style="padding-top: 30px;min-height: 600px;padding-bottom: 100px;">
        <div class="">
            <div class="an-component-header search_wrapper" style="width: 100%">
                <div class="panel panel-default an-sidebar-search filter-condition-panel">
                    <div class="member_title">
                        <span class="f28m">檢視信件</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="" style="width: 100%;">
            <div class="pr">
                <div class="tl f25">
                    {{ str_replace('豬豬在線','',$letter->title) }}
                </div>
                <div class="conten">
                    <?php echo $letter->content ?>
                </div>
                {{-- <div class="money_item5" style="width: 100%">
                    <div><span class="list_1">
                        <span class="item_data2">發送時間</span>
                        <span class="item_data">
                            {{ $letter->created_at }}
                        </span>
                        </span>
                    </div>
                    <div><span class="list_1">
                        <span class="item_data2">已讀時間</span>
                        <span class="item_data">
                            {{ $read_at }}
                        </span>
                        </span>
                    </div>
                </div> --}}
                <div class="col-55 f14 fbold">
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

@endsection
