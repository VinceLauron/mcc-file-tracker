<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $fullname = $_POST['fullname'];
    $docu_type = $_POST['docu_type'];
    $course = $_POST['course'];
    $contact = $_POST['contact'];
    $purpose = $_POST['purpose'];
    $status = $_POST['status'];
    $note = $_POST['note'];

    // Check if the request should be resubmitted
    $resubmit = isset($_POST['resubmit']) ? true : false;

    if ($resubmit) {
        // Change the status to "pending" or other status that indicates it's been resubmitted
        $status = 'pending';

        // Notify admin by updating the admin side table or sending an email
        // Optional: Implement admin notification logic here (email, update status, etc.)
    }

    // Update the request in the database
    $stmt = $conn->prepare("UPDATE request SET fullname=?, docu_type=?, course=?, contact=?, purpose=?,
    status=?, note=? WHERE id=?");
    $stmt->bind_param("ssssssii", $fullname, $docu_type, $course, $contact, $purpose, $status, $note, $id);

    if ($stmt->execute()) {
        echo "Request updated successfully.";
    } else {
        echo "Error updating request: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
