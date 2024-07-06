<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "fms_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_SESSION['email']; // Assuming the email is stored in session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve submitted form data
    $fullname = $_POST['fullname'];
    $dob = $_POST['dob'];
    $contact = $_POST['contact'];
    $sex = $_POST['sex'];
    $occupation = $_POST['occupation'];
    $id_number = $_POST['id_number'];
    $year_graduated = $_POST['year_graduated'];
    $school_graduated = $_POST['school_graduated'];
    $address = $_POST['address'];
    $nationality = $_POST['nationality'];
    $postal = $_POST['postal'];

    // Update user details in the database
    $stmt = $conn->prepare("UPDATE applicant SET fullname=?, dob=?, contact=?, sex=?, occupation=?, id_number=?, year_graduated=?, school_graduated=?, address=?, nationality=?, postal=? WHERE email=?");
    $stmt->bind_param("ssssssssssss", $fullname, $dob, $contact, $sex, $occupation, $id_number, $year_graduated, $school_graduated, $address, $nationality, $postal, $email);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['fullname'] = $fullname; // Update session variable with new fullname if needed
        // Optionally, redirect to a success page or refresh the page
        // header("Location: index.php"); // Uncomment this line if you want to redirect after update
        // exit();
        echo "<p>Details updated successfully.</p>";
    } else {
        echo "<p>No changes made.</p>";
    }

    $stmt->close();
}

// Retrieve user details
$stmt = $conn->prepare("SELECT fullname, dob, email, contact, sex, occupation, id_number, year_graduated, school_graduated, address, nationality, postal FROM applicant WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($fullname, $dob, $email, $contact, $sex, $occupation, $id_number, $year_graduated, $school_graduated, $address, $nationality, $postal);
$stmt->fetch();
$stmt->close();
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <style>
        .container {
            background-color: #fff;
            padding: 2em;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }
        h1 {
            color: #333;
        }
        .form-group {
            margin-bottom: 1em;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 0.5em;
        }
        .form-group input {
            width: 100%;
            padding: 0.5em;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group button {
            padding: 0.75em 1.5em;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>User Details</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="form-group">
                <label for="fullname">Full Name:</label>
                <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($fullname); ?>" required>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($dob); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="contact">Mobile Number:</label>
                <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($contact); ?>" required>
            </div>
            <div class="form-group">
                <label for="sex">Gender:</label>
                <input type="text" id="sex" name="sex" value="<?php echo htmlspecialchars($sex); ?>" required>
            </div>
            <div class="form-group">
                <label for="occupation">Occupation:</label>
                <input type="text" id="occupation" name="occupation" value="<?php echo htmlspecialchars($occupation); ?>" required>
            </div>
            <div class="form-group">
                <label for="id_number">ID Number:</label>
                <input type="text" id="id_number" name="id_number" value="<?php echo htmlspecialchars($id_number); ?>" required>
            </div>
            <div class="form-group">
                <label for="year_graduated">Year Graduated:</label>
                <input type="text" id="year_graduated" name="year_graduated" value="<?php echo htmlspecialchars($year_graduated); ?>" required>
            </div>
            <div class="form-group">
                <label for="school_graduated">School Graduated:</label>
                <input type="text" id="school_graduated" name="school_graduated" value="<?php echo htmlspecialchars($school_graduated); ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>" required>
            </div>
            <div class="form-group">
                <label for="nationality">Nationality:</label>
                <input type="text" id="nationality" name="nationality" value="<?php echo htmlspecialchars($nationality); ?>" required>
            </div>
            <div class="form-group">
                <label for="postal">Postal Code:</label>
                <input type="text" id="postal" name="postal" value="<?php echo htmlspecialchars($postal); ?>" required>
            </div>

            <div class="form-group">
                <button type="submit">Update Details</button>
            </div>
        </form>
    </div>
</body>
</html>
