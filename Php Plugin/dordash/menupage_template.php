<div class="container-fluid" style="margin-top:30px !important;">
        <div class="container">
            <div class="row mb-2">
                <div class="col-md-9">
                    <h1>Dordash</h1>
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
                            <label> Vendor Id </label>
                            <input type="text" class="form-control" id="vendor_id" placeholder="Enter Vendor Id">
                        </div>
                        <div class="form-group">
                            <label> Kiosk Id </label>
                            <input type="text" class="form-control" id="kiosk_id" placeholder="Enter Kiosk Id">
                        </div>

                        <div class="form-group">
                            <label> User Name </label>
                            <input type="text" class="form-control" id="user_name" placeholder="Enter Kiosk Id">
                        </div>

                        <div class="form-group">
                            <label> Password </label>
                            <input type="text" class="form-control" id="password" placeholder="Enter Password">
                        </div>

                        <div class="form-group">
                            <label> Minimum Order </label>
                            <input type="text" class="form-control" id="minimum_order" placeholder="Enter Password">
                        </div>

                        <div class="form-group">
                            <label> Range </label>
                            <input type="text" class="form-control" id="area_range" placeholder="Enter Password">
                        </div>
            
                        <div class="form-group">
                            <label> Base Url </label>
                            <input type="text" class="form-control" id="base_url" placeholder="Enter Password">
                        </div>
            

                        <button name="ssubmit" type="submit" class="btn btn-primary mt-2" id="submit">Submit</button>
                    </form>
                </div>
            </div>
            <?php
             $key = 0;
             global $wpdb;
              $table_name = $wpdb->prefix . "doordash_details"; 
              $result = $wpdb->get_results ( "SELECT * FROM ". $table_name );
            ?>
            <table id="tblUser">
                <thead>
                    <th>Id</th>
                    <th>Vendor Id</th>
                    <th>Kiosk Id</th>
                    <th>User Name</th>
                    <th>Password</th>
                    <th>Minimum Order</th>
                    <th>Range</th>
                    <th>Base Url</th>
                    <th>Action</th>
                </thead>
                <tbody>
                <?php foreach( $result as $user) {
                    ?>
                        <tr>
                            <td><?php echo ++$key; ?><input type="hidden" class="dordash_id" value=<?php echo $user->id ?>></td>
                            <td><?php echo $user->vendor_id; ?></td>
                            <td><?php echo $user->kiosk_id; ?></td>
                            <td><?php echo $user->user_name; ?></td>
                            <td><?php echo $user->vpassword; ?></td> 
                            <td><?php echo $user->minimum_order; ?></td>
                            <td><?php echo $user->area_range; ?></td>
                            <td><?php echo $user->base_url; ?></td>       
                            <td>
                                <a href="" class="btn btn-primary btn-sm sedit"><i class="fa fa-pencil-square-o"></i></a>
                                <a href="" id="<?php echo $user->id ?>" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i></a>
                            
                            </td>
                        </tr>
                        <?php
                    }
                    ?>    
                </tbody>
            </table>
        </div>
    </div>

    <!--  -->

    <div class="modal fade" id="myModal" role="dialog">
<div class="modal-dialog">
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title">Update</h4>
    </div>
    <div class="modal-body">
    <input type="hidden" class="form-control" id="did">
    <label>Vendor Id </label>
                            <input type="text" class="form-control" id="vid">
                            <label class="mlabel"> Kiosk Id</label><br>
                            <input type="text" class="form-control" id="kid">
                            <label class="mlabel"> User Name</label><br>
                            <input type="text" class="form-control" id="uname">
                            <label class="mlabel"> Password </label><br>
                            <input type="text" class="form-control" id="pass">
                            <label class="mlabel"> Minimum Order </label><br>
                            <input type="text" class="form-control" id="morder">
                            <label class="mlabel"> Range </label><br>
                            <input type="text" class="form-control" id="range">
                            <label class="mlabel"> Base Url </label><br>
                            <input type="text" class="form-control" id="burl">
                            </div>
                    
    <div class="modal-footer">
    <button type="button" class="btn btn-primary supdate" data-dismiss="modal">Update</button>
      <button type="button" class="btn btn-primary close" data-dismiss="modal">Close</button>
    </div>
    
  </div>