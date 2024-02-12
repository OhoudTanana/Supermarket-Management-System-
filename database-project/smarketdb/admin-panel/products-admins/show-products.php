<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php
if (!isset($_SESSION['adminname'])) {
    echo "<script> window.location.href='" . ADMINURL . "/admins/login-admins.php' </script> ";
}

// Count the number of distinct product types
$productTypesQuery = $conn->query("SELECT COUNT(DISTINCT productCode) AS numProductTypes FROM products");
$productTypesResult = $productTypesQuery->fetch(PDO::FETCH_OBJ);
$numProductTypes = $productTypesResult->numProductTypes;

$products = $conn->query("SELECT * FROM products");
$products->execute();

$allProducts = $products->fetchAll(PDO::FETCH_OBJ);

if (isset($_GET['id'])) {
    $productCode = $_GET['id'];
    $delete = $conn->query("DELETE FROM products WHERE productCode ='$productCode'");
    $delete->execute();
    header("location: show-products.php");
}
?>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4 d-inline">Products</h5>
                <p>Number of Product Types: <?php echo $numProductTypes; ?></p>
                <a href="add-products.php" class="btn btn-primary mb-4 text-center float-right">Create Products</a>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">product code</th>
                            <th scope="col">product name</th>
                            <th scope="col">product vendor</th>
                            <th scope="col">product description</th> <!-- New column -->
                            <th scope="col">update</th>
                            <th scope="col">delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($allProducts as $product) : ?>
                            <tr>
                                <th scope="row">1</th>
                                <td><?php echo $product->productCode; ?></td>
                                <td><?php echo $product->productName; ?></td>
                                <td><?php echo $product->productVendor; ?></td>
                                <td><?php echo $product->productDescription; ?></td> <!-- New column -->
                                <td><a href="update-products.php?id=<?php echo $product->productCode; ?>" class="btn btn-warning text-white text-center ">Update </a></td>
                                <td><a href="show-products.php?id=<?php echo $product->productCode; ?>" class="btn btn-danger  text-center ">Delete </a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require "../layouts/footer.php"; ?>
