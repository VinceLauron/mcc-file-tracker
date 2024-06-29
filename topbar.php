<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>MCC FILE AND DOCUMENT TRACKER</title>

  <style>
    .logo {
      margin: auto;
      font-size: 20px;
      background: white;
      padding: 5px 11px;
      border-radius: 50%;
      color: #000000b3;
    }
    .mcc {
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      flex: 1;
      text-align: center;
      font-size: 1.2rem;
    }
    .navbar {
      padding: 0;
    }
    .navbar-content {
      display: flex;
      align-items: center;
      justify-content: space-between;
      width: 100%;
    }
    .navbar .container-fluid {
      display: flex;
      align-items: center;
    }
    .navbar .container-fluid > div {
      display: flex;
      align-items: center;
    }
    .navbar .container-fluid .col-md-1 img {
      width: 70px;
    }
    .navbar .container-fluid .col-md-2 {
      justify-content: flex-end;
    }
    .navbar .container-fluid .col-md-2 a {
      color: white;
      font-size: 1rem;
    }
  </style>
</head>

<body>

  <nav class="navbar navbar-dark bg-success fixed-top">
    <div class="container-fluid mt-2 mb-2 navbar-content">
      <div class="col-md-1">
        <img src="img/mcc1.png" alt="MCC Logo">
      </div>
      <div class="mcc">
        <p>MADRIDEJOS COMMUNITY COLLEGE FILE AND DOCUMENT TRACKER</p>
      </div>
      <div class="col-md-2">
        <a class="text-light" href="ajax.php?action=logout"><?php echo $_SESSION['login_name'] ?> <i class="fa fa-power-off"></i></a>
      </div>
    </div>
  </nav>

</body>

</html>
   