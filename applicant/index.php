<?php
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    include('./header.php'); 
    // include('./auth.php'); 
    exit();
}

// Database connection
include 'db_connect.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
    <link rel="icon" href="assets/img/mcc1.png" type="image/x-icon" />
<style>
  body, html {
    height: 100%;
    margin: 0;
    display: flex;
    flex-direction: column; /* Ensure content flows vertically */
    background-color: #f8f9fa; /* Optional background color */
}

#topbar {
    width: 90%;
    position: fixed;
    top: 0;
    left: 0;
    height: 50px; /* Adjust topbar height as needed */
    background-color: #f1f1f1;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Add shadow for better visibility */
    z-index: 1000;
    display: flex;
    align-items: center;
    padding: 0 20px;
}

#sidebar {
    position: fixed;
    top: 50px; /* Match the height of the topbar */
    left: 0;
    width: 200px;
    height: calc(100% - 50px); /* Sidebar should fill the remaining height */
    background-color: #343a40;
    z-index: 999;
    padding: 20px 0;
}

#view-panel {
    margin-top: 0; /* Create space below the topbar */
    margin-left: 220px; /* Adjust this based on sidebar width */
    width: calc(100% - 220px); /* Adjust to fit remaining screen width */
    padding: 20px;
    background-color: #ffffff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Adds a subtle shadow */
    border-radius: 8px; /* Rounds the corners */
    overflow-y: auto;
    max-height: calc(100vh - 60px); /* Ensure the content does not overflow */
}

.toast {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1050;
    padding: 10px;
    background-color: #343a40;
    color: #fff;
    border-radius: 5px;
}

@media (max-width: 768px) {
    #view-panel {
        margin-left: 0;
        width: 100%;
        padding: 10px;
    }

    #sidebar {
        width: 100px; /* Smaller sidebar for mobile view */
    }
}


</style>
<body>
    <?php include 'sidebar.php'; ?>
    <?php include 'topbar.php'; ?>
    
    <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body text-white"></div>
    </div>
    
    <main id="view-panel">
        <?php $page = isset($_GET['page']) ? $_GET['page'] : 'home'; ?>
        <?php include $page . '.php'; ?>
    </main>
</body>


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

