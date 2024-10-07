<?php
require 'phpmailer/vendor/autoload.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reset_token = $_POST['reset_token'];
    $password = md5($_POST['password']); // Hash the new password

    // Database connection
    include 'db_connect.php';

    // Validate the token
    $stmt = $conn->prepare("SELECT id FROM users WHERE reset_token = ?");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("s", $reset_token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Update the password and reset the token
        $update_stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL WHERE reset_token = ?");
        if ($update_stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }

        $update_stmt->bind_param("ss", $password, $reset_token);
        if ($update_stmt->execute()) {
            $message = "Password has been reset successfully.";
            $redirect = "login.php"; // Redirect to login page
            $status = "success";
        } else {
            $message = "Failed to reset password: " . htmlspecialchars($update_stmt->error);
            $redirect = "reset_password.php?reset_token=" . urlencode($reset_token);
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
    <style>
        body{
            background-color: lightcyan;
        }
        .container-fluid {
            text-align: center;
            margin-top: 50px;
            background-color: lavender;
        }

        img {
            width: 250px; /* Adjust image size */
            border-radius: 15px; /* Add border radius */
            display: block;
            margin: 0 auto 20px; /* Center image and add bottom margin */
        }

        p {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            width: 300px;
            margin: 0 auto;
            text-align: center; /* Center the placeholder text */
            padding: 10px;
            font-size: 16px;
            border-radius: 10px; /* Add border-radius for the input field */
        }

        .btn {
            border-radius: 10px;
            padding: 10px 10px;
            font-size: 16px;
            width: 65%;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <img src="img/password-protected-email.gif" alt="Password Protection">
        <p>Enter New Password</p>
        <form id="resetPasswordForm" action="reset_password.php" method="POST">
            <?php
            // Retrieve reset_token from the URL
            $reset_token = isset($_GET['reset_token']) ? htmlspecialchars($_GET['reset_token']) : '';
            ?>
            <input type="hidden" name="reset_token" value="<?php echo $reset_token; ?>">
            <div class="form-group">
                <input type="password" name="password" id="password" placeholder="Enter New Password" class="form-control" required>
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
