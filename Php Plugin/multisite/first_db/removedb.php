<?php 

if ( ! defined( 'ABSPATH' ) ) {

    die;

}

	 global $wpdb;
     $table_name = $wpdb->prefix . "state";
     $sql = "DROP TABLE IF EXISTS $table_name";
     $wpdb->query($sql);

     $response = array(
        'data' =>'Delete' );

    
     $table_name1 = $wpdb->prefix . "area";
     $sql1 = "DROP TABLE IF EXISTS $table_name1";
     $wpdb->query($sql1);

     $response = array(
        'data' =>'Delete' );


    