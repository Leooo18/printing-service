<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Bootstrap CSS -->
    <link href="Frontpage components/css/bootstrapfrontpage.min.css" rel="stylesheet">
    <link href="FrontEndDesign/img/favicon-32x32.png" rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">



    <!-- Custom Stylesheet -->
    <link href="Frontpage components/css/frontpagestyle.css" rel="stylesheet">

    <style>
    body {
        background-color: #f8f9fa; /* Matches the site's light grey background */
        font-family: 'Heebo', sans-serif;
    }

    .registration-form {
        max-width: 500px;
        margin: 50px auto;
        padding: 30px;
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        border: 1px solid #e9ecef;
    }

    .registration-form h2 {
        font-family: 'Nunito', sans-serif;
        font-weight: 800;
        color: #212529; /* Matches site's text color */
    }

    .form-control {
        border: 1px solid #ced4da;
        border-radius: 5px;
        box-shadow: none;
    }

    .form-control:focus {
        border-color: #ff4d4d; /* Matches the red accents */
        box-shadow: 0 0 0 0.2rem rgba(255, 77, 77, 0.25);
    }

    .btn-primary {
        background-color: #ff4d4d; /* Red theme */
        border-color: #ff4d4d;
        font-weight: 600;
    }

    .btn-primary:hover {
        background-color: #cc0000; /* Darker red for hover effect */
    }

    .text-center a {
        color: #3498db;
        font-weight: 600;
    }

    .text-center a:hover {
        text-decoration: underline;
    }
</style>

</head>

<body>
    <div class="container">
        <div class="registration-form">
            <h2 class="text-center mb-4">Register</h2>
            <form action="register.php" method="POST">
                <div class="mb-3">
                    <label for="full_name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter your full name" required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="Address" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary w-100 py-2">Register</button>
                </div>
                <p class="text-center mt-3">Already have an account? <a href="login.php">Login here</a>.</p>
            </form>
        </div>
    </div>
    <?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data and sanitize inputs
    $full_name = htmlspecialchars(trim($_POST['full_name']));
    $address = htmlspecialchars(trim($_POST['address']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validate inputs
    if (empty($full_name) || empty($address) || empty($email) || empty($password) || empty($confirm_password)) {
        echo "<script>alert('All fields are required.');</script>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format.');</script>";
    } elseif ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match.');</script>";
    } elseif (strlen($password) < 6) {
        echo "<script>alert('Password must be at least 6 characters long.');</script>";
    } else {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Save to database (example: MySQL)
        $conn = new mysqli('localhost', 'root', '', 'user_db');

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if the email is already registered
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "<script>alert('Email is already registered.');</script>";
        } else {
            // Insert the new user
            $stmt = $conn->prepare("INSERT INTO users (FullName, address, email, password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $full_name, $address, $email, $hashed_password);

            if ($stmt->execute()) {
                echo "<script>alert('Registration successful! Redirecting to login page.'); window.location.href='login.php';</script>";
            } else {
                echo "<script>alert('Error: " . $stmt->error . "');</script>";
            }
        }
        $stmt->close();
        $conn->close();
    }
}
?>



    <!-- Bootstrap JS -->
    <script src="Frontpage components/js/bootstrap.bundle.min.js"></script>
</body>

</html>
