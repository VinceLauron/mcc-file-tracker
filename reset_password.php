<?php
require 'phpmailer/vendor/autoload.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code = $_POST['code'];
    $password = md5($_POST['password']); // Hash the new password

    // Database connection
    include 'db_connect.php';

    // Validate the token
    $stmt = $conn->prepare("SELECT id FROM users WHERE code = ?");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("s", $code);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Update the password and reset the token
        $update_stmt = $conn->prepare("UPDATE users SET password = ?, code = NULL WHERE code = ?");
        if ($update_stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }

        $update_stmt->bind_param("ss", $password, $code);
        if ($update_stmt->execute()) {
            echo "Password has been reset successfully.";
        } else {
            echo "Failed to reset password: " . htmlspecialchars($update_stmt->error);
        }

        $update_stmt->close();
    } else {
        echo "Invalid reset token.";
    }

    $stmt->close();
    $conn->close();
}
?>

<div class="container-fluid">
    <form action="reset_password.php" method="POST">
        <?php
        // Retrieve reset_token from the URL
        $code = isset($_GET['code']) ? htmlspecialchars($_GET['code']) : '';
        ?>
        <input type="hidden" name="code" value="<?php echo $code; ?>">
        <div class="form-group">
            <label for="password">New Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Reset Password</button>
    </form>
</div>
