  /*
*
* Create Date: 13 July 2018
* Created By: Pankaj Gawande
* 
*/

function med(type, id, text=""){
  
  if (type == 'add') {

    if (id != "") {

      $("#"+id).attr('disabled', true);
    
    }
    
    if (text === "") {

      text = "Please Wait..";    
    }
    
    $("#"+id).html(text + '<i class="la la-spinner spinner"></i>');

  }else{

    if (id != "") {

      $("#"+id).attr('disabled', false);
          
    }

    if (text != "") {

      $("#"+id).html(text);
    
    }

  }
}

function ajax_error(error,btnId = 'submit', btnText = 'Submit'){
 
  if(error.status === 422){
    
    for(var key in error.responseJSON.errors){                            
      
      $('input[name="'+ key +'"]').after('<span class="error">'+error.responseJSON.errors[key]+'</span>');
      
    }

  }else{

    swal("Opps!",error.responseJSON.message, "error");
  }

  med('remove', btnId, btnText);

}

function ajax_success(res, url=false, btnId, btnText=""){
  
  if (res.code === 259) {

    url = APP_URL + 'login';

  }else if(res.code === 422){

    url     = false;
    btnText = "Submit";
    
    for(var key in res.errors){                            
      
      $('input[name="'+ key +'"]').after('<span class="error">'+res.errors[key]+'</span>');
      
    }

  }else if (res.code === 200) {

    swal("Great!",res.message, "success");  
  
  }
  
  if (url) {

    med('add', btnId, 'Redirecting..');    

    setTimeout(function(){ 
     
      window.location.href = url;

    }, 2000);
  
  }else{

    med('remove', btnId, btnText);
  
  }  
  
}

function token_expired(url,msg){

  swal("Opps!",msg, "error");  
  
  setTimeout(function(){ 
   
    window.location.href = url;

  }, 3000);

}


function select_country(){

  var countryId = $('#country_id option:selected').attr('cId');
  
  $.ajax({

    url  : SITEURL + 'admin/states-list',
    data : { "country_id" : countryId },
    dataType : "JSON",
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    success : function (res){
 
      var options = '<option value="">Select State</option>';

      if (res.code === 200) {
        
        for (var i = 0; i < res.result.length; i++) {
          
          options = options + '<option value="'+res.result[i].id+'" sId="'+res.result[i].id+'">'+res.result[i].state_name+'</option>';
          
        } 
      }
      $("#state_id").html(options);
      $("#city_id").html('<option value="">Select City</option>');
    },
    error: function(error) {

      $("#state_id").html('<option value="">States not found</option>');
      $("#city_id").html('<option value="">Select City</option>');

    }

  })

}

function select_state(){

  var stateid = $('#state_id option:selected').attr('sId');
  
  $.ajax({
    url  : SITEURL + 'admin/cities-list',
    data : { "state_id" : stateid },
    dataType : "JSON",
    headers: headers,
    success : function (res){
      
      var options = '<option value="">Select City</option>';

      if (res.code === 200) {
        
        for (var i = 0; i < res.result.length; i++) {
        
          options = options + '<option value="'+res.result[i].id+'" cId="'+res.result[i].id+'">'+res.result[i].city_name+'</option>';
          
        } 
      }
      
      $("#city_id").html(options);
    },
    error: function(error) {

      $("#city_id").html('<option value="">Cities not found</option>');
    
    }

  });
}

// This function is used to update status (1 / 0).

function update_status(status, type, id){
 
   swal({
    
     title: "Are you sure?",
     text: "You want to update Status",
     icon: "warning",
     buttons: true,
     dangerMode: true,
   })
   .then((willDelete) => {

    if (willDelete) {

  $.ajax({
    url  : SITEURL + 'admin/update-status',
    method: 'POST',
    data : { "status" : status, "type": type, "id": id },
    dataType : "JSON",
    headers: headers,
    
    
    success: function(res) {            

      $('#table').DataTable().ajax.reload(null, false);
      
     // $('#reload_span').ajax.reload(true, true);
      
      swal(res.message, { icon: "success", timer: 2000}); 

    },          
    error: function(error){

      ajax_error(error);              
  } 
      });  
    }
 });
}



// This function is used to update image approve (admin / null).

