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



	<div class="row pb-4" style="margin: 40px">
		<div class="col-md-4 col-lg-4 pb-4">
<?php  
// Prepare and execute query to fetch admin profiles
$query = "SELECT ap.admin_image_location, a.account_name, a.role FROM admin_profile ap RIGHT JOIN account a ON ap.account_id = a.account_id WHERE 
        a.role = 'Admin'"; 
$stmt = $connection->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if there are results
if ($results) {
    foreach ($results as $profile) {
        // Display each admin profile dynamically
        ?>
        <div class="admin-profile-card">
			<?php if($profile['admin_image_location'] == NULL) { ?>
			<i class="fa-solid fa-user admin-profile-icon"></i>		
			<?php } else { ?>
            <img src="<?php echo htmlspecialchars($profile['admin_image_location']); ?>" alt="Profile Image" class="admin-profile-image">
			<?php } ?>
            <div class="admin-profile-info">
                <h3 class="admin-profile-name"><?php echo htmlspecialchars($profile['account_name']); ?></h3>
                <p class="admin-profile-role"><?php echo htmlspecialchars($profile['role']); ?></p>
            </div>
        </div>
        <?php
    }
} else {
    echo "<p>No admin profiles found.</p>";
}
?>
			        
<div class="row">
    <?php
    if (isset($_POST["import"])) {
        $databasehost = "localhost";
        $databasename = "gradgala";
        $databasetable = "account";
        $databaseusername = "root";
        $databasepassword = '';

        // File handling
        $csvfile = $_FILES["fileToUpload"]["tmp_name"]; // Use tmp_name for uploaded files
        if (!file_exists($csvfile)) {
            error_log('File does NOT exist!');
            die("File not found. Make sure you specified the correct path.");
        }

        // Create a new PDO instance
        try {
            $pdo = new PDO(
                "mysql:host=$databasehost;dbname=$databasename",
                $databaseusername,
                $databasepassword,
                array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                )
            );
        } catch (PDOException $e) {
            error_log('Database connection failed!');
            die("Database connection failed: " . $e->getMessage());
        }

        // Open the CSV file for reading
        if (($handle = fopen($csvfile, "r")) !== FALSE) {
            // Skip the header row
            fgetcsv($handle);

            // Prepare SQL statements
            $insertSql = "INSERT INTO $databasetable (account_name, account_email, account_password, role) VALUES (:account_name, :account_email, :account_password, :role)";
            $stmtInsert = $pdo->prepare($insertSql);

            // Prepare a select statement to check for duplicates
            $checkSql = "SELECT COUNT(*) FROM $databasetable WHERE account_email = :account_email";
            $stmtCheck = $pdo->prepare($checkSql);

            // Read each row from the CSV file
            while (($data = fgetcsv($handle)) !== FALSE) {
                // Assign values based on CSV columns (adjust as needed)
                $account_name = $data[0]; // 'NAME (Full name as IC)'
                $account_email = $data[1]; // 'STUDENT EMAIL'
                $role = $data[2]; // 'ROLE'
                $account_password = ''; // Assuming password is not provided; adjust as necessary

                // Check for existing record
                $stmtCheck->execute([':account_email' => $account_email]);
                $exists = $stmtCheck->fetchColumn();

                if ($exists == 0) { // If no existing record found
                    // Execute the insert statement
                    $stmtInsert->execute([
                        ':account_name' => $account_name,
                        ':account_email' => $account_email,
                        ':account_password' => $account_password, // Insert empty password or modify as needed
                        ':role' => $role
                    ]);
                } else {
                    echo "Duplicate record found for email: $account_email. Skipping insert.<br>";
                }
            }
            fclose($handle);
            echo "CSV import process completed!";
        } else {
            echo "Error opening the file.";
        }
    }
    ?>
    
    <div class="row" style="padding-top:20px">
        <form action="" method="post" enctype="multipart/form-data" >
            <label for="fileToUpload">Select CSV file:</label>
			<br>
            <input type="file" id="fileToUpload" name="fileToUpload" accept=".csv" required>
			<br>
            <input type="submit" class="btn btn-primary" name="import" value="Import">

        </form>
    </div>

</div>

		</div>



		<div class="col-md-8 col-lg-8" style="">
			<div class="admin-filter-container" style="padding: 5px; justify-content: space-evenly">
				<a href="adminprofile_users.php" class="admin-filter-btn" data-before="USERS" data-after="USERS"></a>
				<a href="adminprofile_works.php" class="admin-filter-btn" data-before="WORKS" data-after="WORKS"></a>
				<a href="adminprofile_comments.php" class="admin-filter-btn" data-before="COMMENTS" data-after="COMMENTS"></a>
			</div>

			<!-- Content Containers -->
			<div id="users-content" class="admin-content-container"></div>
			<div id="works-content" class="admin-content-container"></div>
			<div id="comments-content" class="admin-content-container"></div>

			<div class="row" style="padding: 10px;">
				
<div class="admin-list-container">
    <?php
    // Define the number of records per page
    $recordsPerPage = 20;

    // Get the current page number from the URL, default to 1 if not set
    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $current_page = max(1, $current_page); // Ensure it's at least 1

    // Calculate the starting record for the SQL query
    $startFrom = ($current_page - 1) * $recordsPerPage;

    // Prepare and execute query to fetch users and their portfolio records
    $query = "SELECT a.account_id, a.account_name, p.category_id 
              FROM account a 
              LEFT JOIN portfolio p ON a.account_id = p.account_id 
              WHERE a.role = 'Users'
              LIMIT :startFrom, :recordsPerPage
              "; 

    $stmt = $connection->prepare($query);
    $stmt->bindParam(':startFrom', $startFrom, PDO::PARAM_INT);
    $stmt->bindParam(':recordsPerPage', $recordsPerPage, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Prepare a query to count total users for pagination
    $countQuery = "
        SELECT COUNT(*) as total 
        FROM account 
        WHERE role = 'Users'
    ";
    $countStmt = $connection->prepare($countQuery);
    $countStmt->execute();
    $totalCount = $countStmt->fetchColumn();
    $totalPages = ceil($totalCount / $recordsPerPage);

    // Check if there are results
    if ($results) {
        foreach ($results as $user) {
            // Display each user dynamically in the existing structure
            ?>
            <div class="admin-list-item">
                <span class="admin-list-id"><?php echo htmlspecialchars($user['account_id']); ?></span>
                <span class="admin-list-name"><?php echo htmlspecialchars($user['account_name']); ?></span>
                <span class="admin-list-type"><?php echo htmlspecialchars($user['category_id'] ?? 'N/A'); ?></span>
                <i class="fa-solid fa-trash admin-delete-btn" onclick="deleteUser(<?php echo htmlspecialchars($user['account_id']); ?>)"></i>
            </div>
            <?php
        }
    } else {
        echo "<p>No users found.</p>";
    }
    ?>
</div>

<div class="pagination" style="text-align: center; margin-top: 20px;">
    <?php
    // Pagination links
    for ($page = 1; $page <= $totalPages; $page++) {
        echo '<a href="?page=' . $page . '">' . $page . '</a> ';
    }
    ?>
</div>

<script>
    function deleteUser(accountId) {
        if (confirm("Are you sure you want to delete this user?")) {
            // Make an AJAX request or redirect to delete the user
            window.location.href = 'delete_user.php?account_id=' + accountId;
        }
    }
</script>



	</div>

		</div>
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
