<?php 

class C5_skin_base extends C5_theme_option_elements {
	
	public $slug = 'skin';
	public $name = 'Skin';
	public $image = 'skin';
	public $supports = array();
	
	function __construct() {
		
	}
	
	function _hook() {
		$this->slug = 'skin';
		$this->name = 'Skin';
		$this->image = 'skin';
		
		$this->supports = array( 'title' );
		
		$this->hook();
	}
	
	
	function hook() {
		add_action( 'init',  array($this, 'register_custom_posttype'));
		add_action('admin_init', array($this, 'meta_box'));
		
		
		
	}
	
	
	function single_hook() {
		add_action('admin_init', array($this, 'init_duplicate'));
		
		// Add it to a column in WP-Admin
		add_filter('manage_posts_columns', array($this, 'duplicate_title'));
		add_action('manage_posts_custom_column', array($this, 'duplicate_data'),5,2);
	}
	function meta_box() {
		
	}
	
	
	
	function duplicate_title($defaults){
		
	    $defaults['duplicate'] = 'Duplicate';
	    return $defaults;
	}
	function duplicate_data($column_name, $id){
		$post_type = get_post_type(get_the_ID());
		if($column_name === 'duplicate' && ( $post_type =='skin' || $post_type == 'header' || $post_type == 'footer'  )){
	   
	        echo '<a href="?post_type='.$post_type.'&c5_duplicate=true&c5_id='.get_the_ID().'">Duplicate</a>';
	    }
	}
	
	function init_duplicate() {
		if(isset($_GET['c5_duplicate'])){
			
			$post_type = get_post_type($_GET['c5_id']);
			$meta_values = get_post_custom($_GET['c5_id']);
			$defaults = array( 
			  'post_status' => 'publish',
			  'post_type'   => $post_type,
			  'post_title'    => get_the_title($_GET['c5_id']) . ' Copy',
			);
			//print_r($meta_values);
			$post_id = wp_insert_post( $defaults );
			foreach ($meta_values as $key => $value) {
				if(is_array(@unserialize($value[0]))){
					update_post_meta($post_id , $key, unserialize($value[0]));
				}else{
					update_post_meta($post_id , $key, $value[0]);
				}
			}
			
		}	
	}
	
	
	function register_custom_posttype() {
		register_post_type( $this->slug,
		
		 	// let's now add all the options for this post type
			array('labels' => array(
				'name' =>  $this->name, 
				'singular_name' => $this->name, 
				'all_items' => 'All  ' . $this->name .'s', 
				'add_new' => 'Create ' . $this->name ,
				'add_new_item' => 'Create '.$this->name .' Template' , 
				'edit' => 'Edit', /* Edit Dialog */
				'edit_item' => 'Edit '.$this->name .' Template' , 
				'new_item' => 'New '.$this->name .' Template', 
				'view_item' => 'View '.$this->name .' Template' , 
				'search_items' => 'Search '. $this->name . ' Templates', 
				'not_found' =>  'Nothing found in the Database.',
				'not_found_in_trash' => 'Nothing found in Trash', 
				'parent_item_colon' => ''
				), 
				
				'description' => '', 
				'public' => false,
				'publicly_queryable' => true,
				'exclude_from_search' => false,
				'show_ui' => true,
				'query_var' => true,
				'menu_position' => 30, 
				'menu_icon' => C5_skins_URL. 'images/'.$this->image.'.png', 
				'rewrite'	=> array( 'slug' => $this->slug,  'with_front' => false ),
				'has_archive' => $this->slug, 
				'capability_type' => 'page',
				'hierarchical' => false,
				'supports' => $this->supports
		 	) 
		); 
	}
	
	function get_content($id , $label , $std,$section = '') {
		return array(
		    'label' => $label,
		    'id' => $id,
		    'type' => 'textarea',
		    'desc' => '<span class="c5ab_launch_generator button c5ab_another_editor">[ ] Insert shortcode</span>',
		    'std' => $std,
		    'rows' => '',
		    'post_type' => '',
		    'taxonomy' => '',
		    'class' => ''
		);
	}
	
