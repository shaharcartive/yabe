<?php

/**
 * Class FUE_Addon_Woocommerce_Conditions
 */
class FUE_Addon_Woocommerce_Conditions {

    /**
     * @var FUE_Addon_Woocommerce
     */
    private $fue_wc;

    /**
     * Class constructor
     *
     * @param FUE_Addon_Woocommerce $wc
     */
    public function __construct( $wc ) {
        $this->fue_wc = $wc;
    }

    /**
     * Get WC-related conditions
     * @return array
     */
    public function get_conditions() {
        $conditions = array();

        $conditions['bought_products']      = __('customer bought these products', 'follow_up_emails');
        $conditions['bought_categories']    = __('customer bought from these categories', 'follow_up_emails');

        $conditions['first_purchase']       = __('on first purchase', 'follow_up_emails');
        $conditions['order_total_above']    = __('order total above:', 'follow_up_emails');
        $conditions['order_total_below']    = __('order total below:', 'follow_up_emails');

        $conditions['total_orders_above']   = __('total orders by customer above:', 'follow_up_emails');
        $conditions['total_orders_below']   = __('total orders by customer below:', 'follow_up_emails');
        $conditions['total_purchases_above']= __('total purchase amount by customer above:', 'follow_up_emails');
        $conditions['total_purchases_below']= __('total purchase amount by customer below:', 'follow_up_emails');

        return $conditions;
    }

    /**
     * Test if $item passes the requirements in $condition
     * @param array $condition
     * @param FUE_Sending_Queue_Item $item
     * @return bool|WP_Error
     */
    public function test_condition( $condition, $item ) {

        switch ( $condition['condition'] ) {

            case 'first_purchase':
                $result = $this->test_first_purchase_condition( $item );
                break;

            case 'bought_products':
                $result = $this->test_bought_products_condition( $item, $condition );
                break;

            case 'bought_categories':
                $result = $this->test_bought_categories_condition( $item, $condition );
                break;

            case 'order_total_above':
            case 'order_total_below':
                $result = $this->test_order_total_condition( $item, $condition );
                break;

            case 'total_orders_above':
            case 'total_orders_below':
                $result = $this->test_total_orders_count_condition( $item, $condition );
                break;

            case 'total_purchases_above':
            case 'total_purchases_below':
                $result = $this->test_total_purchases_condition( $item, $condition );
                break;

            default:
                return new WP_Error( 'fue_email_conditions', sprintf( __('Unknown condition: %s', 'follow_up_emails'), $condition['condition'] ) );
                break;

        }

        return $result;

    }

    /**
     * Test will pass if the customer is buying from the store (all or a specific product) for the first time.
     *
     * If a `product_id` property is present, this test will pass if that product is being
     * purchased for the first time. It will fail otherwise.
     *
     * @param FUE_Sending_Queue_Item $item
     * @return bool|WP_Error
     */
    public function test_first_purchase_condition( $item ) {
        $customer = fue_get_customer_from_order( $item->order_id );

        if ( !$customer ) {
            return new WP_Error(
                'fue_email_conditions',
                sprintf( __('Customer data could not be found (Order #%d)', 'follow_up_emails'), $item->order_id )
            );
        }

        if ( empty( $item->product_id ) ) {
            $count = $this->fue_wc->count_customer_purchases( $customer->id, $item->product_id );
        } else {
            $count = $this->fue_wc->count_customer_purchases( $customer->id );
        }

        if ( $count != 1 ) {
            return new WP_Error(
                'fue_email_conditions',
                sprintf( __('first_purchase condition failed for queue #%d (purchases: %d)', 'follow_up_emails'), $item->id, $count )
            );
        }

        return true;

    }

    /**
     * Test will pass if the customer has bought all of the products
     * specified in the condition
     *
     * @param FUE_Sending_Queue_Item $item
     * @param array $condition
     * @return bool|WP_Error
     */
    public function test_bought_products_condition( $item, $condition ) {
        $wpdb       = Follow_Up_Emails::instance()->wpdb;
        $products   = array_filter( array_map( 'absint', explode(',', $condition['products'] ) ) );
        $customer   = fue_get_customer_from_order( $item->order_id );
        $result     = true;

        if ( !$customer ) {
            return new WP_Error(
                'fue_email_conditions',
                sprintf( __('Customer data could not be found (Order #%d)', 'follow_up_emails'), $item->order_id )
            );
        }

        if ( !empty( $products ) ) {

            foreach ( $products as $product ) {

                if ( !$this->fue_wc->customer_purchased_product( $customer, $product ) ) {
                    // no purchases found for this product
                    $wc_product = WC_FUE_Compatibility::wc_get_product( $product );

                    return new WP_Error(
                        'fue_email_conditions',
                        sprintf(
                            __('Customer has not purchased a required product (#%d - %s)', 'follow_up_emails'),
                            $product,
                            $wc_product->get_formatted_name()
                        )
                    );
                }

            }

        }

        return true;
    }

