<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get customer information from POST data
    $customerName = trim($_POST['customer-name']);
    $readyTime = $_POST['ready-time'];
    $totalCost = 0;

    // Prepare an array for storing selected dishes and quantities
    $selectedDishes = [];

    // Define prices for each dish (can be stored in DB for scalability)
    $prices = [
        'garlic-bread' => 250,
        'caesar-salad' => 200,
        'canapes' => 300,
        'bruschetta' => 275,
        'penne-alfredo' => 375,
        'pink-sauce-pasta' => 350,
        'kung-pao' => 390,
        'steak' => 445,
        'cheesecake' => 349,
        'tiramisu' => 275,
        'baklava' => 250,
        'brownie' => 245,
        'cappuccino' => 250,
        'latte' => 265,
        'mocktail' => 345,
        'affogato' => 365
    ];

    // Process each posted item for quantities
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'qty-') !== false && intval($value) > 0) {
            // Extract the dish name from the input field (removing 'qty-')
            $dishName = str_replace('qty-', '', $key);
            $quantity = intval($value);

            // Get the price of the dish from the prices array
            if (array_key_exists($dishName, $prices)) {
                $price = $prices[$dishName];

                // Calculate total cost for this dish
                $totalCost += $price * $quantity;

                // Add the dish and quantity to the selected dishes array
                $selectedDishes[] = [
                    'name' => $dishName,
                    'quantity' => $quantity,
                    'price' => $price,
                    'total_cost' => $price * $quantity
                ];
            }
        }
    }

    if (!empty($selectedDishes)) {
        // Convert selected dishes array to JSON format
        $orderItemsJson = json_encode($selectedDishes);

        // Check if this customer already has an order
        $sql_check = "SELECT id, order_items, total_cost FROM prebookings WHERE customer_name = ?";
        $stmt_check = $conn->prepare($sql_check);

        if (!$stmt_check) {
            die("SQL Error: " . $conn->error);
        }

        $stmt_check->bind_param("s", $customerName);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        
        if ($result_check->num_rows > 0) {
            // Update existing order
            $row = $result_check->fetch_assoc();
            $orderId = $row['id'];
            $existingOrderItems = json_decode($row['order_items'], true);
            $existingTotalCost = $row['total_cost'];

            // Merge new items with existing items
            foreach ($selectedDishes as $newDish) {
                $found = false;
                foreach ($existingOrderItems as &$existingDish) {
                    if ($existingDish['name'] == $newDish['name']) {
                        $existingDish['quantity'] += $newDish['quantity'];
                        $existingDish['total_cost'] += $newDish['total_cost'];
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $existingOrderItems[] = $newDish;
                }
            }

            // Recalculate the total cost
            $existingTotalCost += $totalCost;

            // Convert merged order items back to JSON
            $mergedOrderItemsJson = json_encode($existingOrderItems);

            // Update the order with new order items and total cost
            $sql_update = "UPDATE prebookings SET ready_time=?, order_items=?, total_cost=? WHERE id=?";
            $stmt_update = $conn->prepare($sql_update);

            if (!$stmt_update) {
                die("SQL Error: " . $conn->error);
            }

            $stmt_update->bind_param("ssdi", $readyTime, $mergedOrderItemsJson, $existingTotalCost, $orderId);
            $stmt_update->execute();
        } else {
            // Insert new order
            $sql_insert = "INSERT INTO prebookings (customer_name, ready_time, order_items, total_cost) VALUES (?, ?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);

            if (!$stmt_insert) {
                die("SQL Error: " . $conn->error);
            }

            $stmt_insert->bind_param("sssd", $customerName, $readyTime, $orderItemsJson, $totalCost);
            $stmt_insert->execute();
        }

        echo "<script>alert('Your order has been placed. Total bill: $totalCost Rs.'); window.location.href = 'prebooking.html';</script>";
    } else {
        echo "<script>alert('Please select at least one dish.'); window.location.href = 'prebooking.html';</script>";
    }
}
$conn->close();
?>
