<?php
session_start();

if(!isset($_SESSION['email']))
header('location:login.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/mcc1.png" type="image/x-icon" />
    <title>MCC DOCUMENT TRACKER</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        #sidebar {
            position: fixed;
            width: 250px;
            height: 100%;
            background-color: #2a2f5b;
            padding-top: 20px;
        }

        #sidebar .sidebar-list {
            padding: 0;
            list-style: none;
        }

        #sidebar .nav-item {
            display: block;
            padding: 15px 20px;
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
        }

        #sidebar .nav-item .icon-field {
            margin-right: 10px;
        }

        #sidebar .nav-item:hover,
        #sidebar .nav-item.active {
            background-color: #495057;
        }

        .topbar {
            position: fixed;
            width: calc(100% - 300px);
            height: 60px;
            background-color: #2a2f5b;
            color: white;
            display: flex;
            align-items: center;
            padding: 0 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000; /* Make sure it is above other content */
            left: 250px; /* Align with sidebar */
        }

        .topbar .topbar-brand {
            font-size: 20px;
            font-weight: bold;
        }

        .topbar .topbar-menu {
            margin-left: auto;
            display: flex;
            align-items: center;
        }

        .topbar .topbar-menu a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            padding: 10px;
        }

        .topbar .topbar-menu a:hover {
            background-color: #495057;
            border-radius: 5px;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            padding-top: 80px;
        }
    </style>
</head>
<body>
<?php include 'sidebar.php' ?>
<?php include 'topbar.php' ?>


    <div class="main-content" id="main-content">
        <h1>Welcome, <?php echo $_SESSION['fullname']; ?>!</h1>
        <p>You have successfully logged in.</p>
    </div>

    <script>
        function loadContent(page) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', page, true);
            xhr.onload = function() {
                if (this.status === 200) {
                    document.getElementById('main-content').innerHTML = this.responseText;
                }
            };
            xhr.send();
        }
    </script>
</body>
</html>
