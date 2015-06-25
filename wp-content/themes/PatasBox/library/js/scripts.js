jQuery(document).ready(function($) {

    /*
     Responsive jQuery is a tricky thing.
     There's a bunch of different ways to handle
     it, so be sure to research and find the one
     that works for you best.
     */
	 


    /* getting viewport width */
    var responsive_viewport = $(window).width();

    /* if is below 481px */
    if (responsive_viewport < 481) {

    } /* end smallest screen */

    /* if is larger than 481px */
    if (responsive_viewport > 481) {

    } /* end larger than 481px */

    /* if is above or equal to 768px */
    if (responsive_viewport >= 768) {

        /* load gravatars */
        $('.comment img[data-gravatar]').each(function() {
            $(this).attr('src', $(this).attr('data-gravatar'));
        });

    }

    /* off the bat large screen actions */
    if (responsive_viewport > 1030) {

    }
    
    $("[title]").tipTip();

    // add all your scripts here

    $('.dropdown-toggle').dropdown();
    
    $("#gotop").click(function() {
        $("html, body").animate({scrollTop: 0}, "200");
    });
    
    $('#breaking-bar').fadeIn();
    if ($('body').hasClass('rtl')) {
        $('#c5-webTicker').webTicker({direction: "right"});
    } else {
        $('#c5-webTicker').webTicker();
    }

    $('.c5-pages-menu-wrap').each(function() {
        var this_menu = $(this);

        this_menu.find('ul').addClass('sub-menu');
        this_menu.find('li').addClass('menu-item');
        this_menu.children('.top-nav').children('ul').removeClass('sub-menu').addClass('top-nav menu-sc-nav clearfix');
        this_menu.fadeIn();
    });

    $(document).on('click', '.c5-font-control span', function(e) {
        $('.c5-article-content').removeClass('size_1');
        $('.c5-article-content').removeClass('size_2');
        $('.c5-article-content').removeClass('size_3');

        $('.c5-article-content').addClass($(this).attr('class'));

    });

    //$('a[href*=#]:not([href=#])').click(function() {
//        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
//            var target = $(this.hash);
//            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
//            if (target.length) {
//                $('html,body').animate({
//                    scrollTop: target.offset().top
//                }, 1000);
//                return false;
//            }
//        }
//    });
 $(document).ready(
function(){
   // Change the image of hoverable images
   $(".product-category img").hover( function() {
       var hoverImg = HoverImgOf($(this).attr("src"));
       $(this).attr("src", hoverImg);
     }, function() {
       var normalImg = NormalImgOf($(this).attr("src"));
       $(this).attr("src", normalImg);
     }
   );
});

function HoverImgOf(filename)
{
   var re = new RegExp("(.+)\\.(gif|png|jpg)", "g");
   return filename.replace(re, "$1_hover.$2");
}
function NormalImgOf(filename)
{
   var re = new RegExp("(.+)_hover\\.(gif|png|jpg)", "g");
   return filename.replace(re, "$1.$2");
}


$(document).ready(function(){
	$("#open").click(function(){
		$('#overlay, #review_form_wrapper').animate({'opacity':'0.7'}, 300, 'linear');
     	$('#review_form_wrapper').animate({'opacity':'1.00'},300,'linear');
     	$('#overlay, #review_form_wrapper').css('display','block');
     	$('#review_form_wrapper').css({'right':(($(document).width()/2)-($('#review_form_wrapper').width()/2))});
     	$('#review_form_wrapper').css({'top':0});
  	});
	
	$('#close').click(function(){
		$('#overlay, #review_form_wrapper').animate({'opacity':'0'}, 300, 'linear', function(){
     	$('#overlay, #review_form_wrapper').css('display','none');
		});
	});
});




    var c5_reading_scroll = function() {
        if ($('.c5-article-content').length === 0) {
            return;
        }
        var content_offset = $('.c5-article-content').offset().top;
        var content_height = $('.c5-article-content').height();
        var window_offest = $(window).scrollTop();
        var window_height = $(window).height();

        var percent = 0;
        if (window_offest > content_offset) {
            percent = 100 * (window_offest - content_offset) / (content_height - window_height);
        } else if (window_offest > (content_offset + content_height)) {
            percent = 100;
        }
        if (percent > 100) {
            percent = 100;
        }
        if (percent < 0) {
            percent = 0;
        }
        $('.c5-reading-progress').css('width', percent + '%');
    };
    $(window).scroll(c5_reading_scroll);


    $('.c5-sidebar-handle').click(function() {
        var main_window = $('.c5-main-page-wrap-sidebar');

        if (main_window.hasClass('c5-sidebar-active')) {
            main_window.removeClass('c5-sidebar-active');
            main_window.addClass('c5-sidebar-hidden');
        } else {
            main_window.removeClass('c5-sidebar-hidden');
            main_window.addClass('c5-sidebar-active');
        }

    });
    $('.c5-search-handle').click(function() {
        var main_window = $('#inner-header');
        var search_area = $('#c5-search-area');
        if (search_area.hasClass('search_on')) {
            search_area.removeClass('search_on');
            main_window.removeClass('search_on');
        } else {
            search_area.addClass('search_on');
            main_window.addClass('search_on');
        }
    });

    $('.close-icon').click(function() {
        var main_window = $('#inner-header');
        var search_area = $('#c5-search-area');

        search_area.removeClass('search_on');
        main_window.removeClass('search_on');

    });

    $('.c5-load-more-posts').each(function() {
        var this_elem = $(this);
        var articl_scroll = function() {
            var k = this_elem.offset().top;
            var b = $(window).scrollTop();
            if ((k - b) < 500 && !this_elem.hasClass('loading')) {
                this_elem.addClass('loading');
                var render_type = this_elem.attr('render_type');
                var slider_id = this_elem.attr('slider_id');
                var single_width = this_elem.attr('single_width');
                $.ajax({
                    type: "post",
                    url: ajax_var.url,
                    data: "action=c5_load_more_posts&nonce=" + ajax_var.nonce + "&atts=" + this_elem.attr('data-atts') + "&args=" + this_elem.attr('data-args') + "&page=" + this_elem.attr('data-page') + "&content_width=" + this_elem.attr('data-content-width') + "&primary_color=" + this_elem.attr('data-color'),
                    success: function(data) {
                        if (data !== '') {
                            this_elem.attr('data-page', parseInt(this_elem.attr('data-page')) + 1);

                            this_elem.parent().children('.c5-load-wrap').append(data);

                            if (render_type == 'grid-1' || render_type == 'grid-2' || render_type == 'grid-3') {

                                var container_slider_id = $('.c5ab_posts_' + render_type + '_' + slider_id + '  .c5-load-wrap').isotope('destroy');


                                container_slider_id = $('.c5ab_posts_' + render_type + '_' + slider_id + '  .c5-load-wrap').isotope({itemSelector: '.element', masonry: {
                                        columnWidth: parseInt(single_width)
                                    }});


                            } else {


                            }

                            this_elem.removeClass('loading');

                            try {
                                FB.XFBML.parse();
                            } catch (ex) {
                            }

                            $(".gallery.flexslider").flexslider({
                                animation: "slide",
                                slideshowSpeed: 7E3,
                                controlNav: true,
                                smoothHeight: true
                            });

                        } else {
                            this_elem.remove();
                        }
                    }
                });
            }
        };
        $(window).scroll(articl_scroll);
        articl_scroll();

    });



    $(".menu-sc-nav ul.sub-menu li").each(function() {
        if ($(this).children("ul.sub-menu").length > 0) {
            if ($('body').hasClass('rtl')) {
                $(this).children("a:first").append('<span class="more fa fa-angle-left"></span>');
            } else {
                $(this).children("a:first").append('<span class="more fa fa-angle-right"></span>');
            }
        }
    });
    /*
     $(".menu-sc-nav > li").each(function() {
     if($(this).children("ul.sub-menu").length > 0) {
     $(this).children("a:first").append('<span class="more fa fa-angle-down"></span>');
     }
     });
     */

    $(".navigation-shortcode.responsive-on .responsive-controller").click(function() {
        var menu = $(this).parent().children('ul.menu-sc-nav').clone();


        menu.find('.c5-mega-menu-block').remove();
        menu.find('li').removeClass();
        menu.find('li').css('width', '100%');
        menu.find('ul').removeClass();
        menu.removeClass();
        menu.addClass('c5-stroll');
        $.magnificPopup.open({
            items: {
                src: menu
            },
            mainClass: 'c5-menu-post',
            type: 'inline'
        }, 0);

    });

    $(".c5-post-like").click(function() {
        var heart = $(this);
        var post_id = heart.attr("data-post_id");
        $.ajax({
            type: "post",
            url: ajax_var.url,
            data: "action=c5_post_like&nonce=" + ajax_var.nonce + "&post_like=&post_id=" + post_id,
            success: function(count) {
                if (count != "already")
                {
                    heart.addClass("voted");
                    heart.children('.count').text(count);
                }
            }
        });

        return false;
    });

    $(".gallery_slider").magnificPopup({
        delegate: 'a',
        type: 'image',
        tLoading: 'Loading image #%curr%...',
        mainClass: 'mfp-img-mobile',
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0, 1]
        },
        image: {
            tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
            titleSrc: function(item) {
                return item.el.attr('title') + '';
            }
        }
    });

    $(".gallery.flexslider").flexslider({
        animation: "slide",
        slideshowSpeed: 7E3,
        controlNav: true,
    });
    $('.c5ab-dribbble-flexslider').flexslider({
        animation: "slide",
        selector: ".c5ab-dribbble-slides > li",
        controlNav: false,
        directionNav: true,
        prevText: "<span class='fa fa-angle-left'></span>",
        nextText: "<span class='fa fa-angle-right'></span>",
    });
    $('.c5ab-instagram-flexslider').flexslider({
        animation: "slide",
        selector: ".c5ab-instagram-slides > li",
        controlNav: false,
        directionNav: true,
        prevText: "<span class='fa fa-angle-left'></span>",
        nextText: "<span class='fa fa-angle-right'></span>",
    });
    $('#c5_woo_carousel').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        itemWidth: 95,
        itemMargin: 5,
        asNavFor: '#woo_slider'
    });
    $("#woo_slider").flexslider({
        animation: "fade",
        slideshowSpeed: 7E3,
        controlNav: false,
    });


    if ($("#floating-trigger").length > 0) {
        var a = function() {

            var b = $(window).scrollTop();
            var d = $("#floating-trigger").offset().top;
            var c = $(".header_floating");
            var k = $('#gotop');
            if (b > d) {
                c.addClass('descended');
                k.fadeIn();
            } else {
                c.removeClass('descended');
                k.fadeOut();
            }

        };
        $(window).scroll(a);
        a();
    }
    $('a.c5-social').click(function(event) {
        event.preventDefault();
        window.open($(this).attr("href"), "popupWindow", "width=600,height=600,scrollbars=yes");
    });


    //floating authors
    /* Auto Align Scroll */

    var c5_scroll_auto_align = function() {
        var window_height = $(window).height();

        var screen_scroll_top = $(window).scrollTop();

        var total_height = window_height + screen_scroll_top;



        var main_wrap = $('.c5-article-content');
        var main_wrap_offset_top = main_wrap.offset().top;
        var main_wrap_height = main_wrap.height();

        var total_main_wrap = main_wrap_offset_top + main_wrap_height;


        $('.c5-sidebar-float ').each(function() {

            var this_elem = $(this);
            var this_elem_height = this_elem.height();

            if (screen_scroll_top > (main_wrap_offset_top - 60) && screen_scroll_top < total_main_wrap) {
                this_elem.addClass('fix_it');
                this_elem.css('top', '');
            } else if (total_height > total_main_wrap) {
                this_elem.removeClass('fix_it');
                var margin = main_wrap_height - this_elem_height;
                this_elem.css('top', margin);

            } else {
                this_elem.removeClass('fix_it');
                this_elem.css('top', '');
            }
        });
    };

    if (responsive_viewport >= 768) {
        //$(window).scroll(c5_scroll_auto_align);
        //c5_scroll_auto_align();
    }
    
    $(".c5-pre-con").fadeOut("slow");

}); /* end of as page load scripts */


