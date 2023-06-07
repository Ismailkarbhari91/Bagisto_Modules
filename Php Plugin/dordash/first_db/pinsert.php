<?php


  $title=$_REQUEST['title'];

  global $wpdb;
  $table_name = $wpdb->prefix . "providers";


  $output = $wpdb->insert( $table_name, 
            array(
            'title' => $title
            ));

        
                $response = array(
                        'data' => array(
                            'title' => $title
                        ),
                );

            return wp_send_json_success($response);
        