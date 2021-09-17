
    $(window).scroll(function() {
        //控制导航
        if ($(window).scrollTop() < 0) {
            $('#headdiv').stop().animate({ "top": "0px" }, 200);

            $('.nav2 .mmm').css("padding-top", "20px");
            $('.nav2 .sub').css("top", "0px");
            $('.top02').css("height", "60px");

        } else {
            $('#headdiv').stop().animate({ "top": "0px" }, 200);
            $('.top02').css("height", "60px");

            $('.nav2 .mmm').css("padding-top", "20px");
            $('.nav2 .sub').css("top", "60px");
        }
    });




    jQuery(".nav2").slide({ type: "menu", titCell: ".m", targetCell: ".sub", effect: "slideDown", delayTime: 300, triggerTime: 100, returnDefault: true });
 




    $(document).ready(function() {

        $('.top02').css("background-color", "rgba(255, 255, 255, 0.07)");

        $(".top02").mouseover(function() {
            $(".top02").css("background-color", "rgba(255, 255, 255, 0.2)");
        });
        $(".top02").mouseout(function() {
            $(".top02").css({ "background-color": "rgba(255, 255, 255, 0.07)" });

        });

    });


    $(function() {
        $(window).scroll(function() {
            var winTop = $(window).scrollTop();
            if (winTop >= 30) {
                $(".top02").addClass("sticky_h");
            } else {
                $(".top02").removeClass("sticky_h");
            } //if-else
        }); //win func.
    }); //ready func.


    $(function() {
        $(window).scroll(function() {
            var winTop = $(window).scrollTop();
            if (winTop >= 30) {
                $(".logo").addClass("logo_2");
            } else {
                $(".logo").removeClass("logo_2");
            } //if-else
        }); //win func.
    }); //ready func.










    
    $(window).scroll(function() {
        //控制导航
        if ($(window).scrollTop() < 30) {

            $('.logoa').css("display", "block");
            $('.logob').css("display", "none");


        } else {
            $('.logoa').css("display", "none");

            $('.logob').css("display", "block");
        }
    });


    $(document).ready(function() {



        $(".mouse_row").mouseover(function() {
            $(".mouse_row").css("background-color", "rgba(69, 72, 144, 0.3)");
        });
        $(".mouse_row").mouseout(function() {
            $(".mouse_row").css({ "background-color": "rgba(69, 72, 144, 0)", "height": "500px" });


        });

    });




    $(document).ready(function() {



        $(".mouse_row2").mouseover(function() {
            $(".mouse_row2").css("background-color", "rgba(69, 72, 144, 0.3)");
        });
        $(".mouse_row2").mouseout(function() {
            $(".mouse_row2").css({ "background-color": "rgba(69, 72, 144, 0)", "height": "500px" });


        });

    });



    $(document).ready(function() {



        $(".mouse_row3").mouseover(function() {
            $(".mouse_row3").css("background-color", "rgba(69, 72, 144, 0.3)");
        });
        $(".mouse_row3").mouseout(function() {
            $(".mouse_row3").css({ "background-color": "rgba(69, 72, 144, 0)", "height": "500px" });


        });

    });




    $(document).ready(function() {



        $(".mouse_row4").mouseover(function() {
            $(".mouse_row4").css("background-color", "rgba(69, 72, 144, 0.3)");
        });
        $(".mouse_row4").mouseout(function() {
            $(".mouse_row4").css({ "background-color": "rgba(69, 72, 144, 0)", "height": "500px" });


        });

    });



     $(window).scroll(function() {
        //控制导航
        if ($(window).scrollTop() > 400) {

            $('.sub_nav').css({ "position": "fixed", "top": "60px", "width": "100%", "z-index": "7" });



        } else {
            $('.sub_nav').css({ "position": "relative", "top": "0px", "width": "100%", "z-index": "7" });


        }
    });


      // Animacao menu scroll to
    $('.goto').on('click', function() {
        var to = $(this).attr('href'); // $(this) is the clicked link. We store its href.
        $('html, body').animate({ scrollTop: ($(to).offset().top) - 200 }, 700);
        $('.tohere').removeClass("active");
        $('.tohere' + to).addClass("active");
        $('.goto').removeClass("active");
        $(this).addClass("active");
        return false;
    });