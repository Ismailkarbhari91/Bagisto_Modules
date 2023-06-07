<?php 
$parameters = $request->get_json_params();
// $id=$parameters['name'];
global $wpdb;
$table_name = $wpdb->prefix . "area";
$table_name1 = $wpdb->prefix . "state"; 
$results = $wpdb->get_results ( "SELECT `title`,`state`, `pincode`, `address` FROM $table_name");
foreach($results as $sq)
{

    $title = $sq->title;
    // echo $title;
    $state = $sq->state;
    // echo $state;
    $pincode = $sq->pincode;
    $address = $sq->address;
    $web = $wpdb->get_results ( "SELECT `website` FROM $table_name1 where id IN ($state)");
    // print_r($web);
    foreach($web as $w)
    { 
        $url_id = $w->website;
        // echo $url_id;
    $url = get_home_url($blog_id = $url_id);
    // echo $url;

}
$response[] = array(
    array(
   'url' => $url,
   'state' => $state,
   'title' => $title,
   'pincode' => $pincode,
   'address' => $address
   ),
);
}

return wp_send_json_success($response);