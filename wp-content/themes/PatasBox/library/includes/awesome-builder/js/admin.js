/**
 * Awesome Builder UI
 * 
 * Dependencies: jQuery, jQuery UI
 *
 * @author Code125(info@code125.com)
 */
;(function($) {
  C5AB_UI = {
    processing: false,
    init: function() {
    	this.defaut_actions();
    	this.enable_sortable();
    	this.responsiveViewTrigger();
    	this.saveWidgetData();
    	this.generateShortcode();
    },
    defaut_actions: function (){
    	var $switchButton = $('.c5ab-launch-builder');
    	if( $('#c5abShowBuilder').val() == 'nTrue'){
    		$('#postdivrich').fadeOut();
    		$('#c5bp-builder-panel').fadeIn();
    		$switchButton.html( $switchButton.attr('data-hide'));
    		$switchButton.addClass('showen');
    		$('#c5abShowBuilder').val('True');
    	}
    	$(document).on('click', '.c5ab-launch-builder', function (e) {
    		if($(this).hasClass('showen')){
    			$('#c5bp-builder-panel').fadeOut();
    			$('#postdivrich').fadeIn();
    			$(this).removeClass('showen');
    			$(this).html($(this).attr('data-show'));
    			$('#c5abShowBuilder').val('False');
    		
    		}else {
    			$('#postdivrich').fadeOut();
    			$('#c5bp-builder-panel').fadeIn();
    			
    			$(this).addClass('showen');
    			$(this).html($(this).attr('data-hide'));
    			$('#c5abShowBuilder').val('True');
    		}
    	});
    	$("[title]").tipTip();
    	$(document).on('mouseenter', '[title]', function (e) {
    	
    		$("[title]").tipTip();
    	});
    	$(document).on('click', '.option-tree-setting-edit', function (e) {
    		OT_UI.init();
    	});
    	
    	var $sidebar   = $(".c5ab-panel-container .c5ab-control-panel");
    	var $window    = $(window);
    	
    	
    	var sidebarHeight = $sidebar.height();
    	var topPadding = 15;
    	if($(".c5ab-panel-container").length > 0){
    	$window.scroll(function() {
    		var sideOffset =  $(".c5ab-panel-container").offset();
    		var panel_height = $('.c5ab-panel-container ');
    	    if ($window.scrollTop()  > sideOffset.top &&  $window.scrollTop() < panel_height.height() ) {
    	        $sidebar.stop().css('marginTop' ,  $window.scrollTop() - sideOffset.top - topPadding  );
    	    }else {
    	        $sidebar.stop().css('marginTop' , topPadding);
    	    }
    	});
    	}
    	
    	$(document).on('click', '.c5abf-trash', function (e) {
    		var obj = C5AB_UI.get_parent($(this));
    		obj.remove();
    		
    		C5AB_UI.orderTemplate();
    		$(this).preventDefault();
    	});
    	
    	$(document).on('click', '.c5ab-launch-video', function (e) {
    		
    		var data = '<iframe width="853" height="480" src="http://www.youtube.com/embed/' +$(this).attr('data-video')+ '?rel=0" frameborder="0" allowfullscreen></iframe>';
    		
    		$.magnificPopup.open({
    		    items: {
    		        src: data
    		    },
    		    mainClass: 'c5ab-video-post',
    		    type: 'inline',
    		    closeOnContentClick:false,
    		});
    		
    		$(this).preventDefault();
    	});
    	
    	
    	
    	$(document).on('click', '.c5ab-load-template ul.c5ab-templates li', function loadTemplate (e) {
    		var data = {
    				action: 'c5ab_load_template',
    				id: $(this).attr('data-id'),
    			};
    		$.post(ajaxurl, data, function(response) {
    			$('.c5ab-quick-tour').remove();
    			$('#c5ab-panel-wrap-js').append(response);
    			C5AB_UI.enable_sortable();
    		}); 
    	});
    	
    	
    	$(document).on('click', '.c5abf-cog', function launchRowEdit (e) {
    		var id = C5AB_UI.get_parent($(this)).attr('data-id');
    		var data = {
    				action: 'c5ab_edit_options_panel',
    				id: id,
    				options: $('#c5ab-' + id + '-settings').val(),
    			};
    		C5AB_UI.loadingWindow();
    		$.post(ajaxurl, data, function(response) {
    			$.magnificPopup.close();
    			$.magnificPopup.open({
    			    items: {
    			        src: response
    			    },
    			    mainClass: 'c5ab-widgets-post',
    			    type: 'inline',
    			    closeOnContentClick:false,
    			    closeOnBgClick:false,
    			    showCloseBtn:false,
    			    enableEscapeKey:false
    			});
    		
    		}); 
    	});
    	
    	$(document).on('click', '.c5ab-close-screen', function (e) {
    		$.magnificPopup.close();
    	});
    	
    	
    	$(document).on('click', '.c5ab-animation-wrap', function (e) {
    		$('#c5ab-animation').val($(this).attr('data-animation'));
    		$('.c5ab-animation-wrap').removeClass('selected');
    		$('.c5ab-animation-preview').removeClass().addClass('c5ab-animation-preview animated ');
    		$('.c5ab-animation-preview').addClass($(this).attr('data-animation'));
    		$(this).addClass('selected');
    	});
    	
    	  
    	
    	
    	$(document).on('click', '.c5abf-duplicate', function (e) {
    		var obj = C5AB_UI.get_parent($(this));
    		var new_id = C5AB_UI.randString(4);
    		var temp = obj.clone();
    		var new_id_total = obj.attr('data-id') + new_id;
    		temp.find('input').each( function ( ) {
    			var k = $(this).attr('id');
    			var arrayOfStrings = k.split('-');
    			if( $(this).attr('id') == $(this).val() + '-id' ){
    				$(this).val( arrayOfStrings[0] + new_id + '-' + arrayOfStrings[1] );
    					
    			}
    			$(this).attr('id', 'c5ab-' + arrayOfStrings[1] + new_id + '-' + arrayOfStrings[2] );
    			$(this).attr('name', 'c5ab-' +  arrayOfStrings[1] + new_id +'-' + arrayOfStrings[2]);
    			
    			C5AB_UI.get_parent($(this)).attr('data-id', arrayOfStrings[1] + new_id);
    			    			
    		});
    		
    		temp.find('.ui-resizable-handle').remove();
    		obj.parent().append(temp);
    		C5AB_UI.enable_sortable();
    		
    		C5AB_UI.orderTemplate();
    		if(obj.hasClass('c5ab-row')){
    			C5AB_UI.scrollToElement('#c5ab-' + new_id_total + '-type' );
    		}
    		$(this).preventDefault();
    		
    		
    	});
    	
    	$(document).on('click', '.c5ab-control-panel span', function (e) {
    		var new_id = C5AB_UI.randString(6);
    		var $html = C5AB_UI.addRow($(this).attr('data-columns'), new_id);
    		$('.c5ab-panel-wrap').children('.c5ab-panel-rows-wrap').append( $html );
    		C5AB_UI.enable_sortable();
    		
    		C5AB_UI.orderTemplate();
    		C5AB_UI.scrollToElement('#c5ab-' + new_id + '-type' );
    		
    	});
    	
    	$(document).on('click', '.c5ab-add-element ', function (e) {
    		var id = $(this).parent().parent().parent();
    		C5AB_UI.loadingWindow();
    		$.ajax({
    		    type: "post",
    		    url: c5ab_ajax_object.ajax_url,
    		    data: "action=c5ab_load_widgets&parent=" + id.attr('data-id'),
    		    success: function(data){
    		        $.magnificPopup.close();
    		        $.magnificPopup.open({
    		            items: {
    		                src: data
    		            },
    		            mainClass: 'c5ab-widgets-post',
    		            type: 'inline'
    		        }, 0);
    		    }
    		});
    	});
    	
    	$(document).on('keyup', 'input.c5ab_search', function (e) {
    	    var text = $(this).val().toLowerCase();
    	    var items = $("ul.c5ab-all-widgets li");
    	
    	    //first, hide all:
    	    items.hide();
    	
    	    //show only those matching user input:
    	    items.filter(function () {
    	        var bool = false;
    	        
    	         if( $(this).children('.c5ab-single-widget-wrap').children('h4').text().toLowerCase().search(text) >= 0 || $(this).children('.c5ab-single-widget-wrap').children('p').text().toLowerCase().search(text) >= 0) {
    	         	bool= true;
    	         }
    	         
    	         return bool;
    	    }).show();
    	});
    	$(document).on('keyup', 'input.c5-icon-search', function (e) {
    	    var text = $(this).val().toLowerCase();
    	    var items = $(this).parent().children('.option-tree-ui-radio-images')
    	
    	    //first, hide all:
    	    items.hide();
    	
    	    //show only those matching user input:
    	    items.filter(function () {
    	        var bool = false;
    	        
    	         if( $(this).attr('data-icon').toLowerCase().search(text) >= 0 ) {
    	         	bool= true;
    	         }
    	         
    	         return bool;
    	    }).show();
    	});
    	
    	
    	$(document).on('click', '.c5ab-single-widget ', function (e) {
    		if($(this).hasClass('c5ab-single-shortcode')){
    			C5AB_UI.launchShortcodeEdit($(this).attr('data-widget-class'), $(this).attr('data-source'), $(this).attr('data-parent-id'));
    		}else{
    			var parent_id = $(this).attr('data-parent');
    			var new_id = C5AB_UI.addElement( $(this).children('.c5ab-single-widget-hidden') , parent_id);
    		
    			C5AB_UI.launchWidgetEdit(new_id);
    		}
    	});
    	
    	$(document).on('click', '.c5ab-animation-text ', function (e) {
    		$('.c5ab-animation-container-wrap').toggle(400);
    		$('.c5ab-animation-preview-wrap').toggle(400);
    		
    	});
    	
    	$(document).on('click', '.c5ab_launch_generator ', function (e) {
    		if($(this).hasClass('c5ab_another_editor')){
    			
    			parent_elm = $(this);
    			do {
    				 parent_elm = parent_elm.parent();
    			} while (!parent_elm.hasClass('format-settings'));
    			
    			C5AB_UI.launchShortcodesSelector('another_editor', parent_elm.attr('id'));
    		}else {
    			C5AB_UI.launchShortcodesSelector('default_editor', '');
    		}
    		
    	});
    	
    	
    	$(document).on('click', '.c5ab-element ', function (e) {
    		var new_id = $(this).attr('data-id');
    		
    		C5AB_UI.launchWidgetEdit(new_id);
    		
    	});
    	
    	$(document).on('click', '.c5ab-screen-control ', function (e) {
    		var obj = $(this);
    		
    		if(obj.hasClass('c5abf-laptop')){
    			if(obj.hasClass('TRUE')){
    				obj.removeClass('TRUE');
    				obj.addClass('FALSE');
    				obj.parent().children('#desktop').val('FALSE');
    			}else {
    				obj.removeClass('FALSE');
    				obj.addClass('TRUE');
    				obj.parent().children('#desktop').val('TRUE');
    			}
    		
    		}else if(obj.hasClass('c5abf-tablet')){
    			if(obj.hasClass('TRUE')){
    				obj.removeClass('TRUE');
    				obj.addClass('FALSE');
    				obj.parent().children('#tablet').val('FALSE');
    			}else {
    				obj.removeClass('FALSE');
    				obj.addClass('TRUE');
    				obj.parent().children('#tablet').val('TRUE');
    			}
    		}else if(obj.hasClass('c5abf-mobile')){
    			if(obj.hasClass('TRUE')){
    				obj.removeClass('TRUE');
    				obj.addClass('FALSE');
    				obj.parent().children('#mobile').val('FALSE');
    			}else {
    				obj.removeClass('FALSE');
    				obj.addClass('TRUE');
    				obj.parent().children('#mobile').val('TRUE');
    			}
    		}    		
    	});
    	
    	
    	
    	
    },
    scrollToElement: function(selector, time, verticalOffset) {
        time = typeof(time) != 'undefined' ? time : 1000;
        verticalOffset = typeof(verticalOffset) != 'undefined' ? verticalOffset : 0;
        element = $(selector).parent();
        offset = element.offset();
        offsetTop = offset.top + verticalOffset;
        $('html, body').animate({
            scrollTop: offsetTop
        }, time);
    },
    get_parent: function (elm) {
    	do {
    		 elm = elm.parent();
    	} while (!elm.hasClass('c5ab-base'));
    	
    	return elm;
    },
    loadingWindow: function () {
    	$.magnificPopup.close();
    	$.magnificPopup.open({
    	    items: {
    	        src: '<span class="c5abf-cog c5ab-loading-widnow"></span>'
    	    },
    	    mainClass: 'c5ab-loading-post',
    	    type: 'inline',
    	    showCloseBtn:false,
    	});
    },
    
    enable_sortable: function () {
    	
    	$( ".c5ab-panel-rows-wrap " ).sortable({
    	      placeholder: "c5ab-placeholder",
    	      items: ".c5ab-element",
    	      connectWith: ".c5ab-layout-base-elements",
    	      stop: function( event, ui ) {
    	      	 C5AB_UI.orderTemplate();
    	      }
    	});
    	
    	
    	
    	$( ".c5ab-panel-wrap" ).sortable({
    	      placeholder: "c5ab-placeholder c5ab-row",
    	      items: ".c5ab-row ",
    	      connectWith: ".c5ab-panel-rows-wrap",
    	      stop: function( event, ui ) {
    	      	 C5AB_UI.orderTemplate();
    	      }
    	});
    	/*
    	$( ".c5ab-row-base-elements" ).sortable({
    	      placeholder: "c5ab-placeholder",
    	      items: ".c5ab-element",
    	      connectWith: ".c5ab-layout-base-elements",
    	      stop: function( event, ui ) {
    	      	 C5AB_UI.orderTemplate();
    	      }
    	});
    	*/
    	
    	$(".c5ab-panel-wrap .c5ab-layout").resizable({
    	    autoHide: true,
    	    resize: function(e, ui) {
    	        var parent = ui.element.parent();
    	        
    	        var old_span = C5AB_UI.getColsCount( ui.element );
    	        
    	        var col_count = parseInt($('#c5ab-col-count-js').attr('data-col-count'));
    	        
    	        var new_span = Math.round( col_count*ui.size['width'] / parent.width());
    	        if(new_span > col_count){
    	        	new_span = col_count;
    	        }
    	        if(new_span < 0){
    	        	new_span = 0;
    	        }
    	        if(C5AB_UI.getResponsiveView() == 'desktop'){
    	        	var next_element = ui.element.next();
    	        	if(next_element.hasClass('c5ab_base_col')){
    	        		var next_span = C5AB_UI.getColsCount(next_element);
    	        		var total_span = next_span + old_span;
    	        		C5AB_UI.removeCols(  next_element );
    	        		next_span = total_span - new_span;
    	        		next_element.addClass('c5ab_col_' + next_span);
    	        	}else {
    	        		if(old_span > 1){
    	        			ui.element.parent().append( C5AB_UI.addColumn(0,2) );
    	        			C5AB_UI.enable_sortable();
    	        			C5AB_UI.initResizeHelper();
    	        		}
    	        	}
    	        }
    	        
    	        
    	        
    	        C5AB_UI.removeCols(  ui.element );
    	        
    	        ui.element.removeAttr('style');
    	        ui.element.addClass('c5ab_col_' + new_span);
    	        
    	        
    	    },
    	    stop: function(e, ui) {
    	    	
    	    	C5AB_UI.updateViewLayoutCount(ui.element);
    	    	C5AB_UI.updateViewLayoutCount(ui.element.next());
    	        if( ui.element.hasClass('c5ab_col_0')){
    	        	ui.element.remove();
    	        }
    	        if( ui.element.next().hasClass('c5ab_col_0')){
    	        	ui.element.next().remove();
    	        }
    	        
    	        C5AB_UI.orderTemplate();
    	    }
    	});
    	$('.ui-resizable-e').html(C5AB_UI.resizeHelper);
    	
    	C5AB_UI.initResizeHelper();
    	C5AB_UI.orderTemplate();
    
    },
    updateViewLayoutCount: function (element) {
    	var id = element.attr('data-id');
    	var current_count = C5AB_UI.getColsCount(element);
    	element.children('.c5ab-layout-wrap').children('.c5ab-container').children('.c5ab-base-elements').children('#c5ab-' +  id + '-' + C5AB_UI.getResponsiveView()).val(current_count);
    },
    randString: function(n)
    {
        if(!n)
        {
            n = 5;
        }
    
        var text = '';
        var possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    
        for(var i=0; i < n; i++)
        {
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        }
    
        return text;
    },
    remove: function(e) {
    
    },
    responsiveViewTrigger: function(e) {
    	$(document).on('click', '.c5ab_view_controls span', function (e) {
    		$('.c5ab_view_controls span').removeClass('selected');
    		$('.c5ab-main-panel-wrap').removeClass('c5ab_editing_off');
    		 
    		$(this).addClass('selected');
    		if( !$(this).hasClass('c5ab_desktop') ){
    			$('.c5ab-main-panel-wrap').addClass('c5ab_editing_off');
    		}
    		C5AB_UI.showLayout();
    	});
    	
    },
    showLayout: function () {
    	$('.c5ab-layout').each(function () {
    		C5AB_UI.removeCols($(this));
    		var span = $(this).children('.c5ab-layout-wrap').children('.c5ab-container').children('.c5ab-base-elements').children('#c5ab-' +  $(this).attr('data-id') + '-' + C5AB_UI.getResponsiveView() ).val() ;
    		$(this).addClass('c5ab_col_' + span);
    	});
    },
    getResponsiveView: function(e) {
    	var value = '';
    	$('.c5ab_view_controls span').each(function () {
    		
    		if($(this).hasClass('selected')){
    			if($(this).hasClass('c5abf-laptop')){
    				value =  'desktop';
    			}else if($(this).hasClass('c5abf-tablet')){
    				value =  'tablet';
    			}else if($(this).hasClass('c5abf-mobile')){
    				value =  'phone';
    			}
    		}
    	});
    	return value;
    },
    initResizeHelper: function(e) {
    	$('.ui-resizable-e').html('<div class="c5ab-resize"><span class="c5ab-move-left c5abf-left-open c5ab-sq-btn"></span><span class="c5ab-move c5abf-hdrag c5ab-sq-btn" title="Move"></span><span class="c5ab-move-right c5abf-right-open c5ab-sq-btn"></span></div>');
    },
    addColumn: function(desktop, tablet) {
    	
    	var test = $('#c5ab-sample-layout').clone();
    	var new_id = C5AB_UI.randString(6);
    	var old_id = 'test-id';
    	
    	test.children('.c5ab_base_col').attr('data-id' , new_id);
    	
    	test.children('.c5ab_base_col').removeClass('c5ab_col_0').addClass('c5ab_col_' + desktop);
    	
    	var settings = [ 'id' ,  'order', 'parent', 'type' , 'content' , 'desktop' , 'tablet' , 'phone' ];
    	$.each( settings, function( i , value  ) {
    		test.find( '#c5ab-' + old_id + '-' + value).attr('name' , 'c5ab-' + new_id + '-' + value);
    		test.find( '#c5ab-' + old_id + '-' + value).attr('id' , 'c5ab-' + new_id + '-' + value);
    	});
    	
    	test.find('#c5ab-' + new_id + '-desktop').val(desktop);
    	test.find('#c5ab-' + new_id + '-tablet').val(tablet);
    	
    	
    	return test.html();
    },
    
    addRow: function(columns, new_id) {
    	$('.c5ab-quick-tour').remove();
    	var test = $('#c5ab-sample-row').clone();
    	
    	var old_id = 'test-id';
    	
    	test.children('.c5ab-row').attr('data-id' , new_id);
    	
    	var settings = [ 'id' ,  'order', 'parent', 'type' , 'content' , 'settings' , 'background' , 'bg_mode' , 'full_width' ];
    	$.each( settings, function( i , value  ) {
    		test.find( '#c5ab-' + old_id + '-' + value).attr('name' , 'c5ab-' + new_id + '-' + value);
    		test.find( '#c5ab-' + old_id + '-' + value).attr('id' , 'c5ab-' + new_id + '-' + value);
    	});
    	var arr = columns.split('_');
    	$.each( arr, function( i , value  ) {
    		test.find('.c5ab-row-base-elements').append( C5AB_UI.addColumn(value , value));
    	});
    	
    	
    	return test.html();
    },
    addElement: function(obj , parent_id) {
    	
    	var new_id = C5AB_UI.randString(6);
    	var old_id = 'test-id';
    	
    	obj.children('.c5ab-element').attr('data-id' , new_id);
    	
    	var settings = [ 'id' ,  'order', 'parent', 'type' ,'helper_text', 'widget_class' , 'content' , 'animation' , 'animation_delay' , 'animation_duration' , 'desktop', 'tablet', 'mobile' ];
    	$.each( settings, function( i , value  ) {
    		obj.find( '#c5ab-' + old_id + '-' + value).attr('name' , 'c5ab-' + new_id + '-' + value);
    		obj.find( '#c5ab-' + old_id + '-' + value).attr('id' , 'c5ab-' + new_id + '-' + value);
    	});
    	
    	
    	$('#c5ab-' + parent_id + '-type').parent().append(obj.html()); 
    	
    	return new_id;   	
    	
    },
    launchWidgetEdit: function(id) {
    	
    	var data = {
    			action: 'c5ab_edit_widget',
    			id: id,
    			class: $('#c5ab-' + id + '-widget_class').val(),
    			content: $('#c5ab-' + id + '-content').val(),
    			animation: $('#c5ab-' + id + '-animation').val(),
    			desktop: $('#c5ab-' + id + '-desktop').val(),
    			tablet: $('#c5ab-' + id + '-tablet').val(),
    			mobile: $('#c5ab-' + id + '-mobile').val(),
    			
    			
    			animation_delay: $('#c5ab-' + id + '-animation_delay').val(),
    			animation_duration: $('#c5ab-' + id + '-animation_duration').val(),
    		};
    		C5AB_UI.loadingWindow();
    		
    	$.post(ajaxurl, data, function(response) {
    		$.magnificPopup.close();
    		$.magnificPopup.open({
    		    items: {
    		        src: response
    		    },
    		    mainClass: 'c5ab-widgets-post',
    		    type: 'inline',
    		    preloader: true,
    		    closeOnContentClick:false,
    		    closeOnBgClick:false,
    		    showCloseBtn:false,
    		    enableEscapeKey:false,
    		});
    	
    	}); 
    		
    	
    },
    launchShortcodeEdit: function(class_name, c5_source , parent_id) {
    	
    	var data = {
    			action: 'c5ab_edit_shortcode',
    			class_name: class_name,
    			content: c5_source,
    			parent_id: parent_id
    		};
    	C5AB_UI.loadingWindow();
    	$.post(ajaxurl, data, function(response) {
    		$.magnificPopup.close();
    		$.magnificPopup.open({
    		    items: {
    		        src: response
    		    },
    		    mainClass: 'c5ab-widgets-post',
    		    type: 'inline',
    		    closeOnContentClick:false,
    		    closeOnBgClick:false,
    		    showCloseBtn:false,
    		    enableEscapeKey:false
    		});
    	
    	}); 
    		
    	
    },
    launchShortcodesSelector: function(c5_type, parent_id) {
    	if(c5_type == 'another_editor'){
    		var data = {
    			action: 'c5ab_launch_generator',
    			content: 'another',
    			parent_id: parent_id
    		};
    	}else {
    		var data = {
    			action: 'c5ab_launch_generator',
    			content: 'default'
    		};
    	}
    	C5AB_UI.loadingWindow();
    	$.post(ajaxurl, data, function(response) {
    		$.magnificPopup.close();
    		$.magnificPopup.open({
    		    items: {
    		        src: response
    		    },
    		    mainClass: 'c5ab-widgets-post',
    		    type: 'inline',
    		    closeOnContentClick:false,
    		    closeOnBgClick:false,
    		    showCloseBtn:false,
    		    enableEscapeKey:false
    		});
    	
    	}); 
    		
    	
    },
    saveWidgetData: function (elm) {
    	$(document).on('click', '.c5ab-save-widget-data', function (e) {
    		tinyMCE.triggerSave();
    		var t = $(this);
    		var data = {
    				action: 'c5ab_save_widget_data',
    				content: $('#c5ab-widget-form').serialize()
    			};
    		
    		$.post(ajaxurl, data, function(response) {
    			$('#c5ab-' + t.attr('data-id') + '-content').val(response);
    			
    			$.magnificPopup.close();
    		});
    		

    		/*
    		alert( window.btoa( $('#c5ab-widget-form').serialize()  )  );
    		
    		$('#c5ab-' + t.attr('data-id') + '-content').val( window.btoa( $('#c5ab-widget-form').serialize()  )  ); 
    		*/
    		var test_field = $('#c5ab-widget-form input[type=text]').eq('2').val();
    		if( test_field  == ''){
    			var test_field = $('#c5ab-widget-form input[type=text]').eq('3').val();
    		}
    		$('#c5ab-' + t.attr('data-id') + '-helper_text').val(test_field);
    		$('#c5ab-' + t.attr('data-id') + '-desktop').val($('#desktop').val());
    		$('#c5ab-' + t.attr('data-id') + '-tablet').val($('#tablet').val());
    		$('#c5ab-' + t.attr('data-id') + '-mobile').val($('#mobile').val());
    		$('#c5ab-' + t.attr('data-id') + '-animation').val($('#c5ab-animation').val());
    		$('#c5ab-' + t.attr('data-id') + '-animation_delay').val($('#c5ab-animation_delay').val());
    		$('#c5ab-' + t.attr('data-id') + '-animation_duration').val($('#c5ab-animation_duration').val());
    		$('#c5ab-' + t.attr('data-id') + '-helper_text').parent().find('.c5ab-helper-text').text(test_field);
    		C5AB_UI.loadingWindow();
    		C5AB_UI.orderTemplate();
    	});
    	
    	$(document).on('click', '.c5ab-save-row-data', function (e) {
    		
    		var t = $(this);
    		var data = {
    				action: 'c5ab_save_row_data',
    				content: $('#c5ab-row-form').serialize()
    			};
    		
    		$.post(ajaxurl, data, function(response) {
    			//alert(response);
    			$('#c5ab-' + t.attr('data-id') + '-settings').val(response);
    			
    			$.magnificPopup.close();
    		});
    		C5AB_UI.loadingWindow();
    		C5AB_UI.orderTemplate();
    	});
    	
    	
    },
    generateShortcode: function () {
    	$(document).on('click', '.c5ab-generate-shortcode-data', function (e) {
    		
    		var t = $(this);
    		var class_name = t.attr('data-class');
    		var c5_source = t.attr('data-source');
    		var c5_parent_id = t.attr('data-parent-id');
    		var data = {
    				action: 'c5ab_generate_shortcode',
    				class: class_name,
    				content: $('#c5ab-widget-form').serialize()
    			};
    		
    		$.post(ajaxurl, data, function(response) {
    			if(c5_source == 'another'){
    				var return_elm = $('#' + c5_parent_id).find('.textarea');
    				return_elm.val( return_elm.val( ) + response);
    			}else {
    				send_to_editor(response);	
    			}
    		});
    		$.magnificPopup.close();
    	});
    	
    },
    removeCols: function(e) {
    
    	var col_count = parseInt($('#c5ab-col-count-js').attr('data-col-count'));
    	for (var i = 0; i <= col_count; i++) {
    		e.removeClass('c5ab_col_' + i);
    	}
    },
    getColsCount: function(e) {
    
    	var col_count = parseInt($('#c5ab-col-count-js').attr('data-col-count'));
    	for (var i = 0; i <= col_count; i++) {
    		if(e.hasClass('c5ab_col_' + i)){
    			return i;
    		}
    	}
    	
     },
     
     
     orderTemplate: function() {
     	var order = 0;
     	$('.c5ab-panel-rows-wrap').children('.c5ab-row').each(function () {
     		var obj = $(this);
     		
     		obj.find('#c5ab-'+ obj.attr('data-id') + '-order').val(order);
     		order++;
     		
     		
     	});
     	$('.c5ab-panel-rows-wrap').find('.c5ab-base').each(function () {
     		var current_obj = $(this);
     		var parent_obj = C5AB_UI.get_parent(current_obj);
     		C5AB_UI.setParent(current_obj , parent_obj.attr('data-id'));
     		if( current_obj.hasClass('c5ab-row') ){
     			C5AB_UI.orderRow( current_obj); 
     		
     		}else if( current_obj.hasClass('c5ab-layout') ){
     			C5AB_UI.orderLayout( current_obj);
     		}
     	
     	});
     	
      },
      orderRow: function (curren_obj) {
      	var order = 0;
      	curren_obj.children('.c5ab-row-wrap').children('.c5ab-container ').children('.c5ab-base-elements').children('.c5ab-layout').each(function() {
      		var obj = $(this);
      		
      		obj.find('#c5ab-'+ obj.attr('data-id') + '-order').val(order);
      		order++;
      	});
      
      },
      orderLayout: function (curren_obj) {
      	var order = 0;
      	curren_obj.children('.c5ab-layout-wrap ').children('.c5ab-container ').children('.c5ab-base-elements').children('.c5ab-base ').each(function() {
      		var obj = $(this);
      		
      		obj.find('#c5ab-'+ obj.attr('data-id') + '-order').val(order);
      		order++;
      	});
      
      },
      setParent: function(elm, parent_id) {
      	var id = elm.attr('data-id');
      	elm.find('#c5ab-' + id + '-parent').val(parent_id);
      	
       },
  };
  $(document).ready( function() {
    C5AB_UI.init();
  });
})(jQuery);
