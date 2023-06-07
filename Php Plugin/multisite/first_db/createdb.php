<?php 

if ( ! defined( 'ABSPATH' ) ) {

    die;

}

        global $wpdb;
	    	$table_name = $wpdb->prefix . "state";
      
      $charset_collate = $wpdb->get_charset_collate();

      $sql = "CREATE TABLE IF NOT EXISTS " . $table_name . " (
        id int NOT NULL AUTO_INCREMENT,
        title varchar(255) NOT NULL,
        website varchar(255) NOT NULL,  
        PRIMARY KEY  (id)
      ) $charset_collate;";


      // 

      $table_name1 = $wpdb->prefix . "area";
      
      $charset_collate = $wpdb->get_charset_collate();

      $sql1 = "CREATE TABLE IF NOT EXISTS " . $table_name1 . " (
        id int NOT NULL AUTO_INCREMENT,
        title varchar(255) NOT NULL,
        state varchar(255) NOT NULL,
        pincode varchar(255),
        address varchar(255),  
        PRIMARY KEY  (id)
      ) $charset_collate;";

      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);
      dbDelta($sql1);

