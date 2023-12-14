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

if ( ! class_exists( 'Test_Pending_Emails' ) ) {
	/**
	 * Main Class File.
	 */
	class Test_Pending_Emails {

		public function __construct() {

			// template path.
			define( 'CUSTOM_TEMPLATE_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/templates/' );
			add_action( 'init', array( &$this, 'include_email_files' ) );
		}

		public function include_email_files() {
			include_once WP_PLUGIN_DIR . '/notify-pending-emails/class-wc-email-manager.php';
		}
	}
}
$test_pending_emails = new Test_Pending_Emails();
