<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>


<?php
if (isset($_SESSION['id'])) {
    $customerNumber = $_SESSION['id'];

    // Fetch cart items for the logged-in customer
    $cartQuery = $conn->prepare("SELECT c.cartID, p.productCode, p.productName, p.buyPrice, c.quantity
                                 FROM shopping_cart c
                                 JOIN products p ON c.productCode = p.productCode
                                 WHERE c.customerNumber = :customerNumber");
    $cartQuery->bindParam(":customerNumber", $customerNumber);
    $cartQuery->execute();

    $cartItems = $cartQuery->fetchAll(PDO::FETCH_OBJ);
// Calculate total amount
$totalAmount = 0;
foreach ($cartItems as $item) {
    $totalAmount += $item->buyPrice * $item->quantity;
}
} else {
// Redirect to login page or show a message if the user is not logged in
echo '<script>alert("Please log in to view your cart."); window.location.href = "login.php";</script>';
exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
</head>
<body>

    <h2>Your Shopping Cart</h2>

    <?php if (count($cartItems) > 0) : ?>
        <table class="table mt-5">
        <thead>
            <tr>
                <th scope="col">Product Code</th>
                <th scope="col">Product Name</th>
                <th scope="col">Item Price</th>
                <th scope="col"> Quantity</th>
                <th scope="col">Total</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
            <tbody>
                <?php foreach ($cartItems as $item) : ?>
                    <tr>
                        <td><?php echo $item->productCode; ?></td>
                        <td><?php echo $item->productName; ?></td>
                        <td><?php echo $item->buyPrice; ?></td>
                        <td><?php echo $item->quantity; ?></td>
                        <td><?php echo $item->buyPrice * $item->quantity; ?></td>
                        <td>
                            <!-- Add a form for deleting an item -->
                            <form method="post" action="delete_items.php">
                                <input type="hidden" name="cartID" value="<?php echo $item->cartID; ?>">
                                <input type="submit" class="btn btn-danger" value="Delete">
                            </form>

                            <!-- Add a form for updating the quantity -->
                            <form method="post" action="update.php">
                                <input type="hidden" name="cartID" value="<?php echo $item->cartID; ?>">
                                <input type="number" name="quantity" value="<?php echo $item->quantity; ?>" min="1">
                                <input type="submit" class="btn btn-primary" value="Update">
                            </form>
                        <td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Display total amount -->
        <h2> <p>Total Amount: <?php echo $totalAmount; ?></p> </h2>
    <?php else : ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>

    
    <a href="pay.php" style="margin-left: 600px;" class="btn btn-primary px-4 py-3">Proceed to Checkout</a>

</body>
</html>


<?php require "../includes/footer.php"; ?>