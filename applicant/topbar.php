<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Include SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.min.css">
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
    <!-- Include SweetAlert JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.all.min.js"></script>
    <script>
        function confirmLogout(event) {
            event.preventDefault(); // Prevent the default action
            // Use SweetAlert for confirmation
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to logout.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, logout'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Proceed with logout
                    window.location.href = event.target.href;
                }
            });
        }
    </script>
</head>
<body>

    <div class="topbar">
        <div class="topbar-brand">
            MCC Document Tracker
        </div>
        <div class="topbar-menu">
            <a href="login.php" class="logout" onclick="confirmLogout(event)">
                <i class="fa fa-power-off"></i> Logout<br>
                <?php echo $_SESSION['fullname']; ?> 
            </a>
        </div>
    </div>

</body>
</html>
