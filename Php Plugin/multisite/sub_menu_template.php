<div class="container-fluid" style="margin-top:30px !important;">
        <div class="container">
            <div class="row mb-2">
                <div class="col-md-9">
                    <h1>Area</h1>
                </div>
                <div class="col-md-3">
                    <button type="button" id="insert-btn" class="btn btn-primary" style="float: right;">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            <div class="card mb-3" id="form-body">
                <div class="card-header">
                    Insert Data
                </div>
                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <label>Area </label>
                            <input type="text" class="form-control" id="areatitle" placeholder="Enter Area">
                        </div>
                        <?php
             $key;

             global $wpdb;
              $table_name = $wpdb->prefix . "state"; 
              $result = $wpdb->get_results ( "SELECT * FROM ". $table_name );
            ?>
                        <div class="form-group mt-2">
                            <label>State</label><br>
                            <select name="state" id="state">
                            <?php foreach( $result as $user) {
                                ?>
                    <option value="<?php echo $user->id; ?>"><?php echo $user->title; ?></option>
                    <?php
                            }
                          ?>
                          </select>
                        </div>
						<div class="form-group">
                            <label>Pin Code</label>
                            <input type="text" class="form-control" id="areepincode" placeholder="Enter Pincode">
                        </div>
						<div class="form-group">
                            <label>Address</label>
                            <input type="text" class="form-control" id="areaaddress" placeholder="Enter Pincode">
                        </div>
                        <button name="ssubmit" type="submit" class="btn btn-primary mt-2" id="areasubmit">Submit</button>
                    </form>
                </div>
            </div>
            <table id="tblUser">
                <thead>
                    <th>Id</th>
                    <th>Area</th>
                    <th>State</th>
                    <th>Pincode</th>
                    <th>Address</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php
                     global $wpdb;
                     $table_name = $wpdb->prefix . "area"; 
                     $result = $wpdb->get_results ( "SELECT * FROM ". $table_name );
                     foreach( $result as $user) {
                        $table_name1 = $wpdb->prefix . "state"; 
                        $state = $wpdb->get_results ( "SELECT * FROM ". $table_name1 );
                        foreach( $state as $sta) {
                            if($user->state==$sta->id)
                        {
                        $stitle=$sta->title;
                        ?>
                        <tr>
                            <td><?php echo ++$key; ?><input type="hidden" class="state_id" value=<?php echo $user->id ?>></td>
                            <td><?php echo $user->title; ?></td>
                            <td><?php echo $stitle; ?><input type="hidden" class="state_id" value=<?php echo $user->state ?>></td> 
                            <td><?php echo $user->pincode; ?></td> 
                            <td><?php echo $user->address; ?></td>      
                            <td>
                                <a href="" class="btn btn-primary btn-sm area_edit"><i class="fa fa-pencil-square-o"></i></a>
                                <a href="" id="<?php echo $user->id ?>" class="btn btn-danger btn-sm area_delete"><i class="fa fa-trash"></i></a>
                            
                            </td>
                        </tr>
                        <?php
                        }
                        }
                     }
                        ?>
                </tbody>
            </table>
        </div>
    </div>


    <!--  -->

    <div class="modal fade" id="myareaModal" role="dialog">
<div class="modal-dialog">
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title">Update</h4>
    </div>
    <div class="modal-body">
    <input type="hidden" class="form-control" id="arae_id">
    <label>Title </label>
    
                            <input type="text" class="form-control" id="area_title" placeholder="Enter Title">
                            </div>
                            <div class="form-group mt-2 pop_product">
                            <label class="plabel">State</label><br>
                            <select name="astate" id="astate">
                            <?php
                     global $wpdb;
                    //  $table_name = $wpdb->prefix . "area"; 
                    //  $result = $wpdb->get_results ( "SELECT * FROM ". $table_name );
                    //  foreach( $result as $user) {
                        $table_name1 = $wpdb->prefix . "state"; 
                        $state = $wpdb->get_results ( "SELECT * FROM ". $table_name1 );
                        foreach( $state as $sta) {
                            // if($user->state==$sta->id)
                        // {
                        $stitle=$sta->title;
                
                        ?>
                                    <option value="<?php echo $sta->id; ?>"><?php echo $stitle; ?></option>
                                    <?php
                
                        // }
                     }
                        ?>
                            </select>
                </div>
                <div class="form-group mt-2 pop_product">
                            <label class="aplabel">Pin Code</label>
                            <input type="text" class="form-control" id="apincode" placeholder="Enter Pincode">
                            </div>
                            <div class="form-group mt-2 pop_product">
                            <label class="adlabel">Address</label>
                            <input type="text" class="form-control" id="address" placeholder="Enter Pincode">
                            </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-primary area_update" data-dismiss="modal">Update</button>
      <button type="button" class="btn btn-primary close" data-dismiss="modal">Close</button>
    </div>
  </div>