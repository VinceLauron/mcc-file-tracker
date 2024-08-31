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
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Include SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.min.css">
    <style>
        .topbar {
            position: fixed;
            width: 100%;
            height: 60px;
            background-color: #2a2f5b;
            color: white;
            display: flex;
            justify-content: space-between; /* Align items on both ends */
            align-items: center;
            padding: 0 50px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000; /* Make sure it is above other content */
            top: 0; /* Ensure it is placed at the top */
        }
        .topbar-menu {
            display: flex;
            align-items: center;
        }
        .topbar-menu a {
            color: white;
            text-decoration: none;
            margin-left: 20px; /* Adjust spacing */
            display: flex;
            align-items: center;
        }
        .topbar-menu a .fa {
            margin-right: 5px;
        }
        .topbar-brand {
            font-size: 16px;
            font-weight: bold;
        }
        .topbar-brand, .topbar-menu {
            flex: 1; /* Distribute space between brand and menu */
        }

        .topbar .topbar-menu .fa {
            margin-right: 5px; /* Space between icon and text */
        }

        #sidebar {
            position: fixed;
            top: 60px; /* Make sure the sidebar starts below the topbar */
            width: 250px;
            height: calc(100% - 60px);
            background-color: #2a2f5b;
            padding-top: 20px;
            left: 0;
            transition: transform 0.3s ease-in-out;
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

        #sidebar-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            font-size: 24px;
            color: white;
            cursor: pointer;
            z-index: 1100;
        }

        #main-content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease-in-out;
            padding-top: 80px; /* Ensure content is not hidden under the topbar */
        }

        @media (max-width: 768px) {
            #sidebar {
                transform: translateX(-250px);
            }

            #sidebar-toggle {
                display: block;
            }

            #main-content {
                margin-left: 0;
            }

            #sidebar.show {
                transform: translateX(0);
            }

            #main-content.shifted {
                margin-left: 250px;
            }
        }
        .notification-bell {
            position: relative;
            display: flex;
            align-items: center;
            margin-left: 20px;
            cursor: pointer;
        }
        .notification-bell .fa-bell {
            font-size: 24px;
        }
        .notification-dropdown {
            display: none;
            position: absolute;
            top: 60px;
            right: 20px;
            background-color: #fff;
            color: #333;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            max-height: 400px;
            overflow-y: auto;
            z-index: 1000;
            border-radius: 4px;
            padding: 10px;
        }
        .notification-dropdown.show {
            display: block;
        }
        .notification-table {
            width: 100%;
            border-collapse: collapse;
        }
        .notification-table th, .notification-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .notification-table th {
            background-color: #f2f2f2;
        }
        .notification-item.read {
            color: #6c757d;
        }
        .notification-no-item {
            padding: 10px;
            text-align: center;
            color: #6c757d;
        }
    </style>
    <!-- Include SweetAlert JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

        document.addEventListener('DOMContentLoaded', function() {
            const bellIcon = document.querySelector('.notification-bell');
            const dropdown = document.querySelector('.notification-dropdown');

            bellIcon.addEventListener('click', function() {
                dropdown.classList.toggle('show');
                if (dropdown.classList.contains('show')) {
                    fetchAndShowNotifications();
                }
            });

            function updateNotificationCount() {
                $.ajax({
                    url: 'fetch_notifications.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('.notification-count').text(response.count); // Update the count
                    }
                });
            }

            function fetchAndShowNotifications() {
                $.ajax({
                    url: 'fetch_notifications.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        const dropdown = $('.notification-dropdown');
                        dropdown.empty(); // Clear existing notifications

                        if (response.notifications && response.notifications.length > 0) {
                            const table = $('<table class="notification-table"></table>');
                            table.append('<tr><th>Notification</th></tr>');

                            response.notifications.forEach(function(notification) {
                                const row = $('<tr></tr>').append('<td>' + notification.message + '</td>');
                                table.append(row);
                            });

                            dropdown.append(table);
                        } else {
                            dropdown.append("<div class='notification-no-item'>No new notifications</div>");
                        }
                    },
                    error: function(error) {
                        console.error('Error fetching notifications:', error);
                    }
                });

            }

            updateNotificationCount();
            setInterval(updateNotificationCount, 5000); // Update every 5 seconds
        });
    </script>
</head>
<body>
<div class="topbar">
    <div class="topbar-brand">MCC Document Tracker</div>
    <div class="topbar-menu" style="justify-content: flex-end;">
        <div class="notification-bell">
            <i class="fa fa-bell"></i>
            <span class="notification-count">0</span> <!-- Display the notification count -->
            <div class="notification-dropdown">
                <!-- Notifications will be dynamically inserted here -->
            </div>
        </div>
        <a href="login.php" class="logout" onclick="confirmLogout(event)">
            <i class="fa fa-sign-out-alt"></i> Logout
        </a>
    </div>
</div>

</body>
</html>
