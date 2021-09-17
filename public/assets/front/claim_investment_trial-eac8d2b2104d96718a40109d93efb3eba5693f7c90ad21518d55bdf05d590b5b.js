function claim_count(){
  var amount = $('#investment_amount').val();
  var claim_id = $('#display_claim_id').text();
  $('.appendTag').html("");
  getJson(claim_id,amount);

  function getJson(claim_id,amount) {
      url = "/front/claim_info_count.json?id="+claim_id+"&amount="+amount
      $.getJSON(url,function(result){  // front_claim_info_count
          if(result[0] === false) {
              swal(result[1], '', 'error');
          } else {
             // console.log(result);
              $.each(result, function(i, reword){
                  appendTag(reword);
              });

              const reducer = (accumulator, currentValue) => accumulator + currentValue;

              amount_sum = result.map(function(thing){ return thing[1] + thing[4] }).reduce(reducer)
              principal_sum = result.map(function(thing){ return thing[2]}).reduce(reducer)
              interest_sum = result.map(function(thing){ return thing[3] }).reduce(reducer)

              tag ='<tr style="height: 40px;">'+
              '<td align="center"> 總計 </td>'+
              '<td align="center">' + fmoney(amount_sum,0) + ' 元 </td>'+
              '<td align="center">' + fmoney(principal_sum,0) + ' 元 </td>'+
              '<td align="center">' + fmoney(interest_sum,0) + ' 元 </td>'+
              '</tr>';

              $('.appendTag').append(tag);
          }
      });
  }

  function appendTag(reword) {
      tag = '<tr style="height: 40px;">'+
          '<td align="center">' + reword[0] + '</td>'+
          '<td align="center">' + fmoney(reword[1]+reword[4],0) + ' 元 </td>'+
          '<td align="center">' + fmoney(reword[2],0) + ' 元 </td>'+
          '<td align="center">' + fmoney(reword[3],0) + ' 元 </td>'+
          '</tr>';

      $('.appendTag').append(tag);
  }
};
function count_clear(){
  $("#investment_amount").val("");
  $('.appendTag').html("");
};
