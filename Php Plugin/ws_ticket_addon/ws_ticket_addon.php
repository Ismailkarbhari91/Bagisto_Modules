<?php

/**
 * Plugin Name:       Wsdesk_tickets Addon  Plugin
 * Description:       Handle the basics with this plugin.
 * Version:           1.10.3
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       help_desk addon
 * Domain Path:       /languages
 */
if ( ! defined( 'ABSPATH' ) ) {

    die;

}

define('CRUD_URL', plugin_dir_url( __FILE__ ) );
define('BASE_URL', get_option( 'siteurl' ));
define('CRUD_PATH', plugin_dir_path( __FILE__ ) );

if(!class_exists( 'CrudClass' ) ){

    class CrudClass{
        function register(){
              add_action('admin_menu', array($this, 'theme_options_panel'));
              add_action('admin_enqueue_scripts', array($this, 'hooks') );
              add_action("wp_ajax_insert", array($this,'insert'));
              add_action("wp_ajax_nopriv_insert", array($this,'insert'));

              add_shortcode('customshortcode',array($this,'custom_shortcode_func'));

              add_shortcode('rating',array($this,'custom_shortcode_rating'));

              add_action( 'wp_enqueue_scripts', array($this,'custom_css') );

              add_filter( 'woocommerce_add_to_cart_validation', array($this,'remove_cart_item_before_add_to_cart'));

              add_action('woocommerce_after_checkout_form', array($this,'debounce_add_jscript_checkout'));
			
			add_filter('woocommerce_create_account_default_checked', '__return_true');

              


              add_filter( 'woocommerce_checkout_fields', array($this,'change_order_note_label' ));

             

              add_action('rest_api_init', function () {
                register_rest_route( 'happyhours/v1','delete', array(
                          'methods'  => 'POST',
                          'callback' =>  array( $this, 'delete' )
                ));
              });

              add_action('rest_api_init', function () {
                register_rest_route( 'happyhours/v1','image', array(
                          'methods'  => 'POST',
                          'callback' =>  array( $this, 'image' )
                ));
              });

              add_action('rest_api_init', function () {
                register_rest_route( 'rating/v1','rating', array(
                          'methods'  => 'POST',
                          'callback' =>  array( $this, 'rating' )
                ));
              });

             
              add_action('rest_api_init', function () {
                register_rest_route( 'happyhours/v1','edit', array(
                          'methods'  => 'POST',
                          'callback' =>  array( $this, 'edit' )
                ));
              });

              add_action('rest_api_init', function () {
                register_rest_route( 'happyhours/v1','pid', array(
                          'methods'  => 'POST',
                          'callback' =>  array( $this, 'pid' )
                ));
              });

              add_action('woocommerce_after_order_notes', array($this,'custom_checkout_field'));

        			add_action('woocommerce_checkout_update_order_meta',array($this,'custom_checkout_fields_update_order_meta' ));

            
              add_action( 'woocommerce_order_status_completed', array($this,'wdesk_inser_data' ));

              add_action('woocommerce_admin_order_data_after_billing_address',array($this,'edit_woocommerce_checkout_page'));

              add_action( 'woocommerce_payment_complete', array($this,'processing_to_completed'));
			
		add_filter( 'woocommerce_default_address_fields' , array($this,'filter_default_address_fields', 20, 1 ));
		
      add_filter( 'woocommerce_endpoint_order-received_title', array($this,'misha_thank_you_title' ));
 
			add_action( 'woocommerce_thankyou', array($this,'bbloomer_add_content_thankyou' ));
			
			add_filter( 'woocommerce_order_button_text', array($this,'woo_custom_order_button_text' ));
			
			remove_action( 'woocommerce_checkout_order_review',  array($this,'woocommerce_checkout_before_order_review_heading', 10 ));
			
			add_action( 'woocommerce_checkout_before_order_review_heading',  array($this,'youroder_remove_title'));
	
			
        }

	
		function yourorder_remove_title() {
echo '';
}

		

		function woo_custom_order_button_text() {
    return __( 'Submit Ticket', 'woocommerce' ); 
}
		
		function bbloomer_add_content_thankyou() {
  		
			 echo '<button onclick=window.location="https://consociatesolutions.com/custom_development/"; type="button" class="btn btn-primary close" data-dismiss="modal">Go to home</button>';
}
		

				function filter_default_address_fields( $address_fields ) {
					// Only on checkout page
					if( ! is_checkout() ) return $address_fields;

					// All field keys in this array
					$key_fields =array('country','first_name','last_name','company','address_1','address_2','city','state','postcode');

					// Loop through each address fields (billing and shipping)
					foreach( $key_fields as $key_field )
						$address_fields[$key_field]['required'] = false;

					return $address_fields;
				}

        function processing_to_completed($order_id){
            $order = new WC_Order($order_id);
            $order->update_status('completed'); 
        
        }

        function custom_checkout_field($checkout)

            {

            echo '<div id="custom_checkout_field">';

            woocommerce_form_field('custom_field_name', array(

            'type' => 'text',

            'class' => array('my-field-class form-row-wide') ,

            'label' => __('Subject') ,


            ) ,

            $checkout->get_value('custom_field_name'));

            echo '</div>';


            woocommerce_form_field('custom_field_name1', array(

                'type' => 'text',
    
                'class' => array('my-field-class form-row-wide') ,
    
                'label' => __('Description') ,
            
    
                ) ,
    
                $checkout->get_value('custom_field_name1'));
    
                

            }


            

            function custom_checkout_fields_update_order_meta( $order_id ) {
                update_post_meta( $order_id, 'custom_field_name', sanitize_text_field( $_POST['custom_field_name'] ) );
                update_post_meta( $order_id, 'custom_field_name1', sanitize_text_field( $_POST['custom_field_name1'] ) );

            }

            function wdesk_inser_data($order_id)
            {

                if ( ! $order_id ) {
                    return;
                  }
                 
                $order = wc_get_order( $order_id );

                $json=json_encode($order);
                 
                global $wpdb;
                $subject=$order->get_meta('custom_field_name');
                $description=$order->get_meta('custom_field_name1');
                $email=$order->get_meta('_billing_email');
                
                // 
               
                $order = wc_get_order( $order_id );
                $items = $order->get_items();
        
        
                foreach ( $items as $item ) {
                    $product_name = $item->get_name();
                    $product_id = $item->get_product_id();
                }


                $table_name_priority = $wpdb->prefix . "first_table"; 
            $results = $wpdb->get_results ( "SELECT * FROM $table_name_priority where product='$product_id'");


              $p=json_encode($results);

              $pi=json_decode($p);
            
              foreach ($pi as $pit) {
                # code...
               $pits= $pit->priority;
              }
                // 

                $table_name = $wpdb->prefix . "wsdesk_tickets";
                $output = $wpdb->insert( $table_name, 
                array(
                'ticket_author'   => ( is_user_logged_in() ) ? get_current_user_id() : 0,
                'ticket_date'     => gmdate( 'M d, Y h:i:s A' ),
				'ticket_updated'  => current_time( 'mysql' ),
                'ticket_email' => $email,
                'ticket_title' => $subject,
                'ticket_content'=>$description,
                'ticket_parent'   => 0,
				'ticket_category' => 'raiser_reply',
				'ticket_vendor'   => '',
				'ticket_trash'    => 0,
                'priority'        =>$pits
            ));



            $id = $wpdb->insert_id;

            update_post_meta( $order_id, 'ticket_id', $id );

           

            
            $table_names = $wpdb->prefix . "wsdesk_ticketsmeta";

            $resul=$wpdb->insert( $table_names, 
            array(
            'ticket_id'   => $id,
            'meta_key'     => 'ticket_label',
            'meta_value'  => 'label_LL01'
        ));


        $order = wc_get_order( $order_id );
        $items = $order->get_items();


        foreach ( $items as $item ) {
            $product_name = $item->get_name();
            $product_id = $item->get_product_id();
        }

           $resul=$wpdb->insert( $table_names, 
            array(
            'ticket_id'   => $id,
            'meta_key'     => 'productid',
            'meta_value'  => $product_id
        ));

        $resul=$wpdb->insert( $table_names, 
        array(
        'ticket_id'   => $id,
        'meta_key'     => 'productname',
        'meta_value'  => $product_name
    ));



              $table_name_priority = $wpdb->prefix . "first_table"; 
              $results = $wpdb->get_results ( "SELECT * FROM $table_name_priority where product='$product_id'");


              $p=json_encode($results);

              $pi=json_decode($p);
            
              foreach ($pi as $pit) {
                # code...
               $pits= $pit->priority;
              }

              $resul=$wpdb->insert( $table_names, 
                array(
                'ticket_id'   => $id,
                'meta_key'     => 'priority',
                'meta_value'  => $pits
            ));



            }


            


                    function edit_woocommerce_checkout_page($order){



                        echo '<p><strong>'.__('Subject').':</strong><br>' . $order->get_meta('custom_field_name') . '</p>';

                        echo '<p><strong>'.__('Description').':</strong><br>' . $order->get_meta('custom_field_name1') . '</p>';

                        echo '<p><strong>'.__('Ticket ID').':</strong><br>' . $order->get_meta('ticket_id') . '</p>';
                    }
            

                        function change_order_note_label( $fields ) {

                        $fields['order']['order_comments']['label'] = 'Subject';
                        $fields['order']['order_comments']['placeholder'] = '';
                        return $fields;
                    }
        
        function debounce_add_jscript_checkout()
        {
            wp_enqueue_script('menuplugin-admin_css7',CRUD_URL.'assests/js/checkout.js');
        }

        function custom_css()
        {
            wp_enqueue_style('menuplugin-admin_css5', CRUD_URL.'assests/css/front_end.css');
            wp_enqueue_script('menuplugin-admin_css6',CRUD_URL.'assests/js/front_end.js');
           


            wp_localize_script('menuplugin-admin_css6', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php')));

            
        }



       
      function custom_add_to_cart()
      {

        include( CRUD_PATH. 'include/api/addtocart.php' );
      }

      function custom_shortcode_rating() {

        global $wpdb;
        $table_name = $wpdb->prefix . "wsdesk_tickets";
        $sql =  $wpdb->get_results( "SELECT round(Avg(rating),1) as rating FROM $table_name");
        foreach($sql as $s)
        {

            // print_r($s->rating);

            $rating= $s->rating; 
        
                ?>
            <p>
                <div class="placeholder" style="color: lightgray;">
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                    <span class="small"><?php echo( $rating) ?>/5</span>
                </div>
        
                <div class="overlay" style="position: relative;top: -22px;">
                    <?php
                    while($rating>0)
                    {
                        if($rating >0.5)
                        {
                            ?>
                            <i class="fas fa-star"></i>
                        <?php
                        }
                            else
                            {
                                ?>
                            <i class="fas fa-star-half"></i>
                           <?php 
                            }
        
                       $rating--;
                        }
                    }
        ?>
                </div> 
            </p>
            <?php
       }


        function custom_shortcode_func() {

            global $wpdb;
            $table_name = $wpdb->prefix . "first_table";
            $sql =  $wpdb->get_results( "SELECT title,product FROM $table_name");

            $products = wc_get_products( array( 'status' => 'publish'));

           ?>
  
          <h5 class="heading">Select Services <span class="input_required">*</span></h5>
         <div class="box">
			 
           <?php foreach($sql as $s)
           {
            foreach($products as $product)
            {

                  if($s->product==$product->get_id()){


                    $id=$product->get_id();
                    $title=$product->get_title();
                    $price=$product->get_price();
         
            ?>
           
           <div class="details">
          
           <input hidden type="radio"  id="<?php echo $title; ?>" name="radio" value="<?php echo $id; ?>">
           <label for="<?php echo $title; ?>">
            <h5><?php echo $title; ?></h5>
            <h5>₹ <?php echo $price; ?></h5>
            <div class="hidebtn">
            <?php echo do_shortcode( '[add_to_cart id='.$id.']' )?>
            </div>
          </label>
          </div>
         <?php 
        }
    }

     
}

      ?>

         </div>
         <a href=""  class="btn btn-primary alt wc-forward wp-element-button">Submit Ticket</a>
         
            <?php
        }
            
            

            function dropdownview()
            {
                $table_name_priority = $wpdb->prefix . "first_table"; 
                $results = $wpdb->get_results ( "SELECT * FROM $table_name_priority ORDER BY `priority`");

                $abc="<select>";
                foreach ($results as $view) {
                    $abc.="<option  value='$view->priority'>$view->title</option>";
                  }
    
                  $abc.="</select>";
                  return $abc;

            }

        function remove_cart_item_before_add_to_cart( $product_id) {
            if( ! WC()->cart->is_empty() )
                WC()->cart->empty_cart();
            return $product_id;
        }

        function edit($request) {

            include( CRUD_PATH. 'include/api/update_data.php' );
        }


        function alertmessage($mssg_type, $mssg ){

            echo "<div class=$mssg_type>$mssg</div>";
        }

        function delete($request) {

        include( CRUD_PATH. 'include/api/delete_data.php' );
    }

    function image($request) {

        include( CRUD_PATH. 'include/api/imageupload.php' );
    }


    function rating($request) {

        include( CRUD_PATH. 'include/api/rating.php' );
    }


    function pid($request) {

        include( CRUD_PATH. 'include/api/addtocart.php' );
    }



        function hooks( $hook )
        {

        
        wp_register_script('menuplugin-admin_js', CRUD_URL.'assests/js/jquery.min.js' ,array('jquery'),false,true);

        wp_register_script('menuplugin-admin_js1', CRUD_URL.'assests/js/datatables.min.js' ,array('jquery'),false,true);

        wp_register_script('menuplugin-admin_js2', CRUD_URL.'assests/js/bootstrap.min.js' ,array('jquery'),false,true);

        wp_register_script('menuplugin-admin_js2', CRUD_URL.'assests/js/bootstrap.min.js' ,array('jquery'),false,true);

        wp_register_script('menuplugin-admin_js3', CRUD_URL.'assests/js/custom.js' ,array('jquery'),false,true);

        wp_localize_script( 'menuplugin-admin_js3', 'wnm_custom', array( 'base_url' => BASE_URL));
        // wp_localize_script( 'menuplugin-admin_js3', 'wnm_custom', array( 'plugin_url' => CRUD_URL));


        wp_localize_script('menuplugin-admin_js3', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php')));

       

        wp_register_script('menuplugin-admin_js4', "https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js");


        // 

        wp_register_style('menuplugin-admin_css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css');

        wp_register_style('menuplugin-admin_css1', 'https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css');

        wp_register_style('menuplugin-admin_css2', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css');

        wp_register_style('menuplugin-admin_css3', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');


        wp_register_style('menuplugin-admin_css4', CRUD_URL.'assests/css/custom.css');

			
			 $page = ( isset( $_GET['page'] ) ? sanitize_text_field( $_GET['page'] ) : '' );
       
        if( 'crud_plugin' ==  $page)
        { 
        
            wp_enqueue_script( 'menuplugin-admin_js' );

            wp_enqueue_script( 'menuplugin-admin_js1' );

            wp_enqueue_script( 'menuplugin-admin_js2' );

            wp_enqueue_script( 'menuplugin-admin_js3' );

            wp_enqueue_script( 'menuplugin-admin_js4' );


            

           
            // 

            wp_enqueue_style( 'menuplugin-admin_css' );

            wp_enqueue_style( 'menuplugin-admin_css1' );

            wp_enqueue_style( 'menuplugin-admin_css2' );

            wp_enqueue_style( 'menuplugin-admin_css3' );

            wp_enqueue_style( 'menuplugin-admin_css4' );
            

          

            

        }

        
        
   

    }



        function theme_options_panel(){
            
            // add_menu_page(
            //     'Wsdesk_tickets Addon', 
            //     'WS_Ticket Addon', 
            //     'manage_options', 
            //     'crud_plugin', 
            //     array($this, 'crud_menupage'),
            //     'dashicons-admin-users',
            //     1);

                add_submenu_page(

                    'wsdesk_tickets',
                    'WS_Ticket Addon',
                    'Priority',
                    'manage_options',
                    'crud_plugin', 
                    array($this, 'crud_menupage'),
                );
          }

          function mt_add_pages() {
            
        }        

        function crud_menupage(){
            include(CRUD_PATH."menupage_template.php");
        }

        function create_db_table(){
            
            include(CRUD_PATH.'first_db/createdb.php' );

        }

        function remove_db_table() {
        
            include( CRUD_PATH.'first_db/removedb.php' );

        }

        function insert() {
        
            include( CRUD_PATH.'first_db/insert.php' );

        }

        

        

    
    }
}

if(class_exists( 'CrudClass' ) ){
    $crud = new CrudClass();
    $crud->register();
}

register_activation_hook( __FILE__, array( $crud, 'create_db_table' ) );

register_deactivation_hook( __FILE__, array( $crud, 'remove_db_table' ) );

