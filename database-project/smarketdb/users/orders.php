<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php

//grabbing the data

if(isset($_SESSION['id'])){
  $id = $_SESSION['id'];

  if($_SESSION['id'] != $id ){

		echo "<script> window.location.href='".APPURL."' </script> ";
	} 

    // Fetch orders, details, and payments for the logged-in user
$combinedQuery = $conn->prepare("SELECT 
o.orderNumber,
o.orderDate,
o.status,
od.productCode,
od.quantityOrdered,
od.priceEach,
p.checkNumber,
p.paymentDate,
p.amount
FROM 
orders o
JOIN 
orderdetails od ON o.orderNumber = od.orderNumber
LEFT JOIN 
payments p ON o.customerNumber = p.customerNumber
WHERE 
o.customerNumber = :customerId");
$combinedQuery->bindParam(":customerId", $id);
$combinedQuery->execute();

$allData = $combinedQuery->fetchAll(PDO::FETCH_OBJ);

} else {
    echo "<script> window.location.href='".APPURL."/404.php' </script> ";
}

?>

<div class="container">

<?php if(count($allData) > 0) : ?>
    <table class="table mt-5">
        <thead>
            <tr>
                <th scope="col">Order Number</th>
                <th scope="col">Order Date</th>
                <th scope="col">Order Status</th>
                <th scope="col">Product Code</th>
                <th scope="col">Quantity Ordered</th>
                <th scope="col">Price Each</th>
                <th scope="col">Check Number</th>
                <th scope="col">Payment Date</th>
                <th scope="col">Amount</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($allData as $data) : ?>
                <tr>
                    <th scope="row"><?php echo $data->orderNumber ?></th>
                    <td><?php echo $data->orderDate ?></td>
                    <td><?php echo $data->status ?></td>
                    <td><?php echo $data->productCode ?></td>
                    <td><?php echo $data->quantityOrdered ?></td>
                    <td><?php echo $data->priceEach ?></td>
                    <td><?php echo $data->checkNumber ?></td>
                    <td><?php echo $data->paymentDate ?></td>
                    <td><?php echo $data->amount ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
<?php else : ?>
    <div class="alert alert-primary" role="alert">
        You have not made any orders yet.
    </div>
<?php endif; ?>

<?php require "../includes/footer.php"; ?>