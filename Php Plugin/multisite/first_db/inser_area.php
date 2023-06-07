<?php


  $fname=$_REQUEST['areatitle'];

  $lname= $_REQUEST['state'];


  echo $fname;
  echo $lname;
 
  global $wpdb;
  $table_name = $wpdb->prefix . "area";


  $output = $wpdb->insert( $table_name, 
            array(
            'title' => $fname,
            'state' => $lname
            ));

        
                $response = array(
                        'data' => array(
                        'title' => $fname,
                        'state' => $lname
                        ),
                );

        return wp_send_json_success($response);    
          
                     
        