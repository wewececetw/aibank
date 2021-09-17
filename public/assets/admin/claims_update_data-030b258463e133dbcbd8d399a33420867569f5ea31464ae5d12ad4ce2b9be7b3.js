$(function() {


  // update claim status day
  var riskSliders_1 = document.getElementsByClassName('statusDaysSlider');

  for (var i = 0; i < riskSliders_1.length; i++) {
    riskSliders_1[i].oninput = function() {
      var riskSliderVal = this.closest('td').nextElementSibling.firstElementChild;
      riskSliderVal.innerHTML = this.value;
    };
  };

  $('#updateClaimStatusDays').on('click', function() {
    var data = $('.statusDaysSlider').serialize();
    $.ajax({
      url: '/admin/system_variables',
      method: 'PATCH',
      data: data,
      async: false
    });
  });

  // update interest rate 
  var riskSliders_2 = document.getElementsByClassName('riskSlider');

  for (var i = 0; i < riskSliders_2.length; i++) {
    riskSliders_2[i].oninput = function() {
      var riskSliderVal = this.closest('td').nextElementSibling.firstElementChild;
      riskSliderVal.innerHTML = this.value + '%';
    };
  };

  $('.updateInterestRates').on('click', function() {
    var data = $('.riskSlider').serialize();
    $.ajax({
      url: '/admin/system_variables',
      method: 'PATCH',
      data: data,
      async: false
    });
  });
  

});
