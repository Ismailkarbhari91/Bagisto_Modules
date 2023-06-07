<?php

$parameters = $request->get_json_params();

//  print_r($parameters);
$id=$parameters['id'];
$title=$parameters['title'];
$product=$parameters['state'];
$pincode=$parameters['pincode'];
$address=$parameters['address'];
global $wpdb;
$table_name = $wpdb->prefix . "area";
$sql = $wpdb->update($table_name, array(
    'title'=>$title,'state'=>$product,'pincode'=>$pincode,'address'=>$address),
      array('id'=>$id));
$wpdb->query($sql);
 
$return = array(
    'message'  => 'Updated'
);
return wp_send_json_success($return);