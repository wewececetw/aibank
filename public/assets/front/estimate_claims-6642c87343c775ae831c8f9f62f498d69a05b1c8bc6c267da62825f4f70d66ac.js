var changeIntelligent = ''; // 定義目前選擇、登入者預設的智能媒合設定

var estimate_claims_checked_ids = []; // 已詳閱並同意勾選的編號
var selected_claim = ""; //Global variable, store seleted claim element

// 檢查必填欄位
var validation = function(){
    if($('#input_amount').val() === ""){
        $('.input_amount_errmsg').text('投資金額不可為空值。');
        return false;
    }

    if($('.current_block').html().trim() === ""){
        swal("請更換智能組合。", "", "warning");
        return false;
    }

    return true;
};

// 依據登入者的智能媒合設定來定義初始的智能分組
var roiSetting_mappimg_changeIntelligent = {first: 1, second: 2, average: 3, third: 4, fourth: 5};
var make_default_changeIntelligent = function(){
    for (var mapping in roiSetting_mappimg_changeIntelligent){
        if(roiSetting_mappimg_changeIntelligent[mapping] == user_risk_category){
            changeIntelligent = mapping;
            break;
        }
    }
    $('#groupingRadios'+user_risk_category).prop('checked', true);
};

// 依據目前的 changeIntelligent 變數值來改變目前呈現的智能分組
var change_current_risk_block = function(){
    var selected_risk = $('.'+ changeIntelligent +'_intelligent_block');

    var _id = selected_risk.find('select').data('id');
    var _color;

    var blockHtml = selected_risk.html();
    $('.current_block').html(blockHtml);
    $('.current_block').find('.noUi-base').remove();

    if($('.current_block').html().trim() !== ""){
        make_intelligent_slider_bar(false);
        if(_id === 'proportion-slider-third'){
            _color = selected_risk.find("select[data-target='first'] option:selected").attr('value');
            change_slider_color_and_text(_id, 'first', _color, true);

            _color = selected_risk.find("select[data-target='second'] option:selected").attr('value');
            change_slider_color_and_text(_id, 'second', _color, true);
        } else if(_id === 'proportion-slider-forth'){
            _color = selected_risk.find("select option:selected").attr('value');
            change_slider_color_and_text(_id, '', _color, true);
        }
    }
};

var click_count = 0; // 點擊次數

// 點擊 row 跳出債權明細 modal
var addIntelligentClaimsRowClickEvent = function(row, can_tender) {
    $(row).off('mouseover').on('mouseover', function() {
        $(row).css( 'cursor', 'pointer' );
    });

    $(row).find('td:not(".func")').off('click').on('click', function() {
        // console.log($(this)["0"].attributes["1"].nodeValue);
        var claim_id = $(row).attr('data-id');
        var claim_info_url = '/front/claim_detail/?id=' + claim_id;
        $.get( claim_info_url, function( data ) {
            //console.log(data);
            $("#claim_detail").html(data);
            $("#send_tender").remove();
            $('#exampleModalLong2').modal('show');
        });
    });
};

// 檢查是否解鎖購買按鈕disabled限制
var check_buy_intelligent_claims_disabled = function(estimated_datatable){
    var rows = estimated_datatable.rows().data();
    $('#buy_intelligent_claims').prop('disabled', !(estimate_claims_checked_ids.length === rows.length) );
}

