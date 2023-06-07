<?php

 $parameters = $request->get_json_params();

//  print_r($parameters);
$id=$parameters['id'];
global $wpdb;
$table_name = $wpdb->prefix . "area";
$sql = "DELETE FROM $table_name WHERE id=$id";
$wpdb->query($sql);

$return = array(
    'message'  => 'Area Deleted'
);
return wp_send_json($return);
