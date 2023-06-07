jQuery(document).ready(function($) {
    $('#tblUser').DataTable();
    $("#form-body").hide();

    $("#insert-btn").on('click',function(){
        $("#form-body").toggle(500);
    });

    // 

    $("#submit").on('click',function(e){
      e.preventDefault();

      var titles = $('#title').val();
      var state = $('#website').val();

      $.ajax({
          url : ajax_object.ajax_url,
          type : "post",
          dataType: "json",
          data : {
                'action': "insert",
                'title' : titles,
                'website' : state,
                 success : function(response){
                 alert("Data Inserted Successfully");
                 $("#form-body").hide();
                 location.reload(true);
               },
              
          }
      });
  });
  // 


  // area

  $("#areasubmit").on('click',function(e){
    e.preventDefault();

    var titles = $('#areatitle').val();
    var state = $('#state').val();
    var pincode = $('#areepincode').val();
    var address = $('#areaaddress').val();
    alert(pincode);
    alert(address);


    var origin   = wnm_custom.base_url;

    var settings = {
      "url": origin+"/wp-json/area/v1/area",
      "method": "POST",
      "timeout": 0,
      "headers": {
        "Content-Type": "application/json"
      },
      "data": JSON.stringify({
        "areatitle": titles,
        "state": state,
        "pincode": pincode,
        "address": address
      }),
    };
    
    $.ajax(settings).done(function (response) {
      alert('Data Inserted Successfully');
			  location.reload(true);
    });
});
  // 

  // state delete

  $(".delete").on('click',function(e){

    e.preventDefault();

    var id= this.id;
    var origin   = wnm_custom.base_url;
    // alert(id);
    // console.log(id);
    var settings = {
      "url": origin+"/wp-json/area/v1/delete",
      "method": "POST",
      "timeout": 0,
      "headers": {
        "Content-Type": "application/json"
      },
      "data": JSON.stringify({
        "id": id
      }),
    };
    
    $.ajax(settings).done(function (response) {
//       console.log(response);
      alert('Data Deleted Successfully');
			  location.reload(true);
    });
  });
  // 
  // 

  // area delete

  $(".area_delete").on('click',function(e){

    e.preventDefault();

    var id= this.id;
    // alert(id);
    var origin   = wnm_custom.base_url;

    var settings = {
      "url": origin+"/wp-json/area/v1/delete_area",
      "method": "POST",
      "timeout": 0,
      "headers": {
        "Content-Type": "application/json"
      },
      "data": JSON.stringify({
        "id": id
      }),
    };
    
    $.ajax(settings).done(function (response) {
      console.log(response);
      alert('Data Deleted Successfully');
			  location.reload(true);
    });
  });
  // 
  // state edit

  $(".sedit").on('click',function(e){
    e.preventDefault();
    $("#myModal").modal("show");

    var currentRow=$(this).closest("tr");
    var col1=currentRow.find("td:eq(1)").html();
    var h1=$('input[type=hidden]',currentRow.find("td:eq(0)")).val();
    var h=$('input[type=hidden]',currentRow.find("td:eq(2)")).val();
    $('#state_id').val(h1);
    $('#state_title').val(col1);
    $('#state_website').val(h);

  });
  // state close

  $(".close").on('click',function(e){
    $("#myModal").modal("hide");
  });

  // state update

  $(".supdate").on('click',function(e){

    e.preventDefault();
    var aid = $('#state_id').val();
    var at = $('#state_title').val();
    // var as = $('#state').val();
    var as = $('select[name=state_website] option').filter(':selected').val();

    // alert(aid);
    // alert(at);
    // alert(as);

    var origin   = wnm_custom.base_url;

    var settings = {
      "url": origin+"/wp-json/area/v1/update_state",
      "method": "POST",
      "timeout": 0,
      "headers": {
        "Content-Type": "application/json"
      },
      "data": JSON.stringify({
        "id": aid,
        "title": at,
        "website": as
      }),
    };
    
    $.ajax(settings).done(function (response) {
      alert('Data Updated Successfully');
			  location.reload(true);
    });


  });
  // 


  // area edit

  $(".area_edit").on('click',function(e){
    e.preventDefault();
    $("#myareaModal").modal("show");

    var currentRow=$(this).closest("tr");
    var col1=currentRow.find("td:eq(1)").html();
    var col2=currentRow.find("td:eq(3)").html();
    var col3=currentRow.find("td:eq(4)").html();
    var h1=$('input[type=hidden]',currentRow.find("td:eq(0)")).val();
    var h=$('input[type=hidden]',currentRow.find("td:eq(2)")).val();
    $('#arae_id').val(h1);
    $('#area_title').val(col1);
    $('#apincode').val(col2);
    $('#address').val(col3);

  });
  // area close

  $(".close").on('click',function(e){
    $("#myareaModal").modal("hide");
  });

  // 


  // area update

  $(".area_update").on('click',function(e){

    e.preventDefault();
    // alert('hi');
    var aid = $('#arae_id').val();
    var at = $('#area_title').val();
    // var as = $('#state').val();
    var as = $('select[name=astate] option').filter(':selected').val();

    // alert(aid);
    // alert(at);
    // alert(as);

    var origin   = wnm_custom.base_url;

    var settings = {
      "url": origin+"/wp-json/area/v1/update_area",
      "method": "POST",
      "timeout": 0,
      "headers": {
        "Content-Type": "application/json"
      },
      "data": JSON.stringify({
        "id": aid,
        "title": at,
        "state": as
      }),
    };
    
    $.ajax(settings).done(function (response) {
//       console.log(response);
      alert('Data Updated Successfully');
			  location.reload(true);
    });
 
  });
    // 

});
