<?php
/**
 * Single Product Price, including microdata for SEO
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product;
?>
<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">



<?php  if ($product->is_in_stock()) : ?>
	<p class="price"><?php echo $product->get_price_html(); ?></p>
    <?php else: ?> 
    <p class="price-out-of-stock">Fuera de stock</p>
<?php endif;  ?>

	

	<meta itemprop="price" content="<?php echo $product->get_price(); ?>" />
	<meta itemprop="priceCurrency" content="<?php echo get_woocommerce_currency(); ?>" />
	<link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />

</div>