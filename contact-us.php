<?php

include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Taalim - Empowering Education</title>
    <link rel="stylesheet" href="contact-us.css">
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <!-- Navbar unchanged
    <header> <div class="container">
            <div class="logo">
                <img src="images/E-TAALIM.pnj.png" alt="E-Taalim Logo">
            </div>
            <nav>
                <ul class="nav-links">
                    <li><a href="index.html" class="active">HOME</a></li>
                    <li><a href="About-us.html">ABOUT US</a></li>
                    <li><a href="courses.php">COURSES</a></li>
                    <li><a href="mentor.php">MENTORS</a></li>
                    <li><a href="contact-us.html">CONTACT US</a></li>
                </ul>
            </nav>
            <div class="sign-in">
                <a href="signup.html" class="btn btn-primary">Sign In</a>
            </div>
        </div></header> -->







    <!-- Contact Banner -->
    <section class="contact-banner">
        <div class="banner-overlay">
            <h1>Contact Us</h1>
            <p><a href="index.html">Home</a> / Contact</p>
        </div>
    </section>

    <!-- Enhanced Contact Section -->
    <section class="contact-section">
        <div class="container">
            <div class="section-header">
                <h2>Get in Touch</h2>
                <p>We'd love to hear from you! Whether you have a question about our courses, mentors, or anything else, our team is ready to answer all your questions.</p>
            </div>
            
            <div class="contact-container">
                <!-- Contact Info Cards -->
                <div class="contact-info-cards">
                    <div class="info-card">
                        <div class="icon-container">
                            <i class="fa fa-map-marker"></i>
                        </div>
                        <h3>Our Location</h3>
                        <p>Algiers, Algeria</p>
                        <p>123 Education Street</p>
                    </div>
                    
                    <div class="info-card">
                        <div class="icon-container">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <h3>Email Us</h3>
                        <p>support@e_taalim.com</p>
                        <p>info@e_taalim.com</p>
                    </div>
                    
                    <div class="info-card">
                        <div class="icon-container">
                            <i class="fa fa-phone"></i>
                        </div>
                        <h3>Call Us</h3>
                        <p>+213 XX XX XX XX</p>
                        <p>+213 XX XX XX XX</p>
                    </div>
                    
                    <div class="info-card">
                        <div class="icon-container">
                            <i class="fa fa-clock-o"></i>
                        </div>
                        <h3>Working Hours</h3>
                        <p>Monday-Friday: 9AM - 5PM</p>
                        <p>Weekend: 10AM - 2PM</p>
                    </div>
                </div>
                
                <!-- Contact Form -->
                <div class="contact-form-container">
                    <div class="form-header">
                        <h3>Send Us a Message</h3>
                        <p>Fill out the form below and we'll get back to you as soon as possible.</p>
                    </div>
                    
                    <form id="contactForm" class="animated-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="fullName">Full Name <span class="required">*</span></label>
                                <div class="input-container">
                                    <i class="fa fa-user"></i>
                                    <input type="text" id="fullName" name="fullName" placeholder="Your name" required>
                                </div>
                                <div class="error-message">Please enter your name</div>
                            </div>
                            
                            <div class="form-group">
                                <label for="email">Email <span class="required">*</span></label>
                                <div class="input-container">
                                    <i class="fa fa-envelope"></i>
                                    <input type="email" id="email" name="email" placeholder="Your email" required>
                                </div>
                                <div class="error-message">Please enter a valid email</div>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <div class="input-container">
                                    <i class="fa fa-phone"></i>
                                    <input type="tel" id="phone" name="phone" placeholder="Your phone number">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="subject">Subject <span class="required">*</span></label>
                                <div class="input-container">
                                    <i class="fa fa-tag"></i>
                                    <input type="text" id="subject" name="subject" placeholder="Message subject" required>
                                </div>
                                <div class="error-message">Please enter a subject</div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Message <span class="required">*</span></label>
                            <div class="input-container textarea-container">
                                <i class="fa fa-comment"></i>
                                <textarea id="message" name="message" placeholder="Write your message here..." rows="5" required></textarea>
                            </div>
                            <div class="error-message">Please enter your message</div>
                        </div>
                        
                        <div class="form-group checkbox-group">
                            <label class="checkbox-container">
                                <input type="checkbox" id="consent" name="consent" required>
                                <span class="checkmark"></span>
                                I agree to the <a href="#" class="terms-link">Privacy Policy</a> and consent to being contacted.
                            </label>
                            <div class="error-message">You must agree to the privacy policy</div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary submit-btn">
                            <span>Send Message</span>
                            <i class="fa fa-paper-plane"></i>
                            <div class="loader"></div>
                        </button>
                    </form>
                    
                    <div class="success-message" id="successMessage">
                        <div class="success-icon">
                            <i class="fa fa-check-circle"></i>
                        </div>
                        <h3>Message Sent!</h3>
                        <p>Thank you for contacting us. We'll get back to you shortly.</p>
                        <button class="btn btn-primary" id="sendAnotherBtn">Send Another Message</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Map Section -->
    <section class="map-section">
        <div class="container">
            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d102239.58355570477!2d3.0160527071729247!3d36.7375608117553!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x128fb26977ea659f%3A0x128fb3686e9aee73!2sAlgiers%2C%20Algeria!5e0!3m2!1sen!2sus!4v1683900294803!5m2!1sen!2sus" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>
    
    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <div class="section-header">
                <h2>Frequently Asked Questions</h2>
                <p>Find quick answers to common questions about our platform and services.</p>
            </div>
            
            <div class="faq-container">
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>How can I enroll in a course?</h3>
                        <span class="toggle-icon"><i class="fa fa-plus"></i></span>
                    </div>
                    <div class="faq-answer">
                        <p>To enroll in a course, simply browse our course catalog, select the course you're interested in, and click the "Enroll" button. You'll be guided through the registration and payment process.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>What payment methods do you accept?</h3>
                        <span class="toggle-icon"><i class="fa fa-plus"></i></span>
                    </div>
                    <div class="faq-answer">
                        <p>We accept various payment methods including credit/debit cards, PayPal, and bank transfers. All payments are processed securely through our platform.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>How do I become a mentor on E-Taalim?</h3>
                        <span class="toggle-icon"><i class="fa fa-plus"></i></span>
                    </div>
                    <div class="faq-answer">
                        <p>To become a mentor, visit our "Become a Mentor" page and fill out the application form. Our team will review your application and get back to you with the next steps.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Can I get a refund if I'm not satisfied with a course?</h3>
                        <span class="toggle-icon"><i class="fa fa-plus"></i></span>
                    </div>
                    <div class="faq-answer">
                        <p>Yes, we offer a 30-day money-back guarantee for most courses. If you're not satisfied, you can request a refund within 30 days of purchase.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>










    
    

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

    <script src="script.js"></script>
    
</body>
</html>