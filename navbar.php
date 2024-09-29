<?php
if (!isset($_SESSION['login_id'])) {
    header('location:login.php');
}
?>

<nav id="sidebar" class='mx-lt-5' style="background-color: #2a2f5b;">
    <div class="sidebar-list">
        <a href="indexs.php?page=home" class="nav-item nav-home <?php echo isset($_GET['page']) && $_GET['page'] === 'home' ? 'active-dashboard' : ''; ?>">
            <span class='icon-field'><i class="fa fa-home"></i></span> Dashboard
        </a>
        <a href="indexs.php?page=view_requests" class="nav-item nav-files <?php echo isset($_GET['page']) && $_GET['page'] === 'view_requests' ? 'active-requests' : ''; ?>">
            <span class='icon-field'><i class="fa fa-file"></i></span> Status Request
        </a>
        <a href="indexs.php?page=all_request" class="nav-item nav-form <?php echo isset($_GET['page']) && $_GET['page'] === 'all_request' ? 'active-all' : ''; ?>">
            <span class='icon-field'><i class="fa fa-folder-open"></i></span> All Request
        </a>
		<a href="indexs.php?page=user_details" class="nav-item nav-form <?php echo isset($_GET['page']) && $_GET['page'] === 'user_details' ? 'active-all' : ''; ?>">
            <span class='icon-field'><i class="fa fa-user-plus"></i></span> User Accounts
        </a>
        <?php if ($_SESSION['login_type'] == 1): ?>
            <a href="indexs.php?page=users" class="nav-item nav-users <?php echo isset($_GET['page']) && $_GET['page'] === 'users' ? 'active-users' : ''; ?>">
                <span class='icon-field'><i class="fa fa-users"></i></span> Users
            </a>
        <?php endif; ?>
    </div>
</nav>

<style>
.nav-item.active-dashboard {
    background-color: royalblue; /* Color for Dashboard */
    color: white; /* Change text color if needed */
}
.nav-item.active-requests {
    background-color: royalblue; /* Color for Status Request */
    color: white; /* Change text color if needed */
}
.nav-item.active-all {
    background-color: royalblue; /* Color for All Request */
    color: white; /* Change text color if needed */
}
.nav-item.active-users {
    background-color: royalblue; /* Color for Users */
    color: white; /* Change text color if needed */
}
.nav-item.active-user_details {
    background-color: royalblue; /* Color for Users */
    color: white; /* Change text color if needed */
}
</style>
