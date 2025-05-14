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

// Get course ID from URL parameter
$course_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// If no ID provided, redirect to courses page
if ($course_id === 0) {
    header("Location: courses.php");
    exit;
}

// Query to get course details
$sql = "SELECT c.*, m.name as mentor_name, m.id_mentor, m.profile_picture, m.major as mentor_major 
        FROM course c 
        LEFT JOIN mentor m ON c.id_mentor = m.id_mentor 
        WHERE c.id_course = $course_id";
$result = $conn->query($sql);

// Check if course exists
if ($result->num_rows === 0) {
    header("Location: courses.php");
    exit;
}

// Get course data
$course = $result->fetch_assoc();

// Query to get other courses by the same mentor
$related_courses_sql = "SELECT id_course, subject, major, level FROM course 
                        WHERE id_mentor = {$course['id_mentor']} 
                        AND id_course != $course_id 
                        LIMIT 3";
$related_courses_result = $conn->query($related_courses_sql);

// Query to get other mentors in the same major
$other_mentors_sql = "SELECT id_mentor, name, major, profile_picture 
                      FROM mentor 
                      WHERE major = '{$course['major']}' 
                      AND id_mentor != {$course['id_mentor']} 
                      LIMIT 3";
$other_mentors_result = $conn->query($other_mentors_sql);

// Generate lessons based on the course subject and major
$lessons = [];
switch(strtolower($course['major'])) {
    case 'mathematics':
        $lessons = ['Algebra', 'Geometry', 'Calculus', 'Statistics'];
        break;
    case 'science':
        $lessons = ['Physics', 'Chemistry', 'Biology', 'Earth Science'];
        break;
    case 'programming':
        $lessons = ['HTML/CSS', 'JavaScript', 'Backend Development', 'Database Design'];
        break;
    case 'languages':
        $lessons = ['Grammar', 'Vocabulary', 'Conversation', 'Writing'];
        break;
    default:
        $lessons = ['Introduction', 'Core Concepts', 'Advanced Topics', 'Practical Applications'];
}

// Set default profile image if empty
$mentor_image = !empty($course["profile_picture"]) ? $course["profile_picture"] : "images/mentor1.png";

// Count students (mock data for now)
$student_count = rand(50, 2000);

// Format date
$course_date = new DateTime($course["date_course"]);
$formatted_date = $course_date->format('M d, Y');

