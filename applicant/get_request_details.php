<?php
include 'db_connect.php';

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT id, id_number, fullname, contact, course, docu_type, purpose, status, note FROM request WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($id, $id_number, $fullname, $contact, $course, $docu_type, $purpose, $status, $note);
$stmt->fetch();

$response = array(
    'id' => $id,
    'id_number' => $id_number,
    'fullname' => $fullname,
    'contact' => $contact,
    'course' => $course,
    'docu_type' => $docu_type,
    'purpose' => $purpose,
    'status' => $status,
    'note' => $note
);

echo json_encode($response);

$stmt->close();
$conn->close();
?>
