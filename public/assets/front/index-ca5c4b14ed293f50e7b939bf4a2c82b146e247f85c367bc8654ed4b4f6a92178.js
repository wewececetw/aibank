$(window).scroll(function() {
	// 控制导航
	if ($(window).scrollTop() < 0) {
	  $('#headdiv').stop().animate({
		"top": "0px"
	  }, 200);

	  $('.nav2 .mmm').css("padding-top", "20px");
	  $('.nav2 .sub').css("top", "0px");
	  $('.top02').css("height", "60px");

	} else {
	  $('#headdiv').stop().animate({
		"top": "0px"
	  }, 200);
	  $('.top02').css("height", "60px");

	  $('.nav2 .mmm').css("padding-top", "20px");
	  $('.nav2 .sub').css("top", "60px");
	}
  });

  jQuery(".nav2").slide({
	type: "menu",
	titCell: ".m",
	targetCell: ".sub",
	effect: "slideDown",
	delayTime: 300,
	triggerTime: 100,
	returnDefault: true
  });

  AOS.init({
	easing: 'ease-out-back',
	duration: 1000
  });

  $(document).ready(function() {
	$('.top02').css("background-color", "rgba(255, 255, 255, 0.07)");
	$(".top02").mouseover(function() {
	  $(".top02").css("background-color", "rgba(255, 255, 255, 0.2)");
	});
	$(".top02").mouseout(function() {
	  $(".top02").css({
		"background-color": "rgba(255, 255, 255, 0.07)"
	  });
	});
	// open relative modal if user come from faq
		// if(location.hash){
		// $('html, body').animate({ scrollTop: $(".service_jpg").position().top },500);
		// switch (location.hash){
		// 	case "#showClaimMatch" :
		// 	$("#exampleModalLong").modal();
		// 	break;
		// 	case "#showCreditScore" :
		// 	$("#exampleModalLong2").modal();
		// 	break;
		// }
		// }
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

  $('.waypoint').waypoint(function(direction) {
	if (direction == 'down') {
	  $(this).addClass('count');
	}
  }, {
	offset: function() {
	  return 400 // trip waypoint when element is this many px from top 
	}
  });

  $('.counter').counterUp({
	delay: 10,
	time: 500
  });
  
  $('.counter').addClass('animated fadeInDownBig');
  
  $('h3').addClass('animated fadeIn');

//   $('.option-btn').on('click', function(){
// 	  var year = $(this).attr('data-year');
// 	  var season = $(this).attr('data-season');    
	  
// 	  $.ajax({ 
// 		  type : "POST", 
// 		  url : "/trustpigs/get_default_rate_table", 
// 		  data : {'year': year, 'season': season},
// 		  success : function(result) { 
// 			  $("#img-1").attr('src', result.dpd30.web.url)
// 			  $("#img-2").attr('src',result.dpd90.web.url)
// 			  $("#img-3").attr('src', result.nco.web.url)
// 		  }, 
// 		  error : function(result) { 
// 			  //handle the error 
// 		  } 
// 	  });   
//   })



$(function() {

	// Render all articles when click show more(finance or news)
	$(".show-more").click(function(){		
		var articleBox = $(this).closest("section").find(".articles-box ")
		$.ajax({ 
			type : "POST", 
			url : "/trustpigs/get_all_articles", 
			data : {'category': $(this).data("category")},
			success : function(result) { 
				articleBox.html("")
				result.forEach(function(data){
					var article = ""
					var date = new Date(data.created_at)
					article += "<div class='col-md-4 pd5 aos-init aos-animate' aos='fade-up'>"
					article += "<a href='/news/" + data.id+ "/news_detail'>"
					article += "<div class='linka'><div class='news-img'><img src="+ data.web_image_url +"></div>"
					article += "<div class='news-title'>" + data.title + "</div>"
					article += "<p class='news-pretext'>" + data.remark + "</p>"
					article += "<div class='news-created-time'>" + date.toISOString().split('T')[0] + "</div>"
					article += "</div></a></div>"
					articleBox.append(article)
				})
			}, 
			error : function(result) { 
					//handle the error
			} 
		}); 
	})

	// Countdown function      
	function startCountDown(){
		// Launched on every Thursday to Sunday.
		const countdown = document.querySelector('.countdown');
		if(countdown == null) {return ;}
		const ignoreDay = [5,6,0]
		// Set Launch Date (ms)
		const todayDay = new Date().getDay();
		const dayDifferent = 4 - todayDay
		const launchDate = moment().add(dayDifferent, 'days').startOf('day').add(10, 'hours')._d

		// Update every second
		const intvl = setInterval(() => {
			// Get todays date and time (ms)
			const now = new Date().getTime();	
			// Distance from now and the launch date (ms)
			const distance = launchDate - now;
			// Time calculation
			const days = Math.floor(distance / (1000 * 60 * 60 * 24));
			const hours = Math.floor(
				(distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
			);
			const mins = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			const seconds = Math.floor((distance % (1000 * 60)) / 1000);

			// Display result
			var d = $(".days span")
			var h = $(".hours span")
			var m = $(".minutes span")
			var s = $(".seconds span")

			s.addClass("pop");
			setTimeout(function(){
				s.removeClass("pop")
			}, 100)

			d.text(days)
			h.text(hours)
			m.text(mins)
			s.text(seconds)

			// If launch date is reached
			if (distance < 0 || ignoreDay.includes(todayDay)) {
				// Stop countdown
				clearInterval(intvl);
				// Style and output text
				countdown.style.padding = '10px 10px 10px 10px';
				countdown.innerHTML = '開標中！！速速搶標！!';
			}
		}, 1000);
	}
	startCountDown();

	// Replace service_jpg22 image
	if(window.innerWidth > 576){
		$("img.m1").show();
		$("img.m2").hide();		
	}
	else{
		$("img.m1").hide();
		$("img.m2").show();			
	}
	
			

	// JavaScript Code for Claim match simulator

	var tenderAmount = 0
	var sliderFirstA, sliderFirstB, sliderSecondC, sliderSecondD, sliderSecondE, sliderThirdAB, sliderThirdCDE, sliderThirdABLabel,
		sliderThirdCDELabel, uniqueBlock = 0
	// Step 0 - open simulator playground
	$("#simulator").on("click", function() {
		$.goodpopup.getPopup("demo-popup-1").open()
	});
	// Step 1 - input amount
	$(document).on("click", "#button-go-2", function() {
	  if($("#tenderAmount").val() <= 0){
		$(".alert-text").text("")
		$(".alert-text").text("請輸入投資金額！")
	  }
	  else if($("#tenderAmount").val() > 150){
		$(".alert-text").text("")
		$(".alert-text").text("請輸入小於 150萬 的金額！")          
	  }
	  else{
		$.goodpopup.getPopup("demo-popup-2").open();
		$("#intelligent").val("#tab01")
		// Asynchronous issue, postpone to call slider_bar dynamic function after page render slider bar
		postponeFunction(make_intelligent_slider_bar, 500)
		postponeFunction(make_slider_dynamic, 700)
	  }
	});
	// Step 2-1 - back to step1
	$(document).on("click", "#button-back-1", function() {
		$.goodpopup.getPopup("demo-popup-1").open();
	});
	// Step 2-2 - collect slider bar data to calculate investment result
	$(document).on("click", "#button-go-3", function() {
	  
	  changeIntelligent = $("#intelligent").val()
	  // get slider group data
	  sliderFirstA = $('.slider-first-A').get(0).innerHTML.split('：')[1].split('%')[0];
	  sliderFirstB = 100 - Number(sliderFirstA);

	  sliderSecondC = $('.slider-second-C').get(0).innerHTML.split('：')[1].split('%')[0];
	  sliderSecondD = $('.slider-second-D').get(0).innerHTML.split('：')[1].split('%')[0];
	  sliderSecondE = $('.slider-second-E').get(0).innerHTML.split('：')[1].split('%')[0];

	  sliderThirdAB = $('.slider-third-AB').get(0).innerHTML.split('：')[0].split('%')[0];
	  sliderThirdCDE = $('.slider-third-CDE').get(0).innerHTML.split('：')[0].split('%')[0];
	  sliderThirdABLabel = $('.slider-third-AB-label').get(0).innerHTML.split('：')[0].split('%')[0];
	  sliderThirdCDELabel = $('.slider-third-CDE-label').get(0).innerHTML.split('：')[0].split('%')[0];
	  uniqueBlock = $('#unique_block').get(0).innerHTML.split('：')[0];
	 
	  // set selected slider data to estimatedArray
	  var estimatedArray;

	  if(changeIntelligent.includes('tab01')) {
		  estimatedArray = [['A',sliderFirstA],['B',sliderFirstB]]
	  } else if(changeIntelligent.includes('tab02')) {
		  estimatedArray = [['C',sliderSecondC],['D',sliderSecondD],['E',sliderSecondE]]
	  } else if(changeIntelligent.includes('tab03')) {
		  estimatedArray = [['A',20],['B',20],['C',20],['D',20],['E',20]]
	  } else if(changeIntelligent.includes('tab04')) {
		  estimatedArray = [[sliderThirdABLabel,sliderThirdAB],[sliderThirdCDELabel,sliderThirdCDE]]
	  } else {
		  estimatedArray = [[uniqueBlock,100]]
	  }
	  tenderAmount = $("#tenderAmount").val() * 10000

	  var result = estimate_claims(tenderAmount, estimatedArray)        
	  $.goodpopup.getPopup("demo-popup-3").open();

	  // Asynchronous issue, postpone to call result table dynamic function after page render step3
	  setTimeout(function(){
			make_result_table(result)
		}, 300)
	});
	// Step 3 - restart simulation
	$(document).on("click", "#button-go-1", function() {
		$.goodpopup.getPopup("demo-popup-1").open()
	})  
	
	$(document).on('click',".js-goodpopup-close-direct", function(){
		$("div.goodpopup_visible").click();
	})

  });

  // Function for postpone any function 
  // params : 1. func - function which doesn't need parameter, 2. time - the milesecond you want to postpone
  var postponeFunction = function(func, time, args={}){
	setTimeout(function(){
	  func()
	}, time)
	}

  // Function for read mockup claim json data and calculate to get final investment result 
  // params : 1. inputAmount - the user's investment amount, 2. estimatedArray - data array from step2, eg: [['A',50],['C',50]]
  var estimate_claims = function(inputAmount, estimatedArray){
	var matchResult = {
	  selectedClaims: [], 
	  totalTender: 0,
	  estimatedBenefit: 0
	}
	estimatedArray.forEach(function(data){
	  var targetRiskCategory = data[0]
	  var originInvestmentAmount = (inputAmount * data[1])/100
	  var claims = getMockupClaims(targetRiskCategory)

	  var tender_numbers = originInvestmentAmount/1000
	  var claims_index = 0 
	  for(var i=0; i<tender_numbers; i++){
		if( claims_index == 3){
		  claims_index = 0
		}
		claims[claims_index].tender_amount += 1000
		claims[claims_index].remaining_amount -=  1000
		matchResult.totalTender += 1000
		claims_index += 1
	  }
	  claims.forEach(function(claim){
		matchResult.estimatedBenefit += (claim.tender_amount * claim.annual_interest_rate * claim.periods / 12) / 100
	  })
	  var obj = {}
	  obj[targetRiskCategory] = claims
	  matchResult.selectedClaims.push(obj)
	})
	return matchResult
  }

  // Function for render table data
  // params: 1.result - should be from estimate_claims()
  var make_result_table = function(result){
	  var $tbody = $('table#claims').find('tbody')
	  var tableCode = ""

	  $("#real-tender").text(fmoney(result.totalTender, 0));
	  $("#estimated-benefit").text(fmoney(parseInt(result.estimatedBenefit), 0));
	  $("#tender-income-percent").text(((result.estimatedBenefit / result.totalTender)*100).toFixed(1)+ "%");
	  result.selectedClaims.forEach(function(groupClaims){
		groupClaims[Object.keys(groupClaims)[0]].forEach(function(claim){
		  tableCode += "<tr><td class='bd-example-modal-lg lalign' data-th='風險等級'><span class='fcolor'>" + Object.keys(groupClaims)[0] + "</span></td>"
		  tableCode += "<td class='bd-example-modal-lg'  data-th='年化收益'><span class='fcolor2 '>" + claim.annual_interest_rate + "</span></td>"
		  tableCode += "<td class='bd-example-modal-lg'  data-th='物件編號'><span class='fbold '>" + claim.serial_number + "</span></td>"
		  tableCode += "<td class='bd-example-modal-lg'  data-th='債權額度'><span class='fbold '>" + fmoney(claim.staging_amount, 0) + "</span></td>"
		  tableCode += "<td class='bd-example-modal-lg'  data-th='期數'><span class='fbold '>" + claim.periods + "</span></td>"
		  tableCode += "<td class='bd-example-modal-lg'  data-th='剩餘金額'><span class='fbold '>" + fmoney(claim.remaining_amount, 0) + "</span></td>"
		  tableCode += "<td class='bd-example-modal-lg'  data-th='還款方式'><span class='fbold '>" + claim.repayment_method +  "</span></td>"
		  tableCode += "<td class='bd-example-modal-lg'  data-th='投資金額'><span class='fbold '>" + fmoney(claim.tender_amount, 0) + "</span></td></tr>"

		  $tbody.append(tableCode)
		  tableCode = ""
		})
	  })
  }

  // Function for get data from global variable mockupClaims
  // params: 1.category - send category (ex: A), then get all claims belongs to that category.
  var getMockupClaims = function(category){
	var data = mockupClaims[category]
	return data
	}
	
	

;