function image_status(status, type, id){
 
   swal({
    
     title: "Are you sure?",
     text: "You want to update Image Approve",
     icon: "warning",
     buttons: true,
     dangerMode: true,
   })
   .then((willDelete) => {

    if (willDelete) {

  $.ajax({
    url  : SITEURL + 'admin/update-image',
    method: 'POST',
    data : { "status" : status, "type": type, "id": id },
    dataType : "JSON",
    headers: headers,
    
    
    success: function(res) {            

      $('#table').DataTable().ajax.reload(null, false);
      
     // $('#reload_span').ajax.reload(true, true);
      
      swal(res.message, { icon: "success", timer: 2000}); 

    },          
    error: function(error){

      ajax_error(error);              
  } 
      });  
    }
 });
}

function verified_email(is_email_verified, type, id){
   
     swal({
       
      title: "Are you sure?",
      text: "You want to varified email",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {

    if (willDelete) {
      
      $.ajax({
        url  : SITEURL + 'admin/verified-email',
        method: 'POST',
        data : {  "is_email_verified" : is_email_verified ,"type": type, "id": id },
        dataType : "JSON",
        headers: headers,
        success: function(res) {            

          $('#table').DataTable().ajax.reload(null, false);
          //$('#reload_span').ajax.reload(true, true);


          swal(res.message, { icon: "success", timer: 2000}); 

        },          
        error: function(error){

          ajax_error(error);              

        } 
      });
    
    }


});
}




function verified_contact(is_mobile_verified, type, id){
   
  swal({
    
    title: "Are you sure?",
    text: "You want to verified contact",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  
  })
  .then((willDelete) => {

    if (willDelete) {
  
  $.ajax({
    url  : SITEURL + 'admin/verified-contact',
    method: 'POST',
    data : {  "is_mobile_verified" : is_mobile_verified ,"type": type, "id": id },
    dataType : "JSON",
    headers: headers,
    success: function(res) {            

      $('#table').DataTable().ajax.reload(null, false);
      //$('#reload_span').ajax.reload(true, true);


      swal(res.message, { icon: "success", timer: 2000}); 

    },          
    error: function(error){

      ajax_error(error);              

    } 
  });

}

});
}
function com_status(status, type, id){
         
  $.ajax({
    url  : SITEURL + 'admin/complaint-status',
    method: 'POST',
    data : { "status" : status, "type": type, "id": id },
    dataType : "JSON",
    headers: headers,
    success: function(res) {            

      $('#table').DataTable().ajax.reload(null, false);

      swal(res.message, { icon: "success", timer: 2000}); 

    },          
    error: function(error){

      ajax_error(error);              

    } 
  });
}
//doc status for document 


// This function is used to delete record

function delete_record(type, id){

  swal({
    
    title: "Are you sure?",
    text: "You want to delete this record",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {

    if (willDelete) {
      
      $.ajax({

        url  : SITEURL + 'admin/delete-record',
        method: 'POST',
        data : { "type": type, "id": id },
        dataType : "JSON",
        headers: headers,
        success: function(res) {            

          $('#table').DataTable().ajax.reload(null, false);
                
          swal(res.message, { icon: "success", timer: 2000});

        },          
        error: function(error){

          ajax_error(error);              

        } 
      
      });
    
    }

  });

}


// Restore
function restore(type, id){

  swal({
    
    title: "Are you sure?",
    text: "You want to restore this record",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {

    if (willDelete) {
      
      $.ajax({

        url  : SITEURL + 'admin/restore-record',
        method: 'POST',
        data : { "type": type, "id": id },
        dataType : "JSON",
        headers: headers,
        success: function(res) {            

          $('#table').DataTable().ajax.reload(null, false);
                
          swal(res.message, { icon: "success", timer: 2000});

        },          
        error: function(error){

          ajax_error(error);              

        } 
      
      });
    
    }

  });

}

// Check field is already exists
function check_exists(type, field, id = "", btnId = "submit"){

  let data = {
    
    "type": type, 
    "field": field,
    "value": $("#"+field).val(),
    "id": id
  
  };
  
  $("#"+btnId).attr('disabled', false);
  $('input[name="'+ field +'"]').next('.error').remove();

  $.ajax({

    url  : SITEURL + 'api/check-exists',
    method: 'GET',
    data : data,
    dataType : "JSON",
    headers: headers,
    success: function(res) {                 
      
      $("#"+btnId).attr('disabled', true);
      $('input[name="'+ field +'"]').after('<span class="error">'+res.message+'</span>');    

    },          
    error: function(error){

      $("#"+btnId).attr('disabled', false);
      $('input[name="'+ field +'"]').next('.error').remove();      

    } 
  
  });
}

function bulk_delete_record(table){

  var idsArr = [];  
      $(".checkbox:checked").each(function() {  
         idsArr.push($(this).attr('data-id'));
        });  

   if(idsArr.length <=0){  
      
        swal("Please select any record !", { icon: "warning", timer: 2000});
  }else{    

    swal({
       
      title: "Are you sure?",
      text: "You want to delete selected record permanently",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {

    if (willDelete) {
      
      $.ajax({

        url  : SITEURL + 'admin/bulk-delete-record',
        method: 'put',
        data : {"type": table ,"id": idsArr },
        dataType : "JSON",
        headers: headers,
        success: function(res) {

          $('#table').DataTable().ajax.reload(null, false);
                
          if(res.message == "Database error."){
            
            swal(res.message, { icon: "error", timer: 2000});
            
          }else{

            swal(res.message, { icon: "success", timer: 2000});
          }

        },          
        error: function(error){

          ajax_error(error);              

        } 
      
      });
    
    }

  });

 }
}

function designer_bulk_delete_record(table){

  var idsArr = [];  
      $(".checkbox:checked").each(function() {  
         idsArr.push($(this).attr('data-id'));
        });  

   if(idsArr.length <=0){  
      
        swal("Please select any record !", { icon: "warning", timer: 2000});
  }else{    

    swal({
       
      title: "Are you sure?",
      text: "You want to delete selected record permanently",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {

    if (willDelete) {
      
      $.ajax({

        url  : SITEURL + 'designer-dashboard/bulk-delete-record',
        method: 'put',
        data : {"type": table ,"id": idsArr },
        dataType : "JSON",
        headers: headers,
        success: function(res) {

          $('#table').DataTable().ajax.reload(null, false);
                
          if(res.message == "Database error."){
            
            swal(res.message, { icon: "error", timer: 2000});
            
          }else{

            swal(res.message, { icon: "success", timer: 2000});
          }

        },          
        error: function(error){

          ajax_error(error);              

        } 
      
      });
    
    }

  });

 }
}


$(".checked_all").click(function () {
      $('.checkbox').prop('checked', this.checked);
    });

function checkbox() {  
    if ($('.checkbox:checked').length == $('.checkbox').length) {
      $('.checked_all').prop('checked', true);
    } else {
      $('.checked_all').prop('checked', false);
    }
  } 
 

  
function select_block(){
  
  var societyId = $('#society_id').val();

  $.ajax({

    url  : SITEURL + 'admin/block-list',
    data : { "society_id" : societyId },
    dataType : "JSON",
    headers: headers,

    success : function (res){

      var options = '<option value="">Select Block</option>';


      if (res.code === 200) {

        for (var i = 0; i < res.result.length; i++) {
    
          options = options + '<option value="'+res.result[i].id+'" sId="'+res.result[i].id+'">'+res.result[i].title+'</option>';
        } 
      }
      $("#block_id").html(options);

    },
    error: function(error) {

      $("#block_id").html('<option value="">Block not found</option>');
      $("#floor_id").html('<option value="">Floor not found</option>');
      $("#flat_id").html('<option value="">Flat not found</option>');

    }
  })
}

function select_floor(){

  var blockId = $('#block_id').val();
    $.ajax({

      url  : SITEURL + 'admin/floor-list',
      data : { "block_id" : blockId },
      dataType : "JSON",
      headers: headers,

      success : function (res){

        var options = '<option value="">Select floor</option>';

        if (res.code === 200) {

          for (var i = 0; i < res.result.length; i++) {

            options = options + '<option value="'+res.result[i].id+'" sId="'+res.result[i].id+'">'+res.result[i].floor_no+'</option>';
          } 
        }
        $("#floor_id").html(options);

      },
      error: function(error) {

        $("#floor_id").html('<option value="">Floor not found</option>');
        $("#flat_id").html('<option value="">Flat not found</option>');

      }
    })
}

function select_flat(){
  
  var floorId = $('#floor_id').val();
  $.ajax({

    url  : SITEURL + 'admin/flat-list',
    data : { "floor_id" : floorId },
    dataType : "JSON",
    headers: headers,

    success : function (res){
      
      var options = '<option value="">Select flat</option>';

      if (res.code === 200) {

        for (var i = 0; i < res.result.length; i++) {
          
          options = options + '<option value="'+res.result[i].id+'" sId="'+res.result[i].id+'">'+res.result[i].flat_no+'</option>';
        } 
      }
      $("#flat_id").html(options);

    },
    error: function(error) {

      $("#flat_id").html('<option value="">Flat not found</option>');
      
    }
  })
}

function society_events(){

  var societyID = $('#society_id').val();
  var option = '';
  $('#event_amount').val('');

  
  $.ajax({
    url  : SITEURL + 'admin/society-events',
    data : { "society_id" : societyID },
    dataType : "JSON",
    headers: headers,

    success : function (res){
 
      if (res.code == 200) {

        option = option + '<option value="">Select Event</option>';

        for (var i = 0; i < res.result.length; i++) {

          option = option + '<option value="'+res.result[i].id+'">'+res.result[i].title+'</option>';
        }

        $('#event_id').html(option);

      }
    },
    error: function(error) {

      $('#event_id').html('<option value="">Events not found</option>');
    
    }

  });
}

function society_expense(){

  var societyID = $('#society_id').val();
  var option = '';
  
  $.ajax({
    url  : SITEURL + 'admin/society-expense',
    data : { "society_id" : societyID },
    dataType : "JSON",
    headers: headers,

    success : function (res){
 
      if (res.code == 200) {

        option = option + '<option value="">Select Expense</option>';

        for (var i = 0; i < res.result.length; i++) {

          option = option + '<option value="'+res.result[i].id+'">'+res.result[i].reason+'</option>';
        }

        $('#title').html(option);

      }
    },
    error: function(error) {

      $('#title').html('<option value="">Expense not found</option>');
    
    }

  });
}

function society_resident(){

  var societyID = $('#society_id').val();
  var option = '';
  
  $.ajax({
    url  : SITEURL + 'admin/society-resident',
    data : { "society_id" : societyID },
    dataType : "JSON",
    headers: headers,

    success : function (res){

      if (res.code == 200) {

        option = option + '<option value = "">Select User</option>';


        for (var i = 0; i < res.result.length; i++) {
       
          option = option + '<option value="'+res.result[i].resident_id+'">'+res.result[i].user.name+'</option>';
        }

        $('#paid_by_user').html(option);
      }
    },
    error: function(error) {

      $('#paid_by_user').html('<option value="">User not found</option>');
    
    }

  });
}


function select_complaint_user(){

  var societyID = $('#society_id').val();
  
  var option = '';
  
  $.ajax({
    url  : SITEURL + 'admin/society-resident',
    data : { "society_id" : societyID },
    dataType : "JSON",
    headers: headers,

    success : function (res){

      if (res.code == 200) {

        option = option + '<option value = "">Select User</option>';

        for (var i = 0; i < res.result.length; i++) {

          option = option + '<option value="'+res.result[i].user_id+'">'+res.result[i].user.name+'</option>';
        }

        $('#by_id').html(option);
      }
    },
    error: function(error) {

      $('#by_id').html('<option value="">User not found</option>');
    
    }

  });
}

function select_societyAdmin(){

  var societyID = $('#society_id').val();


  var option = '';
  
  $.ajax({
    url  : SITEURL + 'admin/society-adminUser',
    data : { "society_id" : societyID },
    dataType : "JSON",
    headers: headers,

    success : function (res){

      if (res.code == 200) {

        option = option + '<option value = "">Select society admin</option>';

        for (var i = 0; i < res.result.length; i++) {

          option = option + '<option value="'+res.result[i].user_id+'">'+res.result[i].user.name+'</option>';
        }

        $('#create_by_user').html(option);
      }
    },
    error: function(error) {

      $('#create_by_user').html('<option value="">Society admin not found</option>');
    
    }

  });
}

// This function is used to designer delete record

function designer_delete_record(type, id){

  swal({
    
    title: "Are you sure?",
    text: "You want to delete this record",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {

    if (willDelete) {
      
      $.ajax({

        url  : SITEURL + 'designer-dashboard/delete-record',
        method: 'POST',
        data : { "type": type, "id": id },
        dataType : "JSON",
        headers: headers,
        success: function(res) {            

          $('#table').DataTable().ajax.reload(null, false);
                
          swal(res.message, { icon: "success", timer: 2000});

        },          
        error: function(error){

          ajax_error(error);              

        } 
      
      });
    
    }

  });

}


// Designer Restore
function designer_restore(type, id){

  swal({
    
    title: "Are you sure?",
    text: "You want to restore this record",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {

    if (willDelete) {
      
      $.ajax({

        url  : SITEURL + 'designer-dashboard/restore-record',
        method: 'POST',
        data : { "type": type, "id": id },
        dataType : "JSON",
        headers: headers,
        success: function(res) {            

          $('#table').DataTable().ajax.reload(null, false);
                
          swal(res.message, { icon: "success", timer: 2000});

        },          
        error: function(error){

          ajax_error(error);              

        } 
      
      });
    
    }

  });

}
