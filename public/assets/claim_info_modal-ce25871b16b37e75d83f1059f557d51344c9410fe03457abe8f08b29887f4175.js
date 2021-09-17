$(function(){
    var id = $('#claim_id').val();
    var user_id = $('#user_id').val();

    $('#claim-info-table').css('opacity','0');
    setTimeout(function(){
      $('#claim-info-table').DataTable( {
          responsive: true,
          paging:  false,
          info: false,
          filter: false,
      } );
      $('#claim-info-table').css('opacity','1');
    },300);


    $('#buy-table').DataTable( {
        responsive: true,
        paging:  false,
        info: false,
        filter: false,
    } );

    $('#investment-trial-table').DataTable( {
        responsive: true,
        paging:  false,
        info: false,
        filter: false,
    } );

    // 執行債權詳細資料 modal 的計算按鈕
    $("#count_btn").on('click',function() {
        var amount = $('#investment_amount').val();
        var claim_id = $('#display_claim_id').text();
        $('.appendTag').get(0).innerHTML = ''
        getJson(claim_id,amount);

        function getJson(claim_id,amount) {
            url = "/front/claim_info_count.json?id="+claim_id+"&amount="+amount
            $.getJSON(url,function(result){  // front_claim_info_count
                if(result[0] === false) {
                    swal(result[1], '', 'error');
                } else {
                    $.each(result, function(i, reword){
                        appendTag(reword);
                    });
                }
            });
        }

        function appendTag(reword) {
            tag = '<tr id=row' + reword[0] + ' data-count="'+ reword[0] +'">'+
                '<td><a>' + reword[0] + '</a></td>'+
                '<td><a>' + fmoney(reword[1]+reword[4],0) + '</a></td>'+
                '<td><a>' + fmoney(reword[2],0) + '</a></td>'+
                '<td><a>' + fmoney(reword[3],0) + '</a></td>'+
                '</tr>';
            $('.appendTag').append(tag);
        }

    });

    // 投標
    $("#send_tender").on('click',function() {
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

        window.location.href = "/front/tender?id="+claim_id;
    });

    

    $('.InvestmentTrialModalOpenButton').click(function(){
        $('.InvestmentTrialModal').modal();
    });

    $('.InvestmentTrialModalCloseButton').click(function(){
        $('.InvestmentTrialModal').modal('hide');
        $('body').addClass('modal-open');
        return false;
    });

    $('.InvestmentTrialModal').on('hide.bs.modal', function() {
    });

    $('.InvestmentTrialModal').on('hidden.bs.modal', function() {
        $('body').addClass('modal-open');
    });
});
