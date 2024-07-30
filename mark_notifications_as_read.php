<?php
session_start();
include 'db_connect.php';

$email = $_SESSION['email']; // Or use 'login_id' based on your session variable

$sql = "UPDATE notifications SET read_status = 1 WHERE user_email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();

$stmt->close();
$conn->close();
?>
