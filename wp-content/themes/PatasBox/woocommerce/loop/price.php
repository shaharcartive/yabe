<?php
/**
 * Loop Price
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;
?>

<?php if ( $price_html = $product->get_price_html() ) : ?>

<?php  if ($product->is_in_stock()) : ?>
	<span class="price"><?php echo $price_html; ?></span>
    <?php else: ?> 
    <span class="price-out-of-stock">Fuera de stock</span>
<?php endif; endif; ?>