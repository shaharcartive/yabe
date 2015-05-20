<?php 

//test
add_filter( 'woocommerce_show_page_title', '__return_false' );


if ( version_compare( WOOCOMMERCE_VERSION, "2.1" ) >= 0 ) {
	add_filter( 'woocommerce_enqueue_styles', '__return_false' );
} else {
	define( 'WOOCOMMERCE_USE_CSS', false );
}

add_action( 'wp_enqueue_scripts', 'c5_wo_remove_woo_lightbox', 99 );
function c5_wo_remove_woo_lightbox() {
	remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );
	wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
	wp_dequeue_script( 'prettyPhoto' );
	wp_dequeue_script( 'prettyPhoto-init' );
}


function c5_wc_get_current_page() {
	if( is_shop() ){
		return wc_get_page_id( 'shop' );
	}
	
	elseif ( is_cart() ) {
		return wc_get_page_id( 'cart' ) ;
	}
	
	elseif ( is_checkout() ) {
		return wc_get_page_id( 'checkout' ) ;
	}
	
	elseif ( is_account_page() ) {
		return wc_get_page_id( 'myaccount' ) ;
	}
	
	elseif ( is_order_received_page() ) {
		return wc_get_page_id( 'checkout' ) ;
	}
	
	elseif ( is_add_payment_method_page() ) {
		return wc_get_page_id( 'myaccount' ) ;
	}
	return false;
}

add_action('woocommerce_before_shop_loop_item_title', 'c5_woocommerce_thumbnail', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

function c5_wc_in_cart($id) {
	global $product, $woocommerce;
	
	$items_in_cart = array();

	if($woocommerce->cart->get_cart() && is_array($woocommerce->cart->get_cart())) {
		foreach($woocommerce->cart->get_cart() as $cart) {
			if($id == $cart['product_id'] ){
				return true;
			}
		}
	}
	return false;
}

function c5_woocommerce_thumbnail() {
	global $product, $woocommerce;

	$items_in_cart = array();

	if($woocommerce->cart->get_cart() && is_array($woocommerce->cart->get_cart())) {
		foreach($woocommerce->cart->get_cart() as $cart) {
			$items_in_cart[] = $cart['product_id'];
		}
	}

	$id = get_the_ID();
	$in_cart = in_array($id, $items_in_cart);
	$size = 'shop_catalog';

	$gallery = get_post_meta($id, '_product_image_gallery', true);
	$attachment_image = '';
	if(!empty($gallery)) {
		$gallery = explode(',', $gallery);
		$first_image_id = $gallery[0];
		$attachment_image = wp_get_attachment_image($first_image_id , $size, false, array('class' => 'hover-image'));
	}
	$thumb_image = get_the_post_thumbnail($id , $size);

	if($attachment_image) {
		$classes = 'crossfade-images';
	} else {
		$classes = '';
	}

	echo '<span class="'.$classes.'">';
	echo $attachment_image;
	echo $thumb_image;
	if($in_cart) {
		echo '<span class="cart-loading"><i class="fa fa-check"></i></span>';
	} else {
		echo '<span class="cart-loading"><i class="fa fa-spin fa-spinner"></i></span>';
	}
	echo '</span>';
}


 ?>