<?php
add_filter('c5ab_theme_mode', '__return_true');
/*
if(isset($_GET['c5_flip'])){
	$simple_option = get_option('c5_options_mode');
	if($simple_option == 'simple'){
		update_option('c5_options_mode', 'advanced');
	}else {
		update_option('c5_options_mode', 'simple');
	}
}

$simple_option = get_option('c5_options_mode');

if($simple_option == 'advanced'){
	define('C5_simple_option', false);	
}else {
	define('C5_simple_option', true);
}
*/
define('C5_simple_option', true);
$GLOBALS['c5-in-article'] =false;


/*

$c5_initial_setup = get_option('c5_initial_setup');
if($c5_initial_setup != 'setuped'){
	add_action( 'admin_notices', 'c5_initial_setup' );
}

function c5_initial_setup() {
	update_option('c5_initial_setup', 'setuped');
	?>
	<div class="c5_initial_setup">
	<h3>Thank You for Purchasing Crystal</h3>
	<p>We would like to help you setting up your website, If this is the first time to use the theme we recommend  you to install the demo content then Use the quick setup</p>
	<a class="button button-primary button-large pull-left" href="<?php echo esc_url( admin_url() . 'index.php?page=c5-quick-setup' ); ?>">Quick Setup</a>
	<p id="wp-admin-bar-c5_install_demo" class="button button-primary button-large pull-left" >Install Demo Content</p>
	<p class="button c5-close-initial-setup button-primary button-large pull-left">Close</p>
	</div>
	<?php
}

*/
define('C5_ROOT', get_template_directory() . '/');
define('C5_URL', get_template_directory_uri() . '/');

if ( ! isset( $content_width ) ) $content_width = 740;

//require_once(C5_ROOT . 'library/includes/wp-less.php' );

require_once(C5_ROOT . 'library/bones.php' ); 
require_once(C5_ROOT . 'library/includes/awesome-builder/loader.php' );
require_once(C5_ROOT . 'library/includes/loader.php' );
require_once(C5_ROOT . 'library/includes/widget-import-export/widget-data.php' );
require_once(C5_ROOT . 'library/includes/wordpress-importer/loader.php' );
require_once(C5_ROOT . 'library/translation/translation.php' );

add_image_size( 'thumbnail', 150, 150, true );
add_image_size( 'medium', 300, 300, true );

function c5_import_admin_notice() {
    ?>
    	<input type="hidden" name="website_dir" id="website_dir" value="<?php echo esc_url(home_url()); ?>" />
    	<style>
    		#option-tree-settings-api .ui-tabs,
    		.ot-metabox-wrapper{
    			direction: ltr;
    		}
    		
    		#wp-admin-bar-c5_install_demo{
    			cursor: pointer;
    		}
    		.mfp-install-demo-post.mfp-auto-cursor  .mfp-content{
    			max-width:500px;
    			background: white;
    			padding: 30px;
    		}
    		
    		.btn {
    		display: inline-block;
    		padding: 8px 12px;
    		margin-bottom: 0;
    		font-size: 14px;
    		font-weight: 500;
    		line-height: 1.428571429;
    		text-align: center;
    		white-space: nowrap;
    		vertical-align: middle;
    		cursor: pointer;
    		border: 1px solid transparent;
    		border-radius: 4px;
    		}
    		a.btn{
    			text-decoration:none;
    		}
    		
    		.btn-primary {
    		color: #fff;
    		background-color: #428bca;
    		border-color: #428bca;
    		}
    		
    		.btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.active {
    		background-color: #357ebd;
    		border-color: #3071a9;
    		}
    		
    		.btn:hover, .btn:focus {
    		color: #fff;
    		text-decoration: none;
    		}
    	</style>
    <?php
}
add_action( 'admin_notices', 'c5_import_admin_notice' );

