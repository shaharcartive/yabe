jQuery(document).ready(function ($) {


 
function c5_show_hide_box(value, target) {
	if(value == 'on'){
		$('#' + target).fadeIn();
	}else {
		$('#' + target).fadeOut();
	}
}

var use_color = $('#setting_use_custom_colors input[name="use_custom_colors"]:checked').val();
c5_show_hide_box(use_color, 'meta_styling_color');

var use_layout = $('#setting_use_custom_layout input[name="use_custom_layout"]:checked').val();
c5_show_hide_box(use_layout, 'meta_styling_layout');


 $(document).on('click', '#setting_use_custom_colors input', function (e) {
 	var value = $(this).val();
 	c5_show_hide_box(value, 'meta_styling_color');
 });
 $(document).on('click', '#setting_use_custom_layout input', function (e) {
 	var value = $(this).val();
 	c5_show_hide_box(value, 'meta_styling_layout');
 });
 
 $(document).on('click', '.c5_span_icon', function (e) {
 	$('.c5_span_icon').removeClass('selected');
 	$(this).addClass('selected');
 	$('#c5_icon').val($(this).attr('data-class'));
 });
 
 
 $('.quick-panel-flexslider').flexslider({
          animation: "slide",
          slideshow: false,
          touch:false,
          smoothHeight: false,
          animationLoop:false,
          controlNav: false,
          directionNav:false,
          
      });
  $(document).on("click", ".c5-next-page", function (e) {
  		var slide_no = $(this).attr('data-slide');
        $('.quick-panel-flexslider').flexslider( parseInt( slide_no) );
  });
  
  
  $(document).on("click", ".c5-install-button", function (e) {
  		data = '<h3><span class="fa fa-spin fa-circle-o-notch"></span> Installting...</h3><p>Please wait, you will be notified when your request is processed.</p>';
  			$.magnificPopup.open({
  			  items: {
  			    src: data
  			  },
  			  mainClass: 'mfp-install-demo-post',
  			  type: 'inline'
  			}, 0);
  		var k = $(this);
          $.ajax({
              type: "post",
              url: ajaxurl,
              data: "action=c5_install_demo&type="+k.attr('data-type')+"&id="+k.attr('data-demo'),
              success: function(count){
              	$.magnificPopup.close();
              	data = '<h3><span class="fa fa-check-square-o"></span> Done.</h3><p>Thank you, your request have been proceeded, below you can find any additional messages from the importer.</p><pre>'+count+'</pre>';
          		$.magnificPopup.open({
          		  items: {
          		    src: data
          		  },
          		  mainClass: 'mfp-install-demo-post',
          		  type: 'inline'
          		}, 0);
              	
              	k.addClass('c5-installed');
              }
          });
  
          return false;
      });
 
 $(document).on("click", ".c5_install_button", function (e) {
     
     data = '<h3>Install Demo Content</h3><p>installing now...</p>';
     $.magnificPopup.open({
       items: {
         src: data
       },
       mainClass: 'mfp-install-demo-post',
       type: 'inline'
     }, 0);
     
     
     window.location.href = $("#website_dir").val() + '/wp-admin/admin.php?import=c5_wordpress';
     
     
     
  }); 
  
  $(document).on('click', '.c5-video-tutorial', function (e) {
  
  var str = $(this).attr('class');
  var myArray = str.split(' ');
  var myArray2 = myArray[1].split('#');
  
  	var data = '<iframe width="853" height="480" src="http://www.youtube.com/embed/' +myArray2[1]+ '?rel=0" frameborder="0" allowfullscreen></iframe>';
  	
  	$.magnificPopup.open({
  	    items: {
  	        src: data
  	    },
  	    mainClass: 'c5ab-video-post',
  	    type: 'inline',
  	    closeOnContentClick:false,
  	});
  	
  });
  
  
    //posts js
  
 

 

 
 });