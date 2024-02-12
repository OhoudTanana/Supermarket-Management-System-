<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>


<?php 
//we need to validate also, that if the user is logged in, he wont be able to access the login and register page

if(isset($_SESSION['adminname'])){
  echo "<script> window.location.href='".ADMINURL."' </script> "; //is user not set we go back to the hotel page
  //we use javascript
 }
 
 
 if(isset($_POST['submit'])){ 
 
   //we need to validate the entered data inside the field
   if(empty($_POST['email']) OR empty($_POST['password'])){
 
     echo "<script> alert('one or more inputs are empty') </script>"; //if not valid display an alert
   }else{
 
     $email = $_POST['email'];
     $password = $_POST['password'];
 
     //validate the email with th equery
 
     $login = $conn->query("SELECT * FROM admins WHERE email = '$email'"); //this certain query returns a number, nb 1 since its only affecting one email
     $login->execute();
 
     $fetch = $login->fetch(PDO::FETCH_ASSOC);
 
     //get the row count
 
     if($login->rowCOUNT() > 0){ //to validate the email, where going to bring the query that we have and add to it the 
       //rowCount(), its goign to grab the nb of affected data, affected rows for a certain query, then if the user
       //entered the right email this is going to affect only one row, if it matches its going to grab a row 
       //if its one (>0), then 
 
       if(password_verify($password, $fetch['mypassword'])){
         //if they match, we create a session, so that we can carry info across pages
         
        // echo "<script>alert('LOGGED IN')</script>";
 
         //1.Creating our session variables
         $_SESSION['adminname'] = $fetch['adminname'];
         $_SESSION['id'] = $fetch['id'];
 
         header("location: ".ADMINURL."");
 
       }
       else{
         echo "<script> alert('email or password is wrong') </script>";
       }
 
     }else{
       echo "<script> alert('email or password is wrong') </script>";
     }
 
   }
 }


?>
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mt-5">Login</h5>
              <form method="POST" class="p-auto" action="login-admins.php">
                  <!-- Email input -->
                  <div class="form-outline mb-4">
                    <input type="email" name="email" id="form2Example1" class="form-control" placeholder="Email" />
                   
                  </div>

                  
                  <!-- Password input -->
                  <div class="form-outline mb-4">
                    <input type="password" name="password" id="form2Example2" placeholder="Password" class="form-control" />
                    
                  </div>



                  <!-- Submit button -->
                  <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">Login</button>

                 
                </form>

            </div>
       </div>
       <?php require "../layouts/footer.php"; ?>