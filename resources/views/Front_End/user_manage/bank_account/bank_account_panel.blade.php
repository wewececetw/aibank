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
    <link rel="stylesheet" media="screen" href="/css/file.css" />
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker3.min.css">

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


    @if (session('bank_check'))
        <script>
            swal("提示", "請新增銀行帳號！", "error")

        </script>
    @endif


    <div class="container" style="min-height: 500px">
        <div class="row">
            <div class="member_content" style="min-height: 200px">
                <div class="member_title"> <span class="f28m">銀行帳號</span></div>
                <div class="col-100 f20m ">
                    <table id="data" cellspacing="0" cellpadding="0" class="rwd-table tablesorter border1">
                        <thead>
                            <tr class="title_tr">
                                <th data-field="action" data-formatter="ActionFormatter"><span>開戶行</span></th>
                                <th class="tc"><span>銀行分行</span></th>
                                <!-- <th><span>銀行代碼</span></th> -->
                                <th class="tc"><span>銀行帳號</span></th>
                                <!-- <th><span>狀態</span></th> -->
                                <th class="tc"><span>使用中</span></th>
                                <th class="tc"><span>刪除</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user_bank as $row)
                            <tr>
                                <td class="lalign" data-th="開戶行">

                                    <span class="">{{ substr('000'.$row->userbank_banklist->bank_code, -3) }} &nbsp;
                                        {{ $row->userbank_banklist->bank_name }}</span>


                                </td>
                                <td data-th="銀行分行" class="tc"><span
                                        class="">{{ $row->userbank_banklist->bank_branch_name }}</span> </td>

                                <!-- <td data-th="銀行代碼"></td> -->
                                <td data-th="銀行帳號" class="tc">
                                    <span class="fbold">{{ $row->bank_account }}</span>
                                </td>

                                <!-- <td data-th="狀態" class="cc1"></td> -->
                                <td data-th="使用中" class="tc">
                                    <span class=" fcolor f18">
                                        <input type="radio" class="js-bank-profile-radio bank_is_active"
                                            onchange="update_active({{ $row->user_bank_id }})" name="user_bank"
                                            <?=( $row->is_active == '是' )? 'checked':'';?>>
                                    </span>
                                </td>

                                <td data-th="刪除" class="tc">
                                    <button type="submit" class="btn no-btn-style btn_nobg" data-toggle="modal"
                                        data-target="#DeleteBankModal{{ $row->user_bank_id }}"
                                        <?=( $row->is_active == '是' )? "style='display:none' " : "" ;?>>
                                        <i class="fa fa-times-circle f16" aria-hidden="true"></i>
                                    </button>

                                    {{-- <!-- 刪除 modal --> --}}
                                    <div class="modal fade" id="DeleteBankModal{{ $row->user_bank_id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="DeleteBankModalLabel">
                                        <div class="modal-dialog modal-md" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close"><span aria-hidden="true">×</span></button>

                                                </div>
                                                <div class="modal-body">
                                                    <!-- <h4 class="modal-title" id="">刪除</h4> -->
                                                    確定要刪除嗎？
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">取消</button>
                                                    <button type="button" class="btn btn-danger"
                                                        onclick="delete_bank({{ $row->user_bank_id }})">確定</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-100 pd40" style="padding-bottom: 20px;">
                <div class="f20m f20mborder2 ">新增銀行帳戶</div>
            </div>

            <div class="" style="width: 100%">
                <form id="new_bank_form" class="simple_form new_bank_profile">

                    <input name="utf8" type="hidden" value="✓">
                    <input type="hidden" name="authenticity_token"
                        value="u1wcDVeYuAuFkwYi8KVNHiMlDXwZIthIi9U7MQl1PhPUugwdsBjB12QxVaSpxwJ7EgnzeHM+XEykAeSkkY3tNw==">
                    <input type="hidden" name="bank_profile[branch]" id="bank_profile_branch">

                    <div class="field col-55">
                        <div class="f16 f16txt">開戶行(代號)</div>
                        <div class="co36" style="width:50%">
                            <select class="select required form-control select2" name="bank_profile" id="bank_profile">
                                <option value="-1">請選擇</option>
                                @foreach ($bank as $item)

                                <?=
                                    $b = '00'.$item->bank_code;
                                    $current_b = substr($b, -3) ;

                                    ?>
                                <option value="{{ $item->bank_code }}">{{ $current_b }}&nbsp;{{ $item->bank_name }}
                                </option>

                                @endforeach

                            </select>
                        </div>

                        <div class="co36">
                            <select class="select required form-control select2" name="bank_id" id="bank_branch">
                                <option value="0">請選擇</option>
                            </select>
                        </div>

                        <div class="co36">
                        </div>
                    </div>

                    <div class="col-55">
                        <div class="field">
                            <div class="f16 f16txt">銀行帳號</div>
                            <input class="string form-control" required="required" placeholder="請輸入帳號" type="text"
                                name="bank_account" id="bank_account" maxlength="16">
                            <span class="f14 pp2">

                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                銀行帳號只能輸入 10 到 16 碼數字。
                            </span>
                        </div>
                    </div>

                    <div class="">
                        <div class="p60 col-55">
                            <p style="max-width: 90%">
                                請注意 ：<br>
                                1.新增或修改銀行帳戶資訊作業需20個工作天。<br>
                                2.銀行帳戶以兩組為限，請確認您的銀行資訊填寫無誤。<br>
                                3.存摺戶名必需與身分證上的姓名完全相同。<br>
                                4.建議您使用 中信/元大/合庫/彰銀，可免除返還投資報酬匯款手續費。
                            </p>
                        </div>
                        {{-- <div class="f16 f16txt p60 col-55">
                            <span class="f14 pp2">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                您的專屬代收虛擬帳號： 彰化銀行（009）{{ $user->virtual_account }}

                            </span>
                        </div> --}}
                    </div>
                </form>
            </div>

        </div>
        <div class="member_footer">
            <button class="btn form_bt pull-right footer_btn" onclick="submit_bank();">新增銀行帳戶</button>
        </div>
    </div>
