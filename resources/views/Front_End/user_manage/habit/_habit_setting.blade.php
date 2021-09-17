<div class="container" style="min-height: 500px">
    <div class="member_title"> <span class="f28m">投資習慣設定</span></div>

    <div class="st2">
        <div class="intelligent_block clearAfter first_intelligent_block">
            <div class="modal-col-3">
                <div class="grouping_block clearAfter">
                    <div class="radio   m-r-10">
                        <label>
                            <input type="radio" class="click_radio" name="groupingRadios" id="groupingRadios1"
                                value="1"> <span class="f20">{{ $roiSetData[0]['name'] }}</span>
                        </label>
                    </div>
                    <div class="pull-left description_bt">
                        <div data-toggle="tooltip" style="cursor: pointer" onclick="show_description(1)"
                            data-placement="bottom" title="{{ $roiSetData[0]['description'] }}">
                            <i class="fa fa-question-circle m-r-5" aria-hidden="true"></i>說明
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-col-9" id="co9_width">
                <div class="proportion_block clearAfter">
                    <div class="space_block"></div>
                    <div class="slider_style_area">
                        <span class="f12bb">穩重謹慎型</span>
                        <div id="roi_id_1"></div>
                        <div class="proportion_bar clearAfter">
                            <div class="pull-left">
                                <span>A：<span id="val_1_1"></span>%</span>
                            </div>
                            <div class="pull-right">
                                <span>B：<span id="val_1_2"></span>%</span>
                            </div>
                        </div>
                        <div class="space_block"></div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>

    <div class="st2">
        <div class="intelligent_block clearAfter second_intelligent_block">
            <div class="modal-col-3">
                <div class="grouping_block clearAfter">
                    <div class="radio m-r-10">
                        <label>
                            <input type="radio" class="click_radio" name="groupingRadios" id="groupingRadios2"
                                value="2">
                            <span class="f20">{{ $roiSetData[1]['name'] }}</span>
                        </label>
                    </div>
                    <div class="pull-left description_bt">
                        <div data-toggle="tooltip" style="cursor: pointer" onclick="show_description(2)"
                            data-placement="bottom" title="{{ $roiSetData[1]['description'] }}">
                            <i class="fa fa-question-circle m-r-5" aria-hidden="true"></i>說明
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-col-9">
                <div class="proportion_block clearAfter">
                    <div class="space_block"></div>
                    <div class="slider_style_area">
                        <span class="f12bb">積極進取型</span>
                        <div id="roi_id_2"></div>
                        <div class="proportion_bar clearAfter">
                            <div class="slider-second-C second_bar" style="width: 40%;">C：<span id="val_2_1"></span>%
                            </div>
                            <div class="slider-second-D second_bar t-center" style="width: 30%;">D：<span
                                    id="val_2_2"></span>%</div>
                            <div class="slider-second-E second_bar t-right" style="width: 30%;">E：<span
                                    id="val_2_3"></span>%</div>
                        </div>
                    </div>
                    <div class="space_block"></div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>

    <div class="st2">
        <div class="intelligent_block clearAfter average_intelligent_block">
            <div class="modal-col-3">
                <div class="grouping_block clearAfter">
                    <div class="radio m-r-10">
                        <label>
                            <input type="radio" class="click_radio" name="groupingRadios" id="groupingRadios3"
                                value="3"> <span class="f20">{{ $roiSetData[2]['name'] }}</span>
                        </label>
                    </div>
                    <div class="pull-left description_bt">
                        <div data-toggle="tooltip" style="cursor: pointer" onclick="show_description(3)"
                            data-placement="bottom" title="{{ $roiSetData[2]['description'] }}">
                            <i class="fa fa-question-circle m-r-5" aria-hidden="true"></i>說明
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-col-9">
                <div class="proportion_block clearAfter">
                    <div class="average_area">
                        <span class="f12bb">穩健平衡型</span>
                        <div class="average_block a-color"></div>
                        <div class="average_block b-color"></div>
                        <div class="average_block c-color"></div>
                        <div class="average_block d-color"></div>
                        <div class="average_block e-color"></div>
                    </div>
                    <div class="average_bar clearAfter">
                        <div class="bar_block ">A：20%</div>
                        <div class="bar_block ">B：20%</div>
                        <div class="bar_block ">C：20%</div>
                        <div class="bar_block ">D：20%</div>
                        <div class="bar_block ">E：20%</div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="st2">
        <div class="intelligent_block clearAfter third_intelligent_block">
            <div class="modal-col-3">
                <div class="grouping_block clearAfter">
                    <div class="radio  m-r-10">
                        <label>
                            <input type="radio" class="click_radio" name="groupingRadios" id="groupingRadios4"
                                value="4"> <span class="f20">{{ $roiSetData[3]['name'] }}</span>
                        </label>
                    </div>
                    <div class="pull-left description_bt">
                        <div data-toggle="tooltip" style="cursor: pointer" onclick="show_description(4)"
                            data-placement="bottom" title="{{ $roiSetData[3]['description'] }}">
                            <i class="fa fa-question-circle m-r-5" aria-hidden="true"></i>說明
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-col-9">
                <div class="proportion_block clearAfter">
                    <div class="slider_style_area">
                        <span class="f12bb">穩健積極型</span>
                        <div id="roi_id_4"></div>
                        <div class="proportion_bar clearAfter">
                            <div class="pull-left">
                                <span class="slider-third-AB-label">A</span>：<span class="slider-third-AB"><span
                                        id="val_4_1"></span>%</span>
                            </div>
                            <div class="pull-right">
                                <span class="slider-third-CDE-label">C</span>：<span class="slider-third-CDE"><span
                                        id="val_4_2"></span>%</span>
                            </div>
                        </div>
                    </div>
                    <div class="proportion_select left8">
                        <select class="form-control js-change-color" id="roi_id_4_left_select"
                            data-id="proportion-slider-third" data-target="first">
                            <option value="a-color">A</option>
                            <option value="b-color">B</option>
                        </select>
                    </div>
                    <div class="proportion_select right right8 ">
                        <select class="form-control js-change-color" id="roi_id_4_right_select"
                            data-id="proportion-slider-third" data-target="second">
                            <option value="c-color">C</option>
                            <option value="d-color">D</option>
                            <option value="e-color">E</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="st2">
        <div class="proportion-slider-forth intelligent_block clearAfter fourth_intelligent_block" data-target="">
            <div class="modal-col-3">
                <div class="grouping_block clearAfter">
                    <div class="radio  m-r-10">
                        <label>
                            <input type="radio" class="click_radio" name="groupingRadios" id="groupingRadios5"
                                value="5"> <span class="f20">{{ $roiSetData[4]['name'] }}</span>
                        </label>
                    </div>
                    <div class="pull-left description_bt">
                        <div data-toggle="tooltip" style="cursor: pointer" onclick="show_description(5)"
                            data-placement="bottom" title="{{ $roiSetData[4]['description'] }}">
                            <i class="fa fa-question-circle m-r-5" aria-hidden="true"></i>說明
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-col-9">
                <div class="proportion_block clearAfter">
                    <div class="slider_style_area">
                        <span class="f12bb">足智多謀型</span>
                        <div class="unique_area ">
                            <div id="unique_block" class="unique_block a-color h40">A：100%</div>
                        </div>
                    </div>
                    <div class="proportion_select left8 p25">
                        <select class="form-control js-change-color" data-id="proportion-slider-forth"
                            id="roi_id_5_select">
                            <option value="a-color">A</option>
                            <option value="b-color">B</option>
                            <option value="c-color">C</option>
                            <option value="d-color">D</option>
                            <option value="e-color">E</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="member_footer">
        <button type="button" class="btn form_bt pull-right save_custom_setting_btn footer_btn" id="submitBtn">儲存
            <span id="loading" class="hideloading">
                <i class="fas fa-circle-notch fa-spin"></i>
            </span>
        </button>
    </div>
    <div class="clear"></div>
