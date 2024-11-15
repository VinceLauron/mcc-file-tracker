<?php
// Check if session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include 'db_connect.php';

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
                    <th>Document Type</th>
                    <th>Status</th>
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
                    echo "<td data-label='Document Type'>" . htmlspecialchars($docu_type) . "</td>";
                    echo "<td data-label='Status' class='$status_class'>" . htmlspecialchars($status) . "</td>";
                    echo "<td data-label='Actions'>
                            <a href=\"javascript:void(0);\" class=\"btn btn-view\" onclick=\"openModal($id)\">View</a>
                             <a href='javascript:void(0);' class='btn btn-delete' onclick='confirmDelete($id)'>Delete</a>
                        </td>";

                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- Modal Structure -->
<div id="viewModal" class="modal">
    <div class="modal-content">
        <h2>Edit Request</h2>
        <form id="editRequestForm" method="post">
            <input type="hidden" id="editId" name="id">

            <div class="form-group">
                <label for="editIdNumber">ID Number:</label>
                <input type="text" id="editIdNumber" name="id_number" readonly>
            </div>

            <div class="form-group">
                <label for="editFullname">Full Name:</label>
                <input type="text" id="editFullname" name="fullname" readonly>
            </div>

            <div class="form-group">
                <label for="editCourse">Course:</label>
                <input type="text" id="editCourse" name="course" readonly>
            </div>

            <!-- Document Type with Radio Buttons -->
            <section class="radio-section">
	<div class="radio-list">
		<label>Document Type:</label>
		<div class="radio-item"><input name="docu_type" id="docuType1" type="radio" value="Transcript Of Records"><label for="docuType1">Transcript Of Records</label></div>
        <div class="radio-item"><input name="docu_type" id="docuType2" type="radio" value="Certificate Of Good Moral"><label for="docuType2">Certificate Of Good Moral</label></div>
        <div class="radio-item"><input name="docu_type" id="docuType3" type="radio" value="Diploma"><label for="docuType3">Diploma</label></div>
	</div>
</section>

            <div class="form-group">
                <label for="editContact">Contact:</label>
                <input type="text" id="editContact" name="contact" readonly>
            </div>

            <div class="form-group">
                <label for="editPurpose">Purpose of Request:</label>
                <input type="text" id="editPurpose" name="purpose">
            </div>

            <div class="form-group">
    <label for="editStatus">Status:</label>
    <input type="text" id="editStatus" name="status" readonly>
</div>

            <div class="form-group">
                <label for="editNote">Note:</label>
                <textarea id="editNote" name="note" readonly></textarea>
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-save" onclick="saveChanges()">Save</button>
                <button type="button" class="btn btn-no" onclick="closeModal()">Close</button>
            </div>
        </form>
    </div>
</div>


<style>
    .modal {
    display: none;
    position: fixed;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
    padding: 10px;
}

.modal-content {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    width: 100%;
    max-width: 400px;
    max-height: 90vh; /* Ensures the modal doesn't exceed 90% of the viewport height */
    overflow-y: auto; /* Adds scroll if content overflows vertically */
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
}

h2 {
    margin-bottom: 20px;
    text-align: center;
    font-size: 1.5rem;
    color: #333;
}

.form-group {
    margin-bottom: 10px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-size: 0.9rem;
    color: #555;
}

.form-group input,
.form-group textarea,
.form-group select {
    width: 100%;
    padding: 8px;
    font-size: 14px;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-sizing: border-box;
    transition: border-color 0.3s;
}

.form-group input:focus,
.form-group textarea:focus,
.form-group select:focus {
    border-color: #007bff;
    outline: none;
}

.form-group textarea {
    resize: vertical;
    height: 80px;
}

.form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 15px;
}

.btn {
    padding: 8px 16px;
    border: none;
    cursor: pointer;
    border-radius: 5px;
    font-size: 14px;
    transition: background-color 0.3s ease;
}

.btn-save {
    background-color: #28a745;
    color: white;
}

.btn-no {
    background-color: #dc3545;
    color: white;
    height: 50%;
}

.btn:hover {
    opacity: 0.9;
}

.form-actions .btn {
    width: 48%;
}

