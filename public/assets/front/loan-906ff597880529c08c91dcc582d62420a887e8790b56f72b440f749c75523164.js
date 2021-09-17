AOS.init({
  easing: "ease-out-back",
  duration: 1000
});

$(document).ready(function() {
  $("#button_rewrite").on("click", function() {
    $("#loan_name").val("");
    $("#loan_dob").val("yyyy/mm/dd");
    $("#loan_id_number").val("");
    $("#loan_cellphone_number").val("");
    $("#loan_telephone_number").val("");
    $("#loan_address").val("");
    $("#loan_company_name").val("");
    $("#loan_job_title").val("");
    $("#loan_monthly_salary").val("");
    $("#loan_company_phone").val("");
    $("#loan_building_location").val("");
    $("#loan_building_numbers").val("");
    $("#loan_land_numbers").val("");
    $("#loan_car_type").val("");
    $("#loan_car_brand").val("");
    $("#loan_car_model").val("");
    $("#loan_plate_number").val("");
    $("#loan_car_capacity").val("");
    $("#loan_car_color").val("");
    $("#loan_production_at").val("yyyy/mm/dd");
    $("#loan_description").val("");
    $("#loan_check_amount").val("");
    $("#loan_expire_at").val("yyyy/mm/dd");
    $("#loan_drawer").val("");
    $("#loan_check_number").val("");
    $("#loan_bank").val("");
    $("#loan_bank_branch").val("");
    $("#loan_amount").val("");
    $("#loan_periods").val("");
  });

  $("#loan-select").change(function() {
    var loanSelected = $(this)
      .find("option:selected")
      .attr("data-id");
    $(".loan_select_area").hide();
    $("#" + loanSelected).show();
  });

  $("#loan_amount").change(function() {
    loan_amount = $(this).val();
    if (Number(loan_amount) < 1) {
      swal("請填入正確貸款金額", "", "error");
    }
  });

  $("#loan_periods").change(function() {
    loan_periods = $(this).val();
    if (Number(loan_periods) < 1) {
      swal("請填入正確期數", "", "error");
    }
  });

  $("#captcha")
    .attr("placeholder", "")
    .val("");
  if (window.location.href.indexOf("#loan_from") != -1) {
    $("#loan_form").modal();
  }
  $(".loan_apply").on("click", function() {
    $("#loan_form").modal();
  });

  $("#loan_form_button").click(function() {
    $("#loan_form").modal();
    // var check = confirm("豬豬在線貸款專區產品還在建制中，目前僅提供個人信用貸款引介服務，只要您名下有機車即可申請，申請書完成後將有專員主動與您連絡")
    // if(check){

    // }
  });
});
