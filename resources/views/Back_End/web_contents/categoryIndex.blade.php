@extends('Back_End.layout.header')
@section('content')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style>
    #tbd>tr,
    #tbd>tr>td,
    #user_table>thead>tr,
    #user_table>thead>tr>th {
        text-align: center;
    }

    .noSlide {
        pointer-events: none;
    }

    .mask.show {
        position: absolute;
        background-color: #808080bd;
        height: 100%;
        width: 98%;
        z-index: 99999;
    }
    .mask.hide {
        display: :none;
        position: absolute;
        background-color: #808080bd;
        height: 100%;
        width: 98%;
        z-index: 99999;
    }
    .loadSpinner {
        width: 30px;
        height: 30px;
        margin: 0 auto;
        padding: 10px;
        border: 3px dashed #5bdb4b;
        border-radius: 100%;
        position: absolute;
        left: 49%;
        top: 45%;
    }
    .mask .loadSpinner {animation: run 1.5s .3s cubic-bezier(.17,.37,.43,.67) infinite;}

    @keyframes run {
        0 {transform: rotate(0deg);}
        50% {transform: rotate(180deg);}
        100% {transform: rotate(360deg);}
    }

</style>
<script>
    $(function () {
        $("#tbd").sortable({
            stop: function (event, ui) {
                let newSortList = getNowSort();

                if (newSortList) {
                    // sortData = newSortList;
                    $("#mask").toggleClass('hide',false);
                    $("#mask").toggleClass('show',true);
                    newSortList = reDrawSortTD(sortData, newSortList);
                    $.ajax({
                        url: "{{ url('/web_contents/resort') }}",
                        type: "POST",
                        data: {
                            data: JSON.stringify(newSortList)
                        },
                        success: function (d) {
                            sortData = newSortList;
                            $("#mask").toggleClass('hide',true);
                            $("#mask").toggleClass('show',false);
                        },
                        error: function (e) {
                            swal('??????','??????????????????????????????!','error').then(function(){
                                location.reload();
                            })
                        }
                    })
                }
            }
        });
        $("#tbd").disableSelection();
    });

</script>
<script>
    let sortData = {!!$sortData!!};

    function getNowSort() {
        let $_trs = $(".sortTr");
        let newSortList = [];
        $_trs.each(function (i, v) {
            newSortList.push({
                item_num: i,
                web_contents_id: $(v).data('id'),
                sort: $(v).data('sort')
            });
        })
        let needUpdate = checkSort(newSortList);
        if (!needUpdate) {
            return newSortList;
        } else {
            return false;
        }
    }

    function checkSort(newList) {
        let x = 0,
            xlen = newList.length;
        for (x; x < xlen; x++) {
            let thisObj = newList[x];
            let oldObj = sortData[x];
            if (thisObj.item_num !== oldObj.item_num || thisObj.web_contents_id !== oldObj.web_contents_id) {
                return false;
            }
        }
        return true;
    }

    function reDrawSortTD(sortData, newSortList) {
        let x = 0,
            xlen = newSortList.length;
        let newList = [];
        for (x; x < xlen; x++) {
            let td_id = `#st_${newSortList[x].web_contents_id}`;
            $(td_id).text(sortData[x].sort);
            newList.push({
                item_num: x,
                web_contents_id: newSortList[x].web_contents_id,
                sort: sortData[x].sort
            });
        }
        return newList;
    }

</script>



<section id="main-content">
    <section class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">{{ $category_ch_name }}??????</h3>
                    <a class="btn btn-info" href='{{  url("$thisBaseUrl/create") }}' style="margin-bottom:10px">??????</a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <div class="mask hide" id="mask">
                            <div class="loadSpinner"></div>
                        </div>
                        <table id="user_table" class="table table-striped table-advance table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>??????</th>
                                    <th>??????</th>
                                    <th>??????</th>
                                    <th>??????</th>
                                    <th>??????</th>
                                </tr>
                            </thead>

                            <tbody id="tbd">

                                @foreach($data as $row)
                                <tr class="sortTr" data-id="{{ $row->web_contents_id }}" data-sort="{{ $row->sort }}">
                                    <td><i class="fas fa-sort"></i></td>
                                    <td id="st_{{ $row->web_contents_id }}">{{  $row->sort  }}</td>
                                    <td>{{  $row->name  }}</td>
                                    <td>
                                        @if($row->is_active == 1)
                                        <label class="label label-success">?????????</label>
                                        @else
                                        <label class="label label-danger">?????????</label>
                                        @endif
                                    </td>

                                    <td>{{ $row->remark }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="btn btn-info"
                                                href='{{ url("$thisBaseUrl/$row->web_contents_id/edit") }}'><i
                                                    class="fa fa-eye"></i></a>
                                            <a class="btn btn-danger"
                                                onclick="deleteContent({{ $row->web_contents_id }});"><i
                                                    class="fa fa-trash-o"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </section>
                </div>
            </div>
        </div>

    </section>
</section>

</section>



<script>
    function deleteContent(target) {
        swal({
            title: "??????",
            text: '???????????????????',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#eb547c",
            confirmButtonText: "????????????",
            cancelButtonText: "??????",
        }).then(() => {
            $.ajax({
                url: '{{ url("$thisBaseUrl") }}' + '/' + target,
                type: 'DELETE',
                success: function (d) {
                    if (d.status == 'success') {
                        swal('??????', '????????????!', 'success').then(() => {
                            location.reload();
                        })
                    }
                },
                error: function (e) {
                    swal('??????', '??????????????????????????????!', 'error').then(() => {
                        location.reload();
                    })
                }
            })
        });
    }

</script>





@endsection
