var base_url = window.location.origin;
var base_url = base_url+'/turantam/';
function change_status(id,module){
    console.log();
    var stat_val = '0';
    if($("#status_id_"+id).attr('value') == '0') stat_val = '1';
    $.ajax({
        url : base_url+'admin/change-'+module+'-status/'+id,
        type : "post",
        data : {'is_active': stat_val},
        success : function(response){
          console.log(response);
          if(response)
          {
            if(stat_val == '0') 
            {
              $('#status_id_'+id).css('color','red').attr('value','0').text('Inactive');
              $("#alert_id").html('<div class="alert alert-success">!! Status changed to Inactive</div>');
            }
            else
            {
              $('#status_id_'+id).css('color','green').attr('value','1').text('Active');
              $("#alert_id").html('<div class="alert alert-success">!! Status changed to Active</div>');
            }
          }
        }
    });
}
function confirm_modal(id,module){
  console.log(module);
  delete_url = base_url+'admin/delete-'+module+'/'+id;
  if(module == 'service-category') module = 'service category';
  if(module == 'package-entity') module = 'package entity';
  if(module == 'package-entity-value') module = 'package entity value';
  if(module == 'order-details') module = 'order details';
  else module = module;
  $('#modal-4').find('.modal-title').html('Are you sure to delete this '+module+' ?');
  $('#modal-4').modal('show', {backdrop: 'static'});
  document.getElementById('delete_link').setAttribute('href' , delete_url);
}
// function change_status(id,module){
//   var val = $("#is_status_"+id).val();
//   var text = $("#is_status_"+id+" option:selected").text();
//    $.ajax({
//         url : base_url+'admin/change-'+module+'-status',
//         type : "post",
//         data : {id: id, is_active: val},
//         success : function(response){
//             console.log(response);
//             if(response!='')
//             {
//               console.log(text);
//                 $("#alert").html('').html('<strong>!! Status changed to '+text+'</strong>').show();
//             }
//         }
//       });
// }
function remove_module_single_data(id,module)
{
  $.ajax({
        url : base_url+'admin/delete-'+module+'/'+id+'/',
        type : "post",
        data : 1,
        success : function(response){
            console.log(response);
            if(response!='')
            {
              $("#module_data_"+id).remove();
              $("#alert").html('').html('<strong>!! Data deleted  successfully </strong>').show();
            }
        }
      });

}
/**************************** C H E C K B O X *******************************/
function mmursp_how_many(module)
{
  var checkedValue = ""; 
  var removeRow = [];
  var inputElements = document.getElementsByClassName('mmursp_delete_check_class');
  for(var i=0; inputElements[i]; ++i)
  {
        if(inputElements[i].checked)
        {
           checkedValue += inputElements[i].value +",";
           removeRow.push(inputElements[i].value);
        }
  }

  document.getElementById('mmursp_id').value=checkedValue;
  var mmursp_select_action_top = $('[name=mmursp_select_action_top]').val();
  var mmursp_id = $('[name=mmursp_id]').val();
  $.ajax({
        url : base_url+'admin/delete-or-ac_inac-multi-'+module,
        type : "post",
        data : {mmursp_select_action_top: mmursp_select_action_top,
          mmursp_id: mmursp_id},
        success : function(response){
          console.log(response);
          if(response!='')
          {
            console.log(removeRow);
            if(module == 'order')
            {
                if(mmursp_select_action_top == "delete"){
                  for(var i=0; i<removeRow.length; i++)
                  {
                    $("#module_data_"+removeRow[i]).remove();
                  }
                  $("#alert_id").html('').html('<div class="alert alert-success">!! Data deleted  successfully </div>').show();
                }
                else if(mmursp_select_action_top == "trash"){
                  for(var i=0; i<removeRow.length; i++)
                  {
                    $("#module_data_"+removeRow[i]).remove();
                  }
                  $("#alert_id").html('').html('<div class="alert alert-success">!! Data trashed  successfully </div>').show();
                }
                else if(mmursp_select_action_top == "pending"){
                  for(var i=0; i<removeRow.length; i++)
                  {
                    $("#module_data_"+removeRow[i]).find('#delete_check_id_'+removeRow[i]).prop('checked',false);
                    $("#module_data_"+removeRow[i]).find('select').val('pending').attr('selected');
                    $("#module_data_"+removeRow[i]).find('a.active').css('color','blue').attr('value','1').text('Pending');
                  }
                  $("#alert_id").html('').html('<div class="alert alert-success">!! Status changed successfully </div>').show(); 
                }
                else if(mmursp_select_action_top == "completed"){
                    for(var i=0; i<removeRow.length; i++)
                    {
                      $("#module_data_"+removeRow[i]).find('#delete_check_id_'+removeRow[i]).prop('checked',false);
                      $("#module_data_"+removeRow[i]).find('select').val('completed').attr('selected');
                      $("#module_data_"+removeRow[i]).find('a.active').css('color','green').attr('value','1').text('Completed');
                    }
                    $("#alert_id").html('').html('<div class="alert alert-success">!! Status changed successfully </div>').show();
                }
                else if(mmursp_select_action_top == "cancelled"){
                  for(var i=0; i<removeRow.length; i++)
                  {
                    $("#module_data_"+removeRow[i]).find('#delete_check_id_'+removeRow[i]).prop('checked',false);
                    $("#module_data_"+removeRow[i]).find('select').val('cancelled').attr('selected');
                    $("#module_data_"+removeRow[i]).find('a.active').css('color','red').attr('value','1').text('Cancelled');
                  }
                  $("#alert_id").html('').html('<div class="alert alert-success">!! Status changed successfully </div>').show(); 
                }
            }
            else
            {
                if(mmursp_select_action_top == "delete"){
                  for(var i=0; i<removeRow.length; i++)
                  {
                    $("#module_data_"+removeRow[i]).remove();
                  }
                  $("#alert_id").html('').html('<div class="alert alert-success">!! Data deleted  successfully </div>').show();
                }
                else if(mmursp_select_action_top == "restore"){
                  for(var i=0; i<removeRow.length; i++)
                  {
                    $("#module_data_"+removeRow[i]).remove();
                  }
                  $("#alert_id").html('').html('<div class="alert alert-success">!! Data restored successfully </div>').show();
                }
                else if(mmursp_select_action_top == "trash"){
                  for(var i=0; i<removeRow.length; i++)
                  {
                    $("#module_data_"+removeRow[i]).remove();
                  }
                  $("#alert_id").html('').html('<div class="alert alert-success">!! Data trashed  successfully </div>').show();
                }
                else if(mmursp_select_action_top == "inactive"){
                  for(var i=0; i<removeRow.length; i++)
                  {
                    $("#module_data_"+removeRow[i]).find('#delete_check_id_'+removeRow[i]).prop('checked',false);
                    $("#module_data_"+removeRow[i]).find('select').val('inactive').attr('selected');
                    $("#module_data_"+removeRow[i]).find('a.active').css('color','red').attr('value','1').text('Inactive');
                  }
                  $("#alert_id").html('').html('<div class="alert alert-success">!! Status changed successfully </div>').show(); 
                }
                else if(mmursp_select_action_top == "active"){
                    for(var i=0; i<removeRow.length; i++)
                    {
                      $("#module_data_"+removeRow[i]).find('#delete_check_id_'+removeRow[i]).prop('checked',false);
                      $("#module_data_"+removeRow[i]).find('select').val('active').attr('selected');
                      $("#module_data_"+removeRow[i]).find('a.active').css('color','green').attr('value','1').text('Active');
                    }
                    $("#alert_id").html('').html('<div class="alert alert-success">!! Status changed successfully </div>').show();
                }
            }
            $('#mmursp_root_checkbox_id_top').prop('checked',false);
          }
        }
    });
}
function mmursp_each_check(which_id)
{
  var inputElements = document.getElementsByClassName('mmursp_delete_check_class');
  if(document.getElementById('mmursp_root_checkbox_id_top').checked==true)
  {
    document.getElementById('mmursp_root_checkbox_id_top').checked=false;
    for(var i=0; inputElements[i]; ++i)
    {
      inputElements[i].checked=true;
      if(inputElements[i].value==which_id)
      {
        inputElements[i].checked=false;
      }   
    }
  }
}
function mmursp_all_check_top()
{
  //alert('dff');
  if(document.getElementById('mmursp_root_checkbox_id_top').checked==true)
  {
    //document.getElementById('mmursp_root_checkbox_id_bottom').checked=true;
    var inputElements = document.getElementsByClassName('mmursp_delete_check_class');
    for(var i=0; inputElements[i]; ++i)
    {
      inputElements[i].checked=true;
    }
  }
  else
  {
    //document.getElementById('mmursp_root_checkbox_id_bottom').checked=false;
    var inputElements = document.getElementsByClassName('mmursp_delete_check_class');
    for(var i=0; inputElements[i]; ++i)
    {
      inputElements[i].checked=false;
    }
  }
}


