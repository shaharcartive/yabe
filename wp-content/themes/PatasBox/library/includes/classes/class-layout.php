<?php

class C5_theme_layout extends C5_theme_option_elements {

    function __construct() {
        
    }

    function skin_exist($id) {
        if ($id == '') {
            return false;
        }
        $found = false;
        $skin_query = new WP_Query( 'p=' . $id . '&post_type=skin' );
        
        // The Loop
        if ( $skin_query->have_posts() ) {
        	$found = true;
        }
       // wp_reset_postdata();
        return $found;
    }
    
    
    function get_color_from_skin($skin_id) {
    	return get_post_meta($skin_id, 'primary_color', true);
    }
	
	
	
    function get_current_skin_id() {
		
		if(class_exists( 'WooCommerce' )){
			if(is_woocommerce() || is_checkout() || is_cart() ){
				
				$page_id = c5_wc_get_current_page();
				if($page_id){
					$value = get_post_meta($page_id, 'skin_default', true);
					if ($this->skin_exist($value)) {
					    return $value;
					}
				}
				
				$value = ot_get_option('skin_default_shop');
				if ($this->skin_exist($value)) {
				    return $value;
				}
			}
			
		}
		
		
		if (is_category() || is_tax()) {
            $obj = get_queried_object();
            $term_id = $obj->term_id;
            $tax = $obj->taxonomy;
            
            $value = get_option('c5_term_meta_' . $tax . '_' . $term_id . '_' . 'skin');
            if ($this->skin_exist($value)) {
                return $value;
            }
            
            $tax_terms = get_taxonomy($tax );
            $post_type = $tax_terms->object_type[0];
            $post_type_id = $this->get_cpt( $post_type);
            if($post_type_id){
            	$value = get_post_meta($post_type_id, 'category_skin' , true) ;
            	if ($this->skin_exist($value)) {
            	    return $value;
            	}
            }
            
            $value = ot_get_option('skin_default_category');
            if ($this->skin_exist($value)) {
                return $value;
            }
        } elseif (is_tag()) {
            $obj = get_queried_object();
            $term_id = $obj->term_id;
            $tax = $obj->taxonomy;

            $value = get_option('c5_term_meta_' . $tax . '_' . $term_id . '_' . 'skin');
            if ($this->skin_exist($value)) {
                return $value;
            }
            $value = ot_get_option('skin_default_tag');
            if ($this->skin_exist($value)) {
                return $value;
            }
        } elseif (is_single()) {
            global $post;
            $value = get_post_meta($post->ID, 'posts_skin', true);
            if ($this->skin_exist($value)) {
                return $value;
            }

            $type = get_post_type($post->ID);
            $use_parent = 'off';
           
            if ($type == 'post') {
                $use_parent = ot_get_option('posts_styling');
            } else {
            	$post_type_id = $this->get_cpt(get_post_type($post->ID));
            	if($post_type_id){
            		$use_parent = get_post_meta($post_type_id, 'posts_styling' , true) ;
            	}
            }
            if ($use_parent == 'on') {
                $tax = c5_get_post_tax($post->ID);
                $category_follow = get_post_meta($post->ID, 'category_follow', true);
                if ($category_follow != '') {
                    $value = get_option('c5_term_meta_' . $tax . '_' . $category_follow . '_' . 'article_skin');
                    if ($this->skin_exist($value)) {
                        return $value;
                    }
                }
                $terms = wp_get_post_terms($post->ID, $tax);
                if (count($terms) != 0) {
                    foreach ($terms as $term) {
                        $value = get_option('c5_term_meta_' . $tax . '_' . $term->term_id . '_' . 'skin');
                        if ($this->skin_exist($value)) {
                            return $value;
                        }
                    }
                }
            }
            if($type == 'product'){
            	$value = ot_get_option('skin_default_shop');
            	if ($this->skin_exist($value)) {
            	    return $value;
            	}
            }elseif ($type != 'post') {
                $post_type_id = $this->get_cpt(get_post_type($post->ID));
                if($post_type_id){
                	$value = get_post_meta($post_type_id, 'skin_default' , true) ;
                	if ($this->skin_exist($value)) {
                	    return $value;
                	}
                }
            }

            $value = ot_get_option('article_skin');
            if ($this->skin_exist($value)) {
                return $value;
            }
        } elseif (is_search()) {
            $value = ot_get_option('skin_default_search');
            if ($this->skin_exist($value)) {
                return $value;
            }
        } elseif (is_author()) {
            $obj = get_queried_object();

            $value = get_the_author_meta('c5_term_meta_user_skin', $obj->ID);
            if ($this->skin_exist($value)) {
                return $value;
            }

            $value = ot_get_option('skin_default_author');
            if ($this->skin_exist($value)) {
                return $value;
            }
        } elseif (is_404()) {
            $value = ot_get_option('skin_default_404');
            if ($this->skin_exist($value)) {
                return $value;
            }
        } elseif (is_page()) {
            global $post;

            $value = get_post_meta($post->ID, 'skin_default', true);
            if ($this->skin_exist($value)) {
                return $value;
            }

            $value = ot_get_option('skin_default_page');
            if ($this->skin_exist($value)) {
                return $value;
            }
        } elseif (is_archive()) {
            $value = ot_get_option('skin_default_archive');
            if ($this->skin_exist($value)) {
                return $value;
            }
        }


        $value = ot_get_option('skin_default');

        return $value;
    }
    
