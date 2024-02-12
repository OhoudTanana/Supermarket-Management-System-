<?php
require "../includes/header.php";
require "../config/config.php";

if (isset($_SESSION['username'])) {
    echo "<script> window.location.href='" . APPURL . "' </script> ";
}

if (isset($_POST['submit'])) {
    // If the user clicked on the register button named submit
    $salesRepEmployeeNumber = $_POST['salesRepEmployeeNumber'];

    // Check if salesRepEmployeeNumber is not set or empty, then set it to null
    if (!isset($salesRepEmployeeNumber) || $salesRepEmployeeNumber === '') {
        $salesRepEmployeeNumber = null;
    }

    if ($salesRepEmployeeNumber !== null) {
        $checkEmployee = $conn->prepare("SELECT employeeNumber FROM employees WHERE employeeNumber = :employeeNumber");
        $checkEmployee->execute([':employeeNumber' => $salesRepEmployeeNumber]);
        $employeeExists = $checkEmployee->fetchColumn();

        if (!$employeeExists) {
            echo "<script> alert('Invalid Sales Employee Number');window.location.href='register.php' </script>";
            
        }
    }

    if (
        empty($_POST['customerNumber']) ||
        empty($_POST['contactLastName']) ||
        empty($_POST['contactFirstName']) ||
        empty($_POST['phone']) ||
        empty($_POST['addressLine1']) ||
        empty($_POST['city']) ||
        empty($_POST['postalCode']) ||
        empty($_POST['country']) ||
        empty($_POST['creditLimit'])
    ) {
        echo "<script> alert('One or more fields are empty');window.location.href='register.php' </script>";
    } else {
        try {
            // Insert customer
            $insertCustomer = $conn->prepare("INSERT INTO customers(customerNumber,customerName, contactLastName, contactFirstName, phone, addressLine1, addressLine2, city, state, postalCode, country, salesRepEmployeeNumber, creditLimit)
            VALUES(:customerNumber, :customerName, :contactLastName, :contactFirstName, :phone, :addressLine1, :addressLine2, :city, :state, :postalCode, :country, :salesRepEmployeeNumber, :creditLimit)");

            $insertCustomer->execute([
                ":customerNumber" => $_POST['customerNumber'],
                ":customerName" => $_POST['customerName'],
                ":contactLastName" => $_POST['contactLastName'],
                ":contactFirstName" => $_POST['contactFirstName'],
                ":phone" => $_POST['phone'],
                ":addressLine1" => $_POST['addressLine1'],
                ":addressLine2" => $_POST['addressLine2'],
                ":city" => $_POST['city'],
                ":state" => $_POST['state'],
                ":postalCode" => $_POST['postalCode'],
                ":country" => $_POST['country'],
                ":salesRepEmployeeNumber" => $salesRepEmployeeNumber,
                ":creditLimit" => $_POST['creditLimit'],
            ]);

            echo "<script> alert('Registration successful!'); window.location.href='login.php' </script>";
            exit();
        } catch (PDOException $e) {
            // Handle database errors
            echo "<script> alert('Database error: " . $e->getMessage() . "'); </script>";
        }
    }
}
?>




    <div class="hero-wrap js-fullheight" style="background-image: url('<?php echo APPURL;?>/images/R.jpeg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-start" data-scrollax-parent="true">
          <div class="col-md-7 ftco-animate">
          	<!-- <h2 class="subheading">Welcome to Vacation Rental</h2>
          	<h1 class="mb-4">Rent an appartment for your vacation</h1>
            <p><a href="#" class="btn btn-primary">Learn more</a> <a href="#" class="btn btn-white">Contact us</a></p> -->
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-section ftco-book ftco-no-pt ftco-no-pb">
    	<div class="container">
	    	<div class="row justify-content-middle" style="margin-left: 200px;">
	    		<div class="col-md-10 mt-5">
						<form action="register.php" method="POST" class="appointment-form" style="margin-top: -568px;">
							<h3 class="mb-3">Register</h3>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
			    					    <input required type ="text" name="customerNumber" class="form-control" placeholder="Customer Number">
			    				    </div>
								</div>
                                <div class="col-md-4">
									<div class="form-group">
			    					    <input required type ="text" name="customerName" class="form-control" placeholder="Customer Name">
			    				    </div>
								</div>

			<div class="col-md-4">
                <div class="form-group">
                <input required type ="text" name="contactLastName" class="form-control" placeholder="Contact Last Name">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <input required type ="text" name="contactFirstName" class="form-control" placeholder="Contact First Name">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <input required type ="text" name="phone" class="form-control" placeholder="Phone">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <input required type ="text" name="addressLine1" class="form-control" placeholder="Address Line 1">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <input type="text" name="addressLine2" class="form-control" placeholder="Address Line 2">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <input required type ="text" name="city" class="form-control" placeholder="City">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <input type ="text" name="state" class="form-control" placeholder="State">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <input required type ="text" name="postalCode" class="form-control" placeholder="Postal Code">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <input required type ="text" name="country" class="form-control" placeholder="Country">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <input type="text" name="salesRepEmployeeNumber" class="form-control" placeholder="Sales Employee Number">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <input required type="text" name="creditLimit" class="form-control" placeholder="Credit Limit">
            </div>
        </div>

        
        <div class="col-md-4">
            <div class="form-group">
                <input style="margin-left: 240px;" type="submit" name="submit" value="Register" class="btn btn-primary py-3 px-4">
</div>
        </div>
    </div>
</form>
								
							

    </section>

  <?php require "../includes/footer.php"; ?>