// Format time
$course_time = new DateTime($course["time_course"]);
$formatted_time = $course_time->format('h:i A');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Taalim - <?php echo htmlspecialchars($course["subject"]); ?></title>
    <link rel="stylesheet" href="module.css">
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
                    <li><a href="courses.php" class="active">COURSES</a></li>
                    <li><a href="mentor.php">MENTORS</a></li>
                    <li><a href="contact-us.html">CONTACT US</a></li>
                </ul>
            </nav>
            <div class="sign-in">
                <a href="signup.html" class="btn btn-primary">Sign In</a>
            </div>
        </div>
    </header> -->

    <!-- Module Content -->
    <div class="container module-container">
        <main class="module-main">
            <h2><?php echo htmlspecialchars($course["subject"]); ?></h2>
            
            <div class="categories">
                <span class="category-tag"><?php echo htmlspecialchars($course["major"]); ?></span>
                <span class="category-tag"><?php echo htmlspecialchars($course["level"]); ?></span>
                <span class="category-tag"><i class="fa fa-calendar"></i> <?php echo $formatted_date; ?></span>
                <span class="category-tag"><i class="fa fa-clock-o"></i> <?php echo $formatted_time; ?></span>
            </div>
            
            <p class="module-description">
                This comprehensive <?php echo htmlspecialchars($course["subject"]); ?> course is designed for <?php echo htmlspecialchars($course["level"]); ?> level students 
                interested in mastering <?php echo htmlspecialchars($course["major"]); ?>. The course provides a solid foundation in theoretical concepts 
                while emphasizing practical applications. Students will develop critical thinking skills and problem-solving abilities 
                through hands-on exercises, projects, and interactive discussions.
            </p>
            
            <h3>Lessons:</h3>
            <ul class="lessons-list">
                <?php foreach($lessons as $lesson): ?>
                <li><?php echo htmlspecialchars($lesson); ?></li>
                <?php endforeach; ?>
            </ul>
            
            <div class="mentors-section">
                <h3>Our Mentors For This Course</h3>
                <div class="mentors-grid">
                    <!-- Primary Course Mentor -->
                    <div class="mentor-card">
                        <div class="mentor-avatar">
                            <img src="<?php echo htmlspecialchars($mentor_image); ?>" alt="<?php echo htmlspecialchars($course["mentor_name"]); ?>">
                        </div>
                        <h4 class="mentor-name"><?php echo htmlspecialchars($course["mentor_name"]); ?></h4>
                        <p class="mentor-specialty"><?php echo htmlspecialchars($course["mentor_major"]); ?></p>
                        <a href="profile_mentor.php?id=<?php echo $course["id_mentor"]; ?>" class="btn btn-primary">View Profile</a>
                    </div>
                    
                    <!-- Other Mentors in Same Major -->
                    <?php if ($other_mentors_result->num_rows > 0): ?>
                        <?php while($mentor = $other_mentors_result->fetch_assoc()): ?>
                            <?php $other_mentor_image = !empty($mentor["profile_picture"]) ? $mentor["profile_picture"] : "images/mentor1.png"; ?>
                            <div class="mentor-card">
                                <div class="mentor-avatar">
                                    <img src="<?php echo htmlspecialchars($other_mentor_image); ?>" alt="<?php echo htmlspecialchars($mentor["name"]); ?>">
                                </div>
                                <h4 class="mentor-name"><?php echo htmlspecialchars($mentor["name"]); ?></h4>
                                <p class="mentor-specialty"><?php echo htmlspecialchars($mentor["major"]); ?></p>
                                <a href="profile_mentor.php?id=<?php echo $mentor["id_mentor"]; ?>" class="btn btn-primary">View Profile</a>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
                
                <p class="module-description">
                    Our experienced mentors are dedicated to helping you succeed in your educational journey. 
                    They bring real-world expertise and a passion for teaching to every session. 
                    Feel free to reach out to them with any questions or for additional guidance on course materials.
                </p>
            </div>

            <!-- Related Courses Section -->
            <?php if ($related_courses_result->num_rows > 0): ?>
            <section class="related-courses">
                <h3 class="section-title">Related Courses</h3>
                <div class="related-courses-list">
                    <ul>
                        <?php while($related = $related_courses_result->fetch_assoc()): ?>
                            <li>
                                <a href="module.php?id=<?php echo $related["id_course"]; ?>">
                                    <?php echo htmlspecialchars($related["subject"]); ?> 
                                    <span class="course-level">(<?php echo htmlspecialchars($related["level"]); ?>)</span>
                                </a>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </section>
            <?php endif; ?>

            <!-- Comment Section -->
            <section class="comment-section">
                <h3>Leave a Comment</h3>
                <form class="comment-form" method="post" action="submit_comment.php">
                    <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
                    <textarea name="comment" placeholder="Write your comment here..."></textarea>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </section>
        </main>

        <!-- Sidebar -->
        <aside class="module-sidebar">
            <div class="sidebar-card">
                <h3>This course includes:</h3>
                <ul class="includes-list">
                    <li><?php echo htmlspecialchars($course["level"]); ?> level content</li>
                    <li><?php echo $student_count; ?> students enrolled</li>
                    <li><?php echo count($lessons); ?> lessons</li>
                    <li>Scheduled on <?php echo $formatted_date; ?></li>
                    <li>Starts at <?php echo $formatted_time; ?></li>
                    <li>Available from the app</li>
                    <li>Certificate of completion</li>
                    <li>Lifetime access</li>
                </ul>
                <div style="text-align: center; margin: 20px 0;">
                    <span style="font-size: 24px; font-weight: bold; color: #1e3a5f;">
                        $<?php echo number_format($course["price"], 2); ?>
                    </span>
                </div>
                <a href="enroll.php?id=<?php echo $course_id; ?>" class="btn btn-primary" style="width: 100%; margin-top: 20px;">Enroll Now</a>
            </div>
            
            <div class="sidebar-card">
                <h3>Subscribe To Our Newsletter</h3>
                <p>Get updates on new courses, special offers, and educational resources!</p>
                <form class="newsletter-form" method="post" action="subscribe.php">
                    <input type="email" name="email" placeholder="Your email" required>
                    <input type="text" name="website" placeholder="Website (optional)">
                    <button type="submit" class="btn btn-secondary" style="width: 100%;">Subscribe</button>
                </form>
            </div>
            
            <div class="sidebar-card">
                <h3>Need Help?</h3>
                <p>Have questions about this course or need assistance?</p>
                <a href="contact-us.php" class="btn btn-secondary" style="width: 100%;">Contact Support</a>
            </div>
        </aside>
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