<?php
/**
 * Plugin Name: Notify Pending Payment Orders
 * Description: This plugin sends a notification to the admin when a pending payment order is received on the website.
 * Version: 1.0
 * Author: Pinal Shah
 * Requires at least: 4.5
 * WC Requires at least: 4.0
 * WC tested up to: 8.3.1
 * Text Domain: pending-payments
 * Domain Path: /languages/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package Custom Snippets
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Custom_Pending_Payments' ) ) {
	/**
	 * Main Class File.
	 */
	class Custom_Pending_Payments {

		public function __construct() {

			// hook for when order status is changed.
			add_action( 'woocommerce_checkout_order_processed', array( &$this, 'custom_trigger_email_action' ), 10, 2 );
			// include the email class files.
			add_filter( 'woocommerce_email_classes', array( &$this, 'custom_init_emails' ) );

			// Email Actions - Triggers.
			$email_actions = array(
				'custom_pending_email',
			);

			foreach ( $email_actions as $action ) {
				add_action( $action, array( 'WC_Emails', 'send_transactional_email' ), 10, 10 );
			}

			add_filter( 'woocommerce_template_directory', array( $this, 'custom_template_directory' ), 10, 2 );
		}

		public function custom_init_emails( $emails ) {
			// Include the email class file if it's not included already.
			if ( ! isset( $emails['Custom_Email'] ) ) {
				$emails['Custom_Email'] = include_once 'emails/class-custom-email.php';
			}
			return $emails;
		}

		public function custom_trigger_email_action( $order_id, $posted ) {

			// add an action for our email trigger if the order id is valid.
			if ( isset( $order_id ) && (int) $order_id > 0 ) {
				new WC_Emails();
				do_action( 'custom_pending_email_notification', $order_id );
			}
		}

		public function custom_template_directory( $directory, $template ) {
			// ensure the directory name is correct.
			if ( false !== strpos( $template, 'custom' ) ) {
				return 'notify-pending-emails';
			}

			return $directory;
		}
	}
}
$custom_pending_payments = new Custom_Pending_Payments();
