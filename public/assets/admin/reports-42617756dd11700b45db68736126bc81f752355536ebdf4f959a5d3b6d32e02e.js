// Place all the behaviors and hooks related to the matching controller here.
// All this logic will automatically be available in application.js.

$(function() {



  $('#export_client_button').click(function(e){
    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val();
    $.ajax({
        type: "POST",
        url: '/admin/reports/client_export',
        dataType: 'json',
        data: {start_date:start_date, end_date:end_date},
        success: function(data,status,xhr) {
          export_url = data[0]['url']
          console.log(location.href);
          location.href = '../'+export_url;
        },
        erroe: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr);
            console.log(ajaxOptions);
            console.log(thrownError);
        }
    });
  });


  $('#export_claim_button').click(function(e){
    query_date_id = $('#query_date_id').val();
    $.ajax({
        type: "POST",
        url: '/admin/reports/claim_export',
        dataType: 'json',
        data: {query_date:query_date_id},
        success: function(data,status,xhr) {
          export_url = data[0]['url']
          console.log(location.href);
          location.href = '../'+export_url;
        },
        erroe: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr);
            console.log(ajaxOptions);
            console.log(thrownError);
        }
    });
  });


  $('#unpay_export_button').click(function(e){
    query_date_id = $('#query_date_id').val();
    $.ajax({
        type: "POST",
        url: '/admin/reports/unpay_export',
        dataType: 'json',
        data: {query_date:query_date_id},
        success: function(data,status,xhr) {
          export_url = data[0]['url']
          console.log(location.href);
          location.href = '../'+export_url;
        },
        erroe: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr);
            console.log(ajaxOptions);
            console.log(thrownError);
        }
    });
  });


  $('#export_loan_button').click(function(e){
    query_date_id = $('#query_date_id').val();
    loan_type = $('#loan_type_id').val();

    $.ajax({
        type: "POST",
        url: '/admin/reports/loan_export',
        dataType: 'json',
        data: {query_date:query_date_id,loan_type:loan_type},
        success: function(data,status,xhr) {
          export_url = data[0]['url']
          console.log(location.href);
          location.href = '../'+export_url;
        },
        erroe: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr);
            console.log(ajaxOptions);
            console.log(thrownError);
        }
    });
  });

  $('#export_recommendation_button').click(function(e){
    query_start_month = $('#query_start_month').val();
    query_end_month = $('#query_end_month').val();

    $.ajax({
        type: "POST",
        url: '/admin/reports/recommendation_export',
        dataType: 'json',
        data: {query_start_month:query_start_month, query_end_month:query_end_month},
        success: function(data,status,xhr) {
          export_url = data[0]['url']
          console.log(location.href);
          location.href = '../'+export_url;
        },
        erroe: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr);
            console.log(ajaxOptions);
            console.log(thrownError);
        }
    });
  });

  $('#loan_type_id').click(function(e){
    loan_type = $('#loan_type_id').val();
    console.log('loan_type',loan_type);
    $("[name=index_loan_type]").val(loan_type);
    console.log('index_loan_type',$("[name=index_loan_type]").val());

  });

});
