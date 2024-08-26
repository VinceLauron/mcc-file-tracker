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
            $message = "Password has been reset successfully.";
            $redirect = "login.php"; // Redirect to login page
            $status = "success";
        } else {
            $message = "Failed to reset password: " . htmlspecialchars($update_stmt->error);
            $redirect = "reset_password.php?code=" . urlencode($code);
            $status = "error";
        }

        $update_stmt->close();
    } else {
        $message = "Invalid reset token.";
        $redirect = "reset_password.php";
        $status = "error";
    }

    $stmt->close();
    $conn->close();

    // Return JSON response for SweetAlert to process
    echo json_encode(['message' => $message, 'redirect' => $redirect, 'status' => $status]);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="assets/css/reset_password.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="applicant/assets/img/mcc1.png" type="image/x-icon" />
</head>
<body>
    <div class="container-fluid">
        <form id="resetPasswordForm" action="reset_password.php" method="POST">
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

    <script>
        document.getElementById('resetPasswordForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the form from submitting the traditional way

            var formData = new FormData(this);

            fetch('reset_password.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    icon: data.status,
                    title: data.message,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    if (data.status === 'success') {
                        window.location.href = data.redirect;
                    }
                });
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'An error occurred',
                    text: 'Please try again later.',
                    showConfirmButton: true
                });
            });
        });
    </script>
</body>
</html>