    function template_exist($id) {
    	if($id != ''){
    		return true;
    	}
    	return false;
    }
    
    function get_current_template_id() {
    
    		if (is_category() || is_tax()) {
                $obj = get_queried_object();
                $term_id = $obj->term_id;
                $tax = $obj->taxonomy;
    
                $value = get_option('c5_term_meta_' . $tax . '_' . $term_id . '_' . 'template');
                if ($this->template_exist($value)) {
                    return $value;
                }
                
                $tax_terms = get_taxonomy($tax );
                $post_type = $tax_terms->object_type[0];
                $post_type_id = $this->get_cpt( $post_type);
                if($post_type_id){
                	$value = get_post_meta($post_type_id, 'category_template' , true) ;
                	if ($this->skin_exist($value)) {
                	    return $value;
                	}
                }
                
                $value = ot_get_option('cat_template');
                if ($this->template_exist($value)) {
                    return $value;
                }
            } elseif (is_tag()) {
                $obj = get_queried_object();
                $term_id = $obj->term_id;
                $tax = $obj->taxonomy;
    
                $value = get_option('c5_term_meta_' . $tax . '_' . $term_id . '_' . 'template');
                if ($this->template_exist($value)) {
                    return $value;
                }
                $value = ot_get_option('tag_template');
                if ($this->template_exist($value)) {
                    return $value;
                }
            
            } elseif (is_search()) {
                $value = ot_get_option('search_template');
                if ($this->template_exist($value)) {
                    return $value;
                }
            } elseif (is_author()) {
                $obj = get_queried_object();
    
                $value = get_the_author_meta('c5_term_meta_user_template', $obj->ID);
                if ($this->template_exist($value)) {
                    return $value;
                }
    
                $value = ot_get_option('author_template');
                if ($this->template_exist($value)) {
                    return $value;
                }
            } elseif (is_404()) {
                $value = ot_get_option('404_template');
                if ($this->template_exist($value)) {
                    return $value;
                }
            } elseif (is_archive()) {
                $value = ot_get_option('archive_template');
                if ($this->template_exist($value)) {
                    return $value;
                }
            }
    
    
            $value = ot_get_option('default_template');
    
            return $value;
        }
    function get_update_value($post_id,$option) {
    	if (is_category() || is_tax() || is_tag()) {
			$obj = get_queried_object();
	        $term_id = $obj->term_id;
	        $tax = $obj->taxonomy;
	
	        $value = get_option('c5_term_meta_' . $tax . '_' . $term_id . '_' . $option);
		}elseif (is_author()) {
			$obj = get_queried_object();
			
	        $value = get_the_author_meta('c5_term_meta_user_'.$option, $obj->ID);
		}else {
			$value = get_post_meta($post_id, $option, true);
		}
		return esc_attr($value);
    }    
    function update_color_values($post_id = '') {
    	global $c5_skindata;
    	foreach ($this->get_colors_options() as $option) {
    		if($option['type'] == 'background'){
    			$value = $this->get_update_value($post_id, $option['id']);
    			if(is_array($value)){
    				if( 
    				$value['background-color'] != '' ||
    				$value['background-repeat'] != '' ||
    				$value['background-attachment'] != '' ||
    				$value['background-position'] != '' ||
    				$value['background-size'] != '' ||
    				$value['background-image'] != ''     				
    				){
    					$c5_skindata[ $option['id'] ] = $value;
    				}
    			}
    		}else {
    			$c5_skindata[ $option['id'] ] = $this->get_update_value($post_id, $option['id']);
    		}	
    	}
    } 
    
