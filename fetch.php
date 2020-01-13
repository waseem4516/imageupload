


<?php
include('database_connection.php');
$query = "SELECT * FROM tbl_image ORDER BY img_position ASC";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$number_of_rows = $statement->rowCount();

$output = '';

if($number_of_rows > 0)
{
 $count = 0;
 foreach($result as $row)
 {
  $count ++; 
  $output .= '
  <div class="col-sm-3 box4 single" id="image-list'.$row["image_id"].'" data-position="'.$row["img_position"].'">
   
     <img src="files/'.$row["image_name"].'" width="200" height="200"  />
     <div class="over-layer">
          <i style="position: relative;top: 50%;transform: translateY(-50%);" class="delete over-layer" id="'.$row["image_id"].'" data-image_name="'.$row["image_name"].'">X</i>
      </div>
     
    
    </div>
    </div>
 
  ';

 }
}
else
{
 $output .= 'No Data Found';
}
$output .= '';
echo $output;

?>

