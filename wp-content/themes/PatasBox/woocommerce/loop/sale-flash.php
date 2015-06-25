<?php
/**
 * Product loop sale flash
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product;
$tags = get_the_terms( $post->ID, 'product_tag' );
?>


<?php if ( $product->is_on_sale() ) : ?>

	<?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . __( 'Sale!', 'woocommerce' ) . '</span>', $post, $product ); ?>

<?php endif; ?>

<?php // if ($tag->name == 'En Exclusiva para PatasBox')  :  ?>



<?php // endif; ?>