<?php 
$parameters = $request->get_json_params();
$id=$parameters['name'];
// print($id);
global $wpdb;
$table_name = $wpdb->prefix . "area"; 
$results = $wpdb->get_results ( "SELECT `state` FROM $table_name where title='$id'");
return wp_send_json_success($results);