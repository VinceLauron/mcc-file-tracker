<?php
// Start the session and check if the user is logged in
session_start();
if (!isset($_SESSION['login_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fms_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch approved requests from database
$approved_sql = "SELECT * FROM request WHERE status = 'approved'";
$approved_result = $conn->query($approved_sql);

// Fetch pending requests from database
$pending_sql = "SELECT * FROM request WHERE status = 'pending'";
$pending_result = $conn->query($pending_sql);

// Fetch rejected requests from database
$rejected_sql = "SELECT * FROM request WHERE status = 'rejected'";
$rejected_result = $conn->query($rejected_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/mcc1.png" type="image/x-icon" />
    <title>Request Status - MCC Document Tracker</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        h2 {
            color: #333;
            margin-top: 40px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #2a2f5b;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Request Status</h1>
        
        <h2>Approved Requests</h2>
        <table>
            <tr>
                <th>Full Name</th>
                <th>Contact</th>
                <th>ID Number</th>
                <th>Document Type</th>
                <th>Purpose</th>
                <th>Status</th>
            </tr>
            <?php
            if ($approved_result->num_rows > 0) {
                while ($row = $approved_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['fullname']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['contact']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['id_number']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['docu_type']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['purpose']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No approved requests</td></tr>";
            }
            ?>
        </table>
        
        <h2>Pending Requests</h2>
        <table>
            <tr>
                <th>Full Name</th>
                <th>Contact</th>
                <th>ID Number</th>
                <th>Document Type</th>
                <th>Purpose</th>
                <th>Status</th>
            </tr>
            <?php
            if ($pending_result->num_rows > 0) {
                while ($row = $pending_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['fullname']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['contact']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['id_number']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['docu_type']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['purpose']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No pending requests</td></tr>";
            }
            ?>
        </table>
        
        <h2>Rejected Requests</h2>
        <table>
            <tr>
                <th>Full Name</th>
                <th>Contact</th>
                <th>ID Number</th>
                <th>Document Type</th>
                <th>Purpose</th>
                <th>Status</th>
            </tr>
            <?php
            if ($rejected_result->num_rows > 0) {
                while ($row = $rejected_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['fullname']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['contact']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['id_number']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['docu_type']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['purpose']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No rejected requests</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
