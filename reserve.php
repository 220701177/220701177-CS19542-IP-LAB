<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database credentials
$servername = "localhost";
$username = "root";
$password = ""; // Your MySQL password here
$dbname = "mycafe";

// Create connection to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = $_POST['name'];
    $start_time = (int)$_POST['start-time'];
    $end_time = (int)$_POST['end-time'];
    $table_id = $_POST['table_id'];

    // Check for conflicts (no date involved)
    $sql_check = "SELECT * FROM reservations 
                  WHERE table_id = ? 
                  AND ((start_time < ? AND end_time > ?) 
                  OR (start_time < ? AND end_time > ?))";

    $stmt_check = $conn->prepare($sql_check);
    if (!$stmt_check) {
        die("Error preparing query: " . $conn->error);
    }

    // Bind parameters and execute the statement
    $stmt_check->bind_param("siiii", $table_id, $end_time, $start_time, $start_time, $end_time);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    // Check if any conflicting reservations exist
    if ($result_check->num_rows > 0) {
        echo "Table is already reserved for this time slot.";
    } else {
        // Insert new reservation
        $sql_insert = "INSERT INTO reservations (name, start_time, end_time, table_id) 
                       VALUES (?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        if (!$stmt_insert) {
            die("Error preparing insert query: " . $conn->error);
        }

        // Bind parameters and execute the insert
        $stmt_insert->bind_param("siis", $name, $start_time, $end_time, $table_id);

        if ($stmt_insert->execute()) {
            echo "Reservation successful!";
        } else {
            echo "Error: " . $stmt_insert->error;
        }
    }

    // Close statement handles
    $stmt_check->close();
    $stmt_insert->close();
}

// Close database connection
$conn->close();
?>
