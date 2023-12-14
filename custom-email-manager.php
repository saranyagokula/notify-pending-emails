<?php
/**
 * Handles email sending
 */
class Custom_Email_Manager {

	/**
	 * Constructor sets up actions
	 */
	public function __construct() {
	    
	    // template path
	    define( 'CUSTOM_TEMPLATE_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/templates/' );
	    // hook for when order status is changed
	    add_action( 'woocommerce_order_status_pending', array( &$this, 'custom_trigger_email_action' ), 10, 2 );
	    // include the email class files
	    add_filter( 'woocommerce_email_classes', array( &$this, 'custom_init_emails' ) );
		
	    // Email Actions - Triggers
	    $email_actions = array(
            
		    'custom_pending_email',
		    'custom_item_email',
	    );

	    foreach ( $email_actions as $action ) {
	        add_action( $action, array( 'WC_Emails', 'send_transactional_email' ), 10, 10 );
	    }
		
	    add_filter( 'woocommerce_template_directory', array( $this, 'custom_template_directory' ), 10, 2 );
		
	}
	
	public function custom_init_emails( $emails ) {
	    // Include the email class file if it's not included already
	    if ( ! isset( $emails[ 'Custom_Email' ] ) ) {
	        $emails[ 'Custom_Email' ] = include_once( 'emails/class-custom-email.php' );
	    }
	
	    return $emails;
	}
	
	public function custom_trigger_email_action( $order_id, $posted ) {
	     // add an action for our email trigger if the order id is valid
	    if ( isset( $order_id ) && 0 != $order_id ) {
	        
	        new WC_Emails();
    		do_action( 'custom_pending_email_notification', $order_id );
	    
	    }
	}
	
	public function custom_template_directory( $directory, $template ) {
	   // ensure the directory name is correct
	    if ( false !== strpos( $template, '-custom' ) ) {
	      return 'my-custom-email';
	    }
	
	    return $directory;
	}
	
}// end of class
new Custom_Email_Manager();
?>