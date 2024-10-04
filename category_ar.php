<?php 
 	try { 
 		$connection = new PDO('mysql:host=localhost;dbname=gradgala','root',''); 
	} 
	catch (PDOException $e) { 
 		echo $e->getMessage(); 
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
	<link href="css/tricia.css.css" rel="stylesheet">
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
						<a class="nav-link" href="about_us.html">About Us</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="explore.html">Explore</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="contact_us.html">Contact Us</a>
					</li>
				</ul>
				<button class="sign-button">
					<img src="image/icon/Profile%20Circle%202.png" class="w-20"> Log In
				</button>
			</div>
		</nav>
	</header>

	<div>
		<div class="catslide-slider">
			<div class="catslide-slides">
				<input type="radio" name="radio-btn" id="radio1">
				<input type="radio" name="radio-btn" id="radio2">
				<input type="radio" name="radio-btn" id="radio3">
				<input type="radio" name="radio-btn" id="radio4">

				<div class="catslide-slide catslide-first">
					<img src="image/images/admin_1.jpg" alt="">
				</div>
				<div class="catslide-slide">
					<img src="image/images/admin_1.jpg" alt="">
				</div>
				<div class="catslide-slide">
					<img src="image/images/admin_1.jpg" alt="">
				</div>
				<div class="catslide-slide">
					<img src="image/images/admin_1.jpg" alt="">
				</div>

				<div class="catslide-navigation-auto">
					<div class="catslide-auto-btn1"></div>
					<div class="catslide-auto-btn2"></div>
					<div class="catslide-auto-btn3"></div>
					<div class="catslide-auto-btn4"></div>
				</div>

				<div class="catslide-navigation-manual">
					<label for="radio1" class="catslide-manual-btn"></label>
					<label for="radio2" class="catslide-manual-btn"></label>
					<label for="radio3" class="catslide-manual-btn"></label>
					<label for="radio4" class="catslide-manual-btn"></label>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			var counter = 1;
			var autoSlide = setInterval(function() {
				document.getElementById('radio' + counter).checked = true;
				counter++;
				if (counter > 4) {
					counter = 1;
				}
			}, 3000);

		</script>
	</div>


	<div class="catpage-filter-margin">
		<div class="normcat-filter-container">
			<div>
				<a href="category_an.php" class="normcat-filter-btn" data-before="ANIMATION" data-after="ANIMATION"></a>
				<a href="category_fi.php" class="normcat-filter-btn" data-before="FILM" data-after="FILM"></a>
				<a href="category_vc.php" class="normcat-filter-btn" data-before="VISUAL COMMUNICATION" data-after="VISUAL COMMUNICATION"></a>
				<a href="category_ar.php" class="normcat-filter-btn" data-before="ARTISTS" data-after="ARTISTS"></a>
			</div>
		</div>

		<!-- Content Sections -->
		<div class="normcat-filter-content-container">
			<div id="animation-content" class="normcat-filter-content"></div>
			<div id="film-content" class="normcat-filter-content"></div>
			<div id="vc-content" class="normcat-filter-content"></div>
			<div id="artists-content" class="normcat-filter-content"></div>
		</div>

		<section class="cat-image-gallery">
			<div>
				<?php 
        // SQL query to fetch account names with role 'Users', profile image, and category_id
        $query = "
            SELECT 
                a.account_id,      -- Include account_id for reference
                a.account_name, 
                up.users_image_location, 
                p.category_id 
            FROM 
                account a 
            JOIN 
                user_profile up ON a.account_id = up.account_id 
            JOIN 
                portfolio p ON a.account_id = p.account_id 
            WHERE 
                a.role = 'Users' 
            ORDER BY 
                a.account_name ASC"; // Sort by account_name in ascending order

        $stmt = $connection->prepare($query);
        $stmt->execute(); // Execute the query
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if there are results
        if ($results) {
            foreach ($results as $user) {
                // Display each user's information dynamically
                ?>
				<div class="cat-image-wrapper">
					<img src="<?php echo htmlspecialchars($user_profile['users_image_location']); ?>" alt="Profile Image"> <!-- Echo the profile image -->
					<div class="cat-overlay">
						<h3 class="cat-title"><?php echo htmlspecialchars($user_profile['category_id']); ?></h3> <!-- Echo account name -->
						<p class="cat-text">
							<?php 
                                echo htmlspecialchars($user_profile['account_name']); // Echo category ID
                            ?>
						</p>
					</div>
				</div>
				<?php
            }
        } else {
            echo "<p>No users found.</p>";
        }
?>
			</div>
		</section>

	</div>



	<div class="hidden-section" style="display: none;">
		This section is hidden.
		<section class="cat-image-gallery">
			<div>
				<div class="cat-image-wrapper">
					<img src="image/images/admin_1.jpg" alt="">
					<div class="cat-overlay">
						<h3 class="cat-title">Admin Image 1</h3>
						<p class="cat-text">This is some additional information</p>
					</div>
				</div>
				<div class="cat-image-wrapper">
					<img src="image/images/test_2.JPG" alt="">
					<div class="cat-overlay">
						<h3 class="cat-title">Test Image 2</h3>
						<p class="cat-text">This is some additional information</p>
					</div>
				</div>
				<div class="cat-image-wrapper">
					<img src="image/images/test_2.JPG" alt="">
					<div class="cat-overlay">
						<h3 class="cat-title">Test Image 2</h3>
						<p class="cat-text">This is some additional information</p>
					</div>
				</div>
				<div class="cat-image-wrapper">
					<img src="image/images/admin_1.jpg" alt="">
					<div class="cat-overlay">
						<h3 class="cat-title">Admin Image 1</h3>
						<p class="cat-text">This is some additional information</p>
					</div>
				</div>
				<div class="cat-image-wrapper">
					<img src="image/images/test_2.JPG" alt="">
					<div class="cat-overlay">
						<h3 class="cat-title">Test Image 2</h3>
						<p class="cat-text">This is some additional information</p>
					</div>
				</div>
				<div class="cat-image-wrapper">
					<img src="image/images/admin_1.jpg" alt="">
					<div class="cat-overlay">
						<h3 class="cat-title">Admin Image 1</h3>
						<p class="cat-text">This is some additional information</p>
					</div>
				</div>
				<div class="cat-image-wrapper">
					<img src="image/images/test_2.JPG" alt="">
					<div class="cat-overlay">
						<h3 class="cat-title">Test Image 2</h3>
						<p class="cat-text">This is some additional information</p>
					</div>
				</div>
				<div class="cat-image-wrapper">
					<img src="image/images/admin_1.jpg" alt="">
					<div class="cat-overlay">
						<h3 class="cat-title">Admin Image 1</h3>
						<p class="cat-text">This is some additional information</p>
					</div>
				</div>
				<!-- Add more images similarly... -->
			</div>
		</section>
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
						<a href="aboutus.html#mission">
							<p class="didact-gothic-regular">Mission</p>
						</a>
						<a href="aboutus.html#story">
							<p class="didact-gothic-regular">Story</p>
						</a>
						<a href="aboutus.html#team">
							<p class="didact-gothic-regular">Team</p>
						</a>
						<a href="aboutus.html#impact">
							<p class="didact-gothic-regular">Impact</p>
						</a>
					</a>
				</li>
				<li style="padding-right: 30px;">
					<a href="explore.html" target="_blank">
						<h4>Explore</h4>
					</a>
					<a href="animation.html">
						<p class="didact-gothic-regular">Animation</p>
					</a>
					<a href="visualcomm.html">
						<p class="didact-gothic-regular">Visual Comm</p>
					</a>
					<a href="film.html">
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
