$("#claims").tablesorter();

// 立即投資按鈕點擊後，如無登入就跳 loginNoticeAlert
$("#invest").click(function(){
    var user_id = $('#user_id').text();
    if(user_id === ""){
        loginNoticeAlert();
        return false;
    }
    else{
        location.href="/front/claim_match"
    }              
})
$("body").on("click",".favorite_star",function(){
    var user_id = $('#user_id')[0].innerText;
    var claim_id = $('#claim_id')[0].innerText;
    var img = $(this)
    if(user_id === ""){
        loginNoticeAlert();
        return false;
    }
    $.ajax({ 
        type : "POST", 
        url : "/front/update_favorite", 
        data : {user_id: user_id, claim_id: claim_id},
        complete : function(result) { 
            if(result.responseText=="created"){
                swal("已收藏","", "success");
                img.prop("src","/template/images/favorited.png")
            }
            else{
                swal("已取消收藏","", "warning");
                img.prop("src","/template/images/unfavorited.png")
            }
        }
    });
    
})


$(".tender_document_detail").click(function() {
    var claim_id = $(this).attr("name");
    var claim_info_url = '/front/claim_detail/?id=' + claim_id;
    $.get( claim_info_url, function( data ) {
        //console.log(data);
        var type = "<%= params[:type] == 'special'  %>";
        $("#claim_detail").html(data);
        $("#exampleModalLong2").modal()
    });
});
function send_tender_button() {
    var claim_id = $('#claim_id')[0].innerText;
    var user_id = $('#user_id')[0].innerText;
    var check_user_info = $('#check_user_info')[0].innerText;
    var bank_profile = $('#bank_profile')[0].innerText;
    var subscription_value = $('#subscription_value')[0].innerText;


    if(user_id === ""){
        loginNoticeAlert();
        return false;
    }

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

    window.location.href = "/users/sign_in";
};
