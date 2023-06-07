jQuery(document).ready(function($) {
    $('#tblUser').DataTable();
    $("#form-body").hide();

    $("#insert-btn").on('click',function(){
        $("#form-body").toggle(500);
    });

    $("#submit").on('click',function(e){
        e.preventDefault();

        var titles = $('#title').val();
        var products = $('#product').val();

        var priority=$('#priority').val();

        $.ajax({
            url : ajax_object.ajax_url,
            type : "post",
            dataType: "json",
            data : {
                  'action': "insert",
                  'title' : titles,
                  'product' : products,
                  'priority' :priority,
                   success : function(response){
                   alert("Data Inserted Successfully");
                   $("#form-body").hide();
                   location.reload(true);
                 },
                
            }
        });
    });


    $(".delete").on('click',function(e){

        e.preventDefault();


		
        var origin   = wnm_custom.base_url;

  

        var id= this.id ;
        var settings = {
            "url": origin+"/wp-json/happyhours/v1/delete",
            "method": "POST",
            "timeout": 0,
            "headers": {
              "Content-Type": "application/json"
            },
            "data": JSON.stringify({
              "data": {
                "id": id
              }
            }),
          };
          
          $.ajax(settings).done(function (response) {
            alert('Data Deleted Successfully');
			  location.reload(true);
          });
  } );


    
  $(".edit").on('click',function(e){
    e.preventDefault();


   

       var currentRow=$(this).closest("tr");

      //  var col0=currentRow.find("td:eq(0)").html();
       var col1=currentRow.find("td:eq(1)").html();
       var col2=currentRow.find("td:eq(2)input[type='hidden']").html();
      
    


       var h=$('input[type=hidden]',currentRow.find("td:eq(2)")).val();


       var h1=$('input[type=hidden]',currentRow.find("td:eq(0)")).val();

      var col3=currentRow.find("td:eq(3)").html();

       $('#pop_priority').val(col3);



       $('#pop_title').val(col1);

       $('#pop_id').val(h1);


       $('#pop_product').val(h);



      $("#myModal").modal("show");

    });

    $(".update").on('click',function(e){

      e.preventDefault();
           
          var id=$('#pop_id').val();

            var title=$('#pop_title').val();
    
            var product=$('#pop_product').val();

            var priority=$('#pop_priority').val();

            var origin   = wnm_custom.base_url;

            // alert(origin);

            var settings = {
              "url": origin+"/wp-json/happyhours/v1/edit",
              "method": "POST",
              "timeout": 0,
               "headers": {
                    "Content-Type": "application/json"
                },
                "data": JSON.stringify({
                    "data": {
                    "id": id,
                    "title":title,
                    "product": product,
                    "priority": priority,                    
                 }
      }),
    };
    
    $.ajax(settings).done(function (response) {
      console.log(response);
		alert("Data Updated Successfully");
		location.reload(true);
    });
		
		

    });

  $(".close").on('click',function(e){
    $("#myModal").modal("hide");
  });


  
});
