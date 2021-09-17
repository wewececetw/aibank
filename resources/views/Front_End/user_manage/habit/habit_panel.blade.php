@extends('Front_End.layout.header')

@section('content')

<div id="main-page">
    <link rel="stylesheet" media="screen" href="/table/css/table.css" />
    <link rel="stylesheet" media="screen" href="/css/list.css" />
    <link rel="stylesheet" media="screen" href="/css/list_modal.css" />
    <link rel="stylesheet" media="screen" href="/css/modal.css" />
    <link rel="stylesheet" media="screen" href="/css/member.css?v=20191016" />
    <link rel="stylesheet" media="screen" href="/css/member2.css?v=20181027" />
    <link rel="stylesheet" media="screen" href="/css/tender.css" />
    <link rel="stylesheet" media="screen" href="/css/sliderbar.css" />
    <link rel="stylesheet" media="screen" href="/css/claim.css" />
    <link rel="stylesheet" media="screen"
        href="/assets/front/match-ab00adde9a2208fa12a33b86a261b34d9ea621b0ceed421ed9fd13204e088bb4.css" />
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    {{-- noUiSlider --}}
    <style>
        #slider .noUi-base {
            background: red;
        }

        #slider .noUi-background {
            background: blue;
        }

        #slider .noUi-connect {
            background: green;
        }

        .hideloading {
            display: none;
        }

    </style>

    <div class="member_banner">
        <div class="container">
            <div class="row">
                <div class="banner_content">

                </div>
            </div>
        </div>
    </div>

    @component('Front_End.user_manage.account.mobileSelect')
    @endcomponent


    @component('Front_End.user_manage.habit._habit_setting',[
        'defaultSetting' => $defaultSetting,
        'roi_id' => $roi_id,
        'roiSetData' => $roiSetData
    ])

    @endcomponent



</div>



@endsection
