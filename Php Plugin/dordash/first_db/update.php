<?php


  $id = $_REQUEST['id'];

  $vendid=$_REQUEST['vendor_id'];

  $kiosid= $_REQUEST['kiosk_id'];

  $pass=$_REQUEST['vpassword'];

  $base_url=$_REQUEST['base_url'];

  $user_name = $_REQUEST['user_name'];

  $minimum_order = $_REQUEST['minimum_order'];

  $area_range = $_REQUEST['area_range'];


 
  global $wpdb;
  $table_name = $wpdb->prefix . "doordash_details";



                $sql = $wpdb->update($table_name, array(
                    'vendor_id'=>$vendid,'kiosk_id'=>$kiosid,'vpassword'=>$pass,'base_url'=>$base_url,'user_name'=>$user_name,'minimum_order'=>$minimum_order,'area_range'=>$area_range),
                      array('id'=>$id));
                $wpdb->query($sql);


                $return = array(
                    'message'  => 'Updated'
                );
                

            return wp_send_json_success($return);
        