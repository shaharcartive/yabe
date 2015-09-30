<?php
/**
 * WooCommerce Points and Rewards
 *
 * @package     WC-Points-Rewards/Classes
 * @author      WooThemes
 * @copyright   Copyright (c) 2013, WooThemes
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Cart / Checkout class
 *
 * Adds earn/redeem messages to the cart / checkout page and calculates the discounts available
 *
 * @since 1.0
 */
 
class WC_Points_Rewards_Cart_Checkout {

	/**
	 * Add cart/checkout related hooks / filters
	 *
	 * @since 1.0
	 */
	 			
	public function __construct() {
		
		// Coupon display
		add_filter( 'woocommerce_cart_totals_coupon_label', array( $this, 'coupon_label' ) );
		
		// Coupon loading
		add_action( 'woocommerce_cart_loaded_from_session', array( $this, 'points_last' ) );
		add_action( 'woocommerce_applied_coupon', array( $this, 'points_last' ) );

		// add earn points/redeem points message above cart / checkout

		add_action( 'woocommerce_before_cart', array( $this, 'render_earn_points_message' ), 15 );
		add_action( 'woocommerce_before_cart', array( $this, 'render_redeem_points_message' ), 16 );
    	add_action( 'woocommerce_before_checkout_form', array( $this, 'render_earn_points_message' ), 5 );
		add_action( 'woocommerce_before_checkout_form', array( $this, 'render_redeem_points_message' ), 6 );

		// handle the apply discount submit on the cart page
		add_action( 'wp', array( $this, 'maybe_apply_discount' ) );

		// handle the apply discount AJAX submit on the checkout page
		add_action( 'wp_ajax_wc_points_rewards_apply_discount', array( $this, 'ajax_maybe_apply_discount' ) );

	}

	/**
	 * Make the label for the coupon look nicer
	 * @param  string $label
	 * @return string
	 */
	public function coupon_label( $label ) {
		if ( strstr( strtoupper( $label ), 'WC_POINTS_REDEMPTION' ) ) {
			$label = esc_html( __( 'Points redemption', 'woocommerce-points-and-rewards' ) );
		}

		return $label;
	}

	/**
	 * Ensure points are applied before tax, last
	 */
	public function points_last() {
		$ordered_coupons = array();
		$points = array();

		foreach ( WC()->cart->get_applied_coupons() as $code ) {
			if ( strstr( $code, 'wc_points_redemption_' ) ) {
				$points[] = $code;
			} else {
				$ordered_coupons[] = $code;
			}
		}

		WC()->cart->applied_coupons = array_merge( $ordered_coupons, $points );
	}


	/**
	 * Redeem the available points by generating and applying a discount code on the cart page
	 *
	 * @since 1.0
	 */
	public function maybe_apply_discount() {
		// only apply on cart and from apply discount action
		if ( ! is_cart() || ! isset( $_POST['wc_points_rewards_apply_discount'] ) ) {
			return;
		}

		// bail if the discount has already been applied
		if ( WC()->cart->has_discount( WC_Points_Rewards_Discount::get_discount_code() ) ) {
			return;
		}

		// Get discount amount if set and store in session
		WC()->session->set( 'wc_points_rewards_discount_amount', ( ! empty( $_POST['wc_points_rewards_apply_discount_amount'] ) ? absint( $_POST['wc_points_rewards_apply_discount_amount'] ) : '' ) );

		// generate and set unique discount code
		$discount_code = WC_Points_Rewards_Discount::generate_discount_code();

		// apply the discount
		WC()->cart->add_discount( $discount_code );
	}


	/**
	 * Redeem the available points by generating and applying a discount code via AJAX on the checkout page
	 *
	 * @since 1.0
	 */
	public function ajax_maybe_apply_discount() {
		check_ajax_referer( 'apply-coupon', 'security' );

		// bail if the discount has already been applied
		if ( WC()->cart->has_discount( WC_Points_Rewards_Discount::get_discount_code() ) ) {
			die;
		}

		// Get discount amount if set and store in session
		WC()->session->set( 'wc_points_rewards_discount_amount', ( ! empty( $_POST['discount_amount'] ) ? absint( $_POST['discount_amount'] ) : '' ) );

		// generate and set unique discount code
		$discount_code = WC_Points_Rewards_Discount::generate_discount_code();

		// apply the discount
		WC()->cart->add_discount( $discount_code );

		wc_print_notices();
		die;
	}


