<?php
/**
 * Edit address form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $current_user;
$page_title = ( $load_address === 'billing' ) ? __( 'Billing Address', 'woocommerce' ) : __( 'Shipping Address', 'woocommerce' );
get_currentuserinfo();
?>

<?php wc_print_notices(); ?>

<?php if ( is_user_logged_in() ) { ?>
 	<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('Mi Cuenta','woothemes'); ?>">
 	<i class="fa fa-arrow-left"></i> Volver a mi cuenta</a>
 <?php } 
 else { ?>
 	<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('Login / Register','woothemes'); ?>"><?php _e('Login / Register','woothemes'); ?></a>
 <?php } ?>
 
<?php if ( ! $load_address ) : ?>
	<?php wc_get_template( 'myaccount/my-address.php' ); ?>
<?php else : ?>

	<form class="edit-account" method="post">
		<h2 class="title-line"><span><?php echo apply_filters( 'woocommerce_my_account_edit_address_title', $page_title ); ?></span></h3>

		<?php foreach ( $address as $key => $field ) : ?>
			<?php woocommerce_form_field( $key, $field, ! empty( $_POST[ $key ] ) ? wc_clean( $_POST[ $key ] ) : $field['value'] ); ?>
		<?php endforeach; ?>
		<p>
			<input type="submit" class="button" name="save_address" value="<?php _e( 'Save Address', 'woocommerce' ); ?>" />
			<?php wp_nonce_field( 'woocommerce-edit_address' ); ?>
			<input type="hidden" name="action" value="edit_address" />
		</p>
	</form>

<?php endif; ?>