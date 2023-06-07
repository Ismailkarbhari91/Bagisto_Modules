<?php

$parameters = $request->get_json_params();

//  print_r($parameters);
$id=$parameters['data']['id'];
$title=$parameters['data']['title'];
$product=$parameters['data']['product'];
$priority=$parameters['data']['priority'];
global $wpdb;
$table_name = $wpdb->prefix . "first_table";
$sql = $wpdb->update($table_name, array(
    'title'=>$title,'product'=>$product,
      'priority'=>$priority),
      array('id'=>$id));
$wpdb->query($sql);
 
$return = array(
    'message'  => 'Updated'
);
return wp_send_json_success($return);