<?php
session_start();

// CHECK ADMIN LOGIN
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit;
}

// DATABASE CONNECT
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gradgala";

// CREATE CONNECTION
$conn = new mysqli($servername, $username, $password, $dbname);

// CHECK CONNECTION
if ($conn->connect_error) {
    die("connection failed: " . $conn->connect_error);
}

// PROCESS OF DELETE FEEDBACK
if (isset($_POST['delete_feedback'])) {
    $feedback_id = $_POST['feedback_id'];
    $sql = "DELETE FROM feedback WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $feedback_id);
    $stmt->execute();
    $stmt->close();
}

// GET FEEDBACK FORM
$sql = "SELECT * FROM feedback ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!--PHP END HERE-->

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="description" content="hehe">
    <meta name="keywords" content="HTML, CSS, JavaScript">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FEEDBACK COLLECTION</title>
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

    <!--FEEDBACK COLLECTION SECTION-->
    <link href="css/shape_style.css" rel="stylesheet">

    <!--FEEDBACK COLLECTION START HERE-->
    <section class="row">
        <h2 class="col text-center pt-5">Feedback Collection</h2>
    </section>

    <div class="row bg-feedback-dark-blue p-3 rounded" role="table" aria-label="Feedback List">
        <div class="col-md-3 text-center text-white" role="columnheader"><strong>Name</strong></div>
        <div class="col-md-3 text-center text-white" role="columnheader"><strong>Email</strong></div>
        <div class="col-md-3 text-center text-white" role="columnheader"><strong>Comment</strong></div>
        <div class="col-md-3 text-center text-white" role="columnheader"><strong>Action</strong></div>

        <div class="col-12 mt-3" role="rowgroup">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='bg-white p-3 rounded shadow mb-3' role='row'>";
                    echo "<article class='row py-2 border-bottom'>";
                    echo "<div class='col-md-3 text-center text-black'>" . htmlspecialchars($row["name"]) . "</div>";
                    echo "<div class='col-md-3 text-center text-black'>" . htmlspecialchars($row["email"]) . "</div>";
                    echo "<div class='col-md-3 text-center text-black'>";
                    echo "<div class='bg-light p-2 rounded text-black'>" . htmlspecialchars($row["comment"]) . "</div>";
                    echo "</div>";
                    echo "<div class='col-md-3 text-center'>";
                    echo "<div class='d-flex flex-column align-items-center'>";
                    echo "<form method='post'>";
                    echo "<input type='hidden' name='feedback_id' value='" . $row["id"] . "'>";
                    echo "<button type='submit' name='delete_feedback' class='btn btn-sm btn-danger mb-2' aria-label='Delete Feedback'>Delete</button>";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                    echo "</article>";
                    echo "</div>";
                }
            } else {
                echo "<div class='col-12 text-center text-white'>No Feedback Yet</div>";
            }
            ?>
        </div>
    </div>

    <!--FEEDBACK COLLECTION END HERE-->

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

<?php
$conn->close();
?>
