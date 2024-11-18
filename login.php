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
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MYCAFÉ - Staff Dashboard</title>
  <link rel="stylesheet" href="stylee.css">
  <style>
    body {
      background-image: url('https://img.freepik.com/premium-photo/night-scene-empty-table-with-restaurant-background-ads_31965-623916.jpg');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      background-attachment: fixed;
      height: 100vh;
      margin: 0;
      padding: 0;
      color: white; 
      font-family: cursive;
    }

    nav ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
    }
    nav ul li {
      margin: 0 15px;
    }
    nav ul li a {
      color: white;
      text-decoration: none;
      font-size: 20px;
    }

    .dashboard-container {
      width: 90%;
      margin: 50px auto;
      padding: 20px;
      border-radius: 8px;
      border: 2px solid white;
      backdrop-filter: blur(10px);
      color: white;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      color: white; 
    }

    table, th, td {
      border: 1px solid #ddd;
    }

    th, td {
      padding: 12px;
      text-align: left;
    }

    th {
      background-color: rgb(86, 46, 23);
      color: white;
    }

    td {
      background-color: rgba(255, 255, 255, 0.1);
    }

    .delete-button {
      padding: 5px 10px;
      background-color: rgb(86, 46, 23);
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .delete-button:hover {
      background-color: #b66540;
    }

    footer {
      text-align: center;
      margin: 20px 0;
      color: black;
      font-size: 18px;
      font-weight: bold;
    }

    footer a {
      color: black;
      text-decoration: none;
      font-size: 18px;
      font-weight: bold;
    }

    footer a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <header>
    <h1>Staff Dashboard - MYCAFÉ</h1>
    <nav aria-label="Main Navigation">
      <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="menu.html">Menu</a></li>
        <li><a href="reservation.html">Table Reservation</a></li>
        <li><a href="prebooking.html">Pre-book Food</a></li>
        <li><a href="contact.html">Location & Contact</a></li>
      </ul>
    </nav>
  </header>

  <main>
  <div class="dashboard-container">
    <h2>Pre-booking Orders</h2>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Dish Name</th>
                <th>Quantity</th>
                <th>Ready Time</th>
                <th>Dish Cost (Rs)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Query to retrieve pre-booking orders from the database
            $sql_prebookings = "SELECT id, customer_name, order_items, ready_time, total_cost FROM prebookings";
            $result_prebookings = $conn->query($sql_prebookings);

            if (!$result_prebookings) {
                die("SQL Error: " . $conn->error);
            }

            if ($result_prebookings->num_rows > 0) {
                while ($row = $result_prebookings->fetch_assoc()) {
                    $orderId = htmlspecialchars($row['id']);
                    $customerName = htmlspecialchars($row['customer_name']);
                    $readyTime = htmlspecialchars($row['ready_time']);
                    $totalCost = htmlspecialchars($row['total_cost']);
                    $orderItems = json_decode($row['order_items'], true);

                    // Flag to ensure orderId and customerName are displayed once
                    $firstRow = true;

                    foreach ($orderItems as $item) {
                        echo "<tr>";

                        if ($firstRow) {
                            echo "<td>{$orderId}</td>
                                  <td>{$customerName}</td>";
                            $firstRow = false; // Only display once
                        } else {
                            echo "<td></td><td></td>"; // Empty cells for additional items
                        }

                        echo "<td>" . htmlspecialchars($item['name']) . "</td>
                              <td>" . htmlspecialchars($item['quantity']) . "</td>
                              <td>{$readyTime}</td>
                              <td>" . htmlspecialchars($item['total_cost']) . "</td>
                              </tr>";
                    }

                    // Display the total cost and delete button after the items
                    echo "<tr>
                            <td colspan='5' style='text-align:right;'><strong>Total Amount (Rs):</strong></td>
                            <td><strong>{$totalCost}</strong></td>
                          </tr>";
                    echo "<tr>
                            <td colspan='6'>
                              <div style='text-align: center;'>
                                <form action='delete_prebooking.php' method='post' style='display:inline;'>
                                  <input type='hidden' name='id' value='{$orderId}'>
                                  <input type='hidden' name='type' value='prebooking'>
                                  <button type='submit' class='delete-button'>Delete</button>
                                </form>
                              </div>
                            </td>
                          </tr>";
                }
            } else {
                // If no pre-booking orders found
                echo "<tr><td colspan='6' style='text-align:center;'>No pre-booking orders found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>


    <div class="dashboard-container">
      <h2>Table Reservations</h2>
      <table>
        <thead>
          <tr>
            <th>Reservation ID</th>
            <th>Customer Name</th>
            <th>Table Number</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Query to retrieve table reservations from the database
          $sql_reservations = "SELECT id, name, table_id, start_time, end_time FROM reservations";
          $result_reservations = $conn->query($sql_reservations);

          if (!$result_reservations) {
              die("SQL Error: " . $conn->error);
          }

          if ($result_reservations->num_rows > 0) {
              while ($row = $result_reservations->fetch_assoc()) {
                  $reservationId = htmlspecialchars($row['id']);
                  $customerName = htmlspecialchars($row['name']);
                  $tableId = htmlspecialchars($row['table_id']);
                  $startTime = htmlspecialchars($row['start_time']);
                  $endTime = htmlspecialchars($row['end_time']);
                  
                  echo "<tr>
                          <td>{$reservationId}</td>
                          <td>{$customerName}</td>
                          <td>{$tableId}</td>
                          <td>{$startTime}</td>
                          <td>{$endTime}</td>
                          <td>
                            <form action='delete_prebooking.php' method='post' style='display:inline;'>
                              <input type='hidden' name='id' value='{$reservationId}'>
                              <input type='hidden' name='type' value='reservation'>
                              <button type='submit' class='delete-button'>Delete</button>
                            </form>
                          </td>
                        </tr>";
              }
          } else {
              echo "<tr><td colspan='6'style='text-align:center;'>No table reservations found</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </main>

  <footer>
    <p>Follow us on Instagram: <a href="https://www.instagram.com/mycafe" target="_blank">@MYCAFÉ</a></p>
    <p>© 2024 MYCAFÉ. All rights reserved.</p>
  </footer>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
