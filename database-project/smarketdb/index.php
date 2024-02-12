<?php require "includes/header.php"; ?>
<?php require "config/config.php"; ?>

<?php

$offices = $conn->query("SELECT * FROM offices");

$offices->execute();

$allOffices = $offices->fetchALL(PDO::FETCH_OBJ); 

?>


    <div class="hero-wrap js-fullheight" style="background-image: url('images/R.jpeg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-start" data-scrollax-parent="true">
          <div class="col-md-7 ftco-animate">
          	<h2 class="subheading">Welcome</h2>
          	<h1 class="mb-4">Shop and View Various Items</h1>
            <p><a href="<?php echo APPURL;?>/about.php" class="btn btn-primary">Learn more</a> <a href="<?php echo APPURL;?>/contact.php" class="btn btn-white">Contact us</a></p>
          </div>
        </div>
      </div>
    </div>

  
    <section class="ftco-section ftco-services">
    	<div class="container">
    		<div class="row">

			<?php foreach($allOffices as $offices) : ?>
          <div class="col-md-4 d-flex services align-self-stretch px-4 ftco-animate">
            <div class="d-block services-wrap text-center">
              <div class="media-body py-4 px-3">
                <h3 class="heading">Office Code:<?php echo $offices->officeCode; ?></h3>
                <p>Location: <?php echo $offices->city; ?>.</p>
				<p>Phone Number: <?php echo $offices->phone; ?></p>
				<p>Address Line1: <?php echo  $offices->addressLine1; ?></p>
				<p>Address Line2: <?php echo $offices->addressLine2; ?></p>
				<p>State: <?php echo $offices->state; ?></p>
				<p>Country: <?php echo $offices->country; ?></p>
				<p>Postal Code: <?php echo $offices->postalCode; ?> </p>
				<p>Territory: <?php echo $offices->territory; ?></p>
               
			<p><a href="<?php echo APPURL; ?>/view_employees.php?officeCode=<?php echo $offices->officeCode; ?>" class="btn btn-primary">
              View Employees</a></p>
               
           
            
              </div>
			
            </div>    
			  
          </div>

		   <?php endforeach; //information will be pulled dynamically from database not displayed by html ?>  
 
        </div>
    	</div>
    </section>
		<section class="ftco-intro" style="background-image: url(images/P.jpeg);" data-stellar-background-ratio="0.5">
			<div class="overlay"></div>
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-md-9 text-center">
						<h2>Ready to get started</h2>
						<p class="mb-4">It’s safe to shop online with us! Get your stuff in clicks or drop us a line with your questions.</p>
						<p class="mb-0"><a href="<?php echo APPURL;?>/about.php" class="btn btn-primary px-4 py-3">Learn More</a> <a href="<?php echo APPURL;?>/contact.php" class="btn btn-white px-4 py-3">Contact us</a></p>
					</div>
				</div>
			</div>
		</section>


  <?php require "includes/footer.php"; ?>
