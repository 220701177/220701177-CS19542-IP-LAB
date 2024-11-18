<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";  // Update with your MySQL password
$dbname = "mycafe";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch form data
$name = $_POST['name'];
$start_time = (int)$_POST['start-time'];
$end_time = (int)$_POST['end-time'];

// Query to fetch reservations that overlap with the provided start and end time
$sql = "SELECT table_id FROM reservations 
        WHERE (start_time < ? AND end_time > ?) 
        OR (start_time < ? AND end_time > ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiii", $end_time, $start_time, $start_time, $end_time);
$stmt->execute();
$result = $stmt->get_result();

$occupied_tables = [];
while ($row = $result->fetch_assoc()) {
    $occupied_tables[] = $row['table_id'];  // Collect occupied table IDs
}

// Define the tables layout
$all_tables = [
    'T1' => 'Two-Seater',
    'T2' => 'Two-Seater',
    'T3' => 'Two-Seater',
    'T4' => 'Four-Seater',
    'T5' => 'Four-Seater',
    'T6' => 'Four-Seater',
    'T7' => 'Four-Seater',
    'T8' => 'Four-Seater',
    'T9' => 'Four-Seater',
    'T10' => 'Four-Seater',
    'T11' => 'Four-Seater',
    'T12' => 'Four-Seater',
    'T13' => 'Four-Seater',
    'T14' => 'Ten-Seater',
    'T15' => 'Ten-Seater'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Tables</title>
    <link rel="stylesheet" href="stylee.css">
    <style>
        .table { 
            display: inline-block; 
            width: 80px; 
            height: 80px; 
            text-align: center; 
            line-height: 80px; 
            margin: 10px; 
            border: 2px solid white;
            border-radius: 10px;
            color: white;
            cursor: pointer;
        }

        .available {
            background-color: green;
        }

        .occupied {
            background-color: gray;
        }
    </style>
</head>
<body>

<header>
    <h1>Available Tables</h1>
</header>

<main>
    <div class="table-layout">
        <?php
        // Display available and occupied tables
        foreach ($all_tables as $table_id => $table_type) {
            if (in_array($table_id, $occupied_tables)) {
                echo "<div class='table occupied'>{$table_id}</div>";
            } else {
                echo "<div class='table available'>{$table_id}</div>";
            }
        }
        ?>
    </div>
</main>

<footer>
    <p>Powered by MYCAFÉ</p>
</footer>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
