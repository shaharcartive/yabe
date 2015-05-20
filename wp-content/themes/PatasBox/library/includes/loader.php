<?php 


define('C5_skins_ROOT', C5_ROOT . 'library/includes/');
define('C5_skins_URL', C5_URL . 'library/includes/');


//theme widgets include
require_once(C5_skins_ROOT . 'widgets/widgets-loader.php' );
require_once(C5_skins_ROOT . 'option-tree-extra-types/class-option-tree-types.php' );

	

$files = array(
	'admin-functions',
	'functions',
	'like',
	'post-formats',
	'ajax',
	'lessc.inc'
);

if(class_exists( 'WooCommerce' )){
	$files[] =  'woocommerce';
}
foreach ($files as $file ) {
	require_once(C5_skins_ROOT . 'files/'.$file.'.php' );
}
$classes = array(
	'header',
	'header-css',
	'bread-crumb',
//	'social-share-count',
	'admin-bar',
	'theme-options-base',
	'theme-options-elements',
	'theme-functions',
	'archive',
	'quick-setup',
	'post',
	'preview',
	'article',
	'menu',
	'author',
	'category',
	'skin-base',
	'cpt',
	'custom-post',
	'fonts',
	'header',
	'meta-boxes',
	'skin',
	'layout',
	'header-options',
	'footer-options',
	'theme-options',
	'update-notifier'
);

foreach ($classes as $file ) {
	require_once(C5_skins_ROOT . 'classes/class-'.$file.'.php' );
}



if(!C5_simple_option){
	$skin_obj = new C5_header();
	$skin_obj->_hook();
	$skin_obj = new C5_skin();
	$skin_obj->_hook();
	$skin_obj = new C5_footer();
	$skin_obj->_hook();
	$skin_obj->single_hook();
}
$c5_admin_bar = new C5_admin_bar();
$c5_cpt = new C5_cpt();

$theme_options = new C5_theme_option_build();
$meta_boxes = new C5_meta_boxes();
$theme_options->hook_theme_options();


 ?>