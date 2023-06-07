
    <div class="container-fluid" style="margin-top:30px !important;">
        <div class="container">
            <div class="row mb-2">
                <div class="col-md-9">
                    <h1>Addons</h1>
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
                            <label>Title </label>
                            <input type="text" class="form-control" id="title" placeholder="Enter Title">
                        </div>
                        <div class="form-group mt-2">
                            <label>Product</label><br>
                            <select name="product" id="product">
                            <?php
                
                              $products = wc_get_products( array( 'status' => 'publish'));
                              foreach ( $products as $product ){ ?>
                                <option value="<?php echo $product->get_id();?>"><?php echo $product->get_title();?></option>
                                <?php
                              }  
                              ?>
                          </select>
                        </div>
                        <div class="form-group mt-2">
                        <label>Priority</label><br>
                        <input type="text" class="form-control" id="priority" placeholder="Enter Priority">
                        </div>
                        <button name="ssubmit" type="submit" class="btn btn-primary mt-2" id="submit">Submit</button>
                    </form>
                </div>
            </div>

            <?php
                // require_once('config.php');
                $key;

                global $wpdb;
              $table_name = $wpdb->prefix . "first_table"; 
              $result = $wpdb->get_results ( "SELECT * FROM ". $table_name );
            ?>

            <table id="tblUser">
                <thead>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Product</th>
                    <th>Prority</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php foreach( $result as $user) { 
                         $products = wc_get_products( array( 'status' => 'publish'));
                         foreach ( $products as $product ){
                       if($user->product==$product->get_id())
                        {
                        $ptitle=$product->get_title();
                        
                      ?>
                        <tr>

                            <td><?php echo ++$key; ?><input type="hidden" class="pop_p_id" value=<?php echo $user->id ?>></td>
                            <td><?php echo $user->title; ?></td>
                            <td><?php echo $ptitle; ?><input type="hidden" class="pid" value=<?php echo $user->product; ?>></td>
                            <td><?php echo $user->priority; ?></td>
                            
                            <td>
                                <a href="" class="btn btn-primary btn-sm edit"><i class="fa fa-pencil-square-o"></i></a>
                                <a href="" id="<?php echo $user->id ?>" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i></a>
                            
                            </td>
                        </tr>
                    <?php 
                }
            }
                }?>
                </tbody>
            </table>
        </div>
    </div>


    <div class="modal fade" id="myModal" role="dialog">
<div class="modal-dialog">
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title">Update</h4>
    </div>
    <div class="modal-body">
    <input type="hidden" class="form-control" id="pop_id">
    <label>Title </label>
    
                            <input type="text" class="form-control" id="pop_title" placeholder="Enter Title">
                            </div>
                            <div class="form-group mt-2 pop_product">
                            <label class="plabel">Product</label><br>
                            <select name="product" id="pop_product">
                            <?php
                            $products = wc_get_products( array( 'status' => 'publish'));
                            foreach ( $products as $product ){ ?>   
                            <option  value="<?php echo $product->get_id();?>"><?php echo $product->get_title();?></option>
                              <?php
                              }
                              ?>
                            </select>
                            </div>
                        <div class="form-group mt-2">
                        <label class="plabel">Priority</label><br>
                        <input type="text" class="form-control" id="pop_priority" placeholder="Enter Priority">
                        </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-primary update" data-dismiss="modal">Update</button>
      <button type="button" class="btn btn-primary close" data-dismiss="modal">Close</button>
    </div>
    
  </div>

   <script>




   </script>