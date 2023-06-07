<?php

$id = $_GET['id'];

echo $id;

global $wpdb;
$table_name = $wpdb->prefix . "wp_state";
echo $table_name;
$sql = "DELETE FROM wp_first_table WHERE id=1";
$wpdb->query($sql);
