<?php
// Check if session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['email'])) {
    echo "Not authorized";
    exit();
}

// Include database connection
include 'db_connect.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$showAlert = false;
$disableForm = false;
$alertMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input data
    $id = $_POST['id'];
    $id_number = htmlspecialchars($_POST['id_number']);
    $fullname = htmlspecialchars($_POST['fullname']);
    $contact = htmlspecialchars($_POST['contact']);
    $course = htmlspecialchars($_POST['course']);
    $docu_type = htmlspecialchars($_POST['docu_type']);
    $purpose = htmlspecialchars($_POST['purpose']);
    $status = htmlspecialchars($_POST['status']);
    $note = htmlspecialchars($_POST['note']);

    // Check if status is "rejected"
    if ($status == 'rejected') {
        // Perform the resend action here
        $status = 'pending'; // Update status to pending for resend
        // Additional logic for notifying administrator can go here
        // For example, you can send an email to notify them about the resend
    }

    // Prepare and bind
    $stmt = $conn->prepare("UPDATE request SET id_number = ?, fullname = ?, contact = ?, course = ?, docu_type = ?, purpose = ?, status = ?, note = ? WHERE id = ?");
    $stmt->bind_param("ssssssssi", $id_number, $fullname, $contact, $course, $docu_type, $purpose, $status, $note, $id);

    if ($stmt->execute()) {
        $showAlert = true;
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT id, id_number, fullname, contact, course, docu_type, purpose, status, note FROM request WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($id, $id_number, $fullname, $contact, $course, $docu_type, $purpose, $status, $note);
    $stmt->fetch();

    $stmt->close();
}

$conn->close();
?>
<title>MCC DOCUMENT TRACKER</title>
<link rel="icon" href="assets/img/mcc1.png" type="image/x-icon" />
<body style="background-image: url('../img/back.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; height: 100vh;">
    <div class="container mt-5" style="background-color: rgba(255, 255, 255, 0.8); padding: 20px; border-radius: 8px;">
        <!-- Back to Index Button -->
        <div class="mb-4">
            <a href="index.php" class="btn btn-secondary">Back to Index</a>
        </div>
        <h2 style="text-align: center;">Edit Request</h2>
        <?php if (!$disableForm && isset($_GET['id'])): ?>
            <form id="editRequestForm" method="POST" action="">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="id_number">ID Number</label>
                        <input type="text" class="form-control" id="id_number" name="id_number" value="<?php echo htmlspecialchars($id_number); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="fullname">Full Name</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo htmlspecialchars($fullname); ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="contact">Contact</label>
                        <input type="text" class="form-control" id="contact" name="contact" value="<?php echo htmlspecialchars($contact); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="course">Course/Program</label>
                        <select class="form-control" id="course" name="course" required>
                            <option value="" disabled>Select Course/Program</option>
                            <option value="BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY" <?php if ($course == "BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY") echo 'selected'; ?>>BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY</option>
                            <option value="BACHELOR OF SCIENCE IN BUSINESS ADMINISTRATION MAJOR IN FINANCIAL MANAGEMENT" <?php if ($course == "BACHELOR OF SCIENCE IN BUSINESS ADMINISTRATION MAJOR IN FINANCIAL MANAGEMENT") echo 'selected'; ?>>BACHELOR OF SCIENCE IN BUSINESS ADMINISTRATION MAJOR IN FINANCIAL MANAGEMENT</option>
                            <option value="BACHELOR OF SCIENCE IN HOSPITALITY MANAGEMENT" <?php if ($course == "BACHELOR OF SCIENCE IN HOSPITALITY MANAGEMENT") echo 'selected'; ?>>BACHELOR OF SCIENCE IN HOSPITALITY MANAGEMENT</option>
                            <option value="BACHELOR OF SCIENCE IN SECONDARY EDUCATION MAJOR IN FILIPINO" <?php if ($course == "BACHELOR OF SCIENCE IN SECONDARY EDUCATION MAJOR IN FILIPINO") echo 'selected'; ?>>BACHELOR OF SCIENCE IN SECONDARY EDUCATION MAJOR IN FILIPINO</option>
                            <option value="BACHELOR OF SCIENCE IN ELEMENTARY EDUCATION" <?php if ($course == "BACHELOR OF SCIENCE IN ELEMENTARY EDUCATION") echo 'selected'; ?>>BACHELOR OF SCIENCE IN ELEMENTARY EDUCATION</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="docu_type">Document Type</label>
                        <select class="form-control" id="docu_type" name="docu_type" required>
                            <option value="" disabled>Select Document Type</option>
                            <option value="Good Moral Certificates" <?php if ($docu_type == "Good Moral Certificates") echo 'selected'; ?>>Good Moral Certificates</option>
                            <option value="Transcript of Records" <?php if ($docu_type == "Transcript of Records") echo 'selected'; ?>>Transcript of Records</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="purpose">Purpose</label>
                        <input type="text" class="form-control" id="purpose" name="purpose" value="<?php echo htmlspecialchars($purpose); ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="status">Status</label>
                        <input type="text" class="form-control" id="status" name="status" value="<?php echo htmlspecialchars($status); ?>" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="note">Note</label>
                        <textarea class="form-control" id="note" name="note" required readonly><?php echo htmlspecialchars($note); ?></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Resubmit Changes</button>
                    </div>
                </div>
            </form>
        <?php endif; ?>

        <!-- Display modal using SweetAlert for approved requests -->
        <?php if ($disableForm): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Request Already Accepted Please wait for Released!',
                        html: '<?php echo $alertMessage; ?>',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    }).then(function() {
                        // Redirect or handle as needed
                        window.location.href = "index.php"; // Change to your desired redirect URL
                    });
                });
            </script>
        <?php endif; ?>

        <!-- Display success alert -->
        <?php if ($showAlert): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Record updated successfully',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(function() {
                        window.location.href = "index.php"; // Change to your desired redirect URL
                    });
                });
            </script>
        <?php endif; ?>
    </div>
    <!-- Include necessary stylesheets -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Include necessary scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybBogGzV+rT04oFb4IHsiX3YDzH7UVR8+4vfVRe+Br4dKc5Ux" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-ho+j7jyWK8fNpkmMj0zthpj8vLkm/D/QDf6f9/jy5iVdISp+Ejsd6GWPgZef7j9z" crossorigin="anonymous"></script>
</body>
