<?php
// Define variables and set to empty values
$nameErr = $emailErr = $phoneErr = $messageErr = "";
$name = $email = $phone = $message = "";

// Function to clean input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 验证名字
    if (empty($_POST["name"])) {
        $nameErr = "Need to insert name";
    } else {
        $name = test_input($_POST["name"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
            $nameErr = "Only for alpha and space";
        }
    }
    
    // Validate email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }
    
    // Validate phone number
    if (empty($_POST["phone_number"])) {
        $phoneErr = "Phone number is required";
    } else {
        $phone = test_input($_POST["phone_number"]);
        if (!preg_match("/^[0-9]{10}$/",$phone)) {
            $phoneErr = "Invalid phone number format";
        }
    }
    
    // Validate message
    if (empty($_POST["message"])) {
        $messageErr = "Message is required";
    } else {
        $message = test_input($_POST["message"]);
    }
    
    // If no errors, save to database
      if (empty($nameErr) && empty($emailErr) && empty($phoneErr) && empty($messageErr)) {
        // Database connection information
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "gradgala";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare SQL statement
        $sql = "INSERT INTO feedback (feedback_username, feedback_useremail, feedback_phonenumber, feedback_description) VALUES (?, ?, ?, ?)";
        
        // Prepare and bind
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $name, $email, $phone, $message);

           // 在执行之前，检查所有变量是否都有值
        if (!empty($name) && !empty($email) && !empty($phone) && !empty($message)) {

        // Execute statement
         if ($stmt->execute()) {
                $successMessage = "Thank you for your message. We'll get back to you soon!";
        } else {
            $errorMessage = "Sorry! There was a problem. Please try again later. Error: " . $stmt->error;
         }
        // Close statement and connection
        $stmt->close();
        $conn->close();
    }
}
      }

?>

