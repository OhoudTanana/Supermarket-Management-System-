<?php 
require "../layouts/header.php";
require "../../config/config.php";

// Retrieve orderNumber from URL
if(isset($_GET['orderNumber'])) {
    $orderNumber = $_GET['orderNumber'];

    // Fetch order details from the database based on orderNumber
    $orderDetails = $conn->prepare("SELECT * FROM orderdetails WHERE orderNumber = :orderNumber");
    $orderDetails->bindParam(':orderNumber', $orderNumber);
    $orderDetails->execute();
    $orderDetailsData = $orderDetails->fetchAll(PDO::FETCH_OBJ);
} else {
    // Handle cases where orderNumber is not provided in the URL
    echo "Order details not found.";
}
?>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4 d-inline">Order Details for Order Number: <?php echo $orderNumber; ?></h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Product Code</th>
                            <th scope="col">Quantity Ordered</th>
                            <th scope="col">Price Each</th>
                            <th scope="col">Order Line Number</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($orderDetailsData as $detail) : ?>
                            <tr>
                                <td><?php echo $detail->productCode; ?></td>
                                <td><?php echo $detail->quantityOrdered; ?></td>
                                <td><?php echo $detail->priceEach; ?></td>
                                <td><?php echo $detail->orderLineNumber; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require "../layouts/footer.php"; ?>
