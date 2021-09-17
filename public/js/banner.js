var timelineSwiper = new Swiper ('.timeline .swiper-container', {
    direction: 'vertical',
    loop: false,
    speed: 1600,
    pagination: '.swiper-pagination',
    paginationBulletRender: function (swiper, index, className) {
      var year = document.querySelectorAll('.swiper-slide')[index].getAttribute('data-year');
      return '<span class="' + className + '">' + year + '</span>';
    },
    paginationClickable: true,
    nextButton: '.swiper-button-next',
    prevButton: '.swiper-button-prev',
    breakpoints: {
      768: {
        direction: 'horizontal',
      }
    }
  });

  var swiper1 = new Swiper('.swiper1', {
    paginationClickable: true,//按鈕可點擊
    slidesPerView: 4,
    spaceBetween: 30,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  });
  
  var swiper2 = new Swiper('.swiper2', {
    paginationClickable: true,
    slidesPerView: 4,
    spaceBetween: 20,
    pagination: '.swiper-pagination',
    nextButton: '#swiper-button-next2',
    prevButton: '#swiper-button-prev2',
    breakpoints: {
      640: {
        slidesPerView: 1,
        spaceBetween: 30,
      },
      768: {
        slidesPerView: 2,
        spaceBetween: 20,
      },
      1024: {
        slidesPerView: 3,
        spaceBetween: 20,
      },
    },
  });
  var swiper3 = new Swiper('.swiper3', {

    slidesPerView: 3,
    spaceBetween: 50,
    paginationClickable: true,//按鈕可點擊
    nextButton: '#swiper-button-next3',
    prevButton: '#swiper-button-prev3',
    pagination: '.swiper-pagination',
    breakpoints: {
      640: {
        slidesPerView: 1,
        spaceBetween: 30,
      },
      768: {
        slidesPerView: 2,
        spaceBetween: 40,
      },
      1024: {
        slidesPerView: 3,
        spaceBetween: 20,
      },
    }
  });

  // $(document).ready(function(){
  //   $('#nav-icon1,#nav-icon2,#nav-icon3,#nav-icon4').click(function(){
  //     $(this).toggleClass('open');
  //   });
  //     });