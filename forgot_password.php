<?php
require 'phpmailer/vendor/autoload.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];

    // Database connection
    include 'db_connect.php';

    // Check if the user exists and is verified
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? AND is_verified = 'Verified'");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Generate a unique token
        $reset_token = bin2hex(random_bytes(50));

        // Store the token in the database
        $update_stmt = $conn->prepare("UPDATE users SET reset_token = ? WHERE username = ?");
        if ($update_stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }
        $update_stmt->bind_param("ss", $reset_token, $username);
        $update_stmt->execute();

        // Construct the reset link with the token as a parameter
        $resetLink = "http://mccdocumenttracker.com/reset_password.php?reset_token=" . urlencode($reset_token);

        // Set up PHPMailer and send the email
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Set your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'lauronvince13@gmail.com'; // SMTP username
            $mail->Password = 'vohwbqmjcwqifszs'; // SMTP password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('lauronvince13@gmail.com', 'MCC Document Tracker');
            $mail->addAddress($username);

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body    = "Please click the following link to reset your password: <a href='{$resetLink}'>Reset Password</a>";

            if ($mail->send()) {
                $message = "<div class='alert alert-success'>An email with the password reset link has been sent.</div>";
            } else {
                $message = "<div class='alert alert-danger'>Email could not be sent.</div>";
            }
        } catch (Exception $e) {
            $message = "<div class='alert alert-danger'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</div>";
        }

        $update_stmt->close();
    } else {
        $message = "<div class='alert alert-danger'>User not found or not verified.</div>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="assets/css/forgot_password.css">
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
            margin-bottom: 20px;
        }

        h1 {
            text-align: justify;
            margin-bottom: 15px;
            font-size: 28px;
        }

        p {
            font-size: 16px;
            color: #555;
            margin-bottom: 30px;
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
        }

        .btn {
            padding: 10px 20px;
            font-size: 16px;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <img src="img/password-protection.gif" alt="Password Protection">
    <h1>Please Enter The Email Address</h1>
    <p>We will send you a link to reset your password</p>
    <?php if (isset($message)) echo $message; ?>
    <form action="forgot_password.php" method="POST">
        <div class="form-group">
            <input type="email" name="username" id="username" placeholder="Enter Email Address" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Request Password Reset</button>
    </form>
</div>
</body>
</html>