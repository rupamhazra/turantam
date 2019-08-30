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