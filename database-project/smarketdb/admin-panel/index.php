<?php require "layouts/header.php"; ?>
<?php require "../config/config.php"; ?>
<?php 

if(!isset($_SESSION['adminname'])){
  echo "<script> window.location.href='".ADMINURL."/admins/login-admins.php' </script> "; //is user not set we go back to the hotel page
  
 }

//hotel count

$products = $conn->query("SELECT COUNT(*) AS count_products FROM products");
$products->execute();

$allproducts = $products->fetch(PDO::FETCH_OBJ);

//admin count

$admins = $conn->query("SELECT COUNT(*) AS count_admins FROM admins");
$admins->execute();

$allAdmins = $admins->fetch(PDO::FETCH_OBJ);

//room count

$employees = $conn->query("SELECT COUNT(*) AS count_employees FROM employees");
$employees->execute();

$allemployees = $employees->fetch(PDO::FETCH_OBJ);

//booking count

$orders = $conn->query("SELECT COUNT(*) AS count_orders FROM orders");
$orders->execute();

$allorders = $orders->fetch(PDO::FETCH_OBJ);

?>
      <div class="row">
        <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">products</h5>
              <!-- <h6 class="card-subtitle mb-2 text-muted">Bootstrap 4.0.0 Snippet by pradeep330</h6> -->
              <p class="card-text">number of products: <?php echo $allproducts->count_products; ?></p>
             
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">employees</h5>
              
              <p class="card-text">number of employees: <?php echo $allemployees->count_employees; ?></p>
              
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Admins</h5>
              
              <p class="card-text">number of admins: <?php echo $allAdmins->count_admins; ?></p>
              
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">orders</h5>
              
              <p class="card-text">number of orders: <?php echo $allorders->count_orders; ?></p>
              
            </div>
          </div>
        </div>
      </div>

      <?php require "layouts/footer.php"; ?>