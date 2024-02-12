<?php

require "../../config/config.php";

if(isset($_GET['productCode'])){

    $productCode = $_GET['productCode'];

    $getImage = $conn->query("SELECT * FROM products WHERE productCode ='$productCode'");
    $getImage->execute();

    $fetch = $getImage->fetch(PDO::FETCH_OBJ);

    //we can acces the image by $fetch->image, and to delete eit we use unlink

    unlink("hotel_images/". $fetch->image) ;

    $delete = $conn->query("DELETE FROM products WHERE id ='$productCode'");
    $delete->execute();

    header("location : show-products.php");


}
?>