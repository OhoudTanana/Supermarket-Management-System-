<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php

if (isset($_SESSION['id'])) {
    $customerNumber = $_SESSION['id'];


if (isset($_POST['productCode']) && isset($_POST['quantity'])) {

    $productCode = $_POST['productCode'];
    $quantity = intval($_POST['quantity']);


        // Check if the item is already in the cart for the customer
        $checkCartQuery = $conn->prepare("SELECT * FROM shopping_cart WHERE customerNumber = :customerNumber AND productCode = :productCode");
        $checkCartQuery->bindParam(":customerNumber", $customerNumber);
        $checkCartQuery->bindParam(":productCode", $productCode);
        $checkCartQuery->execute();

        if ($checkCartQuery->rowCount() > 0) {
            // Update quantity if the item is already in the cart
            $updateCartQuery = $conn->prepare("UPDATE shopping_cart SET quantity = quantity + :quantity WHERE customerNumber = :customerNumber AND productCode = :productCode");
            $updateCartQuery->bindParam(":quantity", $quantity);
            $updateCartQuery->bindParam(":customerNumber", $customerNumber);
            $updateCartQuery->bindParam(":productCode", $productCode);
            $updateCartQuery->execute();
        } else {
            // Insert new item to the cart
            $insertCartQuery = $conn->prepare("INSERT INTO shopping_cart (customerNumber, productCode, quantity) VALUES (:customerNumber, :productCode, :quantity)");
            $insertCartQuery->bindParam(":customerNumber", $customerNumber);
            $insertCartQuery->bindParam(":productCode", $productCode);
            $insertCartQuery->bindParam(":quantity", $quantity);
            $insertCartQuery->execute();
        }

        echo '<script>alert("Item added to the cart.");</script>';
	} else {
        echo '<script>alert("Invalid Request");</script>';
    }
} else {
    echo '<script>alert("User not logged in.");</script>';
}
?>

<?php require "../includes/footer.php"; ?>
