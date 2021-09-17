$(function() {

  // 開啟帳戶影本
  $('[name="image_button"]').on('click', function() {
    index = this.id.substring(13)
    images_data = $('#images_data').val();
    accounts_data = $('#accounts_data').val();
    images_data_arr = images_data.substring(1, Number(images_data.length-1))
    accounts_data_arr = accounts_data.substring(1, Number(accounts_data.length-1))

    var images_data_arr = images_data_arr.split(",");
    image_url = images_data_arr[Number(index)]
    first_index = image_url.indexOf('"');
    image_url = image_url.substring(first_index+1 , Number(image_url.length-1))

    var accounts_data_arr = accounts_data_arr.split(",");
    account = accounts_data_arr[Number(index)]
    first_index = account.indexOf('"');
    account = account.substring(first_index+1 , Number(account.length-1))

    $("#account_file_image").attr('src', image_url);
    $(".modal-body a").attr('href', image_url)
    $(".modal-title").html('帳戶影本,帳號：'+account)
  });

});
