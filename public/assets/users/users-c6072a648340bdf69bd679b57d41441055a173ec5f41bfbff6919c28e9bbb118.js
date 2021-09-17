var changeIntelligent = ''; // 定義目前選擇、登入者預設的智能媒合設定

var personal_infomation_btns_disabled = function(){
    var check_sent_at = $('#check_sent_at').val();
    console.log('check_sent_at ='+check_sent_at );
    console.log(check_sent_at !== '');

    if(check_sent_at !== ''){
        $("#personal_submit").attr('disabled', true);
        $("#mobile-check").attr('disabled', true);
        $("#status_message").html('目前為待審核狀態，回覆後方可再次提交。');
    }else {
        $("#personal_submit").attr('disabled', false);
        $("#mobile-check").attr('disabled', false);
    }
};

$(function(){
    personal_infomation_btns_disabled();

    // 進入投資習慣設定
    $('#investment-setting-tab').click(function() {
        if(risk_level !== ""){
            swal("您的風險屬性類型", risk_level);
        }

        // 避免使用者動到投資組合設定後沒有送出更新，之後若又從其他頁籤返回此頁時，可能會誤會已經送出儲存，故要回復原始設定
        $.ajax({
            type: "GET",
            url: '/users/restore_investment_setting',
            dataType: 'script',
            data: {},
            success: function(result) {
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(xhr);
                console.log(ajaxOptions);
                console.log(thrownError);
            }
        });
    });

    // 發送手機驗證碼
    $("#mobile-check").on('click',function() {
        var btn = $(this);
        var origin_mobile_check_btn_text = btn.text();
        var phone = $(".phone_number_input").val();

        btn.attr('disabled', true);
        btn.text('發送中');

        $.ajax({
            type: "POST",
            url: '/users/send_notify',
            data: {phone:phone},
            success: function(result) {
                if( result.success ){
                    btn.text(origin_mobile_check_btn_text);
                    swal(result.message, '', 'info');

                    // 倒數60秒之後才可以點擊
                    var countdown = 60;
                    var interval = setInterval(function(){
                        if(countdown !== 0){
                            btn.text(origin_mobile_check_btn_text + '(' + countdown + ')');
                            countdown -= 1;
                        } else {
                            btn.text(origin_mobile_check_btn_text);
                            btn.attr('disabled', false);
                            clearInterval(interval);
                        }
                    }, 1000);
                } else {
                    btn.attr('disabled', false);
                    btn.text(origin_mobile_check_btn_text);
                    swal(result.message, '', 'error');
                }
            },
            erroe: function(xhr, ajaxOptions, thrownError) {
                console.log(xhr);
                console.log(ajaxOptions);
                console.log(thrownError);
                btn.attr('disabled', false);
                btn.text(origin_mobile_check_btn_text);
            }
        });

        return false;
    });

    // 依據登入者的智能媒合設定來定義初始的分組
    make_default_changeIntelligent();
    make_intelligent_slider_bar(true);

    // 選擇智能分組
    $('.click_radio').on('click',function(){
        changeIntelligent = $(this).val();
        setCurrentRoiSetting();
    });

    // 儲存投資習慣設定
    $(".save_custom_setting_btn").on('click',function(e) {
        e.preventDefault();

        validation();

        var slider_first_A = $('.slider-first-A').get(0).innerHTML.split('：')[1].split('%')[0];
        var slider_first_B = 100 - Number(slider_first_A);

        var slider_second_C = $('.slider-second-C').get(0).innerHTML.split('：')[1].split('%')[0];
        var slider_second_D = $('.slider-second-D').get(0).innerHTML.split('：')[1].split('%')[0];
        var slider_second_E = $('.slider-second-E').get(0).innerHTML.split('：')[1].split('%')[0];

        var slider_third_AB = $('.slider-third-AB').get(0).innerHTML.split('：')[0].split('%')[0];
        var slider_third_CDE = $('.slider-third-CDE').get(0).innerHTML.split('：')[0].split('%')[0];
        var slider_third_AB_label = $('.slider-third-AB-label').get(0).innerHTML.split('：')[0].split('%')[0];
        var slider_third_CDE_label = $('.slider-third-CDE-label').get(0).innerHTML.split('：')[0].split('%')[0];

        var unique_block = $('#unique_block').get(0).innerHTML.split('：')[0];

        var estimated_array;

        if(changeIntelligent == 'first') {
            estimated_array = [['A',slider_first_A],['B',slider_first_B]]
        } else if(changeIntelligent == 'second') {
            estimated_array = [['C',slider_second_C],['D',slider_second_D],['E',slider_second_E]]
        } else if(changeIntelligent == 'average') {
            estimated_array = [['A',20],['B',20],['C',20],['D',20],['E',20]]
        } else if(changeIntelligent == 'third') {
            estimated_array = [[slider_third_AB_label,slider_third_AB],[slider_third_CDE_label,slider_third_CDE]]
            console.log(estimated_array );
        } else {
            estimated_array = [[unique_block,100]]
        }

        var message = "已成功儲存投資習慣設定。";
        if(user_info_check != ""){
            message += user_info_check;
        }

        $.ajax({
            type: "POST",
            url: '/users/'+user_id+'/custom_settings',
            dataType: 'json',
            data: { roi_setting_id: user_risk_category, estimated_array:JSON.stringify(estimated_array) },
            success: function(data,status,xhr) {
                swal(message, "", "info");
            },
            erroe: function(xhr, ajaxOptions, thrownError) {
                console.log(xhr);
                console.log(ajaxOptions);
                console.log(thrownError);
            }
        });
    });

    $('#agree_contract_btn').click(function(){
        $('#user_registration_form').submit();
    });

    // 讓地址一致
    $('#the_same_address').prop('checked',false) // 預設不勾
    $('#the_same_address').click(function(){
        contact_address = $('#user_residence_address').val();
        contact_country = $('#user_residence_country').val();
        contact_district = $('#user_residence_district').val();
        $('#user_contact_address').val(contact_address);
        $('#user_contact_country').val(contact_country);

        var districts = districtList[contact_country]
        var optionHTML = ""
        $("#user_contact_district").html("")
        districts.forEach(function(district){
            optionHTML += "<option value="+ district +">"+ district +"</option>"
        })
        $("#user_contact_district").html(optionHTML)
        $('#user_contact_district').val(contact_district);


    });

    // 送出風險評量
    $('.questionnaire_form').find(':submit').click(function(){
        var check_question_2 = $('[id^="questionnaire_question_2_"]:checked').length;
        var check_question_3 = $('[id^="questionnaire_question_3_"]:checked').length;

        if(check_question_2 == 0) {
            swal('請勾選您的家庭平均年收入', '', 'error');
            return false;
        } else if(check_question_3 == 0) {
            swal('請勾選您曾經投資的產品', '', 'error');
            return false;
        } else {
            return true;
        }
    });

});

// 檢查必填欄位
var validation = function(){
    if($('#input_amount').val() == ""){
        $('.input_amount_errmsg').text('投資金額不可為空值。');
    }
};

// 依據登入者的智能媒合設定來定義初始的智能分組
var roiSetting_mappimg_changeIntelligent = {first: 1, second: 2, average: 3, third: 4, fourth: 5}
var make_default_changeIntelligent = function(){
    for (var mapping in roiSetting_mappimg_changeIntelligent){
        if(roiSetting_mappimg_changeIntelligent[mapping] == user_risk_category){
            changeIntelligent = mapping;
            break;
        }
    }
    $('#groupingRadios'+user_risk_category).prop('checked', true);
};

var setCurrentRoiSetting = function(){
    user_risk_category = roiSetting_mappimg_changeIntelligent[changeIntelligent];
};

// 檢查必填欄位
var validation = function(){
    if(changeIntelligent == ""){
        alert('請選擇風險設定。');
    }
};
