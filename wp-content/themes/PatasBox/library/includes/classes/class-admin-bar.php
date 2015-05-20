<?php 

class C5_admin_bar {

	function __construct() {
		add_action( 'admin_bar_menu', array($this, 'admin_bar'), 1000 );
	}
	
	function admin_bar() {
	    global $wp_admin_bar, $wpdb;
	    if ( !is_admin_bar_showing()  )
	        return;
	        
	        
	     global $post;
	     global $c5_skinid;
	     global $c5_skindata;
	     $c5_skin_id = $c5_skinid;
	     
	     $c5_header_id  = '';
	     if(isset($c5_skindata['header_default'])){
	     	$c5_header_id  = $c5_skindata['header_default'];
	     }
	     
	     $c5_footer_id = '';
	     if(isset($c5_skindata['footer_default'])){
	     	$c5_footer_id  = $c5_skindata['footer_default'];
	     }
	     
	     	$wp_admin_bar->add_menu( array( 'id' => 'c5_parent', 'title' => 'PatasBox Opciones', 'href' => home_url() . '/wp-admin/themes.php?page=ot-theme-options' ) );
	     	
	     	if( is_admin() && current_user_can('manage_options') ){
	     		$wp_admin_bar->add_menu( array( 'parent'=>'top-secondary', 'id' => 'c5_install_demo', 'class' =>  'c5-install-demo', 'title' => 'Install Demo Content', 'href' => admin_url( 'tools.php?page=c5-demo-import' ) ) );
	     	}
	     	if($c5_skin_id !=''){
	     		$wp_admin_bar->add_node( array( 'parent' => 'c5_parent','id' => 'skin_edit', 'title' => __( 'Edit Skin', 'code125-admin' ), 'href' => home_url() . '/wp-admin/post.php?post=' . $c5_skin_id .'&action=edit' ) );
	     	}
	     	if($c5_header_id !=''){
	     		$wp_admin_bar->add_node( array( 'parent' => 'c5_parent','id' => 'header_edit', 'title' => __( 'Edit Header', 'code125-admin' ), 'href' => home_url() . '/wp-admin/post.php?post=' . $c5_header_id.'&action=edit' ) );
	     	}
	     	
	     	if($c5_footer_id !='' && $c5_footer_id!='footer-1'){
	     		$wp_admin_bar->add_node( array( 'parent' => 'c5_parent','id' => 'footer_edit', 'title' => __( 'Edit Footer', 'code125-admin' ), 'href' => home_url() . '/wp-admin/post.php?post=' . $c5_footer_id.'&action=edit' ) );
	     	}
	     	if(!is_admin()){
	     		$wp_admin_bar->add_node( array( 'parent' => 'c5_parent','id' => 'c5_refresh_categories', 'title' => __( 'Refresh Cached Categories Info', 'code125-admin' ), 'href' => get_permalink() . '?update=categories' ) );
	     	}
	     
	    /* Add the main siteadmin menu item */
	    $wp_admin_bar->add_node( array( 'parent' => 'c5_parent','id' => 'crystal_options', 'title' =>  'Opciones del Template' , 'href' => admin_url() . 'themes.php?page=ot-theme-options' ) );
	    
	    
//	    if( is_admin() && current_user_can('manage_options') ){
//	    	$string = 'Simple';
//	    	if(C5_simple_option){
//	    		$string = 'Advanced';
//	    	}
//	    	
//	    	$wp_admin_bar->add_node( array( 'parent' => 'c5_parent','id' => 'c5_switch_mode', 'title' => 'Switch to ' . $string . ' Mode' ,'href' => admin_url() . 'about.php?c5_flip=true') );
//	    	
//	    
//	    }
	   
	    if( is_admin() ){
		    $wp_admin_bar->add_menu( array('parent'=>'top-secondary', 'id' => 'c5_video_tutorials', 'title' => 'Video Tutorials' ) );
		    
		    $array = array(
		    	'FPoO527BBNk'=>'Awersome Builder - Page Builder',
		    	'Qwt-Vi2gpto'=>'One Click Install',
		    	'3DpU-koo4po'=>'Quick Setup Wizard',
		    	'OMKP5V79diQ'=>'Homepage Slider',
		    	'dRenmF25qGA'=>'Enable Mega Menu',
		    	'JjlOvQc7z9A'=>'Creating Footer',
		    	'xhHYRi9fIn4'=>'Dealing with Categories',
		    	'dCA_9DwatkQ'=>'Custom Fonts ',
		    	'IZnyrlZfI-8'=>'Setting default blog',
		    	'IvuAV53Dd8k'=>'Using Pre-loaded templates',
		    	'H9U8Lxn7FOU'=>'Create and assign Homepage',
		    	'C0X3pjTO4B0'=>'Turning Animation Off',
		    	
		    );
		    
		    foreach ($array as $key => $title) {
		    	/* Add the main siteadmin menu item */
		    	$wp_admin_bar->add_node( 
		    		array( 
		    			'parent' => 'c5_video_tutorials',
		    			'id' => str_replace(' ', '_',  strtolower($title) ), 
		    			'title' =>  $title , 
		    			'meta' =>array(
		    				'class' => 'c5-video-tutorial c5video#'.$key.'  '
		    			)
		    		) 
		    	);
		    }
	    }
	    
	    
	    
	}
	
	
}

 ?>