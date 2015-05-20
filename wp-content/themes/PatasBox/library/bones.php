<?php
/* Welcome to Bones :)
This is the core Bones file where most of the
main functions & features reside. If you have
any custom functions, it's best to put them
in the functions.php file.

Developed by: Eddie Machado
URL: http://themble.com/bones/
*/

/*********************
LAUNCH BONES
Let's fire off all the functions
and tools. I put it up here so it's
right up top and clean.
*********************/

// we're firing all out initial functions at the start
add_action( 'after_setup_theme', 'c5_ahoy', 16 );

function c5_ahoy() {
	
	// launching operation cleanup
	add_action( 'init', 'c5_head_cleanup' );
	// remove WP version from RSS
	add_filter( 'the_generator', 'c5_rss_version' );
	// remove pesky injected css for recent comments widget
	add_filter( 'wp_head', 'c5_remove_wp_widget_recent_comments_style', 1 );
	// clean up comment styles in the head
	add_action( 'wp_head', 'c5_remove_recent_comments_style', 1 );
	// clean up gallery output in wp
	add_filter( 'gallery_style', 'c5_gallery_style' );

	// enqueue base scripts and styles
	
	add_action( 'wp', 'c5_prepare_theme', 1 );
	add_action( 'wp_enqueue_scripts', 'c5_scripts_and_styles', 999 );
	
	// ie conditional wrapper

	// launching this stuff after theme setup
	c5_theme_support();

	// adding sidebars to Wordpress (these are created in functions.php)
	add_action( 'widgets_init', 'c5_register_sidebars' );
	

	// cleaning up random code around images
	add_filter( 'the_content', 'c5_filter_ptags_on_images' );
	// cleaning up excerpt
	add_filter( 'excerpt_more', 'c5_excerpt_more' );

} /* end bones ahoy */

function c5_prepare_theme() {
	$info_obj = new C5_theme_layout();
	
	$skin_id = $info_obj->get_current_skin();
	global $c5_skindata;
	global $c5_headerdata;
	global $c5_footerdata;
	
	global $wp_locale;
	
	if($c5_skindata['rtl'] == 'rtl' && !is_admin() ){
		$wp_locale->text_direction = 'rtl';
	}
	
}

add_action('admin_init', 'c5_admin_init_theme_awesome_builder');
function c5_admin_init_theme_awesome_builder() {
	global $c5_skindata;
	
	$c5_skindata['post_types'] =array(
		'page', 'footer'
	);
}

/*********************
WP_HEAD GOODNESS
The default wordpress head is
a mess. Let's clean it up by
removing all the junk we don't
need.
*********************/

function c5_head_cleanup() {

	// remove WP version from css
	add_filter( 'style_loader_src', 'c5_remove_wp_ver_css_js', 9999 );
	// remove Wp version from scripts
	add_filter( 'script_loader_src', 'c5_remove_wp_ver_css_js', 9999 );
	
	$GLOBALS['c5_page_load_start' ]  = microtime(true);
	
	$skip = array(
		'c5ab_social_icons'
	);
	foreach ($skip as $value) {
		$GLOBALS['c5ab_custom_css_' . $value] = TRUE;	
	}
	

} /* end bones head cleanup */

// remove WP version from RSS
function c5_rss_version() { return ''; }

// remove WP version from scripts
function c5_remove_wp_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}

// remove injected CSS for recent comments widget
function c5_remove_wp_widget_recent_comments_style() {
	if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
		remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
	}
}

// remove injected CSS from recent comments widget
function c5_remove_recent_comments_style() {
	global $wp_widget_factory;
	if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
		remove_action( 'wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style') );
	}
}

// remove injected CSS from gallery
function c5_gallery_style($css) {
	return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );
}

/*********************
SCRIPTS & ENQUEUEING
*********************/

