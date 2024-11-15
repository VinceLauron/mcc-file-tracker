<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="img/mcc1.png" type="">

  <title>MCC DOCUMENT TRACKER </title>

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="radiance/css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

  <!--owl slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

  <!-- font awesome style -->
  <link href="radiance/css/font-awesome.min.css" rel="stylesheet" />

  <!-- Custom styles for this template -->
  <link href="radiance/css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="radiance/css/responsive.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
 /* Make the header section sticky on scroll */
.header_section {
  position: sticky;
  top: 0;
  width: 100%;
  z-index: 1000;
  background-color: darkblue;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  padding: 10px 20px;
}

.navbar-nav .nav-item-spacing {
  position: relative; /* For the hover effect */
  text-decoration: none;
  color: blue; /* Customize link color */
  font-size: 14px; /* Adjust the font size */
  margin-right: 0; /* Reduce spacing between links */
}

.navbar-nav .nav-item-spacing:hover {
  text-decoration: none;
  color: #007bff; /* Change color on hover */
}

.navbar-nav .nav-item-spacing::after {
  content: "";
  display: block;
  width: 0;
  height: 2px;
  background-color: #007bff; /* Line color */
  transition: width 0.3s ease; /* Smooth animation */
  position: absolute;
  bottom: -3px; /* Position the line below the text */
  left: 0;
}

.navbar-nav .nav-item-spacing:hover::after {
  width: 100%; /* Line expands fully on hover */
}


</style>
</head>

<body>

  <div class="hero_area">
    <div class="hero_bg_box">
      <div class="bg_img_box">
        <img src="radiance/images/hero-bg.png" alt="">
      </div>
    </div>

    <!-- header section strats -->
    <header class="header_section">
  <div class="container-fluid">
    <nav class="navbar navbar-expand-lg custom_nav-container">
      <a class="navbar-brand" href="index.php">
        <span>MCC DOCUMENT TRACKER</span>
      </a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
  <ul class="navbar-nav">
    <li class="nav-item active">
      <a class="nav-link nav-item-spacing" href="index.php">Home <span class="sr-only">(current)</span></a>
    </li>
    <li class="nav-item">
      <a href="https://mccalumnitracker.com" class="nav-link nav-item-spacing" target="_blank">Alumni Tracker</a>
    </li>
    <li class="nav-item">
      <a href="help.php" class="nav-link nav-item-spacing" target="_blank">Help Center</a>
    </li>
    <li class="nav-item">
        <a id="reminders-link" href="javascript:void(0);" class="nav-link nav-item-spacing">Reminders for Requesters</a>
      </li>
      <li class="nav-item">
        <a id="dosdonts-link" href="javascript:void(0);" class="nav-link nav-item-spacing">Do's and Don'ts</a>
      </li>

  </ul>
  <form class="form-inline">
    <button class="btn my-2 my-sm-0 nav_search-btn" type="submit">
      <i class="fa fa-search" aria-hidden="true"></i>
    </button>
  </form>
</div>

    </nav>
  </div>
