<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/mcc1.png" type="image/x-icon" />

    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="assets/style2.css">
     
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

   <title>MCC DOCUMENT TRACKER</title>
</head>
<body>
    <div class="container">
        <header>Registration</header>

        <form action="register.php" method="POST" id="registration-form">
            <div class="form first">
                <div class="details personal">
                    <span class="title">Personal Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Full Name</label>
                            <input type="text" name="fullname" placeholder="Enter your name" required>
                        </div>

                        <div class="input-field">
                            <label>Date of Birth</label>
                            <input type="date" name="dob" placeholder="Enter birth date" required>
                        </div>

                        <div class="input-field">
                            <label>Email</label>
                            <input type="email" name="email" placeholder="Enter your email" required>
                        </div>

                        <div class="input-field">
                            <label>Mobile Number</label>
                            <input type="text" name="contact" placeholder="Enter mobile number" required>
                        </div>

                        <div class="input-field">
                            <label>Gender</label>
                            <select name="sex" required>
                                <option disabled selected>Select gender</option>
                                <option>Male</option>
                                <option>Female</option>
                                <option>Others</option>
                            </select>
                        </div>

                        <div class="input-field">
                            <label>Occupation</label>
                            <input type="text" name="occupation" placeholder="Enter your occupation" required>
                        </div>
                    </div>
                </div>

                <div class="details ID">
                    <span class="title">Identity Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>ID Number</label>
                            <input type="text" name="id_number" placeholder="Enter School ID number" required>
                        </div>

                        <div class="input-field">
                            <label>Year Graduated</label>
                            <input type="text" name="year_graduated" placeholder="Enter Year Graduated" required>
                        </div>

                        <div class="input-field">
                            <label>School Graduated</label>
                            <input type="text" name="school_graduated" placeholder="Enter School Name" required>
                        </div>

                        <div class="input-field">
                            <label>Address Type</label>
                            <input type="text" name="address" placeholder="Permanent or Temporary" required>
                        </div>

                        <div class="input-field">
                            <label>Nationality</label>
                            <input type="text" name="nationality" placeholder="Enter nationality" required>
                        </div>

                        <div class="input-field">
                            <label>Postal Code</label>
                            <input type="text" name="postal" placeholder="Enter Postal Code" required>
                        </div>
                    </div>

                    <div class="buttons">
                        <div class="backBtn">
                            <i class="uil uil-navigator"></i>
                            <a href="login.php"> <span style="color: white;" class="btnText">Back</span></a>
                        </div>
                        
                        <button type="submit" class="submit">
                            <span class="btnText">Submit</span>
                            <i class="uil uil-navigator"></i>
                        </button>
                       
                    </div> 
                </div>
            </div>
        </form>
    </div>
</body>
</html>
