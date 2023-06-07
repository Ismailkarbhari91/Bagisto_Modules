


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
<?php

$id = $_GET['id'];
$title=$_GET['title'];
$product=$_GET['product'];
// echo $id;
?>

    <div class="container">
        <div class="card mt-4" id="form-body">
            <div class="card-header">
                Update Data
            </div>
            <div class="card-body">
                    <input id="id" type="hidden" value="<?php echo $id; ?>" name="id">
                    <div class="form-group">
                        <label>Name </label>
                        <input id="name" type="text" value="<?php echo $title; ?>" class="form-control" name="name">
                    </div>
                    <div class="form-group mt-2">
                        <label>Email</label>
                        <input id="product" type="text" value="<?php echo $product;?>" class="form-control" name="product">
                    </div>
                    <button type="submit" class="btn btn-primary mt-2 edit" id="submit">Submit</button>
               
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- <script>

    jQuery(document).ready(function($) {

        $(".edit").on('click',function(e){

            var id=$('#id').val();
            alert(id);
            var title=$('#name').val();
            var product=$('#product').val();


            var settings = {
          "url": "http://localhost/plugin/wp-json/happyhours/v1/edit",
          "method": "POST",
          "timeout": 0,
           "headers": {
                "Content-Type": "application/json"
            },
            "data": JSON.stringify({
                "data": {
                "id": id,
                "title":title,
                "product": product
                }
  }),
};

$.ajax(settings).done(function (response) {
  console.log(response);
});
} );
});
    </script> -->