</header>


    <!-- end header section -->
     
    <!-- slider section -->
    <section class="slider_section ">
      <div id="customCarousel1" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="container ">
              <div class="row">
                <div class="col-md-6 ">
                  <div class="detail-box">
                    <h1>
                      MADRIDEJOS COMMUNITY <br>
                      COLLEGE
                    </h1>
                    <p>
                    is a higher education institution located in Bunakan, Madridejos, a municipality in the province of Cebu, Philippines. The college was established to provide accessible and affordable education to the local community, focusing on developing skilled professionals who can contribute to the region's socioeconomic growth.
                    </p>
                    <div class="btn-box">
                      <a href="applicant/login.php" class="btn1">
                        REQUEST DOCUMENT
                      </a>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="img-box">
                    <img src="img/Madridejos.jpg" alt="">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="carousel-item ">
            <div class="container ">
              <div class="row">
                <div class="col-md-6 ">
                  <div class="detail-box">
                    <h1>
                    MADRIDEJOS COMMUNITY <br>
                    COLLEGE
                    </h1>
                    <p>
                    is a higher education institution located in Bunakan, Madridejos, a municipality in the province of Cebu, Philippines. The college was established to provide accessible and affordable education to the local community, focusing on developing skilled professionals who can contribute to the region's socioeconomic growth.
                    </p>
                    <div class="btn-box">
                      <a href="applicant/login.php" class="btn1">
                      REQUEST DOCUMENT
                      </a>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="img-box">
                  <img src="img/Madridejos.jpg" alt="">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="container ">
              <div class="row">
                <div class="col-md-6 ">
                  <div class="detail-box">
                    <h1>
                    MADRIDEJOS COMMUNITY <br>
                    COLLEGE
                    </h1>
                    <p>
                    is a higher education institution located in Bunakan, Madridejos, a municipality in the province of Cebu, Philippines. The college was established to provide accessible and affordable education to the local community, focusing on developing skilled professionals who can contribute to the region's socioeconomic growth.
                    </p>
                    <div class="btn-box">
                      <a href="applicant/login.php" class="btn1">
                      REQUEST DOCUMENT
                      </a>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="img-box">
                  <img src="img/Madridejos.jpg" alt="">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <ol class="carousel-indicators">
          <li data-target="#customCarousel1" data-slide-to="0" class="active"></li>
          <li data-target="#customCarousel1" data-slide-to="1"></li>
          <li data-target="#customCarousel1" data-slide-to="2"></li>
        </ol>
      </div>

    </section>
    <!-- end slider section -->
  </div>

  <!-- why section -->

  <section class="why_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
        MADRIDEJOS COMMUNIY COLLEGE <span>CORE VALUES</span>
        </h2>
      </div>
      <div class="why_container">
        <div class="box">
          <div class="img-box">
            <img src="img/Madridejos.jpg" alt="">
          </div>
          <div class="detail-box">
            <h5>
            Madridejos Community College Vision Statement:
            </h5>
            <p>
            The Madridejos Community College envisions a society comprised of fully competent individuals with benevolent character innovative, service-oriented, and highly empowered to meet and exceed challenges as proactive participants in shaping our world's future.
            </p>
          </div>
        </div>
        <div class="box">
          <div class="img-box">
            <img src="img/Madridejos.jpg" alt="">
          </div>
          <div class="detail-box">
            <h5>
            Madridejos Community College Mission Statement:
            </h5>
            <p>
            Madridejos Community College is a safe, accessible, and affordable learning environment that aims to foster academic and career success through development of critical thinking, creativity, informed research, and social responsibility. Our mission is to deliver academic programs that are timely, appropriate, and transformative in response to the demands of local, national, and international communities in a highly dynamic world.
            </p>
          </div>
        </div>
        <div class="box">
          <div class="img-box">
            <img src="img/Madridejos.jpg" alt="">
          </div>
          <div class="detail-box">
            <h5>
            Madridejos Community College Goals:
            </h5>
            <p>
            Develop globally competitive, value-laden professionals capable of making a positive social, environmental, and economic impact through research and community service.<br><br>
                              Learning Enhancement and Support. Foster student learning and support by leveraging student strengths and meeting their specific needs through targeted success pathways. <br><br>
                              Adaptive to change through innovation. Create an environment that encourages learners to be more innovative and resilient in order to adapt to today's highly dynamic world. <br><br>
                              Well-grounded in research. Conduct extensive research based on facts and sound reasoning to expand the learner's knowledge, promote effective learning, comprehend different concerns and trends, seek the truth, and identify opportunities that lie ahead. <br><br>
                              Inculcate moral values. Instill positive attitudes and high moral virtues towards daily activities in and outside the school. <br><br>
                              Social Responsibility. Ensure the relevance, alignment and support of the community and businesses by providing outreach, bridge programs, and community-focused facilities.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end why section -->

  <!-- team section -->
  <section class="team_section layout_padding">
    <div class="container-fluid">
      <div class="heading_container heading_center">
        <h2 class="">
          Our <span> Team</span>
        </h2>
      </div>

      <div class="team_container">
        <div class="row">
          <div class="col-lg-3 col-sm-6">
            <div class="box ">
              <div class="img-box">
                <img src="img/user.png" class="img1" alt="">
              </div>
              <div class="detail-box">
                <h5>
                  Vince Simuelle Lauron
                </h5>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-sm-6">
            <div class="box ">
              <div class="img-box">
                <img src="img/user.png" class="img1" alt="">
              </div>
              <div class="detail-box">
                <h5>
                  Bryan James Desuyo
                </h5>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-sm-6">
            <div class="box ">
              <div class="img-box">
                <img src="img/user.png" class="img1" alt="">
              </div>
              <div class="detail-box">
                <h5>
                  Argie Magallanes
                </h5>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-sm-6">
            <div class="box ">
              <div class="img-box">
                <img src="img/user.png" class="img1" alt="">
              </div>
              <div class="detail-box">
                <h5>
                 Arabela Villarosa
                </h5>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end team section -->

  <!-- info section -->

  <section class="info_section layout_padding2">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-lg-3 info_col">
          <div class="info_contact">
            <h4>
              Address
            </h4>
            <div class="contact_link_box">
              <a href="">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                <span>
                  Bunakan,Madridejos,Cebu
                </span>
              </a>
              <a href="">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <span>
                  Call +63 9345 789 0987
                </span>
              </a>
              <a href="">
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <span>
                  mccdocumenttracker@gmail.com
                </span>
              </a>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3 info_col">
          <div class="info_detail">
            <h4>
              Info
            </h4>
            <p>
              it can be easy to request through this website
            </p>
          </div>
        </div>
        <div class="col-md-6 col-lg-2 mx-auto info_col">
          <div class="info_link_box">
            <h4>
              Links
            </h4>
            <div class="info_links">
              <a class="active" href="index.php">
                Home
              </a>
              <a class="" href="login.php">
                Login
              </a>
              <a class="" href="applicant/login.php" >
                SIgn In as Applicant
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end info section -->

  <!-- footer section -->
  <section class="footer_section">
    <div class="container">
      <p>
        &copy; <span id="displayYear"></span> All Rights Reserved By
        <a href="index.php">Madridejos Community College -Designed By Vince Simuelle Lauron</a>
      </p>
    </div>
  </section>
  <!-- footer section -->

  <!-- jQery -->
  <script type="text/javascript" src="radiance/js/jquery-3.4.1.min.js"></script>
  <!-- popper js -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
  </script>
  <!-- bootstrap js -->
  <script type="text/javascript" src="radiance/js/bootstrap.js"></script>
  <!-- owl slider -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
  </script>
  <!-- custom js -->
  <script type="text/javascript" src="radiance/js/custom.js"></script>
  <!-- Google Map -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap">
  </script>
  <!-- End Google Map -->
