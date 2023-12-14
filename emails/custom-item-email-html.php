<?php
/**
 * Admin new order email
 */
$order = new WC_order( $item_data->order_id );
$opening_paragraph = __( 'A new order has been made by %s. The details of the item are as follows:', 'custom-email' );

?>

<?php do_action( 'woocommerce_email_header', $email_heading ); ?>

<?php
$billing_first_name = ( version_compare( WOOCOMMERCE_VERSION, "3.0.0" ) < 0 ) ? $order->billing_first_name : $order->get_billing_first_name();
$billing_last_name = ( version_compare( WOOCOMMERCE_VERSION, "3.0.0" ) < 0 ) ? $order->billing_last_name : $order->get_billing_last_name(); 
if ( $order && $billing_first_name && $billing_last_name ) : ?>
	<p><?php printf( $opening_paragraph, $billing_first_name . ' ' . $billing_last_name ); ?></p>
<?php endif; ?>

<table cellspacing="0" cellpadding="6" style="width: 100%; border: 1px solid #eee;" border="1" bordercolor="#eee">
	<tbody>
		<tr>
			<th scope="row" style="text-align:left; border: 1px solid #eee;"><?php _e( 'Ordered Product', 'custom-email' ); ?></th>
			<td style="text-align:left; border: 1px solid #eee;"><?php echo $item_data->product_title; ?></td>
		</tr>
		<tr>
			<th scope="row" style="text-align:left; border: 1px solid #eee;"><?php _e( 'Quantity', 'custom-email' ); ?></th>
			<td style="text-align:left; border: 1px solid #eee;"><?php echo $item_data->qty; ?></td>
		</tr>
		<tr>
			<th scope="row" style="text-align:left; border: 1px solid #eee;"><?php _e( 'Total', 'custom-email' ); ?></th>
			<td style="text-align:left; border: 1px solid #eee;"><?php echo $item_data->total; ?></td>
		</tr>
	</tbody>
</table>

<p><?php _e( 'This is a custom email sent as the order status has been changed to Pending Payment.', 'custom-email' ); ?></p>

<p><?php echo make_clickable( sprintf( __( 'You can view and edit this order in the dashboard here: %s', 'custom-email' ), admin_url( 'post.php?post=' . $item_data->order_id . '&action=edit' ) ) ); ?></p>

<?php do_action( 'woocommerce_email_footer' ); ?>