    /**
     * Test will pass if the customer has bought from all of the categories specified
     *
     * @param $item
     * @param $condition
     * @return bool|WP_Error
     */
    public function test_bought_categories_condition( $item, $condition ) {
        $wpdb       = Follow_Up_Emails::instance()->wpdb;
        $categories = array_filter( array_map( 'absint', $condition['categories'] ) );
        $customer   = fue_get_customer_from_order( $item->order_id );
        $result     = true;

        if ( !$customer ) {
            return new WP_Error(
                'fue_email_conditions',
                sprintf( __('Customer data could not be found (Order #%d)', 'follow_up_emails'), $item->order_id )
            );
        }

        if ( !empty( $categories ) ) {

            foreach ( $categories as $category ) {

                if ( !$this->fue_wc->customer_purchased_from_category( $customer, $category ) ) {
                    // no purchases found for this product
                    $wc_category = get_term( $category, 'product_cat' );

                    return new WP_Error(
                        'fue_email_conditions',
                        sprintf(
                            __('Customer has not purchased from a required category (%s)', 'follow_up_emails'),
                            $wc_category->name
                        )
                    );
                }

            }

        }

        return true;
    }

    /**
     * Test will pass if the order's total amount is above/below the specified value
     *
     * @param FUE_Sending_Queue_Item $item
     * @param array $condition
     * @return bool|WP_Error
     */
    public function test_order_total_condition( $item, $condition ) {
        $order  = WC_FUE_Compatibility::wc_get_order( $item->order_id );
        $total  = $order->get_total();
        $value  = floatval( $condition['value'] );

        if ( $condition['condition'] == 'order_total_above' ) {
            $result = $total > $value;
        } else {
            $result = $total < $value;
        }

        if ( !$result ) {
            return new WP_Error(
                'fue_email_conditions',
                sprintf(
                    __('Condition "%s" failed. Order total: %s / Condition value: %s', 'follow_up_emails'),
                    $condition['condition'],
                    $total,
                    $value
                )
            );
        }

        return $result;
    }

    /**
     * Test will pass if the customer's number of orders is above/below the specified value
     *
     * @param FUE_Sending_Queue_Item $item
     * @param array $condition
     * @return bool|WP_Error
     */
    public function test_total_orders_count_condition( $item, $condition ) {
        $customer = fue_get_customer_from_order( $item->order_id );

        if ( !$customer ) {
            return new WP_Error(
                'fue_email_conditions',
                sprintf( __('Customer data could not be found (Order #%d)', 'follow_up_emails'), $item->order_id )
            );
        }

        $total  = $customer->total_orders;
        $value  = floatval( $condition['value'] );

        if ( $condition['condition'] == 'total_orders_above' ) {
            $result = $total > $value;
        } else {
            $result = $total < $value;
        }

        if ( !$result ) {
            return new WP_Error(
                'fue_email_conditions',
                sprintf(
                    __('Condition "%s" failed. Orders: %s / Condition value: %s', 'follow_up_emails'),
                    $condition['condition'],
                    $total,
                    $value
                )
            );
        }

        return $result;
    }

    /**
     * Test will pass if the total purchase amount of a customer is above/below the specified value
     *
     * @param FUE_Sending_Queue_Item $item
     * @param array $condition
     * @return bool|WP_Error
     */
    public function test_total_purchases_condition( $item, $condition ) {
        $customer = fue_get_customer_from_order( $item->order_id );

        if ( !$customer ) {
            return new WP_Error(
                'fue_email_conditions',
                sprintf( __('Customer data could not be found (Order #%d)', 'follow_up_emails'), $item->order_id )
            );
        }

        $total  = $customer->total_purchase_price;
        $value  = floatval( $condition['value'] );

        if ( $condition['condition'] == 'total_purchases_above' ) {
            $result = $total > $value;
        } else {
            $result = $total < $value;
        }

        if ( !$result ) {
            return new WP_Error(
                'fue_email_conditions',
                sprintf(
                    __('Condition "%s" failed. Total Purchases: %s / Condition value: %s', 'follow_up_emails'),
                    $condition['condition'],
                    $total,
                    $value
                )
            );
        }

        return $result;
    }

    /**
     * Checks if an order matches the given email's conditions in terms of status change.
     *
     * It will not exactly match the order's status history, instead it will check if an
     * order's status is different from the email trigger and match the order status to
     * a status condition
     *
     * @param WC_Order  $order
     * @param FUE_Email $email
     * @return bool
     */
    public static function order_matches_status_condition( $order, $email ) {
        $status = WC_FUE_Compatibility::get_order_status( $order );

        if ( $status == $email->trigger ) {
            return false;
        }

        $conditions = $email->conditions;

        foreach ( $conditions as $condition ) {
            if ( $condition['condition'] == $status ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if there is a match in the order's status and the email's trigger
     *
     * @param int|WC_Order  $order
     * @param int|FUE_Email $email
     * @return bool
     */
    private function order_status_matches_email_trigger( $order, $email ) {
        if ( is_numeric( $order ) ) {
            $order = WC_FUE_Compatibility::wc_get_order( $order );
        }

        if ( is_numeric( $email ) ) {
            $email = new FUE_Email( $email );
        }

        return WC_FUE_Compatibility::get_order_status( $order ) == $email->trigger;
    }

}