function c5_import_admin_js($hook) {
   
	wp_enqueue_style( 'c5ab-flexslider', C5BP_extra_uri . 'css/flexslider.css');
	wp_enqueue_script( 'c5ab-flexslider', C5BP_extra_uri . 'js/jquery.flexslider-min.js', array(), '2.2', true );
      
   wp_enqueue_style( 'c5-admin-ss', get_template_directory_uri() . '/library/css/admin.css' );
   wp_register_script( 'admin-import-js', get_template_directory_uri() . '/library/js/js-admin.js', array( 'jquery' ), '', true );
   wp_enqueue_script( 'admin-import-js' );
}
add_action( 'admin_enqueue_scripts', 'c5_import_admin_js' );

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function c5_register_sidebars() {
	$all_sidebars = array(
		array(
			'id'=>'sidebar',
			'name'=>'Primary Sidebar',
			'description' => 'Default Sidebar for All Pages'
		),
		array(
			'id'=>'article',
			'name'=>'Article Sidebar',
			'description' => 'Default Sidebar for Articles'
		),
	);
	if(class_exists( 'WooCommerce' )){
		$all_sidebars[] =  array(
			'id'=>'shop_sidebar',
			'name'=>'Shop Sidebar',
			'description' => 'Shop Sidebar'
		);
	}

	$sidebars = ot_get_option('sidebars', array());
	if ($sidebars) {
	    foreach ($sidebars as $sidebar) {
	    	$all_sidebars[] = array(
	    		'id'=>$sidebar['slug'],
	    		'name'=>$sidebar['title'],
	    		'description' => $sidebar['description']
	    	);
	    }
	}
	
	foreach ($all_sidebars as  $sidebar) {
		register_sidebar(array(
			'id' => $sidebar['id'],
			'name' => $sidebar['name'],
			'description' => $sidebar['description'],
			'before_widget' => '<div id="%1$s" class="widget c5_al_widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="title">',
			'after_title' => '</h3>',
		));
	}
	
	
} // don't remove this bracket!

