<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php
//catch the id that we sent
if(isset($_GET['id'])){

  $productCode = $_GET['id'];

  $product = $conn->query("SELECT * FROM products WHERE productCode='$productCode'");
  $product->execute();
  $productSingle = $product->fetch(PDO::FETCH_OBJ);

if(isset($_POST['submit']))
{
  if(empty($_POST['productName'] OR $_POST['productDescription'] OR $_POST['productVendor'])){
    echo"<script>alert('one or more input are empty')</script>";
  }
  else{

    $productName = $_POST['productName'];
$productDescription = $_POST['description']; // Corrected field name
$productVendor = $_POST['productvendor']; // Corrected field name

//we use prepare because we are going to use a handler
$update = $conn->prepare("UPDATE products SET productName = :productName , productDescription = :productDescription, productVendor = :productVendor  WHERE productCode=:productCode");

$update->execute([
 ":productName" => $productName,
 ":productDescription" => $productDescription,
 ":productVendor" => $productVendor,
 ":productCode" => $productCode
]);

 
   header("location: show-products.php");

  }

}
}

?>
       <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-5 d-inline">Update Product</h5>
          <form method="POST" action="update-products.php?id=<?php echo $productCode; ?>" enctype="multipart/form-data">
                <!-- Email input -->
                <div class="form-outline mb-4 mt-4">
                  <input type="text" value="<?php echo $productSingle->productName; ?>" name="productName" id="form2Example1" class="form-control" placeholder="productName" />
                 
                </div>
                <div class="form-group">
                  <label for="exampleFormControlTextarea1">Product Description</label>
                  <textarea class="form-control"  name="description" id="exampleFormControlTextarea1" rows="3"><?php echo $productSingle->productDescription; ?></textarea>
                </div>

                <div class="form-outline mb-4 mt-4">
                  <label for="exampleFormControlTextarea1">Product Vendor </label>

                  <input type="text" value="<?php echo $productSingle->productVendor; ?>" name="productvendor" id="form2Example1" class="form-control"/>
                 
                </div>

      
                <!-- Submit button -->
                <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">update</button>

          
              </form>

            </div>
          </div>
        </div>
      </div>
      <?php require "../layouts/footer.php"; ?>