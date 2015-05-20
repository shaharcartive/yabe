<?php 


add_action( 'wp_ajax_c5_install_widgets', 'c5_install_widgets' );

function c5_install_widgets() {
	
	
	require_once C5_ROOT . 'library/includes/auto-import/auto-widgets-import.php';
	$widgets_file =  get_template_directory_uri() . '/library/includes/auto-import/widget_data.json';
	
	$data = new Auto_Widget_IMPORT($widgets_file);
	echo 'done';
	die();
}

add_action( 'wp_ajax_c5_upgrade_theme', 'c5_upgrade_theme' );

function c5_upgrade_theme() {
	update_option('c5_options_mode', 'advanced');
	die();
}




add_action( 'wp_ajax_c5_install_theme_options', 'c5_install_theme_options' );

function c5_install_theme_options() {
	
	$simple_option = get_option('c5_options_mode');
	
	if($simple_option == 'advanced'){
		$data_file = get_template_directory_uri() . '/library/includes/auto-import/options.txt';
		
	}else {
		$data_file = get_template_directory_uri() . '/library/includes/auto-import/options-simple.txt';
	}
	
	$get_data = wp_remote_get( $data_file );
	
	if ( is_wp_error( $get_data ) )
	  return false;
	  
	$rawdata = isset( $get_data['body'] ) ? $get_data['body'] : '';
	$options = unserialize( ot_decode( $rawdata ) );
	
	/* get settings array */
	$settings = get_option( 'option_tree_settings' );
	
	/* has options */
	if ( is_array( $options ) ) {
	  
	  /* validate options */
	  if ( is_array( $settings ) ) {
	  
	    foreach( $settings['settings'] as $setting ) {
	    
	      if ( isset( $options[$setting['id']] ) ) {
	        
	        $content = ot_stripslashes( $options[$setting['id']] );
	        
	        $options[$setting['id']] = ot_validate_setting( $content, $setting['type'], $setting['id'] );
	        
	      }
	    
	    }
	  
	  }
	  
	  $demo_url = 'code-125.com';
	  
	  
	  foreach ($options as $key => $value) {
	  	if(is_array($value)){
	  		continue;
	  	}
	  	$test_value = explode( $demo_url, $value);
	  	if(count($test_value) == 2){
	  		$info = explode('/', $value);
	  		$index = count($info) - 1;
	  		$new_value =  c5ab_get_attachment_id_from_filename($info[$index]);
	  		if($new_value !=''){
	  			$options[$key] = $new_value;
	  		}
	  	}
	  }
	  
	  
	  update_option( 'option_tree' , $options);
	  
	  
	}
	
	
	die();
}

 function c5ab_get_attachment_id_from_filename ($name) {
 	global $wpdb;
 	
 	$query = "SELECT guid FROM {$wpdb->posts} WHERE guid LIKE '%{$name}%'";
 	$id = $wpdb->get_var($query);
 		
 	return $id;
 }
 
 function c5_load_more_posts() {
 	$args = unserialize(base64_decode($_POST['args']));
 	$args['paged'] = $_POST['page'];
 	$args['post_status'] = 'publish';
 	
 	$atts = unserialize(base64_decode($_POST['atts']));
 	
 	$device = new C5AB_Mobile_Detect();
 	
 	$GLOBALS['c5_content_width'] = $_POST['content_width'];
 	
 	$post_obj = new C5_post();
 	// The Query
 	$the_query = new WP_Query( $args );
 	global $c5_skindata;
 	$c5_skindata = array();
 	$c5_skindata['primary_color'] = $_POST['primary_color'];
 	$text = '';
 	$return = '';
// 	print_r($atts);
 	// The Loop
 	if ( $the_query->have_posts() ) {
 	       
 		while ( $the_query->have_posts() ) {
 			$the_query->the_post();
 			switch ($atts['render_type'] ) {
 				case 'slider':
 					$return .= $post_obj->get_post_slide($atts);
 					break;
 				case 'blog-thumb';
 					$return .= $post_obj->get_post_thumb($atts);	
 					break;
 				case 'grid-1';
 					$current_count = $the_query->current_post;
 					if ($GLOBALS['c5_content_width'] < 400) {
 						$col_count= 1;
 					}elseif ($GLOBALS['c5_content_width'] < 800) {
 						$col_count= 2;
 					}else {
 						$col_count= 3;
 					}
 					
 					$return .= $post_obj->get_grid_1_item($atts, $col_count, $current_count);
 					break;
 				case 'grid-2';
 					if ($GLOBALS['c5_content_width'] < 400) {
 						$col_count= 1;
 					}elseif ($GLOBALS['c5_content_width'] < 800) {
 						$col_count= 2;
 					}else {
 						$col_count= 3;
 					}
 					$current_count = $the_query->current_post;
 					$return .= $post_obj->get_grid_2_item($atts, $col_count, $current_count);
 					break;
 				case 'grid-3';
 					if ($GLOBALS['c5_content_width'] < 400) {
 						$col_count= 1;
 					}elseif ($GLOBALS['c5_content_width'] < 800) {
 						$col_count= 2;
 					}else {
 						$col_count= 3;
 					}
 					$current_count = $the_query->current_post;
 					$return .= $post_obj->get_grid_3_item($atts, $col_count, $current_count);
 					break;
 				case 'blog-1';
 					$return .=  $post_obj->get_post_blog_1($atts );
 					break;
 				case  'blog-2':
 					$return .= $post_obj->get_post_blog_2($atts) ;
 					break;
 			}
 			
 		}
 			
 	        
 	        
 	       
 	        
 	}
 	
 	/* Restore original Post Data */
 	wp_reset_postdata();
 	
 	
 	echo $return;
 	
 	die();
 }
 
 add_action( 'wp_ajax_c5_load_more_posts', 'c5_load_more_posts' );
 add_action( 'wp_ajax_nopriv_c5_load_more_posts', 'c5_load_more_posts' );

 ?>