$(function(){
  //電話格式檢查
  var reg_phoneTel=/^09[0-9]{8}$/;

  // Switch tab
  $(function() {
	  $(".btn").click(function() {
      $(".form-signin").toggleClass("form-signin-left");
      $(".form-signup").toggleClass("form-signup-left");
      $(".frame").toggleClass("frame-long");
      $(".signup-inactive").toggleClass("signup-active");
      $(".signin-active").toggleClass("signin-inactive");
      $(".forgot").toggleClass("forgot-left");
      $(this).removeClass("idle").addClass("active");
	  });
  });

  $(function() {
    $(".btn-signup").click(function() {
      $(".nav").toggleClass("nav-up");
      $(".form-signup-left").toggleClass("form-signup-down");
      $(".success").toggleClass("success-left");
      $(".frame").toggleClass("frame-short");
    });
  });

  $(function() {
    $(".btn-signin").click(function() {
      $(".btn-animate").toggleClass("btn-animate-grow");
      $(".welcome").toggleClass("welcome-left");
      $(".cover-photo").toggleClass("cover-photo-down");
      $(".frame").toggleClass("frame-short");
      $(".profile-photo").toggleClass("profile-photo-down");
      $(".btn-goback").toggleClass("btn-goback-up");
      $(".forgot").toggleClass("forgot-fade");
    });
  });


  $(".sign-up-button").click(function(){

    user_email = $(".reg_email")[0].value;
    user_name = $("#user_name")[0].value;
    user_id_card_number = $("#user_id_card_number")[0].value;
    user_phone_number = $("#user_phone_number")[0].value;
    user_password = $(".reg_password")[0].value;
    user_password_confirmation = $("#user_password_confirmation")[0].value;
    user_come_from_info_text = "不需填寫"
    if(["phone_sales","recommendation_from_sales","recommendation","others"].includes($("#user_come_from_info").val())){
      if($("#user_come_from_info").val() == "recommendation" && $("#user_come_from_info_text").val() == ""){
        //Keep the user_come_from_info_text with static value
      }
      else{
        user_come_from_info_text = $("#user_come_from_info_text").val()
      }
    }

    if( user_email == ""){
      $(".reg_email")[0].focus();
      swal("提示", "信箱不能為空白", "error");
      return false;
    }
    // else if (!reg_Email.test(user_email)) {
    //   $(".reg_email")[0].focus();
    //   swal("提示", "信箱格式有誤", "error");
    //   return false;
    // }

    if( user_name == ""){
      $("#user_name")[0].focus();
      swal("提示", "姓名不能為空白", "error");
      return false;
    }

    if( user_id_card_number == ""){
      $("#user_id_card_number")[0].focus();
      swal("提示", "身分證字號不能為空白", "error");
      return false;
    }

    if(!checkID(user_id_card_number)){
      $("#user_id_card_number")[0].focus();
      swal("提示", "身分證字號格式有誤", "error");
      return false;
    }

    if( user_phone_number == ""){
      $("#user_phone_number")[0].focus();
      swal("提示", "手機號碼不能為空白", "error");
      return false;
    }else if (!reg_phoneTel.test(user_phone_number)) {
      $("#user_phone_number")[0].focus();
      swal("提示", "手機號碼格式有誤", "error");
      return false;
    }

    if( user_password == ""){
      $(".reg_password")[0].focus();
      swal("提示", "密碼不能為空白", "error");
      return false;
    }

    if( user_password_confirmation == ""){
      $("#user_password_confirmation")[0].focus();
      swal("提示", "確認密碼不能為空白", "error");
      return false;
    }

    if( user_password != user_password_confirmation ){
      swal("提示", "密碼與確認密碼必須相同", "error");
      return false;
    }
    if( user_come_from_info_text == "" ){
      $("#user_come_from_info_text").focus();
      swal("提示", "得知管道資料不齊全", "error");
      return false;      
    }

  });

  $('#agree_contract_btn').click(function(){
      $('#user_registration_form').submit();
      $('#agree_contract_btn').attr('disabled', true);
  });

  // Detect come_from_info to show come_from_info_text
  $('#user_come_from_info').change(function(){
      if(["phone_sales","recommendation_from_sales"].includes($(this).val())){
        $('.come_from_info_text').show()
        $('#user_come_from_info_text').prop("placeholder","請填寫推薦代碼")
      }
      else if($(this).val() == "recommendation" ){
        $('.come_from_info_text').show()
        $('#user_come_from_info_text').prop("placeholder","請填寫親友的推薦代碼(選填)")
      }
      else if($(this).val() == "others" ){
        $('.come_from_info_text').show()
        $('#user_come_from_info_text').prop("placeholder","請填寫得知訊息管道")
      }
      else{
        $('.come_from_info_text').hide()       
      }
  })
  function checkID(id) {
    tab = "ABCDEFGHJKLMNPQRSTUVXYWZIO"
    A1 = new Array(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 3, 3, 3, 3, 3, 3);
    A2 = new Array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 1, 2, 3, 4, 5);
    Mx = new Array(9, 8, 7, 6, 5, 4, 3, 2, 1, 1);

    if (id.length != 10) return false;
    i = tab.indexOf(id.charAt(0));
    if (i == -1) return false;
    sum = A1[i] + A2[i] * 9;

    for (i = 1; i < 10; i++) {
      v = parseInt(id.charAt(i));
      if (isNaN(v)) return false;
      sum = sum + v * Mx[i];
    }
    if (sum % 10 != 0) return false;
    return true;
  }

});
