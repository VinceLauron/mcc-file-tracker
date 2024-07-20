<?php
// Check if session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

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

// Fetch requests from database
$sql = "SELECT * FROM request WHERE status = 'pending' OR status = 'onprocess'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Requests - MCC Document Tracker</title>
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
        }
        .btn-approve {
            background-color: #28a745;
        }
        .btn-release {
            background-color: #007bff;
        }
        .btn-reject {
            background-color: #dc3545;
        }
        .btn:hover {
            opacity: 0.9;
        }
        .note-input {
            width: 100%;
            padding: 8px;
            margin-top: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Pending Requests</h1>
        <table>
            <tr>
                <th>ID Number</th>
                <th>Full Name</th>
                <th>Contact</th>
                <th>Course/Program</th>
                <th>Document Type</th>
                <th>Purpose</th>
                <th>Actions</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id_number']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['fullname']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['contact']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['course']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['docu_type']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['purpose']) . "</td>";
                    echo "<td>
                            <form action='update_request_status.php' method='POST' style='display:inline;'>
                                <input type='hidden' name='request_id' value='" . htmlspecialchars($row['id']) . "'>
                                <textarea name='note' class='note-input' placeholder='Enter note here...'></textarea>";
                                
                                if ($row['status'] == 'onprocess') {
                                    echo "<button type='submit' name='action' value='release' class='btn btn-release'>Release</button>";
                                } else if ($row['status'] == 'released') {
                                    echo "<button type='submit' name='action' value='released' class='btn btn-approve' disabled>Released</button>";
                                } else {
                                    echo "<button type='submit' name='action' value='onprocess' class='btn btn-approve'>Accepted/On Process</button>";
                                }

                                echo "<button type='submit' name='action' value='reject' class='btn btn-reject'>Reject</button>
                            </form>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No pending requests</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
