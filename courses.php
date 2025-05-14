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

// Set the number of courses per page
$courses_per_page = 6;

// Get current page number
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $courses_per_page;

// Initialize filter variables
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$major_filter = isset($_GET['major']) ? $conn->real_escape_string($_GET['major']) : '';
$level_filter = isset($_GET['level']) ? $conn->real_escape_string($_GET['level']) : '';

// Build the SQL query with filters
$sql = "SELECT c.id_course, c.subject, c.date_course, c.major, c.level, c.price, m.name as mentor_name 
        FROM course c 
        LEFT JOIN mentor m ON c.id_mentor = m.id_mentor 
        WHERE 1=1";

// Add search filter if provided
if (!empty($search)) {
    $sql .= " AND (c.subject LIKE '%$search%' OR c.major LIKE '%$search%')";
}

// Add major filter if provided
if (!empty($major_filter) && $major_filter != 'All Categories') {
    $sql .= " AND c.major = '$major_filter'";
}

// Add level filter if provided
if (!empty($level_filter) && $level_filter != 'All Levels') {
    $sql .= " AND c.level = '$level_filter'";
}

// Add pagination
$sql .= " LIMIT $offset, $courses_per_page";

$result = $conn->query($sql);

// Get all unique majors for the filter dropdown
$major_sql = "SELECT DISTINCT major FROM course ORDER BY major";
$major_result = $conn->query($major_sql);

// Get all unique levels for the filter dropdown
$level_sql = "SELECT DISTINCT level FROM course ORDER BY level";
$level_result = $conn->query($level_sql);

// Count total courses for pagination (with filters)
$count_sql = "SELECT COUNT(*) as total FROM course c WHERE 1=1";
if (!empty($search)) {
    $count_sql .= " AND (c.subject LIKE '%$search%' OR c.major LIKE '%$search%')";
}
if (!empty($major_filter) && $major_filter != 'All Categories') {
    $count_sql .= " AND c.major = '$major_filter'";
}
if (!empty($level_filter) && $level_filter != 'All Levels') {
    $count_sql .= " AND c.level = '$level_filter'";
}

$count_result = $conn->query($count_sql);
$total_courses = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_courses / $courses_per_page);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Taalim - Empowering Education</title>
    <link rel="stylesheet" href="courses.css">
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
    </header>

    <!-- Courses Hero Section -->
    <section class="courses-hero">
        <div class="container">
            <h1>Explore Our Courses</h1>
            <p>Find the perfect course to boost your skills and knowledge</p>
            
            <form class="search-filter" method="GET" action="courses.php">
                <input type="text" name="search" placeholder="Search courses..." value="<?php echo htmlspecialchars($search); ?>">
                <select name="major" title="Filter by category">
                    <option value="">All Categories</option>
                    <?php
                    if ($major_result->num_rows > 0) {
                        while($major_row = $major_result->fetch_assoc()) {
                            $selected = ($major_filter == $major_row['major']) ? 'selected' : '';
                            echo '<option value="' . htmlspecialchars($major_row['major']) . '" ' . $selected . '>' . 
                                 htmlspecialchars($major_row['major']) . '</option>';
                        }
                    }
                    ?>
                </select>
                <select name="level" title="Filter by level">
                    <option value="">All Levels</option>
                    <?php
                    if ($level_result->num_rows > 0) {
                        while($level_row = $level_result->fetch_assoc()) {
                            $selected = ($level_filter == $level_row['level']) ? 'selected' : '';
                            echo '<option value="' . htmlspecialchars($level_row['level']) . '" ' . $selected . '>' . 
                                 htmlspecialchars($level_row['level']) . '</option>';
                        }
                    }
                    ?>
                </select>
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
        </div>
    </section>

    <!-- Courses Grid -->
    <div class="courses-container">
        <div class="courses-grid">
            <?php
            // Check if there are courses
            if ($result->num_rows > 0) {

                while($row = $result->fetch_assoc()) {
                    // Format the date
                    $date = new DateTime($row["date_course"]);
                    $formatted_date = $date->format('M d, Y');
                    
                    echo '<div class="course-card">';
                    echo '<div class="course-image">';
                    echo '<img src="images/courses.jpg" alt="Course image">';
                    echo '</div>';
                    echo '<div class="course-content">';
                    echo '<span class="course-category">' . htmlspecialchars($row["major"]) . '</span>';
                    
                    
                    echo '<a href="module.php?id=' . $row["id_course"] . '" class="btn btn-primary">View Module</a>';
                    
                    echo '<h3 class="course-title">' . htmlspecialchars($row["subject"]) . '</h3>';
                    
                    
                    echo '<p class="course-description">';
                    echo '<strong>Mentor:</strong> ' . htmlspecialchars($row["mentor_name"]) . '<br>';
                    echo '<strong>Major:</strong> ' . htmlspecialchars($row["major"]) . '<br>';
                    echo '<strong>Level:</strong> ' . htmlspecialchars($row["level"]);
                    echo '</p>';
                    
                    echo '<div class="course-meta">';
                    
                    echo '<span class="course-duration"><i class="fa fa-calendar"></i> ' . $formatted_date . '</span>';
                    echo '<span class="course-price">$' . number_format($row["price"], 2) . '</span>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "<p style='text-align: center; grid-column: 1 / -1; padding: 20px;'>No courses found matching your criteria.</p>";
            }
            ?>
        </div>
        
        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo ($page - 1); ?>&search=<?php echo urlencode($search); ?>&major=<?php echo urlencode($major_filter); ?>&level=<?php echo urlencode($level_filter); ?>">
                    <i class="fa fa-angle-left"></i>
                </a>
            <?php endif; ?>
            
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&major=<?php echo urlencode($major_filter); ?>&level=<?php echo urlencode($level_filter); ?>" 
                   class="<?php echo ($i == $page) ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
            
            <?php if ($page < $total_pages): ?>
                <a href="?page=<?php echo ($page + 1); ?>&search=<?php echo urlencode($search); ?>&major=<?php echo urlencode($major_filter); ?>&level=<?php echo urlencode($level_filter); ?>">
                    <i class="fa fa-angle-right"></i>
                </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
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