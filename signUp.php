<?php
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

$message = "";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['account_email'];
    $username = $_POST['account_name'];
    $password = $_POST['account_password'];
    
    // Simple password validation
    if (strlen($password) < 8) {
        $message = "Password must be at least 8 characters long";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL statement
        $sql = "INSERT INTO account (account_name, account_email, account_password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        // Execute the statement
        if ($stmt->execute()) {
            $message = "Registration successful!";
            // You can add redirection to login page here
            // header("Location: login.php");
            // exit();
        } else {
            $message = "Registration failed: " . $conn->error;
        }

        // Close statement and connection
        $stmt->close();
    }
    $conn->close();
} else {
    $message = "Please fill out the form below to register.";
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
    <title>GRADGALA - Sign Up</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/tricia.css.css" rel="stylesheet">
    <link href="css/signup.css" rel="stylesheet">
    <link href="css/all.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Didact+Gothic&family=Jost:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/20b1307a62.js" crossorigin="anonymous"></script>
    <link href="css/all.css" rel="stylesheet">
    <link href="css/signUp.css" rel="stylesheet">
    <style>
        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .error {
            color: red;
            margin-bottom: 1rem;
        }

        .success {
            color: green;
            margin-bottom: 1rem;
        }

        .requirements {
            font-size: 0.8rem;
            margin-bottom: 1rem;
            text-align: left;
        }

        .requirement {
            color: red;
        }

        .requirement.met {
            color: green;
        }
    </style>
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
<!-- ... 前面的HTML代码保持不变 ... -->

  <!-- Registration form -->
    <div class="signUp-fluid d-flex align-items-center justify-content-center" style="min-height: 70vh; background-size: cover; background-color: rgba(0, 0, 0, 1.0); z-index: 1;">
        <?php if($message): ?>
            <div class="alert <?php echo strpos($message, 'successful') !== false ? 'alert-success' : 'alert-danger'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <form id="signup-form" action="signUp.php" method="POST">
            <h2>Register Admin</h2>
            <div class="input-field">
                <input type="email" id="account_email" name="account_email" required>
                <label>Email</label>
            </div>
            <div class="input-field">
                <input type="text" id="account_name" name="account_name" required>
                <label>Username</label>
            </div>
            <div class="input-field">
                <div class="password-container">
                    <input type="password" id="account_password" name="account_password" required>
                    <label>Password</label>
                </div>
            </div>
            <p>Already have an account? <a href="#">Login Now</a></p>
            <button type="submit">Register</button>
        </form>
    </div>


<!-- ... 后面的HTML代码保持不变 ... -->




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
                    <a href="contactus.html" target="_blank">
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
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15934.333043276549!2d101.71268429735204!3d3.203597498345196!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc3843bfb6a031%3A0x2dc5e067aae3ab84!2sTunku%20Abdul%20Rahman%20University%20of%20Management%20and%20Technology%20(TAR%20UMT)!5e0!3m2!1sen!2smy!4v1726569313355!5m2!1sen!2smy"
                width="400" height="250" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
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
