<?php
/**
 * Admin new order email
 */
$order = new WC_order( $item_data->order_id );

echo "= " . $email_heading . " =\n\n";

$opening_paragraph = __( 'A new order has been made by %s. The details of the item are as follows:', 'custom-email' );

$billing_first_name = ( version_compare( WOOCOMMERCE_VERSION, "3.0.0" ) < 0 ) ? $order->billing_first_name : $order->get_billing_first_name();
$billing_last_name = ( version_compare( WOOCOMMERCE_VERSION, "3.0.0" ) < 0 ) ? $order->billing_last_name : $order->get_billing_last_name(); 
if ( $order && $billing_first_name && $billing_last_name ) {
	echo sprintf( $opening_paragraph, $billing_first_name . ' ' . $billing_last_name ) . "\n\n";
}

echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

echo sprintf( __( 'Ordered Product: %s', 'custom-email' ), $item_data->product_title ) . "\n";

echo sprintf( __( 'Quantity: %s', 'custom-email' ), $item_data->qty ) . "\n";

echo sprintf( __( 'Total: %s', 'custom-email' ), $item_data->total ) . "\n";

echo "\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

echo __( 'This is a custom email sent as the order status has been changed to Pending Payment.', 'custom-email' ) . "\n\n";

echo apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) );
