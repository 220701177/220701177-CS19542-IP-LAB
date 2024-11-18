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

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Fetch all reservations (no date involved)
    $sql = "SELECT table_id, start_time, end_time FROM reservations";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        die("Error in SQL query preparation: " . $conn->error);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();

    $reservations = [];
    while ($row = $result->fetch_assoc()) {
        $reservations[] = $row;
    }

    // Return the reservations as JSON
    echo json_encode($reservations);

    $stmt->close();
} else {
    echo json_encode(["error" => "Invalid request method"]);
}

$conn->close();
