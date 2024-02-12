<?php
require "includes/header.php";
require "config/config.php";

// Check the officeCode 
if (isset($_GET['officeCode'])) {
    $officeCode = $_GET['officeCode'];

    // Fetch employees for the selected office
    $employeesQuery = $conn->prepare("SELECT * FROM employees WHERE officeCode = :officeCode");
    $employeesQuery->bindParam(":officeCode", $officeCode);
    $employeesQuery->execute();

    $allEmployees = $employeesQuery->fetchAll(PDO::FETCH_OBJ);
?>
    <div class="container">
        <h2>Employees for Office Code: <?php echo $officeCode; ?></h2>

        <?php if (count($allEmployees) > 0) : ?>
            <table class="table mt-5">
                <thead>
                    <tr>
                        <th scope="col">Employee Number</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Job Title</th>
                    </tr>
                </thead>

                <tbody>
                    
                    <?php foreach ($allEmployees as $employee) : ?>
                        <tr>
                            <th scope="row"><?php echo $employee->employeeNumber; ?></th>
                            <td><?php echo $employee->lastName; ?></td>
                            <td><?php echo $employee->firstName; ?></td>
                            <td><?php echo $employee->jobTitle; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <div class="alert alert-primary" role="alert">
                No employees found for this office.
            </div>
        <?php endif; ?>
    </div>

<?php
} else {
    // Redirect to an error page if officeCode is found
    echo "<script> window.location.href='" . APPURL . "/404.php' </script>";
}

require "includes/footer.php";
?>
