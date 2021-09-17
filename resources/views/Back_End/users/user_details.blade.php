@extends('Back_End.layout.header')

@section('content')

<style>
    .fluid {
        height: 130px;
        margin-left: 40px;
        display: inline-block !important;
        margin-top: 10px;
    }

    #dialog_large_image {
        background-color: rgba(0, 0, 0, 0.5);
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        z-index: 99999999;
        /* background: rgba(255, 255, 255,0.8); */
        overflow: auto;
        -webkit-box-align: center;
        -webkit-box-pack: center;
        -moz-box-align: center;
        -moz-box-pack: center;
        -o-box-align: center;
        -o-box-pack: center;
        -ms-box-align: center;
        -ms-box-pack: center;
        box-align: center;
        box-pack: center;
    }
</style>
<div class="change_user_state_model">
    <div class="user_state_model">
        <button class="close" type="button">X</button>
        <h4>駁回原因</h4>

        <div>
            <p><input type="radio" class="reason" name="reason" value="-2" onclick="show_input()"> &nbsp; 照片模糊</p>
            <p><input type="radio" class="reason" name="reason" value="-3" onclick="show_input()"> &nbsp; 地址與身分證不符</p>
            <p><input type="radio" class="reason" name="reason" value="-4" onclick="show_input()"> &nbsp; 其他原因</p>
            <textarea name="other_reason" id="other_reason" cols="30" rows="10" style="display: none"></textarea>
        </div>

        <button class="btn btn-danger" style="float:right" name=""
            onClick="user_state({{$row->user_id}},'reject')">確定駁回</button>
    </div>
</div>

