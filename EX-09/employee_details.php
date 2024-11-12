<?php
include 'db_connect.php';
function getEmployeeDetails($empId) {
    global $conn;
    $sql = "SELECT * FROM EMPDETAILS WHERE EMPID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $empId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $empId = $_POST["empId"];
    $salary = $_POST["salary"];
    $designation = $_POST["designation"];

    $sql = "UPDATE EMPDETAILS SET SALARY = ?, DESIG = ? WHERE EMPID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("dsi", $salary, $designation, $empId);

    if ($stmt->execute()) {
        echo "<p>Employee details updated successfully!</p>";
    } else {
        echo "<p>Error updating employee details: " . $conn->error . "</p>";
    }
}

$empId = isset($_GET["empId"]) ? $_GET["empId"] : 1;
$employee = getEmployeeDetails($empId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Details</title>
</head>
<body>
    <h2>Employee Details</h2>
    <form method="post" action="employee_details.php">
        <input type="hidden" name="empId" value="<?php echo $employee['EMPID']; ?>">
        
        <p><strong>Employee ID:</strong> <?php echo $employee['EMPID']; ?></p>
        <p><strong>Name:</strong> <?php echo $employee['ENAME']; ?></p>
        <p><strong>Department:</strong> <?php echo $employee['DEPT']; ?></p>
        <p><strong>Date of Joining:</strong> <?php echo $employee['DOJ']; ?></p>

        <label for="designation">Designation:</label>
        <input type="text" name="designation" id="designation" value="<?php echo $employee['DESIG']; ?>"><br>

        <label for="salary">Salary:</label>
        <input type="number" name="salary" id="salary" value="<?php echo $employee['SALARY']; ?>" step="0.01"><br>

        <input type="submit" name="update" value="Update">
    </form>
</body>
</html>
