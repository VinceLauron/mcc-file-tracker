<?php
// Check if session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['email'])) {
    // If the user is not logged in, return an error response
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

// Database connection
include 'db_connect.php';

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// Check if `id` is provided
if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'Request ID is required']);
    exit();
}

$id = $_GET['id'];

// Prepare the SQL query to fetch the request details based on the provided ID
$stmt = $conn->prepare("SELECT id_number, fullname, contact, course, docu_type, purpose, status, note FROM request WHERE id = ?");
$stmt->bind_param("i", $id);

// Execute the query
$stmt->execute();
$stmt->bind_result($id_number, $fullname, $contact, $course, $docu_type, $purpose, $status, $note);

// Fetch the result
if ($stmt->fetch()) {
    // Return the data as a JSON object
    echo json_encode([
        'id_number' => $id_number,
        'fullname' => $fullname,
        'contact' => $contact,
        'course' => $course,
        'docu_type' => $docu_type,
        'purpose' => $purpose,
        'status' => $status,
        'note' => $note
    ]);
} else {
    // If no data is found, return an error
    echo json_encode(['error' => 'Request not found']);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
