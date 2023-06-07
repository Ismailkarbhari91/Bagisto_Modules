<?php
// Include the WC_Shipping_Method class
if (!class_exists('WC_Shipping_Method')) {
    return;
}

// Define the custom shipping method class

class Custom_Shipping_Method extends WC_Shipping_Method {


    /**
     * Constructor for your shipping class
     */
    public function __construct() {
        $this->id                 = 'custom_shipping_method'; // Unique ID for your shipping method
        $this->method_title       = __('Doordash Shipping Method', 'custom-shipping-method'); // Title shown in the admin
        $this->method_description = __('Doordash shipping method description.', 'custom-shipping-method'); // Description shown in the admin
        $this->enabled            = get_option('custom_shipping_method_enabled', 'no');
        $this->title              = __('Doordash Shipping', 'custom-shipping-method'); // Title shown on the frontend
        $this->init();

        // add_filter('woocommerce_package_rates', array($this, 'hide_custom_shipping_method_on_page_load'), 10, 2);
    }

    /**
     * Initialize your shipping method
     */
    public function init() {
        $this->init_form_fields(); // Define shipping method settings
        $this->init_settings(); // Load the settings from the database

        // Save settings in admin if you have any defined
        add_action('woocommerce_update_options_shipping_' . $this->id, [$this, 'process_admin_options']);
    }

    /**
     * Define shipping method settings
     */
    public function init_form_fields() {
        $this->form_fields = array(
            'enabled' => array(
                'title'   => __('Enable/Disable', 'custom-shipping-method'),
                'type'    => 'checkbox',
                'label'   => __('Enable this shipping method', 'custom-shipping-method'),
                'default' => 'no',
            ),
            'title' => array(
                'title'       => __('Title', 'custom-shipping-method'),
                'type'        => 'text',
                'description' => __('Enter the title for this shipping method', 'custom-shipping-method'),
                'default'     => __('Custom Shipping', 'custom-shipping-method'),
                'desc_tip'    => true,
            ),
            // Add more settings fields as needed
        );
    }

    /**
     * Calculate shipping rates
     */
    public function calculate_shipping($package = []) {

        // $fee = update_option('custom_shipping_method_fee',0); // Set the initial fee value to zero

        // $fee = get_option('custom_shipping_method_enabled', 'no');


        // if (!is_admin()) {
            // Check if the request is not from the admin area (i.e., it's a page refresh)
            $fee = get_option('custom_shipping_method_fee'); // Set the fee to 10 on page refresh
        // }
    
           

    
        $rate = array(
            'id'      => $this->id,
            'label'   => $this->title,
            'cost'    => $fee, // Define the cost or calculate it dynamically based on package details
            'taxes'   => false,
            'calc_tax'=> 'per_order',
        );
    
        $this->add_rate($rate);
        
    }
   
    
    

}