	function get_dark_light($name, $id,$default) {
		
		$layout_array = array(
			'dark',
			'light'
		);
		$layout_options = array(
		);
		
		foreach ($layout_array as $value) {
			$layout_options[] = array(
			    'src' => C5_skins_URL. 'images/dark/'.$value.'.png', 
			    'label' => '',
			    'value' => $value . '-mode'
			);
		}
		$return = array(
		    'label' => $name . ' Background style',
		    'id' => $id,
		    'type' => 'radio-image',
		    'desc' => 'Choose the Background style for '. $name ,
		    'choices' => $layout_options,
		    'std' => $default,
		    'rows' => '',
		    'post_type' => '',
		    'taxonomy' => '',
		    'class' => '',
		);
		
		
		return $return;
	}
	
	function get_font_weight_images() {
		$layout_array = array(
			'100',
			'300',
			'400',
			'700'
		);
		$layout_options = array(
		);
		
		foreach ($layout_array as $value) {
			$layout_options[] = array(
			    'src' => C5_skins_URL. 'images/font-weight/'.$value.'.png', 
			    'label' => '',
			    'value' => $value . ''
			);
		}
		return $layout_options;
	}
	
	function get_uppercase_normal_images() {
		$layout_array = array(
			'normal',
			'uppercase',
		);
		$layout_options = array(
		);
		
		foreach ($layout_array as $value) {
			$layout_options[] = array(
			    'src' => C5_skins_URL. 'images/upper/'.$value.'.png', 
			    'label' => '',
			    'value' => $value . ''
			);
		}
		return $layout_options;
	}
	
	function get_font_size_array($name , $id , $default,$section= '') {
		$return = array(
		    'label' => $name . ' font size',
		    'id' => $id,
		    'type'=> 'numeric-slider',
		    'desc'=> 'Select the font size for ' . $name,
		    'std'=> $default, 
		    'min_max_step' => '10,100,1',
		    'rows' => '',
		    'post_type' => '',
		    'taxonomy' => '',
		    'class' => '',
		);
		
		
		return $return;
	}
	
	function get_logo_position_images() {
		$layout_array = array(
			'logo-left',
			'logo-right',
			//'logo-center-top',
			//'logo-center-bottom',
			'logo-custom',
		);
		$layout_options = array(
		);
		
		foreach ($layout_array as $value) {
			$array = array(
			    'src' => C5_skins_URL. 'images/logo-align/'.$value.'.png',
			    'label' => '',
			    'value' => $value 
			);
			 array_push($layout_options, $array);
		}
		return $layout_options;
	}
	
	function get_menu_position_images() {
		$layout_array = array(
			'top',
			'side',
		);
		$layout_options = array(
		);
		
		foreach ($layout_array as $value) {
			$array = array(
			    'src' => C5_skins_URL. 'images/menu/'.$value.'.gif',
			    'label' => '',
			    'value' => $value 
			);
			 array_push($layout_options, $array);
		}
		return $layout_options;
	}
	function get_breaking_news_images() {
		$layout_array = array(
			'horizontal',
			'vertical',
			'thumbnail',
		);
		$layout_options = array(
		);
		
		foreach ($layout_array as $value) {
			$array = array(
			    'src' => C5_skins_URL. 'images/breaking-news/'.$value.'-slide.gif',
			    'label' => '',
			    'value' => $value 
			);
			 array_push($layout_options, $array);
		}
		return $layout_options;
	}
	
	function get_current_menus() {
			/** Menu Locations* */
			    $themes = get_registered_nav_menus();
				$menu_new = array();
					
			    foreach ($themes as $key => $value) {
			        $menu_new[] = array(
			            'label' => $value,
			            'value' => $key
			        );
			    }
			    
			    return $menu_new;
	}	
}
?>