</body>
<script>
  // Handle "Reminders for Requesters" click
  document.getElementById('reminders-link').addEventListener('click', function () {
    Swal.fire({
      title: 'Reminders for Requesters',
      html: `
        <ul style="text-align: left;">
          <li>Submit complete documents to avoid delays.</li>
          <li>Follow up only after the processing period.</li>
          <li>Ensure all payments are settled beforehand.</li>
          <li>Check your email for updates on your request.</li>
          <li>The parent or guardian may be able to claim the desired document if the requester is unable to do so; however, they must bring the following documents.</li>
          <li>Bring Valid Id or any valid documents that you are relatives to requester or authentication letter(signature) and Waiver.</li>
          <li>For payment fees of the documents please proceed to the cashier.</li>
        </ul>
      `,
      icon: 'info',
      confirmButtonText: 'Got it!',
    });
  });

  // Handle "Do's and Don'ts" click
  document.getElementById('dosdonts-link').addEventListener('click', function () {
    Swal.fire({
      title: "Do's and Don'ts",
      html: `
        <ul style="text-align: left;">
          <li><strong>Do's:</strong></li>
          <ul>
            <li>Sign in to Alumni Tracker to proceed sign up form of the requesting document.</li>
            <li>Provide accurate information on forms.</li>
            <li>Respect the processing timeline.</li>
            <li>Ask questions if unsure about the process.</li>
            <li>Submit all the requirements if needed.</li>
            <li>Try to read Terms and Conditions, Do's and Don'ts for the clear instructions.</li>
            <li>Don't click the link if you are already Alumni it is for Transferes and Non-Graduates students only.</li>
          </ul>
          <li><strong>Don'ts:</strong></li>
          <ul>
            <li>Do not submit fake or tampered documents.</li>
            <li>Do not harass staff for expedited processing.</li>
            <li>Do not share your credentials with others.</li>
          </ul>
      `,
      icon: 'warning',
      confirmButtonText: 'Understood',
    });
  });
</script>

</html>