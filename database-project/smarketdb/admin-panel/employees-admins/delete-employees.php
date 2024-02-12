<?php

require "../../config/config.php";

if(isset($_GET['id'])){

    $id = $_GET['id'];

    $getImage = $conn->query("SELECT * FROM rooms WHERE id ='$id'");
    $getImage->execute();

    //deleting image from file
    $fetch = $getImage->fetch(PDO::FETCH_OBJ);

    //we can acces the image by $fetch->image, and to delete eit we use unlink

    unlink("room_images/". $fetch->image) ;

    //deleting data from database
    $delete = $conn->query("DELETE FROM rooms WHERE id ='$id'");
    $delete->execute();

    header("location: show-rooms.php");


}
?>