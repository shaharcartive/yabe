<?php 
/*
Plugin Name: Awesome Builder
Plugin URI: http://www.code125.com/page-builder/
Description: A drag and drop page builder & shortcode generator that simplifies building your website.
Version: 1.2
Author: Code125
Author URI: http://themeforest.net/user/Code125
License: GPL3
License URI: http://www.gnu.org/licenses/gpl.html
*/

if(!class_exists('C5BP_LOADER')){
	class C5BP_LOADER {
		public function __construct() {
		 
		 /* load languages */
		 $this->load_languages();
		 
		 /* load Plugin */
		 add_action( 'after_setup_theme', array( $this, 'load_pagebuilder' ), 1 );
		  
		  add_action('wp_head', array($this, 'front_css'));
		  
		  add_filter( 'the_content',  array( $this, 'load_template_front' ) );
		  
		  
		  
		}
		
		private function load_languages() {
		    
		      /**
		       * A quick check to see if we're in plugin mode.
		       *
		       * @since     1.2
		       */
		      define( 'C5AB_PLUGIN_MODE', strpos( dirname( __FILE__ ), 'plugins' . DIRECTORY_SEPARATOR . basename( dirname( __FILE__ ) ) ) !== false ? true : false );
		      
		      /**
		       * Path to the languages directory. 
		       *
		       * This path will be relative in plugin mode and absolute in theme mode.
		       *
		       * @since     1.2
		       */
		      define( 'C5AB_LANG_DIR', dirname( plugin_basename( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'languages' . DIRECTORY_SEPARATOR );
		
		      /* load the text domain  */
		      if ( C5AB_PLUGIN_MODE ) {
		      
		        add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
		        
		      } else {
		      
		        add_action( 'after_setup_theme', array( $this, 'load_textdomain' ) );
		        
		      }
		      
		    }
		/**
		 * Load the text domain.
		 *
		 * @return    void
		 *
		 * @access    private
		 * @since     2.0
		 */
		public function load_textdomain() {
		
		  if ( C5AB_PLUGIN_MODE ) {
		  
		    load_plugin_textdomain( 'c5ab', false, C5AB_LANG_DIR );
		    
		  } else {
		  
		    load_theme_textdomain( 'c5ab', DIRECTORY_SEPARATOR . C5AB_LANG_DIR  );
		    
		  }
		  
		}
		
		function front_css() {
		
			$this->load_file( C5BP_root . "includes/front_css.php" );
		}
		
		function load_template_front($content) {
		  
		  /*
		  $template = get_post_meta($GLOBALS['post']->ID, 'c5ab_data', true);
		  if( is_array(@unserialize( base64_decode( $template) )) ){
		  	$template = unserialize( base64_decode( $template ) );
		  	$content .= c5ab_get_option('before_full'); 
		  	ob_start();
		  	
		  	foreach ($template as $row) {
		  	
		  	    $obj = new C5PB_ROW();
		  	    $obj->set_options($row);
		  	    $obj->render();
		  	}
		  	
		  	$content .= ob_get_contents();
		  	ob_end_clean();
		  	$content .= c5ab_get_option('after_full');
		  }
		  */
		  $template = get_post_meta($GLOBALS['post']->ID, 'c5ab_data', true);
		  if( is_array(@unserialize( base64_decode( $template) )) ){
		  	$template = unserialize( base64_decode( $template ) );
		  	$content .= '</div>'; 
		  	ob_start();
		  	
		  	foreach ($template as $row) {
		  	
		  	    $obj = new C5PB_ROW();
		  	    $obj->set_options($row);
		  	    $obj->render();
		  	}
		  	
		  	$content .= ob_get_contents();
		  	ob_end_clean();
		  	$content .= '<div class="'.c5_get_width_class().'">';
		  }
		  
		  return $content;
		}
		
		public function load_pagebuilder() {
		
		  /* setup the constants */
		  $this->constants();
		  
		  /* include the required admin files */
		  $this->admin_includes();
		  
		  /* include the required files */
		  //$this->includes();
		  
		  /* hook into WordPress */
		  $this->hooks();
		  
		}
		
		
		
		private function constants() {
		  
		  define('C5BP_Version', '1.0');
		  
		  define( 'C5BP_C5_THEME_MODE', apply_filters( 'c5ab_theme_mode', false ) );
		  	
		  
		  
		  if ( C5AB_PLUGIN_MODE ) {
		    define( 'C5BP_root', plugin_dir_path( __FILE__ ) );
		    define( 'C5BP_uri', plugin_dir_url( __FILE__ ) );
		  } else {
		    	
		      define( 'C5BP_root', C5_skins_ROOT . 'awesome-builder/' );
		      define( 'C5BP_uri', C5_skins_URL . 'awesome-builder/' );
		    
		  }
		  
		  
		}
		
		
		private function admin_includes() {
		  
		  /* exit early if we're not on an admin page */
		 
		   
		  add_filter( 'ot_show_pages', '__return_false' );
		  
		  $this->load_file( C5BP_root . 'option-tree/ot-loader.php');
		  /*
		  //plugin widgets include
		  if(get_option('c5ab_load_widgets') != 'NO'){
		  	$this->load_file( C5BP_root . 'widgets/widgets-loader.php');
		  }
		  */
		  /* global include files */
		  $files = array( 
		    'settings',
		    'base',
		    'element',
		    'layout',
		    'row',
		    'template',
		    'mobile',
		    'generator',
		    'user'
		  );
		  
		  /* require the files */
		  foreach ( $files as $file ) {
		    $this->load_file( C5BP_root . "classes/{$file}.php" );
		  }
		  define('C5BP_col_count', c5ab_get_option('col_count'));
		  
		  $this->load_file( C5BP_root . 'includes/ajax.php');
		   $this->load_file( C5BP_root . 'includes/functions.php');
		  
		  if(c5ab_get_option('widgets') == 'off'){
		  	update_option('c5ab_load_widgets' , 'NO' ); 
		  }
		  add_action( 'add_meta_boxes',  array($this, 'metabox') );
		  
		}
		
		private function load_file( $file ){
		  
		  include_once( $file );
		  
		}
		
		function hooks() {
			/* add scripts for metaboxes to post-new.php & post.php */
			add_action( 'admin_enqueue_scripts', array($this, 'load_js'), 11 );
			      
			/* add styles for metaboxes to post-new.php & post.php */
			add_action( 'admin_enqueue_scripts', array($this, 'load_css'), 11 );
						
			
			
			
			add_action('wp_enqueue_scripts', array($this, 'load_front_css') );
			
			
			add_action('edit_form_after_title',  array($this, 'media_button'), 11);
			
			add_action( 'pre_post_update', array($this, 'pre_post_update')  );
			
			add_shortcode( 'c5ab_template', array( $this, 'shortcode_template' ) );
		}
		
		
		function shortcode_template($atts,$content) {
			$atts = shortcode_atts( array(
				      'id' => ''
			     ), $atts );
			
			$content = '';
			
			if($atts['id'] == ''){
				return;
			}
			$template = c5_get_premade_template($atts['id']);
			
			if( !$template ){
				$template = get_post_meta($atts['id'], 'c5ab_data', true);	
			}
			if( is_array(@unserialize( base64_decode( $template) )) ){
				$template = unserialize( base64_decode( $template ) );
				$content .= c5ab_get_option('before_full'); 
				ob_start();
				
				foreach ($template as $row) {
				
				    $obj = new C5PB_ROW();
				    $obj->set_options($row);
				    $obj->render();
				}
				
				$content .= ob_get_contents();
				ob_end_clean();
				$content .= c5ab_get_option('after_full');
			}
			
			
			return $content; 
			     
		}
		
		function media_button($post) {
		
			$array = c5ab_get_option('post_types');
			
			if(is_array($array)){
				foreach($array as $type){
					if($post->post_type== $type){
						echo '<span class="c5ab-btn c5ab-launch-builder " data-show="'.__('Show Awesome Builder', 'c5ab').'" data-hide="'.__('Show classical Editor', 'c5ab').'" >'.__('Show Awesome Builder', 'c5ab').'</span>';
					}
				}
			}
		}
		
		
		
		function load_front_css() {
			//wp_enqueue_style( 'c5ab-admin', C5BP_uri . 'less/admin.less');
			wp_enqueue_style( 'c5ab-animate', C5BP_uri . 'css/animate.min.css');
			wp_enqueue_script( 'c5ab-front', C5BP_uri . 'js/c5ab-front.js', array(), '1.0.0', true );
			wp_enqueue_script( 'c5ab-wow', C5BP_uri . 'js/wow.min.js', array(), '1.12', true );
		}
		
		function load_css($hook) {
			
			wp_enqueue_style( 'c5ab-admin', C5BP_uri . 'css/admin.css');
			//wp_enqueue_style( 'c5ab-admin','http://awesome-builder.code-125.com/wp-content/uploads/wp-lesshttp://awesome-builder.code-125.com/wp-content/plugins/awesome-builder/less/admin-1c8e216668.css');
			
			
			wp_register_style( 'c5ab-admin-font', C5BP_uri . 'css/c5ab-font.css' );
			wp_enqueue_style( 'c5ab-admin-font' );
		}
		
		function load_js() {
			wp_enqueue_script( 'jquery-ui-resizable' );
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'jquery-ui-tabs' );
			wp_enqueue_script( 'jquery-ui-dialog' );
			wp_enqueue_script( 'jquery-ui-button' );
			
			
			wp_enqueue_script( 'c5ab-admin', C5BP_uri . 'js/admin.js', array(), '1.0.0', true );
			wp_enqueue_script( 'c5ab-magnific', C5BP_uri . 'js/jquery.magnific-popup.min.js', array(), '1.0.0', true );
			
			wp_enqueue_script( 'c5ab-tooltip', C5BP_uri . 'js/tooltip.min.js', array(), '1.0.0', true );
			
			wp_enqueue_script( 'c5ab-underscore', C5BP_uri . 'js/underscore.min.js', array(), '1.6.0', true );
			
			            
			wp_localize_script( 'c5ab-admin', 'c5ab_ajax_object',
			array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
		}
		
		function metabox() {
			$array = c5ab_get_option('post_types');
			
			if(is_array($array)){
				foreach($array as $type){
					add_meta_box( 'c5bp-builder-panel', __( 'Awesome Builder', 'c5bp-builder' ), array($this, 'metabox_render') , $type, 'normal', 'high' );
				}
			}
		}
		
		
		function metabox_render() {
			$this->load_file( C5BP_root . "includes/panel.php" );
		}
		
		function pre_post_update( $post_id ) {
			// If this is just a revision, don't send the email.
			if ( wp_is_post_revision( $post_id ) )
				return;
			if(!isset($_POST['c5ColCount'])){
				return;
			}
			
			
			$order = $this->get_children('0' , $_POST );
			$value = $this->get_child_values($order, $_POST );
			
			update_post_meta($post_id, 'c5ab_data', base64_encode(serialize($value)) );
			if(isset($_POST['c5ColCount'])){
				update_post_meta($post_id, 'c5ab_col_cout', $_POST['c5ColCount'] );
			}
			$c5abShowBuilder = 'False';
			if(isset($_POST['c5abShowBuilder']) && $_POST['c5abShowBuilder'] == 'True'){
				$c5abShowBuilder = 'True';
			}
			update_post_meta($post_id, 'c5ab_show_builder', $c5abShowBuilder); 
			c5_update_ab_templates();
			
			
		}
		
		function get_child_values($order , $post_data) {
			$data_return = array();
			foreach ($order as $id => $value2) {
				$return = array();
				
				foreach ($post_data as $key => $value) {
					$exploded = explode("-", $key);
					
					if($exploded[0] == 'c5ab' ){
						if( $exploded[1] == $id){
							
							if( is_array(@unserialize( base64_decode( $value) )) ){
								
								$return[$exploded[2] ] = unserialize( base64_decode( $value ) );
							}else {
								$return[$exploded[2] ] = $value;
							}
							
						}
					}
				}
				if(count($value2)!=0){
					$return['content'] = $this->get_child_values($value2 , $post_data);
				}
				$return['id'] = $id;
				$data_return[] = $return;
			}
			return $data_return;
		}
		
		function get_children($parent_id , $post_data ) {
			$order =array();
			foreach ($post_data as $key => $value) {
				$exploded = explode("-", $key);
				if($exploded[0] == 'c5ab' && $exploded[1] != 'test' ){
					if( $_POST['c5ab-' . $exploded[1] .'-parent'] == $parent_id){
						$order[$exploded[1]] = array() ;
					}
				}
			}
			if(count($order)!=0){
				foreach ($order as $key => $value) {
					$order[$key]=$this->get_children($key , $post_data );
				}
			}
			
			return $order;
		}
		
		function validate_col_grid($template, $saved_col_count ) {
			/*
			foreach ($template as  $array) {
				if($array['type'] == 'row'){
					$total= 0;
					foreach ($array['content'] as $layout) {
						$total += round( $layout['desktop']*$saved_col_count/C5BP_col_count );
						$layout['desktop'] = round( $layout['desktop']*$saved_col_count/C5BP_col_count );
						$layout['tablet'] = round( $layout['tablet']*$saved_col_count/C5BP_col_count );
						$layout['mobile'] = round( $layout['mobile']*$saved_col_count/C5BP_col_count );
					}
					if($total != $saved_col_count){
						$diff = $saved_col_count - $total;
						if($array['content'][0]['desktop'] + $diff > 0){
							
						}
					}
				}
				
			}
			*/
			return $template;
		}
	}
	$c5bp_loader = new C5BP_LOADER();
}
 ?>