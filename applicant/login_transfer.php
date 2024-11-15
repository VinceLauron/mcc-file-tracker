<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password']; // In this case, the password is the verification code
 // Database connection
    include 'db_connect.php';
    // Check if email and verification code match
    $stmt = $conn->prepare("SELECT fullname FROM applicant WHERE email = ? AND verification_code = ? AND is_verified = 1");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Successful login
        $user = $result->fetch_assoc();
        $_SESSION['email'] = $email;
        $_SESSION['fullname'] = $user['fullname'];

        // Display SweetAlert
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "Success!",
                        text: "Login successful!",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(function() {
                        window.location.href = "index.php"; // Redirect to dashboard or another page
                    });
                });
              </script>';
    } else {
        // Display SweetAlert for invalid login
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "Error!",
                        text: "Invalid email or verification code.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                });
              </script>';
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/mcc1.png" type="image/x-icon" />
    <title>Login</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('../radiance/images/back.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 2em;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        header {
            font-size: 24px;
            margin-bottom: 1em;
            color: #333;
        }
        .form {
            width: 100%;
        }
        .details {
            margin-bottom: 1em;
        }
        .title {
            font-size: 18px;
            margin-bottom: 0.5em;
            color: #555;
        }
        .fields {
            margin-bottom: 1em;
        }
        .input-field {
            margin-bottom: 1em;
        }
        .input-field label {
            display: block;
            margin-bottom: 0.5em;
            color: #555;
        }
        .input-field input {
            width: 100%;
            padding: 0.5em;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .buttons {
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
        }
        .submit {
            background-color: #007BFF;
            color: #fff;
            padding: 0.75em 1.5em;
            border: none;
            border-radius: 15px;
            cursor: pointer;
            margin-bottom: 1em;
            width: 100%;
        }
        .submit:hover {
            background-color: #0056b3;
        }
        .signup-link {
            color: #007BFF;
            text-decoration: none;
        }
        .signup-link:hover {
            text-decoration: underline;
        }
        .responsive-img{
            width: 70%;
            height: 70%;
        }
        .checkbox-container {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-top: 10px;
        }
        .styled-checkbox {
            width: 18px;
            height: 18px;
            cursor: pointer;
            margin-right: 8px;
        }
    </style>
</head>
<body>

<div class="container">
    <center> <img src="assets/img/mcc1.png" alt="MCC Logo" class="responsive-img" style="margin-bottom: 20px;"></center>
    <h1>Login Students</h1>
    <form action="login_transfer.php" method="POST">
        <div class="form">
            <div class="details">
                <div class="input-field">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="input-field">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter your password" required>
                </div>
                <!-- Terms and Conditions Checkbox -->
        <div class="checkbox-container">
            <input type="checkbox" name="terms" id="terms" class="styled-checkbox" required>
            <label for="terms">
                I agree to the <a href="#" onclick="showTerms()">Terms and Conditions</a>
            </label>
        </div>
                <div class="buttons">
                    <button type="submit" class="submit">
                        <span class="btnText">Login</span>
                    </button>
                    <a href="account_verified.php" class="signup-link">Create New Account for Transfer and Non-graduates Students</a>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    function showTerms() {
        Swal.fire({
            title: 'Terms and Conditions',
            html: `
                <p>By using the Madridejos Community College (MCC) Document Tracker System, you agree to the following terms:</p>
                <ul style="text-align:left;">
                    <li><strong>Accuracy of Information:</strong> You confirm that all information provided during the request process is accurate and truthful. Providing false information may lead to disciplinary action.</li>
                    <li><strong>Authorized Use:</strong> This system is intended for the use of MCC students, alumni, and staff only. Unauthorized access or use is strictly prohibited and may result in legal action.</li>
                    <li><strong>Privacy and Confidentiality:</strong> Your personal information is collected solely for processing your document requests. MCC is committed to protecting your privacy and will not share your information without consent, unless required by law.</li>
                    <li><strong>Request Processing Time:</strong> Document requests are processed in the order they are received. Processing times may vary depending on the document type and peak request periods.</li>
                    <li><strong>Fees and Payments:</strong> Certain documents may require processing fees. These fees are non-refundable once the request is submitted.</li>
                    <li><strong>Notification of Document Status:</strong> You will receive updates regarding the status of your document request through the notification system. It is your responsibility to regularly check for updates.</li>
                    <li><strong>Prohibited Activities:</strong> Any misuse of this system, including attempting to access others' documents or bypass system security, will result in immediate suspension of access and possible disciplinary action.</li>
                    <li><strong>Changes to Terms:</strong> MCC reserves the right to modify these terms and conditions at any time. It is your responsibility to review the terms periodically for any changes.</li>
                </ul>
                <p>By proceeding with your document request, you acknowledge that you have read, understood, and agree to these terms and conditions. Please contact the MCC administration for any questions.</p>
            `,
            icon: 'info',
            confirmButtonText: 'I Agree',
            confirmButtonColor: '#007BFF'
        });
    }
</script>
</body>
</html>
