<?php

 $parameters = $request->get_json_params();

//  print_r($parameters);
$id=$parameters['data']['id'];
global $wpdb;
$table_name = $wpdb->prefix . "first_table";
$sql = "DELETE FROM $table_name WHERE id=$id";
$wpdb->query($sql);

$return = array(
    'message'  => 'Updated'
);
return wp_send_json($return);
