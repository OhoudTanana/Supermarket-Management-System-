<?php
session_start(); // Start the session
require "../layouts/header.php";
require "../../config/config.php";

// For the session
if (!isset($_SESSION['adminname'])) {
    header("Location: " . ADMINURL . "/admins/login-admins.php"); // If user is not set, redirect to the login page
    exit();
}

// For the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Validate the entered data inside the fields
    $productCode = isset($_POST['productCode']) ? $_POST['productCode'] : '';
    $productName = isset($_POST['name']) ? $_POST['name'] : '';
    $productDescription = isset($_POST['productDescription']) ? $_POST['productDescription'] : '';
    $productVendor = isset($_POST['productVendor']) ? $_POST['productVendor'] : '';

    if (empty($productCode) || empty($productName) || empty($productDescription) || empty($productVendor)) {
        echo "<script> alert('One or more inputs are empty') </script>"; // Display an alert if not valid
    } else {
        // If valid, save the submitted info by the form
        try {
            $insert = $conn->prepare("INSERT INTO products (productCode, productName, productDescription, productVendor) VALUES (:productCode, :productName, :productDescription, :productVendor)");

            $insert->execute([
                ":productCode" => $productCode,
                ":productName" => $productName,
                ":productDescription" => $productDescription,
                ":productVendor" => $productVendor,
            ]);

            echo "<script>
                alert('Product added successfully');
                window.location.replace('show-products.php');
            </script>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>

<!-- Your HTML form -->
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-5 d-inline">Add Products</h5>
                <form method="POST" action="add-products.php" enctype="multipart/form-data">
                    <!-- Product Code input -->
                    <div class="form-outline mb-4 mt-4">
                        <label for="productCode">Product Code</label>
                        <input type="text" name="productCode" id="productCode" class="form-control" placeholder="Product Code" required />
                    </div>

                    <!-- Product Name input -->
                    <div class="form-outline mb-4 mt-4">
                        <label for="form2Example1">Product Name</label>
                        <input type="text" name="name" id="form2Example1" class="form-control" placeholder="Name" required />
                    </div>

                    <!-- Description input -->
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Description</label>
                        <textarea name="productDescription" class="form-control" id="exampleFormControlTextarea1" rows="3" required></textarea>
                    </div>

                    <!-- Product Vendor input -->
                    <div class="form-outline mb-4 mt-4">
                        <label for="form2Example1">Product Vendor</label>
                        <input type="text" name="productVendor" id="form2Example1" class="form-control" required />
                    </div>

                    <!-- Submit button -->
                    <button type="submit" name="submit" class="btn btn-primary mb-4 text-center">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require "../layouts/footer.php"; ?>
