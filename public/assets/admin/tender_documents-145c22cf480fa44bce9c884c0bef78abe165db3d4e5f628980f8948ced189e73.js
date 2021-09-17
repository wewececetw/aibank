var tender_document_claim_id_select2;

$(function() {
  tender_document_claim_id_select2 = $("#tender_document_claim_id").select2({
    theme: "bootstrap",
    width: "100%",
    placeholder: I18n.t("helpers.select.prompt"),
    allowClear: true,
    ajax: {
      url: "/admin/tender_documents/claims_for_select2",
      dataType: "json",
      type: "POST",
      data: function(params) {
        var query = {
          search: params.term,
          page: params.page || 1,
          per: 10
        };

        return query;
      },
      processResults: function(data, params) {
        params.page = params.page || 1;

        return {
          results: data.results,
          pagination: {
            more: params.page * data.per < data.filtered_count
          }
        };
      },
      delay: 250
    }
  });

  $("#export-uncollected").click(function(e) {
    $.ajax({
      type: "POST",
      url: "/admin/tender_documents/export_uncollected/",
      dataType: "json",
      success: function(data, status, xhr) {
        export_url = data[0]["url"];
        console.log(location.href);
        console.log(export_url);
        location.href = "../" + export_url;
      },
      error: function(xhr, ajaxOptions, thrownError) {
        console.log(xhr);
        console.log(ajaxOptions);
        console.log(thrownError);
      }
    });
  });

  $(".export_tender_repayment").click(function(e) {
    var date = $("#repayment_date").val();
    var type = $(this).data("type");
    var foreign = $(this).data("foreign");
    if (date == "") {
      console.log("no date");
      return false;
    }
    $.ajax({
      type: "POST",
      url: "/admin/tender_documents/download_repayment/",
      dataType: "json",
      data: { date: date, type: type, foreign: foreign },
      success: function(data, status, xhr) {
        export_url = data[0]["url"];
        location.href = "../" + export_url;
      },
      error: function(xhr, ajaxOptions, thrownError) {
        console.log(xhr);
        console.log(ajaxOptions);
        console.log(thrownError);
      }
    });
  });

  $("#import-uncollected-confirm").click(function(e) {
    uncollected = $("#uncollected_xlsx").prop("files");
    console.log(uncollected);
    $.ajax({
      type: "POST",
      url: "/admin/tender_documents/check_import_uncollected/",
      dataType: "json",
      data: { uncollected: uncollected },
      success: function(data, status, xhr) {
        console.log(data);
        export_url = data[0]["url"];
        console.log(location.href);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        console.log(xhr);
        console.log(ajaxOptions);
        console.log(thrownError);
      }
    });
  });

  $("#export_invoice").click(function(e) {
    $.ajax({
      type: "POST",
      url: "/admin/tender_documents/download_invoice/",
      dataType: "json",
      success: function(data, status, xhr) {
        export_url = data[0]["url"];
        location.href = "../" + export_url;
      },
      error: function(xhr, ajaxOptions, thrownError) {
        console.log(xhr);
        console.log(ajaxOptions);
        console.log(thrownError);
      }
    });
  });

  $("#export_abnormal").click(function(e) {
    $.ajax({
      type: "POST",
      url: "/admin/tender_documents/download_abnormal/",
      dataType: "json",
      success: function(data, status, xhr) {
        export_url = data[0]["url"];
        location.href = "../" + export_url;
      },
      error: function(xhr, ajaxOptions, thrownError) {
        console.log(xhr);
        console.log(ajaxOptions);
        console.log(thrownError);
      }
    });
  });

  $("#export-all").click(function() {
    $.ajax({
      type: "POST",
      url: "/admin/tender_documents/download_all/",
      dataType: "json",
      success: function(data, status, xhr) {
        export_url = data[0]["url"];
        location.href = "../" + export_url;
      },
      error: function(xhr, ajaxOptions, thrownError) {
        console.log(xhr);
        console.log(ajaxOptions);
        console.log(thrownError);
      }
    });
  });

  $("#export_tax_list").click(function(e) {
    var year = $("#tax_year").val();

    $.ajax({
      type: "POST",
      url: "/admin/tender_documents/download_tax_list/",
      dataType: "json",
      data: { year: year },
      success: function(data, status, xhr) {
        export_url = data[0]["url"];
        location.href = "../" + export_url;
      },
      error: function(xhr, ajaxOptions, thrownError) {
        console.log(xhr);
        console.log(ajaxOptions);
        console.log(thrownError);
      }
    });
  });
});
