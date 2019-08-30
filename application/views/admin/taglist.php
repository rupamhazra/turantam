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
.badge-bc{
  background-color: #5cb85c;
  color: #fff !important;
}
.alert{
  padding: 7px;
  margin-bottom: 0px;
  padding-left: 30px;
}
a.label:focus, a.label:hover {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
a.ptb-0
{
  padding-top: 0px !important;
  padding-bottom: 0px !important;
}
.mt-10{
  margin-top: 10px;
}
.div_border
{
  border: 1px solid #E6E9ED;
  padding: 10px;
  text-align: center;
  color: deepskyblue;
}
.tag:after{
  content: none;
}
span.tag{
  padding: 10px 12px;
}
.tagsinput span.tag a{
      font-size: 18px;
}
.inline_text_cs{
  color:#fff;
}
</style>

<div class="">
  
    <div class="page-title">
          <div class="title_left" style="width: 15%;">
            <h3>Tags</h3>
          </div>
          <div class="title_left">
            <div id="alert_id"></div>
          </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-xs-12">
          <div class="col-md-8 col-xs-12">
              <div class="x_panel">
               <div class="x_content">
                  <p><?php echo $this->session->flashdata('msg');?></p>
                  <div id="tags_1_tagsinput1_exist" class="tagsinput" style="width: auto; min-height: 300px; height: 300px;border: none;">
                  <?php if(count($tagsList)>0){ 
                foreach($tagsList as $key => $row){
                ?>
                <span class="tag" id="tag_id_<?php echo $row['id']; ?>"><span id="fullname_<?php echo $row['id']; ?>" ondblclick="inline_edit(<?php echo $row['id']; ?>)"><?php echo $row['name']; ?>&nbsp;&nbsp;&nbsp;</span><a href="javascript:void(0)" title="Removing tag" onclick="removeTag(<?php echo $row['id']; ?>);">x</a></span>

                 <?php }}?>
                  </div>
               </div>
              </div>
          </div>
          <div class="col-md-4 col-xs-12">
            <div class="x_panel">
              <div class="x_content">
                 
                  <input id="tags_1" type="text" name="tag_name" class="tags form-control" value="" />
                    <div class="ln_solid"></div>
                    <div class="row" style="float: left;margin-left: -34px;">
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                            <button id="addPage" type="button" onclick="addTags()"class="btn btn-success" >Submit</button>
                        </div>
                    </div>
                    </div>
                    
              </div>   
            </div>
          </div>
        </div>
    </div>
</div>
<script type="text/javascript">
  
  var url = '<?php echo base_url() ?>';   
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
                    <h4 class="modal-title" style="text-align:center;">Are you sure to delete this Blog Category ?</h4>
                </div>
                
                
                <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                    <a href="#" class="btn btn-danger" id="delete_link">Delete</a>
                    <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery Tags Input -->
   
    <script src="<?php echo base_url(); ?>assets/js/multicheckbox_category.js"></script>
    <script type="text/javascript">
   function addTags(){
    var tag_name = $(".tags ").val();
    var html = '';
    var html1 = '';
    console.log(tag_name);
    $.ajax({
        url : url+'admin/add-tags',
        type : "post",
        data : {tag_name: tag_name,ajax: "on"},
        success : function(response){
            response = JSON.parse(response);
            console.log(response);
            if(response!='')
            {
              $.each(response,function(key,value){
                console.log(value);
                 html += "<span class='tag' id='tag_id_"+value.id+"' onclick='select_tags("+value.id+");'><span id='fullname_"+value.id+"'>"+value.name+"</span>&nbsp;&nbsp;&nbsp;";
                 html += "<a href='javascript:void(0)' title='Removing tag' onclick='removeTag("+value.id+");'>x</a></span>";
                  html += "<input type='checkbox' name='selected_tags[]' id='selected_tags_"+value.id+"' value='"+value.id+"' style='display: none;'>";
                  
              });
              $("#tags_1").val('');
              $('#tags_1_tagsinput').find('span').remove();
              $('#tags_1_tagsinput1_exist').prepend(html);
             
              
            }
        }
      });
  }
  function removeTag(id){
    $.ajax({
        url : url+'admin/delete-tag/'+id,
        type : "POST",
        data : {ajax: 'on'},
        success : function(response){
          console.log(response);
          if(response){
            $("#tag_id_"+id).remove();
          }
        }
    });
  }
    </script>
  
<script type="text/javascript">
function inline_edit(id){
  var name = $("#fullname_"+id).text();
  $("#fullname_"+id).html('');
  $('<input></input>')
      .attr({
          'type': 'text',
          'name': 'fname',
          'id': 'txt_fullname_'+id,
          'size': '30',
          'value': name,
          'onblur': "inline_blur("+id+")",
          'color': "#fff"
      })
      .appendTo('#fullname_'+id);
  $('#txt_fullname_'+id).focus();
}
 function inline_blur(id){
  var name = $("#txt_fullname_"+id).val();
    console.log(name);
    $.ajax({
          url : url+'admin/edit-tags/'+id,
          type : "post",
          data : {tag_name: name},
          // cache : false,
          // contentType : false,
          // processData : false,
          success : function(response){
              //alert(response);
              console.log(response);
              if(response!="")
              {
                console.log(1111);
                $('#fullname_'+id).html(name+'&nbsp;&nbsp;&nbsp;');
              }
          }
        });
  }
$(document).ready(function() {
  init_TagsInput()
});
function init_TagsInput() {
    "undefined"!=typeof $.fn.tagsInput&&$("#tags_1").tagsInput( {
        width: "auto"
    }
    )
}
</script>