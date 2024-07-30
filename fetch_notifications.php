<?php
session_start();
include 'db_connect.php';

$email = $_SESSION['email']; // Or use 'login_id' based on your session variable

$sql = "SELECT message, date_created FROM notifications WHERE user_email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

$notifications = [];
while ($row = $result->fetch_assoc()) {
    $notifications[] = $row;
}

echo json_encode($notifications);

$stmt->close();
$conn->close();
?>
