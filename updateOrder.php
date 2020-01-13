<?php
include('database_connection.php');

if(isset($_POST['sequence'])){

    foreach ($_POST['sequence'] as $sequence){

        $k = explode('=', $sequence);

        $id = str_replace('image-list', '', $k[0]);
        $pos = $k[1];
        echo $pos.' = '.$id;
        $query = "
       UPDATE tbl_image SET img_position = '".$pos."' WHERE  image_id='".$id."' ";
        $statement = $connect->prepare($query);
        $statement->execute();
    }

    echo '1';

}
?>