$(function(){
    // 依據登入者的智能媒合設定來定義初始的分組
    make_default_changeIntelligent();
    change_current_risk_block();
    make_intelligent_slider_bar();

    // 智能媒合結果 datatable
    var estimated_datatable = $('#claim-intelligent-table').DataTable({
        // responsive: true,
        select: true,
        searching: false,
        lengthChange: false,
        language : {
            "info": "顯示 _START_ 到 _END_ 筆，共 _TOTAL_ 筆",
            "infoEmpty": "無符合的資料",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "lengthMenu": "顯示 _MENU_",
            "zeroRecords": "無符合的資料",
            "processing": "搜尋中，請稍後，如久無反應請重新整理頁面。",
            "paginate": {
                "previous": "前一頁",
                "next": "後一頁",
            },           
        },
        columns:[
            {
                // 同意合約
                data: null,
                visible: true,
                orderable: false,
                searchable: false,
                className: 'black func',
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-th', '同意協議書'); 
                },
                render: function (data, type, full, meta){
                    return '<label><input type="checkbox" name="id[]" value="' + data.id + '" class="agreement_checkbox" style="color:black"> 已詳閱並同意 <br/> <a href="#" data-claim_id="'+ data.id +'" data-tender_amount="'+ data.tender_amount +'" class="download_agreement_pdf">債權讓售協議書</a></label>';
                }

            },

            {
                data: null,
                visible: true,
                orderable: true,
                className: 'fcolor',
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-th', '風險等級'); 
                },
                render: function(data, type, full, meta) {
                    var html_content = '';

                    if(data.interest_rate != undefined){
                        html_content += '<div class="interest_rate '+ data.interest_rate.category.toLowerCase() + '_category">'+ data.interest_rate.category +'</div>\n';
                    }

                    return html_content;
                },
            },
            {
                data: null,
                visible: true,
                orderable: true,
                className: 'fcolor2',
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-th', '年化收益'); 
                },

                render: function(data, type, full, meta) {
                    var html_content = '';

                    if(data.interest_rate != undefined){
                        html_content += '<div class="interest_rate_text">'+ data.interest_rate.rate +'%</div>';
                    }

                    return html_content;
                },
            },
            {
                data: 'claim_number',
                name: 'claim_number_eq',
                visible: true,
                orderable: false,
                searchable: true,
                className: 'black',
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-th', '物件編號'); 
                },
            },
            {
                data: 'staging_amount',
                name: 'staging_amount',
                visible: true,
                orderable: true,
                searchable: false,
                className: 'black',
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-th', '債權額度'); 
                },
                render: function(data, type, full, meta) {
                  return fmoney(data,0);
                }
            },
            {
                data: 'remaining_periods',
                name: 'remaining_periods',
                visible: true,
                orderable: true,
                searchable: false,
                className: 'black',
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-th', '期數'); 
                },
                render: function (data, type, full, meta){
                    return data + '期';
                }
            },
            {
                data: 'remaining_amount',
                name: 'remaining_amount',
                visible: true,
                orderable: true,
                searchable: false,
                className: 'fbold',
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-th', '剩餘金額'); 
                },
                render: function(data, type, full, meta) {
                  return fmoney(data,0);
                }
            },
            {
                data: 'launched_at',
                name: 'launched_at',
                visible: true,
                orderable: true,
                className: 'fbold',
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-th', '上架日期'); 
                },
            },
            {
                data: 'estimated_close_date',
                name: 'estimated_close_date',
                visible: true,
                orderable: true,
                className: 'fbold',
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-th', '預計結標日'); 
                },
            },
            {
                data: null,
                name: 'purchased_progress',
                visible: true,
                orderable: true,
                className: '',
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-th', '認購進度'); 
                },
                render: function ( data, type, full, meta ) {
                    var purchased_progress = Math.round(Number(data.purchased_progress)*100)/100;
                    var html_content = "";
                    html_content += '<div class="progress">';
                    html_content += '<div class="progress-bar progress-barpp" role="progressbar" aria-valuenow="'+ purchased_progress +'" aria-valuemin="0" aria-valuemax="100" style="width: '+ data.purchased_progress +'%;">';
                    html_content += '<div style="color:black">';
                    html_content += purchased_progress + '%';
                    html_content += '</div>';
                    html_content += '</div>';
                    html_content += '</div>';


                    return html_content;
                },
            },
            {
                data: null,
                name: 'paid_present',
                visible: true,
                orderable: true,
                className: '',
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-th', '繳款進度'); 
                },
                render: function ( data, type, full, meta ) {
                    var html_content = "";
                    html_content += '<div class="progress">';
                    html_content += '<div class="progress-bar progress-barpp2" role="progressbar" aria-valuenow="'+ data.paid_percent +'" aria-valuemin="0" aria-valuemax="100" style="width: '+ data.paid_percent +'%;">';
                    html_content += '<div style="color:black">';
                    html_content += data.paid_percent + '%';
                    html_content += '</div>';
                    html_content += '</div>';
                    html_content += '</div>';

                    return html_content;
                },
            },
            {
                data: 'repayment_method',
                name: 'repayment_method',
                visible: true,
                orderable: true,
                className: 'black',
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-th', '還款方式'); 
                },
            },
            {
                data: 'tender_amount',
                name: 'tender_amount',
                visible: true,
                orderable: true,
                className: 'black',
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-th', '投資金額'); 
                },
            },
            {
                // 操作
                data: null,
                visible: true,
                orderable: false,
                searchable: false,
                className: 'black delete func',
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-th', '刪除'); 
                },
                render: function ( data, type, full, meta ) {
                    var id = data.id;
                    var actions = '<button type="button" data-toggle="modal" data-target="#ClaimDeleteModal" class="btn no-btn-style redemption_bt tender_repayment btn_nobg" ><i class="fa fa-times-circle f16" aria-hidden="true"></i></button>';
                    return actions;
                },
            }

        ],
        rowCallback: function( row, data, index ) {
            $(row).attr('data-claim_id', data.id);
            $(row).attr('data-id', data.id);
            $(row).attr('data-tender_amount', data.tender_amount);
            // $(row).attr('data-toggle', "modal");
            // $(row).attr('data-target', "#exampleModalLong2");
            $(row).find('.agreement_checkbox').prop('checked', estimate_claims_checked_ids.indexOf(data.id) !== -1);
            addIntelligentClaimsRowClickEvent(row, false);
        },
    });

    // 判斷是否可媒合
    $('.intelligent_bt').on('click',function(){
        user_id = $('#user_id').text()
        console.log(user_id);
        if(user_id == ''){
          $('.intelligent_bt').removeAttr('data-toggle');
          loginNoticeAlert();
          return;
        }
    });

    // 選擇智能分組
    $('.click_radio').on('click',function(){
        changeIntelligent = $(this).val();
    });

    // 關閉改變智能分組modal
    $('.close_change_intelligent_modal').on('click', function(){
        $('.change_intelligent_modal').modal('toggle');
    });

    $('.claim_intelligent_modal').focusin(function(){
        $('body').addClass('modal-open');
    });

    $('#ChangeIntelligentModal').focusin(function(){
        make_intelligent_slider_bar(false);
    });

    // 改變智能分組
    $('.change_check').on('click',function(){
        change_current_risk_block();
        // $('.change_intelligent_modal').modal('toggle');
    });

    // Binding event on delete td element for setting claim
    $('#claim-intelligent-table').on( 'click', 'tr td.delete', function () {
        $("#ClaimDeleteModal").modal()
        selected_claim = $(this).parent()
    });

    // 刪除選定的債權
    $('.confirm-delete-btn').on('click',function(){
        selected_claim.remove().draw( false );
    });

    // 下載債權讓售協議書
    $(document).on('click', '.download_agreement_pdf', function() {

        var user_id = $('#user_id').html();

        if(user_id === ""){
            loginNoticeAlert();
            return;
        }

        var claim_id = $(this).data('claim_id');
        var amount = $(this).data('tender_amount');
        window.open("/front/tender.pdf?id="+claim_id+"&amount="+amount);
    });

    // 勾選單一債權讓售協議書
    $(document).on('click', '.agreement_checkbox', function(){
        if( $(this).prop('checked') ) {
            //
            estimate_claims_checked_ids.push( parseInt( $(this).val() ) );
        } else {
            //
            var checked_id_index = estimate_claims_checked_ids.indexOf( parseInt( $(this).val() ) );
            estimate_claims_checked_ids.splice( checked_id_index, 1 );

            $('.check_all_agreement').prop('checked', false);
        }

        check_buy_intelligent_claims_disabled(estimated_datatable);
    });

    // 全部勾選債權讓售協議書
    $('.check_all_agreement').on('click', function(){
        $('.agreement_checkbox').prop('checked', $(this).prop('checked'));

        if( $(this).prop('checked') ) {
            var rows = estimated_datatable.rows().data();
            
            //
            for(var i = 0; i < rows.length; i++) {
                if( estimate_claims_checked_ids.indexOf( rows[i].id ) === -1 ) {
                    estimate_claims_checked_ids.push( rows[i].id );
                }
            }
        } else {
            //
            estimate_claims_checked_ids = [];
        }

        check_buy_intelligent_claims_disabled(estimated_datatable);
    });

    // 確認送出，購買媒合的債權
    $('#buy_intelligent_claims').on('click', function(){
        var rows = estimated_datatable.rows().data();
        var submit_row_datas = [];
        var row_data;

        var user_id = $('#user_id').html();
        check_user_info = $('#check_user_info').html();

        if(user_id === ""){
        loginNoticeAlert();
            return;
        }

        // 檢查用戶資訊是否完整填寫
        if(check_user_info != ""){ 
            swal(check_user_info, "", "error");
            return;
        }

        // 確認是否都勾選我看過並同意債權讓售協議書
        if( $('.agreement_checkbox:not(:checked)').length > 0 ){
            swal("請看過並同意所有債權讓售協議書", "", "error");
            return;
        }

        rows.each(function( row ){
            submit_row_datas.push({claim_id: row.id, amount: row.tender_amount});
        });

        // console.log(submit_row_datas);

        if (submit_row_datas.length < 1) {
            swal("請點選試算按鈕進行投資", "", "error");
            return;
        }

        swal({
          title: "確認購買此組合債權？",
          text: "已詳閱「債權讓售協議書」且確認購買所選之債權",
          icon: "info",
          buttons:  {
            cancel: "取消",
            defeat: "確定",
          },
        })
        .then((willDelete) => {
          if (willDelete) {
            var serialize_row_datas = JSON.stringify(submit_row_datas);
            window.location.href = "/front/tender_finish?claim="+serialize_row_datas;
          }
        });

        
    });

    // 智能媒合
    var estimate_claims = function(input_amount, estimated_array, input_period){

        loading_with_countdown();
        $.ajax({
            type: "POST",
            url: '/front/estimate_claims.json',
            data: { input_amount: input_amount * 10000, estimated_array: JSON.stringify(estimated_array), input_period: input_period, mode: "normal" },
            success: function(data,status,xhr) {
                $('body').loading('stop');
                investment_processing(data, input_amount, estimated_array, input_period)
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(xhr);
                console.log(ajaxOptions);
                console.log(thrownError);
                $('body').loading('stop');
            }
        });
    };

    // 用媒合後的資料產生內容到頁面上
    var render_intelligent_match_result = function(data) {
        estimated_benefit = ((data && data.estimated_benefit) || 0);
        real_reward_data = Math.round((data && data.real_reward) || 0);
        var element_benefit = $("#reward-benefit");
        var real_reward = $("#real-reward");
        real_reward.get(0).innerHTML = fmoney(real_reward_data,0);
        element_benefit.get(0).innerHTML = fmoney(estimated_benefit,0);

        estimate_claims_checked_ids = [];
        console.log(data);
        estimated_datatable.clear();
        if(data && data.claims){
            estimated_datatable.rows.add(data.claims);
        }
        estimated_datatable.draw();

        $('#buy_intelligent_claims').prop('disabled', true);
        $('.check_all_agreement').prop('checked', false);
        $('body').loading('stop');
    }

    // 執行試算按鈕
    $("#trial_income_btn").on('click',function(e) {
        if(!validation()){
            return false;
        }
        // 獲取智能分組調整比例資料
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
        // Get investment amount
        var input_amount = $('#input_amount').val();
         
        // Get selected periods
        var input_period = []

        $(".input-period:checked").each(function(index){
            if($(this).val().includes("<=")){
                var max_period = $(this).val().replace("<=","")
                for(var i = max_period; i > 0 ; i--){
                    input_period.push(i)
                }
            }
            else{
                input_period.push($(this).val())
            }
        })
        
        // remove duplicate number from <=
        input_period = input_period.filter(function(item, pos) {
            return input_period.indexOf(item) == pos;
        })


        var estimated_array;

        if(changeIntelligent == 'first') {
            estimated_array = [['A',slider_first_A],['B',slider_first_B]]
        } else if(changeIntelligent == 'second') {
            estimated_array = [['C',slider_second_C],['D',slider_second_D],['E',slider_second_E]]
        } else if(changeIntelligent == 'average') {
            estimated_array = [['A',20],['B',20],['C',20],['D',20],['E',20]]
        } else if(changeIntelligent == 'third') {
            estimated_array = [[slider_third_AB_label,slider_third_AB],[slider_third_CDE_label,slider_third_CDE]]
        } else {
            estimated_array = [[unique_block,100]]
        }

        estimate_claims(input_amount, estimated_array, input_period);
    });

    // 讓輸入數字之後，會將未滿3的數字變為3，大於3以上數字則會只保留整數部分。
    var delay = (function(){
      var timer = 0;
      return function(callback, ms){
        clearTimeout (timer);
        timer = setTimeout(callback, ms);
      };
    })();
    $('#input_amount').on('change', function(){
        // console.log($('#input_amount').val());
          if($('#input_amount').val() !== '') {
            $('#input_amount').val(Math.floor($('#input_amount').val()));
          }

          // 限制投資金額 3 - 1000萬
          if($('#input_amount').val() < 3 ) {
              swal("投資金額必須大於三萬");
              $('#input_amount').val(3);
          }
          if($('#input_amount').val() > 1000 ) {
              swal("投資金額必須小於一千萬");
              $('#input_amount').val(1000);
          }

    });

    // 讓輸入數字之後，點擊 enter 後不會送出 form。
    $('#input_amount').on('keydown', function(){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode === 13){
            return false;
        }
    });

    // Periods batch selected function
    $('#batch-selected').click(function(){
        if($(this).val() == "全選"){
          $(this).val("全不選")
          $('.input-period').each(function(){
            $(this).prop("checked", true);
          })
        }
        else{
          $(this).val("全選")
          $('.input-period').each(function(){
            $(this).prop("checked", false);
          })        
        }
    })

    // Function for displat loading with countdown
    function loading_with_countdown(){
        $('body').loading('start');

        $("div.loading-overlay-content").html("")
        // make countdown animation
        $("div.loading-overlay-content").append("LOADING...</br>請等候約<span id='waiting-time'>5</span> 秒鐘，為您產生試算結果")
        var countdown = setInterval(function(){
            if($("#waiting-time").text() > 0){
                $("#waiting-time").text($("#waiting-time").text()-1)
            }
            else{
                clearInterval(countdown);
            }
        }, 1000)
    }

    function investment_processing(data, input_amount, estimated_array, input_period){
                if( data.break_message !== "" ) { // 如果有風險類型的剩餘投標金額大於等於 1000，且總投標金額不足 30000，則要跳出提示訊息
                    swal(data.break_message, {
                        buttons: {
                            clear: {
                                text: "重新設定",
                                value: true,
                            },
                            agree: {
                                text: "隨機媒合",
                                value: false,
                            }
                        },
                    }).then((value) => {
                        if(value) {
                            render_intelligent_match_result(null);
                        }
                        else{
                            swal("系統會依照您投資的金額，隨機抓取 A ~ E , 不分期數債權做媒合", {
                                buttons: {
                                    clear: {
                                        text: "取消",
                                        value: false,
                                    },
                                    agree: {
                                        text: "確認",
                                        value: true,
                                    }
                                },
                            }).then((value) => {
                                if(value) {
                                    $.ajax({
                                        type: "POST",
                                        url: '/front/estimate_claims.json',
                                        data: { input_amount: input_amount * 10000, estimated_array: JSON.stringify(estimated_array), input_period: input_period, mode: "random" },
                                        beforeSend: function(){
                                            loading_with_countdown();                             
                                        },
                                        success: function(data) {
                                            // callback this function 
                                            investment_processing(data, input_amount, estimated_array, input_period)                                                                      
                                        }
                                    })
                                }
                                else{
                                    $('body').loading('stop');
                                }
                            })
                        }
                    });
                } else if( data.confirm_message !== "" ) { // 如果有風險類型的剩餘投標金額大於等於 1000，且總投標金額大於等於 30000，則要跳出提示訊息
                    swal(data.confirm_message, {
                        buttons: {
                            cancel: "取消",
                            agree: {
                                text: "同意",
                                value: true,
                            },
                        },
                    }).then((value) => {
                        if(value) {
                            render_intelligent_match_result(data)
                        } else {
                            render_intelligent_match_result(null);
                        }
                    });
                } else {
                    // Get investment limitation
                    var investment_limitation = parseInt($('#investment_limitation').text());
                
                    if(input_amount > investment_limitation){
                        swal('此結果僅做試算使用，投資超過限額將無法投標',"","info");                        
                    }
                    render_intelligent_match_result(data)
                }        
    }


});
