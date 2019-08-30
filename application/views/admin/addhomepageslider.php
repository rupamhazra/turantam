<style type="text/css">

.errorClass {
	border:1px solid red !important;
}

.input{	
}
.input-wide{
	width: 500px;
}
</style>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Home Page</h3>
        </div>


    </div>
    <div class="clearfix"></div>

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    <?php
                    echo form_open_multipart(base_url() . "admin/add-home-page-slider", array("class" => "form-horizontal form-label-left", "name" => "banner_Form"));
                    ?>
                    <p><?php
                        echo $this->session->flashdata('msg');
                        ?></p>
                        <?php if(!empty($banner_details)){
                            $each_element = json_decode($banner_details['value']);
                            //pre($each_element,1);
                        } ?>
                    <input type="hidden" name="addBanner" value="1">
                    <div class="item form-group">
                        <label class="col-md-12" for="title">Banner Title </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <input name="inputTitle" class="form-control" id="" value="<?php echo !empty($each_element->home_page_title) ? $each_element->home_page_title:''; ?>">
                        </div>
                    </div>
					<div class="item form-group">
                        <label class="col-md-12" for="title">Banner Description </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <textarea name="inputDescription" class="form-control" id="inputDescription"></textarea>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-md-12" for="title">Button Link </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <input name="inputButtonLink" class="form-control" id="inputButtonLink">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-md-12" for="title">Banner Image </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <input type="file" id="inputImage" class="form-control" name="inputImage">
                        </div>   
                    </div>
                    <div class="item form-group">
                       
                        <img src="">
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                            <button id="addPage" type="submit" class="btn btn-success">Submit</button>
							 <button type="submit" class="btn btn-primary" onclick="history.back();">Back</button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>

                </div>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>