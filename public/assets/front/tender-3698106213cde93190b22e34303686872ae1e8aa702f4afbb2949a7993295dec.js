$(document).ready(function(){
  claim_id = $('#claim_id').val();
  min_investment_amount = $('#min_investment_amount').val();
  max_investment_amount = $('#max_investment_amount').val();
  $("#tender_btn").attr('disabled', true)

  is_checked = false;

    // $('#tender-table').DataTable( {
    //     responsive: true,
    //     paging:  false,
    //     info: false,
    //     filter: false,
    // } );

    // $('#tender-finish-table').DataTable( {
    //     responsive: true,
    //     paging:  false,
    //     info: false,
    //     filter: false,
    // } );

    $("#tender_btn").on('click',function() {
        var _this = $(this);
        if(_this.hasClass('lock')){
            return false;
        }
        _this.addClass('lock');
        $("#tender_btn").attr('disabled', true);
        amount = $('#investment_amount').val();
        amount = amount.replace(/\,/ig, "");
        if(is_checked == false){
            swal('請詳閱投資合約與應注意事項，並同意且接受合約及應注意事項所有條款無誤', '', 'info');
            $("#tender_btn").attr('disabled', false);
            _this.removeClass('lock');
        }else{
            if(!isNaN(amount)){
                // console.log('amount',amount);
                // console.log('is_checked',is_checked);
                if(Number(amount) >= Number(min_investment_amount) && Number(amount) <= Number(max_investment_amount)){
                    tender_finish();
                }else{
                    swal('請填入正確投標金額', '', 'error');
                    $("#tender_btn").attr('disabled', false);
                    _this.removeClass('lock');
                }
            }else{
                swal('請填入正確投標金額', '', 'error');
                $("#tender_btn").attr('disabled', false);
                _this.removeClass('lock');
            }
        }
    });

    $("#notice_checkbox").on('click', function() {
      if($('#notice_checkbox').get(0).checked) {
        $("#tender_btn").attr('disabled', false)
        is_checked = true;
      } else {
        $("#tender_btn").attr('disabled', true)
        is_checked = false;
      }
    })

    // 購買債權時的下載債權憑證
    $("#download_pdf").on('click', function() {
      amount = $('#investment_amount').val();
      amount = amount.replace(/\,/ig, "");
      if(Number(amount) >= Number(min_investment_amount) && Number(amount) <= Number(max_investment_amount)){
        window.open("/front/tender.pdf?id="+claim_id+"&amount="+amount);
      }else{
        swal('請填入正確投標金額', '', 'error');
      }
      // window.open("/claim_contract.pdf");
    })

    // 在我的標單下載債權憑證
    $('.js-myaccount_download_tender').on('click', function(){
        var tender_document_id = $(this).data('tender_document_id')
        var tender_amount = $(this).data('amount')
        window.open("/front/myaccount_download_tender.pdf?tender_document_id="+tender_document_id+"&amount="+tender_amount);
    });

    $('#investment_amount').change(function(){
      amount = $('#investment_amount').val();

      // 如果數值有千分位會判斷錯誤
      if( amount !== undefined ){
          amount = amount.replace(/\,/ig, "");
      }

      if(parseInt(amount) < parseInt(min_investment_amount)){
        amount = fmoney(min_investment_amount,0);
      }else if(parseInt(amount) > parseInt(max_investment_amount)){
        amount = fmoney(max_investment_amount,0);
      }else{
        amount = fmoney(Math.floor((amount/1000))*1000);
      }
      $('#investment_amount').val(amount);
      $('#put_in_amount').html(amount);
      $('#payment_amount').html(amount);
    });

    function tender_finish(){
        notice_checkbox = $('#notice_checkbox')
        claim_id = $('#claim_id').val();
        var claim_obj = [{claim_id: claim_id, amount: amount}];
        var claim = JSON.stringify(claim_obj); Target="_blank"
        console.log('tender_finish',claim);

        window.location.href = "/front/tender_finish?claim="+claim;
    }
});
