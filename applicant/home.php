<?php
session_start();

if(!isset($_SESSION['email']))
header('location:login.php');
?>



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

