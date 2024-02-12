<?php
// Start the session

// Include header and configuration files
require "../layouts/header.php";
require "../../config/config.php";

// Redirect if not logged in
if (!isset($_SESSION['adminname'])) {
    header("location: " . ADMINURL . "/admins/login-admins.php");
}

// Process form submission
if (isset($_POST['submit'])) {
    // Validate form data
    $requiredFields = ['employeeNumber', 'lastName', 'firstName', 'extension', 'email', 'officeCode', 'reportsTo'];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            echo "<script>alert('One or more inputs are empty');</script>";
            exit(); // Stop execution if any field is empty
        }
    }

    // Sanitize form data
    $employeeNumber = $_POST['employeeNumber'];
    $lastName = $_POST['lastName'];
    $firstName = $_POST['firstName'];
    $extension = $_POST['extension'];
    $email = $_POST['email'];
    $officeCode = $_POST['officeCode'];
    $reportsTo = $_POST['reportsTo'];
    $jobTitle = $_POST['jobTitle'];

    // Validate that the officeCode value exists in the offices table
    $existingOffice = $conn->prepare("SELECT COUNT(*) FROM offices WHERE officeCode = :officeCode");
    $existingOffice->bindParam(':officeCode', $officeCode, PDO::PARAM_STR);
    $existingOffice->execute();
    $countOffice = $existingOffice->fetchColumn();

    // Validate that the reportsTo value exists in the employees table
    $existingEmployees = $conn->prepare("SELECT COUNT(*) FROM employees WHERE employeeNumber = :reportsTo");
    $existingEmployees->bindParam(':reportsTo', $reportsTo, PDO::PARAM_INT);
    $existingEmployees->execute();
    $countReportsTo = $existingEmployees->fetchColumn();

    if ($countOffice > 0 && $countReportsTo > 0) {
        // Insert data into the database using prepared statement
        $insert = $conn->prepare("INSERT INTO employees(employeeNumber, lastName, firstName, extension, email, officeCode, reportsTo, jobTitle)
            VALUES(:employeeNumber, :lastName, :firstName, :extension, :email, :officeCode, :reportsTo, :jobTitle)");

        $insert->bindParam(':employeeNumber', $employeeNumber, PDO::PARAM_INT);
        $insert->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $insert->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $insert->bindParam(':extension', $extension, PDO::PARAM_STR);
        $insert->bindParam(':email', $email, PDO::PARAM_STR);
        $insert->bindParam(':officeCode', $officeCode, PDO::PARAM_STR);
        $insert->bindParam(':reportsTo', $reportsTo, PDO::PARAM_INT);
        $insert->bindParam(':jobTitle', $jobTitle, PDO::PARAM_STR);
 
        $insert->execute();

        // Redirect to the show-employees page
        header("location: show-employees.php");
    } else {
        echo "<script>alert('Invalid Office Code or Reports To value');</script>";
        exit(); // Stop execution if officeCode or reportsTo value is not valid
    }
}
?>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-5 d-inline">Add Employees</h5>
                <form method="POST" action="add-employees.php" enctype="multipart/form-data">
                    <div class="form-outline mb-4 mt-4">
                        <input type="text" name="employeeNumber" id="form2Example1" class="form-control" placeholder="Employee Number" />
                    </div>
                    <div class="form-outline mb-4 mt-4">
                        <input type="text" name="lastName" id="form2Example1" class="form-control" placeholder="Last Name" />
                    </div>
                    <div class="form-outline mb-4 mt-4">
                        <input type="text" name="firstName" id="form2Example1" class="form-control" placeholder="First Name" />
                    </div>
                    <div class="form-outline mb-4 mt-4">
                        <input type="text" name="extension" id="form2Example1" class="form-control" placeholder="Extension" />
                    </div>
                    <div class="form-outline mb-4 mt-4">
                        <input type="text" name="email" id="form2Example1" class="form-control" placeholder="Email" />
                    </div>
                    <div class="form-outline mb-4 mt-4">
                        <input type="text" name="officeCode" id="form2Example1" class="form-control" placeholder="Office Code" />
                    </div>
                    <div class="form-outline mb-4 mt-4">
                        <label for="reportsTo" class="form-label">Reports To</label>
                        <select name="reportsTo" id="reportsTo" class="form-control">
                            <option value="">Select an Employee</option>
                            <?php
                            // Fetch existing employees for the dropdown
                            $existingEmployees = $conn->query("SELECT employeeNumber, CONCAT(firstName, ' ', lastName) AS fullName FROM employees");
                            $existingEmployees->execute();
                            $employeesList = $existingEmployees->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($employeesList as $employee) {
                                echo "<option value=\"{$employee['employeeNumber']}\">{$employee['fullName']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-outline mb-4 mt-4">
                        <input type="text" name="jobTitle" id="form2Example1" class="form-control" placeholder="Job Title" />
                    </div>
                    
                    <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require "../layouts/footer.php"; ?>
