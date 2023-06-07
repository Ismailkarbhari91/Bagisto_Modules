<?php


  $id = $_REQUEST['id'];

  $title=$_REQUEST['title'];
 
  global $wpdb;
  $table_name = $wpdb->prefix . "providers";



                $sql = $wpdb->update($table_name, array(
                    'title'=>$title),
                      array('id'=>$id));
                $wpdb->query($sql);


                $return = array(
                    'message'  => 'Updated'
                );
                

            return wp_send_json_success($return);
        