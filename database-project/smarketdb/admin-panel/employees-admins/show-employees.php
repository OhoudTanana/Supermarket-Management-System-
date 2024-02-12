<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php
// Function to count the number of employees
function countEmployees($conn) {
    $countQuery = $conn->query("SELECT COUNT(*) as total FROM employees");
    $countQuery->execute();
    $countResult = $countQuery->fetch(PDO::FETCH_OBJ);
    return $countResult->total;
}

if (!isset($_SESSION['adminname'])) {
    echo "<script> window.location.href='" . ADMINURL . "/admins/login-admins.php' </script> ";
}

$employees = $conn->query("SELECT * FROM employees");
$employees->execute();
$allemployees = $employees->fetchAll(PDO::FETCH_OBJ);
if (isset($_GET['id'])) {
    $employeeNumber = $_GET['id'];
    $delete = $conn->query("DELETE FROM employees WHERE employeeNumber ='$employeeNumber'");
    $delete->execute();
    header("location: show-employees.php");
}

?>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4 d-inline">employees</h5>
                <p>Total Employees: <?php echo countEmployees($conn); ?></p>
                <a href="<?php echo ADMINURL; ?>/employees-admins/add-employees.php"
                    class="btn btn-primary mb-4 text-center float-right">Add employees</a>

                <table class="table">
                    <thead>
                        <tr>

                            <th scope="col">employeeNumber</th>
                            <th scope="col">lastName</th>
                            <th scope="col">firstName</th>
                            <th scope="col">extension</th>
                            <th scope="col">email</th>
                            <th scope="col">office Code</th>
                            <th scope="col">reports To</th>
                            <th scope="col">job Title</th>

                            <th scope="col">delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($allemployees as $employee) : ?>
                        <tr>
                            <th scope="row"><?php echo $employee->employeeNumber; ?></th>
                            <td><?php echo $employee->lastName; ?></td>
                            <td><?php echo $employee->firstName; ?></td>
                            <td><?php echo $employee->extension; ?></td>
                            <td><?php echo $employee->email; ?>m2</td>
                            <td><?php echo $employee->officeCode; ?></td>
                            <td><?php echo $employee->reportsTo; ?></td>
                            <td><?php echo $employee->jobTitle; ?></td>
                            <td>
                                <a href="<?php echo ADMINURL; ?>/employees-admins/show-employees.php?id=<?php echo $employee->employeeNumber; ?>"
                                    class="btn btn-danger text-center">Delete</a> </td>
                        </tr>

                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require "../layouts/footer.php"; ?>
