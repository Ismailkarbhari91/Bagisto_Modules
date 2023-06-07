<?php

$parameters = $request->get_json_params();

//  print_r($parameters);
$id=$parameters['id'];
$title=$parameters['title'];
$product=$parameters['website'];
global $wpdb;
$table_name = $wpdb->prefix . "state";
$sql = $wpdb->update($table_name, array(
    'title'=>$title,'website'=>$product),
      array('id'=>$id));
$wpdb->query($sql);
 
$return = array(
    'message'  => 'Updated'
);
return wp_send_json_success($return);