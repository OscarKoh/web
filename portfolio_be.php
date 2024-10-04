<?php 
$message = "";

session_start();

/*if(!isset($user)) {
    header("Location: login.php");
}*/

$user = $_SESSION["userid"];


//1)Make connection to the database
include_once "common/connection.php";
    
// 1)Get user ID from url bar
//$user_id = $_GET['user_id'];

//2)Prepare SQL statement to user select records user record based on user id from URL file
$select_user = $connection->prepare("SELECT account.account_name, user_profile.user_picture FROM account INNER JOIN user_profile ON account.account_id = user_profile.account_id WHERE account.account_id = ?");

//3)Execute the SQL statement
$select_user->execute([$user]);

//4)Fetch the data selected from the SQL statement
$result = $select_user->fetch();

if($result){
    $user_name = $result["account_name"];
    $user_img = $result["user_picture"];
}


if(isset($_POST["submit"])){
    
    $category = $_POST['category'];
    $title = $_POST['title'];
    $desc = $_POST['desc'];

    //1) Set location to upload file on the server
    $target_folder = "uploads/";
    
    //2) Check if user browsed to a file to upload or not
    if(empty($_FILES['upload_file']['name'])){
        $message = "Please select a file to upload";
        
    }
    else{
        //3) Set allowed file types
        $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');
        
        //4) Set the full path to the file to be uploaded to the server. E.G. upload/anxion.jpg
        $target_path = $target_folder . basename($_FILES['upload_file']['name']);
        
        //5) Get the file extension of the file you want to upload
        $file_ext = strtolower(pathinfo($target_path, PATHINFO_EXTENSION));
        
        //6) Check whether file to be uploaded is allowed of not
        if(in_array($file_ext, $allowed_ext)) {
            //7) Upload the file
            if(move_uploaded_file($_FILES['upload_file']['tmp_name'], $target_path)) {
                //Make connection to the database
                include_once "common/connection.php";
                
                //insert the image record into the table
                $insert_sql = $connection->prepare('INSERT INTO portfolio(account_id, portfolio_title, portfolio_description, category_name, portfolio_img) VAlUE(?, ?, ?, ?, ?)');
                
                //Run or execute the SQL statement 
                $result_insert = $insert_sql->execute([$user, $title, $desc, $category, $target_path]);
                
                $message = "Uploaded File Successfully";
            }
            else{
                $message = "Fail to Upload File";
            }
        }
        else{
            $message = "Please select only image file";
        }   
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="description" content="hehe">
    <meta name="keywords" content="HTML, CSS, JavaScript">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRADGALA</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/mystyle.css" rel="stylesheet">
    <link href="css/jingxuan.css" rel="stylesheet">
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

    <body>
        <div class="row w-75 mx-auto pt-5">
            <div class="col-md-4 bg-white">
                <img src="<?php echo $user_img; ?>" class="w-60">
                <p><?php echo $user_name; ?></p>
            </div>

            <div class="col-md-8 bg-white">
                <div class="col poppins-bold">
                    <a href="profile_be.php">PROFILE</a> | <a href="portfolio_be.php">ARTWORK</a>
                </div>

                <form action="" method="post" enctype="multipart/form-data">
                    <br>
                    <div class="form-group">
                        <label for="title">Artwork Title:</label>
                        <textarea class="form-control" rows="1" id="title" name="title" placeholder="Put in your artwork title"></textarea>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="desc">Description:</label>
                        <textarea class="form-control" rows="5" id="desc" name="desc" placeholder="Fill in your artwork description here"></textarea>
                    </div>
                    <br>
                    <p>Category:</p>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="animation" name="category" value="Animation">
                        <label class="form-check-label" for="animation">Animation</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="visual_communication" name="category" value="Visual Communication">
                        <label class="form-check-label" for="visual_communication">Visual Communication</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="film" name="category" value="Film">
                        <label class="form-check-label" for="film">Film</label>
                    </div>
                    <br>
                    <div>
                        <label for="upload">Main Artwork</label>
                        <input type="file" name="upload_file" id="" class="form-control" placeholder="Upload Your Main Artwork">
                    </div>
                    <br>
                    <input type="submit" value="Submit" class="btn btn-dark" name="submit">
                    <p><?php echo $message; ?></p>
                </form>
                <br>
                <br>
            </div>

        </div>
    </body>


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
