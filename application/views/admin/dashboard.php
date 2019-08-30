<style>
.label{
    border:1px solid;
}
.red{
    color:red;
}
.blue{
    color:blue;
}
.brown{
    color:#a94442;
}
</style>
 <div class="row tile_count">
    <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Users</span>
              <div class="count brown"><?php echo count($users); ?></div>
             <!--  <span class="count_bottom"><i class="green">4% </i> From last Week</span> -->
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-clock-o"></i> Total Services</span>
              <div class="count blue"><?php echo count($services); ?></div>
              <!-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span> -->
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Packages</span>
              <div class="count green" id="pages"><?php echo count($packages); ?></div>
              <!-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>
                <script type="text/javascript">
               
                var page = parseFloat($('#pages').text()) / 100 ;
              document.write(page)</script> </i> From last Week</span> -->
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Orders</span>
              <div class="count brown"><?php echo count($orders); ?></div>
             <!--  <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span> -->
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Service Category</span>
              <div class="count green"><?php echo count($service_categories); ?></div>
              
            </div>
            
          </div>
      </div>
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Recent Orders</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li>&nbsp;</li>
                    <li>&nbsp;</li>
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    
                    <!-- <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li> -->
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div class="dashboard-widget-content">
                    <ul class="list-unstyled timeline widget">
                        <?php if(count($recentOrders)>0){
                           foreach($recentOrders as $row){ ?>
                          <li>
                            <div class="block">
                              <div class="block_content">
                                <h2 class="title">
                                    <?php echo $row['order_no']; ?>
                                </h2>
                                <div class="byline">
                                  <span><?php echo $row['date_created']; ?></span>
                                </div>
                                <p class="excerpt"><?php //echo $row['blog_excerpt']; ?><a href="<?php echo base_url('admin/update-order').'/'. $row['id']; ?>" class="brown"> Edit</a>
                                </p>
                              </div>
                            </div>
                          </li>
                        <?php } }?>
                     
                    </ul>
                  </div>
                </div>
              </div>
            </div>
      </div>
<!-- <div class="">
    
      <div class="page-title">
            <div class="title_left">
              <h3>PAGES</h3>
            </div>

           
          </div>
    <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>List</h2>
                   <div class="clearfix"></div>
                </div>
               <div class="x_content">
                  <p><?php
                        echo $this->session->flashdata('msg');
                        ?></p>
                  <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                      <tr>
                        <th>Name</th>
                        <th>Url</th>
                        <th>Parent</th>
                        <th>Location</th>
                        <th>Position</th>
                        <th width="80px">Status</th>
                        <th width="240px">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                       <?php if(count($parentList)>0){
                           foreach($parentList as $row){ ?>
                               <tr>
                                    <td><?php echo $row['page_name']; ?></td>
                                    <td><?php echo $row['page_url']; ?></td>
                                    <td><?php if($row['parent_id']==0) echo "No Parent"; else displayParent($row['parent_id']); ?></td>
                                    <td><?php echo $row['location']; ?></td>
                                    <td><?php echo $row['position']; ?></td>
                                    <td><a class="label " <?php if($row['is_active']=='active') echo 'style="color:green;"'; else echo'style="color:red;"'; ?> href="<?php echo base_url().'admin/change-page-status/'.$row['page_id']; ?>"><?php echo ucfirst($row['is_active']); ?></a></td>
                                    <td><a class="label blue" href="<?php echo base_url('admin/update-content').'/'.$row['page_id']; ?>">Content</a> <a class="label blue" href="<?php echo base_url('admin/update-banner').'/'.$row['page_id']; ?>">Banner</a> <a class="label blue" href="<?php echo base_url('admin/update-page-meta') . '/' . $row['page_id']; ?>">Meta</a> <a class="label brown" href="<?php echo base_url('admin/edit-page').'/'. $row['page_id']; ?>">Edit</a> <a class="label red" href="#" onclick="confirm_modal('<?php echo base_url('admin/delete-page').'/'.$row['page_id'];?>');">Delete</a></td>
                                    
                               </tr>
                           <?php }
                       }
                       else{ ?>
                           <tr>
                            <td colspan="5">No pages found</td>
                           </tr>
                      <?php }  ?>
                        
                    </tbody>
                  </table>
                  
                  
               </div>
              </div>
            </div>
    </div>
</div> -->
<script type="text/javascript">
    function confirm_modal(delete_url)
    {
        $('#modal-4').modal('show', {backdrop: 'static'});
        document.getElementById('delete_link').setAttribute('href' , delete_url);
    }
    </script>
    
    <!-- (Normal Modal)-->
    <div class="modal fade" id="modal-4">
        <div class="modal-dialog">
            <div class="modal-content" style="margin-top:100px;">
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" style="text-align:center;">Are you sure to delete this Page ?</h4>
                </div>
                
                
                <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                    <a href="#" class="btn btn-danger" id="delete_link">Delete</a>
                    <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>