/*
Template Name: Happy Paws
Author: Ingrid Kuhn
Author URI: http://themeforest.net/user/ingridk
*/

//Strict Mode 
(function($) {
    "use strict";
		
    //Document ready function
    $(document).ready(function() {	
	
		
		//Preloader		
		$("#preloader").fadeOut("slow");
		$("#spinner").fadeOut("slow");	
		
		//Load WOW Animations

        new WOW().init();		      
		
		//Slide In Panel
	
		//open the lateral panel
		$('.toggle-btn a').on('click', function (event) {
		var href = $(this).attr('href');
		event.preventDefault();
		$(href).addClass('is-visible');
		});
		//close the lateral panel
		$('.cd-panel').on('click', function (event) {
		if ($(event.target).is('.cd-panel') || $(event.target).is('.cd-close')) {
		$('.cd-panel').removeClass('is-visible');
		event.preventDefault();
		}
		});


        //Scrolling feature 
		
        $('.page-scroll a').bind('click', function(event) {
            var $anchor = $(this);
            $('html, body').stop().animate({
                scrollTop: $($anchor.attr('href')).offset().top
            }, 1500, 'easeInOutExpo');
            event.preventDefault();
        });
		
		//	Back Top Link

		var offset = 5200;
		var duration = 500;
		$(window).scroll(function() {
			if ($(this).scrollTop() > offset) {
				$('.back-to-top').fadeIn(400);
			} else {
				$('.back-to-top').fadeOut(400);
			}
		});
		
		
		
		$("#owl-adopt").owlCarousel({
			nav: true,
			navText: ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
			dots:true,
			loop:false,
			autoplay:false,
			navRewind:true,
			responsiveClass:true,
			responsive:{
					0:{
					items:1,
					},
					600:{
						items:1,
					},
					991:{
						items:2,
					},
					1200:{
						items:3,
					}
					}
        });
		
		// Parallax Slider
	
		  var $slider = $(".slider"),
			  $slideBGs = $(".slide__bg"),
			  diff = 0,
			  curSlide = 0,
			  numOfSlides = $(".slide").length-1,
			  animating = false,
			  animTime = 500,
			  autoSlideTimeout,
			  autoSlideDelay = 6000,
			  $pagination = $(".slider-pagi");
		  
		  function createBullets() {
			for (var i = 0; i < numOfSlides+1; i++) {
			  var $li = $("<li class='slider-pagi__elem'></li>");
			  $li.addClass("slider-pagi__elem-"+i).data("page", i);
			  if (!i) $li.addClass("active");
			  $pagination.append($li);
			}
		  };
		  
		  createBullets();
		  
		  function manageControls() {
			$(".slider-control").removeClass("inactive");
			if (!curSlide) $(".slider-control.left").addClass("inactive");
			if (curSlide === numOfSlides) $(".slider-control.right").addClass("inactive");
		  };
		  
		  function autoSlide() {
			autoSlideTimeout = setTimeout(function() {
			  curSlide++;
			  if (curSlide > numOfSlides) curSlide = 0;
			  changeSlides();
			}, autoSlideDelay);
		  };
		  
		  autoSlide();
		  
		  function changeSlides(instant) {
			if (!instant) {
			  animating = true;
			  manageControls();
			  $slider.addClass("animating");
			  $slider.css("top");
			  $(".slide").removeClass("active");
			  $(".slide-"+curSlide).addClass("active");
			  setTimeout(function() {
				$slider.removeClass("animating");
				animating = false;
			  }, animTime);
			}
			window.clearTimeout(autoSlideTimeout);
			$(".slider-pagi__elem").removeClass("active");
			$(".slider-pagi__elem-"+curSlide).addClass("active");
			$slider.css("transform", "translate3d("+ -curSlide*100 +"%,0,0)");
			$slideBGs.css("transform", "translate3d("+ curSlide*50 +"%,0,0)");
			diff = 0;
			autoSlide();
		  }

		  function navigateLeft() {
			if (animating) return;
			if (curSlide > 0) curSlide--;
			changeSlides();
		  }

		  function navigateRight() {
			if (animating) return;
			if (curSlide < numOfSlides) curSlide++;
			changeSlides();
		  }

		  $(document).on("mousedown touchstart", ".slider", function(e) {
			if (animating) return;
			window.clearTimeout(autoSlideTimeout);
			var startX = e.pageX || e.originalEvent.touches[0].pageX,
				winW = $(window).width();
			diff = 0;
			
			$(document).on("mousemove touchmove", function(e) {
			  var x = e.pageX || e.originalEvent.touches[0].pageX;
			  diff = (startX - x) / winW * 70;
			  if ((!curSlide && diff < 0) || (curSlide === numOfSlides && diff > 0)) diff /= 2;
			  $slider.css("transform", "translate3d("+ (-curSlide*100 - diff) +"%,0,0)");
			  $slideBGs.css("transform", "translate3d("+ (curSlide*50 + diff/2) +"%,0,0)");
			});
		  });
		  
		  $(document).on("mouseup touchend", function(e) {
			$(document).off("mousemove touchmove");
			if (animating) return;
			if (!diff) {
			  changeSlides(true);
			  return;
			}
			if (diff > -8 && diff < 8) {
			  changeSlides();
			  return;
			}
			if (diff <= -8) {
			  navigateLeft();
			}
			if (diff >= 8) {
			  navigateRight();
			}
		  });
		  
		  $(document).on("click", ".slider-control", function() {
			if ($(this).hasClass("left")) {
			  navigateLeft();
			} else {
			  navigateRight();
			}
		  });
		  
		  $(document).on("click", ".slider-pagi__elem", function() {
			curSlide = $(this).data("page");
			changeSlides();
		  });
		

        		
    });
		

})(jQuery);

 