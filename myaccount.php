<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Include database connection
require_once 'connection.php';

$user_id = $_SESSION['user_id'];

// Retrieve user information
$sql = "SELECT email, FullName, address FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("SQL error: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($email, $fullName, $address);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQs & Help - FAX Parcel Print</title>
    <link href="css/main.css" rel="stylesheet">
    <link rel="stylesheet" href="css/order.css">
    <link href="Frontpage components/css/frontpagestyle.css" rel="stylesheet">
    <link href="Frontpage components/css/bootstrapfrontpage.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <header>
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
                    <a href="contact.php" class="nav-item nav-link">Contact Us</a>
                </div>
            </div>
        </nav>
    </header>
<body>
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="text-center">My Account</h4>
            </div>
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" id="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="fullName" class="form-label">Full Name</label>
                        <input type="text" id="fullName" class="form-control" value="<?php echo htmlspecialchars($fullName); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" id="address" class="form-control" value="<?php echo htmlspecialchars($address); ?>" readonly>
                    </div>
                    <div class="d-grid">
                        <a href="change_password.php" class="btn btn-warning">Change Password</a>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<footer>
        <div class="container-fluid bg-dark text-light footer pt-5 mt-0 wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-lg-3 col-md-6">
                        <h4 class="text-white mb-3">Links</h4>
                        <a class="btn btn-link" href="about.html">About Us</a>
                        <a class="btn btn-link" href="contact.php">Contact Us</a>
                        <a class="btn btn-link" href="privacy-policy.html">Privacy Policy</a>
                        <a class="btn btn-link" href="termsandcondition.html">Terms & Condition</a>
                        <a class="btn btn-link" href="faqandhelp.html">FAQs & Help</a>
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
 
</footer>
</html>
