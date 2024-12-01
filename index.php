<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>FAX Parcel Print</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

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
                <a href="index.php" class="nav-item nav-link active">Home</a>
                <a href="about.html" class="nav-item nav-link">About</a>
                <a href="contact.php" class="nav-item nav-link">Contact Us</a>

                
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

    <!-- Carousel Start -->
    <div class="container-fluid p-0 ">
        <div class="owl-carousel header-carousel position-relative">
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="image/megamall.jpg" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(241, 160, 186, 0.356);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-sm-10 col-lg-8">
                                <h1 class="display-3 text-white animated slideInDown">Your One-Stop.</br> total SOLUTIONS.</br> PRINT SHOP</h1>
                                <p class="fs-5 text-white mb-4 pb-2">We take care of all your Business printing needs!</p>
                                <a href="about.html" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Read More</a>
                                <a href="order.html" class="btn btn-light py-md-3 px-md-5 animated slideInRight">Order Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="image/megamall.jpg" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(241, 160, 186, 0.356);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-sm-10 col-lg-8">
                                <h1 class="display-3 text-white animated slideInDown">Your One Stop </br> Digital Print Shop!</h1>
                                <p class="fs-5 text-white mb-4 pb-2">Don't wait any longer. Visit us here at Fax Parcel Print today and let us assist you in creating a high-quality that meets all your professional needs.</p>
                                <a href="about.html" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Read More</a>
                                <a href="order.html" class="btn btn-light py-md-3 px-md-5 animated slideInRight">Order Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->


    <!-- Footer Start -->

<div class="container-fluid bg-dark text-light footer pt-5 mt-0 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-3 col-md-6">
                <h4 class="text-white mb-3">Links</h4>
                <a class="btn btn-link" href="about.html">About Us</a>
                <a class="btn btn-link" href="contact.php">Contact Us</a>
                <a class="btn btn-link" href="privacy-policy.html">Privacy Policy</a>
                <a class="btn btn-link" href="termsandcondition.html">Terms & Condition</a>
                <a class="btn btn-link" href="faqandHelp.html">FAQs & Help</a>
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="text-white mb-3">Contact</h4>
                <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>SM Megamall Ortigas, Unit 33 Lower Ground Flr., Bldg A. Julia Vargas Ave., EDSA Mandaluyong City</p>
                <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>(02) 8551 4984</p>
                <p class="mb-2"><i class="fa fa-envelope me-3"></i>mega@faxparcelprint.com</p>
                <div class="d-flex pt-2">
                    <a class="btn btn-outline-light btn-social" href="https://www.facebook.com/FaxParcelPrint/"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-outline-light btn-social" href="https://www.instagram.com/FaxParcelPrint/"><i class="fab fa-instagram"></i></a>
                    <a class="btn btn-outline-light btn-social" href="https://twitter.com/FaxParcelPrint/"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <h4 class="text-white mb-3">Our Location</h4>
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1930.5327509343065!2d121.05761961166314!3d14.583231186392893!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c85e1eaf3f4b%3A0x360bc98982d18e73!2sSM%20Megamall!5e0!3m2!1sen!2sph!4v1690953212345!5m2!1sen!2sph" 
                        width="100%" 
                        height="300" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="copyright">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    &copy; <a class="border-bottom" href="#">FAX Parcel Print</a>, All Right Reserved.
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="footer-menu"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->


    <!-- Back to Top -->
    

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