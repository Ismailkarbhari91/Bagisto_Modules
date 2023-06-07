<?php


  $fname=$_REQUEST['title'];

  $lname= $_REQUEST['product'];

  $priority=$_REQUEST['priority'];

  echo $fname;
  echo $lname;
 
  global $wpdb;
  $table_name = $wpdb->prefix . "first_table";


  $output = $wpdb->insert( $table_name, 
            array(
            'title' => $fname,
            'product' => $lname,
            'priority'=>$priority
            ));

        
                $response = array(
                        'data' => array(
                        'title' => $fname,
                        'product' => $lname,
                        'priority'=>$priority
                        ),
                );

            return wp_send_json_success($response);
        