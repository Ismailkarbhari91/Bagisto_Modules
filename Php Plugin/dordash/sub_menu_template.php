<div class="container-fluid" style="margin-top:30px !important;">
        <div class="container">
            <div class="row mb-2">
                <div class="col-md-9">
                    <h1>Providers</h1>
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
                            <label> Title </label>
                            <input type="text" class="form-control" id="ptitle" placeholder="Enter Title">
                        </div>
                        <button name="psubmit" type="submit" class="btn btn-primary mt-2" id="psubmit">Submit</button>
                    </form>
                </div>
            </div>
            <?php
             $key = 0;
             global $wpdb;
              $table_name = $wpdb->prefix . "providers"; 
              $result = $wpdb->get_results ( "SELECT * FROM ". $table_name );
            ?>
            <table id="tblUser">
                <thead>
                    <th>Id</th>
                    <th>Tilte</th>
                    <th>Action</th>
                </thead>
                <tbody>
                <?php foreach( $result as $user) {
                    ?>
                        <tr>
                            <td><?php echo ++$key; ?><input type="hidden" class="dordash_id" value=<?php echo $user->id ?>></td>
                            <td><?php echo $user->title; ?></td>
                            <td>
                                <a href="" class="btn btn-primary btn-sm pedit"><i class="fa fa-pencil-square-o"></i></a>
                                <a href="" id="<?php echo $user->id ?>" class="btn btn-danger btn-sm pdelete"><i class="fa fa-trash"></i></a>
                            
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

    <div class="modal fade" id="myModals" role="dialog">
<div class="modal-dialog">
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title">Update</h4>
    </div>
    <div class="modal-body">
    <input type="hidden" class="form-control" id="pid">
    <label> Title </label>
    <input type="text" class="form-control" id="pstitle">
    </div>                
    <div class="modal-footer">
    <button type="button" class="btn btn-primary pupdate" data-dismiss="modal">Update</button>
      <button type="button" class="btn btn-primary pclose" data-dismiss="modal">Close</button>
    </div>
    
  </div>