<!--PHP END HERE-->

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="description" content="hehe">
    <meta name="keywords" content="HTML, CSS, JavaScript">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONTACT US</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/mystyle.css" rel="stylesheet">
    <link href="css/all.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Didact+Gothic&family=Jost:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/20b1307a62.js" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Section for Content starts here -->
    <div class="container-fluid">
        <header class="row pb-4 bg-main" style="padding: 20px">
            <div class="col-md-6 col-lg-6 d-flex align-items-center">
                <a href="home.html">
                    <img src="image/logo/gradgala_logo.png" style="width:auto;height:60px;">
                </a>
            </div>
            <nav class="col-md-6 col-lg-6">
                <div class="ms-auto d-flex justify-content-end align-items-center" style="height:100px;">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="home.html">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="sub/about_us.html">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="sub/explore.html">Explore</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="sub/contact_us.html">Contact Us</a>
                        </li>
                    </ul>
                    <button class="sign-button">
                        <img src="image/icon/Profile%20Circle%202.png" class="w-20"> Log In
                    </button>
                </div>
            </nav>
        </header>
    </div>

    <div class="row">
        <div class="col text-center pt-5">
            <h2>CONTACT US</h2>
        </div>
    </div>
    <link rel="stylesheet" type="text/css" href="css/shape_style.css">
    <div class="container">
        <?php
    if (isset($successMessage)) {
        echo "<p style='color: green;'>$successMessage</p>";
    } elseif (isset($errorMessage)) {
        echo "<p style='color: red;'>$errorMessage</p>";
    }
    ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            <span class="error"><?php echo $nameErr; ?></span>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            <span class="error"><?php echo $emailErr; ?></span>

            <label for="phone_number">Phone Number</label>
            <input type="tel" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($phone); ?>" required>
            <span class="error"><?php echo $phoneErr; ?></span>

            <label for="message">Feedback</label>
            <textarea id="message" name="message" required><?php echo htmlspecialchars($message); ?></textarea>
            <span class="error"><?php echo $messageErr; ?></span>

            <input type="submit" value="Submit" id="button">
        </form>


        <div class="row">
            <div class="col text-center">
                <h5>Apply Your Account Here ↓ </h5>
            </div>
        </div>
        <link rel="stylesheet" type="text/css" href="css/shape_style.css">
        <button class="register-button" button type="button" onclick="location.href='https://forms.gle/cBcCuTyzAYnvaLRo9'">
            Register
        </button>
        <br>
    </div>






    <footer class="row pb-4 bg-main" style="padding: 20px">
        <!-- Section for Content starts here -->
        <div class="container-fluid justify-content-left">
            <a href="home.html">
                <img src="image/logo/gradgala_logo.png" style="width:auto;height:60px;">
            </a>
        </div>
        <div class="container-fluid col-md-7 col-lg-7 justify-content-left" style="padding-top: 30px;">
            <ul class="nav justify-content-left">
                <li style="padding-right: 30px;">
                    <a href="home.html" target="_blank">
                        <h4>Home</h4>
                        <p class="didact-gothic-regular">Return to Homepage</p>
                    </a>
                </li>
                <li style="padding-right: 30px;">
                    <a href="aboutus.html" target="_blank">
                        <h4>About Us</h4>
                        <a href="aboutus.html#objectives" target="_blank">
                            <p class="didact-gothic-regular">Objectives</p>
                        </a>
                        <a href="aboutus.html#vision" target="_blank">
                            <p class="didact-gothic-regular">Vision</p>
                        </a>
                        <a href="aboutus.html#mission" target="_blank">
                            <p class="didact-gothic-regular">Mission</p>
                        </a>
                        <a href="aboutus.html#background" target="_blank">
                            <p class="didact-gothic-regular">Background</p>
                        </a>
                    </a>
                </li>
                <li style="padding-right: 30px;">
                    <a href="sub/explore.html" target="_blank">
                        <h4>Explore</h4>
                    </a>
                    <a href="sub/animation.html" target="_blank">
                        <p class="didact-gothic-regular">Animation</p>
                    </a>
                    <a href="sub/visualcomm.html" target="_blank">
                        <p class="didact-gothic-regular">Visual Comm</p>
                    </a>
                    <a href="sub/film.html" target="_blank">
                        <p class="didact-gothic-regular">Film</p>
                    </a>
                </li>
                <li style="padding-right: 30px;">
                    <a href="contact_us.html" target="_blank">
                        <h4>Contact/Visit Us</h4>
                        <p class="didact-gothic-regular">Working Hours:</p>
                        <p class="didact-gothic-regular">Mon - Fri: 9 a.m. - 5 p.m.</p>
                        <p class="didact-gothic-regular">Email: Gradgala@gmail.com</p>
                    </a>
                </li>
            </ul>
        </div>
        <div class="container-fluid col-md-5 col-lg-5" style="padding-top: 30px;">
            <h4>Location</h4>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15934.333043276549!2d101.71268429735204!3d3.203597498345196!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc3843bfb6a031%3A0x2dc5e067aae3ab84!2sTunku%20Abdul%20Rahman%20University%20of%20Management%20and%20Technology%20(TAR%20UMT)!5e0!3m2!1sen!2smy!4v1726569313355!5m2!1sen!2smy" width="400" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
        <div style="font-size:40px;">
            <a href="https://www.instagram.com/tarumt.official/" target="_blank">
                <i class="fa-brands fa-square-instagram" style="padding-right: 10px;"></i>
            </a>
            <a href="https://api.whatsapp.com/send?phone=601110843326" target="_blank">
                <i class="fa-brands fa-square-whatsapp" style="padding-right: 10px;"></i>
            </a>
            <a href="https://www.facebook.com/tarumtkl/?locale=ms_MY" target="_blank">
                <i class="fa-brands fa-square-facebook" style="padding-right: 10px;"></i>
            </a>
        </div>
        <div>
            <h8>GRADGALA © 2024 <h8 style="padding-left: 20px;">Privacy Policy | Terms of Use</h8>
            </h8>
        </div>
    </footer>
</body>

</html>
