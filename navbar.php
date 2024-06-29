<style>
	
</style>

<nav id="sidebar" class='mx-lt-5 bg-dark' >
		
		<div class="sidebar-list">

				<a href="indexs.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-home"></i></span> Dashboard</a>
				<a href="indexs.php?page=files" class="nav-item nav-files"><span class='icon-field'><i class="fa fa-file"></i></span> Files</a>
				<a href="indexs.php?page=all_files" class="nav-item nav-files"><span class='icon-field'><i class="fa fa-file"></i></span> All Files</a>
				<a href="indexs.php?page=track" class="nav-item nav-search"><span class='icon-field'><i class="fa fa-search"></i></span> Track Files</a>
				<?php if($_SESSION['login_type'] == 1): ?>
				<a href="indexs.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users"></i></span> Users</a>
			<?php endif; ?>
		</div>

</nav>
<script>
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>