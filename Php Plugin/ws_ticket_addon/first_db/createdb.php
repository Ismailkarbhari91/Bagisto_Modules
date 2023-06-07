<?php 

if ( ! defined( 'ABSPATH' ) ) {

    die;

}

        global $wpdb;
	    	$table_name = $wpdb->prefix . "first_table";
      
      $charset_collate = $wpdb->get_charset_collate();

      $sql = "CREATE TABLE IF NOT EXISTS " . $table_name . " (
        id int NOT NULL AUTO_INCREMENT,
        title varchar(255) NOT NULL,
        product varchar(255) NOT NULL,
        priority varchar(255),  
        PRIMARY KEY  (id)
      ) $charset_collate;";

      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);

