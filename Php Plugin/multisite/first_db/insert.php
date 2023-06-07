<?php


  $fname=$_REQUEST['title'];

  $lname= $_REQUEST['website'];


  echo $fname;
  echo $lname;
 
  global $wpdb;
  $table_name = $wpdb->prefix . "state";


  $output = $wpdb->insert( $table_name, 
            array(
            'title' => $fname,
            'website' => $lname
            ));

        
                $response = array(
                        'data' => array(
                        'title' => $fname,
                        'website' => $lname
                        ),
                );

        return wp_send_json_success($response);    
          
                     
        