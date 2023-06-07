<?php

$parameters = $request->get_json_params();

//  print_r($parameters);
$id=$parameters['areatitle'];
$rating=$parameters['state'];
$pincode=$parameters['pincode'];
$address=$parameters['address'];

// print_r($parameters);
// echo $rating;
global $wpdb;
$table_name = $wpdb->prefix . "area";
$sql = $wpdb->insert( $table_name, 
            array(
            'title' => $id,
            'state' => $rating,
            'pincode' => $pincode,
            'address' => $address,
            ));
$wpdb->query($sql);
 
$return = array(
    'message'  => 'Inserted'
);
return wp_send_json_success($return);