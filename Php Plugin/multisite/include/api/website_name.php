<?php 
$parameters = $request->get_json_params();
$id=$parameters['id'];
// print($id);
global $wpdb;
$table_name = $wpdb->prefix . "state"; 
$results = $wpdb->get_results ( "SELECT `website` FROM $table_name where id=$id");
foreach($results as $sq)
{

    $state = $sq->website;
    $url = get_home_url($blog_id = $sq->website);
    // echo($url);
}

$response = array(
     array(
    'url' => $url,
    'state' => $state
    ),
);

return wp_send_json_success($response);