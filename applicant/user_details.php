<?php

// Check if session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// Database connection
include 'db_connect.php';
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_SESSION['email']; // Assuming the email is stored in session

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve submitted form data
    $fullname = $_POST['fullname'];
    $dob = $_POST['dob'];
    $contact = $_POST['contact'];
    $sex = $_POST['sex'];
    $program_graduated = $_POST['program_graduated'];
    $id_number = $_POST['id_number'];
    $year_graduated = $_POST['year_graduated'];
    $admission = $_POST['admission'];
    $picture = $_FILES['picture']['name'];

    // Handle image upload
    if (!empty($_FILES['picture']['name'])) {
        $target_dir = "uploads/"; // Create this directory to store uploaded files
        $target_file = $target_dir . basename($_FILES["picture"]["name"]);
        move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file);
    }

    // Update user details in the database
    $stmt = $conn->prepare("UPDATE applicant SET fullname=?, dob=?, contact=?, sex=?, program_graduated=?, id_number=?, year_graduated=?, admission=?, picture=? WHERE email=?");
    $stmt->bind_param("ssssssssss", $fullname, $dob, $contact, $sex, $program_graduated, $id_number, $year_graduated, $admission, $picture, $email);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['fullname'] = $fullname; // Update session variable with new fullname if needed
        // Success message using SweetAlert
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "Success!",
                        text: "Details updated successfully",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(function() {
                        window.location.href = "index.php"; // Redirect to dashboard or another page
                    });
                });
              </script>';
    } else {
        // Error message using SweetAlert
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "Error!",
                        text: "Failed to update details",
                        icon: "error",
                        confirmButtonText: "OK"
                    }).then(function() {
                        window.location.href = "index.php"; // Redirect to dashboard or another page
                    });
                });
              </script>';
    }

    $stmt->close();
}

// Retrieve user details
$stmt = $conn->prepare("SELECT fullname, dob, email, contact, sex, program_graduated, id_number, year_graduated, admission, picture FROM applicant WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($fullname, $dob, $email, $contact, $sex, $program_graduated, $id_number, $year_graduated, $admission, $picture);
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
            display: flex;
            flex-direction: column;
        }
        .form-group label {
            font-weight: bold;
            margin-bottom: 0.5em;
        }
        .form-group input, .form-group button {
            padding: 0.5em;
            border: 1px solid #ccc;
            border-radius: 4px;

            width: 100%;
            box-sizing: border-box;
        }
        .form-group-inline {
            display: flex;
            justify-content: space-between;
            gap: 1em;
        }
        .form-group-inline .form-group {
            flex: 1;
        }
         .form-group img {
        max-width: 200px; /* Increased maximum width */
        height: auto; /* Maintain aspect ratio */
        border-radius: 10px; /* Optional: Add rounded corners for aesthetics */
    }
    .button-primary {
        background-color: #007bff; /* Bootstrap primary color */
        color: white; /* Text color */
        border: none; /* Remove border */
        border-radius: 4px; /* Rounded corners */
        padding: 0.5em; /* Padding */
        cursor: pointer; /* Pointer cursor on hover */
        transition: background-color 0.3s; /* Smooth background color transition */
    }

    .button-primary:hover {
        background-color: #0056b3; /* Darker shade on hover */
    }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('preview');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>User Details</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
                  <center> <label for="picture">Profile Picture:</label></center>
                   <center><img id="preview" src="uploads/<?php echo htmlspecialchars($picture); ?>" alt="Profile Picture"></center>
                    <input type="file" id="picture" name="picture" accept="image/*" onchange="previewImage(event)">
                </div>
            <div class="form-group-inline">
                <div class="form-group">
                    <label for="id_number">ID Number:</label>
                    <input type="text" id="id_number" name="id_number" value="<?php echo htmlspecialchars($id_number); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="fullname">Full Name:</label>
                    <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($fullname); ?>" readonly>
                </div>
            </div>
            <div class="form-group-inline">
                <div class="form-group">
                    <label for="dob">Date of Birth:</label>
                    <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($dob); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="contact">Mobile Number:</label>
                    <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($contact); ?>" required maxlength="11" oninput="validateMobileNumber(this)">
                </div>
            </div>
            <div class="form-group-inline">
                <div class="form-group">
                    <label for="sex">Gender:</label>
                    <input type="text" id="sex" name="sex" value="<?php echo htmlspecialchars($sex); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="program_graduated">Program Graduated:</label>
                    <input type="text" id="program_graduated" name="program_graduated" value="<?php echo htmlspecialchars($program_graduated); ?>" readonly>
                </div>
            </div>
            <div class="form-group-inline">
                <div class="form-group">
                    <label for="year_graduated">Year Graduated:</label>
                    <input type="text" id="year_graduated" name="year_graduated" value="<?php echo htmlspecialchars($year_graduated); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="admission">Year Of Admission:</label>
                    <input type="text" id="admission" name="admission" value="<?php echo htmlspecialchars($admission); ?>" readonly>
                </div>
            </div>
            <div class="form-group">
            <button type="submit" class="button-primary">Update Details</button>
            </div>
        </form>
    </div>
</body>
</html>
<script>
    function validateMobileNumber(input) {
        input.value = input.value.replace(/[^0-9]/g, ''); // Allow only digits
    }
</script>