// loading modernizr and jquery, and reply script
function c5_scripts_and_styles() {
	
	global $wp_styles; 
	global $c5_skindata;
	
	if (!is_admin()) {
		
		// modernizr (without media query polyfill)
		wp_enqueue_script( 'bones-modernizr', get_template_directory_uri() . '/library/js/libs/modernizr.custom.min.js', array(), '2.5.3', false );

		// register main stylesheet
		wp_enqueue_style( 'c5-stylesheet', get_template_directory_uri() . '/library/css/style.css' );
//		wp_enqueue_style( 'c5-diary-stylesheet', get_template_directory_uri() . '/library/less/style.less' );
		
		
		if(class_exists( 'WooCommerce' )){
			wp_enqueue_style( 'c5-woocommerce', get_template_directory_uri() . '/library/css/woocommerce.css' );
			wp_enqueue_style( 'c5-woocommerce-font', get_template_directory_uri() . '/library/less-woocommerce/font.css' );
//			wp_enqueue_style( 'c5-woocommerce', get_template_directory_uri() . '/library/less-woocommerce/index.less' );
		}
		
		if(is_rtl()){
			wp_enqueue_style( 'c5-rtl', get_template_directory_uri() . '/library/css/rtl.css' );
		}
		

		// ie-only style sheet
		wp_enqueue_style( 'bones-ie-only', get_template_directory_uri() . '/library/css/ie.css', array(), '' );

		// comment reply script for threaded comments
		if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
			wp_enqueue_script( 'comment-reply' );
		}
		$main_font = array();
		$main_font['heading_font'] = $c5_skindata['heading_font'];
		$main_font['body_font'] = $c5_skindata['body_font'];
		foreach ($main_font as $key => $value) {
			$info = explode('#', $value);
			if($info[2]=='googlefont'){
				wp_enqueue_style( 'c5-font-'. $key, 'http://fonts.googleapis.com/css?family='.$info[0].':100,200,300,400,500,600,700,800,900&subset='.$info[1] );
			}elseif ($info[2]=='earlyaccess') {
				wp_enqueue_style( 'c5-font-'. $key, 'http://fonts.googleapis.com/earlyaccess/'.$info[0].'.css');
			}elseif ($info[2]=='custom') {
				$fonts = ot_get_option('custom_fonts');
				if(is_array($fonts)){
					foreach ($fonts as $font) {
						if($font['title'] == $info[0]){
							wp_enqueue_style( 'c5-font-'. str_replace(" ", "", $font['title']), get_template_directory_uri() . '/library/fonts/'.$font['folder'].'/'.	$font['css'].'.css');
						}
					}
				}
			}
		}
		
		//adding scripts file in the footer
		wp_register_script( 'bones-js', get_template_directory_uri() . '/library/js/scripts.js', array( 'jquery' ), '', true );
		
		wp_register_script( 'bootstrap-js', get_template_directory_uri() . '/library/js/libs/bootstrap.min.js', array( 'jquery' ), '', true );
		wp_register_script( 'news-ticker-js', get_template_directory_uri() . '/library/js/libs/jquery.webticker.min.js', array( 'jquery' ), '', true );
		wp_register_script( 'tiptip-js', get_template_directory_uri() . '/library/js/libs/tiptip.js', array( 'jquery' ), '', true );
		wp_register_script( 'isotope-js', get_template_directory_uri() . '/library/js/libs/isotope.pkgd.min.js', array( 'jquery' ), '', true );
		wp_register_script( 'c5-sidebarEffects', get_template_directory_uri() . '/library/js/libs/sidebarEffects.js', array( 'jquery' ), '', true );

		$wp_styles->add_data( 'bones-ie-only', 'conditional', 'lt IE 9' ); // add conditional wrapper around ie stylesheet

		/*
		I recommend using a plugin to call jQuery
		using the google cdn. That way it stays cached
		and your site will load faster.
		*/
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'bones-js' );
		wp_enqueue_script( 'bootstrap-js' );
		wp_enqueue_script( 'news-ticker-js' );
		wp_enqueue_script( 'isotope-js' );
		wp_enqueue_script( 'tiptip-js' );
		wp_enqueue_script( 'c5-sidebarEffects' );
		
		wp_localize_script('bones-js', 'ajax_var', array(
		    'url' => admin_url('admin-ajax.php'),
		    'nonce' => wp_create_nonce('ajax-nonce')
		));
		global $is_IE;
		if($is_IE){
			wp_register_script( 'respond-js', get_template_directory_uri() . '/library/js/libs/respond.min.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'respond-js' );
		}
	}
}

/*********************
THEME SUPPORT
*********************/

// Adding WP 3+ Functions & Theme Support
function c5_theme_support() {

	// wp thumbnails (sizes handled in functions.php)
	add_theme_support( 'post-thumbnails' );

	// default thumb size
	set_post_thumbnail_size(125, 125, true);
	
	add_theme_support( 'woocommerce' );
	
	add_theme_support( 'custom-header');
	add_theme_support( 'custom-background' );
	// rss thingy
	add_theme_support('automatic-feed-links');

	// to add header image support go here: http://themble.com/support/adding-header-background-image-support/

	// adding post format support
	add_theme_support( 'post-formats',
		array(
			//'aside',           // title less blurb
			'gallery',           // gallery of images
//			'link',              // quick link to other site
			'image',             // an image
			'quote',             // a quick quote
			//'status',          // a Facebook like status update
			'video',             // video
			'audio',             // audio
			//'chat'             // chat transcript
		)
	);

	// wp menus
	add_theme_support( 'menus' );

	$menus = array(
		'main-nav' => 'Main Menu',
	);
	$menus_array = ot_get_option('menus', array());
	if ($menus_array) {
	    foreach ($menus_array as $menu_array) {
	    	$menus[ $menu_array['location'] ] =  $menu_array['title'];
	    }
	}
	   
	// registering wp3+ menus
	register_nav_menus($menus);
} /* end bones theme support */

/*********************
PAGE NAVI
*********************/

// Numeric Page Navi (built into the theme by default)
function c5_page_navi() {
	global $wp_query;
	$bignum = 999999999;
	if ( $wp_query->max_num_pages <= 1 )
		return;
	
	echo '<nav class="c5-pagination">';
	
		echo paginate_links( array(
			'base' 			=> str_replace( $bignum, '%#%', esc_url( get_pagenum_link($bignum) ) ),
			'format' 		=> '',
			'current' 		=> max( 1, get_query_var('paged') ),
			'total' 		=> $wp_query->max_num_pages,
			'prev_text' 	=> '<span class="fa fa-chevron-left"></span>;',
			'next_text' 	=> '<span class="fa fa-chevron-right"></span>;',
			'type'			=> 'list',
			'end_size'		=> 3,
			'mid_size'		=> 3
		) );
	
	echo '</nav>';
	
} /* end page navi */

/*********************
RANDOM CLEANUP ITEMS
*********************/

// remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function c5_filter_ptags_on_images($content){
	return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

// This removes the annoying […] to a Read More link
function c5_excerpt_more($more) {
	global $post;
	// edit here if you like
	return '';
}
?>