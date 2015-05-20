<?php 

class C5_header_css {
	
	function __construct() {
	
	}
	
	function hook() {
		add_action('wp_head', array($this, 'custom_css'), 229);
	}
	function format_background($array) {
	    $data = '';
	    $properties = array(
	    	'background-color',
	    	'background-position',
	    	'background-repeat',
	    	'background-attachment',
	    	'background-image',
	    );
	    
	    foreach ($properties as $property) {
    		if( isset($array[$property]) ){
	    		if ($array[$property] != '') {
	    			if($property == 'background-image'){
	    				$data .= $property . ':url(\'' . esc_url($array[$property]) . '\');';
	    			}else{
	    		    	$data .= $property .':' . $array[$property] . ';';
	    			}
	    		}
    		}
    	
    	}
	    return $data;
	}
	
	    function custom_css() {
	        global $c5_skindata;
	        global $c5_headerdata;
	
	        $heading_font = explode('#', $c5_skindata['heading_font']);
	        $body_font = explode('#', $c5_skindata['body_font']);
	
	        $obj_style = new C5AB_STYLE();
	        $rgb = $obj_style->hex2rgb($c5_skindata['primary_color']);
	        if(is_single()){
	        	global $post;
	        	$user_id = $post->post_author;
	        	$google_plus_id=  get_the_author_meta('c5_term_meta_user_google_plus', $user_id);
	        	if($google_plus_id!=''){  ?>
	       			<link rel="author" href="http://www.google.com/+<?php echo $google_plus_id; ?>">
	        <?php } } ?>
	        <style id="c5-custom-css">
	
	
	            /** Primary Color**/
	
	            
	            .c5ab_posts_slider  .flex-control-paging li a.flex-active,
	            #wp-calendar td#today,
	            .c5ab_posts_thumb_boxes_single:hover .box-content,
	            .flip-post .post-data-bg,
	            .rating-row .progress-bar-success,
	            .c5-cat-info-warp:hover .c5-cat-icon,
	            .c5-sidebar-controller,
	            #bbpress-forums  fieldset.bbp-form .submit.button,
	            
	            .top-menu-nav ul.menu-sc-nav > li.menu-item > ul.sub-menu  li:hover,
	            .c5ab_circle,
	            .header.descended .c5-reading-progress,
	            .flex-control-paging li a.flex-active,
	            .c5ab_posts_thumb_blog_1_single a.c5-meta-cat,
	            .c5-main-header-wrap a.c5-meta-cat
	            {
	                background-color: <?php echo $c5_skindata['primary_color'] ?>;
	            }
	            /*
	            h3.title,
	            h2.title,
	            h3.widget-title,
	            .products h2,
	            .cross-sells h2,
	            .cart_totals h2,
	            .woocommerce-billing-fields h3,
	            .woocommerce-shipping-fields h3  label,
	            #order_review_heading,
	            #bbpress-forums fieldset.bbp-form legend,
	            .comment-form #submit,
	            .commentlist .comment-reply-link
	            {
	            	color: <?php echo $c5_skindata['primary_color'] ?>;
	            }
	            h3.widget-title::after,
	            h3.title::after,
	            h2.title::after,
	            .products h2::after,
	            .cross-sells h2::after,
	            .cart_totals h2::after,
	            .woocommerce-billing-fields h3::after,
	            .woocommerce-shipping-fields h3 label::after,
	            #order_review_heading::after,
	            #bbpress-forums fieldset.bbp-form legend::after{
	                border-top: 5px solid  <?php echo $c5_skindata['primary_color'] ?>;
	                border-left: 5px solid  <?php echo $c5_skindata['primary_color'] ?>;
	            }
	            */
	            
	            
	            
	            #bbpress-forums  fieldset.bbp-form .submit.button:hover{
	            	background-color: <?php echo $obj_style->hexDarker($c5_skindata['primary_color']) ?>;
	            }
				.c5ab_social_counter ul li a:hover,
				.c5ab_pricing_title{
					border-color:<?php echo $c5_skindata['primary_color'] ?>;
				}
	            .c5ab_post_thumb .hover,
	            .c5ab_posts_thumb_boxes_single .box-content{
	                background-color: <?php echo $c5_skindata['primary_color'] ?>;
	                background-color: rgba(<?php echo $rgb[0] ?> , <?php echo $rgb[1] ?> , <?php echo $rgb[2] ?>, 0.8);
	            }
	            
	            
	            
	           
	            a,
	            ul.newsticker a.c5-cat,
	            .c5ab_posts_slider ul li .content li a:hover,
	            .c5ab_posts_slider ul li .content li:hover,
	            .c5ab_post_thumb .content .c5_meta_data li:hover,
	            .c5ab_post_thumb .content .c5_meta_data a:hover,
	            .c5ab_post_thumb .content h3 a:hover,
	            .c5-rating-box .c5-rating-wrap .fa,
	            .c5-sitemap ul a:hover,
	            .c5ab_social_icons a:hover,
	            .c5ab_social_icons a:focus,
	            .c5-service-item:hover .fa,
	            .c5ab_social_counter ul li a:hover,
	            .c5-social-sidebar ul li:hover a,
	            a.c5-meta-cat,
	            .c5-pagination ul.page-numbers li span.num:hover {
	              
	                color: <?php echo $c5_skindata['primary_color'] ?>;
	            }
	            a:hover,
	            a.c5-meta-cat:hover{
	                color: <?php echo $obj_style->hexDarker($c5_skindata['primary_color']) ?>;
	            }
	
