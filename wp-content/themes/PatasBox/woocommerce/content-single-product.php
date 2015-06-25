<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>

<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="row">
	<?php
		/**
		 * woocommerce_before_single_product_summary hook
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action( 'woocommerce_before_single_product_summary' );
	?>
    
 
	<div class="summary entry-summary">
    <h3><?php echo str_replace(' | ', '<br />', get_the_title()); ?></h3>

		<?php
			/**
			 * woocommerce_single_product_summary hook
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 */
			do_action( 'woocommerce_single_product_summary' );
		?>

	</div><!-- .summary -->
    <?php   if (  is_product() ) : ?>
        <div id="sharing_product">
<?php echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );	?>

<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
<ul>
<li>
<a href="http://twitter.com/share?url=<?php echo get_permalink() ?>&text=<?php echo str_replace(' | ', '', get_the_title()); ?>&via=patasbox" target="_blank" class="share-btn twitter">
    <i class="fa fa-twitter"></i>
</a>
</li>
<li>
<!-- Google Plus -->
<a href="https://plus.google.com/share?url=<?php echo get_permalink() ?>" target="_blank" class="share-btn google-plus">
    <i class="fa fa-google-plus"></i>
</a>
</li>
<li>
<!-- Facebook -->
<a href="http://www.facebook.com/sharer/sharer.php?u=<URL>" target="_blank" class="share-btn facebook">
    <i class="fa fa-facebook"></i>
</a>
</li>
<li>
<a href="https://www.pinterest.com/pin/create/button/?url=<?php echo get_permalink() ?>" target="_blank" class="share-btn pinterest">
    <i class="fa fa-pinterest"></i>
</a>
</li>
</ul>
</div>
<?php endif ?>
	</div>
	<?php
		/**
		 * woocommerce_after_single_product_summary hook
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );
	?>

	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->



<?php do_action( 'woocommerce_after_single_product' ); ?>