$sidebars = array('Footer');
foreach ($sidebars as $sidebar) {
    register_sidebar(array('name'=> $sidebar,
    	'id' => 'Footer',
        'before_widget' => '<div id="%1$s" class="widget c5_al_widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
}

$sidebars = array('Ventajas');
foreach ($sidebars as $sidebar) {
    register_sidebar(array('name'=> $sidebar,
    	'id' => 'Ventajas',
        'before_widget' => '<div id="%1$s" class="ventajas c5ab-col-base c5ab-col-lg-4 c5ab-col-md-4 c5ab-col-sm-12 widget c5_al_widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>'
    ));
}

/************* COMMENT LAYOUT *********************/

// Comment Layout
function c5_comments( $comment, $args, $depth ) {
	?>
   <li <?php comment_class(); ?>>
   	<article id="comment-<?php comment_ID(); ?>" class="clearfix">
   		<header class="comment-author vcard clearfix">
   		    <?php /*
   		        this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
   		        echo get_avatar($comment,$size='32',$default='<path_to_url>' );
   		    */ ?>
   		    <!-- custom gravatar call -->
   		    <?php echo get_avatar($comment,$size='64',$default= ot_get_option('avatar') ); ?>
   		    <!-- end custom gravatar call -->
   			<?php printf('<cite class="fn">%s</cite>', get_comment_author_link()) ?><br><time class="time_class" datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time('j F, Y'); ?> </a></time>
   			<?php edit_comment_link(__('(Edit)', 'code125'),'  ','') ?>
   			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
   		</header>
   		<?php if ($comment->comment_approved == '0') : ?>
      			<div class="alert info">
         			<p><?php _e('Your comment is awaiting moderation.', 'code125') ?></p>
         		</div>
   		<?php endif; ?>
   		<section class="comment_content clearfix">
   			<?php comment_text() ?>
   		</section>
   	</article>
   <!-- </li> is added by wordpress automatically -->
<?php
} // don't remove this bracket!

function c5_wp_title( $title, $sep ) {
	global $paged, $page;
	$sep = '|';
	if ( is_feed() )
		return $title;

	// Add the site name.
	$title = get_bloginfo( 'name' ) . ' ' . $sep;
	
	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description' );
	if (  is_home() || is_front_page()  ){
		$title .= ' ' . $site_description;
		
	}else {
		$title .= ' ' . get_the_title();
	}
	
	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title .= " " . sprintf( __( 'Page %s', 'code125' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'c5_wp_title', 0, 2 );
add_action('wp_footer','c5_wp_footer_time',99999);

function c5_wp_footer_time() {
	 
	$diff = microtime(true) - $GLOBALS['c5_page_load_start' ];
	 ?>
	<!-- this page took <?php echo $diff ?> Seconds to load, Caution if you are using a caching plugin so this won't be an actual data - generated by Crystal WordPress Theme-->
	<?php
}

add_action( 'save_post',  'c5ab_catssave_meta_box'  , 1, 2 );
function c5ab_catssave_meta_box( $post_id, $post_object) {
	 global $pagenow;
	       
      /* don't save if $_POST is empty */
      if ( empty( $_POST ) )
        return $post_id;
      
      /* don't save during quick edit */
      if ( $pagenow == 'admin-ajax.php' )
        return $post_id;
        
      /* don't save during autosave */
      if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return $post_id;

      /* don't save if viewing a revision */
      if ( $post_object->post_type == 'revision' || $pagenow == 'revision.php' )
        return $post_id;
        
      if(isset( $_POST['category_styling']) ){
      	update_post_meta($post_id, 'category_styling' , $_POST['category_styling']);
      }
}

function c5_get_tax_from_post_type($post_type) {
	$obj = get_post_type_object( $post_type);
	foreach ($obj->taxonomies as  $taxonomy) {
		if($taxonomy!='post_tag'){
			return $taxonomy;
		}
	}
	return false;
	
}

function c5_imageCreateFromAny($filepath) { 
	
    $type = exif_imagetype($filepath); // [] if you don't have exif you could use getImageSize() 
    $allowedTypes = array( 
        1,  // [] gif 
        2,  // [] jpg 
        3,  // [] png 
        6   // [] bmp 
    ); 
    if (!in_array($type, $allowedTypes)) { 
        return false; 
    } 
    switch ($type) { 
        case 1 : 
            $im = imageCreateFromGif($filepath); 
        break; 
        case 2 : 
            $im = imageCreateFromJpeg($filepath); 
        break; 
        case 3 : 
            $im = imageCreateFromPng($filepath); 
        break; 
        case 6 : 
            $im = imageCreateFromBmp($filepath); 
        break; 
    }    
    return $im;  
}

// get average luminance, by sampling $num_samples times in both x,y directions
    function c5_get_avg_luminance($filename, $num_samples=10) {
    	if (!function_exists('exif_imagetype')) {
    		return 0;
    	}
    	$options = get_option('c5_images_luminance');
    	if (is_array($options)) {
    		if (isset($options[$filename])) {
    			return $options[$filename];
    		}
    	}else {
    		$options =array();
    	}

        $img = c5_imageCreateFromAny($filename);

        $width = imagesx($img);
        $height = imagesy($img);

        $x_step = intval($width/$num_samples);
        $y_step = intval($height/$num_samples);

        $total_lum = 0;

        $sample_no = 1;

        for ($x=0; $x<$width; $x+=$x_step) {
            for ($y=0; $y<$height; $y+=$y_step) {

                $rgb = imagecolorat($img, $x, $y);
                $lum = c5_get_lum($rgb);

                $total_lum += $lum;

                // debugging code
     //           echo "$sample_no - XY: $x,$y = $r, $g, $b = $lum<br />";
                $sample_no++;
            }
        }

        // work out the average
        $avg_lum  = round( $total_lum/$sample_no);
		
		
		$options[$filename] = $avg_lum;
		update_option('c5_images_luminance' , $options);
        return  $avg_lum;
    }
    function c5_get_lum_hex($color) {
    	$hex = str_replace('#', '', $color);
    	
    	if(strlen($hex) == 3) {
	      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
	      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
	      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
	   } else {
	      $r = hexdec(substr($hex,0,2));
	      $g = hexdec(substr($hex,2,2));
	      $b = hexdec(substr($hex,4,2));
	   }
    	$lum = round( ($r+$r+$b+$g+$g+$g)/6 );
    	return $lum;
    }
    function c5_get_lum($color) {
    	// choose a simple luminance formula from here
    	// http://stackoverflow.com/questions/596216/formula-to-determine-brightness-of-rgb-color
    	$r = ($color >> 16) & 0xFF;
        $g = ($color >> 8) & 0xFF;
        $b = $color & 0xFF;

        // choose a simple luminance formula from here
        // http://stackoverflow.com/questions/596216/formula-to-determine-brightness-of-rgb-color
        $lum = round( ($r+$r+$b+$g+$g+$g)/6 );
        return $lum;
    }
function my_login_logo() { ?>
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/img/logo-patasbox-login.svg);
            padding-bottom: 30px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );


add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

/* Placeholder campos Checkout */
function custom_override_checkout_fields( $fields ) {
     $fields['billing']['billing_first_name']['placeholder'] = 'Nombre';
     $fields['billing']['billing_last_name']['placeholder'] = 'Apellidos';
     $fields['billing']['billing_company']['placeholder'] = 'Nombre de la Empresa';
     $fields['billing']['billing_state']['placeholder'] = 'Provincia';
     $fields['billing']['billing_email']['placeholder'] = 'Dirección de email';
     $fields['billing']['billing_phone']['placeholder'] = 'Teléfono';

     $fields['shipping']['shipping_first_name']['placeholder'] = 'Nombre';
     $fields['shipping']['shipping_last_name']['placeholder'] = 'Apellidos';
     $fields['shipping']['shipping_company']['placeholder'] = 'Nombre de la Empresa';
     $fields['shipping']['shipping_state']['placeholder'] = 'Provincia';     
     return $fields;
}
/* Fin Placeholder campos Checkout */

/* Gracias por tu compra personalizada */

add_action( 'template_redirect', 'wc_custom_redirect_after_purchase' );
	function wc_custom_redirect_after_purchase() {
		global $wp;
		if ( is_checkout() && ! empty( $wp->query_vars['order-received'] ) ) {
		$order_id = absint( $wp->query_vars['order-received'] );
		$order_key = wc_clean( $_GET['key'] );
		$redirect = get_permalink(1689);
		$redirect .= get_option( 'permalink_structure' ) === '' ? '&' : '?';
		$redirect .= 'order=' . $order_id . '&key=' . $order_key;
		wp_redirect( $redirect );
		exit;
	}
} 

add_filter( 'the_content', 'wc_custom_thankyou' );
function wc_custom_thankyou( $content ) {
// Check if is the correct page
if ( ! is_page(1689) ) {
return $content;
}
// check if the order ID exists
if ( ! isset( $_GET['key'] ) || ! isset( $_GET['order'] ) ) {
return $content;
}
$order_id = apply_filters( 'woocommerce_thankyou_order_id', absint( $_GET['order'] ) );
$order_key = apply_filters( 'woocommerce_thankyou_order_key', empty( $_GET['key'] ) ? '' : wc_clean( $_GET['key'] ) );
$order = wc_get_order( $order_id );
if ( $order->id != $order_id || $order->order_key != $order_key ) {
return $content;
}
ob_start();
// Check that the order is valid
if ( ! $order ) {
// The order can't be returned by WooCommerce - Just say thank you
?><p><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'woocommerce' ), null ); ?></p><?php
} else {
if ( $order->has_status( 'failed' ) ) {
// Order failed - Print error messages and ask to pay again
/**
* @hooked wc_custom_thankyou_failed - 10
*/
do_action( 'wc_custom_thankyou_failed', $order );
} else {
// The order is successfull - print the complete order review
/**
* @hooked wc_custom_thankyou_header - 10
* @hooked wc_custom_thankyou_table - 20
* @hooked wc_custom_thankyou_customer_details - 30
*/
do_action( 'wc_custom_thankyou_successful', $order );
}
}
$content .= ob_get_contents();
ob_end_clean();
return $content;
} 

add_action( 'wc_custom_thankyou_failed', 'wc_custom_thankyou_failed', 10 );
function wc_custom_thankyou_failed( $order ) {
	wc_get_template( 'custom-thankyou/failed.php', array( 'order' => $order ) );
}

add_action( 'wc_custom_thankyou_successful', 'wc_custom_thankyou_header', 10 );
function wc_custom_thankyou_header( $order ) {
	wc_get_template( 'custom-thankyou/header.php', array( 'order' => $order ) );
}

add_action( 'wc_custom_thankyou_successful', 'wc_custom_thankyou_table', 20 );
function wc_custom_thankyou_table( $order ) {
	wc_get_template( 'custom-thankyou/table.php', array( 'order' => $order ) );
}

add_action( 'wc_custom_thankyou_successful', 'wc_custom_thankyou_customer_details', 30 );
function wc_custom_thankyou_customer_details( $order ) {
	wc_get_template( 'custom-thankyou/customer-details.php', array( 'order' => $order ) );
}

/* Fin Gracias por tu compra personalizada */

/* Redirección de registro por defecto de WP */
add_action( 'login_form_register', 'wpse45134_catch_register' );
function wpse45134_catch_register()
{
    wp_redirect( home_url( '/registro' ) );
    exit();
}

function wc_csv_export_remove_column( $column_headers ) {
	unset( $column_headers['item_sku']);
	unset( $column_headers['status']);
	unset( $column_headers['order_total']);
	unset( $column_headers['shipping_method']);
	
	unset( $column_headers['billing_first_name']);
	unset( $column_headers['billing_last_name']);
	unset( $column_headers['billing_company']);
	unset( $column_headers['billing_address_1']);
	unset( $column_headers['billing_address_2']);
	unset( $column_headers['billing_postcode']);
	unset( $column_headers['billing_city']);
	unset( $column_headers['billing_state']);

	unset( $column_headers['billing_country']);
	unset( $column_headers['item_tax']);
	unset( $column_headers['item_total']);
	unset( $column_headers['item_refunded']);
	unset( $column_headers['shipping_items']);

	unset( $column_headers['fee_items']);
	unset( $column_headers['tax_items']);
	unset( $column_headers['coupon_items']);
	unset( $column_headers['shipping_items']);
			
	unset( $column_headers['shipping_total']);
	unset( $column_headers['shipping_tax_total']);
	unset( $column_headers['fee_total']);
	unset( $column_headers['fee_tax_total']);
	unset( $column_headers['tax_total']);
	unset( $column_headers['cart_discount']);
	unset( $column_headers['order_discount']);
	unset( $column_headers['discount_total']);
	unset( $column_headers['refunded_total']);
	unset( $column_headers['order_currency']);
	unset( $column_headers['payment_method']);
	unset( $column_headers['customer_id']);
	unset( $column_headers['order_notes']);
	unset( $column_headers['download_permissions']);
	unset( $column_headers['item_name']);
	
	unset( $column_headers['customer_note']);
		
	return $column_headers;
}
add_filter( 'wc_customer_order_csv_export_order_headers', 'wc_csv_export_remove_column' );

function wc_csv_export_rename_column( $column_headers ) {
	$column_headers['order_id'] = 'Numero pedido';
	$column_headers['order_date'] = 'Fecha';
	$column_headers['shipping_first_name'] = 'Cliente';
	$column_headers['shipping_last_name'] = 'Cliente Apellido';
	$column_headers['shipping_address_1'] = 'Dirección';
	$column_headers['shipping_address_2'] = 'Dirección continuación';
	$column_headers['shipping_postcode'] = 'Código Postal';
	$column_headers['shipping_city'] = 'Población';
	$column_headers['shipping_state'] = 'País';
	$column_headers['shipping_company'] = 'Compañía';
	$column_headers['customer_note'] = 'Comentarios';
	$column_headers['shipping_state'] = 'Provincia';
	$column_headers['shipping_country'] = 'Pais';
	$column_headers['item_quantity'] = 'Unidades';
	$column_headers['item_meta'] = 'Suscripción';
	$column_headers['tracking_provider'] = 'Servicio';
	$column_headers['billing_email'] = 'Email';
	$column_headers['date_shipped'] = 'Fecha envío';

	$column_headers['admin_custom_order_field:sku_2'] = 'SKU';
		
	return $column_headers;
}
add_filter( 'wc_customer_order_csv_export_order_headers', 'wc_csv_export_rename_column' );

add_action('pre_get_posts','shop_filter_cat');

 function shop_filter_cat($query) {
    if (!is_admin() && is_post_type_archive( 'product' ) && $query->is_main_query()) {
       $query->set('tax_query', array(
                    array ('taxonomy' => 'product_cat',
                                       'field' => 'slug',
                                        'terms' => 'planes',
										'operator'  => 'NOT IN'
                                 )
                     )
       );   
    }
 }
 
 remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
 remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
 function wc_remove_related_products( $args ) {
	return array();
}
add_filter('woocommerce_related_products_args','wc_remove_related_products', 10);

add_action( 'woocommerce_archive_description', 'woocommerce_category_image', 2 );
function woocommerce_category_image() {
    if ( is_product_category() ){
	    global $wp_query;
	    $cat = $wp_query->get_queried_object();
	    $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
	    $image = wp_get_attachment_url( $thumbnail_id );
	    if ( $image ) {
		    echo '<img src="' . $image . '" alt="" />';
		}
	}
}

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );

add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 25 );

function remove_loop_button(){
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
}
add_action('init','remove_loop_button');
 
 

?>