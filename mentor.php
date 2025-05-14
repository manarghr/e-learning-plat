<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "etaali";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the number of mentors per page
$mentors_per_page = 9;

// Get current page number
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $mentors_per_page;

// Query to get mentors with pagination
$sql = "SELECT id_mentor, name, major, profile_picture FROM mentor LIMIT $offset, $mentors_per_page";
$result = $conn->query($sql);

// Query to get total number of mentors for pagination
$count_sql = "SELECT COUNT(*) as total FROM mentor";
$count_result = $conn->query($count_sql);
$total_mentors = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_mentors / $mentors_per_page);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Taalim - Empowering Education</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="mentor.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <!-- Navigation Bar -->
    <header>
        <div class="container">
            <div class="logo">
                <img src="images/E-TAALIM.pnj.png" alt="E-Taalim Logo">
            </div>
            <nav>
                <ul class="nav-links">
                    <li><a href="index.html" class="active">HOME</a></li>
                    <li><a href="About-us.html">ABOUT US</a></li>
                    <li><a href="courses.html">COURSES</a></li>
                    <li><a href="mentor.html">MENTORS</a></li>
                    <li><a href="contact-us.html">CONTACT US</a></li>
                </ul>
            </nav>
            <div class="sign-in">
                <a href="signup.html" class="btn btn-primary">Sign up</a>
            </div>
        </div>
    </header> 

    <div class="hero-text">
        <h1>Meet Our Mentors</h1>
        <p>Learn from the best in the field</p>
    </div>

    <div class="container mentors-container">
        <main class="mentors-main">
            <div class="mentors-section">
                <div class="mentors-grid">
                    <?php
                    // Check if there are mentors
                    if ($result->num_rows > 0) {
                        // Output data of each mentor
                        while($row = $result->fetch_assoc()) {
                            // Set default image if profile_picture is empty
                            $profile_image = !empty($row["profile_picture"]) ? $row["profile_picture"] : "mentor_images/mentor1.jpg";
                            
                            echo '<div class="mentor-card">';
                            echo '<div class="mentor-avatar">';
                            echo '<img src="' . htmlspecialchars($profile_image) . '" alt="' . htmlspecialchars($row["name"]) . '">';
                            echo '</div>';
                            echo '<h4 class="mentor-name">' . htmlspecialchars($row["name"]) . '</h4>';
                            echo '<p class="mentor-specialty">' . htmlspecialchars($row["major"]) . '</p>';
                            echo '<a href="profile_mentor.php?id=' . $row["id_mentor"] . '" class="btn btn-primary">View Profile</a>';
                            echo '</div>';
                        }
                    } else {
                        echo "<p>No mentors found</p>";
                    }
                    ?>
                </div>
                
                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                <div class="pagination" style="text-align: center; margin-top: 20px;">
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="?page=<?php echo $i; ?>" 
                           style="display: inline-block; padding: 5px 10px; margin: 0 5px; 
                                  background-color: <?php echo ($i == $page) ? '#ffa64d' : '#1e3a5f'; ?>; 
                                  color: white; border-radius: 5px; text-decoration: none;">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>
                </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <img src="images/E-TAALIM.pnj.png" alt="E-Taalim Logo">
                    <div class="footer-tagline">
                        <p>EMPOWERING EDUCATION</p>
                        <p><span class="highlight">ONE CLICK</span> AT A TIME...</p>
                    </div>
                    <div class="social-icons">
                        <a href="#" aria-label="Facebook"><i class="fa fa-facebook"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fa fa-twitter"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fa fa-instagram"></i></a>
                        <a href="#" aria-label="LinkedIn"><i class="fa fa-linkedin"></i></a>
                        <a href="#" aria-label="YouTube"><i class="fa fa-youtube-play"></i></a>
                    </div>
                </div>
                
                <div class="footer-newsletter">
                    <h3>Subscribe To Our Newsletter</h3>
                    <p>Get the latest updates on new courses, mentors, and exclusive offers!</p>
                    <div class="newsletter-form">
                        <input type="email" placeholder="Enter your email">
                        <button class="btn btn-primary">Subscribe</button>
                    </div>
                </div>
                
                <div class="footer-contact">
                    <h3>Contact Us</h3>
                    <p><i class="fa fa-envelope"></i> support@e_taalim.com</p>
                    <p><i class="fa fa-phone"></i> +213 XX XX XX XX</p>
                    <p><i class="fa fa-map-marker"></i> Algiers, Algeria</p>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>Copyright © 2025 E-Taalim</p>
                <p>All Rights Reserved | <a href="#">Terms and Conditions</a> | <a href="#">Privacy Policy</a></p>
            </div>
        </div>
    </footer>
</body>
</html>
<?php
// Close connection
$conn->close();
?>