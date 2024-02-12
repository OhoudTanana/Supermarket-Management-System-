<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php
if (!isset($_SESSION['adminname'])) {
    echo "<script> window.location.href='" . ADMINURL . "/admins/login-admins.php' </script> ";
}

// Call the stored procedure to get the count of orders
$countQuery = $conn->query("CALL CountOrders()");
$countResult = $countQuery->fetch(PDO::FETCH_OBJ);
$totalOrders = $countResult->totalOrders;

// Close the cursor for the previous statement
$countQuery->closeCursor();

$orders = $conn->query("SELECT * FROM orders");
$orders->execute();
$allorders = $orders->fetchAll(PDO::FETCH_OBJ);

?>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4 d-inline">orders</h5>
                <p>Total Orders: <?php echo $totalOrders; ?></p>

                <table class="table">
                    <thead>
                        <tr>

                            <th scope="col">order Number</th>
                            <th scope="col">order Date</th>
                            <th scope="col">required Date</th>
                            <th scope="col">customerNumber</th>
                            <th scope="col">Order Details</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($allorders as $order) : ?>
                            <tr>
                                <td><?php echo $order->orderNumber; ?></td>
                                <td><?php echo $order->orderDate; ?></td>
                                <td><?php echo $order->requiredDate; ?></td>
                                <td><?php echo $order->customerNumber; ?></td>
                                <td><a href="order-details.php?orderNumber=<?php echo $order->orderNumber; ?>">Order details</a></td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require "../layouts/footer.php"; ?>
