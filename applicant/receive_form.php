<?php
// Check if session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['email'])) {
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

$email = $_SESSION['email'];

// Fetch user's requests from the database
$stmt = $conn->prepare("SELECT id, id_number, fullname, contact, course, docu_type, purpose, status, note FROM request WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($id, $id_number, $fullname, $contact, $course, $docu_type, $purpose, $status, $note);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Requests - MCC Document Tracker</title>
    <style>
        .container {
            width: 100%;
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
        .btn {
            padding: 8px 16px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            color: #fff;
            margin-top: 10px;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        .btn-view {
            background-color: #007bff;
        }
        .btn-delete {
            background-color: #dc3545;
        }
        .btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Requests</h1>
        <table>
            <tr>
                <th>ID Number</th>
                <th>Full Name</th>
                <th>Contact</th>
                <th>Course/Program</th>
                <th>Document Type</th>
                <th>Purpose</th>
                <th>Status</th>
                <th>Note</th>
                <th>Actions</th>
            </tr>
            <?php
            while ($stmt->fetch()) {
                $status_class = '';
                if ($status == 'pending') {
                    $status_class = 'status-pending';
                } elseif ($status == 'onprocess') {
                    $status_class = 'status-onprocess';
                } elseif ($status == 'rejected') {
                    $status_class = 'status-rejected';
                }
                elseif ($status == 'released') {
                    $status_class = 'status-released';
                }
                echo "<tr>";
                echo "<td>" . htmlspecialchars($id_number) . "</td>";
                echo "<td>" . htmlspecialchars($fullname) . "</td>";
                echo "<td>" . htmlspecialchars($contact) . "</td>";
                echo "<td>" . htmlspecialchars($course) . "</td>";
                echo "<td>" . htmlspecialchars($docu_type) . "</td>";
                echo "<td>" . htmlspecialchars($purpose) . "</td>";
                echo "<td class='$status_class'>" . htmlspecialchars($status) . "</td>";
                echo "<td>" . htmlspecialchars($note) . "</td>";
                echo "<td>
                        <a href='view_request.php?id=" . htmlspecialchars($id) . "' class='btn btn-view'>View</a>
                        <a href='delete_request.php?id=" . htmlspecialchars($id) . "' class='btn btn-delete' onclick='return confirm(\"Are you sure you want to delete this request?\")'>Delete</a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>

<?php
$stmt->close(); 
$conn->close();
?>

