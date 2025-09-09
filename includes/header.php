<!-- Header -->
<!-- Ensure Font Awesome is available on all pages using the header -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<?php
    $isSubdir = strpos($_SERVER['SCRIPT_NAME'], '/team page/') !== false;
    $BASE = $isSubdir ? '../' : '';
?>
<header>
    <!-- Top Bar with Contact Information -->
    <div class="top-bar">
        <div class="container">
            <div class="top-bar-content">
                <div class="contact-info-left">
                    <span class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        San Miguel Village, Brgy. Poblacion, Makati City
                    </span>
                </div>
                <div class="contact-info-right">
                    <span class="contact-item">
                        <i class="fas fa-phone"></i>
                        + (632) 8896-4169
                    </span>
                    <span class="contact-item">
                        <i class="fas fa-envelope"></i>
                        services@sentinelphils.com
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <div class="main-nav-bar">
        <div class="container">
            <div class="nav-content">
                <!-- Logo (Left) -->
                <div class="logo">
                    <img src="<?= $BASE ?>assets/images/logo.png" alt="Sentinel Logo">
                    <span class="logo-text">Sentinel</span>
                </div>

                <!-- Navigation Menu (Right) -->
                <nav class="main-nav">
                    <ul>
                        <li><a href="<?= $BASE ?>index.php">HOME</a></li>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link">TEAM <i class="fas fa-chevron-down"></i></a>
                            <ul class="dropdown-menu">
                                <?php $path = $_SERVER['SCRIPT_NAME']; ?>
                                <li><a href="<?= $BASE ?>team page/management.php" class="<?= strpos($path,'management.php')!==false?'active':'' ?>">Management Team</a></li>
                                <li><a href="<?= $BASE ?>team page/core-team.php" class="<?= strpos($path,'core-team.php')!==false?'active':'' ?>">Core Team</a></li>
                            </ul>
                        </li>
                        <li><a href="<?= $BASE ?>about us.php">ABOUT US</a></li>
                        <li><a href="<?= $BASE ?>portfolio.php">PORTFOLIO</a></li>
                        <li><a href="<?= $BASE ?>events.php">EVENTS</a></li>
                        <li><a href="<?= $BASE ?>careers.php">CAREERS</a></li>
                        <li><a href="<?= $BASE ?>contact.php">CONTACT</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>