/*********************** S E A R C H **********************/
function filter(module){
  var url = base_url+'admin/list-'+module;
  if(module == 'user'){
    var uname_or_email = $("#uname_or_email").val();
    var f = document.createElement("form");
    f.setAttribute('method',"get");
    f.setAttribute('action',url);
    f.setAttribute('id','filter_form');
    //create input element

    var i1 = document.createElement("input");
    i1.type = "text";
    i1.name = "user_or_email";
    i1.id = "user_or_email";

    //create a button
    var s = document.createElement("input");
    s.type = "submit";
    s.value = "Submit";
    // add all elements to the form
    f.appendChild(i1);
    f.appendChild(s);
    // add the form inside the body
    $("body").append(f);   //using jQuery or
    document.getElementsByTagName('body')[0].appendChild(f); //pure javascript
    $("#user_or_email").val(uname_or_email);
    console.log(uname_or_email);
  }
  else if(module == 'service'){
    var cat = $("#inputCategory").val();
    var f = document.createElement("form");
    f.setAttribute('method',"get");
    f.setAttribute('action',url);
    f.setAttribute('id','filter_form');
    //create input element
    var i1 = document.createElement("input");
    i1.type = "text";
    i1.name = "cat_id";
    i1.id = "cat_id";

    var i2 = document.createElement("input");
    i2.type = "text";
    i2.name = "service_name";
    i2.id = "service_name";

    //create a button
    var s = document.createElement("input");
    s.type = "submit";
    s.value = "Submit";
    // add all elements to the form
    f.appendChild(i1).appendChild(i2);
    f.appendChild(s);
    // add the form inside the body
    $("body").append(f);   //using jQuery or
    document.getElementsByTagName('body')[0].appendChild(f); //pure javascript
    $("#cat_id").val(cat);
    $("#service_name").val($("#inputService").val());
  }
  else if(module == 'package'){
    var f = document.createElement("form");
    f.setAttribute('method',"get");
    f.setAttribute('action',url);
    f.setAttribute('id','filter_form');
    //create input element
    var i1 = document.createElement("input");
    i1.type = "text";
    i1.name = "service_id";
    i1.id = "service_id";
    var i2 = document.createElement("input");
    i2.type = "text";
    i2.name = "package_name";
    i2.id = "package_name";
    //create a button
    var s = document.createElement("input");
    s.type = "submit";
    s.value = "Submit";
    // add all elements to the form
    f.appendChild(i1).appendChild(i2);
    f.appendChild(s);
    // add the form inside the body
    $("body").append(f);
    document.getElementsByTagName('body')[0].appendChild(f); //pure javascript
    $("#service_id").val($("#inputService").val());
    $("#package_name").val($("#inputPackage").val());
  }
  else if(module == 'package-entity'){
    var f = document.createElement("form");
    f.setAttribute('method',"get");
    f.setAttribute('action',url);
    f.setAttribute('id','filter_form');
    //create input element
    var i1 = document.createElement("input");
    i1.type = "text";
    i1.name = "package_id";
    i1.id = "package_id";
    var i2 = document.createElement("input");
    i2.type = "text";
    i2.name = "package_entity_name";
    i2.id = "package_entity_name";
    //create a button
    var s = document.createElement("input");
    s.type = "submit";
    s.value = "Submit";
    // add all elements to the form
    f.appendChild(i1).appendChild(i2);
    f.appendChild(s);
    // add the form inside the body
    $("body").append(f);
    document.getElementsByTagName('body')[0].appendChild(f); //pure javascript
    $("#package_id").val($("#inputPackage").val());
    $("#package_entity_name").val($("#inputPackageEntity").val());
  }
  else if(module == 'package-entity-value'){
    var f = document.createElement("form");
    f.setAttribute('method',"get");
    f.setAttribute('action',url);
    f.setAttribute('id','filter_form');
    //create input element
    var i1 = document.createElement("input");
    i1.type = "text";
    i1.name = "package_entity_id";
    i1.id = "package_entity_id";
    //create a button
    var s = document.createElement("input");
    s.type = "submit";
    s.value = "Submit";
    // add all elements to the form
    f.appendChild(i1);
    f.appendChild(s);
    // add the form inside the body
    $("body").append(f);
    document.getElementsByTagName('body')[0].appendChild(f); //pure javascript
    $("#package_entity_id").val($("#inputPackageEntity").val());
  }
  else if(module == 'order'){
    var f = document.createElement("form");
    f.setAttribute('method',"get");
    f.setAttribute('action',url);
    f.setAttribute('id','filter_form');
    //create input element
    var i1 = document.createElement("input");
    i1.type = "text";
    i1.name = "customer_id";
    i1.id = "customer_id";
    var i2 = document.createElement("input");
    i2.type = "text";
    i2.name = "order_status";
    i2.id = "order_status";
    var i3 = document.createElement("input");
    i3.type = "text";
    i3.name = "payment_type";
    i3.id = "payment_type";
    var i4 = document.createElement("input");
    i4.type = "text";
    i4.name = "order_no";
    i4.id = "order_no";
    var i5 = document.createElement("input");
    i5.type = "text";
    i5.name = "txn_id";
    i5.id = "txn_id";
     var i6 = document.createElement("input");
    i6.type = "text";
    i6.name = "paid_status";
    i6.id = "paid_status";
    //create a button
    var s = document.createElement("input");
    s.type = "submit";
    s.value = "Submit";
    // add all elements to the form
    f.appendChild(i1).appendChild(i2).appendChild(i3).appendChild(i4).appendChild(i5).appendChild(i6);
    f.appendChild(s);
    // add the form inside the body
    $("body").append(f);
    document.getElementsByTagName('body')[0].appendChild(f); //pure javascript
    $("#customer_id").val($("#inputCustomer").val());
    $("#order_status").val($("#inputOrderStatus").val());
    $("#payment_type").val($("#inputPaymentType").val());
    $("#order_no").val($("#inputOrderNo").val());
    $("#txn_id").val($("#inputTxnId").val());
    $("#paid_status").val($("#inputPaidStatus").val());
  }
  else if(module == 'order-details'){
    var f = document.createElement("form");
    f.setAttribute('method',"get");
    f.setAttribute('action',url);
    f.setAttribute('id','filter_form');
    //create input element
    var i1 = document.createElement("input");
    i1.type = "text";
    i1.name = "package_id";
    i1.id = "package_id";

    var i2 = document.createElement("input");
    i2.type = "text";
    i2.name = "order_no";
    i2.id = "order_no";

    //create a button
    var s = document.createElement("input");
    s.type = "submit";
    s.value = "Submit";
    // add all elements to the form
    f.appendChild(i1);
    f.appendChild(i2);
    f.appendChild(s);
    // add the form inside the body
    $("body").append(f);   //using jQuery or
    document.getElementsByTagName('body')[0].appendChild(f); //pure javascript
    $("#package_id").val($('#inputPackage').val());
    $("#order_no").val($('#inputOrderNo').val());
  }
  $('#filter_form').submit();
}