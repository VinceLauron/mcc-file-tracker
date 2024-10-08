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
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .container {
            width: 100%;
            max-width: 100%;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            border-radius: 8px;
            overflow-x: auto;
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
            word-wrap: break-word;
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Requests - MCC Document Tracker</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Number</th>
                    <th>Full Name</th>
                    <th>Document Type</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
    <?php
    while ($stmt->fetch()) {
        $status_class = ''; // Initialize the class variable for status

        // Assign a class based on the status value
        if ($status == 'pending') {
            $status_class = 'status-pending';
        } elseif ($status == 'onprocess') {
            $status_class = 'status-onprocess';
        } elseif ($status == 'rejected') {
            $status_class = 'status-rejected';
        } elseif ($status == 'released') {
            $status_class = 'status-released';
        }

        // Generate table rows with the dynamic status class
        echo "<tr>";
        echo "<td data-label='ID Number'>" . htmlspecialchars($id_number) . "</td>";
        echo "<td data-label='Full Name'>" . htmlspecialchars($fullname) . "</td>";
        echo "<td data-label='Document Type'>" . htmlspecialchars($docu_type) . "</td>";
        echo "<td data-label='Status' class='$status_class'>" . htmlspecialchars($status) . "</td>";
        echo "<td data-label='Actions'>
                <button class='btn btn-view btn-primary' data-bs-toggle='modal' data-bs-target='#viewModal' onclick='loadModalData(" . htmlspecialchars($id) . ")'>View</button>
                <a href='#' class='btn btn-delete btn-danger' onclick='confirmDelete(\"" . htmlspecialchars($id) . "\")'>Delete</a>
              </td>";
        echo "</tr>";
    }
    ?>
</tbody>

        </table>
    </div>

   <!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">Request Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="details-section">
                    <div class="details-item">
                        <span class="details-label">ID Number:</span>
                        <span id="modal-id_number" class="details-value"></span>
                    </div>
                    <div class="details-item">
                        <span class="details-label">Full Name:</span>
                        <span id="modal-fullname" class="details-value"></span>
                    </div>
                    <div class="details-item">
                        <span class="details-label">Contact:</span>
                        <span id="modal-contact" class="details-value"></span>
                    </div>
                    <div class="details-item">
                        <span class="details-label">Course:</span>
                        <span id="modal-course" class="details-value"></span>
                    </div>
                    <div class="details-item">
                        <span class="details-label">Document Type:</span>
                        <span id="modal-docu_type" class="details-value"></span>
                    </div>
                    <div class="details-item">
                        <span class="details-label">Purpose:</span>
                        <span id="modal-purpose" class="details-value"></span>
                    </div>
                    <div class="details-item">
                        <span class="details-label">Status:</span>
                        <span id="modal-status" class="details-value"></span>
                    </div>
                    <div class="details-item">
                        <span class="details-label">Note:</span>
                        <span id="modal-note" class="details-value"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS -->
<style>
    /* Modal header styling */
    .modal-header {
        background-color: #007bff;
        color: #fff;
        border-bottom: none;
    }

    .modal-title {
        font-weight: bold;
        font-size: 1.5rem;
    }

    /* Modal body and details section */
    .modal-body {
        padding: 20px;
        background-color: #f9f9f9;
        font-size: 16px;
    }

    .details-section {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    .details-item {
        display: flex;
        justify-content: space-between;
        padding: 15px;
        margin-bottom: 15px;
        background-color: #f5f5f5;
        border-radius: 8px;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.05);
    }

    .details-item:last-child {
        margin-bottom: 0;
    }

    .details-label {
        font-weight: bold;
        font-size: 1.1rem;
        color: #555;
    }

    .details-value {
        font-size: 1.1rem;
        color: #333;
        text-align: right;
    }

    /* Status styling */
    #modal-status {
        font-weight: bold;
        padding: 8px 12px;
        border-radius: 8px;
        display: inline-block;
        color: #fff;
    }

    .modal-status-pending {
        background-color: #ffeb3b; /* Yellow for pending */
        color: #000;
    }

    .modal-status-onprocess {
        background-color: #ffc107; /* Orange for on process */
        color: #000;
    }

    .modal-status-rejected {
        background-color: #f44336; /* Red for rejected */
    }

    .modal-status-released {
        background-color: #4caf50; /* Green for released */
    }

    /* Modal footer styling */
    .modal-footer {
        display: flex;
        justify-content: flex-end;
        padding: 15px;
        background-color: #f1f1f1;
        border-top: none;
    }

    .btn-close {
        background-color: transparent;
        border: none;
        color: #fff;
        font-size: 1.2rem;
        opacity: 0.8;
    }

    .btn-close:hover {
        opacity: 1;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 5px;
    }
</style>



    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    
    <!-- JavaScript for SweetAlert Delete Confirmation -->
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to delete_request.php with the ID
                    window.location.href = 'delete_request.php?id=' + id;
                }
            });
        }

        function loadModalData(id) {
    // AJAX call to fetch request details by ID and load into modal
    fetch(`get_request_details.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            // Fill modal with fetched data
            document.getElementById('modal-id_number').textContent = data.id_number;
            document.getElementById('modal-fullname').textContent = data.fullname;
            document.getElementById('modal-contact').textContent = data.contact;
            document.getElementById('modal-course').textContent = data.course;
            document.getElementById('modal-docu_type').textContent = data.docu_type;
            document.getElementById('modal-purpose').textContent = data.purpose;
            document.getElementById('modal-status').textContent = data.status;
            document.getElementById('modal-note').textContent = data.note;
            
            // Remove previous status class from the status element
            const statusElement = document.getElementById('modal-status');
            statusElement.classList.remove('modal-status-pending', 'modal-status-onprocess', 'modal-status-rejected', 'modal-status-released');
            
            // Apply the appropriate status class
            if (data.status === 'pending') {
                statusElement.classList.add('modal-status-pending');
            } else if (data.status === 'onprocess') {
                statusElement.classList.add('modal-status-onprocess');
            } else if (data.status === 'rejected') {
                statusElement.classList.add('modal-status-rejected');
            } else if (data.status === 'released') {
                statusElement.classList.add('modal-status-released');
            }
        })
        .catch(error => console.error('Error fetching data:', error));
}

    </script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
