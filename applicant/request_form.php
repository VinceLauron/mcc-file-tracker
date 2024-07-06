<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link rel="icon" href="assets/img/mcc1.png" type="image/x-icon" />
  <title>Request Form - MCC Document Tracker</title>
  <style>
    body {
      background: #80808045;
      font-family: Arial, sans-serif;
    }

    .container {
      width: 50%;
      margin: 50px auto;
      background: #fff;
      padding: 20px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      border-radius: 8px;
    }

    .container h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      margin-bottom: 5px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .form-group textarea {
      resize: vertical;
    }

    .btn {
      display: block;
      width: 100%;
      padding: 10px;
      background: #2a2f5b;
      color: #fff;
      border: none;
      border-radius: 4px;
      font-size: 16px;
      cursor: pointer;
    }

    .btn:hover {
      background: #495057;
    }
  </style>
</head>

<body>
  <div class="container">
    <h2>Request Form</h2>
    <form action="request_form.php" method="POST">
      <div class="form-group">
        <label for="fullname">Full Name:</label>
        <input type="text" id="fullname" name="fullname" required>
      </div>
      <div class="form-group">
        <label for="contact">Contact:</label>
        <input type="text" id="contact" name="contact" required>
      </div>
      <div class="form-group">
        <label for="id_number">ID Number:</label>
        <input type="text" id="id_number" name="id_number" required>
      </div>
      <div class="form-group">
        <label for="docu_type">Document Type:</label>
        <select id="docu_type" name="docu_type" required>
          <option value="" disabled selected>Select Document Type</option>
          <option value="certificate">Certificate</option>
          <option value="birth_certificate">Birth Certificate</option>
          <option value="good_moral_certificate">Good Moral Certificate</option>
          <option value="tor">TOR</option>
        </select>
      </div>
      <div class="form-group">
        <label for="purpose">Purpose of Request:</label>
        <textarea id="purpose" name="purpose" rows="4" required></textarea>
      </div>
      <button type="submit" class="btn">Submit Request</button>
    </form>
  </div>
</body>

</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form inputs
    $fullname = htmlspecialchars($_POST['fullname']);
    $contact = htmlspecialchars($_POST['contact']);
    $id_number = htmlspecialchars($_POST['id_number']);
    $docu_type = htmlspecialchars($_POST['docu_type']);
    $purpose = htmlspecialchars($_POST['purpose']);

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "fms_db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert data into database
    $sql = "INSERT INTO request (fullname, contact, id_number, docu_type, purpose) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $fullname, $contact, $id_number, $docu_type, $purpose);

    if ($stmt->execute()) {
        // Redirect to the administrator page
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
}
?>
