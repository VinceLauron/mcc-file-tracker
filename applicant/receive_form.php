<?php
// Check if session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Database connection
include 'db_connect.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_SESSION['email'];

// Fetch user's requests from the database
$stmt = $conn->prepare("SELECT id, id_number, fullname, contact, course, docu_type, purpose, status, note FROM request WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($id, $id_number, $fullname, $contact, $course, $docu_type, $purpose, $status, $note);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Requests - MCC Document Tracker</title>
    <style>
        .container {
            width: 90%;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            border-radius: 8px;
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
        }
        th {
            background: silver;
            color: black;
        }
        .btn {
            padding: 8px 16px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            color: #fff;
            margin-top: 10px;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        .btn-view {
            background-color: #007bff;
        }
        .btn-delete {
            background-color: #dc3545;
        }
        .btn:hover {
            opacity: 0.9;
        }
        @media (max-width: 768px) {
            .container {
                width: 100%;
                padding: 10px;
            }
            table, th, td {
                font-size: 14px;
                padding: 8px;
            }
            .btn {
                padding: 6px 12px;
                font-size: 14px;
            }
        }
        @media (max-width: 480px) {
            .container {
                padding: 5px;
            }
            table, th, td {
                font-size: 12px;
                padding: 6px;
            }
            .btn {
                padding: 4px 8px;
                font-size: 12px;
            }
            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
            table thead {
                display: none;
            }
            table tr {
                display: block;
                margin-bottom: 10px;
            }
            table td {
                display: block;
                text-align: right;
                border-bottom: 1px solid #ddd;
                position: relative;
                padding-left: 50%;
            }
            table td::before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                width: calc(50% - 20px);
                padding-right: 10px;
                text-align: left;
                font-weight: bold;
                white-space: nowrap;
            }
        }
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            position: relative;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover, .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
        .modal-table {
            width: 100%;
            border-collapse: collapse;
        }
        .modal-table th, .modal-table td {
            border: none;
            padding: 8px;
            text-align: left;
        }
        .modal-table th {
            width: 30%;
            background: #f5f5f5;
            font-weight: bold;
        }
        .modal-table td {
            width: 70%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Requests</h1>
        <table>
            <thead>
                <tr>
                    <th>ID Number</th>
                    <th>Full Name</th>
                    <th>Contact</th>
                    <th>Course/Program</th>
                    <th>Document Type</th>
                    <th>Purpose</th>
                    <th>Status</th>
                    <th>Note</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($stmt->fetch()) {
                    $status_class = '';
                    if ($status == 'pending') {
                        $status_class = 'status-pending';
                    } elseif ($status == 'onprocess') {
                        $status_class = 'status-onprocess';
                    } elseif ($status == 'rejected') {
                        $status_class = 'status-rejected';
                    } elseif ($status == 'released') {
                        $status_class = 'status-released';
                    }
                    echo "<tr>";
                    echo "<td data-label='ID Number'>" . htmlspecialchars($id_number) . "</td>";
                    echo "<td data-label='Full Name'>" . htmlspecialchars($fullname) . "</td>";
                    echo "<td data-label='Contact'>" . htmlspecialchars($contact) . "</td>";
                    echo "<td data-label='Course/Program'>" . htmlspecialchars($course) . "</td>";
                    echo "<td data-label='Document Type'>" . htmlspecialchars($docu_type) . "</td>";
                    echo "<td data-label='Purpose'>" . htmlspecialchars($purpose) . "</td>";
                    echo "<td data-label='Status' class='$status_class'>" . htmlspecialchars($status) . "</td>";
                    echo "<td data-label='Note'>" . htmlspecialchars($note) . "</td>";
                    echo "<td data-label='Actions'>
                            <button class='btn btn-view' data-id='" . htmlspecialchars($id) . "' data-id-number='" . htmlspecialchars($id_number) . "' data-fullname='" . htmlspecialchars($fullname) . "' data-contact='" . htmlspecialchars($contact) . "' data-course='" . htmlspecialchars($course) . "' data-docu-type='" . htmlspecialchars($docu_type) . "' data-purpose='" . htmlspecialchars($purpose) . "' data-status='" . htmlspecialchars($status) . "' data-note='" . htmlspecialchars($note) . "'>View</button>
                            <a href='delete_request.php?id=" . htmlspecialchars($id) . "' class='btn btn-delete' onclick='return confirm(\"Are you sure you want to delete this request?\")'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- The Modal -->
    <div id="viewModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Request Details</h2>
            <table class="modal-table">
                <tr>
                    <th>ID Number</th>
                    <td id="modal-id-number"></td>
                </tr>
                <tr>
                    <th>Full Name</th>
                    <td id="modal-fullname"></td>
                </tr>
                <tr>
                    <th>Contact</th>
                    <td id="modal-contact"></td>
                </tr>
                <tr>
                    <th>Course/Program</th>
                    <td id="modal-course"></td>
                </tr>
                <tr>
                    <th>Document Type</th>
                    <td id="modal-docu-type"></td>
                </tr>
                <tr>
                    <th>Purpose</th>
                    <td id="modal-purpose"></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td id="modal-status"></td>
                </tr>
                <tr>
                    <th>Note</th>
                    <td id="modal-note"></td>
                </tr>
            </table>
        </div>
    </div>

    <script>
        // Get the modal
        var modal = document.getElementById("viewModal");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Get all view buttons
        var viewButtons = document.querySelectorAll('.btn-view');

        // Add click event to each view button
        viewButtons.forEach(button => {
            button.onclick = function() {
                // Get data attributes
                var idNumber = button.getAttribute('data-id-number');
                var fullname = button.getAttribute('data-fullname');
                var contact = button.getAttribute('data-contact');
                var course = button.getAttribute('data-course');
                var docuType = button.getAttribute('data-docu-type');
                var purpose = button.getAttribute('data-purpose');
                var status = button.getAttribute('data-status');
                var note = button.getAttribute('data-note');

                // Populate modal with data
                document.getElementById('modal-id-number').innerText = idNumber;
                document.getElementById('modal-fullname').innerText = fullname;
                document.getElementById('modal-contact').innerText = contact;
                document.getElementById('modal-course').innerText = course;
                document.getElementById('modal-docu-type').innerText = docuType;
                document.getElementById('modal-purpose').innerText = purpose;
                document.getElementById('modal-status').innerText = status;
                document.getElementById('modal-note').innerText = note;

                // Display the modal
                modal.style.display = "block";
            }
        });
    </script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
