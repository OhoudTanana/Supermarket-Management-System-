<?php 

session_start();
session_unset();
session_destroy();

//since the login page is the only page that the admin is going to access after logging out then we have to redirect him after the session is destroyed
header("location: http://localhost/php-project/hotel-booking/admin-panel/admins/login-admins.php");

?>