<?php
/**
 * Single product short description
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product;

$cat_count = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
$tag_count = sizeof( get_the_terms( $post->ID, 'product_tag' ) );



if ( ! $post->post_excerpt ) return;
?>
<div class="c5-shop-hr"></div>




<?php
$tags = get_the_terms( $post->ID, 'product_tag' );


foreach ( $tags as $tag ) {
   $html = '<h2 class="text-center title-line wow fadeInDown animated animated animated tag"><span class="tagged_as">';
    $html .= "{$tag->name} ";
	$html .= '</span></h2>';
}

echo $html;
?>
<div itemprop="description" class="shopdesc">
	<?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ) ?>
</div>