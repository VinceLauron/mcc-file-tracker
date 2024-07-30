<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Requests - MCC Document Tracker</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
                            <button class='btn btn-view' data-toggle='modal' data-target='#viewModal' data-id='" . htmlspecialchars($id) . "' data-id_number='" . htmlspecialchars($id_number) . "' data-fullname='" . htmlspecialchars($fullname) . "' data-contact='" . htmlspecialchars($contact) . "' data-course='" . htmlspecialchars($course) . "' data-docu_type='" . htmlspecialchars($docu_type) . "' data-purpose='" . htmlspecialchars($purpose) . "' data-status='" . htmlspecialchars($status) . "' data-note='" . htmlspecialchars($note) . "'>View</button>
                            <a href='delete_request.php?id=" . htmlspecialchars($id) . "' class='btn btn-delete' onclick='return confirm(\"Are you sure you want to delete this request?\")'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- View Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">Request Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>ID Number:</strong> <span id="modal-id-number"></span></p>
                    <p><strong>Full Name:</strong> <span id="modal-fullname"></span></p>
                    <p><strong>Contact:</strong> <span id="modal-contact"></span></p>
                    <p><strong>Course/Program:</strong> <span id="modal-course"></span></p>
                    <p><strong>Document Type:</strong> <span id="modal-docu-type"></span></p>
                    <p><strong>Purpose:</strong> <span id="modal-purpose"></span></p>
                    <p><strong>Status:</strong> <span id="modal-status"></span></p>
                    <p><strong>Note:</strong> <span id="modal-note"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#viewModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id_number = button.data('id_number');
            var fullname = button.data('fullname');
            var contact = button.data('contact');
            var course = button.data('course');
            var docu_type = button.data('docu_type');
            var purpose = button.data('purpose');
            var status = button.data('status');
            var note = button.data('note');

            var modal = $(this);
            modal.find('#modal-id-number').text(id_number);
            modal.find('#modal-fullname').text(fullname);
            modal.find('#modal-contact').text(contact);
            modal.find('#modal-course').text(course);
            modal.find('#modal-docu-type').text(docu_type);
            modal.find('#modal-purpose').text(purpose);
            modal.find('#modal-status').text(status);
            modal.find('#modal-note').text(note);
        });
    </script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
