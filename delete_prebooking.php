<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = ""; // Your MySQL database password here
$dbname = "mycafe";

// Create connection to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if 'id' and 'type' are set in the POST request
if (isset($_POST['id']) && isset($_POST['type'])) {
    $id = $_POST['id'];
    $type = $_POST['type'];

    // Input validation: ID should be numeric and type should be either 'prebooking' or 'reservation'
    if (!empty($id) && is_numeric($id) && in_array($type, ['prebooking', 'reservation'])) {
        
        // Determine the correct table to delete from based on the 'type'
        $table = ($type === 'prebooking') ? 'prebookings' : 'reservations';
        
        // Prepare the delete statement securely
        $stmt = $conn->prepare("DELETE FROM $table WHERE id = ?");
        
        if ($stmt) {
            $stmt->bind_param("i", $id);

            // Execute the deletion
            if ($stmt->execute()) {
                // Successful deletion, show a success message and redirect back to the staff dashboard
                echo "<script>
                        alert('{$type} entry deleted successfully.');
                        window.location.href = 'login.php'; // Redirect to the staff dashboard
                    </script>";
            } else {
                // Error during execution
                echo "<script>
                        alert('Error executing the deletion. Please try again.');
                        window.location.href = 'login.php'; // Redirect to the staff dashboard
                    </script>";
                error_log("Error executing deletion: " . $stmt->error); // Log the error for debugging
            }

            $stmt->close();
        } else {
            // Error preparing the SQL statement
            echo "<script>
                    alert('Error preparing the deletion statement. Please try again.');
                    window.location.href = 'login.php'; // Redirect to the staff dashboard
                </script>";
            error_log("Error preparing statement: " . $conn->error); // Log the error for debugging
        }

    } else {
        // Invalid ID or type
        echo "<script>
                alert('Invalid order ID or type provided. Please try again.');
                window.location.href = 'login.php'; // Redirect to the staff dashboard
            </script>";
    }

} else {
    // ID or type not provided in POST request
    echo "<script>
            alert('No order ID or type provided.');
            window.location.href = 'login.php'; // Redirect to the staff dashboard
        </script>";
}

// Close the database connection
$conn->close();
?>
