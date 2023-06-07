<div class="container-fluid" style="margin-top:30px !important;">
        <div class="container">
            <div class="row mb-2">
                <div class="col-md-9">
                    <h1>States</h1>
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
                            <label>State </label>
                            <input type="text" class="form-control" id="title" placeholder="Enter State">
                        </div>
                        <div class="form-group mt-2">
                        <?php
		$all_blogs    = get_blogs_of_user( get_current_user_id() );
		$primary_blog = (int) get_user_meta( get_current_user_id(), 'primary_blog', true );
		if ( count( $all_blogs ) > 1 ) {
			$found = false;
			?>
                            <label>Website</label><br>
                            <select name="website" id="website">
                            <?php
				foreach ( (array) $all_blogs as $blog ) {
					if ( $blog->userblog_id === $primary_blog ) {
						$found = true;
					}
					?>
                    <option value="<?php echo $blog->userblog_id; ?>"<?php selected( $primary_blog, $blog->userblog_id ); ?>><?php echo esc_url( get_home_url( $blog->userblog_id ) ); ?></option>
					<?php
				}
				?>
                          </select>
                          <?php
        }
                          ?>
                        </div>
                        <button name="ssubmit" type="submit" class="btn btn-primary mt-2" id="submit">Submit</button>
                    </form>
                </div>
            </div>
            <?php
             $key;

             global $wpdb;
              $table_name = $wpdb->prefix . "state"; 
              $result = $wpdb->get_results ( "SELECT * FROM ". $table_name );
            ?>
            <table id="tblUser">
                <thead>
                    <th>Id</th>
                    <th>State</th>
                    <th>Website</th>
                    <th>Action</th>
                </thead>
                <tbody>
                <?php foreach( $result as $user) {
                    // 
                    $url = get_home_url($blog_id = $user->website);
                    ?>
                        <tr>
                            <td><?php echo ++$key; ?><input type="hidden" class="state_id" value=<?php echo $user->id ?>></td>
                            <td><?php echo $user->title; ?></td>
                            <td><?php echo $url ?><input type="hidden" class="state_id" value=<?php echo $user->website ?>></td>        
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
    <input type="hidden" class="form-control" id="state_id">
    <label>Title </label>
    
                            <input type="text" class="form-control" id="state_title" placeholder="Enter Title">
                            </div>
                            <div class="form-group mt-2 pop_product">
                            <label class="slabel">Website</label><br>
                            <select name="state_website" id="state_website">
                            <?php
                               $all_blogs    = get_blogs_of_user( get_current_user_id() );
                               $primary_blog = (int) get_user_meta( get_current_user_id(), 'primary_blog', true );
                               if ( count( $all_blogs ) > 1 ) {
                                   $found = false;
                                   foreach ( (array) $all_blogs as $blog ) {
                                    if ( $blog->userblog_id === $primary_blog ) {
                                        $found = true;
                                    }
                                    ?>
                                    <option value="<?php echo $blog->userblog_id;?>"><?php echo esc_url( get_home_url( $blog->userblog_id ) );?></option>
                                     <?php
                                   }
                                }
                              ?>
                            </select>
                            </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-primary supdate" data-dismiss="modal">Update</button>
      <button type="button" class="btn btn-primary close" data-dismiss="modal">Close</button>
    </div>
    
  </div>