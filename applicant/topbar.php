<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
<<<<<<< HEAD
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
            align-items: center;
            padding: 0 50px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000; /* Make sure it is above other content */
            top: 0; /* Ensure it is placed at the top */
=======
    <title>Your Page Title</title>
    <link rel="icon" href="assets/img/mcc1.png" type="image/x-icon" />
    <!-- Include the Google Fonts link if not already included -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Include Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background: silver;
        }
        .navbar {
            width: 100%;
            background: royalblue;
            padding: 20px 15px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.2);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .nav-links {
            display: flex;
            align-items: center;
>>>>>>> 338cc41baf20f40be0953b24b32df9d486bf1981
        }
        .nav-links li {
            list-style: none;
            margin: 0 12px;
        }
        .nav-links li a {
            position: relative;
            color: #fff;
            font-size: 20px;
            font-weight: 500;
            padding: 6px 0;
            text-decoration: none;
<<<<<<< HEAD
            margin-left: 30px;
            padding: 60px;
            display: flex;
            align-items: center;
        }

        .topbar .topbar-menu .fa {
            margin-right: 5px; /* Space between icon and text */
=======
        }
        .nav-links li a:before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            width: 0%;
            background: #34efdf;
            border-radius: 12px;
            transition: all 0.4s ease;
        }
        .nav-links li a:hover:before {
            width: 100%;
        }
        .nav-links li.center a:before {
            left: 50%;
            transform: translateX(-50%);
        }
        .nav-links li.upward a:before {
            width: 100%;
            bottom: -5px;
            opacity: 0;
        }
        .nav-links li.upward a:hover:before {
            bottom: 0px;
            opacity: 1;
        }
        .nav-links li.forward a:before {
            width: 100%;
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.4s ease;
        }
        .nav-links li.forward a:hover:before {
            transform: scaleX(1);
            transform-origin: left;
        }
        .right-icons {
            display: flex;
            align-items: center;
        }
        .right-icons button, .right-icons .notification-icon {
            color: #fff;
            font-size: 20px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            background: none;
            padding: 6px 0;
            display: flex;
            align-items: center;
            margin-left: 20px;
        }
        .right-icons button i, .right-icons .notification-icon i {
            margin-right: 8px;
        }
        .hamburger-menu {
            display: none;
            font-size: 28px;
            cursor: pointer;
        }
        .content {
            margin-top: 80px; /* Adjust based on the height of your navbar */
            padding: 20px;
        }
        section {
            display: none; /* Hide all sections by default */
            padding: 20px;
            margin-bottom: 40px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.2);
        }
        section.active {
            display: block; /* Show only the active section */
        }
        @media (max-width: 768px) {
            .nav-links {
                display: none;
                flex-direction: column;
                width: 100%;
            }
            .nav-links li {
                margin: 10px 0;
            }
            .nav-links.active {
                display: flex;
            }
            .hamburger-menu {
                display: block;
            }
>>>>>>> 338cc41baf20f40be0953b24b32df9d486bf1981
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
            color: black;
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
<<<<<<< HEAD
    <div class="topbar">
        <div class="topbar-brand">MCC Document Tracker</div>
        <div class="topbar-menu">
            <a href="login.php" class="logout" onclick="confirmLogout(event)">
                <i class="fa fa-power-off"></i> Logout<br>
                <?php echo $_SESSION['fullname']; ?>
            </a>
        </div>
    </div>
=======
    <div class="navbar">
        <div class="hamburger-menu"><i class="fas fa-bars"></i></div>
        <ul class="nav-links">
            <li><a href="home.php" class="nav-link" data-target="home">Home</a></li>
            <li class="center"><a href="#request-form" class="nav-link" data-target="request-form" data-file="request_form.php">Request Form</a></li>
            <li class="upward"><a href="#status-request" class="nav-link" data-target="status-request" data-file="receive_form.php">Status Request</a></li>
            <li class="forward"><a href="#user-details" class="nav-link" data-target="user-details" data-file="user_details.php">User Details</a></li>
        </ul>
        <div class="right-icons">
            <div class="notification-icon"><i class="fas fa-bell"></i></div>
            <button class="logout-button" id="logout-button"><i class="fas fa-sign-out-alt"></i><?php echo $_SESSION['fullname'] ?> </button>
        </div>
    </div>

    <div class="content">
        <section id="home" class="active">
            <h2>Home</h2>
            <div class="section-content"></div>
        </section>
        <section id="request-form">
            <h2>Request Form</h2>
            <div class="section-content"></div>
        </section>
        <section id="status-request">
            <h2>Status Request</h2>
            <div class="section-content"></div>
        </section>
        <section id="user-details">
            <h2>User Details</h2>
            <div class="section-content"></div>
        </section>
    </div>

    <script>
        $(document).ready(function(){
            $('.nav-link').on('click', function(e){
                e.preventDefault();
                var target = $(this).data('target');
                var file = $(this).data('file');

                // Hide all sections
                $('section').removeClass('active');

                // Show the target section
                $('#' + target).addClass('active');

                // Clear the section content before loading new content
                $('#' + target + ' .section-content').empty();

                // Load the file content if file attribute is present
                if(file){
                    $('#' + target + ' .section-content').load(file);
                }

                // Scroll to the target section
                $('html, body').animate({
                    scrollTop: $('#' + target).offset().top
                }, 800);

                // Close the menu if in mobile view
                if ($(window).width() <= 768) {
                    $('.nav-links').removeClass('active');
                }
            });

            $('#logout-button').on('click', function(){
                Swal.fire({
                    title: 'Are you sure you want to logout?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, logout!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Perform logout action here, e.g., redirect to logout PHP script
                        window.location.href = 'login.php';
                    }
                });
            });

            $('.hamburger-menu').on('click', function() {
                $('.nav-links').toggleClass('active');
            });
        });
    </script>
>>>>>>> 338cc41baf20f40be0953b24b32df9d486bf1981
</body>
</html>