<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">使用者細節</h3>
            </div>
        </div>

        <div class="col-md-12">
            <div style="border:solid 1px #1a2732">
                <div style="padding:10px;background-color:#394a59;position;relative;">
                    <h4 style="color:white;">
                        {{$row->user_name}}
                    </h4>
                    <a class="last_page" onclick="history.go(-1)">回上一頁</a>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <a href="/admin/users_edit/{{$row->user_id}}" class="btn btn-info" name="" onClick="#">編輯會員</a>
                    </div>

                    <div class='form-group'>
                        <div class="form_table_area">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>VIP</th>
                                        <!-- <th>超級推手</th> -->
                                        <th>警示戶</th>
                                        <th>審核狀態</th>
                                        <th>接收郵件</th>
                                        <th>手續費優惠比例</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <!-- VIP -->
                                        <td>
                                            <button class="btn btn-success" name="" onClick="#">啟用</button>
                                        </td>
                                        <!-- 超級推手 -->
                                        <!-- @if($row->getOriginal('is_super_pusher') == 0)
                                            <td >
                                                {{-- <button class="btn btn-success" name="" onClick="super_pusher({{$row->user_id}})" >啟用</button> --}}
                                            </td>
                                            @elseif($row->getOriginal('is_super_pusher') == 1)
                                            <td>
                                                <button class="btn btn-danger" name="" onClick="super_pusher_cancel({{$row->user_id}})" >解除</button>
                                            </td>
                                            @endif -->
                                        <!-- 警示戶 -->
                                        @if($row->getOriginal('is_alert') == 0)
                                        <td>
                                            <button class="btn btn-danger" name=""
                                                onClick="is_alert({{$row->user_id}})">啟用</button>
                                        </td>
                                        @elseif($row->getOriginal('is_alert') == 1)
                                        <td>
                                            <button class="btn btn-success" name=""
                                                onClick="is_alert_cancel({{$row->user_id}})">解除</button>
                                        </td>
                                        @endif
                                        <!-- 審核狀態 -->
                                        <td>
                                            @if($row->user_state == 2)
                                            <button class="btn btn-success" name=""
                                                onClick="user_state({{$row->user_id}},1)">審核通過</button>
                                            <button class="btn btn-info state_model">駁回</button>
                                            @endif
                                            <span>
                                                <?php
                                                    $user_state_array = Lang::get('user_state');
                                                    $state = $row->user_state;
                                                    if(isset($user_state_array[$state])){
                                                        $u_state = $user_state_array[$state];
                                                    }else{
                                                        $u_state = '未知狀態';
                                                    }
                                                    ?>
                                                {{ $u_state }}
                                            </span>
                                        </td>
                                        <!-- 接收郵件 -->
                                        <td>
                                            @if($row->getOriginal('is_receive_letter') == 0)
                                            <button class="btn btn-success" id="letterOpen">開啟</button>
                                            @elseif($row->getOriginal('is_receive_letter') == 1)
                                            <button class="btn btn-danger" id="letterClose">關閉</button>
                                            @else
                                            @endif
                                        </td>
                                        <!-- 手續費優惠%數 -->
                                        <td>
                                            {{$row->discount * 100 .'%'}}
                                        </td>
                                    </tr>
                                </tbody>

                                <thead>
                                    <tr>
                                        <th>會員編號</th>
                                        <th>帳號生效日</th>
                                        <th>得知管道</th>
                                        <th>不想收到訊息</th>
                                        <th>手續費開始時間</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <!-- 會員編號 -->
                                        <td>
                                            <?=isset($row->member_number)?$row->member_number:'';?>
                                        </td>
                                        <!-- 帳號生效日 -->
                                        <td>
                                            {{$row->confirmed_at}}
                                        </td>
                                        <!-- 得知管道 -->
                                        <td>
                                            {{$row->come_from_info_text}}
                                        </td>
                                        <!--不想收到訊息-->
                                        <td>
                                            @if($row->getOriginal('is_receive_letter_type') == 0)
                                            <button class="btn btn-success" id="letter_type_Open">開啟</button>
                                            @elseif($row->getOriginal('is_receive_letter_type') == 1)
                                            <button class="btn btn-danger" id="letter_type_Close">關閉</button>
                                            @else
                                            @endif
                                        </td>
                                        <td>
                                            {{$row->discount_start}}
                                        </td>
                                    </tr>
                                </tbody>

                                <thead>
                                    <tr>
                                        <th>姓名</th>
                                        <th>身分證字號</th>
                                        <th>是否停權</th>
                                        <th>會員身份別</th>
                                        <th>手續費結束時間</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <!-- 姓名 -->
                                        <td>
                                            {{$row->user_name}}
                                        </td>
                                        <!-- 身分證字號 -->
                                        <td>
                                            {{$row->id_card_number}}
                                            <!-- 是否停權 -->
                                        <td>
                                            {{$row->banned}}
                                        </td>
                                        <!--會員身份別-->
                                        <td>
                                            <span>
                                                @php
                                                $identityArray = Lang::get('user_identity');
                                                @endphp

                                                <select name="user_identity" id="user_identity">
                                                    <option value="" style="color:lightgray">選擇身份別</option>
                                                    {{-- <option value="0">尚未提交</option>
                                                    <option value="1">已提交</option> --}}
                                                    @foreach($identityArray as $k => $v)
                                                    @if($k == $row->user_identity)
                                                    <option selected value="{{$k}}">{{ $v }}</option>
                                                    @else
                                                    <option value="{{$k}}">{{ $v }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                                <button style="margin-left:5px;" class="btn btn-info"
                                                    onclick="update_u_id({{$row->user_id}})">更改</button>
                                            </span>
                                        </td>
                                        <td>
                                            {{$row->discount_close}}
                                        </td>
                                    </tr>
                                </tbody>

                                <thead>
                                    <tr>
                                        <th>電話</th>
                                        <th>E-mail</th>
                                        <th>出生年月日</th>
                                        <th>理專人員</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <!-- 電話 -->
                                        <td>
                                            {{$row->phone_number}}
                                        </td>
                                        <!-- E-mail -->
                                        <td>
                                            {{$row->email}}
                                        </td>
                                        <!-- 出生年月日 -->
                                        <td>
                                            {{$row->birthday}}
                                        </td>
                                        <!-- 理專人員 -->
                                        <td>
                                            <input name="come_from_info_text" id="s_p" type="text"
                                                value="{{$row->science_professionals}}"><button style="margin-left:5px;"
                                                class="btn btn-info" onclick="update_s_p({{$row->user_id}})">更改</button>
                                        </td>
                                    </tr>
                                </tbody>

                                <thead>
                                    <tr>
                                        <th>戶籍地址</th>
                                        <th>通訊地址</th>
                                        <th>備註</th>
                                        <th>是否變更為公司戶</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <!-- 戶籍地址 -->
                                        <td>
                                            {{$row->residence_country}}{{$row->residence_district}}{{$row->residence_address}}
                                        </td>
                                        <!-- 通訊地址 -->
                                        <td>
                                            {{$row->contact_country}}{{$row->contact_district}}{{$row->contact_address}}
                                        </td>
                                        <!-- 備註 -->
                                        <td>
                                            {{$row->note}}
                                        </td>
                                        <!-- 是否變更為公司戶 -->
                                        <td>
                                            @if(!empty($company_user[0]->company_name))
                                            {{ $company_user[0]->company_name }}
                                            @else
                                            <button
                                                style="margin-left:5px;" class="btn btn-info"
                                                onclick="update_cn({{$row->user_id}})">更改為公司戶</button>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>

                                <thead>
                                    <tr>
                                        <th>個人專屬推薦碼</th>
                                        <th>推薦人數</th>
                                        <th>推薦人推薦碼</th>
                                        <th>推薦人編號/姓名</th>
                                        <th>成立時間</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <!-- 個人專屬推薦碼 -->
                                        <td>
                                            {{$row->recommendation_code}}
                                        </td>
                                        <!-- 推薦人數 -->
                                        <td>
                                            @if (isset($recommend_count))
                                            @foreach ($recommend_count as $item)
                                            {{ $item->c }}
                                            @endforeach
                                            @endif
                                        </td>
                                        <!-- 推薦人推薦碼 -->
                                        <td>
                                            @if(isset($row->come_from_info_text) && $row->come_from_info_text != "")
                                            {{ $row->come_from_info_text }}
                                            @else
                                            <input name="come_from_info_text" id="cfit" type="text"><button
                                                style="margin-left:5px;" class="btn btn-info"
                                                onclick="update_cfit({{$row->user_id}})">新增</button>
                                            @endif
                                        </td>
                                        <!-- 推薦人編號/姓名 -->
                                        <td>
                                            @if(isset($recommend))
                                            {{ $recommend->member_number }} / {{ $recommend->user_name }}
                                            @endif

                                        </td>
                                        <!-- 成立時間 -->
                                        <td>
                                            @if(isset($row->come_from_info_text_created_at))
                                            {{ date('Y-m-d',strtotime($row->come_from_info_text_created_at))}}
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>銀行</th>
                                <th>匯款帳號</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($row->user_userbank as $data)
                            @if($data->is_active ==1)
                            <tr>
                                <!-- 銀行 -->
                                <td>
                                    {{$data->userbank_banklist->bank_name}}
                                </td>
                                <!-- 匯款帳號 -->
                                <td>
                                    {{$data->bank_account}}
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>

                    <div class='form-group'>
                        <div class="form_table_area">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>投資習慣</th>
                                        <th>總匯入金額</th>
                                        <th>總應實現利息</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <!-- 投資習慣 -->
                                        <td>
                                            {{  (isset($roi_setting_id))?$roi_setting_id:'未選擇'   }}
                                        </td>
                                        <!-- 總匯入金額 -->
                                        <td>
                                            {{  (isset($invest_info['total_invest']))?$invest_info['total_invest'].'元':''  }}
                                        </td>
                                        <!-- 總應實現利息 -->
                                        <td>
                                            {{  (isset($invest_info['total_income']))?$invest_info['total_income'].'元':''  }}
                                        </td>
                                    </tr>
                                </tbody>

                                <thead>
                                    <tr>
                                        <th>總投期款</th>
                                        <th>實現本金</th>
                                        <th>實現利息</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <!-- 總投期款 -->
                                        <td>
                                            {{  (isset($invest_info['total_invest']))?$invest_info['total'].'元':''  }}
                                        </td>
                                        <!-- 實現本金 -->
                                        <td>
                                            {{   (isset($invest_info['back_invest_money']))?$invest_info['back_invest_money'].'元':''   }}
                                        </td>
                                        <!-- 實現利息 -->
                                        <td>
                                            {{   (isset($invest_info['back_invest_income']))?$invest_info['back_invest_income'].'元':''   }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <img class="img" style="width:15%;margin-left:300px;"
                                src="/users/back_img_r?g={{$row->user_id}}" alt="">
                            <img class="img" style="width:15%;float:right;margin-right:300px;"
                                src="/users/font_img_r?g={{$row->user_id}}" alt="">
                            <div id="dialog_large_image"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-12" style="margin-top:20px;">
            <div style="border:solid 1px #1a2732">
                <div style="padding:10px;background-color:#394a59;position;relative;">
                    <h4 style="color:white;">
                        使用者銀行帳戶
                    </h4>
                </div>
                <div class="panel-body">
                    <div class='form-group'>
                        <div class="form_table_area">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>開戶行</th>
                                        <th>分行</th>
                                        <th>銀行代號</th>
                                        <th>帳號</th>
                                        <th>狀態</th>
                                        <th>使用中</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($row->user_userbank as $data)
                                    <tr>
                                        {{-- @php
                                           foreach($row->user_userbank as $data){
                                           dd($data->userbank_banklist);}
                                           @endphp --}}
                                        <!-- 開戶行 -->
                                        <td>
                                            {{$data->userbank_banklist->bank_name}}
                                        </td>
                                        <!-- 分行 -->
                                        <td>
                                            {{$data->userbank_banklist->bank_branch_name}}
                                        </td>
                                        <!-- 銀行代號 -->
                                        <td>
                                            {{str_pad((string)$data->userbank_banklist->bank_code,3,'0',STR_PAD_LEFT)}}
                                        </td>
                                        <!-- 帳號 -->
                                        <td>
                                            {{$data->bank_account}}
                                        </td>
                                        <!-- 狀態 -->
                                        <td>
                                            {{$data->state}}
                                        </td>
                                        <!-- 使用中 -->
                                        <td>
                                            {{$data->is_active}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="fluid_block col-md-12" style="text-align:center;margin:50px auto">
            <img class="ui fluid image" id="preview-new-cert1" src="{{ asset($row->id_front_file_name) }}" alt="">
            <img class="ui fluid image" id="preview-new-cert1" src="{{ asset($row->id_back_file_name) }}" alt="">
        </div>
    </section>
</section>
<script>
    $("#letterOpen").click(function () {
        letterChange(1)
    });
    $("#letterClose").click(function () {
        letterChange(0)
    });
    $("#letter_type_Open").click(function () {
        letter_type_Change(1)
    });
    $("#letter_type_Close").click(function () {
        letter_type_Change(0)
    });

    $(function () {
        $(".img").click(function () {

            var large_image = '<img src= ' + $(this).attr("src") + '></img>';
            $('#dialog_large_image').show();
            $('#dialog_large_image').html($(large_image).animate({
                width: '50%',
                margin: '12.5% 25%'
            }, 500));
        });
        $("#dialog_large_image").click(function () {
            $('#dialog_large_image').hide();
        });
    });

    function show_input() {
        var a = $('input[name="reason"]:checked').val();
        if (a == -4) {
            $("#other_reason").show();
        } else {
            $("#other_reason").hide();
        }
    }

    function letter_type_Change(letter_type) {
        $.ajax({
            url: '{{ url("/admin/users_details/letter_type_Change/$row->user_id/") }}' + '/' + letter_type,
            type: "get",
            success: function (d) {
                console.log(d);
                if (d.status == 'success') {
                    alert('成功!');
                    location.reload();
                } else {
                    alert('出現錯誤!請重新再試');
                    location.reload();
                }
            },
            error: function (e) {
                console.log(e);
            }
        })
    }

    function letterChange(letter) {
        $.ajax({
            url: '{{ url("/admin/users_details/letterChange/$row->user_id/") }}' + '/' + letter,
            type: "get",
            success: function (d) {
                console.log(d);
                if (d.status == 'success') {
                    alert('成功!');
                    location.reload();
                } else if (d.status == 'type_error') {
                    alert('已開啟不接收訊息!請關閉稍後再嘗試');
                    location.reload();
                } else {
                    alert('出現錯誤!請重新再試');
                    location.reload();
                }
            },
            error: function (e) {
                console.log(e);
            }
        })
    }

    function user_state(target, st) {
        if (st == 'reject') {
            var a = $('input[name="reason"]:checked').val();
            st = a;
            if (st == -4) {
                ot = $("#other_reason").val();
            } else {
                ot = '';
            }
        } else {
            ot = '';
        }
        $.ajax({
            type: "POST",
            url: "{{ url('/admin/users_details/user_state') }}",
            dataType: "json",
            data: {
                id: target,
                state: st,
                other: ot,
            },
            success: function (data) {
                if (data.success) {
                    alert("狀態更新成功！");
                    location.reload();
                }
            }
        });
    }

    function is_alert(target) {
        if (window.confirm('你確定要將此會員設為警示戶?')) {
            $.ajax({
                type: "POST",
                url: "/admin/users_details/is_alert",
                dataType: "json",
                data: {
                    id: target,
                },
                success: function (data) {
                    if (data.success) {
                        alert("已將此會員設為警示戶");
                        location.reload();
                    }
                }
            });
        }

    }

    function is_alert_cancel(target) {
        if (window.confirm('你確定要解除此會員警示戶狀態?')) {
            $.ajax({
                type: "POST",
                url: "/admin/users_details/is_alert",
                dataType: "json",
                data: {
                    id: target,
                },
                success: function (data) {
                    if (data.success) {
                        alert("此會員已非警示戶");
                        location.reload();
                    }
                }
            });
        }

    }

    function super_pusher(target) {
        if (window.confirm('你確定要將此會員設為超級推手?')) {
            $.ajax({
                type: "POST",
                url: "/admin/users_details/super_pusher",
                dataType: "json",
                data: {
                    id: target,
                },
                success: function (data) {
                    if (data.success) {
                        alert("已將此會員設為超級推手");
                        location.reload();
                    }
                }
            });
        }

    }

    function super_pusher_cancel(target) {
        if (window.confirm('你確定要解除此會員超級推手狀態?')) {
            $.ajax({
                type: "POST",
                url: "/admin/users_details/super_pusher",
                dataType: "json",
                data: {
                    id: target,
                },
                success: function (data) {
                    if (data.success) {
                        alert("此會員已非超級推手");
                        location.reload();
                    }
                }
            });
        }

    }

    function update_cn(target){
        $.ajax({
            type: "POST",
            url: "/admin/users_details/update_cn",
            dataType: "json",
            data: {
                id: target
            },
            success: function (data) {
                if (data.success) {
                    alert("已新增公司戶");
                    location.reload();
                }
            }
        })
    }

    function update_cfit(target) {

        var cfit = $('#cfit').val();

        $.ajax({
            type: "POST",
            url: "/admin/users_details/update_cfit",
            dataType: "json",
            data: {
                id: target,
                cfit: cfit,
            },
            success: function (data) {
                if (data.success) {
                    alert("已新增推薦人推薦碼");
                    location.reload();
                }
            }
        })
    }

    function update_s_p(target) {

        var s_p = $('#s_p').val();

        $.ajax({
            type: "POST",
            url: "/admin/users_details/update_s_p",
            dataType: "json",
            data: {
                id: target,
                s_p: s_p,
            },
            success: function (data) {
                if (data.success) {
                    alert("已更改理專人員");
                    location.reload();
                }
            }
        })
    }

    function update_u_id(target) {

        var u_id = $('#user_identity').val();

        $.ajax({
            type: "POST",
            url: "/admin/users_details/update_u_id",
            dataType: "json",
            data: {
                id: target,
                u_id: u_id,
            },
            success: function (data) {
                if (data.success) {
                    alert("已更改會員身份別");
                    location.reload();
                }
            }
        })
    }


    $('.close').click(function () {
        $('.change_user_state_model').fadeOut();
    })

    $('.state_model').click(function () {
        $('.change_user_state_model').fadeIn();
    })
</script>

@endsection