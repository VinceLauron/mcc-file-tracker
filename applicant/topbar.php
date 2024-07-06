<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .topbar {
            position: fixed;
            width: calc(100% - 280px); /* Adjust to the width of the sidebar */
            height: 60px;
            background-color: #2a2f5b;
            color: white;
            display: flex;
            align-items: center;
            padding: 0 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000; /* Make sure it is above other content */
            left: 250px; /* Align with sidebar */
            top: 0; /* Ensure it stays at the top of the page */
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
            display: flex;
            align-items: center;
        }

        .topbar .topbar-menu a:hover {
            background-color: #495057;
            border-radius: 5px;
        }

        .topbar .topbar-menu .fa {
            margin-right: 5px; /* Space between icon and text */
        }
    </style>
</head>
<body>

    <div class="topbar">
        <div class="topbar-brand">
            MCC Document Tracker
        </div>
        <div class="topbar-menu">
            <a href="login.php" class="logout">
                <i class="fa fa-power-off"></i> Logout
            </a>
        </div>
    </div>

</body>
</html>
