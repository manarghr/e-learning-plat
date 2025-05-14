<?php
session_start();
$logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
$user_name = $logged_in ? $_SESSION['user_name'] : '';
?>

<!-- Navigation Bar -->
<header>
    <div class="container">
        <div class="logo">
            <img src="images/E-TAALIM.pnj.png" alt="E-Taalim Logo">
        </div>
        <nav>
            <ul class="nav-links">
                <li><a href="index.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php' || basename($_SERVER['PHP_SELF']) == 'index.php') ? 'class="active"' : ''; ?>>HOME</a></li>
                <li><a href="About-us.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'About-us.php') ? 'class="active"' : ''; ?>>ABOUT US</a></li>
                <li><a href="courses.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'courses.php') ? 'class="active"' : ''; ?>>COURSES</a></li>
                <li><a href="mentor.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'mentor.php') ? 'class="active"' : ''; ?>>MENTORS</a></li>
                <li><a href="contact-us.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'contact-us.php') ? 'class="active"' : ''; ?>>CONTACT US</a></li>
            </ul>
        </nav>
        <div class="sign-in">
            <?php if ($logged_in): ?>
                <span class="user-welcome">Welcome, <?php echo htmlspecialchars($user_name); ?></span>
                <a href="logout.php" class="btn btn-primary">Logout</a>
            <?php else: ?>
                <a href="signup.html" class="btn btn-primary">Sign In</a>
            <?php endif; ?>
        </div>
    </div>
</header>