    function update_layout_values($post_id = '') {
    	global $c5_skindata;
    	foreach ($this->get_layout_options() as $option) {
    		$c5_skindata[ $option['id'] ] = esc_attr( $this->get_update_value($post_id, $option['id']) );
    		
    				
    	}
    	
    	
    }    
        
	function get_updated_skin_data() {
		global $c5_skindata;
		
		if(class_exists( 'WooCommerce' )){
			if(is_woocommerce() || is_checkout() || is_cart() ){
				
				$page_id = c5_wc_get_current_page();
				$c5_skindata['big_sidebar'] = 'shop_sidebar';
				if($page_id){
					$use_custom_colors = get_post_meta($page_id, 'use_custom_colors', true);
					if ($use_custom_colors == 'on') {
					    $this->update_color_values($page_id);
					}
					$use_custom_layout = get_post_meta($page_id, 'use_custom_layout', true);
					if ($use_custom_layout == 'on') {
					    $this->update_layout_values($page_id);
					}
				}
			}
			
		}
		
		
		if (is_category() || is_tax() || is_tag()) {
            $obj = get_queried_object();
            $term_id = $obj->term_id;
            $tax = $obj->taxonomy;

            $use_custom_colors = get_option('c5_term_meta_' . $tax . '_' . $term_id . '_' . 'use_custom_colors');
            if ($use_custom_colors == 'on') {
                $this->update_color_values();
            }
            $use_custom_layout = get_option('c5_term_meta_' . $tax . '_' . $term_id . '_' . 'use_custom_layout');
            if ($use_custom_layout == 'on') {
                $this->update_layout_values();
            }
            
            
        } elseif (is_single() || is_page()  ) {
            if (is_single()) {
            	$c5_skindata['big_sidebar']  = ot_get_option('article_sidebar');
            	$article_page  = ot_get_option('article_width');
            	if ($article_page!='') {
            		$c5_skindata['page_width']  = $article_page;
            	}
            	if(class_exists( 'WooCommerce' )){
            		if (is_woocommerce()) {
            			$c5_skindata['big_sidebar'] = 'shop_sidebar';	
            		}
            	}	
            		
            			
            	
            }
            global $post;
            $page_id = $post->ID;
            $use_custom_colors = get_post_meta($page_id, 'use_custom_colors', true);
            if ($use_custom_colors == 'on') {
                $this->update_color_values($page_id);
            }
            $use_custom_layout = get_post_meta($page_id, 'use_custom_layout', true);
            if ($use_custom_layout == 'on') {
                $this->update_layout_values($page_id);
            }
            
        } elseif (is_author()) {
            $obj = get_queried_object();

            $use_custom_colors = get_the_author_meta('c5_term_meta_user_'.'use_custom_colors', $obj->ID);
            
            if ($use_custom_colors == 'on') {
                $this->update_color_values();
            }
            
            $use_custom_layout = get_the_author_meta('c5_term_meta_user_'.'use_custom_layout', $obj->ID);
            if ($use_custom_layout == 'on') {
                $this->update_layout_values();
            }
        } 
		
	}
    function get_current_skin() {

        global $c5_skindata;
        global $c5_skinid;
		
		$c5_skindata_defaults = get_option('c5_skin_defaults');
		if( !is_array($c5_skindata_defaults) ){
			$obj = new C5_skin();
			$obj->meta_box();
			$c5_skindata_defaults = get_option('c5_skin_defaults');
		}
		if(C5_simple_option){
			$c5_skindata = array();
			
			foreach ($c5_skindata_defaults as $name => $value) {
				$option = ot_get_option($name);
			    if ( $option != '') {
			       $c5_skindata[$name] = $option;
			    } else {
			        $c5_skindata[$name] = $value[1];
			    }
			}		
		}else{
	        $skin_id = $this->get_current_skin_id();
	        $c5_skinid = $skin_id;
	        if (!is_array($c5_skindata_defaults)) {
	            $skin_obj = new C5_skin();
	            $c5_skindata_defaults = get_option('c5_skin_defaults');
	        }
	        if ($skin_id != '') {
	            $meta_values = get_post_custom($skin_id);
	            $c5_skindata = array();
	            foreach ($c5_skindata_defaults as $name => $value) {
	                if (isset($meta_values[$name][0]) && $meta_values[$name][0] != '') {
	                    if ($value[0] == 'background') {
	                        $c5_skindata[$name] = unserialize($meta_values[$name][0]);
	                    } else {
	                        $c5_skindata[$name] = esc_attr($meta_values[$name][0]);
	                    }
	                } else {
	                    $c5_skindata[$name] = $value[1];
	                }
	            }
	        } else {
	            foreach ($c5_skindata_defaults as $name => $value) {
	                $c5_skindata[$name] = $value[1];
	            }
	        }
	
	
        }
		
        $this->get_updated_skin_data();
        
        $this->get_current_header($c5_skindata['header_default']);
        $this->get_current_footer($c5_skindata['footer_default']);
		
		if(isset($_POST['c5-preview-color']) && $_POST['c5-preview-color']!=''){
			$c5_skindata['primary_color'] = esc_attr($_POST['c5-preview-color']);
			$c5_skindata['title_color'] = esc_attr($_POST['c5-preview-color']);
		}
		
		if(isset($_POST['c5-layout-mode']) && $_POST['c5-layout-mode']!=''){
			$c5_skindata['layout_width']  = esc_attr($_POST['c5-layout-mode']);
		}
		
		if(isset($_POST['c5-menu-mode']) && $_POST['c5-menu-mode']!=''){
			$c5_headerdata['header_menu_position'] = esc_attr($_POST['c5-menu-mode']);
		}
		
		
		
        
        
        $template_id = $this->get_current_template_id();
        
        $c5_skindata['template_id'] = $template_id;

        $GLOBALS['c5-main-width'] = c5_get_page_width();
        c5_check_mobile_width();
    }

