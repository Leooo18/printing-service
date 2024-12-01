<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Contact Us - FAX Parcel Print</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="contact us, FAX Parcel Print, inquiry" name="keywords">
    <meta content="Contact FAX Parcel Print for any questions or inquiries" name="description">

    <!-- Favicon -->
    <link href="FrontEndDesign/img/favicon-32x32.png" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="Frontpage components/lib/animate/animate.min.css" rel="stylesheet">
    <link href="Frontpage components/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="Frontpage components/css/bootstrapfrontpage.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="Frontpage components/css/frontpagestyle.css" rel="stylesheet">
    
</head>

<body>
    <!-- PHP Login Check -->
    <?php
    $isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    ?>

    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="index.php" class="navbar-brand d-flex align-items-center px-3 px-lg-4">
            <h2 class="m-0">
                <img src="image/fax logo.jpg" alt="FAX Parcel Print Logo" class="logo">
                <span style="color: black;">FAX Parcel</span> <span style="color: red;">Print</span>
            </h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.php" class="nav-item nav-link">Home</a>
                <a href="about.html" class="nav-item nav-link">About</a>
                <a href="contact.php" class="nav-item nav-link active">Contact Us</a>
                
                <?php if ($isLoggedIn): ?>
                <!-- When the user is logged in -->
                <button class="btn btn-primary btn-rounded py-3 px-3 align-items-center rounded" onclick="window.location.href='myaccount.php'">MyAccount</button>
                <button class="btn btn-primary btn-rounded py-3 px-3 align-items-center rounded" onclick="window.location.href='logout.php'">Log out</button>
                <?php else: ?>
                <!-- When the user is NOT logged in -->
                <button class="btn btn-primary btn-rounded py-3 px-3 align-items-center rounded" onclick="window.location.href='login.php'">Login</button>
                <button class="btn btn-primary btn-rounded py-3 px-3 align-items-center rounded" onclick="window.location.href='register.php'">Register</button>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Contact Section Start -->
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="display-4 text-center mb-4">Contact Us</h1>
                <p class="text-center mb-5">If you have any questions or inquiries, feel free to reach out to us using the form below or via our contact details.</p>

                <!-- Contact Form -->
                <form action="contact_process.php" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Your Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Your Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Your Message</label>
                        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg">Send Message</button>
                </form>
            </div>
        </div>

        <!-- Contact Details -->
        <div class="row justify-content-center mt-5">
            <div class="col-lg-6">
                <h4 class="text-center mb-4">Our Contact Details</h4>
                
                <div class="mb-3">
                    <p><i class="fa fa-map-marker-alt me-3"></i><strong>Location:</strong> SM Megamall Ortigas, Unit 33 Lower Ground Flr., Bldg A. Julia Vargas Ave., EDSA Mandaluyong City</p>
                    <p><i class="fa fa-phone-alt me-3"></i><strong>Phone:</strong> (02) 8551 4984</p>
                    <p><i class="fa fa-envelope me-3"></i><strong>Email:</strong> mega@faxparcelprint.com</p>
                </div>

                <!-- Working Hours -->
                <div class="mb-3">
                    <p><i class="fa fa-clock me-3"></i><strong>Working Hours:</strong></p>
                    <ul>
                        <li>Monday - Friday: 9:00 AM - 6:00 PM</li>
                        <li>Saturday: 10:00 AM - 4:00 PM</li>
                        <li>Sunday: Closed</li>
                    </ul>
                </div>

                <!-- Social Media Links -->
                <div class="mb-3">
                    <p><i class="fab fa-facebook me-3"></i><strong>Follow us on:</strong></p>
                    <a class="btn btn-outline-light btn-social" href="https://www.facebook.com/FaxParcelPrint/"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-outline-light btn-social" href="https://www.instagram.com/FaxParcelPrint/"><i class="fab fa-instagram"></i></a>
                    <a class="btn btn-outline-light btn-social" href="https://twitter.com/FaxParcelPrint/"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>

        <!-- Large Google Map -->
        <div class="row justify-content-center mt-5">
            <div class="col-lg-10">
                <h4 class="text-center mb-4">Our Location</h4>
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1930.5327509343065!2d121.05761961166314!3d14.583231186392893!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c85e1eaf3f4b%3A0x360bc98982d18e73!2sSM%20Megamall!5e0!3m2!1sen!2sph!4v1709607109438!5m2!1sen!2sph" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact Section End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 pb-3">
        <div class="container text-center">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p>&copy; <a href="#">FAX Parcel Print</a>, All Right Reserved. Designed by <a href="#">Your Company</a></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="Frontpage components/lib/wow/wow.min.js"></script>
    <script src="Frontpage components/lib/easing/easing.min.js"></script>
    <script src="Frontpage components/lib/waypoints/waypoints.min.js"></script>
    <script src="Frontpage components/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="Frontpage components/js/FrontPage.js"></script>
</body>

</html>