</div>


</body>

</html>


<script>
    function update_active(target) {
        $.ajax({
            type: "POST",
            url: "/user/is_active_update",
            dataType: "json",
            data: {
                user_bank_id: target,
            },
            success: function (data) {
                if (data.success) {
                    swal('提示', '更改成功!', 'success').then(function () {
                        location.reload();
                    })
                }
            }
        });
    }

    function delete_bank(target) {

        $.ajax({
            type: "POST",
            url: "/user/bank_delete/" + target,
            data: {
                id: target,
            },
            success: function (data) {
                if (data.success) {
                    swal('提示', '刪除成功!', 'success').then(function () {
                        location.reload();
                    })
                }
            }
        });
    }



    $('#bank_profile').change(function () {
        $.ajax({
            type: "POST",
            url: "/user/bank_select",
            dataType: "json",
            data: $('#new_bank_form').serialize(),
            success: function (data) {
                if (data.success) {
                    var $bank_branch = '';
                    data.ban_opt.forEach(function (item) {
                        $bank_branch += '<option value=" ' + item['bank_id'] + '">' + item[
                                'bank_branch_code'] + '&nbsp;' + item['bank_branch_name'] +
                            '</option>';

                    });

                    $('#bank_branch').html($bank_branch);
                }

            }
        });

    })


    function submit_bank() {

        var bank_account = $('#bank_account').val();
        var bank_profile = $('#bank_profile').val();
        var isNum = /^[0-9]+$/;

        if (bank_account.length < 10) {
            // alert('帳號應是10到16位數字！');
            swal('提示', '帳號應是10到16位數字！', 'error');

        } else if (isNaN(bank_account)) {
            // alert('請輸入正確帳號！');
            swal('提示', '請輸入正確帳號！', 'error');

        } else if (bank_profile == '-1') {
            // alert('請選擇開行戶!');
            swal('提示', '請選擇開行戶', 'error');
        } else {
            $.ajax({
                type: "POST",
                url: "{{url('/user/bank_account_insert')}}",
                dataType: "json",
                data: $('#new_bank_form').serialize(),
                success: function (data) {
                    if (data.success) {
                        // alert("新增成功");
                        swal("提示", "新增成功", "success").then(function () {
                            location.reload();
                        })
                    } else {
                        if (data.msg == 'repeat') {
                            swal("提示", "新增失敗! 此銀行帳戶已註冊", "error").then(function () {
                                location.reload();
                            })
                        } else {
                            swal("提示", "新增失敗! 請重新輸入", "error").then(function () {
                                location.reload();
                            })
                        }
                    }
                }
            });
        }

    }




    function test() {

    }
    test();

</script>


@endsection
