<?php
// Check if session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Database connection
include 'db_connect.php';

$user_email = $_SESSION['email'];

// Fetch unread notifications
$sql = "SELECT message FROM notifications WHERE user_email = ? AND status = 'unread' ORDER BY date_created DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $user_email);
$stmt->execute();
$result = $stmt->get_result();

$notifications = [];
while ($row = $result->fetch_assoc()) {
    $notifications[] = $row;
}

$stmt->close();
$conn->close();

// Return the notifications and count as JSON
echo json_encode(['notifications' => $notifications, 'count' => count($notifications)]);
?>
