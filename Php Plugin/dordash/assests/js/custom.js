jQuery(document).ready(function($) {
    $('#tblUser').DataTable();
    $("#form-body").hide();

    $("#insert-btn").on('click',function(){
        $("#form-body").toggle(500);
    });


    // insert

$("#submit").on('click',function(e){
    e.preventDefault();

    var vid = $('#vendor_id').val();
    var kid = $('#kiosk_id').val();

    var pass=$('#password').val();

    var burl=$('#base_url').val();

    var user_name =$('#user_name').val();

    var minimum_order =$('#minimum_order').val();

    var area_range =$('#area_range').val();

    $.ajax({
        url : myAjax.ajaxurl,
        type : "post",
        dataType: "json",
        data : {
              'action': "insert",
              'vendor_id' : vid,
              'kiosk_id' :  kid,
              'vpassword' :  pass,
              'base_url' :  burl,
              'user_name' : user_name,
              'minimum_order' : minimum_order,
              'area_range' : area_range,
               success : function(response){
               alert("Data Inserted Successfully");
               $("#form-body").hide();
               location.reload(true);
             },
            
        }
    });
});

// 

// edit

$(".sedit").on('click',function(e){
    e.preventDefault();
    $("#myModal").modal("show");
    // 

    var currentRow=$(this).closest("tr");
    var col1=currentRow.find("td:eq(1)").html();
    var col2=currentRow.find("td:eq(2)").html();
    var col3=currentRow.find("td:eq(3)").html();
    var col4=currentRow.find("td:eq(4)").html();
    var col5=currentRow.find("td:eq(5)").html();
    var col6=currentRow.find("td:eq(6)").html();
    var col7=currentRow.find("td:eq(7)").html();
    // alert(col2);
    var h1=$('input[type=hidden]',currentRow.find("td:eq(0)")).val();

    // alert(h1);

    $('#did').val(h1);
    $('#vid').val(col1);
    $('#kid').val(col2);
    $('#uname').val(col3);
    $('#pass').val(col4);
    $('#morder').val(col5);
    $('#range').val(col6);
    $('#burl').val(col7);


    // 
  
});
// 

//close
$(".close").on('click',function(e){
    $("#myModal").modal("hide");
  });

//   


// update

$(".supdate").on('click',function(e){

    e.preventDefault();

    var id = $('#did').val();
    var vid = $('#vid').val();
    var kid = $('#kid').val();
    var pass = $('#pass').val();
    var burl = $('#burl').val();
    var uname = $('#uname').val();
    var m_order = $('#morder').val();
    var a_range = $('#range').val();



    $.ajax({
        url : myAjax.ajaxurl,
        type : "post",
        dataType: "json",
        data : {
              'action': "update",
              'id'    : id,
              'vendor_id' : vid,
              'kiosk_id' :  kid,
              'vpassword' :  pass,
              'base_url' :  burl,
              'user_name' : uname,
              'minimum_order' : m_order,
              'area_range' : a_range,
               success : function(response){
               alert("Data Updated Successfully");
               $("#form-body").hide();
               location.reload(true);
             },
            
        }
    });
});

// 

// delete

$(".delete").on('click',function(e){

    e.preventDefault();

    var id= this.id;
    // alert(id);

    $.ajax({
        url : myAjax.ajaxurl,
        type : "post",
        dataType: "json",
        data : {
              'action': "delete",
              'id'    : id,
               success : function(response){
               alert("Data Deleted Successfully");
               $("#form-body").hide();
               location.reload(true);
             },
            
        }
    });
});
// 

// pinsert

$("#psubmit").on('click',function(e){
    e.preventDefault();

    var title = $('#ptitle').val();

    // alert(title);

    $.ajax({
        url : myAjax.ajaxurl,
        type : "post",
        dataType: "json",
        data : {
              'action': "pinsert",
              'title' : title,
               success : function(response){
               alert("Data Inserted Successfully");
               $("#form-body").hide();
               location.reload(true);
             },
            
        }
    });
});


// 

// pedit


$(".pedit").on('click',function(e){
    e.preventDefault();
    $("#myModals").modal("show");
    var currentRow=$(this).closest("tr");
    var col1=currentRow.find("td:eq(1)").html();
    var h1=$('input[type=hidden]',currentRow.find("td:eq(0)")).val();
    // alert(col1);

    $('#pid').val(h1);
    $('#pstitle').val(col1);

});

// 

//close
$(".pclose").on('click',function(e){
    $("#myModals").modal("hide");

    
  });

//   


// update

$(".pupdate").on('click',function(e){

    e.preventDefault();

    var id = $('#pid').val();
    var title = $('#pstitle').val();

    $.ajax({
        url : myAjax.ajaxurl,
        type : "post",
        dataType: "json",
        data : {
              'action': "pupdate",
              'id'    : id,
              'title' : title,
               success : function(response){
               alert("Data Updated Successfully");
               $("#form-body").hide();
               location.reload(true);
             },
            
        }
    });
});
// 

// delete

$(".pdelete").on('click',function(e){

    e.preventDefault();

    var id= this.id;
    // alert(id);

    $.ajax({
        url : myAjax.ajaxurl,
        type : "post",
        dataType: "json",
        data : {
              'action': "pdeleted",
              'id'    : id,
               success : function(response){
               alert("Data Deleted Successfully");
               $("#form-body").hide();
               location.reload(true);
             },
            
        }
    });
});
// 


});