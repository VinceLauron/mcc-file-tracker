<?php
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

// Database connection
include 'db_connect.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<?php include 'sidebar.php'; ?>
<?php include 'topbar.php'; ?>

<center>
    <div id="welcome-message">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['fullname']); ?>!</h1>
        <p>You have successfully logged in</p>
    </div>
</center>

<script>
    function loadContent(page) {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', page, true);
        xhr.onload = function() {
            if (this.status === 200) {
                document.getElementById('main-content').innerHTML = this.responseText;
                document.getElementById('welcome-message').style.display = 'none';
            }
        };
        xhr.send();
    }
</script>
