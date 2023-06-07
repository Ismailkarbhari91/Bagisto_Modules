<?php

$parameters = $request->get_json_params();

//  print_r($parameters);
$id=$parameters['id'];
$rating=$parameters['rating'];

// print_r($parameters);
// echo $rating;
global $wpdb;
$table_name = $wpdb->prefix . "wsdesk_tickets";
$sql = $wpdb->update($table_name, array(
    'rating'=>$rating),
      array('ticket_id'=>$id));
$wpdb->query($sql);
 
$return = array(
    'message'  => 'Updated'
);
return $return;