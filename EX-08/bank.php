<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banking Application</title>
</head>
<body>
    <h2>Banking Application</h2>

    <?php
    $conn = new mysqli('localhost', 'root', '', 'bank_db');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["display_customer"])) {
        $cid = $_POST["cid"];
        $sql = "SELECT * FROM CUSTOMER WHERE CID = '$cid'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "Customer ID: " . $row["CID"] . " - Name: " . $row["CNAME"] . "<br>";
            }
        } else {
            echo "No customer found with ID: " . $cid;
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["display_account"])) {
        $ano = $_POST["ano"];
        $sql = "SELECT * FROM ACCOUNT WHERE ANO = '$ano'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "Account Number: " . $row["ANO"] . " - Type: " . $row["ATYPE"] . " - Balance: " . $row["BALANCE"] . " - Customer ID: " . $row["CID"] . "<br>";
            }
        } else {
            echo "No account found with number: " . $ano;
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["insert_customer"])) {
        $cid = $_POST["cid"];
        $cname = $_POST["cname"];
        $sql = "INSERT INTO CUSTOMER (CID, CNAME) VALUES ('$cid', '$cname')";

        if ($conn->query($sql) === TRUE) {
            echo "New customer inserted successfully<br>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["insert_account"])) {
        $ano = $_POST["ano"];
        $atype = $_POST["atype"];
        $balance = $_POST["balance"];
        $cid = $_POST["cid"];

        if ($atype != 'S' && $atype != 'C') {
            die("Account type must be 'S' for Savings or 'C' for Current<br>");
        }

        $customer_check = "SELECT * FROM CUSTOMER WHERE CID = '$cid'";
        $result = $conn->query($customer_check);

        if ($result->num_rows == 0) {
            die("No customer found with ID: " . $cid . "<br>");
        }

        $sql = "INSERT INTO ACCOUNT (ANO, ATYPE, BALANCE, CID) VALUES ('$ano', '$atype', '$balance', '$cid')";

        if ($conn->query($sql) === TRUE) {
            echo "New account inserted successfully<br>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    ?>
    <h3>Display Customer Information</h3>
    <form method="post">
        <label for="cid">Customer ID:</label>
        <input type="text" id="cid" name="cid" required>
        <input type="submit" name="display_customer" value="Display Customer">
    </form>

    <h3>Display Account Information</h3>
    <form method="post">
        <label for="ano">Account Number:</label>
        <input type="text" id="ano" name="ano" required>
        <input type="submit" name="display_account" value="Display Account">
    </form>

    <h3>Insert Customer Information</h3>
    <form method="post">
        <label for="cid">Customer ID:</label>
        <input type="text" id="cid" name="cid" required><br>
        <label for="cname">Customer Name:</label>
        <input type="text" id="cname" name="cname" required><br>
        <input type="submit" name="insert_customer" value="Insert Customer">
    </form>

    <h3>Insert Account Information</h3>
    <form method="post">
        <label for="ano">Account Number:</label>
        <input type="text" id="ano" name="ano" required><br>
        <label for="atype">Account Type (S for Savings, C for Current):</label>
        <input type="text" id="atype" name="atype" required pattern="[SC]"><br>
        <label for="balance">Balance:</label>
        <input type="number" id="balance" name="balance" required><br>
        <label for="cid">Customer ID:</label>
        <input type="text" id="cid" name="cid" required><br>
        <input type="submit" name="insert_account" value="Insert Account">
    </form>
    
</body>
</html>

<?php
$conn->close();
?>
