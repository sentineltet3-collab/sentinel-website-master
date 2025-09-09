<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Sentinel Integrated Security Services</title>
    <link rel="icon" href="assets/images/logo.png" type="image/png">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/contact.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <?php include('includes/header.php'); ?>

    <!-- Contact Page Content -->
    <div class="contact-container">
        <!-- Left Section - Contact Information -->
        <div class="contact-info-section">
            <div class="contact-info-content">
                <h1 class="contact-title">CONTACT US</h1>
                <p class="contact-intro">
                    We would love to speak with you. Feel free to reach out using the below details.
                </p>

                <!-- Get In Touch Section -->
                <div class="contact-section">
                    <h2 class="section-heading">Get In Touch</h2>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <span>+(632) 8896-4169</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <span>services@sentinelphils.com</span>
                    </div>
                    <div class="contact-item">
                        <i class="fab fa-linkedin"></i>
                        <span>Sentinel Integrated Security Services, Inc.</span>
                    </div>
                    <div class="contact-item">
                        <i class="fab fa-linkedin"></i>
                        <span>sinsirecruitment</span>
                    </div>
                    <div class="contact-item">
                        <i class="fab fa-linkedin"></i>
                        <span>SENTINEL.NOL.RECRUITMENT</span>
                    </div>
                    <div class="contact-item">
                        <i class="fab fa-linkedin"></i>
                        <span>SentinelSouthLuzonRecruitmentTeam</span>
                    </div>
                </div>

                <!-- Address Section -->
                <div class="contact-section">
                    <h2 class="section-heading">Address</h2>
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>1757 Nicanor Garcia St.<br>San Miguel Village, Brgy. Poblacion,<br>Makati City</span>
                    </div>
                </div>

                <!-- Office Hours Section -->
                <div class="contact-section">
                    <h2 class="section-heading">Office Hours</h2>
                    <div class="contact-item">
                        <i class="fas fa-clock"></i>
                        <span>Mon-Fri 8:30AM - 6:00PM</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-clock"></i>
                        <span>Sat 8:30AM - 2:00PM</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Section - Contact Form -->
        <div class="contact-form-section">
            <div class="form-container">
                <?php
                // Display success or error messages
                if (isset($_GET['status'])) {
                    if ($_GET['status'] == 'success') {
                        echo '<div class="alert alert-success">
                                <i class="fas fa-check-circle"></i>
                                <span>Thank you! Your message has been sent successfully. We will get back to you soon.</span>
                              </div>';
                    } elseif ($_GET['status'] == 'error' && isset($_GET['message'])) {
                        echo '<div class="alert alert-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>' . htmlspecialchars(urldecode($_GET['message'])) . '</span>
                              </div>';
                    }
                }
                ?>
                <form class="contact-form" action="process-contact.php" method="POST">
                    <div class="form-group">
                        <label for="name">Name *</label>
                        <div class="name-fields">
                            <input type="text" id="first-name" name="first_name" placeholder="First" required>
                            <input type="text" id="last-name" name="last_name" placeholder="Last" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="message">Comment or Message *</label>
                        <textarea id="message" name="message" rows="5" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="terms">Terms & Conditions *</label>
                        <div class="terms-container">
                            <div class="checkbox-wrapper">
                                <input type="checkbox" id="terms-checkbox" name="terms" required>
                                <label for="terms-checkbox">I accept the terms & conditions below</label>
                            </div>
                            <div class="terms-content">
                                <h3>Terms and Conditions</h3>
                                <p>Please read these Terms and Conditions carefully before using Our Service.</p>
                                <h4>Interpretation and Definitions</h4>
                                <p>The words of which the initial letter is capitalized have meanings defined under the following conditions. The following definitions shall have the same meaning regardless of whether they appear in singular or in plural.</p>
                                <p>For the purposes of these Terms and Conditions:</p>
                                <ul>
                                    <li><strong>Company</strong> (referred to as either "the Company", "We", "Us" or "Our" in this Agreement) refers to Sentinel Integrated Security Services, Inc.</li>
                                    <li><strong>Country</strong> refers to: Philippines</li>
                                    <li><strong>Service</strong> refers to the Website.</li>
                                    <li><strong>Terms and Conditions</strong> (also referred as "Terms") mean these Terms and Conditions that form the entire agreement between You and the Company regarding the use of the Service.</li>
                                    <li><strong>Website</strong> refers to Sentinel Integrated Security Services, accessible from sentinelphils.com</li>
                                    <li><strong>You</strong> means the individual accessing or using the Service, or the company, or other legal entity on behalf of which such individual is accessing or using the Service, as applicable.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="submit-btn">Send Message</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include('includes/footer.php'); ?>

    <!-- Floating Icons -->
    <div class="floating-icons">
        
        <div class="privacy-icon">
            <i class="fas fa-sync-alt"></i>
            <span>Privacy - Terms</span>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
</body>
</html>
