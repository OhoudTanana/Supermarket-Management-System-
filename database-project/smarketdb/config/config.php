<?php
//those constants will stay the same along the whole project


//try catch, where the database connection is attempted
try
    {
//specifies the host name of the database server 
define("HOST", "localhost");

//specifies the dbname to connect to 
define("DBNAME", "smarketdb");

//specifies the username for connecting to database
define("USER", "root");

//password for database user, i dont have a password for my php admin tool
define("PASS", "");

//create an object from the pdo(certain way or a tool inside php that allows you to simply connect to databases in
//a more secure way, alot more sequre than mysqli -not valid rn-) class that we have inside our own php
//PDO , PHP Data Objects, interact with database regardless of the DBMS used

//create a new PDO instance for database connection
$conn = new PDO("mysql: host=".HOST.";dbname=".DBNAME."", USER, PASS); 
//1. Create a new PDO instance
//2. The first arg specifies the database type ("mysql")
//3. second arg is the concatentaion of the host and dbname using the constarants
//4. third and forth arg are the username and the pass to the db connection 



//Set PDO attributes to handle errors
//if something is wrong with the database connection, we can fullyy validate for the database connection
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//The setAttribute method is used to set attributes for the PDO instance.
//In this case, it sets the error handling mode.

}

catch (PDOException $e) //PDOException is another pdo class
    {
        //catch any exceptions (errors) that occur during the connection of database
        echo $e->getMessage();
    }



?>