/* Media Queries for smaller screens */
@media screen and (max-width: 600px) {
    .modal-content {
        width: 100%;
        max-width: 300px;
        padding: 15px;
    }
    h2 {
        font-size: 1.2rem;
    }
    .btn {
        font-size: 13px;
    }
}
a {
	text-decoration: none;
}
ul {
	list-style-type: none;
}

.form-group {
    margin-bottom: 15px;
}

/* Radio item wrapper */
.radio-item {
    position: relative;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
}

/* Style the radio buttons to look like they're inside the input */
.radio-item input[type="radio"] {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    z-index: 1;
    width: 20px;
    height: 20px;
    cursor: pointer;
}

/* Style the label like an input box */
.radio-item label {
    display: block;
    width: 100%;
    padding: 8px 8px 8px 40px; /* Padding to make room for the radio button */
    background-color: whitesmoke;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
    cursor: pointer;
    transition: border-color 0.3s ease;
    box-sizing: border-box;
    position: relative;
}

/* Highlight border and background when radio is checked */
.radio-item input[type="radio"]:checked + label {
    border-color: #007bff;
    background-color: #f0f8ff;
}


.radio-item input[type="radio"]:checked + label::before {
    background: #007bff;
}

/* Ensure all form fields have the same height */
.form-group input,
.form-group textarea,
.radio-item label {
    height: 40px; /* Ensure height matches */
}

/* Adjust the alignment of form fields */
.form-group {
    margin-bottom: 10px;
}

.form-group input[type="radio"] {
    margin-right: 8px; /* Adjust space between radio button and label */
}

/* Highlight the status field */
#editStatus {
    background-color: #f0f8ff; /* Light blue background */
    border: 2px solid #007bff; /* Blue border */
    color: #007bff; /* Text color to match the border */
    font-weight: bold;
}

</style>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function openModal(id) {
    document.getElementById('viewModal').style.display = 'flex';
    fetch(`get_request_details.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('editId').value = data.id;
            document.getElementById('editIdNumber').value = data.id_number;
            document.getElementById('editFullname').value = data.fullname;
            document.getElementById('editCourse').value = data.course;
            document.getElementById('editContact').value = data.contact;
            document.getElementById('editPurpose').value = data.purpose;

            // Set document type (radio buttons)
            if (data.docu_type === 'Transcript of Records') {
                document.getElementById('docuType1').checked = true;
            } else if (data.docu_type === 'Certificate Of Good Moral') {
                document.getElementById('docuType2').checked = true;
            } else if (data.docu_type === 'Diploma') {
                document.getElementById('docuType3').checked = true;
            }

            // Set status (read-only)
            document.getElementById('editStatus').value = data.status;
            // Set note
            document.getElementById('editNote').value = data.note;
        })
        .catch(error => console.error('Error fetching request:', error));
}


function closeModal() {
    document.getElementById('viewModal').style.display = 'none';
}

function saveChanges() {
    const formData = new FormData(document.getElementById('editRequestForm'));
    const status = document.getElementById('editStatus').value;

    // Check if the status is "Pending", "On Process", or "Released"
    if (status === "pending" || status === "onprocess" || status === "released") {
        Swal.fire({
            title: 'Action Not Allowed',
            text: 'You cannot save changes while the status is "Pending", "On Process", or "Released".',
            icon: 'warning',
            confirmButtonText: 'OK'
        });
        return; // Exit the function
    }

    // Additional check for rejected status
    if (status === "rejected") {
        Swal.fire({
            title: 'Request Rejected',
            text: 'Would you like to resubmit the request?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, resubmit!',
            cancelButtonText: 'No, cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                formData.append('resubmit', 'true'); // Add resubmit flag
                submitFormData(formData); // Submit the form data
            }
        });
    } else {
        submitFormData(formData); // Submit the form data without confirmation
    }
}


function submitFormData(formData) {
    fetch('resubmit_request.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(result => {
        Swal.fire({
            title: 'Success!',
            text: result,
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            closeModal();
            location.reload(); // Reload to reflect updates
        });
    })
    .catch(error => {
        Swal.fire({
            title: 'Error!',
            text: 'An error occurred while updating the request.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        console.error('Error updating request:', error);
    });
}
</script>
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, Keep it!',
    }).then((result) => {
        if (result.isConfirmed) {
            // If the user confirms, redirect to the delete_request.php with the id
            window.location.href = 'delete_request.php?id=' + id;
        }
    })
}
</script>


</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
