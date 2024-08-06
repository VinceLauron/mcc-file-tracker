<?php
session_start();
$response = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_code = $_POST['verification_code'];
    $email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

    if (empty($email)) {
        $response = "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Session Error',
                            text: 'Session email not set. Please go back and register again.'
                        });
                     </script>";
    } else {
        // Database connection
include 'db_connect.php';
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check the verification code
        $stmt = $conn->prepare("SELECT verification_code FROM applicant WHERE email = ? AND is_verified = 0");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($verification_code);
        $stmt->fetch();
        $stmt->close();

        if ($entered_code == $verification_code) {
            // Update user to set is_verified to true
            $stmt = $conn->prepare("UPDATE applicant SET is_verified = 1 WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->close();

            $response = "<script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Verification Successful',
                                text: 'You can now log in using the verification code as your password.'
                            }).then(() => {
                                window.location.href = 'login.php';
                            });
                         </script>";
        } else {
            $response = "<script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Invalid Code',
                                text: 'Invalid verification code.'
                            });
                         </script>";
        }

        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/mcc1.png" type="image/x-icon" />
    <link rel="stylesheet" href="styles.css"> <!-- Link to external CSS file -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Link to SweetAlert -->
    <title>Verify Email</title>
    <script>
        function showLoadingAlert(event) {
            event.preventDefault(); // Prevent the default form submission

            Swal.fire({
                title: 'Verifying...',
                text: 'Please wait while we verify your code.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Submit the form after a short delay to show the alert
            setTimeout(() => {
                event.target.submit();
            }, 1000); // Adjust delay as needed
        }
    </script>
    <style>
        body {
            background-image: url('../radiance/images/back.png'); /* Ensure the correct path to your image */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: #6EACDA;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            height: 50%;
        }

        header {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        .form .title {
            font-size: 18px;
            margin-bottom: 10px;
            text-align: center;
            
        }

        .input-field {
            margin-bottom: 15px;
            text-align: center
            
        }

        .input-field label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            font-size: 24px;
        }

        .input-field input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .buttons {
            text-align: center;
        }

        .buttons .submit,
        .buttons .primary {
            background-color: #007bff;
            border: none;
            padding: 10px 20px;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }

        .buttons .submit:hover,
        .buttons .primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="verify.php" method="POST" onsubmit="showLoadingAlert(event)">
            <header>Email Verification</header>
            <div class="form">
                <div class="details verification">
                    <div class="fields">
                        <div class="input-field">
                            <label> Enter Verification Code</label>
                            <input type="text" name="verification_code" placeholder="Enter the code sent to your email" required>
                        </div>
                    </div>
                    <div class="buttons">
                        <button type="submit" class="submit">
                            <span class="btnText">Verify</span>
                            <i class="uil uil-navigator"></i>
                        </button>
                        <a href="login.php">
                            <button type="button" class="primary">Login Applicant</button>
                        </a>
                    </div> 
                </div>
            </div>
        </form>
    </div>
    <?= $response ?>
</body>
</html>
