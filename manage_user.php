<?php 
include('db_connect.php');
if(isset($_GET['id'])){
$user = $conn->query("SELECT * FROM users where id =".$_GET['id']);
foreach($user->fetch_array() as $k =>$v){
	$meta[$k] = $v;
}
}
?>
 <link rel="icon" href="applicant/assets/img/mcc1.png" type="image/x-icon" />
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
