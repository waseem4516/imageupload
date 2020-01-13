<!DOCTYPE html>
<html>
<head>
<title>Ajax Multiple Image</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="vendor/jquery/jquery-ui/jquery-ui.css">
<script src="vendor/jquery/jquery-ui/jquery-ui.js" type="text/javascript"></script>


     <style type="text/css">

         .box4 {
             position: relative;
             width: 200px;
             border: 1px solid black;
             margin: 0 auto;
             padding: 3px;
             overflow: hidden;
         }

         .over-layer {
             position: absolute;
             left: 0;
             top: 0;
             width: 100%;
             height: 100%;
             text-align: center;
             background: #402e2e8f;

         }
         .box4 .over-layer{
             top: -100%;
             transition: all 0.40s ease-in-out 0.1s;
         }
         .box4 .over-layer i {
             position: relative;
             top: 50%;
             font-size: 20px;
             color: red;
             z-index: 1;
             opacity: 0;
             transition: all 0.40s ease-in-out 0.1s;
         }

         .box4:hover .over-layer i
         {

             opacity: 1;
             transition-delay: 0.1s;
         }
         .box4:hover .over-layer{
             top: 0;

         }
     </style>

 </head>
 <body>
  <br />
  <div class="container">
     <div align="right">
      <input type="file" name="multiple_files" id="multiple_files" multiple />
      <span class="text-muted">Only .jpg, png, .gif file allowed</span>
      <span id="error_multiple_files"></span>
     </div>
     <br/>             
     <div  id="image_table">
      
     </div>

      <button id="submit">Reorder</button>
  </div>
 </body>
</html>

<script>
$(document).ready(function(){
 load_image_data();
 function load_image_data()
 {
  $.ajax({
   url:"fetch.php",
   method:"POST",
   success:function(data)
   {
    $('#image_table').html(data);
   }
  });
 } 
 $('#multiple_files').change(function(){
  var error_images = '';
  var form_data = new FormData();
  var files = $('#multiple_files')[0].files;
  if(files.length > 10)
  {
   error_images += 'You can not select more than 10 files';
  }
  else
  {
   for(var i=0; i<files.length; i++)
   {
    var name = document.getElementById("multiple_files").files[i].name;
    var ext = name.split('.').pop().toLowerCase();
    if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
    {
     error_images += '<p>Invalid '+i+' File</p>';
    }
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("multiple_files").files[i]);
    var f = document.getElementById("multiple_files").files[i];
    var fsize = f.size||f.fileSize;
    if(fsize > 2000000)
    {
     error_images += '<p>' + i + ' File Size is very big</p>';
    }
    else
    {
     form_data.append("file[]", document.getElementById('multiple_files').files[i]);
    }
   }
  }
  if(error_images == '')
  {
   $.ajax({
    url:"upload.php",
    method:"POST",
    data: form_data,
    contentType: false,
    cache: false,
    processData: false,
    beforeSend:function(){
     $('#error_multiple_files').html('<br /><label class="text-primary">Uploading...</label>');
    },   
    success:function(data)
    {
     $('#error_multiple_files').html('<br /><label class="text-success">Uploaded</label>');
     load_image_data();
    }
   });
  }
  else
  {
   $('#multiple_files').val('');
   $('#error_multiple_files').html("<span class='text-danger'>"+error_images+"</span>");
   return false;
  }
 });  
 
 $(document).on('click', '.delete', function(){
  var image_id = $(this).attr("id");
  var image_name = $(this).data("image_name");
  if(confirm("Are you sure you want to remove it?"))
  {
   $.ajax({
    url:"delete.php",
    method:"POST",
    data:{image_id:image_id, image_name:image_name},
    success:function(data)
    {
     load_image_data();
     alert("Image removed");
    }
   });
  }
 }); 
 
});
</script>
<script type="text/javascript">
    $(document).ready(function () {
        var dropIndex;
        $("#image_table").sortable({
            stop: function(e, ui) {
              

                $sequence = ($.map($(this).find('.single'), function(el) {
                    return el.id + '=' + $(el).index();
                }));

            }
        });

    });

$('#submit').on('click', function () {

    $.ajax({
        url:'updateOrder.php',
        data:{'sequence':$sequence},
        type:'post',
        success:function(data){
            if(data=='1' || data==1){
                alert('updated successfully');
            }
        }
    })

})
</script>
