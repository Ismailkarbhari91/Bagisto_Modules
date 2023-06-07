<?php

/**
 * Plugin Name:       Dordash Plugin
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           1.10.3
 * Author:            Dordash Plugin
 * Author URI:        https://facebook.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       dordash_plugin
 * Domain Path:       /languages
 */

 if ( ! defined( 'ABSPATH' ) ) {

    die;
}

// define global varibale 


define('URL', plugin_dir_url( __FILE__ ) );
define('PATH', plugin_dir_path( __FILE__ ) );
define('BASE_URL', get_option( 'siteurl' ));

// end global varibale

// define class

// start
if(!class_exists( 'DordashPluginClass' ) ){

    class DordashPluginClass{

        // register
        function register(){

        // menu 

        add_action('admin_menu', array($this, 'theme_options_panel'));
        //add custom column on admin order page
        add_filter( 'manage_edit-shop_order_columns', array($this,'custom_order_columns'), 20 );
        // add data in custom column admin order page
        add_filter( 'manage_shop_order_posts_custom_column', array($this,'custom_order_column_data'), 20, 2 );

        // js enque
        add_action( 'wp_enqueue_scripts', array($this,'add_my_scripts' ));
        add_action('admin_enqueue_scripts', array($this,'add_my_scripts'));

        // ajax
        add_action('wp_ajax_get_estimate', array($this,'handle_ajax_request'));
        add_action('wp_ajax_nopriv_get_estimate', array($this,'handle_ajax_request'));

        // fee order page
        add_action( 'woocommerce_cart_calculate_fees', array($this,'add_delivery_fee' ));

        // Add custom field to checkout page
        add_filter( 'woocommerce_checkout_fields', array($this,'add_custom_checkout_field' ));

        // Save custom fields to order table
            add_action( 'woocommerce_checkout_create_order', array($this,'save_custom_checkout_fields'), 10, 2 );

            // new order total
            // add_action( 'woocommerce_checkout_update_order_meta', array($this,'update_order_total_in_meta' ));

            add_action( 'woocommerce_admin_order_totals_after_shipping', array($this,'display_custom_field_fee'), 10, 1 );

            // 

            add_action( 'wp_ajax_get_recal_estimate', array($this,'recal_estimate' ));
            add_action( 'wp_ajax_nopriv_get_recal_estimate', array($this,'recal_estimate' ));

            // 

            add_action( 'woocommerce_order_status_changed', array($this,'prevent_order_status_change_to_cancelled'), 10, 4 );

            // 
            add_action( 'woocommerce_admin_order_actions_end', array($this,'add_content_to_wcactions_column' ));

            // 

            add_action( 'wp_ajax_cancel_order_status', array($this,'cancel_order_status_callback' ));
            add_action('wp_ajax_nopriv_cancel_order_status', array($this,'cancel_order_status_callback'));

            // 

            // add_action( 'wp_enqueue_scripts', array($this,'wpdocs_my_enqueue_scripts' ));
            // 

            // shipping lines s
            add_action( 'woocommerce_checkout_create_order', array($this,'add_data_to_shipping_lines'), 10, 2 );

            // 

            add_action( 'wp_ajax_recalculating', array($this,'handle_recalculating_request' ));
            add_action('wp_ajax_nopriv_recalculating', array($this,'handle_recalculating_request'));

            // save custom extra shipping field
            add_action('wp_ajax_save_tfee', array($this,'save_tfee'));
            add_action('wp_ajax_nopriv_save_tfee', array($this,'save_tfee'));

            // extra fee to shipping

            // insert ajax

            add_action('wp_ajax_insert', array($this,'insert'));
            add_action('wp_ajax_nopriv_insert', array($this,'insert'));


            //update

            add_action('wp_ajax_update', array($this,'updated'));
            add_action('wp_ajax_nopriv_update', array($this,'updated'));

            // delete 

            add_action('wp_ajax_delete', array($this,'deleted'));
            add_action('wp_ajax_nopriv_delete', array($this,'deleted'));

            // pinsert

            add_action('wp_ajax_pinsert', array($this,'pinsert'));
            add_action('wp_ajax_nopriv_pinsert', array($this,'pinsert'));


            //pupdate

            add_action('wp_ajax_pupdate', array($this,'pupdated'));
            add_action('wp_ajax_nopriv_pupdate', array($this,'pupdated'));


            //pdeleted

            add_action('wp_ajax_pdeleted', array($this,'pdeleted'));
            add_action('wp_ajax_nopriv_pdeleted', array($this,'pdeleted'));



            // 

            // 

            add_action( 'wp_ajax_get_kiosk_id', array($this,'get_kiosk_id' ));
            add_action( 'wp_ajax_nopriv_get_kiosk_id', array($this,'get_kiosk_id' ));

            // 

            add_action( 'wp_ajax_get_kiosk_ids', array($this,'get_kiosk_ids' ));
            add_action( 'wp_ajax_nopriv_get_kiosk_ids', array($this,'get_kiosk_ids' ));


            // add_action( 'woocommerce_admin_order_totals_after_total',array($this,'add_custom_field_to_order_total' ));

            // 
            // add_action( 'woocommerce_admin_order_totals_after_total', array($this,'update_order_total_in_database'), 99, 1 );

            add_action('woocommerce_shipping_init', array($this,'custom_shipping_method_init'));

            add_filter('woocommerce_shipping_methods', array($this,'add_custom_shipping_method'));

            add_action('woocommerce_before_checkout_form', array($this,'remove_checkout_data'));


            add_action( 'wp_ajax_update_distance', array($this,'update_distance'));
            add_action( 'wp_ajax_nopriv_update_distance', array($this,'update_distance'));

            add_action('wp_ajax_enable_custom_shipping_method', array($this,'enable_custom_shipping_method_callback'));
            add_action('wp_ajax_nopriv_enable_custom_shipping_method', array($this,'enable_custom_shipping_method_callback'));

            add_action('wp_ajax_custom_shipping_validation', array($this,'shipping_validation'));
            add_action('wp_ajax_nopriv_custom_shipping_validation', array($this,'shipping_validation'));

            // add_action( 'woocommerce_review_order_before_order_total', array($this,'add_additional_column_before_order_total' ));
        
            add_action('wp_ajax_custom_shipping_fee_update', array($this,'shipping_fee_update'));
            add_action('wp_ajax_nopriv_custom_shipping_fee_update', array($this,'shipping_fee_update'));

            add_action('wp_ajax_cancel_order', array($this,'cancel_order'));
            add_action('wp_ajax_nopriv_cancel_order', array($this,'cancel_order'));

            // add_action('wp_ajax_estimated_date', array($this,'add_additional_column_before_order_total'));
            // add_action('wp_ajax_nopriv_estimated_date', array($this,'add_additional_column_before_order_total'));

        }
        // end register



        public function cancel_order()
        {


            $wo_id = $_POST['wo_id'];
            $kioskId = $_POST['kioskId'];
            
            global $wpdb;
            $table_name = $wpdb->prefix . "doordash_details"; 
            $result = $wpdb->get_results ( "SELECT base_url FROM ". $table_name );
            foreach( $result as $user) 
            {
                $api_url = $user->base_url;
            }

            $response = wp_remote_post( $api_url.'/Delivery/cancelOrder', array(
                'headers' => array(
                  'Content-Type' => 'application/json',
                ),
                'body' => json_encode( array(
                  'wo_id' => $wo_id,
                  'kioskId' => $kioskId,
                ) ),
              ) );
            
              if ( is_wp_error( $response ) ) {
                // Handle the error
                wp_send_json_error( $response->get_error_message() );
              } else {
                // Return the response
               $response_data = json_decode( $response['body'], true );  
                  wp_send_json_success($response_data);
                  
              }

        }
        // 

        public function shipping_fee_update()
        {

            // $enable = isset($_POST['enable']) ? $_POST['enable'] : 'no';
        //    $s = get_option('custom_shipping_method_enabled');
        //    if ($s=='yes')
        //    {
            update_option('custom_shipping_method_enabled', "no");
            update_option('custom_shipping_method_fee', 0);
        //    }

        }

        // Add additional column to WooCommerce checkout page
        function add_additional_column_before_order_total() {
        
    
            echo '<tr class="woocommerce-table__line-item additional-column-row">';
            echo '<th class="woocommerce-table__delivery_date"></th>';
            echo '<td class="woocommerce-table__delivery_date_value" colspan="2"></td>';
            echo '</tr>';
            
        }


        // 

        function shipping_validation()
        {
            global $wpdb;
            $table_name = $wpdb->prefix . "doordash_details"; 
            $result = $wpdb->get_results ( "SELECT minimum_order,area_range FROM ". $table_name );
            foreach( $result as $user) 
            {

            $minimum_order   = $user->minimum_order;
            $area_range   = $user->area_range;
            }
            // Return the kioskId as a JSON response
            wp_send_json_success( array(
              'minimum_order' => $minimum_order,
              'area_range'=> $area_range,
            ) );
        }

        // 
        function enable_custom_shipping_method_callback() {
            $enable = isset($_POST['enable']) ? $_POST['enable'] : 'no';
            
            if( isset($_POST['enable']) && $_POST['enable'] == 'yes')
            {
                update_option('custom_shipping_method_enabled', 'yes');
                update_option('custom_shipping_method_fee', $_POST['fee']);      
                // $fee = isset($_POST['fee']);
            }
            elseif( $_POST['enable'] == 'no' && get_option('custom_shipping_method_fee')){
                update_option('custom_shipping_method_enabled', 'no');
                update_option('custom_shipping_method_fee', 0);      
            }        
            die();
        }
        
        // 

        

        // 

        function update_distance() {
            if ( isset( $_POST['zip_code'] ) ) {
                $origin = get_option('woocommerce_store_postcode'); // Replace with the actual origin zip code
                $destination = sanitize_text_field( $_POST['zip_code'] );
        
                // Call the ZipCodeAPI to calculate the distance
                $api_key = 'Xp5doz3gGpH9y0wWJh5SVIUvPvuLzB6aCXdlxbHpHwoSBFizs9xUfXswT6dh6Br5'; // Replace with your actual API key
                $url = "https://www.zipcodeapi.com/rest/$api_key/distance.json/$origin/$destination/mile";
                $response = wp_remote_get($url);
        
                if (is_wp_error($response)) {
                    // Handle API request error
                    $distance = 'Error: ' . $response->get_error_message();
                } else {
                    $body = wp_remote_retrieve_body($response);
                    $data = json_decode($body);
        
                    if ($data && !empty($data->distance)) {
                        $distance = $data->distance;
                    } else {
                        // Handle API response error
                        $distance = 'Error: Unable to calculate distance.';
                    }
                }
        
                // Return the updated distance value
                echo $distance;
                exit;
            }
        
            // If an error occurred or the distance calculation failed, return a default value or error message
            echo 'Error: Failed to calculate the distance';
            exit;
        }
        

        // 
        
        function remove_checkout_data() {
            if (is_checkout() && !is_wc_endpoint_url()) {
                // Remove custom field values
                // WC()->session->__unset('custom_field_delivery_time');
                // WC()->session->__unset('custom_field_fee');
        
                // // Remove billing address
                WC()->customer->set_billing_address_1('');
                WC()->customer->set_billing_address_2('');
                WC()->customer->set_billing_city('');
                WC()->customer->set_billing_state('');
                WC()->customer->set_billing_postcode('');
                WC()->customer->set_billing_country('');
            }
        }



        function custom_shipping_method_init()
{
    // Check if the class exists before declaring it
    if (class_exists('WC_Custom_Shipping_Method')) {
        return;
    }

    // Include the required shipping method class
    include(PATH."class-custom-shipping-method.php");


    // Register the custom shipping method
}


function add_custom_shipping_method($methods) {
    $methods[] = 'Custom_Shipping_Method';
    return $methods;
}

        // include(PATH."class-custom-shipping-method.php");

        //

        function get_kiosk_id() {
            global $wpdb;
            $table_name = $wpdb->prefix . "doordash_details"; 
            $result = $wpdb->get_results ( "SELECT kiosk_id,vpassword FROM ". $table_name );
            foreach( $result as $user) 
            {

            $kioskId   = $user->kiosk_id;
            $password   = $user->vpassword;
            }
            // Return the kioskId as a JSON response
            wp_send_json_success( array(
              'kioskId' => $kioskId,
              'password'=> $password,
            ) );
          }


          function get_kiosk_ids() {
            global $wpdb;
            $table_name = $wpdb->prefix . "doordash_details"; 
            $result = $wpdb->get_results ( "SELECT kiosk_id FROM ". $table_name );
            foreach( $result as $user) 
            {

            $kioskId   = $user->kiosk_id;

            }
            // Return the kioskId as a JSON response
            wp_send_json_success( array(
              'kioskId' => $kioskId,
            ) );
          }


        //menu
        
        function theme_options_panel(){
            
            add_menu_page(
                'Dordash Plugin Menu', 
                'Shipping Method', 
                'manage_options', 
                'dordash_type', 
                array($this, 'menupage'),
                'dashicons-admin-site',
                1);

                // add_submenu_page(
                //     'dordash_type',
                //     'Dordash Plugin Menu',
                //     'Provider',
                //     'manage_options',
                //     'provider_type', 
                //     array($this, 'area_menupage'),
                // );
            }



            function area_menupage(){
                include(PATH."sub_menu_template.php");
            }
            


            function menupage(){
                include(PATH."menupage_template.php");
            }

        

        //extra fee to shipping

        // function update_order_total_in_database( $order_id ) {
        //     // Get the order object
        //     $order = wc_get_order( $order_id );
        
        //     // Get the custom field value
        //     $custom_total = $order->get_meta( 'tfee' );
        
        //     // If the custom field value is not empty, update the order total
        //     if ( ! empty( $custom_total ) ) {
        //         $order->update_meta_data( '_order_total', $custom_total );
        //         $order->save();
        //     }
        // }
        // save custom extra shipping field

        function save_tfee() {
            // Get the wo_id and tfee values from the AJAX request data
            $wo_id = $_POST['wo_id'];
            $tfee = $_POST['tfee'];

            // Get the order object
            // $order = wc_get_order( $wo_id );
          
            // Update the custom field value for the WordPress order
            update_post_meta($wo_id, 'tfee', $tfee);

            // $total = $order->get_meta( '_order_total' );
            // $total += $tfee;

            // Get the current order total
            // $total = $order->get_total();

            // Add the custom fee to the order total
            // $total += $tfee;

            // Update the order total value in the database
            // $order->set_total( $total );
            // $order->save();

            //   update_post_meta($wo_id, '_order_total', $total);
    
              // Send a JSON response back to the client
            wp_send_json_success();
          }


        // recalculating

        // ajax handling
        function handle_recalculating_request() {
            // Extract the request parameters

            
            $wo_id = $_POST['wo_id'];
            $kioskId = $_POST['kioskId'];
            $delivery_time = $_POST['delivery_time'];
            

            global $wpdb;
            $table_name = $wpdb->prefix . "doordash_details"; 
            $result = $wpdb->get_results ( "SELECT base_url FROM ". $table_name );
            foreach( $result as $user) 
            {
                $api_url = $user->base_url;
            }

            // Call the API
            $response = wp_remote_post( $api_url.'/Delivery/updateOrder', array(
              'headers' => array(
                'Content-Type' => 'application/json',
              ),
              'body' => json_encode( array(
                'wo_id' => $wo_id,
                'kioskId' => $kioskId,
                'delivery_time' => $delivery_time,
              ) ),
            ) );
          
            if ( is_wp_error( $response ) ) {
              // Handle the error
              wp_send_json_error( $response->get_error_message() );
            } else {
              // Return the response
             $response_data = json_decode( $response['body'], true );  
                wp_send_json_success($response_data);
                
            }
          }
        




        //shipping lines

        function add_data_to_shipping_lines( $order, $data ) {

            $custom_method_id = $_POST['billing_custom_field'];
            $custom_method_title = $_POST['billing_custom_field'];
            $custom_total = $_POST['custom_field_fee'];
       
            $shipping_method = array(
                'method_id' => $custom_method_id,
                'method_title' => $custom_method_title,
                'total' => $custom_total
            );
            
            // Add the shipping method to the order
            $order->add_shipping(new WC_Shipping_Rate(
                $shipping_method['method_id'],
                $shipping_method['method_title'],
                $shipping_method['total']
            ));
        }       

        // function wpdocs_my_enqueue_scripts()
        // {
        //     wp_enqueue_script( 'wpdocs-bootstrap-bundle-script', '//cdn.jsdelivr.net/npm/sweetalert2@11', array(), null, true );
        // }
        
        // 

        function cancel_order_status_callback() {
            // get the order ID from the AJAX request
           $order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
        
            // check if order ID is valid
            if ( !$order_id ) {
                wp_die();
            }


           


            // update the order status to 'cancelled'
            $order = wc_get_order( $order_id );
            if ( $order && $order->get_status() !== 'cancelled' ) {
                $order->update_status( 'cancelled' );
            }

            // 
            // 
        
            wp_die();
        }
        
        

        // 


        function add_content_to_wcactions_column() {
            // get the current order
            global $post;
            $order = wc_get_order( $post->ID );
            // 

            // get the order ID
            $order_id = $order->get_id();
            // 

            // 

            // 

            global $wpdb;
            $table_name = $wpdb->prefix . "doordash_details"; 
            $result = $wpdb->get_results ( "SELECT kiosk_id FROM ". $table_name );
            foreach( $result as $user) 
            {

            $kioskId   = $user->kiosk_id;

            }

            // 

            global $wpdb;
            $table_name = $wpdb->prefix . "doordash_details"; 
            $result = $wpdb->get_results ( "SELECT base_url FROM ". $table_name );
            foreach( $result as $user) 
            {
            $api_url   = $user->base_url;
            }

            $url = $api_url.'/Delivery/getStatus';
            $data = array(
            // 'order_id' => 'ics-stg193',
            'wo_id' => $order_id,
            'kioskId' => $kioskId
            );
            $options = array(
            'http' => array(
                'header' => "Content-type: application/json\r\n",
                'method' => 'POST',
                'content' => json_encode($data),
            ),
            );
            $context = stream_context_create($options);
            $response = file_get_contents($url, false, $context);
            $response_data = json_decode($response, true);
        
            // Retrieve the dasher_status value
            $dasher_status = $response_data['dasher_status'];
            $status = $response_data['status'];

            // 

            // check if order status is completed
            if ( $order->get_status() === 'completed') {
                // create some tooltip text to show on hover
                $tooltip = __('Order has already been completed.', 'textdomain');
        
                // create a button label
                $label = __('Label', 'textdomain');
        
                // create the button icon
                $icon = '<span class="dashicons dashicons-admin-generic"></span>';
        
                echo '<a class="button tips custom-classs" href="#" data-tip="'.$tooltip.'" disabled>'.$icon.' '.$label.'</a>';
            }
            elseif( $status ==='assigned' )
            {
                // create some tooltip text to show on hover
                $tooltip = __('Order has already been completed.', 'textdomain');
        
                // create a button label
                $label = __('Label', 'textdomain');
        
                // create the button icon
                $icon = '<span class="dashicons dashicons-admin-generic"></span>';
        
                echo '<a class="button tips custom-classs" href="#" data-tip="'.$tooltip.'" disabled>'.$icon.' '.$label.'</a>';
            }

            elseif( $status ==='cancelled' )
            {
                // create some tooltip text to show on hover
                $tooltip = __('Order has already been completed.', 'textdomain');
        
                // create a button label
                $label = __('Label', 'textdomain');
        
                // create the button icon
                $icon = '<span class="dashicons dashicons-admin-generic"></span>';
        
                echo '<a class="button tips custom-classs" href="#" data-tip="'.$tooltip.'" disabled>'.$icon.' '.$label.'</a>';
            }
            // elseif( $status ==='cancelled' )
            // {
            //     // create some tooltip text to show on hover
            //     $tooltip = __('Order has already been completed.', 'textdomain');
        
            //     // create a button label
            //     $label = __('Label', 'textdomain');
        
            //     // create the button icon
            //     $icon = '<span class="dashicons dashicons-admin-generic"></span>';
        
            //     echo '<a class="button tips custom-classs" href="#" data-tip="'.$tooltip.'" disabled>'.$icon.' '.$label.'</a>';
            // }
             else {
                // create some tooltip text to show on hover
                $tooltip = __('Cancel Order.', 'textdomain');
        
                // create a button label
                $label = __('Label', 'textdomain');
        
                // create the button icon
                $icon = '<span class="dashicons dashicons-admin-generic"></span>';
        
                // create the HTML for the modal dialog
                $dialog_html = '<div id="custom-modal-dialog" style="display:none">
                 <button class="cancel-order-button">'.__('Cancel Order', 'textdomain').'</button>
                 <button id="recalculate-fee-button" class="recalculte-fee-button">'.__('Recalculate Fee', 'textdomain').'</button>
                </div>';
        
                // output the button and dialog HTML
                echo '<a class="button tips custom-class" href="#TB_inline?width=600&height=550&inlineId=custom-modal-dialog" data-tip="'.$tooltip.'">'.$icon.' '.$label.'</a>';
                echo $dialog_html;
        
                // add the Thickbox script to the page
                add_thickbox();
            }
        ?>
        <style>
            /*  */

        </style>
        <?php
           
        }
        

        // prevent

        function prevent_order_status_change_to_cancelled( $order_id, $old_status, $new_status, $order ) {
            //
            $order_id = get_the_ID();

            global $wpdb;
            $table_name = $wpdb->prefix . "doordash_details"; 
            $result = $wpdb->get_results ( "SELECT base_url FROM ". $table_name );
            foreach( $result as $user) 
            {
            $api_url   = $user->base_url;
            }

            $url = $api_url.'/Delivery/getStatus';
            $data = array(
            'order_id' => 'ics-stg193',
            'wo_id' => $order_id,
            'kioskId' => 'icash-web-234324-wer688'
            );
            $options = array(
            'http' => array(
                'header' => "Content-type: application/json\r\n",
                'method' => 'POST',
                'content' => json_encode($data),
            ),
            );
            $context = stream_context_create($options);
            $response = file_get_contents($url, false, $context);
            $response_data = json_decode($response, true);
        
            // Retrieve the dasher_status value
            $dasher_status = $response_data['dasher_status'];
        
            // Output the dasher_status value
        // 	echo $dasher_status;
        
            // 	 	
            if ( $new_status === 'cancelled' && $old_status === 'completed' ) {
                // If the order status is changing from 'completed' to 'cancelled', prevent the change.
                $order->update_status( $old_status, __( 'Order status cannot be changed from completed to cancelled.', 'woocommerce' ) );
            }
             elseif ( $new_status === 'cancelled' && $dasher_status === 'assigned' ) {
                // If the order status is changing from 'completed' to 'cancelled', prevent the change.
                $order->update_status( $old_status, __( 'Order status cannot be changed from completed to cancelled.', 'woocommerce' ) );
            }
        }
        

         // new order total

         function display_custom_field_fee( $order ) 
{
	$order_id = get_the_ID();
	$order = wc_get_order( $order_id );
    if ( ! $order ) {
        return;
    }

    $fee = $order->get_meta( 'custom_field_fee', true );
    if ( ! $fee ) {
        return;
    }

    $extrafee = $order->get_meta( 'tfee', true );
    if ( ! $extrafee ) {
        return;
    }

    echo '<tr class="order-custom-field-fee">';
    echo '<td class="label">' . __( 'Shipping Fee:', 'woocommerce' ) . '</td>';
    echo '<td width="1%"></td>';
    echo '<td class="total">$' . $fee . '</td>';
    echo '</tr>';

    echo '<tr class="order-custom-field-fee">';
    echo '<td class="label">' . __( 'Extra Shipping Fee:', 'woocommerce' ) . '</td>';
    echo '<td width="1%"></td>';
    echo '<td class="total">$' . $extrafee . '</td>';
    echo '</tr>';
}




function recal_estimate() {

            $wo_id = $_POST['wo_id'];
            $kioskId = $_POST['kioskId'];

            global $wpdb;
            $table_name = $wpdb->prefix . "doordash_details"; 
            $result = $wpdb->get_results ( "SELECT base_url FROM ". $table_name );
            foreach( $result as $user) 
            {
            $api_url   = $user->base_url;
            }
            
            // Call the API
            $response = wp_remote_post( $api_url.'/Delivery/getStatus',
             array(
              'headers' => array(
                'Content-Type' => 'application/json',
              ),
              'body' => json_encode( array(
                'wo_id' => $wo_id,
                'kioskId' => $kioskId,
              ) ),
            ) );
          
            if ( is_wp_error( $response ) ) {
              // Handle the error
              wp_send_json_error( $response->get_error_message() );
            } else {
              // Return the response
             $response_data = json_decode( $response['body'], true );  
                wp_send_json_success($response_data);
                
            }

    

}



        // Save custom fields to order table
        function save_custom_checkout_fields( $order, $data ) {
            // $new_total = floatval( $_POST['custom_field_order_total'] );
    
            // // Update the order meta data with the new total value
            // $order->set_total( $new_total );
            // $order->save();
            $my_field_1 = sanitize_text_field( $_POST['custom_field_delivery_time'] );
            $my_field_2 = sanitize_text_field( $_POST['custom_field_fee'] );
            if ( ! empty( $my_field_1 ) ) {
                $order->update_meta_data( 'custom_field_delivery_time', $my_field_1 );
            }
            if ( ! empty( $my_field_2 ) ) {
                $order->update_meta_data( 'custom_field_fee', $my_field_2 );
            }

            if ( isset( $data['billing_custom_field'] ) ) {
                $order->update_meta_data( 'provider', sanitize_text_field( $data['billing_custom_field'] ) );
            }
            $order_notes = isset( $data['order_comments'] ) ? sanitize_text_field( $data['order_comments'] ) : '';
            if ( ! empty( $order_notes ) ) {
            $order->update_meta_data( 'dropoff_instructions', $order_notes );
            }

            $pickup_instructions = 'Pick from back door';
            $order->update_meta_data( 'pickup_instructions', $pickup_instructions );

            // $shipping = $order->get_post_meta('_shipping_lines');

            // $data = array(
            //     'method_title' => 'Flat rate',
            //     'method_id' => 'flat_rate',
            //     'total' => '10.00'
            // );


        }
        
        // 
        
        

        // 

        // custom fields 

        function add_custom_checkout_field( $fields ) {

            $custom_field_delivery_time = WC()->session->get('custom_field_delivery_time');
            $custom_field_fee = WC()->session->get('custom_field_fee');

            
            $fields['order']['custom_field_delivery_time'] = array(
                'type' => 'text',
                'label' => __('Delivery Time'),
                'required' => false,
                'class' => array('form-row-wide'),
                'clear' => true,
                'default' => $custom_field_delivery_time,
            );
        
            $fields['order']['custom_field_fee'] = array(
                'type' => 'text',
                'label' => __('Fee'),
                'required' => false,
                'class' => array('form-row-wide'),
                'clear' => true,
                'default' => $custom_field_fee,
            );
            
            $fields['order']['custom_field_order_total'] = array(
                'type' => 'text',
                'label' => __( 'Order Total' ),
                'required' => false,
                'class' => array( 'form-row-wide' ),
                'clear' => true,
            );
        
            global $wpdb;
            $table_name = $wpdb->prefix . "doordash_details"; 
            $result = $wpdb->get_results ( "SELECT kiosk_id,vpassword FROM ". $table_name );
            foreach( $result as $user) 
            {
            $pass = $user->vpassword;
            $kioskId   = $user->kiosk_id;
            }

            $fields['order']['custom_field_password'] = array(
                'type' => 'text',
                'required' => false,
                'class' => array( 'form-row-wide' ),
                'clear' => true,
                'default' => $pass
            );

            $fields['order']['custom_field_kiosid'] = array(
                'type' => 'text',
                'required' => false,
                'class' => array( 'form-row-wide' ),
                'clear' => true,
                'default' => $kioskId
            );

            $fields['order']['billing_custom_field'] = array(
                'type' => 'text',
                'required' => false,
                'class' => array( 'form-row-wide' ),
                'clear' => true,
                'default' =>'DoorDash'
            );


            //
           // Get the origin and destination zip codes

        //    $order_total = WC()->cart->get_cart_contents_total();
        //    $storecode = get_option('woocommerce_store_postcode');
        //    $billingcode = WC()->customer->get_shipping_postcode();

        //     $origin = $storecode; // Replace with the actual origin zip code
        //     $destination = $billingcode; // Replace with the actual destination zip code

        //     // Call the ZipCodeAPI to calculate the distance
        //     $api_key = 'Xp5doz3gGpH9y0wWJh5SVIUvPvuLzB6aCXdlxbHpHwoSBFizs9xUfXswT6dh6Br5'; // Replace with your actual API key
        //     $url = "https://www.zipcodeapi.com/rest/$api_key/distance.json/$origin/$destination/mile";
        //     $response = wp_remote_get($url);

        //     if (is_wp_error($response)) {
        //     // Handle API request error
        //     $distance = 'Error: ' . $response->get_error_message();
        //     } else {
        //     $body = wp_remote_retrieve_body($response);
        //     $data = json_decode($body);
    
        //     if ($data && !empty($data->distance)) {
        //     $distance = $data->distance;
        //     } else {
        //     // Handle API response error
        //     $distance = 'Error: Unable to calculate distance.';
        //     }
        //     }

            // 
            $fields['order']['billing_distance'] = array(
                'type' => 'text',
                'class' => array('form-row-wide'),
                'label' => __('Distance to Store'),
                'required' => false,
                'readonly' => true
                // 'default' => $distance
            );
        

            //
            // $options[''] = __( 'Select a value', 'woocommerce');
            global $wpdb;
            $table_name = $wpdb->prefix . "providers"; 
            $result = $wpdb->get_results("SELECT * FROM $table_name");
            $options = array();
            foreach ($result as $user) {
                $options[$user->title] = $user->title;
            }
            
            // $fields['billing']['billing_custom_field'] = array(
            //     'type' => 'select',
            //     'label' => 'Select a delivery provider',
            //     'required' => true,
            //     'options' => array(
            //         '' => 'Select',
            //         'DoorDash'=>'DoorDash',
            //     ),
            // );
            

            ?>
            <!-- <style>
            #custom_field_delivery_time_field,
            #custom_field_fee_field,
            #custom_field_order_total_field,#custom_field_kiosid,#custom_field_password {
                display: none;
            }
            </style> -->
            <?php
         
            return $fields;
        }
        
        

        // fee

        function add_delivery_fee( $cart ) {
            if ( ! empty( $_POST['action'] ) && $_POST['action'] == 'my_ajax_request' ) {
                // Extract the fee value from the Ajax response
                $fee = isset( $_POST['fee'] ) ? floatval( $_POST['fee'] ) : 0;
                error_log( 'Delivery fee: ' . $fee );
                if ( $fee > 0 ) {
                    // Add the fee as a cart fee
                    $cart->add_fee( 'Delivery Fee', $fee );
                    error_log( 'Delivery fee added to cart.' );
                }
            }
        }
        

        // ajax handling
        function handle_ajax_request() {
            // Extract the request parameters
            $password = $_POST['password'];
            $kioskId = $_POST['kioskId'];
            $dropoff_address = $_POST['dropoff_address'];
            $order_value = $_POST['order_value'];
            // $delivery_time = $_POST['delivery_time'];
            
            global $wpdb;
            $table_name = $wpdb->prefix . "doordash_details"; 
            $result = $wpdb->get_results ( "SELECT base_url FROM ". $table_name );
            foreach( $result as $user) 
            {
            $api_url   = $user->base_url;
            }

            // Call the API
            $response = wp_remote_post( $api_url.'/Delivery/getEstimate', array(
              'headers' => array(
                'Content-Type' => 'application/json',
              ),
              'body' => json_encode( array(
                'password' => $password,
                'kioskId' => $kioskId,
                'dropoff_address' => $dropoff_address,
                'order_value' => $order_value,
              ) ),
            ) );
          
            if ( is_wp_error( $response ) ) {
              // Handle the error
              wp_send_json_error( $response->get_error_message() );
            } else {
              // Return the response
             $response_data = json_decode( $response['body'], true );
              $delivery_time = $response_data['DoorDash']['delivery_time'];
              $fee = $response_data['DoorDash']['fee'];
                
              //
              $order_id = WC()->session->get('order_awaiting_payment'); 	
          
          // wp_send_json_success( array(
          //     'delivery_time' => $delivery_time,
          //     'fee' => $fee,
          // 	'order_id' => $order_id,
          // ) );
              
                wp_send_json_success($response_data);
                
            }
          }
          
          

        // enque js
        function add_my_scripts( $hook ) {
            wp_enqueue_script( 'jquery' );
            wp_enqueue_style( 'jquery-ui-css', 'https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css' );
            wp_enqueue_script( 'jquery-ui-datepicker', 'https://code.jquery.com/ui/1.13.1/jquery-ui.min.js', array( 'jquery' ), '1.12.1', true );
            wp_enqueue_script( 'my-ajax-script', URL.'assests/js/front_end.js', array('jquery'), '1.0', true );
            
            wp_enqueue_style( 'custom-ui-css', URL.'assests/css/custom.css' ); 
            // 
            wp_register_script('menuplugin-admin_js3', URL.'assests/js/custom.js' ,array('jquery'), '1.0', true );
            wp_register_script('menuplugin-admin_js', URL.'assests/js/jquery.min.js' ,array('jquery'),false,true);
    
            wp_register_script('menuplugin-admin_js1', URL.'assests/js/datatables.min.js' ,array('jquery'),false,true);
    
            wp_register_script('menuplugin-admin_js2', URL.'assests/js/bootstrap.min.js' ,array('jquery'),false,true);
            //
            
            // 
            wp_register_style('menuplugin-admin_css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css');
    
            wp_register_style('menuplugin-admin_css1', 'https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css');
    
            wp_register_style('menuplugin-admin_css2', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css');
    
            wp_register_style('menuplugin-admin_css3', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');
    
            // 
            // Define the 'ajaxurl' JavaScript variable

            //   global $wpdb;
            //   $table_name = $wpdb->prefix . "doordast_details"; 
            //   $result = $wpdb->get_results ( "SELECT kiosk_id,vpassword FROM ". $table_name );
            //   foreach($result as $s)
            //     {
            //         $password = $s->vpassword;
            //         $kioskId = $s->kiosk_id;
            //     }
            // 
            wp_localize_script( 'my-ajax-script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ),) );

            // 

            $page = ( isset( $_GET['page'] ) ? sanitize_text_field( $_GET['page'] ) : '' );
           
            // multi
    
            if( 'dordash_type' ==  $page || 'provider_type'==$page)
            { 
            
                wp_enqueue_script( 'menuplugin-admin_js' );
    
                wp_enqueue_script( 'menuplugin-admin_js1' );
    
                wp_enqueue_script( 'menuplugin-admin_js2' );
    
                wp_enqueue_script( 'menuplugin-admin_js3' );
    
                // wp_enqueue_script( 'menuplugin-admin_js4' );
               
                // 
    
                wp_enqueue_style( 'menuplugin-admin_css' );
    
                wp_enqueue_style( 'menuplugin-admin_css1' );
    
                wp_enqueue_style( 'menuplugin-admin_css2' );
    
                wp_enqueue_style( 'menuplugin-admin_css3' );
    
                wp_enqueue_style( 'menuplugin-admin_css4' );   

                // wp_enqueue_media();
    
            }

            // 
          }
          

        //add custom column on admin order page
        function custom_order_columns( $columns ) { 	
            $new_columns = array();
            foreach( $columns as $column_name => $column_info ) {
                $new_columns[ $column_name ] = $column_info;
                if( $column_name === 'order_status' ) {
                    // Add a new column after the status column
                    $new_columns['new_column'] = __( 'Dordash Status', 'text-domain' );
                    $new_columns['new_column1'] = __( 'Delivery Date & Time', 'text-domain' );
                }
            }
            return $new_columns;
        }
        // add data in custom column admin order page
        function custom_order_column_data( $column, $post_id ) {
            global $order_id;
            $order_id = get_the_ID();

            // 

            global $wpdb;
            $table_name = $wpdb->prefix . "doordash_details"; 
            $result = $wpdb->get_results ( "SELECT base_url FROM ". $table_name );
            foreach( $result as $user) 
            {
            $api_url   = $user->base_url;
            }

            // 

            if ( $column === 'new_column') {
                $url = $api_url.'/Delivery/getStatus';
                $data = array(
                    'order_id' => 'ics-stg193',
                    'wo_id' => $order_id,
                    'kioskId' => 'icash-web-234324-wer688'
                );
                $options = array(
                    'http' => array(
                        'header' => "Content-type: application/json\r\n",
                        'method' => 'POST',
                        'content' => json_encode($data),
                    ),
                );
                $context = stream_context_create($options);
                $response = file_get_contents($url, false, $context);
                $response_data = json_decode($response, true);
        
                // Retrieve the dasher_status value
                $dasher_status = $response_data['dasher_status'];
                $status = $response_data['status'];
                $estimated = $response_data['estimated_delivery_time'];
                
        
                // Output the dasher_status value in the new column
                echo $status;
            }
            if ( $column === 'new_column1') {
                $url = $api_url.'/Delivery/getStatus';
                $data = array(
                    'wo_id' => $order_id,
                    'kioskId' => 'icash-web-234324-wer688'
                );
                $options = array(
                    'http' => array(
                        'header' => "Content-type: application/json\r\n",
                        'method' => 'POST',
                        'content' => json_encode($data),
                    ),
                );
                $context = stream_context_create($options);
                $response = file_get_contents($url, false, $context);
                $response_data = json_decode($response, true);
                $estimated = $response_data['estimated_delivery_time'];
                
        
                // Output the dasher_status value in the new column
                if (isset($estimated) && !empty($estimated)) {
                echo $estimated;
                }
            }


        }

        // action hook

        function create_db_table(){
        
            include(PATH.'first_db/createdb.php' );

        }

        function remove_db_table() {
        
            include(PATH.'first_db/removedb.php' );

        }

        function insert() {
        
            include( PATH.'first_db/insert.php' );

        }

        function updated() {
        
            include( PATH.'first_db/update.php' );

        }


        function deleted() {
        
            include( PATH.'first_db/delete.php' );

        }


        function pinsert() {
        
            include( PATH.'first_db/pinsert.php' );

        }

        function pupdated() {
        
            include( PATH.'first_db/pupdate.php' );

        }
        
        function pdeleted() {
        
            include( PATH.'first_db/pdelete.php' );

        }
                
    }

}
// end
// 
if(class_exists( 'DordashPluginClass' ) ){
    $crud = new DordashPluginClass();
    $crud->register();
}

register_activation_hook( __FILE__, array( $crud, 'create_db_table' ) );

// register_deactivation_hook( __FILE__, array( $crud, 'remove_db_table' ) );
