$(function() {
    $('#menu').on('change', function() {
        var url = $(this).val(); // get selected value
        if (url) { // require a URL
            window.open(url, '_top'); // open in a new tab
        }
        return false;
    });
});
$(function(){
    //檢查圖片大小
    $("#user_id_front,#user_id_back").on("change",function(){
        var _this =this;
        var reader = new FileReader();
        reader.readAsDataURL(this.files[0]);
        reader.onload = function (e) {
            var image = new Image();
            image.src = e.target.result;
            image.onload = function () {
                var height = this.height;
                var width = this.width;
                if(width<1024 || height < 768){
                    swal("圖片尺寸需至少 1024 x786 以上", "", "error"); 
                    _this.value="";
                    $("#"+_this.id+"_preview").attr("src", "");
                    var img_class = _this.id == "user_id_front" ? "uploadpreview 01" : "uploadpreview 02 uploadpreview_a";
                    $("#"+_this.id+"_preview").attr("class", img_class);
                    $("#"+_this.id+"_preview").attr("alt", "");

                }
            };

        };
    });

    $("#submit").on("click",function(){
        var url = $("form:last").attr("action");
        $.post(url,$("form").serialize())
        .success(function(data){
            if(data.success == "ok"){
                location.href="/users";
            }else{
                swal("驗證碼不正確", "", "error"); 
            }
        });
        return false;
    });

    $("#personal_submit").on("click", function(){
      var birthday = $("#user_birthday").val();
      if( birthday == "" ){
        swal("出生日期不能為空", "", "error"); 
        $("#user_birthday").focus();
        return false;  
      }

      var user_residence_address = $("#user_residence_address").val();
      if( user_residence_address == "" ){
        swal("戶籍地址不能為空", "", "error"); 
        $("#user_residence_address").focus();
        return false;  
      }
      var user_contact_address = $("#user_contact_address").val();
      if( user_contact_address == "" ){
        swal("通訊地址不能為空", "", "error"); 
        $("#user_contact_address").focus();
        return false;  
      }
      if( $("#user_id_front_preview").attr("src") == undefined || $("#user_id_front_preview").attr("src") == "" ){
        var user_id_front = $("#user_id_front").val();
        if( user_id_front == "" ){
          swal("身分證影本正面需上傳圖片", "", "error"); 
          $("#user_id_front").focus();
          return false;  
        }
      }

      if( $("#user_id_back_preview").attr("src") == undefined || $("#user_id_back_preview").attr("src") == "" ){
        var user_id_back = $("#user_id_back").val();
        if( user_id_back == "" ){
          swal("身分證影本背面需上傳圖片", "", "error"); 
          $("#user_id_back").focus();
          return false;  
        }
      }
      
      var mobile_check_token = $("#mobile_check_token").val();
      if( mobile_check_token == "" ){
        swal("驗證碼不能為空", "", "error"); 
        $("#mobile_check_token").focus();
        return false;  
      }
      
      $('body').loading({
          stoppable: false
      });
    })

    $("#user_id_front, #user_id_back").change(function(e){
        var img_id = "#"+this.id+"_preview"; 
        file_to_base64(e.target.files[0],function(base64){
          $(img_id).attr("src", base64);
          $(img_id).attr("style", "width: 10%;object-fit:contain;");
        });
    });

    function file_to_base64(file, callback){
        var reader = new FileReader();
        reader.onload = function (e){
          callback(e.target.result);
        }
        reader.readAsDataURL(file);
    }

    $("#user_residence_country").change(function(){ 
        var country = $(this).val()
        var districts = districtList[country]
        var optionHTML = ""
        $("#user_residence_district").html("")
        districts.forEach(function(district){
            optionHTML += "<option value="+ district +">"+ district +"</option>"
        })
        $("#user_residence_district").html(optionHTML)
    })

    $("#user_contact_country").change(function(){ 
        var country = $(this).val()
        var districts = districtList[country]
        var optionHTML = ""
        $("#user_contact_district").html("")
        districts.forEach(function(district){
            optionHTML += "<option value="+ district +">"+ district +"</option>"
        })
        $("#user_contact_district").html(optionHTML)
    })

    if($("#hide_contact_district").val() != ""){
        var country = $("#user_contact_country").val()
        var districts = districtList[country]
        var optionHTML = ""
        $("#user_contact_district").html("")
        districts.forEach(function(district){
            if($("#hide_contact_district").val() == district){
                optionHTML += "<option selected value="+ district +">"+ district +"</option>"
            }
            else{
                optionHTML += "<option value="+ district +">"+ district +"</option>"
            }
        })
        $("#user_contact_district").html(optionHTML)
    }

    if($("#hide_residence_district").val() != ""){
        var country = $("#user_residence_country").val()
        var districts = districtList[country]
        var optionHTML = ""
        $("#user_residence_district").html("")
        districts.forEach(function(district){
            if($("#hide_residence_district").val() == district){
                optionHTML += "<option selected value="+ district +">"+ district +"</option>"
            }
            else{
                optionHTML += "<option value="+ district +">"+ district +"</option>"
            }
        })
        $("#user_residence_district").html(optionHTML)
    }
    

});

