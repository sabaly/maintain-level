!(function($) {
	'use strict';
	

	//Deconnexion
	$('#disconnect-btn').on('click', function() {
		$.ajax({
			type : 'GET',
			data : 'end=1',
			success : function(msg) {
				location.reload();
			}
		});
	});

	//Mobile navigation
	/*		Main menu 		*/
	if ($('.menu').length) {
	    var $mobile_nav = $('.menu').clone().prop({
	      class: 'mobile-nav d-lg-none'
	    });

	    $('body main').append($mobile_nav);
	    $('body main').append('<div class="mobile-nav-overly"></div>');

	    $(document).on('click', '.mobile-nav-toggle', function(e) {
	        $('body main').toggleClass('mobile-nav-active');
	        $('.mobile-nav-toggle i').toggleClass('icofont-navigation-menu icofont-close');
	        $('.mobile-nav-toggle i').css('color', 'red');
	        $('.mobile-nav-overly').toggle();
	    });

	    $(document).click(function(e) {
	        var container = $(".mobile-nav, .mobile-nav-toggle");
	        if (!container.is(e.target) && container.has(e.target).length === 0) {
		        if ($('body main').hasClass('mobile-nav-active')) {
		          $('body main').removeClass('mobile-nav-active');
		          $('.mobile-nav-toggle i').toggleClass('icofont-navigation-menu icofont-close');
		          $('.mobile-nav-toggle i').css('color', '#00f');
		          $('.mobile-nav-overly').fadeOut(1000);
		        }
	      	}
	    });
	} else if ($(".mobile-nav, .mobile-nav-toggle").length) {
	    $(".mobile-nav, .mobile-nav-toggle").hide();
	}

	/* 	Problem toggle and answer message toggle 	*/
	if($('.problem-in-mobile ').length) {
		var $mobile_pro = $('.problem-in-mobile').clone().prop({
	      class: 'mobile-pro d-lg-none'
	    });

		$('body main').append($mobile_pro);
	    $('body main').append('<div class="mobile-pro-overly"></div>');

	    $(document).on('click', '.mobile-pro-toggle', function(e) {
	        $('body main').toggleClass('mobile-pro-active'); 
            $('.mobile-pro-toggle i').toggleClass('icofont-question icofont-caret-left');
	        $('.mobile-pro-overly').toggle(100);
	    });

	    $(document).click(function(e) {
	        var proContainer = $(".mobile-pro, .mobile-pro-toggle");
	        if (!proContainer.is(e.target) && proContainer.has(e.target).length === 0) {
		        if ($('body main').hasClass('mobile-pro-active')) {
		          $('body main').removeClass('mobile-pro-active');
                  $('.mobile-pro-toggle i').toggleClass('icofont-question icofont-caret-left');
		          $('.mobile-pro-overly').fadeOut(100);
		        }
	      	}
	    });
	}else if ($(".mobile-pro, .mobile-pro-toggle").length) {
	    $(".mobile-pro, .mobile-pro-toggle").hide();
	}

	if($('.answer-in-mobile').length) {
		var $mobile_ans = $('.answer-in-mobile').clone().prop({
	      class: 'mobile-ans d-lg-none'
	    });

	    $('body main').append($mobile_ans);
	    $('body main').append('<div class="mobile-ans-overly"></div>');

	    $(document).on('click', '.mobile-ans-toggle', function(e) {
	        $('body main').toggleClass('mobile-ans-active');
            $('.mobile-ans-toggle i').toggleClass('icofont-paper-plane icofont-caret-left');
	        $('.mobile-ans-overly').toggle();

	    	console.log($mobile_ans);
	    });

	    $(document).click(function(e) {
	        var ansContainer = $(".mobile-ans, .mobile-ans-toggle");
	        if (!ansContainer.is(e.target) && ansContainer.has(e.target).length === 0) {
		        if ($('body main').hasClass('mobile-ans-active')) {
		            $('body main').removeClass('mobile-ans-active');
            	    $('.mobile-ans-toggle i').toggleClass('icofont-paper-plane icofont-caret-left');
		            $('.mobile-ans-overly').fadeOut(500);
		        }
	      	}
	    });
	}else if ($(".mobile-ans, .mobile-ans-toggle").length) {
	    $(".mobile-ans, .mobile-ans-toggle").hide();
	}
	
})(jQuery);