    function get_current_header($header_id) {
        global $c5_headerdata;
        $c5_headerdata_defaults = get_option('c5_header_defaults');
        
        if( !is_array($c5_headerdata_defaults) ){
        	$obj = new C5_header();
        	$obj->meta_box();
        	$c5_headerdata_defaults = get_option('c5_header_defaults');
        }
        
        if(C5_simple_option){
        	$c5_headerdata = array();
        	foreach ($c5_headerdata_defaults as $name => $value) {
        		$option = ot_get_option($name);
        	    if ( $option != '') {
        	       $c5_headerdata[$name] = $option;
        	    } else {
        	        $c5_headerdata[$name] = $value[1];
        	    }
        	}
        }else{
	        if (!is_array($c5_headerdata_defaults)) {
	            $skin_obj = new C5_header();
	            $c5_headerdata_defaults = get_option('c5_header_defaults');
	        }
	        if ($header_id != '') {
	            $meta_values = get_post_custom($header_id);
	            $c5_headerdata = array();
	
	            foreach ($c5_headerdata_defaults as $name => $value) {
	                if (isset($meta_values[$name][0]) && $meta_values[$name][0] != '') {
	                    if ($value[0] == 'background') {
	                        $c5_headerdata[$name] = unserialize($meta_values[$name][0]);
	                    } else {
	                        $c5_headerdata[$name] = esc_attr($meta_values[$name][0]);
	                    }
	                } else {
	                    $c5_headerdata[$name] = $value[1];
	                }
	            }
	        } else {
	            foreach ($c5_headerdata_defaults as $name => $value) {
	                $c5_headerdata[$name] = $value[1];
	            }
	        }
        }
    }
    
    function get_cpt($slug) {
    	$args = array(
    		'post_type' => 'cpt',
    		'meta_value' => $slug
    	);
    	$id = false;
    	$the_query = new WP_Query( $args );
    	// The Loop
    	if ( $the_query->have_posts() ) {
    		while ( $the_query->have_posts() ) {
    			$the_query->the_post();
    			$id = get_the_ID();
    		}
    	}
    	wp_reset_postdata();
    	return $id;
    }

