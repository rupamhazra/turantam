function mmursp_how_many()
  {
    var checkedValue = ""; 
    var inputElements = document.getElementsByClassName('mmursp_delete_check_class');
    for(var i=0; inputElements[i]; ++i)
    {
          if(inputElements[i].checked)
          {
             checkedValue += inputElements[i].value +",";
          }
    }
    document.getElementById('mmursp_id').value=checkedValue;
    document.getElementById("mmursp_deleteForm").submit();
  }

  function mmursp_each_check(which_id,which_sub_id)
  {
    var inputElements = document.getElementsByClassName('mmursp_delete_check_class_'+which_sub_id);
    if(document.getElementById('mmursp_root_checkbox_id_top_'+which_sub_id).checked==true)
    {
      document.getElementById('mmursp_root_checkbox_id_top_'+which_sub_id).checked=false;
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

  function mmursp_all_check_top(which_sub_id)
  {
    //alert('dff');
    if(document.getElementById('mmursp_root_checkbox_id_top_'+which_sub_id).checked==true)
    {
      //document.getElementById('mmursp_root_checkbox_id_bottom').checked=true;
      var inputElements = document.getElementsByClassName('mmursp_delete_check_class_'+which_sub_id);
      for(var i=0; inputElements[i]; ++i)
      {
        inputElements[i].checked=true;
      }
    }
    else
    {
      //document.getElementById('mmursp_root_checkbox_id_bottom').checked=false;
      var inputElements = document.getElementsByClassName('mmursp_delete_check_class_'+which_sub_id);
      for(var i=0; inputElements[i]; ++i)
      {
        inputElements[i].checked=false;
      }
    }
  }