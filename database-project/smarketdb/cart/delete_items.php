<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["cartID"])) {
    $cartID = $_POST["cartID"];

    try {
        $conn->beginTransaction();

         // Get the product details before deleting
         $itemDetailsQuery = $conn->prepare("SELECT p.buyPrice, c.quantity
         FROM shopping_cart c
         JOIN products p ON c.productCode = p.productCode
         WHERE c.cartID = :cartID");
         $itemDetailsQuery->bindParam(":cartID", $cartID);
         $itemDetailsQuery->execute();
         $itemDetails = $itemDetailsQuery->fetch(PDO::FETCH_OBJ);


         // Ensure that the query fetched the expected columns
         if (!$itemDetails || !property_exists($itemDetails, 'buyPrice') || !property_exists($itemDetails, 'quantity')) {
          // Handle the error or display a message
        echo '<script>alert("Error: Could not fetch item details."); window.location.href = "view_cart.php";</script>';
        exit;
        }


        // Delete the item from the shopping cart
        $deleteQuery = $conn->prepare("DELETE FROM shopping_cart WHERE cartID = :cartID");
        $deleteQuery->bindParam(":cartID", $cartID);
        $deleteQuery->execute();

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
        echo '<script>alert("Item deleted successfully."); window.location.href = "view_cart.php";</script>';


    } catch (Exception $e) {
        $conn->rollBack();
        echo '<script>alert("Error updating quantity: ' . $e->getMessage() . '"); window.location.href = "view_cart.php";</script>';

    }
} else {
    echo '<script>alert("Invalid request."); window.location.href = "view_cart.php";</script>';

}
?>

<?php require "../includes/footer.php"; ?>