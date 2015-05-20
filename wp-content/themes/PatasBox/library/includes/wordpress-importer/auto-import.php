<?php 
add_action('admin_init','c5_theme_activation_redirection');

function c5_theme_activation_redirection() {
	global $pagenow;
	 if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' )
	 {
	      wp_redirect( admin_url( 'tools.php?page=c5-demo-import&activated=true' ) );
	      exit;
	 }
}

add_action( 'wp_ajax_c5_install_demo', 'c5_install_demo' );
function c5_install_demo() 
{
    global $wpdb; 

    if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);

    // Load Importer API
    require_once ABSPATH . 'wp-admin/includes/import.php';

    if ( ! class_exists( 'WP_Importer' ) ) {
        $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
        if ( file_exists( $class_wp_importer ) )
        {
            require $class_wp_importer;
        }
    }

    if ( ! class_exists( 'WP_Import' ) ) {
        $class_wp_importer = get_template_directory() ."/library/includes/wordpress-importer/wordpress-importer.php";
        if ( file_exists( $class_wp_importer ) )
            require $class_wp_importer;
    }
	
	$type = $_POST['type'];
	$id = $_POST['id'];
	
	
	$obj = new C5_theme_activation();
	
	$all_objects = $obj->all_demos();
	
	$info = $all_objects[$id];
	
	
	if ($type == 'demo' || $type == 'options') {
		$obj->import_theme_options($info['theme-options']);
		
		c5_register_sidebars();
	}
	
	
	if ($type == 'demo' || $type == 'widget') {
		$temp_obj = new Auto_Widget_IMPORT($info['widgets']);
	}
	
    if ( class_exists( 'WP_Import' ) && $type =='demo' ) 
    { 
        $import_filepath = $info['xml'];
        $wp_import = new WP_Import();
        $wp_import->fetch_attachments = true;
        $wp_import->import($import_filepath);
        
        $options_file = get_template_directory_uri() . '/library/includes/wordpress-importer/wp-options.txt';
        $obj->import_wp_options($options_file);
        
        $nav_menu_locations = array(
		    'main-nav' => 'Main Menu',
		);
		
		set_theme_mod( 'nav_menu_locations' , $nav_menu_locations );
		
		$home = get_page_by_title( $info['homepage'] );
		update_option('page_on_front' ,$home->ID  );
		update_option('show_on_front' , 'page' );
		
		
		$demo_url = 'code-125.com';
		
		/*
		$query = new WP_Query( array( 'post_type' => 'header', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC', 'post_status' => 'publish' ) );
		
		
		if ( $query->have_posts() ) {
		  while ( $query->have_posts() ) {
		    $query->the_post();
		    $meta_value = get_post_custom();
		    foreach ($meta_value as $key => $value) {
		    	
	    		$test_value = explode( $demo_url, $value);
	    		if(count($test_value) == 2){
	    			$info = explode('/', $value);
	    			$index = count($info) - 1;
	    			$new_value =  $this->get_attachment_id_from_filename($info[$index]);
	    			if($new_value !=''){
	    				update_post_meta(get_the_ID() , $key, $new_value);
	    			}
	    		}
		    	
		    }
		} 
		}
		wp_reset_postdata();
		*/
		
		$old_settings = get_option( 'option_tree');
		
		$old_settings['preview'] = 'off';
		
		foreach ($old_settings as $key => $value) {
			if(is_array($value)){
				continue;
			}
			$test_value = explode( $demo_url, $value);
			if(count($test_value) == 2){
				$info = explode('/', $value);
				$index = count($info) - 1;
				$new_value =  $obj->get_attachment_id_from_filename($info[$index]);
				if($new_value !=''){
					$old_settings[$key] = $new_value;
				}
			}
			
		}
		
		
		update_option( 'option_tree' , $old_settings);


    }
        die(); // this is required to return a proper result
}

 ?>