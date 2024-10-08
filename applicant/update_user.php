<?php

session_start();
include 'db_connect.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_SESSION['email']; // Assuming the email is stored in the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $dob = $_POST['dob'];
    $contact = $_POST['contact'];
    $sex = $_POST['sex'];
    $program_graduated = $_POST['program_graduated'];
    $id_number = $_POST['id_number'];
    $year_graduated = $_POST['year_graduated'];
    $admission = $_POST['admission'];
    $picture = $_FILES['picture']['name'];

    if (!empty($picture)) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["picture"]["name"]);
        move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file);
    }

    $stmt = $conn->prepare("UPDATE applicant SET fullname=?, dob=?, contact=?, sex=?, program_graduated=?, id_number=?, year_graduated=?, admission=?, picture=? WHERE email=?");
    $stmt->bind_param("ssssssssss", $fullname, $dob, $contact, $sex, $program_graduated, $id_number, $year_graduated, $admission, $picture, $email);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['fullname'] = $fullname; // Update session
        echo json_encode(['success' => true, 'message' => 'Details updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update details.']);
    }

    $stmt->close();
    $conn->close();
}
