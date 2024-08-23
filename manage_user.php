<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'phpmailer/vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    ob_start(); // Start output buffering
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password securely
    $is_verified = 'Verified'; // Automatically set status to Verified

    // Database connection
    include 'db_connect.php';

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO users (name, username, password, is_verified) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $username, $password, $is_verified);

    if ($stmt->execute()) {
        $_SESSION['username'] = $username;
        header("Location: indexs.php?page=users");
        exit();
    } else {
        echo "Failed to store user data.";
    }

    $stmt->close();
    $conn->close();
    ob_end_flush(); // End output buffering and send output
}
?>
<div class="container-fluid">
    <form action="manage_user.php" id="manage-user" method="POST">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="username">Email (Username)</label>
            <input type="email" name="username" id="username" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
            <input type="checkbox" id="showPassword" style="margin-top: 10px;"> Show Password
        </div>
        <div class="form-group">
            <label for="type">User Type</label>
            <select name="type" id="type" class="custom-select">
                <option value="1">Admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script>
document.getElementById('showPassword').addEventListener('change', function() {
    var passwordField = document.getElementById('password');
    if (this.checked) {
        passwordField.type = 'text';
    } else {
        passwordField.type = 'password';
    }
});
</script>
