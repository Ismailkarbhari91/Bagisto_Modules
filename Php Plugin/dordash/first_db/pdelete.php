<?php


  $id = $_REQUEST['id'];

  global $wpdb;
$table_name = $wpdb->prefix . "providers";
$sql = "DELETE FROM $table_name WHERE id=$id";
$wpdb->query($sql);

$return = array(
    'message'  => 'Deleted'
);
return wp_send_json($return);
