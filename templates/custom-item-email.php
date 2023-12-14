<?php
/**
 * Admin new order email
 */
$order = wc_get_order( $item_data->order_id );
$opening_paragraph = __( 'A new order has been made by %s. The details of the item are as follows:', 'custom-email' );

?>

<?php do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php
$billing_first_name = $order->get_billing_first_name();
$billing_last_name  = $order->get_billing_last_name();
if ( $order && $billing_first_name && $billing_last_name ) : ?>
	<p><?php printf( $opening_paragraph, $billing_first_name . ' ' . $billing_last_name ); ?></p>
<?php endif; ?>

<?php
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );
?>

<p><?php _e( 'This is a custom email sent as the order status has been changed to Pending Payment.', 'custom-email' ); ?></p>

<p><?php echo make_clickable( sprintf( __( 'You can view and edit this order in the dashboard here: %s', 'custom-email' ), admin_url( 'post.php?post=' . $item_data->order_id . '&action=edit' ) ) ); ?></p>

<?php do_action( 'woocommerce_email_footer' ); ?>
