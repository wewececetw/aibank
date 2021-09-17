
var openedArticleHeight = 0
$(".collapsed").click(function(){
    var currentDisplayElement =  $('div#accordion .collapse')
    currentDisplayElement.hide()
    
    // if the current opened div element is larger than 500px, auto-target to clicked element position
    if(openedArticleHeight >= 500){
    $(window).scrollTop($(this).offset().top - (window.innerHeight/2) )
    }
    // using JQuery UI to customize show function
    $(this).closest(".card").find('.collapse').show("slide",{direction: 'up'}, 300)
    openedArticleHeight = $(this).closest(".card").find('.card-body').height()
})


;
