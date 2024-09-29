<?php
// Check if session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
include 'db_connect.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch requests from database, ordered by created_at or id in descending order
$sql = "SELECT * FROM request WHERE status = 'pending' OR status = 'onprocess' ORDER BY date_created DESC"; // or ORDER BY id DESC
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Requests - MCC Document Tracker</title>
    <!-- Include SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        .container {
    width: 100%; /* Adjust the width to be more flexible */
    margin: 0 auto;
    padding: 20px;
    background: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
    max-width: 1200px; /* Maximum width to avoid it becoming too large */
    overflow-x: auto; /* Allow horizontal scroll if table overflows */
    word-wrap: break-word; /* Ensure long text breaks */
}

h1 {
    text-align: center;
    color: #333;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 12px;
    text-align: left;
    vertical-align: top; /* Ensures proper alignment of long text */
}

th {
    background-color: #f2f2f2;
    color: black;
}

td {
    word-wrap: break-word; /* Break long text in table cells */
    white-space: normal; /* Prevent text from overflowing */
}

.btn {
    padding: 8px 16px;
    border: none;
    cursor: pointer;
    border-radius: 4px;
    color: #fff;
    margin-top: 10px;
}

.btn-approve {
    background-color: #28a745;
}

.btn-release {
    background-color: #007bff;
}

.btn-reject {
    background-color: #dc3545;
}

.btn:hover {
    opacity: 0.9;
}

.note-input {
    width: 100%;
    padding: 8px;
    margin-top: 10px;
    border-radius: 4px;
    border: 1px solid #ddd;
}

/* Optional: Ensure modal overflow handling */
.modal-body {
    max-height: 70vh;
    overflow-y: auto;
    word-wrap: break-word;
}

    </style>
</head>
<body>
    <div class="container">
        <h1>Pending Requests</h1>
        <table id="requestsTable">
            <thead>
                <tr>
                    <th>ID Number</th>
                    <th>Full Name</th>
                    <th>Contact</th>
                    <th>Course/Program</th>
                    <th>Document Type</th>
                    <th>Purpose</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id_number']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['fullname']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['contact']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['course']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['docu_type']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['purpose']) . "</td>";
                    echo "<td>
                            <form action='update_request_status.php' method='POST' class='request-form' style='display:inline;'>
                                <input type='hidden' name='request_id' value='" . htmlspecialchars($row['id']) . "'>
                                <textarea name='note' class='note-input' placeholder='Enter note here...'></textarea>";
                                
                                if ($row['status'] == 'onprocess') {
                                    echo "<button type='button' name='action' value='release' class='btn btn-release' onclick='confirmAction(this, \"Release\")'>Release</button>";
                                } else if ($row['status'] == 'released') {
                                    echo "<button type='button' name='action' value='released' class='btn btn-approve' disabled>Released</button>";
                                } else {
                                    echo "<button type='button' name='action' value='onprocess' class='btn btn-approve' onclick='confirmAction(this, \"Accept/On Process\")'>Accepted/On Process</button>";
                                }

                                echo "<button type='button' name='action' value='reject' class='btn btn-reject' onclick='confirmAction(this, \"Reject\")'>Reject</button>
                            </form>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No pending requests</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

    <!-- Include SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#requestsTable').DataTable({
                "pageLength": 5
            });
        });

        function confirmAction(button, actionText) {
            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to ${actionText.toLowerCase()} this request.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: `Yes, ${actionText.toLowerCase()} it!`
            }).then((result) => {
                if (result.isConfirmed) {
                    // Get the form and set the action value
                    const form = button.closest('form');
                    const actionInput = document.createElement('input');
                    actionInput.type = 'hidden';
                    actionInput.name = 'action';
                    actionInput.value = button.value;
                    form.appendChild(actionInput);

                    // Submit the form
                    form.submit();
                }
            });
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
