jQuery(document).ready(function ($) {

	$('.c5ab_twitter_slider').flexslider({
	          animation: "slide",
	          controlsContainer: ".flex-container",
	          selector: ".c5ab_twitter_slides > li",
	    });
	    
	
	$(".toggle h3").click(function (e) {
	    e.preventDefault();
	    $(this).toggleClass("active").next("div").slideToggle("fast");
	});
	
	
	$('.c5ab_popup').magnificPopup({
			type: 'image',
			closeOnContentClick: true,
			mainClass: 'mfp-img-mobile',
			image: {
				verticalFit: true
			}
			
		});
	
	 //Quick read
	    $(document).on("click", ".c5-view-article", function c5_quick_read (e) {
	
	        $.ajax({
	            type: "POST",
	            data: 'post_id=' + $(this).attr('data-id')+ "&action=c5_get_full_post",
	            url: c5_ajax_var.url,
	            success: function (data) {
	                $.magnificPopup.open({
	                    items: {
	                        src: data
	                    },
	                    mainClass: 'c5-article-post',
	                    type: 'inline'
	                }, 0);
	             }
	        });
	        e.preventDefault();
	
	    });
	  
	  $('.top-menu-nav ul.menu-sc-nav > li.menu-item ').each(function () {
	      var $t = $(this);
	  	if($t.hasClass('c5-mega-menu-li')){
	  		$t.closest('.inner-header').addClass('c5-mega-menu-float-wrap');
	  	}
	  });
	  
	  $('.top-menu-nav ul.menu-sc-nav > li.menu-item ').each(function () {
	      var $t = $(this);
	  	if($t.hasClass('c5-mega-sub-menu')){
	  		$t.parent('.menu-sc-nav').parent('.navigation-shortcode').addClass('c5-mega-menu-wrap');
	  		var li_count = $t.children('ul.sub-menu').children('li').length;
	  		$t.parent('.menu-sc-nav').parent('.navigation-shortcode').parent('.c5-left').addClass('c5-mega-menu-float-wrap');
	  		$t.parent('.menu-sc-nav').parent('.navigation-shortcode').parent('.c5-right').addClass('c5-mega-menu-float-wrap');
	  		
	  		$t.children('ul.sub-menu').children('li').css('width', 100/li_count + '%');
	  		$t.children('ul.sub-menu').children('li').addClass('c5-mega-li-menus');
	  		
	  		$t.children('ul.sub-menu').wrap( '<div class="c5-mega-menu-wrap"><div class="mid-page"> </div></div>' );
	  	}
	  });
	  
	  //Mega Menu
	  $('.c5-mega-menu-li').on('mouseenter', function (e) {
	          
	          var $t = $(this);
	          if ($t.hasClass('c5-done')) {
	          	return;
	          }
	          if($t.parent('.menu-sc-nav').parent('.navigation-shortcode').hasClass('sidebar')){
	          	return;
	          }
	          
	          $t.children('.c5-mega-menu-wrap').html('<span class="fa  fa-circle-o-notch fa-spin c5-loading "></span>');
	          $.ajax({
	              type: "POST",
	              data: 'passing_string=' + $(this).children('a.c5-mega-menu-a').attr('c5-mega-data') + '&action=c5ab_menu_mega_menu',
	              url: c5_ajax_var.url,
	              success: function (data) {
	  				$t.children('.c5-mega-menu-wrap').html(data);
	  				$t.addClass('c5-done');
	  				
	              }
	          });
	      });
	      
	$("#c5-submit-contact").click(function (e) {
	    if ($("#email").val() && $("#name").val() && $("#message").val()) {
	        $("#email").removeClass("contact_error");
	        $("#name").removeClass("contact_error");
	        $("#message").removeClass("contact_error");
	        var emailReg = /^([\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4})?$/;
	        if (!emailReg.test($("#email").val())) {
	            $("#email").addClass("contact_error");
	        } else {
	            $.ajax({
	                type: "POST",
	                data: jQuery("#c5-contact-form").serialize() + "&action=c5ab_contact_send",
	                url: c5_ajax_var.url,
	                success: function (data) {
	                	alert(data);
	                    if (data === "done") {
	                        $(".message_contact_true").fadeIn();
	                    } else {
	                        $(".message_contact_false").fadeIn();
	                    }
	                }
	            });
	        }
	    } else {
	        if (!$("#email").val()) {
	            $("#email").addClass("contact_error");
	        } else {
	            $("#email").removeClass("contact_error");
	        }
	        if (!$("#name").val()) {
	            $("#name").addClass("contact_error");
	        } else {
	            $("#name").removeClass("contact_error");
	        }
	        if (!$("#message").val()) {
	            $("#message").addClass("contact_error");
	        } else {
	            $("#message").removeClass("contact_error");
	        }
	    }
	    e.preventDefault();
	});
	
	
	
	 $(document).on("click", ".c5ab_accordion_tab_handle", function c5ab_accordion_tab_handle (e) { 
	 	$(this).parent().children('.c5ab_accordion_tab_handle').removeClass('current');
	 	$(this).parent().children('.pane').slideUp();
	 	$(this).addClass('current');
	 	$('.pane-' + $(this).attr('data-id')).slideDown();
	 
	 });
	 
	 $(document).on("click", ".c5ab_tab_handle", function c5ab_tab_handle (e) { 
	 	$(this).closest('.c5ab_tabs_wrap').find('.c5ab_tab_handle').removeClass('current');
	 	$(this).closest('.c5ab_tabs_wrap').find('.pane').css('display','none');
	 	$(this).addClass('current');
	 	$('.pane-' + $(this).attr('data-id')).fadeIn();
	 
	 });
	 
	   
	
});