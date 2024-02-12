<?php require "includes/header.php"; ?>
<?php require "config/config.php"; ?>

<?php

if (isset($_SESSION['id'])) {
    $customerNumber = $_SESSION['id'];

    if (isset($_POST['addToCart']) && isset($_POST['productCode'])) {
        $productCode = $_POST['productCode'];

        // Check if the item is already in the cart for the customer
        $checkCartQuery = $conn->prepare("SELECT * FROM shopping_cart WHERE customerNumber = :customerNumber AND productCode = :productCode");
        $checkCartQuery->bindParam(":customerNumber", $customerNumber);
        $checkCartQuery->bindParam(":productCode", $productCode);
        $checkCartQuery->execute();

        // Check if the product is in stock
        $productStockQuery = $conn->prepare("SELECT quantityInStock FROM products WHERE productCode = :productCode");
        $productStockQuery->bindParam(":productCode", $productCode);
        $productStockQuery->execute();
        $quantityInStock = $productStockQuery->fetchColumn();

        if ($checkCartQuery->rowCount() > 0) {
            // Update quantity if the item is already in the cart
            $updateCartQuery = $conn->prepare("UPDATE shopping_cart SET quantity = quantity + 1 WHERE customerNumber = :customerNumber AND productCode = :productCode");
            $updateCartQuery->bindParam(":customerNumber", $customerNumber);
            $updateCartQuery->bindParam(":productCode", $productCode);
            $updateCartQuery->execute();
        } else {
            // Insert new item to the cart
            if ($quantityInStock > 1) {
                $insertCartQuery = $conn->prepare("INSERT INTO shopping_cart (customerNumber, productCode, quantity) VALUES (:customerNumber, :productCode, 1)");
                $insertCartQuery->bindParam(":customerNumber", $customerNumber);
                $insertCartQuery->bindParam(":productCode", $productCode);
                $insertCartQuery->execute();

                   // Decrease the stock quantity in the products table
                $updateStockQuery = $conn->prepare("UPDATE products SET quantityInStock = quantityInStock - 1 WHERE productCode = :productCode");
                $updateStockQuery->bindParam(":productCode", $productCode);
                $updateStockQuery->execute();
            } else {
                // Product is out of stock
                echo '<script>alert("Sorry, this product is out of stock."); window.location.href = "products.php";</script>';
                exit;
            }
        }

        echo '<script>alert("Item added to the cart."); window.location.href = "products.php";</script>';
    }
}

$products = $conn->query("SELECT * FROM products");
$products->execute();
$allProducts = $products->fetchAll(PDO::FETCH_OBJ);
?>
 <section style="margin-top: 150px;" class="ftco-section ftco-services">
    	<div class="container">
    		<div class="row">

			<?php foreach($allProducts as $products) : //looping through this array, then grab it as an object, by fetch ?>
          <div class="col-md-4 d-flex services align-self-stretch px-4 ftco-animate">
            <div class="d-block services-wrap text-center">
              <div class="media-body py-4 px-3">
                <h3 class="heading">Product Code: <?php echo $products->productCode; ?></h3>
                <p>Product Name: <?php echo $products->productName; ?>.</p>
				<p>Product Line: <?php echo $products->productLine; ?></p>
				<p>Product Scale: <?php echo  $products->productScale; ?></p>
				<p>Product Vendor: <?php echo $products->productVendor; ?></p>
				<p>Product Description: <?php echo $products->productDescription; ?></p>
				<p>Quantity In Stock: <?php echo $products->quantityInStock; ?></p>
				<p>Buy Price: <?php echo $products->buyPrice; ?> </p>
				<p>MSRP: <?php echo $products->MSRP; ?></p>
				<form method="post">
                                <input type="hidden" name="productCode" value="<?php echo $products->productCode; ?>">
                                <input type="submit" class="btn btn-primary" name="addToCart" value="Add to Cart">
                            </form>
            </div>    
          </div>
		</div>

		   <?php endforeach; //information will be pulled dynamically from database not displayed by html ?>  
 
        </div>
    	</div>
    </section>

<?php require "includes/footer.php"; ?>