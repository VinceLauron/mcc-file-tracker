<?php
// Start the session and check if the user is logged in as admin
session_start();
if (!isset($_SESSION['login_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize inputs
    $request_id = htmlspecialchars($_POST['request_id']);
    $action = htmlspecialchars($_POST['action']);

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

    // Update request status
    $status = ($action == 'approve') ? 'approved' : 'rejected';
    $sql = "UPDATE request SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $request_id);

    if ($stmt->execute()) {
        // Redirect back to the admin page
        header("Location: indexs.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
}
?>
