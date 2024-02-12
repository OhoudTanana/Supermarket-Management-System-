<?php
require "../includes/header.php";
require "../config/config.php";

// Ensure user is logged in and has items in the cart
if (!isset($_SESSION['id'])) {
    echo '<script>alert("Please log in to view your cart."); window.location.href = "login.php";</script>';
    exit;
}

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

// Insert order record into the database
$orderDate = date('Y-m-d');
$requiredDate = date('Y-m-d', strtotime($orderDate . ' + 7 days')); // Assume required in 7 days
$status = 'Pending'; // You can adjust the initial status
$comments = ''; // You can add comments as needed

try {
    $conn->beginTransaction();

    // Insert order record
    $insertOrderQuery = $conn->prepare("INSERT INTO orders (orderDate, requiredDate, status, comments, customerNumber)
                                       VALUES (:orderDate, :requiredDate, :status, :comments, :customerNumber)");
    $insertOrderQuery->bindParam(":orderDate", $orderDate);
    $insertOrderQuery->bindParam(":requiredDate", $requiredDate);
    $insertOrderQuery->bindParam(":status", $status);
    $insertOrderQuery->bindParam(":comments", $comments);
    $insertOrderQuery->bindParam(":customerNumber", $customerNumber);
    $insertOrderQuery->execute();

    $orderNumber = $conn->lastInsertId();

    // Insert order details
    foreach ($cartItems as $item) {
        $insertOrderDetailsQuery = $conn->prepare("INSERT INTO orderdetails (orderNumber, productCode, quantityOrdered, priceEach, orderLineNumber)
                                                  VALUES (:orderNumber, :productCode, :quantityOrdered, :priceEach, :orderLineNumber)");
        $insertOrderDetailsQuery->bindParam(":orderNumber", $orderNumber);
        $insertOrderDetailsQuery->bindParam(":productCode", $item->productCode);
        $insertOrderDetailsQuery->bindParam(":quantityOrdered", $item->quantity);
        $insertOrderDetailsQuery->bindParam(":priceEach", $item->buyPrice);
        $insertOrderDetailsQuery->bindParam(":orderLineNumber", $item->cartID); // Assuming cartID can be used as the order line number
        $insertOrderDetailsQuery->execute();
    }

    // Insert payment record
    $checkNumber = uniqid('CHECK'); // You may generate a unique check number
    $paymentDate = date('Y-m-d');
    $insertPaymentQuery = $conn->prepare("INSERT INTO payments (customerNumber, checkNumber, paymentDate, amount)
                                          VALUES (:customerNumber, :checkNumber, :paymentDate, :amount)");
    $insertPaymentQuery->bindParam(":customerNumber", $customerNumber);
    $insertPaymentQuery->bindParam(":checkNumber", $checkNumber);
    $insertPaymentQuery->bindParam(":paymentDate", $paymentDate);
    $insertPaymentQuery->bindParam(":amount", $totalAmount);
    $insertPaymentQuery->execute();

    // Clear the shopping cart for the customer
    $clearCartQuery = $conn->prepare("DELETE FROM shopping_cart WHERE customerNumber = :customerNumber");
    $clearCartQuery->bindParam(":customerNumber", $customerNumber);
    $clearCartQuery->execute();

    $conn->commit();

    echo '<script>alert("Order placed successfully. Thank you for your purchase!"); window.location.href = "../index.php";</script>';
} catch (Exception $e) {
    $conn->rollBack();
    echo '<script>alert("Error placing order: ' . $e->getMessage() . '"); window.location.href = "view_cart.php";</script>';
}

require "../includes/footer.php";
?>
