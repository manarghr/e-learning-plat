<?php
include 'header.php';
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

// Get mentor ID from URL parameter
$mentor_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// If no ID provided, redirect to mentors page
if ($mentor_id === 0) {
    header("Location: mentor.php");
    exit;
}

// Query to get mentor details
$sql = "SELECT * FROM mentor WHERE id_mentor = $mentor_id";
$result = $conn->query($sql);

// Check if mentor exists
if ($result->num_rows === 0) {
    header("Location: mentor.php");
    exit;
}

// Get mentor data
$mentor = $result->fetch_assoc();

// Query to get mentor's courses
$courses_sql = "SELECT * FROM course WHERE id_mentor = $mentor_id";
$courses_result = $conn->query($courses_sql);

// Set default profile image if empty
$profile_image = !empty($mentor["profile_picture"]) ? $mentor["profile_picture"] : "images/mentor1.png";

// Generate a professional "About Me" description based on mentor data
$about_me = "I am a passionate educator specializing in " . $mentor["major"] . " with " . $mentor["experience"] . 
            " years of experience in the field. As a " . $mentor["level"] . "-level instructor, I am dedicated to helping students " .
            "master complex concepts through engaging and interactive learning experiences. My teaching approach focuses on " .
            "practical applications and real-world examples to ensure students not only understand the theory but can also " .
            "apply their knowledge effectively.";

// Additional paragraph for the about section
$about_me_additional = "My goal is to create a supportive learning environment where students feel comfortable asking questions " .
                      "and exploring new ideas. I believe that education is most effective when it's tailored to individual learning " .
                      "styles and needs, which is why I offer personalized guidance and feedback throughout my courses.";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Taalim - <?php echo htmlspecialchars($mentor["name"]); ?></title>
    <link rel="stylesheet" href="profile_mentor.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <!-- Navigation Bar
    <header>
        <div class="container">
            <div class="logo">
                <img src="images/E-TAALIM.pnj.png" alt="E-Taalim Logo">
            </div>
            <nav>
                <ul class="nav-links">
                    <li><a href="index.html">HOME</a></li>
                    <li><a href="About-us.html">ABOUT US</a></li>
                    <li><a href="courses.php">COURSES</a></li>
                    <li><a href="mentor.php" class="active">MENTORS</a></li>
                    <li><a href="contact-us.html">CONTACT US</a></li>
                </ul>
            </nav>
            <div class="sign-in">
                <a href="signup.html" class="btn btn-primary">Sign In</a>
            </div>
        </div>
    </header> -->

    <div class="hero-text">
        <h1>Mentor Profile</h1>
    </div>

    <div class="mentor-container">
        <!-- Sidebar -->
        <aside class="mentor-sidebar">
            <div class="mentor-avatar">
                <img src="<?php echo htmlspecialchars($profile_image); ?>" alt="<?php echo htmlspecialchars($mentor["name"]); ?>">
            </div>
            <h2 class="mentor-name"><?php echo htmlspecialchars($mentor["name"]); ?></h2>
            <p class="mentor-title"><?php echo htmlspecialchars($mentor["major"]); ?></p>
            
            <div class="mentor-rating">
                <div class="stars">
                    <i class="fa fa-star" style="color: #ffa64d;"></i>
                    <i class="fa fa-star" style="color: #ffa64d;"></i>
                    <i class="fa fa-star" style="color: #ffa64d;"></i>
                    <i class="fa fa-star" style="color: #ffa64d;"></i>
                    <i class="fa fa-star-half-o" style="color: #ffa64d;"></i>
                </div>
                <p>4.5 (128 reviews)</p>
            </div>
            
            <div class="mentor-contact">
                <p><i class="fa fa-envelope"></i> <?php echo htmlspecialchars($mentor["email"]); ?></p>
                <p><i class="fa fa-phone"></i> <?php echo htmlspecialchars($mentor["phone"]); ?></p>
                <p><i class="fa fa-map-marker"></i> Algiers, Algeria</p>
            </div>
            
            <a href="mailto:<?php echo htmlspecialchars($mentor["email"]); ?>" class="btn btn-primary" style="width: 100%;">Contact Mentor</a>
        </aside>
        
        <!-- Main Content -->
        <main class="mentor-main">
            <section class="about-section">
                <h3 class="section-title">About Me</h3>
                <p class="about-text"><?php echo $about_me; ?></p>
                <p class="about-text"><?php echo $about_me_additional; ?></p>
            </section>
            
            <section class="certification-section">
                <h3 class="section-title">Qualifications & Skills</h3>
                <p class="certification-text">
                    <strong>Major:</strong> <?php echo htmlspecialchars($mentor["major"]); ?><br>
                    <strong>Level:</strong> <?php echo htmlspecialchars($mentor["level"]); ?><br>
                    <strong>Experience:</strong> <?php echo htmlspecialchars($mentor["experience"]); ?> years<br>
                    <strong>Skills:</strong> <?php echo htmlspecialchars($mentor["skills"]); ?>
                </p>
            </section>
            
            <section class="courses-section">
                <h3 class="section-title">My Courses</h3>
                <?php if ($courses_result->num_rows > 0): ?>
                <table class="courses-table">
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Major</th>
                            <th>Level</th>
                            <th>Date</th>
                            <th>Price</th>
                            <th>Action</th> <!-- Add this new column header -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($course = $courses_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($course["subject"]); ?></td>
                            <td><?php echo htmlspecialchars($course["major"]); ?></td>
                            <td><?php echo htmlspecialchars($course["level"]); ?></td>
                            <td><?php echo date('M d, Y', strtotime($course["date_course"])); ?></td>
                            <td>$<?php echo number_format($course["price"], 2); ?></td>
                            <td>
                                <!-- Add this button that links to module.php -->
                                <a href="module.php?id=<?php echo $course["id_course"]; ?>" class="btn btn-primary">View Module</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p>No courses available from this mentor yet.</p>
                <?php endif; ?>
            </section>

            <section class="review-section">
                <h3 class="section-title">Add Review</h3>
                <p>Your Review about this mentor</p>
                <form class="review-form" method="post" action="submit_review.php">
                    <input type="hidden" name="mentor_id" value="<?php echo $mentor_id; ?>">
                    <textarea name="comment" placeholder="Comment"></textarea>
                    <button type="submit" class="btn btn-primary">Submit Review</button>
                </form>
            </section>
            
            <section class="notes-section">
                <h3 class="section-title">Student Notes</h3>
                <p>[Login to view student notes]</p>
                
                <div class="note">
                    <p class="note-author">Isabella Shoria</p>
                    <p class="note-text">The courses with this mentor have been incredibly helpful. I've learned so much in such a short time!</p>
                </div>
                
                <div class="note">
                    <p class="note-author">Diego Cuzumim</p>
                    <p class="note-text">Very knowledgeable and patient. Explains complex concepts in an easy-to-understand way.</p>
                </div>
                
                <div class="note">
                    <p class="note-author">Sula Miranda Silva</p>
                    <p class="note-text">Highly recommend this mentor for anyone looking to improve their skills in <?php echo htmlspecialchars($mentor["major"]); ?>.</p>
                </div>
            </section>
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