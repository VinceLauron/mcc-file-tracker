<?php
if(!isset($_SESSION['login_id']))
header('location:login.php');
session_start();
include 'db_connect.php';

require 'phpmailer/vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Hash the password using MD5
    $status = 'Verified'; // Automatically set status to Verified

    // Insert user data into the database
    $stmt = $conn->prepare("INSERT INTO users (name, username, password, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $username, $password, $status);

    if ($stmt->execute()) {
        // No need to send verification code, automatically verified
        $_SESSION['username'] = $username;
        header("Location: indexs.php?page=users"); // Redirect to dashboard or appropriate page
        exit();
    } else {
        echo "Failed to store user data.";
    }

    $stmt->close();
    $conn->close();
}
?>

<div class="container-fluid">
    <form action="manage_user.php" id="manage-user" method="POST">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="username">Email (Username)</label>
            <input type="email" name="username" id="username" class="form-control" required>
        </div>
        <div class="form-group">
        <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
            <input type="checkbox" id="showPassword" style="margin-top: 10px;"> Show Password
        </div>
        <div class="form-group">
            <label for="type">User Type</label>
            <select name="type" id="type" class="custom-select">
                <option value="1">Admin</option>
            </select>
        </div>
    </form>
</div>

<script>
document.getElementById('showPassword').addEventListener('change', function() {
        var passwordField = document.getElementById('password');
        if (this.checked) {
            passwordField.type = 'text';
        } else {
            passwordField.type = 'password';
        }
    });

	$('#manage-user').submit(function(e){
		e.preventDefault();
		start_load();
		$.ajax({
			url:'ajax.php?action=save_user',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp ==1){
					alert_toast("Data successfully saved",'success');
					setTimeout(function(){
						location.reload();
					},1500);
				}
			}
		});
	});
</script>
