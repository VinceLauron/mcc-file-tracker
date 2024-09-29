<?php
header('Content-Type: application/json');

include 'db_connect.php';
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id_number, fullname, email, contact, dob, sex, program_graduated, year_graduated, admission FROM applicant"; // Adjust table name as needed
$result = $conn->query($sql);

$users = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

$conn->close();

echo json_encode($users);
?>