	/**
	 * Renders a message above the cart displaying how many points the customer will receive for completing their purchase
	 *
	 * @since 1.0
	 */
	public function render_earn_points_message() {

		global $wc_points_rewards;

		// get the total points earned for this purchase
		$points_earned = $this->get_points_earned_for_purchase();

		$message = get_option( 'wc_points_rewards_earn_points_message' );

		// bail if no message set or no points will be earned for purchase
		if ( ! $message || ! $points_earned )
			return;

		// points earned
		$message = str_replace( '{points}', number_format_i18n( $points_earned ), $message );

		// points label
		$message = str_replace( '{points_label}', $wc_points_rewards->get_points_label( $points_earned ), $message );

		// wrap with info div
		$message = '<div class="woocommerce-info wc_points_rewards_earn_points">' . $message . '</div>';

		echo apply_filters ( 'wc_points_rewards_earn_points_message', $message, $points_earned );
	}


	/**
	 * Renders a message and button above the cart displaying the points available to redeem for a discount
	 *
	 * @since 1.0
	 */
	public function render_redeem_points_message() {
		global $wc_points_rewards;
	$points_balance = WC_Points_Rewards_Manager::get_users_points( get_current_user_id() );
	$cluster = get_option( 'wc_points_rewards_cluster' );
	$minimum = get_option( 'wc_points_rewards_minimum' );
	
		// don't display a message if coupons are disabled or points have already been applied for a discount
		if ( WC()->cart->total<$minimum || $points_balance<$cluster || ! WC()->cart->coupons_enabled() || WC()->cart->has_discount( WC_Points_Rewards_Discount::get_discount_code() ) ) {
			return;
		}

		// get the total discount available for redeeming points
		$discount_available = $this->get_discount_for_redeeming_points();

		$message = get_option( 'wc_points_rewards_redeem_points_message' );
		

		// bail if no message set or no points will be earned for purchase
		if ( ! $message || ! $discount_available ) {
			return;
		}
		
		$ratio= get_option( 'wc_points_rewards_redeem_points_ratio');
        $ratio = str_replace("1:", "", $ratio);
        $poinst_selected_post = $_POST['pointsselect'];
		
		if ($poinst_selected_post == null) { 
		
 $poinst_selected_post = $cluster;	
 
 }
		$actualdiscount = $ratio * $poinst_selected_post . get_woocommerce_currency_symbol();
		

		// points required to redeem for the discount available
		$points  = WC_Points_Rewards_Manager::calculate_points_for_discount( $discount_available );
	    $message = str_replace( '{points}', $poinst_selected_post, $message );

		// the maximum discount available given how many points the customer has
		$message = str_replace( '{points_value}', $actualdiscount, $message );

		// points label
		$message = str_replace( '{points_label}', $wc_points_rewards->get_points_label( $points ), $message );
		
		
		// add 'Apply Discount' button
		
		$message .= '<form class="wc_points_rewards_apply_discount" action="' . esc_url( WC()->cart->get_cart_url() ) . '" method="post">';
		$message .=  '<select name="pointsselect" onchange="this.form.submit();">';
		$x = $points;
			$y = $x / $cluster; 
			$z = 1;
			
			while($z <= $y) {
				
				 if ($z*$cluster == $poinst_selected_post ) {
    $message .= "<option selected value='". $z*$cluster . "'>Usa " . $z*$cluster . " Patascoins</option>"; 
	 $z++;
} else {
    $message .= "<option value='". $z*$cluster . "'>Usa " . $z*$cluster . " Patascoins</option>"; 
	 $z++;
}
   
} 
 $message .=  "</select>";
		$message .= '<input type="hidden" name="wc_points_rewards_apply_discount_amount" class="wc_points_rewards_apply_discount_amount" />';
		$message .= '<input type="submit" class="button wc_points_rewards_apply_discount" name="wc_points_rewards_apply_discount" value="' . __( 'Apply Discount', 'woocommerce-points-and-rewards' ) . '" /></form>';
		
		// wrap with info div
		$message = '<div class="woocommerce-info wc_points_rewards_earn_points">' . $message . '</div>';

		echo apply_filters ( 'wc_points_rewards_redeem_points_message', $message, $discount_available );

		if ( 'yes' === get_option( 'wc_points_rewards_partial_redemption_enabled' ) ) {
			
			
 $poinst_selected = $_POST['pointsselect'];
  
 if ($poinst_selected == null) { 
 $poinst_selected = $cluster;	
 }
			// Add code to prompt for points amount
			wc_enqueue_js( '
				$( "input.wc_points_rewards_apply_discount" ).click( function() {
					var points = "' . $poinst_selected . '";
					if ( points != null ) {
						$( "input.wc_points_rewards_apply_discount_amount" ).val( points );
					}
					return true;
				});
			' );
		}

		// add AJAX submit for applying the discount on the checkout page
		if ( is_checkout() ) {
			wc_enqueue_js( '
			/* Points & Rewards AJAX Apply Points Discount */
			$( "form.wc_points_rewards_apply_discount" ).submit( function() {
				var $section = $( "div.wc_points_rewards_earn_points" );

				if ( $section.is( ".processing" ) ) return false;

				$section.addClass( "processing" ).block({message: null, overlayCSS: {background: "#fff url(" + woocommerce_params.ajax_loader_url + ") no-repeat center", backgroundSize: "16px 16px", opacity: 0.6}});

				var data = {
					action:    "wc_points_rewards_apply_discount",
					discount_amount: $("input.wc_points_rewards_apply_discount_amount").val(),
					security:  ( woocommerce_params.apply_coupon_nonce ? woocommerce_params.apply_coupon_nonce : wc_checkout_params.apply_coupon_nonce )
				};

				$.ajax({
					type:     "POST",
					url:      woocommerce_params.ajax_url,
					data:     data,
					success:  function( code ) {

						$( ".woocommerce-error, .woocommerce-message" ).remove();
						$section.removeClass( "processing" ).unblock();

						if ( code ) {
							$section.before( code );

							$section.remove();

							$( "body" ).trigger( "update_checkout" );
						}
					},
					dataType: "html"
				});
				return false;
			});
			' );
		}
	}


	/**
	 * Returns the amount of points earned for the purchase, calculated by getting the points earned for each individual
	 * product purchase multiplied by the quantity being ordered
	 *
	 * @since 1.0
	 */
	private function get_points_earned_for_purchase() {
		$points_earned = 0;

		foreach ( WC()->cart->get_cart() as $item_key => $item ) {
			$points_earned += apply_filters( 'woocommerce_points_earned_for_cart_item', WC_Points_Rewards_Product::get_points_earned_for_product_purchase( $item['data'] ), $item_key, $item ) * $item['quantity'];
		}

		// reduce by any discounts.  One minor drawback: if the discount includes a discount on tax and/or shipping
		//  it will cost the customer points, but this is a better solution than granting full points for discounted orders
		if ( version_compare( WC_VERSION, '2.3', '<' ) ) {
			$discount = WC()->cart->discount_cart + WC()->cart->discount_total;
		} else {
			$discount = WC()->cart->discount_cart;
		}

		$discount_amount = min( WC_Points_Rewards_Manager::calculate_points( $discount ), $points_earned );

		// apply a filter that will allow users to manipulate the way discounts affect points earned
		$points_earned = apply_filters( 'wc_points_rewards_discount_points_modifier', $points_earned - $discount_amount, $points_earned, $discount_amount );

		// check if applied coupons have a points modifier and use it to adjust the points earned
		$coupons = WC()->cart->get_applied_coupons();

		if ( ! empty( $coupons ) ) {

			$points_modifier = 0;

			// get the maximum points modifier if there are multiple coupons applied, each with their own modifier
			foreach ( $coupons as $coupon_code ) {

				$coupon = new WC_Coupon( $coupon_code );

				if ( ! empty( $coupon->coupon_custom_fields['_wc_points_modifier'][0] ) && $coupon->coupon_custom_fields['_wc_points_modifier'][0] > $points_modifier )
					$points_modifier = $coupon->coupon_custom_fields['_wc_points_modifier'][0];
			}

			if ( $points_modifier > 0 )
				$points_earned = round( $points_earned * ( $points_modifier / 100 ) );
		}

		return apply_filters( 'wc_points_rewards_points_earned_for_purchase', $points_earned, WC()->cart );
	}


	/**
	 * Returns the maximum possible discount available given the total amount of points the customer has
	 *
	 * @since 1.0
	 */
	public static function get_discount_for_redeeming_points( $applying = false ) {
		// get the value of the user's point balance
		$available_user_discount = WC_Points_Rewards_Manager::get_users_points_value( get_current_user_id() );

		// no discount
		if ( $available_user_discount <= 0 ) {
			return 0;
		}

		if ( $applying && 'yes' === get_option( 'wc_points_rewards_partial_redemption_enabled' ) && WC()->session->get( 'wc_points_rewards_discount_amount' ) ) {
			$requested_user_discount = WC_Points_Rewards_Manager::calculate_points_value( WC()->session->get( 'wc_points_rewards_discount_amount' ) );
			if ( $requested_user_discount > 0 && $requested_user_discount < $available_user_discount ) {
				$available_user_discount = $requested_user_discount;
			}
		}

		$discount_applied = 0;

		if ( ! did_action( 'woocommerce_before_calculate_totals' ) ) {
			WC()->cart->calculate_totals();
		}

		// calculate the discount to be applied by iterating through each item in the cart and calculating the individual
		// maximum discount available
		foreach ( WC()->cart->get_cart() as $item_key => $item ) {

			$discount     = 0;
			$max_discount = WC_Points_Rewards_Product::get_maximum_points_discount_for_product( $item['data'] );

			if ( is_numeric( $max_discount ) ) {

				// adjust the max discount by the quantity being ordered
				$max_discount *= $item['quantity'];

				// if the discount available is greater than the max discount, apply the max discount
				$discount = ( $available_user_discount <= $max_discount ) ? $available_user_discount : $max_discount;

			// Max should be product price. As this will be applied before tax, it will respect other coupons.
			} else {

				// Use the line price - this is the max we can apply here
				if ( method_exists( $item['data'], 'get_price_including_tax' ) ) {
					$max_discount = $item['data']->get_price_including_tax( $item['quantity'] );
				} else {
					$max_discount = $item['data']->get_price() * $item['quantity'];
				}

				// if the discount available is greater than the max discount, apply the max discount
				$discount = ( $available_user_discount <= $max_discount ) ? $available_user_discount : $max_discount;
			}

			// add the discount to the amount to be applied
			$discount_applied += $discount;

			// reduce the remaining discount available to be applied
			$available_user_discount -= $discount;
		}

		// if the available discount is greater than the order total, make the discount equal to the order total less any other discounts
		if ( version_compare( WC_VERSION, '2.3', '<' ) ) {
			if ( 'no' === get_option( 'woocommerce_prices_include_tax') ) {
				$discount_applied = max( 0, min( $discount_applied, WC()->cart->subtotal_ex_tax - WC()->cart->discount_total ) );

			} else {
				$discount_applied = max( 0, min( $discount_applied, WC()->cart->subtotal - WC()->cart->discount_total ) );

			}
		} else {
			if ( 'no' === get_option( 'woocommerce_prices_include_tax' ) ) {
				$discount_applied = max( 0, min( $discount_applied, WC()->cart->subtotal_ex_tax ) );

			} else {
				$discount_applied = max( 0, min( $discount_applied, WC()->cart->subtotal ) );

			}
		}

		// limit the discount available by the global maximum discount if set
		$max_discount = get_option( 'wc_points_rewards_cart_max_discount' );

		if ( false !== strpos( $max_discount, '%' ) )
			$max_discount = self::calculate_discount_modifier( $max_discount );

		if ( $max_discount && $max_discount < $discount_applied ) {
			$discount_applied = $max_discount;
		}

		return $discount_applied;
	}

	/**
	 * Calculate the maximum points discount when it's set to a percentage by multiplying the percentage times the cart's
	 * price
	 *
	 * @since 1.0
	 * @param string $percentage the percentage to multiply the price by
	 * @return float the maximum discount after adjusting for the percentage
	 */
	private static function calculate_discount_modifier( $percentage ) {

		$percentage = str_replace( '%', '', $percentage ) / 100;

		if ( 'no' === get_option( 'woocommerce_prices_include_tax') ) {
			$discount = WC()->cart->subtotal_ex_tax;

		} else {
			$discount = WC()->cart->subtotal;

		}

		return $percentage * $discount;
	}


} // end \WC_Points_Rewards_Cart_Checkout class
