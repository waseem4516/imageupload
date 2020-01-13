
<?php

include('database_connection.php');


if(count($_FILES["file"]["name"]) > 0)
{

 sleep(3);
 for($count=0; $count<count($_FILES["file"]["name"]); $count++)
 {
    $file_name = $_FILES["file"]["name"][$count];
    $tmp_name = $_FILES["file"]['tmp_name'][$count];
    $file_array = explode(".", $file_name);
    $file_extension = end($file_array);
    if(file_already_uploaded($file_name, $connect))
      {
       $file_name = $file_array[0] . '-'. rand() . '.' . $file_extension;
      }
    $location = 'files/' . $file_name;
    if(move_uploaded_file($tmp_name, $location))
      {

          $query = "SELECT * FROM tbl_image ORDER BY img_position DESC LIMIT 1";
          $statement = $connect->prepare($query);
          $statement->execute();
          $result = $statement->fetchAll();
          $position = $result[0]['img_position']+1;
       $query = "
       INSERT INTO tbl_image (image_name, image_description, img_position) 
       VALUES ('".$file_name."', '', '".$position."')
       ";
       $statement = $connect->prepare($query);
       $statement->execute();
      }

 }

      foreach($_FILES['file']['name'] as $keys => $values)  
      {  
           if(move_uploaded_file($_FILES['file']['tmp_name'][$keys], 'destination/' . $values))  
           {  
                
                $output .= '<div class=col-sm-3">
                <div class="panel-group">
                <div class="panel box4">
                <img src="destination/'.$values.'" class="img-responsive" width="200" height="200" />
                </div>
                </div>
                </div>';  
           }  
      }  
 }  
 echo $output;  




function file_already_uploaded($file_name, $connect)
{
 
 $query = "SELECT * FROM tbl_image WHERE image_name = '".$file_name."'";
 $statement = $connect->prepare($query);
 $statement->execute();
 $number_of_rows = $statement->rowCount();
 if($number_of_rows > 0)
 {
  return true;
 }
 else
 {
  return false;
 }
}

?>
<?php   
   
 
 ?>

