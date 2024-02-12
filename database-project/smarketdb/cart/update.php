<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["cartID"]) && isset($_POST["quantity"])) {
  
    $cartID = $_POST["cartID"];

    try {
        $conn->beginTransaction();
        // Get the product details before updating
        $itemDetailsQuery = $conn->prepare("SELECT p.buyPrice, c.quantity
                                            FROM shopping_cart c
                                            JOIN products p ON c.productCode = p.productCode
                                            WHERE c.cartID = :cartID AND c.customerNumber = :customerNumber");
        $itemDetailsQuery->bindParam(":cartID", $cartID);
        $itemDetailsQuery->bindParam(":customerNumber", $_SESSION['id']);
        $itemDetailsQuery->execute();
        $itemDetails = $itemDetailsQuery->fetch(PDO::FETCH_OBJ);

        // Ensure that the query fetched the expected columns
        if (!$itemDetails || !property_exists($itemDetails, 'buyPrice') || !property_exists($itemDetails, 'quantity')) {
            // Handle the error or display a message
            echo '<script>alert("Error: Could not fetch item details."); window.location.href = "view_cart.php";</script>';
            exit;
        }

        // Update the quantity in the shopping cart
        $updateQuery = $conn->prepare("UPDATE shopping_cart SET quantity = :quantity WHERE cartID = :cartID AND customerNumber = :customerNumber");
        $updateQuery->bindParam(":quantity", $_POST["quantity"]);
        $updateQuery->bindParam(":cartID", $cartID);
        $updateQuery->bindParam(":customerNumber", $_SESSION['id']);
        $updateQuery->execute();

        // Recalculate total amount
        $totalAmount = 0;
        $cartItemsQuery = $conn->prepare("SELECT p.buyPrice, c.quantity
                                          FROM shopping_cart c
                                          JOIN products p ON c.productCode = p.productCode
                                          WHERE c.customerNumber = :customerNumber");
        $cartItemsQuery->bindParam(":customerNumber", $_SESSION['id']);
        $cartItemsQuery->execute();
        $cartItems = $cartItemsQuery->fetchAll(PDO::FETCH_OBJ);

        foreach ($cartItems as $item) {
            $totalAmount += $item->buyPrice * $item->quantity;
        }

        // Update the total amount in the shopping cart table
        $updateTotalAmountQuery = $conn->prepare("UPDATE shopping_cart
                                                 SET totalAmount = :totalAmount
                                                 WHERE customerNumber = :customerNumber");
        $updateTotalAmountQuery->bindParam(":totalAmount", $totalAmount);
        $updateTotalAmountQuery->bindParam(":customerNumber", $_SESSION['id']);
        $updateTotalAmountQuery->execute();

        $conn->commit();
        echo '<script>alert("Quantity updated successfully."); window.location.href = "view_cart.php";</script>';
    } catch (Exception $e) {
        $conn->rollBack();
        echo '<script>alert("Error updating quantity: ' . $e->getMessage() . '"); window.location.href = "view_cart.php";</script>';
    }
} else {
    echo '<script>alert("Invalid request."); window.location.href = "view_cart.php";</script>';
}

require "../includes/footer.php";
?>