</div>


<script>
    function show_description(id) {
        switch (id) {
            case 1:
                swal("穩重謹慎型", "適合風險承受度較低，期望避免投資本金的損失<br>(選擇A及B級風險組合，可於10％到90％的區間內調整個別風險等級的投資比重)");
                break;
            case 2:
                swal("積極進取型", "願意承受較高的風險，以追求高的投資報酬<br>(選擇C及D及E級風險組合，可於10％到40％的區間內調整個別風險等級的投資比重)");
                break;
            case 3:
                swal("穩健平衡型", "適合承受少量的風險，以最求合理的投資報酬");
                break;
            case 4:
                swal("穩健積極型", "適合在穩健中願意承受相當程度的風險，追求較高的投資報酬<br>(A或B擇一及C或D或E擇一的風險組合，可於40％到60％的區間內調整個別風險等級的投資比重)");
                break;
            case 5:
                swal("足智多謀型", "適合各類投資，自身有充分判斷風險的能力");
                break;
            default:
        }
    }
    var defaultOBJ = {
        a_percent: 0,
        b_percent: 0,
        c_percent: 0,
        d_percent: 0,
        e_percent: 0,
        roi_setting_id: 0,
    };

    $(function () {
        var endDefaultUpdate = false;
        var default_roi_id = '{{ $roi_id }}';
        // var defaultOBJ = {
        //     a_percent: 0,
        //     b_percent: 0,
        //     c_percent: 0,
        //     d_percent: 0,
        //     e_percent: 0,
        //     roi_setting_id: 0,
        // };

        var dataObj = {
            roi_setting_id: 1,
            select: {},

        };
        /* -------------------------------------------------------------------------- */
        //穩重謹慎型 slibar設定
        var roi_id_1 = document.getElementById('roi_id_1');
        var val_1_1 = document.getElementById('val_1_1');
        var val_1_2 = document.getElementById('val_1_2');

        noUiSlider.create(roi_id_1, {
            padding: 10,
            start: 90,
            step: 10,
            connect: true,
            range: {
                'min': 0,
                'max': 100
            },
        });
        //調整數值時
        roi_id_1.noUiSlider.on('update', function (values, handle) {
            let r1a = Math.floor(values[handle]);
            let r1b = (100 - r1a);
            val_1_1.innerHTML = r1a;
            val_1_2.innerHTML = r1b;
            if (endDefaultUpdate) {
                updateDoingThing(1, [r1a, r1b]);
            }
        });
        /* -------------------------------------------------------------------------- */
        // 積極進取型 slibar設定
        var roi_id_2 = document.getElementById('roi_id_2');
        var val_2_1 = $('#val_2_1');
        var val_2_2 = $('#val_2_2');
        var val_2_3 = $('#val_2_3');

        noUiSlider.create(roi_id_2, {
            padding: 10,
            start: [10, 20],
            step: 10,
            margin: 10,
            connect: true,
            range: {
                'min': 0,
                'max': 100
            },
        });
        roi_id_2.noUiSlider.on('update', function (values, handle) {
            var c2 = Math.floor(values[0]);
            var d2 = Math.floor(values[1]) - c2;
            var e2 = 100 - d2 - c2;
            val_2_1.text(c2);
            val_2_2.text(d2);
            val_2_3.text(e2);
            if (endDefaultUpdate) {
                updateDoingThing(2, [c2, d2, e2]);
            }
        });
        /* -------------------------------------------------------------------------- */
        // 積極進取型 slibar設定
        var roi_id_4 = document.getElementById('roi_id_4');
        var val_4_1 = $('#val_4_1');
        var val_4_2 = $('#val_4_2');

        noUiSlider.create(roi_id_4, {
            padding: 10,
            start: 10,
            step: 10,
            margin: 10,
            connect: true,
            range: {
                'min': 0,
                'max': 100
            },
        });
        roi_id_4.noUiSlider.on('update', function (values, handle) {
            let x41 = Math.floor(values[handle]);
            let x42 = 100 - x41;
            val_4_1.text(x41);
            val_4_2.text(x42);
            if (endDefaultUpdate) {
                updateDoingThing(4, [x41, x42]);
            }
        });
        /* Some Setting Function -------------------------------------------------------------------------- */
        function updateDoingThing(roi_setting_id, value_array) {
            changeSelect(roi_setting_id);
            let obj = getObjectTemp(roi_setting_id, value_array);
            changeDefaultObj(obj);
        }

        function getObjectTemp(roi_id, numArray) {
            let obj = {
                roi_setting_id: roi_id,
            };
            switch (roi_id) {
                case 1:
                    obj['a_percent'] = numArray[0];
                    obj['b_percent'] = numArray[1];
                    return obj;
                    break;
                case 2:
                    obj['c_percent'] = numArray[0];
                    obj['d_percent'] = numArray[1];
                    obj['e_percent'] = numArray[2];
                    return obj;
                    break;
                case 3:
                    obj['a_percent'] = numArray[0];
                    obj['b_percent'] = numArray[0];
                    obj['c_percent'] = numArray[0];
                    obj['d_percent'] = numArray[0];
                    obj['e_percent'] = numArray[0];
                    return obj;
                    break;
                case 4:
                    let n1 = selectValueToKey($("#roi_id_4_left_select").val());
                    let n2 = selectValueToKey($("#roi_id_4_right_select").val());
                    obj[n1] = numArray[0];
                    obj[n2] = numArray[1];
                    return obj;
                    break;
                case 5:
                    let n3 = selectValueToKey($("#roi_id_5_select").val());
                    obj[n3] = numArray[0];
                    return obj;
                    break;
                default:
                    break;
            }
        }
        //切換Radio選擇
        function changeSelect(id) {
            $('#groupingRadios' + id).prop('checked', true);
        };
        //select 的 value 對應 object key
        function selectValueToKey(val) {
            let array = {
                'a-color': 'a_percent',
                'b-color': 'b_percent',
                'c-color': 'c_percent',
                'd-color': 'd_percent',
                'e-color': 'e_percent',
            };
            return array[val];
        }
        // radio選擇事件監聽
        $("input[name='groupingRadios']").on('click', function () {
            let thisRadioValue = $(this).val();
            switch (thisRadioValue) {
                case "1":
                    let roi_1_val = roi_id_1.noUiSlider.get();
                    let r1a = Math.floor(roi_1_val);
                    let r1b = (100 - r1a);
                    updateDoingThing(1, [r1a, r1b]);
                    break;
                case "2":
                    let roi_2_val = roi_id_2.noUiSlider.get();
                    let r2c = Math.floor(roi_2_val[0]);
                    let r2d = Math.floor(roi_2_val[1]) - r2c;
                    let r2e = 100 - r2d - r2c;
                    updateDoingThing(2, [r2c, r2d, r2e]);
                    break;
                case "3":
                    updateDoingThing(3, [20]);
                    break;
                case "4":
                    let roi_4_val = roi_id_4.noUiSlider.get();
                    let x41 = Math.floor(roi_4_val);
                    let x42 = 100 - x41;
                    updateDoingThing(4, [x41, x42]);
                    break;
                case "5":
                    updateDoingThing(5, [100]);
                    break;
                default:
                    break;
            }
        })

        //那三個下拉選單的監聽
        $("#roi_id_4_left_select , #roi_id_4_right_select").change(function () {
            let roi_4_val = roi_id_4.noUiSlider.get();
            let x41 = Math.floor(roi_4_val);
            let x42 = 100 - x41;
            updateDoingThing(4, [x41, x42]);
        })
        $("#roi_id_5_select").change(function () {
            updateDoingThing(5, [100]);
        })

        //修改OBJ
        function changeDefaultObj(obj) {
            $.each(defaultOBJ, function (k, v) {
                if (obj[k] == null) {
                    defaultOBJ[k] = 0;
                } else {
                    defaultOBJ[k] = obj[k];
                }
            })
        }

        /* 跑預設值-------------------------------------------------------------------------- */
        var defaultSetting = JSON.parse('{!! $defaultSetting !!}');
        console.log("MyOutput: defaultSetting", defaultSetting)
        let x = 0,
            xlen = defaultSetting.length;
        //設定預設的progress bar值
        for (x; x < xlen; x++) {
            switch (x) {
                case 0:
                    roi_id_1.noUiSlider.set(defaultSetting[x].a_percent);
                    set_default_obj(defaultSetting[x]);
                    break;
                case 1:
                    let d_p = defaultSetting[x].c_percent + defaultSetting[x].d_percent;
                    roi_id_2.noUiSlider.set([defaultSetting[x].c_percent, d_p]);
                    set_default_obj(defaultSetting[x]);
                    break;
                case 2:
                    //晚點做
                    set_default_obj(defaultSetting[x]);
                    break;
                case 3:
                    roi_id4_proccess(defaultSetting[x]);
                    set_default_obj(defaultSetting[x]);
                    break
                case 4:
                    roi_id5_proccess(defaultSetting[x]);
                    set_default_obj(defaultSetting[x]);
                default:
                    break;
            }
            if (x == (xlen - 1)) {
                endDefaultUpdate = true;
            }
        }

        function roi_id4_proccess(data) {
            let right = $("#roi_id_4_right_select");
            let left = $("#roi_id_4_left_select");
            if (data.hasOwnProperty('a_percent') && data.a_percent != 0) {
                left.val('a-color').change();
                roi_id_4.noUiSlider.set(data.a_percent);
            } else {
                left.val('b-color').change();
                roi_id_4.noUiSlider.set(data.b_percent);
            }
            if (data.hasOwnProperty('c_percent') && data.c_percent != 0) {
                right.val('c-color').change();
            } else if (data.hasOwnProperty('d_percent') && data.d_percent != 0) {
                right.val('d-color').change();
            } else {
                right.val('e-color').change();
            }
        }

        function roi_id5_proccess(data) {
            $.each(data, function (k, v) {
                let sel = $("#roi_id_5_select");
                if (k != 'roi_setting_id' && k != 0) {
                    let kv = k.split('_')[0];
                    sel.val(kv + "-color").change();
                }
            })
        }
        //設定預設Object
        function set_default_obj(defaultSettingObj) {
            let roi_setting_id = defaultSettingObj.roi_setting_id;
            if (roi_setting_id == default_roi_id) {
                $.each(defaultSettingObj, function (k, v) {
                    defaultOBJ[k] = v;
                });
            }
        }

        //設定選擇組別
        $('#groupingRadios' + default_roi_id).prop('checked', true);

        //儲存按鈕
        $("#submitBtn").click(function () {
            $(this).attr('disabled', true);
            $("#loading").toggleClass('hideloading', false);
            $.ajax({
                url: '{{ url("/users/tab_four/save") }}',
                type: 'post',
                data: defaultOBJ,
                success: function (d) {
                    $("#loading").toggleClass('hideloading', true);

                    if (d.status == 'success') {
                        swal('提示', '修改成功!', 'success').then(function () {
                            location.reload();
                        })

                    } else {
                        swal('提示', '修改失敗，請聯絡系統管理員排除問題!', 'error').then(function () {
                            location.reload();
                        })
                    }
                },
                error: function (e) {
                    $("#loading").toggleClass('hideloading', true);

                    swal('提示', '修改失敗，請聯絡系統管理員排除問題!', 'error').then(function () {
                        location.reload();
                    })
                },
            })
        })
    })
</script>