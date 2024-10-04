<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_number = $_POST['id_number'];
    $password = $_POST['password'];

    // Database connection
    include 'db_connect.php';
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if id_number exists and retrieve the hashed password
    $stmt = $conn->prepare("SELECT fullname, email, password FROM applicant WHERE id_number = ? AND is_verified = 1");
    $stmt->bind_param("s", $id_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch user data
        $user = $result->fetch_assoc();
        $stored_hash = $user['password'];

        // Verify the provided password against the stored hash
        if (password_verify($password, $stored_hash)) {
            // Successful login
            $_SESSION['id_number'] = $id_number;
            $_SESSION['email'] = $user['email'];
            $_SESSION['fullname'] = $user['fullname'];

            // Regenerate session ID to prevent session fixation
            session_regenerate_id(true);

            // Debugging
            error_log("Login successful for id_number: $id_number");

            // Display SweetAlert and redirect
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
            // Debugging
            error_log("Password verification failed for id_number: $id_number");

            // Display SweetAlert for invalid login
            echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            title: "Error!",
                            text: "Invalid alumni ID or password.",
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                    });
                  </script>';
        }
    } else {
        // Debugging
        error_log("No user found for id_number: $id_number");

        // Display SweetAlert for invalid login
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "Error!",
                        text: "Invalid alumni ID or password.",
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
        .responsive-img {
            width: 70%;
            height: 70%;
        }
    </style>
</head>
<body>

<div class="container">
    <center> <img src="assets/img/mcc1.png" alt="MCC Logo" class="responsive-img" style="margin-bottom: 20px;"></center>
    <h1>Request Document</h1>
    <header>Login</header>
    <form action="login.php" method="POST">
        <div class="form">
            <div class="details">
                <div class="input-field">
                    <label>Alumni ID</label>
                    <input type="text" name="id_number" placeholder="Enter your alumni ID" required>
                </div>
                <div class="input-field">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter your password" required>
                </div>
                <div class="buttons">
                    <button type="submit" class="submit">
                        <span class="btnText">Login</span>
                    </button>
                    <a href="login_transfer.php" class="signup-link" hidden>For Transfer Students Only!!!</a>
                </div>
            </div>
        </div>
    </form>
</div>

</body>
</html>