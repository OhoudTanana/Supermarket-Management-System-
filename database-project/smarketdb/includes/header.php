<?php
//start the session
session_start();

//the base url

define("APPURL", "http://localhost/database-project/smarketdb");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Supermarket Managment System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,500,500i,600,600i,700,700i&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
 
    <link rel="stylesheet" href="<?php echo APPURL;?>/css/animate.css">
    
    <link rel="stylesheet" href="<?php echo APPURL;?>/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo APPURL;?>/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?php echo APPURL;?>/css/magnific-popup.css">

    <link rel="stylesheet" href="<?php echo APPURL;?>/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="<?php echo APPURL;?>/css/jquery.timepicker.css">

    <link rel="stylesheet" href="<?php echo APPURL;?>/css/flaticon.css">
    <link rel="stylesheet" href="<?php echo APPURL;?>/css/style.css">
  </head>
  <body>
		<div class="wrap">
			<div class="container">
				<div class="row justify-content-between">
						<div class="col d-flex align-items-center">
							<p class="mb-0 phone"><span class="mailus">Phone no:</span> <a href="contact.php">+00 1234 567</a> or <span class="mailus">email us:</span> <a href="contact.php">emailsample@email.com</a></p>
						</div>
						<div class="col d-flex justify-content-end">
							<div class="social-media">
				    		<p class="mb-0 d-flex">
				    			<a  class="d-flex align-items-center justify-content-center"><span class="fa fa-facebook"><i class="sr-only">Facebook</i></span></a>
				    			<a  class="d-flex align-items-center justify-content-center"><span class="fa fa-twitter"><i class="sr-only">Twitter</i></span></a>
				    			<a  class="d-flex align-items-center justify-content-center"><span class="fa fa-instagram"><i class="sr-only">Instagram</i></span></a>
				    			<a  class="d-flex align-items-center justify-content-center"><span class="fa fa-dribbble"><i class="sr-only">Dribbble</i></span></a>
				    		</p>
			        </div>
						</div>
				</div>
			</div>
		</div>
		<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
	    	<a class="navbar-brand" href="<?php echo APPURL;?>">Supermarket<span>System</span></a>
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="fa fa-bars"></span> Menu
	      </button>
	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
	        	<li class="nav-item active"><a href="<?php echo APPURL; ?>" class="nav-link">Home</a></li>
				<li class="nav-item "><a href="<?php echo APPURL; ?>/products.php" class="nav-link">Products</a></li>
	        	<li class="nav-item"><a href="<?php echo APPURL; ?>/about.php" class="nav-link">About</a></li>
	          <li class="nav-item"><a href="<?php echo APPURL; ?>/contact.php" class="nav-link">Contact</a></li>

			  <?php //when we are logged in we only need to show  the menue without the login and register
			   if(!isset($_SESSION['username'])) : //if not set yet, dispaly login and regitser ?> 

	          <li class="nav-item"><a href="<?php echo APPURL;?>/auth/login.php" class="nav-link">Login</a></li>
			  <li class="nav-item"><a href="<?php echo APPURL;?>/auth/register.php" class="nav-link">Register</a></li>
			 <?php  else: //if set display the menue?>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle"  id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            
		  <?php echo $_SESSION['username']; ?>
			
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="<?php echo APPURL;?>/users/orders.php">Your Orders</a></li>
            <li><a class="dropdown-item" href="<?php echo APPURL; ?>/cart/view_cart.php">Your Cart</a></li>
        
            <li><a class="dropdown-item" href="<?php echo APPURL; ?>/auth/logout.php">Logout</a></li>
          </ul>
        </li>

		<?php endif; //to show a more cleaner code, this resembles the end of if?> 


	        </ul>
	      </div>
	    </div>
	  </nav>
