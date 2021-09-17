$(".claim_detail").click(function() {
    var claim_id = $(this).attr("name");
    var claim_info_url = '/front/claim_detail/?id=' + claim_id;
    $.get( claim_info_url, function( data ) {
        $("#claim_detail").html(data);
        $("#claim_detail_box").modal()
    });
});

function send_tender_button() {
    var claim_id = $('#claim_id')[0].innerText;
    var user_id = $('#user_id')[0].innerText;
    var check_user_info = $('#check_user_info')[0].innerText;
    var bank_profile = $('#bank_profile')[0].innerText;
    var subscription_value = $('#subscription_value')[0].innerText;

    if(check_user_info !== ''){ // 檢查用戶資訊是否完整填寫
        swal(check_user_info, "", "error");
        return false;
    }

    if(subscription_value >= 100 ) {
        swal('此債權已完成認購，請勿再投標。', "", "error");
        return false;
    }

    if(bank_profile == 0){
        swal('您的銀行帳戶尚未提交審核，或審核尚未通過', "", "error");
        return false;
    }

    window.location.href = "/front/tender?id="+claim_id;
};
