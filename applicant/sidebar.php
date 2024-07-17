<?php

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/mcc1.png" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

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
        #sidebar .logo {
        display: block;
            margin: 0 auto 20px;
            width: 100px;
            height: auto;
        }
    </style>
</head>
<body>
    
    <nav id="sidebar" class="mx-lt-5 bg-dark">
    <img src="assets/img/mcc1.png" class="logo">
        <div class="sidebar-list">
            <div class="nav-item nav-home" onclick="loadContent('home.php')">
                <span class="icon-field"><i class="fa fa-home"></i></span> Dashboard
            </div>
            <div class="nav-item nav-files" onclick="loadContent('request_form.php')">
                <span class="icon-field"><i class="fa fa-envelope"></i></span> Request Form
            </div>
            <div class="nav-item nav-files" onclick="loadContent('receive_form.php')">
                <span class="icon-field"><i class="fa fa-envelope-open"></i></span> Received Form
            </div>
            <div class="nav-item nav-users" onclick="loadContent('user_details.php')">
                <span class="icon-field"><i class="fa fa-users"></i></span> User Details
            </div>
        </div>
    </nav>

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
