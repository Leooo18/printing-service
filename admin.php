<?php
session_start();
include("connection.php"); // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check if inputs are empty
    if (empty($email) || empty($password)) {
        $_SESSION['login_error'] = "Email or password cannot be empty!";
        header('Location: admin.php'); // Redirect back to admin login
        exit;
    }

    // Prepare and execute the SQL statement for admin login
    $sql = "SELECT * FROM users WHERE email = ? AND is_admin = 1"; // Check for admin users only
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        $_SESSION['login_error'] = "Database error: " . mysqli_error($conn);
        header('Location: admin.php');
        exit;
    }

    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $storedPassword = $row['password'];

        // Verify the entered password with the stored hashed password
        if (password_verify($password, $storedPassword)) {
            // Set session variables
            $_SESSION['admin_email'] = $row['email'];
            $_SESSION['admin_logged_in'] = true;

            header('Location: dashboard.php'); // Redirect to admin dashboard
            exit;
        } else {
            $_SESSION['login_error'] = "Incorrect password!";
        }
    } else {
        $_SESSION['login_error'] = "Admin not found or not authorized!";
    }

    // Redirect back to admin login with error
    header('Location: admin.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="overlay"></div>
    <div class="container">
        <h1>Admin Login</h1>
        <form action="admin.php" method="post">
            <input type="email" name="email" id="email" placeholder="Enter your email" required>
            <input type="password" name="password" id="password" placeholder="Enter your password" required>
            <button type="submit">Login</button>
            <?php
            if (isset($_SESSION['login_error'])) {
                echo '<p style="color: red;">' . $_SESSION['login_error'] . '</p>';
                unset($_SESSION['login_error']);
            }
            ?>
        </form>
    </div>
</body>

<style>
    /* Styling */
    body {
        background-image: url('fax parcel.jpg');
        background-size: cover;
        background-position: center;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(241, 160, 186, 0.356);
    }

    .container {
        background: rgba(255, 255, 255, 0.9);
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        text-align: center;
        position: relative;
        z-index: 1;
    }

    input {
        width: calc(100% - 20px);
        padding: 12px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    button {
        width: 100%;
        padding: 12px;
        background-color: #3498db;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 18px;
    }

    button:hover {
        background-color: #2980b9;
    }

    h1 {
        margin-bottom: 20px;
        color: #333;
    }

    
</style>

</html>
