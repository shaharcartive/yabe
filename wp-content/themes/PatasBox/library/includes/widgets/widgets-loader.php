<?php 
/*
Plugin Name: Awesome Builder Extra
Plugin URI: http://www.code125.com/page-builder/
Description: Extra Widgets for Awesome Builder Plugin.
Version: 1.0
Author: Code125
Author URI: http://themeforest.net/user/Code125
License: GPL3
License URI: http://www.gnu.org/licenses/gpl.html
*/


if(!class_exists('C5BP_EXTRA')){
	class C5BP_EXTRA {
		public function __construct() {
		  
		  /* load languages */
		  //$this->load_languages();
		  
		  /* load Plugin */
		  $this->load();
		  //add_action( 'plugins_loaded', array( $this, 'load' ), 1 );
		  
		}
		
		
		function load() {
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
		  
		  
		  
		  define('C5BP_extra_uri', C5_skins_URL . 'widgets/');
		  define('C5BP_extra_root',C5_skins_ROOT . 'widgets/' );
		  /*
		  define('C5BP_extra_uri', C5_shortcodes_URL .'/c5-builder/');
		  define('C5BP_extra_root', C5_shortcodes_PATH .'/c5-builder/');
		  */
		}
		
		
		private function admin_includes() {
		  
		  /* exit early if we're not on an admin page */
		  
		  
		  
		  $this->load_file( C5BP_extra_root . 'includes/C5_Widget.php');
		  $this->load_file( C5BP_extra_root . 'includes/C5_style.php');
		  $this->load_file( C5BP_extra_root . 'includes/C5_icons.php');
		  $this->load_file( C5BP_extra_root . 'includes/C5_image.php');
		  $this->load_file( C5BP_extra_root . 'includes/C5_skin.php');
		  $this->load_file( C5BP_extra_root . 'includes/C5_social.php');
		  $this->load_file( C5BP_extra_root . 'includes/twitteroauth.php');
		  $this->load_file( C5BP_extra_root . 'includes/ot_radio-text.php');
		  $this->load_file( C5BP_extra_root . 'pre-made/pre-made.php');
		  
		  
		  /* global include files */
		  $files = array( 
		    'button',
		    'service_column',
		    'call_an_action',
		    'facebook_post',
		    'facebook_like_box',
		    'google_plus_box',
		    'youtube_box',
		    'twitter',
		    'tweet',
		    'title',
		    'ads',
		    'social_icons',
		    'flickr',
		    'video',
		    'audio',
		    'tabs',
		    'pricing_table',
		    'toggle',
		    'space',
		    'divider',
		    'percentage',
		    'center',
		    'box',
		    'slider',
		    'image',
		    'instagram',
		    'dribbble',
		    'ul',
		    'icon',
		    'search',
		    'account',
		    'social_count',
		    'featured_post',
		    'authors_info',
		    'contact_form',
		    'text',
		    'rating',
		    'menu',
		    'posts',
		    'section',
		  );
		  
		  /* require the files */
		  foreach ( $files as $file ) {
		    $this->load_file( C5BP_extra_root . "widgets/{$file}.php" );
		  }
		  
		  
		  
		}
		
		private function load_file( $file ){
		  
		  include_once( $file );
		  
		}
		
		function hooks() {
			/* add scripts for metaboxes to post-new.php & post.php */
			add_action( 'admin_print_scripts-post-new.php', array($this, 'load_js'), 11 );
			add_action( 'admin_print_scripts-post.php', array($this, 'load_js'), 11 );
			      
			/* add styles for metaboxes to post-new.php & post.php */
			add_action( 'admin_enqueue_scripts', array($this, 'load_css'), 11 );
			
			
			
			add_action('wp_enqueue_scripts', array($this, 'load_front_css') );
			
			add_action('widgets_init' , array($this, 'register_widgets'));
		}
		
		
		
		
		
		
		function load_front_css() {
			//wp_enqueue_style( 'c5ab-widgets', C5BP_extra_uri . 'less/c5ab-widgets.less');
			wp_enqueue_style( 'c5ab-widgets', C5BP_extra_uri . 'css/c5ab-widgets.css');
			wp_enqueue_style( 'c5ab-font-awesome', C5BP_extra_uri . 'fonts/font-awesome/css/font-awesome.min.css');
//			wp_enqueue_style( 'c5ab-flexslider', C5BP_extra_uri . 'css/flexslider.css');
			wp_enqueue_script( 'c5ab-widgets', C5BP_extra_uri . 'js/c5ab-widgets.js', array(), '1.0.0', true );
			wp_localize_script('c5ab-widgets', 'c5_ajax_var', array(
			    'url' => admin_url('admin-ajax.php'),
			    'nonce' => wp_create_nonce('ajax-nonce')
			));
			wp_enqueue_script('jquery' );
			wp_enqueue_script( 'c5ab-flexslider', C5BP_extra_uri . 'js/jquery.flexslider-min.js', array(), '2.2', true );
			wp_enqueue_script( 'c5ab-magnify', C5BP_extra_uri . 'js/jquery.magnific-popup.min.js', array(), '0.9.9', true );
			
			wp_enqueue_script('c5ab-jquery-tools', C5BP_extra_uri . 'js/jquery.tools.min.js', array(), '1.0', true);
		}
		
		function load_css() {
			//wp_enqueue_style( 'c5ab-admin', C5BP_extra_uri . 'css/admin.css');
			//wp_enqueue_style( 'c5ab-admin','http://naga.code-125.com/wp-content/uploads/wp-less/naga/library/naga-plugin/c5-builder/less/admin-61e2bbfc16.css');
			wp_enqueue_style( 'c5ab-font-awesome', C5BP_extra_uri . 'fonts/font-awesome/css/font-awesome.min.css');
			
		}
		
		function load_js() {
			//wp_enqueue_script( 'c5ab-admin', C5BP_extra_uri . 'js/admin.js', array(), '1.0.0', true );
			
		}
		
		function register_widgets() {
			register_widget( 'C5AB_service_column' );
			register_widget( 'C5AB_button' );
			//register_widget( 'C5AB_call_an_action' );
			register_widget( 'C5AB_facebook_post' );
			register_widget( 'C5AB_facebook_like_box' );
			register_widget( 'C5AB_google_plus_box' );
			register_widget( 'C5AB_youtube_box' );
			register_widget( 'C5AB_twitter' );
			register_widget( 'C5AB_title' );
			register_widget( 'C5AB_ads' );
			register_widget( 'C5AB_social_icons' );
			register_widget( 'C5AB_flickr' );
			register_widget( 'C5AB_video' );
			register_widget( 'C5AB_audio' );
			register_widget( 'C5AB_tabs' );
			register_widget( 'C5AB_pricing_table' );
			register_widget( 'C5AB_toggle' );
			register_widget( 'C5AB_space' );
			register_widget( 'C5AB_divider' );
			register_widget( 'C5AB_center' );
			register_widget( 'C5AB_percentage' );
			register_widget( 'C5AB_box' );
			register_widget( 'C5AB_slider' );
			register_widget( 'C5AB_image' );
			register_widget( 'C5AB_ul' );
			register_widget( 'C5AB_icon' );
			register_widget( 'C5AB_tweet' );
			register_widget( 'C5AB_search' );
			register_widget( 'C5AB_account' );
			register_widget( 'C5AB_social_count' );
			register_widget( 'C5AB_featured_post' );
			register_widget( 'C5AB_authors_info' );
			register_widget( 'C5AB_contact_form' );
			register_widget( 'C5AB_instagram' );
			register_widget( 'C5AB_dribbble' );
			register_widget( 'C5AB_text' );
			register_widget( 'C5AB_section' );
			register_widget( 'C5AB_menu' );
			register_widget( 'C5AB_posts' );
			register_widget( 'C5AB_review' );
			
			
			
			
			
			
			
		}
		
	}
	$c5bp_extra = new C5BP_EXTRA();
}

?>