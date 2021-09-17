$(document).ready(function(){
    $('#business_product_a').click(function(){
      link_to_loan();
    });
    $('#business_product_b').click(function(){
      link_to_loan();
    });
    $('#business_product_c').click(function(){
      link_to_loan();
    });
    var link_to_loan = function(){
      window.location.href="/front/loan";
    };
});
