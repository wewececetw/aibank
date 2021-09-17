$(document).ready(function(){


    if(window.innerWidth <= 578){
        $("process-image-source").prop("src","/template/images/process_image_mobile.jpg")
    }

    $('#menu').on('change', function() {
        var url = $(this).val(); // get selected value
        if (url) { // require a URL
            window.open(url, '_top'); // open in a new tab
        }
        return false;
    });


    $(".investment_title").click(function(){
        $(".investment_content").slideToggle(1000)
    })


    $(".tender_repayment").click(function(){
        $.ajax({
            type: "POST",
            url: '/front/my_tender_repayments/',
            data: { tender_document_id:this.name},
            success: function(result) {
                $("#TenderRepayment").modal();
                console.log(result['tender_document'])
                tender_array = result['tender_document']
                array_length = tender_array.length
                tender_detail = '';
                return_invest = 0;
                interest = 0;
                fee = 0;
                return_total = 0;
                trturn_this_month_sum = 0
                for (var i = 0; i < array_length; i++) {
                    console.log(tender_array[i])
                    return_invest += Number(tender_array[i][2]);  // 返還投資金額
                    interest += Number(tender_array[i][3]); // 利潤
                    fee += Number(tender_array[i][4]);  // 手續費
                    return_total += Number(tender_array[i][1]);  // 返還淨值
                    trturn_this_month = (Number(tender_array[i][4]) + Number(tender_array[i][1])) // 總應返還
                    trturn_this_month_sum += trturn_this_month;
                    tender_tmp = '<tr>' +
                          '<td data-th="期數"><span class="fcolor">'+ (i+1) +'</span></td>' +
                          '<td data-th="應返還日"><span>'+ tender_array[i][7] +'</span> </td>' +
                          '<td data-th="還投資金額">' + tender_array[i][2]+ '</td>' +
                          '<td data-th="利潤"><span class="fbold">'+tender_array[i][3]+'</span> </td>' +
                          '<td data-th="手續費">' + tender_array[i][4]+ '</td>' +
                          '<td data-th="總應返還"><span class="fbold">'+ trturn_this_month +'</span></td>' +
                          '<td data-th="返還淨值">' + tender_array[i][1] + '</td>' +
                          '<td data-th="入帳日">' + (tender_array[i][5] == null ? "" : tender_array[i][5]) + '</td>' +
                          '<td data-th="返還日">' + (tender_array[i][6] == null ? "" : tender_array[i][6]) + '</td>' +
                        '</tr>';
                    tender_detail += tender_tmp;
                }

                tender_sum = '<tr>'+
                        '<td>總計</td>'+
                        '<td></td>'+
                        '<td>'+return_invest+'</td>'+
                        '<td>'+interest+'</td>'+
                        '<td>'+fee+'</td>'+
                        '<td>'+ trturn_this_month_sum +'</td>'+
                        '<td>'+return_total+'</td>'+
                        '<td></td>'+
                        '<td></td>'+
                        '<td></td>'+
                    '</tr>';

                tender_document = '<table id="" cellspacing="0" cellpadding="0" class="rwd-table tablesorter t_color ">'+
                        '<thead>'+
                            '<tr class="title_tr">' +
                              '<th data-field="action" data-formatter="ActionFormatter" width=""><span>期數</span></th>' +
                              '<th width=""><span>應返還日</span></th>' +
                              '<th width=""><span>返還投資金額</span></th>' +
                              '<th width=""><span>利潤</span></th>' +
                              '<th width=""><span>手續費</span></th>' +
                              '<th width=""><span>總應返還</span></th>' +
                              '<th width=""><span>返還淨值</span></th>' +
                              '<th width=""><span>入帳日</span></th>' +
                              '<th width=""><span>返還日</span></th>' +
                            '</tr>'+
                        '</thead>'+
                        '<tbody>'+
                            tender_detail +
                            tender_sum +
                        '</tbody>'+
                    '</table>';

                $('#tender_repayment_detail').html(tender_document)
            },
            erroe: function(xhr, ajaxOptions, thrownError) {
                console.log(xhr);
                console.log(ajaxOptions);
                console.log(thrownError);
            }
        });
    });

    var addRowClickEvent = function(claim_id) {
        var claim_info_url = '/front/claim_info/?id=' + claim_id;
        $.get( claim_info_url, function( data ) {
            var claim_modal = bootbox.dialog({
                title: '債權詳細資料',
                message: data,
                onEscape: function() {
                    var investmentTrialModalIsShown = ($(".InvestmentTrialModal").data('bs.modal') || {}).isShown;
                    if( investmentTrialModalIsShown ){
                        $(".InvestmentTrialModal").modal('hide');
                        return false;
                    }
                    $('.modal-backdrop').remove();
                },
                backdrop: true,
                className: "bootbox-modal-width", // 讓 modal 寬度增加
                closeButton: false
            });


            claim_modal.find('#send_tender').remove();
        });
    }; 

    var click_count = 0; // 點擊次數
    $('#investment-table tbody tr td:not(.operation_column)').on('click',function() {
        var row_elmt = $(this);
        click_count++;
        if (click_count === 1) {
            singleClickTimer = setTimeout(function() {
                click_count = 0;
                addRowClickEvent(row_elmt.parents('tr').data("claim_id"));
            }, 400);
        } else if (click_count === 2) {
            clearTimeout(singleClickTimer);
            click_count = 0;
        }
    });

    $(".tender_document_detail").click(function() {
        // console.log($(this)["0"].attributes["0"].nodeValue);
        var claim_id = $(this).attr("name");
        var claim_info_url = '/front/claim_detail/?id=' + claim_id;
        $.get( claim_info_url, function( data ) {
            $("#claim_detail").html(data);
            $("#send_tender").remove();
            if ($("div #failure")[0].className == "member_btn list_active"){
                $("#calculation_link").remove();
            }
        });
    });

});
