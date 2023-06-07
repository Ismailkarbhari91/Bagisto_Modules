<?php

/**
 * Plugin Name:       Multisite Plugin
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           1.10.3
 * Author:            Multisite Plugin
 * Author URI:        https://facebook.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       multisite
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {

    die;
}

define('MULTI_URL', plugin_dir_url( __FILE__ ) );
define('MULTI_PATH', plugin_dir_path( __FILE__ ) );
define('BASE_URL', get_option( 'siteurl' ));


if(!class_exists( 'MultiPluginClass' ) ){

    class MultiPluginClass{
        function register(){

            add_action('admin_menu', array($this, 'theme_options_panel'));
            add_action('admin_enqueue_scripts', array($this, 'hooks') );
            add_action("wp_ajax_insert", array($this,'insert'));
            add_action("wp_ajax_nopriv_insert", array($this,'insert'));
            add_action("wp_ajax_insert_new", array($this,'insert_new'));
            add_action("wp_ajax_nopriv_insert_new", array($this,'insert_new'));
            add_shortcode('customshortcode',array($this,'custom_shortcode_func'));
            add_action('wp_enqueue_scripts', array($this,'custom_css'));

            // api

            add_action('rest_api_init', function () {
                register_rest_route( 'area/v1','area', array(
                          'methods'  => 'POST',
                          'callback' =>  array( $this, 'area' )
                ));
              });

              add_action('rest_api_init', function () {
                register_rest_route( 'area/v1','area_name', array(
                          'methods'  => 'POST',
                          'callback' =>  array( $this, 'area_name' )
                ));
              });

              add_action('rest_api_init', function () {
                register_rest_route( 'area/v1','website_name', array(
                          'methods'  => 'POST',
                          'callback' =>  array( $this, 'website_name' )
                ));
              });

              add_action('rest_api_init', function () {
                register_rest_route( 'area/v1','website_like', array(
                          'methods'  => 'POST',
                          'callback' =>  array( $this, 'website_like' )
                ));
              });

              add_action('rest_api_init', function () {
                register_rest_route( 'area/v1','delete', array(
                          'methods'  => 'POST',
                          'callback' =>  array( $this, 'delete' )
                ));
              });


              add_action('rest_api_init', function () {
                register_rest_route( 'area/v1','delete_area', array(
                          'methods'  => 'POST',
                          'callback' =>  array( $this, 'delete_area' )
                ));
              });

              add_action('rest_api_init', function () {
                register_rest_route( 'area/v1','update_area', array(
                          'methods'  => 'POST',
                          'callback' =>  array( $this, 'update_area' )
                ));
              });

              add_action('rest_api_init', function () {
                register_rest_route( 'area/v1','update_state', array(
                          'methods'  => 'POST',
                          'callback' =>  array( $this, 'update_state' )
                ));
              });

              add_action('rest_api_init', function () {
                register_rest_route( 'area/v1','website_all', array(
                          'methods'  => 'POST',
                          'callback' =>  array( $this, 'website_all' )
                ));
              });
        
        }
       
        function theme_options_panel(){
            
            add_menu_page(
                'Multi Plugin Menu', 
                'State', 
                'manage_options', 
                'multi_site', 
                array($this, 'multi_menupage'),
                'dashicons-admin-site',
                1);

                add_submenu_page(
                    'multi_site',
                    'Multi Plugin Menues',
                    'Area',
                    'manage_options',
                    'area_site', 
                    array($this, 'area_menupage'),
                );
          }

          function area_menupage(){
            include(MULTI_PATH."sub_menu_template.php");
        }

          function multi_menupage(){
            include(MULTI_PATH."menupage_template.php");
        }

        function hooks( $hook )
        {

        
        wp_register_script('menuplugin-admin_js', MULTI_URL.'assests/js/jquery.min.js' ,array('jquery'),false,true);

        wp_register_script('menuplugin-admin_js1', MULTI_URL.'assests/js/datatables.min.js' ,array('jquery'),false,true);

        wp_register_script('menuplugin-admin_js2', MULTI_URL.'assests/js/bootstrap.min.js' ,array('jquery'),false,true);

        wp_register_script('menuplugin-admin_js2', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js' ,array('jquery'),false,true);

        wp_register_script('menuplugin-admin_js4', "https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js");

        wp_register_script('menuplugin-admin_js3', MULTI_URL.'assests/js/custom.js' ,array('jquery'),false,true);

        wp_localize_script('menuplugin-admin_js3', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php')));
        wp_localize_script( 'menuplugin-admin_js3', 'wnm_custom', array( 'base_url' => BASE_URL));


        // 

        wp_register_style('menuplugin-admin_css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css');

        wp_register_style('menuplugin-admin_css1', 'https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css');

        wp_register_style('menuplugin-admin_css2', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css');

        wp_register_style('menuplugin-admin_css3', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');

        wp_register_style('menuplugin-admin_css4', MULTI_URL.'assests/css/custom.css');
        

        $page = ( isset( $_GET['page'] ) ? sanitize_text_field( $_GET['page'] ) : '' );
       
        // multi

        if( 'multi_site' ==  $page)
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

        if( 'state_site' ==  $page)
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

        // area
    
        if( 'area_site' ==  $page)
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

        // 

        }

        function create_db_table(){
            
            include(MULTI_PATH.'first_db/createdb.php' );

        }

        function remove_db_table() {
        
            include(MULTI_PATH.'first_db/removedb.php' );

        }

        function insert() {
        
            include(MULTI_PATH.'first_db/insert.php' );

        }

        function insert_new() {
        
            include(MULTI_PATH.'first_db/inser_area.php' );

        }

        function area($request) {

            include( MULTI_PATH. 'include/api/area.php' );
        }

        function area_name($request) {

            include( MULTI_PATH. 'include/api/area_name.php' );
        }

        function website_like($request) {

            include( MULTI_PATH. 'include/api/website_like.php' );
        }

        function website_all($request) {

            include( MULTI_PATH. 'include/api/website_all.php' );
        }

        function website_name($request) {

            include( MULTI_PATH. 'include/api/website_name.php' );
        }

        function delete($request) {

            include( MULTI_PATH. 'include/api/delete_data.php' );
        }

        function delete_area($request) {

            include( MULTI_PATH. 'include/api/delete_area.php' );
        }

        function update_area($request) {

            include( MULTI_PATH. 'include/api/update_area.php' );
        }

        function update_state($request) {

            include( MULTI_PATH. 'include/api/state_update.php' );
        }

        function custom_css()
        {
    
            wp_enqueue_script('menuplugin-admin_css6',MULTI_URL.'assests/js/front_end.js' ,array('jquery'),false,true);
            wp_localize_script( 'menuplugin-admin_css6', 'wnm_custom', array( 'base_url' => BASE_URL));
            wp_enqueue_style('menuplugin-admin_css5',MULTI_URL.'assests/css/front_end.css');
              
        }

        function custom_shortcode_func() {

            ?>
<button id="btnchange" class="btnchange">Order Online</button>
<section class="popup">
  <div class="popup__content">
    <h3 id="location">Select Location</h3>
    <div class="close">
      <span></span>
      <span></span>
    </div>
    <div class="estate">
    <input type="text" class="form-control" id="test" placeholder="Enter State">
        </div>
    <div class="apend" id="apend"> 
         </div>
  </div>
</section>
            <?php
        }
    }
    }



    if(class_exists( 'MultiPluginClass' ) ){
        $crud = new MultiPluginClass();
        $crud->register();
    }

    register_activation_hook( __FILE__, array( $crud, 'create_db_table' ) );

    register_deactivation_hook( __FILE__, array( $crud, 'remove_db_table' ) );

    