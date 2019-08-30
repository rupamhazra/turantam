<div class="page-title">
      <div class="title_left" style="width: 15%;margin-bottom: 10px;">
        <h3>Service List</h3>
        <!-- <span class="all_trash_span">
          <a href="<?php echo base_url('/admin/list-service');?>">All (<?php echo $serviceListCount; ?>)</a> | <a href="<?php echo base_url('/admin/list-service-trash');?>">Trash (<?php echo $serviceListTrashCount; ?>)</a>
        </span> -->
      </div>
      <div class="title_left">
      <div id="alert_id">
        <?php if($this->session->flashdata('msg')) echo '<div class="alert alert-success">'.$this->session->flashdata('msg').'</div>'; ?>
      </div>
      </div>
           
    </div>