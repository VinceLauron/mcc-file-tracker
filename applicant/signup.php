<?php
// Check if the query parameters for School ID and Full Name are set
$id_number = isset($_GET['id_number']) ? $_GET['id_number'] : '';
$fullname = isset($_GET['fullname']) ? $_GET['fullname'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/mcc1.png" type="image/x-icon" />

    <!-- CSS -->
    <link rel="stylesheet" href="assets/style2.css">
    
    <!-- Iconscout CSS -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <title>MCC DOCUMENT TRACKER</title>
    <style>
    body {
        background-image: url('../radiance/images/back.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    .container {
        width: 90%;
        max-width: 800px;
        margin: 0 auto;
        background: rgba(255, 255, 255, 0.9);
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    header {
        text-align: center;
        font-size: 24px;
        margin-bottom: 20px;
    }

    .logo {
        width: 150px;
        height: auto;
        margin-bottom: 10px;
    }

    h1 {
        font-size: 20px;
        margin-bottom: 20px;
    }

    form {
        display: flex;
        flex-direction: column;
    }

    .form {
        display: flex;
        flex-direction: column;
    }

    .details {
        margin-bottom: 20px;
    }

    .input-field {
        margin-bottom: 15px;
    }

    .input-field label {
        display: block;
        margin-bottom: 5px;
    }

    .input-field input,
    .input-field select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .buttons {
        display: flex;
        justify-content: center; /* Center-align buttons */
        gap: 10px; /* Adds spacing between buttons */
        margin-top: 20px; /* Optional: Adds margin above buttons */
    }

    .buttons button {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        color: white;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }

    .backBtn {
        background-color: #6c757d;
    }

    .submit {
        background-color: #28a745;
    }

    .buttons button:hover {
        opacity: 0.9;
    }

    @media (max-width: 768px) {
        .container {
            width: 95%;
            padding: 15px;
        }

        .logo {
            width: 120px;
        }

        h1 {
            font-size: 18px;
        }

        .buttons {
            flex-direction: column;
            gap: 10px; /* Adjust spacing between buttons */
        }

        .buttons button {
            width: 100%;
            padding: 8px 16px;
        }
    }

    @media (max-width: 480px) {
        .logo {
            width: 100px;
        }

        h1 {
            font-size: 16px;
        }

        .buttons button {
            padding: 8px 10px;
        }
    }
</style>

</head>
<body>
    <div class="container">
        <header>Registration</header>
        <center><img src="assets/img/mcc1.png" alt="Logo" class="logo"></center>
        <center><h1>Create New Account</h1></center>

        <form action="register.php" method="POST" id="registration-form">
            <div class="form first">
                <div class="details personal">
                    <span class="title">Personal Details</span>

                    <div class="fields">
                    <div class="input-field">
                            <label>School ID Number</label>
                            <!-- Auto-fill the School ID Number, and make it read-only -->
                            <input type="text" name="id_number" placeholder="Enter School ID number" value="<?php echo htmlspecialchars($id_number); ?>" readonly>
                        </div>
                        <div class="input-field">
                            <label>Full Name</label>
                            <!-- Auto-fill the Full Name, and make it read-only -->
                            <input type="text" name="fullname" placeholder="Enter your name" value="<?php echo htmlspecialchars($fullname); ?>" readonly>
                        </div>

                        <div class="input-field">
                            <label>Date of Birth</label>
                            <input type="date" name="dob" placeholder="Enter birth date" required>
                        </div>

                        <div class="input-field">
                            <label>Gender</label>
                            <select name="sex" required>
                                <option disabled selected>Select gender</option>
                                <option>Male</option>
                                <option>Female</option>
                                <option>Others</option>
                            </select>
                        </div>

                        <div class="input-field">
                            <label>Email</label>
                            <input type="email" name="email" placeholder="Enter your email" required>
                        </div>

                        <div class="input-field">
                            <label>Mobile Number</label>
                            <input type="text" name="contact" placeholder="Enter mobile number" required>
                        </div>
                    </div>
                </div>

                <div class="details ID">
                    <div class="fields">
                        <div class="input-field">
                            <label>Program Graduated</label>
                            <select id="program_graduated" name="program_graduated" required>
                                <option value="" disabled selected>Select Course Here</option>
                                <option value="BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY">BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY</option>
                                <option value="BACHELOR OF SCIENCE IN BUSINESS ADMINISTRATION MAJOR IN FINANCIAL MANAGEMENT">BACHELOR OF SCIENCE IN BUSINESS ADMINISTRATION MAJOR IN FINANCIAL MANAGEMENT</option>
                                <option value="BACHELOR OF SCIENCE IN HOSPITALITY MANAGEMENT">BACHELOR OF SCIENCE IN HOSPITALITY MANAGEMENT</option>
                                <option value="BACHELOR OF SCIENCE IN SECONDARY EDUCATION MAJOR IN FILIPINO">BACHELOR OF SCIENCE IN SECONDARY EDUCATION MAJOR IN FILIPINO</option>
                                <option value="BACHELOR OF SCIENCE IN ELEMENTARY EDUCATION">BACHELOR OF SCIENCE IN ELEMENTARY EDUCATION</option>
                            </select>
                        </div>

                        <div class="input-field">
                            <label>Year Of Admission</label>
                            <input type="text" name="admission" placeholder="Enter Year Admission" required>
                        </div>

                        <div class="input-field">
                            <label>Year Graduated</label>
                            <input type="text" name="year_graduated" placeholder="Enter Year Graduated" required>
                        </div>
                    </div>

                    <div class="buttons">
                        <button type="button" class="backBtn" onclick="window.location.href='login_transfer.php'">
                            <i class="uil uil-navigator"></i>
                            <span class="btnText">Back</span>
                        </button>
                        
                        <button type="submit" class="submit">
                            <span class="btnText">Submit</span>
                            <i class="uil uil-navigator"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
