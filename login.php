<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link rel="icon" href="applicant/assets/img/mcc1.png" type="image/x-icon" />

  <title>MCC FILE AND DOCUMENT TRACKER</title>
 	

<?php include('./header.php'); ?>
<?php 
session_start();
if(isset($_SESSION['login_id']))
header("location:indexs.php?page=home");
?>

</head>
<style>
	body{
		width: 100%;
	    height: calc(100%);
	}
	main#main{
		width:100%;
		height: calc(100%);
		background:white;
	}
	#login-right{
		position: absolute;
		right:0;
		width:40%;
		height: calc(100%);
		background:white;
		display: flex;
		align-items: center;
	}
	#login-left{
		position: absolute;
		left:0;
		width:60%;
		height: calc(100%);
		background:darkblue;
		display: flex;
		align-items: center;
	}
	#login-left .logo {
		text-align: left;
		width: 100%;
		padding-left: 20px;
	}
	#login-right .card{
		margin: auto
	}
	.logo {
		margin: auto;
		font-size: 8rem;
		padding: .5em 0.8em;
	}
</style>

<body>


  <main id="main" class=" alert-info">
  		<div id="login-left">
  			<div class="logo">
  				<img src="img/mcc1.png">
  			</div>
  		</div>
  		<div id="login-right">
  			<div class="w-100">
  				<h4 style="color:black; text-align: center;"><b>MADRIDEJOS COMMUNITY COLLEGE FILE AND DOCUMENT TRACKER</b></h4>
  				<br>
  			
  			<div class="card col-md-8">
  				<div class="card-body">
  					<form id="login-form" >
  						<div class="form-group">
  							<label for="username" class="control-label" style="color: black">Username</label>
  							<input type="email" id="username" name="username" placeholder="Enter Username" class="form-control">
  						</div>
  						<div class="form-group">
  							<label for="password" class="control-label" style="color: black">Password</label>
  							<input type="password" id="password" name="password" placeholder="Enter Password" class="form-control">
  						</div>
  						<center><button class="btn-sm btn-block btn-wave col-md-4 btn-primary">Login</button></center>
						  <div class="text-center mt-3">
							<a href="forgot-password.php" id="forgot-password-link">Forgot Password?</a>
						</div>
  					</form>
  				</div>
  			</div>
  		</div>
   		</div>

  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


</body>
<script>
	$('#login-form').submit(function(e){
		e.preventDefault()
		$('#login-form button[type="button"]').attr('disabled',true).html('Logging in...');
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'ajax.php?action=login',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
		$('#login-form button[type="button"]').removeAttr('disabled').html('Login');

			},
			success:function(resp){
				if(resp == 1){
					location.reload('indexs.php?page=home');
				}else{
					$('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
					$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
				}
			}
		})
	})
</script>	
</html>
