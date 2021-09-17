@extends('Front_End.layout.header')

@section('content')

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
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker3.min.css">

    <div class="tender_banner">
        <div class="container">
            <div class="row">
            </div>
        </div>
    </div>

    <div class="container" id='Main' style="padding-top: 30px;min-height: 600px;padding-bottom: 50px;">
        <div class="">
            <div class="an-component-header search_wrapper" style="width: 100%">
                <div class="panel panel-default an-sidebar-search filter-condition-panel panel2">

                    <div class="panel-heading" role="tab">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" href="#search_panel" data-toggle="collapse"
                                data-parent="#accordion" aria-expanded="false" aria-controls="search_panel">
                                <i class="fa fa-search" aria-hidden="true"></i> 篩選條件
                            </a>
                        </h4>
                    </div>

                    <div id="search_panel" class="panel-collapse collapse" role="search panel" aria-expanded="false"
                        style="height: 0px;">
                        <div class="panel-body">

                            {{-- <form class="form-horizontal"> --}}
                                <div class="form-group form-group_left">
                                    <label class="col-sm-2 control-label">
                                        標題
                                    </label>
                                    <div class="col-sm-12">
                                        <input type='text' id="title" name='title' placeholder='請輸入標題'
                                            class='an-form-control no-redius border-bottom m-0 text_color filter-title filter-condition form-control'
                                            value="">
                                    </div>
                                </div>
                                <div class="form-group form-group_left">
                                    <label class="col-sm-2 control-label">
                                        內容
                                    </label>
                                    <div class="col-sm-12">
                                        <input type='text' id="content" name='content' placeholder='請輸入內容'
                                            class='an-form-control no-redius border-bottom m-0 text_color filter-content filter-condition form-control'
                                            value="">
                                    </div>
                                </div>
                                <div class="clear"></div>
                                <div class="form-group">
                                    <div class="col-sm-12 ">
                                        <button class="btn btn-secondary btn_modal" id="searchBtn">
                                            查詢
                                        </button>
                                        <button class="btn btn_modal btn00c" onclick="delete_value()">
                                            清空
                                        </button>
                                    </div>
                                </div>
                            {{-- </form> --}}

                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="" style="width: 100%;">

            <table id="letters_table" cellspacing="0" cellpadding="0" class="rwd-table">
                <thead>
                    <tr class="title_tr">
                        <th data-field="action" data-formatter="ActionFormatter" width="10%">
                            <span>標題</span>
                        </th>
                        {{-- <th width="40%"><span>內容</span></th> --}}
                        <th width="17%"><span>發送時間</span></th>
                        <th width="17%"><span>已讀時間</span></th>
                        <th width="8%"><span>檢視訊息</span></th>
                        <th width="8%"><span>刪除</span></th>
                    </tr>
                </thead>
                <tbody id="mail_tbody">
                    @foreach ($letters as $letter)
                    <tr>
                        <td class="lalign" data-th="標題">
                            <span class="fcolor">{{ str_replace('豬豬在線','',$letter->title) }}</span>
                        </td>
                        {{-- <td data-th="內容">
                            <span class="">//echo $letter->content ?></span>
                        </td> --}}
                        <td data-th="發送時間">{{ $letter->created_at }}</td>
                        <td data-th="已讀時間">
                            <span class="fbold">
                                {{ (isset($read_at[$letter->internal_letter_id] ))?$read_at[$letter->internal_letter_id] : '未讀' }}
                            </span>
                        </td>
                        <td data-th="檢視訊息" class="tc">
                            <a href="{{ url('/check_letters').'/'.$letter->internal_letter_id }}">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </a>
                        </td>
                        <td data-th="刪除">
                            <i class="fa fa-times-circle f16 deleteLetter" aria-hidden="true"
                                data-id="{{ $letter->internal_letter_id }}"></i>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        content_height();
        function content_height(){
            $("#Main").css("min-height",document.body.offsetHeight);   
        }
        $(".deleteLetter").click(function () {
            let $this = $(this);
            let letterId = $this.attr('data-id');
            swal({
                title: "確定刪除此信件?",
                text: "此操作將無法復原",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "確定刪除!",
            }).then(
                function (isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            url: '{{ url("/del_inbox_letters/") }}' + '/' + letterId,
                            type: 'get',
                            success: function (d) {
                                if(d.status == 'success'){
                                    swal('提示', '刪除成功!', 'success').then(() => {
                                        location.reload();
                                    });
                                }else if(d.status == 'error'){
                                    swal('提示','系統錯誤此郵件已被刪除!','error');
                                }else{
                                    swal('提示','請勿嘗試刪除他人信件!','error');
                                }
                            },
                            error: function (e) {
                                console.log(e);
                                swal('提示', '系統異常，請稍後再試!', 'error');
                            }
                        })
                    }
                }
            );
        })

        function delete_value() {
            $('input').val('');
            searchObj.title = '';
            searchObj.ctx = '';
            $("#searchBtn").trigger('click');
        }
        //搜尋資料
        var searchObj = {
            title : '',
            ctx : '',
        };

        $("#title").on('keyup',function(){
            searchObj.title = $(this).val().trim()
        })
        $("#content").on('keyup',function(){
            searchObj.ctx = $(this).val().trim()
        })
        //查詢
        $("#searchBtn").click(function(){
            $.ajax({
                url:'{{ url("/inbox_letters/search") }}',
                type : 'post',
                data:searchObj,
                success:function(d){
                    if(d.length > 0){
                        redrawTable(d);
                    }else{
                        swal('提示','查無資料','info');
                    }
                },
                error:function(e){
                    swal('提示','系統異常，請稍後再試!','error');
                }
            })
        })
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
            return `
            <tr>
                <td class="lalign" data-th="標題">
                    <span class="fcolor">${d.title}</span>
                </td>
                <td data-th="發送時間">${d.created_at}</td>
                <td data-th="已讀時間">
                    <span class="fbold">
                        ${d.read_at}
                    </span>
                </td>
                <td data-th="檢視訊息" class="tc">
                    <a href="{{ url('/check_letters')}}/${d.internal_letter_id}">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                    </a>
                </td>
                <td data-th="刪除">
                    <i class="fa fa-times-circle f16 deleteLetter" aria-hidden="true"
                        data-id="${d.internal_letter_id}"></i>
                </td>
            </tr>
            `
        }
    </script>


    </body>

    </html>

    @endsection