    function get_current_footer($footer_id) {
        global $c5_footerdata;
        $c5_footer_defaults = get_option('c5_footer_defaults');
        
        if( !is_array($c5_footer_defaults) ){
        	$obj = new C5_footer();
        	$obj->meta_box();
        	$c5_footer_defaults = get_option('c5_footer_defaults');
        }
        
        if(C5_simple_option){
        	$c5_footerdata = array();
        	foreach ($c5_footer_defaults as $name => $value) {
        		$option = ot_get_option($name);
        	    if ( $option != '') {
        	       $c5_footerdata[$name] = $option;
        	    } else {
        	        $c5_footerdata[$name] = $value[1];
        	    }
        	}
        }else{
	        if (!is_array($c5_footer_defaults)) {
	            $skin_obj = new C5_footer();
	            $c5_footer_defaults = get_option('c5_footer_defaults');
	        }
	
	        if ($footer_id != '') {
	            $meta_values = get_post_custom($footer_id);
	            $c5_footerdata = array();
	
	            foreach ($c5_footer_defaults as $name => $value) {
	                if (isset($meta_values[$name][0]) && $meta_values[$name][0] != '') {
	                    if ($value[0] == 'background') {
	                        $c5_footerdata[$name] = unserialize($meta_values[$name][0]);
	                    } else {
	                        $c5_footerdata[$name] = esc_attr($meta_values[$name][0]);
	                    }
	                } else {
	                    $c5_footerdata[$name] = $value[1];
	                }
	            }
	        } else {
	            foreach ($c5_footer_defaults as $name => $value) {
	                $c5_footerdata[$name] = $value[1];
	            }
	        }
	     }
    }

    function build_layout($source) {
        global $c5_skindata;
        global $c5_headerdata;
        ?>
        
            <div id="inner-content" class=" clearfix">
            	<?php 
            	$class = 'c5-sidebar-hidden';
            	switch ($c5_skindata['page_width']) {
            		case 'left':
            			$GLOBALS['c5_content_width'] = 740;
            			$class = 'c5-sidebar-active';
            			break;
            		case 'right':
            			$GLOBALS['c5_content_width'] = 740;
            			$class = 'c5-sidebar-active';
            			break;
            		case 'full':
            			$GLOBALS['c5_content_width'] = 1070;
            			break;
            		default:
            			$GLOBALS['c5_content_width'] = 740;
            			break;
            	}
				c5_check_mobile_width(); 
            	echo '<div class="c5-main-width-wrap c5-main-page-wrap-sidebar '.$class.' c5-page-'.$c5_skindata['page_width'].' clearfix"><div class="row"><div class="c5-middle-control clearfix">';
            	if ($c5_skindata['page_width'] == 'left' || $c5_skindata['page_width'] == 'left_hidden') {
            		$this->get_sidebar($c5_skindata['big_sidebar']);
            		$this->get_main_content($source);
            		
            		
            		
            	}elseif ($c5_skindata['page_width'] == 'right' || $c5_skindata['page_width'] == 'right_hidden') {
            		
            		$this->get_main_content($source);
            		$this->get_sidebar($c5_skindata['big_sidebar']);
            	}else {
            		$this->get_main_content($source);
            	}
            	echo '</div></div></div>';
            	
    }			
    
    function get_sidebar($sidebar) {
    	$test = $GLOBALS['c5_content_width'];
    	$GLOBALS['c5_content_width'] = 300;
    	?>
    	<div id="sidebar-<?php echo $sidebar ?>" class="c5-single-content c5-sidebar-wrap clearfix">
    	<?php
    	if ( is_active_sidebar( $sidebar ) ){
    		dynamic_sidebar( $sidebar );
    	}
    	?>
    	</div>
    	<?php
    	$GLOBALS['c5_content_width'] = $test;
    }
    
    function get_main_content($source) {
    	echo '<div class="c5-main-content-area c5-single-content clearfix">';
    	switch ($source) {
			case 'home':
				get_template_part( 'library/includes/templates/template-index');
				break;
			case 'page':
				get_template_part( 'library/includes/templates/template-page');
				break;
			case 'woocommerce':
				get_template_part( 'library/includes/templates/template-woocommerce');
				break;
			case 'single':
				get_template_part( 'library/includes/templates/template-single');
				break;
			case '404':
				get_template_part( 'library/includes/templates/template-404');
				break;
		
		}
		echo '</div>';
    	
    }
    
}
?>