	            #c5-below-logo{
	                border-top: 4px solid <?php echo $c5_skindata['primary_color'] ?>;
	            }
	            #c5_bread_crumb .border{
	                border-left: 4px solid <?php echo $c5_skindata['primary_color'] ?>;
	            }
	            
	            a.c5btn,
	            #c5-submit-contact,
	            .comment-form #submit,
	            .commentlist .comment-reply-link,
	            #c5-login-submit,
	            .post-password-form input[type=submit] ,
	            .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit, .woocommerce #content input.button, .woocommerce-page a.button, .woocommerce-page button.button, .woocommerce-page input.button, .woocommerce-page #respond input#submit, .woocommerce-page #content input.button
	            
	            {
	            	background-color: <?php echo $c5_skindata['primary_color'] ?>;
	            	border-bottom: 3px solid <?php echo $obj_style->hexDarker($c5_skindata['primary_color']) ?>;
	            	text-shadow: 0px -2px <?php echo $obj_style->hexDarker($c5_skindata['primary_color']) ?>;
	            }
	            
	            a.c5btn:hover,
	            #c5-submit-contact:hover,
	            .comment-form #submit:hover,
	            .commentlist .comment-reply-link:hover,
	            #c5-login-submit:hover,
	            .post-password-form input[type=submit]:hover,
	            
	            .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .woocommerce #respond input#submit:hover, .woocommerce #content input.button:hover, .woocommerce-page a.button:hover, .woocommerce-page button.button:hover, .woocommerce-page input.button:hover, .woocommerce-page #respond input#submit:hover, .woocommerce-page #content input.button:hover {
	            	background-color: <?php echo $obj_style->hexDarker($c5_skindata['primary_color']) ?>;
	            	border-bottom: 3px solid <?php echo $obj_style->hexDarker($c5_skindata['primary_color'],20) ?>;
	            	text-shadow: 0px -2px <?php echo $obj_style->hexDarker($c5_skindata['primary_color'],20) ?>;
	            }
				
				/** woocommerce **/
				
				.c5-body-class.woocommerce div.product span.price, 
				.c5-body-class.woocommerce div.product p.price, 
				.c5-body-class.woocommerce #content div.product span.price, 
				.c5-body-class.woocommerce #content div.product p.price, 
				.c5-body-class.woocommerce-page div.product span.price, 
				.c5-body-class.woocommerce-page div.product p.price, 
				.c5-body-class.woocommerce-page #content div.product span.price, 
				.c5-body-class.woocommerce-page #content div.product p.price,
				
				.c5-body-class.woocommerce div.product .stock,
				.c5-body-class.woocommerce #content div.product .stock, 
				.c5-body-class.woocommerce-page div.product .stock, 
				.c5-body-class.woocommerce-page #content div.product .stock,
				
				.woocommerce .woocommerce-product-rating .star-rating,
				.woocommerce-page .woocommerce-product-rating .star-rating,
				
				.woocommerce div.product .woocommerce-tabs ul.tabs li:hover a,
				.woocommerce div.product .woocommerce-tabs ul.tabs li.active a,
				.woocommerce #content div.product .woocommerce-tabs ul.tabs li:hover a,
				.woocommerce #content div.product .woocommerce-tabs ul.tabs li.active a, 
				.woocommerce-page div.product .woocommerce-tabs ul.tabs li:hover a, 
				.woocommerce-page div.product .woocommerce-tabs ul.tabs li.active a, 
				.woocommerce-page #content div.product .woocommerce-tabs ul.tabs li:hover a, 
				.woocommerce-page #content div.product .woocommerce-tabs ul.tabs li.active a
				 {
					color: <?php echo $c5_skindata['primary_color'] ?>;
				}
				
				/*.c5-body-class.woocommerce div.product form.cart .button,
				.c5-body-class.woocommerce #content div.product form.cart .button,
				.c5-body-class.woocommerce-page div.product form.cart .button,
				.c5-body-class.woocommerce-page #content div.product form.cart .button,
				.woocommerce a.button, 
				.woocommerce button.button, 
				.woocommerce input.button, 
				.woocommerce #respond input#submit, 
				.woocommerce #content input.button, 
				.woocommerce-page a.button, 
				.woocommerce-page button.button, 
				.woocommerce-page input.button, 
				.woocommerce-page #respond input#submit, 
				.woocommerce-page #content input.button,*/
				.woocommerce ul.products li.product .crossfade-images .cart-loading .fa, 
				.woocommerce-page ul.products li.product .crossfade-images .cart-loading .fa,
				.woocommerce span.onsale, .woocommerce-page span.onsale,
				.woocommerce .cart-collaterals .shipping_calculator .shipping-calculator-button, 
				.woocommerce-page .cart-collaterals .shipping_calculator .shipping-calculator-button,
				.woocommerce .widget_price_filter .ui-slider .ui-slider-handle, 
				.woocommerce-page .widget_price_filter .ui-slider .ui-slider-handle,
				.woocommerce .widget_layered_nav ul li.chosen a, 
				.woocommerce-page .widget_layered_nav ul li.chosen a,
				.woocommerce ul.products li.product .c5-product-buttons a.added_to_cart, 
				.woocommerce-page ul.products li.product .c5-product-buttons a.added_to_cart{
					background: <?php echo $c5_skindata['primary_color'] ?>;
				}
				
				/*.c5-body-class.woocommerce div.product form.cart .button:hover, 
				.c5-body-class.woocommerce #content div.product form.cart .button:hover, 
				.c5-body-class.woocommerce-page div.product form.cart .button:hover, 
				.c5-body-class.woocommerce-page #content div.product form.cart .button:hover,
				.woocommerce a.button:hover, 
				.woocommerce button.button:hover, 
				.woocommerce input.button:hover, 
				.woocommerce #respond input#submit:hover,
				.woocommerce #content input.button:hover, 
				.woocommerce-page a.button:hover, 
				.woocommerce-page button.button:hover, 
				.woocommerce-page input.button:hover, 
				.woocommerce-page #respond input#submit:hover, 
				.woocommerce-page #content input.button:hover,
				.woocommerce .cart-collaterals .shipping_calculator .shipping-calculator-button:hover, 
				.woocommerce-page .cart-collaterals .shipping_calculator .shipping-calculator-button:hover{
					background: <?php echo $obj_style->hexDarker($c5_skindata['primary_color']) ?>;
					
				}*/
				
				.woocommerce .quantity .plus:hover, .woocommerce .quantity .minus:hover, .woocommerce #content .quantity .plus:hover, .woocommerce #content .quantity .minus:hover, .woocommerce-page .quantity .plus:hover, .woocommerce-page .quantity .minus:hover, .woocommerce-page #content .quantity .plus:hover, .woocommerce-page #content .quantity .minus:hover{
					border-color: <?php echo $c5_skindata['primary_color'] ?>;
				}
	
	            /** text color **/

	
	            /** font sizes ***/
	            
	            .top-menu-nav ul.menu-sc-nav>li.menu-item>a{
	            	font-size:<?php echo $c5_skindata['menu_fs'] ?>px;
	            }
	            
	            h3.title,
	            h2.title,
	            h3.widget-title,
	            .products h2{
	            	font-size:<?php echo $c5_skindata['title_fs'] ?>px;
	            }
	            
	            
	            ul.c5_meta_data li{
	            	font-size:<?php echo $c5_skindata['article_meta_fs'] ?>px;
	            }
	            .c5-dark-shadow .c5-header-data h1{
	            	font-size:<?php echo $c5_skindata['article_title_fs'] ?>px;
	            }
	            .c5-dark-shadow .c5-header-data p{
	            	font-size:<?php echo $c5_skindata['article_subtitle_fs'] ?>px;
	            }
	            .c5-article-content{
	            	font-size:<?php echo $c5_skindata['article_text_fs'] ?>px;
	            }
	            
	            
	            
	
	            
	            /** Font **/
	            body{
	                font-family: <?php echo $body_font[0] ?>,"Helvetica Neue", Helvetica, Arial, sans-serif ;
	                font-size: <?php echo $c5_skindata['body_fs'] ?>px;
	            }
	            h1,h2,h3,h4,h5,h6,
	            .top-menu-nav.default ul.menu-sc-nav > li.menu-item > a,
	            .c5-today,
	            .c5-breaking-wrap .breaking-title,
	            ul.newsticker li,
	            .navigation-shortcode.sidebar.top-menu-nav ul.menu-sc-nav > li.menu-item > a,
	            #wp-calendar,
	            .flip-post a.title-link,
	            h2.title,
	            .footer .widget_categories ul li,
	            .c5ab_social_counter ul li a span.count,
	            .services_wrapper .service-item .lower_half h5,
	            .c5ab_slider ul li .content p.title ,
	            .widget_recent-posts ul li a{
	                font-family: <?php echo $heading_font[0] ?>,"Helvetica Neue", Helvetica, Arial, sans-serif ;
	            }
	
	            <?php
	            $this->update_category();
	            $terms_options = $this->get_terms_array();
	            echo $this->terms_custom_css($terms_options);
	            ?>
			/***General Custom CSS**/
			<?php echo ot_get_option('custom_css'); ?>
			/***Skin Custom CSS**/
			<?php echo $c5_skindata['custom_css']; ?>
	        </style>
	
			
	        <?php
	        
	        echo ot_get_option('google_analytics');
	    }
	    
	    
	    
	    function update_category(){
	    	
	    	if (isset($_GET['update'])) {
	    		if($_GET['update'] == 'categories'){
	    			$terms = $this->create_terms_array();
	    			update_option( 'c5_terms_settings', $terms );
	    		}
	    	}
	    }
	    function get_terms_array() {
	    	global $c5_terms_array ;
	    	$category_styling = ot_get_option('category_styling');
	    	if($category_styling == 'off'){
	    		return array();
	    	}
	    	$terms = get_option( 'c5_terms_settings' );
	    	if(!is_array($terms)){
		    	$terms = $this->create_terms_array();
	    		update_option( 'c5_terms_settings', $terms );
	    	}
	    	
	    	$c5_terms_array = $terms;
	    	return $terms ;
	    }
	    function create_terms_array() {
	    	global $c5_terms_array ;
	    	
	    	$c5_terms_array= array();
	    	$taxonomies = get_taxonomies('', 'names');
	    	foreach ($taxonomies as $tax) {
	    	    $terms = get_terms($tax);
	    	    if (is_array($terms)) {
	    	        foreach ($terms as $term) {
	    	            $options =array();
	    	            
	    	            $icon = get_option('c5_term_meta_' . $tax . '_' . $term->term_id . '_icon');
	    	            if($icon != ''){
	    	            	$options['icon']= $icon;
	    	            }
	    	            
	    	            $use_color = get_option('c5_term_meta_' . $tax . '_' . $term->term_id . '_use_custom_colors');
	    	            
	    	            if($use_color == 'on'){
	    	            	$color = get_option('c5_term_meta_' . $tax . '_' . $term->term_id . '_primary_color');
	    	            	if($color != ''){
	    	            		$options['color']= $color;
	    	            	}
	    	            }elseif ( !C5_simple_option ) {
	    	            	$skin = get_option('c5_term_meta_' . $tax . '_' . $term->term_id . '_skin');
	    	            	$skin_obj = new C5_skin_functions();
	    		            if ($skin_obj->skin_exist($skin)) {
	    		                $color = $skin_obj->get_color_from_skin($skin);
	    						$options['color']= $color;
	    		            }
	    	            }
	    	            
	    	            if(count($options) > 0){
	    	            	$c5_terms_array[ $tax . '-' . $term->term_id ] = $options;
	    	        	}
	    	        }	
	    	    }
	    	}
	    	update_option( 'c5_terms_settings', $c5_terms_array );
	    	return $c5_terms_array;
	    }
	    
	    
	    function terms_custom_css($terms) {
			$data = '';
		    foreach ($terms as $class => $options) {
		        if(!isset( $options['color'] )){
		        	continue;
		        }
                $color = $options['color'];
                $data .= $this->categories_css($color, '.' .$class);
		           
		    }
		    return $data;
		}
			
	    
	    
	    function categories_css($color = '', $class_name) {
	    	$obj_style = new C5AB_STYLE();
	    	
	    	$rgb_color =  $obj_style->hex2rgb($color);
	    	$dark_color = $obj_style->hexDarker($color);
            
            $data ='
            .c5ab_posts_thumb_boxes_single'. $class_name .':hover .box-content,
            .flip-post'. $class_name .' .post-data-bg,
            .c5-main-header-wrap a.c5-meta-cat'. $class_name .',
            .c5ab_posts_thumb_blog_1_single  a.c5-meta-cat'. $class_name .'{
                background-color: '. $color .';
            }
			
			h3.title'. $class_name .',
            h2.title'. $class_name .'{
                color: '. $color .';
            }
            
           
            
            .c5ab_post_thumb'. $class_name .' .hover,
            .c5ab_posts_thumb_boxes_single'. $class_name .' .box-content{
                background-color: '. $color .';
                background-color: rgba('. $rgb_color[0] .' , '. $rgb_color[1] .' , '. $rgb_color[2] .', 0.8);
            }
           ';
            
            return $data;
	    }
	
}

function c5_get_category_icon($class) {
	global $c5_terms_array ;
	
	if(isset($c5_terms_array[$class])){
		if (isset(  $c5_terms_array[$class]['icon'] )) {
			return $c5_terms_array[$class]['icon'];
		}
	}
	return false;
}
function c5_get_category_color($class) {
	global $c5_terms_array ;
	
	if(isset($c5_terms_array[$class])){
		if (isset(  $c5_terms_array[$class]['color'] )) {
			return $c5_terms_array[$class]['color'];
		}
	}
	return false;
}

 ?>