/*! A fix for the iOS orientationchange zoom bug.
 Script by @scottjehl, rebound by @wilto.
 MIT License.
 */
(function(w) {
    // This fix addresses an iOS bug, so return early if the UA claims it's something else.
    if (!(/iPhone|iPad|iPod/.test(navigator.platform) && navigator.userAgent.indexOf("AppleWebKit") > -1)) {
        return;
    }
    var doc = w.document;
    if (!doc.querySelector) {
        return;
    }
    var meta = doc.querySelector("meta[name=viewport]"),
            initialContent = meta && meta.getAttribute("content"),
            disabledZoom = initialContent + ",maximum-scale=1",
            enabledZoom = initialContent + ",maximum-scale=10",
            enabled = true,
            x, y, z, aig;
    if (!meta) {
        return;
    }
    function restoreZoom() {
        meta.setAttribute("content", enabledZoom);
        enabled = true;
    }
    function disableZoom() {
        meta.setAttribute("content", disabledZoom);
        enabled = false;
    }
    function checkTilt(e) {
        aig = e.accelerationIncludingGravity;
        x = Math.abs(aig.x);
        y = Math.abs(aig.y);
        z = Math.abs(aig.z);
        // If portrait orientation and in one of the danger zones
        if (!w.orientation && (x > 7 || ((z > 6 && y < 8 || z < 8 && y > 6) && x > 5))) {
            if (enabled) {
                disableZoom();
            }
        }
        else if (!enabled) {
            restoreZoom();
        }
    }
    w.addEventListener("orientationchange", restoreZoom, false);
    w.addEventListener("devicemotion", checkTilt, false);
})(this);
