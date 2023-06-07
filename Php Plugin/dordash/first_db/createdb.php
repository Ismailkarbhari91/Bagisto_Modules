<?php 

if ( ! defined( 'ABSPATH' ) ) {

    die;

}

        global $wpdb;
	    	$table_name = $wpdb->prefix . "doordash_details";
      
      $charset_collate = $wpdb->get_charset_collate();

      $sql = "CREATE TABLE IF NOT EXISTS " . $table_name . " (
        id int NOT NULL AUTO_INCREMENT,
        vendor_id varchar(255) NOT NULL,
        kiosk_id varchar(255) NOT NULL,
        vpassword varchar(255) NOT NULL,
        base_url varchar(255) NOT NULL,
        minimum_order varchar(255) NOT NULL,
        user_name varchar(255) NOT NULL,
        area_range varchar(255) NOT NULL,
        PRIMARY KEY  (id)
      ) $charset_collate;";


      // 

      $table_name1 = $wpdb->prefix . "providers";
      
      $charset_collate = $wpdb->get_charset_collate();

      $sql1 = "CREATE TABLE IF NOT EXISTS " . $table_name1 . " (
        id int NOT NULL AUTO_INCREMENT,
        title varchar(255) NOT NULL,  
        PRIMARY KEY  (id)
      ) $charset_collate;";

      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);
      dbDelta($sql1);

