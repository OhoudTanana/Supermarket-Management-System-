<?php
//we neeed to:start the session, unset the varibales, destroy the session

session_start();
session_unset();
session_destroy();

header("location: http://localhost/database-project/smarketdb/index.php");

//since session is destroyed and the varibales ar eunset, due to validation, instead of the username and the menue, 
//the loggin and register will show on again


?>
