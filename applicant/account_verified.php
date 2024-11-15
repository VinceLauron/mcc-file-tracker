<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the submitted School ID and Full Name
    $id_number = $_POST['id_number'];
    $fullname = $_POST['fullname'];

    // Here you can perform validation to check if the ID and Full Name are valid
    // For example, you might query the database to ensure these details exist.

    // If valid, redirect to the signup page with the ID and Full Name in the URL
    header("Location: signup.php?id_number=" . urlencode($id_number) . "&fullname=" . urlencode($fullname));
    exit();
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
            position: relative;
        }

        .message-box {
            position: absolute;
            top: 60px; /* Adjust this to position below the button */
            right: 0;
            left: 0;
            margin: 0 auto;
            width: 250px;
            padding: 1em;
            background-color: #f9f9f9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            color: #333;
            font-size: 14px;
            display: none; /* Hide by default */
        }

        .toggle-button {
            margin-left: 70%;
            position: relative;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 0.5em 1em;
            cursor: pointer;
            margin-bottom: 10px;
        }

        .toggle-button:hover {
            background-color: #0056b3;
        }

        header {
            font-size: 24px;
            margin-bottom: 1em;
            color: #333;
        }

        .form {
            width: 100%;
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

        .responsive-img {
            width: 70%;
            height: 70%;
        }
    </style>
</head>
<body>

<div class="container">
    <button class="toggle-button" onclick="toggleMessageBox()">Instructions</button>
    
    <!-- Message Box positioned below the button -->
    <div class="message-box" id="messageBox">
        <strong>Instructions:</strong>
        <p>Please make sure to enter your School ID in the correct format (YYYY-YYYY) and verify your full name as it appears in our records.</p>
        <p>Try to get in touch with the BSIT Department or ask Mr. Dino Illustrismo for permission if you can't remember your school ID number.</p>
    </div>

    <center> <img src="assets/img/mcc1.png" alt="MCC Logo" class="responsive-img" style="margin-bottom: 20px;"></center>
    <h1>Verify Credentials First To Proceed</h1>
    <form id="verifyForm" action="" method="POST">
        <div class="form">
            <div class="input-field">
                <label>School ID Number</label>
                <input type="text" name="id_number" placeholder="Enter your School Number" required pattern="^\d{4}-\d{4}$" title="Format: YYYY-YYYY (8 digits total)">
            </div>

            <div class="input-field">
                <label>Fullname</label>
                <input type="text" name="fullname" placeholder="Enter your Fullname" required>
            </div>
            <div class="buttons">
                <button type="button" class="submit" onclick="confirmSubmission()">
                    <span class="btnText">Submit</span>
                </button>
            </div>
        </div>
    </form>
</div>

<script>
function toggleMessageBox() {
    const messageBox = document.getElementById('messageBox');
    if (messageBox.style.display === 'none' || messageBox.style.display === '') {
        messageBox.style.display = 'block';
    } else {
        messageBox.style.display = 'none';
    }
}

function confirmSubmission() {
    const idInput = document.querySelector('input[name="id_number"]');
    const idPattern = /^\d{4}-\d{4}$/;

    if (!idPattern.test(idInput.value)) {
        Swal.fire({
            title: 'Invalid Format!',
            text: "School ID Number must be in the format YYYY-YYYY.",
            icon: 'error'
        });
        return;
    }

    Swal.fire({
        title: 'Are you sure?',
        text: "Make sure the details are correct!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, submit it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('verifyForm').submit();
        }
    });
}
</script>

</body>
</html>
